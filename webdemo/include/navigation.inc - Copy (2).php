<?php
$conn = db_connect();

$lang_id      = (int)($_SESSION['lang'] ?? 1);
$content_type = !empty($_SESSION['userid_front']) ? 2 : 1;
$pos_id       = 2; // Assuming Position 2 is your main menu position

$sql = "SELECT lf.lid, lf.icon_name, ls.ls_id, ls.parent_ls_id, ls.position, ls.link_level,
               ls.uplink, ls.up_position, lt.link_name, lt.url, lt.type_id,
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
    // Top-level if it's explicitly marked as uplink=1 OR it's a root item (level NULL/0)
    if ($row['link_level'] === null || $row['link_level'] == 0 || $row['link_level'] == '0') {
        $navMain[] = $row;
    } else {
        $navChildren[$row['parent_ls_id']][] = $row;
    }
}
?>




<div class="container-fluid nav-bar p-0">
    <div class="row gx-0 menutop_bg align-items-center">
        <div class="col-md-12">
            <nav class="navbar navbar-expand-lg navbar-light">
                <a href="index.php" class="navbar-brand d-block d-lg-none mobile_logo px-0">
                    <img src="img/new_logo_main.png">
                </a>

                <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars fa-1x"></span>
                </button>

                <div class="collapse navbar-collapse px-5" id="navbarCollapse">
                    <div class="navbar-nav p-4 p-lg-0">
                        <div id='logo-container'>
                            <img src='img/stickylogo.png'>
                        </div>

                        <?php foreach ($navMain as $main): 
                            $mainId = (int)$main['ls_id'];
                            $subLinks = $navChildren[$mainId] ?? [];
                            //$mainUrl = ($main['url'] != '') ? $main['url'] : $main['lfile'] . '?lid=' . $main['lid'];
                            $mainUrl = "show_content.php?lang=" . $lang_id . 
                                       "&level=" . ($main['link_level'] ?? 0) . 
                                       "&ls_id=" . $main['ls_id'] . 
                                       "&lid=" . $main['lid'];
                        ?>
                            <?php if (empty($subLinks)): ?>
                                <a href="<?= htmlspecialchars($mainUrl) ?>" class="nav-item nav-link"><?= htmlspecialchars($main['link_name']) ?></a>
                            <?php else: ?>
                                <div class="nav-item dropdown">
                                    <a href="<?= htmlspecialchars($mainUrl) ?>" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                                        <?= htmlspecialchars($main['link_name']) ?>
                                    </a>
                                    <div class="dropdown-menu">
                                        <?php foreach ($subLinks as $sub): 
                                            $subId = (int)$sub['ls_id'];
                                            $subSubLinks = $navChildren[$subId] ?? []; // Checking for Level 2
                                            //$subUrl = ($sub['url'] != '') ? $sub['url'] : $sub['lfile'] . '?lid=' . $sub['lid'];
                                            $subUrl = "show_content.php?lang=" . $lang_id . 
                                                      "&level=" . $sub['link_level'] . 
                                                      "&ls_id=" . $sub['ls_id'] . 
                                                      "&lid=" . $sub['lid'];
                                        ?>
                                            <?php if (empty($subSubLinks)): ?>
                                                <a href="<?= htmlspecialchars($subUrl) ?>" class="dropdown-item"><?= htmlspecialchars($sub['link_name']) ?></a>
                                            <?php else: ?>
                                                <div class="dropdown-submenu">
                                                    <a href="<?= htmlspecialchars($subUrl) ?>" class="dropdown-item dropdown-toggle"><?= htmlspecialchars($sub['link_name']) ?></a>
                                                    <div class="dropdown-menu shadow">
                                                        <?php foreach ($subSubLinks as $gc): 
                                                            $gcUrl = ($gc['url'] != '') ? $gc['url'] : $gc['lfile'] . '?lid=' . $gc['lid'];
                                                        ?>
                                                            <a href="<?= htmlspecialchars($gcUrl) ?>" class="dropdown-item"><?= htmlspecialchars($gc['link_name']) ?></a>
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
                        <div class="searchBoxRow cf search-container">
                            <label class="sr-only">Search</label>
                            <input type="text" value="Search" class="searchInput" onfocus="this.value=''">
                            <svg viewBox="0 0 24 24" class="search__icon">
                                <path d="M21.53 20.47l-3.66-3.66C19.195 15.24 20 13.214 20 11c0-4.97-4.03-9-9-9s-9 4.03-9 9 4.03 9 9 9c2.215 0 4.24-.804 5.808-2.13l3.66 3.66c.147.146.34.22.53.22s.385-.073.53-.22c.295-.293.295-.767.002-1.06zM3.5 11c0-4.135 3.365-7.5 7.5-7.5s7.5 3.365 7.5 7.5-3.365 7.5-7.5 7.5-7.5-3.365-7.5-7.5z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>