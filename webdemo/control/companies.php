<?php include '../appcode/globals.inc.php';
include_once(dirname_r(__FILE__, 1) . '/include/include.inc.php');
$obj->userAuthenticationPageLevel();
$obj->userAuthenticationMainLevel();
include_once('include/pageHeader.inc.php');
?>

<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    if (isset($_POST['type1']) && $_POST['frmType'] == 4) 
    {

        $pass = $_POST['new_password'];

        $frmVal = array(
          "new_password|text|y|1|50|alnum_spcA|Please enter Valid Password!",
        );

       

        $ValiStr = implode('|$$|', $frmVal);
        $FrmError = $chk->requestcheck($ValiStr, "frm", "div", true, true);


        if(!$FrmError[0]) 
        {
            $FielArr = array(
                'password' => hash('sha256', $pass),
                'reset_password' => '1',
            );

            
            $Fields = implode('|$$|', array_keys($FielArr));
            $Values = implode("|$$|", $FielArr);
            $success=$obj->update('applicant_register',$Fields,$Values,"applicant_id=$_POST[u_id]");

          
            if ($success) 
            {
                echo "<script>alert('Password Changed Successfully');</script>";
                 echo "<script>
                    $(window).load(function(){
                        $('#thankyouModal').modal('show');
                    });
                </script>";
            ?>    
                    <div class="modal" tabindex="-1" role="dialog" id="thankyouModal">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"><?php echo $_POST['compname']; ?></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Updated Password is - <b><?php echo $_POST['new_password']; ?></b></p>
                            </div>
                            <div class="modal-footer">
                                <!-- <button type="button" class="btn btn-primary" onclick="copyToClipboard(<?php // echo $_POST['new_password']; ?>)">Copy Password</button> -->
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                            </div>
                        </div>
                    </div>
            
            <?php } 
            else {
                echo "<script>alert('Something Went Wrong');</script>";
            }

        } else {
            echo "<script>alert('Enter Details in correct format');</script>";
        }
    }
    
}


