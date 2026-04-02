<?php include '../appcode/globals.inc.php';
include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');
AjaxFilePrevent();
?>
<div id="PopWind" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">            
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Add/ Modify Sub Module</h4>
            </div>
            
            <?php
            if(isset($_REQUEST['frmType']) && $_REQUEST['frmType']==2){
                $rs=simplefetch("select sub_module_id,module_id,sub_module_name,sub_module_page,fa_icon,per_type_id from web_st_sub_module where status='Active' and sub_module_id=$_REQUEST[sub_module_id]");
                if($rs[0]>0){
                    foreach($rs[1] as $row);
                }
            }
            ?>
            
            <form name="formNC" id="formNC" method="post" autocomplete="off" role="form" action="<?php echo "sub_module_action.php?per_id=$_SESSION[per_id]&amp;EncHid=$_SESSION[EncTok]";?>">
            <input type="hidden" name="frmType" id="frmType" value="<?php echo $_REQUEST['frmType'];?>" />
            <input type="hidden" name="sub_module_id" id="sub_module_id" value="<?php echo $_REQUEST['sub_module_id'];?>" />
            <div class="modal-body">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="module_id">Module Name</label>
                      <select name="module_id" id="module_id" class="form-control" data-validate="module_id|text|y|1|10|num|dontselect=-1|Please enter Valid option!">
                        <option value="-1">--- Select ---</option>
                        <?php
                        $rs1=fetchtable("web_st_module","status='Active'");
                        if($rs1[0]>0){
                            foreach($rs1[1] as $row1){
                                if(($row['module_id'] ?? '') ==$row1['module_id'])
                                    echo "<option value='$row1[module_id]' selected=''>$row1[module_name]</option>";
                                else
                                    echo "<option value='$row1[module_id]'>$row1[module_name]</option>";
                            }
                        }
                        ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="sm_name">Sub Module Name</label>
                      <input type="text" class="form-control" name="sm_name" id="sm_name" placeholder="Sub Module Name" value="<?= ($row['sub_module_name'] ?? ''); ?>" data-validate="sm_name|text|y|1|50|alnum_spc|Please enter Valid Sub Module Name!">
                    </div>
                    
                    <div class="form-group">
                      <label for="submodule_page">Page Name</label>
                      <input type="text" class="form-control" name="submodule_page" id="submodule_page" placeholder="Page Name" value="<?= ($row['sub_module_page'] ?? ''); ?>" data-validate="submodule_page|text|y|1|250|alnum_spc|Please enter Valid page Name!">
                    </div>
                    
                    <div class="form-group">
                      <label for="fa_ico_name">Fontawesome Icon Name</label>
                      <input type="text" class="form-control" name="fa_ico_name" id="fa_ico_name" placeholder="Icon Name" value="<?= ($row['fa_icon'] ?? ''); ?>" data-validate="fa_ico_name|text|n|1|25|alnum_spc|Please enter Valid Icon Name!">
                    </div>
                    
                    <div class="form-group">
                        <label for="per_types[]">Nature of Permissions</label>
                        <div class="checkbox">
                        <?php
                        $rs2 = fetchcols("web_st_permission_type", "per_type_id,per_type_name,case when FIND_IN_SET(per_type_id,\"$row[per_type_id]\") then 'checked=\"true\"' else '' end as chk", "order by pos");
                        if ($rs2[0] > 0) {
                            foreach ($rs2[1] as $row2) {
                                $PtypStr[] = $row2['per_type_id'];
                                ?>                                
                                <label class="radio-inline last-label">
                                  <input type="checkbox" name="per_types[]" id="per_type_<?php echo $row2['per_type_id']; ?>" value="<?php echo $row2['per_type_id']; ?>" <?php echo $row2['chk']; ?>  data-validate="<?php echo end($rs2[1])==$row2?"per_types|checkbox|y|1|2|selmin=1|Please Select atleast One Checkbox to Proceed..":""?>">
                                  <?php echo $row2['per_type_name']; ?>
                                </label>
                            <?php
                            }
                        }
                        ?>
                        </div>
                    </div>
                  </div>
                  <!-- /.box-body -->
                  <!--<div class="box-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>-->
                
                <div class="clearfix"></div>
                <div id="ShowMsg"></div>
            </div>
            <div class="clearfix"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            </form>    
            <div class="clearfix"></div>        
        </div>
    </div>
</div>
<script type="text/javascript">
$(function(){
    $('#formNC').formChecks({ajaxSubFunc:frmAction}).SetToFirstFocus();  
})

function frmAction(){
    $.base64.utf8encode = true;
    $.ajax({
        type     : "POST",
        dataType: "text",
        cache    : false,
        url      : $('#formNC').attr('action'),
        data     : $('#formNC').serialize(),
        beforeSend: function(){
            $.fn.ajaxLoading();
        },        
        success  : function(data) {                                    
            try{
                data=$.parseJSON($.base64.atob(data));            
                if(data[0]){                    
                    ($('#frmType').val()==1)?$('#formNC')[0].reset():'';                    
                    $('#ShowMsg').ShowMsg({msg:'Request Completed Successfully!',colwidth:'col-md-8',coloffset:'col-md-offset-2',alertClass:'alert-success'});
                    $('#reloadGrid').trigger('click');                                        
                }
                else{                    
                    if(data[1]!= undefined && data[1][0]==true){
                        FEror=data[1][1];                    
                        $.fn.ShowError(FEror);    
                    }
                    else if(data[2]!= undefined && data[2][0]==true){
                        MEror=data[2][1];
                        //console.log(MEror);
                        $('#ShowMsg').ShowMsg({msg:MEror,alertClass:data[2][2],colwidth:'col-md-8',coloffset:'col-md-offset-2'});
                    }
                    else{                                          
                        $('#ShowMsg').ShowMsg({msg:'Request not Completed Successfully!',colwidth:'col-md-8',coloffset:'col-md-offset-2',alertClass:'alert-danger'});                        
                    }
                }
            }
            catch(err) {
                $('#ShowMsg').ShowMsg({msg:"<strong>Error:</strong> Unexpected Response received, You may try again!",colwidth:'col-md-8',coloffset:'col-md-offset-2',alertClass:'alert-warning'});                                
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


</script>