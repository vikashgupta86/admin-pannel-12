<?php include '../appcode/globals.inc.php';
include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');
AjaxFilePrevent();
userAuthenticationPageLevel();
$result=array(0=>false);

$queries='';
$musume_type =  empty($_SESSION['musume_type']) ? 0 : $_SESSION['musume_type'];

    $frmVal=array(
        "bannerCat|radia|y|1|10|num|Please enter Valid option!",        
    );
    $ValiStr=implode('|$$|',$frmVal);
    $FrmError=$chk->requestcheck($ValiStr,"formNC","div",true,true);
    if($FrmError){
        $result[0]=false;
        $result[2]=array(true,'Unable to complete your request, please try again!','alert-info');
       // goto ComeHere;        
    }
    
    $queries="update web_media_category set banner_flage=1 where status='Active' and m_cat_id=$_REQUEST[bannerCat]|$$|";
    $queries.="update web_media_category set banner_flage=NULL where status='Active' and m_cat_id!=$_REQUEST[bannerCat]|$$|";
    
    $success=batch_execute($queries);
    
if($success)
    $result[0]=true;

//ComeHere:
echo frm_response($result);