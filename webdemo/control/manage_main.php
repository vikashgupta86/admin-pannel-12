<?php 
    include '../appcode/globals.inc.php';
    include_once(BASE_PATH .'/control/include/include.inc.php');
    userAuthenticationPageLevel();
    userAuthenticationMainLevel();
    include_once('include/pageHeader.inc.php');
    include('include/top_user_info.inc.php'); 
?>
    
<h2 class="h5 content-header text-dark">Manage Main Links</h2>

<?php 
    $showType=false;
    include('include/chooseLang.inc.php');

    if(isset($_REQUEST['preSub']) && $_REQUEST['preSub']==1 && ($frmError ?? false) == false){
        $ShowGridFlage=true;
        ?>        
        <div class="box-body clearfix">                    
            <div class="panel panel-default">                        
                <?php /* <form name="frm1" id="frm1" action="<?php echo curPageName(false)."_action.php?per_id=".($_REQUEST['per_id'] ?? '')."&amp;EncHid=".($_SESSION['EncTok'] ?? '');?>" role="form" class="form-border clearfix" method="post">  */  ?>
                <h4 class="text-center">Manage Main Links</h4> 
                <input type="hidden" name="lang_id" id="lang_id" value="<?php echo $_REQUEST['lang_id'] ?? '';?>" />
                <input type="hidden" name="type_id" id="type_id" value="<?= $_REQUEST['type_id'] ?? '';?>" />
                <input type="hidden" name="dept_type_id" id="dept_type_id" value="<?php echo $_REQUEST['dept_type_id'] ?? ''; ?>" />
                    <table id="myTable1" class="table table-striped table-bordered" cellspacing="0" width="100%">                            
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Link Name</th>
                                <th>Link Type</th>
                                <th>Language</th>
                                <th>Published On</th>
                                <th>Expiry On</th>                                                
                                <th class="text-center">MainLinks</th>
                                <th class="text-center">Link Place</th>
                                <th class="text-center">Link Position</th>
                                <th class="text-center">Set as TopLink</th>
                                <th class="text-center">TopLink Position</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                    </table>
                    <?php /*
                    <div class="text-center" id="SubBut" style="display: none;">
                        <p class="text-muted small mt-2">Use individual <strong>Update</strong> buttons for specific rows, or <strong>Submit</strong> below for bulk changes.</p>
                        <button type="submit" class="btn btn-primary rounded-0 px-4 process-btn">Submit</button>
                    </div> */ ?>
                <?php /* </form> */ ?>
                <div id="ShowMsg1"></div>                    
                <div id="reloadGrid"></div>
            </div>
        </div>
        <?php
    }
