<?php
$conn = db_connect();

$lang_id      = (int)($_SESSION['lang'] ?? 1);
$content_type = !empty($_SESSION['userid_front']) ? 2 : 1;
$pos_id       = 2; 

$sql = "SELECT lf.lid, lf.icon_name, ls.ls_id, ls.parent_ls_id, ls.position, ls.link_level,
               ls.uplink, ls.up_position, lt.link_name, lt.url, lt.type_id, lt.file_name,
               CASE WHEN lt.type_id=1 THEN 'showfile.php'
                    WHEN lt.type_id=2 THEN 'showlink.php'
                    ELSE '' END AS lfile
        FROM web_links_final lf
        INNER JOIN web_link_temp lt ON lt.link_temp_id = lf.link_temp_id
        INNER JOIN web_links_structure ls ON ls.lid = lf.lid
        WHERE lf.status='Active' 
          AND lt.status='Active' 
          AND ls.status='Active'
          AND lt.lang_id=? 
          AND lt.content_type=?
          AND (lf.expiry_date IS NULL OR lf.expiry_date > CURRENT_DATE())
          AND (
               (ls.pos_id = ? AND ls.link_level IS NULL) 
               OR 
               (ls.uplink = 1 AND ls.link_level IS NULL)
               OR
               (ls.parent_ls_id IN (SELECT ls2.ls_id FROM web_links_structure ls2 WHERE ls2.pos_id = ? OR ls2.uplink = 1))
               OR
               (ls.link_level = 2)
          )
        ORDER BY COALESCE(ls.up_position, ls.position) ASC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iiii", $lang_id, $content_type, $pos_id, $pos_id);
$stmt->execute();
$allNavData = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$navMain = [];
$navChildren = [];

foreach ($allNavData as $row) {
    if ($row['link_level'] === null || $row['link_level'] == 0 || $row['link_level'] == '0') {
        $navMain[] = $row;
    } else {
        $navChildren[$row['parent_ls_id']][] = $row;
    }
}

/**
 * Generates URL, Target, and Icon based on type_id
 */
function generateLinkData($row, $lang_id) {
    $data = ['url' => '', 'target' => '', 'icon' => ''];
    $filePathBase = "WriteReadData/L45218/";

    switch ($row['type_id']) {
        case 1: // File Link
            $data['url'] = $filePathBase . $row['file_name'];
            $data['target'] = 'target="_blank"';
            $ext = strtolower(pathinfo($row['file_name'], PATHINFO_EXTENSION));
            if ($ext == 'pdf') {
                $data['icon'] = '<i class="fa fa-file-pdf-o text-danger"></i> ';
            } elseif (in_array($ext, ['jpg', 'jpeg', 'png'])) {
                $data['icon'] = '<i class="fa fa-file-image-o text-primary"></i> ';
            } else {
                $data['icon'] = '<i class="fa fa-file-o"></i> ';
            }
            break;

        case 2: // External URL Link
            $data['url'] = $row['url'];
            $data['target'] = 'target="_blank"';
            $data['icon'] = '<i class="fa fa-external-link"></i> ';
            break;

        case 3: // Internal Content Link
            $data['url'] = "show_content.php?lang=" . $lang_id . 
                           "&level=" . ($row['link_level'] ?? 0) . 
                           "&ls_id=" . $row['ls_id'] . 
                           "&lid=" . $row['lid'];
            $data['target'] = '';
            $data['icon'] = '';
            break;
    }
    return $data;
}
?>

