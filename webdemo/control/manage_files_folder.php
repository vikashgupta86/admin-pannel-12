<?php include '../appcode/globals.inc.php';
include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');
userAuthenticationPageLevel();
userAuthenticationMainLevel();
include_once('include/pageHeader.inc.php');
?>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <?php include('include/top_user_info.inc.php');?>  
          <!-- Left side column. contains the logo and sidebar -->
          <?php //include('include/left_nav.inc.php');?>
        
          <!-- Content Wrapper. Contains page content -->

          <h3 class="box-title">Manage Files In Folder</h3>
        
                    <?php include('include/choosefolder.inc.php');?>
             
                    <!--<div class="text-right" style="margin-bottom: 2px;"><button id="AddNew" cdata-frmT='1' class="btn btn-warning">Add New</button></div>-->
                    <div class="panel panel-default">
                        <table id="myTable1" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Files Name</th>
                                    <th>Last Modified Date</th>
                                   <th>Preview</th>
                                    <th class="text-center">Action</th>
                                </tr>
                               
                            </thead>
                        </table>
                    </div>
                    <div id="ShowMsg1"></div>                    
                    <div id="reloadGrid"></div>
                </div>                                
                <!-- /.box-body -->
                
                
            <?php
				
				
				
				
				
   
  // Specifying directory
  //$mydir = '../WriteReadData/L45218/';
 
  // Scanning files in a given directory in ascending order
  //$myfiles = scandir($mydir);
 
// foreach($myfiles as $filename){
 
 //echo $filename, '<br>'; 
 //}
  // Displaying the files in the directory
  //print_r($myfiles);
				




?>    
                
                
              </div>                    
          </div>
          
          <!-- /.content-wrapper -->
          
        
    <script type="text/javascript">            
    //console.log(csrfMagicName);
         $(document).delegate('#AddNew,.fa-edit,.fa-trash-o,.fa-retweet,.fa-desktop', 'click', function() {
            var frmType=$(this).attr('cdata-frmT');

            //console.log(frmType);  
                   
            if($.inArray(frmType,['3','4','5','6'])!='-1'){

                var con=confirm('Do you really want to Proceed?');
                var eleCtrl=$(this);
                //console.log(con)
                if(con){          
                    var lid=($(this).attr('pub-lid')!=undefined)?$(this).attr('pub-lid'):'';
                    $.base64.utf8encode = true;
                    $.ajax({
                        type     : "POST",
                        dataType: "text",
                        cache    : false,
                        url      : '<?php echo "files_folder_action.php?per_id=$_SESSION[per_id]&EncHid=$_SESSION[EncTok]";?>&lid='+lid,
                        data     : {<?php echo $GLOBALS['csrf']['token'];?>,'frmType':frmType,'filename':$(this).data('filename'),'foldername':$(this).data('foldername')},
                        beforeSend: function(){
                            $.fn.ajaxLoading();
                        },        
                        success  : function(data) {                                    
                            try{
                                data=$.parseJSON($.base64.atob(data));                                                
                                if(data[0]){
                                    $('#ShowMsg1').ShowMsg({msg:'Request Completed Successfully!',alertClass:'alert-success'});
                                    $('#reloadGrid').trigger('click');                                    
                                    if(frmType==3)
                                        eleCtrl.closest('tr').hide();                    
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
            else if(frmType=='9')
            {
                
                var lid=($(this).attr('pub-lid')!=undefined)?$(this).attr('pub-lid'):'';
                $('.modal-container').OpenPop({
                    url:"pub_link.php?frmType=" + frmType + "&lid="+lid+"&link_temp_id=" + $(this).data('link_temp_id') + "&lang_id=<?php echo "$_REQUEST[lang_id]";?>&type_id=<?php echo $_REQUEST['type_id'] ?? '';?>&per_id=<?php //echo "$_SESSION[per_id]&EncHid=$_SESSION[EncTok]";?>",
                });
            }
            else
            {

                var lid=($(this).attr('pub-lid')!=undefined)?$(this).attr('pub-lid'):'';
                $('.modal-container').OpenPop({
                    url:"add_musume_type.php?frmType=" + frmType + "&lid="+lid+"&link_temp_id=" + $(this).data('link_temp_id') + "&lang_id=<?php echo "$_REQUEST[lang_id]";?>&type_id=<?php echo $_REQUEST['type_id'] ?? '';?>&per_id=<?php echo "$_SESSION[per_id]&EncHid=$_SESSION[EncTok]";?>",
                });
            }
        });
        
        
        $(function(){
            
            var mGridTable=$('table#myTable1').DataTable( {
                        "processing": true,
                        "serverSide": false,
                        "ajax": {
                            "url":"AjaxFill/getfolder_data.php?<?php echo "EncHid=$_SESSION[EncTok]";?>",
                            "type":"POST",
                            "data":{<?php echo $GLOBALS['csrf']['token'];?>,'fname':'<?php echo "$_REQUEST[fname]";?>'}
                            },
                        scrollY:        400,
                        scrollCollapse: true,
                        paging:         false
                    } );
            
          
            
            $(document).delegate('#reloadGrid', 'click', function ReLoadGrid() {
                mGridTable.ajax.reload( null, false );
            });
        })
         
    </script>

    <script src='../tinymce/tinymce/tinymce.min.js'></script>
 <script src="rtf/rtfConf.js"></script>

 
    <?php include('include/pageFooter.inc.php');?>