<?php

require './appcode/globals.inc.php';
require_once './include/website_common.inc.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}


if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

include 'include/header.inc.php';
?>

<body class="hold-transition login-page container-fluid">

<div class="login-box">
    <div class="login-logo">Login to Proceed</div>

    <div class="login-box-body">

        <form id="formLogin"
              method="post"
              action="login_action.php"
              autocomplete="off">

            <!-- CSRF -->
            <input type="hidden"
                   name="csrf_token"
                   value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES); ?>">

            <div class="form-group has-feedback">
                <label for="T1">Login (Email ID):</label>
                <input type="email"
                       class="form-control"
                       name="T1"
                       id="T1"
                       maxlength="100"
                       required>
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>

            <div class="form-group has-feedback">
                <label for="T2">Password:</label>
                <input type="password"
                       class="form-control"
                       name="T2"
                       id="T2"
                       maxlength="100"
                       required>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>

            <?php if (!empty($_ENV['CAPTCHA']) && $_ENV['CAPTCHA'] === "true"): ?>
            <div class="form-group has-feedback">
                <div class="feed-back">
                    <img id="captcha"
                         src="captcha/php_captcha_contact.php?sid=<?= random_int(1,999999); ?>" />
                    <br>
                    Can't read the image?
                    <strong style="color:red;cursor:pointer;"
                            onclick="refreshCaptcha1()">Refresh</strong>
                </div>

                <label for="T3">[Case Sensitive]</label>
                <input type="text"
                       class="form-control"
                       name="T3"
                       id="T3"
                       maxlength="6"
                       required>
                <span class="glyphicon glyphicon-eye-open form-control-feedback"></span>
            </div>
            <?php endif; ?>

            <div class="row">
                <div class="col-xs-4">
                    <button type="submit"
                            class="btn btn-primary btn-block btn-flat">
                        Sign In
                        <i class="fa fa-sign-in"></i>
                    </button>
                </div>
            </div>

        </form>

        <a href="forgot_password.php">
            forgot my password
            <i class="fa fa-question-circle-o"></i>
        </a>

    </div>
</div>

<div id="ShowMsg">
<?php
if (!empty($_SESSION['msg'])) {
    echo htmlspecialchars($_SESSION['msg'], ENT_QUOTES);
    unset($_SESSION['msg']);
}
?>
</div>

<script>
function refreshCaptcha1(){
    const img = document.getElementById('captcha');
    if(img){
        img.src = "captcha/php_captcha_contact.php?sid=" + Math.random();
    }
}
</script>

</body>
</html>
