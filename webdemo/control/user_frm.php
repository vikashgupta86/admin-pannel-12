<?php include '../appcode/globals.inc.php';
require_once(dirname_r(__FILE__, 1) ."/include/include.inc.php");
AjaxFilePrevent();

//for state officer
$dsg='y';
if($_REQUEST['user_type_id']==9)
{
  $dsg='n';
}
?>


      <?php
      if (isset($_REQUEST['frmType']) && $_REQUEST['frmType'] == 2) {
       $rs = simplefetch("select wu.user_id,uf.f_name, uf.m_name, uf.l_name, uf.addr, uf.mobile, uname,
        uf.state_id, uf.district_id, uf.pincode, uf.std_code,wu.other_designation,wu.desig_id, uf.landline, uf.f_std_code, uf.f_landline,wu.department
        from web_users wu
        INNER JOIN web_users_profile uf on uf.user_id=wu.user_id
        where wu.status='Active' and wu.current_status='Active' and wu.user_id=$_REQUEST[user_id]");
       
       if ($rs[0] > 0) {
        foreach ($rs[1] as $row);
      }
    }
    ?>

    <form name="formNC" id="formNC" method="post" autocomplete="off" role="form" action="<?php echo "user_frm_action.php?per_id=$_SESSION[per_id]&amp;EncHid=$_SESSION[EncTok]"; ?>">
      <input type="hidden" name="frmType" id="frmType" value="<?php echo $_REQUEST['frmType']; ?>" />
      <input type="hidden" name="user_id" id="user_id" value="<?php echo $_REQUEST['user_id']; ?>" />
      <div class="modal-body">
        <div class="box-body">
          <?php 


          if(in_array($_SESSION['user_type'],array(1,2,13)) && !in_array($_REQUEST['user_type_id'], array(1,4)) ){ 

           ?>
            <div class="form-group">
              <label for="user_type_id">User Types</label>
              <select name="user_type_id" id="user_type_id" class="form-control user_type_id" data-validate="user_type_id|text|y|1|10|num|dontselect=-1|Please enter Valid option!">
                <option value="-1">--- Select ---</option>
                <?php
                // $subQry = ($_SESSION['user_type'] != '0') ? " and user_type_id not in(1,4)" : '';
                if($_SESSION['user_type']==13){#menas EPC users
                  $subQry =  "and user_type_id in (3,15)" ;
                }
                else if($_SESSION['user_type'] != '0'){
                      $subQry =  "and user_type_id not in(1,2,4)" ;
                }else{
                  $subQry =  "";
                }

                $rs1 = fetchtable("web_st_user_type", "status='Active' $subQry order by pos");
                if ($rs1[0] > 0) {
                 foreach ($rs1[1] as $row1) {
                  if ($_REQUEST['user_type_id'] == $row1['user_type_id']) {
                   echo "<option value='$row1[user_type_id]' selected=''>$row1[user_type]</option>";
                 } else {
                   echo "<option value='$row1[user_type_id]'>$row1[user_type]</option>";
                 }

               }
             }
             ?>
           </select>
         </div>

         <?php

       }

       else{
 

        if(in_array($_REQUEST['user_type_id'], array(4))){ 
          echo "<input type='hidden' name='user_type_id' id='user_type_id' value='$_SESSION[user_type]'>";
        }else{ 
          echo "<input type='hidden' name='user_type_id' id='user_type_id' value='$_REQUEST[user_type_id]'>";
        }
      }


      if(!in_array($_REQUEST['user_type_id'], array(1,4,8))){
     
       $stychk = "display:block";
     }
    
     else{
        
        $stychk = "display:none";
        
     }


      if(in_array($_REQUEST['user_type_id'], array(8))){
       
           $stychk1 = "display:block";
        }
        else{
        $stychk1 = "display:none";
        }

     $usr_type = $_REQUEST['user_type_id']; ?>
     <div class="row">
     <div class="form-group col-md-4" id="deg" style="<?php echo $stychk; ?>">
      <label for="desig_id">Designation</label>
      <select name="desig_id" id="desig_id" class="form-control" data-validate="desig_id|text|<?php echo $dsg ?>|1|10|num|dontselect=-1|Please enter Valid option!">
        <option value="-1">--- Select ---</option>
        <?php
        
        $rs1 = fetchtable("web_st_designation", "status='Active' AND  FIND_IN_SET($usr_type,applicable_for)  order by pos");
        if ($rs1[0] > 0) {
          foreach ($rs1[1] as $row1) {
            if (($row['desig_id'] ?? '') == $row1['desig_id']) {
              echo "<option value='$row1[desig_id]' selected=''>$row1[designation]</option>";
            } else {
              echo "<option value='$row1[desig_id]'>$row1[designation]</option>";
            }

          }
        }
        ?>
      </select>
      </div>
      <?php  if (($_REQUEST['desig_id'] ?? '') ==9 || ($row['desig_id'] ?? '')==9){
       $stydchk = "display:block";
       }
       else{
       $stydchk = "display:none";
        }?>
     <div class="form-group other_degi col-md-4" style="<?php echo $stydchk; ?>">
      <label for="other_degi">Other Designation:</label>
      <input type="text" class="form-control" name="other_degi" id="other_degi" placeholder="Other Designation" value="<?php echo ($row['other_designation'] ?? ''); ?>" data-validate="other_degi|text|y|1|500|alnum_spc|Please enter Valid Name!"/>
    </div>



<div class="form-group col-md-4" id="deg1" style="<?php echo $stychk1; ?>">
      <label for="desig_id1">Department</label>
      <select name="department" id="department" class="form-control" data-validate="department|text|y|1|10|num|dontselect=-1|Please enter Valid option!">
        <option value="-1">--- Select ---</option>
        <?php
        $rs1 = fetchtable("department", "status='Active'");
        if ($rs1[0] > 0) {
          foreach ($rs1[1] as $row1) {
              if (($row['department'] ?? '') == $row1['id']) {
                echo "<option value='$row1[id]' selected=''>$row1[dept_name]</option>";
              } else {
                echo "<option value='$row1[id]'>$row1[dept_name]</option>";
              }
          }
        }
        ?>
      </select>
      </div> 


  </div>










    <div class="row">
      <div class="form-group col-md-2">
        <label for="title_id">Title</label>
        <select name="title_id" id="title_id" class="form-control" data-validate="title_id|text|n|1|10|num|dontselect=-1|Please enter Valid option!">
          <option value="-1">N/A</option>
          <?php
          $rs1 = fetchtable("web_st_title", "status='Active' and title_id!=8 order by pos");
          if ($rs1[0] > 0) {
           foreach ($rs1[1] as $row1) {
            if (($row['title_id'] ?? '') == $row1['title_id']) {
             echo "<option value='$row1[title_id]' selected=''>$row1[title_name]</option>";
           } else {
             echo "<option value='$row1[title_id]'>$row1[title_name]</option>";
           }

         }
       }
       ?>
     </select>
   </div>

   <div class="form-group col-md-3">
    <label for="f_name">First Name:</label>
    <input type="text" class="form-control" name="f_name" id="f_name" placeholder="First Name" maxlength="100" value="<?php echo ($row['f_name'] ?? ''); ?>" data-validate="f_name|text|y|1|100|alpha_s|Please enter Valid Name!"/>
  </div>

  <div class="form-group col-md-3">
    <label for="m_name">Middle Name:</label>
    <input type="text" class="form-control" name="m_name" id="m_name" placeholder="Middle Name" maxlength="100" value="<?php echo ($row['m_name'] ?? ''); ?>" data-validate="m_name|text|n|1|100|alpha_s|Please enter Valid Name!"/>
  </div>

  <div class="form-group col-md-3">
    <label for="l_name">Last Name:</label>
    <input type="text" class="form-control" name="l_name" id="l_name" placeholder="Last Name" maxlength="100" value="<?php echo ($row['l_name'] ?? ''); ?>" data-validate="l_name|text|y|1|100|alpha_s|Please enter Valid Name!"/>
  </div>
</div>

<?php

//for state officer
$ct='n';
if($_REQUEST['user_type_id']==9)
{
  $ct='y';
}

$ContactFlage = true;
$emailFlage = true;
$india_address = 'display:block';
$int_address = 'display:none';
$ParamArryN['prefix'] = '';
$ParamArryN['Mand'] = array('Addr' => 'n', 'City' => $ct, 'Dist' => 'n', 'Plac' => 'n', 'Pin' => 'n','Demail' => 'y','mobile'=>'n');
$ParamModN = array($ParamArryN['prefix'] . 'Addr' => $row['addr'] ?? "", $ParamArryN['prefix'] . 'City' => $row['state_id'] ?? "", $ParamArryN['prefix'] . 'Dist' => $row['district_id'] ?? "", $ParamArryN['prefix'] . 'Pin' => $row['pincode'] ?? "", $ParamArryN['prefix'] . 'c_Land' => $row['std_code'] ?? "", $ParamArryN['prefix'] . 'Land' => $row['landline'] ?? "", $ParamArryN['prefix'] . 'mob' => $row['mobile'] ?? "", $ParamArryN['prefix'] . 'c_Fax' => $row['f_std_code'] ?? "", $ParamArryN['prefix'] . 'Fax' => $row['f_landline'] ?? "",$ParamArryN['prefix'].'Demail'=>$row['uname'] ?? "");
include 'include/Com_addr.inc.php';
?>

</div>
<!-- /.box-body -->
                  <!--<div class="box-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>-->

                  <div class="clearfix"></div>
                  <div id="ShowMsg"></div>
                </div>
                <div class="clearfix"></div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
              
        <script <?= $nonce; ?>  type="text/javascript">
          $(function(){
            $('#formNC').formChecks({ajaxSubFunc:frmAction}).SetToFirstFocus();
            $(".modal-dialog").css("width", "850px");
          })


          function frmAction(){
            $.base64.utf8encode = true;
            $.ajax({
              type     : "POST",
              dataType: "text",
              cache    : false,
              url      : $('#formNC').attr('action'),
              data     : $('#formNC').serialize(),
              beforeSend: function(){
                $.fn.ajaxLoading();
              },
              success  : function(data) {
                try{
                  data=$.parseJSON($.base64.atob(data));
                  if(data[0]){
                    ($('#frmType').val()==1)?$('#formNC')[0].reset():'';
                    $('#ShowMsg').ShowMsg({msg:'Request Completed Successfully!',colwidth:'col-md-8',coloffset:'col-md-offset-2',alertClass:'alert-success'});
                    $('#reloadGrid').trigger('click');
                  }
                  else{
                    if(data[1]!= undefined && data[1][0]==true){
                      FEror=data[1][1];
                      $.fn.ShowError(FEror);
                    }
                    else if(data[2]!= undefined && data[2][0]==true){
                      MEror=data[2][1];
                        //console.log(MEror);
                        $('#ShowMsg').ShowMsg({msg:MEror,alertClass:data[2][2],colwidth:'col-md-8',coloffset:'col-md-offset-2'});
                      }
                      else{
                        $('#ShowMsg').ShowMsg({msg:'Request not Completed Successfully!',colwidth:'col-md-8',coloffset:'col-md-offset-2',alertClass:'alert-danger'});
                      }
                    }
                  }
                  catch(err) {
                    $('#ShowMsg').ShowMsg({msg:"<strong>Error:</strong> Unexpected Response received, You may try again!",colwidth:'col-md-8',coloffset:'col-md-offset-2',alertClass:'alert-warning'});
                  }

                },
                error:function(){
                  $.fn.custom_alert({msg:'Something went wrong, Please try again!'});
                },
                complete: function(){
                  $.fn.ajaxLoading({show:false});
                },
              });
          }

          $(document).ready(function(){
            $('.user_type_id').change(function() {

              var dep_id = $(this).val();
              if(dep_id !='')
              {
               $('#deg').css('display','block');
               GetDesignation('desig_id',dep_id);

             }else{ 
               $('#deg').css('display','none');
             }
           });

            $('#desig_id').change(function() {
              var deg_id = $(this).val();
              if(deg_id==1)
              {
                $('.other_degi').css('display','block');
              }else
              {
                $('.other_degi').css('display','none');
              }
            });

            
          });


          function GetDesignation(FillTo,dep_id){
            $.fn.FillData({url:'AjaxFill/getDesignationList.php',Fill_To:FillTo,Arr:{'user_type':dep_id},Async:false});
          }

        </script>