<?php
declare(strict_types=1);

try {
    require_once __DIR__ . '/appcode/globals.inc.php';
    require_once __DIR__ . '/appcode/usercon_pdo.inc.php';
    require_once __DIR__ . '/include/website_common.inc.php';
} catch (Throwable $e) {
    error_log('Bootstrap failed: ' . $e->getMessage());
    http_response_code(500);
    exit('Server configuration error.');
}

$conn = db_connect();
if (!$conn instanceof mysqli) {
    http_response_code(500);
    exit('Database connection failed.');
}

$lang         = (int)($_SESSION['lang'] ?? 1);
$contentType  = !empty($_SESSION['userid_front']) ? 2 : 1;
$hindiQry     = ($lang === 2 || $lang === 3) ? subquerylinkhindi() : '';
$hindiJoin    = subqueryjoin();

/* ==========================================================
   CENTRAL LINK FETCHER
   ========================================================== */
function fetch_links(
    mysqli $conn,
    int $posId,
    ?int $parentId = null,
    ?int $level = null,
    array $positions = [],
    bool $archived = false
): array {

    global $lang, $contentType, $hindiQry, $hindiJoin;

    $expiry = $archived
        ? "lf.expiry_date <= CURRENT_DATE"
        : "(lf.expiry_date IS NULL OR lf.expiry_date > CURRENT_DATE)";

    $sql = "
        SELECT
            hindi_id,
            $hindiQry
            lt.lang_id,
            lt.meta_tag,
            lt.link_name,
            lt.title,
            lt.link_bdesc,
            lt.type_id,
            lt.file_name,
            lf.lid,
            lf.icon_name,
            lf.new_icon,
            ls.ls_id,
            ls.parent_ls_id,
            ls.position,
            CASE WHEN lt.type_id!=3 THEN 'target=\"_blank\"' ELSE '' END AS l_target,
            CASE WHEN ls.link_level IS NULL THEN '0' ELSE ls.link_level END AS link_level,
            CASE 
                WHEN lt.type_id=1 THEN 'showfile.php'
                WHEN lt.type_id=2 THEN 'showlink.php'
                ELSE ''
            END AS lfile
        FROM web_links_final lf
        INNER JOIN web_link_temp lt ON lt.link_temp_id=lf.link_temp_id
        INNER JOIN web_links_structure ls ON ls.lid=lf.lid
        $hindiJoin
        WHERE
            lf.status='Active'
            AND lt.status='Active'
            AND ls.status='Active'
            AND ls.pos_id=?
            AND lt.lang_id=?
            AND lt.content_type=?
            AND $expiry
    ";

    $types  = "iii";
    $params = [$posId, $lang, $contentType];

    if ($parentId !== null) {
        $sql .= " AND ls.parent_ls_id=?";
        $types .= "i";
        $params[] = $parentId;
    }

    if ($level !== null) {
        $sql .= " AND ls.link_level=?";
        $types .= "i";
        $params[] = $level;
    }

    if (!empty($positions)) {
        $in = implode(',', array_fill(0, count($positions), '?'));
        $sql .= " AND ls.position IN ($in)";
        $types .= str_repeat('i', count($positions));
        $params = array_merge($params, $positions);
    }

    $sql .= " ORDER BY ls.position ASC";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        throw new RuntimeException($conn->error);
    }

    $stmt->bind_param($types, ...$params);
        echo "<pre>" . var_dump(value: $stmt) . "</pre>";

    $stmt->execute();

    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

/* ==========================================================
   ANNOUNCEMENT RENDER
   ========================================================== */
function render_announcement(mysqli $conn, int $parentId): void
{
    $rows = fetch_links($conn, 4, $parentId, 1);

    if (!$rows) return;

    echo '<div class="col-md-9"><marquee style="height:30px;line-height:40px;"
          onmouseover="this.stop();" onmouseout="this.start();">';

    foreach ($rows as $row) {

        $linkfile = empty($row['lfile'])
            ? create_front_links_by_link_name($row['link_name'])
            : $row['lfile'];

        $newlink = is_array($linkfile) ? $linkfile[0] : $linkfile;

        $title = htmlspecialchars($row['title'], ENT_QUOTES);
        $name  = htmlspecialchars($row['link_name'], ENT_QUOTES);

        echo "<a style='color:#FFFFFF' {$row['l_target']}
              title='{$title}'
              href='{$newlink}?lang={$GLOBALS['lang']}&ls_id={$row['ls_id']}&lid={$row['lid']}'>
              {$name}
              </a>&nbsp;&nbsp;&nbsp;&nbsp;";
    }

    echo '</marquee></div>';
}

