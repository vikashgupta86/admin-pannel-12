<?php 
include '../appcode/globals.inc.php';
include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');
AjaxFilePrevent();
userAuthenticationPageLevel();

$result = array(0 => false);
$success = false;

// if(in_array($_REQUEST['frmType'],array(1,2))){
//     $frmVal=array(
//         "m_name|text|y|1|50|alnum_spc|Please enter Valid Module Name!",
//         "fa_ico_name|text|n|1|25|alnum_spc|Please enter Valid Icon Name!"
//     );    
//    // $ValiStr=implode('|$$|',$frmVal);
//     $FrmError = $chk->requestcheck($ValiStr,"formNC","div",true);
//     if($FrmError[0]){
//         $result[0]=false;
//         $result[1]=$FrmError;
//         echo frm_response($result);
//         exit;
//     }    
// }


if(isset($_REQUEST['frmType'])){

    switch($_REQUEST['frmType']){

        case 1:

            $ChkModule=getNameQry("select module_id from web_st_module where status='Active' and lower(trim(module_name))=lower(trim('$_REQUEST[m_name]'))");

            if(!empty($ChkModule)){
                $result[2]=array(true,'Requested module already exist!','alert-info');
                echo frm_response($result);
                exit;
            }

            $FielArr = array(
                'module_name' => $_REQUEST['m_name'],
                'fa_name' => $_REQUEST['fa_ico_name'],
                'entry_by' => $_SESSION['userid'],
                'entry_date' => date('Y-m-d H:i:s'),
            );

            //var_dump($FielArr);

            $insertRes = insert("web_st_module", $FielArr, 1);
            $success = ($insertRes !== false);

        break;

        case 2:

            $ChkModule = getNameQry("select module_id from web_st_module where status='Active' and module_id!=$_REQUEST[module_id] and lower(trim(module_name))=lower(trim('$_REQUEST[m_name]'))");

            if(!empty($ChkModule)){
                $result[2]=array(true,'Requested module already exist!','alert-info');
                echo frm_response($result);
                exit;
            }

            $success=update(
                "web_st_module",
                "module_name|$$|fa_icon",
                "$_REQUEST[m_name]|$$|$_REQUEST[fa_ico_name]",
                "module_id=$_REQUEST[module_id]"
            );

        break;

        case 3:

            $success=delete("web_st_module","module_id=$_REQUEST[module_id]");

        break;
    }

    if(!empty($success))
        $result[0]=true;
}

echo frm_response($result);
?>