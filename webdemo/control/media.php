<?php include '../appcode/globals.inc.php';
include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');
AjaxFilePrevent();
$_SESSION['uploader']='MD32145';
?>

            <?php

                if(isset($_REQUEST['frmType']) && $_REQUEST['frmType']==2)
                {
                    $rs = simplefetch("SELECT * FROM web_media_temp WHERE status='Active' AND m_temp_id = ".$_REQUEST['m_temp_id_'].";");
                    if($rs[0]>0){
                        foreach($rs[1] as $row);                    
                    }
                }
            ?>
            
            <form name="formNC" id="formNC" method="post" autocomplete="off" role="form" action="<?php echo "media_action.php?per_id=$_SESSION[per_id]&amp;EncHid=$_SESSION[EncTok]";?>" enctype="multipart/form-data" >
            <input type="hidden" name="frmType" id="frmType" value="<?php echo $_REQUEST['frmType'];?>" />            
            <input type="hidden" name="m_temp_id" id="m_temp_id" value="<?php echo $_REQUEST['m_temp_id_'] ?? '';?>" />
            <input type="hidden" name="m_id" id="m_id" value="<?php echo $_REQUEST['m_id'];?>" />
            <input type="hidden" name="m_cat_id" id="m_cat_id" value="<?= $_REQUEST['m_cat_id'] ?? '';?>" /> 
            <input type="hidden" name="content_type_id" id="content_type_id" value="<?php echo $_REQUEST['content_type_id'];?>" /> 
                       

                    <div class="mb-3">
                      <label for="l_bdesc" class="form-label">Brief Description</label>
                      <textarea class="form-control" name="l_bdesc" id="l_bdesc" placeholder="Brief Description of the Media" data-validate="l_bdesc|textarea|n|1|2000|alnum_spc|Please enter Valid data!"><?= $row['m_description'] ?? '';?></textarea>
                    </div>
                    
                    <div class="mb-3">
                      <label for="l_bdesc_h" class="form-label">Brief Description (Hindi)</label>
                      <textarea class="form-control" name="l_bdesc_h" id="l_bdesc_h" placeholder="Brief Description of the Media" data-validate="l_bdesc_h|textarea|n|1|20000|alnum_spc|Please enter Valid data!"><?= $row['m_description_h'] ?? '';?></textarea>
                    </div>
					
					  <div class="mb-3">
					  
					    <?php 
						
						if(empty($_SESSION['musume_type'])){ ?>
						
                          <label for="nmnh_type_id" class="form-label">Site Type</label>
                      <select name="nmnh_type_id" id="nmnh_type_id" class="form-control" data-validate="nmnh_type_id|text|y|1|10|num|dontselect=-1|Please enter Valid option!">
                        <!-- <option value="-1">--- Select ---</option> -->

                        <?php
                            $rs1=fetchtable("nmnh_type","status='Active'",1);
                            if($rs1[0]>0){
                                foreach($rs1[1] as $row1)
                                {
                                    $selected = '';
                                    if(isset($row['nmnh_type']) && $row['nmnh_type'] == $row1['id']) {
                                        $selected = 'selected';
                                    } elseif(isset($_REQUEST['content_type_id']) && $_REQUEST['content_type_id'] == $row1['id']) {
                                        $selected = 'selected';
                                    } elseif($row1['nmnh_type'] == 'General' && !isset($row['nmnh_type']) && empty($_REQUEST['content_type_id'])) {
                                        $selected = 'selected';
                                    }
                                    echo "<option value='$row1[id]' $selected>$row1[nmnh_type]</option>";
                                }
                            }
                        ?>
                      </select>
                        </div>
						<?php }else{ ?>
						 <input type="hidden" name="nmnh_type_id" id="nmnh_type_id" value="<?php if(empty($_SESSION['musume_type'])){ echo "0"; } else{ echo $_SESSION['musume_type']; }?>" />
						<?php } ?>
					  </div>

                    <div class="mb-3 col-md-6">
                        <ul class="list-inline">
                            <li><label for="l_natur" class="form-label">Media Nature</label></li>
                            <li class="checkbox">
                                <input type="radio" name="l_natur" id="l_natur1" value="1" <?php if (($row['type_of_media'] ?? '') == '1') echo 'checked=""'; ?> required /> Photo
                                <input type="radio" name="l_natur" id="l_natur2" value="2" <?php if (($row['type_of_media'] ?? '') == '2') echo 'checked=""'; ?> data-validate="l_natur|checkbox|y|1|2|selmin=1|Please Select atleast One option!" required /> Video
                            </li>
                        </ul>
                    </div>
                    
                    <div class="mb-3 col-md-6">
                        <ul class="list-inline">
                            <li><label for="m_type" class="form-label">Media Type</label></li>
                            <li class="checkbox">
                                <input type="radio" name="m_type" id="m_type1" value="1" <?php if (($row['type_of_media'] ?? '') == '1') echo 'checked=""'; ?> required /> Upload                                
                                <input type="radio" name="m_type" id="m_type2" value="2" <?= (($row['type_of_media'] ?? '') == '2') ? 'checked=""' : ''; ?> data-validate="m_type|checkbox|y|1|2|selmin=1|Please Select atleast One option!" required/> Youtube
                            </li>
                        </ul>
                    </div>
                    
                    <div id="urlBlock">
                        <div class="form-group">
                          <label for="l_url" class="form-label">Media URL</label>
                          <input type="text" class="form-control" name="l_url" id="l_url" placeholder="Media URL" value="<?= $row['url'] ?? '';?>" data-validate="l_url|text|y|1|500|url|Please enter Valid URL!"/>
                          <p class="help-block">URL should be start 'http:// or https:// or ftp:// '</p>
                        </div>
                    </div>
                    
                    <div id="fileBlock">
                        <?php
                        if(!empty($row['image_name'])){                              
                        ?>
                        <div class="mb-3col-md-6">
                          <label for="l_file" class="form-label">Existing Image</label>
                          <img src="<?php echo "../WriteReadData/$_SESSION[uploader]/$row[image_name]";?>" class="img-thumbnail" alt="Link Icon" width="100"/>
                        </div>
                        <?php
                        }
                        ?>
                        <div class="form-group">
                          <label for="l_file" class="form-label">Choose File</label>
                          <?php $Mand=(empty($row['image_name']))?'y':'n';?>
                          
                          <input type="file" name="l_file" id="l_file" data-validate="l_file|file|<?php echo $Mand;?>|1|20000|file_extn=jpg;png;jpeg;mp4;flv;|Please Select file, Allowed extenstions are jpg, jpeg, png!" accept="image/png, image/jpeg, image/jpg"/>
                          <p class="help-block">File size should be less then 2 MB.</p> 
                        </div>
                    </div>
                                        
                  </div>

                <div class="clearfix"></div>
                <div id="ShowMsg"></div>
            
			
			<div class="clearfix"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary ">Submit</button>
            </div>
			</div>
            
            </form>    
           
