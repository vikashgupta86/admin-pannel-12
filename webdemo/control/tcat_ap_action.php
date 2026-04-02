<?php include '../appcode/globals.inc.php';
include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');
AjaxFilePrevent();
userAuthenticationPageLevel();

$result=array(0=>false);
    $frmVal=array(        
        "t_cat_id|text|y|1|10|num|Please enter Valid data!"
    );
    $ValiStr=implode('|$$|',$frmVal);
    $FrmError=$chk->requestcheck($ValiStr,"formNC","div",true,true);
    if($FrmError){
        $result[0]=false;
        $result[2]=array(true,'Something went wrong, Please try again!','alert-info');
        //goto ComeHere;        
    }
    
    if(isset($_REQUEST['frmType'])){
        switch($_REQUEST['frmType']){
            case 3:#reject request
                $FielArr=array(
                    'app_rej_user_id'=>$_SESSION['userid'],
                    'app_rej_action_on' => date('Y-m-d H:i:s'),
                    'app_reject'=>2
                );
                
               // $success=$obj->update("web_tender_category",$Fields,$Values,"t_cat_id=$_REQUEST[t_cat_id]");

                $tcatid = $_REQUEST['t_cat_id'];
                $success = update("web_tender_category", $FielArr, "t_cat_id = $tcatid", 1 );
                // $updatetndrcat = "UPDATE web_tender_category SET link_temp_id = ?, app_rej_action_on = ?, app_reject = ? WHERE t_cat_id = ?";
                // $success = simplefetchUA($updatetndrcat, "isii", [$_SESSION['userid'], date('Y-m-d H:i:s'), 2, $tcatid]);

            break;
            
            case 4:#approve request
                $FielArr=array(
                    'app_rej_user_id'=>$_SESSION['userid'],
                    'app_rej_action_on' => date('Y-m-d H:i:s'),
                    'app_reject'=>1
                );
                
                //$success=$obj->update("web_tender_category",$Fields,$Values,"t_cat_id=$_REQUEST[t_cat_id]");
                $tcatid = $_REQUEST['t_cat_id'];

                $success = update("web_tender_category", $FielArr, "t_cat_id = $tcatid", 1 );

                // $updatetndrcat = "UPDATE web_tender_category SET link_temp_id = ?, app_rej_action_on = CURRENT_TIMESTAMP, app_reject = ? WHERE t_cat_id = ?";
                // $success = simplefetchUA($updatetndrcat, "iii", [$_SESSION['userid'], 1, $tcatid]);
                
            break;
        }
    }
if($success)
    $result[0]=true;

//ComeHere:
echo frm_response($result);