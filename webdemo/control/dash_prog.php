<?php 
    include '../appcode/globals.inc.php';
    include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');
    AjaxFilePrevent();
    $_SESSION['uploader']='PCAT8945';
?>
           
            <?php
            if(isset($_REQUEST['frmType']) && $_REQUEST['frmType']==2){
                $rs=simplefetch("SELECT * FROM web_dash_prog_data WHERE status='Active' AND prog_data_id = ".$_REQUEST['prog_data_id']."");
                if($rs[0]>0){
                    foreach($rs[1] as $row);                    
                }
            }
            ?>
            
                <form name="formNC" id="formNC" method="post" autocomplete="off" role="form" action="<?php echo "dash_prog_action.php?per_id=$_SESSION[per_id]&amp;EncHid=$_SESSION[EncTok]";?>" enctype="multipart/form-data" >
                <input type="hidden" name="frmType" id="frmType" value="<?php echo $_REQUEST['frmType'];?>" />                        
                <input type="hidden" name="prog_data_id" id="prog_data_id" value="<?php echo $_REQUEST['prog_data_id'];?>" />

                    <div class="mb-3">
					    <label for="year_id" class="form-label">Year <span class="text-danger">*</span></label>
                        <select name="year_id" id="year_id" class="form-control" data-validate="year_id|text|y|1|10|num|dontselect=-1|Please enter Valid option!" required>
                            <option value="">--- Select ---</option>

                            <?php
                            $rs1=fetchtable("years","status='Active'",1);
                            if($rs1[0]>0){
                                foreach($rs1[1] as $row1){
                                    if(($row['year_id'] ?? '')==$row1['year_id'])
                                        echo "<option value='$row1[year_id]' selected=''>$row1[years]</option>";
                                    else
                                        echo "<option value='$row1[year_id]'>$row1[years]</option>";
                                }
                            }
                            ?>
                        </select>
                        <span id="prgcaterror"></span>
                    </div>
                        
                    <div class="mb-3">
					    <label for="dash_cat_id" class="form-label">Dashboard Category <span class="text-danger">*</span></label>
                        <select name="dash_cat_id" id="dash_cat_id" class="form-control" data-validate="dash_cat_id|text|y|1|10|num|dontselect=-1|Please enter Valid option!" required>
                            <option value="">--- Select ---</option>

                            <?php
                            $rs1=fetchtable("web_dash_prog","status='Active'",1);
                            if($rs1[0]>0){
                                foreach($rs1[1] as $row1){
                                    if(($row['prog_id'] ?? '')==$row1['prog_id'])
                                        echo "<option value='$row1[prog_id]' selected=''>$row1[prog_name]</option>";
                                    else
                                        echo "<option value='$row1[prog_id]'>$row1[prog_name]</option>";
                                }
                            }
                            ?>
                        </select>
                        <span id="prgcaterror"></span>
                    </div>

                    <?php /*
                    <div class="mb-3">
					    <label for="dash_sb_link_id" class="form-label">Sub Links <span class="text-danger">*</span></label>
                        <select name="dash_sb_link_id" id="dash_sb_link_id" class="form-control" data-validate="dash_sb_link_id|text|y|1|10|num|dontselect=-1|Please enter Valid option!" required>
                            <option value="">--- Select ---</option>
                            <?php
                                $sql = "SELECT lt.link_temp_id,lt.link_name FROM web_links_structure ls INNER JOIN web_links_final lf ON ls.lid = lf.lid INNER JOIN web_link_temp lt ON lt.link_temp_id = lf.link_temp_id where ls.parent_ls_id = 60 and ls.status = 'Active' ORDER BY lt.link_name ASC";
                                $stmt = $conn->prepare($sql);
                                $stmt->execute();
                                $allprgData = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
                                $stmt->close();
                                foreach($allprgData as $row1)
                                {
                                    if(($row['dash_sb_link_id'] ?? '')==$row1['link_temp_id'])
                                        echo "<option value='$row1[link_temp_id]' selected=''>$row1[link_name]</option>";
                                    else
                                        echo "<option value='$row1[link_temp_id]'>$row1[link_name]</option>";
                                }
                            
                            ?>
                        </select>
                        <span id="prgcaterror"></span>
                    </div>
                    <?php */ ?>

                    <div  class="mb-3">
                      <label for="prog_name" class="form-label">Program Name <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" name="prog_name" id="c_name" placeholder="Program Name" value="<?= $row['attribute_name'] ?? '';?>" data-validate="prog_name|text|y|1|500|alnum_spcA|Please enter Valid Program Name!" required />
                      <span id="prgnameerror"></span>
                    </div>
                    
                    <div  class="mb-3">
                      <label for="prog_name_h" class="form-label">Program Name (Hindi)</label>
                      <input type="text" class="form-control" name="prog_name_h" id="prog_name_h" placeholder="Program Name in Hindi" value="<?= $row['attribute_name_hin'] ?? '';?>" data-validate="prog_name_h|text|n|1|5000|alnum_spcA|Please enter Valid Program Name!"/>
                    </div> 
                    
                    <div  class="mb-3">
                      <label for="value_type" class="form-label">Value Type <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" name="value_type" id="value_type" placeholder="Value Type" value="<?= $row['value_type'] ?? '';?>" data-validate="value_type|text|y|1|500|alnum_spcA|Please enter Valid Value Type!" required/>
                      <span id="vltypeerror"></span>
                    </div>
                    
                    <div  class="mb-3">
                      <label for="value_type_h" class="form-label">Value Type (Hindi)</label>
                      <input type="text" class="form-control" name="value_type_h" id="value_type_h" placeholder="Value Type in Hindi" value="<?= $row['value_type_hin'] ?? '';?>" data-validate="value_type_h|text|n|1|5000|alnum_spcA|Please enter Valid Value Type!"/>
                      <span id="vlerror"></span>
                    </div> 

                    <div  class="mb-3">
                      <label for="value_num" class="form-label">Value <span class="text-danger">*</span></label>
                      <input type="number" step="0.01" class="form-control" name="value_num" id="value_num" placeholder="Value" value="<?= $row['value'] ?? '';?>" data-validate="value_num|text|y|1|500|alnum_spcA|Please enter Valid Value!" placeholder="0.00" required/>
                    </div>
                    
                  </div>
                
                <div id="ShowMsg"></div>
            </div>
            <div class="modal-footer in-modal-body">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            </form>    
          

