<?php 
    include '../appcode/globals.inc.php';
    include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');
    userAuthenticationPageLevel();
    userAuthenticationMainLevel();
    include_once('include/pageHeader.inc.php');
    include('include/top_user_info.inc.php'); 
?>
    
<h2 class="h5 content-header text-dark">Manage Dashboard Category</h2>

<div class="text-end mb-2">
    <button id="AddNew" cdata-frmT="1" class="btn btn-warning rounded-0 fw-bold px-3 py-1 add-btn"><i class="fa fa-plus-square-o me-1" aria-hidden="true"></i>Add New Link</button>
</div>  


        <ul class="nav nav-tabs border-bottom-0" id="myTab" role="tablist">
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
                                <th>Link Name (Alias)</th>
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
                            <th>Link Name (Alias)</th>
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
                            <th>Link Name (Alias)</th>
                            <th>Created By/On</th>
                            <th>Rejected By/On</th>
                            <th>Preview</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>





<div class="panel panel-default d-none">                        
                        <ul class="nav nav-tabs" id="myTab">
            			  <li class="active"><a tab-ind='1' data-target="#pending" data-toggle="tab"></a></li>
            			  <!-- <li><a tab-ind='2' data-target="#publish" data-toggle="tab">Approved Categories</a></li>
            			  <li><a tab-ind='3' data-target="#rejected" data-toggle="tab">Rejected Categories</a></li>                                          			   -->
            			</ul>                        
            			<div class="tab-content">
            			  <div class="tab-pane active" id="pending">
                                <table id="myTable1" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Category Name</th>
                                            <th>Category Name (Hindi)</th>
                                            <th>Created By/On</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                </table>
                          </div>
            			  <div class="tab-pane" id="publish">
                                <table id="myTable2" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Category Name</th>
                                            <th>Category Name (Hindi)</th>
                                            <th>Created By/On</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                </table>
                          </div>
            			  <div class="tab-pane" id="rejected">
                                <table id="myTable3" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Category Name</th>
                                            <th>Category Name (Hindi)</th>
                                            <th>Created By/On</th>
                                        </tr>
                                    </thead>
                                </table>
                          </div>                			  
            			</div>
                    </div>
                    <div id="ShowMsg1"></div>                    
                    <div id="reloadGrid"></div>
                </div>                                
                <!-- /.box-body -->
              </div>                    
          </div>
          <!-- /.content-wrapper -->
        
          
        
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
                        url      : '<?php echo "dash_cat_action.php?per_id=$_SESSION[per_id]&EncHid=$_SESSION[EncTok]";?>',
                        data     : {<?php echo $GLOBALS['csrf']['token'];?>,'frmType':frmType,'prog_id':$(this).data('prog_id')},
                        beforeSend: function(){
                            $.fn.ajaxLoading();
                        },        
                        success  : function(data) {                                    
                            try{
                                data=$.parseJSON($.base64.atob(data));   
                                if(data[0] == true)
                                {
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
            else{      
               
                $('.modal-container').OpenPop({
                    url:"dash_cat.php?frmType=" + frmType +"&prog_id=" + $(this).data('prog_id') + "&lang_id=<?php echo "$_REQUEST[lang_id]";?>&type_id=<?= $_REQUEST['type_id'] ?? '';?>&per_id=<?php echo "$_SESSION[per_id]&EncHid=$_SESSION[EncTok]";?>",
                    title: "Add/ Modify Details"
                });
            }
        });
        
        var mGridTable='';
        $(function(){   
            //if($('#myTab').length>0){
                // jQuery('#myTab a:first').tab('show');
                // tab='#pending';
                // $('a[data-toggle="tab"]').on( 'shown.bs.tab', function (e) {                
                //     $.fn.dataTable.tables( {visible: true, api: true} ).columns.adjust();
                //     tab=$(this).data('target');
                // } );

                $('#myTab a').each(function(i,d)
                {
                    tabID=$(d).attr('tab-ind');
                    tempTable=$('table#myTable'+tabID).DataTable( {
                        "processing": true,
                        "serverSide": false,
                        "ajax": {
                            "url":"AjaxFill/getDashCat.php?<?php echo "EncHid=$_SESSION[EncTok]";?>",
                            "type":"POST",
                            "data":{<?php echo $GLOBALS['csrf']['token'];?>,'tabID':tabID,'per_id':'<?php echo "$_REQUEST[per_id]";?>'}
                            },
                        scrollY:        400,
                        scrollCollapse: true,
                        paging:         false
                    } );
                    
                    if(tabID==1){
                        mGridTable=tempTable;    
                    }
                });
                
                // $('#myTab a').each(function(i,d)
                // {
                //     tabID=$(d).attr('tab-ind');
                //     tempTable=$('table#myTable'+tabID).DataTable( {
                //         "processing": true,
                //         "serverSide": false,
                //         "ajax": {
                //             "url":"AjaxFill/getDashCat.php?<?php // echo "EncHid=$_SESSION[EncTok]";?>",
                //             "type":"POST",
                //             "data":{<?php // echo $GLOBALS['csrf']['token'];?>,'tabID':tabID,'per_id':'<?php // echo "$_REQUEST[per_id]";?>'}
                //             },
                //         scrollY:        400,
                //         scrollCollapse: true,
                //         paging:         false
                //     } );
                    
                //     if(tabID==1){
                //         mGridTable=tempTable;    
                //     }
                // });
            //}
                        
            
            $(document).delegate('#reloadGrid', 'click', function ReLoadGrid() {
                mGridTable.ajax.reload( null, false );
            });
        })
         
    </script>

      <?php include('include/pageFooter.inc.php');?>