<?php include '../appcode/globals.inc.php';
include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');
userAuthenticationPageLevel();
userAuthenticationMainLevel();
include_once('include/pageHeader.inc.php');

?>
   
            <?php include('include/top_user_info.inc.php');?>  
          <!-- Left side column. contains the logo and sidebar -->

       
        
          <!-- Content Wrapper. Contains page content -->
          <div class="content-wrapper">
            <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Manage Continuous Contents Position</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <form name="frm" id="frm" action="<?php echo curPageName()."?EncHid=$_SESSION[EncTok]"?>" role="form" class="form-border clearfix col-sm-6 col-sm-offset-3" method="post">
                        <input type="hidden" name="preSub" id="preSub" value="1" />     
                        <input type="hidden" name="per_id" id="per_id" value="<?php echo $_REQUEST['per_id']?>" />                                         
                        
                        <div class="form-group">
                          <label for="lang_id">Choose Language</label>
                          <select name="lang_id" id="lang_id" class="form-control" data-validate="lang_id|text|y|1|10|num|dontselect=-1|Please enter Valid option!">                            
                            <?php                            
                            $rs1=fetchtable("web_lang","status='Active'");
                            if($rs1[0]>0){
                                foreach($rs1[1] as $row1){
                                    if($_REQUEST['lang_id']==$row1['lang_id'])
                                        echo "<option value='$row1[lang_id]' selected=''>$row1[lang]</option>";
                                    else
                                        echo "<option value='$row1[lang_id]'>$row1[lang]</option>";
                                }
                            }
                            ?>
                          </select>
                        </div>
                        
                        <div class="form-group">
                          <label for="lid">Link Name</label>
                          <select name="lid" id="lid" class="form-control" data-validate="lid|text|y|1|10|num|dontselect=-1|Please enter Valid option!">
                            <option value="-1">--- Select ---</option>
                            <?php
                            if(isset($_REQUEST['lang_id']))
                            {
                                $rs1=simplefetch("select lf.lid,wlt.link_name from web_links_final lf
INNER JOIN web_link_temp wlt on wlt.link_temp_id=lf.link_temp_id
INNER JOIN (SELECT wlt1.link_temp_id,wlt1.lid,wlt1.main_link_temp_id from web_link_temp wlt1 
                where wlt1.`status`='Active' and wlt1.type_id=3 and wlt1.continuous_content=1 and wlt1.lang_id=$_REQUEST[lang_id] and wlt1.app_reject=1 and wlt1.publish_by is not null group by main_link_temp_id) wlc on wlc.main_link_temp_id=lf.lid 
where wlt.`status`='Active' and wlt.type_id=3 and wlt.lang_id=$_REQUEST[lang_id] ORDER BY wlt.link_name");

                                if($rs1[0]>0){
                                    
                                    foreach($rs1[1] as $row1){
                                        if($_REQUEST['lid']==$row1['lid'])
                                            echo "<option value='$row1[lid]' selected=''>".html_entity_decode($row1['link_name'])."</option>";
                                        else
                                            echo "<option value='$row1[lid]'>".html_entity_decode($row1['link_name'])."</option>";
                                    }
                                }
                            }
                            ?>
                          </select>
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
                    <div class="panel-heading box-title">Continious Content</div>
                        <div class="panel-body">
                             <form class="clearfix" name="frmmain" id="frmmain" method="post" action="cont_pos_action.php">
                                <input type="hidden" name="per_id" id="per_id" value="<?php echo $_REQUEST['per_id']?>" />
                                <input type="hidden" name="EncHid" id="EncHid" value="<?php echo $_SESSION['EncTok']?>" />
                                    <input type="hidden" name="mStr" id="mStr" value="" />
                                    <input type="hidden" name="lid" id="lid" value="<?php echo $_REQUEST['lid'];?>" />
                                     <div class="col-sm-8 col-sm-offset-2">                                             
                                      <table id="GridData" class="table table-bordered table-striped table-hover">
                                        <thead>
                                        <tr>
                                          <th>S.No</th>
                                          <th>Page No</th>
                                          <th>Preview</th>
                                          <th>Position</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                      </table>
                                      <div class="col-sm-8 col-sm-offset-4">
                                      <input type="button" name="submit" id="submit" class="btn btn-primary" value="Update" />
                                      </div>                      
                                  </div>
                           </form> 
                      </div>
                    </div>
                    <div id="ShowMsg"></div>
                </div>
                <?php
                }
                ?>                
                <!-- /.box-body -->
              </div>                    
          </div>
          <!-- /.content-wrapper -->
          
          
    <script type="text/javascript">
        
        function GetContLink(){
            $.fn.FillData({url:'AjaxFill/GetContLink.php',Fill_To:'lid',Arr:{'lang_id':$('#lang_id').val(),'h_cont':'2'}});
        }
        
        var mGridTable='';
        $(function(){
            $('#lang_id').change(function(){
                GetContLink();
            })
            
            <?php
            if(!isset($_REQUEST['lid'])){
            ?>
            GetContLink();
            <?php
            }
            ?>
        }); 
                  
        


                    GetContLink();


    ////    var sortedIDs=$('#GridData tbody').sortable();
        $('#submit').click(function()
        {            
            // var sortedIDs = $( "#GridData tbody" ).sortable( "toArray" );
            // $('#mStr').val(sortedIDs);        
            $.base64.utf8encode = true;
            $.ajax({
                type     : "POST",
                dataType: "text",
                cache    : false,
                url      : $('#frmmain').attr('action'),
                data     : $('#frmmain').serialize(),
                beforeSend: function(){
                    $.fn.ajaxLoading();
                },        
                success  : function(data) {                                    
                    try{
                        data=$.parseJSON($.base64.atob(data));            
                        if(data[0]){            
                            $('#ShowMsg').ShowMsg({msg:'Request Completed Successfully!',alertClass:'alert-success'});
                            GetGrid($('form[id=frmmain] #lid').val());                                        
                        }
                        else{                    
                            if(data[1]!= undefined && data[1][0]==true){
                                FEror=data[1][1];                    
                                $.fn.ShowError(FEror);    
                            }
                            else if(data[2]!= undefined && data[2][0]==true){
                                MEror=data[2][1];                                
                                $('#ShowMsg').ShowMsg({msg:MEror,alertClass:data[2][2]});
                            }
                            else{                                          
                                $('#ShowMsg').ShowMsg({msg:'Request not Completed Successfully!',alertClass:'alert-danger'});                        
                            }
                        }
                    }
                    catch(err) {
                        $('#ShowMsg').ShowMsg({msg:"<strong>Error:</strong> Unexpected Response received, You may try again!", alertClass:'alert-warning'});                                
                    }
                                           
                },
                error:function(){
                    
                    $('#ShowMsg').ShowMsg({msg:"<strong>Error:</strong> Something went wrong, Please try again!",alertClass:'alert-warning'});  
                },
                complete: function(){            
                    $.fn.ajaxLoading({show:false});
                },
            });
        })
        
        function GetGrid(lid)
        {
            $('#GridData tbody').loadGrid({pageName:"AjaxFill/getPosContContent.php?lid="+lid+"&per_id=<?php echo "$_REQUEST[per_id]&lang_id=$_REQUEST[lang_id]&EncHid=$_SESSION[EncTok]";?>"});
        }
        
        /*
        $(function(){            
            $('#frm').formChecks().SetToFirstFocus();
            //GetGrid();            
            <?php
            if(isset($_REQUEST['lid'])){
            ?>
            GetGrid(<?php echo $_REQUEST['lid'];?>);
            <?php
            }
            ?>
            
            $(document).delegate('.Lpreview','click',function(){
                $('.modal-container').OpenPop({
                    url:"link_preview.php?link_temp_id=" + $(this).data('link_temp_id') + "&lang_id=<?php echo "$_REQUEST[lang_id]";?>&type_id=3&per_id=<?php echo "$_SESSION[per_id]&EncHid=$_SESSION[EncTok]";?>",
                });
            })
        })
        */
         


        
    </script>

    <?php include('include/pageFooter.inc.php');?>