<?php

$conn = db_connect();

$lang = $_SESSION['lang'] ?? '1';
if (!in_array($lang, ['1','2','3'], true)) {
    $lang = '1';
}

$lid   = isset($_GET['lid'])   ? (int)$_GET['lid']   : 0;
$ls_id = isset($_GET['ls_id']) ? (int)$_GET['ls_id'] : 0;
$level = isset($_GET['level']) ? (int)$_GET['level'] : 0;
$l_show = isset($_GET['l_show']) ? (int)$_GET['l_show'] : 0;
$d_show = isset($_GET['d_show']) ? (int)$_GET['d_show'] : 0;
$arch   = isset($_GET['arch'])   ? (int)$_GET['arch']   : 0;
$sh_arch = isset($_GET['sh_arch']) ? (int)$_GET['sh_arch'] : 0;

if ($lid <= 0) {
    header('Location: index.php');
    exit;
}


if ($l_show === 1 || $d_show === 1) {

    $sql = "
        SELECT
            lt.author_name,
            DATE_FORMAT(lt.pub_date,'%d %M %Y') AS pub_date,
            DATE_FORMAT(lf.publish_date,'%M %d, %Y') AS publish_date,
            lf.show_content,
            lf.feedback_required,
            lt.feed_req,
            lt.lang_id,
            lf.icon_name,
            CASE WHEN lt.type_id!=3 THEN 'target=\"_blank\"' ELSE '' END AS l_target,
            CASE
                WHEN lt.type_id=1 THEN 'showfile.php'
                WHEN lt.type_id=2 THEN 'showlink.php'
                ELSE ''
            END AS lfile,
            lf.lid,
            lt.link_name,
            lt.title,
            lt.type_id,
            lt.file_name,
            lt.details
        FROM web_links_final lf
        INNER JOIN web_link_temp lt
            ON lt.link_temp_id = lf.link_temp_id
        WHERE
            lf.status='Active'
            AND lt.status='Active'
            AND lf.lid = ?
    ";

    if ($l_show === 1) {
        $sql .= " AND lt.type_id = 3 AND lt.lang_id = ?";
    } else {
        $sql .= " AND lt.lang_id = ?";
    }

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $lid, $lang);
    $stmt->execute();
    $result = $stmt->get_result();

    $rs = [
        $result->num_rows,
        $result->fetch_all(MYSQLI_ASSOC)
    ];

} else {


    if ($ls_id <= 0) {
        header('Location: index.php');
        exit;
    }

    $archiveCondition = $arch === 1
        ? "AND (lf.expiry_date IS NULL OR lf.expiry_date <= CURRENT_DATE())"
        : "AND (lf.expiry_date IS NULL OR lf.expiry_date > CURRENT_DATE())";

    $levelCondition = ($level <= 0)
        ? "AND ls.link_level IS NULL"
        : "AND ls.link_level = ?";

    $sql = "
        SELECT
            lt.author_name,
            DATE_FORMAT(lt.pub_date,'%d %M %Y') AS pub_date,
            DATE_FORMAT(lf.publish_date,'%M %d, %Y') AS publish_date,
            lf.show_content,
            lf.feedback_required,
            lt.feed_req,
            lt.lang_id,
            lf.icon_name,
            COALESCE(ls.link_level,0) AS link_level,
            lf.lid,
            ls.ls_id,
            ls.parent_ls_id,
            lt.link_name,
            lt.title,
            lt.link_bdesc,
            lt.type_id,
            lt.file_name,
            lt.details
        FROM web_links_final lf
        INNER JOIN web_link_temp lt
            ON lt.link_temp_id = lf.link_temp_id
        INNER JOIN web_links_structure ls
            ON ls.lid = lf.lid
        WHERE
            lf.status='Active'
            AND lt.status='Active'
            AND ls.status='Active'
            AND lf.lid = ?
            AND ls.ls_id = ?
            AND lt.type_id = 3
            AND lt.lang_id = 1
            $levelCondition
            $archiveCondition
    ";

    if ($level <= 0) {
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $lid, $ls_id);
    } else {
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $lid, $ls_id, $level);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    $rs = [
        $result->num_rows,
        $result->fetch_all(MYSQLI_ASSOC)
    ];
}
?>
