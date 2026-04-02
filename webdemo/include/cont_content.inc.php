<?php
if(isset($_GET['lc_id'])){
    $rs=simplefetch("select wlc.lc_id,wlc.lid_main,wlc.lid,wlt.details from web_links_continuous wlc
    INNER JOIN web_link_temp wlt on wlt.link_temp_id=wlc.link_temp_id
    where wlc.status='Active' and wlt.status='Active' and wlt.continuous_content=1 and wlc.lid_main=$_GET[lid] and wlc.lc_id=$_GET[lc_id] order by wlc.position+0");
    if($rs[0]>0){
        foreach($rs[1] as $row);
    ?>
    <div class="cms-content">
        <?php
            rtfPathManage($row['details'],false);
            _html_entity_decode($row['details']);
            echo $row['details'];
        ?>
    </div>
    <?php
    }
}

$rs=simplefetch("select wlc.lc_id,wlc.lid_main,wlc.lid,wlt.details,case when wlc.position is null then '999999' else wlc.position end as nPos from web_links_continuous wlc
    INNER JOIN web_link_temp wlt on wlt.link_temp_id=wlc.link_temp_id
    where wlc.status='Active' and wlt.status='Active' and wlt.continuous_content=1 and wlc.lid_main=$_GET[lid] order by nPos+0");
if($rs[0]>0){
?>
<div class="clearfix"></div>
<div class="row text-center">
    <ul class="pagination">        
      <li class=""><a id="first" href="javascript:void(0);">&#124;&#60;</a></li>
      <li class=""><a id="prev" href="javascript:void(0);">&laquo;</a></li>    
      <li class="<?php echo (isset($_GET['lc_id']))?'':'active';?>"><a href="<?php echo "show_content.php?lang=$_SESSION[lang]&level=$_GET[level]&ls_id=$_GET[ls_id]&lid=$_GET[lid]";?>">1</a></li>
      <?php
      $sNo=1;
      foreach($rs[1] as $row){
        $actClass=(isset($_GET['lc_id'])&&$_GET['lc_id']==$row['lc_id'])?'active':'';
        ?>
        <li class="<?php echo $actClass;?>"><a href="<?php echo "show_content.php?lang=$_SESSION[lang]&level=$_GET[level]&ls_id=$_GET[ls_id]&lid=$_GET[lid]&lc_id=$row[lc_id]";?>"><?php echo ++$sNo;?></a></li>
        <?php
      }
      ?>
      <li class=""><a id="next" href="javascript:void(0);">&raquo;</a></li>
      <li class=""><a id="last" href="javascript:void(0);">&#62;&#124;</a></li>
    </ul>
</div>
<?php
}
?>

<script type="text/javascript">
function isNumber(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}
$(function(){
    $('#prev, #next').click(function(){
        if($(this).hasClass('disabled'))
            return false;
        
        switch($(this).attr('id')){
            case 'prev':
                if(isNumber($(this).closest('ul').find('.active').prev().text())==false){
                    isNumber($(this).closest('ul').find('.active').prev().addClass('disabled'));
                }
                reqURL=$(this).closest('ul').find('.active').prev().find('a').attr('href');
            break;
            
            case 'next':
                if(isNumber($(this).closest('ul').find('.active').next().text())==false){
                    isNumber($(this).closest('ul').find('.active').next().addClass('disabled'));
                }
                reqURL=$(this).closest('ul').find('.active').next().find('a').attr('href');
            break;
        }        
        window.location.href=reqURL;
    })
    
    $('#first, #last').click(function(){
        if($(this).attr('id')=='first')        
            reqURL = $('ul.pagination li:nth-child(3)').find('a').attr('href');
        else
            reqURL = $('ul.pagination li:nth-last-child(3)').find('a').attr('href');
            
        window.location.href=reqURL;
    })
})
</script>