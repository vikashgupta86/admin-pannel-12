<style>

.fancybox-thumb img

{
    height: 200px;
    width: 100%;
}

.fancybox 
{
    margin-bottom: 30px;
}

.btn:focus, .btn:active, button:focus, button:active {
  outline: none !important;
  box-shadow: none !important;
}

#image-gallery .modal-footer{
  display: block;
}

button
{
    background: transparent;
    border: none;
}

.thumb{
  margin-top: 15px;
  margin-bottom: 15px;
  min-height:300px!important;
}
.img-thumbnail
{
	height: 150px;
	width:100%;
}
.thumbnail p
{
    font-size: 14px;
    padding: 5px 5px;
    margin: 0px 0px;
    line-height: 22px;
    color: #000;
	min-height: 120px;
    background-color: #dee2e6;
}
.modal-header h4
{
    color: #fff;
    font-size: 14px;
    font-weight: 600;
    padding: 0px 0px 0px 0px;
    margin: 0px 0px 0px 0px;
}

.modal-header {
    background-color: #c19514 !important;
    border-radius: 0px;
    padding: 10px 10px;
    font-weight: normal;
}

</style>

<?php
$dUrl = null;
$hindi = $hindi ?? '';
$hindiQryjoin = $hindiQryjoin ?? '';
$subQrybrd=empty($_GET['level'])?" and ls.ls_id='$_GET[ls_id]' and ls.link_level is null":" and ls.ls_id='$_GET[ls_id]' and ls.link_level='$_GET[level]'";  
    $subQrybrd.=empty($arch_id)?" and (ISNULL(lf.expiry_date) || concat(lf.expiry_date,' ',ifnull(lf.expiry_time,'00:00:00'))>CURRENT_TIMESTAMP())":" and (ISNULL(lf.expiry_date) || concat(lf.expiry_date,' ',ifnull(lf.expiry_time,'00:00:00'))<=CURRENT_TIMESTAMP())";  
    
	$subQrybrd.="and concat(lf.publish_date,' ',ifnull(lf.publish_time,'00:00:00'))<=CURRENT_TIMESTAMP()";  

    $rsbrd=simplefetch("select  $hindi lt.lang_id,case when lt.type_id!=3 then 'target=\"_blank\"' else '' end as l_target,case when ls.link_level is null then '0' else ls.link_level end as link_level,case when lt.type_id=1 then 'showfile.php' when lt.type_id=2 then 'showlink.php' else '' end as lfile,lf.lid,ls.ls_id,ls.parent_ls_id,lt.file_name,ls.status,SUBSTRING_INDEX(lt.file_name,'.',-1)as fext from web_links_final lf
INNER JOIN web_link_temp lt on lt.link_temp_id=lf.link_temp_id
INNER JOIN web_links_structure ls on ls.lid=lf.lid $hindiQryjoin
where lf.status='Active' and lt.status='Active' and ls.status='Active' $subQrybrd  and lt.lang_id=1 and lt.l_sub_type='1' order by ls.position desc limit 1",1);

    
    if($rsbrd[0] > 0){
        foreach($rsbrd[1] as $d);
     $lbr=$d['parent_ls_id'];
    }

   if($lbr==""){
    $liddata=$_GET['ls_id'];
   }
   else{
     $liddata=$lbr;
   }


  if($_GET['level'] == 0){
       
      $l="  and ls.link_level=1";
    }
     else{
      $l="  and ls.link_level=($row[link_level])";
    }


 if($_GET['level'] > 0){
     $row['leftBlock']=1;
}




if($row['leftBlock']){#means has sublinks so generate left block
    $InnerBlock='col-md-9'; 

         
    $LefBlock=$row['show_content']==2?'col-md-12':'col-md-3';
	
        ?>
        <div class="<?php echo $LefBlock;?>" style="border:0px solid red;">
            <?php
            $hindiQry=null;
            $hindi=subquerylinkhindi2($_SESSION['lang']);
			$hindiQryjoin=subqueryjoin();
            $linSubQry = $linSubQry ?? null;


            require('appcode/ps_pagination.inc.php');
            $sortQry = (isset($linSubQry) /*|| count($LfieldArray)>0*/)?" p_date desc":" ls.position desc";#sort condition based on searchable and others
            $sortQry = (isset($linSubQry) /*|| count($LfieldArray)>0*/)?" p_date desc":" ls.position desc";#sort condition based on searchable and others
            $sql1=("select hindi_id,$hindi lt.author_name,lt.pub_date as p_date, date_format(lt.pub_date,'%d %M %Y')as pub_date,lt.lang_id,lt.link_bdesc,case when lt.type_id!=3 then 'target=\"_blank\"' else '' end as l_target,case when ls.link_level is null then '0' else ls.link_level end as link_level,case when lt.type_id=1 then 'showfile.php' when lt.type_id=2 then 'showlink.php' else '' end as lfile,lf.lid,ls.ls_id,ls.parent_ls_id,lt.file_name,ls.status,case when lt.type_id=1 then SUBSTRING_INDEX(lt.file_name,'.',-1) when lt.type_id=2 then 'url' else '' end as fext,case when lf.icon_name is null then 'no-icon.png' else lf.icon_name end as icon_name, lt.details, lf.new_icon from web_links_final lf
            INNER JOIN web_link_temp lt on lt.link_temp_id=lf.link_temp_id
            INNER JOIN web_links_structure ls on ls.lid=lf.lid $hindiQryjoin
            where lf.status='Active' and lt.status='Active' and ls.status='Active' and concat(lf.publish_date,' ',ifnull(lf.publish_time,'00:00:00'))<=CURRENT_TIMESTAMP() and ls.parent_ls_id='$liddata' $l and (case when lf.expiry_date is null then '1=1' else  concat(lf.expiry_date,' ',ifnull(lf.expiry_time,'00:00:00'))>CURRENT_TIMESTAMP() end) and lt.lang_id=$row[lang_id] $linSubQry order by $sortQry");
            
        //echo $sql1 ;
          //die;
		  
            $append.="lang=$_SESSION[lang]&level=$_GET[level]&ls_id=$_GET[ls_id]&lid=$_GET[lid]";
            $pages =new PS_Pagination($connection="", $sql1, $rows_per_page = 65, $links_per_page = 5, $append );                     
            $rs31[]=$pages->paginate();
            #echo '<pre>';print_r($rs3);
            if(isset($_REQUEST['page'])){$sno=$rs31[0][2];}
            else{$sno=0;}
            #if($total[0]>0){
            /*$rs3=simplefetch("select lt.author_name,date_format(lt.pub_date,'%d %M %Y')as pub_date,lt.lang_id,lt.link_bdesc,case when lt.type_id!=3 then 'target=\"_blank\"' else '' end as l_target,case when ls.link_level is null then '0' else ls.link_level end as link_level,case when lt.type_id=1 then 'showfile.php' when lt.type_id=2 then 'showlink.php' else '' end as lfile,lf.lid,ls.ls_id,ls.parent_ls_id,lt.link_name,lt.title,lt.type_id,lt.file_name,ls.status,case when lt.type_id=1 then SUBSTRING_INDEX(lt.file_name,'.',-1) else '' end as fext,case when lf.icon_name is null then 'no-icon.png' else lf.icon_name end as icon_name from web_links_final lf
            INNER JOIN web_link_temp lt on lt.link_temp_id=lf.link_temp_id
            INNER JOIN web_links_structure ls on ls.lid=lf.lid
            where lf.status='Active' and lt.status='Active' and ls.status='Active' and ls.parent_ls_id=$row[ls_id] and ls.link_level=($row[link_level]+1) and (ISNULL(lf.expiry_date) || concat(lf.expiry_date,' ',ifnull(lf.expiry_time,'00:00:00'))>=CURRENT_TIMESTAMP()) and lt.lang_id=$row[lang_id] order by ls.position desc");*/
                if($rs31[0]>0){
                    $IconShow=false;
                    foreach($rs31[0][1] as $row31){
                        if($row31['icon_name']!='no-icon.png'){
                            $IconShow='true';                            
                            break;    
                        }                        
                    }
                    
                    if($row['show_content']==2&&$IconShow==true /*&& !in_array($_GET['lid'],array(52,53,54,77))*/){#means links with icon showing
                        $lPos=1;
                        
                        #custom view based on this for books and research faculty
                        $bookClass=($_GET['lid']==49 || $_GET['lid']==74 )?'icwa-book':'';
                        
                        #make custom popup view for research faculty                            
                        $sPopClass=(in_array(trim(strtolower($row['link_name'])),array('research faculty','books' )))?'showPop':'';
                        
                        echo "<div class='row'>";
                        foreach($rs31[0][1] as $row31){
                            $linkfile = empty($row31['lfile'])?create_front_links_by_link_name($row31['link_name']):$row31['lfile'];
                            if(is_array($linkfile)){
                                $newlinkfile=$linkfile[0];
                                $dUrl=$linkfile[2] ?? '';    
                            }
                            else{                
                                $newlinkfile=$linkfile;
                            }                            
                            $showMid=(($rs3[0][0] ?? '')==$lPos && $lPos++%3==1)?" col-md-offset-4":'';                                                                                    
                    ?>                    
                        <div class="col-md-4 <?php echo $bookClass.$showMid;?>">
                            <!--<img src="WriteReadData/IC1425/<?php echo $row3['icon_name'] ?? ''; ?>" height="150px" />-->
                            <p class="booksmain <?php echo !empty($sPopClass)?'CopyIcon '.$sPopClass:'';?>" <?php echo !empty($sPopClass)?"data-lid='$row31[lid]'":'';?>>
                                <?php                                
                                $row31['link_name']=(isset($_GET['lid']) && $_GET['lid']==67)?'':$row31['link_name'];
                                if(empty($bookClass)){
                                ?>
                                    <div class="imghover-inner" ><a <?php echo $row31['l_target'];?> title="<?php echo CleanW3cWarn($row31['title'] ?? '')?>" href="<?php echo empty($bookClass)?"$newlinkfile?lang=$_SESSION[lang]&amp;level=$row31[link_level]&amp;ls_id=$row31[ls_id]&amp;lid=$row31[lid]{$dUrl}":"javascript:void(0);"?>"><img src="WriteReadData/IC1425/<?php echo $row31['icon_name']?>" height="220px" /><br/><br/><?php echo CleanW3cWarn($row31['link_name'] ?? '')?></a></div>                                
                                <?php    
                                }
                                else{
                                ?>
                                <img src="WriteReadData/IC1425/<?php echo $row31['icon_name']?>" height="220px" /><?php echo CleanW3cWarn($row31['link_name']);                                
                                }
                                ?>
                            </p>
                            <div style="padding-left:17px; color:#614b4b"><?php echo html_entity_decode($row31['author_name'] ?? '');?><?php echo empty($bookClass)?(!empty($row31['pub_date'])?"&nbsp;|&nbsp;$row31[pub_date]":""):(!empty($row31['link_bdesc'])?"<br>$row31[link_bdesc]":"");?></div>
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
                                $dUrl=$linkfile[2] ?? '';    
                            }
                            else{                
                                $newlinkfile=$linkfile;
                            }
                            /*Condition for the FAQ*/
                            if($row['link_name']=='FAQs'){
                                echo "<li  data-toggle='collapse' data-target='#faq_".$row31['lid']."'><a href='javascript:void(0)'>".CleanW3cWarn($row31['link_name'])."</a> $newic</li>";
                            ?>
                            <div  class="faq-details collapse" id='faq_<?php echo $row31['lid'];?>'><?php 
                                rtfPathManage($row31['details'],false);
                                _html_entity_decode($row31['details']);
                                echo $row31['details'];
                             ?></div>
    
                            <?php
                            }
                            else{
                            //echo "<li>"; 
                            
                              if ($row31['link_name'] != ""){
                               ?>
                               <li <?php if (($rows[31]['lid'] ?? '') == $_GET['lid']){?> style="color: #fff; border-left: 3px solid #3f93f3; box-shadow: inset 430px 0 0 0 #004696" <?php }?>>
                                 
                               <a <?php if (($rows[31]['lid'] ?? '') == $_GET['lid']){?> style="color: #fff; box-shadow: inset 430px 0 0 0 #004696" <?php }?><?php echo $row31['l_target'];?> title="<?php echo CleanW3cWarn($row31['title'])?>&nbsp;<?php echo $Mtitle ?? '' ?>" href='<?php echo "$newlinkfile?lang=$_SESSION[lang]&amp;level=$row31[link_level]&amp;ls_id=$row31[ls_id]&amp;lid=$row31[lid]{$dUrl}"?>'><?php echo CleanW3cWarn($row31['link_name'])?><?php echo $newic; ?>
                                <?php echo getFileIcon($row31['fext']),filesize_formatted($row31['file_name']); ?>
                                </a>
                                <div style="padding-left:15px; color:#614b4b"><?php echo html_entity_decode($row31['author_name'] ?? '');?><?php echo empty($bookClass)?(!empty($row31['pub_date'])?"&nbsp;|&nbsp;$row31[pub_date]":""):(!empty($row31['link_bdesc'])?"<br>$row31[link_bdesc]":"");?></div>
                                </li>
								<?php                        
                            //echo "</li>";
                            }
                            }
                        }
                        echo "</ul>";                    
                    }
                                        
                        
                    if($rs31[0][4]>1 && $LefBlock=='col-md-12'){
                        echo '<div class="row text-center" style="border:0px solid green;"> '. $pages->renderFullNav()  . '</div>';
                    }
                }
            ?>        
        </div>
        <?php
        }

			//echo "value=" . $_GET[ls_id];
			//echo $liddata;
        if($row['show_content']==1){
        ?>
        <div class="<?php echo $InnerBlock ?? '';?>">
            <div id="dvContents2">
<?php
			/*if($_GET[ls_id]==244)
			{
                if($_GET['lang']=='1'){
				    include 'include/orgchart.html';
                }
                else if($_GET['lang']=='2'){
                        include 'include/orgchart_hindi.html';
                }
                else{}
			}*/

?>
		<?php if(!isset($_GET['lc_id'])){?>   
            <div class="cms-content">
			
				<div class="row">
					<div class="col-md-12">

						<h4 class="innerheading" id="link_name">
						<?php
						if ($_SESSION['lang'] == "1") {
							echo html_entity_decode($row['link_name']);
						} else {

							//echo html_entity_decode($row['hindi_name']);
                            echo html_entity_decode($row['hindi_name'] ?? "");
						}
						#echo (isset($_GET['arch'])&& $_GET['arch']==1)?" ( Archived )":'';
						?></h4></br>
						<div class="auth_nam_dat"><?php echo html_entity_decode($row['author_name'] ?? ''); ?><?php echo !empty($row['pub_date']) ? "&nbsp;|&nbsp;$row[pub_date]" : ""; ?></div>
					</div>
				</div>

			<?php
				
                if($_SESSION['lang']=="2" || $_SESSION['lang']=="3" && !empty($row['hdetails']))
                            {
                     rtfPathManage($row['hdetails'],false);
                    html_entity_decode($row['hdetails'] ?? "");
                    echo $row['hdetails'];  
                    
                    }
					
					else
                    {
                        
                       rtfPathManage($row['details'],false); 
                   // _html_entity_decode($row['details'] ?? '');
                    echo html_entity_decode($row['details'] ?? '');
					echo $row['details'];
					echo $row['linkname'] ?? '';
    
                    }
                ?>
            </div>
            <?php
            }


$InnerBlock='col-md-12';
if($row['link_level'] >0){#means has sublinks so generate left block
    $InnerBlock='col-md-9'; 

         
    //$LefBlock=$row['show_content']==2?'col-md-12':'col-md-3';
    $LefBlock='col-md-12';
        ?>
        <div class="<?php echo $LefBlock;?>" style="border:0px solid red;">
            <?php
            $hindiQry=null;
               $hindi=subquerylinkhindi2($_SESSION['lang']);
    $hindiQryjoin=subqueryjoin();
            //require('appcode/ps_pagination.inc.php');


            $sortQry = (isset($linSubQry) /*|| count($LfieldArray)>0*/)?" p_date desc":" ls.position desc";#sort condition based on searchable and others
            $sortQry = (isset($linSubQry) /*|| count($LfieldArray)>0*/)?" p_date desc":" ls.position desc";#sort condition based on searchable and others

            $sql=("select hindi_id,$hindi lt.author_name,lt.pub_date as p_date, date_format(lt.pub_date,'%d %M %Y')as pub_date,lt.lang_id,lt.link_bdesc,case when lt.type_id!=3 then 'target=\"_blank\"' else '' end as l_target,case when ls.link_level is null then '0' else ls.link_level end as link_level,case when lt.type_id=1 then 'showfile.php' when lt.type_id=2 then 'showlink.php' else '' end as lfile,lf.lid,ls.ls_id,ls.parent_ls_id,lt.file_name,ls.status,case when lt.type_id=1 then SUBSTRING_INDEX(lt.file_name,'.',-1) when lt.type_id=2 then 'url' else '' end as fext,case when lf.icon_name is null then 'no-icon.png' else lf.icon_name end as icon_name, lt.details, lf.new_icon from web_links_final lf
            INNER JOIN web_link_temp lt on lt.link_temp_id=lf.link_temp_id
            INNER JOIN web_links_structure ls on ls.lid=lf.lid $hindiQryjoin
            where lf.status='Active' and lt.status='Active' and ls.status='Active' and ls.parent_ls_id=$row[ls_id] and ls.link_level=($row[link_level]+1) /* and concat(lf.publish_date,' ',ifnull(lf.publish_time,'00:00:00'))<=CURRENT_TIMESTAMP() and (case when lf.expiry_date is null then '1=1' else  concat(lf.expiry_date,' ',ifnull(lf.expiry_time,'00:00:00'))>CURRENT_TIMESTAMP() end)*/ and lt.lang_id=$row[lang_id] $linSubQry order by $sortQry");

        //echo $sql ;
         //  die;
            $append.="lang=$_SESSION[lang]&level=$_GET[level]&ls_id=$_GET[ls_id]&lid=$_GET[lid]";
            $pages =new PS_Pagination($connection="", $sql, $rows_per_page = 65, $links_per_page = 5, $append );                     
            $rs3[]=$pages->paginate();
            #echo '<pre>';print_r($rs3);
            if(isset($_REQUEST['page'])){$sno=$rs3[0][2];}
            else{$sno=0;}
            #if($total[0]>0){
            $rs3=simplefetch("select hindi_id,$hindi lt.author_name,lt.pub_date as p_date, date_format(lt.pub_date,'%d %M %Y')as pub_date,lt.lang_id,lt.type_id,lt.link_bdesc,case when lt.type_id!=3 then 'target=\"_blank\"' else '' end as l_target,case when ls.link_level is null then '0' else ls.link_level end as link_level,case when lt.type_id=1 then 'showfile.php' when lt.type_id=2 then 'showlink.php' else '' end as lfile,lf.lid,ls.ls_id,ls.parent_ls_id,lt.file_name,ls.status,case when lt.type_id=1 then SUBSTRING_INDEX(lt.file_name,'.',-1) when lt.type_id=2 then 'url' else '' end as fext,case when lf.icon_name is null then 'no-icon.png' else lf.icon_name end as icon_name, lt.details, lf.new_icon from web_links_final lf
            INNER JOIN web_link_temp lt on lt.link_temp_id=lf.link_temp_id
            INNER JOIN web_links_structure ls on ls.lid=lf.lid $hindiQryjoin
            where lf.status='Active' and lt.status='Active' and ls.status='Active' and ls.parent_ls_id=$row[ls_id] and ls.link_level=($row[link_level]+1) and concat(lf.publish_date,' ',ifnull(lf.publish_time,'00:00:00'))<=CURRENT_TIMESTAMP() and (case when lf.expiry_date is null then '1=1' else  concat(lf.expiry_date,' ',ifnull(lf.expiry_time,'00:00:00'))>CURRENT_TIMESTAMP() end) and lt.lang_id=$row[lang_id] and lt.l_sub_type='1'  $linSubQry order by $sortQry",1);



#         $rows = $result->fetch_all(MYSQLI_ASSOC);


    if($rs3[0]>0){
                    $IconShow=false;

								
                                // $rs1=fetchtable("nmnh_type","status='Active' $dept_type",1);
                                // if($rs1[0]>0){
                                //     foreach($rs1[1] as $row1){
                                //         if(($_REQUEST['nmnh_type_id'] ?? '') ==$row1['id'])
                                //             echo "<option value='$row1[id]' selected=''>$row1[nmnh_type]</option>";
                                //         else
                                //             echo "<option value='$row1[id]'>$row1[nmnh_type]</option>";
                                //     }
                                // }
                                


//                                if($rs3[0] > 0){

                                    foreach($rs3[1] as $row3){


                                        if($row3['icon_name']!='no-icon.png'){
                                            $IconShow='true';                            
                                            break;  
                                        }                        
                                    }
                     //           }
                    
                    if($row['show_content']==2&&$IconShow==true /*&& !in_array($_GET['lid'],array(52,53,54,77))*/){#means links with icon showing
                        $lPos=1;
                        
                        #custom view based on this for books and research faculty
                        $bookClass=($_GET['lid']==49 || $_GET['lid']==74 )?'icwa-book':'';
                        
                        #make custom popup view for research faculty                            
                        $sPopClass=(in_array(trim(strtolower($row['link_name'])),array('research faculty','books' )))?'showPop':'';
                        
                        echo "<div class='row'>";
                        foreach($rs3[0][1] as $row3){
                            $linkfile = empty($row3['lfile'])?create_front_links_by_link_name($row3['link_name']):$row3['lfile'];
                            if(is_array($linkfile)){
                                $newlinkfile=$linkfile[0];
                                $dUrl=$linkfile[2] ?? '';    
                            }
                            else{                
                                $newlinkfile=$linkfile;
                            }                            
                            $showMid=($rs3[0][0]==$lPos && $lPos++%3==1)?" col-md-offset-4":'';                                                                                    
                    ?>                    
                        <div class="col-md-4 <?php echo $bookClass.$showMid;?>">
                            <!--<img src="WriteReadData/IC1425/<?php echo $row3['icon_name']?>" height="150px" />-->
                            <p class="booksmain <?php echo !empty($sPopClass)?'CopyIcon '.$sPopClass:'';?>" <?php echo !empty($sPopClass)?"data-lid='$row3[lid]'":'';?>>
                                <?php                                
                                $row3['link_name']=(isset($_GET['lid']) && $_GET['lid']==67)?'':$row3['link_name'];
                                if(empty($bookClass)){
                                ?>
                                    <div class="imghover-inner" ><a <?php echo $row3['l_target'];?> title="<?php echo CleanW3cWarn($row3['title'])?>" href="<?php echo empty($bookClass)?"$newlinkfile?lang=$_SESSION[lang]&amp;level=$row3[link_level]&amp;ls_id=$row3[ls_id]&amp;lid=$row3[lid]{$dUrl}":"javascript:void(0);"?>"><img src="WriteReadData/IC1425/<?php echo $row3['icon_name']?>" height="220px" /><br/><br/><?php echo CleanW3cWarn($row3['link_name'])?></a></div>                                
                                <?php    
                                }
                                else{
                                ?>
                                <img src="WriteReadData/IC1425/<?php echo $row3['icon_name']?>" height="220px" /><?php echo CleanW3cWarn($row3['link_name']);                                
                                }
                                ?>
                            </p>
                            <div style="padding-left:17px; color:#614b4b"><?php echo html_entity_decode($row3['author_name']);?><?php echo empty($bookClass)?(!empty($row3['pub_date'])?"&nbsp;|&nbsp;$row3[pub_date]":""):(!empty($row3['link_bdesc'])?"<br>$row3[link_bdesc]":"");?></div>
                        </div>
                    <?php                        
                        echo ($lPos++%3==0)?"</div><div class='row'>":'';
                        }
                        echo "</div>";
                    }
                    else{                        
                        $LefBlockFull=($LefBlock=='col-md-12')?'sidebar-links-full':'sidebar-links';
                        //  echo "<ul>";
						echo "<table id='customers' class='table table-hover tablecont'><thead><tr><th>S. No.</th><th style='width: 540px;'>Title</th><th>Link Type</th><th>File Size</th><th>Last Updated</th></tr></thead>";
                        //  print_r($rs3[1]);
						$sno=1;	
                        foreach($rs3[1] as $row3){         
                            $newic=$row3['new_icon']=="1"?"<img alt='New Content' border=0 src='images/new.gif'>":"";
                            $linkfile = empty($row3['lfile'])?create_front_links_by_link_name($row3['link_name']):$row3['lfile'];
							
							
                            if(is_array($linkfile)){
                                $newlinkfile=$linkfile[0];
                                $dUrl=$linkfile[2] ?? '';    
                            }
                            else{                
                                $newlinkfile=$linkfile;
                            }

                            /*Condition for the FAQ*/
                            if($row['link_name']=='FAQs'){
                                echo "<li  data-toggle='collapse' data-target='#faq_".$row3['lid']."'><a href='javascript:void(0)'>".CleanW3cWarn($row3['link_name'])."</a> $newic</li>";
                            ?>
                            <div class="faq-details collapse" id='faq_<?php echo $row3['lid'];?>'><?php 
                                rtfPathManage($row3['details'],false);
                                _html_entity_decode($row3['details']);
                                echo $row3['details'];
                             ?></div>
    
                            <?php
                            }
                            else{
                            //echo "<li>"; 
							if ($row3['type_id']==1)
								{
									$typeid="File Link";
								}
								elseif ($row3['type_id']==2)
								{
									$typeid="URL";
								}
								elseif ($row3['type_id']==3)
								{
									$typeid="Content";
								}
                               ?>
								<tr>
								<td><?php echo $sno; ?></td>
								<td><a <?php echo $row3['l_target'];?> title="<?php echo CleanW3cWarn($row3['title'] ?? ''); ?>&nbsp;<?php echo $Mtitle ?? ''; ?>" href='<?php echo "$newlinkfile?lang=$_SESSION[lang]&amp;level=$row3[link_level]&amp;ls_id=$row3[ls_id]&amp;lid=$row3[lid]{$dUrl}"?>'><?php echo CleanW3cWarn($row3['link_name'])?><?php echo $newic; ?>
                                <?php echo getFileIcon($row3['fext']);?>
                                </a></td>
								<td><?php echo $typeid ?></td>
								<td style="color: red;"><?php echo getFileIcon($row3['fext']),filesize_formatted($row3['file_name']); ?></td>
								<td><?php echo $row3['publish_date'] ?></td>
							</tr>	
								
                               <!--<a <?php //echo $row3['l_target'];?> title="<?php //echo CleanW3cWarn($row3['title'])?>&nbsp;<?php //echo $Mtitle?>" href='<?php //echo "$newlinkfile?lang=$_SESSION[lang]&amp;level=$row3[link_level]&amp;ls_id=$row3[ls_id]&amp;lid=$row3[lid]{$dUrl}"?>'><?php //echo CleanW3cWarn($row3['link_name'])?><?php //echo $newic; ?>
                                <?php //echo getFileIcon($row3['fext']),filesize_formatted($row3['file_name']); ?>
                                </a>-->
								
                                <div style="padding-left:15px; color:#614b4b"><?php echo html_entity_decode($row3['author_name'] ?? '');?><?php echo empty($bookClass)?(!empty($row3['pub_date'])?"&nbsp;|&nbsp;$row3[pub_date]":""):(!empty($row3['link_bdesc'])?"<br>$row3[link_bdesc]":"");?></div>
                                <?php                        
                            //echo "</li>";
                            }
                        $sno++;}
                        //echo "</ul>"; 
						
						echo "</table>"; 						
                    }
                                        
                        
                    //if($rs3[0][4]>1 && $LefBlock=='col-md-12'){
                    if($rs3[0]>1 && $LefBlock=='col-md-12'){
                        echo '<div class="row text-center" style="border:0px solid green;"> '. $pages->renderFullNav()  . '</div>';
                    }
                }
            ?>        
        </div>
        <?php
       }
            
            if($row['link_name']=='Events'){
            ?>
            <div id="event_cal"></div>
            <script type="text/javascript">
                $(function(){
                    //var currentYear = '';//new Date().getFullYear();
                    $('#event_cal').calendar({ 
                        enableContextMenu: true,
                        enableRangeSelection: true,
                        renderEnd: function(e) {
                            currentYear=e.currentYear;
                            //console.log(new Date(currentYear, 4, 28));
                            $.fn.ajaxLoading({show:false});
                        },                        
                        mouseOnDay: function(e) {
                            if(e.events.length > 0) {
                                var content = '';
                                
                                for(var i in e.events) {
                                    content += '<div class="event-tooltip-content">'
                                                    //+ '<div class="event-name" style="color:' + e.events[i].color + '">' + e.events[i].name + '</div>'
                                                    + '<div class="event-name" style="color:#000">' + e.events[i].name + '</div>'
                                                    + '<div class="event-location">' + e.events[i].location + '</div>'
                                                + '</div>';
                                }
                            
                                $(e.element).popover({ 
                                    trigger: 'manual',
                                    container: 'body',
                                    html:true,
                                    content: content
                                });
                                
                                $(e.element).popover('show');
                            }
                        },
                        mouseOutDay: function(e) {
                            if(e.events.length > 0) {
                                $(e.element).popover('hide');
                            }
                        },
                        dayContextMenu: function(e) {
                            $(e.element).popover('hide');
                        },
                        yearChanged: function(e) {
                            e.preventRendering = true;
                            currentYear=e.currentYear;
                            //$(e.target).append('<div style="text-align:center"><div class="model"><div class="loader-container"></div></div></div>');
                            $.fn.ajaxLoading();
                            $.base64.utf8encode = true;                            
                            $.ajax({ 
                                method: "post",
                                dataType: "text",
                                url      : '<?php echo "AjaxFill/getWebCont.php?lang=$_SESSION[lang]";?>',
                                data     : {'function':'events','year':currentYear,<?php echo $GLOBALS['csrf']['token'];?>}, 
                                success: function(data) {
                                    dataSource=$.parseJSON($.base64.atob(data));
                                    $.each(dataSource, function (key, value) {
                                        //console.log('key:' + key+' Value:'+value +' Test:'+value.startDate + 'NewDate:'+new Date(value.startDate*1000))
                                        value.startDate=new Date(value.startDate*1000);
                                        value.endDate=new Date(value.endDate*1000);
                                    });
                                    //console.log(dataSource);                                                                                                  
                                    $(e.target).data('calendar').setDataSource(dataSource);
                                } 
                            });
                        }
                    });
                    
                })
            </script>            
            <?php            
            }
            #####if have the continous content
            include('cont_content.inc.php');
            ?>
			
<div class="row">
<?php

$rs2=simplefetch("select DISTINCT mc.cat_name, mc.cat_name_h,mm.m_cat_id from web_link_map_media mm INNER JOIN web_media_category mc on mc.m_cat_id=mm.m_cat_id INNER JOIN web_media_temp mt on mt.m_cat_id=mc.m_cat_id INNER JOIN web_media_final mf on mf.m_temp_id=mt.m_temp_id where mc.status='Active' and mm.status='Active' and mf.status='Active' and mt.status='Active' and mt.image_name is not null and mc.app_reject=1 and mm.lid=$_GET[lid] ",1);	
		if($rs2[0]>0){
        
		foreach($rs2[1] as $rowcat){
						
?>

<div class="col-md-12" style="font-weight:bold;"><?php echo strtoupper ($rowcat['cat_name']);  ?></div>
				
<?php    

$rs=simplefetch("select mf.m_id,mf.m_temp_id,mt.image_name,mt.m_description,mc.cat_name from web_link_map_media mm
INNER JOIN web_media_category mc on mc.m_cat_id=mm.m_cat_id
INNER JOIN web_media_temp mt on mt.m_cat_id=mc.m_cat_id
INNER JOIN web_media_final mf on mf.m_temp_id=mt.m_temp_id
where mc.status='Active' and mm.status='Active' and mf.status='Active' and mt.status='Active' and mt.image_name is not null and mc.app_reject=1 /*and mc.banner_flage is null*/ and mm.m_cat_id=$rowcat[m_cat_id]  GROUP BY m_temp_id",1);
    if($rs[0]>0){
        foreach($rs[1] as $row){

        ?>
        <div class="fancybox1 col-md-4 " style='margin-bottom:20px;'>
            <a class="fancybox-thumb" rel="gallery<?php echo $row['m_temp_id'];?>" href="WriteReadData/MD32145/<?php echo $row['image_name'];?>" title="">
            	<img alt='(<?php echo $row['cat_name'];?>) - <?php echo html_entity_decode($row['m_description'] ?? '');?>' src="WriteReadData/MD32145/<?php echo $row['image_name'];?>" alt=""/>
            </a>        
            <!--<div style='text-align:center;'>(<?php //echo $row['cat_name'];?>) - <?php //echo html_entity_decode($row['m_description']);?></div>-->
			
			<div style='text-align:center;'><?php echo html_entity_decode($row['m_description'] ?? '');?></div>
			
            <?php
            /*$rs1=simplefetch("select mf.m_id,mt.m_temp_id,mt.image_name,mt.m_description from web_media_temp mt
            INNER JOIN web_media_final mf on mf.m_temp_id=mt.m_temp_id where mt.status='Active' and mf.status='Active' and mt.m_cat_id=$row[m_cat_id]");
            if($rs1[0]>0){*/
            ?>
                <div class="hidden" style="display:none;">
            <?php
                #foreach($rs1[1] as $row1){
            ?>
                <a  class="fancybox1" rel="gallery<?php echo $row['m_temp_id'];?>" title="<?php echo $row['m_description']?>" href="WriteReadData/MD32145/<?php echo $row['image_name'];?>">
                    <img src="WriteReadData/MD32145/<?php echo $row['image_name'];?>" alt=""/>
                </a>
            <?php
                #}
            ?>
                </div>
            <?php
            #}
            ?>  
            
        </div>

        <?php
				}
			}
		}
	}	
    ?>
    	</div>
	
        </div>
	</div>
</div>

</div>
	
<!-- Add fancyBox main JS and CSS files -->
<script type="text/javascript" src="assets/fancyBox/jquery.fancybox.pack.js?v=2.1.5"></script>
<link rel="stylesheet" type="text/css" href="assets/fancyBox/jquery.fancybox.css?v=2.1.5" media="screen" />
<script>
$(document).ready(function() {
    $(".fancybox-thumb").click(function() {
        var gallery = []; // array of gallery elements        
        $(".fancybox1[rel='"+$(this).attr('rel')+"']").each(function(){
            //console.log('aaa');
            gallery.push({'href':this.href,'title':this.title}); // push element to the array
        })
        
        $.fancybox.open(
            gallery,{
                //padding : 0,
                prevEffect	: 'fade',
		        nextEffect	: 'fade',
                beforeShow : function() {                    
                    this.title = 'Image ' + (this.index + 1) + ' of ' + this.group.length + (this.title ? ' - ' + this.title : '');
                },
                helpers	:{
                    /*title	: {
        				type: 'inside'
        			}*/
                }
            }
        );    
        return false;
    })
    
	/*$(".fancybox").fancybox({	   
		prevEffect	: 'fade',
		nextEffect	: 'fade',
		helpers	: {
			title	: {
				type: 'inside'
			},
			thumbs	: {
				width	: 50,
				height	: 50
			}
		}
	});*/
    
});
</script>

            <?php if(($row['feedback_required'] ?? '') =='1'){?>
            <div class="row">
                <div class="text-right"><button style="background:#004696" type="submit" id="l_feedback" class="btn btn-primary" data-hrf='l_feedback' href='<?php echo "feedback.php?lang=$_SESSION[lang]&level=$row[level]&ls_id=$row[ls_id]&lid=$row[lid]";?>'><a style="color: #fff;" href="<?php echo "feedback.php?lang=$_SESSION[lang]&level=$row[level]&ls_id=$row[ls_id]&lid=$row[lid]";?>">Post Comments</a></button></div>
            </div>
            <?php }?>     
        </div>
    <?php
        }
    //echo $row['lid'];
	// if ($row['lid'] == 25)
	// {
	?>
<!--		<h3>Reach Us</h3>
		<div><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d28029.76329345724!2d77.18915918624015!3d28.578157213197663!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390ce3020e54e7ff%3A0x11b3bb227e453423!2sMinistry%20of%20Minority%20Affairs!5e0!3m2!1sen!2sin!4v1659005900896!5m2!1sen!2sin" width="100%" height="350" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe><br/></div>
		-->
	<?php
	 //}
	?>
	
