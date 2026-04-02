<?php include '../appcode/globals.inc.php';
include_once(dirname_r(__FILE__, 1) . '/include/include.inc.php');
$obj->AjaxFilePrevent();
?>

<div id="PopWind" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Add/Modify Competition Data</h4>
            </div>

            <?php
            if(isset($_REQUEST['frmType']) && $_REQUEST['frmType']==9){

                $rs=$obj->simplefetch("select * from comp_data where status='Active' and comp_data_id='".$_REQUEST['comp_data_id']."'",1);
                if($rs[0]>0){
                    foreach($rs[1] as $row);                    
                    //die($row['years']);
                }
            }   
            ?>

            <form name="formNC" id="formNC" method="post" autocomplete="on" role="form" action="<?php echo "comp_data.php?per_id=$_SESSION[per_id]&amp;EncHid=$_SESSION[EncTok]"; ?>" enctype="multipart/form-data">
                <input type="hidden" name="frmType" id="frmType" value="<?php echo $_REQUEST['frmType']; ?>" />
                <input type="hidden" name="comp_data_id" id="comp_data_id" value="<?php echo $_REQUEST['comp_data_id']; ?>" />
                <input type="hidden" name="type1" id="type1"/>
                <input type="hidden" name="sector_id" id="sector_id" value="<?php echo $row['sector_id']; ?>" />
                <input type="hidden" name="subsector_id" id="subsector_id" value="<?php echo $row['subsector_id']; ?>" />
                
                <div class="modal-body">
                    <div class="box-body">

                        <div class="form-group ">
                            <label for="year">Select Year</label>
                            <select <?= $_REQUEST['frmType']==9?'disabled':''?> id='year_id' name="year_id" class='form-control' data-validate="year|text|y|1|10|num|dontselect=-1|Please select Valid option!">
                                <option selected value="-1">--- Select ---</option>
                                <?php
    
                                    $rs1=$obj->simplefetch("select * from years where status='Active'");
    
                                    if($rs1[0]>0){
                                        foreach($rs1[1] as $row1){
                                            $sel = "";
                                            if($row1['year_id'] == $row['year'] ) 
                                            {
                                                $sel = "selected";
                                            }
                                            echo "<option $sel value=".$row1['year_id'].">".$row1['years']."</option>";
                                        }
                                    }
    
                                ?>
                            </select>
                        </div>


                        <div class="form-group ">
                            <label for="sector_id">Select Sector</label>
                            <select <?= $_REQUEST['frmType']==9?'disabled':''?> id='sector_id' name="sector_id" class='form-control' data-validate="sector_id|text|y|1|10|num|dontselect=-1|Please select Valid option!">
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
                            <label for="subsector_id">Select Sub-Sectors</label>
                            <select <?= $_REQUEST['frmType']==9?'disabled':''?> id='subsector_id' name="subsector_id" class='form-control' data-validate="subsector_id|text|y|1|10|num|dontselect=-1|Please select Valid option!">
                                <option selected value="-1">--- Select ---</option>
                            <?php

                                $rs1=$obj->simplefetch("select * from neca_subsectors where status='Active'");

                                if($rs1[0]>0){
                                    foreach($rs1[1] as $row1){
                                        $sel = "";
                                        if($row1['subsector_id'] == $row['subsector_id'] ) 
                                        {
                                            $sel = "selected";
                                        }
                                        echo "<option $sel value=".$row1['subsector_id'].">".$row1['subsector_name']."</option>";
                                    }
                                }

                            ?>
                            </select>
                        </div>      
                        <div class="form-group ">
                            <label for="first">1st</label>
                            <input type="text" class="form-control" name="first" id="first" placeholder="Enter 1st Name" value="<?php echo $row['first']; ?>" data-validate="first|text|y|1|500|alnum_spcA|Please enter Valid Name!"/>
                        </div>                                            

                        <div class="form-group ">
                            <label for="second">2nd</label>
                            <input type="text" class="form-control" name="second" id="second" placeholder="Enter 2nd Name" min="1900" max="2099" step="1"  value="<?php echo $row['second']; ?>" data-validate="second|text|y|1|500|alnum_spcA|Please enter Valid Name!"/>
                        </div>
                        
                        
                        <div class="form-group ">
                            <label for="cert_merit">Certificate of Merit (COM)</label>
                            <input type="text" class="form-control" name="cert_merit" id="cert_merit" placeholder="Enter Certificate of Merit (COM)" min="1900" max="2099" step="1"  value="<?php echo $row['cert_merit']; ?>" data-validate="cert_merit|text|y|1|500|alnum_spcA|Please enter Valid Name!"/>
                        </div>

                       
                    </div>


                    <div class="clearfix"></div>
                    <div id="ShowMsg"></div>
                </div>
                <div class="clearfix"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" onclick="checkData();" class="btn btn-primary">Submit</button>
                </div>
            </form>
            

            <div class="clearfix"></div>
        </div>
    </div>
</div>

<script type="text/javascript">


    function checkData(){
        const sector_id = document.getElementById('sector_id').value;
        const subsector_id = document.getElementById('subsector_id').value;
        const year = document.getElementById('year_id').value;
        //const first = document.getElementById('first').value;
        const frmType = document.getElementById('frmType').value;

        if( frmType != '9')
        {
            $.ajax({
                url: '../include/get_data.php',
                type: "POST",
                async: false,
                data: {
                sector_id: sector_id,
                year: year_id,
                },
                success: function(data) {
                    if (data == '1'){
                        document.getElementById('year_id').value = "";
                        document.getElementById('sector_id').value = "";
                        document.getElementById('subsector_id').value = "";
                        alert("Data for this specific Year & State already exists!");
                    }
                }
            });
        }
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
        
        // // const close = document.getElementById('close');
        // const up_photo12 = document.getElementById('up_photo12');
        // const errorMessage = document.getElementById('errorMessage');
        // errorMessage.innerHTML = '';

        // const fileInput = document.getElementById('quest');
        // const file = fileInput.files[0];
        // const maxSize = 5 * 1024 * 1024;


        $.base64.utf8encode = true;
        var formData = new FormData();

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