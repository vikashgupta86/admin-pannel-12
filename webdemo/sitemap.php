<?php

require './appcode/globals.inc.php';
require_once './include/website_common.inc.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require './include/header.inc.php';
?>

<body>
<div id="wrapper">

    <?php require './include/topmain.inc.php'; ?>

    <div id="container-body">
        <?php require './include/sitemap.inc.php'; ?>
    </div>

    <?php require './include/footer_main.inc.php'; ?>

</div>
</body>
</html>
