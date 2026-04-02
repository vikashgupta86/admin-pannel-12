<div class="form-box mb-4"> 
    <form name="frm" id="frm" action="<?php echo curPageName()."?EncHid=$_SESSION[EncTok]"?>" role="form" method="post">
        <input type="hidden" name="preSub" id="preSub" value="1" />     
        <input type="hidden" name="per_id" id="per_id" value="<?php echo $_REQUEST['per_id']?>" />
		<input type="hidden" name="nmnh_type" id="nmnh_type" value="<?php echo empty($_SESSION['musume_type']) ? 0 :$_SESSION['musume_type']; ?>" />						
                        
        <div class="mb-3">
            <label for="lang_id" class="form-label fw-bold small">Choose Language <span class="text-danger">*</span></label>
            <select name="lang_id" id="lang_id" class="form-select form-select-sm rounded-0" data-validate="lang_id|text|y|1|10|num|dontselect=-1|Please enter Valid option!">                            
                <?php                            
                $rs1=fetchtable("web_lang","status='Active'");
                if($rs1[0]>0){
                    foreach($rs1[1] as $row1){
                        if($_REQUEST['lang_id']==$row1['lang_id']) {
                            echo "<option value='$row1[lang_id]' selected=''>$row1[lang]</option>";
                        } else {
                            echo "<option value='$row1[lang_id]'>$row1[lang]</option>";
                        }
                    }
                }
                ?>
            </select>
        </div>
        
        <?php
            if(isset($MainView) && $MainView==false){
                ?>
                <div class="mb-3" id="linkTypeBlock">
                    <label for="type_id" class="form-label fw-bold small">Link Type <span class="text-danger">*</span></label>
                    <select name="type_id" id="type_id" class="form-select form-select-sm rounded-0" data-validate="type_id|text|y|1|10|num|dontselect=-1|Please enter Valid option!">
                        <option value="-1">--- Select ---</option>
                        <?php                            
                        $rs1=fetchtable("web_link_type","status='Active' order by type");
                        if($rs1[0]>0){
                            foreach($rs1[1] as $row1){
                                if($_REQUEST['type_id'] ?? '' ==$row1['type_id'])
                                    echo "<option value='$row1[type_id]' selected=''>$row1[type]</option>";
                                else
                                    echo "<option value='$row1[type_id]'>$row1[type]</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <?php
            }
        ?>

        <div class="mb-3">
            <label for="lid" class="form-label fw-bold small">Choose Link Name <span class="text-danger">*</span></label>
            <select name="lid" id="lid" class="form-select form-select-sm rounded-0" data-validate="lid|text|n|1|10|num|dontselect=-1|Please enter Valid option!">
                <option value="-1">--- Select ---</option>
                <?php
                $subQry=(isset($MainView) && $MainView==true)?'and ls.pos_id=4':'';
                if(isset($_REQUEST['lang_id'])){                                
                    $rs1=simplefetch("select ls.ls_id,lf.lid,wlt.link_name from web_links_final lf
    INNER JOIN web_link_temp wlt on wlt.link_temp_id=lf.link_temp_id
    INNER JOIN web_links_structure ls on ls.lid=lf.lid
    where wlt.`status`='Active' and wlt.type_id=3 $subQry and wlt.continuous_content=0 and wlt.lang_id=$_REQUEST[lang_id] ORDER BY wlt.link_name");
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
            <button type="submit" class="btn btn-primary rounded-0 px-4 process-btn">Proceed</button>
        </div>
    </form>
</div>

<script<?= $nonce; ?>>
$(document).ready(function(){
    function GetContLink(){
        var TypeId = ($('#type_id').length && $('#type_id').val()) ? $('#type_id').val() : '3';
        $.ajax({
            url: 'AjaxFill/GetMainLink.php',
            type: 'POST',
            data: {
                lang_id: $('#lang_id').val(),
                type_id: TypeId,
                mainView: '<?php echo isset($MainView) ? $MainView : ""; ?>',
                nmnh_type: $('#nmnh_type').val()
            },
            success: function(response){
                if ($('#lid').is('select')) {
                    $('#lid').html(response); 
                } else {
                    $('#lid').val(response); 
                }
            },
            error: function(xhr, status, error){
                console.error("AJAX Error:", error);
            }
        });
    }
    GetContLink();
    $('#lang_id, #type_id').on('change', function(){
        GetContLink();
    });
    <?php if(isset($_REQUEST['preSub']) && isset($_REQUEST['lid'])) { ?>
        $('#lid').val('<?php echo $_REQUEST['lid']; ?>');
    <?php } ?>
});
</script>