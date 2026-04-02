<?php include '../../appcode/globals.inc.php';
require_once(dirname_r(__FILE__, 3) ."/appcode/DataTable/dataTableServer.inc.php");
AjaxFilePrevent();
userAuthenticationPageLevel();
$data = array();
#echo '<pre>';print_r($_REQUEST);
$LimitQry = $sspObj->limit($_GET);

$userTypeId = intval($_REQUEST['user_type_id'] ?? 0);

$rs = simplefetch("select ut.user_type,wu.user_id,concat(uf.f_name,' ', ifnull(uf.m_name,''),' ', ifnull(uf.l_name,''))as user_name,wu.my_val,uf.f_name,uf.addr,uf.mobile,wu.current_status, wu.uname from web_users wu
INNER JOIN web_st_user_type ut on ut.user_type_id=wu.user_type_id
INNER JOIN web_users_profile uf on uf.user_id=wu.user_id
 where wu.status='Active' and wu.user_id!=1 and wu.user_type_id=$userTypeId $LimitQry");
if ($rs[0] > 0) {
	$sNo = (!empty($_REQUEST['start'])) ? intval($_REQUEST['start']) : '0';
	foreach ($rs[1] as $row) {
		if ($row['current_status'] == 'Pending') {
			$cStatus = "<span class='text-info'><strong>Pending</strong></span>";
			$Links = "<i class=\"fa fa-check\" cdata-frmT='7' data-uid='$row[user_id]' title='Approve'></i>
			<i class=\"fa fa-ban\" cdata-frmT='8' data-uid='$row[user_id]' title='Reject'></i>";
		} elseif ($row['current_status'] == 'Active') {
			$cStatus = "<span class='text-success'><strong>Active</strong></span>";
			$Links = "<i class=\"fa fa-eye-slash btn btn-primary btn-xs\" cdata-frmT='5' data-uid='$row[user_id]' title='Inactive User'></i>
                <i class=\"fa fa-retweet btn btn-primary btn-xs\" cdata-frmT='4' data-uid='$row[user_id]' title='Reset Password'></i>
                <i class=\"fa fa-edit btn btn-primary btn-xs\" cdata-frmT='2' data-uid='$row[user_id]' title='Modify Details'></i>
                <i class=\"fa fa-trash btn btn-primary btn-xs\" cdata-frmT='3' data-uid='$row[user_id]' title='Delete User'></i>";
		} elseif ($row['current_status'] == 'Rejected') {
			$cStatus = "<span class='text-primary'><strong>Rejected</strong></span>";
			$Links = '---';
		} else {
			$cStatus = "<span class='text-primary'><strong>Inactive</strong></span>";
			$Links = "<i class=\"fa fa-eye\" cdata-frmT='6' data-uid='$row[user_id]' title='Re-activate User'></i>";
		}
		$data[] = array(++$sNo,
			$row['user_type'],
			$row['user_name'],
			$row['addr'],
			$row['mobile'],
			$row['uname'],
			#$row['my_val'],
			$cStatus,
			"<div class=\"text-center tools\">
                $Links
            </div>",
		);
	}
}

$recordsTotal = getNameQry("select count(wu.user_id)  from web_users wu
INNER JOIN web_st_user_type ut on ut.user_type_id=wu.user_type_id
 where wu.status='Active' and wu.user_id!=1");
$recordsFiltered = getNameQry("select count(wu.user_id)  from web_users wu
INNER JOIN web_st_user_type ut on ut.user_type_id=wu.user_type_id
 where wu.status='Active' and wu.user_id!=1");

$resData = array(
	"draw" => isset($_REQUEST['draw']) ? intval($_REQUEST['draw']) : 0,
	"recordsTotal" => intval($recordsTotal),
	"recordsFiltered" => intval($recordsFiltered),
	"data" => $data,
);
echo frm_response($resData, true, false);