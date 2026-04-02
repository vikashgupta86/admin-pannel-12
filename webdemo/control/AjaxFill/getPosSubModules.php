<?php include '../../appcode/globals.inc.php';
AjaxFilePrevent();
userAuthenticationPageLevel();
$data=array();

$rs=simplefetch("select sm.sub_module_id,m.module_name,sm.sub_module_name,sm.fa_icon,sm.sub_module_page,sm.pos from web_st_sub_module sm
INNER JOIN web_st_module m on m.module_id=sm.module_id where m.status='Active' and sm.status='Active' and m.module_id=$_REQUEST[module_id] order by sm.pos");
if($rs[0]>0){                                
    foreach($rs[1] as $row){
    ?>
    <tr id="<?php echo $row['sub_module_id'];?>">
        <td class="reorder"><?php echo ++$sNo;?></td>
        <td><?php echo $row['sub_module_name'];?></td>
        <td class="text-center"><?php echo $row['pos'];?></td>
    </tr>
    <?php                                
    }
}
?>