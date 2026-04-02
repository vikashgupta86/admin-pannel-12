<div class="form-box mb-4"> 
    <form name="frm" id="frm" action="<?php echo curPageName()."?EncHid=$_SESSION[EncTok]"?>" role="form" class="form-border clearfix col-sm-6 col-sm-offset-3" method="post">
        <input type="hidden" name="preSub" id="preSub" value="1" />     
        <input type="hidden" name="per_id" id="per_id" value="<?php echo $_REQUEST['per_id']?>" />                                         
        
        <div class="mb-3">
        <label for="t_cat_id">Choose Category</label>
        <select name="t_cat_id" id="t_cat_id" class="form-select form-select-sm rounded-0" data-validate="t_cat_id|text|y|1|10|num|dontselect=-1|Please enter Valid option!">
            <option value="-1">--- Choose Category ---</option>                            
            <?php                            
            $rs1 = fetchtable("web_tender_category","status='Active' and app_reject=1");
            if($rs1[0]>0){
                foreach($rs1[1] as $row1){
                    // if($_REQUEST['t_cat_id'] ?? '' == $row1['t_cat_id'])
                    //     echo "<option value='$row1[t_cat_id]' selected=''>".html_entity_decode($row1['cat_name'])."</option>";
                    // else
                    //     echo "<option value='$row1[t_cat_id]'>".html_entity_decode($row1['cat_name'])."</option>";

                    if(isset($_REQUEST['t_cat_id']))
                    {
                        if($_REQUEST['t_cat_id'] == $row1['t_cat_id'])
                        echo "<option value='".$row1['t_cat_id']."' selected=''>$row1[cat_name]</option>";
                        else
                        echo "<option value='".$row1['t_cat_id']."'>$row1[cat_name]</option>";
                    }
                    else
                    {
                        echo "<option value='".$row1['t_cat_id']."'>$row1[cat_name]</option>";
                    }
                }
            }
            ?>
        </select>
        </div>
        <?php /* if($_SESSION['department']!=''){?>
        
        <div class="mb-3">
        <label for="department">Department</label>
        <select name="department" id="department" class="form-select form-select-sm rounded-0" data-validate="department|text|y|1|10|num|dontselect=-1|Please enter Valid option!">                            
            <?php
            $dp=$_SESSION['department'];
            $rs1 = fetchtable("department","status='Active' and id = $dp",1);
            if($rs1[0]>0){
            
            
            foreach($rs1[1] as $row1){
            
                if($_SESSION['department'] == $row1['id']){
                echo "<option value='$row1[id]' selected=''>$row1[dept_name]</option>";
                }else{
            
                if($_REQUEST['department'] ?? ''==$row1['id'])
                        echo "<option value='$row1[id]' selected=''>$row1[dept_name]</option>";
                    else
                
                        echo "<option value='$row1[id]'>$row1[dept_name]</option>";
                        }
                }
                }
            ?>
            
        </select>
        
        </div> 
        <?php }else{?>   
        
        <div class="mb-3">
        <label for="department">Choose Department</label>
        <select name="department" id="department" class="form-select form-select-sm rounded-0" data-validate="department|text|y|1|10|num|dontselect=-1|Please enter Valid option!">                            
            <option value="">--- Choose Department ---</option> 
            
            <?php
            $rs1 = fetchtable("department","status='Active'",1);
            if($rs1[0]>0){
            
            
            foreach($rs1[1] as $row1){
            
                if($_SESSION['department'] ?? '' ==$row1['id']){
                echo "<option value='$row1[id]' selected=''>$row1[dept_name]</option>";
                }else{
            
                if($_REQUEST['department'] ?? ''==$row1['id'])
                        echo "<option value='$row1[id]' selected=''>$row1[dept_name]</option>";
                    else
                
                        echo "<option value='$row1[id]'>$row1[dept_name]</option>";
                        }
                }
                }
            ?>
            
        </select>
        
        
        
        </div> 
    <?php } */?>    
        
        
        <div class="col-sm-8 col-sm-offset-4">
            <button type="submit" class="btn btn-primary">Proceed</button>
        </div>
    </form>
</div>    
<script type="text/javascript">
$(function(){
    $('#frm').formChecks().SetToFirstFocus();
})
</script>