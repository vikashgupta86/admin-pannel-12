<?php include '../appcode/globals.inc.php';
include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');
AjaxFilePrevent();
userAuthenticationPageLevel();
$result=array(0=>false);
    
    $frmVal=array(
        "title_id|text|n|1|10|num|dontselect=-1|Please enter Valid option!",
        "f_name|text|y|1|500|alnum_spc|Please enter Valid Name!",
        "m_name|text|n|1|500|alnum_spc|Please enter Valid Name!",
        "l_name|text|y|1|500|alnum_spc|Please enter Valid Name!",
        "dob|text|y|10|10|dt|Please enter/ select Valid Date!",        
        "l_file|file|n|1|2048|file_extn=jpg;png;jpeg;|Please Select file, Allowed extenstions are jpg, jpeg, png!",
        "address|textarea|y|1|2000|alnum_spc|Please enter Valid Source!",
        "state_id|text|y|1|10|num|dontselect=-1|Please enter Valid option!",
        "district_id|text|y|1|10|num|dontselect=-1|Please enter Valid option!",
        "pincode|text|n|6|10|alnum_spc|Please enter Valid Pincode!",
        "c_landline|text|n|1|5|num|Please enter Valid Number!",
        "landline|text|n|8|10|num|Please enter Valid Number!",
        "c_fax|text|n|1|5|num|Please enter Valid Number!",
        "fax|text|n|8|10|num|Please enter Valid Number!",
        "mob|text|n|10|11|num|Please enter mobile number !",
        "Demail|text|n|1|100|email|Please enter Proper Email!",
    );
    
    $ValiStr=implode('|$$|',$frmVal);
    $FrmError=$chk->requestcheck($ValiStr,"formNC","div",true,true);
    if($FrmError){
        $result[0]=false;
        $result[1]=$FrmError;
        //goto ComeHere;        
    }

$FielArr=array(
    'user_id'=>$_SESSION['userid'],
    'title_id'=>$_REQUEST['title_id'],
    'f_name'=>$_REQUEST['f_name'],
    'm_name'=>$_REQUEST['m_name'],
    'l_name'=>$_REQUEST['l_name'],
    'gender'=>$_REQUEST['u_gen'],
    'dob'=>!empty($_REQUEST['dob'])? $_REQUEST['dob']:'',
    'addr'=>$_REQUEST['address'],
    'state_id'=>$_REQUEST['state_id'],                
    'district_id'=>$_REQUEST['district_id'],
    'pincode'=>$_REQUEST['pincode'],
    'mobile'=>$_REQUEST['mob'],
    'email_id'=>$_REQUEST['Demail'],
    'std_code'=>$_REQUEST['c_landline'],
    'landline'=>$_REQUEST['landline'],    
    'f_std_code'=>$_REQUEST['c_fax'],
    'f_landline'=>$_REQUEST['fax'],    
);

if(!empty($_FILES['l_file']['name'])){
    $filName =  upload('l_file',$_SESSION['uploader']);        
    if(empty($filName)){
        $result[2]=array(true,'Unable to upload the Profile Image!','alert-info');
       // goto ComeHere; 
    }
    
    $FielArr=array_merge($FielArr,array(
            'profile_img'=>$filName
        ));
}



$ChkPub = getNameQry("select wup.profile_id from web_users_profile wup RIGHT JOIN web_users wu on wu.user_id=wup.user_id WHERE wu.status='Active' and wu.current_status='Active' and wu.user_id = ".$_SESSION['userid']."");
if(!empty($ChkPub)){
        
    //$success = update("web_users_profile",$Fields,$Values,"user_id = ".$_SESSION['userid']."");

    $uid = $_SESSION['userid'];
    $success = update("web_users_profile", $FielArr, "user_id = $uid", 1 );
}
else{   
     
    //$success =  insert("web_users_profile",$Fields,$Values);

    $success = insert("web_users_profile", $FielArr, 1);
}

if($success)
    $result[0]=true;


echo frm_response($result);