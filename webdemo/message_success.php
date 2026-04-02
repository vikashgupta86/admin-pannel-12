<?php
include './appcode/globals.inc.php';
include_once './include/website_common.inc.php';
include './include/header.inc.php';
?>

<body>
  <div class="container">
    <br>
    <div class="panel panel-default">
      <div class="panel-body alert alert-success text-center" id="custom_msg">
        <strong>Success!</strong><br>
        Your message has been sent. Thank you.
      </div>

      <form class="text-center" method="get" action="<?php echo $obj->BaseUrl(); ?>">
        <input class="btn btn-primary" type="submit" value="Go to Home Page" />
      </form>
    </div>
  </div>
</body>
</html>
