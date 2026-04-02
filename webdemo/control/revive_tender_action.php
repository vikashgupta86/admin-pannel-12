<?php include '../appcode/globals.inc.php';
include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');
AjaxFilePrevent();
userAuthenticationPageLevel();
$result=array(0=>false);
if(isset($_REQUEST['frmType'])&& $_REQUEST['frmType']==1){
    $frmVal=array(        
        "r_details|textarea|y|1|2000|alnum_spc|Please enter Valid data!"
    );
    $ValiStr=implode('|$$|',$frmVal);
    $FrmError=$chk->requestcheck($ValiStr,"formNC","div",true,true);
    if($FrmError){
        $result[0]=false;
        $result[1]=$FrmError;
        //goto ComeHere;        
    }
}

if(isset($_REQUEST['frmType'])){
    switch($_REQUEST['frmType']){
        case 1:#for add revive case
            /*$ChkModule=$obj->getNameQry("select link_temp_id from web_link_temp where status='Active' and trim(lower(link_name))=trim(lower('$_REQUEST[l_name]'))");
            if(!empty($ChkModule)){
                $result[2]=array(true,'Requested Link Name already exist!','alert-info');
                goto ComeHere;                                                        
            }*/
            $FielArr=array(
                't_temp_id' => $_REQUEST['t_temp_id'],                               
                'revive_by' => $_SESSION['userid'],
                'revive_on' => date('Y-m-d H:i:s'),
                'revive_details' => $_REQUEST['r_details']
            );
            
            // $Fields=implode(',',array_keys($FielArr));
            // $Values=implode("|$$|",$FielArr);
            
            //$success = insert("web_tender_revive",$Fields,$Values,"t_temp_id=$_REQUEST[t_temp_id]");
            $success = insert("web_tender_revive", $FielArr, 1);
        break;
        
        case 3:#reject request
            /*$ChkModule=$obj->getNameQry("select link_temp_id from web_link_temp where status='Active' and link_temp_id!=$_REQUEST[link_temp_id] and lower(trim(link_name))=lower(trim('$_REQUEST[l_name]'))");
            if(!empty($ChkModule)){
                $result[2]=array(true,'Requested module already exist!','alert-info');
                goto ComeHere;                                                        
            }*/
            
            $FielArr=array(
                'app_rej_user_id' => $_SESSION['userid'],
                'app_rej_action_on' => date('Y-m-d H:i:s'),
                'app_reject'=>2
            );
            
            // $Fields=implode('|$$|',array_keys($FielArr));
            // $Values=implode("|$$|",$FielArr);
            
            //$success=$obj->update("web_tender_temp",$Fields,$Values,"t_temp_id=$_REQUEST[t_temp_id]");

            $ttempid = $_REQUEST['t_temp_id'];
            $success = update("web_tender_temp", $FielArr, "t_temp_id = $ttempid", 1 );

        break;
        
        case 4:#approve request
            $FielArr=array(
                'app_rej_user_id'=>$_SESSION['userid'],
                'app_rej_action_on'=> date('Y-m-d H:i:s'),
                'app_reject'=>1
            );
            
            // $Fields=implode('|$$|',array_keys($FielArr));
            // $Values=implode("|$$|",$FielArr);
            
           // $success=$obj->update("web_tender_temp",$Fields,$Values,"t_temp_id=$_REQUEST[t_temp_id]");

            $ttempid = $_REQUEST['t_temp_id'];
            $success = update("web_tender_temp", $FielArr, "t_temp_id = $ttempid", 1 );

        break;
    }
}

if($success)
    $result[0]=true;

//ComeHere:
echo frm_response($result);
?>