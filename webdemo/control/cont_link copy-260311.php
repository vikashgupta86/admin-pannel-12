<?php include '../appcode/globals.inc.php';
include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');
AjaxFilePrevent();
$_SESSION['uploader']='L45218';
$_SESSION['rtfUpload']='RTF1984';
?>

            
            <?php
            if(isset($_REQUEST['frmType']) && $_REQUEST['frmType']==2)
            {
                $rs=simplefetch("select * from web_link_temp where status='Active' and continuous_content=1 and main_link_temp_id=$_REQUEST[lid] and link_temp_id=$_REQUEST[link_temp_id]");
                if($rs[0]>0){
                    foreach($rs[1] as $row);                    
                }
            }
            
            $rs1=simplefetch("select lf.lid,wlt.link_name,l.lang from web_links_final lf INNER JOIN web_link_temp wlt on lf.link_temp_id=wlt.link_temp_id INNER JOIN web_lang l on l.lang_id=wlt.lang_id where lf.status='Active' and wlt.`status`='Active' and lf.lid=$_REQUEST[lid]");
            if($rs1[0]>0){
                foreach($rs1[1] as $row1);                    
            }
            ?>
            
            <form name="formNC" id="formNC" method="post" autocomplete="off" role="form" action="<?php echo "cont_link_action.php?per_id=$_SESSION[per_id]&amp;EncHid=$_SESSION[EncTok]";?>" enctype="multipart/form-data" >
            <input type="hidden" name="frmType" id="frmType" value="<?php echo $_REQUEST['frmType'];?>" />
            <input type="hidden" name="lang_id" id="lang_id" value="<?php echo $_REQUEST['lang_id'];?>" />
            <input type="hidden" name="link_temp_id" id="link_temp_id" value="<?php echo $_REQUEST['link_temp_id'];?>" />
            <input type="hidden" name="lid" id="lid" value="<?php echo $_REQUEST['lid'] ?? '';?>" />            
            <div class="modal-body">
                  <div class="box-body">
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
                                        
                  </div>
                  <!-- /.box-body -->
                  <!--<div class="box-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>-->
                
                <div class="clearfix"></div>
                <div id="ShowMsg"></div>
            </div>
            <div class="clearfix"></div>
            <div class="modal-footer">
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
    showRTF();
})

function frmAction(){
  //  $.base64.utf8encode = true;
    
    var formData = new FormData();
    var other_data = $('#formNC').serializeArray();
    $.each(other_data,function(key,input){  
        //managing the RTF content start    
        let DomStr = input.value.match(/<body[^>]*>[\s\S]*<\/body>/gi);
        DomStr = DomStr==null?input.value:$('<div />').text(DomStr).html();     
        //RTF END      
        formData.append(input.name,DomStr);
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