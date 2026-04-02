<?php 
include '../../appcode/globals.inc.php';
require_once(dirname_r(__FILE__, 3) ."/appcode/DataTable/dataTableServer.inc.php");

AjaxFilePrevent();
userAuthenticationPageLevel();

$data = array();

$LimitQry = $sspObj->limit($_GET);

$usr_session='';
if($_SESSION['user_type']=='20'){
     $usr_session=" AND (pc.entry_by='".$_SESSION['userid']."')";
}
$yrid = $_REQUEST['year_id'] ?? '';
$prid = $_REQUEST['prog_id'] ?? '';

if(!empty($prid))
{
    $rs = simplefetch("SELECT dpcat.prog_name, pc.prog_data_id, pc.attribute_name, pc.attribute_name_hin, pc.value_type, pc.value_type_hin, pc.value, pc.entry_date FROM web_dash_prog_data pc INNER JOIN web_dash_prog dpcat ON dpcat.prog_id = pc.prog_id WHERE pc.status='Active' AND pc.prog_id = ".$prid." AND pc.year_id = ".$yrid." ORDER BY pc.prog_data_id DESC $LimitQry ");
}
else
{
    $rs = simplefetch("SELECT dpcat.prog_name, pc.prog_data_id, pc.attribute_name, pc.attribute_name_hin, pc.value_type, pc.value_type_hin, pc.value, pc.entry_date FROM web_dash_prog_data pc INNER JOIN web_dash_prog dpcat ON dpcat.prog_id = pc.prog_id WHERE pc.status='Active' AND pc.year_id = ".$yrid." ORDER BY pc.prog_data_id DESC $LimitQry ");
} 


//$rs = simplefetch("SELECT dpcat.prog_name, pc.prog_data_id, pc.attribute_name, pc.attribute_name_hin, pc.value_type, pc.value_type_hin, pc.value, concat(wu.user_name,' [',date_format(pc.entry_date,'%d/%m/%Y'),' ]') as cName FROM web_dash_prog_data pc INNER JOIN web_users wu ON wu.user_id = pc.entry_by INNER JOIN web_dash_prog dpcat ON dpcat.prog_id = pc.prog_id WHERE pc.status='Active' ORDER BY pc.prog_data_id DESC $LimitQry ");
if($rs[0]>0){

    $sNo = (!empty($_REQUEST['start'])) ? intval($_REQUEST['start']) : 0;

    foreach($rs[1] as $row){

        $data[] = array(
            ++$sNo,
            html_entity_decode($row['prog_name']),        // Category Name
            html_entity_decode($row['attribute_name']),   // Program Name
            html_entity_decode($row['value_type']),       // Value Type
            html_entity_decode($row['value']),            // Value
            $row['entry_date'],                                // Created By/On

            "<div class=\"text-center tools\">
                <i class=\"fa fa-edit\" cdata-frmT='2' data-prog_data_id='{$row['prog_data_id']}' title='Modify Details'></i>
                <i class=\"fa fa-trash-o\" cdata-frmT='3' data-prog_data_id='{$row['prog_data_id']}' title='Delete Category'></i>
            </div>"
        );

    }
}

$recordsTotal = getNameQry("SELECT count(wu.user_id) FROM web_users wu
INNER JOIN web_st_user_type ut on ut.user_type_id=wu.user_type_id
where wu.status='Active' and wu.user_id!=1");

$recordsFiltered = $recordsTotal;

$resData = array(
    "draw" => isset($_REQUEST['draw']) ? intval($_REQUEST['draw']) : 0,
    "recordsTotal" => intval($recordsTotal),
    "recordsFiltered" => intval($recordsFiltered),
    "data" => $data
);

echo frm_response($resData,true,false);