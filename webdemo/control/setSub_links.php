<?php 
    include '../appcode/globals.inc.php';
    include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');
    AjaxFilePrevent();

    if(isset($_REQUEST['frmType']) && $_REQUEST['frmType']==2) {
        // $rs=simplefetch("select * from web_link_temp where status='Active' and link_temp_id=$_REQUEST[link_temp_id]");

        $rssbqry = "SELECT * FROM web_link_temp WHERE status = 'Active' AND link_temp_id = ? ";
        $rs = simplefetch($rssbqry, "i", $_REQUEST['link_temp_id']);

        if($rs[1]>0){
            foreach($rs[1] as $row);                    
        }
    }
?>
            
<form name="formNC" id="formNC" method="post" autocomplete="off" role="form" action="<?php echo "setSub_links_action.php?per_id=$_SESSION[per_id]&amp;EncHid=$_SESSION[EncTok]";?>" enctype="multipart/form-data" >
    <input type="hidden" name="frmType" id="frmType" value="<?php echo $_REQUEST['frmType'] ?? '';?>" />
    <input type="hidden" name="lang_id" id="lang_id" value="<?php echo $_REQUEST['lang_id'];?>" />
    <input type="hidden" name="level" id="level" value="<?php echo $_REQUEST['level'] ?? '';?>" />
    <input type="hidden" name="lsid" id="lsid" value="<?php echo $_REQUEST['lsid'] ?? '';?>" />
    <input type="hidden" name="lid" id="lid" value="<?php echo $_REQUEST['lid'] ?? '';?>" />
    <input type="hidden" name="nmnh_type_id_sub" id="nmnh_type_id_sub" value="<?php echo $_REQUEST['nmnh_type'] ?? '';?>" />            
    
    <div class="Table-responsive">
        <table id="myTable2" class="table table-striped table-bordered">                            
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Link Name</th>
                    <th>Link Type</th>
                    <th>Language</th>
                    <th>Published On</th>
                    <th>Expiry On</th>                                                
                    <th class="text-center">SubLinks</th>                                    
                    <th class="text-center">Link Position</th>
                    <?php
                    if($_REQUEST['level']==0){
                    ?>
                    <th class="text-center">No of Characters to be Show</th>
                    <?php
                    }
                    ?>
                </tr>
            </thead>
        </table>        
    </div>
    <div id="ShowMsg"></div>
    <div class="modal-footer in-modal-body">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>    

<script type="text/javascript">
$(function(){
    
    $(document).delegate('input[type="checkbox"][name="sChk[]"]', 'click', function() {
        //console.log($(this).val())
        var chkLink=$(this);
        var lVal=$(this).val();
        if(chkLink.is(':checked')){
            //console.log('Checked')
            $('#pos_' + lVal + ',#chr_' + lVal).removeClass('disabled')
                            .attr({'disabled':false});
        }
        else{
            console.log('Not Checked')
            $('#pos_' + lVal + ',#chr_' + lVal).addClass('disabled')
                            .attr({'disabled':true});
        }
    })
    var nmnh_type_id_sub = $("#nmnh_type_id_sub").val();
    mGridTable=$('table#myTable2').DataTable( {

                "processing": true,
                "serverSide": false,
                "ajax": {
                    "url":"AjaxFill/get_sLinks.php?<?php echo "EncHid=$_SESSION[EncTok]";?>",
                    "type":"POST",
                    "data":{<?php echo $GLOBALS['csrf']['token'];?>,'lang_id':'<?php echo "$_REQUEST[lang_id]";?>','level':'<?php echo "$_REQUEST[level]";?>','lid':'<?php echo "$_REQUEST[lid]";?>','lsid':'<?php echo "$_REQUEST[lsid]";?>','per_id':'<?php echo "$_REQUEST[per_id]";?>','nmnh_type_id_sub':nmnh_type_id_sub}
                    },
                scrollY:        400,
                scrollCollapse: true,
                paging:         false,
                bFilter: false,
                bInfo : false,
                drawCallback: function (settings) {
                    //console.log(settings.fnRecordsDisplay())
                  if ( settings.fnRecordsDisplay() != 0 ) {
                     $('#SubBut').show();
                  }
                }
            } );
    
        
    function CallfrCk(){
        $('#formNC').formChecks({nonASCII:true,ajaxSubFunc:frmAction}).SetToFirstFocus();
    }
    CallfrCk();
    
    $(".modal-dialog").css("width", "1024px");
})

function frmAction(){
	$.base64.utf8encode = true;
    
    var formData = new FormData();
    //formData.append('name', $('#formNC').serialize());
    //formData.append('l_file', $('#l_file')[0].files[0]);
    
    var other_data = $('#formNC').serializeArray();
    $.each(other_data,function(key,input){
        formData.append(input.name,input.value);
    });
    
    // Capture all sublink inputs and selections from all pages
    var sData = mGridTable.$('input, select').serializeArray();
    $.each(sData,function(key,input){
        formData.append(input.name,input.value);
    });
    
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
            $.fn.custom_alert({msg:'Something went wrong, Please try again!'});                        
        },
        complete: function(){            
            $.fn.ajaxLoading({show:false});
        },
    });
}


</script>