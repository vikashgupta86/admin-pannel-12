<?php 
include '../appcode/globals.inc.php';
include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');

userAuthenticationPageLevel();
userAuthenticationMainLevel();

include_once('include/pageHeader.inc.php');

?>
            <?php include('include/top_user_info.inc.php');?>  

<div class="container-fluid py-4">

<h2 class="h5 border-bottom pb-2 mb-4 text-dark" style="font-weight:400;">
Manage Media
</h2>

<div class="form-box text-center mb-4">
<form id="categoryForm">
<div class="mb-3 text-start">
<label class="form-label">Choose Category <span class="text-danger">*</span></label>
<select class="form-select form-select-sm" id="m_cat_id" required>
<option value="">Select</option>
<option value="1">Banner</option>
</select>
</div>
<button type="submit" class="btn btn-primary rounded-0 px-4 fw-bold"
style="background-color:#337ab7;border-color:#2e6da4;">
Proceed
</button>
</form>
</div>

<div class="text-end mb-2">
<button type="button" class="btn btn-warning rounded-0 text-white fw-bold px-3 py-1"
data-bs-toggle="modal" data-bs-target="#mediaModal"
style="background-color:#f39c12;border-color:#e08e0b;">
Add New Photo <i class="bi bi-plus-square ms-1"></i>
</button>
</div>

<ul class="nav nav-tabs border-bottom-0" id="mediaTabs" role="tablist">
<li class="nav-item">
<button class="nav-link active rounded-0 text-dark border border-bottom-0 fw-bold"
data-bs-toggle="tab" data-bs-target="#pending" type="button">
Pending Photos
</button>
</li>
<li class="nav-item">
<button class="nav-link rounded-0 text-dark border"
data-bs-toggle="tab" data-bs-target="#published" type="button">
Published Photos
</button>
</li>
<li class="nav-item">
<button class="nav-link rounded-0 text-dark border"
data-bs-toggle="tab" data-bs-target="#rejected" type="button">
Rejected Photos
</button>
</li>
</ul>

<div class="tab-content border p-3">

<div class="tab-pane fade show active" id="pending">
<div class="table-responsive">
<table id="table1" class="table table-striped table-bordered small">
<thead>
<tr>
<th>S.No</th>
<th>Description</th>
<th>Description (Hindi)</th>
<th>Photo/Video</th>
<th>Preview</th>
<th>Created</th>
<th>Approved</th>
<th>Action</th>
</tr>
</thead>
</table>
</div>
</div>

<div class="tab-pane fade" id="published">
<div class="table-responsive">
<table id="table2" class="table table-striped table-bordered small">
<thead>
<tr>
<th>S.No</th>
<th>Description</th>
<th>Description (Hindi)</th>
<th>Photo/Video</th>
<th>Preview</th>
<th>Created</th>
<th>Approved</th>
<th>Published</th>
<th>Action</th>
</tr>
</thead>
</table>
</div>
</div>

<div class="tab-pane fade" id="rejected">
<div class="table-responsive">
<table id="table3" class="table table-striped table-bordered small">
<thead>
<tr>
<th>S.No</th>
<th>Description</th>
<th>Description (Hindi)</th>
<th>Photo/Video</th>
<th>Created</th>
<th>Rejected</th>
</tr>
</thead>
</table>
</div>
</div>

</div>
</div>

<?php include('include/pageFooter.inc.php'); ?>

<script>

let tables = {};

function loadTable(tabID){

if(!$('#m_cat_id').val()){
alert('Select category first.');
return;
}

if(tables[tabID]){
tables[tabID].ajax.reload();
return;
}

tables[tabID] = $('#table'+tabID).DataTable({
processing:true,
serverSide:false,
paging:false,
scrollY:400,
ajax:{
url:"AjaxFill/getMedia.php?EncHid=<?php echo $_SESSION['EncTok'];?>",
type:"POST",
data:{
<?php echo $GLOBALS['csrf']['token'];?>,
tabID:tabID,
m_cat_id:$('#m_cat_id').val(),
content_type_id:'<?php echo $_REQUEST['nmnh_type_id'] ?? '';?>'
}
}
});

}

$('#categoryForm').on('submit', function(e){
e.preventDefault();
loadTable(1);
});

$('button[data-bs-toggle="tab"]').on('shown.bs.tab', function(e){

let target = $(e.target).attr('data-bs-target');

if(target === '#pending') loadTable(1);
if(target === '#published') loadTable(2);
if(target === '#rejected') loadTable(3);

});

</script>