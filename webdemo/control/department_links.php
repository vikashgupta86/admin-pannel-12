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
          <?php include('include/left_nav.inc.php');?>
        
          <!-- Content Wrapper. Contains page content -->
          <div class="content-wrapper">
            <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Manage Department Line</h3>
                </div>
                <!-- /.box-header -->                
                
                <div class="box-body">
                   <div class="box-body">
                   
            			<form name="formNC" id="formNC" method="post" autocomplete="off" role="form" class="form-border clearfix col-sm-6 col-sm-offset-3" action="<?php echo "dep_links_action.php?per_id=$_SESSION[per_id]&amp;EncHid=$_SESSION[EncTok]";?>" enctype="multipart/form-data" >
                        <input type="hidden" name="depmap" id="depmap" value="1" /> 
                        <input type="hidden" name="frmType" id="frmType" value="1" />    
                        <input type="hidden" name="per_id" id="per_id" value="<?php echo $_REQUEST['per_id']?>" />                                         
                         <div class="form-group">
                          <label for="dep_id">Department</label>
                          <select name="dep_id" id="dep_id" class="form-control" data-validate="dep_id|text|y|1|10|num|dontselect=-1|Please enter Valid option!">                            
                           <option value="-1">--- Select ---</option>
                            <?php 

                            $rs1=$obj->fetchtable("department","status='Active' order by dept_name");
                            if($rs1[0]>0){
                                foreach($rs1[1] as $row1){
                                    if($_REQUEST['dep_id']==$row1['id'])
                                        echo "<option value='$row1[id]' selected=''>$row1[dept_name]</option>";
                                    else
                                        echo "<option value='$row1[id]'>$row1[dept_name]</option>";
                                }
                            }
                            ?>
                          </select>
                        </div>
						
						<div class="form-group">
                          <label for="dep_user_id">Department Users</label>
                          <select name="dep_user_id" id="dep_user_id" class="form-control" data-validate="dep_user_id|text|y|1|10|num|dontselect=-1|Please enter Valid option!">                            
                           <option value="-1">--- Select ---</option>
                            <?php 

                            /*$rs1=$obj->fetchtable("web_users","status='Active' and department= order by uname");
                            if($rs1[0]>0){
                                foreach($rs1[1] as $row1){
                                    if($_REQUEST['dep_user_id']==$row1['id'])
                                        echo "<option value='$row1[id]' selected=''>$row1[uname]</option>";
                                    else
                                        echo "<option value='$row1[id]'>$row1[uname]</option>";
                                }
                            }*/
                            ?>
                          </select>
                        </div>
						
						
                        <div class="form-group">
                          <label for="lang_id">Choose Language</label>
                          <select name="lang_id" id="lang_id" class="form-control" data-validate="lang_id|text|y|1|10|num|dontselect=-1|Please enter Valid option!">                            
                            <option value="-1">--- Select ---</option>
							<?php                            
                            $rs1=$obj->fetchtable("web_lang","status='Active'");
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
                        
                        <div class="form-group" id="linkTypeBlock">
                          <label for="type_id">Link Type</label>
                          <select name="type_id" id="type_id" class="form-control" data-validate="type_id|text|y|1|10|num|dontselect=-1|Please enter Valid option!">
                            <option value="-1">--- Select ---</option>
                            <?php                            
                            $rs1=$obj->fetchtable("web_link_type","status='Active' and type_id != 2 order by type");
                            if($rs1[0]>0){
                                foreach($rs1[1] as $row1){
                                    if($_REQUEST['type_id']==$row1['type_id'])
                                        echo "<option value='$row1[type_id]' selected=''>$row1[type]</option>";
                                    else
                                        echo "<option value='$row1[type_id]'>$row1[type]</option>";
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
                            if(isset($_REQUEST['type_id'])){
								
								$rs1=$obj->simplefetch("select lf.lid,ifnull(date_format(lf.expiry_date,'%M %d, %Y'),'N/A')as expiry_date,lf.expiry_time,wlt.link_temp_id,wlt.lang_id,wlt.type_id,concat(wlt.link_name, ifnull(concat(' (', wlt.link_alias, ')'),'')) as link_name,concat(wu.user_name,' [',date_format(wlt.creation_date,'%d/%m/%Y'),' ]')as cName
								,concat(ru.user_name,' [',date_format(wlt.app_rej_action_on,'%M %d, %Y'),' ]')as rName,concat(pu.user_name,' [',date_format(lf.publish_date,'%M %d, %Y'),' ]')as pName from web_link_temp wlt
								INNER JOIN web_users wu on wu.user_id=wlt.creator_id
								INNER JOIN web_users ru on ru.user_id=wlt.app_rej_user_id
								INNER JOIN web_links_final lf on lf.link_temp_id=wlt.link_temp_id
								INNER JOIN web_users pu on pu.user_id=lf.publish_by
								where wlt.`status`='Active' and lf.status='Active' and wlt.lang_id=$_REQUEST[lang_id] and wlt.continuous_content=0 and wlt.type_id=$_REQUEST[type_id] $usr_session order by wlt.link_temp_id DESC $LimitQry",1);

								
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
                        <div class="clearfix"></div>       
                        <div class="col-sm-8 col-sm-offset-4">
                            <button type="submit" class="btn btn-primary">Add New Link</button>
                          </div>
                    </form>
                </div>
                <div class="clearfix"></div>
                <div id="ShowMsg"></div>
                </div>
                    <!--<div class="text-right" style="margin-bottom: 2px;"><button id="AddNew" cdata-frmT='1' class="btn btn-warning">Add New</button></div>-->
                    
                    <div class="panel panel-default">
                        <table id="myTable1" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Link Name</th>

                                    <th>Last Modified Date</th>
                                   <!--<th>Preview</th>-->
                                    <th class="text-center">Action</th>
                                </tr>
                               
                            </thead>
                        </table>
                    </div>
                    <div id="ShowMsg1"></div>                    
                    <div id="reloadGrid"></div>
                </div>                                
                <!-- /.box-body -->
              
              </div>                    
          </div>
          
          <!-- /.content-wrapper -->
          <?php include('include/pageFooter.inc.php');?>
          
          <div class="control-sidebar-bg"></div>
        </div>
    </body>
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
                        url      : '<?php echo "dep_links_action.php?per_id=$_SESSION[per_id]&EncHid=$_SESSION[EncTok]";?>&lid='+lid,
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
	 });
	
        
       $('#type_id').change(function(){
	    //alert($('#dep_id').val());
		
            var mGridTable=$('#myTable1').DataTable( {
						"bDestroy": true,
						"bJQueryUI": true,
                        "processing": true,
                        "serverSide": false,
                        "ajax": {
                            "url":"AjaxFill/getdept_data.php?<?php echo "EncHid=$_SESSION[EncTok]";?>",
                            "type":"POST",
							"data":{'lang_id':$('#lang_id').val(),'lid':$('#lid').val(),'type_id':$('#type_id').val(),'dep_id':$('#dep_id').val(),'dep_user_id':$('#dep_user_id').val()}
							
                            },
                        scrollY:        400,
                        scrollCollapse: true,
                        paging:         false
                    } );
            
            
            $(document).delegate('#reloadGrid', 'click', function ReLoadGrid() {
                mGridTable.ajax.reload( null, false );
				
            });
			
			
      })
	  
		
        $(function(){
            $('#frm').formChecks().SetToFirstFocus();                                   
            <?php
            if($secFrmFlage==true){
            ?>
            $('#frmmain').formChecks({ajaxSubFunc:subFrm}).SetToFirstFocus();            
            <?php
            }
            ?>
            
            function GetContLink(){
                $.fn.FillData({url:'AjaxFill/DepContLink.php',Fill_To:'lid',Arr:{'type_id':$('#type_id').val(),'lang_id':$('#lang_id').val()}});
            }
            $('#type_id').change(function(){
                GetContLink();
				
            })
			
			
			$('#dep_id').change(function(){
                $.fn.FillData({url:'AjaxFill/DeptUser.php',Fill_To:'dep_user_id',Arr:{'dep_id':$('#dep_id').val()}});
				
            })
			
            
            <?php
            if(!isset($_REQUEST['lid'])){
            ?>
            GetContLink();
            <?php
            }
            ?>
            
            $('#chk').click(function(){
                $.fn.CheckAll({chkName:'chk[]',ckFlage:$(this).is(':checked')})
            })
        })
    function CallfrCk(){
        $('#formNC').formChecks({nonASCII:true,ajaxSubFunc:frmAction}).SetToFirstFocus();
    }
    CallfrCk();
		
		
 function frmAction(){

    $.base64.utf8encode = true;
    
    var formData = new FormData();
    //formData.append('name', $('#formNC').serialize());
   //formData.append('l_file', $('#l_file')[0].files[0]);
    
    var other_data = $('#formNC').serializeArray();
    $.each(other_data,function(key,input){   
    	//managing the RTF content start 	
    	let DomStr = input.value.match(/<body[^>]*>[\s\S]*<\/body>/gi);
    	DomStr = DomStr==null?input.value:$('<div />').text(DomStr).html();    	
    	//RTF END
    	
    	formData.append(input.name, DomStr);
    });
    
    $.ajax({
        type     : "POST",
        dataType: "text",
        cache    : false,        
        enctype: 'multipart/form-data',
        url      : $('#formNC').attr('action'),
        data     : formData,        
        processData: false,
        contentType: false,
        
        beforeSend: function(){
            $.fn.ajaxLoading();
        },        
        success  : function(data) {                                    
            try{
                data=$.parseJSON($.base64.atob(data));            
                if(data[0]){               
                    
                        ($('#frmType').val()==1)?$('#formNC')[0].reset():'';                    
                        $('#ShowMsg').ShowMsg({msg:'Request Completed Successfully!',colwidth:'col-md-8',coloffset:'col-md-offset-2',alertClass:'alert-success'});
                   
                        
                        
                    $('#reloadGrid').trigger('click');
                                                            
                }
                else{                    
                    if(data[1]!= undefined && data[1][0]==true){
                        FEror=data[1][1];                    
                        $.fn.ShowError(FEror);    
                    }
                    else if(data[2]!= undefined && data[2][0]==true){
                        MEror=data[2][1];
                        
                        $('#ShowMsg').ShowMsg({msg:MEror,alertClass:data[2][2],colwidth:'col-md-8',coloffset:'col-md-offset-2'});
                    }
                    else{                                          
                        $('#ShowMsg').ShowMsg({msg:'Request not Completed Successfully!',colwidth:'col-md-8',coloffset:'col-md-offset-2',alertClass:'alert-danger'});                        
                    }
                }
            }
            catch(err) {
                $('#ShowMsg').ShowMsg({msg:"<strong>Error:</strong> Unexpected Response received, You may try again!",colwidth:'col-md-8',coloffset:'col-md-offset-2',alertClass:'alert-warning'});                                
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


