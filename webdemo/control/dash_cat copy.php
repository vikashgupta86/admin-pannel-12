<?php include '../appcode/globals.inc.php';
include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');
AjaxFilePrevent();
$_SESSION['uploader']='PCAT8945';
?>
           
           
            
            <?php
                if(isset($_REQUEST['frmType']) && $_REQUEST['frmType']==2)
                {
                    $prgid = $_REQUEST['prog_id'] ?? '';
                    $rs = simplefetch("select * from web_dash_prog where status='Active' and prog_id = ".$prgid."");
                    if($rs[0]>0){
                        foreach($rs[1] as $row);                    
                    }
                }
            ?>
            
            <form name="formNC" id="formNC" method="post" autocomplete="off" role="form" action="<?php echo "dash_cat_action.php?per_id=$_SESSION[per_id]&amp;EncHid=$_SESSION[EncTok]";?>" enctype="multipart/form-data" >
            <input type="hidden" name="frmType" id="frmType" value="<?php echo $_REQUEST['frmType'];?>" />                        
            <input type="hidden" name="prog_id" id="prog_id" value="<?php echo $_REQUEST['prog_id'];?>" />
            <div class="modal-body">

                  <div class="box-body">
                    <div class="form-group">
                      <label for="c_name">Category Name</label>
                      <input type="text" class="form-control" name="c_name" id="c_name" placeholder="Category Name" value="<?php echo $row['prog_name'] ?? '';?>" data-validate="c_name|text|y|1|500|alnum_spcA|Please enter Valid Category Name!"/>
                    </div>
                    
                    <div class="form-group">
                      <label for="hc_name">Category Name (Hindi)</label>
                      <input type="text" class="form-control" name="hc_name" id="hc_name" placeholder="Category Name in Hindi" value="<?= $row['prog_name_hin'] ?? '';?>" data-validate="hc_name|text|n|1|5000|alnum_spcA|Please enter Valid Category Name!"/>
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
    function CallfrCk(){
        $('#formNC').formChecks({nonASCII:true,ajaxSubFunc:frmAction}).SetToFirstFocus();
    }
    CallfrCk();
})

function frmAction(){
    $.base64.utf8encode = true;
    
    // prevent form to go to the server for submission, as we are handling it via AJAX. we will get the response from the server and then we can decide what to do with that response.
    event.preventDefault();


    var formData = new FormData();
    //formData.append('name', $('#formNC').serialize());
    formData.append('l_file', $('#l_file')[0].files[0]);
    
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
        error:function(xhr, status, error){            
            $('#PopWind').modal('toggle');
            /*for(var x in xhr){
                console.log("Name:" + x + ">>>>" + xhr[x]);    
            }*/                       
            if(xhr.status==403){
                $.fn.custom_alert({msg:$(xhr.responseText).find("#custom_msg").html()});
            }
            else{
                $.fn.custom_alert({msg:'Something went wrong, Please try again!'});    
            }
        },
        complete: function(){            
            $.fn.ajaxLoading({show:false});
        },
    });
}


</script>