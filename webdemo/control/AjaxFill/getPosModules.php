<?php include '../../appcode/globals.inc.php';
AjaxFilePrevent();
userAuthenticationPageLevel();
$data=array();

$rs=simplefetch("select * from web_st_module where status='Active' order by pos");
if($rs[0]>0){                                
    foreach($rs[1] as $row){
    ?>
    <tr id="<?php echo $row['module_id'];?>">
        <td class="reorder"><?php echo ++$sNo;?></td>
        <td><?php echo $row['module_name'];?></td>
        <td class="text-center"><?php echo $row['pos'];?></td>
    </tr>
    <?php                                
    }
}
?>