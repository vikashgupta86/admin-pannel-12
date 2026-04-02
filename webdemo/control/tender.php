<?php include '../appcode/globals.inc.php';
include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');
AjaxFilePrevent();
$_SESSION['uploader']='T45218';
$_SESSION['rtfUpload']='RTFT4581';
$_SESSION['rtfTender']='RTFTender';
?>
<h6 class="modal-title">Add/ Modify Tender Details</h6>
            
            <?php
            if(isset($_REQUEST['frmType']) && $_REQUEST['frmType']==2){
                $rs = simplefetch("select *,date_format(pub_date,'%Y-%m-%d')as pub_date,date_format(close_date,'%Y-%m-%d')as close_date,date_format(open_date,'%Y-%m-%d')as open_date from web_tender_temp where status='Active' and t_temp_id=".$_REQUEST['t_temp_id']."");
                if($rs[0]>0){
                    foreach($rs[1] as $row);                    
                }
            }
            ?>
            
            <form name="formNC" id="formNC" method="post" autocomplete="off" role="form" action="<?php echo "tender_action.php?per_id=$_SESSION[per_id]&amp;EncHid=$_SESSION[EncTok]";?>" enctype="multipart/form-data" >
            <input type="hidden" name="frmType" id="frmType" value="<?php echo $_REQUEST['frmType'];?>" />
            <input type="hidden" name="t_cat_id" id="t_cat_id" value="<?php echo $_REQUEST['t_cat_id'] ?? '';?>" />            
            <input type="hidden" name="t_temp_id" id="t_temp_id" value="<?php echo $_REQUEST['t_temp_id'] ?? '';?>" />
            <input type="hidden" name="t_id" id="t_id" value="<?php echo $_REQUEST['t_id'] ?? 0;?>" />            
            <div class="modal-body">
                  <div class="box-body">
                    <div class="form-group">

                    <div class="form-group">
                      <label for="l_name">Tender Name <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" name="l_name" id="l_name" placeholder="Tender Name" value="<?php echo $row['tender_name'] ?? '';?>" data-validate="l_name|text|y|1|500|alnum_spc|Please enter Valid Link Name!" required/>
                    </div>
                    
                    <div class="form-group">
                      <label for="l_title">Title <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" name="l_title" id="l_title" placeholder="Title" value="<?php echo $row['title'] ?? '';?>" data-validate="l_title|text|y|1|500|alnum_spc|Please enter Valid Link Title!" required/>
                    </div>
                        
                    <div class="form-group">
                      <label for="t_num">Tender Number <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" name="t_num" id="t_num" placeholder="Tender Number" value="<?php echo $row['t_num'] ?? '';?>" data-validate="t_num|text|y|1|500|alnum_spc|Please enter Valid Link Title!" required/>
                    </div>
                        
                    <div class="form-group">
                      <label for="l_bdesc">Brief Description: <span class="text-danger">*</span></label>
                      <textarea class="form-control" name="l_bdesc" id="l_bdesc" placeholder="Brief Description of the Link" data-validate="l_bdesc|textarea|n|1|2000|alnum_spc|Please enter Valid data!" required><?php echo $row['link_bdesc'] ?? '';?></textarea>
                    </div>
                    
                    <div class="form-group">
                      <label for="l_key">Keywords:</label>
                      <textarea class="form-control" name="l_key" id="l_key" placeholder="Keywords of the Link" data-validate="l_key|textarea|n|1|2000|alnum_spc|Please enter Valid data!" ><?php echo $row['keywords'] ?? '';?></textarea>
                    </div>
                    
                    <div class="form-group">
                      <label for="l_src">Source:</label>
                      <textarea class="form-control" name="l_src" id="l_src" placeholder="Source of the Link" data-validate="l_src|textarea|n|1|2000|alnum_spc|Please enter Valid Source!"><?php echo $row['source'] ?? '';?></textarea>
                    </div>
                    
                    <div class="form-group">
                      <label for="l_mdesc">Meta Description:</label>
                      <textarea class="form-control" name="l_mdesc" id="l_mdesc" placeholder="Meta Description of the Link" data-validate="l_mdesc|textarea|n|1|2000|alnum_spc|Please enter Valid data!"><?php echo $row['meta_tag'] ?? '';?></textarea>
                    </div>
                    
                    <div class="row">
                        <div class="form-group col-md-6">
                          <label for="link_pubDate">Publish Date: <span class="text-danger">*</span></label>
                          <div class="input-group">
                            <input type="date" class="form-control" name="link_pubDate" id="link_pubDate" placeholder="DD/MM/YYYY" value="<?php echo $row['pub_date'] ?? '';?>" data-validate="link_pubDate|text|n|10|10|dt|Please enter/ select Valid Date!" required/>
                            <span class="input-group-addon CopyIcon" data-for='link_pubDate'><span class="glyphicon glyphicon-calendar"></span></span>
                          </div>
                        </div>                        
                        
                        <div class="form-group col-md-6">
                            <label for="ptime">Publish Time: <span class="text-danger">*</span></label>
                            <div class='input-group date ptime'>
                                <input type='time' name="ptime" id="ptime" class="form-control ptime" value="<?php echo $row['pub_time'] ?? '';?>" data-validate="ptime|text|n|5|5|ti|Please enter/ select Valid Time!" required/>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="form-group col-md-6">
                          <label for="t_cloDate">Bid-submission/ Closing Date: <span class="text-danger">*</span></label>
                          <div class="input-group">
                            <input type="date" class="form-control" name="t_cloDate" id="t_cloDate" placeholder="DD/MM/YYYY" value="<?php echo $row['close_date'] ?? '';?>" data-validate="t_cloDate|text|n|10|10|dt|Please enter/ select Valid Date!" required/>
                            <span class="input-group-addon CopyIcon" data-for='t_cloDate'><span class="glyphicon glyphicon-calendar"></span></span>
                          </div>
                        </div>                        
                        
                        <div class="form-group col-md-6">
                            <label for="ctime">Bid-submission/ Closing Time: <span class="text-danger">*</span></label>
                            <div class='input-group date ctime'>
                                <input type='time' name="ctime" id="ctime" value="<?php echo $row['close_time'] ?? '';?>" class="form-control ctime" data-validate="ctime|text|n|5|5|ti|Please enter/ select Valid Time!" required/>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="form-group col-md-6">
                          <label for="t_openDate">Tender Opening Date: <span class="text-danger">*</span></label>
                          <div class="input-group">
                            <input type="date" class="form-control" name="t_openDate" id="t_openDate" placeholder="DD/MM/YYYY" value="<?php echo $row['open_date'] ?? '';?>" data-validate="t_openDate|text|n|10|10|dt|Please enter/ select Valid Date!" required/>
                            <span class="input-group-addon CopyIcon" data-for='t_openDate'><span class="glyphicon glyphicon-calendar"></span></span>
                          </div>
                        </div>                        
                        
                        <div class="form-group col-md-6">
                            <label for="otime">Tender Opening Time: <span class="text-danger">*</span></label>
                            <div class='input-group date otime'>
                                <input type='time' name="otime" id="otime" value="<?php echo $row['open_time'] ?? '';?>" class="form-control otime" data-validate="otime|text|n|5|5|ti|Please enter/ select Valid Time!" required/>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                      <label for="l_file">Choose File </label>
                      <?php $Mand=(empty($row['file_name']))?'y':'n';?>
                      
                      <input type="file" name="l_file" id="l_file" data-validate="l_file|file|<?php echo $Mand;?>|1|30000|file_extn=pdf|Please Select file,Filename should not contain any special character and white space. Invalid Filename! Allowed extenstions are pdf!" accept="application/pdf"/>
                      <?php
                      if(!empty($row['file_name'])){                              
                      ?>
                      <a href="#"><i class="fa fa-file-pdf-o text-red" data-fname='<?php echo base64_encode($row['file_name'] ?? '');?>' title="View File"></i></a>
                      <?php
                      }
                      ?>
                      <p class="help-block">Allowed file extenstion is 'pdf'. File size should be less then 20 MB.</p> 
                    </div>                        
                
                    <div class="form-group">
                      <label for="textarea2">Rich Text Formater: </label>
                      <textarea class="form-control" name="textarea2" id="textarea2" placeholder="Keywords of the Link" data-validate="textarea2|textarea|y|1|50000|rtf|Please enter Valid data!"><?php rtfPathManage($row['details'],false);echo $row['details'] ?? '';?></textarea>
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

    function removeScriptTags(input) 
    {
        return input.replace(/<script[\s\S]*?>[\s\S]*?<\/script>/gi, '');
    }

    $('#l_name, #l_title, #l_bdesc, #t_num, #l_key, #l_src, #l_mdesc, #textarea2').on('input', function () 
    {
        let clean = removeScriptTags($(this).val());
        $(this).val(clean);
    });

    
