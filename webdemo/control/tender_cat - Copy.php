<?php include '../appcode/globals.inc.php';
include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');
AjaxFilePrevent();
$_SESSION['uploader']='PCAT8945';
?>

            
            <?php
            if(isset($_REQUEST['frmType']) && $_REQUEST['frmType']==2)
            {
              //  $rs=$obj->simplefetch("select * from web_tender_category where status='Active' and t_cat_id=$_REQUEST[t_cat_id]");

                $sql = "SELECT * FROM web_tender_category WHERE status='Active' AND t_cat_id = ? ";
                $conn = db_connect();
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $_REQUEST['t_cat_id']);
                $stmt->execute();
                $rs = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
                $stmt->close();

                foreach($rs as $row);                    
            }
            ?>
            
            <form name="formNC" id="formNC" method="post" autocomplete="off" role="form" action="<?php echo "tender_cat_action.php?per_id=$_SESSION[per_id]&amp;EncHid=$_SESSION[EncTok]";?>" enctype="multipart/form-data" >
            <input type="hidden" name="frmType" id="frmType" value="<?php echo $_REQUEST['frmType'];?>" />                        
            <input type="hidden" name="t_cat_id" id="t_cat_id" value="<?php echo $_REQUEST['t_cat_id'];?>" />            
            <div class="modal-body">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="c_name">Category Name</label>
                      <input type="text" class="form-control" name="c_name" id="c_name" placeholder="Category Name" value="<?php echo $row['cat_name'] ?? '' ;?>" data-validate="c_name|text|y|1|500|alnum_spc|Please enter Valid Category Name!"/>
                    </div>
                    
                    <!--<div class="form-group">
                      <label for="hc_name">Category Name (Hindi)</label>
                      <input type="text" class="form-control" name="hc_name" id="hc_name" placeholder="Category Name in Hindi" value="<?php // echo html_entity_decode($row['cat_name_h']);?>" data-validate="hc_name|text|n|1|5000|alnum_spc|Please enter Valid Category Name!"/>
                    </div>                        
                    
                    <?php
                     /*if(!empty($row['img_name'])){                              
                    ?>
                    <div class="form-group col-md-6">
                      <label for="l_file">Existing Icon: </label>
                      <img src="<?php echo "../WriteReadData/$_SESSION[uploader]/$row[img_name]";?>" class="img-thumbnail" alt="Link Icon" width="100"/>
                    </div>
                    <?php
                    } */
                    ?>
                    <div class=" clearfix"></div>
                    <div class="form-group">
                      <label for="l_file">Choose File: </label>
                      <?php // $Mand=(empty($row['img_name']))?'y':'n';?>
                      <input type="file" name="l_file" id="l_file" data-validate="l_file|file|<?php // echo $Mand;?>|1|5000|file_extn=jpg;jpeg;png;|Please Select file, Allowed extenstions are jpg, jpeg, png!"/>
                      
                      <p class="help-block bg-danger">Allowed file extenstion are <kbd>jpg, jpeg, png</kbd>. File size should be less then 2 MB.</p> 
                    </div>-->
                                        
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
/*
$(function(){        
    function CallfrCk(){
        $('#formNC').formChecks({nonASCII:true,ajaxSubFunc:frmAction}).SetToFirstFocus();
    }
    CallfrCk();
})

function frmAction(){
    $.base64.utf8encode = true;
    
    var formData = new FormData();
    //formData.append('name', $('#formNC').serialize());
    //formData.append('l_file', $('#l_file')[0].files[0]);
    
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