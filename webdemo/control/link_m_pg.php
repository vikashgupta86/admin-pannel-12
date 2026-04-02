<?php 
    include '../appcode/globals.inc.php';
    include_once(BASE_PATH .'/control/include/include.inc.php');
    userAuthenticationPageLevel();
    userAuthenticationMainLevel();
    include_once('include/pageHeader.inc.php');
    include('include/top_user_info.inc.php');

    $secFrmFlage = '';
?>
   
<h2 class="h5 content-header text-dark">Map Link with PhotoGallery</h2>

<div class="form-box mb-4">
    <form name="frm" id="frm" action="<?php echo curPageName()."?EncHid=$_SESSION[EncTok]"?>" role="form" method="post">
        <input type="hidden" name="preSub" id="preSub" value="1" />     
        <input type="hidden" name="per_id" id="per_id" value="<?php echo $_REQUEST['per_id']?>" />                                         
                        
        <div class="mb-3">
            <label for="lang_id" class="form-label fw-bold small">Choose Language <span class="text-danger">*</span></label>
            <select name="lang_id" id="lang_id" class="form-control" data-validate="lang_id|text|y|1|10|num|dontselect=-1|Please enter Valid option!">                            
                <?php                            
                $rs1=fetchtable("web_lang","status='Active'");
                if($rs1[0]>0){
                    foreach($rs1[1] as $row1){
                        if($_REQUEST['lang_id'] ==$row1['lang_id'])
                            echo "<option value='$row1[lang_id]' selected=''>$row1[lang]</option>";
                        else
                            echo "<option value='$row1[lang_id]'>$row1[lang]</option>";
                    }
                }
                ?>
            </select>
        </div>
                        
        <div class="mb-3">
            <label for="lid" class="form-label fw-bold small">Link Name <span class="text-danger">*</span></label>
            <select name="lid" id="lid" class="form-control" data-validate="lid|text|y|1|10|num|dontselect=-1|Please enter Valid option!">
            <option value="-1">--- Select ---</option>
            <?php
            if(isset($_REQUEST['lang_id'])){
                $rs1=simplefetch("select lf.lid,wlt.link_name from web_links_final lf
INNER JOIN web_link_temp wlt on wlt.link_temp_id=lf.link_temp_id
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
        <div class="text-center">
            <button type="submit" class="btn btn-primary rounded-0 px-4 process-btn" id="proceedBtn" style="background-color: #337ab7; border-color: #2e6da4;">Proceed</button>
        </div>
    </form>
</div>
                    
                
                
                <?php                
                if(isset($_REQUEST['preSub']) && $_REQUEST['preSub']==1 && ($frmError ?? '')==false){
                    $secFrmFlage=true;
                ?>                
                    <div class="panel panel-default">
                    <div class="panel-heading box-title">PhotoGallery List</div>
                        <div class="panel-body">
                             <form class="clearfix" name="frmmain" id="frmmain" method="post" action="<?php echo curPageName(false);?>_action.php">
                                <input type="hidden" name="per_id" id="per_id" value="<?php echo $_REQUEST['per_id']?>" />
                                <input type="hidden" name="EncHid" id="EncHid" value="<?php echo $_SESSION['EncTok']?>" />                                    
                                    <input type="hidden" name="lid" id="lid" value="<?php echo $_REQUEST['lid'];?>" />
                                      <table id="GridData" class="table table-bordered table-striped table-hover clearfix">
                                        <thead>
                                        <tr>
                                          <th>S.No</th>
                                          <th>Category Name</th>
                                          <th>Category Name (Hindi)</th>
                                          <th>Cover Image</th>
                                          <th class="text-center">Select All <label for="chk[]"><input type="checkbox" name="chk" id="chk"></label></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php                                                                                
                                        $rs=simplefetch("select pc.m_cat_id,pc.cat_name,pc.cat_name_h,pc.img_name,concat(wu.user_name,' [',date_format(pc.creation_date,'%d/%m/%Y'),' ]')as cName,concat(ru.user_name,' [',date_format(pc.app_rej_action_on,'%M %d, %Y'),' ]')as apName,if(wfut.m_map_id is not null,'checked=\"\"','')as flage from web_media_category pc 
                                        INNER JOIN web_users wu on wu.user_id=pc.creator_id
                                        INNER JOIN web_users ru on ru.user_id=pc.app_rej_user_id
                                        LEFT JOIN(SELECT * from web_link_map_media where `status`='Active' and lid=$_REQUEST[lid]) wfut on wfut.m_cat_id=pc.m_cat_id
                                        where pc.status='Active' and pc.app_reject=1 order by pc.m_cat_id DESC");
                                        if($rs[0]>0){ 
                                            $sNo = 1;                                       
                                            foreach($rs[1] as $row){
                                                if(empty($row['img_name'])){
                                                    $cImage="<i class=\"fa fa-picture-o\" aria-hidden=\"true\" style=\"font-size: 50px;\"></i>";                    
                                                }
                                                else{
                                                    $cImage="<img src=\"../WriteReadData/PCAT8945/$row[img_name]\" class=\"img-circle\" alt=\"Link Icon\" width=\"50\" height=\"50\">";                    
                                                }
                                            ?>
                                            <tr>
                                                <td class="reorder"><?php echo ++$sNo;?></td>
                                                <td class="reorder"><?php echo html_entity_decode($row['cat_name']);?></td>
                                                <td class="reorder"><?php echo html_entity_decode($row['cat_name_h']);?></td>
                                                <td><?php echo $cImage;?></td>
                                                <td class="text-center error-message">                                                            
                                                  <div><input type="checkbox" name="chk[]" id="chk_<?php echo $row['m_cat_id'];?>" value="<?php echo $row['m_cat_id'];?>" <?php echo $row['flage'];?> data-validate="<?php //echo end($rs[1])==$row?"chk[]|checkbox|n|1|4|selmin=1|Please Select atleast One Checkbox to Proceed..":""?>">                                                            
                                               </div></td>
                                            </tr>
                                            <?php                                
                                            }
                                        }
                                        ?>
                                        </tbody>
                                      </table>
                                      <div class="text-center">
                                        <input type="submit" name="submit" id="submit" class="btn btn-primary rounded-0 px-4 process-btn" value="Submit" />
                                      </div>    
                                                   
                           </form> 
                      </div>

                      
                    <div id="ShowMsg"></div>

                    <?php
                }
                ?>                
 
 
          
    <script type="text/javascript">
        function subFrm(){
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
                        $('#ShowMsg').ShowMsg({msg:"<strong>Error:</strong> Unexpected Response received, You may try again!",alertClass:'alert-warning'});                                
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
                $.fn.FillData({url:'AjaxFill/GetContLink.php',Fill_To:'lid',Arr:{'lang_id':$('#lang_id').val()}});
            }
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
            
            $('#chk').click(function(){
                $.fn.CheckAll({chkName:'chk[]',ckFlage:$(this).is(':checked')})
            })
        })
    </script>

    <?php include('include/pageFooter.inc.php');?>