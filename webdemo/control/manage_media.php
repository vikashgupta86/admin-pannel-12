<?php 
    include '../appcode/globals.inc.php';
    include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');
    userAuthenticationPageLevel();
    userAuthenticationMainLevel();
    include_once('include/pageHeader.inc.php');
    include('include/top_user_info.inc.php'); 
?>
    
<h2 class="h5 content-header text-dark">Manage Photo</h2>

<?php include('include/chooseMedCat.inc.php');?>
        
                
<?php
    if(isset($_REQUEST['preSub']) && $_REQUEST['preSub']==1 && ($frmError ?? '')==false){
        $ShowGridFlage=true;
        ?>        
        <div class="text-end mb-2">
    <button id="AddNew" cdata-frmT="1" class="btn btn-warning rounded-0 fw-bold px-3 py-1 add-btn"><i class="fas fa-plus-square me-1" aria-hidden="true"></i>Add New Link</button>
        </div>                                



        <ul class="nav nav-tabs border-bottom-0" id="myTab" role="tablist">
            <li class="nav-item"><button class="nav-link rounded-0 text-dark border border-bottom-0 active" data-bs-toggle="tab" data-bs-target="#pending" type="button">Pending Links</button></li>
            <li class="nav-item"><button class="nav-link rounded-0 text-dark border border-bottom-0" data-bs-toggle="tab" data-bs-target="#publish" type="button">Published Links</button></li>
            <li class="nav-item"><button class="nav-link rounded-0 text-dark border border-bottom-0" data-bs-toggle="tab" data-bs-target="#rejected" type="button">Rejected Links</button></li>
        </ul>
                    <!-- <div class="panel panel-default">                         -->
                        <!-- <ul class="nav nav-tabs border-bottom-0" id="myTab" role="tablist">
                            <li class="nav-item"><button class="nav-link rounded-0 text-dark border border-bottom-0 active" data-bs-toggle="tab" data-bs-target="#pending" type="button">Pending Photo's</button></li>
                            <li class="nav-item"><button class="nav-link rounded-0 text-dark border border-bottom-0" data-bs-toggle="tab" data-bs-target="#publish" type="button">Published Photo's</button></li>
                            <li class="nav-item"><button class="nav-link rounded-0 text-dark border border-bottom-0" data-bs-toggle="tab" data-bs-target="#rejected" type="button">Rejected Photo's</button></li>
                        </ul> -->
                        <div class="tab-content border p-0">
                            <div class="tab-pane fade show active" id="pending">
                                <div class="table-responsive">
                                    <table id="myTable1" class="table table-striped table-bordered w-100">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>Description</th>
                                                <th>Description (Hindi)</th>
                                                <th>Photo/ Video</th>
                                                <th>Preview</th>                                            
                                                <th>Created By/On</th>
                                                <th>Approved By/On</th>                                                                                            
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
                                            <th>Description</th>
                                            <th>Description (Hindi)</th>
                                            <th>Photo/ Video</th>
                                            <th>Preview</th>                                            
                                            <th>Created By/On</th>
                                            <th>Approved By/On</th>
                                            <th>Published By/On</th>                                            
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
                                            <th>Description</th>
                                            <th>Description (Hindi)</th>
                                            <th>Photo/ Video</th>                                            
                                            <th>Created By/On</th>
                                            <th>Rejected By/On</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div id="ShowMsg1"></div>
                        <div id="reloadGrid"></div>
                <!-- </div> -->
                <?php
                }
                ?>                



    <script type="text/javascript">        
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
                        url      : 'media_action.php?per_id=<?= $_SESSION['per_id']; ?>&m_cat_id=<?= $_REQUEST['m_cat_id'] ?? ''; ?>&EncHid=<?= $_SESSION['EncTok']; ?>',
                        data     : {<?php echo $GLOBALS['csrf']['token'];?>,'frmType':frmType,'m_temp_id':$(this).data('m_temp_id')},
                        beforeSend: function(){
                            $.fn.ajaxLoading();
                        },        
                        success  : function(data) {                                    
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
                var m_id=($(this).attr('pub-m_id')!=undefined)?$(this).attr('pub-m_id'):'';
                var content_type_id=($('#nmnh_type_id').val()!=undefined)?$('#nmnh_type_id').val():'';
                //alert(content_type_id);
                $('.modal-container').OpenPop({
                    url: "media.php?frmType=" + frmType +
                        "&m_id=" + m_id +
                        "&content_type_id=" + content_type_id +
                        "&m_temp_id =" +$(this).data('m_temp_id')+
                        "&per_id= <?= $_SESSION['per_id']; ?>&m_cat_id=<?= $_REQUEST['m_cat_id'] ?? ''; ?>&EncHid=<?= $_SESSION['EncTok']; ?>",
                    title: "Add New Photo"
                });

                // $('.modal-container').OpenPop({
                //     url:"media.php?frmType=" + frmType + "&m_id=" + m_id + "&content_type_id=" + content_type_id + "&m_temp_id="+$(this).data('m_temp_id')+"&per_id= <?= $_SESSION['per_id']; ?>&m_cat_id=<?= $_REQUEST['m_cat_id'] ?? ''; ?>&EncHid=<?= $_SESSION['EncTok']; ?>",
                // });
            }
        });
        
        var mGridTable='';
        $(function(){

            /*if($('#myTab').length>0)
            {
                jQuery('#myTab a:first').tab('show');
                tab='#pending';
                $('a[data-toggle="tab"]').on( 'shown.bs.tab', function (e) {                
                    $.fn.dataTable.tables( {visible: true, api: true} ).columns.adjust();
                    tab=$(this).data('target');
                } );
                
                $('#myTab a').each(function(i,d){
                    tabID=$(d).attr('tab-ind');

                    tempTable=$('table#myTable'+tabID).DataTable( {
                        "processing": true,
                        "serverSide": false,
                        "ajax": {
                            "url":"AjaxFill/getMedia.php?<?php echo "EncHid=$_SESSION[EncTok]";?>",
                            "type":"POST",
                            "data":{<?php echo $GLOBALS['csrf']['token'];?>,'tabID':tabID,'m_cat_id':'<?= $_REQUEST['m_cat_id'] ?? ''; ?>','per_id':'<?= $_REQUEST['per_id'] ?? ''; ?>','content_type_id':'<?= $_REQUEST['nmnh_type_id'] ?? ''; ?>'}
                            },
                        scrollY:        400,
                        scrollCollapse: true,
                        paging:         false
                    } );
                    
                    if(tabID==1){
                        mGridTable=tempTable;    
                    }
                })
            } */

            if($('#myTab').length){

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
                            url: "AjaxFill/getMedia.php?<?= "EncHid=$_SESSION[EncTok]"; ?>",
                            type: "POST",
                            data: {
                                <?= $GLOBALS['csrf']['token']; ?>,
                                tabID: tabID,
                                m_cat_id: '<?= $_REQUEST['m_cat_id'] ?? ''; ?>',
                                per_id: '<?= $_REQUEST['per_id'] ?? ''; ?>',
                                content_type_id: '<?= $_REQUEST['nmnh_type_id'] ?? ''; ?>',
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
            
            
            //
            
            /*var mGridTable=$('#GridData').DataTable({                
                'aoColumnDefs': [{'aTargets': [2],'bSortable': false}],
                "processing": true,
                "serverSide": false,
                "ajax": "AjaxFill/getUsers.php?user_type_id=<?php // echo "$_REQUEST[user_type_id]";?>&per_id=<?php // echo "$_SESSION[per_id]&EncHid=$_SESSION[EncTok]";?>",                
            });*/
            
            $(document).delegate('#reloadGrid', 'click', function ReLoadGrid() {
                mGridTable.ajax.reload( null, false );
            });
        })
         
    </script>


        <?php include('include/pageFooter.inc.php');?>
          
  