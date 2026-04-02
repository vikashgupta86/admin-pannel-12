<?php include '../appcode/globals.inc.php';
include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');
AjaxFilePrevent();
userAuthenticationPageLevel();
$result=array(0=>false);

$frmVal=array(
    "lid|text|y|1|10|num|Please enter Valid value!",
    #"chk|checkbox|y|1|2|selmin=1|Please Select atleast One Checkbox to Proceed.."
);    
// $ValiStr=implode('|$$|',$frmVal);
// $FrmError=$chk->requestcheck($ValiStr,"frmmain","div",true);
// if($FrmError[0]){    
//     $result[0]=false;
//     $result[1]=$FrmError;    
//     goto ComeHere;        
// }

$queries = '';
$subQry = '';

if (isset($_REQUEST['chk']) && is_array($_REQUEST['chk']) && count($_REQUEST['chk']) > 0) {
    $str = implode(',', $_REQUEST['chk']);
    $subQry = " and m_cat_id not in($str)";
}

$lid = isset($_REQUEST['lid']) ? (int)$_REQUEST['lid'] : 0;

// $queries .= "update web_link_map_media set status='Deleted' where status='Active' and lid=$_REQUEST[lid] $subQry|$$|";

$queries .= "update web_link_map_media set status='Deleted' where status='Active' and lid=$lid $subQry|$$|";

// if(count($_REQUEST['chk'])>0)
// {                            
//     foreach($_REQUEST['chk'] as $k=>$val)
//     {
//         $queries.="insert into web_link_map_media (lid,m_cat_id,entry_by,entry_date,ip_addr) select $_REQUEST[lid],$val,$_SESSION[userid],Now(),'$_SERVER[REMOTE_ADDR]' from web_link_map_media where status='Active' and lid=$_REQUEST[lid] and m_cat_id=$val having count(*)=0|$$|";
//     }                            
// }

if (isset($_REQUEST['chk']) && is_array($_REQUEST['chk']) && count($_REQUEST['chk']) > 0) {
    foreach ($_REQUEST['chk'] as $val) {
        $val = (int)$val;

        $queries .= "insert into web_link_map_media (lid, m_cat_id, entry_by, entry_date, ip_addr) select $lid, $val, $_SESSION[userid], CURRENT_TIMESTAMP, '$_SERVER[REMOTE_ADDR]'
            from web_link_map_media 
            where status='Active' and lid=$lid and m_cat_id=$val 
            having count(*)=0|$$|";
    }
}


//die($query);
$success=batch_execute($queries);
if($success)
    $result[0]=true;

//ComeHere:
echo frm_response($result);
?>