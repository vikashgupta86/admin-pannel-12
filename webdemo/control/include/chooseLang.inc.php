                <!-- <form id="manageContentsForm" class="d-none">
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
                </form> -->


<div class="form-box mb-4"> 

<form name="frm" id="frm" action="<?php echo curPageName()."?EncHid=$_SESSION[EncTok]"?>" role="form" method="post">
    <input type="hidden" name="preSub" id="preSub" value="1" />     
    <input type="hidden" name="per_id" id="per_id" value="<?php echo $_REQUEST['per_id']?>" />                                         
                        
    <div class="mb-3">
        <label for="lang_id" class="form-label fw-bold small">Choose Language <span class="text-danger">*</span></label>
        <select name="lang_id" id="lang_id" class="form-select form-select-sm rounded-0" data-validate="lang_id|text|y|1|10|num|dontselect=-1|Please enter Valid option!">                            
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
						
    <?php
        /**
        * $publishFlage=true if want to get this block
        */
        if(isset($publishFlage)){
            ?>
            <div class="mb-3">
                <ul class="list-inline">
                    <li><label for="l_natur" class="form-label fw-bold small">Link Nature <span class="text-danger">*</span></label></li>
                    <li class="checkbox">
                        <input type="radio" name="l_natur" id="l_natur1" value="1" checked="" /> Normal Links
                        <input type="radio" name="l_natur" id="l_natur2" value="2" <?php echo ($_REQUEST['l_natur'] ?? '') ==2?'checked=""':'';?> data-validate="l_natur|checkbox|y|1|2|selmin=1|Please Select atleast One option!"/> Continuous Links
                    </li>
                </ul>
            </div>
            
            <div class="mb-3" id="contLinkBlock" style="display: none;">
                <label for="lid" class="form-label fw-bold small">Choose Link Name <span class="text-danger">*</span></label>
                <select name="lid" id="lid" class="form-select form-select-sm rounded-0" data-validate="lid|text|n|1|10|num|dontselect=-1|Please enter Valid option!">
                    <option value="-1">--- Select ---</option>
                    <?php
                        if(isset($_REQUEST['lang_id'])){
                            $rs1=simplefetch("select lf.lid,wlt.link_name from web_links_final lf
								INNER JOIN web_link_temp wlt on wlt.link_temp_id=lf.link_temp_id
								LEFT JOIN (SELECT wlt1.link_temp_id,wlt1.lid,wlt1.main_link_temp_id from web_link_temp wlt1 
								where wlt1.`status`='Active' and wlt1.type_id=3 and wlt1.continuous_content=1 and wlt1.lang_id=$_REQUEST[lang_id] and (wlt1.app_reject!=2 || wlt1.app_reject is null) and wlt1.publish_by is null) wlc on wlc.main_link_temp_id=lf.lid 
								where wlt.`status`='Active' and wlt.type_id=3 and wlt.lang_id=$_REQUEST[lang_id] and wlc.link_temp_id is not null ORDER BY wlt.link_name");
                            if($rs1[0]>0){
                                foreach($rs1[1] as $row1){
                                    if($_REQUEST['lid']==$row1['lid'])
                                        echo "<option value='$row1[lid]' selected=''>".html_entity_decode($row1['link_name'] ?? '')."</option>";
                                    else
                                        echo "<option value='$row1[lid]'>".html_entity_decode($row1['link_name'] ?? '')."</option>";
                                }
                            }
                        }
                    ?>
                </select>
            </div>
            <?php
        }
                        
        if(!isset($showType) || $showType==true){
            ?>
            <div class="mb-3" id="linkTypeBlock">
                <label for="type_id" class="form-label fw-bold small">Link Type <span class="text-danger">*</span></label>
                <select name="type_id" id="type_id" class="form-select form-select-sm rounded-0" data-validate="type_id|text|y|1|10|num|dontselect=-1|Please enter Valid option!">
                    <option value="-1">--- Select ---</option>
                    <?php                            
                        $rs1=fetchtable("web_link_type","status='Active' order by type");
                        if($rs1[0]>0){
                            foreach($rs1[1] as $row1){
                                if(($_REQUEST['type_id'] ?? '')==$row1['type_id'])
                                    echo "<option value='$row1[type_id]' selected=''>$row1[type]</option>";
                                else
                                    echo "<option value='$row1[type_id]'>$row1[type]</option>";
                            }
                        }
                    ?>
                </select>
            </div>
		    <?php 			
			    /*if(empty($_SESSION['department_type'])){ ?>
				    <div class="mb-3">
                        <label for="dept_type_id" class="form-label fw-bold small">Site Type <span class="text-danger">*</span></label>
                        <select name="dept_type_id" id="dept_type_id" class="form-control" data-validate="dept_type_id|text|y|1|10|num|dontselect=-1|Please enter Valid option!">
                            <option value="-1">--- Select ---</option>
                            <option value="0" <?php if($_REQUEST['dept_type_id']=='0'){ echo 'selected';} ?>>Head Office</option>
                            <?php
                                $rs1=fetchtable("dept_type","status='Active'",1);
                                if($rs1[0]>0){
                                    foreach($rs1[1] as $row1){
                                        if($_REQUEST['dept_type_id']==$row1['id'])
                                            echo "<option value='$row1[id]' selected=''>$row1[dept_type]</option>";
                                        else
                                            echo "<option value='$row1[id]'>$row1[dept_type]</option>";
                                    }
                            ?>
                        </select>
                    </div>
                    <?php
                }*/ 
            }
        ?>  				
		<?php 
			#if(empty($_SESSION['department_type'])){
			
            #}else{  
        ?> 
		<input type="hidden" name="dept_type_id" id="dept_type_id" value="<?php echo $_SESSION['department_type'] ?? 1;?>">
		<?php #} ?>

        
        <?php /*
        <div class="mb-3">
            <label for="dept_type_id" class="form-label fw-bold small">Content Type <span class="text-danger">*</span></label>
            <select name="dept_type_id" id="dept_type_id" class="form-select form-select-sm rounded-0" data-validate="dept_type_id|text|y|1|10|num|dontselect=-1|Please enter Valid option!">
                <option value="-1">--- Select ---</option>
                <?php
                    $rs1=fetchtable("dept_type","status='Active'",1);
                    if($rs1[0]>0){
                        foreach($rs1[1] as $row1){
                            if((isset($_REQUEST['dept_type_id']) && $_REQUEST['dept_type_id']==$row1['id']))
                                echo "<option value='$row1[id]' selected=''>$row1[dept_type]</option>";
                            else
                                echo "<option value='$row1[id]'>$row1[dept_type]</option>";
                        }
                    }
                ?>
            </select>
        </div>
        */ ?>

        <div class="text-center">
            <button type="submit" class="btn btn-primary rounded-0 px-4 process-btn" id="proceedBtn">Proceed</button>
        </div>
        <!-- <div class="col-sm-8 col-sm-offset-4">
            <button type="submit" class="btn btn-primary">Proceed</button>
        </div> -->
    </form>
</div>



    <script type="text/javascript">
        $(function(){
            function FrmChk(){
                $('#frm').formChecks().SetToFirstFocus();
            }
            FrmChk();
    
            function GetContLink(){
                $.fn.FillData({url:'AjaxFill/GetContLink.php',Fill_To:'lid',Arr:{'lang_id':$('#lang_id').val(),'h_cont':'1'},Async:false});
            }
    
            $('#contLinkBlock').hide();
            $("input[type='radio'][name='l_natur']").change(function(){
                ShowHid($(this).val());
                GetContLink();
                FrmChk();
            })
    
            function ShowHid(val){
                if(val==2){
                    $('#linkTypeBlock').hide();
                    $('#contLinkBlock').show();
                } else {
                    $('#linkTypeBlock').show();
                    $('#contLinkBlock').hide();
                }
            }
    
            $('#lang_id').change(function(){
                //console.log($("input[type='radio'][name='l_natur']:checked").val())
                if($("input[type='radio'][name='l_natur']:checked").val()==2)
                    GetContLink();
                })
            <?php
                if(isset($_REQUEST['preSub'])){
            ?>
                ShowHid(<?php echo $_REQUEST['l_natur'] ?? '';?>);    
                $('#lid').val(<?php echo $_REQUEST['lid'] ?? '';?>);
            <?php
                }
            ?>
        })
    </script>