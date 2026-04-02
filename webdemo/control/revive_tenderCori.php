<?php include '../appcode/globals.inc.php';
include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');
$obj->AjaxFilePrevent();
?>
<div id="PopWind" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">            
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Revive Link</h4>
            </div>
                        
            <?php
            if(isset($_REQUEST['frmType']) && $_REQUEST['frmType']==1){
                $rs=$obj->simplefetch("select tt.tender_name,concat(u.user_name, '( ',date_format(tt.creation_date,'%d/%m/%Y'),' )')as linkCdate from web_tender_temp tt 
                    INNER JOIN web_users u on u.user_id=tt.creator_id 
                    LEFT JOIN web_tender_revive tr on tr.t_temp_id=tt.t_temp_id                     
                    where tt.status='Active' and tt.corrigendum=1 and tt.t_temp_id=$_REQUEST[t_temp_id]");
                if($rs[0]>0){
                    foreach($rs[1] as $row);
                }
            }
            ?>
            
            <form name="formNC" id="formNC" method="post" autocomplete="off" role="form" action="<?php echo "revive_tenderCori_action.php?per_id=$_SESSION[per_id]&amp;EncHid=$_SESSION[EncTok]";?>" enctype="multipart/form-data" >
            <input type="hidden" name="frmType" id="frmType" value="<?php echo $_REQUEST['frmType'];?>" />
            <input type="hidden" name="t_cat_id" id="t_cat_id" value="<?php echo $_REQUEST['t_cat_id'];?>" />
            <input type="hidden" name="t_temp_id" id="t_temp_id" value="<?php echo $_REQUEST['t_temp_id'];?>" />            
            <div class="modal-body">
                  <div class="box-body">
                    <div class="form-group col-md-6">
                      <label for="l_name">Corrigendum Heading:</label>
                      <label class="normal "><?php echo html_entity_decode($row['tender_name']);?></label>                      
                    </div>
                    
                    <div class="form-group col-md-6">
                      <label for="l_alias">Created by/ On:</label>
                      <label class="normal "><?php echo $row['linkCdate'];?></label>
                    </div>                    
                        
                    <div class="form-group">
                      <label for="r_details">Revive Details:</label>
                      <textarea class="form-control" name="r_details" id="r_details" rows="8" placeholder="Revive Details" data-validate="r_details|textarea|y|1|2000|alnum_spc|Please enter Valid data!"><?php #echo html_entity_decode($row['link_bdesc']);?></textarea>
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
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            </form>    
            <div class="clearfix"></div>        
        </div>
    </div>
</div>

<script type="text/javascript">
$(function(){
    function CallfrCk(){
        $('#formNC').formChecks({nonASCII:true,ajaxSubFunc:frmAction}).SetToFirstFocus();
    }
    CallfrCk();
})

function frmAction(){
    $.base64.utf8encode = true;
    
    var formData = new FormData();
    var other_data = $('#formNC').serializeArray();
    $.each(other_data,function(key,input){
        formData.append(input.name,input.value);
    });
    
    $.ajax({
        type     : "POST",
        dataType: "text",
        cache    : false,        
        enctype: 'multipart/form-data',
        url      : $('#formNC').attr('action'),
        data     : formData,//$('#formNC').serialize(),        
        processData: false,
        contentType: false,
        
        beforeSend: function(){
            $.fn.ajaxLoading();
        },        
        success  : function(data) {                                    
            try{
                data=$.parseJSON($.base64.atob(data));            
                if(data[0]){                    
                    ($('#frmType').val()==1)?$('#formNC')[0].reset():'';                    
                    $('#ShowMsg1').ShowMsg({msg:'Request Completed Successfully!',alertClass:'alert-success'});
                    $('#reloadGrid').trigger('click');
                    $('#PopWind').modal('toggle');                                        
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
            $('#PopWind').modal('toggle');
            $.fn.custom_alert({msg:'Something went wrong, Please try again!'});                        
        },
        complete: function(){            
            $.fn.ajaxLoading({show:false});
        },
    });
}


</script>