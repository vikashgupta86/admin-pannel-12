<div class="container">
    <?php
    //error_reporting(0);
     $hindi=subquerylinkhindi2($_SESSION['lang']);
    $hindiQryjoin=subqueryjoin();  
    $ArchFlage=(isset($_GET['sh_arch'])&& $_GET['sh_arch']==1)?true:false;
    $SubQry=empty($_GET['level'])?" and ls.link_level is null":" and ls.link_level=$_GET[level]";
    $SubQry.=(isset($_GET['sh_arch'])&& $_GET['sh_arch']==1)?" and lf.expiry_date<=current_date()":" and (ISNULL(lf.expiry_date) || lf.expiry_date>current_date())";    
    $rs=simplefetch("select  $hindi case when ls.link_level is null then '0' else ls.link_level end as link_level,date_format(lf.publish_date,'%M %d, %Y')as publish_date,lf.show_content,lt.feed_req,lt.lang_id,lf.icon_name,case when lt.type_id!=3 then 'target=\"_blank\"' else '' end as l_target,case when lt.type_id=1 then 'showfile.php' when lt.type_id=2 then 'showlink.php' else '' end as lfile,lf.lid,ls.ls_id,ls.parent_ls_id,lt.title,lt.type_id,lt.file_name,lt.details
     from web_links_final lf
    INNER JOIN web_link_temp lt on lt.link_temp_id=lf.link_temp_id
    INNER JOIN web_links_structure ls on ls.lid=lf.lid $hindiQryjoin 
    where lf.status='Active' and lt.status='Active' and ls.status='Active' and lt.type_id=3  and lt.lang_id=1 and lf.lid=$_GET[lid] $SubQry and ls.ls_id=$_GET[ls_id]");
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
            $rs4=simplefetch("select tf.t_id,tt.t_temp_id,tt.tender_name,tt.close_time,ifnull(date_format(tt.pub_date,'%M %d, %Y'),'N/A')as pub_date,tt.pub_time,ifnull(date_format(tt.close_date,'%M %d, %Y'),'N/A')as close_date,ifnull(date_format(tt.open_date,'%M %d, %Y'),'N/A')as open_date,tt.open_time,ifnull(date_format(tt.expiry_date,'%M %d, %Y'),'N/A')as expiry_date
         from web_tender_temp tt
INNER JOIN web_tender_final tf on tf.t_temp_id=tt.t_temp_id
 where tt.`status`='Active' and concat(tt.close_date,' ',ifnull(tt.close_time,'00:00:00'))<=CURRENT_TIMESTAMP() and tt.corrigendum is null",1);
            if($rs4[0]>0){
                
              if($_SESSION['lang']=="2")
              {
                $ArchLink="<a href=\"tendersArc.php?lang=$_SESSION[lang]&amp;lid=$row[lid]&amp;ls_id=$row[ls_id]&amp;level=$row[link_level]&amp;arch=1\" title=\"Archive Tenders\"><i class=\"fa fa-archive fa-2x\" aria-hidden=\"true\"></i></a>";
            }else
            {
                
                 $ArchLink="<a href=\"tendersArc.php?lang=$_SESSION[lang]&amp;lid=$row[lid]&amp;ls_id=$row[ls_id]&amp;level=$row[link_level]&amp;arch=1\" title=\"Archive Tenders\"><i class=\"fa fa-archive fa-2x\" aria-hidden=\"true\"></i>Archives </a>";
            }
            
            }          
        }    
    ?>
   
    <div class="row">
        <div class="col-md-4"><h4> <?php echo html_entity_decode($row['link_name']);#echo (isset($_GET['arch'])&& $_GET['arch']==1)?" ( Archived )":'';?></h4></div>
        <div class="col-md-8 text-right">            
            <div class="">
                <?php //echo $ArchLink;?>
                <!--<a href="javascript:void(0);" title="Print Version"><i class="fa fa-print fa-2x" aria-hidden="true"></i></a>-->
            </div>
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
        <br />
    </div>
    <?php
        (isset($_GET['arch'])&& $_GET['arch']==1)?include('include/tender_archive.inc.php'):include('include/tender_active.inc.php');
    }
    ?>
   
</div>
<!-- Modal -->

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  
  <div  id="ajaxModalPopup"></div>
  
</div>
<script type="text/javascript">
$(function(){
    $('.fa-info-circle').click(function(){
        
        var t_id = $(this).data('t_id');
		
		if(t_id){
			
			$.ajax({url: "tender_details.php?t_id="+t_id, success: function(result){
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