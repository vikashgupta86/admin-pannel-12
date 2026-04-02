<?php 
    include '../appcode/globals.inc.php';
    include_once(BASE_PATH .'/control/include/include.inc.php');
    userAuthenticationPageLevel();
    userAuthenticationMainLevel();
    include_once('include/pageHeader.inc.php');
    include('include/top_user_info.inc.php'); 
?>
    
<h2 class="h5 content-header text-dark">Manage New Links</h2>


                    <?php 
                    $showType=false;
                    include('include/chooseLang.inc.php');?>


                
                
                <?php
                if(isset($_REQUEST['preSub']) && $_REQUEST['preSub']==1 && ($frmError ?? '')==false){
                    $ShowGridFlage=true;
                ?>
                
                                
                    <div class="panel panel-default">                        
                        <form name="frm1" id="frm1" action="<?php echo curPageName(false)."_action.php?EncHid=$_SESSION[EncTok]"?>" role="form" class="form-border clearfix" method="post">
                        <h4 class="text-center">Manage New Links</h4>
                        <input type="hidden" name="lang_id" id="lang_id" value="<?php echo $_REQUEST['lang_id'];?>" />
                        <table id="myTable1" class="table table-striped table-bordered" cellspacing="0" width="100%">                            
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Link Name</th>
                                    <th>Link Type</th>
                                    <th>Language</th>
                                    <th>Published On</th>
                                    <th>Expiry On</th>                                                
                                    <th class="text-center">NewLink Set On</th>
                                    <th class="text-center">Set as NewLink</th>
                                </tr>
                            </thead>
                        </table>
                        <div class="text-center" id="SubBut" style="display: none;">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                        </form>
                        <!-- <p class="help-block text-danger">* After 15 Days New Icon would be removed Automatically.</p> -->
                    </div>
                    <div id="ShowMsg1"></div>                    
                    <div id="reloadGrid"></div>
                   
                <?php
                }
                ?>                


          
        
    <script type="text/javascript">
                        
        $(function(){
            mGridTable=$('table#myTable1').DataTable( {
                
                        "processing": true,
                        "serverSide": false,
                        "ajax": {
                            "url":"AjaxFill/get_mLinks.php?<?php echo "EncHid=$_SESSION[EncTok]";?>",
                            "type":"POST",
                            "data":{<?php echo $GLOBALS['csrf']['token'];?>,'custom_view':2,'lang_id':'<?php echo "$_REQUEST[lang_id]";?>','per_id':'<?php echo "$_REQUEST[per_id]";?>','dept_type_id':'<?php echo "$_REQUEST[dept_type_id]";?>'}
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
                    } );
            
            $(document).delegate('#reloadGrid', 'click', function ReLoadGrid() {
                mGridTable.ajax.reload( null, false );
            });
            
            
            $('#frm1').formChecks({ajaxSubFunc:frmAction}).SetToFirstFocus();
        })
        
        function frmAction(){
            $.base64.utf8encode = true;
                            
            var formData = new FormData();
            
            // Gather standard form fields (like hidden inputs) that are NOT in the table
            var other_data = $('#frm1').serializeArray();            
            $.each(other_data,function(key,input){
                // Only add if not shadowed by a table cell input to prevent duplicates
                if ($('#myTable1').find('[name="'+input.name+'"]').length == 0) {
                    formData.append(input.name,input.value);
                }
            });

            // Correctly capture data (especially checkboxes) from ALL DataTable rows
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
    </script>

    <?php include('include/pageFooter.inc.php');?>