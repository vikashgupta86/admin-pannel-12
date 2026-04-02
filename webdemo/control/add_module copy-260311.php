<?php 
    include '../appcode/globals.inc.php';
    include_once(BASE_PATH .'/control/include/include.inc.php');
    userAuthenticationPageLevel();
    userAuthenticationMainLevel();
    include_once('include/pageHeader.inc.php');
    include('include/top_user_info.inc.php'); 
?>
    
<h2 class="h5 content-header text-dark">List of Modules</h2>


                    <div class="table-responsive">                                             
                      <table id="GridData" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                              <th>S.No</th>
                              <th>Module Name</th>                                                    
                              <th><button type="button" id="AddNew" class="btn btn-primary">Add New Module <i class="fa fa-plus-square-o" aria-hidden="true"></i></button></th>
                          </tr>
                      </thead>
                  </table>
              </div>  
  
  
<div id="ShowMsg1"></div>
<div id="reloadGrid"></div>

<script>            
  $(function () {
   
    $(document).delegate('#AddNew,.fa-edit,.fa-trash-o', 'click', function() {                
        var frmType=($(this).hasClass('fa-edit'))?'2':(($(this).hasClass('fa-trash-o'))?'3':'1');
        if(frmType==3){
            var con=confirm('Do you really want to Proceed?');
            console.log(con)
            if(con){                        
                $.base64.utf8encode = true;
                $.ajax({
                    type     : "POST",
                    dataType: "text",
                    cache    : false,
                    url      : '<?php echo "module_action.php?per_id=$_SESSION[per_id]&amp;EncHid=$_SESSION[EncTok]";?>',
                    data     : {<?php echo $GLOBALS['csrf']['token'];?>,'frmType':'3','module_id':$(this).data('modid')},
                    beforeSend: function(){
                        $.fn.ajaxLoading();
                    },        
                    success  : function(data) {  
                        alert(data);                                  
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
            $('.modal-container').OpenPop({
                url:"module.php?frmType=" + frmType + "&module_id=" + $(this).data('modid') + "&per_id=<?php echo "$_SESSION[per_id]&EncHid=$_SESSION[EncTok]";?>",
            });
        }
    });
    
    var mGridTable=$('#GridData').DataTable({                
        'aoColumnDefs': [{'aTargets': [2],'bSortable': false}],
        "processing": true,
        "serverSide": false,
        "ajax": "AjaxFill/getModules.php?per_id=<?php echo "$_SESSION[per_id]&EncHid=$_SESSION[EncTok]";?>",
                /*"fnRowCallback" : function(nRow, aData, iDisplayIndex){                                        
                    var index = iDisplayIndex +1;
                    $('td:eq(0)',nRow).html(index);
                   return nRow;
               }*/
                /*"initComplete": function(settings, json) {
                    console.log(settings+' JSON:'+json)
                }*/
            });
    
            /*function ReLoadGrid(){                
                mGridTable.ajax.reload( null, false );
            }*/
            
            $(document).delegate('#reloadGrid', 'click', function ReLoadGrid() {
                mGridTable.ajax.reload( null, false );
            });
        });
    </script>


<?php include('include/pageFooter.inc.php');?>
