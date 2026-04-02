<div class="container" id="inner-search" style="min-height: 550px;">
<?php 
// Ensure the include is properly terminated
include 'urlpath.inc.php'; 

// 1. Establish Database Connection
$conn = db_connect(); 

// 2. Initialize and Sanitize Parameters from GET/SESSION
$lang    = isset($_GET['lang']) ? (int)$_GET['lang'] : (isset($_SESSION['lang']) ? (int)$_SESSION['lang'] : 1);
$lid     = isset($_GET['lid']) ? (int)$_GET['lid'] : 0;
$ls_id   = isset($_GET['ls_id']) ? (int)$_GET['ls_id'] : 0;
$level   = isset($_GET['level']) ? (int)$_GET['level'] : 0;
$l_show  = isset($_GET['l_show']) ? (int)$_GET['l_show'] : 0;
$d_show  = isset($_GET['d_show']) ? (int)$_GET['d_show'] : 0;
$arch    = isset($_GET['arch']) ? (int)$_GET['arch'] : 0;

// Basic Validation: Redirect if critical IDs are missing
if ($lid <= 0 || ($l_show == 0 && $d_show == 0 && $ls_id <= 0)) {
    header('Location: index.php');
    exit;
}

// 3. Define the SQL condition for the link level
$level_cond = ($level <= 0) ? "AND ls.link_level IS NULL" : "AND ls.link_level = ?";

// 4. Fetch Content Based on the Mode (Direct Show vs standard Navigation)
if ($l_show == 1 || $d_show == 1) {
    $sql = "SELECT lt.author_name, lt.details, lt.title, lt.lang_id, lf.lid, 
                   DATE_FORMAT(lf.publish_date,'%M %d, %Y') as publish_date
            FROM web_links_final lf
            INNER JOIN web_link_temp lt ON lt.link_temp_id = lf.link_temp_id
            WHERE lf.status = 'Active' AND lt.status = 'Active' AND lt.type_id = 3 
              AND lt.lang_id = ? AND lf.lid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $lang, $lid);
} else {
    $sql = "SELECT lt.author_name, lt.details, lt.title, lt.link_name, lt.lang_id, 
                   lf.lid, ls.ls_id, ls.link_level, 
                   DATE_FORMAT(lf.publish_date,'%M %d, %Y') as publish_date
            FROM web_links_final lf
            INNER JOIN web_link_temp lt ON lt.link_temp_id = lf.link_temp_id
            INNER JOIN web_links_structure ls ON ls.lid = lf.lid
            WHERE lf.status = 'Active' AND lt.status = 'Active' AND ls.status = 'Active' 
              AND lt.type_id = 3 AND lt.lang_id = ? AND lf.lid = ? AND ls.ls_id = ? 
              $level_cond";
    
    $stmt = $conn->prepare($sql);
    if ($level <= 0) {
        $stmt->bind_param("iii", $lang, $lid, $ls_id);
    } else {
        $stmt->bind_param("iiii", $lang, $lid, $ls_id, $level);
    }
}

$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$stmt->close();

// 5. Check if data was returned
if (!$row) {
    echo "<div class='alert alert-warning'>No content found.</div>";
} else {
    // 6. Construct Archive Toggle Link
    $arch_base = "show_content.php?lang=$lang&lid=" . $row['lid'] . "&ls_id=" . ($row['ls_id'] ?? $ls_id) . "&level=$level";
    $ArchLink = ($arch == 0) 
        ? "<a href='$arch_base&arch=1' title='Archive Links'><i class='fa fa-archive' style='font-size: 20px;'></i></a>"
        : "<a href='$arch_base' title='Active Links'><i class='fa fa-bars' style='font-size: 20px;'></i></a>";
?>
    <div class="row">
        <div class="col-md-12">
            <div class="pull-right" style="margin-left: 10px;">
                <?php echo $ArchLink; ?>
            </div>
            <div class="pull-right smallfont">
                <?php echo ($lang == 1) ? 'Last Updated On: ' : '????? ?????: '; ?>
                <?= $row['publish_date']; ?>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <h2 class="innerheading"><?= html_entity_decode($row['title']) ?></h2>
            <div id="print-container" class="mt-3">
                <?php 
                // Handle Module Views (Photo/Video Gallery, etc.)
                $vmod = isset($_GET['vmod']) ? (int)$_GET['vmod'] : 0;
                $mode = ($vmod > 0) ? $vmod : $arch;

                switch ($mode) {
                    case 1: 
                        include 'include/link_archive.inc.php'; 
                        echo html_entity_decode($row['details']);   #   ADDED_SAC_260224
                        break;
                    case 2:
                    case 3: 
                        include 'include/photo_cat.inc.php'; 
                        break;
                    case 4: 
                        include 'include/sitemap_arch.inc.php'; 
                        break;
                    default: 
                        // Directly render the content details from the database
                        
                        echo html_entity_decode($row['details']); 
                        break;
                }
                ?>
            </div>
        </div>
    </div>
<?php } ?>
</div>