/* ==========================================================
   LOAD ALL HOMEPAGE SECTIONS (ONE DB CALL PER BLOCK)
   ========================================================== */

$sections = fetch_links($conn, 4, null, null, [1,2,3,4,5,6]);

$grouped = [];
foreach ($sections as $row) {
    $grouped[$row['position']][] = $row;
}

?>
<!-- ================= ANNOUNCEMENT ================= -->

<?php
if (!empty($grouped[1])) {
    foreach ($grouped[1] as $row) {
        echo '<div class="container-fluid bg-dark text-white">';
        echo '<div class="row">';
        echo '<div class="col-md-2">';
        echo htmlspecialchars($row['link_name']);
        echo '</div>';
        render_announcement($conn, (int)$row['ls_id']);
        echo '</div></div>';
    }
}
?>

<!-- ================= SERVICES (POSITION 2) ================= -->

<?php
if (!empty($grouped[2])) {

    $rows = fetch_links($conn, 4, (int)$grouped[2][0]['ls_id'], 1);

    echo '<div class="container"><div class="row">';

    foreach ($rows as $row) {

        $name = htmlspecialchars($row['link_name'], ENT_QUOTES);

        echo '<div class="col-md-2 text-center">';
        echo "<img src='WriteReadData/IC1425/{$row['icon_name']}' class='img-fluid'>";
        echo "<h6>{$name}</h6>";
        echo '</div>';
    }

    echo '</div></div>';
}
?>

<!-- ================= MINISTER (POSITION 3) ================= -->

<?php
if (!empty($grouped[3])) {
    foreach ($grouped[3] as $row) {
        echo '<div class="container py-4">';
        echo '<div class="row bg-light p-4">';
        echo "<div class='col-md-2'><img src='WriteReadData/IC1425/{$row['icon_name']}' class='img-fluid'></div>";
        echo "<div class='col-md-10'>";
        echo "<p>" . html_entity_decode($row['link_bdesc']) . "</p>";
        echo "<h3>" . html_entity_decode($row['link_name']) . "<br>" . html_entity_decode($row['meta_tag']) . "</h3>";
        echo "</div></div></div>";
    }
}
?>

<!-- ================= ABOUT (POSITION 4,5,6) ================= -->

<?php
if (!empty($grouped[4])) {
    foreach ($grouped[4] as $row) {
        echo '<div class="container py-4">';
        echo "<h2>" . htmlspecialchars($row['link_name']) . "</h2>";
        echo "<p>" . html_entity_decode($row['link_bdesc']) . "</p>";
        echo "</div>";
    }
}

if (!empty($grouped[5]) || !empty($grouped[6])) {
    echo '<div class="container"><div class="row">';
    foreach ([5,6] as $pos) {
        if (!empty($grouped[$pos])) {
            foreach ($grouped[$pos] as $row) {
                echo '<div class="col-md-2 text-center">';
                echo "<img src='WriteReadData/IC1425/{$row['icon_name']}' class='img-fluid'>";
                echo "<h6>" . htmlspecialchars($row['link_name']) . "</h6>";
                echo "<p>" . html_entity_decode($row['link_bdesc']) . "</p>";
                echo '</div>';
            }
        }
    }
    echo '</div></div>';
}
?>

<!-- ================= GOVT ICONS (POS 9) ================= -->

<?php
$govIcons = fetch_links($conn, 9);

if ($govIcons) {

    echo '<div class="container-fluid">';
    echo '<marquee onmouseover="this.stop();" onmouseout="this.start();">';

    foreach ($govIcons as $row) {
        echo '<div style="float:left;width:150px;margin-right:90px;">';
        echo "<a href='{$row['url']}' target='_blank'>";
        echo "<img src='WriteReadData/IC1425/{$row['icon_name']}' height='70'>";
        echo '</a></div>';
    }

    echo '</marquee></div>';
}

$conn->close();
?>