<?php
declare(strict_types=1);

require './appcode/globals.inc.php';
require_once './include/website_common.inc.php';

$obj->AjaxFilePrevent();

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}



$ctId  = filter_input(INPUT_GET, 'ct_id', FILTER_VALIDATE_INT);
$tId   = filter_input(INPUT_GET, 't_id', FILTER_VALIDATE_INT);
$catId = filter_input(INPUT_GET, 'catid', FILTER_VALIDATE_INT);

if (!$ctId || !$tId) {
    $obj->headersFront('tender_details', null);
    exit;
}



$sql = "
SELECT 
    tt.file_name,
    tt.details,
    wtc.cat_name,
    tf.ct_id,
    tf.t_id,
    tf.publish_time,
    tf.expiry_time,
    tt.close_time,
    IFNULL(DATE_FORMAT(tf.publish_date,'%M %d, %Y'),'N/A') AS publish_date,
    IFNULL(DATE_FORMAT(tf.expiry_date,'%M %d, %Y'),'N/A') AS expiry,
    IFNULL(DATE_FORMAT(tt.close_date,'%M %d, %Y'),'N/A') AS close_date,
    IFNULL(DATE_FORMAT(tt.expiry_date,'%M %d, %Y'),'N/A') AS expiry_date,
    tt.t_temp_id,
    tt.tender_name
FROM web_tender_temp tt
INNER JOIN web_tender_corrigendum_final tf ON tf.t_temp_id = tt.t_temp_id
INNER JOIN web_tender_category wtc ON wtc.t_cat_id = tt.t_cat_id
WHERE tt.status = 'Active'
  AND tt.corrigendum = 1
  AND tf.ct_id = ?
  AND tf.t_id = ?
";

$result = core_query($sql, "ii", [$ctId, $tId]);

if (!$result['success'] || empty($result['data'])) {
    exit;
}

$row = $result['data'][0];

?>
<style>
.modal-dialog {
    max-width: 70%!important;
    margin: 1.75rem auto;
}
</style>

<div class="modal-dialog" id="PopWind1">
<div class="modal-content">

<div class="modal-header">
    <h4 class="modal-title">Tender Corrigendum Details</h4>
    <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
</div>

<div class="modal-body">
<table class="table table-bordered">
<colgroup>
    <col width="30%">
    <col width="70%">
</colgroup>

<tr>
    <th class="bg-info">Title & Ref.No:</th>
    <td><?= htmlspecialchars($row['tender_name'], ENT_QUOTES); ?></td>
</tr>

<tr>
    <th class="bg-info">Tender Category:</th>
    <td><?= htmlspecialchars($row['cat_name'], ENT_QUOTES); ?></td>
</tr>

<tr>
    <th class="bg-info">Published Date:</th>
    <td>
        <?= htmlspecialchars($row['publish_date'], ENT_QUOTES); ?>
        <?= htmlspecialchars($row['publish_time'], ENT_QUOTES); ?>
    </td>
</tr>

<tr>
<th class="bg-info">
<?= ($catId === 3)
    ? 'Bid-submission / Closing Date and Time'
    : 'Date and Time'; ?>
</th>
<td>
    <?= htmlspecialchars($row['close_date'], ENT_QUOTES); ?>
    <?= htmlspecialchars($row['close_time'], ENT_QUOTES); ?>
</td>
</tr>

<tr>
<th class="bg-info">Corrigendum Document:</th>
<td>
<?php if (!empty($row['file_name'])): ?>
<a target="_blank"
   href="showfile.php?lang=<?= htmlspecialchars($_SESSION['lang'] ?? '1'); ?>&t_id=<?= $tId ?>&ct_id=<?= $ctId ?>">
   <i class="fa fa-file-pdf-o"></i>
</a>
<?php endif; ?>
</td>
</tr>

<?php if (!empty($row['details'])): 
    rtfPathManage($row['details'], false);
?>
<tr>
    <th colspan="2">Corrigendum Details</th>
</tr>
<tr>
<td colspan="2">
    <?= $row['details']; ?>
</td>
</tr>
<?php endif; ?>

</table>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
    <button type="button" class="btn btn-default" id="cor_print">Print</button>
</div>

</div>
</div>