$(function(){
    $('#l_name').keyup(function(){        
        $('#l_title').val($(this).val());
    });
    $(".modal-dialog").css("width", "800px");
    showRTF();
        
    // function CallfrCk(){
    //     $('#formNC').formChecks({nonASCII:true,ajaxSubFunc:frmAction}).SetToFirstFocus();
    // }
    // CallfrCk();
    
    // $('#link_pubDate,#t_cloDate,#t_openDate').datepicker({
    //         autoclose:true,
    //         todayHighlight:true,            
    //         format:'dd/mm/yyyy',
            
    //     }        
    // );
    
    // $('.ptime, .ctime,.otime').datetimepicker({
    //     //format: 'LT'        
    //     format: 'HH:mm'        
    // });
});

/*
function frmAction(){
    $.base64.utf8encode = true;
    
    var formData = new FormData();
    //formData.append('name', $('#formNC').serialize());
    formData.append('l_file', $('#l_file')[0].files[0]);
    
    var other_data = $('#formNC').serializeArray();
    $.each(other_data,function(key,input){
        //managing the RTF content start    
        let DomStr = input.value.match(/<body[^>]*>[\s\S]*<\/body>/gi);
        DomStr = DomStr==null?input.value:$('<div />').text(DomStr).html();     
        //RTF END
        formData.append(input.name, DomStr);
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
            $('#PopWind').modal('toggle');
            $.fn.custom_alert({msg:'Something went wrong, Please try again!'});                        
        },
        complete: function(){            
            $.fn.ajaxLoading({show:false});
        },
    });
}
*/


$('#l_name').on('keyup', function() {
    var update_l_title = $(this).val();
    $('#l_title').val(update_l_title);
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