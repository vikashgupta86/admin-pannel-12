<?php 
    include '../appcode/globals.inc.php';
    include_once(BASE_PATH .'/control/include/include.inc.php');
    userAuthenticationPageLevel();
    userAuthenticationMainLevel();
    include_once('include/pageHeader.inc.php');
    include('include/top_user_info.inc.php'); 
?>
    
<h2 class="h5 content-header text-dark">List of Sub-Modules</h2>

                         <div class="table-responsive">                                             
                      <table id="GridData" class="table table-bordered table-striped table-hover">
                        <thead>
                        <tr>
                          <th>S.No</th>
                          <th>Module Name</th>
                          <th>Sub Module Name</th>                                                    
                          <th><button type="button" id="AddNew" class="btn btn-primary">Add New Sub Module <i class="fa fa-plus-square-o" aria-hidden="true"></i></button></th>
                        </tr>
                        </thead>
                        <?php /*<tbody>
                            <?php 
                            $rs=simplefetch("select module_name,module_id,abbrev,ifnull(fa_icon,'fa-arrow-right')as fa_icon from web_st_module where status='Active' and module_id not in (1) order by pos"); 
                            if ($rs[0] > 0){ 
                                $s = 1; 
                                foreach ($rs[1] as $row){ 
                                    ?>
                                    <tr class="GridRow mouse_over_tr">
                                        <td class="DataCenter"><?php echo $s++; ?></td>
                                        <td><i class="fa <?php echo $row['fa_icon'];?>"></i>&nbsp;&nbsp;<?php echo $row[ 'module_name']; ?></td>                            
                                        <td class="DataCenter">
                                            <?php 
                                            if(in_array("2", $LinkPermission)) 
                                                echo "<a href=\"add_module.php?per_id=$_REQUEST[per_id]&amp;child=2&amp;mod_id=$row[module_id]&amp;EncHid=$_SESSION[EncTok]\">Edit</a>&nbsp;||&nbsp;"; 
                                            if (in_array("3", $LinkPermission)) 
                                                echo "<a href=\"add_module.php?per_id=$_REQUEST[per_id]&amp;child=3&amp;val_sub=1&amp;mod_id=$row[module_id]&amp;EncHid=$_SESSION[EncTok]\" onclick=\"return confirm('Do You Really Want to Delete?')\">Delete</a>"; 
                                            ?>
                                            <div class="tools">
                                                <i class="fa fa-edit"></i>
                                                <i class="fa fa-trash-o"></i>
                                            </div>
                                        </td>
                                    </tr>
                					<?php 
                                } 
                            } 
                            ?>
                        </tbody>*/?>
                        
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
                            url      : '<?php echo "sub_module_action.php?per_id=$_SESSION[per_id]&amp;EncHid=$_SESSION[EncTok]";?>',
                            data     : {'frmType':'3','sub_module_id':$(this).data('submodid')},
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
                    $('.modal-container').OpenPop({
                        url:"sub_module.php?frmType=" + frmType + "&sub_module_id=" + $(this).data('submodid') + "&per_id=<?php echo "$_SESSION[per_id]&EncHid=$_SESSION[EncTok]";?>",
                    });
                }
            });
            
            var mGridTable=$('#GridData').DataTable({
                "columnDefs": [
                    { "visible": false, "targets": 1},
                    {'aTargets': [3],'bSortable': false}
                ],
                //'aoColumnDefs': [{'aTargets': [3],'bSortable': false}],//this not working with columnDefs
                "processing": true,
                "serverSide": false,
                "ajax": "AjaxFill/getSubModules.php?per_id=<?php echo "$_SESSION[per_id]&EncHid=$_SESSION[EncTok]";?>",
                "drawCallback": function ( settings ) {
                    var api = this.api();
                    var rows = api.rows( {page:'current'} ).nodes();
                    var last=null;
         
                    api.column(1, {page:'current'} ).data().each( function ( group, i ) {
                        if ( last !== group ) {
                            $(rows).eq( i ).before(
                                '<tr class="group"><td colspan="3">'+group+'</td></tr>'
                            );
                            last = group;
                        }
                    } );
                    }
            });
            
            // Order by the grouping
            $('#GridData').on( 'click', 'tr.group', function () {
                var currentOrder = mGridTable.order()[0];
                if ( currentOrder[0] === 1 && currentOrder[1] === 'asc' ) {
                    mGridTable.order( [ 1, 'desc' ] ).draw();
                }
                else {
                    mGridTable.order( [ 1, 'asc' ] ).draw();
                }
            } );
                        
            $(document).delegate('#reloadGrid', 'click', function ReLoadGrid() {
                mGridTable.ajax.reload( null, false );
            });
          });
        </script>

            <?php include('include/pageFooter.inc.php');?>
