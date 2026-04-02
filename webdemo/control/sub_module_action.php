<?php 
include '../appcode/globals.inc.php';
include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');

AjaxFilePrevent();
userAuthenticationPageLevel();

$result = array(0 => false);

if(in_array($_REQUEST['frmType'],array(1,2))){

    $frmVal=array(
        "module_id|text|y|1|10|num|dontselect=-1|Please enter Valid option!",
        "sm_name|text|y|1|50|alnum_spc|Please enter Valid Module Name!",
        "submodule_page|text|y|1|250|alnum_spc|Please enter Valid page Name!",
        "fa_ico_name|text|n|1|25|alnum_spc|Please enter Valid Icon Name!"
    );    

    $ValiStr=implode('|$$|',$frmVal);
    $FrmError=$chk->requestcheck($ValiStr,"formNC","div",true);

    if($FrmError){
        $result[1]=$FrmError;
        echo frm_response($result);
        exit;
    }
}

if(isset($_REQUEST['frmType'])){

    switch($_REQUEST['frmType']){

        case 1:

            $sm_name = $_REQUEST['sm_name'] ?? '';

            $ChkModule = getNameQry("select sub_module_id from web_st_sub_module where status='Active' and lower(trim(sub_module_name))=lower(trim('$sm_name'))");

            if(!empty($ChkModule)){
                $result[2]=array(true,'Requested sub module already exist!','alert-info');
                echo frm_response($result);
                exit;
            }

            $per_types = $_REQUEST['per_types'] ?? [];
            $per_type_id = implode(',', $per_types);

            $module_id = $_REQUEST['module_id'] ?? '';
            $fa_ico_name = $_REQUEST['fa_ico_name'] ?? '';
            $submodule_page = $_REQUEST['submodule_page'] ?? '';

$insertData = [
    'module_id'       => $module_id,
    'sub_module_name' => $sm_name,
    'fa_icon'         => $fa_ico_name,
    'sub_module_page' => $submodule_page,
    'per_type_id'     => $per_type_id
];

$success = insert("web_st_sub_module", $insertData);


        break;


        case 2:

            $sub_module_id = $_REQUEST['sub_module_id'] ?? 0;
            $sm_name = $_REQUEST['sm_name'] ?? '';

            $ChkModule = getNameQry("select module_id from web_st_sub_module where status='Active' and sub_module_id!=$sub_module_id and lower(trim(sub_module_name))=lower(trim('$sm_name'))");

            if(!empty($ChkModule)){
                $result[2]=array(true,'Requested sub module already exist!','alert-info');
                echo frm_response($result);
                exit;
            }

            $per_types = $_REQUEST['per_types'] ?? [];
            $per_type_id = implode(',', $per_types);

            $module_id = $_REQUEST['module_id'] ?? '';
            $fa_ico_name = $_REQUEST['fa_ico_name'] ?? '';
            $submodule_page = $_REQUEST['submodule_page'] ?? '';
$updateData = [
    'module_id'       => $module_id,
    'sub_module_name' => $sm_name,
    'fa_icon'         => $fa_ico_name,
    'sub_module_page' => $submodule_page,
    'per_type_id'     => $per_type_id
];

$success = update(
    "web_st_sub_module",
    $updateData,
    "sub_module_id=$sub_module_id"
);

        break;


        case 3:

            $sub_module_id = $_REQUEST['sub_module_id'] ?? 0;

            $success = delete(
                "web_st_sub_module",
                "sub_module_id=$sub_module_id"
            );

        break;
    }

    if(isset($success) && $success){
        $result[0]=true;
    }
}

echo frm_response($result);
?>