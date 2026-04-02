<?php 
    include '../appcode/globals.inc.php';
    include_once(BASE_PATH .'/control/include/include.inc.php');
    AjaxFilePrevent();
    if (isset($_POST['dept_type_id']) && $_POST['dept_type_id'] !== '') {
        $result = [0 => false];
        $queries = '';
        $lang_id = (int)($_POST['lang_id'] ?? 0);
        $dept_type_id = (int)($_POST['dept_type_id'] ?? 0);
        $mChk = $_POST['mChk'] ?? [];

        if (empty($lang_id)) {
            $result[2] = [true, 'Language selection is missing!', 'alert-danger'];
            echo frm_response($result);
            exit;
        }

        # single row update to avoid deleting other links
        if (!isset($_POST['single_update'])) {
            $mStr = !empty($mChk) ? implode(',', array_map('intval', $mChk)) : '0';
            $queries = "UPDATE web_links_structure ls INNER JOIN web_links_final lf ON ls.lid = lf.lid INNER JOIN web_link_temp wlt ON wlt.link_temp_id = lf.link_temp_id SET ls.status = 'Deleted' WHERE ls.status = 'Active' AND ls.link_level IS NULL AND wlt.lang_id = $lang_id AND wlt.content_type = $dept_type_id AND lf.lid NOT IN ($mStr)|$$|";
        }

        # Insert or Update selected links
        if (!empty($mChk)) {
            foreach ($mChk as $mid) {
                $mid = (int)$mid;
                $pos_id = (int)($_POST['pos_id_'.$mid] ?? -1);
                $pos = (int)($_POST['pos_'.$mid] ?? 0);
                $uplink = isset($_POST['Tchk_'.$mid]) ? 1 : 0;
                $up_position = (int)($_POST['Tpos_'.$mid] ?? 0);
            
                $chkExistRs = simplefetch("SELECT ls_id FROM web_links_structure WHERE lid=$mid AND link_level IS NULL LIMIT 1");
                $chkExist = (isset($chkExistRs[1][0]['ls_id'])) ? $chkExistRs[1][0]['ls_id'] : '';
                
                if (empty($chkExist)) {
                    $queries .= "INSERT INTO web_links_structure (lid, pos_id, position, uplink, up_position, entry_by, entry_date, ip_addr, status) VALUES ($mid, $pos_id, $pos, $uplink, $up_position, '{$_SESSION['userid']}', NOW(), '{$_SERVER['REMOTE_ADDR']}', 'Active')|$$|";
                } else {
                    $queries .= "UPDATE web_links_structure SET pos_id = $pos_id, position = $pos, uplink = $uplink, up_position = $up_position, entry_by = '{$_SESSION['userid']}', entry_date = NOW(), ip_addr = '{$_SERVER['REMOTE_ADDR']}', status = 'Active' WHERE ls_id = $chkExist|$$|";
                }
            }
        } else if (isset($_POST['single_update'])) {
            $mid = (int)$_POST['lid'];
            $queries .= "UPDATE web_links_structure SET status = 'Deleted' WHERE lid=$mid AND link_level IS NULL AND status='Active'|$$|";
        }
    
        $success = false;
        if (!empty($queries)) {
            $queries = str_ireplace(["''", "'NULL'"], "NULL", $queries);
            $success = batch_execute($queries);
            if ($success) {
                $result[0] = true;
            }
        } else {
            $result[0] = true; 
        }
        
        echo frm_response($result);
        exit;
    }

    $_SESSION['uploader']='L45218';
    $_SESSION['rtfUpload']='RTF1984';
?>

            
<?php
    $row = [];
    if(isset($_REQUEST['frmType']) && $_REQUEST['frmType'] == 2)
    {
        $lid = (int)($_REQUEST['lid'] ?? 0);
        $link_temp_id = (int)($_REQUEST['link_temp_id'] ?? 0);
        $rs = simplefetch("select * from web_link_temp where status='Active' and continuous_content=1 and main_link_temp_id=$lid and link_temp_id=$link_temp_id");
        if(isset($rs[0]) && $rs[0] > 0){
            foreach($rs[1] as $row);                    
        }
    }

    $req_LID = (int)($_REQUEST['lid'] ?? 0);
    $rs1 = simplefetch("select lf.lid,wlt.link_name,l.lang from web_links_final lf INNER JOIN web_link_temp wlt on lf.link_temp_id=wlt.link_temp_id INNER JOIN web_lang l on l.lang_id=wlt.lang_id where lf.status='Active' and wlt.`status`='Active' and lf.lid= $req_LID");
    if(isset($rs1[0]) && $rs1[0] > 0){
        foreach($rs1[1] as $row1);                    
    }