<script <?= $nonce; ?>  type="text/javascript">
$(function()
{
    $(".modal-dialog").css("width", "700px");
    <?php if(($row['type_of_media'] ?? '') == '1') { ?>
    $('#urlBlock').hide();
    <?php } else if (($row['type_of_media'] ?? '') == '2') { ?>
    $('#fileBlock').hide();
    <?php } ?>
    $('#l_name').keyup(function(){        
        $('#l_title').val($(this).val());
    });
        
    function CallfrCk(){
        $('#formNC').formChecks({nonASCII:true,ajaxSubFunc:frmAction}).SetToFirstFocus();
    }
    CallfrCk();
    
    // $('input[type="radio"][name="l_natur"]').click(function()
    // {
    //     alert($(this).val());
    //     if($(this).val()==1)
    //     {
    //     //photo
    //         $('#urlBlock').hide();
    //         $('#fileBlock').show();
                                    
    //         $('#l_file').attr({'data-validate':$('#l_file').data('validate').replace('mp4;flv;','jpg;png;jpeg;').replace('mp4, flv', 'jpg, jpeg, png')})            
            
    //         $('#m_type1').trigger('click');
    //         $('#m_type2').addClass('disabled').attr({'disabled':true});
    //     }
    //     else{//video
    //         //$('#urlBlock').show();
    //         //$('#fileBlock').hide();
    //         //console.log($('#l_file').data('validate').replace('jpg;png;jpeg;', 'mp4;flv;').replace('jpg, jpeg, png', 'mp4, flv'))
    //         //$('#l_file').data('validate',$('#l_file').data('validate').replace('jpg;png;jpeg;', 'mp4;flv;').replace('jpg, jpeg, png', 'mp4, flv'));
    //         $('#l_file').attr({'data-validate':$('#l_file').data('validate').replace('jpg;png;jpeg;', 'mp4;flv;').replace('jpg, jpeg, png', 'mp4, flv')});
    //         $('#m_type2').removeClass('disabled').removeAttr('disabled');
    //     }
    //     CallfrCk();
    // })
    
    
    
    // $('#formNC #type_id').change(function(){        
    //     var lType=$(this).val();
    //     //console.log(lType);
    //     switch(lType){
    //         case '1':
    //             $('#urlBlock,#contBlock').hide();
    //             $('#fileBlock').show();
    //             $(".modal-dialog").css("width", "600px");
    //         break;
            
    //         case '2':
    //             $('#fileBlock,#contBlock').hide();
    //             $('#urlBlock').show();
    //             $(".modal-dialog").css("width", "600px");
    //         break;
            
    //         case '3':
    //             $('#fileBlock,#urlBlock').hide();
    //             $('#contBlock').show();
    //             $(".modal-dialog").css("width", "800px");
    //             showRTF();
    //         break;
    //     }
    //     CallfrCk();
    // })  
    // $('#formNC #type_id').trigger('change');
});


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


