<?php include '../appcode/globals.inc.php';
include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');
AjaxFilePrevent();
userAuthenticationPageLevel();
$result=array(0=>false);
// if(isset($_REQUEST['frmType'])&& $_REQUEST['frmType']==1){
//     $frmVal=array(        
//         "r_details|textarea|y|1|2000|alnum_spc|Please enter Valid data!"
//     );
//     $ValiStr=implode('|$$|',$frmVal);
//     $FrmError=requestcheck($ValiStr,"formNC","div",true,true);
//     if($FrmError[0]){
//         $result[0]=false;
//         $result[1]=$FrmError;
//         goto ComeHere;        
//     }
// }

if(isset($_REQUEST['frmType'])){
    switch($_REQUEST['frmType']){
        case 1:#for add revive case
            /*$ChkModule=getNameQry("select link_temp_id from web_link_temp where status='Active' and trim(lower(link_name))=trim(lower('$_REQUEST[l_name]'))");
            if(!empty($ChkModule)){
                $result[2]=array(true,'Requested Link Name already exist!','alert-info');
                goto ComeHere;                                                        
            }*/
            $FielArr=array(
                'link_temp_id' => $_REQUEST['link_temp_id'],                               
                'revive_by' => $_SESSION['userid'],
                'revive_on'=> date('Y-m-d H:i:s'),
                'revive_details' => $_REQUEST['r_details']
            );
            
            // $Fields=implode(',',array_keys($FielArr));
            // $Values=implode("|$$|",$FielArr);
            
            //$success=insert("web_link_revive",$Fields,$Values,"link_temp_id=$_REQUEST[link_temp_id]");

            $ltmpid = $_REQUEST['link_temp_id'];
            $usri = $_SESSION['userid'];
            $rdetail = $_REQUEST['r_details'];

            $tndrcat = "INSERT INTO web_link_revive (link_temp_id, revive_by, revive_on, revive_details) VALUES (?, ?, '1970-01-01 00:00:00', ?)";
            $success = simplefetchUA($tndrcat, "iiss", [$ltmpid, $usri, date('Y-m-d H:i:s'), $rdetail]);


        break;
        
        case 3:#reject request
            /*$ChkModule=getNameQry("select link_temp_id from web_link_temp where status='Active' and link_temp_id!=$_REQUEST[link_temp_id] and lower(trim(link_name))=lower(trim('$_REQUEST[l_name]'))");
            if(!empty($ChkModule)){
                $result[2]=array(true,'Requested module already exist!','alert-info');
                goto ComeHere;                                                        
            }*/
            
            // $FielArr=array(
            //     'app_rej_user_id'=>$_SESSION['userid'],
            //     'app_rej_action_on'=>curdatetime(),
            //     'app_reject'=>2
            // );
            
            // $Fields=implode('|$$|',array_keys($FielArr));
            // $Values=implode("|$$|",$FielArr);
            
            //$success=update("web_link_temp",$Fields,$Values,"link_temp_id=$_REQUEST[link_temp_id]");

            $updatetndrcat = "UPDATE web_link_temp SET app_rej_user_id = ?, app_rej_action_on = CURRENT_TIMESTAMP, app_reject = ? WHERE link_temp_id = ?";

            $success = simplefetchUA($updatetndrcat, "iii", [$_SESSION['userid'], 2 , $_REQUEST['link_temp_id']]);


        break;
        
        case 4:#approve request
            // $FielArr=array(
            //     'app_rej_user_id'=>$_SESSION['userid'],
            //     'app_rej_action_on'=>curdatetime(),
            //     'app_reject'=>1
            // );
            
            // $Fields=implode('|$$|',array_keys($FielArr));
            // $Values=implode("|$$|",$FielArr);
            
            //$success=update("web_link_temp",$Fields,$Values,"link_temp_id=$_REQUEST[link_temp_id]");

            $updatetndrcat = "UPDATE web_link_temp SET app_rej_user_id = ?, app_rej_action_on = CURRENT_TIMESTAMP, app_reject = ? WHERE link_temp_id = ?";

            $success = simplefetchUA($updatetndrcat, "iii", [$_SESSION['userid'], 1 , $_REQUEST['link_temp_id']]);
        break;
    }
}

if($success)
    $result[0]=true;

//ComeHere:
echo frm_response($result);
?>