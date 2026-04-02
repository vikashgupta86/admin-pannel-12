<?php 
    include '../appcode/globals.inc.php';
    include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');
    AjaxFilePrevent();

    if(isset($_REQUEST['frmType']) && $_REQUEST['frmType']==1){
        $rs=simplefetch("select t.type,l.lang,case when lt.continuous_content=1 then lt2.link_name else lt.link_name end as link_name,concat(u.user_name, '( ',date_format(lt.creation_date,'%d/%m/%Y'),' )')as linkCdate,lt.continuous_content from web_link_temp lt 
            INNER JOIN web_users u on u.user_id=lt.creator_id 
            INNER JOIN web_link_type t on t.type_id=lt.type_id 
            INNER JOIN web_lang l on l.lang_id=lt.lang_id 
            LEFT JOIN web_link_revive lr on lr.link_temp_id=lt.link_temp_id 
            LEFT JOIN web_link_temp lt2 on lt.main_link_temp_Id=lt2.link_temp_id
            where lt.status='Active' and lt.link_temp_id=$_REQUEST[link_temp_id]");
        if($rs[0]>0){
            foreach($rs[1] as $row);
        }
    }
    ?>
    
    <form name="formNC" id="formNC" method="post" autocomplete="off" role="form" action="<?php echo "revive_link_action.php?per_id=$_SESSION[per_id]&amp;EncHid=$_SESSION[EncTok]";?>" enctype="multipart/form-data" >
        <input type="hidden" name="frmType" id="frmType" value="<?php echo $_REQUEST['frmType'];?>" />
        <input type="hidden" name="lang_id" id="lang_id" value="<?php echo $_REQUEST['lang_id'];?>" />
        <input type="hidden" name="link_temp_id" id="link_temp_id" value="<?php echo $_REQUEST['link_temp_id'];?>" />            

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="l_name" class="form-label">Link Type:</label>
                <label class="normal "><?php echo $row['type'];?></label>                      
            </div>
        
            <div class="col-md-6 mb-3">
                <label for="l_alias" class="form-label">Language:</label>
                <label class="normal "><?php echo $row['lang'];?></label>
            </div>
        
            <div class="col-md-6 mb-3">
                <label for="l_name" class="form-label">Link Name:</label>
                <label class="normal "><?php echo html_entity_decode($row['link_name']);?></label>                      
            </div>
            
            <div class="col-md-6 mb-3">
                <label for="l_alias" class="form-label">Created by/ On:</label>
                <label class="normal "><?php echo $row['linkCdate'];?></label>
            </div>                    
                
            <div class="col-12 mb-3">
                <label for="r_details" class="form-label">Revive Details:</label>
                <textarea class="form-control" name="r_details" id="r_details" rows="8" placeholder="Revive Details" data-validate="r_details|textarea|y|1|2000|alnum_spc|Please enter Valid data!"><?php #echo html_entity_decode($row['link_bdesc']);?></textarea>
            </div>
                        
        </div>

    
        <div id="ShowMsg"></div>
        <div class="modal-footer in-modal-body">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>    


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