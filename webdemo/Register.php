<?php
declare(strict_types=1);

require './appcode/globals.inc.php';
require_once './include/website_common.inc.php';
require './include/header.inc.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}


if (!empty($_SESSION['userid_front'])) {
    header('Location: index.php');
    exit;
}


$lid    = filter_input(INPUT_GET, 'lid', FILTER_VALIDATE_INT);
$ls_id  = filter_input(INPUT_GET, 'ls_id', FILTER_VALIDATE_INT);
$f_type = filter_input(INPUT_GET, 'f_type', FILTER_VALIDATE_INT);
$lang   = $_SESSION['lang'] ?? 1;


if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf = $_SESSION['csrf_token'];

?>
<body>
<div id="wrapper">

<?php include 'include/topajit.inc.php'; ?>

<div id="container-body">

<div>
<div class="modal-dialog">
<div class="modal-content">

<div class="modal-header" style="background-color:#007e00;">
    <h4 class="modal-title">
        <strong style="color:white">REGISTER</strong>
    </h4>
</div>

<form name="formNC"
      id="formNC"
      method="post"
      autocomplete="off"
      action="<?= htmlspecialchars("register_action.php?lang=$lang", ENT_QUOTES) ?>">

<input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf, ENT_QUOTES) ?>">
<input type="hidden" name="lid" value="<?= (int)$lid ?>">
<input type="hidden" name="ls_id" value="<?= (int)$ls_id ?>">
<input type="hidden" name="f_type" value="<?= (int)$f_type ?>">

<div class="modal-body">

<div class="form-group">
    <label>Type of Registration</label>
    <select name="regtype" id="regtype" class="form-control" required>
        <option value="">Select</option>
        <option value="1">School</option>
        <option value="2">Student</option>
        <option value="3">Department</option>
    </select>
</div>

<div id="divschool" style="display:none;">
    <div class="form-group">
        <label>School Name</label>
        <input type="text" name="school" class="form-control">
    </div>
    <div class="form-group">
        <label>Contact Person</label>
        <input type="text" name="cname" class="form-control">
    </div>
</div>

<div id="divstudent" style="display:none;">
    <div class="form-group">
        <label>Student Name</label>
        <input type="text" name="student" class="form-control">
    </div>
    <div class="form-group">
        <label>School / College</label>
        <input type="text" name="guardian" class="form-control">
    </div>
    <div class="form-group">
        <label>DOB</label>
        <input type="date" name="dob" class="form-control">
    </div>
</div>

<div id="divdep" style="display:none;">
    <div class="form-group">
        <label>Name</label>
        <input type="text" name="dept_name" class="form-control">
    </div>
    <div class="form-group">
        <label>Department</label>
        <input type="text" name="department" class="form-control">
    </div>
</div>

<hr>

<div class="form-group">
    <label>Address</label>
    <input type="text" name="address" class="form-control" required>
</div>

<div class="form-group">
    <label>Mobile</label>
    <input type="text" name="phone" maxlength="10" class="form-control" required>
</div>

<div class="form-group">
    <label>Email</label>
    <input type="email" name="email" class="form-control" required>
</div>

<?php if (!empty($_ENV['CAPTCHA']) && $_ENV['CAPTCHA'] === "true"): ?>
<div class="form-group">
    <img id="captcha1"
         src="control/captcha/php_captcha.php?sid=<?= rand() ?>"
         alt="captcha">
    <br>
    <input type="text"
           name="captcha"
           class="form-control"
           placeholder="Enter Security Code"
           required>
</div>
<?php endif; ?>

<div id="ShowMsg"></div>

</div>

<div class="modal-footer">
    <button type="button"
            class="btn btn-default"
            onclick="window.history.back();">
        Close
    </button>

    <button type="submit"
            class="btn btn-primary">
        Submit
    </button>
</div>

</form>

</div>
</div>
</div>

</div>

<?php include 'include/footer.inc.php'; ?>

</div>
</body>
</html>

<script>
document.getElementById('regtype').addEventListener('change', function () {

    document.getElementById('divschool').style.display = 'none';
    document.getElementById('divstudent').style.display = 'none';
    document.getElementById('divdep').style.display = 'none';

    if (this.value === '1') {
        document.getElementById('divschool').style.display = 'block';
    }
    if (this.value === '2') {
        document.getElementById('divstudent').style.display = 'block';
    }
    if (this.value === '3') {
        document.getElementById('divdep').style.display = 'block';
    }
});
</script>
