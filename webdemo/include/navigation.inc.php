<?php
$conn = db_connect();
$lang_id      = (int)($_SESSION['lang'] ?? 1);
$content_type = !empty($_SESSION['userid_front']) ? 2 : 1;
$pos_id       = 2;

// Different SQL query based on language
if ($lang_id == 1) {
    // English (lang_id=1) - Direct link_temp_id match with structure
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
    
    // echo "<pre>";
    // var_dump($sql);
    // echo "</pre>";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiii", $lang_id, $content_type, $pos_id, $pos_id);

    // echo "<pre>";
    //  echo "lang_id: " . $lang_id . "\n";
    //  echo "content_type: " . $content_type . "\n";
    //  echo "pos_id:" . $pos_id . "\n";
     
    // echo "<pre>";
    // var_dump($stmt);
    // echo "</pre>";

} else {
    // Hindi (lang_id=2) - Use hindi_id from web_links_final to get English structure
    // Hindi web_links_final.lid = English web_links_final.hindi_id
    // Then use English web_links_final.lid for structure
    $sql = "SELECT lf_eng.lid, lf_eng.icon_name, ls.ls_id, ls.parent_ls_id, ls.position, ls.link_level,
    ls.uplink, ls.up_position, lt_hindi.link_name, lt_hindi.url, lt_hindi.type_id, lt_hindi.file_name,
    CASE WHEN lt_hindi.type_id=1 THEN 'showfile.php'
    WHEN lt_hindi.type_id=2 THEN 'showlink.php'
    ELSE '' END AS lfile
    FROM web_links_final lf_hindi
    INNER JOIN web_link_temp lt_hindi ON lt_hindi.link_temp_id = lf_hindi.link_temp_id
    INNER JOIN web_links_final lf_eng ON lf_eng.hindi_id = lf_hindi.lid
    INNER JOIN web_link_temp lt_eng ON lt_eng.link_temp_id = lf_eng.link_temp_id
    INNER JOIN web_links_structure ls ON ls.lid = lf_eng.lid
    WHERE lf_hindi.status='Active'
    AND lf_eng.status='Active'
    AND lt_hindi.status='Active'
    AND lt_eng.status='Active'
    AND ls.status='Active'
    AND lt_hindi.lang_id=?
    AND lt_hindi.content_type=?
    AND lt_eng.lang_id=1
    AND (lf_hindi.expiry_date IS NULL OR lf_hindi.expiry_date > CURRENT_DATE())
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

}

$stmt->execute();
$allNavData = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Group data into main navigation and children
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
            
            /*$data['url'] = "content/" . $lang_id .
            "/" . ($row['link_level'] ?? 0) .
            "/" . $row['ls_id'] .
            "/" . $row['lid'];
            $data['target'] = '';
            $data['icon'] = '';
            break;*/
    }
    return $data;
}

// Add file size information for file links
foreach ($allNavData as $key => $row) {
    $allNavData[$key]['file_display_size'] = '';
    if ($row['type_id'] == 1 && !empty($row['file_name'])) {
        $filePath = "WriteReadData/L45218/" . $row['file_name'];
        if (file_exists($filePath)) {
            $bytes = filesize($filePath);
            if ($bytes >= 1048576) {
                $allNavData[$key]['file_display_size'] = '(' . number_format($bytes / 1048576, 2) . ' MB)';
            } elseif ($bytes >= 1024) {
                $allNavData[$key]['file_display_size'] = '(' . number_format($bytes / 1024, 2) . ' KB)';
            } else {
                $allNavData[$key]['file_display_size'] = '(' . $bytes . ' Bytes)';
            }
        }
    }
}

// Re-group data after adding file size
$navMain = [];
$navChildren = [];
foreach ($allNavData as $row) {
    if ($row['link_level'] === null || $row['link_level'] == 0 || $row['link_level'] == '0') {
        // Main links stay in the order provided by SQL (ASC)
        $navMain[] = $row;
    } else {
        // Collect children into their parent's bucket
        $navChildren[$row['parent_ls_id']][] = $row;
    }
}

// After the loop, reverse the order of each children array to get DESC order
foreach ($navChildren as $parent_id => $children) {
    $navChildren[$parent_id] = array_reverse($children);
}
?>

