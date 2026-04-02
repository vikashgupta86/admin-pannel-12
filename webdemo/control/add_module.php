<?php 
    include '../appcode/globals.inc.php';
    include_once(BASE_PATH .'/control/include/include.inc.php');
    userAuthenticationPageLevel();
    userAuthenticationMainLevel();
    include_once('include/pageHeader.inc.php');
    include('include/top_user_info.inc.php'); 
?>
    
<h2 class="h5 content-header text-dark">List of Modules</h2>


                    <div class="table-responsive">                                             
                      <table id="GridData" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                              <th>S.No</th>
                              <th>Module Name</th>                                                    
                              <th><button type="button" id="AddNew" class="btn btn-primary">Add New Module <i class="fa fa-plus-square-o" aria-hidden="true"></i></button></th>
                          </tr>
                      </thead>
                  </table>
              </div>  
  
  
<div id="ShowMsg1"></div>
<div id="reloadGrid"></div>

<script>     

$(function () {

    $(document).on('click', '#AddNew, .fa-edit, .fa-trash-o', function () {

        var frmType = $(this).hasClass('fa-edit') ? 2 :
                      $(this).hasClass('fa-trash-o') ? 3 : 1;

        var module_id = $(this).data('modid') || 0;

        if (frmType === 3) {

            if (!confirm('Do you really want to proceed?')) return;

            $.base64.utf8encode = true;

            $.ajax({
                type: "POST",
                dataType: "text",
                cache: false,
                url: "module_action.php?per_id=<?php echo $_SESSION['per_id']; ?>&EncHid=<?php echo $_SESSION['EncTok']; ?>",
                data: {
                    <?php echo $GLOBALS['csrf']['token']; ?>,
                    frmType: 3,
                    module_id: module_id
                },

                beforeSend: function () {
                    $.fn.ajaxLoading();
                },

                success: function (data) {

                    try {

                        data = $.parseJSON($.base64.atob(data));

                        if (data[0]) {

                            $('#ShowMsg1').ShowMsg({
                                msg: 'Request Completed Successfully!',
                                alertClass: 'alert-success'
                            });

                            $('#reloadGrid').trigger('click');

                        } else {

                            $('#ShowMsg1').ShowMsg({
                                msg: 'Request not Completed Successfully!',
                                alertClass: 'alert-danger'
                            });
                        }

                    } catch (err) {

                        $('#ShowMsg1').ShowMsg({
                            msg: "<strong>Error:</strong> Unexpected response received. Try again.",
                            alertClass: 'alert-warning'
                        });

                    }
                },

                error: function () {

                    $.fn.custom_alert({
                        msg: 'Something went wrong, please try again!'
                    });

                },

                complete: function () {
                    $.fn.ajaxLoading({ show: false });
                }
            });

        } else {

            $('.modal-container').OpenPop({
                url: "module.php?frmType=" + frmType +
                     "&module_id=" + module_id +
                     "&per_id=<?php echo $_SESSION['per_id']; ?>&EncHid=<?php echo $_SESSION['EncTok']; ?>"
            });

        }

    });


    var mGridTable = $('#GridData').DataTable({

        columnDefs: [
            { targets: [2], orderable: false }
        ],

        processing: true,
        serverSide: false,

        ajax: "AjaxFill/getModules.php?per_id=<?php echo $_SESSION['per_id']; ?>&EncHid=<?php echo $_SESSION['EncTok']; ?>"

    });


    $(document).on('click', '#reloadGrid', function () {
        mGridTable.ajax.reload(null, false);
    });

});
    </script>


<?php include('include/pageFooter.inc.php');?>
