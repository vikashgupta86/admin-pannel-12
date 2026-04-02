<?php 
    include '../appcode/globals.inc.php';
    include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');
    AjaxFilePrevent();
?>

    <?php
    if(isset($_REQUEST['frmType']) && $_REQUEST['frmType']==1){
        $rs=simplefetch("SELECT mt.m_description,mt.m_description_h,mt.m_temp_id,mt.m_name,mt.m_name_h,mt.type_of_media,case when mt.type_of_media=1 then 'Photo' else 'Video' end as mType,concat(wu.user_name,' [',date_format(mt.creation_date,'%d/%m/%Y'),' ]')as cName,ifnull(concat(ru1.user_name,' [',date_format(mt.app_rej_action_on,'%M %d, %Y'),' ]'),'N/A')as apName from web_media_temp mt
    INNER JOIN web_media_category mc on mc.m_cat_id=mt.m_cat_id
    INNER JOIN web_users wu on wu.user_id=mt.creator_id
    INNER JOIN web_users ru1 on ru1.user_id=mt.app_rej_user_id
    LEFT JOIN (select * from web_media_final where status='Active') mf on mf.m_temp_id=mt.m_temp_id
    where mt.status='Active' and mt.app_reject=1 and mt.m_temp_id=$_REQUEST[m_temp_id]");
        if($rs[0]<=0){
            //$show_msg("Error comes, Please try again!",'info',true);
            echo "<script>$(function(){\$.fn.custom_alert({msg:'Error comes, Please try again!',title:'Information'});\$('#PopWind').hide();})</script>"; 
            exit();                                       
        }
        else{
            foreach($rs[1] as $row);
    ?>
            <form name="formNC" id="formNC" method="post" autocomplete="off" role="form" action="<?php echo "media_pub_action.php?per_id=$_SESSION[per_id]&amp;EncHid=$_SESSION[EncTok]";?>" enctype="multipart/form-data" >
            <input type="hidden" name="frmType" id="frmType" value="<?php echo $_REQUEST['frmType'];?>" />            
            <input type="hidden" name="m_temp_id" id="m_temp_id" value="<?php echo $_REQUEST['m_temp_id'];?>" />            
            <div class="modal-body">
                  <div class="box-body">
                    <div class="form-group col-md-6">
                      <label for="l_name">Media Type:</label>
                      <label class="normal "><?php echo $row['mType'];?></label>                      
                    </div>
                    
                    <div class="form-group col-md-4">
                      <label for="l_alias">Description:</label>
                      <label class="normal "><?php echo $row['m_description'];?></label>
                    </div>
                    
                    <div class="form-group col-md-12">
                      <label for="l_name">Description (Hindi):</label>
                      <label class="normal "><?php echo html_entity_decode($row['m_description_h']);?></label>                      
                    </div>
                    
                    <div class="form-group col-md-6">
                      <label for="l_alias">Created by/ On:</label>
                      <label class="normal "><?php echo $row['cName'];?></label>
                    </div>
                    
                    <div class="form-group col-md-6">
                      <label for="l_alias">Approved by/ On:</label>
                      <label class="normal "><?php echo $row['apName'];?></label>
                    </div>
                                        
                    <div class="form-group col-md-6">
                      <label for="link_pubDate">Publish Date:</label>
                      <div class="input-group">
                        <input type="date" class="form-control" name="link_pubDate" id="link_pubDate" placeholder="DD/MM/YYYY" value="<?php echo curdatetime('%d/%m/%Y');?>" data-validate="link_pubDate|text|y|10|10|dt|Please enter/ select Valid Date!"/>
                        <span class="input-group-addon CopyIcon" data-for='link_pubDate'><span class="glyphicon glyphicon-calendar"></span></span>
                      </div>
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
// $(function(){
//     $('.input-group-addon').click(function(){
//         if($(this).data('for')!=undefined){            
//             $('#'+$(this).data('for')).trigger('focus');
//         }
//     })
//     $('#link_pubDate,#link_expDate,#link_nrevDate').datepicker({
//             autoclose:true,
//             todayHighlight:true,            
//             format:'dd/mm/yyyy',
//             startDate: '0',
//         }        
//     );    
    
//     function CallfrCk(){
//         $('#formNC').formChecks({nonASCII:true,ajaxSubFunc:frmAction}).SetToFirstFocus();
//     }
//     CallfrCk();
// })



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