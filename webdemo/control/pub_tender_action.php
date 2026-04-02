<?php include '../appcode/globals.inc.php';
include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');
AjaxFilePrevent();
userAuthenticationPageLevel();
$result=array(0=>false);
// if(isset($_REQUEST['frmType'])&& $_REQUEST['frmType']==1){
//     $frmVal=array(        
//         "link_pubDate|text|y|10|10|dt|Please enter/ select Valid Date!",
//         "link_expDate|text|n|10|10|dt|Please enter/ select Valid Date!",
//         "link_nrevDate|text|n|10|10|dt|Please enter/ select Valid Date!",
//     );
//     $ValiStr=implode('|$$|',$frmVal);
//     $FrmError=$chk->requestcheck($ValiStr,"formNC","div",true,true);
//     if($FrmError){
//         $result[0]=false;
//         $result[1]=$FrmError;
//         //goto ComeHere;        
//     }
// }

if(isset($_REQUEST['frmType'])){
    switch($_REQUEST['frmType']){
        case 1:
            /*$ChkModule=$obj->getNameQry("select link_temp_id from web_link_temp where status='Active' and trim(lower(link_name))=trim(lower('$_REQUEST[l_name]'))");
            if(!empty($ChkModule)){
                $result[2]=array(true,'Requested Link Name already exist!','alert-info');
                goto ComeHere;                                                        
            }*/
            $FielArr=array(
                't_temp_id'=>$_REQUEST['t_temp_id'],
              	'publish_date'=>!empty($_REQUEST['link_pubDate'])? $_REQUEST['link_pubDate']:'',                               
                'expiry_date'=>!empty($_REQUEST['link_expDate'])? $_REQUEST['link_expDate']:'',
                'next_review_date'=>!empty($_REQUEST['link_nrevDate'])? $_REQUEST['link_nrevDate']: date('Y-m-d H:i:s'),                                                
                'publish_by'=>$_SESSION['userid'],
				'publish_time'=>$_REQUEST['ptime'],
				'expiry_time'=>$_REQUEST['ctime'],
				
				               
            );
            
            
            $lid = getName("web_tender_temp","concat(t_id,'|$$|',ifnull(main_t_temp_id,''))as str","t_temp_id = ".$_REQUEST['t_temp_id']."");
            if(empty($lid[0]))
            {
                  
               // $success = insert("web_tender_final",$Fields,$Values);                
               $success = insert("web_tender_final", $FielArr, 1);

            }
            else
            {
                $ttempid = $lid[0];
                $success = update("web_tender_final", $FielArr, "t_temp_id = $ttempid", 1 );
                //$success = update("web_tender_final",$Fields,$Values,"t_id=$lid[0]");
            }
            
            if($success){
                $cDate = date('Y-m-d H:i:s');
                $ttmpid = $_REQUEST['t_temp_id'];

              //  update("web_tender_temp","publish_by|$$|publish_on","$_SESSION[userid]|$$|$cDate","t_temp_id=$_REQUEST[t_temp_id]");
                $tid = $success[0];
                $updatetndrcat = "UPDATE web_tender_temp SET t_id = ?, publish_by = ?, publish_on = ? WHERE t_temp_id = ? ";
                $success = simplefetchUA($updatetndrcat, "iisi", [$tid, $_SESSION['userid'], $cDate, $ttmpid]);
            }            
        break;
    }
}

if($success)
    $result[0]=true;

echo frm_response($result);
?>