<?php include '../appcode/globals.inc.php';
include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');
userAuthenticationPageLevel();
userAuthenticationMainLevel();
include_once('include/pageHeader.inc.php');
$frmError=$secFrmFlage=false;
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
                  <h3 class="box-title">Map Sub Module with User Type</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">                    
                    <form name="frm" id="frm" action="<?php echo curPageName()."?per_id={$_REQUEST['per_id']}&EncHid={$_SESSION['EncTok']}"?>" role="form" class="form-border clearfix col-sm-6 col-sm-offset-3" method="post">
                        <input type="hidden" name="preSub" id="preSub" value="1" />
                        <div class="mb-3">
                          <label for="user_type_id" class="form-label">User Type</label>
                          <select name="user_type_id" id="user_type_id" class="form-control" data-validate="user_type_id|text|y|1|10|num|dontselect=-1|Please enter Valid option!">
                            <option value="-1">--- Select ---</option>
                            <?php
                            $rs1=fetchtable("web_st_user_type","status='Active' order by user_type");
                            if($rs1[0]>0){
                                foreach($rs1[1] as $row1){
                                    if(($_REQUEST['user_type_id'] ?? '')==$row1['user_type_id'])
                                        echo "<option value='$row1[user_type_id]' selected=''>$row1[user_type]</option>";
                                    else
                                        echo "<option value='$row1[user_type_id]'>$row1[user_type]</option>";
                                }
                            }
                            ?>
                          </select>
                        </div>  
                        <div class="col-sm-12 col-sm-offset-4 mb-4">
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
                    <div class="panel-heading box-title " style="font-weight:bold; ">Sub Modules List</div>
                        <div class="panel-body">
                             <form class="clearfix" name="frmmain" id="frmmain" method="post" action="map_func_user_action.php">
                                <input type="hidden" name="per_id" id="per_id" value="<?php echo $_REQUEST['per_id']?>" />
                                <input type="hidden" name="EncHid" id="EncHid" value="<?php echo $_SESSION['EncTok']?>" />                                    
                                    <input type="hidden" name="user_type_id" id="user_type_id" value="<?php echo $_REQUEST['user_type_id'];?>" />
                                     <div class="col-sm-12 col-sm-offset-2">                                             
                                      <table id="GridData" class="table table-bordered table-striped table-hover clearfix">
                                        <thead><?php
$sNo = 1;
$user_type_id = $_REQUEST['user_type_id'] ?? 0;

/* FETCH MODULES */
$modules = simplefetch("
SELECT module_id,module_name
FROM web_st_module
WHERE status='Active'
ORDER BY module_name
");

if($modules[0] > 0){

    foreach($modules[1] as $module){

        $submodules = simplefetch("
        SELECT 
            sm.sub_module_id,
            m.module_name,
            sm.sub_module_name,
            sm.fa_icon,
            sm.sub_module_page,
            sm.pos,
            IF(wfut.sub_module_id IS NOT NULL,'checked=\"\"','') AS flage
        FROM web_st_sub_module sm
        INNER JOIN web_st_module m 
            ON m.module_id = sm.module_id
        LEFT JOIN (
            SELECT *
            FROM web_map_func_user_type
            WHERE status='Active'
            AND user_type_id=".$user_type_id."
        ) wfut
            ON sm.sub_module_id = wfut.sub_module_id
        WHERE 
            m.status='Active'
            AND sm.status='Active'
            AND m.module_id=".$module['module_id']."
        ORDER BY sm.pos
        ");

        if($submodules[0] > 0){

            echo '<tr class="group"><td colspan="3">'.$module['module_name'].'</td></tr>';

            $lastRow = end($submodules[1]);
            reset($submodules[1]);

            foreach($submodules[1] as $row){
?>

<tr id="<?php echo $row['sub_module_id']; ?>">

<td class="reorder"><?php echo $sNo++; ?></td>

<td><?php echo $row['sub_module_name']; ?></td>

<td class="text-center error-message">
<div>

<input
type="checkbox"
name="chk[]"
id="chk_<?php echo $row['sub_module_id']; ?>"
value="<?php echo $row['sub_module_id']; ?>"
<?php echo $row['flage']; ?>
data-validate="<?php echo ($row === $lastRow)
? 'chk[]|checkbox|y|1|2|selmin=1|Please Select atleast One Checkbox to Proceed..'
: ''; ?>"
>

</div>
</td>

</tr>

<?php
            }
        }
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
            $('#frm').formChecks();                       
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
    