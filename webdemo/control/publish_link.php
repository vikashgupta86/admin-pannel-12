<?php include '../appcode/globals.inc.php';
include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');
userAuthenticationPageLevel();
userAuthenticationMainLevel();
include_once('include/pageHeader.inc.php');
?>
    
            <?php include('include/top_user_info.inc.php');?>  
          <!-- Left side column. contains the logo and sidebar -->

        
          <!-- Content Wrapper. Contains page content -->
        
                  <h3 class="h5 content-header text-dark">Publish Links</h3>
              
         
                    <?php 
					$showType=false;
					$publishFlage=true;include('include/chooseLang.inc.php');?>
            
                
                
                <?php
                if(isset($_REQUEST['preSub']) && $_REQUEST['preSub']==1 && ($frmError ?? '')==false){
                    $ShowGridFlage=true;
                ?>
                
                                
                <div class="box-body clearfix">
                    <div class="panel panel-default">
                        <table id="myTable1" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Link Name</th>
                                    <th>Created By/On</th>
                                    <th>Approved By/On</th>
                                    <th>Preview</th>                                                
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div id="ShowMsg1"></div>                    
                    <div id="reloadGrid"></div>
                </div>
                <?php
                }
                ?>                
                <!-- /.box-body -->                
              </div>                    
          </div>
          <!-- /.content-wrapper -->
         
          
        
    <script type="text/javascript">        
        $(document).delegate('.fa-tv', 'click', function() {
            var frmType=$(this).attr('cdata-frmT');
            //console.log(frmType);            
            if($.inArray(frmType,['3','4'])!='-1'){
                var con=confirm('Do you really want to Proceed?');
                //console.log(con)
                if(con){                        
                    $.base64.utf8encode = true;
                    $.ajax({
                        type     : "POST",
                        dataType: "text",
                        cache    : false,
                        url      : '<?php echo "revive_link_action.php?per_id=$_SESSION[per_id]&amp;EncHid=$_SESSION[EncTok]";?>',
                        data     : {<?php echo $GLOBALS['csrf']['token'];?>,'frmType':frmType,'link_temp_id':$(this).data('link_temp_id')},
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
                            //$.fn.custom_alert({msg:'Something went wrong, Please try again!'});   
                            $('#ShowMsg1').ShowMsg({msg:"<strong>Error:</strong> Something went wrong, Please try again!",alertClass:'alert-warning'});                     
                        },
                        complete: function(){            
                            $.fn.ajaxLoading({show:false});
                        },
                    });
                }
            }
            else{
                $('.modal-container').OpenPop({
                    url:"pub_link.php?frmType=" + frmType + "&link_temp_id=" + $(this).data('link_temp_id') + "&lang_id=<?= $_REQUEST['lang_id'] ?? '';?>&type_id=<?= $_REQUEST['type_id'] ?? '';?>&per_id=<?php echo "$_SESSION[per_id]&EncHid=$_SESSION[EncTok]";?>",
                    title:'Publish Link'
                });
            }
        });
        
        
        $(function(){            
            var mGridTable=$('table#myTable1').DataTable( {
                        "processing": true,
                        "serverSide": false,
                        "ajax": {
                            "url":"AjaxFill/getPubLinks.php?<?php echo "EncHid=$_SESSION[EncTok]";?>",
                            "type":"POST",
                            "data":{<?php echo $GLOBALS['csrf']['token'];?>,'lang_id':'<?= $_REQUEST['lang_id'] ?? '';?>','l_natur':'<?= $_REQUEST['l_natur'] ?? '';?>','type_id':'<?= $_REQUEST['type_id'] ?? '';?>','per_id':'<?php echo "$_REQUEST[per_id]";?>','nmnh_type':'<?= $_REQUEST['nmnh_type_id'] ?? '';?>','lid':$('#lid').val()}
                            },
                        scrollY:        400,
                        scrollCollapse: true,
                        paging:         false
                    } );
            
            //
            
            /*var mGridTable=$('#GridData').DataTable({                
                'aoColumnDefs': [{'aTargets': [2],'bSortable': false}],
                "processing": true,
                "serverSide": false,
                "ajax": "AjaxFill/getUsers.php?user_type_id=<?php // echo "$_REQUEST[user_type_id]";?>&per_id=<?php // echo "$_SESSION[per_id]&EncHid=$_SESSION[EncTok]";?>",                
            });*/
            
            $(document).delegate('#reloadGrid', 'click', function ReLoadGrid() {
                mGridTable.ajax.reload( null, false );
            });
            
            $(document).delegate('.Lpreview','click',function(){  
                if($('#type_id').val()==3){
                    $('.modal-container').OpenPop({
                        url:"link_preview.php?link_temp_id=" + $(this).data('link_temp_id') + "&lang_id=<?= $_REQUEST['lang_id'] ?? '';?>&type_id=<?= $_REQUEST['type_id'] ?? '';?>&per_id=<?php echo "$_SESSION[per_id]&EncHid=$_SESSION[EncTok]";?>",
                    });
                }
                else{$('.modal-container').OpenPop({
                        url:"link_preview.php?link_temp_id=" + $(this).data('link_temp_id') + "&lang_id=<?= $_REQUEST['lang_id'] ?? '';?>&type_id=<?= $_REQUEST['type_id'] ?? '';?>&per_id=<?php echo "$_SESSION[per_id]&EncHid=$_SESSION[EncTok]";?>",
                        title:'Link Preview'
                    });                                      
                }                
            })
        }) 
         
    </script>

     <?php include('include/pageFooter.inc.php');?>