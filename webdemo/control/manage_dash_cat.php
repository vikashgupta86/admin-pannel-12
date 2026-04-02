<?php 
    include '../appcode/globals.inc.php';
    include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');
    userAuthenticationPageLevel();
    userAuthenticationMainLevel();
    include_once('include/pageHeader.inc.php');
    include('include/top_user_info.inc.php'); 
?>
    
<h2 class="h5 content-header text-dark">Manage Dashboard Category</h2>

<div class="text-end mb-3">
    <button id="AddNew" cdata-frmT="1" class="btn btn-warning rounded-0 fw-bold px-3 py-1 add-btn"><i class="fas fa-plus-square me-1" aria-hidden="true"></i>Add New Link</button>
</div>  


    <table id="myTable1" class="table table-striped table-bordered w-100">
        <thead>
            <tr>
                <th>S.No</th>
                <th>Category Name</th>
                <th>Category Name (Hindi)</th>
                <th>Created By/On</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
    </table>

<div id="ShowMsg1"></div>                    
<div id="reloadGrid"></div>

          
<script type="text/javascript">
    $(document).on('click','#AddNew,.fa-edit,.fa-trash-o,.fa-eye,.fa-eye-slash,.fa-retweet', function () {
    var eleCtrl = $(this);
    var frmType = eleCtrl.attr('cdata-frmT');
    if($.inArray(frmType,['3','4','5','6']) !== -1){
        if(confirm('Do you really want to Proceed?')){
            $.base64.utf8encode = true;
            $.ajax({
                type: "POST",
                dataType: "text",
                cache: false,
                url: "dash_cat_action.php?per_id=<?php echo $_SESSION['per_id']; ?>&EncHid=<?php echo $_SESSION['EncTok']; ?>",
                data: {
                    <?php echo $GLOBALS['csrf']['token']; ?>,
                    frmType: frmType,
                    prog_id: eleCtrl.data('prog_id')
                },
                beforeSend: function(){
                    $.fn.ajaxLoading();
                },
                success: function(data){
                    try {
                        data = $.parseJSON($.base64.atob(data));
                        if(data[0] === true){
                            $('#ShowMsg1').ShowMsg({
                                msg:'Request Completed Successfully!',
                                alertClass:'alert-success'
                            });
                            $('#reloadGrid').trigger('click');
                            if(frmType == 3){
                                eleCtrl.closest('tr').hide();
                            }
                        }else{
                            $('#ShowMsg1').ShowMsg({
                                msg:'Request not Completed Successfully!',
                                alertClass:'alert-danger'
                            });
                        }
                    }catch(err){
                        $('#ShowMsg1').ShowMsg({
                            msg:"<strong>Error:</strong> Unexpected Response received, Try again!",
                            alertClass:'alert-warning'
                        });
                    }
                },
                error:function(){
                    $.fn.custom_alert({msg:'Something went wrong, Please try again!'});
                },
                complete:function(){
                    $.fn.ajaxLoading({show:false});
                }
            });
        }
    } else {
        $('.modal-container').OpenPop({
            url:"dash_cat.php?frmType="+frmType+
                "&prog_id="+eleCtrl.data('prog_id')+
                "&lang_id=<?php echo $_REQUEST['lang_id'] ?? ''; ?>"+
                "&type_id=<?php echo $_REQUEST['type_id'] ?? ''; ?>"+
                "&per_id=<?php echo $_SESSION['per_id']; ?>&EncHid=<?php echo $_SESSION['EncTok']; ?>",
            title:"Add / Modify Details"
        });
    }
});


var mGridTable = '';
$(function(){
    var tabs = [1,2,3];
    tabs.forEach(function(tabID){
        var table = $('#myTable'+tabID).DataTable({
            processing: true,
            serverSide: false,
            ajax:{
                url:"AjaxFill/getDashCat.php?EncHid=<?php echo $_SESSION['EncTok']; ?>",
                type:"POST",
                data:{
                    <?php echo $GLOBALS['csrf']['token']; ?>,
                    tabID: tabID,
                    per_id: "<?php echo $_REQUEST['per_id'] ?? ''; ?>"
                }
            },
            scrollY: 400,
            scrollCollapse: true,
            paging: false
        });
        if(tabID === 1){
            mGridTable = table;
        }
    });
});

$(document).on('click','#reloadGrid',function(){
    if(mGridTable){
        mGridTable.ajax.reload(null,false);
    }
});
</script>
<?php include('include/pageFooter.inc.php');?>