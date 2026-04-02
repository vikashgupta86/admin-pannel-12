<div class="form-box mb-4">
    <form name="frm" id="frm" action="<?= curPageName() . "?EncHid=" . $_SESSION['EncTok']; ?>" role="form" method="post">
        <input type="hidden" name="preSub" id="preSub" value="1" />     
        <input type="hidden" name="per_id" id="per_id" value="<?php echo $_REQUEST['per_id']?>" />    

        <?php 
            $usr_session='';
            if($_SESSION['user_type'] =='20'){
                $usr_session= " and (entry_by='".$_SESSION['userid']."' || nmnh_type='".$_SESSION['musume_type']."')";
            }/*else{
                $usr_session= " and nmnh_type=0";
            }*/
        ?>                                     
        
        <div class="mb-3">
            <label for="m_cat_id" class="form-label fw-bold small">Choose Category <span class="text-danger">*</span></label>
            <select name="m_cat_id" id="m_cat_id" class="form-select form-select-sm rounded-0" data-validate="m_cat_id|text|y|1|10|num|dontselect=-1|Please enter Valid option!">
                <option value="-1">--- Choose Category ---</option>                            
                <?php                            
                $rs1=fetchtable("web_media_category","status='Active' and app_reject=1 $usr_session");
                if($rs1[0]>0){
                    foreach($rs1[1] as $row1){
                        if($_REQUEST['m_cat_id'] ?? ''==$row1['m_cat_id'])
                            echo "<option value='$row1[m_cat_id]' selected=''>".html_entity_decode($row1['cat_name'])."</option>";
                        else
                            echo "<option value='$row1[m_cat_id]'>".html_entity_decode($row1['cat_name'])."</option>";
                    }
                }
                ?>
            </select>
        </div>
        
        <?php 
                            
                            
                            if(empty($_SESSION['musume_type'])){ ?>
                            <div class="mb-3">
                            <label for="nmnh_type_id" class="form-label fw-bold small">Content Type <span class="text-danger">*</span></label>
                        <select name="nmnh_type_id" id="nmnh_type_id" class="form-select form-select-sm rounded-0" data-validate="nmnh_type_id|text|y|1|10|num|dontselect=-1|Please enter Valid option!">
                            <option value="-1">--- Select ---</option>
                            <?php
                            $rs1=fetchtable("nmnh_type","status='Active'",1);
                            if($rs1[0]>0){
                                foreach($rs1[1] as $row1){
                                    if($_REQUEST['nmnh_type_id'] == $row1['id'])
                                        echo "<option value='$row1[id]' selected=''>$row1[nmnh_type]</option>";
                                    else
                                        echo "<option value='$row1[id]'>$row1[nmnh_type]</option>";
                                }
                            }
                            ?>
                        </select>
                            </div>
                            <?php }else{ ?>
                            <input type="hidden" name="nmnh_type_id" id="nmnh_type_id" value="<?php if(empty($_SESSION['musume_type'])){ echo "0"; } else{ echo $_SESSION['musume_type']; }?>" />
                            <?php } ?>
        

        <div class="text-center">
            <button type="submit" class="btn btn-primary rounded-0 px-4 process-btn" id="proceedBtn">Proceed</button>
        </div>

    </form>
</div>    
<script type="text/javascript">
$(function(){
    $('#frm').formChecks();
})
</script>