<?php

    $conn = db_connect();

    $lang_id      = (int)($_SESSION['lang'] ?? 1);
    $content_type = !empty($_SESSION['userid_front']) ? 2 : 1;
    $pos_id       = 4;

    function simpleFetchPrepared(mysqli $conn, string $sql, string $types = "", array $params = []): array {
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new RuntimeException("Prepare failed: " . $conn->error);
        }

        if ($types !== "" && $params) {
            $stmt->bind_param($types, ...$params);
        }

        if (!$stmt->execute()) {
            throw new RuntimeException("Execute failed: " . $stmt->error);
        }

        $result = $stmt->get_result();
        $data   = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];

        $stmt->close();
        return $data;
    }

    
    #   FETCH ALL HOMEPAGE SECTIONS (1–6) IN ONE QUERY
    $sqlSections = "SELECT lf.lid, lf.icon_name, ls.ls_id, ls.parent_ls_id, ls.position, lt.link_name, lt.meta_tag, lt.link_bdesc, lt.type_id, lt.file_name,
                        CASE WHEN lt.type_id!=3 THEN 'target=\"_blank\"' ELSE '' END AS l_target,
                        CASE WHEN ls.link_level IS NULL THEN '0' ELSE ls.link_level END AS link_level,
                        CASE WHEN lt.type_id=1 THEN 'showfile.php'
                        WHEN lt.type_id=2 THEN 'showlink.php'
                            ELSE '' END AS lfile
                    FROM web_links_final lf
                        INNER JOIN web_link_temp lt ON lt.link_temp_id = lf.link_temp_id
                        INNER JOIN web_links_structure ls ON ls.lid = lf.lid
                    WHERE lf.status='Active'
                        AND lt.status='Active'
                        AND ls.status='Active'
                        AND ls.pos_id=?
                        AND ls.link_level IS NULL
                        AND (lf.expiry_date IS NULL OR lf.expiry_date > CURRENT_DATE())
                        AND lt.lang_id=?
                        AND lt.content_type=?
                        AND ls.position IN (1,2,3,4,5,6)
                    ORDER BY ls.position ASC";
                //die ($sqlSections);
                $sectionData = simpleFetchPrepared($conn, $sqlSections,"iii", [$pos_id, $lang_id, $content_type]);

                $sections = [];
                foreach ($sectionData as $row) {
                    $sections[$row['position']][] = $row;
                }

   #    ANNOUNCEMENT FUNCTION
    function renderAnnouncement(mysqli $conn, int $parentId, int $level): void {
        $lang_id      = (int)($_SESSION['lang'] ?? 1);
        $content_type = !empty($_SESSION['userid_front']) ? 2 : 1;

        $sql = "SELECT lf.lid, lt.link_name, ls.ls_id, CASE WHEN lt.type_id!=3 THEN 'target=\"_blank\"' ELSE '' END AS l_target,
                    CASE WHEN lt.type_id=1 THEN 'showfile.php'
                    WHEN lt.type_id=2 THEN 'showlink.php'
                    ELSE '' END AS lfile
                FROM web_links_final lf
                    INNER JOIN web_link_temp lt ON lt.link_temp_id = lf.link_temp_id
                    INNER JOIN web_links_structure ls ON ls.lid = lf.lid
                WHERE lf.status='Active'
                    AND lt.status='Active'
                    AND ls.status='Active'
                    AND ls.parent_ls_id=?
                    AND ls.link_level=?
                    AND (lf.expiry_date IS NULL OR lf.expiry_date > CURRENT_DATE())
                    AND lt.lang_id=?
                    AND lt.content_type=?
                    ORDER BY ls.position ASC
                LIMIT 15";

        $rows = simpleFetchPrepared($conn, $sql, "iiii", [$parentId, $level, $lang_id, $content_type]);

        if (!$rows) return;
            echo '<div class="col-md-9"><marquee behavior="scroll" direction="left">';
        foreach ($rows as $row) {
            $url = $row['lfile'] . '?lid=' . (int)$row['lid'];
            echo '<a ' . $row['l_target'] . ' href="' . htmlspecialchars($url) . '">';
            echo htmlspecialchars($row['link_name']);
            echo '</a>&nbsp;&nbsp;&nbsp;';
        }
        echo '</marquee></div>';
    }

