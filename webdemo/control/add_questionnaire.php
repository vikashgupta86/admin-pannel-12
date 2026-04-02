<?php include '../appcode/globals.inc.php';
include_once(dirname_r(__FILE__, 1) . '/include/include.inc.php');
$obj->AjaxFilePrevent();
?>

<div id="PopWind" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Add/Modify Sub Sectors</h4>
            </div>

            <?php
            $fileR = 'y';
            if(isset($_REQUEST['frmType']) && $_REQUEST['frmType']==9){

                $fileR = 'n';
                $rs=$obj->simplefetch("select * from subsector_quest where status='Active' and subsector_quest_id='".$_REQUEST['subsector_quest_id']."'");
                if($rs[0]>0){
                    foreach($rs[1] as $row);                    
                }
            }
            ?>

            <form name="formNC" id="formNC" method="post" autocomplete="on" role="form" action="<?php echo "upload_questionnaire.php?per_id=$_SESSION[per_id]&amp;EncHid=$_SESSION[EncTok]"; ?>" enctype="multipart/form-data">
                <input type="hidden" name="frmType" id="frmType" value="<?php echo $_REQUEST['frmType']; ?>" />
                <input type="hidden" name="subsector_quest_id" id="subsector_quest_id" value="<?php echo $_REQUEST['subsector_quest_id']; ?>" />
                <input type="hidden" name="type1" id="type1"/>

                <div class="modal-body">
                    <div class="box-body">

                        <div class="form-group ">
                            <label for="sector_id">Sector*</label>
                            <select onchange='get_subsectors()' id='sector_id' name="sector_id" class='form-control' data-validate="sector_id|text|y|1|10|num|dontselect=-1|Please enter Valid option!">
                                <option selected value="-1">--- Select ---</option>
                            <?php

                                $rs1=$obj->simplefetch("select * from neca_sectors where status='Active'");

                                if($rs1[0]>0){
                                    foreach($rs1[1] as $row1){
                                        $sel = "";
                                        if($row1['sector_id'] == $row['sector_id'] ) 
                                        {
                                            $sel = "selected";
                                        }
                                        echo "<option $sel value=".$row1['sector_id'].">".$row1['sector_name']."</option>";
                                    }
                                }

                            ?>
                            </select>
                        </div>

                        <div class="form-group ">
                            <label for="subsector_id">Sub Sector*</label>
                            <select id='subsector_id' name="subsector_id" class='form-control' data-validate="subsector_id|text|y|1|10|num|dontselect=-1|Please enter Valid option!">
                                <option selected value="-1">--- Select ---</option>
                            <?php

                                $rs2=$obj->simplefetch("select * from neca_subsectors where status='Active' and sector_id=$row[sector_id] ");
                                //$rs2=$obj->simplefetch("SELECT s.subsector_id AS subsector_id, s.subsector_name AS subsector_name, s.sector_id FROM neca_subsectors s LEFT JOIN subsector_quest sq ON s.subsector_id = sq.subsector_id AND s.sector_id = sq.sector_id and sq.`status`='Active' WHERE s.sector_id =$row[sector_id] AND s.status='Active' AND sq.subsector_id IS NULL",3);

                                if($rs2[0]>0){
                                    foreach($rs2[1] as $row2){
                                        $sel = "";
                                        if($row2['subsector_id'] == $row['subsector_id'] ) 
                                        {
                                            $sel = "selected";
                                        }
                                        echo "<option $sel value=".$row2['subsector_id'].">".$row2['subsector_name']."</option>";
                                    }
                                }

                            ?>
                            </select>
                        </div>
                       
                        <div class='form-group my-4'>
                            <label for='quest'>Upload Questionnaire </label>
                            <input type='file' name='quest' id='quest' data-validate='quest|file|<?php echo $fileR; ?>|1|1000|file_extn=xlsx;xls;xlsm;xlsb;xltx;doc;docx;|Please Select file, Only Excel or Word files are allowed!'/>
                            
                            <!-- <p id="errorMessage" style="color: red; margin-left: 5px"></p><br><br> -->
                            <label id='up_photo12' class='msghidden' style='display: none'>
                                
                                <div class='alert alert-danger' style="padding: 6px; margin: 4%; margin-top: 1%"  id='errorMessage'>
                                    <!-- <span class='glyphicon glyphicon-remove-circle'></span> -->
                                </div>
                            </label>
                        </div>

                       
                    </div>


                    <div class="clearfix"></div>
                    <div id="ShowMsg"></div>
                </div>
                <div class="clearfix"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
            

            <div class="clearfix"></div>
        </div>
    </div>
</div>

