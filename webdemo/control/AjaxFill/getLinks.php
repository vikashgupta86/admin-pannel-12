<?php 
include '../../appcode/globals.inc.php';

if (!isset($SQL_QUERIES)) {
    $SQL_QUERIES = [];
}

require_once(dirname_r(__FILE__, 3) ."/appcode/DataTable/dataTableServer.inc.php");

AjaxFilePrevent();
userAuthenticationPageLevel();

$data = array();
$dept_type = '';
$status_dept = '';

$department = $_SESSION['department'] ?? '';
$uid = $_SESSION['userid'];
$user_type = $_SESSION['user_type'];

$lang_id = intval($_REQUEST['lang_id'] ?? 0);
$type_id = intval($_REQUEST['type_id'] ?? 0);

if (!empty($department)) {
    $dept_type = "INNER JOIN dept_link_map dm ON wlt.link_temp_id = dm.link_temp_id";
    $status_dept = "AND dm.status='Active' 
                    AND dm.dept_id='$department' 
                    AND dm.user_id='$uid'";
}

$usr_session = '';

if (isset($_REQUEST['nmnh_type']) && $user_type != '20' && !empty($_REQUEST['nmnh_type'])) {
    $cont_type = $_REQUEST['nmnh_type'] == '-1' ? 0 : $_REQUEST['nmnh_type'];
    $usr_session .= " AND wlt.content_type='$cont_type'";
}

$usr_session .= " AND (
    wlt.creator_id = '$uid'
    OR EXISTS (
        SELECT 1
        FROM web_links_final lf2
        INNER JOIN web_links_structure wls ON wls.lid = lf2.lid
 AND wls.status = 'Active'
        INNER JOIN web_links_permission wlp 
            ON wlp.user_id = '$uid' 
            AND wlp.status = 'Active'

        LEFT JOIN web_links_structure parent 
            ON wls.parent_ls_id = parent.ls_id

        LEFT JOIN web_links_structure grandparent 
            ON parent.parent_ls_id = grandparent.ls_id

        WHERE 
            lf2.link_temp_id = wlt.link_temp_id

            AND (
                wls.ls_id = wlp.ls_id
                OR parent.ls_id = wlp.ls_id
                OR grandparent.ls_id = wlp.ls_id
            )
    )
)";

$LimitQry = $sspObj->limit($_GET);

