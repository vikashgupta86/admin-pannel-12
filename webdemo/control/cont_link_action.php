<?php
include '../appcode/globals.inc.php';
include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');

AjaxFilePrevent();
userAuthenticationPageLevel();

$result=array(0=>false);
$cDate=curdatetime();

do {

    

    

    //rtfPathManage($_REQUEST['textarea2']);

    if(isset($_REQUEST['frmType'])){
        switch($_REQUEST['frmType']){

            case 1:
                $ChkLink=getNameQry("select link_temp_id from web_link_temp where status='Active' and app_reject is null  and main_link_temp_id=$_REQUEST[lid] and continuous_content=1");
                if(!empty($ChkLink)){
                    $result[2]=array(true,'Unpublished link already exist!','alert-info');
                    break 2;                                                        
                }

                $FielArr=array(
                    'lang_id'=>$_REQUEST['lang_id'],
                    'type_id'=>3,
                    'continuous_content'=>1,
                    'main_link_temp_id'=>$_REQUEST['lid'],
                    'details'=>$_REQUEST['textarea2'],
                    'creator_id'=>$_SESSION['userid'],
                    'creation_date'=> date('Y-m-d H:i:s'),
                );            
                // $Fields=implode(',',array_keys($FielArr));
                // $Values=implode("|$$|",$FielArr);

              //  $success=insert("web_link_temp",$Fields,$Values);

                $insertRes = insert("web_link_temp", $FielArr, 1);
                $success = ($insertRes !== false);

            break;

            case 2:

                $FielArr=array(                    
                    'details'=>$_REQUEST['textarea2']
                );

                $ChkLink=getNameQry("select link_temp_id from web_link_temp where status='Active' and app_reject is null and link_temp_id!=$_REQUEST[link_temp_id] and main_link_temp_id=$_REQUEST[lid] and continuous_content=1");
                if(!empty($ChkLink)){
                    $result[2]=array(true,'Unpublished link already exist!','alert-info');
                    break 2;                                                        
                }

                $ChkPub=simplefetch("SELECT lc.lc_id,wlt.link_temp_id,wlt.file_name from web_link_temp wlt
                INNER JOIN web_links_continuous lc on lc.link_temp_id=wlt.link_temp_id
                WHERE wlt.`status`='Active' and wlt.link_temp_id=$_REQUEST[link_temp_id] and wlt.main_link_temp_id=$_REQUEST[lid] and wlt.continuous_content=1");

                if($ChkPub[0]<=0){
                   

                   // $success=update("web_link_temp",$Fields,$Values,"link_temp_id=$_REQUEST[link_temp_id] and main_link_temp_id=$_REQUEST[lid] and continuous_content=1");

                    $updatetndrcat = "UPDATE web_link_temp SET details = ? WHERE link_temp_id = ? AND main_link_temp_id = ? AND continuous_content = ?";

                    $success = simplefetchUA($updatetndrcat, "siii", [$_REQUEST['textarea2'], $_REQUEST['link_temp_id'], $_REQUEST['lid'] , 1]);
                }
                else{
                    $FielArr=array_merge($FielArr,array(
                        'lang_id'=>$_REQUEST['lang_id'],
                        'type_id'=>3,
                        'continuous_content'=>1,
                        'main_link_temp_id'=>$_REQUEST['lid'],                        
                        'creator_id'=>$_SESSION['userid'],
                        'creation_date'=>$cDate,
                        'lid'=>$ChkPub[1][0]['lc_id'],
                    ));

                  //  $success=insert("web_link_temp",$Fields,$Values);

                    $insertRes = insert("web_link_temp", $FielArr, 1);
                    $success = ($insertRes !== false);
                }

                if($success){
                    $RevID=getName("web_link_revive","revive_id","link_temp_id=$_REQUEST[link_temp_id] and revive_status=1");
                    if(!empty($RevID))
                    {
                       // update("web_link_revive","revive_status|$$|revived_by|$$|revived_on","2|$$|$_SESSION[userid]|$$|$cDate","revive_id=$RevID and revive_status=1 and link_temp_id=$_REQUEST[link_temp_id]");

                        $updatetndrcat = "UPDATE web_link_revive SET revive_status = ?, revived_by = ?, revived_on = CURRENT_TIMESTAMP  WHERE revive_id = ? AND revive_status = ? AND link_temp_id = ?";

                        $success = simplefetchUA($updatetndrcat, "iiiii", [2, $_SESSION['userid'], $RevID, 1, $_REQUEST['link_temp_id'] , 1]);
                    }
                }

            break;

            case 3:
                $success=delete("web_link_temp","link_temp_id=$_REQUEST[link_temp_id] and main_link_temp_id=$_REQUEST[lid] and continuous_content=1");
            break;
        }
    }

    if($success)
        $result[0]=true;

} while(false);

echo frm_response($result);
?>