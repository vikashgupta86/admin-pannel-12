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
                  <h3 class="box-title">Set Modules Position</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <form name="frmmain" id="frmmain" action="set_pos_module_action.php" method="post" class="form-border clearfix col-sm-8 col-sm-offset-2">
                    <input type="hidden" name="per_id" id="per_id" value="<?php echo $_REQUEST['per_id']?>" />
                    <input type="hidden" name="EncHid" id="EncHid" value="<?php echo $_SESSION['EncTok']?>" />
                    <input type="hidden" name="mStr" id="mStr" value="" />
                     <div class="col-sm-12">                                             
                      <table id="GridData" class="table table-bordered table-striped table-hover">
                        <thead>
                        <tr>
                          <th>S.No</th>
                          <th>Module Name</th>
                          <th>Position</th>
                        </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                      </table>
                      <div class="col-sm-8 col-sm-offset-5">
                      <input type="button" name="submit" id="submit" class="btn btn-primary" value="Update" />
                      </div>                      
                  </div>
                  </form>  
                </div>
                <!-- /.box-body -->
              </div>
              <div id="ShowMsg"></div>
            </div>
          </div>          
          <!-- /.content-wrapper -->
          
        
          
          <!-- /.control-sidebar -->
          <!-- Add the sidebar's background. This div must be placed
               immediately after the control sidebar -->
          <div class="control-sidebar-bg"></div>
        </div>
        <?php include('include/pageFooter.inc.php');?>
    </body>
    <script type="text/javascript">        
        var sortedIDs=$('#GridData tbody').sortable();
        $('#submit').click(function(){            
            var sortedIDs = $( "#GridData tbody" ).sortable( "toArray" );
            $('#mStr').val(sortedIDs);        
            $.base64.utf8encode = true;
            $.ajax({
                type     : "POST",
                dataType: "text",
                cache    : false,
                url      : $('#frmmain').attr('action'),
                data     : $('#frmmain').serialize(),
                beforeSend: function(){
                    $.fn.ajaxLoading();
                },        
                success  : function(data) {                                    
                    try{
                        data=$.parseJSON($.base64.atob(data));            
                        if(data[0]){            
                            $('#ShowMsg').ShowMsg({msg:'Request Completed Successfully!',alertClass:'alert-success'});
                            GetGrid();                                        
                        }
                        else{                    
                            if(data[1]!= undefined && data[1][0]==true){
                                FEror=data[1][1];                    
                                $.fn.ShowError(FEror);    
                            }
                            else if(data[2]!= undefined && data[2][0]==true){
                                MEror=data[2][1];                                
                                $('#ShowMsg').ShowMsg({msg:MEror,alertClass:data[2][2]});
                            }
                            else{                                          
                                $('#ShowMsg').ShowMsg({msg:'Request not Completed Successfully!',alertClass:'alert-danger'});                        
                            }
                        }
                    }
                    catch(err) {
                        $('#ShowMsg').ShowMsg({msg:"<strong>Error:</strong> Unexpected Response received, You may try again!",alertClass:'alert-warning'});                                
                    }
                                           
                },
                error:function(){
                    $.fn.custom_alert({msg:'Something went wrong, Please try again!'});                        
                },
                complete: function(){            
                    $.fn.ajaxLoading({show:false});
                },
            });
        })
        
        function GetGrid(){
            $('#GridData tbody').loadGrid({pageName:"AjaxFill/getPosModules.php?per_id=<?php echo "$_SESSION[per_id]&EncHid=$_SESSION[EncTok]";?>"});
        }
        
        $(function(){
            GetGrid();
        })
         
    </script>
    