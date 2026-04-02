
<?php
		$HOST_FILE = $_ENV['HOST_FILE'] ?? '';
        $InnerBlock='col-md-12'; 
        
        $row['show_content']=(isset($_GET['sh_arch']) && filter_var($_GET['sh_arch'], FILTER_SANITIZE_URL) == 1)?$row['show_content']:false;
        $qry=(isset($_GET['sh_arch']) && filter_var($_GET['sh_arch'], FILTER_SANITIZE_URL) == 1)?'and (case when lf.expiry_date is null then 1=1 else  lf.expiry_date>current_date() end)':'and lf.expiry_date<=current_date()';
		//echo $row['leftBlock']."</br>";
        if($row['leftBlock'] ?? ''){#means has sublinks so generate left block
            $InnerBlock='col-md-9';  
					
            $LefBlock=$row['show_content']!=1?'col-md-12':'col-md-3';
			
			
			
        ?>
        <div class="<?php echo $LefBlock;?>">
            <?php
            require('appcode/ps_pagination.inc.php');
			
            $sql=("select case when lf.expiry_date<=current_date() then '&arch=1&sh_arch=1' else '' end as dyUrl,lt.author_name,date_format(lt.pub_date,'%d %M %Y')as pub_date,lt.lang_id,lt.link_bdesc,lt.lang_id,case when lt.type_id!=3 then 'target=\"_blank\"' else '' end as l_target,case when ls.link_level is null then '0' else ls.link_level end as link_level,case when lt.type_id=1 then 'showfile.php' when lt.type_id=2 then 'showlink.php' else '' end as lfile,lf.lid,ls.ls_id,ls.parent_ls_id,lt.link_name,lt.title,lt.type_id,lt.file_name,ls.status,case when lt.type_id=1 then SUBSTRING_INDEX(lt.file_name,'.',-1) else '' end as fext from web_links_final lf
            INNER JOIN web_link_temp lt on lt.link_temp_id=lf.link_temp_id
            INNER JOIN web_links_structure ls on ls.lid=lf.lid
            where lf.status='Active' and lt.status='Active' and ls.status='Active' and ls.parent_ls_id=$row[ls_id] and ls.link_level=($row[link_level]+1) $qry and lt.lang_id=$row[lang_id] order by ls.position desc");
			
			/*echo "select case when lf.expiry_date<=current_date() then '&arch=1&sh_arch=1' else '' end as dyUrl,lt.author_name,date_format(lt.pub_date,'%d %M %Y')as pub_date,lt.lang_id,lt.link_bdesc,lt.lang_id,case when lt.type_id!=3 then 'target=\"_blank\"' else '' end as l_target,case when ls.link_level is null then '0' else ls.link_level end as link_level,case when lt.type_id=1 then 'showfile.php' when lt.type_id=2 then 'showlink.php' else '' end as lfile,lf.lid,ls.ls_id,ls.parent_ls_id,lt.link_name,lt.title,lt.type_id,lt.file_name,ls.status,case when lt.type_id=1 then SUBSTRING_INDEX(lt.file_name,'.',-1) else '' end as fext from web_links_final lf
            INNER JOIN web_link_temp lt on lt.link_temp_id=lf.link_temp_id
            INNER JOIN web_links_structure ls on ls.lid=lf.lid
            where lf.status='Active' and lt.status='Active' and ls.status='Active' and ls.parent_ls_id=$row[ls_id] and ls.link_level=($row[link_level]+1) $qry and lt.lang_id=$row[lang_id] order by ls.position desc" ;
          //exit;*/
			
            $append="lang = $_SESSION[lang]&level=$_GET[level]&ls_id=$_GET[ls_id]&lid=$_GET[lid]";
            $pages =new PS_Pagination($connection="", $sql, $rows_per_page = 25, $links_per_page = 5, $append );                     
            $rs31[]=$pages->paginate();
			#echo '<pre>';print_r($rs3);
			#exit;
            if(isset($_REQUEST['page'])){$sno=$rs31[0][2];}
            else{$sno=0;}
            
                if($rs31[0]>0){
                    $IconShow=false;
                    foreach($rs31[0][1] as $row31){
                        if($row31['icon_name']!='no-icon.png'){
                            $IconShow='true';                            
                            break;    
                        }                        
                    }
                    
                    if($row['show_content']==2 && $IconShow==true && !in_array($_GET['lid'],array(52,53,54,77))){
                        $lPos=1;
                        echo "<div class='row'>";
                        foreach($rs31[0][1] as $row31){
                            $linkfile = empty($row31['lfile'])?create_front_links_by_link_name($row31['link_name']):$row31['lfile'];
                            if(is_array($linkfile)){
                                $newlinkfile=$linkfile[0];
                                $dUrl=$linkfile[2];    
                            }
                            else{                
                                $newlinkfile=$linkfile;
                            }
                            $bookClass=(filter_var($_GET['lid'], FILTER_SANITIZE_URL)==49)?'icwa-book':'';
                    ?>
                        <div class="col-md-4">
                            <img src="<?php echo $HOST_FILE; ?>WriteReadData/IC1425/<?php echo $row3['icon_name']?>"  height="150px" alt="" />
                            <p class="booksmain">
                                <?php
                                if(empty($bookClass)){
                                ?>
                                <a <?php echo $row31['l_target'];?> title="<?php echo CleanW3cWarn($row31['title'])?>" href="<?php echo empty($bookClass)?"$newlinkfile?lang=$row31[lang_id]&amp;level=$row31[link_level]&amp;ls_id=$row31[ls_id]&amp;lid=$row31[lid]{$dUrl}":"javascript:void(0);"?>"><?php echo CleanW3cWarn($row31['link_name'])?></a>
                                <?php    
                                }
                                else{
                                ?>
                                <?php echo CleanW3cWarn($row31['link_name']);
                                }
                                ?>
                            </p>
                            <div style="padding-left:17px;"><?php echo html_entity_decode($row31['author_name']);?><?php echo empty($bookClass)?(!empty($row31['pub_date'])?"&nbsp;|&nbsp;$row31[pub_date]":""):(!empty($row31['link_bdesc'])?"<br>$row31[link_bdesc]":"");?></div>
                        </div>
                    <?php
                        echo ($lPos++%3==0)?"</div><div class='row'>":'';
                        }
                        echo "</div>";
                    }
                    else{
                        $LefBlockFull=($LefBlock=='col-md-12')?'sidebar-links-full':'sidebar-links';
						
                        echo "<ul class=\"$LefBlockFull\">";
						
                        foreach($rs31[0][1] as $row31){ 
						
                            $newic=$row31['new_icon']=="1"?"<img alt='New Content' border=0 src='images/new.gif'>":"";
                            $linkfile = empty($row31['lfile'])?create_front_links_by_link_name($row31['link_name']):$row31['lfile'];
                            if(is_array($linkfile)){
                                $newlinkfile=$linkfile[0];
                                $dUrl=$linkfile[2];    
                            }
                            else{                
                                $newlinkfile=$linkfile;
                            }
                            echo "<li>";                                        
                                ?>
                                <a <?php echo $row31['l_target'];?> title="<?php echo CleanW3cWarn($row31['title'])?>&nbsp;<?php echo $Mtitle?>" href='<?php echo "$newlinkfile?lang=$row31[lang_id]&amp;level=$row31[link_level]&amp;ls_id=$row31[ls_id]&amp;lid=$row31[lid]{$row31['dyUrl']}"?>'><?php echo CleanW3cWarn($row31['link_name'])?><?php echo $newic; ?>
                                <?php echo getFileIcon($row3['fext']);?>
                                </a>
                                
                                <?php                        
                            echo "</li>";
                        }
						
                        echo "</ul>";                        
                        if($rs31[0][4]>1 && $LefBlock=='col-md-12'){
                            echo '<div class="row text-center"> '. $pages->renderFullNav()  . '</div>';
                        }
                    }
                }
            ?>        
        </div>
        <?php
        }
        
        if($row['show_content']=='1'){
        ?>
        <div class="<?php echo $InnerBlock;?>">   
            <div class="container cms-content">
                <?php
                    rtfPathManage($row1['details'],false);
                    echo html_entity_decode($row1['details']);
                ?>
            </div>     
        </div>
    <?php
        }
    ?>
    