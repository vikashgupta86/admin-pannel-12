<?php include '../appcode/globals.inc.php';
include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');
AjaxFilePrevent();
$_SESSION['uploader']='L45218';
$_SESSION['rtfUpload']='RTF1984';
$_SESSION['hdUpload']='HD87168';
?>

<?php

            if(isset($_REQUEST['frmType']) && $_REQUEST['frmType']==2){

                $rs=simplefetch("select *,date_format(pub_date,'%d/%m/%Y')as pub_date,date_format(evef_date,'%d/%m/%Y')as evef_date,date_format(evet_date,'%d/%m/%Y')as evet_date from web_link_temp where status='Active' and link_temp_id=$_REQUEST[link_temp_id]");
                if($rs[0]>0){
                    foreach($rs[1] as $row);                    
                }
            }
            ?>
            
            <form name="formNC" id="formNC" method="post" autocomplete="off" role="form" action="<?php echo "links_action.php?per_id=$_SESSION[per_id]&amp;EncHid=$_SESSION[EncTok]";?>" enctype="multipart/form-data" >
            <input type="hidden" name="frmType" id="frmType" value="<?php echo $_REQUEST['frmType'];?>" />
            <input type="hidden" name="lang_id" id="lang_id" value="<?php echo $_REQUEST['lang_id'];?>" />
            <input type="hidden" name="link_temp_id" id="link_temp_id" value="<?php echo $_REQUEST['link_temp_id'];?>" />
            <input type="hidden" name="lid" id="lid" value="<?php echo $_REQUEST['lid'];?>" />            
            <div class="mb-3">
                      <label for="type_id" class="form-label">Link Type</label>
                      <select name="type_id" id="type_id" class="form-control form-select c_type" data-validate="type_id|text|y|1|10|num|dontselect=-1|Please enter Valid option!">
                        <option value="-1">--- Select ---</option>
                        <?php
                        $rs1=fetchtable("web_link_type","status='Active' order by type");
                        if($rs1[0]>0){
                            foreach($rs1[1] as $row1){
                                if($_REQUEST['type_id']==$row1['type_id'])
                                    echo "<option value='$row1[type_id]' selected=''>$row1[type]</option>";
                                else
                                    echo "<option value='$row1[type_id]'>$row1[type]</option>";
                            }
                        }
                        ?>
                      </select>
                    </div>
   
					<?php
                    if($_SESSION['user_type'] =='20'){

                         ?>
                        <input type="hidden" name="nmnh_type_id_si" value="<?php echo $_SESSION['musume_type'];?>">
                        

                         <?php
                    }
                    else{
                    ?>

                      <div class="mb-3 d-none">
                      <label for="nmnh_type_id_si" class="form-label">Site Type <span class="text-danger">*</span></label>
                      <select name="nmnh_type_id_si" id="nmnh_type_id_si" class="form-control" data-validate="nmnh_type_id_si|text|y|1|10|num|dontselect=-1|Please enter Valid option!">
                        <option value="-1">--- Select ---</option>
                        <?php
                        $rs1=fetchtable("nmnh_type","status='Active'",1);
                        if($rs1[0]>0){
                            foreach($rs1[1] as $row1){
                                if($_REQUEST['nmnh_type_id']==$row1['id'] || ($row['nmnh_type'] ?? '') ==$row1['id'])
                                    echo "<option value='$row1[id]' selected=''>$row1[nmnh_type]</option>";
                                else
                                    echo "<option value='$row1[id]'>$row1[nmnh_type]</option>";
                            }
                        }
                        ?>
                      </select>
                    </div>
              <?php }  ?>
			  
                    <div class="mb-3">
                      <label for="l_name" class="form-label">Link Name <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" name="l_name" id="l_name" placeholder="Link Name" value="<?php echo ($row['link_name'] ?? '');?>" data-validate="l_name|text|y|1|500|alnum_spcA|Please enter Valid Link Name!"/>
                    </div>
                    
                    <div class="mb-3">
                      <label for="l_alias" class="form-label">Link Alias <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" name="l_alias" id="l_alias" placeholder="Link Alias" value="<?php echo html_entity_decode($row['link_alias'] ?? '');?>" data-validate="l_alias|text|n|1|500|alnum_spc|Please enter Valid Link Name!"/>
                    </div>
                    
                    <div class="mb-3">
                      <label for="l_title" class="form-label">Title <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" name="l_title" id="l_title" placeholder="Link Title" value="<?php echo ($row['title'] ??'');?>" data-validate="l_title|text|y|1|500|alnum_spcA|Please enter Valid Link Title!"/>
                    </div>
                        
                    <div class="mb-3">
                      <label for="l_bdesc" class="form-label">Brief Description: <span class="text-danger">*</span></label>
                      <textarea class="form-control" name="l_bdesc" id="l_bdesc" placeholder="Brief Description of the Link" data-validate="l_bdesc|textarea|n|1|2000|alnum_spcA|Please enter Valid data!"><?php echo html_entity_decode($row['link_bdesc'] ?? '');?></textarea>
                    </div>
                    
                    <div class="mb-3">
                      <label for="l_key" class="form-label">Keywords: <span class="text-danger">*</span></label>
                      <textarea class="form-control" name="l_key" id="l_key" placeholder="Keywords of the Link" data-validate="l_key|textarea|n|1|2000|alnum_spc|Please enter Valid data!"><?php echo html_entity_decode($row['keywords'] ?? '');?></textarea>
                    </div>
                   
                  
                    <?php  if($_REQUEST["lang_id"]=='2' or $_REQUEST["lang_id"]=='3' ) {
                   ?>
  
                     <div class="mb-3" id="HindiBlock">
                          <label for="Engid" class="form-label">Choose English Link <span class="text-danger">*</span></label>
                          <select name="Engid" id="Engid" class="form-control" data-validate="Engid|text|n|1|10|num|dontselect=-1|Please enter Valid option!">
                            <option value="-1">--- Select ---</option>
                            <?php
                            
                               $link_alias="";                            
                                $rs1=simplefetch("select distinct lf.lid,wlt.link_name,wlt.link_alias from web_links_final lf
								INNER JOIN web_link_temp wlt on wlt.link_temp_id=lf.link_temp_id
								INNER JOIN web_links_structure ls on ls.lid=lf.lid
								where wlt.`status`='Active' and wlt.type_id=$_REQUEST[type_id] $subQry and wlt.continuous_content=0 and wlt.lang_id=1 ORDER BY wlt.link_name");
                                if($rs1[0]>0){
                                    foreach($rs1[1] as $row1){
										if(!empty($row1['link_alias'])){
											$link_alias = "(".$row1['link_alias'].")"; 
										}
										
                                if($row['eng_id']==$row1['lid'])
                                    echo "<option value='$row1[lid]' selected=''>$row1[link_name] [ $row1[link_alias] ]</option>";
									
                                else
                                    echo "<option value='$row1[lid]'>$row1[link_name] [ $row1[link_alias] ]</option>";
                                 }
                            }
                            ?>
                          </select>
                        </div>   
                        <?php } ?>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="list-inline">
                                <li><label for="lsub_type" class="form-label">Link Category <span class="text-danger">*</span></label></li>
                                <li class="checkbox">                                    
                                    <input type="radio" name="lsub_type" id="lsub_type1" value="1" checked="" /> Normal
                                   <input type="radio" style="display:none;" name="lsub_type" id="lsub_type2" value="2" <?php echo ($row['l_sub_type'] ?? '') ==2?'checked=""':'';?> /> <!--Publication-->
                                    <input type="radio" style="display:none;" name="lsub_type" id="lsub_type3" value="3" <?php echo ($row['l_sub_type'] ?? '')==3?'checked=""':'';?> data-validate="lsub_type|checkbox|y|1|2|selmin=1|Please Select atleast One option!"/> <!--Event-->
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    <fieldset class="scheduler-border d-none" id="cat_pub">
                        <legend class="scheduler-border">Publication Block</legend>    
                        <div class="mb-3 col-md-6">
                          <label for="au_name" class="form-label">Author Name</label>
                          <input type="text" class="form-control" name="au_name" id="au_name" placeholder="Author Name" value="<?php echo ($row['author_name'] ?? '');?>" data-validate="au_name|text|y|1|500|alnum_spcA|Please enter Valid Author Name!"/>
                        </div>
                        
                        <div class="mb-3 col-md-6">
                          <label for="pubDate" class="form-label">Date of Publication:</label>
                          <div class="input-group col-md-8">
                            <input type="text" class="form-control" name="pubDate" id="pubDate" placeholder="DD/MM/YYYY" value="<?php echo $row['pub_date'] ?? '';?>" data-validate="pubDate|text|y|10|10|dt|Please enter/ select Valid Date!"/>
                            <span class="input-group-addon CopyIcon" data-for='pubDate'><span class="glyphicon glyphicon-calendar"></span></span>
                          </div>                      
                        </div>
                    </fieldset>
                    
                    <fieldset class="scheduler-border" id="cat_event">
                        <legend class="scheduler-border">Event Block</legend>    
                        <div class="row">
                            <div class="mb-3 col-md-6">
                              <label for="efDate" class="form-label">Event Start Date <span class="text-danger">*</span></label>
                              <div class="input-group col-md-8">
                                <input type="date" class="form-control" name="efDate" id="efDate" placeholder="DD/MM/YYYY" value="<?php echo $row['evef_date'] ?? '';?>" data-validate="efDate|text|y|10|10|dt|Please enter/ select Valid Date!"/>
                                <span class="input-group-addon CopyIcon" data-for='efDate'><span class="glyphicon glyphicon-calendar"></span></span>
                              </div>                      
                            </div>
                            
                            <div class="mb-3 col-md-6">
                              <label for="etDate" class="form-label">Event End Date <span class="text-danger">*</span></label>
                              <div class="input-group col-md-8">
                                <input type="date" class="form-control" name="etDate" id="etDate" placeholder="DD/MM/YYYY" value="<?php echo $row['evet_date'] ?? '';?>" data-validate="etDate|text|n|10|10|dt|Please enter/ select Valid Date!"/>
                                <span class="input-group-addon CopyIcon" data-for='etDate'><span class="glyphicon glyphicon-calendar"></span></span>
                              </div>                      
                            </div>
                        </div>
                        
                        <div class="mb-3">
                          <label for="event_name" class="form-label">Event Venue <span class="text-danger">*</span></label>
                          <input type="text" class="form-control" name="event_name" id="event_name" placeholder="Event Venue" value="<?php echo ($row['event_name'] ?? '');?>" data-validate="event_name|text|y|1|500|alnum_spcA|Please enter Valid Event Venue!"/>
                        </div>
                    </fieldset>
                    
                    <div id="urlBlock">
                        <div class="mb-3 d-none">
                          <label for="l_url" class="form-label">Link URL <span class="text-danger">*</span></label>
                          <input type="text" class="form-control" name="l_url" id="l_url" placeholder="Link URL" value="<?php echo $row['url'] ?? '';?>" data-validate="l_url|text|y|1|500|url|Please enter Valid URL!"/>
                          <p class="help-block">URL should be start 'http:// or https:// or ftp:// '</p>
                        </div>
                    </div>
                    
                    <div id="fileBlock">
                        <div class="mb-3 d-none">
                          <label for="l_file" class="form-label">Choose File <span class="text-danger">*</span></label>
                          <?php $Mand=(empty($row['file_name']))?'y':'n';?>
                          
                          <input type="file" name="l_file" id="l_file" data-validate="l_file|file|<?php echo $Mand;?>|1|20000|file_extn=pdf|Please Select file, Only PDF is allowed!"/>
                          <?php
                          if(!empty($row['file_name'])){                              
                          ?>
                          <a href="#"><i class="fa fa-file-pdf-o text-red" data-fname='<?php echo base64_encode($row['file_name']);?>' title="View File"></i></a>
                          <?php
                          }
                          ?>
                          <p class="help-block">Please Select file,Filename should not contain any special character and white space. Invalid Filename! Allowed extenstions are pdf!.</p> 
                        </div>
                    </div>
                    
                    <div id="contBlock">


						<div class="mb-3" >
                          <label for="header_l_file" class="form-label">Choose Header Image <span class="text-danger">*</span></label>
                          <?php //$Mand_h=(empty($row['file_name']))?'y':'n';?>
                          
                          <input type="file" name="header_l_file" id="header_l_file" data-validate="header_l_file|file|n|1|10000|file_extn=jpg;png;jpeg;|Please Select file, Allowed extenstions are jpg, jpeg, png!"/>
						  
						  
                          <?php
                          if(!empty($row['header_img'])){                              
                          ?>
						   <img src="<?php echo "../WriteReadData/$_SESSION[hdUpload]/$row[header_img]";?>" class="img-thumbnail" alt="Link Icon" width="100"/>
                          <!--<a href="#"><i class="fa fa-file-pdf-o text-red" data-fname='<?php //echo base64_encode($row['header_img']);?>' title="View File"></i></a>-->
                          <?php
                          }
                          ?>
						  <p class="help-block">Image should be 1600 X 154 px.</p>
                        </div>
						
                        <div class="mb-3">
                          <label for="l_src" class="form-label">Source <span class="text-danger">*</span></label>
                          <textarea class="form-control" name="l_src" id="l_src" placeholder="Source of the Link" data-validate="l_src|textarea|n|1|2000|alnum_spc|Please enter Valid Source!"><?php echo html_entity_decode($row['source'] ?? '');?></textarea>
                        </div>
                        
                        <div class="mb-3">
                          <label for="l_mdesc" class="form-label">Meta Description <span class="text-danger">*</span></label>
                          <textarea class="form-control" name="l_mdesc" id="l_mdesc" placeholder="Meta Description of the Link" data-validate="l_mdesc|textarea|n|1|2000|alnum_spc|Please enter Valid data!"><?php echo html_entity_decode($row['meta_tag'] ?? '');?></textarea>
                        </div>   
                                             
                    
                        <div class="mb-3">
                          <label for="textarea2" class="form-label">Rich Text Formater <span class="text-danger">*</span></label>
                          <textarea class="form-control" name="textarea2" id="textarea2" placeholder="Keywords of the Link" data-validate="textarea2|textarea|y|1|50000|rtf|Please enter Valid data!"><?php rtfPathManage($row['details'],false);echo $row['details'] ?? '';?></textarea>
                        </div>
                            
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



<?php
/*
<script type="text/javascript">
    
$('#l_name').keyup(function(){
    $('#l_title').val($(this).val());
});
      

    $('#type_id').change(function() {
  // Code to run when the value changes
  console.log("Value changed!");
});

    
// $(function(){
    $('.input-group-addon').click(function(){
        if($(this).data('for')!=undefined){            
            $('#'+$(this).data('for')).trigger('focus');
        }
    })
    



    // $('#pubDate,#efDate,#etDate').datepicker({
    //         autoclose:true,
    //         todayHighlight:true,            
    //         format:'dd/mm/yyyy',
    //         //endDate: '0',
    //     }        
    // ); 
  
    function CallfrCk(){
        $('#formNC').formChecks({nonASCII:true,ajaxSubFunc:frmAction}).SetToFirstFocus();
    }
    CallfrCk();
    
    $('#formNC #type_id').change(function()
    {        console.log("Type Changed");
        var lType=$(this).val();
        console.log("Current Type: " + lType);
        switch(lType){
            case '1':
                $('#urlBlock,#contBlock').hide();
                $('#fileBlock').show();
                $(".modal-dialog").css("width", "600px");
            break;
            
            case '2':
                $('#fileBlock,#contBlock').hide();
                $('#urlBlock').show();
                $(".modal-dialog").css("width", "600px");
            break;
            
            case '3':
                $('#fileBlock,#urlBlock').hide();
                $('#contBlock').show();
                $(".modal-dialog").css("width", "800px");
                showRTF();
            break;
            
        }
        
        CallfrCk();
    }) 
   
   
   
    //  $('#formNC #lang_id').change(function(){        
    //     var langtype=$(this).val();
    //     alert("ajit");
    //     switch(langtype){
    //         case '1':
    //             $('#HindiBlock').hide();
                
    //         break;
            
    //             case '2':
    //             $('#HindiBlock').show();
    //             break;
    //         }
    //          CallfrCk();
    //     })
    $('#formNC #type_id').trigger('change');
    
    $('#cat_pub, #cat_event').hide();
    $('#formNC input[name="lsub_type"]').change(function()
    {        
        var lType=$(this).val();
        //console.log(lType);
        switch(lType){
            case '2':
                $('#cat_event').hide();
                $('#cat_pub').show();
                //$(".modal-dialog").css("width", "600px");
            break;
            
            case '3':
                $('#cat_pub').hide();
                $('#cat_event').show();
                //$(".modal-dialog").css("width", "600px");
            break;
            
            case '1':
                $('#cat_pub, #cat_event').hide();
            break;
        }
        CallfrCk();
    });
    <?php echo isset($row['l_sub_type'])?"$('#formNC #lsub_type$row[l_sub_type]').trigger('change')":'';?>  

// })



function frmAction()
{
    $.base64.utf8encode = true;

    var form = document.getElementById('formNC');
    var formData = new FormData(form);

    var type_id = $('#type_id').val();
    var nmnh_type_id = $('#nmnh_type_id_si').val();
    var urlVal = $('#l_url').val();

    
    if($('#nmnh_type_id_si').length && $('#nmnh_type_id_si').is(':visible')){
        if(nmnh_type_id == "-1" || nmnh_type_id == "" || nmnh_type_id == null){
            alert('Please select Site Type');
            return false;
        }
    }

    if(type_id == '2'){
        if(!urlVal || urlVal.trim() === ''){
            alert('Please enter Valid URL');
            return false;
        }
    }


    // PDF File (1KB – 15MB)
    if($('#l_file')[0] && $('#l_file')[0].files.length > 0){

        var pdfFile = $('#l_file')[0].files[0];
        var pdfSize = pdfFile.size; 

        if(pdfSize < 1024 || pdfSize > 15728640){
            alert('File size must be between 1KB and 15MB');
            return false;
        }
    }

    if($('#header_l_file')[0] && $('#header_l_file')[0].files.length > 0){

        var headerFile = $('#header_l_file')[0].files[0];
        var headerSize = headerFile.size;

        if(headerSize < 1024 || headerSize > 5242880){
            alert('Header image size must be between 1KB and 5MB');
            return false;
        }
    }


    var other_data = $('#formNC').serializeArray();

    $.each(other_data, function(key, input){

        var DomStr = input.value.match(/<body[^>]*>[\s\S]*<\/body>/gi);

        DomStr = (DomStr === null)
            ? input.value
            : $('<div />').text(DomStr).html();

        formData.set(input.name, DomStr);
    });


    $.ajax({
        type: "POST",
        dataType: "text",
        cache: false,
        enctype: 'multipart/form-data',
        url: $('#formNC').attr('action'),
        data: formData,
        processData: false,
        contentType: false,

        beforeSend: function(){
            $.fn.ajaxLoading();
        },

        success: function(data){

            try{
                data = $.parseJSON($.base64.atob(data));

                if(data[0]){

                    if($('#frmType').val() == 1){
                        $('#formNC')[0].reset();
                    }

                    $('#ShowMsg').ShowMsg({
                        msg: 'Request Completed Successfully!',
                        colwidth: 'col-md-8',
                        coloffset: 'col-md-offset-2',
                        alertClass: 'alert-success'
                    });

                    $('#reloadGrid').trigger('click');

                } else {

                    // Validation errors
                    if(data[1] !== undefined && data[1][0] === true){

                        var FEror = data[1][1];
                        $.fn.ShowError(FEror);

                    } 
                    // Custom message errors
                    else if(data[2] !== undefined && data[2][0] === true){

                        var MEror = data[2][1];

                        $('#ShowMsg').ShowMsg({
                            msg: MEror,
                            alertClass: data[2][2],
                            colwidth: 'col-md-8',
                            coloffset: 'col-md-offset-2'
                        });

                    } 
                    else {

                        $('#ShowMsg').ShowMsg({
                            msg: 'Request not Completed Successfully!',
                            colwidth: 'col-md-8',
                            coloffset: 'col-md-offset-2',
                            alertClass: 'alert-danger'
                        });
                    }
                }

            } catch(err){

                $('#ShowMsg').ShowMsg({
                    msg: "<strong>Error:</strong> Unexpected Response received.",
                    colwidth: 'col-md-8',
                    coloffset: 'col-md-offset-2',
                    alertClass: 'alert-warning'
                });
            }
        },

        error: function(){

            $('#PopWind').modal('toggle');

            $.fn.custom_alert({
                msg: 'Something went wrong, Please try again!'
            });
        },

        complete: function(){
            $.fn.ajaxLoading({show:false});
        }
    });
}

</script>
*/
?>


<script type="text/javascript">

    tinymce.init({
        selector: '#textarea2',
        height: 500
    });

    $('#formNC .c_type').change(function() {
        console.log("Link Type Changed");
        var lType = $(this).val();
        switch(lType){
            case '1':
                $('#urlBlock,#contBlock').hide();
                $('#fileBlock').show();
                $(".modal-dialog").css("width", "600px");
                break;
            
            case '2':
                $('#fileBlock,#contBlock').hide();
                $('#urlBlock').show();
                $(".modal-dialog").css("width", "600px");
                break;
            
            case '3':
                $('#fileBlock,#urlBlock').hide();
                $('#contBlock').show();
                $(".modal-dialog").css("width", "800px");
                showRTF();
                break;
            
        }
    }); 

$(document).ready(function () {
    $('#formNC').on('submit', function (e) {
        e.preventDefault();   
        frmAction();
    });


   
    $('#formNC #lang_id').change(function(){        
        var langtype = $(this).val();
        alert("ajit");
        switch(langtype){
            case '1':
                $('#HindiBlock').hide();
                
            break;
            
            case '2':
               $('#HindiBlock').show();
            break;
            }
        CallfrCk();
    })
    $('#formNC #type_id').trigger('change');
    $('#cat_pub, #cat_event').hide();
    $('#formNC input[name="lsub_type"]').change(function() {        
        var lType=$(this).val();
        console.log(lType);
        switch(lType){
            case '2':
                $('#cat_event').hide();
                $('#cat_pub').show();
            break;
            
            case '3':
                $('#cat_pub').hide();
                $('#cat_event').show();
            break;
            
            case '1':
                $('#cat_pub, #cat_event').hide();
            break;
        }
        CallfrCk();
    });
    <?php echo isset($row['l_sub_type'])?"$('#formNC #lsub_type$row[l_sub_type]').trigger('change')":'';?>  
});

$(document).ready(function () {
    $('#formNC').on('submit', function (e) {
        e.preventDefault();   
        frmAction();
    });
});

function frmAction() {
    var formData = new FormData();
    var lFileInput = $('#l_file')[0];
    var headerFileInput = $('#header_l_file')[0];

    if (lFileInput && lFileInput.files.length > 0) {
        formData.append('l_file', lFileInput.files[0]);
    }

    if (headerFileInput && headerFileInput.files.length > 0) {
        formData.append('header_l_file', headerFileInput.files[0]);
    }

    var pdffile = $('#l_file').val().split('\\').pop();
    var header_icon = $('#header_l_file').val().split('\\').pop();

    if (pdffile != '') {
        var filesize = parseFloat(lFileInput.files[0].size / 1024).toFixed(2); // KB
        if (filesize < 1 || filesize > 15000) { // 1KB - 15MB
            alert('File size should be between 1KB and 15MB');
            return false;
        }
    }

    if (header_icon != '') {
        var headerSize = parseFloat(headerFileInput.files[0].size / 1024).toFixed(2); // KB
        if (headerSize < 1 || headerSize > 5000) { // 1KB - 5MB
            alert('File size should be between 1KB and 5MB');
            return false;
        }
    }

    var other_data = $('#formNC').serializeArray();
    $.each(other_data, function (key, input) {
        let DomStr = input.value.match(/<body[^>]*>[\s\S]*<\/body>/gi);
        DomStr = DomStr == null ? input.value : $('<div />').text(DomStr).html();
        formData.append(input.name, DomStr);
    });

    $.ajax({
        type: "POST",
        url: $('#formNC').attr('action'),
        data: formData,
        dataType: "text", 
        cache: false,
        enctype: 'multipart/form-data',
        processData: false,
        contentType: false,

        beforeSend: function () {
            $.fn.ajaxLoading();
        },

success: function(data) {
    try {
        data = $.parseJSON($.base64.atob(data));

        if (data[0] === true) { 

            if ($('#frmType').val() == 1) {
                $('#formNC')[0].reset();
            }

            $('#ShowMsg').ShowMsg({
                msg: 'Request Completed Successfully!',
                colwidth: 'col-md-8',
                coloffset: 'col-md-offset-2',
                alertClass: 'alert-success'
            });

            $('#reloadGrid').trigger('click');

            // Lock modal and close after 3 seconds
            $('#PopWind').find('input, textarea, select, button').prop('disabled', true);
            $('#PopWind').modal({ backdrop: 'static', keyboard: false });
            $('#PopWind .modal-body').css('opacity', '0.6');

            setTimeout(function() {
                $('#PopWind').find('input, textarea, select, button').prop('disabled', false);
                $('#PopWind .modal-body').css('opacity', '1');
                $('#PopWind').modal('hide');
            }, 3000);

        } else { 

            if (data[1] !== undefined && data[1][0] === true) {
                let FEror = data[1][1];
                $.fn.ShowError(FEror); 
            } else if (data[2] !== undefined && data[2][0] === true) {
                let MEror = data[2][1];
                $('#ShowMsg').ShowMsg({
                    msg: MEror,
                    alertClass: data[2][2],
                    colwidth: 'col-md-8',
                    coloffset: 'col-md-offset-2'
                });
            } else {
                $('#ShowMsg').ShowMsg({
                    msg: 'Request not Completed Successfully!',
                    colwidth: 'col-md-8',
                    coloffset: 'col-md-offset-2',
                    alertClass: 'alert-danger'
                });
            }

        }

    } catch (err) {
        console.error("Parsing Error:", err);
        $('#ShowMsg').ShowMsg({
            msg: "<strong>Error:</strong> Unexpected Response received, Please try again!",
            colwidth: 'col-md-8',
            coloffset: 'col-md-offset-2',
            alertClass: 'alert-warning'
        });
    }
}

        error: function () {
            $('#PopWind').modal('toggle');
            $.fn.custom_alert({ msg: 'Something went wrong, Please try again!' });
        },

        complete: function () {
            $.fn.ajaxLoading({ show: false });
        }
    });
}




</script>