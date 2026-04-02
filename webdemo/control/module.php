<?php include '../appcode/globals.inc.php';
include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');
AjaxFilePrevent();
?>
<!-- <div id="PopWind" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">            
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Add/ Modify Module</h4>
            </div> -->
            
            <?php
            if(isset($_REQUEST['frmType']) && $_REQUEST['frmType']==2){
                $rs=simplefetch("select module_name,module_id,fa_icon from web_st_module where status='Active' and module_id=$_REQUEST[module_id]");
                if($rs[0]>0){
                    foreach($rs[1] as $row);
                }
            }
            ?>
            
            <form name="formNC" id="formNC" method="post" autocomplete="off" role="form" action="<?php echo "module_action.php?per_id=$_SESSION[per_id]&amp;EncHid=$_SESSION[EncTok]";?>">
            <input type="hidden" name="frmType" id="frmType" value="<?php echo $_REQUEST['frmType'];?>" />
            <input type="hidden" name="module_id" id="module_id" value="<?php echo $_REQUEST['module_id'];?>" />
            <div class="modal-body">
                  <div class="box-body">
                    <div class="mb-3">
                      <label for="m_name" class="form-label">Module Name</label>
                      <input type="text" class="form-control" name="m_name" id="m_name" placeholder="Module Name" value="<?php echo ($row['module_name'] ?? '');?>" data-validate="m_name|text|y|1|50|alnum_spc|Please enter Valid Module Name!">
                    </div>
                    <div class="mb-3">
                      <label for="fa_ico_name"  class="form-label">Fontawesome Icon Name</label>
                      <input type="text" class="form-control" name="fa_ico_name" id="fa_ico_name" placeholder="Icon Name" value="<?php echo ($row['fa_icon'] ?? '');?>" data-validate="fa_ico_name|text|n|1|25|alnum_spc|Please enter Valid Icon Name!">
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
            <!-- <div class="clearfix"></div>        
        </div>
    </div>
</div> -->
<script type="text/javascript">
$(function(){
    $('#formNC').formChecks({ajaxSubFunc:frmAction}).SetToFirstFocus();  
})

function frmAction(){
   // $.base64.utf8encode = true;
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