switch ($_REQUEST['tabID']) {

    case 1:

        $rs = simplefetch("SELECT 
                            wlt.lid,
                            IFNULL(lr1.revive_details,'N/A') as revive_details,
                            wlt.link_temp_id,
                            wlt.lang_id,
                            wlt.type_id,
                            CONCAT(wlt.link_name, IFNULL(CONCAT(' (', wlt.link_alias, ')'),'')) as link_name,
                            CONCAT(wu.user_name,' [',DATE_FORMAT(wlt.creation_date,'%d/%m/%Y'),' ]') as cName,
                            IFNULL(CONCAT(lr1.user_name,' [',DATE_FORMAT(lr1.revive_on,'%d/%m/%Y'),' ]'),'N/A') as rName,
                            IFNULL(CONCAT(ru1.user_name,' [',DATE_FORMAT(wlt.app_rej_action_on,'%M %d, %Y'),' ]'),'N/A') as apName
                        FROM web_link_temp wlt
                        INNER JOIN web_users wu on wu.user_id=wlt.creator_id
                        LEFT JOIN (
                            SELECT lr.link_temp_id,lr.revive_by,lr.revive_on,lr.revive_details,ru.user_name 
                            FROM web_link_revive lr
                            INNER JOIN web_users ru on ru.user_id=lr.revive_by
                            WHERE lr.status='Active' and lr.revive_status=1
                        ) lr1 on lr1.link_temp_id=wlt.link_temp_id
                        LEFT JOIN web_users ru1 on ru1.user_id=wlt.app_rej_user_id
                        $dept_type
                        WHERE wlt.status='Active' 
                        $status_dept 
                        AND wlt.lang_id=$lang_id 
                        AND wlt.type_id=$type_id 
                        AND wlt.continuous_content=0 
                        AND wlt.app_reject IS NULL 
                        $usr_session  
                        ORDER BY wlt.link_temp_id DESC 
                        $LimitQry", 1);

        if ($rs[0] > 0) {
            $sNo = (!empty($_REQUEST['start'])) ? intval($_REQUEST['start']) : 0;

            foreach ($rs[1] as $row) {
                $data[] = array(
                    ++$sNo,
                    $row['link_name'],
                    $row['cName'],
                    $row['apName'],
                    $row['rName'],
                    $row['revive_details'],
                    "<div class=\"text-center tools\">
                        <i class=\"fa fa-eye Lpreview\" cdata-frmT='7' data-link_temp_id='$row[link_temp_id]' title='Preview'></i>
                    </div>",
                    "<div class=\"text-center tools\">
                        <i class=\"fa fa-edit\" cdata-frmT='2' pub-lid='$row[lid]' data-link_temp_id='$row[link_temp_id]' title='Modify'></i>
                        <i class=\"fas fa-trash-alt\" cdata-frmT='3' data-link_temp_id='$row[link_temp_id]' title='Delete'></i>
                    </div>"
                );
            }
        }

        $recordsTotal = getNameQry("SELECT COUNT(wlt.link_temp_id) 
            FROM web_link_temp wlt 
            $dept_type 
            WHERE wlt.status='Active' 
            $status_dept 
            AND wlt.lang_id=$lang_id 
            AND wlt.type_id=$type_id 
            AND wlt.continuous_content=0 
            AND wlt.app_reject IS NULL 
            $usr_session");

        $recordsFiltered = $recordsTotal;

    break;


    case 2:

        $rs = simplefetch("SELECT 
                            lf.lid,
                            IFNULL(DATE_FORMAT(lf.expiry_date,'%M %d, %Y'),'N/A') as expiry_date,
                            lf.expiry_time,
                            wlt.link_temp_id,
                            wlt.lang_id,
                            wlt.type_id,
                            CONCAT(wlt.link_name, IFNULL(CONCAT(' (', wlt.link_alias, ')'),'')) as link_name,
                            CONCAT(wup.f_name,' [',DATE_FORMAT(wlt.creation_date,'%d/%m/%Y'),' ]') as cName,
                            CONCAT(wup.f_name,' [',DATE_FORMAT(wlt.app_rej_action_on,'%M %d, %Y'),' ]') as rName,
                            CONCAT(wup.f_name,' [',DATE_FORMAT(lf.publish_date,'%M %d, %Y'),' ]') as pName
                        FROM web_link_temp wlt
                        INNER JOIN web_users wu on wu.user_id=wlt.creator_id
                        INNER JOIN web_users ru on ru.user_id=wlt.app_rej_user_id
                        INNER JOIN web_users_profile wup on wup.user_id=wu.user_id
                        INNER JOIN web_links_final lf on lf.link_temp_id=wlt.link_temp_id
                        INNER JOIN web_users pu on pu.user_id=lf.publish_by
                        $dept_type
                        WHERE wlt.status='Active' 
                        $status_dept 
                        AND lf.status='Active' 
                        AND wlt.lang_id=$lang_id 
                        AND wlt.type_id=$type_id 
                        AND wlt.continuous_content=0 
                        $usr_session 
                        ORDER BY wlt.link_temp_id DESC 
                        $LimitQry", 1);

        if ($rs[0] > 0) {
            $sNo = (!empty($_REQUEST['start'])) ? intval($_REQUEST['start']) : 0;

            foreach ($rs[1] as $row) {

                $buttonShow = (!empty($department)) ?
                    "<div class=\"text-center tools\">
                        <i class=\"fa fa-edit\" cdata-frmT='2' pub-lid='$row[lid]' data-link_temp_id='$row[link_temp_id]' title='Modify'></i>
                    </div>" :
                    "<div class=\"text-center tools\">
                        <i class=\"fa fa-desktop\" cdata-frmT='9' pub-lid='$row[lid]' data-link_temp_id='$row[link_temp_id]' title='Publish'></i>
                        <i class=\"fa fa-edit\" cdata-frmT='2' pub-lid='$row[lid]' data-link_temp_id='$row[link_temp_id]' title='Modify'></i>
                        <i class=\"fas fa-trash-alt\" cdata-frmT='3' pub-lid='$row[lid]' data-link_temp_id='$row[link_temp_id]' title='Delete'></i>
                    </div>";

                $data[] = array(
                    ++$sNo,
                    html_entity_decode($row['link_name']),
                    $row['cName'],
                    $row['rName'],
                    $row['pName'],
                    $row['expiry_date'].' '.$row['expiry_time'],
                    "<div class=\"text-center tools\">
                        <i class=\"fa fa-eye Lpreview\" cdata-frmT='7' data-link_temp_id='$row[link_temp_id]' title='Preview'></i>
                    </div>",
                    $buttonShow
                );
            }
        }

        $recordsTotal = getNameQry("SELECT COUNT(wlt.link_temp_id)
                        FROM web_link_temp wlt
                        INNER JOIN web_links_final lf on lf.link_temp_id=wlt.link_temp_id
                        $dept_type
                        WHERE wlt.status='Active'
                        $status_dept
                        AND lf.status='Active'
                        AND wlt.lang_id=$lang_id
                        AND wlt.type_id=$type_id
                        AND wlt.continuous_content=0
                        $usr_session");

        $recordsFiltered = $recordsTotal;

    break;


    case 3:

        $rs = simplefetch("SELECT 
                        wlt.link_temp_id,
                        wlt.lang_id,
                        wlt.type_id,
                        CONCAT(wlt.link_name, IFNULL(CONCAT(' (', wlt.link_alias, ')'),'')) as link_name,
                        CONCAT(wu.user_name,' [',DATE_FORMAT(wlt.creation_date,'%M %d, %Y'),' ]') as cName,
                        CONCAT(ru.user_name,' [',DATE_FORMAT(wlt.app_rej_action_on,'%M %d, %Y'),' ]') as rName
                    FROM web_link_temp wlt
                    INNER JOIN web_users wu on wu.user_id=wlt.creator_id
                    INNER JOIN web_users ru on ru.user_id=wlt.app_rej_user_id
                    $dept_type
                    WHERE wlt.status='Active' 
                    $status_dept 
                    AND wlt.lang_id=$lang_id 
                    AND wlt.type_id=$type_id 
                    AND wlt.continuous_content=0 
                    AND wlt.app_reject=2 
                    $usr_session  
                    ORDER BY wlt.link_temp_id DESC 
                    $LimitQry");

        if ($rs[0] > 0) {
            $sNo = (!empty($_REQUEST['start'])) ? intval($_REQUEST['start']) : 0;

            foreach ($rs[1] as $row) {
                $data[] = array(
                    ++$sNo,
                    html_entity_decode($row['link_name']),
                    $row['cName'],
                    $row['rName'],
                    "<div class=\"text-center tools\">
                        <i class=\"fa fa-eye Lpreview\" cdata-frmT='7' data-link_temp_id='$row[link_temp_id]' title='Preview'></i>
                    </div>"
                );
            }
        }

        $recordsTotal = getNameQry("SELECT COUNT(wlt.link_temp_id) 
            FROM web_link_temp wlt 
            $dept_type 
            WHERE wlt.status='Active' 
            $status_dept 
            AND wlt.lang_id=$lang_id 
            AND wlt.type_id=$type_id 
            AND wlt.continuous_content=0 
            AND wlt.app_reject=2 
            $usr_session");

        $recordsFiltered = $recordsTotal;

    break;
}


$resData = array(
    "draw" => isset($_REQUEST['draw']) ? intval($_REQUEST['draw']) : 0,
    "recordsTotal" => intval($recordsTotal),
    "recordsFiltered" => intval($recordsFiltered),
    "data" => $data
);

echo frm_response($resData, true, false);