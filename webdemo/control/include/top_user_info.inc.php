<body>
    <div id="wrapper">

      <?php  
    include "logoff_timer.php";

    $_SESSION['per_id']= $_REQUEST['per_id'] ?? 0;

    $_REQUEST['nmnh_type_id'] = $_REQUEST['nmnh_type'] ?? 1;
    // $prs=$obj->simplefetch("select wup.profile_img,case when wup.landline is not null then concat(ifnull(wup.std_code,''),'-',wup.landline, ' (Landline)') else '' end as landline,
    //     case when wup.f_landline is not null then concat(ifnull(wup.f_std_code,''),'-',wup.f_landline, ' (Fax)') else '' end as fax,
    //     case when wup.mobile is not null then concat(wup.mobile, ' (Mobile)') else '' end as mobile,
    //     concat(ifnull(t.title_name,''), ' ', ifnull(wup.f_name,''), ' ', ifnull(wup.m_name, ''), ' ', ifnull(wup.l_name, ''))as sName,
    //     concat(wup.addr,ifnull(concat(', ',d.district_name),''),ifnull(concat(' ',s.state_name),''),  ifnull(concat(', pin code -',wup.pincode),''))as addr,
    //     ifnull(wu.uname,'N/A')as email_id,case when wup.gender=1 then 'Male' when wup.gender=2 then 'Female'  when wup.gender=1 then 'Transgender' else 'N/A' end as gender,
    //     date_format(wu.created_on,'%M %d, %Y')as created_on,date_format(wup.dob,'%M %d, %Y')as dob from web_users_profile wup
    // RIGHT JOIN web_users wu on wu.user_id=wup.user_id
    // LEFT JOIN web_st_title t on t.title_id=wup.title_id
    // LEFT JOIN web_st_states s on s.state_id=wup.state_id
    // LEFT JOIN web_st_districts d on d.district_id=wup.district_id
    // WHERE wu.status='Active' and wu.current_status='Active' and wu.user_id=$_SESSION[userid]");

    $tpsql = "SELECT wup.profile_img,case when wup.landline is not null then concat(ifnull(wup.std_code,''),'-',wup.landline, ' (Landline)') else '' end as landline,
              case when wup.f_landline is not null then concat(ifnull(wup.f_std_code,''),'-',wup.f_landline, ' (Fax)') else '' end as fax,
              case when wup.mobile is not null then concat(wup.mobile, ' (Mobile)') else '' end as mobile,
              concat(ifnull(t.title_name,''), ' ', ifnull(wup.f_name,''), ' ', ifnull(wup.m_name, ''), ' ', ifnull(wup.l_name, ''))as sName,
              concat(wup.addr,ifnull(concat(', ',d.district_name),''),ifnull(concat(' ',s.state_name),''),  ifnull(concat(', pin code -',wup.pincode),''))as addr,
              ifnull(wu.uname,'N/A')as email_id,case when wup.gender=1 then 'Male' when wup.gender=2 then 'Female'  when wup.gender=1 then 'Transgender' else 'N/A' end as gender,
              date_format(wu.created_on,'%M %d, %Y')as created_on,date_format(wup.dob,'%M %d, %Y')as dob from web_users_profile wup
              RIGHT JOIN web_users wu on wu.user_id=wup.user_id
              LEFT JOIN web_st_title t on t.title_id=wup.title_id
              LEFT JOIN web_st_states s on s.state_id=wup.state_id
              LEFT JOIN web_st_districts d on d.district_id=wup.district_id
              WHERE wu.status='Active' and wu.current_status='Active' and wu.user_id= ?";
    $tpconn = db_connect();
    $tpstmt = $tpconn->prepare($tpsql);
    $tpstmt->bind_param("i", $_SESSION['userid']);
    $tpstmt->execute();
    $prs = $tpstmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $tpstmt->close();

    foreach($prs as $prow);
?>

      <?php include('include/left_nav.inc.php');?>


<?php
/*
<header class="main-header d-none">
    <!-- Logo -->
    <a href="main.php?per_id=<?= $_REQUEST['per_id'] ?? ''; ?>&amp;EncHid=<?= $_SESSION['EncTok']; ?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>D</b>EPT</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Super</b> ADMIN</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <div class="col-md-4 col-md-offset-4" id="countdown"></div>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
        
          <!-- Notifications: style can be found in dropdown.less -->
        
          <!-- Tasks: style can be found in dropdown.less -->
          
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">

            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="../WriteReadData/PF45214/<?php echo (!empty($prow['profile_img']))?"$prow[profile_img]":"np.png";?>" class="img-circle" alt="User Image">

                <p>
                  <?php echo $prow['sName'];?>
                  <small>Member since: <?php echo $prow['created_on'];?></small>
                </p>

              </li>
              <!-- Menu Body -->
              <div class="clearfix"></div>
              <!-- Menu Footer-->
              <li class="user-footer">
                <ul class="list-group list-inline">
                  <li><a data-original-title="View Profile" data-toggle="tooltip" href="<?php echo "u_profile.php?per_id=$_SESSION[per_id]&amp;EncHid=$_SESSION[EncTok]";?>" class="btn btn-default btn-flat">Profile</a></li>
                  <li><a data-original-title="Change Password" data-toggle="tooltip" href="<?php echo "change_pass.php?per_id=$_SESSION[per_id]&amp;EncHid=$_SESSION[EncTok]";?>" class="btn btn-default btn-flat">Change Password</a></li>
                  <li><a data-original-title="LogOff" data-toggle="tooltip" href="<?php echo "logoff.php?per_id=$_SESSION[per_id]&amp;EncHid=$_SESSION[EncTok]";?>" class="btn btn-default btn-flat">Sign out</a></li>
                </ul>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->          
        </ul>
      </div>
    </nav>
  </header>

*/
?>


    <div class="main-content">
        <header class="top-navbar">
            <button id="sidebarToggle" class="btn btn-link text-white text-decoration-none fs-5 p-0" aria-label="Toggle Navigation"><i class="far fa-bars"></i></button>
            <div class="timer-section d-flex align-items-center flex-grow-1 justify-content-center justify-content-md-center mt-2 mt-md-0">
                <span class="me-2 text-center" style="font-size: 13px;" id="countdown">You Will Be Logged Out In <strong>00-14-30 Sec</strong></span>
            </div>
            <div class="dropdown">
                <button class="d-flex align-items-center text-white text-decoration-none dropdown-toggle btn p-0 border-0" type="button" id="profileDropdown" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                    <img src="assets/images/avatar.png" class="rounded-circle me-2" alt="User" width="25" height="25">
                    <span class="d-none d-sm-inline" style="font-size: 13px;">Shri CMS</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end rounded-0 shadow-sm mt-2" aria-labelledby="profileDropdown">
                    <li><a class="dropdown-item small" href="<?php echo base_url()."/control/u_profile.php?per_id=".($_SESSION['per_id'] ?? '')."&amp;EncHid=$_SESSION[EncTok]";?>"><i class="fas fa-user-circle me-2 text-muted"></i> Profile Details</a></li>
                    <li><a class="dropdown-item small" href="<?php echo base_url()."/control/change_pass.php?per_id=".($_SESSION['per_id'] ?? '')."&amp;EncHid=$_SESSION[EncTok]";?>"><i class="fas fa-key me-2 text-muted"></i> Change Password</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item small text-danger fw-bold" href="include/logoff.php?per_id=<?php echo $_SESSION['per_id'] ?? ''; ?>&amp;EncHid=<?php echo $_SESSION['EncTok']; ?>"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
                </ul>
            </div>
        </header>

        <main class="p-3 flex-grow-1 bg-white">

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>