<div class="container-fluid nav-bar p-0" id="main-nav-container">
    <div class="row gx-0 menutop_bg align-items-center">
        <div class="col-md-12">
            <nav class="navbar navbar-expand-lg navbar-light">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars"></span>
                </button>
                <div id='logo-container' class="sticky-logo-wrap d-block d-lg-none">
                    <a href="index.php">
                        <img src='assets/img/stickylogo.png' alt="Sticky Logo">
                    </a>
                </div>
                <div class="collapse navbar-collapse px-5" id="navbarCollapse">
                    <div class="navbar-nav">
                        <div id='logo-container' class="sticky-logo-wrap d-none d-lg-block">
                            <a href="index.php">
                                <img src='assets/img/stickylogo.png' alt="Sticky Logo">
                            </a>
                        </div>
                        <?php
                        if ($lang_id == 1)
                        {
                        ?>
                            <a href="index.php?lang=1" class="nav-item nav-link active">Home</a>
                        <?php
                        }
                        else
                        {
                        ?>
                        <a href="index.php?lang=2" class="nav-item nav-link active">होम </a>
                        <?php
                        }
                        ?>
                        
                        <?php foreach ($navMain as $main):
                            $subLinks = $navChildren[$main['ls_id']] ?? [];
                            $mLink = generateLinkData($main, $lang_id);
                        ?>
                        <div class="nav-item <?= !empty($subLinks) ? 'dropdown' : '' ?>">
                            <a href="<?= htmlspecialchars($mLink['url']) ?>"
                               class="nav-link <?= !empty($subLinks) ? 'dropdown-toggle' : '' ?>"
                               <?= $mLink['target'] ?>>
                                <?= htmlspecialchars($main['link_name']) ?><?= $mLink['icon'] ?>
                                <small style="font-size: 0.8em;"> <?= $main['file_display_size'] ?></small>
                            </a>
                            <?php if (!empty($subLinks)): ?>
                            <div class="dropdown-menu">
                                <?php foreach ($subLinks as $sub):
                                    $subSubLinks = $navChildren[$sub['ls_id']] ?? [];
                                    $sLink = generateLinkData($sub, $lang_id);
                                ?>
                                <div class="<?= !empty($subSubLinks) ? 'dropdown-submenu' : '' ?>">
                                    <a href="<?= htmlspecialchars($sLink['url']) ?>"
                                       class="dropdown-item <?= !empty($subSubLinks) ? 'dropdown-toggle' : '' ?>"
                                       <?= $sLink['target'] ?>>
                                        <?= _html_entity_decode($sub['link_name']) ?><?= $sLink['icon'] ?>
                                        <small style="font-size: 0.8em;"><?= $sub['file_display_size'] ?></small>
                                    </a>
                                    <?php if (!empty($subSubLinks)): ?>
                                    <div class="dropdown-menu shadow">
                                        <?php foreach ($subSubLinks as $gc):
                                            $gcLink = generateLinkData($gc, $lang_id);
                                        ?>
                                        <a href="<?= htmlspecialchars($gcLink['url']) ?>" class="dropdown-item" <?= $gcLink['target'] ?>>
                                            <?= htmlspecialchars($gc['link_name']) ?><?= $gcLink['icon'] ?>
                                            <small style="font-size: 0.8em;"><?= $gc['file_display_size'] ?></small>
                                        </a>
                                        <?php endforeach; ?>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <?php endforeach; ?>
                            </div>
                            <?php endif; ?>
                        </div>
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
    if ($(window).width() >= 992) {
        $('.dropdown-submenu').hover(function() {
            $(this).find('> .dropdown-menu').stop(true, true).show();
        }, function() {
            $(this).find('> .dropdown-menu').stop(true, true).hide();
        });
    }
    
    $('.dropdown-submenu > .dropdown-toggle').on("click", function(e) {
        if ($(window).width() < 992) {
            e.preventDefault();
            e.stopPropagation();
            var $parent = $(this).parent('.dropdown-submenu');
            $parent.siblings().removeClass('open').find('.dropdown-menu').hide();
            $parent.toggleClass('open');
            $(this).next('.dropdown-menu').slideToggle();
        }
    });
    
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
    
    $('#web_search').on('submit', function(e) {
        if ($input.val().trim().length < 3) {
            e.preventDefault();
            $error.fadeIn();
            return false;
        }
    });
});
</script>