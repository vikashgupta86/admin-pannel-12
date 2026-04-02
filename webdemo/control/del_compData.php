<?php include '../appcode/globals.inc.php';
include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');
$obj->AjaxFilePrevent();
$obj->userAuthenticationPageLevel();
$result=array(0=>false);
$cDate=$obj->curdatetime();


if($_REQUEST['frmType']==3){
    
    $success=$obj->delete("comp_data","comp_data_id=$_REQUEST[comp_data_id]",1);
    //$success=$obj->update("comp_data","set status='Deleted' where comp_data_id=$_REQUEST[comp_data_id]",3);
    
    // $success=$obj->delete("web_link_temp","link_temp_id=$_REQUEST[link_temp_id]");
    // if(!empty($_REQUEST['lid']))
        // $obj->delete("web_links_final","link_temp_id=$_REQUEST[link_temp_id] and lid=$_REQUEST[lid]");

}

// print_r($success);
// exit();

if($success)
    $result[0]=$success;

ComeHere:
echo $obj->frm_response($result[0]);
?>