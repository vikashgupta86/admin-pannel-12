<?php include '../appcode/globals.inc.php';
include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');
$obj->userAuthenticationPageLevel();
$obj->userAuthenticationMainLevel();
include_once('include/pageHeader.inc.php');
?>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <?php include('include/top_user_info.inc.php');?>  
          <!-- Left side column. contains the logo and sidebar -->









            <h2 class="h5 border-bottom pb-2 mb-4 text-dark" style="font-weight: 400;">View Feedback</h2>

            <div class="form-box">
                <form id="feedbackForm">
                    <div class="mb-3 d-flex align-items-center">
                        <label class="form-label me-3 mb-0">Feedback Type <span class="text-danger">*</span></label>
                        <div class="form-check form-check-inline mb-0">
                            <input class="form-check-input" type="radio" name="feedbackType" id="typeBoth" value="both" checked>
                            <label class="form-check-label small" for="typeBoth">Both</label>
                        </div>
                        <div class="form-check form-check-inline mb-0">
                            <input class="form-check-input" type="radio" name="feedbackType" id="typeGeneral" value="general">
                            <label class="form-check-label small" for="typeGeneral">General</label>
                        </div>
                        <div class="form-check form-check-inline mb-0">
                            <input class="form-check-input" type="radio" name="feedbackType" id="typeContent" value="content">
                            <label class="form-check-label small" for="typeContent">Content</label>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label class="form-label">From Date:</label>
                            <input type="date" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">To Date:</label>
                            <input type="date" class="form-control" required>
                        </div>
                    </div>
                    
                    <div class="text-center">
                        <button type="button" id="proceedBtn" class="btn btn-primary rounded-0 px-4 fw-bold" style="background-color: #337ab7; border-color: #2e6da4;">Proceed</button>
                    </div>
                </form>
            </div>

            <div id="dataTableSection" class="d-none mt-4">
                
                <ul class="nav nav-tabs border-bottom-0" id="feedbackTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active rounded-0 text-dark border border-bottom-0 fw-bold" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" type="button" role="tab">General Feedback</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link rounded-0 text-dark border" id="content-tab" data-bs-toggle="tab" data-bs-target="#content" type="button" role="tab">Content Feedback</button>
                    </li>
                </ul>

                <div class="tab-content border p-3" id="myTabContent">
                    <div class="d-flex justify-content-end mb-3">
                        <div class="d-flex align-items-center">
                            <label class="me-2 small fw-bold">Search:</label>
                            <input type="text" class="form-control form-control-sm rounded-0" style="width: 200px;">
                        </div>
                    </div>

                    <div class="tab-pane fade show active" id="general" role="tabpanel">
                        <div class="table-responsive border">
                            <table class="table table-striped table-bordered align-middle small mb-0">
                                <thead>
                                    <tr class="text-nowrap" style="color: #333;">
                                        <th style="width: 5%;">S.No <i class="bi bi-arrow-down-up text-muted ms-1" style="font-size: 10px;"></i></th>
                                        <th style="width: 15%;">Sender Name <i class="bi bi-arrow-down-up text-muted ms-1" style="font-size: 10px;"></i></th>
                                        <th style="width: 15%;">Sender Email <i class="bi bi-arrow-down-up text-muted ms-1" style="font-size: 10px;"></i></th>
                                        <th style="width: 15%;">Sender Mobile <i class="bi bi-arrow-down-up text-muted ms-1" style="font-size: 10px;"></i></th>
                                        <th style="width: 20%;">Feedback/ Query<br><small class="text-muted">(Received On)</small> <i class="bi bi-arrow-down-up text-muted ms-1" style="font-size: 10px;"></i></th>
                                        <th style="width: 15%;">Reply (Yes/ No)<br><small class="text-muted">(Replied On)</small> <i class="bi bi-arrow-down-up text-muted ms-1" style="font-size: 10px;"></i></th>
                                        <th style="width: 10%;">Reply Details <i class="bi bi-arrow-down-up text-muted ms-1" style="font-size: 10px;"></i></th>
                                        <th style="width: 5%;" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="8" class="text-center py-4">Loading...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <div class="tab-pane fade" id="content" role="tabpanel">
                        <p class="text-center text-muted py-4 mb-0">Content feedback data will load here.</p>
                    </div>
                </div>
            </div>


























          
          














        
          <!-- Content Wrapper. Contains page content -->
          <div class="content-wrapper">
            <div class="box">
                <div class="box-header">
                  <h3 class="box-title">View Feedback</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <form name="frm" id="frm" action="<?php echo $obj->curPageName()."?EncHid=$_SESSION[EncTok]"?>" role="form" class="form-border clearfix col-sm-6 col-sm-offset-3" method="post" autocomplete="off">
                        <input type="hidden" name="preSub" id="preSub" value="1" />     
                        <input type="hidden" name="per_id" id="per_id" value="<?php echo $_REQUEST['per_id']?>" />
                                                
                        <div class="form-group">
                            <ul class="list-inline">
                                <li><label for="f_type">Feedback Type</label></li>
                                <li class="checkbox">
                                    <input type="radio" name="f_type" id="f_type3" value="3" checked="" /> Both
                                    <input type="radio" name="f_type" id="f_type1" value="1" <?php echo $_REQUEST['f_type']==1?'checked=""':'';?>/> General
                                    <input type="radio" name="f_type" id="f_type2" value="2" <?php echo $_REQUEST['f_type']==2?'checked=""':'';?> data-validate="f_type|checkbox|y|1|2|selmin=1|Please Select atleast One option!"/> Content
                                </li>
                            </ul>
                        </div>
                        
                        <div class="row">
                            <div class="form-group col-md-6">
                              <label for="f_date">From Date:</label>
                              <div class="input-group">
                                <input type="text" class="form-control CallDate" name="f_date" id="f_date" placeholder="DD/MM/YYYY" value="<?php echo $_REQUEST['f_date'];?>" data-validate="link_nrevDate|text|n|10|10|dt|Please enter/ select Valid Date!"/>
                                <span class="input-group-addon CopyIcon CallDate1" data-for='f_date'><span class="glyphicon glyphicon-calendar"></span></span>
                              </div>
                            </div>
                            
                            <div class="form-group col-md-6">
                              <label for="t_date">To Date:</label>
                              <div class="input-group">
                                <input type="text" class="form-control CallDate" name="t_date" id="t_date" placeholder="DD/MM/YYYY" value="<?php echo $_REQUEST['t_date'];?>" data-validate="link_nrevDate|text|n|10|10|dt|Please enter/ select Valid Date!"/>
                                <span class="input-group-addon CopyIcon CallDate1" data-for='t_date'><span class="glyphicon glyphicon-calendar"></span></span>
                              </div>
                            </div>
                        </div>
                        
                        <div class="col-sm-8 col-sm-offset-4">
                            <button type="submit" class="btn btn-primary">Proceed</button>
                          </div>
                    </form>
                </div>
                
                
                
                <?php
                if(isset($_REQUEST['preSub']) && $_REQUEST['preSub']==1 && $frmError==false){
                    $ShowGridFlage=true;
                ?>
                
                                
                <div class="box-body clearfix">                    
                    <div class="panel panel-default">                        
                        <ul class="nav nav-tabs" id="myTab">
                          <?php
                          $genFlage=$contFlage=false;
                          if(isset($_REQUEST['f_type']) && in_array($_REQUEST['f_type'],array(1,3))){
                            $genFlage=true;
                          ?>  
            			  <li class="active CopyIcon"><a tab-ind='1' data-target="#general" data-toggle="tab">General Feedback</a></li>
                          <?php
                          }
                          
                          if(isset($_REQUEST['f_type']) && in_array($_REQUEST['f_type'],array(2,3))){
                            $contFlage=true;
                          ?>
            			  <li class="CopyIcon"><a tab-ind='2' data-target="#content" data-toggle="tab">Content Feedback</a></li>
                          <?php
                          }
                          ?>            			                                            			  
            			</ul>   
                        
                        <?php
                        if($genFlage){
                        ?>                     
            			<div class="tab-content">
            			  <div class="tab-pane active" id="general">
                                <table id="myTable1" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Sender Name</th>
                                            <th>Sender Email</th>
                                            <th>Feedback/ Query<br />(Received On)</th>
                                            <th>Reply (Yes/ No)<br />(Replied On)</th>
                                            <th>Reply Details</th>                                                
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                </table>
                          </div>                          
                          <?php
                          }
                          
                          if($contFlage){
                          ?>
            			  <div class="tab-pane" id="content">
                                <table id="myTable2" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Link Name</th>
                                            <th>Sender Name</th>
                                            <th>Sender email</th>
                                            <th>Feedback/ Query<br />(Received On)</th>
                                            <th>Reply (Yes/ No)<br />(Replied On)</th>
                                            <th>Reply Details</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                </table>
                          </div>         
                          <?php
                          }
                          ?>      			  
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
        $(document).delegate('.fa-reply', 'click', function() {
            var frmType=$(this).attr('cdata-frmT');
            //console.log(frmType);            
            if($.inArray(frmType,['3','4','5','6'])!='-1'){
                var con=confirm('Do you really want to Proceed?');
                //console.log(con)
                
                if(con){                        
                    $.base64.utf8encode = true;
                    $.ajax({
                        type     : "POST",
                        dataType: "text",
                        cache    : false,
                        url      : '<?php #echo "links_action.php?per_id=$_SESSION[per_id]&amp;EncHid=$_SESSION[EncTok]";?>',
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
                    url:"feed_reply.php?frmType=" + frmType + "&feed_id=" + $(this).data('feed_id') + "&per_id=<?php echo "$_SESSION[per_id]&EncHid=$_SESSION[EncTok]";?>",
                });
            }
        });

        $(document).delegate('.fa-map-o', 'click', function() {
            $('.modal-container').OpenPop({
                url:"feed_details.php?" +"feed_id=" + $(this).data('feed_id') + "&per_id=<?php echo "$_SESSION[per_id]&EncHid=$_SESSION[EncTok]";?>",
            });
        })
        
        var mGridTable='';
        $(function(){
            $('#frm').formChecks().SetToFirstFocus();
            $('.CallDate1').click(function(){
                $(this).siblings('.CallDate').trigger('focus');                    
            })
            $('.CallDate').datepicker({
                    autoclose:true,
                    todayHighlight:true,            
                    format:'dd/mm/yyyy',                    
                }        
            );
            
            if($('#myTab').length>0){
                jQuery('#myTab a:first').tab('show');
                tab='#pending';
                $('a[data-toggle="tab"]').on( 'shown.bs.tab', function (e) {                
                    $.fn.dataTable.tables( {visible: true, api: true} ).columns.adjust();
                    //console.log($(this).data('target'))
                    tab=$(this).data('target');
                } );

                
                $('#myTab a').each(function(i,d){
                    //console.log($(d).attr('tab-ind'))
                    tabID=$(d).attr('tab-ind');
                    //console.log(tabID)

                    tempTable=$('table#myTable'+tabID).DataTable( {
                        "processing": true,
                        "serverSide": false,
                        "ajax": {
                            "url":"AjaxFill/getFeedback.php?<?php echo "EncHid=$_SESSION[EncTok]";?>",
                            "type":"POST",
                            "data":{<?php echo $GLOBALS['csrf']['token'];?>,'tabID':tabID,'f_date':'<?php echo "$_REQUEST[f_date]";?>','t_date':'<?php echo "$_REQUEST[t_date]";?>','per_id':'<?php echo "$_REQUEST[per_id]";?>'}
                            },
                        scrollY:        400,
                        scrollCollapse: true,
                        paging:         false
                    } );
                    
                    if(tabID==1){
                        mGridTable=tempTable;    
                    }
                })
            }
            
            $(document).delegate('#reloadGrid', 'click', function ReLoadGrid() {
                mGridTable.ajax.reload( null, false );
            });
        })
         
    </script>
<!-- CALLING TINYMCE RTF CONFIG FILE  --->
<!-- <script src="rtf/js/tinymce/tinymce.dev.js"></script>
<script src="rtf/js/tinymce/plugins/table/plugin.dev.js"></script>
<script src="rtf/js/tinymce/plugins/paste/plugin.dev.js"></script>
<script src="rtf/js/tinymce/plugins/spellchecker/plugin.dev.js"></script>
<script src="rtf/rtfConf_WU.js"></script> -->
<script src='../node_modules/tinymce/tinymce.min.js'></script>
<script src="rtf/rtfConf.js"></script>
<!-- CALLING TINYMCE RTF CONFIG FILE END --->