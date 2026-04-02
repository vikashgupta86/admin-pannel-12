<?php include '../../appcode/globals.inc.php';
AjaxFilePrevent();
userAuthenticationPageLevel();
?>
    <?php
$rs = simplefetch("select wup.profile_img,case when wup.landline is not null then concat(ifnull(wup.std_code,''),'-',wup.landline, ' (Landline)') else '' end as landline,
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
WHERE wu.status='Active' and wu.current_status='Active' and wu.user_id = ".$_SESSION['userid']."");
if ($rs[0] > 0) {
	foreach ($rs[1] as $row);
	?>
<!-- <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad" > -->
  <div class="profile-card border">
    <div class="profile-card-header">
      <h3 class="panel-title"><?php echo $row['sName']; ?></h3>
    </div>
    <div class="row g-0">
      <div class="col-md-4 profile-img-container bg-white">
        <img alt="User Pic" src="../WriteReadData/PF45214/<?php echo (!empty($row['profile_img'])) ? "$row[profile_img]" : "np.png"; ?>" width="100" class="img-circle img-responsive">
      </div>

        <div class="col-md-8 bg-white">
          <div class="table-responsive">
              <table class="table mb-0 profile-table align-middle">
                <tbody>
                <!--<tr>
                    <td>Department:</td>
                    <td>Programming</td>
                  </tr>-->
                  <tr>
                    <td>User Since:</td>
                    <td><?php echo $row['created_on']; ?></td>
                  </tr>
                  <tr>
                    <td>Date of Birth:</td>
                    <td><?php echo $row['dob']; ?></td>
                  </tr>

                     <tr>
                        <td>Gender:</td>
                        <td><?php echo $row['gender']; ?></td>
                      </tr>
                    <tr>
                        <td>Address:</td>
                        <td><?php echo wordwrap($row['addr'], 48, '<br>'); ?></td>
                  </tr>
                  <tr>
                    <td>Email:</td>
                    <td><?php echo $row['email_id']; ?></td>
                  </tr>
                <tr>
                    <td>Contact Details:</td>
                    <td><?php
                            echo !empty($row['landline']) ? $row['landline'] . '<br>' : '';
                            echo !empty($row['fax']) ? $row['fax'] . '<br>' : '';
                            echo $row['mobile'];
	                        ?>
                    </td>
                </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="profile-card-footer">
        <button type="button" class="btn btn-warning btn-sm text-white rounded-0 px-3" data-toggle="tooltip" cdata-frmT='1' id="edtProfile" style="background-color: #f39c12; border-color: #e08e0b;" data-bs-toggle="modal" data-bs-target="#manageProfileModal">
            <i class="fas fa-pencil"></i>
        </button>
    </div>

  </div>
</div>
<?php
} else {
	show_msg("No profile details found");
}

?>
