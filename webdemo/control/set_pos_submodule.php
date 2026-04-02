<?php include '../appcode/globals.inc.php';
include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');
userAuthenticationPageLevel();
userAuthenticationMainLevel();
include_once('include/pageHeader.inc.php');
$frmError=$ShowGridFlage=false;
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
                  <h3 class="box-title">Set Sub Modules Position</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">                    
                    <form name="frm" id="frm" action="<?php echo curPageName().""?>" role="form" class="form-border clearfix col-sm-6 col-sm-offset-3" method="post">
                        <input type="hidden" name="preSub" id="preSub" value="1" />     
                        <input type="hidden" name="per_id" id="per_id" value="<?php echo $_REQUEST['per_id']?>" />
                        <input type="hidden" name="EncHid" id="EncHid" value="<?php echo $_SESSION['EncTok']?>" />                 
                        <div class="mb-3">
                          <label for="module_id" class="form-label">Module Name</label>
                          <select name="module_id" id="module_id" class="form-control" data-validate="module_id|text|y|1|10|num|dontselect=-1|Please enter Valid option!">
                            <option value="-1">--- Select ---</option>
                            <?php
                            $rs1=fetchtable("web_st_module","status='Active' order by pos, module_name");
                            if($rs1[0]>0){
                                foreach($rs1[1] as $row1){
                                    if(($_REQUEST['module_id']?? '')==$row1['module_id'])
                                        echo "<option value='$row1[module_id]' selected=''>$row1[module_name]</option>";
                                    else
                                        echo "<option value='$row1[module_id]'>$row1[module_name]</option>";
                                }
                            }
                            ?>
                          </select>
                        </div>  
                        <div class="col-sm-8 col-sm-offset-4">
                            <button type="submit" class="btn btn-primary">Submit</button>
                          </div>
                    </form>
                </div>
                
                
                
                <?php
                if(isset($_REQUEST['preSub']) && $_REQUEST['preSub']==1 && $frmError==false){
                    $ShowGridFlage=true;
                ?>                
                <div class="box-body clearfix">
                    <div class="panel panel-default">
                    <div class="panel-heading box-title mt-3">Sub Modules List</div>
                        <div class="panel-body">
                             <form class="clearfix" name="frmmain" id="frmmain" method="post" action="set_pos_submodule_action.php">
                                <input type="hidden" name="per_id" id="per_id" value="<?php echo $_REQUEST['per_id']?>" />
                                <input type="hidden" name="EncHid" id="EncHid" value="<?php echo $_SESSION['EncTok']?>" />
                                    <input type="hidden" name="mStr" id="mStr" value="" />
                                    <input type="hidden" name="module_id" id="module_id" value="<?php echo $_REQUEST['module_id'];?>" />
                                     <div class="col-sm-8 col-sm-offset-2">                                             
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
                                      <div class="col-sm-8 col-sm-offset-4">
                                      <input type="button" name="submit" id="submit" class="btn btn-primary" value="Update" />
                                      </div>                      
                                  </div>
                           </form> 
                      </div>
                    </div>
                    <div id="ShowMsg"></div>
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
                            GetGrid($('form[id=frmmain] #module_id').val());                                        
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
        
        function GetGrid(mod_id){
            $('#GridData tbody').loadGrid({pageName:"AjaxFill/getPosSubModules.php?module_id="+mod_id+"&per_id=<?php echo "$_REQUEST[per_id]&EncHid=$_SESSION[EncTok]";?>"});
        }
        
        $(function(){            
            $('#frm').formChecks().SetToFirstFocus();
            //GetGrid();            
            <?php
            if(isset($_REQUEST['module_id'])){
            ?>
            GetGrid(<?php echo $_REQUEST['module_id'];?>);
            <?php
            }
            ?>
            
        })
         
    </script>
    