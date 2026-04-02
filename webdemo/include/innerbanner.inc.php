<?php

$header_name  = '';
$header_image = 'innerpage_header.jpg';

try {


    $ls_id = isset($_GET['ls_id']) ? (int)$_GET['ls_id'] : 0;
    $lid   = isset($_GET['lid']) ? (int)$_GET['lid'] : 0;
    $level = isset($_GET['level']) ? (int)$_GET['level'] : null;

    if ($ls_id <= 0 || $lid <= 0) {
        header('Location: index.php');
        exit;
    }

    $lang = $_SESSION['lang'] ?? '1';
    $idColumn = ($lang === '3') ? 'marati_id' : 'hindi_id';

    $archMode   = (isset($_GET['arch']) && $_GET['arch'] == '1');
    $showArch   = (isset($_GET['sh_arch']) && $_GET['sh_arch'] == '1');

    $archCondition = $archMode
        ? "AND (lf1.expiry_date IS NULL OR CONCAT(lf1.expiry_date,' ',IFNULL(lf1.expiry_time,'00:00:00')) <= CURRENT_TIMESTAMP())"
        : "AND (lf1.expiry_date IS NULL OR CONCAT(lf1.expiry_date,' ',IFNULL(lf1.expiry_time,'00:00:00')) > CURRENT_TIMESTAMP())";

    $subCondition = is_null($level)
        ? "AND ls.link_level IS NULL"
        : "AND ls.link_level = ?";

    $subCondition .= $showArch
        ? " AND (lf.expiry_date IS NULL OR lf.expiry_date <= CURRENT_DATE())"
        : " AND (lf.expiry_date IS NULL OR CONCAT(lf.expiry_date,' ',IFNULL(lf.expiry_time,'00:00:00')) > CURRENT_TIMESTAMP())";


    $conn = db_connect();

    $sql = "
        SELECT
            lt.link_name,
            h.link_name AS hindi_name,
            lt.header_img
        FROM web_links_final lf
        INNER JOIN web_link_temp lt
            ON lt.link_temp_id = lf.link_temp_id
        INNER JOIN web_links_structure ls
            ON ls.lid = lf.lid
        LEFT JOIN web_links_final hf
            ON hf.lid = lf.$idColumn
        LEFT JOIN web_link_temp h
            ON h.link_temp_id = hf.link_temp_id
        WHERE
            lf.status='Active'
            AND lt.status='Active'
            AND ls.status='Active'
            AND lt.type_id=3
            AND lt.lang_id=1
            AND lf.lid=?
            AND ls.ls_id=?
            $subCondition
        LIMIT 1
    ";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception('Query prepare failed');
    }

    if (is_null($level)) {
        $stmt->bind_param("ii", $lid, $ls_id);
    } else {
        $stmt->bind_param("iii", $lid, $ls_id, $level);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {

        $row = $result->fetch_assoc();

        $header_name = html_entity_decode(
            ($lang === '1')
                ? ($row['link_name'] ?? '')
                : ($row['hindi_name'] ?? '')
        );

        if (!empty($row['header_img'])) {
            $header_image = basename($row['header_img']);
        }
    }

} catch (Throwable $e) {

    error_log($e->getMessage());

    header('Location: index.php');
    exit;
}
?>

<div class="heading_bannertop"
     id="dvContents1"
     style="background-image:url('WriteReadData/HD87168/<?php echo htmlspecialchars($header_image); ?>')">

    <?php echo htmlspecialchars($header_name); ?>

</div>
