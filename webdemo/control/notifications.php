<?php include '../appcode/globals.inc.php';
include_once(dirname_r(__FILE__, 1) . '/include/include.inc.php');
$obj->userAuthenticationPageLevel();
$obj->userAuthenticationMainLevel();
include_once('include/pageHeader.inc.php');
$_SESSION['hdUpload'] = 'test';

?>

<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['type1']) && $_POST['frmType'] == 1) {

        $rs1 = $obj->simplefetch("select max(end_date) as max_date from notifications where status='Active'");
        $max_date = $rs1[1][0]['max_date'];

        // echo "<pre>";
        // print_r($rs1[1][0]['max_date']);
        // echo "</pre>";
        // exit();

        if ($max_date >= $_POST['s_date']) {
            echo "<script>alert('Notification for this period already exists!');</script>";
        } else {

            //if (empty($_POST['sector_id']) || empty($_POST['subsector_id'])) {
            //    echo "<script>alert('Select atleast 1 sector & subsector');</script>";
            //} else {
                $sectors = implode(",", $_POST['sector_id']);
                $sub_sectors = implode(",", $_POST['subsector_id']);

                $start_date = $_POST['s_date'];
                $end_date = $_POST['e_date'];

                // Get today's date in 'Y-m-d' format
                $today = date('Y-m-d');

                // Compare the dates
                // if ($start_date <= $today || $end_date <= $today) {
                //     echo "<script>alert('Start Date and End Date should be greater than Todays Date');</script>";
                if ($start_date < $today || $end_date <= $today) {
                    echo "<script>alert('Start Date and End Date should not be less than Todays Date');</script>";
                } elseif ($start_date >= $end_date) {
                    echo "<script>alert('End Date should be Greater than Start Date');</script>";
                } else {

                    $FielArr = array(
                        'year_id' => $_POST['year_id'],
						'title' => $_POST['title'],
                        //'sectors' => $sectors,
                        //'sub_sectors' => $sub_sectors,
                        'start_date' => $start_date,
                        'end_date' => $end_date,
                        // 'year_id' => $year,
                    );

                    $Fields = implode(',', array_keys($FielArr));
                    $Values = implode("|$$|", $FielArr);
                    $suc = $obj->insert("notifications", $Fields, $Values);
                    if ($suc) {
                        $not_id = $suc[0];
                        echo "<script>alert('Notification Created Successfully');</script>";
                    }
                }
            //}
        }
    } else if (isset($_POST['type1']) && $_POST['frmType'] == 9) {

        $rs1 = $obj->simplefetch("select * from notifications where notice_id='" . $_POST['not_id'] . "' and status='Active'");
        if ($rs1[0] > 0) {
            foreach ($rs1[1] as $row);
        }

        //if ( !empty($_POST['sector_id']) || !empty($_POST['subsector_id']) ) {
        //    $sectors = implode(",", $_POST['sector_id']);
        //    $sub_sectors = implode(",", $_POST['subsector_id']);
        //}

        $year_id = $_POST['year_id'];
		$title = $_POST['title'];
        $old_sdate = $row['start_date'];
        $start_date = $_POST['s_date'];
        $end_date = $_POST['e_date'];
        // $grp = $_POST['grp'];

        // Get today's date in 'Y-m-d' format
        $today = date('Y-m-d');

        // Compare the dates
        if ($today >= $old_sdate && $start_date != $old_sdate) {
            echo "<script>alert('Start Date has passed so it cant be changed');</script>";
        } else {
            if ($end_date <= $today) {
                echo "<script>alert('End Date should be greater than Todays Date');</script>";
            } elseif ($start_date >= $end_date) {
                echo "<script>alert('End Date should be Greater than Start Date');</script>";
            } elseif ($today > $start_date && $start_date != $old_sdate) {
                echo "<script>alert('Start Date should not be Less than Todays Date');</script>";
                // } elseif ($today >= $start_date && $start_date!=$old_sdate) {
                //     echo "<script>alert('Start Date should be Greater than Today Date');</script>";
            } else {

                $FielArr = array(
                    'year_id' => $year_id,
					'title' => $title,
                    //'sectors' => $sectors,
                    //'sub_sectors' => $sub_sectors,
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                );

                $Fields = implode('|$$|', array_keys($FielArr));
                $Values = implode("|$$|", $FielArr);

                $suc = $obj->update("notifications", $Fields, $Values, "notice_id='" . $_POST['not_id'] . "'");
                if ($suc) {
                    echo "<script>alert('Notification Updated Successfully');</script>";
                }
            }
        }
    }
}

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
                    <h3 class="box-title">Notifications</h3>
                </div>



                <div class="box-body clearfix">
                    <div class="text-right" style="margin-bottom: 2px;"><button id="AddNew" cdata-frmT='1' class="btn btn-warning">Add New Notification</button></div>
                    <div class="panel panel-default">
                        <ul class="nav nav-tabs" id="myTab">
                            <li class="active"><a tab-ind='1' data-target="#notification" data-toggle="tab">Notifications</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="notification">
                                <table id="myTable1" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Year</th>
											<th>Title</th>
                                            <!--
											<th>Sectors</th>
                                            <th>Sub Sectors</th>
											-->
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div id="ShowMsg1"></div>
                    <div id="reloadGrid"></div>
                </div>


                <!-- /.box-body -->
            </div>
        </div>
        <!-- /.content-wrapper -->
        <?php include('include/pageFooter.inc.php'); ?>

        <div class="control-sidebar-bg"></div>
    </div>
