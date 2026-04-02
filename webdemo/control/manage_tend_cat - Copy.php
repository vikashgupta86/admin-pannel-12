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
                  <h3 class="box-title">Manage Tender Category</h3>
                </div>
                <!-- /.box-header -->                
                
                                
                <div class="box-body clearfix">
                    <div class="text-right" style="margin-bottom: 2px;"><button id="AddNew" cdata-frmT='1' class="btn btn-warning">Add New Category <i class="fa fa-plus-square-o" aria-hidden="true"></i></button></div>
                    <div class="panel panel-default">                        
                        <ul class="nav nav-tabs" id="myTab">
            			  <li class="active"><a tab-ind='1' data-target="#pending" data-toggle="tab">Pending Categories</a></li>
            			  <li><a tab-ind='2' data-target="#publish" data-toggle="tab">Approved Categories</a></li>
            			  <li><a tab-ind='3' data-target="#rejected" data-toggle="tab">Rejected Categories</a></li>                                          			  
            			</ul>                        
            			<div class="tab-content">
            			  <div class="tab-pane active" id="pending">
                                <table id="myTable1" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Category Name</th>                                                                                        
                                            <th>Created By/On</th>
                                            <th>Approved By/On</th>                         
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
                                            <th>Created By/On</th>
                                            <th>Approved By/On</th>
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
                </div>                                
                <!-- /.box-body -->
              </div>                    
          </div>
          <!-- /.content-wrapper -->
          <?php include('include/pageFooter.inc.php');?>
          
          <div class="control-sidebar-bg"></div>
        </div>
    </body>
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
                        url      : '<?php echo "tender_cat_action.php?per_id=$_SESSION[per_id]&EncHid=$_SESSION[EncTok]";?>',
                        data     : {<?php echo $GLOBALS['csrf']['token'];?>,'frmType':frmType,'t_cat_id':$(this).data('t_cat_id')},
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
                $('.modal-container').OpenPop({
                    url:"tender_cat.php?frmType=" + frmType +"&t_cat_id=" + $(this).data('t_cat_id') + "&per_id=<?php echo "$_SESSION[per_id]&EncHid=$_SESSION[EncTok]";?>",
                });
            }
        });
        
        var mGridTable='';
        $(function(){   
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
                            "url":"AjaxFill/getTenderCat.php?<?php echo "EncHid=$_SESSION[EncTok]";?>",
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
                })
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