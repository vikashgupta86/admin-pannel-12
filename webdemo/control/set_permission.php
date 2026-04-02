<?php include '../appcode/globals.inc.php';
include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');
userAuthenticationPageLevel();
userAuthenticationMainLevel();
include_once 'include/pageHeader.inc.php';
$frmError = $secFrmFlage = false;
?>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php include 'include/top_user_info.inc.php';?>
        <!-- Left side column. contains the logo and sidebar -->
        <?php //include 'include/left_nav.inc.php';?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Set Permission</h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <form name="frm" id="frm" action="<?php echo curPageName() . "?per_id={$_REQUEST['per_id']}&EncHid={$_SESSION['EncTok']}" ?>" role="form" class="form-border clearfix col-sm-6 col-sm-offset-3" method="post">
                    <input type="hidden" name="preSub" id="preSub" value="1" />
                    <div class="mb-3">
                      <label for="user_id" class="form-label">Choose User</label>
<select name="user_id" id="user_id" class="form-control"
data-validate="user_id|text|y|1|10|num|dontselect=-1|Please enter Valid option!">

<option value="-1">--- Select ---</option>

<?php

$selectedUser = $_REQUEST['user_id'] ?? '';

$subQry1 = ($_SESSION['user_type'] != 1)
    ? " AND wu.user_type_id != 1 AND wu.user_id != ".$_SESSION['userid']
    : "";