?>

<!-- ================= ANNOUNCEMENT ================= -->

<div class="container-fluid  wow zoomInDown" data-wow-delay="0.1s" style="border-radius: 0px; visibility: visible; animation-delay: 0.1s; animation-name: zoomInDown; background-color: rgb(33, 33, 33) !important;">
    <div class="row tickerpanle_maine">
        <div class="col-md-2 tickerpanle_maine_heading"><?= htmlspecialchars($sections[1][0]['link_name']) ?> <img src="img/annauncement.png"></div>
        <div class="col-md-9">
            <?php renderAnnouncement($conn, (int)$sections[1][0]['ls_id'], 1); ?>
            </div>
        <div class="col-md-1 tickerpanle_maine_view">View All</div>
    </div>
  
</div>













<?php
    function our_services_carousel(mysqli $conn, int $parentId, int $level): void {
        $lang_id      = (int)($_SESSION['lang'] ?? 1);
        $content_type = !empty($_SESSION['userid_front']) ? 2 : 1;

        $sql = "SELECT lf.lid, lf.icon_name, ls.ls_id, lt.link_name,
                CASE WHEN lt.type_id!=3 THEN 'target=\"_blank\"' ELSE '' END AS l_target,
                CASE WHEN lt.type_id=1 THEN 'showfile.php'
                    WHEN lt.type_id=2 THEN 'showlink.php'
                    ELSE '' END AS lfile
            FROM web_links_final lf
                INNER JOIN web_link_temp lt ON lt.link_temp_id = lf.link_temp_id
                INNER JOIN web_links_structure ls ON ls.lid = lf.lid
            WHERE lf.status='Active'
                AND lt.status='Active'
                AND ls.status='Active'
                AND ls.parent_ls_id=?
                AND ls.link_level=?
                AND (lf.expiry_date IS NULL OR lf.expiry_date > CURRENT_DATE())
                AND lt.lang_id=?
                AND lt.content_type=?
            ORDER BY CAST(ls.position AS UNSIGNED) ASC
            LIMIT 15";

        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new RuntimeException($conn->error);
        }

        $stmt->bind_param("iiii", $parentId, $level, $lang_id, $content_type);
        $stmt->execute();
        $rows = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        if (!$rows) return;

        echo '<div class="container-fluid px-0">';
        echo '<div class="row g-0 serviceicon_top">';
        echo '<div id="carouselExampleControls3" class="carousel slide" data-bs-ride="carousel">';
        echo '<div class="carousel-inner service_icon_top">';

        $chunked = array_chunk($rows, 6); // 6 items per slide

        foreach ($chunked as $index => $slideRows) {

            $active = ($index === 0) ? ' active' : '';

            echo '<div class="carousel-item' . $active . '">';
            echo '<div class="row">';

            foreach ($slideRows as $row) {
                $url = $row['lfile'] . '?lid=' . (int)$row['lid'];
                echo '<div class="col-md-2 border-end">';
                echo '<div class="p-4 text-center">';
                echo '<div style="margin-bottom:10px;">';
                echo '<img src="WriteReadData/IC1425/' . htmlspecialchars($row['icon_name']) . '" class="img-fluid">';
                echo '</div>';
                echo '<h6 class="mb-2">';
                echo '<a ' . $row['l_target'] . ' href="' . htmlspecialchars($url) . '">';
                echo htmlspecialchars($row['link_name']);
                echo '</a>';
                echo '</h6>';
                echo '</div></div>';
            }
            echo '</div></div>';
        }

        echo '</div>';
        echo '
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls3" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls3" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>';
        echo '</div></div></div>';
    }


    $lang_id      = (int)($_SESSION['lang'] ?? 1);
    $content_type = !empty($_SESSION['userid_front']) ? 2 : 1;
    $pos_id       = 4;

    $sql = "SELECT ls.ls_id
        FROM web_links_final lf
            INNER JOIN web_link_temp lt ON lt.link_temp_id = lf.link_temp_id
            INNER JOIN web_links_structure ls ON ls.lid = lf.lid
        WHERE lf.status='Active'
            AND lt.status='Active'
            AND ls.status='Active'
            AND ls.pos_id=?
            AND ls.link_level IS NULL
            AND (lf.expiry_date IS NULL OR lf.expiry_date > CURRENT_DATE())
            AND lt.lang_id=?
            AND lt.content_type=?
            AND ls.position=2
        LIMIT 1";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $pos_id, $lang_id, $content_type);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if ($result) {
        our_services_carousel($conn, (int)$result['ls_id'], 1);
    }
