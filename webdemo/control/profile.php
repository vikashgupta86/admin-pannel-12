<?php include '../appcode/globals.inc.php';
include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');
AjaxFilePrevent();
$_SESSION['uploader'] = 'PF45214';
?>

  <?php
  if (isset($_REQUEST['frmType']) && $_REQUEST['frmType'] == 1) {
   $rs = simplefetch("select wup.*,date_format(wup.dob,'%Y-%m-%d')as dob,s.state_name from web_users_profile wup RIGHT JOIN web_users wu on wu.user_id=wup.user_id
    LEFT JOIN web_st_states s on s.state_id=wup.state_id LEFT JOIN web_st_districts d on d.district_id=wup.district_id WHERE wu.status='Active' and wu.current_status='Active' and wu.user_id = ".$_SESSION['userid']."");
   if ($rs[0] <= 0) {
    //$obj->show_msg("Error comes, Please try again!",'info',true);
    echo "<script <?= $nonce; ?> >$(function(){\$.fn.custom_alert({msg:'Error comes, Please try again!',title:'Information'});\$('#PopWind').hide();})</script>";
    exit();
  } else {
    foreach ($rs[1] as $row);
    ?>

    <h4 class="modal-title">Manage Profile</h4>
   
        
        <form name="formNC" id="formNC" method="post" autocomplete="off" role="form" action="<?php echo "profile_action.php?per_id=$_SESSION[per_id]&amp;EncHid=$_SESSION[EncTok]"; ?>" enctype="multipart/form-data" >
          <input type="hidden" name="frmType" id="frmType" value="<?php echo $_REQUEST['frmType']; ?>" />
          <div class="modal-body">
            <div class="box-body">
              <div class="row">
                <div class="form-group col-md-2">
                  <label for="title_id">Title</label>
                  <select name="title_id" id="title_id" class="form-control" data-validate="title_id|text|n|1|10|num|dontselect=-1|Please enter Valid option!">
                    <option value="-1">N/A</option>
                    <?php
                    $rs1 = fetchtable("web_st_title", "status='Active' and title_id!=8 order by pos");
                    if ($rs1[0] > 0) {
                     foreach ($rs1[1] as $row1) {
                      if ($row['title_id'] == $row1['title_id']) {
                       echo "<option value='$row1[title_id]' selected=''>$row1[title_name]</option>";
                     } else {
                       echo "<option value='$row1[title_id]'>$row1[title_name]</option>";
                     }

                   }
                 }
                 ?>
               </select>
             </div>

             <div class="form-group col-md-3">
              <label for="f_name">First Name:</label>
              <input type="text" class="form-control" name="f_name" id="f_name" placeholder="First Name" value="<?php echo ($row['f_name']); ?>" data-validate="f_name|text|y|1|500|alnum_spc|Please enter Valid Name!"/>
            </div>

            <div class="form-group col-md-3">
              <label for="m_name">Middle Name:</label>
              <input type="text" class="form-control" name="m_name" id="m_name" placeholder="Middle Name" value="<?php echo ($row['m_name']); ?>" data-validate="m_name|text|n|1|500|alnum_spc|Please enter Valid Name!"/>
            </div>

            <div class="form-group col-md-3">
              <label for="l_name">Last Name:</label>
              <input type="text" class="form-control" name="l_name" id="l_name" placeholder="Last Name" value="<?php echo ($row['l_name']); ?>" data-validate="l_name|text|y|1|500|alnum_spc|Please enter Valid Name!"/>
            </div>
          </div>

          <div class="row">
            <div class="form-group col-md-6">
              <ul class="list-inline">
                <li><label for="u_gen">Gender</label></li>
                <li class="checkbox">
                  <input type="radio" name="u_gen" id="u_gen1" value="1" <?php echo isset($row['gender']) && $row['gender'] == 1 ? 'checked=""' : ''; ?> /> Male
                  <input type="radio" name="u_gen" id="u_gen2" value="2" <?php echo (isset($row['gender']) && $row['gender'] == 2) ? 'checked=""' : ''; ?> /> Female
                  <input type="radio" name="u_gen" id="u_gen3" value="3" <?php echo (isset($row['gender']) && $row['gender'] == 3) ? 'checked=""' : ''; ?> data-validate="l_feed|checkbox|y|1|2|selmin=1|Please Select atleast One option!"/> Transgender
                </li>
              </ul>
            </div>
          </div>

          <div class="row">
            <div class="form-group col-md-3">
              <label for="dob">Date of Birth:</label>
              <div class="input-group">
                <input type="text" class="form-control" name="dob" id="dob" placeholder="DD/MM/YYYY" value="<?php echo $row['dob']; ?>" data-validate="dob|text|y|10|10|dt|Please enter/ select Valid Date!"/>
                <span class="input-group-addon CopyIcon" data-for='dob'><span class="glyphicon glyphicon-calendar"></span></span>
              </div>
            </div>

            <div class="form-group col-md-9">
              <div class="form-group col-md-6">
                <label for="l_file">Choose Profile:</label>
                <input type="file" name="l_file" id="l_file" data-validate="l_file|file|n|1|5000|file_extn=jpg;png;jpeg;|Please Select file, Allowed extenstions are jpg, jpeg, png!"/>
                <p class="help-block">Image size should be less then 2 MB.</p>
                <!-- <div>
                  <img id="blah" src="javascript:void(0)" alt="your image" width="50" height="50" class="img-circle img-responsive" />
                </div> -->
              </div>

              <?php
              if (!empty($row['profile_img'])) {
               ?>

               <div class="form-group col-md-6">
                <label for="l_file">Existing Profile: </label>
                <img src="<?php echo "../WriteReadData/$_SESSION[uploader]/$row[profile_img]"; ?>" class="img-thumbnail" alt="Link Icon" width="100"/>
              </div>
              <?php
            }
            ?>


          </div>
        </div>
        <span id="charerror" style="margin-left: 36%;"></span>
        <?php
          $ContactFlage = true;
          $emailFlage = false;
          $ParamArryN['prefix'] = '';
          $ParamArryN['Mand'] = array('Addr' => 'y', 'City' => 'y', 'Dist' => 'y', 'Plac' => 'n', 'Pin' => 'n');
          $ParamModN = array($ParamArryN['prefix'] . 'Addr' => "$row[addr]", $ParamArryN['prefix'] . 'City' => "$row[state_id]", $ParamArryN['prefix'] . 'Dist' => "$row[district_id]", $ParamArryN['prefix'] . 'Pin' => "$row[pincode]", $ParamArryN['prefix'] . 'c_Land' => "$row[std_code]", $ParamArryN['prefix'] . 'Land' => "$row[landline]", $ParamArryN['prefix'] . 'mob' => "$row[mobile]", $ParamArryN['prefix'] . 'c_Fax' => "$row[f_std_code]", $ParamArryN['prefix'] . 'Fax' => "$row[f_landline]",$ParamArryN['prefix'].'Demail'=>"$row[email_id]");
          include 'include/Com_addr.inc.php';
        ?>
        

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
                  <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Update</button>
                </div>
              </form>
              <div class="clearfix"></div>
            </div>
          </div>
          <?php
        }
      }
      ?>
   
    <script <?= $nonce; ?>  type="text/javascript">
      $(function(){
        $(".modal-dialog").css("width", "800px");
        $('.input-group-addon').click(function(){
          if($(this).data('for')!=undefined){
            $('#'+$(this).data('for')).trigger('focus');
          }
        })

        // $('#dob').datepicker({
        //   autoclose:true,
        //   todayHighlight:true,
        //   format:'dd/mm/yyyy', 
        //   endDate: '-20Y',
        // }
        // );

        // function CallfrCk(){
        //   $('#formNC').formChecks({nonASCII:true,ajaxSubFunc:frmAction}).SetToFirstFocus();
        // }
        // CallfrCk();

        $("#l_file").change(function(){
          readURL(this);
        });
        $('#blah').hide();
      })

      function readURL(input) {

        if (input.files && input.files[0]) {
          var reader = new FileReader();

          reader.onload = function (e) {
            $('#blah').attr('src', e.target.result).show();
          }

          reader.readAsDataURL(input.files[0]);
        }
      }



/*
      function frmAction()
      {
        $.base64.utf8encode = true;

        var formData = new FormData();
        formData.append('l_file', $('#l_file')[0].files[0]);

        var other_data = $('#formNC').serializeArray();
        $.each(other_data,function(key,input){
          formData.append(input.name,input.value);
        });

        var addrs = $('#address').val();

        if(/^[a-zA-Z.,\-_b]+$/.test(addrs) == false)
        {
            $('#charerror').css('color', 'red');
            $('#charerror').text('Special Characters not allowed');
            $('#charerror').show();
            return false;
        }
        else
        {
            $('#charerror').hide();
        }

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
                    //window.location.reload();
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
*/


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
    if (typeof tinymce !== 'undefined') {
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

    </script>