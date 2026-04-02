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
        
          <!-- Content Wrapper. Contains page content -->
          <h2 class="h5 content-header text-dark">Manage Contents</h2>
                
         <?php include('include/chooseTenCat.inc.php');?>
               
                
            <?php
                if(isset($_REQUEST['preSub']) && $_REQUEST['preSub']==1 && ($frmError ?? '') == false){
                    $ShowGridFlage=true;
                ?>
                
                    <div class="text-end mb-2">
                        <button id="AddNew" cdata-frmT="1" class="btn btn-warning rounded-0 fw-bold px-3 py-1 add-btn"><i class="fas fa-plus-square me-1" aria-hidden="true"></i>Add New Tender</button>
                    </div>           
                
                    <!-- <div class="text-right" style="margin-bottom: 2px;"><button id="AddNew" cdata-frmT='1' class="btn btn-warning">Add New Tender <i class="fa fa-plus-square-o" aria-hidden="true"></i></button></div> -->
                           
                        <ul class="nav nav-tabs border-bottom-0" id="myTab" role="tablist">
                            <li class="nav-item"><button class="nav-link rounded-0 text-dark border border-bottom-0 active" data-bs-toggle="tab" data-bs-target="#pending" type="button">Pending Tender</button></li>
                            <li class="nav-item"><button class="nav-link rounded-0 text-dark border border-bottom-0" data-bs-toggle="tab" data-bs-target="#publish" type="button">Published Tender</button></li>
                            <li class="nav-item"><button class="nav-link rounded-0 text-dark border border-bottom-0" data-bs-toggle="tab" data-bs-target="#rejected" type="button">Rejected Tender</button></li>
                        </ul>

                        <!-- <ul class="nav nav-tabs" id="myTab">
            			  <li class="active"><a tab-ind='1' data-target="#pending" data-toggle="tab">Pending Tender</a></li>
            			  <li><a tab-ind='2' data-target="#publish" data-toggle="tab">Published Tender</a></li>
            			  <li><a tab-ind='3' data-target="#rejected" data-toggle="tab">Rejected Tender</a></li>                                          			  
            			</ul>                         -->

                        <div class="tab-content border p-0">
                            <div class="tab-pane fade show active" id="pending">
                                <div class="table-responsive">
                                    <table id="myTable1" class="table table-striped table-bordered w-100">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>Tender Number</th>
                                                <th>Tender Name</th>
                                                <th>Created By/On</th>
                                                <th>Approved By/On</th>
                                                <th>Revive By/On</th>
                                                <th>Revive Details</th>                                                
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
                                            <th>Tender Number</th>
                                            <th>Tender Name</th>
                                            <th>Published On</th>
                                            <th>Bid-Submission / Clossing Date</th>
                                            <th>Tender Opening Date</th>
                                            <th>Created By/On</th>
                                            <th>Approved By/On</th>
                                            <th>Expiry On</th>
                                            <th>Corrigendum</th>
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
                                            <th>Tender Name</th>
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
                
                <?php
                }
                ?>                
                <!-- /.box-body -->
              </div>                    
          </div>
          <!-- /.content-wrapper -->
          
          
        
    <script type="text/javascript">
        $(document).delegate('.fa-fax','click',function(){
            var frmType=$(this).attr('cdata-frmT');
            var t_id=($(this).attr('pub-t_id')!=undefined)?$(this).attr('pub-t_id'):'';
            window.location=("tenCori.php?frmType=" + frmType + "&t_id="+t_id+"&t_temp_id=" + $(this).data('t_temp_id') +"&t_cat_id=<?php echo $_REQUEST['t_cat_id'] ?? '';?>" +"&department=<?php echo $_REQUEST['department'] ?? '';?>" + "&per_id=<?php echo "$_SESSION[per_id]&EncHid=$_SESSION[EncTok]";?>");
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
                        data     : {<?php echo $GLOBALS['csrf']['token'];?>,'frmType':frmType,'t_temp_id':$(this).data('t_temp_id'),'t_cat_id':'<?php echo $_REQUEST['t_cat_id'] ?? '';?>','department':'<?php echo $_REQUEST['department'] ?? '';?>'},
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
                    url:"tender.php?frmType=" + frmType + "&t_id="+t_id+"&t_temp_id=" + $(this).data('t_temp_id') +"&t_cat_id=<?php echo $_REQUEST['t_cat_id'] ?? '';?>"+"&department=<?php echo $_REQUEST['department'] ?? '';?>" + "&per_id=<?php echo "$_SESSION[per_id]&EncHid=$_SESSION[EncTok]";?>",
                });
            }
        });
        
            // var mGridTable='';
            
            //     if($('#myTab').length)
            //     {

            //         document.getElementById('myTab')
            //             .addEventListener('shown.bs.tab', function () {
            //                 $.fn.dataTable
            //                     .tables({visible:true, api:true})
            //                     .columns.adjust();
            //             });
            
            //         $('#myTab button').each(function(index){

            //             const tabID = index + 1;

            //             const table = $('#myTable'+tabID).DataTable({
            //                 processing: true,
            //                 serverSide: false,
            //                 ajax: {
            //                     url: "AjaxFill/getTenders.php?<?= "EncHid=$_SESSION[EncTok]"; ?>",
            //                     type: "POST",
            //                     data: {
            //                         <?= $GLOBALS['csrf']['token']; ?>,
            //                         tabID: tabID,
            //                         per_id: '<?= $_REQUEST['per_id'] ?? ''; ?>',
            //                         t_cat_id: '<?= $_REQUEST['t_cat_id'] ?? ''; ?>',
            //                     }
            //                 },
            //                 scrollY: 400,
            //                 scrollCollapse: true,
            //                 paging: false,
            //                 drawCallback: function(){
            //                     document.querySelectorAll('[data-bs-toggle="tooltip"]')
            //                         .forEach(el => new bootstrap.Tooltip(el));
            //                 }
            //             });

            //             if(tabID === 1) mGridTable = table;
            //             if(tabID === 2) mGridTable1 = table;
            //         });
            //     }


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
                    url: "AjaxFill/getTenders.php?<?= "EncHid=$_SESSION[EncTok]"; ?>",
                        type: "POST",
                        data: {
                            <?= $GLOBALS['csrf']['token']; ?>,
                            tabID: tabID,
                            per_id: '<?= $_REQUEST['per_id'] ?? ''; ?>',
                            t_cat_id: '<?= $_REQUEST['t_cat_id'] ?? ''; ?>',
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
    
         
    </script>

    <?php include('include/pageFooter.inc.php');?>

<!-- CALLING TINYMCE RTF CONFIG FILE  --->
<!-- <script src="rtf/js/tinymce/tinymce.dev.js"></script>
<script src="rtf/js/tinymce/plugins/table/plugin.dev.js"></script>
<script src="rtf/js/tinymce/plugins/paste/plugin.dev.js"></script>
<script src="rtf/js/tinymce/plugins/spellchecker/plugin.dev.js"></script>
<script src="rtf/rtfConf.js"></script> -->
<!--<script src='../node_modules/tinymce/tinymce.min.js'></script>-->
<!-- <script src='../tinymce/tinymce/tinymce.min.js'></script>
<script src="rtf/rtfConf1.js"></script> -->
<!-- CALLING TINYMCE RTF CONFIG FILE END --->