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

if (!$ls_id || !$lid) {
    header('Location: index.php');
    exit;
}
?>

<body data-spy="scroll" class="skillbar" data-target=".navbar-collapse">

<div id="wrapper">

    <div>
        <?php include "include/topmain.inc.php"; ?>
    </div>

    <div id="container-body">
        <?php
            include "include/innerbanner.inc.php";
            include "include/organo.inc.php";
        ?>
    </div>

    <div>
        <?php include 'include/footer_main.inc.php'; ?>
    </div>

</div>

</body>
</html>
