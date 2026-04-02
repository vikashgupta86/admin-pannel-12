<?php 
include '../appcode/globals.inc.php';
include_once(dirname_r(__FILE__, 1) . '/include/include.inc.php');
$obj->userAuthenticationPageLevel();
$obj->userAuthenticationMainLevel();
include_once('include/pageHeader.inc.php');
?>

<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['type1']) && $_POST['frmType'] == 1) {

        $sector_id = $_POST['sector_id'];
        $subsector_name = $_POST['subsector_name'];

        $FielArr = array(
            'sector_id' => $sector_id,
            'subsector_name' => $subsector_name,
        );

        $Fields = implode(',', array_keys($FielArr));
        $Values = implode("|$$|", $FielArr);
        $suc = $obj->insert("neca_subsectors", $Fields, $Values);
        if ($suc) {
            $subsec_id = $suc[0];

            echo "<script>alert('SubSector Created Successfully');</script>";
        }
        
    } else if (isset($_POST['type1']) && $_POST['frmType'] == 9) {

        $rs1 = $obj->simplefetch("select * from neca_subsectors where subsector_id='" . $_POST['subsec_id'] . "' and status='Active'",1);
        if ($rs1[0] > 0) {
            foreach ($rs1[1] as $row);

            $sector_id = $_POST['sector_id'];
            $subsector_name = $_POST['subsector_name'];

            $FielArr = array(
                'sector_id' => $sector_id,
                'subsector_name' => $subsector_name,
            );

            $Fields = implode('|$$|', array_keys($FielArr));
            $Values = implode("|$$|", $FielArr);

            $suc = $obj->update("neca_subsectors", $Fields, $Values, "subsector_id='" . $_POST['subsec_id'] . "'",1);
            if ($suc) {
                echo "<script>alert('Sub Sector Updated Successfully');</script>";
            }

        }
        else{
            echo "<script>alert('Something Went Wrong');</script>";
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
                    <h3 class="box-title">Manage Sub Sectors</h3>
                </div>



                <div class="box-body clearfix">
                    <div class="text-right" style="margin-bottom: 2px;"><button id="AddNew" cdata-frmT='1' class="btn btn-warning">Add New Sub Sectors</button></div>
                    <div class="panel panel-default">
                        <ul class="nav nav-tabs" id="myTab">
                            <li class="active"><a tab-ind='1' data-target="#notification" data-toggle="tab">Sub Sectors</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="notification">
                                <table id="myTable1" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Sector Name</th>
                                            <th>Sub Sector Name</th>
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
            var subsec_id = ($(this).attr('data-subsector_id'));

            // if(1==2){          
            if (con) {
                // var lid=($(this).attr('data-link_temp_id')!=undefined)?$(this).attr('data-link_temp_id'):'';
                // console.log(frmType);

                $.base64.utf8encode = true;
                $.ajax({
                    type: "POST",
                    dataType: "text",
                    cache: false,
                    url: '<?php echo "del_subsector.php?per_id=$_SESSION[per_id]&EncHid=$_SESSION[EncTok]"; ?>',
                    data: {
                        <?php echo $GLOBALS['csrf']['token']; ?>,
                        'frmType': frmType,
                        'subsec_id': subsec_id
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
            var lid = ($(this).attr('data-subsector_id') != undefined) ? $(this).attr('data-subsector_id') : '';
            $('.modal-container').OpenPop({
                url: "add_sub_sector.php?frmType=" + frmType + "&per_id=<?php echo "$_SESSION[per_id]&EncHid=$_SESSION[EncTok]" ?>&subsec_id=" + lid,
            });
        } else {
            $('.modal-container').OpenPop({
                url: "add_sub_sector.php?frmType=" + frmType + "&per_id=<?php echo "$_SESSION[per_id]&EncHid=$_SESSION[EncTok]"; ?>",
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
                        "url": "AjaxFill/subsectorsList.php?<?php echo "EncHid=$_SESSION[EncTok]"; ?>",
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