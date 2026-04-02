<?php include '../appcode/globals.inc.php';
include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');
AjaxFilePrevent();
$_SESSION['uploader']='PCAT8945';
?>
           
           
            
            <?php
                if(isset($_REQUEST['frmType']) && $_REQUEST['frmType']==2)
                {
                    $prgid = $_REQUEST['t_cat_id'] ?? '';
                    $rs = simplefetch("select * from web_tender_category where status='Active' and t_cat_id = ".$prgid."");
                    if($rs[0]>0){
                        foreach($rs[1] as $row);                    
                    }
                }
            ?>
            
            <form name="formNC" id="formNC" method="post" autocomplete="off" role="form" action="<?php echo "tender_cat_action.php?per_id=$_SESSION[per_id]&amp;EncHid=$_SESSION[EncTok]";?>" enctype="multipart/form-data" >
            <input type="hidden" name="frmType" id="frmType" value="<?php echo $_REQUEST['frmType'];?>" />                        
            <input type="hidden" name="t_cat_id" id="t_cat_id" value="<?php echo $_REQUEST['t_cat_id'];?>" /> 

                  <div class="row">
                    <div class="col-12 mb-3">
                      <label for="c_name" class="form-label">Category Name <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" name="c_name" id="c_name" placeholder="Category Name" value="<?php echo $row['cat_name'] ?? '';?>" data-validate="c_name|text|y|1|500|alnum_spcA|Please enter Valid Category Name!" required/>
                    </div>

                    <div class="col-12 mb-3">
                      <label for="cat_name_h" class="form-label">Category Name (Hindi) <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" name="cat_name_h" id="cat_name_h" placeholder="Category Name in Hindi" value="<?= $row['cat_name_h'] ?? '';?>" data-validate="hc_name|text|n|1|5000|alnum_spcA|Please enter Valid Category Name!" required/>
                    </div> 
                    
                  </div>
                  <!-- /.box-body -->
                  <!--<div class="box-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>-->
                
                <div id="ShowMsg"></div>
            <div class="modal-footer in-modal-body">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            </form>    
          
<script type="text/javascript">

    function removeScriptTags(input) 
    {
        return input.replace(/<script[\s\S]*?>[\s\S]*?<\/script>/gi, '');
    }

    $('#c_name, #cat_name_h').on('input', function () 
    {
        let clean = removeScriptTags($(this).val());
        $(this).val(clean);
    });
/*$(function(){        
    function CallfrCk(){
        $('#formNC').formChecks({nonASCII:true,ajaxSubFunc:frmAction}).SetToFirstFocus();
    }
    CallfrCk();
})

$(document).ready(function () {

    // Bind form submit
    $('#formNC').on('submit', function (e) {
        e.preventDefault();   // stop normal form submit
        frmAction();
    });

});


function frmAction() {

    var form = $('#formNC')[0];
    var formData = new FormData(form);

    var fileInput = $('#l_file')[0];
    if (fileInput && fileInput.files.length > 0) {
        formData.set('l_file', fileInput.files[0]);
    }

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

    $('#PopWind').modal({
        backdrop: 'static',
        keyboard: false
    });

    setTimeout(function () {

        $('#PopWind')
            .find('input, textarea, select, button')
            .prop('disabled', false);

        $('#PopWind').modal('hide');

    }, 3000);
}
                
                
                else {

                    if (data[1] && data[1][0] === true) {

                        $.fn.ShowError(data[1][1]);

                    } else if (data[2] && data[2][0] === true) {

                        $('#ShowMsg').ShowMsg({
                            msg: data[2][1],
                            alertClass: data[2][2],
                            colwidth: 'col-md-8',
                            coloffset: 'col-md-offset-2'
                        });

                    } else {

                        $('#ShowMsg').ShowMsg({
                            msg: 'Request not Completed Successfully!',
                            colwidth: 'col-md-8',
                            coloffset: 'col-md-offset-2',
                            alertClass: 'alert-danger'
                        });
                    }
                }

            } catch (err) {

                console.error("Parsing Error:", err);

                $('#ShowMsg').ShowMsg({
                    msg: "<strong>Error:</strong> Unexpected response received. Please try again!",
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

            } else {

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
*/

// $('#formNC').on('submit', function (e) {
//     e.preventDefault();   
//     frmAction();
// });


// $('#formNC').on('submit', function (e) {

//     e.preventDefault();

//     if (isValid === true || isValid === undefined) {
//         frmAction();   // submit only if valid
//     }

// });


// function frmAction() {

//     var cname = $('#c_name').val().trim();

//     if (cname === '') {
//         $('#ShowMsg').ShowMsg({
//             msg: 'Category Name is required!',
//             colwidth: 'col-md-8',
//             coloffset: 'col-md-offset-2',
//             alertClass: 'alert-danger'
//         });
//         $('#c_name').focus();
//         return false;
//     }

//     var form = $('#formNC')[0];
//     var formData = new FormData(form);
// };

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

    var cname = $('#c_name').val().trim();

    if (cname === '') {
        $('#ShowMsg').ShowMsg({
            msg: 'Category Name is required!',
            colwidth: 'col-md-8',
            coloffset: 'col-md-offset-2',
            alertClass: 'alert-danger'
        });
        $('#c_name').focus();
        return false;
    }

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