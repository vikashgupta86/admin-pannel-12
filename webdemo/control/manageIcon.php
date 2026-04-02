<?php 
    include '../appcode/globals.inc.php';
    include_once(BASE_PATH .'/control/include/include.inc.php');
    userAuthenticationPageLevel();
    userAuthenticationMainLevel();
    include_once('include/pageHeader.inc.php');
    include('include/top_user_info.inc.php'); 
?>
    
<h2 class="h5 content-header text-dark">Manage Links Icon</h2>

 <?php 
    $MainView=false;
    include('include/chooseLink.inc.php');
                            
    if(isset($_REQUEST['preSub']) && $_REQUEST['preSub']==1 && ($frmError ?? '')==false){
    $ShowGridFlage=true;
        ?>

        <div class="panel panel-default">
            <h4 class="text-center">Manage Links Icon</h4>
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
                        <th class="text-center">Icon Image</th>                                    
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
            </table>                        
        </div>
        <div id="ShowMsg1"></div>                    
        <div id="reloadGrid"></div>
                   
        <?php
    }
?>                


          
         
    <script type="text/javascript">
        $(document).delegate('.fa-plus-square,.fa-edit,.fa-trash-o', 'click', function() {
            var frmType=$(this).attr('cdata-frmT');
            console.log(frmType);            
            if($.inArray(frmType,['3','4','5','6'])!='-1'){
                var con=confirm('Do you really want to Proceed?');
                //console.log(con)
                if(con){                        
                    $.base64.utf8encode = true;
                    $.ajax({
                        type     : "POST",
                        dataType: "text",
                        cache    : false,
                        url      : '<?php echo "linkIcon_action.php?per_id=$_SESSION[per_id]&amp;EncHid=$_SESSION[EncTok]";?>',
                        data     : {<?php echo $GLOBALS['csrf']['token'];?>,'frmType':frmType,'lid':$(this).data('lid')},
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
                                    $('#ShowMsg1').ShowMsg({msg:'Request not Completed Successfully!',alertClass:'alert-danger'});
                                }
                            }
                            catch(err) {
                                $('#ShowMsg1').ShowMsg({msg:"<strong>Error:</strong> Unexpected Response received, You may try again!",alertClass:'alert-warning'});                                
                            }
                                                   
                        },
                        error:function(){
                            $.fn.custom_alert({msg:'Something went wrong, Please try again!'});                        
                        },
                        complete: function(){            
                            $.fn.ajaxLoading({show:false});
                        },
                    });
                }
            }
            else{
                var lid=($(this).attr('pub-lid')!=undefined)?$(this).attr('pub-lid'):'';
                $('.modal-container').OpenPop({
                    url:"linkIcon.php?frmType=" + frmType + "&lid="+lid+"&link_temp_id=" + $(this).data('link_temp_id') + "&lang_id=<?php echo "$_REQUEST[lang_id]";?>&type_id=<?php echo "$_REQUEST[type_id]";?>&per_id=<?php echo "$_SESSION[per_id]&EncHid=$_SESSION[EncTok]";?>",
                    title: "Add/ Modify Link Details"
                });
            }
        });
                
        
        
                
        $(function(){
            mGridTable=$('table#myTable1').DataTable( {
                "processing": true,
                "serverSide": false,
                "ajax": {
                    "url":"AjaxFill/get_iconLinks.php?<?php echo "EncHid=$_SESSION[EncTok]";?>",
                    "type":"POST",
                    "data":{<?php echo $GLOBALS['csrf']['token'];?>,'lang_id':'<?= $_REQUEST['lang_id'] ?? ''; ?>','type_id':'<?= $_REQUEST['type_id'] ?? '';?>','lid':'<?= $_REQUEST['lid'] ?? '';?>','per_id':'<?= $_REQUEST['per_id'] ?? ''; ?>','nmnh_type':'<?= $_REQUEST['nmnh_type'] ?? '';?>'}
                    },
                scrollY:        400,
                scrollCollapse: true,
                paging:         false,
                bInfo : true,
                drawCallback: function (settings) {
                    //console.log(settings.fnRecordsDisplay())
                    if ( settings.fnRecordsDisplay() != 0 ) {
                        //$('#SubBut').show();
                    }
                },
                responsive: true
            } );
            
            $(document).delegate('#reloadGrid', 'click', function ReLoadGrid() {
                mGridTable.ajax.reload( null, false );
            });
            
        })
    </script>

    <?php include('include/pageFooter.inc.php');?>