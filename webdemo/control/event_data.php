<?php include '../appcode/globals.inc.php';
include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');
AjaxFilePrevent();
$_SESSION['uploader']='PCAT8945';

?>
           
            <?php
            if(isset($_REQUEST['frmType']) && $_REQUEST['frmType']==2){
                $rs=simplefetch("SELECT * FROM web_events WHERE status='Active' AND event_id = ".$_REQUEST['event_id']."");
                if($rs[0]>0){
                    foreach($rs[1] as $row);                    
                }
            }
            ?>
            
            <form name="formNC" id="formNC" method="post" autocomplete="off" role="form" action="<?php echo "event_calender_action.php?per_id=$_SESSION[per_id]&amp;EncHid=$_SESSION[EncTok]";?>" enctype="multipart/form-data" >
                <input type="hidden" name="frmType" id="frmType" value="<?php echo $_REQUEST['frmType'];?>" />                        
                <input type="hidden" name="event_id" id="event_id" value="<?php echo $_REQUEST['event_id'];?>" />
                         
            <div class="modal-body">
                  <div class="box-body">
                    <div class="mb-3">
                      <label for="event_name" class="form-label">Event Name <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" name="event_name" id="event_name" placeholder="Program Name" value="<?= $row['event_name'] ?? '';?>" data-validate="event_name|text|y|1|500|alnum_spcA|Please enter Valid Name!"/>
                      <span id="prgnameerror"></span>
                    </div>
                    
                    <div class="mb-3">
                      <label for="strt_date" class="form-label">Start Date</label>
                        <div class="input-group col-md-8">
                        <input type="date" class="form-control" name="strt_date" id="strt_date" placeholder="DD/MM/YYYY" value="<?php echo date('Y-m-d', strtotime($row['event_start_date'] ?? '')); ?>" data-validate="strt_date|text|y|10|10|dt|Please select Valid Date!"/>
                        <span class="input-group-addon CopyIcon" data-for='strt_date'><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                    </div>  
                    
                    <div class="mb-3">
                      <label for="end_date" class="form-label">End Date</label>
                        <div class="input-group col-md-8">
                        <input type="date" class="form-control" name="end_date" id="end_date" placeholder="DD/MM/YYYY" value="<?php echo date('Y-m-d', strtotime($row['event_end_date'] ?? ''));?>" data-validate="end_date|text|y|10|10|dt|Please select Valid Date!"/>
                        <span class="input-group-addon CopyIcon" data-for='end_date'><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                    </div> 
                    
                    <div class="mb-3">
                        <label for="evnt_desc" class="form-label">Event Description</label>
                        <textarea class="form-control" name="evnt_desc" id="evnt_desc" placeholder="Meta Description of the Link" data-validate="evnt_desc|textarea|n|1|2000|alnum_spc|Please enter Valid data!"><?php echo html_entity_decode($row['event_desc'] ?? '');?></textarea>
                        <span id="descerror"></span>
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
                <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            </form>    
          

<script type="text/javascript">


// function frmAction(){
//     var formData = new FormData();
//     var other_data = $('#formNC').serializeArray();
//     $.each(other_data,function(key,input){
//         formData.append(input.name,input.value);
//     });
    
//     $.ajax({
//         type     : "POST",
//         dataType: "text",
//         cache    : false,        
//         enctype: 'multipart/form-data',
//         url      : $('#formNC').attr('action'),
//         data     : formData,//$('#formNC').serialize(),        
//         processData: false,
//         contentType: false,
        
