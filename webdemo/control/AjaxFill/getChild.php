<?php include '../../appcode/globals.inc.php';
$obj->AjaxFilePrevent();
$obj->userAuthenticationPageLevel();

$str1='<div class="form-group"><label for="ddlParent">Select Parent</label><select name="ddlParent" id="ddlParent" class="form-control" data-validate="ddlParent|text|n|1|10|num|dontselect=-1|Please enter Valid option!" onchange="handleSelectChange(event)"><option value="-1">--- Select ---</option>';

$rs=$obj->fetchtable("organogram","status='Active' and parent_id=$_REQUEST[parent_id] order by organo_id",1);

if($rs[0]>0){
    foreach($rs[1] as $row){        
        $str1 .="<option value='".$row['organo_id']."' title='$row[organo_name]'>".($row['organo_name'])."</option>";
    }
	$str1 .= '</select></div>';
echo $str1;
}
