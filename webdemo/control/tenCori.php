<?php 
    include '../appcode/globals.inc.php';
    include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');
    userAuthenticationPageLevel();
    userAuthenticationMainLevel();
    include_once('include/pageHeader.inc.php');
    include('include/top_user_info.inc.php'); 
?>
    
<h2 class="h5 content-header text-dark">Manage Corrigendum of 
    <span class="">
        <?php echo getNameQry("SELECT concat('<br><br>Tender Name: ',tt.tender_name,'<br><br>Tender Number: ',tt.t_num) from web_tender_final tf INNER JOIN web_tender_temp tt on tt.t_temp_id=tf.t_temp_id INNER JOIN web_tender_category tc on tc.t_cat_id=tt.t_cat_id WHERE tf.`status`='Active' and tt.status='Active' and tf.t_id=".$_REQUEST['t_id']." AND tc.t_cat_id=".$_REQUEST['t_cat_id']."");?>
    </span>
</h2>



            <div class="text-end mb-2">
                <button id="GoBack" class="btn btn-warning rounded-0 fw-bold px-3 py-1 add-btn"><i class="fas fa-plus-square me-1" aria-hidden="true"></i>Go Back</button>
            </div>
            <div class="text-end mb-2">
                <button id="AddNew" cdata-frmT='1' pub-t_id="<?php echo $_REQUEST['t_id'] ?? '';?>" pub-t_temp_id="<?php echo $_REQUEST['t_temp_id'];?>" class="btn btn-warning rounded-0 fw-bold px-3 py-1 add-btn"><i class="fas fa-plus-square me-1" aria-hidden="true"></i>Add New Corrigendum</button>
            </div>
           
        <ul class="nav nav-tabs border-bottom-0" id="myTab" role="tablist">
            <li class="nav-item"><button class="nav-link rounded-0 text-dark border border-bottom-0 active" data-bs-toggle="tab" data-bs-target="#pending" type="button">Pending Corrigendum</button></li>
            <li class="nav-item"><button class="nav-link rounded-0 text-dark border border-bottom-0" data-bs-toggle="tab" data-bs-target="#publish" type="button">Published Corrigendum</button></li>
            <li class="nav-item"><button class="nav-link rounded-0 text-dark border border-bottom-0" data-bs-toggle="tab" data-bs-target="#rejected" type="button">Rejected Corrigendum</button></li>
        </ul>
        <div class="tab-content border p-0">
            <div class="tab-pane fade show active" id="pending">
                <div class="table-responsive">
                    <table id="myTable1" class="table table-striped table-bordered w-100">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Corrigendum Heading</th>
                                <th>Created By/On</th>
                                <th>Approved By/On</th>
                                <th>Revive By/On</th>
                                <th>Revive Details</th>                                                
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
                            <th>Corrigendum Heading</th>
                            <th>Published On</th>
                            <th>Bid-Submission / Clossing Date</th>
                            <th>Tender Opening Date</th>
                            <th>Created By/On</th>
                            <th>Approved By/On</th>
                            <th>Expiry On</th>                                            
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
                            <th>Corrigendum Heading</th>
                            <th>Created By/On</th>
                            <th>Rejected By/On</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <div id="ShowMsg1"></div>
        <div id="reloadGrid"></div>
        

<script>
$(document).ready(function(){

    let mGridTable = null;
    let mGridTable1 = null;

    

    $(document).on('click', '#AddNew, .fa-edit, .fa-trash-alt, .fa-retweet, .fa-desktop', function(){

        const $el = $(this);
        const frmType = $el.attr('cdata-frmT');
       
        if(['3','4','5','6'].includes(frmType)){

            if(!confirm('Do you really want to proceed?')) return;

            $.base64.utf8encode = true;

            $.ajax({
                type: "POST",
                dataType: "text",
                cache: false,
                url: "<?= "tender_action.php?per_id=$_SESSION[per_id]&EncHid=$_SESSION[EncTok]"; ?>",
                data: {
                    <?= $GLOBALS['csrf']['token']; ?>,
                    frmType: frmType,
                    t_temp_id: $(this).data('t_temp_id'),
                    t_cat_id: "<?php echo $_REQUEST['t_cat_id'] ?? '';?>"
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
        else {

            var t_id=($(this).attr('pub-t_id')!=undefined)?$(this).attr('pub-t_id'):'';
                var ct_id=($(this).attr('tend-ct_id')!=undefined)?$(this).attr('tend-ct_id'):''; 
				var t_temp_id=($(this).attr('pub-t_temp_id')!=undefined)?$(this).attr('pub-t_temp_id'):'';
				
                
            $('.modal-container').OpenPop({
                url: "tenderCori.php?frmType=" + frmType +
                     "&ct_id=" + ct_id +
                     "&t_id=" + t_id +
                     "&t_temp_id=<?= $_REQUEST['t_temp_id'] ?? ''; ?>" +
                     "&t_t_id=" + t_temp_id +
                     "&t_cat_id=<?= $_REQUEST['t_cat_id'] ?? ''; ?>" +
                     "&per_id=<?= $_SESSION['per_id']; ?>&EncHid=<?= $_SESSION['EncTok']; ?>",
                     title: "Add/ Modify Tender Corrigendum"
            });
        }
    });

    $('#GoBack').click(function(){
        window.location=("manage_tender.php?preSub=1&t_id=<?php echo $_REQUEST['t_id'] ?? '';?>&t_temp_id=<?php echo $_REQUEST['t_temp_id'] ?? '';?>" +"&t_cat_id=<?php echo $_REQUEST['t_cat_id'] ?? '';?>" + "&per_id=<?php echo "$_SESSION[per_id]&EncHid=$_SESSION[EncTok]";?>");  
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
                    url: "AjaxFill/getTendersCori.php?<?= "EncHid=$_SESSION[EncTok]"; ?>",
                    type: "POST",
                    data: {
                        <?= $GLOBALS['csrf']['token']; ?>,
                        tabID: tabID,
                        t_cat_id: '<?= $_REQUEST['t_cat_id'] ?? ''; ?>',
                        t_id: '<?= $_REQUEST['t_id'] ?? ''; ?>',
                        per_id: '<?= $_REQUEST['per_id'] ?? ''; ?>'
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
