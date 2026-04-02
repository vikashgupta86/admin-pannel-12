<?php include '../appcode/globals.inc.php';
include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');
include('include/pageHeader.inc.php');
$obj->LoginSetCookie();
$sSeed = $obj->getNum();
$obj->DecruptUrl();
$_SESSION['auth_seed']=$sSeed;
?>
<body class="hold-transition login-page container-fluid">
<?php
$param=$obj->BindEncruptUrl("reqId=".filter_var($_GET['reqId'], FILTER_SANITIZE_URL)."&uId=".filter_var($_GET['uId'], FILTER_SANITIZE_URL)."&reqOn=".filter_var($_GET['reqOn'], FILTER_SANITIZE_URL)."");    
if(isset($_REQUEST['param'])){        
?>
<div class="login-box">    
  <div class="login-logo">Reset your Password</div>
  <!-- /.login-logo -->  
  <div class="login-box-body">
    <form id="formLogin" name="formLogin" action="reset_password_action.php" method="post" autocomplete="off">
        <input type="hidden" name="param" id="param" value="<?php echo $_REQUEST['param'];?>" />
        <input type="hidden" name="hash" id="hash" value=""/>
        <input type="hidden" name="hash1" id="hash1" value="<?php #echo $_SESSION['auth_seed'];#echo isset($_SESSION['auth_seed']) && !empty($_SESSION['auth_seed'])?md5($_SESSION['auth_seed']):'';?>"/>
        <input type="hidden" name="hash2" id="hash2" value="<?php #echo $_SESSION['auth_seed']; #echo isset($_SESSION['auth_seed']) && !empty($_SESSION['auth_seed'])?md5($_SESSION['auth_seed']):'';?>"/>
      
      <div class="form-group has-feedback">
        <label for="T2" class="control-label">New Password:</label>
        <input type="password" class="form-control" placeholder="Password" name="T2" id="T2" value="" data-validate="T2|password|y|0|100|passpolicy|hidein1=hash1|Please Enter New Password with atleast 8 characters. Password should be contain atlease 2 Special Characters, 2 Upper Case Aplhabets, 2 Lower Case Aplhabets, 2 Numeric Values !">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      
      <div class="form-group has-feedback">
        <label for="T3" class="control-label">Confirm Password:</label>
        <input type="password" class="form-control" placeholder="Password" name="T3" id="T3" value="" data-validate="T3|password|y|0|100|passpolicy|eqelmnt=T2|hidein1=hash2|Please re-enter New Password !">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
	  
	  <?php $capSuf='1';?>
                 <?php if($_ENV['CAPTCHA']=="true"){ ?> 
                 <div class="clearfix"></div>                 
                  <div class="form-group has-feedback">
                    <div class="feed-back"><img id="captcha<?php echo $capSuf;?>" src="captcha/php_captcha.php?sid=<?php echo rand();?><?php echo !empty($capSuf)?"&sval=1":'';?>" /><br />
                        Can't read the image? click <span style="color: red;" href='javascript: void();'><strong class="CopyIcon" onclick="refreshCaptcha(<?php echo $capSuf;?>)">here</strong></span> to refresh
                    </div>
                    <label for="T3<?php echo $capSuf;?>" class="control-label"><span class="disp-block DataRed">[Case Sensitive]</span> </label>        
                    <input type="text" class="form-control" placeholder="Security Code" name="T3<?php echo $capSuf;?>" id="T3<?php echo $capSuf;?>" value="" data-validate="T3<?php echo $capSuf;?>|text|y|6|6|alnum|Please enter Valid Security Code !"/>
                    <span class="glyphicon glyphicon-eye-open form-control-feedback"></span>
                  </div>
                <?php } ?>
            
      <div class="row">        
        <!-- /.col -->
        <div class="text-center col-md-4 col-md-offset-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Submit <i class="fa fa-sign-in" aria-hidden="true"></i></button>
        </div>
      </div>
    </form>
  </div>
  
  <!-- /.login-box-body -->
</div>

<?php
   }
   
   
   //-------------------########Action Code Start###########--------------->
    if(isset($_GET['reqId'])){
        $ChkTime=$obj->getNameQry("select case when TIMEDIFF(ADDDATE('$_GET[reqOn]',INTERVAL 30 minute),now())>0 then true else false end");        
        if($ChkTime==false){            
            $obj->simplefetchUA("update web_forgot_pass_request set req_status=2 where status='Active' and req_status=0 and pas_reset_id=$_GET[reqId]");
            $obj->show_msg("Link has been expired,<br>please re-generate the reset password link using the 'Forgot Password'!");
            $obj->headers('reset_password',"");
        }
        else{
            $ChkReqStatus=$obj->getName("web_forgot_pass_request","req_status","pas_reset_id=$_GET[reqId]");
            if($ChkReqStatus!='0'){
                $obj->show_msg("Link has been expired or you had already reset the password!<br>Generate new link again!");
                $obj->headers('reset_password',"");
            }
        }
    }
  ?>
