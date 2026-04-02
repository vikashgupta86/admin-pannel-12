<?php include '../appcode/globals.inc.php';
include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');
?>
<div id="PopWind" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">            
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Reset Password</h4>
            </div>
            <form name="formNC" id="formNC" role="form" action="resetPass_action.php" method="post" autocomplete="off">
            <div class="modal-body">                
                    <input type="hidden" name="hash3" id="hash3" value=""/>                                    
                  <div class="form-group has-feedback">
                    <label for="P1" class="control-label">Login (Email ID):</label>
                    <input type="text" class="form-control" name="P1" id="P1" placeholder="Login ID" value="" data-validate="P1|text|y|0|100|alnum_spc|hidein1=hash3|Please enter Login ID !"/>
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                  </div>
                  <?php $capSuf='1';?>
                 <?php if($_ENV['CAPTCHA']=="true"){ ?> 
                 <div class="clearfix"></div>                 
                  <div class="form-group has-feedback">
                    <div class="feed-back"><img id="captcha<?php echo $capSuf;?>" src="captcha/php_captcha.php?sid=<?php echo rand();?><?php echo !empty($capSuf)?"&sval=1":'';?>" /><br/>
                        Can't read the image? click <span style="color: red;" href='javascript: void();'><strong class="CopyIcon" onclick="refreshCaptcha(<?php echo $capSuf;?>)">here</strong></span> to refresh
                    </div>
                    <label for="T3<?php echo $capSuf;?>" class="control-label"><span class="disp-block DataRed">[Case Sensitive]</span> </label>        
                    <input type="text" class="form-control" placeholder="Security Code" name="T3<?php echo $capSuf;?>" id="T3<?php echo $capSuf;?>" value="" data-validate="T3<?php echo $capSuf;?>|text|y|6|6|alnum|Please enter Valid Security Code !"/>
                    <span class="glyphicon glyphicon-eye-open form-control-feedback"></span>
                  </div>
                <?php } ?>
               <div class="clearfix"></div>           
               <div id="ShowMsg1"></div>
            </div>
              <div class="clearfix"></div>
              
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Reset</button>
            </div>
            </form>    
            <div class="clearfix"></div>        
        </div>
        
        
    </div>
</div>
<script type="text/javascript">
$(document).ready(function(){  
    refreshCaptcha('<?php echo $capSuf;?>');
    //refreshCaptcha(1);reload(1);    
    $('#formNC').formChecks({addlFunc:CallBackM(),ajaxSubFunc:resetMe}).SetToFirstFocus();
})

function resetMe()
{ 

    $.base64.utf8encode = true;
    $.ajax({
        type     : "POST",
        dataType: "text",
        cache    : false,
        url      : $('#formNC').attr('action'),
        data     : $('#formNC').serialize(),
        beforeSend: function(){
            $.fn.ajaxLoading();
        },        
        success  : function(data) {
            console.log(data);
            data=$.parseJSON($.base64.atob(data));
            if(data[0])
            { 
		        //window.open('/nma1/control/reset_password_link.php','_blank'); 
                //window.location.href="http://122.160.119.248:8080/nma1/control/reset_password_link.php";			
                $('#ShowMsg').ShowMsg({msg:'Reset password link has been send to your registered Email-ID!',alertClass:'alert-success'});
                $('#PopWind').modal('toggle'); 
		    }
            else
            {
                $('#formNC')[0].reset();
                $('#hash3').val('');
                refreshCaptcha(1);
                if(data[1]!= undefined && data[1][0]==true){
                    FEror=data[1][1];                    
                    $.fn.ShowError(FEror);    
                }
                else if(data[2]!= undefined && data[2][0]==true){
                    MEror=data[2][1];
                    //console.log(MEror);
                    $('#ShowMsg1').ShowMsg({msg:MEror,alertClass:data[2][2],colwidth:'col-md-8',coloffset:'col-md-offset-2'});
                }
                else{                                          
                    $('#ShowMsg1').ShowMsg({msg:'Request not Completed Successfully!',colwidth:'col-md-8',coloffset:'col-md-offset-2',alertClass:'alert-danger'});                        
                }
            }                       
        },
        error:function(){
            $('#ShowMsg1').html("<div class='alert fade in col-md-8 col-md-offset-2 model-width alert-info'><a href='#' class='close' data-dismiss='alert'>&times;</a>Something went wrong, Please try again!</div>");
        },
        complete: function(){            
            $.fn.ajaxLoading({show:false});
        },
    }); 
}

function CallBackM(){
    $('#hash3').val('');    
}

</script>


<script src="contactcaptcha/captcha/captcha.js"></script> 