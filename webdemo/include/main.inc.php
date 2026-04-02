 
<div class="container" id="inner-search" style="min-height: 550px;">
    <?php 
	//include('./analytics.php');
	include 'urlpath.inc.php'; 
	?>
	
    <?php

    if (isset($_GET['l_show']) && $_GET['l_show'] == 1) {

        $rs = simplefetch("select lt.author_name,date_format(lt.pub_date,'%d %M %Y')as pub_date,date_format(lf.publish_date,'%M %d, %Y')as publish_date,lf.show_content,lf.feedback_required,lt.feed_req,lt.lang_id,lf.icon_name,case when lt.type_id!=3 then 'target=\"_blank\"' else '' end as l_target,case when lt.type_id=1 then 'showfile.php' when lt.type_id=2 then 'showlink.php' else '' end as lfile,lf.lid,lt.link_name,lt.title,lt.type_id,lt.file_name,lt.details
         from web_links_final lf
        INNER JOIN web_link_temp lt on lt.link_temp_id=lf.link_temp_id
        where lf.status='Active' and lt.status='Active' and lt.type_id=3  and lt.lang_id=".$_SESSION['lang']." and lf.lid=$_GET[lid]");
    }
	elseif (isset($_GET['d_show']) && $_GET['d_show'] == 1) { #show direct link in website with setting mainlink or sublink

        
        $rs = simplefetch("select lt.author_name,date_format(lt.pub_date,'%d %M %Y')as pub_date,date_format(lf.publish_date,'%M %d, %Y')as publish_date,lf.show_content,lf.feedback_required,lt.feed_req,lt.lang_id,lf.icon_name,case when lt.type_id!=3 then 'target=\"_blank\"' else '' end as l_target,case when lt.type_id=1 then 'showfile.php' when lt.type_id=2 then 'showlink.php' else '' end as lfile,lf.lid,lt.link_name,lt.title,lt.type_id,lt.file_name,lt.details
         from web_links_final lf
        INNER JOIN web_link_temp lt on lt.link_temp_id=lf.link_temp_id
        where lf.status='Active' and lt.status='Active' and lt.lang_id=$_SESSION[lang] and lf.lid=$_GET[lid]");
    } else {



        $hindiQry = null;
        $hindiname = null;
        if ($_SESSION['lang'] == "2" || $_SESSION['lang']=="3") {
            $hindiQry = subquerylinkhindi();
        }
        $ArchFlage = (isset($_GET['sh_arch']) && $_GET['sh_arch'] == 1) ? true : false;


        $arch_qry = (isset($_GET['arch']) && $_GET['arch'] == 1) ? "and (ISNULL(lf1.expiry_date) || concat(lf1.expiry_date,' ',ifnull(lf1.expiry_time,'00:00:00'))<=CURRENT_TIMESTAMP())" : "and (ISNULL(lf1.expiry_date) || concat(lf1.expiry_date,' ',ifnull(lf1.expiry_time,'00:00:00'))>CURRENT_TIMESTAMP())";

        $SubQry = empty($_GET['level']) ? " and ls.link_level is null" : " and ls.link_level=$_GET[level]";
        $SubQry .= (isset($_GET['sh_arch']) && $_GET['sh_arch'] == 1) ? " and case when lf.expiry_date is null then 1=1 else  concat(lf.expiry_date,' ',ifnull(lf.expiry_time,'00:00:00'))<=CURRENT_TIMESTAMP() end" : " and (ISNULL(lf.expiry_date) || concat(lf.expiry_date,' ',ifnull(lf.expiry_time,'00:00:00'))>=CURRENT_TIMESTAMP())";
        $SubQry .= "and concat(lf.publish_date,' ',ifnull(lf.publish_time,'00:00:00'))<=CURRENT_TIMESTAMP()";
       



    $VALIDATE_GET1 = '/^([0-9a-zA-Zs _\-+\/=])+$/mui';
    $VALIDATE_POST1 = '/^([0-9a-zA-Zs \r\n!#@%&"_+\-=\[\];:\\|,.\'\"\/?()])+$/mui';
    $filter1 = "/~|!|@|<|>|html|injection|alert|iframe|union|select|sleep|limit|onmouseover|prompt|bad|\[|\]|\?|\{|\}|\(|\)|\"|-|;|'|\\'|,|-|\*/";

    $blackList1 = '/^((?!script|html|injection|alert|iframe|union|select|sleep|limit).)*$/mui';
   
     $VALIDATE_QRYSTRING1 = '/^([0-9a-zA-Zs %=&_\-+\/])+$/mui';


    $get_error=array();
  if (count($_GET) > 0) {
      foreach ($_GET as $key => $value) {
        $value = preg_replace($filter1, '', strtolower($value));
        $_GET[$key] = $value;

        if (!preg_match($VALIDATE_GET1, $value) || !preg_match($blackList1, $value)) {
          
       
            $get_error[]="Invalid GET Data Please POST Valid GET Request";
          
        
        }
      }
    }


    if(sizeof($get_error) > 0){
      
        header('location:index.php');
        exit;
    }


if(((isset($_GET['ls_id'])) && trim($_GET['ls_id'])=='') || ((isset($_GET['lid'])) && trim($_GET['lid'])=='')){
              
                header('location:index.php');
                exit;
            }
if(!isset($_GET['ls_id']) || !isset($_GET['lid'])){
    
        header('location:index.php');
        exit;
}
		if ($_SESSION['lang'] == "3") {
		$id='marati_id';
		}else{
		$id='hindi_id';
		}

        $rs = simplefetch("select hindi_id,$hindiQry  lt.author_name,date_format(lt.pub_date,'%d %M %Y')as pub_date,case when ls.link_level is null then '0' else ls.link_level end as link_level,date_format(lf.publish_date,'%M %d, %Y')as publish_date,lf.show_content,lf.feedback_required,lt.feed_req,lt.lang_id,lf.icon_name,case when lt.type_id!=3 then 'target=\"_blank\"' else '' end as l_target,case when lt.type_id=1 then 'showfile.php' when lt.type_id=2 then 'showlink.php' else '' end as lfile,lf.lid,ls.ls_id,ls.parent_ls_id,lt.link_name,lt.title,lt.link_bdesc,lt.type_id,lt.file_name,lt.details,ls1.subTot,
        case when /*lf.show_content=1 and*/ ls1.subTot is not null then true else false end as leftBlock from web_links_final lf
        INNER JOIN web_link_temp lt on lt.link_temp_id=lf.link_temp_id
        INNER JOIN web_links_structure ls on ls.lid=lf.lid LEFT JOIN (select t1.link_name,t1.details,t1.title,t1.link_bdesc,t1.type_id,f1.publish_date,f1.expiry_date, f1.lid from web_links_final f1
        INNER JOIN web_link_temp t1 on t1.link_temp_id=f1.link_temp_id) h on h.lid=lf.$id
        LEFT JOIN (SELECT count(ls2.ls_id)as subTot, ls2.ls_id, ls2.parent_ls_id from web_links_structure ls2
        INNER JOIN web_links_final lf1 on lf1.lid=ls2.lid
        where ls2.status='Active' and ls2.parent_ls_id is not null $arch_qry GROUP BY ls2.parent_ls_id) ls1 on ls1.parent_ls_id=ls.ls_id
        where lf.status='Active' and lt.status='Active' and ls.status='Active' and lt.type_id=3  and lt.lang_id=1 and lf.lid=$_GET[lid] $SubQry and ls.ls_id=$_GET[ls_id] and lt.l_sub_type='1'",1);
    }

    #echo $rs[0];die();
    if ($rs[0] <= 0) {

        headersFront('index', null);
        exit();
    } else {

        foreach ($rs[1] as $row);

        #for the archive


        unset($ArchLink);
        if ((!isset($_GET['arch'])) && !isset($_GET['l_show'])) {
          


            $rs4 = simplefetch("select lt.lang_id,case when lt.type_id!=3 then 'target=\"_blank\"' else '' end as l_target,case when ls.link_level is null then '0' else ls.link_level end as link_level,case when lt.type_id=1 then 'showfile.php' when lt.type_id=2 then 'showlink.php' else '' end as lfile,lf.lid,ls.ls_id,ls.parent_ls_id,lt.link_name,lt.title,lt.type_id,lt.file_name,ls.status,SUBSTRING_INDEX(lt.file_name,'.',-1)as fext from web_links_final lf
            INNER JOIN web_link_temp lt on lt.link_temp_id=lf.link_temp_id
            INNER JOIN web_links_structure ls on ls.lid=lf.lid
            where lf.status='Active' and lt.status='Active' and ls.status='Active' and ls.parent_ls_id=$row[ls_id] and ls.link_level=($row[link_level]+1) and concat(lf.publish_date,' ',ifnull(lf.publish_time,'00:00:00'))<=CURRENT_TIMESTAMP() and concat(lf.expiry_date,' ',ifnull(lf.expiry_time,'00:00:00'))<=CURRENT_TIMESTAMP() and lt.lang_id=$row[lang_id] order by ls.position");
            if ($rs4[0] > 0) {


                $ArchLink = "<a href=\"show_content.php?lang=$_SESSION[lang]&amp;lid=$row[lid]&amp;ls_id=$row[ls_id]&amp;level=$row[link_level]&amp;arch=1\" title=\"Archive Links\"><i class=\"fa fa-archive fa-2x\" aria-hidden=\"true\" style=\"font-size: 20px;\"></i></a>";
            }

        } else {

            $ArchLink = "<a href=\"show_content.php?lang=$_SESSION[lang]&amp;lid=$row[lid]&amp;ls_id=$row[ls_id]&amp;level=$row[link_level]\" title=\"Active Links\"><i class=\"fa fa-bars\" aria-hidden=\"true\" style=\"font-size: 20px;\"></i></a>";
        }
    ?>
		
        <div class="row">
            <div class="col-md-12">
                <div class="pull-right" style="margin-left: 10px;">
                    <?php 
                    
                    
                    // echo $ArchLink; 


                    ?>
                    <!--<a href="javascript:void(0);" title="Print Version"><i class="fa fa-print fa-2x" aria-hidden="true"></i></a>-->
                </div>
               

                <!--Ajit-->
                <?php
                if ($_SESSION['lang'] == "1") {


                ?>
                    <div class="pull-right smallfont"><?php echo __('Last Updated On'); ?> <?php echo !isset($_GET['d_show']) ? getLinkUpdatedOn($row['lid'], $row['ls_id'], $row['link_level'], $ArchFlage) : $row['publish_date']; ?></div>
                <?php
                } else {

                ?>

                    <div class="pull-right smallfont"><?php echo __('Last2 Updated On'); ?> <?php echo !isset($_GET['d_show']) ? getLinkUpdatedOn($row['lid'], $row['ls_id'], $row['link_level'], $ArchFlage) : $row['publish_date']; ?></div>


                <?php } ?>

            </div>
        </div>

        <div class="row">
            <div class="col-md-12">

                <!--<h4 class="innerheading" id="link_name">
                    <?php
                    /*if ($_SESSION['lang'] == "1") {
                        echo html_entity_decode($row['link_name']);
                    } else {

                        echo html_entity_decode($row['hindi_name']);
                    }*/
                    #echo (isset($_GET['arch'])&& $_GET['arch']==1)?" ( Archived )":'';
                    ?></h4>-->
                <!--<div class="auth_nam_dat"><?php //echo html_entity_decode($row['author_name']); ?><?php //echo !empty($row['pub_date']) ? "&nbsp;|&nbsp;$row[pub_date]" : ""; ?></div>-->
            </div>
        </div>


        <div class="row" id="print-container">
        <?php if(!empty($_GET['vmod'])){ ?>    
        <div id="dvContents2">
        <?php } ?>
		<?php

            // $_GET['arch'] = (isset($_GET['vmod']) && !empty($_GET['vmod'])) ? $_GET['vmod'] : $_GET['arch'];

            $_GET['arch'] = $_GET['vmod'] ?? ($_GET['arch'] ?? null);

            switch ($_GET['arch']) {
                case '1':

                    include 'include/link_archive.inc.php';
                    break;

                case '2':
                case '3':
                    
                    include 'include/photo_cat.inc.php';
                    break;

                case '4':
                    include 'include/sitemap_arch.inc.php';
                    break;

                default:
                
                    include 'include/link_active.inc.php';
                    break;
            }
            ?>
        </div>
	
    <?php
    }
    ?>
</div>
</div>
