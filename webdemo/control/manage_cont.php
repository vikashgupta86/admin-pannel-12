<?php include '../appcode/globals.inc.php';
include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');
userAuthenticationPageLevel();
userAuthenticationMainLevel();
include_once('include/pageHeader.inc.php');
?>
            <?php include('include/top_user_info.inc.php');?>  
          <!-- Left side column. contains the logo and sidebar -->


          <!-- Content Wrapper. Contains page content -->
          <div class="content-wrapper">
            <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Manage Continuous Contents </h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <form name="frm" id="frm" action="<?php echo curPageName()."?EncHid=$_SESSION[EncTok]"?>" role="form" class="form-border clearfix col-sm-6 col-sm-offset-3" method="post">
                        <input type="hidden" name="preSub" id="preSub" value="1" />     
                        <input type="hidden" name="per_id" id="per_id" value="<?php echo $_REQUEST['per_id']?>" />                                         
                        
                        <div class="form-group">
                          <label for="lang_id">Choose Language</label>
                          <select name="lang_id" id="lang_id" class="form-control" data-validate="lang_id|text|y|1|10|num|dontselect=-1|Please enter Valid option!">                            
                            <?php                            
                            $rs1=fetchtable("web_lang","status='Active'");
                            if($rs1[0]>0){
                                foreach($rs1[1] as $row1){
                                    if($_REQUEST['lang_id'] == $row1['lang_id'])
                                        echo "<option value='$row1[lang_id]' selected=''>$row1[lang]</option>";
                                    else
                                        echo "<option value='$row1[lang_id]'>$row1[lang]</option>";
                                }
                            }
                            ?>
                          </select>
                        </div>
                        
                        <div class="form-group">
                          <label for="lid">Link Name</label>
                          <select name="lid" id="lid" class="form-control" data-validate="lid|text|y|1|10|num|dontselect=-1|Please enter Valid option!">
                            <option value="-1">--- Select ---</option>
                            <?php
                            if(isset($_REQUEST['lang_id']))
                            {
                                $rs1=simplefetch("select lf.lid,wlt.link_name from web_links_final lf
INNER JOIN web_link_temp wlt on wlt.link_temp_id=lf.link_temp_id
where wlt.`status`='Active' and wlt.type_id=3 and wlt.lang_id=$_REQUEST[lang_id] ORDER BY wlt.link_name");
                                if($rs1[0]>0){
                                    foreach($rs1[1] as $row1){
                                        if($_REQUEST['lid']==$row1['lid'])
                                            echo "<option value='$row1[lid]' selected=''>".html_entity_decode($row1['link_name'])."</option>";
                                        else
                                            echo "<option value='$row1[lid]'>".html_entity_decode($row1['link_name'])."</option>";
                                    }
                                }
                            }
                            ?>
                          </select>
                        </div>  
                        <div class="col-sm-8 col-sm-offset-4">
                            <button type="submit" class="btn btn-primary">Proceed</button>
                          </div>
                    </form>
                </div>
                
                <?php
                if(isset($_REQUEST['preSub']) && $_REQUEST['preSub']==1 && ($frmError ?? '')==false){
                    $ShowGridFlage=true;
                ?>
                
                                
                <div class="box-body clearfix">
                    <div class="text-right" style="margin-bottom: 2px;">
                        <button id="AddNew" cdata-frmT='1' class="btn btn-warning">Add New</button></div>
                    <div class="panel panel-default">                        
                        <ul class="nav nav-tabs border-bottom-0" id="myTab" role="tablist">
            			  <!-- <li class="active"><a tab-ind='1' data-target="#pending" data-toggle="tab">Pending Links</a></li>
            			  <li><a tab-ind='2' data-target="#publish" data-toggle="tab">Published Links</a></li>
            			  <li><a tab-ind='3' data-target="#rejected" data-toggle="tab">Rejected Links</a></li>    -->
                            <li class="nav-item"><button class="nav-link rounded-0 text-dark border border-bottom-0 active" data-bs-toggle="tab" data-bs-target="#pending" type="button">Pending Links</button></li>
                            <li class="nav-item"><button class="nav-link rounded-0 text-dark border border-bottom-0" data-bs-toggle="tab" data-bs-target="#publish" type="button">Published Links</button></li>
                            <li class="nav-item"><button class="nav-link rounded-0 text-dark border border-bottom-0" data-bs-toggle="tab" data-bs-target="#rejected" type="button">Rejected Links</button></li>                                       			  
            			</ul>  
                        <div class="tab-content border p-0">
                            <div class="tab-pane fade show active" id="pending">
                                <div class="table-responsive">
                                    <table id="myTable1" class="table table-striped table-bordered w-100">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>Link Name</th>
                                                <th>Created By/On</th>
                                                <th>Approved By/On</th>
                                                <th>Revive By/On</th>
                                                <th>Revive Details</th>
                                                <th>Preview</th>                                                
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="publish">
                                <div class="table-responsive">
                                    <table id="myTable2" class="table table-striped table-bordered w-100">
                                        <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Link Name</th>
                                            <th>Created By/On</th>
                                            <th>Approved By/On</th>
                                            <th>Published By/On</th>
                                            <th>Expiry Date</th>
                                            <th>Preview</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="rejected">
                                <div class="table-responsive">
                                    <table id="myTable3" class="table table-striped table-bordered w-100">
                                        <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Link Name</th>
                                            <th>Created By/On</th>
                                            <th>Rejected By/On</th>
                                            <th>Preview</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>                      
            	    <div id="ShowMsg1"></div>                    
                    <div id="reloadGrid"></div>
                </div>
                <?php
                }
                ?>                
                <!-- /.box-body -->
              </div>                    
          </div>
          <!-- /.content-wrapper -->
    <script type="text/javascript">
       // $('#frm').formChecks().SetToFirstFocus();        
        $(document).delegate('#AddNew,.fa-edit,.fa-trash-o,.fa-eye-slash,.fa-retweet', 'click', function() {
            var frmType=$(this).attr('cdata-frmT');
            //console.log(frmType);            
            if($.inArray(frmType,['3','4','5','6'])!='-1')
            {
                var con=confirm('Do you really want to Proceed?');
                var eleCtrl=$(this);
                //console.log(con)
                if(con){                        
                    $.base64.utf8encode = true;
                    $.ajax({
                        type     : "POST",
                        dataType: "text",
                        cache    : false,
                        url      : '<?php echo "cont_link_action.php?per_id=$_SESSION[per_id]&amp;EncHid=$_SESSION[EncTok]";?>',
                        data     : {<?php echo $GLOBALS['csrf']['token'];?>,'frmType':frmType,'lid':<?= $_REQUEST['lid'] ?? '';?>,'link_temp_id':$(this).data('link_temp_id')},
                        beforeSend: function(){
                            $.fn.ajaxLoading();
                        },        
                        success  : function(data) 
                        {            
                            alert(data);                        
                            try{
                                data=$.parseJSON($.base64.atob(data));                                                
                                if(data[0]){
                                    $('#ShowMsg1').ShowMsg({msg:'Request Completed Successfully!',alertClass:'alert-success'});
                                    $('#reloadGrid').trigger('click'); 
                                    if(frmType==3)
                                        eleCtrl.closest('tr').hide();                   
                                }
                                else{                    
                                    $('#ShowMsg1').ShowMsg({msg:'Request not Completed Successfully!',alertClass:'alert-danger'});
                                }
                            }
                            catch(err) {
                                $('#ShowMsg1').ShowMsg({msg:"<strong>Error:</strong> Unexpected Response received, You may try again!",alertClass:'alert-warning'});                                
                            }
                                                   
                        },
                        error:function(){
                            $.fn.custom_alert({msg:'Something went wrong, Please try again!'});                        
                        },
                        complete: function(){            
                            $.fn.ajaxLoading({show:false});
                        },
                    });
                }
            }
            else
            {                
               
                 $('.modal-container').OpenPop({
                    url: "cont_link.php?frmType=" + frmType +
                        "&lid= <?= $_REQUEST['lid'] ?? ''; ?>" +
                        "&link_temp_id=" + $(this).data('link_temp_id') +
                        "&lang_id=<?= $_REQUEST['lang_id'] ?? ''; ?>" +
                        "&type_id=<?= $_REQUEST['type_id'] ?? ''; ?>" +
                        "&per_id=<?= $_SESSION['per_id']; ?>&EncHid=<?= $_SESSION['EncTok']; ?>",
                        title: "Manage Continuous Contents"
                });
            }
        });
        
        function GetContLink()
        {
            $.fn.FillData({url:'AjaxFill/GetContLink.php',Fill_To:'lid',Arr:{'lang_id':$('#lang_id').val()}});
        }
        
        var mGridTable='';
            $('#lang_id').change(function(){
                GetContLink();
            })
            
            <?php
            if(!isset($_REQUEST['lid'])){
            ?>
            GetContLink();
            <?php
            }
            ?> 
                        
            if($('#myTab').length)
            {

                document.getElementById('myTab')
                    .addEventListener('shown.bs.tab', function () {
                        $.fn.dataTable
                            .tables({visible:true, api:true})
                            .columns.adjust();
                    });
        
                $('#myTab button').each(function(index){

                    const tabID = index + 1;

                    const table = $('#myTable'+tabID).DataTable({
                        processing: true,
                        serverSide: false,
                        ajax: {
                            url: "AjaxFill/getContLinks.php?<?= "EncHid=$_SESSION[EncTok]"; ?>",
                            type: "POST",
                            data: {
                                <?= $GLOBALS['csrf']['token']; ?>,
                                tabID: tabID,
                                lang_id: '<?= $_REQUEST['lang_id'] ?? ''; ?>',
                                lid: '<?= $_REQUEST['lid'] ?? ''; ?>',
                                per_id: '<?= $_REQUEST['per_id'] ?? ''; ?>',
                            }
                        },
                        scrollY: 400,
                        scrollCollapse: true,
                        paging: false,
                        drawCallback: function(){
                            document.querySelectorAll('[data-bs-toggle="tooltip"]')
                                .forEach(el => new bootstrap.Tooltip(el));
                        }
                    });

                    if(tabID === 1) mGridTable = table;
                    if(tabID === 2) mGridTable1 = table;
                });
            }

            $(document).on('click','#reloadGrid',function(){

                if(mGridTable) mGridTable.ajax.reload(null,false);
                if(mGridTable1) mGridTable1.ajax.reload(null,false);

            });
            
                        
            //
            
            /*var mGridTable=$('#GridData').DataTable({                
                'aoColumnDefs': [{'aTargets': [2],'bSortable': false}],
                "processing": true,
                "serverSide": false,
                "ajax": "AjaxFill/getUsers.php?user_type_id=<?php // echo "$_REQUEST[user_type_id]";?>&per_id=<?php //  echo "$_SESSION[per_id]&EncHid=$_SESSION[EncTok]";?>",                
            });*/

            
    // $(document).on('click','#reloadGrid',function(){

    //     if(mGridTable) mGridTable.ajax.reload(null,false);
    //     if(mGridTable1) mGridTable1.ajax.reload(null,false);

    // });

    
            
            $(document).delegate('#reloadGrid', 'click', function ReLoadGrid() {
                mGridTable.ajax.reload( null, false );
            });
            
            $(document).delegate('.Lpreview','click',function(){
                $('.modal-container').OpenPop({
                    url:"link_preview.php?link_temp_id=" + $(this).data('link_temp_id') + "&lang_id=<?= $_REQUEST['lang_id'] ?? '';?>&type_id=<?= $_REQUEST['type_id'] ?? '';?>&per_id=<?php echo "$_SESSION[per_id]&EncHid=$_SESSION[EncTok]";?>",
                });
            })
    
        
    </script>

<!-- CALLING TINYMCE RTF CONFIG FILE  --->
<!-- <script src='../node_modules/tinymce/tinymce.min.js'></script> -->
<!-- <script src="rtf/js/tinymce/plugins/table/plugin.dev.js"></script>
<script src="rtf/js/tinymce/plugins/paste/plugin.dev.js"></script>
<script src="rtf/js/tinymce/plugins/spellchecker/plugin.dev.js"></script> -->
<!-- <script src="rtf/rtfConf.js"></script> -->
<!-- CALLING TINYMCE RTF CONFIG FILE END --->


<?php include('include/pageFooter.inc.php');?>