?>

<!-- ================= MINISTER (POSITION 3) ================= -->
<?php if (!empty($sections[3])): ?>
    <?php foreach ($sections[3] as $row): ?>
        <div class="container-fluid bg-light py-5">
            <div class="container">
                <div class="row border bg-white rounded p-4">
                    <div class="col-md-2">
                        <img src="WriteReadData/IC1425/<?= htmlspecialchars($row['icon_name']) ?>" class="img-fluid">
                    </div>
                    <div class="col-md-10">
                        <p><?= html_entity_decode($row['link_bdesc']) ?></p>
                        <h3><?= html_entity_decode($row['link_name']) ?><br><?= html_entity_decode($row['meta_tag']) ?></h3>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>


<!-- ================= ABOUT (POSITION 4) ================= -->
<?php if (!empty($sections[4])): ?>
    <div class="container py-4">
        <?php foreach ($sections[4] as $row): ?>
            <h2><?= htmlspecialchars($row['link_name']) ?></h2>
            <p><?= html_entity_decode($row['link_bdesc']) ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>


<!-- ================= CARDS (POSITION 5 & 6) ================= -->
<?php if (!empty($sections[5]) || !empty($sections[6])): ?>
    <div class="container">
        <div class="row">
            <?php foreach ([5,6] as $pos): ?>
                <?php if (!empty($sections[$pos])): ?>
                    <?php foreach ($sections[$pos] as $row): ?>
                        <div class="col-md-2 text-center">
                            <img src="WriteReadData/IC1425/<?= htmlspecialchars($row['icon_name']) ?>" class="img-fluid">
                            <h6><?= htmlspecialchars($row['link_name']) ?></h6>
                            <p><?= html_entity_decode($row['link_bdesc']) ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>


<!-- ================= GOVT ICONS (POS 9) ================= -->
<?php
$sqlGov = "
SELECT lf.icon_name, lt.url, lt.link_name
FROM web_links_final lf
INNER JOIN web_link_temp lt ON lt.link_temp_id = lf.link_temp_id
INNER JOIN web_links_structure ls ON ls.lid = lf.lid
WHERE lf.status='Active'
AND lt.status='Active'
AND ls.status='Active'
AND ls.pos_id=9
AND ls.link_level IS NULL
AND (lf.expiry_date IS NULL OR lf.expiry_date > CURRENT_DATE())
AND lt.lang_id=?
AND lt.content_type=?
ORDER BY ls.position
";

$govIcons = simpleFetchPrepared($conn, $sqlGov, "ii", [$lang_id, $content_type]);

if ($govIcons):
?>
<div class="container-fluid">
    <marquee onmouseover="this.stop();" onmouseout="this.start();">
        <?php foreach ($govIcons as $row): ?>
            <div style="float:left;width:150px;margin-right:90px;">
                <a href="<?= ($row['url'] != '') ? htmlspecialchars($row['url']) : ''; ?>" target="_blank">
                    <img src="WriteReadData/IC1425/<?= ($row['icon_name'] != '') ? htmlspecialchars($row['icon_name']) : ''; ?>" height="70">
                </a>
            </div>
        <?php endforeach; ?>
    </marquee>
</div>
<?php endif; ?>
            