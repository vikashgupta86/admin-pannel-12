<?php
declare(strict_types=1);

require './appcode/globals.inc.php';
require_once './include/website_common.inc.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

try {
    include './include/header.inc.php';
} catch (Throwable $e) {
    app_log('Header include error: ' . $e->getMessage());
    exit('System error. Please try later.');
}
?>

<body>
<div id="wrapper">

    <div class="header clearfix">
        <?php
        try {
            include 'include/topmain.inc.php';
        } catch (Throwable $e) {
            app_log('Topmain include error: ' . $e->getMessage());
        }
        ?>
    </div>

    <section id="banner"></section>

    <div id="container-body" style="min-height:500px;">
        <?php
        try {
            include 'include/tender.inc.php';
        } catch (Throwable $e) {
            app_log('Tender include error: ' . $e->getMessage());
            echo '<div class="container">Unable to load content.</div>';
        }
        ?>
    </div>

    <?php
    try {
        include 'include/footer_main.inc.php';
    } catch (Throwable $e) {
        app_log('Footer include error: ' . $e->getMessage());
    }
    ?>

</div>
</body>
</html>
