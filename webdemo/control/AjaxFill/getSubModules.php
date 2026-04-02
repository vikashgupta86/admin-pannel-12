<?php include '../../appcode/globals.inc.php';
require_once(dirname_r(__FILE__, 3) ."/appcode/DataTable/dataTableServer.inc.php");
AjaxFilePrevent();
userAuthenticationPageLevel();
$data = array();
$LimitQry=$sspObj->limit($_GET);

$rs = simplefetch("select sm.sub_module_id,m.module_name,sm.sub_module_name,sm.fa_icon,sm.sub_module_page from web_st_sub_module sm
INNER JOIN web_st_module m on m.module_id=sm.module_id where m.status='Active' and sm.status='Active' $LimitQry order by m.module_name");
if ($rs[0] > 0) {
	$sNo = (!empty($_REQUEST['start'])) ? intval($_REQUEST['start']) : '0';
	foreach ($rs[1] as $row) {
		$data[] = array(++$sNo,
			$row['module_name'],
			$row['sub_module_name'],
			#$row['sub_module_page'],
			"<div class=\"tools\">
                <i class=\"fa fa-edit btn btn-primary btn-sm\" data-submodid='$row[sub_module_id]'></i>
                <i class=\"fa fa-trash-o btn btn-primary btn-sm\" data-submodid='$row[sub_module_id]'></i>
            </div>",
		);
	}
}

$recordsTotal = getNameQry("select count(sm.sub_module_id)as ct from web_st_sub_module sm
INNER JOIN web_st_module m on m.module_id=sm.module_id");
$recordsFiltered = getNameQry("select  count(sm.sub_module_id)as ct from web_st_sub_module sm
INNER JOIN web_st_module m on m.module_id=sm.module_id");

$resData = array(
	"draw" => isset($request['draw']) ? intval($request['draw']) : 0,
	"recordsTotal" => intval($recordsTotal),
	"recordsFiltered" => intval($recordsFiltered),
	"data" => $data,
);
echo json_encode($resData);
?>