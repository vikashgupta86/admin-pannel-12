<?php
declare(strict_types=1);

require './appcode/globals.inc.php';
require_once './include/website_common.inc.php';
include 'include/header.inc.php';



$searchTerm = trim($_POST['kval'] ?? '');

// Updated validation for minimum 4 characters 
if (strlen($searchTerm) < 3) {
    echo "<h3>Please enter a search keyword with at least 4 characters.</h3>";
    include('include/footer_main.inc.php');
    exit;
}
?>

<div id="wrapper">

<?php include 'include/topmain.inc.php'; ?>

<div class="heading_bannertop"
     style="background-image:url('WriteReadData/HD87168/innerpage_header.jpg')">
    SEARCH
</div>

<div id="container-body" style="min-height:560px;">

<div class="container sitemap">
    <?php //include('include/urlpath.inc.php'); ?>
</div>

<div class="container">

<div class="pull-right smallfont">
    Date: <?= (new DateTime())->format('d-m-Y'); ?>
</div>

<div class="clearfix"></div>

<?php
if ($searchTerm === '') {
    echo "<h3>Please enter a search keyword.</h3>";
    include('include/footer_main.inc.php');
    exit;
}

try {
    // 1. Establish connection (matching middlequery.txt logic)
    $conn = db_connect(); 
    $like = '%' . $searchTerm . '%';
    
    // 2. Refined SQL Query [cite: 6, 21, 22]
    $sql = "
        SELECT
            lt.link_bdesc,
            lf.view_type,
            lt.lang_id,
            lf.icon_name,
            -- Standardized target logic [cite: 6, 19]
            CASE WHEN lt.type_id != 3 THEN 'target=\"_blank\"' ELSE '' END AS l_target,
            -- Standardized file handler logic [cite: 7, 20]
            CASE 
                WHEN lt.type_id = 1 THEN 'showfile.php'
                WHEN lt.type_id = 2 THEN 'showlink.php'
                ELSE ''
            END AS lfile,
            lf.lid,
            ls.ls_id,
            ls.parent_ls_id,
            lt.link_name,
            lt.title,
            lt.type_id,
            lt.file_name,
            ls.status,
            lt.details,
            COALESCE(ls.link_level, 0) AS link_level,
            -- Extract extension for icons [cite: 9, 26]
            CASE
                WHEN lt.type_id = 1 THEN SUBSTRING_INDEX(lt.file_name, '.', -1)
                ELSE ''
            END AS fext
        FROM web_links_final lf
        INNER JOIN web_link_temp lt ON lt.link_temp_id = lf.link_temp_id
        INNER JOIN web_links_structure ls ON ls.lid = lf.lid
        WHERE lt.status = 'Active' 
          AND lf.status = 'Active' 
          AND ls.status = 'Active'
          -- Expiry check integrated from middlequery 
          AND (lf.expiry_date IS NULL OR lf.expiry_date > CURRENT_DATE())
          AND (
                lt.link_name LIKE ?
             OR lt.url LIKE ?
             OR lt.details LIKE ?
          )
        ORDER BY ls.position DESC
    ";

    // 3. Using Prepared Statements for Security 
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $like, $like, $like);
    $stmt->execute();
    $rawResult = $stmt->get_result();
    $data = $rawResult->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    // Formatting result for existing frontend logic
    $result = ['success' => true, 'data' => $data];

} catch (Throwable $e) {
    app_log("Search Error: " . $e->getMessage());
    // ... error handling ...
}
?>

<div class="row" style="padding-left:21px;">
<h3>
Search Result for "
<?= htmlspecialchars($searchTerm, ENT_QUOTES); ?>"
</h3>
</div>

<?php

if (!$result['success'] || empty($result['data'])) {

    echo "<p>No record Found!</p>";

} else {

    echo "<ul class='sidebar-links-full' style='padding-left:21px;'>";

    foreach ($result['data'] as $row) {

        $linkfile = empty($row['lfile'])
            ? create_front_links_by_link_name($row['link_name'])
            : $row['lfile'];

        $newlinkfile = is_array($linkfile) ? $linkfile[0] : $linkfile;

        $href = sprintf(
            "%s?lang=%d&amp;level=%d&amp;ls_id=%d&amp;lid=%d",
            htmlspecialchars($newlinkfile, ENT_QUOTES),
            (int)$row['lang_id'],
            (int)$row['link_level'],
            (int)$row['ls_id'],
            (int)$row['lid']
        );

        echo "<li>";
        echo "<a "
            . htmlspecialchars($row['l_target'], ENT_QUOTES)
            . " title=\""
            . htmlspecialchars(CleanW3cWarn($row['title']), ENT_QUOTES)
            . "\" href=\"{$href}\">";

        echo htmlspecialchars(CleanW3cWarn($row['link_name']), ENT_QUOTES);

        echo "</a>";

        echo getFileIcon($row['fext'], $row['type_id']);
        echo filesize_formatted($row['file_name']);

        echo "</li>";

        if (!empty($row['link_bdesc'])) {
            echo "<p style='margin-left:25px;'>"
                . htmlspecialchars($row['link_bdesc'], ENT_QUOTES)
                . "</p>";
        }
    }

    echo "</ul>";
}
?>

</div>
</div>

<?php include('include/footer_main.inc.php'); ?>

</div>

<script>
$(function(){
    $('#webSearchBlock').highlight('<?= htmlspecialchars($searchTerm, ENT_QUOTES); ?>');
});
</script>

</body>
</html>
