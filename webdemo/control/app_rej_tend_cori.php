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
        
          <h3 class="box-title">Approve/ Reject Tenders Corrigendum</h3>
                <?php include('include/chooseTenCat.inc.php');?>
                
                <?php
                if(isset($_REQUEST['preSub']) && $_REQUEST['preSub']==1 && ($frmError ?? '') == false){
                    $ShowGridFlage=true;
                ?>
                
                                
                <div class="box-body clearfix">
                    <div class="panel panel-default">
                        <table id="myTable1" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Tender Id / Tender Title </th>
                                    <th>Corrigendum Heading</th>
                                    <th>Created By/On</th>                                                
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                        </table>
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
        $(document).delegate('.fa-quora,.fa-check-circle,.fa-remove', 'click', function() {
            var frmType=$(this).attr('cdata-frmT');
            //console.log(frmType);            
            if($.inArray(frmType,['3','4'])!='-1'){
                var con=confirm('Do you really want to Proceed?');
                //console.log(con)
                if(con){                        
                    $.base64.utf8encode = true;
                    $.ajax({
                        type     : "POST",
                        dataType: "text",
                        cache    : false,
                        url      : '<?php echo "revive_tenderCori_action.php?per_id=$_SESSION[per_id]&amp;EncHid=$_SESSION[EncTok]";?>',
                        data     : {<?php echo $GLOBALS['csrf']['token'];?>,'frmType':frmType,'t_temp_id':$(this).data('t_temp_id')},
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
                    url:"revive_tenderCori.php?frmType=" + frmType + "&t_temp_id=" + $(this).data('t_temp_id') + "&t_cat_id=<?php echo $_REQUEST['t_cat_id'];?>&per_id=<?php echo "$_SESSION[per_id]&EncHid=$_SESSION[EncTok]";?>",
                });
            }
        });
        
        
        $(function(){
            var mGridTable=$('table#myTable1').DataTable( {
                        "processing": true,
                        "serverSide": false,
                        "ajax": {
                            "url":"AjaxFill/getPendTendersCori.php?<?php echo "EncHid=$_SESSION[EncTok]";?>",
                            "type":"POST",
                            "data":{<?php echo $GLOBALS['csrf']['token'];?>,'t_cat_id':'<?php echo $_REQUEST['t_cat_id']."";?>','per_id':'<?php echo $_REQUEST['per_id']."";?>'}
                            },
                        scrollY:        400,
                        scrollCollapse: true,
                        paging:         false
                    } );
                        
            
            $(document).delegate('#reloadGrid', 'click', function ReLoadGrid() {
                mGridTable.ajax.reload( null, false );
            });
        })
         
    </script>

    
          <?php include('include/pageFooter.inc.php');?>