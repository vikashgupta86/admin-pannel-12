<?php 
include '../appcode/globals.inc.php';
include_once(dirname_r(__FILE__, 1) . '/include/include.inc.php');

AjaxFilePrevent();
userAuthenticationPageLevel();

$result = array(0 => false);
$success = false;

$frmVal = array(
    "link_pubDate|text|y|10|10|Please enter/ select Valid Date!"
);

$ValiStr  = implode('|$$|', $frmVal);
$FrmError = $chk->requestcheck($ValiStr, "formNC", "div", true, true);

if ($FrmError) {
    $result[0] = false;
    $result[1] = $FrmError;
    goto ComeHere;
}

function todate($dateStr){
    if (empty($dateStr)) {
        return null;
    }
    return date('Y-m-d', strtotime($dateStr));
}

if (isset($_REQUEST['frmType'])) {

    $m_temp_id = filter_input(INPUT_POST, 'm_temp_id', FILTER_VALIDATE_INT);

    switch ($_REQUEST['frmType']) {

        case 1:

            $FielArr = array(
                'm_temp_id'    => $m_temp_id,
                'publish_date' => !empty($_REQUEST['link_pubDate']) ? todate($_REQUEST['link_pubDate']) : null,
                'publish_by'   => $_SESSION['userid']
            );

            $lid = getName(
                "web_media_temp",
                "concat(m_id,'|$$|',ifnull(main_m_temp_id,'')) as str",
                "m_temp_id=$m_temp_id"
            );

            $lid = explode('|$$|', $lid);

if (empty($lid[0])) {

    $success = insert("web_media_final", $FielArr);

} else {

    $success = update("web_media_final", $FielArr, "m_id=$lid[0]");
}

if ($success) {

    $cDate = curdatetime();

    update(
        "web_media_temp",
        [
            'publish_by' => $_SESSION['userid'],
            'publish_on' => $cDate
        ],
        "m_temp_id=$m_temp_id"
    );
}

        break;
    }
}

if ($success) {
    $result[0] = true;
}

ComeHere:
echo frm_response($result);