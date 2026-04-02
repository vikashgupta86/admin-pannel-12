<?php include '../appcode/globals.inc.php';
//include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');
include('include/pageHeader.inc.php');
//$obj->LoginSetCookie();
$sSeed = $obj->getNum();
//$obj->DecruptUrl();
$_SESSION['auth_seed']=$sSeed;
?>
<body class="hold-transition login-page container-fluid">
<?php
//$param=$obj->BindEncruptUrl("reqId=$_GET[reqId]&uId=$_GET[uId]&reqOn=$_GET[reqOn]");  
$UserID='';
$UsernamegetF='';
$RestUrl='';
$rs=$obj->simplefetch("SELECT * FROM web_forgot_pass_request WHERE status='Active' and pas_reset_id IN (SELECT max(pas_reset_id) as rid FROM web_forgot_pass_request WHERE status='Active')",1);
    if($rs[0]>=0){        
      foreach($rs[1] as $row);  
    }
	
	$UserID  = $row['user_id'];
	$success = $row['pas_reset_id'];
	$reqOn = $obj->curdatetime();
	
	$UserNameID = $obj->getNameQry("select concat(wu.user_id,'|$$|',concat(ifnull(uf.f_name,''),' ',ifnull(uf.m_name,''),' ',ifnull(uf.l_name,'')),'|$$|',ifnull(wu.uname,''),'|$$|',ifnull(wu.user_type_id,''))as str from web_users wu
INNER JOIN web_users_profile uf on uf.user_id=wu.user_id where wu.status='Active' and wu.status='Active' and wu.current_status='Active' and wu.user_type_id!=4 and wu.user_id=$UserID",1);
	
	if (!empty($UserNameID)) {
	$UserNameGet = explode('|$$|', $UserNameID);
	$UsernamegetF = $UserNameGet[1];
	}
	
	//echo "reqId=$success&uId=$UserID&reqOn=" . $obj->curdatetime();
	
	 $param = $obj->BindEncruptUrl("reqId=$success&uId=$UserID&reqOn=" .$reqOn);
		$RestUrl = $obj->BaseUrl() . '/control/r_pass_frm.php' . $param;
	
//echo $param;
//exit;  
//if(isset($_REQUEST['param'])){        
?>
<div class="login-box">    
  <div class="login-logo">Reset your Password</div>
  
  
  <!-- /.login-logo -->  
  <div class="login-box-body">
    
	
	Dear <?php echo $UsernamegetF; ?>, <br><br>You recently requested to reset your password for your account. <a target="_blank" href=<?php echo $RestUrl; ?> title='Click Here to Reset the Password'>Click here</a> to reset it.<br><br>
                                If you did not request a password reset, please ignore this email. This password reset is only valid for the next 30 minutes.
                                <br><br> Regards <br>NIC/NICSI<br>(National Informatics Centre)
	
  </div>
  
  <!-- /.login-box-body -->
</div>

<?php
  // }
   
   
   //-------------------########Action Code Start###########--------------->
    /*if(isset($_GET['reqId'])){
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
    }*/
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
