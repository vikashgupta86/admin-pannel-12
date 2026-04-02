<?php include '../appcode/globals.inc.php';
include_once(dirname_r(__FILE__, 1) . '/include/include.inc.php');
$obj->AjaxFilePrevent();
?>

<div id="PopWind" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Reset Company Password</h4>
            </div>

            <?php
            if(isset($_REQUEST['frmType']) && $_REQUEST['frmType']==4){

                $rs=$obj->simplefetch("SELECT * FROM applicant_register WHERE status='Active' AND applicant_id='".$_REQUEST['u_id']."'");
                if($rs[0]>0){
                    foreach($rs[1] as $row);                    
                }
            }
            ?>

            <form name="formNC" id="formNC" method="post" autocomplete="on" role="form" action="<?php echo "companies.php?per_id=$_SESSION[per_id]&amp;EncHid=$_SESSION[EncTok]"; ?>" enctype="multipart/form-data">
                <input type="hidden" name="frmType" id="frmType" value="<?php echo $_REQUEST['frmType']; ?>" />
                <input type="hidden" name="u_id" id="u_id" value="<?php echo $_REQUEST['u_id']; ?>" />
                <input type="hidden" name="compname" id="compname" value="<?php echo $row['applicant_name']; ?>"/>
                <input type="hidden" name="type1" id="type1"/>
                <h3><?php echo $row['applicant_name']; ?></h3>
                <div class="modal-body">
                    <div class="box-body">
                       
                        <div class="form-group ">
                            <label for="sector_name">New Password</label>
                            <input class="rwpss" type="password" class="form-control" name="new_password" id="new_password" placeholder="Enter New Password" required />
                            <label for="" class="pserror" style='color:red;'></label>
                        </div>
                    </div>


                    <div class="clearfix"></div>
                    <div id="ShowMsg"></div>
                </div>
                <div class="clearfix"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary login_btn">Submit</button>
                </div>
            </form>
            

            <div class="clearfix"></div>
        </div>
    </div>
</div>

<script>
    $('.rwpss').keyup(function() 
	{
        var p = $('.rwpss').val();

        errors = [];

		if (p.length < 8) 
		{
			errors.push("Your password must be at least 8 characters."); 
		}
		if (!/[a-z]/.test(p)) 
		{
			errors.push("Your password must contain at least one lowercase letter.");
		}
		if (!/[A-Z]/.test(p)) 
		{
			errors.push("Your password must contain at least one uppercase letter.");
		}
		if (!/[!@#$%^&*()]/.test(p)) 
		{
			errors.push("Your password must contain at least one special character."); 
		}
		if (!/[0-9]/.test(p)) 
		{
			errors.push("Your password must contain at least one digit."); 
		}
		
		if (errors.length > 0) 
		{
			var reporterr = errors.join("\n");

			$('.login_btn').prop('disabled',true);
			$('.pserror').show();
			$('.pserror').text(reporterr);
			 
			return false;
		}
		$('.pserror').hide();
		$('.login_btn').prop('disabled',false);
		return true;
	});
</script>

<script type="text/javascript">
    
    function CallfrCk(){
        $('#formNC').formChecks({nonASCII:true,ajaxSubFunc:frmAction}).SetToFirstFocus();
    }
    CallfrCk();

    function frmAction() {
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