<div class="container-fluid nav-bar p-0" id="main-nav-container">
    <div class="row gx-0 menutop_bg align-items-center">
        <div class="col-md-12">
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="collapse navbar-collapse px-5" id="navbarCollapse">
                    <div class="navbar-nav p-4 p-lg-0">
                        <div id='logo-container' class="sticky-logo-wrap">
                            <a href="index.php">
                                <img src='assets/img/stickylogo.png' alt="Sticky Logo">
                            </a>
                        </div>
                        
                        <a href="index.php" class="nav-item nav-link active">Home</a>                                                

                        <?php foreach ($navMain as $main): 
                            $mainId = (int)$main['ls_id'];
                            $subLinks = $navChildren[$mainId] ?? [];
                            $mLink = generateLinkData($main, $lang_id);
                        ?>
                            <?php if (empty($subLinks)): ?>
                                <a href="<?= htmlspecialchars($mLink['url']) ?>" class="nav-item nav-link" <?= $mLink['target'] ?>>
                                    <?= htmlspecialchars($main['link_name']) ?><?= $mLink['icon'] ?>
                                </a>
                            <?php else: ?>
                                <div class="nav-item dropdown">
                                    <a href="<?= htmlspecialchars($mLink['url']) ?>" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" <?= $mLink['target'] ?>>
                                        <?= htmlspecialchars($main['link_name']) ?><?= $mLink['icon'] ?>
                                    </a>
                                    <div class="dropdown-menu">
                                        <?php foreach ($subLinks as $sub): 
                                            $subId = (int)$sub['ls_id'];
                                            $subSubLinks = $navChildren[$subId] ?? [];
                                            $sLink = generateLinkData($sub, $lang_id);
                                        ?>
                                            <?php if (empty($subSubLinks)): ?>
                                                <a href="<?= htmlspecialchars($sLink['url']) ?>" class="dropdown-item" <?= $sLink['target'] ?>>
                                                    <?= htmlspecialchars($sub['link_name']) ?><?= $sLink['icon'] ?>
                                                </a>
                                            <?php else: ?>
                                                <div class="dropdown-submenu">
                                                    <a href="<?= htmlspecialchars($sLink['url']) ?>" class="dropdown-item dropdown-toggle" <?= $sLink['target'] ?>>
                                                        <?= htmlspecialchars($sub['link_name']) ?><?= $sLink['icon'] ?>
                                                    </a>
                                                    <div class="dropdown-menu shadow">
                                                        <?php foreach ($subSubLinks as $gc): 
                                                            $gcLink = generateLinkData($gc, $lang_id);
                                                        ?>
                                                            <a href="<?= htmlspecialchars($gcLink['url']) ?>" class="dropdown-item" <?= $gcLink['target'] ?>>
                                                                <?= htmlspecialchars($gc['link_name']) ?><?= $gcLink['icon'] ?>
                                                            </a>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="searchBox">
                        <form name="web_search" id="web_search" method="post" action="web_search.php?lang=<?= (int)$_SESSION['lang']; ?>" autocomplete="off">
                            <div class="searchBoxRow cf search-container">
                                <label class="sr-only">Search</label>
                                <input type="text" name="kval" id="kval" placeholder="Search" class="searchInput" required minlength="3">
                                
                                <button style="line-height: 18px!important; height: 46px!important; margin-top: 0px!important; min-width: 50px!important;" 
                                        class="btn" type="submit" id="web-search-btn" disabled>
                                    <svg viewBox="0 0 24 24" class="search__icon">
                                        <path d="M21.53 20.47l-3.66-3.66C19.195 15.24 20 13.214 20 11c0-4.97-4.03-9-9-9s-9 4.03-9 9 4.03 9 9 9c2.215 0 4.24-.804 5.808-2.13l3.66 3.66c.147.146.34.22.53.22s.385-.073.53-.22c.295-.293.295-.767.002-1.06zM3.5 11c0-4.135 3.365-7.5 7.5-7.5s7.5 3.365 7.5 7.5-3.365 7.5-7.5 7.5-7.5-3.365-7.5-7.5z"></path>
                                    </svg>
                                </button>
                            </div>
                            <div id="search-error" style="color: #d9534f; font-size: 12px; margin-top: 5px; display: none;">
                                Please enter at least 3 characters.
                            </div>
                        </form>
                    </div>                                        
                </div>
            </nav>
        </div>
    </div>
</div>


<script>
$(document).ready(function() {
    const $input = $('#kval');
    const $button = $('#web-search-btn');
    const $error = $('#search-error');
    
    $input.on('input', function() {
        const val = $(this).val().trim();
        
        if (val.length >= 3) {
            $button.prop('disabled', false).css('opacity', '1').css('cursor', 'pointer');
            $error.fadeOut();
        } else {
            $button.prop('disabled', true).css('opacity', '0.5').css('cursor', 'not-allowed');
            if (val.length > 0) {
                $error.fadeIn();
            } else {
                $error.fadeOut();
            }
        }
    });

    // Prevent submission if somehow bypassed
    $('#web_search').on('submit', function(e) {
        if ($input.val().trim().length < 3) {
            e.preventDefault();
            $error.fadeIn();
            return false;
        }
    });
});
</script>