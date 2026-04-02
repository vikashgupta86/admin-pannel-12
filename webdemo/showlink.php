<?php
declare(strict_types=1);

require './appcode/globals.inc.php';
require_once './include/website_common.inc.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require './include/header.inc.php';


$ls_id = filter_input(INPUT_GET, 'ls_id', FILTER_VALIDATE_INT);
$lid   = filter_input(INPUT_GET, 'lid', FILTER_VALIDATE_INT);
$level = filter_input(INPUT_GET, 'level', FILTER_VALIDATE_INT);

if($level != 0)
{
    if (!$ls_id || !$lid || !$level) 
    {
        header('Location: index.php');
        exit;
    }
}
else
{
    if (!$ls_id || !$lid) 
    {
        header('Location: index.php');
        exit;
    }
}



$levelCondition = is_null($level)
    ? " AND ls.link_level IS NULL "
    : " AND ls.link_level = ? ";

$sql = "
    SELECT lt.url
    FROM web_links_final lf
    INNER JOIN web_link_temp lt
        ON lt.link_temp_id = lf.link_temp_id
    INNER JOIN web_links_structure ls
        ON ls.lid = lf.lid
    WHERE lf.status = 'Active'
      AND lt.status = 'Active'
      AND lt.type_id = 2
      AND ls.status = 'Active'
      AND ls.ls_id = ?
      AND lf.lid = ?
      {$levelCondition}
    LIMIT 1
";

$params = [$ls_id, $lid];
$types  = "ii";

if (!is_null($level)) {
    $params[] = $level;
    $types .= "i";
}

$result = simplefetch($sql, $types, $params);

if (empty($result[1][0]['url'])) {
    header("Location: index.php");
    exit;
}

$webUrl = $result[1][0]['url'];

$parsed = parse_url($webUrl);

if (!$parsed || empty($parsed['host'])) {
    header("Location: index.php");
    exit;
}

$allowedDomains = [
    'mumbaiport.gov.in',
    'gov.in',
    'nic.in'
];

$host = strtolower($parsed['host']);

$allowed = false;
foreach ($allowedDomains as $domain) {
    if (str_ends_with($host, $domain)) {
        $allowed = true;
        break;
    }
}

if (!$allowed) {
    ?>
    <html>
    <head>
        <script>
            alert("You are leaving the official domain.");
            window.location.href = "<?php echo htmlspecialchars($webUrl, ENT_QUOTES, 'UTF-8'); ?>";
        </script>
    </head>
    </html>
    <?php
    exit;
}

header("Location: " . $webUrl);
exit;