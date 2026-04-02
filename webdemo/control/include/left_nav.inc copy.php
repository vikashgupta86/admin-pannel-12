
<?php 
  unset($_SESSION['nav']);
  //$cPage= $obj->curPageName(false);
  $cPage= curPageName(false);
  $str = getNameQry("select concat(m.module_id,'|',sm.sub_module_id)as str from web_st_module m INNER JOIN web_st_sub_module sm on m.module_id=sm.module_id where m.`status`='Active' and sm.`status`='Active' and trim(LOWER(sm.sub_module_page))=trim(LOWER('$cPage'))");
  if(!empty($str)){
    $str=explode('|',$str);
    $_SESSION['nav']=$str;
  }
?>



    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header"><b>Super</b> ADMIN</div>
        <div class="user-panel d-flex align-items-center">
            <img src="https://via.placeholder.com/45" class="rounded-circle me-3" alt="User Image">
            <div>
                <p class="text-white text-wrap">Welcome Shri CMS</p>
                <a href="#" class="text-decoration-none text-white small"><i class="bi bi-circle-fill text-success" style="font-size: 10px;"></i> Online</a>
            </div>
        </div>
        <nav class="sidebar-nav">
            <div class="nav flex-column" id="sidebarNavAccordion">
                <a href="#" class="nav-link"><i class="bi bi-speedometer2"></i> Dashboard</a>
                
                <a href="#tenderSubmenu" data-bs-toggle="collapse" aria-expanded="true" class="nav-link d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-file-earmark-text"></i> Tender</span>
                    <i class="bi bi-chevron-down" style="font-size: 10px;"></i>
                </a>
                <ul class="collapse show sub-menu" id="tenderSubmenu" data-bs-parent="#sidebarNavAccordion">
                    <li><a href="#">Manage Tender Category</a></li>
                    <li><a href="#" class="text-white fw-bold">Manage Tenders</a></li>
                    <li><a href="#">Approve/ Reject Tenders</a></li>
                </ul>

                <a href="#photoSubmenu" data-bs-toggle="collapse" aria-expanded="false" class="nav-link d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-grid-3x3"></i> Photogallery</span>
                    <i class="bi bi-chevron-down" style="font-size: 10px;"></i>
                </a>
                <ul class="collapse sub-menu" id="photoSubmenu" data-bs-parent="#sidebarNavAccordion">
                    <li><a href="#">Manage Media</a></li>
                    <li><a href="#">Publish Media</a></li>
                </ul>
            </div>
        </nav>
    </aside>



  <aside class="sidebar d-none" id="sidebar">
      <div class="user-panel d-flex align-items-center">
        <img src="../WriteReadData/PF45214/<?php echo (!empty($prow['profile_img']))?"$prow[profile_img]":"np.png";?>" class="rounded-circle me-3" alt="User Image">
        <div>
          <p class="text-white text-wrap">Welcome <?php echo $prow['sName'];?></p>
          <a href="#" class="text-decoration-none text-white small"><i class="bi bi-circle-fill text-success" style="font-size: 10px;"></i> Online</a>
        </div>
      </div>


      <nav class="sidebar-nav">
        <div class="nav flex-column" id="sidebarNavAccordion">
          <a href="main.php?per_id=<?= $_REQUEST['per_id'] ?? ''; ?>&amp;EncHid=<?= $_SESSION['EncTok']; ?>" class="nav-link"><i class="bi bi-speedometer2"></i> Dashboard</a>
                
                <a href="#tenderSubmenu" data-bs-toggle="collapse" aria-expanded="true" class="nav-link d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-file-earmark-text"></i> Tender</span>
                    <i class="bi bi-chevron-down" style="font-size: 10px;"></i>
                </a>
                <ul class="collapse show sub-menu" id="tenderSubmenu" data-bs-parent="#sidebarNavAccordion">
                    <li><a href="#">Manage Tender Category</a></li>
                    <li><a href="#" class="text-white fw-bold">Manage Tenders</a></li>
                    <li><a href="#">Approve/ Reject Tenders</a></li>
                </ul>

                <a href="#photoSubmenu" data-bs-toggle="collapse" aria-expanded="false" class="nav-link d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-grid-3x3"></i> Photogallery</span>
                    <i class="bi bi-chevron-down" style="font-size: 10px;"></i>
                </a>
                <ul class="collapse sub-menu" id="photoSubmenu" data-bs-parent="#sidebarNavAccordion">
                    <li><a href="#">Manage Media</a></li>
                    <li><a href="#">Publish Media</a></li>
                </ul>
            </div>
        </nav>      


        

      
              <nav class="sidebar-nav">

        <?php
       // $rsmodule=$obj->simplefetch("select up.per_id,up.user_id,m.module_id,m.module_name,m.abbrev,ifnull(m.fa_icon,'fa-arrow-right')as fa_icon from web_user_permission up,web_st_module m, web_st_sub_module sm where up.status='Active' and m.status='Active' and sm.status='Active' and m.module_id=sm.module_id and sm.sub_module_id=up.sub_module_id and up.user_id=$_SESSION[userid] group by m.module_id order by m.pos");

        $rsqury = "SELECT up.per_id,up.user_id,m.module_id,m.module_name,m.abbrev,ifnull(m.fa_icon,'fa-arrow-right')as fa_icon from web_user_permission up,web_st_module m, web_st_sub_module sm where up.status='Active' and m.status='Active' and sm.status='Active' and m.module_id=sm.module_id and sm.sub_module_id=up.sub_module_id and up.user_id = ? GROUP BY m.module_id order by m.pos";
        $rsconn = db_connect();
        $rsstmt = $rsconn->prepare($rsqury);
        $rsstmt->bind_param("i", $_SESSION['userid']);
        $rsstmt->execute();
        $rsmodule = $rsstmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $rsstmt->close();


        if($rsmodule){
            foreach ($rsmodule as $rowmodule){
               // $rssubmodule=$obj->simplefetch("select ifnull(sm.fa_icon,'fa-circle-o')as s_fa_icon,sm.pos,up.per_id,sm.sub_module_id,sm.sub_module_page,sm.sub_module_name from web_user_permission up,web_st_module m, web_st_sub_module sm where up.status='Active' and m.status='Active' and sm.status='Active' and m.module_id=sm.module_id and sm.sub_module_id=up.sub_module_id and up.user_id=$_SESSION[userid] and m.module_id=$rowmodule[module_id] order by sm.pos");
                
                $rssbqury = "SELECT ifnull(sm.fa_icon,'fa-circle-o') as s_fa_icon,sm.pos,up.per_id,sm.sub_module_id,sm.sub_module_page,sm.sub_module_name FROM web_user_permission up,web_st_module m, web_st_sub_module sm WHERE up.status='Active' AND m.status='Active' AND sm.status='Active' AND m.module_id=sm.module_id AND sm.sub_module_id=up.sub_module_id AND up.user_id = ? AND m.module_id = ? order by sm.pos";
                $rssbconn = db_connect();
                $rssbstmt = $rssbconn->prepare($rssbqury);
                $rssbstmt->bind_param("ii", $_SESSION['userid'], $rowmodule['module_id']);
                $rssbstmt->execute();
                $rssubmodule = $rssbstmt->get_result()->fetch_all(MYSQLI_ASSOC);
                $rssbstmt->close();
            ?>
            <li class="treeview" id="block_<?php echo $rowmodule['module_id'];?>">
                <a href="#">
                    <i class="fa <?php echo $rowmodule['fa_icon'];?>"></i>
                    <span><?php echo $rowmodule['module_name'];?></span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <?php
                  if($rssubmodule){
                    echo '<ul class="treeview-menu">';
                    
                    foreach ($rssubmodule as $rowsubmodule){                        
                        $noUtili=(file_exists("$rowsubmodule[sub_module_page].php"))?'':'noDeveloped';
                        if($rowsubmodule['sub_module_page']!='painting_details')
                        {
                    ?>
                        <li data-original-title="<?php echo $rowsubmodule['sub_module_name'];?>" data-toggle="tooltip" id="sub_block_<?php echo $rowsubmodule['sub_module_id'];?>"><a href="<?php echo base_url()."/control/$rowsubmodule[sub_module_page].php?per_id=$rowsubmodule[per_id]&amp;EncHid=$_SESSION[EncTok]";?>" class="<?php echo $noUtili;?>"><i class="fa <?php echo $rowsubmodule['s_fa_icon'];?>"></i> <?php echo $rowsubmodule['sub_module_name'];?></a></li>
                    <?php
                    }
                  }
                    echo '</ul>';
                  }
                  ?>
            </li>
            <?php
            }
        }
        ?>
    </section>
    <!-- /.sidebar -->
  </aside>  
  <script type="text/javascript">
  $(function(){
    <?php
    if(!empty($_SESSION['nav'][0])){
        $mID='block_'.$_SESSION['nav'][0];
    ?>
    $('.sidebar-menu').find('.active').removeClass('active')
    $('#<?php echo $mID;?>').addClass('active');
    <?php
    }
    
    
    if(!empty($_SESSION['nav'][1])){
        $smID='sub_block_'.$_SESSION['nav'][1];
    ?>    
    $('#<?php echo $smID;?>').addClass('active');
    <?php
    }
    ?>
    $('.noDeveloped').click(function(){
        $.fn.custom_alert({msg:'As yet utility not Developed!',title:'Information'});
        return false;
    })
  })
  </script>