<?php include '../appcode/globals.inc.php';
include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');
AjaxFilePrevent();
?>

    <?php
    if(isset($_REQUEST['frmType']) && $_REQUEST['frmType']==1){
	
	
	
        $rs=simplefetch("select tt.tender_name,concat(u.user_name, '( ',date_format(tt.creation_date,'%Y-%m-%d'),' )')as linkCdate from web_tender_temp tt 
                    INNER JOIN web_users u on u.user_id=tt.creator_id 
                    LEFT JOIN web_tender_revive tr on tr.t_temp_id=tt.t_temp_id                     
                    where tt.status='Active' and tt.t_temp_id= ".$_REQUEST['t_temp_id']."");
        if($rs[0]<=0){
            show_msg("Error comes, Please try again!",'info',true);
            //echo >$(function(){\$.fn.custom_alert({msg:'Error comes, Please try again!',title:'Information'});\$('#PopWind').hide();})</script>"; 
            exit();                                       
        }
        else{
            foreach($rs[1] as $row);
			
		$r=simplefetch("select date_format(publish_date,'%Y-%m-%d')as publish_date,date_format(expiry_date,'%Y-%m-%d')as expiry_date, expiry_time,publish_time from web_tender_final where status='Active' and t_id=$_REQUEST[t_id]");     
         foreach($r[1] as $row1);
			
    ?>
    <h4 class="modal-title">Publish Tender</h4>

                           
            <form name="formNC" id="formNC" method="post" autocomplete="off" role="form" action="<?php echo "pub_tenderCori_action.php?per_id=$_SESSION[per_id]&amp;EncHid=$_SESSION[EncTok]";?>" enctype="multipart/form-data" >
            <input type="hidden" name="frmType" id="frmType" value="<?php echo $_REQUEST['frmType'];?>" />
            <input type="hidden" name="t_id" id="t_id" value="<?php echo $_REQUEST['t_id'] ?? '';?>" />
            <input type="hidden" name="t_temp_id" id="t_temp_id" value="<?php echo $_REQUEST['t_temp_id'];?>" />            
            <div class="modal-body">
                  <div class="box-body">
                    <div class="form-group col-md-12">
                      <label for="l_name">Corrigendum Name:</label>
                      <label class="normal "><?php echo $row['tender_name'] ?? '';?></label>                      
                    </div>
                    
                    <div class="form-group col-md-6">
                      <label for="l_alias">Created by/ On:</label>
                      <label class="normal "><?php echo $row['linkCdate'] ?? '';?></label>
                    </div>
                    
                    <div class="form-group col-md-6">
                      <label for="l_alias">Approved by/ On:</label>
                      <label class="normal "><?php echo $row['linkCdate'] ?? '';?></label>
                    </div>
                                        
                    <div class="form-group col-md-6">
                      <label for="link_pubDate">Publish Date:</label>
                      <div class="input-group">
                        <input type="date" class="form-control" name="link_pubDate" id="link_pubDate" placeholder="DD/MM/YYYY" value="<?php echo $row1['publish_date'] ?? '';?>" data-validate="link_pubDate|text|y|10|10|dt|Please enter/ select Valid Date!"/>
                        <span class="input-group-addon CopyIcon" data-for='link_pubDate'><span class="glyphicon glyphicon-calendar"></span></span>
                      </div>
                    </div>
                        <div class="form-group col-md-6">
                            <label for="ptime">Publish Time:</label>
                            <div class='input-group date ptime'>
                                <input type='time' name="ptime" id="ptime" class="form-control ptime" value="<?php echo $row1['publish_time'] ?? '';?>" data-validate="ptime|text|n|5|5|ti|Please enter/ select Valid Time!" />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                            </div>
                        </div>
                    
                    <?php
                    if($row['continuous_content'] ?? '' !=1){
                    ?>
                    <div class="form-group col-md-6">
                      <label for="link_expDate">Expired Date:</label>
                      <div class="input-group">
                        <input type="date" class="form-control" name="link_expDate" id="link_expDate" placeholder="DD/MM/YYYY" value="<?php echo $row1['expiry_date'] ?? '';?>" data-validate="link_expDate|text|y|10|10|dt|Please enter/ select Valid Date!"/>
                        <span class="input-group-addon CopyIcon" data-for='link_expDate'><span class="glyphicon glyphicon-calendar"></span></span>
                      </div>                      
                    </div>
                    
                       <div class="form-group col-md-6">
                            <label for="ctime">Expired Time:</label>
                            <div class='input-group date ctime'>
                                <input type='time' name="ctime" id="ctime" class="form-control ctime" value="<?php echo $row1['expiry_time'] ?? '';?>" data-validate="ctime|text|n|5|5|ti|Please enter/ select Valid Time!" />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                            </div>
                        </div>

                    
                    <div class=" clearfix"></div>
                    
                    <div class="form-group col-md-6">
                      <label for="link_nrevDate">Next Revivew Date:</label>
                      <div class="input-group">
                        <input type="date" class="form-control" name="link_nrevDate" id="link_nrevDate" placeholder="DD/MM/YYYY" value="<?php #echo html_entity_decode($row['link_name']);?>" data-validate="link_nrevDate|text|n|10|10|dt|Please enter/ select Valid Date!"/>
                        <span class="input-group-addon CopyIcon" data-for='link_nrevDate'><span class="glyphicon glyphicon-calendar"></span></span>
                      </div>
                    </div>
                    
                    
                    <div class=" clearfix"></div>
                    <?php                    
                        if($row['type_id'] ?? ''==3){
                        ?>                        
    
                        <div class="form-group col-md-6">
                            <ul class="list-inline">
                                <li><label for="l_show">Show Content</label></li>
                                <li class="checkbox">
                                    <input type="radio" name="l_show" id="l_show1" value="1" checked="" /> Yes
                                    <input type="radio" name="l_show" id="l_show1" value="2" <?php echo $row['cont_show'] ?? '' ==2?'checked=""':'';?> data-validate="l_show|checkbox|y|1|2|selmin=1|Please Select atleast One option!"/> No
                                </li>
                            </ul>
                        </div>
                        
                        <div class="form-group col-md-6">
                            <ul class="list-inline">
                                <li><label for="l_feed">Feedback Required</label></li>
                                <li class="checkbox">
                                    <input type="radio" name="l_feed" id="l_feed1" value="1" <?php echo $row['feed_req'] ?? '' ==1?'checked=""':'';?> /> Yes
                                    <input type="radio" name="l_feed" id="l_feed2" value="2" <?php echo (!isset($row['feed_req']) || $row['feed_req']==2)?'checked=""':'';?> data-validate="l_feed|checkbox|y|1|2|selmin=1|Please Select atleast One option!"/> No
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
                
                <div class="clearfix"></div>
                <div id="ShowMsg"></div>
            </div>
            <div class="clearfix"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            </form>    
         
    <?php
        }    
    }        
    ?>

<script <?= $nonce; ?>  type="text/javascript">
$(function(){
    $('.input-group-addon').click(function(){
        if($(this).data('for')!=undefined){            
            $('#'+$(this).data('for')).trigger('focus');
        }
    })
    // $('#link_pubDate,#link_expDate,#link_nrevDate').datepicker({
    //         autoclose:true,
    //         todayHighlight:true,            
    //         format:'dd/mm/yyyy',
    //         /*startDate: '0',*/
    //     }        
    // );    
    //     $('.ptime, .ctime,.otime').datetimepicker({
    //     //format: 'LT'        
    //     format: 'HH:mm'        
    // });

    // function CallfrCk(){
    //     $('#formNC').formChecks({nonASCII:true,ajaxSubFunc:frmAction}).SetToFirstFocus();
    // }
    // CallfrCk();
});

/*

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