<div id="ShowMsg"><?php 
if(isset($_REQUEST['param']) && !empty($_REQUEST['param']))
    unset($_SESSION['msg']);
    
echo !empty($_SESSION['msg'])?"$_SESSION[msg]":"";?>
</div>

<!-- /.login-box -->
<div class="modal-container"></div>
<script>
//console.log($('form:first *:input[type!=hidden]:first'))
//console.log($('form:first *:input[type!=hidden]:first'));
//$("*:input[type!=hidden]:first" , "#formLogin").focus();
//console.log($("*:input[type!=hidden]:first" , "#formLogin").focus())
$SetPath='';
$(document).ready(function(){        
    $('#formLogin').formChecks({addlFunc:CallBackME(),ajaxSubFunc:verifyMe}).SetToFirstFocus();
});

function verifyMe(){  
    $.base64.utf8encode = true;
    $.ajax({
        type     : "POST",
        dataType: "text",
        cache    : false,
        url      : $('#formLogin').attr('action'),
        data     : $('#formLogin').serialize(),
        beforeSend: function(){
            $.fn.ajaxLoading();
        },        
        success  : function(data) {
            data=$.parseJSON($.base64.atob(data));
            if(data[0]){
                if(data[3]!= undefined && data[3][0]==true){
                    //console.log(data[3][1])
                    $('#ShowMsg').ShowMsg({msg:'Your Password has been changed Successfully!'});
                    // window.location.replace(data[3][1]);
                }                                               
            }
            else{
                $('#formLogin')[0].reset();
                $('#hash,#hash1,#hash2').val('');
                //$('#hash1,#hash2').val($.fn.md5({string:(Math.floor(Math.random()*90000000) + 10000000).toString()}));
                if(data[1]!= undefined && data[1][0]==true){
                    FEror=data[1][1];
                    //console.log(FEror)
                    $.fn.ShowError(FEror);    
                }
                else if(data[2]!= undefined && data[2][0]==true){
                    MEror=data[2][1];
                    //console.log(MEror);       
                    $('#ShowMsg').ShowMsg({msg:MEror,alertClass:data[2][2]});
                }
                else{                                          
                    $('#ShowMsg').ShowMsg({msg:'Request not Completed Successfully!'});                        
                }
            }                       
        },
        error:function(){
            $('#ShowMsg').html("<div class='alert fade in col-md-4 col-md-offset-4 model-width alert-info'><a href='#' class='close' data-dismiss='alert'>&times;</a>Something went wrong, Please try again!</div>");
        },
        complete: function(){            
            $.fn.ajaxLoading({show:false});
        },
    });    
}

function CallBackME(){
    $('#hash,#hash1,#hash2').val('');
    //$('#hash1,#hash2').val($.fn.md5({string:(Math.floor(Math.random()*90000000) + 10000000).toString()}));
}
</script>
<script src="captcha/captcha.js" defer=""></script>
</body>
</html>