<script type="text/javascript">

   
    function get_subsectors() {
      // var x = document.getElementById("state").value;
      var sector_id = $('#sector_id').val();
      // console.log(state);
    
      $.ajax({
        url: './include/get_subsectors.php',
        type: "POST",
        data: {
          sector_id: sector_id
        },
        success: function(data) {
          $('#subsector_id').html(data);
          console.log(data);
        }
      });
    
    }
    
    function CallfrCk(){
        $('#formNC').formChecks({nonASCII:true,ajaxSubFunc:frmAction}).SetToFirstFocus();
    }
    CallfrCk();

    function closeError(){
                const up_photo12 = document.getElementById('up_photo12');
                up_photo12.style.display = "none" ;
                
                // const errorMessage = document.getElementById('errorMessage');
                // errorMessage.innerHTML = '';
    }

    function frmAction() {
        
        // const close = document.getElementById('close');
        const up_photo12 = document.getElementById('up_photo12');
        const errorMessage = document.getElementById('errorMessage');
        errorMessage.innerHTML = '';

        const fileInput = document.getElementById('quest');
        const file = fileInput.files[0];
        const maxSize = 5 * 1024 * 1024;

        $.base64.utf8encode = true;
        var formData = new FormData();

        if (file) {
            if (file.size > maxSize) {

                up_photo12.style.display = "contents" ;
                errorMessage.innerHTML = '<span id="cross" class="glyphicon glyphicon-remove-circle"></span> File Size should be less than 5MB <a class="close" id="close" onclick="closeError()" aria-label="close">×</a>'; 
                fileInput.value = ''; // Clear the selection
                return false;

            } 
        }


        var other_data = $('#formNC').serializeArray();
        $.each(other_data, function(key, input) {
            //managing the RTF content start 	
            let DomStr = input.value.match(/<body[^>]*>[\s\S]*<\/body>/gi);
            DomStr = DomStr == null ? input.value : $('<div />').text(DomStr).html();
            //RTF END

            formData.append(input.name, DomStr);
        });

        exit();
    //     console.log(formData);
    //     alert(formData);

        // $.ajax({
        //     type: "POST",
        //     dataType: "text",
        //     cache: false,
        //     enctype: 'multipart/form-data',
        //     url: $('#formNC').attr('action'),
        //     data: formData, //$('#formNC').serialize(),        
        //     processData: false,
        //     contentType: false,

        //     beforeSend: function() {
        //         $.fn.ajaxLoading();
        //     },
        //     success: function(data) {
        //         try {
        //             data = $.parseJSON($.base64.atob(data));
        //             if (data[0]) {
        //                 //if($('#frmType').val()!=2){
        //                 ($('#frmType').val() == 1) ? $('#formNC')[0].reset(): '';
        //                 $('#ShowMsg').ShowMsg({
        //                     msg: 'Request Completed Successfully!',
        //                     colwidth: 'col-md-8',
        //                     coloffset: 'col-md-offset-2',
        //                     alertClass: 'alert-success'
        //                 });
        //                 /*}
        //                 else{
        //                     $('#ShowMsg1').ShowMsg({msg:'Request Completed Successfully!',alertClass:'alert-success'});
        //                     $('#PopWind').modal('toggle');
        //                 }*/


        //                 $('#reloadGrid').trigger('click');

        //             } else {
        //                 if (data[1] != undefined && data[1][0] == true) {
        //                     FEror = data[1][1];
        //                     $.fn.ShowError(FEror);
        //                 } else if (data[2] != undefined && data[2][0] == true) {
        //                     MEror = data[2][1];
        //                     //console.log(MEror);
        //                     $('#ShowMsg').ShowMsg({
        //                         msg: MEror,
        //                         alertClass: data[2][2],
        //                         colwidth: 'col-md-8',
        //                         coloffset: 'col-md-offset-2'
        //                     });
        //                 } else {
        //                     $('#ShowMsg').ShowMsg({
        //                         msg: 'Request not Completed Successfully!',
        //                         colwidth: 'col-md-8',
        //                         coloffset: 'col-md-offset-2',
        //                         alertClass: 'alert-danger'
        //                     });
        //                 }
        //             }
        //         } catch (err) {
        //             $('#ShowMsg').ShowMsg({
        //                 msg: "<strong>Error:</strong> Unexpected Response received, You may try again!",
        //                 colwidth: 'col-md-8',
        //                 coloffset: 'col-md-offset-2',
        //                 alertClass: 'alert-warning'
        //             });
        //         }

        //     },
        //     error: function() {
        //         $('#PopWind').modal('toggle');
        //         $.fn.custom_alert({
        //             msg: 'Something went wrong, Please try again!'
        //         });
        //     },
        //     complete: function() {
        //         $.fn.ajaxLoading({
        //             show: false
        //         });
        //     },
        // });
    }

</script>