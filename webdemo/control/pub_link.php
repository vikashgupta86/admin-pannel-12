<?php 
    include '../appcode/globals.inc.php';
    include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');
    AjaxFilePrevent();
    $shoCols = '';
    $SubQry = '';
    $Join = '';
    $get_lid = filter_input(INPUT_GET, 'lid', FILTER_VALIDATE_INT);
    
    if(isset($_REQUEST['frmType']) && in_array($_REQUEST['frmType'],array(1,9))) {
        $link_temp_id = filter_var($_REQUEST['link_temp_id'], FILTER_VALIDATE_INT);

        if($_REQUEST['frmType']==9) {
            $shoCols=",date_format(lf.publish_date,'%d/%m/%Y')as publish_date,lf.publish_time as publish_time,lf.expiry_time as expiry_time, date_format(lf.expiry_date,'%d/%m/%Y')as expiry_date,date_format(lf.next_review_date,'%d/%m/%Y') as next_review_date, lf.show_content,lf.feedback_required";
            $Join="INNER JOIN web_links_final lf on lf.link_temp_id=lt.link_temp_id";
            $SubQry=" and lf.lid=$get_lid";
        }
        $rs=simplefetch("select lt.continuous_content,lt.type_id, t.type,l.lang,case when lt.continuous_content=1 then lt2.link_name else lt.link_name end as link_name,concat(u.user_name, '( ',date_format(lt.creation_date,'%d/%m/%Y'),' )')as linkCdate$shoCols from web_link_temp lt 
            INNER JOIN web_users u on u.user_id=lt.creator_id
            INNER JOIN web_users au on au.user_id=lt.app_rej_user_id  
            INNER JOIN web_link_type t on t.type_id=lt.type_id 
            INNER JOIN web_lang l on l.lang_id=lt.lang_id
            $Join
            LEFT JOIN web_link_temp lt2 on lt.main_link_temp_Id=lt2.link_temp_id     
            where lt.status='Active' and lt.app_reject=1 and lt.link_temp_id=$link_temp_id $SubQry");
        if($rs[0]<=0){
            //show_msg("Error comes, Please try again!",'info',true);
            echo "<script>$(function(){\$.fn.custom_alert({msg:'Error comes, Please try again!',title:'Information'});\$('#PopWind').hide();})</script>"; 
            exit();                                       
        } else {
            foreach($rs[1] as $row);
            ?>
            <form name="formNC" id="formNC" method="post" autocomplete="off" role="form" action="<?php echo "pub_link_action.php?per_id=$_SESSION[per_id]&amp;EncHid=$_SESSION[EncTok]";?>" enctype="multipart/form-data" >
                <input type="hidden" name="frmType" id="frmType" value="<?php echo $_REQUEST['frmType'];?>" />
                <input type="hidden" name="lang_id" id="lang_id" value="<?php echo $_REQUEST['lang_id'];?>" />
                <input type="hidden" name="link_temp_id" id="link_temp_id" value="<?php echo $_REQUEST['link_temp_id'];?>" />
                <input type="hidden" name="lid" id="lid" value="<?php echo ($_REQUEST['lid'] ?? '');?>" />
                        
                  <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="l_name" class="form-label">Link Type:</label>
                        <input type="text" class="form-control" value="<?php echo $row['type'];?>" disabled />
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="l_alias" class="form-label">Language:</label>
                        <input type="text" class="form-control" value="<?php echo $row['lang'];?>" disabled />
                    </div>
                    
                    <div class="col-12 mb-3">
                        <label for="l_name" class="form-label">Link Name:</label>
                        <input type="text" class="form-control" value="<?php echo html_entity_decode($row['link_name']);?>" disabled />
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="l_alias" class="form-label">Created by/ On:</label>
                        <input type="text" class="form-control" value="<?php echo $row['linkCdate'];?>" disabled />
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="l_alias" class="form-label">Approved by/ On:</label>
                        <input type="text" class="form-control" value="<?php echo $row['linkCdate'];?>" disabled />
                    </div>
                                        
                    <div class="col-md-6 mb-3">
                        <label for="link_pubDate" class="form-label">Publish Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="link_pubDate" id="link_pubDate" value="<?php echo isset($row['publish_date']) ? date('Y-m-d', strtotime($row['publish_date'])) : date('Y-m-d'); ?>" data-validate="link_pubDate|text|y|10|10|dt|Please enter/ select Valid Date!" required/>
                        <span class="input-group-addon CopyIcon" data-for='link_pubDate'><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>

                    <div class="col-md-6 mb-3">
                      <label for="ptime" class="form-label">Publish Time:</label>
                      <div class="input-group">
                                <input type='time' name="ptime" id="ptime" class="form-control ptime" value="<?php echo $row['publish_time'] ?? '';?>" data-validate="ptime|text|n|5|5|ti|Please enter/ select Valid Time!" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-time"></span>
                        </span>
                      </div>
                    </div>
                    
                    
                    
                    <?php
                    if($row['continuous_content']!=1){
                    ?>
                    <div class="form-group col-md-6 mb-3">
                      <label for="link_expDate" class="form-label">Expired Date:</label>
                      <div class="input-group">
                        <input type="date" class="form-control" name="link_expDate" id="link_expDate" placeholder="DD/MM/YYYY" value="<?php echo isset($row['expiry_date'])?$row['expiry_date']:'';?>" data-validate="link_expDate|text|n|10|10|dt|Please enter/ select Valid Date!"/>
                        <span class="input-group-addon CopyIcon" data-for='link_expDate'><span class="glyphicon glyphicon-calendar"></span></span>
                      </div>                      
                    </div>
                    <div class="form-group col-md-6 mb-3">
                      <label for="ctime" class="form-label">Expired Time:</label>
                      <div class="input-group">
                                <input type='time' name="ctime" id="ctime" value="<?php echo $row['expiry_time'] ?? '';?>" class="form-control ctime" data-validate="ctime|text|n|5|5|ti|Please enter/ select Valid Time!"  />
                        <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                      </div>                      
                    </div>
                    
                    
                    
                    
                    <div class=" clearfix"></div>
                    
                    <div class="form-group col-md-6 mb-3">
                      <label for="link_nrevDate" class="form-label">Next Review Date</label>
                      <div class="input-group">
                        <input type="date" class="form-control" name="link_nrevDate" id="link_nrevDate" placeholder="DD/MM/YYYY" value="<?php echo isset($row['next_review_date'])?$row['next_review_date']:'';?>" data-validate="link_nrevDate|text|n|10|10|dt|Please enter/ select Valid Date!"/>
                        <span class="input-group-addon CopyIcon" data-for='link_nrevDate'><span class="glyphicon glyphicon-calendar"></span></span>
                      </div>
                    </div>
                    
                    
                    <div class=" clearfix"></div>
                    <?php                    
                        if($row['type_id']==3){
                        ?>                        
    
                        <div class="form-group col-md-6 mb-3">
                            <ul class="list-inline">
                                <li><label for="l_show" class="form-label">Show Content <span class="text-danger">*</span></label></li>
                                <li class="checkbox">
                                    <input type="radio" name="l_show" id="l_show1" value="1" <?= (($row['show_content'] ?? null) == 1) ? 'checked' : 'checked'; ?> /> Yes
                                    <input type="radio" name="l_show" id="l_show1" value="2" <?= (($row['show_content'] ?? null) == 2) ? 'checked' : ''; ?> data-validate="l_show|checkbox|y|1|2|selmin=1|Please Select atleast One option!"/> No
                                </li>
                            </ul>
                        </div>
                        
                        <div class="form-group col-md-6 mb-3">
                            <ul class="list-inline">
                                <li><label for="l_feed" class="form-label">Feedback Required <span class="text-danger">*</span></label></li>
                                <li class="checkbox">
                                    <input type="radio" name="l_feed" id="l_feed1" value="1" <?= (($row['feedback_required'] ?? null) == 1) ? 'checked' : ''; ?> /> Yes
                                    <input type="radio" name="l_feed" id="l_feed2" value="2" <?= (($row['feedback_required'] ?? null) == 2) ? 'checked' : 'checked'; ?> data-validate="l_feed|checkbox|y|1|2|selmin=1|Please Select atleast One option!"/> No
                                </li>
                            </ul>
                        </div>
                        <?php
                        }
                    }
                    ?>
                            
                  </div>
                  <!-- /.box-body -->
                  <!--<div class="box-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>-->
                
                <div id="ShowMsg"></div>
            </div>
            <div class="modal-footer in-modal-body">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            </form>    

    <?php
        }    
    }        
    ?>
</div>
<script type="text/javascript">
$(function(){
    $('.input-group-addon').click(function(){
        if($(this).data('for')!=undefined){            
            $('#'+$(this).data('for')).trigger('focus');
        }
    })
    $('#link_pubDate,#link_nrevDate').datepicker({
            autoclose:true,
            todayHighlight:true,            
            format:'dd/mm/yyyy',
            startDate: '0',
        }        
    );    
    
    $('#link_expDate').datepicker({
            autoclose:true,
            todayHighlight:true,            
            format:'dd/mm/yyyy',
            //startDate: '0',
        }        
    );
	$('.ptime, .ctime,.otime').datetimepicker({
        //format: 'LT'        
        format: 'HH:mm'        
    });


    function CallfrCk(){
        $('#formNC').formChecks({nonASCII:true,ajaxSubFunc:frmAction}).SetToFirstFocus();
    }
    CallfrCk();
})

function frmAction1(){
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