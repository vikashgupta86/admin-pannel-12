<?php
require_once '../appcode/globals.inc.php';
// Generate a strong random seed for transport encryption
if (empty($_SESSION['auth_seed'])) {
    $_SESSION['auth_seed'] = bin2hex(random_bytes(32));
}
$sSeed = $_SESSION['auth_seed'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="../control/assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../control/assets/css/login.css" />
    <link rel="stylesheet" href="../control/assets/vendor/font-awesome/css/all.min.css" />
    <script src="../control/assets/js/jquery.min.js"></script>

</head>

<body>
    <div id="ShowMsg"></div>
    <div class="login-container">
        <div class="card login-card">
            <div class="card-header">Login to Proceed</div>
            <div class="card-body p-4">

                <form id="formLogin" name="formLogin" action="login_action.php" method="post" autocomplete="off">
                    <input type="hidden" name="hash_u" id="hash_u" value="" />
                    <input type="hidden" name="hash_p" id="hash_p" value="" />
                    <input type="hidden" name="hash_v" id="hash_v" value="" />
                    <input type="hidden" name="hash2" id="hash2" value="<?php echo $sSeed; ?>" />
                    <input type="hidden" name="<?php echo $GLOBALS['csrf']['input-name']; ?>"
                        value="<?php echo csrf_get_tokens(); ?>" />

                    <div class="mb-3 position-relative">
                        <label for="T1" class="form-label">Login (Email ID):</label>
                        <input type="email" class="form-control" placeholder="Email" name="T1" id="T1" maxlength="50"
                            required>
                    </div>

                    <div class="mb-3 position-relative">
                        <label for="T2" class="form-label">Password:</label>
                        <input type="password" class="form-control" placeholder="Password" name="T2" id="T2"
                            maxlength="50" autocomplete="off" required>
                    </div>

                    <?php if (($_ENV['CAPTCHA'] ?? 'true') == "true") { ?>
                        <div class="mb-3">
                            <div class="feed-back">
                                <img id="captcha" src="captcha/login_captcha.php?sid=<?php echo rand(); ?>"
                                    onclick="refreshCaptcha()" title="Click to refresh" />
                                <br>
                                <small>Can't read? <span class="CopyIcon" onclick="refreshCaptcha()"
                                        style="color: var(--primary)">refresh here</span></small>
                            </div>
                            <label for="T3" class="form-label">Security Code <span class="text-danger">[Case
                                    Sensitive]</span>:</label>
                            <input type="text" class="form-control" placeholder="Enter code" name="T3" id="T3"
                                maxlength="20" required>
                        </div>
                    <?php } ?>

                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <button type="submit" class="btn btn-signin px-4 py-2">Sign In <i
                                class="fa fa-sign-in-alt"></i></button>
                        <a href="#" id="passForgot" class="btn btn-forgot px-3 py-2">Forgot my password? <i
                                class="fa-regular fa-circle-question"></i></a>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <div class="modal-container"></div>
    <script src="../control/assets/js/bootstrap.bundle.min.js"></script>
    <script src="../control/assets/vendor/crypto-js/crypto-js.min.js"></script>
    <script src="captcha/captcha.js" defer></script>

    <script>
        $(document).ready(function () {
            $('#formLogin').on('submit', function (e) {
                e.preventDefault();
                verifyMe();
            });

            var url = "resetPass.php";
            $('#passForgot').click(function (e) {
                e.preventDefault();
                $('.modal-container').load(url, function (result) {
                    var myModal = new bootstrap.Modal(document.getElementById('PopWind'));
                    myModal.show();
                });
            });
        });

        function verifyMe() {
            var email = $('#T1').val().trim().toLowerCase();
            var password = $('#T2').val();
            var seed = $('#hash2').val();

            if (!email || !password) {
                showError("Please enter both email and password.");
                return;
            }

            var key = CryptoJS.SHA256(seed);

            var iv_u = CryptoJS.lib.WordArray.random(16);
            var enc_u = CryptoJS.AES.encrypt(email, key, { iv: iv_u });
            var hash_u = iv_u.toString() + enc_u.ciphertext.toString();

            var iv_p = CryptoJS.lib.WordArray.random(16);
            var enc_p = CryptoJS.AES.encrypt(password, key, { iv: iv_p });
            var hash_p = iv_p.toString() + enc_p.ciphertext.toString();

            var hash_v = CryptoJS.SHA256(seed + email + password).toString();

            $('#hash_u').val(hash_u);
            $('#hash_p').val(hash_p);
            $('#hash_v').val(hash_v);

            var formData = $('#formLogin').serializeArray();
            var filteredData = formData.filter(function (item) {
                return !['T1', 'T2', 'T3_display'].includes(item.name);
            });
            $.ajax({
                type: "POST",
                dataType: "json",
                cache: false,
                url: $('#formLogin').attr('action'),
                data: $.param(filteredData),
                beforeSend: function () {
                    $('button[type="submit"]').prop('disabled', true).html('Proccessing... <i class="fa fa-spinner fa-spin"></i>');
                },
                success: function (data) {
                    if (data.success === true) {
                        if (data.redirect) {
                            window.location.replace(data.redirect);
                        }
                    } else {
                        showError(data.error || "Request not completed successfully!");
                        refreshCaptcha();
                        if (data.next_seed) {
                            $('#hash2').val(data.next_seed);
                        }
                        $('#T2').val('');
                        $('#T3').val('');
                    }
                },
                error: function () {
                    showError("Something went wrong, please try again!");
                    refreshCaptcha();
                },
                complete: function () {
                    $('button[type="submit"]').prop('disabled', false).html('Sign In <i class="fa fa-sign-in-alt"></i>');
                }
            });
        }

        function showError(msg) {
            var $alert = $("<div class='alert alert-danger alert-dismissible fade show' role='alert'>" + msg + "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>");
            $('#ShowMsg').html($alert);
            setTimeout(function () {
                $alert.alert('close');
            }, 5000);
        }
    </script>
</body>

</html>