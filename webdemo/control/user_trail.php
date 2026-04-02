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
          <div class="content-wrapper">
            <div class="box">
                <div class="box-header">
                  <h3 class="box-title">View User Trail</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <form name="frm" id="frm" action="<?php echo curPageName()."?EncHid=$_SESSION[EncTok]"?>" role="form" class="form-border clearfix col-sm-6 col-sm-offset-3" method="post" autocomplete="off">
                        <input type="hidden" name="preSub" id="preSub" value="1" />     
                        <input type="hidden" name="per_id" id="per_id" value="<?php echo $_REQUEST['per_id']?>" />
                                                
                        <div class="form-group">
                            <ul class="list-inline">
                                <li><label for="t_type">Trail Type</label></li>
                                <li class="checkbox">
                                    <input type="radio" name="t_type" id="t_type1" value="1" checked="" /> Login Attempts
                                    <input type="radio" name="t_type" id="t_type2" value="2" <?php echo ($_REQUEST['t_type'] ?? '')==2?'checked=""':'';?>/> Unsuccessful Attempts
                                    <input type="radio" name="t_type" id="t_type3" value="3" <?php echo ($_REQUEST['t_type'] ?? '')==3?'checked=""':'';?> data-validate="t_type|checkbox|y|1|2|selmin=1|Please Select atleast One option!"/> Usertrail
                                </li>
                            </ul>
                        </div>
                        
                        <div class="row">
                            <div class="form-group col-md-6">
                              <label for="f_date">From Date:</label>
                              <div class="input-group">
                                <input type="date" class="form-control CallDate" name="f_date" id="f_date" placeholder="DD/MM/YYYY" value="<?php echo ($_REQUEST['f_date'] ?? '');?>" data-validate="link_nrevDate|text|y|10|10|dt|Please enter/ select Valid Date!"/>
                                <span class="input-group-addon CopyIcon CallDate1" data-for='f_date'><span class="glyphicon glyphicon-calendar"></span></span>
                              </div>
                            </div>
                            
                            <div class="form-group col-md-6">
                              <label for="t_date">To Date:</label>
                              <div class="input-group">
                                <input type="date" class="form-control CallDate" name="t_date" id="t_date" placeholder="DD/MM/YYYY" value="<?php echo ($_REQUEST['t_date'] ?? '');?>" data-validate="link_nrevDate|text|y|10|10|dt|Please enter/ select Valid Date!"/>
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
                if(isset($_REQUEST['preSub']) && $_REQUEST['preSub']==1 && ($frmError ?? '') == false){
                    $ShowGridFlage=true;
                ?>
                
                                
                <div class="box-body clearfix">                    
                    <div class="panel panel-default">                        
                        <ul class="nav nav-tabs border-bottom-0" id="myTab" role="tablist">
                          <?php
                          $lAttempt=$uAttempt=$uTrail=false;
                          if(isset($_REQUEST['t_type']) && in_array($_REQUEST['t_type'],array(1))){
                            $lAttempt=true;
                          ?>  
            			  <li class="active CopyIcon"><a tab-ind='1' data-target="#l_attempt" data-toggle="tab">Login Attempts</a></li>
                          <?php
                          }
                          
                          if(isset($_REQUEST['t_type']) && in_array($_REQUEST['t_type'],array(2))){
                            $uAttempt=true;
                          ?>
            			  <li class="CopyIcon"><a tab-ind='2' data-target="#u_attempt" data-toggle="tab">Unsuccessful Attempts</a></li>
                          <?php
                          }
                          
                          if(isset($_REQUEST['t_type']) && in_array($_REQUEST['t_type'],array(3))){
                            $uTrail=true;
                          ?>
            			  <li class="CopyIcon"><a tab-ind='3' data-target="#u_trail" data-toggle="tab">User Trail</a></li>
                          <?php
                          }
                          ?>            			                                            			  
            			</ul>   
                        
                        <?php
                        if($lAttempt){
                        ?>                     
            			<div class="tab-content">
            			  <div class="tab-pane active" id="l_attempt">
                                <table id="myTable1" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>User Name<br />(Login-ID)</th>
                                            <th>Login On</th>
                                            <th>Logoff On</th>
                                            <th>Internet Protocol</th>
                                            <!--<th>System ip </th>-->
                                            <th>Browser Used</th>
                                       </tr>
                                    </thead>
                                </table>
                          </div>                          
                          <?php
                          }
                          
                          if($uAttempt){
                          ?>
            			  <div class="tab-pane" id="u_attempt">
                                <table id="myTable2" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>User Name<br />(Login-ID)</th>
                                            <th>Login Attempt On</th>                                            
                                            <th>Internet Protocol</th>
                                            <!--<th>System ip </th>-->
                                            <th>Browser Used</th>
                                        </tr>
                                    </thead>
                                </table>
                          </div>         
                          <?php
                          }
                          if($uTrail){
                          ?>
            			  <div class="tab-pane" id="u_trail">
                                <table id="myTable3" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>User Name<br />(Login-ID)</th>                                            
                                            <th>Table Name</th>
                                            <th>Action</th>
                                            <th>Action On</th>                                            
                                            <th>Internet Protocol</th>
                                            <!--<th>System ip </th>-->
                                            <th>Browser Used</th>
                                        </tr>
                                    </thead>
                                </table>
                          </div>         
                          <?php
                          }
                          ?>      			  
            			</div>
                    <div id="ShowMsg1"></div>                    
                    <div id="reloadGrid"></div>
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

    <script <?= $nonce; ?>  type="text/javascript">        
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
                        url      : '<?php echo "links_action.php?per_id=$_SESSION[per_id]&amp;EncHid=$_SESSION[EncTok]";?>',
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
        
        var mGridTable='';
        $(function(){
            $('#frm').formChecks().SetToFirstFocus();
            $('.CallDate1').click(function(){
                $(this).siblings('.CallDate').trigger('focus');                    
            })
            // $('.CallDate').datepicker({
            //         autoclose:true,
            //         todayHighlight:true,            
            //         format:'dd/mm/yyyy',                    
            //     }        
            // );
            
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
                            "url":"AjaxFill/getUserTrail.php?<?php echo "EncHid=$_SESSION[EncTok]";?>",
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