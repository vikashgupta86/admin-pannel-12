<?php
include './appcode/globals.inc.php';
include_once './include/website_common.inc.php';
include 'include/header.inc.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* -----------------------------
   Strict Input Handling
------------------------------ */
$ls_id  = isset($_GET['ls_id']) ? (int)$_GET['ls_id'] : 0;
$lid    = isset($_GET['lid']) ? (int)$_GET['lid'] : 0;
$f_type = isset($_GET['f_type']) ? (int)$_GET['f_type'] : 0;

/* -----------------------------
   CSRF Protection
------------------------------ */
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

/* -----------------------------
   Fetch Link Name Securely
------------------------------ */
$linkName = '';
if ($f_type === 2 && $ls_id > 0 && $lid > 0) {
    $qry = "
        SELECT lt.link_name
        FROM web_links_final lf
        INNER JOIN web_link_temp lt ON lt.link_temp_id = lf.link_temp_id
        INNER JOIN web_links_structure ls ON ls.lid = lf.lid
        WHERE lf.status='Active'
        AND lt.status='Active'
        AND ls.status='Active'
        AND ls.ls_id = $ls_id
        AND lf.lid = $lid
    ";
    $linkName = $obj->getNameQry($qry);
}
?>

<style>
.alert-success {
    background-color: green;
    color: #ffffff;
}
.validation {
    color: red;
}
</style>

<div id="wrapper">
    <div>
        <?php include 'include/topmain.inc.php'; ?>
    </div>

    <div id="container-body" style="min-height:560px;">
        <div class="container-body sitemap">
            <div class="heading_bannertop"
                 style="background-image:url('WriteReadData/HD87168/innerpage_header.jpg')">
                <?php echo __("FEEDBACK"); ?>
            </div>
            <div class="container">
                <?php 
                /*
                include 'include/urlpath.inc.php';
                */
                 ?>
            </div>
        </div>

        <div class="container-fluid">
            <div class="modal-content" style="width:70%; margin:20px auto;">
                
                <form id="formNC"
                      method="post"
                      autocomplete="off"
                      action="<?php echo "feedback_action.php?lang=".(int)$_SESSION['lang']; ?>"
                      enctype="multipart/form-data">

                    <input type="hidden" name="frmType" value="1">
                    <input type="hidden" name="lid" value="<?php echo $lid; ?>">
                    <input type="hidden" name="ls_id" value="<?php echo $ls_id; ?>">
                    <input type="hidden" name="f_type" value="<?php echo $f_type; ?>">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

                    <div class="modal-body">

                        <?php if ($f_type === 2 && !empty($linkName)) { ?>
                            <h4>
                                Feedback for the Link :
                                <kbd><?php echo htmlspecialchars($linkName, ENT_QUOTES); ?></kbd>
                            </h4>
                        <?php } ?>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>Name</label>
                                <input type="text" class="form-control"
                                       name="f_name"
                                       maxlength="100"
                                       required>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Mobile</label>
                                <input type="text"
                                       class="form-control"
                                       name="mob"
                                       maxlength="10"
                                       pattern="[0-9]{10}"
                                       required>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Email</label>
                                <input type="email"
                                       class="form-control"
                                       name="email"
                                       maxlength="100">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Address</label>
                                <textarea class="form-control"
                                          name="address"
                                          rows="4"
                                          maxlength="500"></textarea>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Query</label>
                                <textarea class="form-control"
                                          name="query"
                                          rows="4"
                                          maxlength="2000"
                                          required></textarea>
                            </div>
                        </div>

                        <?php if ($_ENV['CAPTCHA'] === "true") { ?>
                            <div class="form-group">
                                <img id="captcha"
                                     src="contactcaptcha/captcha/php_captcha_cont.php?sid=<?php echo rand(); ?>">
                                <br>
                                <input type="text"
                                       class="form-control"
                                       name="captcha"
                                       maxlength="6"
                                       placeholder="Security Code"
                                       required>
                            </div>
                        <?php } ?>

                        <div id="ShowMsg"></div>

                    </div>

                    <div class="modal-footer">
                        <button type="reset" class="btn btn-default">Clear</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <div>
        <?php include 'include/footer_main.inc.php'; ?>
    </div>
</div>

<script>
document.getElementById('formNC').addEventListener('submit', function(e){
    e.preventDefault();

    let form = this;
    let formData = new FormData(form);

    fetch(form.action, {
        method: "POST",
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        try {
            let decoded = JSON.parse(atob(data));
            if(decoded[0]) {
                form.reset();
                document.getElementById('ShowMsg').innerHTML =
                    "<div class='alert alert-success'>Feedback sent successfully!</div>";
            } else {
                document.getElementById('ShowMsg').innerHTML =
                    "<div class='alert alert-danger'>Submission failed.</div>";
            }
        } catch (e) {
            document.getElementById('ShowMsg').innerHTML =
                "<div class='alert alert-danger'>Unexpected response received.</div>";
        }
    })
    .catch(() => {
        document.getElementById('ShowMsg').innerHTML =
            "<div class='alert alert-danger'>Server error.</div>";
    });
});
</script>
</body>
</html>
