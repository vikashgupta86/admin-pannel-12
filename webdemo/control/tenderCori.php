<?php include '../appcode/globals.inc.php';
include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');
// $obj->AjaxFilePrevent();
$_SESSION['uploader']='T45218';
$_SESSION['rtfUpload']='RTFT4581';

?>

            
            <?php
            if(isset($_REQUEST['frmType']) && $_REQUEST['frmType']==2){
                $rs= simplefetch("select *,date_format(pub_date,'%Y-%m-%d')as pub_date,date_format(close_date,'%Y-%m-%d')as close_date,date_format(open_date,'%Y-%m-%d')as open_date from web_tender_temp where status='Active' and t_temp_id= ".$_REQUEST['t_temp_id']."");
                if($rs[0]>0){
                    foreach($rs[1] as $row);                    
                }
            }
            else
            {
                $corCount=getNameQry("select count(tf.ct_id) as tot from web_tender_temp tt INNER JOIN web_tender_corrigendum_final tf on tf.t_temp_id=tt.t_temp_id 
                where tt.`status`='Active' and tt.t_id= ".$_REQUEST['t_id']." and tt.corrigendum=1");
                if($corCount>0)
                {
                    $rs=simplefetch("select tt.close_time,tt.open_time,date_format(tt.pub_date,'%Y-%m-%d')as pub_date,date_format(tt.close_date,'%Y-%m-%d')as close_date,date_format(tt.open_date,'%Y-%m-%d')as open_date from web_tender_temp tt 
                    INNER JOIN web_tender_corrigendum_final tf on tf.t_temp_id=tt.t_temp_id 
                    where tt.`status`='Active' and tt.t_id= ".$_REQUEST['t_id']." and tt.corrigendum=1 order by tt.t_temp_id DESC LIMIT 1");
                
                }
                else
                {
                
                    $rs=simplefetch("SELECT close_date,close_time,open_date,open_time,date_format(pub_date,'%Y-%m-%d') as pub_date,date_format(close_date,'%Y-%m-%d') as close_date,date_format(open_date,'%Y-%m-%d') as open_date FROM web_tender_temp WHERE status='Active' AND t_temp_id=".$_REQUEST['t_t_id']."");
                
                }
                
                if($rs[0]>0){
                    foreach($rs[1] as $row);                    
                }

			
			}
			
			
			
            ?>
            
            <form name="formNC" id="formNC" method="post" autocomplete="off" role="form" action="<?php echo "tenderCori_action.php?per_id=$_SESSION[per_id]&amp;EncHid=$_SESSION[EncTok]";?>" enctype="multipart/form-data" >
            <input type="hidden" name="frmType" id="frmType" value="<?php echo $_REQUEST['frmType'];?>" />            
            <input type="hidden" name="t_cat_id" id="t_cat_id" value="<?php echo $_REQUEST['t_cat_id'];?>" />            
            <input type="hidden" name="t_temp_id" id="t_temp_id" value="<?php echo $_REQUEST['t_temp_id'];?>" />
            <input type="hidden" name="t_id" id="t_id" value="<?php echo $_REQUEST['t_id'] ?? '';?>" />            
            <input type="hidden" name="ct_id" id="ct_id" value="<?php echo $_REQUEST['ct_id'] ?? '';?>" />
            <div class="modal-body">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="l_name">Heading</label>
                      <input type="text" class="form-control" name="l_name" id="l_name" placeholder="Corrigendum Name" value="<?php echo $row['tender_name'] ?? '';?>" data-validate="l_name|text|y|1|500|alnum_spc|Please enter Valid Link Name!"/>
                    </div>
                    
                    <div class="form-group">
                      <label for="l_title">Title</label>
                      <input type="text" class="form-control" name="l_title" id="l_title" placeholder="Corrigendum Title" value="<?php echo $row['title'] ?? '';?>" data-validate="l_title|text|y|1|500|alnum_spc|Please enter Valid Link Title!"/>
                    </div>
                    
                   <!-- <div class="row">
                        <div class="form-group col-md-6">
                          <label for="link_pubDate">Publish Date:</label>
                          <div class="input-group">
                            <input type="text" class="form-control" name="link_pubDate" id="link_pubDate" placeholder="DD/MM/YYYY" value="<?php //echo $row['pub_date'];?>" data-validate="link_pubDate|text|y|10|10|dt|Please enter/ select Valid Date!"/>
                            <span class="input-group-addon CopyIcon" data-for='link_pubDate'><span class="glyphicon glyphicon-calendar"></span></span>
                          </div>
                        </div>                        
                        
                        <div class="form-group col-md-6">
                            <label for="ptime">Publish Time:</label>
                            <div class='input-group date ptime'>
                                <input type='text' name="ptime" id="ptime" class="form-control ptime" value="<?php //echo $row['pub_time'];?>" data-validate="ptime|text|n|5|5|ti|Please enter/ select Valid Time!" />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                            </div>
                        </div>
                    </div>-->
                    
                    <div class="row">
                        <div class="form-group col-md-6">
                          <label for="t_cloDate">Bid-submission/ Closing Date:</label>
                          <div class="input-group">
                            <input type="date" class="form-control" name="t_cloDate" id="t_cloDate" placeholder="DD/MM/YYYY" value="<?php echo $row['close_date'] ?? '';?>" data-validate="t_cloDate|text|n|10|10|dt|Please enter/ select Valid Date!"/>
                            <span class="input-group-addon CopyIcon" data-for='t_cloDate'><span class="glyphicon glyphicon-calendar"></span></span>
                          </div>
                        </div>                        
                        
                        <div class="form-group col-md-6">
                            <label for="ctime">Bid-submission/ Closing Time:</label>
                            <div class='input-group date ctime'>
                                <input type='time' name="ctime" id="ctime" value="<?php echo $row['close_time'] ?? '';?>" class="form-control ctime" data-validate="ctime|text|n|5|5|ti|Please enter/ select Valid Time!"  />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="form-group col-md-6">
                          <label for="t_openDate">Tender Opening Date:</label>
                          <div class="input-group">
                            <input type="date" class="form-control" name="t_openDate" id="t_openDate" placeholder="DD/MM/YYYY" value="<?php echo $row['open_date'] ?? '';?>" data-validate="t_openDate|text|n|10|10|dt|Please enter/ select Valid Date!"/>
                            <span class="input-group-addon CopyIcon" data-for='t_openDate'><span class="glyphicon glyphicon-calendar"></span></span>
                          </div>
                        </div>                        
                        
                        <div class="form-group col-md-6">
                            <label for="otime">Tender Opening Time:</label>
                            <div class='input-group date otime'>
                                <input type='time' name="otime" id="otime" value="<?php echo $row['open_time'] ?? '';?>" class="form-control otime" data-validate="otime|text|n|5|5|ti|Please enter/ select Valid Time!" />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                      <label for="l_file">Choose File</label>
                      <?php $Mand=(empty($row['file_name']))?'y':'n';?>
                      
                      <input type="file" name="l_file" id="l_file" data-validate="l_file|file|<?php echo $Mand;?>|1|30000|file_extn=pdf|Please Select file, Only PDF is allowed!" accept="application/pdf"/>
                      <?php
                      if(!empty($row['file_name'])){                              
                      ?>
                      <a href="#"><i class="fa fa-file-pdf-o text-red" data-fname='<?php echo base64_encode($row['file_name']);?>' title="View File"></i></a>
                      <?php
                      }
                      ?>
                      <p class="help-block">Allowed file extenstion is 'pdf'. File size should be less then 20 MB.</p> 
                    </div>                        
                
                    <div class="form-group">
                      <label for="textarea2">Rich Text Formater:</label>
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
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            </form>    
            

<script type="text/javascript">
$(function(){
    $('#l_name').keyup(function(){        
        $('#l_title').val($(this).val());
    });
    $(".modal-dialog").css("width", "800px");
    showRTF();
        
   
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