<?php include '../appcode/globals.inc.php';
include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');
AjaxFilePrevent();
userAuthenticationPageLevel();
$result=array(0=>false);

    $frmVal=array( 
        "m_temp_id|text|y|1|10|num|Please enter Valid option!"
    );
    
    $ValiStr=implode('|$$|',$frmVal);
    $FrmError=$chk->requestcheck($ValiStr,"formNC","div",true,true);
    var_dump($FrmError);
    if($FrmError[false]){
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
                
                // $Fields=implode('|$$|',array_keys($FielArr));
                // $Values=implode("|$$|",$FielArr);
                
              //  $success=$obj->update("web_media_temp",$Fields,$Values,"m_temp_id=$_REQUEST[m_temp_id]");

                $m_temp_id = (int)$_REQUEST['m_temp_id'];
                $success = update("web_media_temp", $FielArr, "m_temp_id = $m_temp_id", 1 );

            break;
            
            case 4:#approve request
                $FielArr=array(
                    'app_rej_user_id'=>$_SESSION['userid'],
                    'app_rej_action_on'=> date('Y-m-d H:i:s'),
                    'app_reject'=>1
                );
                
                // $Fields=implode('|$$|',array_keys($FielArr));
                // $Values=implode("|$$|",$FielArr);
                
               // $success=$obj->update("web_media_temp",$Fields,$Values,"m_temp_id=$_REQUEST[m_temp_id]");

                $m_temp_id = (int)$_REQUEST['m_temp_id'];
                $success = update("web_media_temp", $FielArr, "m_temp_id = $m_temp_id", 1 );
            break;
        }
    }

if($success)
$result[0]=true;

//ComeHere:
echo frm_response($result);