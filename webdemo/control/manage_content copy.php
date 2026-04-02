<?php 
    include '../appcode/globals.inc.php';
    include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');
    userAuthenticationPageLevel();
    userAuthenticationMainLevel();
    include_once('include/pageHeader.inc.php');
    include('include/top_user_info.inc.php');
?>  
        
<h2 class="h5 content-header text-dark">Manage Contents</h2>
<div id="dataTableSection" class="d-none1 mt-5">
    <div class="text-end mb-2">
        <button type="button" class="btn btn-warning rounded-0 text-white fw-bold px-3 py-1" style="background-color: #f39c12; border-color: #e08e0b;" data-bs-toggle="modal" data-bs-target="#addLinkModal">
            Add New Link
        </button>
    </div>
    <ul class="nav nav-tabs border-bottom-0" id="linkTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link rounded-0 text-dark border" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending" type="button" role="tab" aria-selected="false">Pending Links</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link active rounded-0 text-dark border border-bottom-0 fw-bold" id="published-tab" data-bs-toggle="tab" data-bs-target="#published" type="button" role="tab" aria-selected="true">Published Links</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link rounded-0 text-dark border" id="rejected-tab" data-bs-toggle="tab" data-bs-target="#rejected" type="button" role="tab" aria-selected="false">Rejected Links</button>
        </li>
    </ul>
    <div class="tab-content border p-3" id="myTabContent">
        <div class="d-flex justify-content-end mb-3">
            <div class="d-flex align-items-center">
                <label class="me-2 small fw-bold">Search:</label>
                <input type="text" class="form-control form-control-sm rounded-0" style="width: 200px;">
            </div>
        </div>

                    <div class="tab-pane fade show active" id="published" role="tabpanel" tabindex="0">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered align-middle small mb-0">
                                <thead>
                                    <tr class="text-nowrap" style="color: #333;">
                                        <th>S.No <i class="bi bi-arrow-down-up text-muted ms-1" style="font-size: 10px;"></i></th>
                                        <th>Link Name (Alias) <i class="bi bi-arrow-down-up text-muted ms-1" style="font-size: 10px;"></i></th>
                                        <th>Created By/On <i class="bi bi-arrow-down-up text-muted ms-1" style="font-size: 10px;"></i></th>
                                        <th>Approved By/On <i class="bi bi-arrow-down-up text-muted ms-1" style="font-size: 10px;"></i></th>
                                        <th>Published By/On <i class="bi bi-arrow-down-up text-muted ms-1" style="font-size: 10px;"></i></th>
                                        <th>Expiry Date <i class="bi bi-arrow-down-up text-muted ms-1" style="font-size: 10px;"></i></th>
                                        <th class="text-center">Preview <i class="bi bi-arrow-down-up text-muted ms-1" style="font-size: 10px;"></i></th>
                                        <th class="text-center">Action <i class="bi bi-arrow-down-up text-muted ms-1" style="font-size: 10px;"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Copyright Policy</td>
                                        <td>CMS Administrator [13/01/2026]</td>
                                        <td>CMS Administrator [January 13, 2026]</td>
                                        <td>CMS Administrator [January 13, 2026]</td>
                                        <td>N/A</td>
                                        <td class="text-center"><i class="bi bi-eye text-dark table-action-icon"></i></td>
                                        <td class="text-nowrap text-center">
                                            <i class="bi bi-display text-dark table-action-icon"></i>
                                            <i class="bi bi-pencil-square text-dark table-action-icon"></i>
                                            <i class="bi bi-trash text-dark table-action-icon"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Test content</td>
                                        <td>CMS Administrator [13/01/2026]</td>
                                        <td>CMS Administrator [January 13, 2026]</td>
                                        <td>CMS Administrator [January 13, 2026]</td>
                                        <td>N/A</td>
                                        <td class="text-center"><i class="bi bi-eye text-dark table-action-icon"></i></td>
                                        <td class="text-nowrap text-center">
                                            <i class="bi bi-display text-dark table-action-icon"></i>
                                            <i class="bi bi-pencil-square text-dark table-action-icon"></i>
                                            <i class="bi bi-trash text-dark table-action-icon"></i>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pending" role="tabpanel" tabindex="0">
                        <p class="text-center text-muted py-4 mb-0">Pending link data will load here.</p>
                    </div>
                    <div class="tab-pane fade" id="rejected" role="tabpanel" tabindex="0">
                        <p class="text-center text-muted py-4 mb-0">Rejected link data will load here.</p>
                    </div>
                </div>
            </div>




