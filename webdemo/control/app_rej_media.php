<?php 
    include '../appcode/globals.inc.php';
    include_once(BASE_PATH .'/control/include/include.inc.php');
    userAuthenticationPageLevel();
    userAuthenticationMainLevel();
    include_once('include/pageHeader.inc.php');
    include('include/top_user_info.inc.php'); 
?>
    
<h2 class="h5 content-header text-dark">Approve/ Reject Media</h2>


                    <?php include('include/chooseMedCat.inc.php');?>
                                
                <?php
                if(isset($_REQUEST['preSub']) && $_REQUEST['preSub']==1 && ($frmError ?? '') ==false){
                    $ShowGridFlage=true;
                ?>
                    <div class="panel panel-default">
                        <table id="myTable1" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Description</th>
                                    <th>Description (Hindi)</th>
                                    <th>Photo/ Video</th>
                                    <th>Preview</th>
                                    <th>Created By/On</th>                                                
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div id="ShowMsg1"></div>                    
                    <div id="reloadGrid"></div>
                <?php
                }
                ?>                                





 <script type="text/javascript">        
        $(document).delegate('.fa-quora,.fa-check-circle,.fa-times', 'click', function() {
            var frmType=$(this).attr('cdata-frmT');
            console.log(frmType);            
            if($.inArray(frmType,['3','4'])!='-1'){
                var con=confirm('Do you really want to Proceed?');
                //console.log(con)
                if(con){                        
                    $.base64.utf8encode = true;
                    $.ajax({
                        type     : "POST",
                        dataType: "text",
                        cache    : false,
                        url      : '<?php echo "media_ap_action.php?per_id=$_SESSION[per_id]&EncHid=$_SESSION[EncTok]";?>',
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
                    url:"media_ap.php?frmType=" + frmType + "&link_temp_id=" + $(this).data('link_temp_id') + "&lang_id=<?= $_REQUEST['lang_id'] ?? ''; ?>&type_id=<?= $_REQUEST['type_id'] ?? '';?>&per_id=<?= $_SESSION['per_id']; ?>&EncHid=<?= $_SESSION['EncTok']; ?>",
                });
            }
        });
        
        
        $(function(){            
            var mGridTable=$('table#myTable1').DataTable( {
                        "processing": true,
                        "serverSide": false,
                        "ajax": {
                            "url":"AjaxFill/getPendMedia.php?<?php echo "EncHid=$_SESSION[EncTok]";?>",
                            "type":"POST",
                            "data":{<?php echo $GLOBALS['csrf']['token'];?>,'m_cat_id':'<?= $_REQUEST['m_cat_id'] ?? ''; ?>','per_id':'<?= $_REQUEST['per_id'] ?? ''; ?>','content_type_id':'<?= $_REQUEST['nmnh_type_id'] ?? '';?>'}
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
          

   