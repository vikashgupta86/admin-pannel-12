<?php 
    include '../appcode/globals.inc.php';
    include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');
    userAuthenticationPageLevel();
    userAuthenticationMainLevel();
    include_once('include/pageHeader.inc.php');
    include('include/top_user_info.inc.php'); 
?>
    
<h3 class="box-title">Failed Url List</h3>



            <form name="frm" id="frm" action="<?php echo curPageName()."?EncHid=$_SESSION[EncTok]"?>" role="form" class="form-border clearfix col-sm-6 col-sm-offset-3" method="post">
                <input type="hidden" name="preSub" id="preSub" value="1" />     
                <input type="hidden" name="per_id" id="per_id" value="<?php echo $_REQUEST['per_id']?>" />                                         
                                                        
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="f_date">From Date:</label>
                        <div class="input-group">
                        <input type="date" class="form-control CallDate" name="f_date" id="f_date" placeholder="DD/MM/YYYY" value="<?php echo ($_REQUEST['f_date'] ?? '');?>" data-validate="link_nrevDate|text|Y|10|10|dt|Please enter/ select Valid Date!"/>
                        <span class="input-group-addon CopyIcon CallDate1" data-for='f_date'><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                    </div>
                    
                    <div class="form-group col-md-6">
                        <label for="t_date">To Date:</label>
                        <div class="input-group">
                        <input type="date" class="form-control CallDate" name="t_date" id="t_date" placeholder="DD/MM/YYYY" value="<?php echo ($_REQUEST['t_date'] ?? '');?>" data-validate="link_nrevDate|text|Y|10|10|dt|Please enter/ select Valid Date!"/>
                        <span class="input-group-addon CopyIcon CallDate1" data-for='t_date'><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                    </div>
                </div>
                
                <div class="col-sm-8 col-sm-offset-4">
                    <button type="submit" class="btn btn-primary">Proceed</button>
                    </div>
            </form>

        <?php
            if(isset($_REQUEST['preSub']) && $_REQUEST['preSub']==1 && ($frmError ?? '') ==false){
                $ShowGridFlage=true;
        ?>
           
        <ul class="nav nav-tabs border-bottom-0" id="myTab" role="tablist">
            <li class="nav-item"><button class="nav-link rounded-0 text-dark border border-bottom-0 active" data-bs-toggle="tab" data-bs-target="#pending" type="button">Url List</button></li>
          
        </ul>
        <div class="tab-content border p-0">
            <div class="tab-pane fade show active" id="pending">
                <div class="table-responsive">
                    <table id="myTable1" class="table table-striped table-bordered w-100">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Ip Address</th>
                                <th>Date Time</th>
                                <th>URL Used</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <div id="ShowMsg1"></div>
        <div id="reloadGrid"></div>
    <?php } ?>    
        

<script>

    $(document).delegate('.fa-fax','click',function(){
        var frmType=$(this).attr('cdata-frmT');
        var t_id=($(this).attr('pub-t_id')!=undefined)?$(this).attr('pub-t_id'):'';
        window.location=("tenCori.php?frmType=" + frmType + "&t_id="+t_id+"&t_temp_id=" + $(this).data('t_temp_id') +"&t_cat_id=<?php echo $_REQUEST['t_cat_id'] ?? '';?>" + "&per_id=<?php echo "$_SESSION[per_id]&EncHid=$_SESSION[EncTok]";?>");
    });

$(document).ready(function(){

    let mGridTable = null;
    let mGridTable1 = null;

    $(document).on('click', '#AddNew,.fa-edit,.fa-trash-o,.fa-eye,.fa-eye-slash,.fa-retweet', function(){

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
                    t_temp_id: $(this).data('t_temp_id')
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
        else 
        {
            var t_id=($(this).attr('pub-t_id')!=undefined)?$(this).attr('pub-t_id'):'';
          
            $('.modal-container').OpenPop({
                url: "tender.php?frmType=" + frmType +
                     "&t_id=" + t_id +
                     "&t_temp_id=" +$(this).data('t_temp_id') +
                     "&t_cat_id=<?= $_REQUEST['t_cat_id'] ?? ''; ?>" +
                     "&per_id=<?= $_SESSION['per_id']; ?>&EncHid=<?= $_SESSION['EncTok']; ?>",
                     title: "Add/ Modify Details"
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
                    url: "AjaxFill/getFailedUrlList.php?<?= "EncHid=$_SESSION[EncTok]"; ?>",
                    type: "POST",
                    data: {
                        <?= $GLOBALS['csrf']['token']; ?>,
                        tabID: tabID,
                        f_date: '<?= $_REQUEST['f_date'] ?? ''; ?>',
                        t_date: '<?= $_REQUEST['t_date'] ?? ''; ?>',
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

});
</script>




<?php include('include/pageFooter.inc.php'); ?>
