<?php include '../appcode/globals.inc.php';
include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');

//die('This file is no longer in use!');
AjaxFilePrevent();
userAuthenticationPageLevel();
$data=array();

$rs=simplefetch("select lc.lc_id,lc.position,wlt.main_link_temp_id,lc.lid,ifnull(date_format(wlt.expiry_date,'%M %d, %Y'),'N/A')as expiry_date,wlt.link_temp_id,wlt.lang_id,wlt.type_id,wlt1.link_name,concat(wu.user_name,' [',date_format(wlt.creation_date,'%d/%m/%Y'),' ]')as cName
        ,concat(ru.user_name,' [',date_format(wlt.app_rej_action_on,'%M %d, %Y'),' ]')as rName,concat(pu.user_name,' [',date_format(lc.publish_date,'%M %d, %Y'),' ]')as pName,case when lc.position is null then '999999' else lc.position end as nPos from web_link_temp wlt
INNER JOIN web_users wu on wu.user_id=wlt.creator_id
INNER JOIN web_users ru on ru.user_id=wlt.app_rej_user_id
INNER JOIN web_links_continuous lc on lc.link_temp_id=wlt.link_temp_id
INNER JOIN web_users pu on pu.user_id=lc.publish_by
INNER JOIN (select lf.lid,wlt.link_name,l.lang from web_links_final lf
    INNER JOIN web_link_temp wlt on lf.link_temp_id=wlt.link_temp_id
    INNER JOIN web_lang l on l.lang_id=wlt.lang_id
    where lf.status='Active' and wlt.`status`='Active' and lf.lid= " . $_REQUEST['lid'] . ")wlt1 on wlt1.lid=wlt.main_link_temp_id
 where wlt.`status`='Active' and wlt.continuous_content=1 and wlt.lang_id= " . $_REQUEST['lang_id'] ." and wlt.main_link_temp_id= " . $_REQUEST['lid'] . " order by nPos+0,lc.lc_id");
if($rs[0]>0){                                
    foreach($rs[1] as $row){
    ?>
    <tr id="<?php echo $row['lc_id'];?>">
        <td class="reorder"><?php echo ++$sNo;?></td>
        <td><?php echo "PageNo. - ".$sNo;?></td>
        <td><?php echo "<div class=\"text-center tools\">                        
                        <i class=\"fa fa-eye Lpreview\" data-toggle=\"tooltip\" aria-hidden=\"true\" cdata-frmT='7' data-link_temp_id='$row[link_temp_id]' title='Preview'></i>
                    </div>";?></td>
        <td class="text-center"><?php echo $row['position'];?></td>
    </tr>
    <?php                                
    }
}
?>