<?php
    require_once '../appcode/globals.inc.php';
    $_SESSION['auth_seed'] = getNum(16);
    $sSeed = $_SESSION['auth_seed'];
    $md5Seed = md5($sSeed);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="../control/assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="../control/assets/css/login.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
            <script src="../control/assets/js/jquery.min.js"></script>

    </head>
    <body>
        <div id="ShowMsg"></div>
        <div class="login-container">
            <div class="card login-card">
                <div class="card-header">Login to Proceed</div>
                <div class="card-body p-4">
                    <form id="formLogin" name="formLogin" action="login_action.php" method="post" autocomplete="off">
                        <input type="hidden" name="hash" id="hash" value=""/>
                        <input type="hidden" name="hash_v" id="hash_v" value=""/>
                        <input type="hidden" name="hash1" id="hash1" value=""/>
                        <input type="hidden" name="hash2" id="hash2" value="<?php echo $md5Seed; ?>"/>
                        <input type="hidden" name="<?php echo $GLOBALS['csrf']['input-name']; ?>" value="<?php echo csrf_get_tokens(); ?>"/>
        
                        <div class="mb-3 position-relative">
                            <label for="T1" class="form-label">Login (Email ID):</label>
                            <input type="email" class="form-control" placeholder="Email" name="T1" id="T1" maxlength="50" required>
                        </div>
        
                        <div class="mb-3 position-relative">
                            <label for="T2" class="form-label">Password:</label>
                            <input type="password" class="form-control" placeholder="Password" name="T2" id="T2" maxlength="50" autocomplete="off" required>
                        </div>
        
                        <?php if(($_ENV['CAPTCHA'] ?? 'true') == "true"){ ?>
                            <div class="mb-3">
                                <div class="feed-back">
                                    <img id="captcha" src="captcha/login_captcha.php?sid=<?php echo rand(); ?>" onclick="refreshCaptcha()" title="Click to refresh"/>
                                    <br>
                                    <small>Can't read? <span class="CopyIcon" onclick="refreshCaptcha()" style="color: var(--primary)">refresh here</span></small>
                                </div>
                                <label for="T3" class="form-label">Security Code <span class="text-danger">[Case Sensitive]</span>:</label>
                                <input type="text" class="form-control" placeholder="Enter code" name="T3" id="T3" maxlength="20" required>
                            </div>
                        <?php } ?>

                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <button type="submit" class="btn btn-signin px-4 py-2">Sign In <i class="fa fa-sign-in-alt"></i></button>
                            <a href="#" id="passForgot" class="btn btn-forgot px-3 py-2">Forgot my password? <i class="fa-regular fa-circle-question"></i></a>
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
            $(document).ready(function(){
                $('#formLogin').on('submit', function(e){
                    e.preventDefault();
                    verifyMe();
                });

                var url = "resetPass.php";
                $('#passForgot').click(function(e) {
                    e.preventDefault();
                    $('.modal-container').load(url, function(result){
                        var myModal = new bootstrap.Modal(document.getElementById('PopWind'));
                        myModal.show();
                    });
                });
            });

            function verifyMe(){
                var email = $('#T1').val();
                var password = $('#T2').val();
                var seeder = $('#hash2').val(); 

                var sha256Email = CryptoJS.SHA256(email.toLowerCase()).toString();
                var hash = sha256Email;
                var hash_v = CryptoJS.SHA256(seeder + sha256Email).toString();
    
                var sha256Pass = CryptoJS.SHA256(password).toString();
                var hash1 = CryptoJS.SHA256(seeder + sha256Pass).toString();

                $('#hash').val(hash);
                $('#hash_v').val(hash_v);
                $('#hash1').val(hash1);
                $('#hash2').val(seeder);
                var formData = $('#formLogin').serializeArray();
                var filteredData = formData.filter(function(item) {
                    return item.name !== 'T1' && item.name !== 'T2';
                });
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    cache: false,
                    url: $('#formLogin').attr('action'),
                    data: $.param(filteredData),
                    beforeSend: function(){
                        $('button[type="submit"]').prop('disabled', true).html('Proccessing... <i class="fa fa-spinner fa-spin"></i>');
                    },
                    success: function(data) {
                        if(data.success === true) {
                            if(data.redirect) {
                                window.location.replace(data.redirect);
                            }
                        } else {
                            showError(data.error || "Request not completed successfully!");
                            refreshCaptcha();
                            if(data.next_seed) {
                                $('#hash2').val(data.next_seed);
                            }                
                            $('#T2').val('');
                            $('#T3').val('');
                        }
                    },
                    error: function() {
                        showError("Something went wrong, please try again!");
                        refreshCaptcha();
                    },
                    complete: function(){
                        $('button[type="submit"]').prop('disabled', false).html('Sign In <i class="fa fa-sign-in-alt"></i>');
                    }
                });
            }

            function showError(msg) {
                var $alert = $("<div class='alert alert-danger alert-dismissible fade show' role='alert'>"+msg+"<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>");
                $('#ShowMsg').html($alert);
                setTimeout(function(){
                    $alert.alert('close');
                }, 5000);
            }
        </script>
    </body>
</html>
