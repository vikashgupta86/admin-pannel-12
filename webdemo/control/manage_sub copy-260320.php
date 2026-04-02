<?php 
    include '../appcode/globals.inc.php';
    include_once(BASE_PATH .'/control/include/include.inc.php');
    userAuthenticationPageLevel();
    userAuthenticationMainLevel();
    include_once('include/pageHeader.inc.php');
    include('include/top_user_info.inc.php'); 
?>
    
<h2 class="h5 content-header text-dark">Manage Sub Links</h2>


<?php
$showType=false;
include('include/chooseLang.inc.php');
?>

<?php
if(isset($_REQUEST['preSub']) && $_REQUEST['preSub']==1 && ($frmError ?? '')==false){

$lang_id = filter_input(INPUT_POST,'lang_id',FILTER_VALIDATE_INT);
?>

<div class="tree-container shadow-sm">

<h4 class="h6 border-bottom pb-2 mb-3 text-primary">
Set / Unset Sublinks
<?php if(isset($_SESSION['musume_type'])) echo $_SESSION['musume_type']; ?>
</h4>

<input type="hidden" id="lang_id" value="<?php echo $_REQUEST['lang_id'];?>">
<input type="hidden" id="nmnh_type_id_set" value="<?php echo $_REQUEST['nmnh_type_id'];?>">

<ul class="tree-list">

<?php

if($_SESSION['user_type']=='20')
{

$condition=" and (ls.entry_by='".$_SESSION['userid']."' || lt.nmnh_type='".$_SESSION['musume_type']."') ";

$rs=simplefetch("
select nls.tot,ls.ls_id,ifnull(ls.link_level,0)as link_level,
lf.lid,lt.link_name,lt.type_id,lt.lang_id,
case when ls.position is null then '9999999999' else ls.position end as lPos
from web_links_structure ls
INNER JOIN web_links_final lf on lf.lid=ls.lid
INNER JOIN web_link_temp lt on lt.link_temp_id=lf.link_temp_id
LEFT JOIN (
select count(ls_id)as tot,parent_ls_id
from web_links_structure
where status='Active' and parent_ls_id is not null
GROUP BY parent_ls_id
) nls on nls.parent_ls_id=ls.ls_id
where ls.status='Active'
and ls.link_level is null
and lt.lang_id=$lang_id
$condition
ORDER BY lt.link_name
",1);

}
else
{

$rs=simplefetch("
select nls.tot,ls.ls_id,ifnull(ls.link_level,0)as link_level,
lf.lid,lt.link_name,lt.type_id,lt.lang_id,
case when ls.position is null then '9999999999' else ls.position end as lPos
from web_links_structure ls
INNER JOIN web_links_final lf on lf.lid=ls.lid
INNER JOIN web_link_temp lt on lt.link_temp_id=lf.link_temp_id
LEFT JOIN (
select count(ls_id)as tot,parent_ls_id
from web_links_structure
where status='Active' and parent_ls_id is not null
GROUP BY parent_ls_id
) nls on nls.parent_ls_id=ls.ls_id
where ls.status='Active'
and ls.link_level is null
and lt.lang_id=$lang_id
and lt.content_type=$_REQUEST[nmnh_type_id]
ORDER BY lt.link_name
",1);

}

if($rs[0] <= 0){
echo "<li class='text-danger'>No Mainlink available</li>";
}
else{

foreach($rs[1] as $row){

$nodeID = $row['link_level'].$row['ls_id'];

$SetSubClass=$glypIcon='';

switch($row['type_id']){

case 1:
$SetSubClass='disabled';
$glypIcon='<i class="bi bi-file-earmark"></i>';
break;

case 2:
$SetSubClass='disabled';
$glypIcon='<i class="bi bi-arrow-right"></i>';
break;

case 3:
$SetSubClass='setSubLink';
$glypIcon='<i class="bi bi-laptop"></i>';
break;

}

?>

<li>

<div class="tree-item">

<?php if($row['tot']>0){ ?>

<i class="bi tree-toggle collapsed showTab"
data-id="<?php echo $nodeID;?>"
data-bs-toggle="collapse"
data-bs-target="#tab_<?php echo $nodeID;?>"></i>

<?php } else { ?>

<i class="bi bi-dash text-muted me-2"></i>

<?php } ?>

<i class="bi bi-folder tree-icon"></i>

<span class="tree-text <?php echo $SetSubClass;?>"
data-lsid="<?php echo $row['ls_id']?>"
link-levl="<?php echo $row['link_level'];?>"
link-lid="<?php echo $row['lid']?>">

<?php echo htmlspecialchars_decode($row['link_name']); ?>

</span>

<button class="btn btn-outline-secondary tree-action ms-auto setSubLink"
data-lsid="<?php echo $row['ls_id']?>"
link-levl="<?php echo $row['link_level'];?>"
link-lid="<?php echo $row['lid']?>">

<i class="bi bi-gear-fill"></i> Manage

</button>

</div>

<?php
if($row['type_id']==3){
?>

<ul class="collapse tree-sublist" id="tab_<?php echo $nodeID;?>">

<?php showChild($row['ls_id'],$row['link_level'],$row['lid'],$_REQUEST['per_id']); ?>

</ul>

<?php
}
?>

</li>

<?php
}
}
?>

</ul>

</div>

<?php
}
?>

<script>

$(function(){

$('.setSubLink').click(function(){

var lsid=$(this).data('lsid');
var level=$(this).attr('link-levl');
var lid=$(this).attr('link-lid');

var nmnh_type=$('#nmnh_type_id_set').val();

$('.modal-container').OpenPop({

url:"setSub_links.php?lsid="+lsid+"&lid="+lid+"&level="+level+
"&nmnh_type="+nmnh_type+
"&lang_id=<?= $_REQUEST['lang_id'] ?? '';?>"+
"&per_id=<?php echo $_SESSION['per_id']?>"+
"&EncHid=<?php echo $_SESSION['EncTok']?>"

});

});

$('.showTab').click(function(){

var sId=$(this).data('id');

if($('#tab_'+sId).is(':visible')){
$('#tab_'+sId).collapse('hide');
}
else{
$('#tab_'+sId).collapse('show');
}

});

});

</script>

<?php include('include/pageFooter.inc.php');?>