//         beforeSend: function(){
//             $.fn.ajaxLoading();
//         },        
//         success  : function(data) {                                    
//             try{
//                 data=$.parseJSON($.base64.atob(data));            
//                 if(data[0]){                    
//                     ($('#frmType').val()==1)?$('#formNC')[0].reset():'';                    
//                     $('#ShowMsg').ShowMsg({msg:'Request Completed Successfully!',colwidth:'col-md-8',coloffset:'col-md-offset-2',alertClass:'alert-success'});
//                     $('#reloadGrid').trigger('click');                                        
//                 }
//                 else{                    
//                     if(data[1]!= undefined && data[1][0]==true){
//                         FEror=data[1][1];                    
//                         $.fn.ShowError(FEror);    
//                     }
//                     else if(data[2]!= undefined && data[2][0]==true){
//                         MEror=data[2][1];
//                         //console.log(MEror);
//                         $('#ShowMsg').ShowMsg({msg:MEror,alertClass:data[2][2],colwidth:'col-md-8',coloffset:'col-md-offset-2'});
//                     }
//                     else{                                          
//                         $('#ShowMsg').ShowMsg({msg:'Request not Completed Successfully!',colwidth:'col-md-8',coloffset:'col-md-offset-2',alertClass:'alert-danger'});                        
//                     }
//                 }
//             }
//             catch(err) {
//                 $('#ShowMsg').ShowMsg({msg:"<strong>Error:</strong> Unexpected Response received, You may try again!",colwidth:'col-md-8',coloffset:'col-md-offset-2',alertClass:'alert-warning'});                                
//             }
                                   
//         },
//         error:function(xhr, status, error){            
//             $('#PopWind').modal('toggle');
//             /*for(var x in xhr){
//                 console.log("Name:" + x + ">>>>" + xhr[x]);    
//             }*/                       
//             if(xhr.status==403){
//                // $.fn.custom_alert({msg:$(xhr.responseText).find("#custom_msg").html()});

//                 $('#ShowMsg1').ShowMsg({msg:$(xhr.responseText)});
//             }
//             else{
//                // $.fn.custom_alert({msg:'Something went wrong, Please try again!'});    
//                 $('#ShowMsg1').ShowMsg({msg:"<strong>Error:</strong> Something went wrong, Please try again!",alertClass:'alert-warning'});  
//             }
//         },
//         complete: function(){            
//             $.fn.ajaxLoading({show:false});
//         },
//     });
// }

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

                // $.fn.custom_alert({
                //     msg: $(xhr.responseText).find("#custom_msg").html()
                // });
                $('#ShowMsg').ShowMsg({msg:$(xhr.responseText),colwidth:'col-md-8',coloffset:'col-md-offset-2',alertClass:'alert-warning'});                                

            } 
            else {

                // $.fn.custom_alert({
                //     msg: 'Something went wrong. Please try again!'
                // });

                $('#ShowMsg').ShowMsg({msg:"<strong>Error:</strong> Something went wrong. Please try again!",colwidth:'col-md-8',coloffset:'col-md-offset-2',alertClass:'alert-warning'});                                

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

        // Event Name
        if($.trim($("#event_name").val()) == "")
        {
            $('#prgnameerror').ShowMsg({
                msg: 'Please enter Event Name!',
                colwidth: 'col-md-8',
                coloffset: 'col-md-offset-2',
                alertClass: 'alert-danger'
            });
            $('#event_name').focus();
            return false;
        }

        // Value Type
        if($.trim($("#strt_date").val()) == "")
        {
            $('#vltypeerror').ShowMsg({
                msg: 'Please enter Start Date!',
                colwidth: 'col-md-8',
                coloffset: 'col-md-offset-2',
                alertClass: 'alert-danger'
            });
            $('#strt_date').focus();
            return false;
        }

        // Value
        if($.trim($("#end_date").val()) == "")
        {
            $('#vlerror').ShowMsg({
                msg: 'Please enter End Date!',
                colwidth: 'col-md-8',
                coloffset: 'col-md-offset-2',
                alertClass: 'alert-danger'
            });
            $('#end_date').focus();
            return false;
        }

        // Value
        if($.trim($("#evnt_desc").val()) == "")
        {
            $('#descerror').ShowMsg({
                msg: 'Please enter End Date!',
                colwidth: 'col-md-8',
                coloffset: 'col-md-offset-2',
                alertClass: 'alert-danger'
            });
            $('#evnt_desc').focus();
            return false;
        }

        if(valid){
            frmAction(); // call your existing ajax function
        }

    });

}); 
</script>