//echo $_SERVER['SERVER_NAME'];
?>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php include('include/top_user_info.inc.php'); ?>
        <!-- Left side column. contains the logo and sidebar -->
        <?php include('include/left_nav.inc.php'); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Registered Companies</h3>
                </div>

                <div class="box-body">
                    <form name="frm" id="frm" action="<?php echo $obj->curPageName() . "?per_id={$_REQUEST['per_id']}&EncHid={$_SESSION['EncTok']}" ?>" role="form" class="form-border clearfix col-sm-6 col-sm-offset-3" method="post">
                        <input type="hidden" name="preSub" id="preSub" value="1" />
                        <div class="form-group">
                            <label for="notice_id">Choose Notification</label>
                            <select name="notice_id" id="notice_id" class="form-control" data-validate="user_id|text|y|1|10|num|dontselect=-1|Please enter Valid option!">
                                <option value="-1">--- Select ---</option>
                                <?php
                                
                                    $rs3 = $obj->simplefetch("SELECT * FROM `notifications` where `status` = 'Active' ORDER BY notice_id DESC");
                                    foreach ($rs3[1] as $row3) {
                                        if ($row3['notice_id'] == $_REQUEST['notice_id']) {
                                            echo "<option value='$row3[notice_id]' selected>$row3[title] ($row3[start_date] - $row3[end_date]) </option>";
                                        } else {
                                            echo "<option value='$row3[notice_id]'>$row3[title] ($row3[start_date] - $row3[end_date]) </option>";
                                        }
                                    }

                                ?>
                            </select>
                        </div>
                        <div class="col-sm-8 col-sm-offset-4">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>

                <?php
                if (isset($_REQUEST['preSub']) && $_REQUEST['preSub'] == 1 && $frmError == false) {
                $ShowGridFlage = true;
                ?>

                <div class="box-body clearfix">
                    <div class="panel panel-default">
                        <ul class="nav nav-tabs" id="myTab">
                            <li class="active"><a tab-ind='1' data-target="#notification" data-toggle="tab">School List</a></li>
                            <span class="exportdiv btn btn-primary" style="float:right;"><a href="AjaxFill/export_company_data.php">Export Data</a></span>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="notification">
                                <table id="myTable1" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Applicant Name</th>
                                            <th>Organisation Name</th>
                                            <th>Email</th>
                                            <th>Mobile</th>
                                            <th>Sector Name</th>
                                            <th>Sub Sector Name</th>
                                            <th>Questionnaire Document</th>
                                            <th>Other uploaded Document</th>
                                            <th>Date</th>
                                            <th>Reset Password</th>
                                            <!--<th class="text-center">View</th>-->
                                        </tr>
                                    </thead>
                                </table>
                            </div>
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
        <?php include('include/pageFooter.inc.php'); ?>

        <div class="control-sidebar-bg"></div>
    </div>


   
</body>


<script>
    function copyToClipboard(textToCopy) 
    {
        alert(textToCopy)
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val(textToCopy).select();
        document.execCommand("copy");
        $temp.remove();
   }
</script>

<script>
     


    $(document).delegate('.fa-retweet', 'click', function() 
    {
        if (window.confirm("Are you sure you want to reset password ?")) 
        {
            var frmType = $(this).attr('cdata-frmT');
            var uid = $(this).attr('data-uid');

            $('.modal-container').OpenPop({
                url: "reset_company_password_popup.php?frmType=" + frmType + "&per_id=<?php echo "$_SESSION[per_id]&EncHid=$_SESSION[EncTok]" ?>&u_id=" + uid,
            });
        }
        else 
        {
            
        }
    });
</script>

<script>
    // $(document).delegate('.exportdiv', 'click', function() 
    // {
        
    //   //  $.base64.utf8encode = true;
    //     $.ajax({
    //         type: "POST",
    //         dataType: "text",
    //         cache: false,
    //         url: '<?php echo "AjaxFill/export_company_data.php?per_id=$_SESSION[per_id]&EncHid=$_SESSION[EncTok]"; ?>',
    //         data: {
    //             <?php echo $GLOBALS['csrf']['token']; ?>,
    //         },
    //         beforeSend: function() 
    //         {
    //             $.fn.ajaxLoading();
    //         },
    //         success: function(res) 
    //         {
    //            // $.fn.ajaxLoading();
    //           // window.location.href = "AjaxFill/export_company_data.php";
    //         },
    //         error: function() 
    //         {
    //             $.fn.custom_alert({
    //                 msg: 'Something went wrong, Please try again!'
    //             });
    //         },
    //         complete: function() {
    //             $.fn.ajaxLoading({
    //                 show: false
    //             });
    //         },
    //     });
        
    // });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('.CallDate').datepicker({
            autoclose: true,
            minViewMode: 2,
            format: 'yyyy'
        });
    })

    var mGridTable = '',
        mGridTable1 = '';
    $(function() {

        $('#frm').formChecks().SetToFirstFocus();
        $('.CallDate1').click(function() {
            $(this).siblings('.CallDate').trigger('focus');
        })

        // $('.date-own').datepicker({
        //     autoclose:true,
        //     minViewMode: 2,
        //     format: 'yyyy'
        // });


        if ($('#myTab').length > 0) {
            jQuery('#myTab a:first').tab('show');
            tab = '#notification';
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                $.fn.dataTable.tables({
                    visible: true,
                    api: true
                }).columns.adjust();
                //console.log($(this).data('target'))
                tab = $(this).res('target');
            });

            $('#myTab a').each(function(i, d) {
                //console.log($(d).attr('tab-ind'))
                tabID = $(d).attr('tab-ind');
                //console.log(tabID)
                tempTable = $('table#myTable' + tabID).DataTable({
                    "processing": true,
                    "serverSide": false,
                    "ajax": {
                        "url": "AjaxFill/companiesList.php?<?php echo "EncHid=$_SESSION[EncTok]"; ?>",
                        "type": "POST",
                        "data": {
                            <?php echo $GLOBALS['csrf']['token']; ?>,
                            'n_id': '<?php echo "$_REQUEST[notice_id]" ?>'
                        }
                    },
                    scrollY: 400,
                    scrollCollapse: true,
                    paging: false,
                    "drawCallback": function(settings) {
                        $('[data-toggle="tooltip"]').tooltip();
                    }
                });

                if (tabID == 1) {
                    mGridTable = tempTable;
                }
                if (tabID == 2) {
                    mGridTable1 = tempTable;
                }
            })
        }

        $(document).delegate('#reloadGrid', 'click', function ReLoadGrid() {
            mGridTable.ajax.reload(null, false);
            mGridTable1.ajax.reload(null, false);
        });

    })
</script>


<!-- CALLING TINYMCE RTF CONFIG FILE END --->
<script src='../tinymce/tinymce/tinymce.min.js'></script>
<script src="rtf/rtfConf.js"></script>