$(document).on('change','input[name="l_natur"]', function () {

    var val = $(this).val();
    if(val == '1')
    {
        // PHOTO
        $('#urlBlock').hide();
        $('#fileBlock').show();

        var rule = $('#l_file').attr('data-validate');
        rule = rule.replace('mp4;flv;','jpg;png;jpeg;');
        $('#l_file').attr('data-validate', rule);

        $('#m_type1').prop('checked', true);
        $('#m_type2').prop('disabled', true).addClass('disabled');
    }
    else
    {
        // VIDEO
        var rule = $('#l_file').attr('data-validate');
        rule = rule.replace('jpg;png;jpeg;','mp4;flv;');
        $('#l_file').attr('data-validate', rule);

        $('#m_type2').prop('disabled', false).removeClass('disabled');
    }

});


$('input[type="radio"][name="m_type"]').click(function(){
    if($(this).val()==1){//upload
        $('#urlBlock').hide();
        $('#fileBlock').show();
    }
    else{//url
        $('#urlBlock').show();
        $('#fileBlock').hide();            
    }
    CallfrCk();
});





// ==============================================================
$(document).ready(function () {

    $('#formNC').on('submit', function (e) {
        e.preventDefault();   
        frmAction();
    });

});


function frmAction() 
{
    var form = $('#formNC')[0];
    var formData = new FormData(form);
    clearFormErrors();

    $.ajax({
        type: "POST",
        url: $('#formNC').attr('action'),
        data: formData,
        dataType: "text",
        processData: false,
        contentType: false,
        cache: false,
        beforeSend: function () {
            $.fn.ajaxLoading();
        },

        success: function (response) {
            try {
                var decoded = atob(response);
                var data = JSON.parse(decoded);
                // console.log(data);
                if (data[0] === true) {

                    if ($('#frmType').val() == 1) {
                        $('#formNC')[0].reset();
                    }

                    $('#ShowMsg').ShowMsg({
                        msg: 'Request Completed Successfully!',
                        colwidth: 'col-md-8',
                        coloffset: 'col-md-offset-2',
                        alertClass: 'alert-success'
                    });

                    $('#reloadGrid').trigger('click');

                    $('#PopWind')
                        .find('input, textarea, select, button')
                        .prop('disabled', true);

                    $('#PopWind').modal({ backdrop: 'static', keyboard: false });

                    setTimeout(function () {

                        $('#PopWind')
                            .find('input, textarea, select, button')
                            .prop('disabled', false);

                        $('#PopWind').modal('hide');

                    }, 3000);

                } 
                else {

                    if (data[1] && data[1][0] === true) {

                        showFormErrors(data[1][1]);

                    } 
                    else if (data[2] && data[2][0] === true) {

                        var MEror = data[2][1];

                        $('#ShowMsg').ShowMsg({
                            msg: MEror,
                            alertClass: data[2][2],
                            colwidth: 'col-md-8',
                            coloffset: 'col-md-offset-2'
                        });

                    } 
                    else {

                        $('#ShowMsg').ShowMsg({
                            msg: 'Request not Completed Successfully!',
                            colwidth: 'col-md-8',
                            coloffset: 'col-md-offset-2',
                            alertClass: 'alert-danger'
                        });

                    }

                }

            } 
            catch (err) {

                console.error("Response Error:", err);

                $('#ShowMsg').ShowMsg({
                    msg: "<strong>Error:</strong> Unexpected Response received, You may try again!",
                    colwidth: 'col-md-8',
                    coloffset: 'col-md-offset-2',
                    alertClass: 'alert-warning'
                });

            }

        },

        error: function (xhr) {

            $('#PopWind').modal('toggle');

            if (xhr.status == 403) {

                $.fn.custom_alert({
                    msg: $(xhr.responseText).find("#custom_msg").html()
                });

            } 
            else {

                $.fn.custom_alert({
                    msg: 'Something went wrong. Please try again!'
                });

            }

        },

        complete: function () {
            $.fn.ajaxLoading({ show: false });
        }

    });

}




function showFormErrors(errors) {

    clearFormErrors();

    $.each(errors, function (key, value) {

        var field = value[1];
        var message = value[3];

        var input = $("#" + field);

        input.addClass('input-error');

        input.after(
            '<div class="field-error text-danger">' + message + '</div>'
        );

    });

}


function clearFormErrors(){

    $('.field-error').remove();
    $('.input-error').removeClass('input-error');

}


$(document).on('input change','input,textarea,select',function(){

    $(this).removeClass('input-error');
    $(this).next('.field-error').remove();

});
</script>