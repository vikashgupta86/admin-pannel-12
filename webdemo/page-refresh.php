<?php
declare(strict_types=1);

require './appcode/globals.inc.php';
require_once './include/website_common.inc.php';
require './include/header.inc.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}


header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");


$baseUrl = '/';

try {
    if (isset($obj) && method_exists($obj, 'BaseUrl')) {
        $baseUrl = htmlspecialchars($obj->BaseUrl(), ENT_QUOTES, 'UTF-8');
    }
} catch (Throwable $e) {
    $baseUrl = '/';
}
?>

<body>
  <div class="container">
    <br>
    <div class="panel panel-default">
      <div class="panel-body alert alert-warning text-center" id="custom_msg">
        <strong>Session Expired!</strong><br>
        Some unexpected activity was detected.<br>
        The page may have expired or the browser back button was used on a protected page.
      </div>

      <form class="text-center" method="get" action="<?php echo $baseUrl; ?>">
        <input class="btn btn-primary" type="submit" value="Go to Home Page" />
      </form>

    </div>
  </div>
</body>
</html>