</body>

<script type="text/javascript">
    //$(document).delegate('#AddNew,.fa-edit,.fa-trash-o,.fa-eye,.fa-eye-slash,.fa-retweet', 'click', function() {

    // $("#AddNew").on("click", function() {
    //     var frmType=$(this).attr('cdata-frmT');

    //     console.log("addEmp.php?frmType=" + frmType  + "&per_id=<?php echo "$_SESSION[per_id]&EncHid=$_SESSION[EncTok]"; ?>");

    //     $('.modal-container').OpenPop({
    //         url:"addEmp.php?frmType=" + frmType  + "&per_id=<?php echo "$_SESSION[per_id]&EncHid=$_SESSION[EncTok]"; ?>",
    //     });
    // });


    $(document).delegate('#AddNew,.fa-edit,.fa-trash-o,.fa-retweet,.fa-desktop', 'click', function() {
        var frmType = $(this).attr('cdata-frmT');

        if ($.inArray(frmType, ['3', '4', '5', '6']) != '-1') {
            // if(1='-1'){

            var con = confirm('Do you really want to Proceed?');

            var eleCtrl = $(this);
            var not_id = ($(this).attr('data-comp_notice_id'));

            // if(1==2){          
            if (con) {
                // var lid=($(this).attr('data-link_temp_id')!=undefined)?$(this).attr('data-link_temp_id'):'';
                // console.log(frmType);

                $.base64.utf8encode = true;
                $.ajax({
                    type: "POST",
                    dataType: "text",
                    cache: false,
                    url: '<?php echo "del_not.php?per_id=$_SESSION[per_id]&EncHid=$_SESSION[EncTok]"; ?>',
                    data: {
                        <?php echo $GLOBALS['csrf']['token']; ?>,
                        'frmType': frmType,
                        'not_id': not_id
                    },
                    beforeSend: function() {
                        $.fn.ajaxLoading();
                    },
                    success: function(res) {
                        console.log(res);
                        try {
                            res = $.parseJSON($.base64.atob(res));
                            // res[0] = true;
                            console.log(res[0]);
                            if (res[0]) {
                                $('#ShowMsg1').ShowMsg({
                                    msg: 'Request Completed Successfully!',
                                    alertClass: 'alert-success'
                                });
                                $('#reloadGrid').trigger('click');
                                if (frmType == 3)
                                    eleCtrl.closest('tr').hide();
                            } else {
                                $('#ShowMsg1').ShowMsg({
                                    msg: 'Request not Completed Successfully!',
                                    alertClass: 'alert-danger'
                                });
                                $('#reloadGrid').trigger('click');
                                // if(frmType==3)
                                //     eleCtrl.closest('tr').hide(); 
                            }
                        } catch (err) {
                            // $('#ShowMsg1').ShowMsg({msg:"<strong>Error:</strong> Unexpected Response received, You may try again!",alertClass:'alert-warning'}); 
                            $('#ShowMsg1').ShowMsg({
                                msg: 'Request Completed Successfully!',
                                alertClass: 'alert-success'
                            });
                            // eleCtrl.closest('tr').hide(); 

                        }

                    },
                    error: function() {
                        $.fn.custom_alert({
                            msg: 'Something went wrong, Please try again!'
                        });
                    },
                    complete: function() {
                        $.fn.ajaxLoading({
                            show: false
                        });
                    },
                });
            }
        } else if (frmType == '9') {
            var lid = ($(this).attr('data-comp_notice_id') != undefined) ? $(this).attr('data-comp_notice_id') : '';
            $('.modal-container').OpenPop({
                url: "add_notification.php?frmType=" + frmType + "&per_id=<?php echo "$_SESSION[per_id]&EncHid=$_SESSION[EncTok]" ?>&not_id=" + lid,
            });
        } else {
            $('.modal-container').OpenPop({
                url: "add_notification.php?frmType=" + frmType + "&per_id=<?php echo "$_SESSION[per_id]&EncHid=$_SESSION[EncTok]"; ?>",
            });
        }
    });

    var mGridTable = '',
        mGridTable1 = '';
    $(function() {
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
                        "url": "AjaxFill/notificationList.php?<?php echo "EncHid=$_SESSION[EncTok]"; ?>",
                        "type": "POST",
                        "data": {
                            <?php echo $GLOBALS['csrf']['token']; ?>,
                            'tabID': tabID,
                            'lang_id': '<?php echo "$_REQUEST[lang_id]"; ?>',
                            'type_id': '<?php echo "$_REQUEST[type_id]"; ?>',
                            'per_id': '<?php echo "$_REQUEST[per_id]"; ?>',
                            'nmnh_type': '<?php echo "$_REQUEST[nmnh_type_id]"; ?>'
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





        //

        /*var mGridTable=$('#GridData').DataTable({                
            'aoColumnDefs': [{'aTargets': [2],'bSortable': false}],
            "processing": true,
            "serverSide": false,
            "ajax": "AjaxFill/getUsers.php?user_type_id=<?php echo "$_REQUEST[user_type_id]"; ?>&per_id=<?php echo "$_SESSION[per_id]&EncHid=$_SESSION[EncTok]"; ?>",                
        });*/

        $(document).delegate('#reloadGrid', 'click', function ReLoadGrid() {
            mGridTable.ajax.reload(null, false);
            mGridTable1.ajax.reload(null, false);
        });

        $(document).delegate('.Lpreview', 'click', function() {
            if ($('#type_id').val() == 3) {
                $('.modal-container').OpenPop({
                    url: "link_preview.php?link_temp_id=" + $(this).data('link_temp_id') + "&lang_id=<?php echo "$_REQUEST[lang_id]"; ?>&type_id=<?php echo "$_REQUEST[type_id]"; ?>&per_id=<?php echo "$_SESSION[per_id]&EncHid=$_SESSION[EncTok]"; ?>",
                });
            } else {
                window.open("link_preview.php?link_temp_id=" + $(this).data('link_temp_id') + "&lang_id=<?php echo "$_REQUEST[lang_id]"; ?>&type_id=<?php echo "$_REQUEST[type_id]"; ?>&per_id=<?php echo "$_SESSION[per_id]&EncHid=$_SESSION[EncTok]"; ?>", '_blank');
            }
        })
    })
</script>

<!-- CALLING TINYMCE RTF CONFIG FILE  --->
<!--<script src="rtf/js/tinymce/jquery-1.10.1.min.js"></script>-->
<!-- <script src="rtf/js/tinymce/tinymce.min.js"></script> -->
<!-- <script src="rtf/js/tinymce/plugins/table/plugin.dev.js"></script>
<script src="rtf/js/tinymce/plugins/paste/plugin.dev.js"></script>
<script src="rtf/js/tinymce/plugins/spellchecker/plugin.dev.js"></script>
 -->


<!-- CALLING TINYMCE RTF CONFIG FILE END --->
<script src='../tinymce/tinymce/tinymce.min.js'></script>
<script src="rtf/rtfConf.js"></script>