<?php
/*
            <h2 class="h5 content-header text-dark">Manage Contents</h2>

            <div class="form-box mb-4">
                <form id="manageContentsForm">
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Choose Language <span class="text-danger">*</span></label>
                        <select class="form-select form-select-sm rounded-0" id="languageSelect">
                            <option value="english">English</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Link Type <span class="text-danger">*</span></label>
                        <select class="form-select form-select-sm rounded-0" id="linkTypeSelect">
                            <option value="">--- Select ---</option>
                            <option value="content">Content</option>
                        </select>
                    </div>

                    <div class="alert alert-danger rounded-0 py-2 d-none d-flex align-items-center" id="validationAlert" role="alert">
                        <i class="bi bi-x-circle me-2"></i> Please enter Valid option!
                        <button type="button" class="btn-close ms-auto" style="font-size: 0.6rem;" aria-label="Close" onclick="document.getElementById('validationAlert').classList.add('d-none')"></button>
                    </div>

                    <div class="text-center">
                        <button type="button" class="btn btn-primary rounded-0 px-4" id="proceedBtn" style="background-color: #337ab7; border-color: #2e6da4;">Proceed</button>
                    </div>
                </form>
            </div>

            <div id="dataTableSection" class="d-none mt-5">
                
                <div class="text-end mb-2">
                    <button type="button" class="btn btn-warning rounded-0 text-white fw-bold px-3 py-1" style="background-color: #f39c12; border-color: #e08e0b;" data-bs-toggle="modal" data-bs-target="#addLinkModal">
                        Add New Link
                    </button>
                </div>

                <ul class="nav nav-tabs border-bottom-0" id="linkTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link rounded-0 text-dark border" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending" type="button" role="tab" aria-selected="false">Pending Links</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active rounded-0 text-dark border border-bottom-0 fw-bold" id="published-tab" data-bs-toggle="tab" data-bs-target="#published" type="button" role="tab" aria-selected="true">Published Links</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link rounded-0 text-dark border" id="rejected-tab" data-bs-toggle="tab" data-bs-target="#rejected" type="button" role="tab" aria-selected="false">Rejected Links</button>
                    </li>
                </ul>

                <div class="tab-content border p-3" id="myTabContent">
                    <div class="d-flex justify-content-end mb-3">
                        <div class="d-flex align-items-center">
                            <label class="me-2 small fw-bold">Search:</label>
                            <input type="text" class="form-control form-control-sm rounded-0" style="width: 200px;">
                        </div>
                    </div>

                    <div class="tab-pane fade show active" id="published" role="tabpanel" tabindex="0">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered align-middle small mb-0">
                                <thead>
                                    <tr class="text-nowrap" style="color: #333;">
                                        <th>S.No <i class="bi bi-arrow-down-up text-muted ms-1" style="font-size: 10px;"></i></th>
                                        <th>Link Name (Alias) <i class="bi bi-arrow-down-up text-muted ms-1" style="font-size: 10px;"></i></th>
                                        <th>Created By/On <i class="bi bi-arrow-down-up text-muted ms-1" style="font-size: 10px;"></i></th>
                                        <th>Approved By/On <i class="bi bi-arrow-down-up text-muted ms-1" style="font-size: 10px;"></i></th>
                                        <th>Published By/On <i class="bi bi-arrow-down-up text-muted ms-1" style="font-size: 10px;"></i></th>
                                        <th>Expiry Date <i class="bi bi-arrow-down-up text-muted ms-1" style="font-size: 10px;"></i></th>
                                        <th class="text-center">Preview <i class="bi bi-arrow-down-up text-muted ms-1" style="font-size: 10px;"></i></th>
                                        <th class="text-center">Action <i class="bi bi-arrow-down-up text-muted ms-1" style="font-size: 10px;"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Copyright Policy</td>
                                        <td>CMS Administrator [13/01/2026]</td>
                                        <td>CMS Administrator [January 13, 2026]</td>
                                        <td>CMS Administrator [January 13, 2026]</td>
                                        <td>N/A</td>
                                        <td class="text-center"><i class="bi bi-eye text-dark table-action-icon"></i></td>
                                        <td class="text-nowrap text-center">
                                            <i class="bi bi-display text-dark table-action-icon"></i>
                                            <i class="bi bi-pencil-square text-dark table-action-icon"></i>
                                            <i class="bi bi-trash text-dark table-action-icon"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Test content</td>
                                        <td>CMS Administrator [13/01/2026]</td>
                                        <td>CMS Administrator [January 13, 2026]</td>
                                        <td>CMS Administrator [January 13, 2026]</td>
                                        <td>N/A</td>
                                        <td class="text-center"><i class="bi bi-eye text-dark table-action-icon"></i></td>
                                        <td class="text-nowrap text-center">
                                            <i class="bi bi-display text-dark table-action-icon"></i>
                                            <i class="bi bi-pencil-square text-dark table-action-icon"></i>
                                            <i class="bi bi-trash text-dark table-action-icon"></i>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pending" role="tabpanel" tabindex="0">
                        <p class="text-center text-muted py-4 mb-0">Pending link data will load here.</p>
                    </div>
                    <div class="tab-pane fade" id="rejected" role="tabpanel" tabindex="0">
                        <p class="text-center text-muted py-4 mb-0">Rejected link data will load here.</p>
                    </div>
                </div>
            </div>


*/?>


          <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
            <div class="box">

                    <?php include('include/chooseLang.inc.php'); ?>
                
                
                <?php
                    if(isset($_REQUEST['preSub']) && $_REQUEST['preSub']==1 && ($frmError ?? '')==false){
                        $ShowGridFlage=true;
                ?>
                
                                
                <div class="box-body clearfix">
                <?php if(empty($_SESSION['department'])){ ?>
                    <div class="text-right" style="margin-bottom: 2px;"><button id="AddNew" cdata-frmT='1' class="btn btn-warning">Add New Link</button></div>
                    <?php } ?>
                    <div class="panel panel-default">                        
                        <ul class="nav nav-tabs" id="myTab">
            			  <li class="active"><a tab-ind='1' data-target="#pending" data-toggle="tab">Pending Links</a></li>
            			  <li><a tab-ind='2' data-target="#publish" data-toggle="tab">Published Links</a></li>
            			  <li><a tab-ind='3' data-target="#rejected" data-toggle="tab">Rejected Links</a></li>                                          			  
            			</ul>                        
            			<div class="tab-content">
            			  <div class="tab-pane active" id="pending">
                                <table id="myTable1" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Link Name (Alias)</th>
                                            <th>Created By/On</th>
                                            <th>Approved By/On</th>
                                            <th>Revive By/On</th>
                                            <th>Revive Details</th>
                                            <th>Preview</th>                                                
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                </table>
                          </div>
            			  <div class="tab-pane" id="publish">
                                <table id="myTable2" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Link Name (Alias)</th>
                                            <th>Created By/On</th>
                                            <th>Approved By/On</th>
                                            <th>Published By/On</th>
                                            <th>Expiry Date</th>
                                            <th>Preview</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                </table>
                          </div>
            			  <div class="tab-pane" id="rejected">
                                <table id="myTable3" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Link Name (Alias)</th>
                                            <th>Created By/On</th>
                                            <th>Rejected By/On</th>
                                            <th>Preview</th>
                                        </tr>
                                    </thead>
                                </table>
                          </div>                			  
            			</div>
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
          <?php include('include/pageFooter.inc.php');?>
          
          <div class="control-sidebar-bg"></div>
        </div>
    </body>
    <script type="text/javascript">        
        //$(document).delegate('#AddNew,.fa-edit,.fa-trash-o,.fa-eye,.fa-eye-slash,.fa-retweet', 'click', function() {
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
                        url      : '<?php echo "links_action.php?per_id=$_SESSION[per_id]&EncHid=$_SESSION[EncTok]";?>&lid='+lid,
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
            else if(frmType=='9'){
                
                var lid=($(this).attr('pub-lid')!=undefined)?$(this).attr('pub-lid'):'';
                $('.modal-container').OpenPop({
                    url:"pub_link.php?frmType=" + frmType + "&lid="+lid+"&link_temp_id=" + $(this).data('link_temp_id') + "&lang_id=<?= $_REQUEST['lang_id'] ?? '';?>&type_id=<?= $_REQUEST['type_id'] ?? '';?>&per_id=<?= $_SESSION['per_id'] . "&EncHid=" . $_SESSION['EncTok']; ?>",
                });
            }
            else{

                var lid=($(this).attr('pub-lid')!=undefined)?$(this).attr('pub-lid'):'';
                $('.modal-container').OpenPop({
                    url:"links.php?frmType=" + frmType + "&lid="+lid+"&link_temp_id=" + $(this).data('link_temp_id') + "&lang_id=<?= $_REQUEST['lang_id'] ?? ''; ?>&nmnh_type_id=<?=  $_REQUEST['nmnh_type_id'] ?? ''; ?>&type_id=<?= $_REQUEST['type_id'] ?? ''; ?>&per_id=<?= $_SESSION['per_id'] . '&EncHid=' . $_SESSION['EncTok']; ?>",
                });
            }
        });
        
        var mGridTable='',mGridTable1='';
        $(function(){   
            if($('#myTab').length>0){
                jQuery('#myTab a:first').tab('show');
                tab='#pending';
                $('a[data-toggle="tab"]').on( 'shown.bs.tab', function (e) {                
                    $.fn.dataTable.tables( {visible: true, api: true} ).columns.adjust();
                    //console.log($(this).data('target'))
                    tab=$(this).data('target');
                } );
                
                $('#myTab a').each(function(i,d)
                {
                    //console.log($(d).attr('tab-ind'))
                    tabID=$(d).attr('tab-ind');
                    //console.log(tabID)
                    tempTable=$('table#myTable'+tabID).DataTable( {
                        "processing": true,
                        "serverSide": false, 
                        "ajax": {
                            "url":"AjaxFill/getLinks.php?<?php echo "EncHid=$_SESSION[EncTok]";?>",
                            "type":"POST",
                            "data":{<?php echo $GLOBALS['csrf']['token'];?>,'tabID':tabID,'lang_id':'<?= $_REQUEST['lang_id'] ?? ''; ?>','type_id':'<?= $_REQUEST['type_id'] ?? '';?>','per_id':'<?= $_REQUEST['per_id'] ?? ''; ?>','nmnh_type':'<?= $_REQUEST['nmnh_type_id'] ?? ''; ?>'}
                            },
                        scrollY:        400,
                        scrollCollapse: true,
                        paging:         false,
                        "drawCallback": function( settings ) {
                            $('[data-toggle="tooltip"]').tooltip();
                            }
                    });
                    
                    if(tabID==1){
                        mGridTable=tempTable;    
                    }
                    if(tabID==2){
                        mGridTable1=tempTable;    
                    }
                })
            }
            
            
            //
            
            /*var mGridTable=$('#GridData').DataTable({                
                'aoColumnDefs': [{'aTargets': [2],'bSortable': false}],
                "processing": true,
                "serverSide": false,
                "ajax": "AjaxFill/getUsers.php?user_type_id=<?= $_REQUEST['user_type_id'] ?? ''; ?>&per_id=<?= $_SESSION['per_id'] ?? '' . "&EncHid=" . $_SESSION['EncTok']; ?>",                
            });*/
            
            $(document).delegate('#reloadGrid', 'click', function ReLoadGrid() 
            {
                alert('here');
                mGridTable.ajax.reload( null, false );
                mGridTable1.ajax.reload( null, false );
            });
            
            $(document).delegate('.Lpreview','click',function(){  
                if($('#type_id').val()==3){
                    $('.modal-container').OpenPop({
                        url:"link_preview.php?link_temp_id=" + $(this).data('link_temp_id') + "&lang_id=<?= $_REQUEST['lang_id'] ?? ''; ?>&type_id=<?= $_REQUEST['type_id'] ?? '';?>&per_id=<?php echo "$_SESSION[per_id]&EncHid=$_SESSION[EncTok]";?>",
                    });
                }
                else{
                    window.open("link_preview.php?link_temp_id=" + $(this).data('link_temp_id') + "&lang_id=<?= $_REQUEST['lang_id'] ?? '';?>&type_id=<?= $_REQUEST['type_id'] ?? '';?>&per_id=<?php echo "$_SESSION[per_id]&EncHid=$_SESSION[EncTok]";?>",'_blank');                                        
                }                
            })
        })
         
    
    </script>


<!-- CALLING TINYMCE RTF CONFIG FILE END --->
<script src='../tinymce/tinymce/tinymce.min.js'></script>
 <script src="rtf/rtfConf.js"></script>