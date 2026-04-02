<?php
//die('as');
?>
<div class="heading_bannertop" id="dvContents1" style="background-image:url('WriteReadData/HD87168/innerpage_header.jpg')">
	<?php
	
	//$rs1=getNameQry("select dept_name from department  where id='$_REQUEST[depid]'");
	$rs2=getNameQry("select cat_name from web_tender_category  where t_cat_id='$_REQUEST[catid]'");
	?>	
		
	<?php echo $rs2 ;?>
	</div>

<div class="container">
		
		
		<?php include('urlpath.inc.php');?>
		
	<div id="dvContents2" class="container-fluid" >
		
    <?php
//    error_reporting(0);
     $hindi=subquerylinkhindi2($_SESSION['lang']);
    $hindiQryjoin=subqueryjoin();  
    $ArchFlage=(isset($_GET['sh_arch'])&& $_GET['sh_arch']==1)?true:false;
    $SubQry=empty($_GET['level'])?" and ls.link_level is null":" and ls.link_level=$_GET[level]";
    $SubQry.=(isset($_GET['sh_arch'])&& $_GET['sh_arch']==1)?" and lf.expiry_date<=current_date()":" and (ISNULL(lf.expiry_date) || lf.expiry_date>current_date())";    
    $rs=simplefetch("select  $hindi case when ls.link_level is null then '0' else ls.link_level end as link_level,date_format(lf.publish_date,'%M %d, %Y')as publish_date,lf.show_content,lt.feed_req,lt.lang_id,lf.icon_name,case when lt.type_id!=3 then 'target=\"_blank\"' else '' end as l_target,case when lt.type_id=1 then 'showfile.php' when lt.type_id=2 then 'showlink.php' else '' end as lfile,lf.lid,ls.ls_id,ls.parent_ls_id,lt.title,lt.type_id,lt.file_name,lt.details
     from web_links_final lf
    INNER JOIN web_link_temp lt on lt.link_temp_id=lf.link_temp_id
    INNER JOIN web_links_structure ls on ls.lid=lf.lid $hindiQryjoin 
    where lf.status='Active' and lt.status='Active' and ls.status='Active' and lt.type_id=3  and lt.lang_id=1  $SubQry ");
    $a="select  $hindi case when ls.link_level is null then '0' else ls.link_level end as link_level,date_format(lf.publish_date,'%M %d, %Y')as publish_date,lf.show_content,lt.feed_req,lt.lang_id,lf.icon_name,case when lt.type_id!=3 then 'target=\"_blank\"' else '' end as l_target,case when lt.type_id=1 then 'showfile.php' when lt.type_id=2 then 'showlink.php' else '' end as lfile,lf.lid,ls.ls_id,ls.parent_ls_id,lt.title,lt.type_id,lt.file_name,lt.details
    from web_links_final lf
   INNER JOIN web_link_temp lt on lt.link_temp_id=lf.link_temp_id
   INNER JOIN web_links_structure ls on ls.lid=lf.lid $hindiQryjoin 
   where lf.status='Active' and lt.status='Active' and ls.status='Active' and lt.type_id=3  and lt.lang_id=1  $SubQry ";
//    echo $a;
    #echo $rs[0];die();
    if($rs[0]<=0){
        headersFront('index',null);
        exit();
    }
    else{
        foreach($rs[1] as $row);
        
        #for the archive 
        unset($ArchLink);
        if((!isset($_GET['arch']))){            
            $rs4=simplefetch("select tf.t_id,tt.t_temp_id,tt.tender_name,tf.expiry_time,ifnull(date_format(tf.publish_date,'%M %d, %Y'),'N/A')as publish_date,tf.publish_time,ifnull(date_format(tf.expiry_date,'%M %d, %Y'),'N/A')as expiry_date,ifnull(date_format(tt.open_date,'%M %d, %Y'),'N/A')as open_date,tt.open_time,ifnull(date_format(tt.expiry_date,'%M %d, %Y'),'N/A')as expirydate
         from web_tender_temp tt
INNER JOIN web_tender_final tf on tf.t_temp_id=tt.t_temp_id
 where tt.`status`='Active' and concat(tf.expiry_time,' ',ifnull(tf.expiry_time,'00:00:00'))<=CURRENT_TIMESTAMP() and tt.corrigendum is null",1);
 $a="select tf.t_id,tt.t_temp_id,tt.tender_name,tf.expiry_time,ifnull(date_format(tf.publish_date,'%M %d, %Y'),'N/A')as publish_date,tf.publish_time,ifnull(date_format(tf.expiry_date,'%M %d, %Y'),'N/A')as expiry_date,ifnull(date_format(tt.open_date,'%M %d, %Y'),'N/A')as open_date,tt.open_time,ifnull(date_format(tt.expiry_date,'%M %d, %Y'),'N/A')as expirydate
 from web_tender_temp tt
INNER JOIN web_tender_final tf on tf.t_temp_id=tt.t_temp_id
where tt.`status`='Active' and concat(tf.expiry_time,' ',ifnull(tf.expiry_time,'00:00:00'))<=CURRENT_TIMESTAMP() and tt.corrigendum is null";
// echo $a;
            if($rs4[0]>0){
                
              if($_SESSION['lang']=="2" || $_SESSION['lang']=="3")
              {
                //$ArchLink="<a href=\"tendersArc.php?lang=$_SESSION[lang]&amp;lid=$row[lid]&amp;ls_id=$row[ls_id]&amp;level=$row[link_level]&amp;arch=1\" title=\"Archive Tenders\"><i class=\"fa fa-archive fa-2x\" aria-hidden=\"true\"></i></a>";
                 $ArchLink="<a href=\"tendersArc.php?lang=$_SESSION[lang]&amp;depid=$_REQUEST[depid]&amp;catid=$_REQUEST[catid]&amp;level=$row[link_level]&amp;arch=1\" title=\"Archive Tenders\"><i class=\"fa fa-archive fa-2x\" aria-hidden=\"true\"></i>Archives </a>";
			}else
            {
                
                 $ArchLink="<a href=\"tendersArc.php?lang=$_SESSION[lang]&amp;depid=$_REQUEST[depid]&amp;catid=$_REQUEST[catid]&amp;level=$row[link_level]&amp;arch=1\" title=\"Archive Tenders\"><i class=\"fa fa-archive fa-2x\" aria-hidden=\"true\"></i>Archives </a>";
            }
            
            }          
        } 
    ?>
   
    <div class="row">
        <div class="col-md-4"><h4> <?php echo $rs2;?></h4></div>
        <div class="col-md-8 text-right">            
            <div class="" align="right">
            <?php
			$rs=simplefetch("select tf.t_id,tt.t_temp_id,tt.tender_name,tf.expiry_time,ifnull(date_format(tf.publish_date,'%M %d, %Y'),'N/A')as publish_date,tf.publish_time,ifnull(date_format(tf.expiry_date,'%M %d, %Y'),'N/A')as expiry_date,ifnull(date_format(tt.open_date,'%M %d, %Y'),'N/A')as open_date,tt.open_time,ifnull(date_format(tt.expiry_date,'%M %d, %Y'),'N/A')as expirydate
					 from web_tender_temp tt
			INNER JOIN web_tender_final tf on tf.t_temp_id=tt.t_temp_id
			 where tt.`status`='Active' and tt.`dept_id`= $_GET[depid] and tt.`t_cat_id`= $_GET[catid] and concat(tf.publish_date,' ',ifnull(tf.publish_time,'00:00:00'))<=CURRENT_TIMESTAMP() and concat(tf.expiry_date,' ',ifnull(tf.expiry_time,'00:00:00'))<=CURRENT_TIMESTAMP() and tt.corrigendum is null order by tt.t_temp_id DESC");
             $a="select tf.t_id,tt.t_temp_id,tt.tender_name,tf.expiry_time,ifnull(date_format(tf.publish_date,'%M %d, %Y'),'N/A')as publish_date,tf.publish_time,ifnull(date_format(tf.expiry_date,'%M %d, %Y'),'N/A')as expiry_date,ifnull(date_format(tt.open_date,'%M %d, %Y'),'N/A')as open_date,tt.open_time,ifnull(date_format(tt.expiry_date,'%M %d, %Y'),'N/A')as expirydate
             from web_tender_temp tt
    INNER JOIN web_tender_final tf on tf.t_temp_id=tt.t_temp_id
     where tt.`status`='Active' and tt.`dept_id`= $_GET[depid] and tt.`t_cat_id`= $_GET[catid] and concat(tf.publish_date,' ',ifnull(tf.publish_time,'00:00:00'))<=CURRENT_TIMESTAMP() and concat(tf.expiry_date,' ',ifnull(tf.expiry_time,'00:00:00'))<=CURRENT_TIMESTAMP() and tt.corrigendum is null order by tt.t_temp_id DESC";
    //  echo $a;
			if($rs[0]>0){echo $ArchLink; }?>
                
                <!--<a href="javascript:void(0);" title="Print Version"><i class="fa fa-print fa-2x" aria-hidden="true"></i></a>-->
            </div>
            <div class="pull-right"><?php echo __('Last Updated On');?>: <?php echo curdatetime('%B %d, %Y');#echo getLinkUpdatedOn($row['lid'],$row['ls_id'],$row['link_level'],$ArchFlage);?></div>
        </div>
        <br />
    </div>
    <?php
        (isset($_GET['arch'])&& $_GET['arch']==1)?include('include/tender_archive.inc.php'):include('include/tender_active.inc.php');
    }
    ?>
	</div>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  
  <div  id="ajaxModalPopup"></div>
  
</div>
<script type="text/javascript">
$(function(){
    $('.fa-info-circle').click(function(){
        
        var t_id = $(this).data('t_id');
        var catid = $(this).data('catid');
		
		if(t_id){
			
			$.ajax({url: "tender_details.php?t_id="+t_id+"&catid="+catid, success: function(result){
			$("#ajaxModalPopup").html(result);
			$('#exampleModal').modal('show');
			}});
		}

        /*$('.modal-container').html('');            
        $('.modal-container').OpenPop({
            url:"<?php echo "tender_details.php?lang=$_SESSION[lang]&t_id="?>"+$(this).data('t_id'),
        });
        return false;*/
    })
})
</script>