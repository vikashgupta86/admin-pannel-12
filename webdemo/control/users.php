<?php 
    include '../appcode/globals.inc.php';
    include_once(BASE_PATH .'/control/include/include.inc.php');
    userAuthenticationPageLevel();
    userAuthenticationMainLevel();
    include_once('include/pageHeader.inc.php');
    include('include/top_user_info.inc.php'); 
?>

<h2 class="h5 content-header text-dark">Manage Users</h2>

<div class="form-box mb-4"> 
    <form name="frm" id="frm" action="<?php echo curPageName() . "?EncHid=$_SESSION[EncTok]" ?>" role="form" method="post">
      <input type="hidden" name="preSub" id="preSub" value="1" />
      <input type="hidden" name="per_id" id="per_id" value="<?php echo $_REQUEST['per_id'] ?>" />
      <div class="mb-3">
        <label for="user_type_id" class="form-label fw-bold small">User Types <span class="text-danger">*</span></label>
        <select name="user_type_id" id="user_type_id" class="form-select form-select-sm rounded-0" data-validate="user_type_id|text|y|1|10|num|dontselect=-1|Please enter Valid option!">
          <option value="-1">--- Select ---</option>
          <?php
          $subQry = ($_SESSION['user_type'] != '0') ? " and user_type_id not in(4)" : '';

          $rs1 = fetchtable("web_st_user_type", "status='Active' $subQry order by pos");
          if ($rs1[0] > 0) {
            foreach ($rs1[1] as $row1) {
            if (($_REQUEST['user_type_id'] ?? '') == $row1['user_type_id']) {
              echo "<option value='$row1[user_type_id]' selected=''>$row1[user_type]</option>";
            } else {
              echo "<option value='$row1[user_type_id]'>$row1[user_type]</option>";
            }

          }
        }
        ?>
      </select>
    </div>
    <div class="text-center">
        <button type="submit" class="btn btn-primary rounded-0 px-4 process-btn">Proceed</button>
    </div>
  </form>
</div>



    <?php
    $frmError="";
    if (isset($_REQUEST['preSub']) && $_REQUEST['preSub'] == 1 && $frmError == false) {
     $ShowGridFlage = true;
     ?>

     <div class="text-end mb-2">
    <button id="AddNew" cdata-frmT="1" class="btn btn-warning rounded-0 fw-bold px-3 py-1 add-btn"><i class="fas fa-plus-square me-1" aria-hidden="true"></i>Add New Link</button>
</div>

     <div class="box-body clearfix">
      <div class="panel panel-default">
        <div class="panel-heading box-title mt-5"><b>Users List</b></div>
        <div class="panel-body">
          <table id="GridData" class="table table-bordered table-striped table-hover">
            <thead>
              <tr>
                <th>S.No</th>
                <th>User Type</th>
                <th>User Name</th>
                <th>Address</th>
                <th>Mobile No.</th>
                <th>Login ID</th>
                <!--<th>Password</th>-->
                <th>Current Status</th>
              <!--  <th class="text-center"><button type="button" id="AddNew" cdata-frmT='1' class="btn btn-primary">Add New User <i class="fa fa-plus-square-o" aria-hidden="true"></i></button></th> -->
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
      <div id="ShowMsg1"></div>
      <div id="reloadGrid"></div>
    </div>
    <?php
  }
  ?>
  <!-- /.box-body -->
</div>
</div>
<!-- /.content-wrapper -->
<?php include 'include/pageFooter.inc.php';?>

<div class="control-sidebar-bg"></div>
</div>
</body>
<script <?= $nonce; ?>  type="text/javascript">
  $(document).delegate('#AddNew,.fa-edit,.fa-trash-o,.fa-eye,.fa-eye-slash,.fa-retweet', 'click', function() {
    var frmType=$(this).attr('cdata-frmT');
    if($.inArray(frmType,['3','4','5','6'])!='-1'){
      var con=confirm('Do you really want to Proceed?');
      console.log(con)
      if(con){
        $.base64.utf8encode = true;
        $.ajax({
          type     : "POST",
          dataType: "text",
          cache    : false,
          url      : '<?php echo "user_frm_action.php?per_id=$_REQUEST[per_id]&amp;EncHid=$_SESSION[EncTok]"; ?>',
          data     : {<?php echo $GLOBALS['csrf']['token']; ?>,'frmType':frmType,'user_id':$(this).data('uid')},
          beforeSend: function(){
            $.fn.ajaxLoading();
          },
          success  : function(data) {
            try{
              data=$.parseJSON($.base64.atob(data));
              if(data[0]){
                $('#ShowMsg1').ShowMsg({msg:'Request Completed Successfully!',alertClass:'alert-success'});
                $('#reloadGrid').trigger('click');
              }
              else{
                $('#ShowMsg1').ShowMsg({msg:'Request not Completed Successfully!',alertClass:'alert-danger'});
              }
            }
            catch(err) {
              $('#ShowMsg1').ShowMsg({msg:"<strong>Error:</strong> Unexpected Response received, You may try again!",alertClass:'alert-warning'});
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
    }
    else{
      $('.modal-container').OpenPop({
        url:"user_frm.php?frmType=" + frmType + "&user_id=" + $(this).data('uid') + "&user_type_id=<?php echo "$_REQUEST[user_type_id]"; ?>&per_id=<?php echo "$_REQUEST[per_id]&EncHid=$_SESSION[EncTok]"; ?>",
        title: "Add/ Modify User Details"
      });
    }
  });

  $(function(){
    $('#frm').formChecks().SetToFirstFocus();


    var mGridTable=$('#GridData').DataTable({
      'aoColumnDefs': [{'aTargets': [2],'bSortable': false}],
      "processing": true,
      "serverSide": false,
      "ajax": "AjaxFill/getUsers.php?user_type_id=<?php echo "$_REQUEST[user_type_id]"; ?>&per_id=<?php echo "$_REQUEST[per_id]&EncHid=$_SESSION[EncTok]"; ?>",
                /*"fnRowCallback" : function(nRow, aData, iDisplayIndex){
                    var index = iDisplayIndex +1;
                    $('td:eq(0)',nRow).html(index);
                   return nRow;
                 }*/
                /*"initComplete": function(settings, json) {
                    console.log(settings+' JSON:'+json)
                  }*/
                });

    $(document).delegate('#reloadGrid', 'click', function ReLoadGrid() {
      mGridTable.ajax.reload( null, false );
    });
  })

</script>