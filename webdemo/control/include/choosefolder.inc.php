			<form name="frm" id="frm" action="<?php echo curPageName()."?EncHid=$_SESSION[EncTok]"?>" role="form" class="form-border clearfix col-sm-6 col-sm-offset-3" method="post">
                        <input type="hidden" name="preSub" id="preSub" value="1" />     
                        <input type="hidden" name="per_id" id="per_id" value="<?php echo $_REQUEST['per_id']?>" />                                         
                        
                        <div class="form-group">
                          <label for="fname">Choose Folder</label>
                          <select name="fname" id="fname" class="form-control" data-validate="fname|text|y|1|500|dontselect=-1|Please enter Valid option!"> 
                              <option value="-1">--- Select ---</option>
							<option value='RTF1984' <?php if(($_REQUEST['fname'] ?? '') == 'RTF1984') echo"selected"; ?>>CMS Content</option>
							<option value='L45218' <?php if(($_REQUEST['fname'] ?? '') == 'L45218') echo"selected"; ?>>File Link Content</option>
							<option value='RTFTender' <?php if(($_REQUEST['fname'] ?? '') == 'RTFTender') echo"selected"; ?>>Tender RTF Content</option>
							<option value='HD87168' <?php if(($_REQUEST['fname'] ?? '') == 'HD87168') echo"selected"; ?>>Link Header Images</option>
							<option value='IC1425' <?php if(($_REQUEST['fname'] ?? '') == 'IC1425') echo"selected"; ?>>Icon</option>
							<option value='PCAT8945' <?php if(($_REQUEST['fname'] ?? '') == 'PCAT8945') echo"selected"; ?>>Media Category</option>
							<option value='MD32145' <?php if(($_REQUEST['fname'] ?? '') == 'MD32145') echo"selected"; ?>>Media Gallery</option>
							<!--<option value='PF45214' <?php //if($_REQUEST['fname'] == 'PF45214') echo"selected"; ?>>PF45214</option>
							<option value='Pub6521' <?php //if($_REQUEST['fname'] == 'Pub6521') echo"selected"; ?>>Pub6521</option>
							<option value='T45218' <?php //if($_REQUEST['fname'] == 'T45218') echo"selected"; ?>>T45218</option>
							<option value='testIMGS' <?php //if($_REQUEST['fname'] == 'testIMGS') echo"selected"; ?>>testIMGS</option>
							<option value='tmp4812' <?php //if($_REQUEST['fname'] == 'tmp4812') echo"selected"; ?>>tmp4812</option>-->

                          </select>
                        </div>
                        <div class="col-sm-8 col-sm-offset-4">
                            <button type="submit" class="btn btn-primary">Proceed</button>
                          </div>
                    </form>
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
        }
        else{
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
    ShowHid(<?php echo ($_REQUEST['l_natur'] ?? '');?>);    
    $('#lid').val(<?php echo ($_REQUEST['lid'] ?? '');?>);
    <?php
    }
    ?>
})
</script>