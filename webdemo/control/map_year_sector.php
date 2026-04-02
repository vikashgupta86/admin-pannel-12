<?php include '../appcode/globals.inc.php';
include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');
$obj->userAuthenticationPageLevel();
$obj->userAuthenticationMainLevel();
include_once('include/pageHeader.inc.php');
$frmError=$secFrmFlage=false;
?>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <?php include('include/top_user_info.inc.php');?>  
          <!-- Left side column. contains the logo and sidebar -->
          <?php include('include/left_nav.inc.php');?>
        
          <!-- Content Wrapper. Contains page content -->
          <div class="content-wrapper">
            <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Map Subsectors with Year</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">                    
                    <form name="frm" id="frm" action="<?php echo $obj->curPageName()."?per_id={$_REQUEST['per_id']}&EncHid={$_SESSION['EncTok']}"?>" role="form" class="form-border clearfix col-sm-6 col-sm-offset-3" method="post">
                        <input type="hidden" name="preSub" id="preSub" value="1" />
                        <div class="form-group">
                          <label for="year_id">Select Year</label>
                          <select name="year_id" id="year_id" class="form-control" data-validate="year_id|text|y|1|10|num|dontselect=-1|Please enter Valid option!">
                            <option value="-1">--- Select ---</option>
                            <?php
                            $rs1=$obj->fetchtable("years","status='Active' order by years");
                            if($rs1[0]>0){
                                foreach($rs1[1] as $row1){
                                        echo "<option value='$row1[year_id]' selected=''>$row1[years]</option>";
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
                    $secFrmFlage=true;
                ?>                
                <div class="box-body clearfix">
                    <div class="panel panel-default">
                    <div class="panel-heading box-title">SubSector's List</div>
                        <div class="panel-body">
                             <form class="clearfix" name="frmmain" id="frmmain" method="post" action="<?php echo $obj->curPageName(false);?>_action.php">
                                <input type="hidden" name="per_id" id="per_id" value="<?php echo $_REQUEST['per_id']?>" />
                                <input type="hidden" name="EncHid" id="EncHid" value="<?php echo $_SESSION['EncTok']?>" />                                    
                                    <input type="hidden" name="year_id" id="year_id" value="<?php echo $_REQUEST['year_id'];?>" />
                                     <div class="col-sm-8 col-sm-offset-2">                                             
                                      <table id="GridData" class="table table-bordered table-striped table-hover clearfix">
                                        <thead>
                                        <tr>
                                          <th>S.No</th>
                                          <th>Sector Name</th>
                                          <th>Subsector Name</th>
                                          <th class="text-center">Select All <label for="chk[]"><input type="checkbox" name="chk" id="chk"></label></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php                                                                                
                                            $rs=$obj->simplefetch("SELECT s.subsector_id, s.sector_id, ns.sector_name, s.subsector_name, CASE WHEN m.subsector_id IS NOT NULL THEN 'checked' END AS flage FROM neca_subsectors s LEFT JOIN neca_sectors ns ON s.sector_id = ns.sector_id LEFT JOIN map_subsector_year m ON s.subsector_id = m.subsector_id AND m.year_id = $_REQUEST[year_id] and m.status='Active' ORDER BY ns.sector_name, s.subsector_name;",1);
                                            if($rs[0]>0){                                            
                                                foreach($rs[1] as $row){
                                                ?>
                                                <tr>
                                                    <td class="reorder"><?php echo ++$sNo;?></td>
                                                    <td><?php echo $row['sector_name'];?></td>
                                                    <td><?php echo $row['subsector_name'];?></td>
                                                    <td class="text-center error-message">                                                            
                                                      <div><input type="checkbox" name="chk[]" id="chk_<?php echo $row['subsector_id'];?>" value="<?php echo $row['subsector_id'];?>" <?php echo $row['flage'];?> data-validate="<?php echo end($rs[1])==$row?"chk[]|checkbox|y|1|2|selmin=1|Please Select atleast One Checkbox to Proceed..":""?>">                                                            
                                                   </div></td>
                                                </tr>
                                                <?php                                
                                                }
                                            }
                                        ?>
                                        </tbody>
                                      </table>
                                      <div class="col-sm-5 col-sm-offset-5 clearfix">
                                        <input type="submit" name="submit" id="submit" class="btn btn-primary" value="Update" />
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
        function subFrm(){
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
        }
        
        
        $(function(){            
            $('#frm').formChecks().SetToFirstFocus();                       
            <?php
            if($secFrmFlage==true){
            ?>
            $('#frmmain').formChecks({ajaxSubFunc:subFrm}).SetToFirstFocus();            
            <?php
            }
            ?>
            $('#chk').click(function(){
                $.fn.CheckAll({chkName:'chk[]',ckFlage:$(this).is(':checked')})
            })
        })
         
    </script>
    