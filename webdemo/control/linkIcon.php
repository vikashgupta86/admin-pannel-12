<?php 
    include '../appcode/globals.inc.php';
    include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');
    AjaxFilePrevent();
    $_SESSION['uploader']='IC1425';

    $rs=simplefetch("SELECT lf.icon_name,lt.type_id, t.type,l.lang,lt.link_name,concat(u.user_name, '( ',date_format(lt.creation_date,'%d/%m/%Y'),' )')as linkCdate from web_link_temp lt
                        INNER JOIN web_links_final lf on lf.link_temp_id=lt.link_temp_id
                        INNER JOIN web_lang l on l.lang_id=lt.lang_id
                        INNER JOIN web_users u on u.user_id=lt.creator_id
                        INNER JOIN web_users au on au.user_id=lt.app_rej_user_id  
                        INNER JOIN web_link_type t on t.type_id=lt.type_id 
                        where lt.status='Active' and lf.status='Active' and lf.lid=$_REQUEST[lid]");
            
    if($rs[0]>0){
        foreach($rs[1] as $row);                    
    }
?>
            
<form name="formNC" id="formNC" method="post" autocomplete="off" role="form" action="<?php echo "linkIcon_action.php?per_id=$_SESSION[per_id]&amp;EncHid=$_SESSION[EncTok]";?>" enctype="multipart/form-data" >
    <input type="hidden" name="frmType" id="frmType" value="<?php echo $_REQUEST['frmType'];?>" />
    <input type="hidden" name="lang_id" id="lang_id" value="<?php echo $_REQUEST['lang_id'];?>" />
    <input type="hidden" name="link_temp_id" id="link_temp_id" value="<?php echo $_REQUEST['link_temp_id'];?>" />
    <input type="hidden" name="lid" id="lid" value="<?php echo $_REQUEST['lid'];?>" />            
        
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="l_name" class="form-label">Link Type:</label>
            <input type="text" class="form-control" value="<?= $row['type'] ?? ''; ?>" readonly disabled />
        </div>
        
        <div class="col-md-6 mb-3">
            <label for="l_alias" class="form-label">Language:</label>
            <input type="text" class="form-control" value="<?= $row['lang'] ?? ''; ?>" readonly disabled />
        </div>
        
        <div class="col-12 mb-3">
            <label for="l_name" class="form-label">Link Name:</label>
            <input type="text" class="form-control" value="<?= html_entity_decode($row['link_name']) ?? ''; ?>" readonly disabled />
        </div>
        
        <div class="form-group col-md-6">
            <label for="l_alias" class="form-label">Created by/ On:</label>
            <input type="text" class="form-control" value="<?= $row['linkCdate'] ?? ''; ?>" readonly disabled />
        </div>
        
        <div class="form-group col-md-6">
            <label for="l_alias" class="form-label">Approved by/ On:</label>
            <input type="text" class="form-control" value="<?= $row['linkCdate'] ?? ''; ?>" readonly disabled />
        </div>
                
        <?php
            if(!empty($row['icon_name'])){                              
                ?>
                <div class="col-12 mb-3">
                    <label for="l_file" class="form-label">Existing Icon: </label>
                    <img src="<?php echo "../WriteReadData/IC1425/$row[icon_name]";?>" class="img-thumbnail" alt="Link Icon" width="100"/>
                </div>
                <?php
            }
        ?>

        <div class="col-12 mb-3">
            <label for="l_file" class="form-label">Choose File: </label>
            <?php $Mand=(empty($row['icon_name']))?'y':'n';?>
            <input type="file" name="l_file" id="l_file" class="form-control" data-validate="l_file|file|<?php echo $Mand;?>|1|5000|file_extn=jpg;jpeg;png;|Please Select file, Allowed extenstions are jpg, jpeg, png!" accept="image/jpeg, image/jpg, image/png"/>
            <p class="help-block bg-danger mt-1">Allowed file extenstion are <kbd>jpg, jpeg, png</kbd>. File size should be less then 2 MB.</p> 
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
    $('#l_name').keyup(function(){        
        $('#l_title').val($(this).val());
    });
        
    function CallfrCk(){
        $('#formNC').formChecks({nonASCII:true,ajaxSubFunc:frmAction}).SetToFirstFocus();
    }
    CallfrCk();
    
    $('#formNC #type_id').change(function(){        
        var lType=$(this).val();
        //console.log(lType);
        switch(lType){
            case '1':
                $('#urlBlock,#contBlock').hide();
                $('#fileBlock').show();
                $(".modal-dialog").css("width", "600px");
            break;
            
            case '2':
                $('#fileBlock,#contBlock').hide();
                $('#urlBlock').show();
                $(".modal-dialog").css("width", "600px");
            break;
            
            case '3':
                $('#fileBlock,#urlBlock').hide();
                $('#contBlock').show();
                $(".modal-dialog").css("width", "800px");
                showRTF();
            break;
        }
        CallfrCk();
    })  
    $('#formNC #type_id').trigger('change');
})

function frmAction(){
    $.base64.utf8encode = true;
    
    var formData = new FormData();
    //formData.append('name', $('#formNC').serialize());
    formData.append('l_file', $('#l_file')[0].files[0]);
    
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
                    //($('#frmType').val()==1)?$('#formNC')[0].reset():'';                    
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
           // $.fn.custom_alert({msg:'Something went wrong, Please try again!'});    
            
            $('#ShowMsg').ShowMsg({msg:"<strong>Error:</strong> Something went wrong, Please try again!",colwidth:'col-md-8',coloffset:'col-md-offset-2',alertClass:'alert-warning'}); 
        },
        complete: function(){            
            $.fn.ajaxLoading({show:false});
        },
    });
}


</script>