              


<div class="form-box mb-4"> 

<form name="frm" id="frm" action="<?php echo curPageName()."?EncHid=$_SESSION[EncTok]"?>" role="form" method="post">
    <input type="hidden" name="preSub" id="preSub" value="1" />     
    <input type="hidden" name="per_id" id="per_id" value="<?php echo $_REQUEST['per_id']?>" />  
                                            
                        
    <div class="mb-3">
        <label for="year_id" class="form-label fw-bold small">Choose Year <span class="text-danger">*</span></label>
        <select name="year_id" id="year_id" class="form-select form-select-sm rounded-0" data-validate="year_id|text|y|1|10|num|dontselect=-1|Please enter Valid option!" required>                            
            <option value="">----Select----</option>
            <?php 
                $rs1=fetchtable("years","status='Active'");
                if($rs1[0]>0){
                    foreach($rs1[1] as $row1)
                    {
                        if(isset($_REQUEST['year_id']))
                        {
                            if($_REQUEST['year_id'] == $row1['year_id'])
                            echo "<option value='".$row1['year_id']."' selected=''>$row1[years]</option>";
                            else
                            echo "<option value='".$row1['year_id']."'>$row1[years]</option>";
                        }
                        else
                        {
                            echo "<option value='".$row1['year_id']."'>$row1[years]</option>";
                        }
                        
                    }
                }
            ?>
        </select>
    </div>

    <div class="mb-3">
        <label for="prog_id" class="form-label fw-bold small">Choose Category <span class="text-danger">*</span></label>
        <select name="prog_id" id="prog_id" class="form-select form-select-sm rounded-0" data-validate="prog_id|text|y|1|10|num|dontselect=-1|Please enter Valid option!">                            
            <option value="">----Select----</option>
            <?php 
                $rs1=fetchtable("web_dash_prog","status='Active'");
                if($rs1[0]>0){
                    foreach($rs1[1] as $row1)
                    {
                        if(isset($_REQUEST['prog_id']))
                        {
                            if($_REQUEST['prog_id'] == $row1['prog_id'])
                            echo "<option value='".$row1['prog_id']."' selected=''>$row1[prog_name]</option>";
                            else
                            echo "<option value='".$row1['prog_id']."'>$row1[prog_name]</option>";
                        }
                        else
                        {
                            echo "<option value='".$row1['prog_id']."'>$row1[prog_name]</option>";
                        }

                       
                    }
                }
            ?>
        </select>
    </div>
						
    	

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
    $('#frm').formChecks().SetToFirstFocus();
})
</script>