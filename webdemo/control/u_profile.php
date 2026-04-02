<?php include '../appcode/globals.inc.php';
include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');
userAuthenticationPageLevel();
userAuthenticationMainLevel();
include_once('include/pageHeader.inc.php');
$frmError=$ShowGridFlage=false;
?>
  
            <?php include('include/top_user_info.inc.php');?>  
        
          <!-- Content Wrapper. Contains page content -->
          <div class="content-wrapper">
            <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Profile Details</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body" id="showUprofile">                    
                    
                </div>
                
                <div id="ShowMsg1"></div>
                <div id="reloadGrid"></div>
                <!-- /.box-body -->
            </div>                    
        </div>
          <!-- /.content-wrapper -->
          
          
          
    <script <?= $nonce; ?>  type="text/javascript">
        $(function(){
            function GetProfile(){
                $.ajax({
                        type     : "POST",
                        dataType: "html",
                        cache    : false,
                        url      : '<?php echo "AjaxFill/get_profile.php?per_id=$_SESSION[per_id]&EncHid=$_SESSION[EncTok]";?>',
                        data     : {<?php echo $GLOBALS['csrf']['token'];?>},
                        beforeSend: function(){
                            $.fn.ajaxLoading();
                        },        
                        success  : function(data) {                                    
                            try{
                                $('#showUprofile').html(data);
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
            
            GetProfile();
            
            $(document).delegate('#reloadGrid', 'click', function ReLoadGrid() {
                GetProfile();
            });
        })
        
        
           
        $(document).delegate('#edtProfile', 'click', function() {
            var frmType=$(this).attr('cdata-frmT');
            //console.log(frmType);            
            if($.inArray(frmType,['3','4','5','6'])!='-1'){
                var con=confirm('Do you really want to Proceed?');
                //console.log(con)
                /*if(con){                        
                    $.base64.utf8encode = true;
                    $.ajax({
                        type     : "POST",
                        dataType: "text",
                        cache    : false,
                        url      : '<?php echo "links_action.php?per_id=$_SESSION[per_id]&amp;EncHid=$_SESSION[EncTok]";?>',
                        data     : {<?php echo $GLOBALS['csrf']['token'];?>,'frmType':frmType,'link_temp_id':$(this).data('link_temp_id')},
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
                }*/
            }
            else
            {
                var lid=($(this).attr('pub-lid')!=undefined)?$(this).attr('pub-lid'):'';
                $('.modal-container').OpenPop({
                    url:"profile.php?frmType=" + frmType + "&per_id=<?php echo "$_SESSION[per_id]&EncHid=$_SESSION[EncTok]";?>",
                });
            }
        });
         
    </script>
    

    <?php include('include/pageFooter.inc.php');?>