<script type="text/javascript">

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

<script>
$(document).ready(function(){

    $("#formNC").on("submit", function(e){

        e.preventDefault(); // stop default submit

        var valid = true;

        // Dashboard Category validation
        if($("#dash_cat_id").val() == "-1"){
            $('#prgcaterror').ShowMsg({
                msg: 'Please select Dashboard Category!',
                colwidth: 'col-md-8',
                coloffset: 'col-md-offset-2',
                alertClass: 'alert-danger'
            });
            $('#dash_cat_id').focus();
            return false;
            
        }

        // Program Name
        if($.trim($("#c_name").val()) == "")
        {
            $('#prgnameerror').ShowMsg({
                msg: 'Please enter Program Name!',
                colwidth: 'col-md-8',
                coloffset: 'col-md-offset-2',
                alertClass: 'alert-danger'
            });
            $('#c_name').focus();
            return false;
        }

        // Value Type
        if($.trim($("#value_type").val()) == "")
        {
            $('#vltypeerror').ShowMsg({
                msg: 'Please enter Value Type!',
                colwidth: 'col-md-8',
                coloffset: 'col-md-offset-2',
                alertClass: 'alert-danger'
            });
            $('#value_type').focus();
            return false;
        }

        // Value
        if($.trim($("#value_num").val()) == "")
        {
            $('#vlerror').ShowMsg({
                msg: 'Please enter Value!',
                colwidth: 'col-md-8',
                coloffset: 'col-md-offset-2',
                alertClass: 'alert-danger'
            });
            $('#value_num').focus();
            return false;
        }

        // if(valid){
        //     frmAction(); 
        // }

    });

});
</script>