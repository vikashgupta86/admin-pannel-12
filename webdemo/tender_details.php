<?php
declare(strict_types=1);

require './appcode/globals.inc.php';
require_once './include/website_common.inc.php';

$obj->AjaxFilePrevent();

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}


$tId   = filter_input(INPUT_GET, 't_id', FILTER_VALIDATE_INT);
$catId = filter_input(INPUT_GET, 'catid', FILTER_VALIDATE_INT);

if (!$tId) {
    exit;
}


$sql = "
SELECT 
    wtc.t_cat_id,
    tt.details,
    tt.file_name,
    tt.t_num,
    tf.t_id,
    tt.t_temp_id,
    wtc.cat_name,
    tt.tender_name,
    tf.expiry_time,
    IFNULL(DATE_FORMAT(tf.publish_date,'%M %d, %Y'),'N/A') AS publish_date,
    tf.publish_time,
    IFNULL(DATE_FORMAT(tf.expiry_date,'%M %d, %Y'),'N/A') AS expirydate,
    IFNULL(DATE_FORMAT(tt.close_date,'%M %d, %Y'),'N/A') AS close_date,
    tt.close_time,
    IFNULL(DATE_FORMAT(tt.expiry_date,'%M %d, %Y'),'N/A') AS expiry_date
FROM web_tender_temp tt
INNER JOIN web_tender_final tf ON tf.t_temp_id = tt.t_temp_id
INNER JOIN web_tender_category wtc ON wtc.t_cat_id = tt.t_cat_id
WHERE tt.status='Active'
  AND wtc.status='Active'
  AND wtc.app_reject=1
  AND tf.t_id = ?
";

$result = core_query($sql, "i", [$tId]);

if (!$result['success'] || empty($result['data'])) {
    exit;
}

$row = $result['data'][0];


$corCountSql = "
SELECT COUNT(tf.ct_id) AS tot
FROM web_tender_temp tt
INNER JOIN web_tender_corrigendum_final tf ON tf.t_temp_id = tt.t_temp_id
WHERE tt.status='Active'
  AND tf.t_id = ?
  AND tt.corrigendum = 1
";

$corCountRes = core_query($corCountSql, "i", [$tId]);
$corCount    = $corCountRes['data'][0]['tot'] ?? 0;

if ($corCount > 0) {

    $pdSql = "
    SELECT CONCAT(
        IFNULL(DATE_FORMAT(tf.publish_date,'%M %d, %Y'),'N/A'),
        ' ',
        tf.publish_time
    ) AS ed
    FROM web_tender_temp tt
    INNER JOIN web_tender_corrigendum_final tf ON tf.t_temp_id = tt.t_temp_id
    WHERE tt.status='Active'
      AND tf.t_id = ?
      AND tt.corrigendum=1
      AND CONCAT(tf.publish_date,' ',IFNULL(tf.publish_time,'00:00:00')) <= CURRENT_TIMESTAMP()
    ORDER BY tt.t_temp_id DESC
    LIMIT 1
    ";

    $pdRes = core_query($pdSql, "i", [$tId]);
    $pd    = $pdRes['data'][0]['ed'] ?? '';

    $cdSql = "
    SELECT CONCAT(
        IFNULL(DATE_FORMAT(tt.close_date,'%M %d, %Y'),'N/A'),
        ' ',
        tt.close_time
    ) AS cd
    FROM web_tender_temp tt
    INNER JOIN web_tender_corrigendum_final tf ON tf.t_temp_id = tt.t_temp_id
    WHERE tt.status='Active'
      AND tf.t_id = ?
      AND tt.corrigendum=1
    ORDER BY tt.t_temp_id DESC
    LIMIT 1
    ";

    $cdRes = core_query($cdSql, "i", [$tId]);
    $cd    = $cdRes['data'][0]['cd'] ?? '';

} else {

    $pd = $row['publish_date'] . ' ' . $row['publish_time'];
    $cd = $row['close_date'] . ' ' . $row['close_time'];
}

?>
<style>
.modal-dialog {
    max-width: 70%!important;
    margin: 1.75rem auto;
}
</style>

<div class="modal-dialog" id="PopWind">
<div class="modal-content">

<div class="modal-header">
    <h4 class="modal-title">Tender Details</h4>
    <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
</div>

<div class="modal-body">

<table class="table table-bordered">
<colgroup>
<col width="30%">
<col width="70%">
</colgroup>

<tr>
<th class="bg-info">Tender Number:</th>
<td><?= htmlspecialchars($row['t_num'], ENT_QUOTES); ?></td>
</tr>

<tr>
<th class="bg-info">Title & Ref.No:</th>
<td><?= htmlspecialchars($row['tender_name'], ENT_QUOTES); ?></td>
</tr>

<tr>
<th class="bg-info">Tender Category:</th>
<td><?= htmlspecialchars($row['cat_name'], ENT_QUOTES); ?></td>
</tr>

<tr>
<th class="bg-info">
<?= ($catId === 3)
    ? 'Bid-submission / Closing Date and Time'
    : 'Date and Time'; ?>
</th>
<td><?= htmlspecialchars($cd, ENT_QUOTES); ?></td>
</tr>

<tr>
<th class="bg-info">Published Date:</th>
<td><?= htmlspecialchars($pd, ENT_QUOTES); ?></td>
</tr>

<tr>
<th class="bg-info">Tender Document:</th>
<td>
<?php if (!empty($row['file_name'])): ?>
<a target="_blank"
   href="showfile.php?lang=<?= htmlspecialchars($_SESSION['lang'] ?? '1'); ?>&t_id=<?= $tId ?>">
<i class="fas fa-file-pdf"></i>
</a>
<?php endif; ?>
</td>
</tr>

<?php if (!empty($row['details'])): 
    rtfPathManage($row['details'], false);
?>
<tr>
<th colspan="2">Tender Details</th>
</tr>
<tr>
<td colspan="2"><?= $row['details']; ?></td>
</tr>
<?php endif; ?>

</table>

</div>

<div class="modal-footer">
<button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
<button type="button" class="btn btn-default" id="print">Print</button>
</div>

</div>
