<?php

    require_once __DIR__ . '/../appcode/usercon_pdo.inc.php';


    $lang = (int)($_SESSION['lang'] ?? 1);
    $contentType = !empty($_SESSION['empid']) ? 2 : 1;

    function upmenu_nlavel(mysqli $conn, int $parentid, int $level): void {
        global $lang, $contentType;

        $sql = "SELECT
                    lf.lid,
                    ls.ls_id,
                    ls.parent_ls_id,
                    ls.link_level,
                    lt.link_name,
                    lt.title,
                    lt.type_id,
                    CASE WHEN lt.type_id != 3 THEN 'target=\"_blank\"' ELSE '' END AS l_target,
                    CASE
                        WHEN lt.type_id = 1 THEN 'showfile.php'
                        WHEN lt.type_id = 2 THEN 'showlink.php'
                        ELSE '#'
                        END AS lfile
                    FROM web_links_final lf
                        INNER JOIN web_link_temp lt ON lt.link_temp_id = lf.link_temp_id
                        INNER JOIN web_links_structure ls ON ls.lid = lf.lid
                    WHERE lf.status='Active'
                        AND lt.status='Active'
                        AND ls.status='Active'
                        AND ls.parent_ls_id = ?
                        AND ls.link_level = ?
                        AND lt.lang_id = ?
                        AND lt.l_sub_type='1'
                        AND (
                            lt.content_type = 1
                            OR (lt.content_type = 2 AND ? = 2)
                        )
                        AND CONCAT(lf.publish_date,' ',IFNULL(lf.publish_time,'00:00:00')) <= CURRENT_TIMESTAMP()
                        AND (
                            lf.expiry_date IS NULL
                            OR CONCAT(lf.expiry_date,' ',IFNULL(lf.expiry_time,'00:00:00')) > CURRENT_TIMESTAMP()
                        )
                        ORDER BY ls.position+0 ASC";

                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("iiii", $parentid, $level, $lang, $contentType);
                    $stmt->execute();
                    $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            return;
        }

        echo '<ul class="dropdown-menu">';
        while ($row = $result->fetch_assoc()) {
            $lid   = (int)$row['lid'];
            $ls_id = (int)$row['ls_id'];
            $linkLevel = (int)$row['link_level'];

            $childCheck = $conn->prepare("
                SELECT 1 FROM web_links_structure
                WHERE parent_ls_id = ?
                LIMIT 1
            ");
            $childCheck->bind_param("i", $ls_id);
            $childCheck->execute();
            $childResult = $childCheck->get_result();
            $hasChild = ($childResult->num_rows > 0);
            $childCheck->close();

            if ($hasChild) {
                echo '<li class="dropdown-submenu">';
                echo '<a class="dropdown-item dropdown-toggle"
                      href="#"
                      data-bs-toggle="dropdown">';
        } else {
            echo '<li>';
            echo '<a class="dropdown-item" '
                . $row['l_target']
                . ' href="'
                . e($row['lfile'])
                . '?lang=' . $lang
                . '&level=' . $linkLevel
                . '&ls_id=' . $ls_id
                . '&lid=' . $lid
                . '">';
        }

        echo e($row['link_name']);
        echo '</a>';

        if ($hasChild) {
            upmenu_nlavel($conn, $ls_id, $level + 1);
        }

        echo '</li>';
    }

    echo '</ul>';

    $stmt->close();
}



$rootSql = "
SELECT
    lf.lid,
    ls.ls_id,
    lt.link_name,
    lt.title,
    lt.type_id,
    CASE WHEN lt.type_id != 3 THEN 'target=\"_blank\"' ELSE '' END AS l_target,
    CASE
        WHEN lt.type_id = 1 THEN 'showfile.php'
        WHEN lt.type_id = 2 THEN 'showlink.php'
        ELSE '#'
    END AS lfile
FROM web_links_final lf
INNER JOIN web_link_temp lt ON lt.link_temp_id = lf.link_temp_id
INNER JOIN web_links_structure ls ON ls.lid = lf.lid
WHERE lf.status='Active'
AND lt.status='Active'
AND ls.status='Active'
AND (ls.pos_id=2 OR ls.uplink=1)
AND ls.link_level IS NULL
AND lt.lang_id = ?
AND lt.l_sub_type='1'
AND (
    lt.content_type = 1
    OR (lt.content_type = 2 AND ? = 2)
)
AND CONCAT(lf.publish_date,' ',IFNULL(lf.publish_time,'00:00:00')) <= CURRENT_TIMESTAMP()
AND (
    lf.expiry_date IS NULL
    OR CONCAT(lf.expiry_date,' ',IFNULL(lf.expiry_time,'00:00:00')) > CURRENT_TIMESTAMP()
)
ORDER BY ls.position ASC
";

$rootStmt = $conn->prepare($rootSql);
$rootStmt->bind_param("ii", $lang, $contentType);
$rootStmt->execute();
$rootResult = $rootStmt->get_result();
?>


<div class="container-fluid nav-bar p-0">
    <div class="row gx-0 menutop_bg align-items-center">
        <div class="col-md-12">
            <nav class="navbar navbar-expand-lg navbar-light">
                <a href="" class="navbar-brand d-block d-lg-none mobile_logo px-0">
                    <img src="img/new_logo_main.png">
                </a>

                <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars fa-1x"></span>
                </button>

                <div class="collapse navbar-collapse px-5 " id="navbarCollapse">
                    <div class="navbar-nav p-4 p-lg-0">
                        <div id='logo-container'>
                            <img src='img/stickylogo.png' >
                        </div>
                
                

<li class="nav-item">
<a class="nav-link"
   href="index.php?lang=<?= $lang ?>">
Home
</a>
</li>

<?php
while ($row = $rootResult->fetch_assoc()) {

    $lid   = (int)$row['lid'];
    $ls_id = (int)$row['ls_id'];

    /* Check if child exists */
    $childCheck = $conn->prepare("
        SELECT 1 FROM web_links_structure
        WHERE parent_ls_id = ?
        LIMIT 1
    ");
    $childCheck->bind_param("i", $ls_id);
    $childCheck->execute();
    $childResult = $childCheck->get_result();
    $hasChild = ($childResult->num_rows > 0);
    $childCheck->close();

    if ($hasChild) {
        echo '<li class="nav-item dropdown">';
        echo '<a class="nav-link dropdown-toggle"
                  href="#"
                  data-bs-toggle="dropdown">';
    } else {
        echo '<li class="nav-item">';
        echo '<a class="nav-link" '
            . $row['l_target']
            . ' href="'
            . e($row['lfile'])
            . '?lang=' . $lang
            . '&level=0'
            . '&ls_id=' . $ls_id
            . '&lid=' . $lid
            . '">';
    }

    echo e($row['link_name']);
    echo '</a>';

    if ($hasChild) {
        upmenu_nlavel($conn, $ls_id, 1);
    }

    echo '</li>';
}
?>

</ul>
</div>
</nav>

</div>
</div>
</div>
