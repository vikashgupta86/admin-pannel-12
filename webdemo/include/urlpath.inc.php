<?php
function getURLPath($lid,$ls_id,$level,$brdCrum='',$showL=true, $arch_id=null){    
    $level = (int)$level;
    $hindi=subquerylinkhindi2($_SESSION['lang']);
    $hindiQryjoin=subqueryjoin();

    $subQry=empty($level)?" and ls.ls_id='$ls_id' and ls.link_level is null":" and ls.ls_id='$ls_id' and ls.link_level='$level'";  
    $subQry.=empty($arch_id)?" and (ISNULL(lf.expiry_date) || lf.expiry_date>current_date())":" and (ISNULL(lf.expiry_date) || lf.expiry_date<=current_date())";  
    $rs3= simplefetch("select  $hindi lt.lang_id,case when lt.type_id!=3 then 'target=\"_blank\"' else '' end as l_target,case when ls.link_level is null then '0' else ls.link_level end as link_level,case when lt.type_id=1 then 'showfile.php' when lt.type_id=2 then 'showlink.php' else '' end as lfile,lf.lid,ls.ls_id,ls.parent_ls_id,lt.file_name,ls.status,SUBSTRING_INDEX(lt.file_name,'.',-1)as fext from web_links_final lf
INNER JOIN web_link_temp lt on lt.link_temp_id=lf.link_temp_id
INNER JOIN web_links_structure ls on ls.lid=lf.lid $hindiQryjoin
where lf.status='Active' and lt.status='Active' and ls.status='Active' $subQry  and lt.lang_id=1 order by ls.position",1);


    if($rs3[0]>0){        
        foreach($rs3[1] as $row3){


            $lClass='';
            $linkfile = empty($row3['lfile'])?create_front_links_by_link_name($row3['link_name']):$row3['lfile'];
            $newlinkfile=is_array($linkfile)?$linkfile[0]:$linkfile;

            #SAC || LOGIC TO REDIRECT TO SHOW CONTENT OR OTHER FILE BASED ON LINK NAME
            $gettt = create_front_links_by_link_name($row3['link_name']);

            if($gettt[0] != 'show_content.php'){
                header("Location: $newlinkfile?lang={$_SESSION['lang']}&level={$row3['link_level']}&ls_id={$row3['ls_id']}&lid={$row3['lid']}");
            }


            if(!empty($_GET['level']) && $_GET['level']==$level || $_GET['level']==0){
                $brdCrum=($showL)?"<li class='active'>".CleanW3cWarn($row3['link_name'])."</li>".$brdCrum:'';

              //  echo $newlinkfile;
                // header('Location: '. $newlinkfile);
            }
            else {
                //  echo "we are in else";
                $Mtitle = $Mtitle ?? '';
                $brdCrum="<li><a title=\"".CleanW3cWarn($row3['title']). $Mtitle ."\" href='$newlinkfile?lang={$_SESSION['lang']}&amp;level=$row3[link_level]&amp;ls_id=$row3[ls_id]&amp;lid=$row3[lid]'>".CleanW3cWarn($row3['link_name'])."</a></li>".$brdCrum;
            }
            #$brdCrum="<li><i class=\"fa fa-angle-double-right fa-lg\" aria-hidden=\"true\"></i> <a title=\"".CleanW3cWarn($row3['title']).$Mtitle."\" href='$newlinkfile?lang=$row3[lang_id]&amp;level=$row3[link_level]&amp;ls_id=$row3[ls_id]&amp;lid=$row3[lid]'>".CleanW3cWarn($row3['link_name'])."</a></li>".$brdCrum;                
            
        }
    }
    
    ScipLoop:
    if(($level-1)>=0)
		//return getURLPath($row3['lid'] ?? '', $row3['parent_ls_id'] ?? '', $level-1, $brdCrum, $showL, $arch_id);
        return getURLPath($row3['lid'] ?? '', $row3['parent_ls_id'] ?? '', $level - 1, $brdCrum, $showL, $arch_id);
        
    return $brdCrum;
}
?>
<ul class="breadcrumb">
    <li><a href="index.php?lang=<?php echo $_SESSION['lang'];?>" title="<?php echo __('Home');?>"><!--<i class="fa fa-home fa-lg" aria-hidden="true"></i>--><?php echo __('Home');?></a></li>
    <?php
        echo getURLPath($_GET['lid'] ?? '', $_GET['ls_id'] ?? '', $_GET['level'] ?? '', null, false, $_GET['arch'] ?? '');
    ?>

   
    
</ul>



    <div  style="margin-left: 2px; float: right;" class="hidden-print" style="width: 10%; float: right;" title="<?php echo __('Print to Page');?>">
        <button onclick="printSpecificContent('print-container')" class="">
            <i id="btnPrint" class="fas fa-print"></i>
        </button>
    </div>



    <div style="margin-left: 2px; float: right;" class="hidden-print" style="width: 2%; float: right;" role="button" title="<?php echo __('Back to Page');?>">
        <button onclick="goBack()" class="">
            <i class="fas fa-arrow-circle-left"></i>
        </button>
    </div>



