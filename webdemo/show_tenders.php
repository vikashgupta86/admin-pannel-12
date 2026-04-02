<?php
declare(strict_types=1);

require './appcode/globals.inc.php';
require_once './include/website_common.inc.php';
require './include/header.inc.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}



$ls_id = filter_input(INPUT_GET, 'ls_id', FILTER_VALIDATE_INT);
$lid   = filter_input(INPUT_GET, 'lid', FILTER_VALIDATE_INT);
$catid = filter_input(INPUT_GET, 'catid', FILTER_VALIDATE_INT);


?>

<body>
<div id="wrapper">

    <div class="header clearfix">
        <?php include 'include/topmain.inc.php'; ?>
    </div>

    <section id="banner"></section>

    <div id="container-body" style="min-height:500px;">
        <?php include 'include/tender.inc.php'; ?>
    </div>

    <?php include 'include/footer_main.inc.php'; ?>

</div>
</body>
</html>
