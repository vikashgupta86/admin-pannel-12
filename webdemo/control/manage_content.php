<?php 
    include '../appcode/globals.inc.php';
    include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');
    userAuthenticationPageLevel();
    userAuthenticationMainLevel();
    include_once('include/pageHeader.inc.php');
    include('include/top_user_info.inc.php'); 
?>
    
<h2 class="h5 content-header text-dark">Manage Contents</h2>

<?php include('include/chooseLang.inc.php'); ?>

<?php
    if(isset($_REQUEST['preSub']) && $_REQUEST['preSub']==1 && ($frmError ?? '')==false){
        $ShowGridFlage=true;    
        if(empty($_SESSION['department'])){ 
            ?>
            <div class="text-end mb-2">
                <button id="AddNew" cdata-frmT="1" class="btn btn-warning rounded-0 fw-bold px-3 py-1 add-btn"><i class="fas fa-plus-square me-1" aria-hidden="true"></i>Add New Link</button>
            </div>
            <?php 
        } 
        ?>
        <ul class="nav nav-tabs border-bottom-0" id="myTab" role="tablist">
            <li class="nav-item"><button class="nav-link rounded-0 text-dark border border-bottom-0 active" data-bs-toggle="tab" data-bs-target="#pending" type="button">Pending Links</button></li>
            <li class="nav-item"><button class="nav-link rounded-0 text-dark border border-bottom-0" data-bs-toggle="tab" data-bs-target="#publish" type="button">Published Links</button></li>
            <li class="nav-item"><button class="nav-link rounded-0 text-dark border border-bottom-0" data-bs-toggle="tab" data-bs-target="#rejected" type="button">Rejected Links</button></li>
        </ul>
        <div class="tab-content border p-0">
            <div class="tab-pane fade show active" id="pending">
                <div class="table-responsive">
                    <table id="myTable1" class="table table-striped table-bordered w-100">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Link Name (Alias)</th>
                                <th>Created By/On</th>
                                <th>Approved By/On</th>
                                <th>Revive By/On</th>
                                <th>Revive Details</th>
                                <th>Preview</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>

            <div class="tab-pane fade" id="publish">
                <div class="table-responsive">
                    <table id="myTable2" class="table table-striped table-bordered w-100">
                        <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Link Name (Alias)</th>
                            <th>Created By/On</th>
                            <th>Approved By/On</th>
                            <th>Published By/On</th>
                            <th>Expiry Date</th>
                            <th>Preview</th>
                            <th class="text-center">Action</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" id="rejected">
                <div class="table-responsive">
                    <table id="myTable3" class="table table-striped table-bordered w-100">
                        <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Link Name (Alias)</th>
                            <th>Created By/On</th>
                            <th>Rejected By/On</th>
                            <th>Preview</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <div id="ShowMsg1"></div>
        <div id="reloadGrid"></div>
        <?php 
    } 
?>