$rs2 = simplefetch("
SELECT wut.user_type, wut.user_type_id
FROM web_users wu
INNER JOIN web_st_user_type wut 
    ON wu.user_type_id = wut.user_type_id
WHERE wu.status='Active' 
AND wut.status='Active'
$subQry1
GROUP BY wut.user_type_id
");

if ($rs2[0] > 0) {

    foreach ($rs2[1] as $row2) {

        echo "<optgroup label='".htmlspecialchars($row2['user_type'])."'>";

        $rs3 = simplefetch("
        SELECT wu.user_id, wu.uname
        FROM web_users wu
        INNER JOIN web_st_user_type wut 
            ON wu.user_type_id = wut.user_type_id
        WHERE wu.status='Active'
        AND wut.status='Active'
        AND wut.user_type_id=".$row2['user_type_id']."
        ");

        if ($rs3[0] > 0) {

            foreach ($rs3[1] as $row3) {

                $selected = ($row3['user_id'] == $selectedUser) ? "selected" : "";

                echo "<option value='".$row3['user_id']."' $selected>"
                     .htmlspecialchars($row3['uname']).
                     "</option>";
            }
        }

        echo "</optgroup>";
    }
}

?>

</select>
            </div>
            <div class="col-sm-8 col-sm-offset-4">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>



    <?php
    if (isset($_REQUEST['preSub']) && $_REQUEST['preSub'] == 1 && $frmError == false) {
       $secFrmFlage = true;
       $userTypeId = getName("web_users", "user_type_id", "user_id=$_REQUEST[user_id]");
       ?>
       <div class="box-body clearfix">
        <div class="panel panel-default">
            <div class="panel-heading box-title mt-5"><b>Permission's List</b></div>
            <div class="panel-body">
             <form class="clearfix" name="frmmain" id="frmmain" method="post" action="<?php echo curPageName(false); ?>_action.php">
                <input type="hidden" name="per_id" id="per_id" value="<?php echo $_REQUEST['per_id'] ?>" />
                <input type="hidden" name="EncHid" id="EncHid" value="<?php echo $_SESSION['EncTok'] ?>" />
                <input type="hidden" name="user_id" id="user_id" value="<?php echo $_REQUEST['user_id']; ?>" />
                <div class="col-sm-12 col-sm-offset-2">
        <table id="GridData" class="table table-bordered table-striped table-hover clearfix">
<thead>
<tr>
<th>S.No</th>
<th>Module Name</th>

<?php
$rs2 = fetchcols("web_st_permission_type", "per_type_id,per_type_name");

if ($rs2[0] > 0) {
    foreach ($rs2[1] as $row2) {
?>
<th class="text-center">
<?php echo $row2['per_type_name']; ?>

<input
class="chkAll"
type="checkbox"
name="chk_<?php echo $row2['per_type_id']; ?>[]"
id="chkR<?php echo $row2['per_type_id']; ?>"
value="<?php echo $row2['per_type_id']; ?>"
>

</th>
<?php
    }
}
?>

</tr>
</thead>

<tbody>

<?php

$subQry = "";
$s = 1;

$str = "";
$str1 = "";
$flage = false;

$userId = (int)($_REQUEST['user_id'] ?? 0);

$rs = simplefetch("select m.module_name,m.module_id from web_st_module m,web_st_sub_module sm where m.status='Active' and sm.status='Active' and m.module_id=sm.module_id $subQry group by m.module_id order by m.pos");

if ($rs[0] > 0) {

foreach ($rs[1] as $row) {

$rs1 = simplefetch("select wsm.sub_module_id,wsm.sub_module_name, wsm.per_type_id from web_map_func_user_type wut INNER JOIN web_st_sub_module wsm on wut.sub_module_id=wsm.sub_module_id INNER JOIN web_st_module wm on wm.module_id=wsm.module_id WHERE wut.`status`='Active' and wsm.`status`='Active' and wm.`status`='Active' and wut.user_type_id=$userTypeId and wm.module_id=".$row['module_id']." ORDER BY wsm.sub_module_name");

if ($rs1[0] > 0) {

$flage = true;
?>

<tr>
<td colspan="<?php echo 2 + $rs2[0]; ?>">
<b><?php echo $row['module_name']; ?></b>
</td>
</tr>

<?php

$sNo = 0;

foreach ($rs1[1] as $row1) {

$PerArr = explode(',', $row1['per_type_id']);

if ($str === "") {
$str = $row1['sub_module_id'];
} else {
$str .= '|$$|' . $row1['sub_module_id'];
}

?>

<tr>

<td class="reorder"><?php echo ++$sNo; ?></td>

<td><?php echo $row1['sub_module_name']; ?></td>

<?php

if ($rs2[0] > 0) {

foreach ($rs2[1] as $row2) {

if ($str1 === "") {
$str1 = $row2['per_type_id'];
} else {
$str1 .= '|$$|' . $row2['per_type_id'];
}

if (in_array($row2['per_type_id'], $PerArr)) {

$Per = getNameQry("select up.per_id from web_user_permission up, web_user_permission_group upg where up.status='Active' and upg.status='Active' and up.per_id=upg.per_id and up.sub_module_id=".$row1['sub_module_id']." and upg.per_type_id=".$row2['per_type_id']." and up.user_id=".$userId);

?>

<td class="text-center error-message">

<div>

<input
type="checkbox"
name="chk<?php echo $row1['sub_module_id'].'_'.$row2['per_type_id']; ?>"
id="chk<?php echo $row1['sub_module_id'].'_'.$row2['per_type_id']; ?>"
value="<?php echo $row2['per_type_id']; ?>"
<?php echo !empty($Per) ? "checked" : ""; ?>
>

</div>

</td>

<?php
}
else {

echo '<td class="DataCenter">N/A</td>';

}

}
}
?>

</tr>

<?php
}
}
}
}
?>

<input type="hidden" name="sub_SF_str" id="str1" value="<?php echo $str1; ?>" />
<input type="hidden" name="sub_M_str" id="str" value="<?php echo $str; ?>" />

</tbody>
</table>
<?php    //  if ($rs1[0] > 0) {?>
    <div class="col-sm-5 col-sm-offset-5 clearfix">
        <input type="submit" name="submit" id="submit" class="btn btn-primary " value="Update" />
    </div>
    <?php //}?>
</div>
</form>
</div>
</div>

<div id="ShowMsg"></div>
</div>
<?php
}
?>
<!-- /.box-body -->
</div>
</div>
<!-- /.content-wrapper -->
<?php include 'include/pageFooter.inc.php';?>

<div class="control-sidebar-bg"></div>
</div>
</body>
<script type="text/javascript">
    function subFrm(){
        $.base64.utf8encode = true;
        $.ajax({
            type     : "POST",
            dataType: "text",
            cache    : false,
            url      : $('#frmmain').attr('action'),
            data     : $('#frmmain').serialize(),
            beforeSend: function(){
                $.fn.ajaxLoading();
            },
            success  : function(data) {
                try{
                    data=$.parseJSON($.base64.atob(data));
                    if(data[0]){
                        $('#ShowMsg').ShowMsg({msg:'Request Completed Successfully!',alertClass:'alert-success'});
                    }
                    else{
                        if(data[1]!= undefined && data[1][0]==true){
                            FEror=data[1][1];
                            $.fn.ShowError(FEror);
                        }
                        else if(data[2]!= undefined && data[2][0]==true){
                            MEror=data[2][1];
                            $('#ShowMsg').ShowMsg({msg:MEror,alertClass:data[2][2]});
                        }
                        else{
                            $('#ShowMsg').ShowMsg({msg:'Request not Completed Successfully!',alertClass:'alert-danger'});
                        }
                    }
                }
                catch(err) {
                    $('#ShowMsg').ShowMsg({msg:"<strong>Error:</strong> Unexpected Response received, You may try again!",alertClass:'alert-warning'});
                }

            },
            error:function(){
                $.fn.custom_alert({msg:'Something went wrong, Please try again!'});
            },
            complete: function(){
                $.fn.ajaxLoading({show:false});
            },
        });
    }



    $(function(){


        function ChkMe(val){
            var x=0;
            var Str=document.getElementById('str').value;
            var Arr=Str.split('|$$|');
            for(x in Arr){
                if(document.getElementById('chkR'+val).checked==true){
                    $('#'+'chk'+Arr[x]+'_'+val).length >0 ?document.getElementById('chk'+Arr[x]+'_'+val).checked=true:'';
                }
                else{
                    $('#'+'chk'+Arr[x]+'_'+val).length >0 ?document.getElementById('chk'+Arr[x]+'_'+val).checked=false:'';
                }
            }
        }

        $('#frm').formChecks().SetToFirstFocus();
        <?php
        if ($secFrmFlage == true) {
           ?>
           $('#frmmain').formChecks({ajaxSubFunc:subFrm}).SetToFirstFocus();
           <?php
       }
       ?>
       $('.chkAll').click(function(){
        ChkMe($(this).val());
    })
   })

</script>
