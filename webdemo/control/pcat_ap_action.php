<?php include '../appcode/globals.inc.php';
include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');
AjaxFilePrevent();
userAuthenticationPageLevel();
$result=array(0=>false);
    $frmVal=array(        
        "m_cat_id|text|y|1|10|num|Please enter Valid data!"
    );
    $ValiStr=implode('|$$|',$frmVal);
    $FrmError=$chk->requestcheck($ValiStr,"formNC","div",true,true);
    if($FrmError){
        $result[0]=false;
        $result[2]=array(true,'Something went wrong, Please try again!','alert-info');
       // goto ComeHere;        
    }
    
    if(isset($_REQUEST['frmType'])){
        switch($_REQUEST['frmType']){
            case 3:#reject request
                $FielArr=array(
                    'app_rej_user_id'=>$_SESSION['userid'],
                    'app_rej_action_on'=> date('Y-m-d H:i:s'),
                    'app_reject'=>2
                );
                
               // $success=$obj->update("web_media_category",$Fields,$Values,"m_cat_id=$_REQUEST[m_cat_id]");

                $m_cat_id = (int)$_REQUEST['m_cat_id'];
                $success = update("web_media_category", $FielArr, "m_cat_id = $m_cat_id", 1 );

            break;
            
            case 4:#approve request
                $FielArr=array(
                    'app_rej_user_id'=>$_SESSION['userid'],
                    'app_rej_action_on'=> date('Y-m-d H:i:s'),
                    'app_reject'=>1
                );
                
                $m_cat_id = (int)$_REQUEST['m_cat_id'];
                $success = update("web_media_category", $FielArr, "m_cat_id = $m_cat_id", 1 );
                //$success=$obj->update("web_media_category",$Fields,$Values,"m_cat_id=$_REQUEST[m_cat_id]");
            break;
        }
    }
if($success)
    $result[0]=true;

echo frm_response($result);