?>
            
<form name="formNC" id="formNC" method="post" autocomplete="off" role="form" action="<?php echo "cont_link_action.php?per_id=$_SESSION[per_id]&amp;EncHid=$_SESSION[EncTok]";?>" enctype="multipart/form-data" >
    <input type="hidden" name="frmType" id="frmType" value="<?php echo $_REQUEST['frmType'];?>" />
    <input type="hidden" name="lang_id" id="lang_id" value="<?php echo $_REQUEST['lang_id'];?>" />
    <input type="hidden" name="link_temp_id" id="link_temp_id" value="<?php echo $_REQUEST['link_temp_id'];?>" />
    <input type="hidden" name="lid" id="lid" value="<?php echo $_REQUEST['lid'] ?? '';?>" />            

    <div class="form-group col-md-8">
        <label for="l_name">Link Name:</label>
        <label class="normal "><?php echo html_entity_decode($row1['link_name']);?></label>                      
    </div>
    <div class="form-group col-md-4">
        <label for="l_alias">Language:</label>
        <label class="normal "><?php echo $row1['lang'];?></label>
    </div>
    <div class="form-group">
        <label for="textarea2">Content Details:</label>
        <textarea class="form-control" name="textarea2" id="textarea2" placeholder="Keywords of the Link" data-validate="textarea2|textarea|y|1|50000|rtf|Please enter Valid data!"><?php rtfPathManage($row['details'],false);echo $row['details'];?></textarea>
    </div>
    <div id="ShowMsg"></div>
                    
    <div class="modal-footer in-modal-body">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>    
          

<script type="text/javascript">
$(function(){        
    function CallfrCk(){
        $('#formNC').formChecks({nonASCII:true,ajaxSubFunc:frmAction}).SetToFirstFocus();
    }
    CallfrCk();
    $(".modal-dialog").css("width", "700px");
    
    setTimeout(function() {
        if (typeof showRTF === 'function') {
            showRTF('#textarea2');
        }
    }, 200);
})

function frmAction(){
    if (typeof tinymce !== 'undefined') {
        tinymce.triggerSave();
    }
    
    var formData = new FormData($('#formNC')[0]);
    
    $.ajax({
        type     : "POST",
        dataType: "text",
        cache    : false,        
        enctype: 'multipart/form-data',
        url      : $('#formNC').attr('action'),
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
                    ($('#frmType').val()==1)?$('#formNC')[0].reset():'';                    
                    $('#ShowMsg').ShowMsg({msg:'Request Completed Successfully!',colwidth:'col-md-8',coloffset:'col-md-offset-2',alertClass:'alert-success'});
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
                        $('#ShowMsg').ShowMsg({msg:MEror,alertClass:data[2][2],colwidth:'col-md-8',coloffset:'col-md-offset-2'});
                    }
                    else{                                          
                        $('#ShowMsg').ShowMsg({msg:'Request not Completed Successfully!',colwidth:'col-md-8',coloffset:'col-md-offset-2',alertClass:'alert-danger'});                        
                    }
                }
            }
            catch(err) {
                $('#ShowMsg').ShowMsg({msg:"<strong>Error:</strong> Unexpected Response received, You may try again!",colwidth:'col-md-8',coloffset:'col-md-offset-2',alertClass:'alert-warning'});                                
            }
                                   
        },
        error:function(){
            $('#PopWind').modal('toggle');
            //$.fn.custom_alert({msg:'Something went wrong, Please try again!'});            
            
            $('#ShowMsg').ShowMsg({msg:"<strong>Error:</strong> Something went wrong, Please try again!",colwidth:'col-md-8',coloffset:'col-md-offset-2',alertClass:'alert-warning'});        
        },
        complete: function(){            
            $.fn.ajaxLoading({show:false});
        },
    });
}
</script>