<script>
$(document).ready(function(){

    let mGridTable = null;
    let mGridTable1 = null;

    $(document).on('click', '#AddNew, .fa-edit, .fa-trash-alt, .fa-retweet, .fa-desktop', function(){

        const $el = $(this);
        const frmType = $el.attr('cdata-frmT');
        const lid = $el.attr('pub-lid') ?? '';
        const linkTempId = $el.data('link_temp_id') ?? '';

        if(['3','4','5','6'].includes(frmType)){

            if(!confirm('Do you really want to proceed?')) return;

            $.base64.utf8encode = true;

            $.ajax({
                type: "POST",
                dataType: "text",
                cache: false,
                url: "<?= "links_action.php?per_id=$_SESSION[per_id]&EncHid=$_SESSION[EncTok]"; ?>&lid=" + lid,
                data: {
                    <?= $GLOBALS['csrf']['token']; ?>,
                    frmType: frmType,
                    link_temp_id: linkTempId
                },
                beforeSend: function(){
                    $.fn.ajaxLoading();
                },
                success: function(response){
                    try{
                        const parsed = $.parseJSON($.base64.atob(response));

                        if(parsed[0]){
                            $('#ShowMsg1').ShowMsg({
                                msg:'Request Completed Successfully!',
                                alertClass:'alert-success'
                            });

                            $('#reloadGrid').trigger('click');

                            if(frmType === '3'){
                                $el.closest('tr').remove();
                            }
                        }else{
                            $('#ShowMsg1').ShowMsg({
                                msg:'Request not Completed Successfully!',
                                alertClass:'alert-danger'
                            });
                        }

                    }catch(err){
                        $('#ShowMsg1').ShowMsg({
                            msg:"<strong>Error:</strong> Unexpected response received.",
                            alertClass:'alert-warning'
                        });
                    }
                },
                error:function(){
                    $.fn.custom_alert({
                        msg:'Something went wrong. Please try again.'
                    });
                },
                complete:function(){
                    $.fn.ajaxLoading({show:false});
                }
            });

        } 
        else if(frmType === '9'){

            $('.modal-container').OpenPop({
                url: "pub_link.php?frmType=" + frmType +
                     "&lid=" + lid +
                     "&link_temp_id=" + linkTempId +
                     "&lang_id=<?= $_REQUEST['lang_id'] ?? ''; ?>" +
                     "&type_id=<?= $_REQUEST['type_id'] ?? ''; ?>" +
                     "&per_id=<?= $_SESSION['per_id']; ?>&EncHid=<?= $_SESSION['EncTok']; ?>",
                     title: "Publish Link"
            });

        } 
        else {

            $('.modal-container').OpenPop({
                url: "links.php?frmType=" + frmType +
                     "&lid=" + lid +
                     "&link_temp_id=" + linkTempId +
                     "&lang_id=<?= $_REQUEST['lang_id'] ?? ''; ?>" +
                     "&nmnh_type_id=<?= $_REQUEST['nmnh_type_id'] ?? ''; ?>" +
                     "&type_id=<?= $_REQUEST['type_id'] ?? ''; ?>" +
                     "&per_id=<?= $_SESSION['per_id']; ?>&EncHid=<?= $_SESSION['EncTok']; ?>",
                     title: "Add/ Modify Link Details"
            });
        }
    });



    if($('#myTab').length)
    {

        document.getElementById('myTab')
            .addEventListener('shown.bs.tab', function () {
                $.fn.dataTable
                    .tables({visible:true, api:true})
                    .columns.adjust();
            });
 
        $('#myTab button').each(function(index){

            const tabID = index + 1;

            const table = $('#myTable'+tabID).DataTable({
                processing: true,
                serverSide: false,
                ajax: {
                    url: "AjaxFill/getLinks.php?<?= "EncHid=$_SESSION[EncTok]"; ?>",
                    type: "POST",
                    data: {
                        <?= $GLOBALS['csrf']['token']; ?>,
                        tabID: tabID,
                        lang_id: '<?= $_REQUEST['lang_id'] ?? ''; ?>',
                        type_id: '<?= $_REQUEST['type_id'] ?? ''; ?>',
                        per_id: '<?= $_REQUEST['per_id'] ?? ''; ?>',
                        nmnh_type: '<?= $_REQUEST['nmnh_type_id'] ?? ''; ?>'
                    }
                },
                scrollY: 400,
                scrollCollapse: true,
                paging: false,
                drawCallback: function(){
                    document.querySelectorAll('[data-bs-toggle="tooltip"]')
                        .forEach(el => new bootstrap.Tooltip(el));
                }
            });

            if(tabID === 1) mGridTable = table;
            if(tabID === 2) mGridTable1 = table;
        });
    }



    $(document).on('click','#reloadGrid',function(){

        if(mGridTable) mGridTable.ajax.reload(null,false);
        if(mGridTable1) mGridTable1.ajax.reload(null,false);

    });


    $(document).on('click','.Lpreview',function(){

        const linkTempId = $(this).data('link_temp_id');

        const url = "link_preview.php?link_temp_id=" + linkTempId +
                    "&lang_id=<?= $_REQUEST['lang_id'] ?? ''; ?>" +
                    "&type_id=<?= $_REQUEST['type_id'] ?? ''; ?>" +
                    "&per_id=<?= $_SESSION['per_id']; ?>&EncHid=<?= $_SESSION['EncTok']; ?>";

        if($('#type_id').val() == 3){
            $('.modal-container').OpenPop({ url: url, title: "Link Preview" });
        }else{
            window.open(url,'_blank');
        }
    });

});
</script>




<?php include('include/pageFooter.inc.php'); ?>
