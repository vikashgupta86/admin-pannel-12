<?php include '../appcode/globals.inc.php';
include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');
userAuthenticationPageLevel();
userAuthenticationMainLevel();
include_once('include/pageHeader.inc.php');
?>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <?php include('include/top_user_info.inc.php');?>  
          <!-- Left side column. contains the logo and sidebar -->
          <?php //include('include/left_nav.inc.php');?>
        
          <!-- Content Wrapper. Contains page content -->
          <div class="content-wrapper">
            <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Tenders List</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <?php include('include/chooseTenList.inc.php');?>
                </div>
                
                
                
                <?php
                if(isset($_REQUEST['preSub']) && $_REQUEST['preSub']==1 && $frmError==false){
                    $ShowGridFlage=true;
                ?>
                
                                
                <div class="box-body clearfix">
                    <!--<div class="text-right" style="margin-bottom: 2px;"><button id="AddNew" cdata-frmT='1' class="btn btn-warning">Add New Tender <i class="fa fa-plus-square-o" aria-hidden="true"></i></button></div>-->
                    <div class="panel panel-default">                        
                        <ul class="nav nav-tabs" id="myTab">
            			  <li><a tab-ind='2' data-target="#publish" data-toggle="tab">Tender</a></li>
            			</ul>                        
            			<div class="tab-content">
            			 
            			  <div class="tab-pane" id="publish">
                                <table id="myTable2" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Category Name</th>
                                            <th>Tender Number</th>
                                            <th>Tender Name</th>
                                            <th>Department</th>
                                            <th>Date of Creation</th>
                                            <!--<th>Published Date</th>-->
                                        </tr>
                                    </thead>
                                </table>
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
          <?php include('include/pageFooter.inc.php');?>
          
          <div class="control-sidebar-bg"></div>
        </div>
    </body>
    <script type="text/javascript">
        $(document).delegate('.fa-fax','click',function(){
            var frmType=$(this).attr('cdata-frmT');
            var t_id=($(this).attr('pub-t_id')!=undefined)?$(this).attr('pub-t_id'):'';
            window.location=("tenCori.php?frmType=" + frmType + "&t_id="+t_id+"&t_temp_id=" + $(this).data('t_temp_id') +"&t_cat_id=<?php echo $_REQUEST['t_cat_id'];?>" +"&department=<?php echo $_REQUEST['department'];?>" + "&per_id=<?php echo "$_SESSION[per_id]&EncHid=$_SESSION[EncTok]";?>");
        })  
              
        $(document).delegate('#AddNew,.fa-edit,.fa-trash-o,.fa-eye,.fa-eye-slash,.fa-retweet', 'click', function() {
            var frmType=$(this).attr('cdata-frmT');
            //console.log(frmType);            
            if($.inArray(frmType,['3','4','5','6'])!='-1'){
                var con=confirm('Do you really want to Proceed?');
                //console.log(con)
                if(con){                        
                    $.base64.utf8encode = true;
                    $.ajax({
                        type     : "POST",
                        dataType: "text",
                        cache    : false,
                        url      : '<?php echo "tender_action.php?per_id=$_SESSION[per_id]&amp;EncHid=$_SESSION[EncTok]";?>',
                        data     : {<?php echo $GLOBALS['csrf']['token'];?>,'frmType':frmType,'t_temp_id':$(this).data('t_temp_id'),'t_cat_id':'<?php echo $_REQUEST['t_cat_id'];?>','department':'<?php echo $_REQUEST['department'];?>'},
                        beforeSend: function(){
                            $.fn.ajaxLoading();
                        },        
                        success  : function(data) {                                    
                            try{
                                data=$.parseJSON($.base64.atob(data));                                                
                                if(data[0]){
                                    $('#ShowMsg1').ShowMsg({msg:'Request Completed Successfully!',alertClass:'alert-success'});
                                    $('#reloadGrid').trigger('click');                    
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
            else{
                var t_id=($(this).attr('pub-t_id')!=undefined)?$(this).attr('pub-t_id'):'';
                $('.modal-container').OpenPop({
                    url:"tender.php?frmType=" + frmType + "&t_id="+t_id+"&t_temp_id=" + $(this).data('t_temp_id') +"&t_cat_id=<?php echo $_REQUEST['t_cat_id'];?>"+"&department=<?php echo $_REQUEST['department'];?>" + "&per_id=<?php echo "$_SESSION[per_id]&EncHid=$_SESSION[EncTok]";?>",
                });
            }
        });
        
        var mGridTable='';
        $(function(){ 
            $('#frm').formChecks().SetToFirstFocus();
            $('.CallDate1').click(function(){
                $(this).siblings('.CallDate').trigger('focus');                    
            })
            $('.CallDate').datepicker({
                    autoclose:true,
                    todayHighlight:true,            
                    format:'dd/mm/yyyy',                    
                }        
            );
		
		
		  
            if($('#myTab').length>0){
                jQuery('#myTab a:first').tab('show');
                tab='#pending';
                $('a[data-toggle="tab"]').on( 'shown.bs.tab', function (e) {                
                    $.fn.dataTable.tables( {visible: true, api: true} ).columns.adjust();
                    //console.log($(this).data('target'))
                    tab=$(this).data('target');
                } );
                
                $('#myTab a').each(function(i,d){
                    //console.log($(d).attr('tab-ind'))
                    tabID=$(d).attr('tab-ind');
                    //console.log(tabID)
                    tempTable=$('table#myTable'+tabID).DataTable( {
                        "processing": true,
                        "serverSide": false,
                        "ajax": {
                            "url":"AjaxFill/getTendersList.php?<?php echo "EncHid=$_SESSION[EncTok]";?>",
                            "type":"POST",
                            "data":{<?php echo $GLOBALS['csrf']['token'];?>,'tabID':tabID,'f_date':'<?php echo "$_REQUEST[f_date]";?>','t_date':'<?php echo "$_REQUEST[t_date]";?>','per_id':'<?php echo "$_REQUEST[per_id]";?>','t_cat_id':'<?php echo "$_REQUEST[t_cat_id]";?>','department':'<?php echo "$_REQUEST[department]";?>'}
                            },
                        scrollY:        400,
                        scrollCollapse: true,
                        paging:         false
                    } );
                    
                    if(tabID==1){
                        mGridTable=tempTable;    
                    }
                })
            }
            
                        
            
            
            
            //
            
            /*var mGridTable=$('#GridData').DataTable({                
                'aoColumnDefs': [{'aTargets': [2],'bSortable': false}],
                "processing": true,
                "serverSide": false,
                "ajax": "AjaxFill/getUsers.php?user_type_id=<?php echo "$_REQUEST[user_type_id]";?>&per_id=<?php echo "$_SESSION[per_id]&EncHid=$_SESSION[EncTok]";?>",                
            });*/
            
            $(document).delegate('#reloadGrid', 'click', function ReLoadGrid() {
                mGridTable.ajax.reload( null, false );
            });
        })
         
    </script>

<!-- CALLING TINYMCE RTF CONFIG FILE  --->
<!-- <script src="rtf/js/tinymce/tinymce.dev.js"></script>
<script src="rtf/js/tinymce/plugins/table/plugin.dev.js"></script>
<script src="rtf/js/tinymce/plugins/paste/plugin.dev.js"></script>
<script src="rtf/js/tinymce/plugins/spellchecker/plugin.dev.js"></script>
<script src="rtf/rtfConf.js"></script> -->
<!--<script src='../node_modules/tinymce/tinymce.min.js'></script>-->

<script src="rtf/rtfConf1.js"></script>
<script src='../node_modules/tinymce/tinymce.min.js'></script>
<!-- CALLING TINYMCE RTF CONFIG FILE END --->