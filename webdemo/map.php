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
                <?php echo __("state designated agency"); ?>
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
                
                <?php include 'map/home-page-map.html'; ?>
                
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
