<?php
declare(strict_types=1);

require './appcode/globals.inc.php';
require_once './include/website_common.inc.php';
require './include/header.inc.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}







/*
if (!($result['success'] ?? '') || empty($result['data'])) {
    header('Location: index.php');
    exit;
}
*/

?>
<style>
table {
    border-collapse: collapse;
    border: 2px solid black;
}
table td {
    border: 2px solid #ddd;
}
</style>

<body>
<div id="wrapper">

<div class="header clearfix">
    <?php include 'include/topmain.inc.php'; ?>
</div>

<section id="banner"></section>

<div id="container-body" style="min-height:500px;">

<div class="heading_bannertop"
     style="background-image:url('WriteReadData/HD87168/innerpage_header.jpg')">
    Tenders
</div>

<div class="container">

<?php include 'include/urlpath.inc.php'; ?>

<div class="container-fluid">

<div class="row">
    <div class="col-md-4">
        <h4 class="innerheading">
            <?//= htmlspecialchars($department['dept_name'], ENT_QUOTES); ?>
        </h4>
    </div>

    <div class="col-md-8 text-right">
        <div class="pull-right">
            <?= __('Last Updated On'); ?>:
            <?= date('F d, Y'); ?>
        </div>
    </div>
</div>

<p>&nbsp;</p>

<table class="table table-bordered table-striped table-hover">
<tr>
    <td><strong>Category</strong></td>
</tr>
<tr>
<td>

<?php
// 1. Use the $conn object directly (it is defined in your globals.inc.php) 
$sql = "SELECT t_cat_id, cat_name FROM web_tender_category WHERE status='Active'";
$result = $conn->query($sql);

// 2. Check if the query itself worked
if ($result) {
    if ($result->num_rows > 0) {
        // 3. Loop through the records
        while ($cat = $result->fetch_assoc()) {
            
            // Ensure $depid is set to prevent undefined variable notices
            $depid = (int)($_GET['depid'] ?? 0); 

            $url = sprintf(
                "show_tenders.php?lang=%s&depid=%d&catid=%d",
                htmlspecialchars($_SESSION['lang'] ?? '1', ENT_QUOTES),
                $depid,
                (int)$cat['t_cat_id']
            );
            
            echo '<a class="sushil_link" href="' . $url . '">';
            echo htmlspecialchars($cat['cat_name'], ENT_QUOTES);
            echo '</a><br>';
        }
    } else {
        echo "No active categories found in database.";
    }
} else {
    // 4. If the query failed, show the error (remove this after testing)
    echo "Query Error: " . $conn->error;
}
?>

</td>
</tr>
</table>

</div>
</div>
</div>

<?php include 'include/footer_main.inc.php'; ?>

</div>
</body>
</html>
