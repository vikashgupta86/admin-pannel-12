<?php include '../appcode/globals.inc.php';
include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');
userAuthenticationPageLevel();
userAuthenticationMainLevel();
include_once('include/pageHeader.inc.php');
$frmError = $ShowGridFlage=false;
?>
    
            <?php include('include/top_user_info.inc.php');?>  
    
            <h2 class="h5 mb-4 text-dark" style="font-weight: 400;">Change Password</h2>
<!-- id="changePasswordForm"-->
            <div class="form-box"> 
                <form name="formNC" id="formNC" action="<?php echo "change_pass_action.php?EncHid=$_SESSION[EncTok]"?>">
                    <input type="hidden" name="preSub" id="preSub" value="1" />     
                    <input type="hidden" name="per_id" id="per_id" value="<?php echo $_REQUEST['per_id']?>" />
                    <input type="hidden" name="hash" id="hash" class="" value=""/>
                    <input type="hidden" name="hash1" id="hash1" value="" class=""/>
                    <input type="hidden" name="hash2" id="hash2" value="" class=""/>
                    <input type="hidden" name="hash3" id="hash3" class="" value=""/>
                    <div class="mb-3">
                        <label class="form-label">Current Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" name="T1" id="T1" placeholder="Current Password" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">New Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" placeholder="New Password" name="T2" id="T2" required>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label">Re-confirm Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" placeholder="Re-confirm New Password" name="T3" id="T3" required>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary rounded-0 px-4 fw-bold" style="background-color: #337ab7; border-color: #2e6da4;">Submit</button>
                    </div>
                </form>
            </div>

            <div id="ShowMsg"></div>




          
<script <?= $nonce; ?>  type="text/javascript">        

// ==============================================================
$(document).ready(function () {

    $('#formNC').on('submit', function (e) {
        e.preventDefault();   
        frmAction();
    });

});


function frmAction() 
{
    // Sync TinyMCE back to the textarea so the value is correctly picked up by the form data collection
    if (typeof tinymce !== 'undefined') 
    {
        tinymce.triggerSave();
    }
    
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
        
        $(function(){
            $('#frmmain').formChecks({addlFunc:CallBackME(),ajaxSubFunc:frmAction}).SetToFirstFocus();
            function CallBackME(){
                // $('#hash').val('');
                // $('#hash,#hash3').val($.fn.md5({string:(Math.floor(Math.random()*90000000) + 10000000).toString()}));

                 $('#hash').val('');
    $('#hash3').val('<?php echo isset($_SESSION['auth_seed']) && !empty($_SESSION['auth_seed'])?md5($_SESSION['auth_seed']):'';?>');
            }
        })
         
    </script>

    <?php include('include/pageFooter.inc.php');?>
    