?>                
<script type="text/javascript">
    $(document).delegate('.single-row-update', 'click', function() {
        var lid = $(this).data('id');
        var rowData = {};
        rowData['single_update'] = 1;
        rowData['lid'] = lid;
        rowData['lang_id'] = $('#lang_id').val();
        rowData['dept_type_id'] = $('#dept_type_id').val();
        rowData['mChk'] = $('#mChk_' + lid).is(':checked') ? [lid] : [];
        rowData['pos_id_' + lid] = $('#pos_id_' + lid).val();
        rowData['pos_' + lid] = $('#pos_' + lid).val();
        rowData['Tpos_' + lid] = $('#Tpos_' + lid).val();
        if($('#Tchk_' + lid).length > 0 && $('#Tchk_' + lid).is(':checked')) {
            rowData['Tchk_' + lid] = lid;
        }
        <?php if (isset($GLOBALS['csrf']['input-name'])) { ?>
            rowData['<?php echo $GLOBALS['csrf']['input-name']; ?>'] = '<?php echo csrf_get_tokens(); ?>';
        <?php } ?>
        $.ajax({
            type: "POST",
            url: "manage_main_action.php?per_id=<?= $_REQUEST['per_id'] ?? ''; ?>&EncHid=<?= $_SESSION['EncTok'] ?? ''; ?>",
            data: rowData,
            beforeSend: function() {
                $.fn.ajaxLoading();
            },
            success: function(data) {
                try {
                    data = $.parseJSON($.base64.atob(data));
                    if (data[0]) {
                        $('#ShowMsg1').ShowMsg({msg: 'Row Updated Successfully!', alertClass: 'alert-success'});
                        // mGridTable.ajax.reload(null, false); 
                    } else {
                        if (data[2] != undefined) {
                            $('#ShowMsg1').ShowMsg({msg: data[2][1], alertClass: data[2][2]});
                        } else {
                            $('#ShowMsg1').ShowMsg({msg: 'Update Failed!', alertClass: 'alert-danger'});
                        }
                    }
                } catch (err) {
                    $('#ShowMsg1').ShowMsg({msg: "Error processing response", alertClass: 'alert-warning'});
                }
            },
            error: function() {
                $.fn.ajaxLoading({show: false});
                alert('Communication error');
            },
            complete: function() {
                $.fn.ajaxLoading({show: false});
            }
        });
    });

    $(document).delegate('input[type="checkbox"][name="mChk[]"]', 'click', function() {
        //console.log($(this).val())
        var chkLink=$(this);
        var lVal=$(this).val();
        if(chkLink.is(':checked')){
            //console.log('Checked')
            $('#pos_id_'+ lVal +',#pos_'+ lVal  +',#Tchk_'+ lVal  +',#Tpos_'+ lVal).removeClass('disabled').attr({'disabled':false});
        }
        else{
            //console.log('Not Checked')
            $('#pos_id_'+ lVal +',#pos_'+ lVal  +',#Tchk_'+ lVal  +',#Tpos_'+ lVal).addClass('disabled').attr({'disabled':true});}
    })
    
    $(document).delegate('select[name^="pos_id_"]', 'change', function() {
        //console.log('LidL'+lid + '>>>LPos:'+lPos)
        lPos=$(this).val();
        //console.log($(this).val())
        //console.log($(this).attr('name').split('_')[2])
        lid=$(this).attr('name').split('_')[2];
        if(lPos==2){
            $('#Tchk_'+ lid  +',#Tpos_'+ lid).addClass('disabled').attr({'disabled':true});
        }
        else{
            $('#Tchk_'+ lid  +',#Tpos_'+ lid).removeClass('disabled').attr({'disabled':false});
        }
    })
            
    $(function(){
        mGridTable=$('table#myTable1').DataTable( {
            "processing": true,
            "serverSide": false,
            "ajax": {
                "url":"AjaxFill/get_mLinks.php?<?php echo "EncHid=".($_SESSION['EncTok'] ?? '');?>",
                "type":"POST",
                "data":{<?php echo $GLOBALS['csrf']['token'] ?? '';?>,'lang_id':'<?= $_REQUEST['lang_id'] ?? '';?>','per_id':'<?= $_REQUEST['per_id'] ?? '';?>','dept_type_id':'<?= $_REQUEST['dept_type_id'] ?? '';?>','type_id':'<?= $_REQUEST['type_id'] ?? '';?>'}
                },
            // scrollY:        400,
            // scrollX: true,
            scrollCollapse: true,
            paging:         true,
            bInfo : false,
            bFilter: true,
            drawCallback: function (settings) {
                //console.log(settings.fnRecordsDisplay())
                if ( settings.fnRecordsDisplay() != 0 ) {
                    $('#SubBut').show();
                }
            },
            responsive: false
        });

        $(document).delegate('#reloadGrid', 'click', function ReLoadGrid() {
            mGridTable.ajax.reload( null, false );
        });
        $('#frm1').formChecks({ajaxSubFunc:frmAction}).SetToFirstFocus();
    })
    
    function frmAction(){
        $.base64.utf8encode = true;
        if(validateMe()==false)
            return false;                
        var formData = new FormData();
        var other_data = $('#frm1').serializeArray();            
        $.each(other_data,function(key,input){
            if ($('#myTable1').find('[name="'+input.name+'"]').length == 0) {
                formData.append(input.name,input.value);
            }
        });
        

        var sData = mGridTable.$('input, select').serializeArray();
        $.each(sData,function(key,input){
            formData.append(input.name,input.value);
        });
        $.ajax({
            type     : "POST",
            dataType: "text",
            cache    : false,        
            enctype: 'multipart/form-data',
            url      : $('#frm1').attr('action'),
            data     : formData,//$('#formNC').serialize(),        
            processData: false,
            contentType: false,
            
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
                        if(data[1]!= undefined && data[1][0]==true){
                            FEror=data[1][1];                    
                            $.fn.ShowError(FEror);    
                        }
                        else if(data[2]!= undefined && data[2][0]==true){
                            MEror=data[2][1];
                            //console.log(MEror);
                            $('#ShowMsg1').ShowMsg({msg:MEror,alertClass:data[2][2]});
                        }
                        else{                                          
                            $('#ShowMsg1').ShowMsg({msg:'Request not Completed Successfully!',alertClass:'alert-danger'});                        
                        }
                    }
                }
                catch(err) {
                    $('#ShowMsg1').ShowMsg({msg:"<strong>Error:</strong> Unexpected Response received, You may try again!",alertClass:'alert-warning'});                                
                }
                                        
            },
            error:function(){
                $('#PopWind').modal('toggle');
                $.fn.custom_alert({msg:'Something went wrong, Please try again!'});                        
            },
            complete: function(){            
                $.fn.ajaxLoading({show:false});
            },
        });
    }
    
    function validateMe(){
        var errFlage=true;
        mGridTable.$('input[type="checkbox"][name="mChk[]"]').each(function(i,d){
            var l_val=$(this).val();
            if($(d).is(':checked')){
                var posIdVal = mGridTable.$('#pos_id_'+l_val).val();
                if(posIdVal == '-1' || posIdVal == undefined){
                    $.fn.custom_alert({msg:'Please select Valid Option for row ' + (i+1) + '!'});
                    errFlage=false;
                    mGridTable.$('#pos_id_'+l_val).focus();
                    return false;
                }
            }
        });
        return errFlage;
    }
</script>

<?php include('include/pageFooter.inc.php');?>