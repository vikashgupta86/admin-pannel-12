<?php
/**
 * 
 * @deprecated fields name would be address,state_id,district_id,city_id,
 * for the server validation val_sub variable should be come with value 1
 * Form Name would be default frm
 * $ParamArry Default Arry Defind in usercon 
 * In case of MOdification RecordSet should be in $sdata
 * 
 * Prefix send if you want to use multiple chunks for the same *
 * 
 * 
 * 
 */
 
 $ParamArry=array(
    'frmName'=>'frm',    
    'prefix'=>'',
    'Mand'=>array('Addr'=>'y','City'=>'y','Dist'=>'y','Plac'=>'y','Pin'=>'n','cLand'=>'n','Land'=>'n','Demail'=>'n'/*,'cProf'=>'n','Prof'=>'n'*/,'mob'=>'n','cFax'=>'n','Fax'=>'n') 
 );
 
 $ParamMod=array($ParamArry['prefix'].'Addr'=>'',$ParamArry['prefix'].'City'=>'-1',$ParamArry['prefix'].'Dist'=>'-1',$ParamArry['prefix'].'Plac'=>'-1',$ParamArry['prefix'].'Pin'=>'',$ParamArry['prefix'].'cLand'=>'',$ParamArry['prefix'].'Land'=>'',$ParamArry['prefix'].'Demail'=>'',/*$ParamArry['prefix'].'cProf'=>'',$ParamArry['prefix'].'Prof'=>'',*/$ParamArry['prefix'].'mob'=>'',$ParamArry['prefix'].'cFax'=>'',$ParamArry['prefix'].'Fax'=>'');
 
 if(isset($ParamModN))
    $ParamMod=$ParamModN;
#if(isset($ParamArryN))
 #   $ParamArry=$ParamArryN;
 if(isset($ParamArryN['prefix']))
    $ParamArry['prefix']=$ParamArryN['prefix'];
 if(isset($ParamArryN['frmName']))
    $ParamArry['frmName']=$ParamArryN['frmName'];

 if(isset($ParamArryN['Mand'])){    
    $ParamArry['Mand']=$ParamArryN['Mand'];    
 }
?>


<script <?= $nonce; ?>  type="text/javascript">
    $(document).ready(function(){
        $('#ParmAdd').unbind('click');
        $('#ParmAdd').click(function (){            
            if($(this).is(":checked")){
                $('#p_address').val($('#r_address').val());
                $('#p_state_id').val($('#r_state_id').val());
                $.when($('#p_district_id').html($('#r_district_id').html())).done(function(){
                    $('#p_district_id').val($('#r_district_id').val());
                });
                $.when($('#p_city_id').html($('#r_city_id').html())).done(function(){
                    $('#p_city_id').val($('#r_city_id').val());
                });
                $('#p_pincode').val($('#r_pincode').val());
                
                $('#p_c_landline').val($('#r_c_landline').val());
                $('#p_landline').val($('#r_landline').val());
                $('#p_mob').val($('#r_mob').val());
                $('#p_c_fax').val($('#r_c_fax').val());
                $('#p_fax').val($('#r_fax').val());                
                $('#p_Demail').val($('#r_Demail').val());
            }
            else{                
                $('#p_address,#p_state_id,#p_district_id,#p_city_id,#p_pincode,#p_c_landline,#p_landline,#p_mob,#p_c_fax,#p_fax,#p_Demail').val('');
                $('#p_state_id,#p_district_id,#p_city_id').val('-1');
            }            
        })
        
        //Corress
        $('#CorrAdd').unbind('click');
        $('#CorrAdd').click(function (){
            if($(this).is(":checked")){                
                $('#c_address').val($('#p_address').val());
                $('#c_state_id').val($('#p_state_id').val());
                $.when($('#c_district_id').html($('#p_district_id').html())).done(function(){
                    $('#c_district_id').val($('#p_district_id').val());
                });
                $.when($('#c_city_id').html($('#p_city_id').html())).done(function(){
                    $('#c_city_id').val($('#p_city_id').val());
                });
                $('#c_pincode').val($('#p_pincode').val());   
                
                $('#c_c_landline').val($('#p_c_landline').val());
                $('#c_landline').val($('#p_landline').val());
                $('#c_mob').val($('#p_mob').val());
                $('#c_c_fax').val($('#p_c_fax').val());
                $('#c_fax').val($('#p_fax').val());                
                $('#c_Demail').val($('#p_Demail').val());             
            }
            else{                
                $('#c_address,#c_state_id,#c_district_id,#c_city_id,#c_pincode,#c_c_landline,#c_landline,#c_mob,#c_c_fax,#c_fax,#c_Demail').val('');
                $('#c_state_id,#c_district_id,#c_city_id').val('-1');
            }            
        })
        $('#CorrAdd1').unbind('click');
        $('#CorrAdd1').click(function (){
            $('#CorrAdd').attr('checked',false);
            if($(this).is(":checked")){                
                $('#c_address').val($('#r_address').val());
                $('#c_state_id').val($('#r_state_id').val());
                $.when($('#c_district_id').html($('#r_district_id').html())).done(function(){
                    $('#c_district_id').val($('#r_district_id').val());
                });
                $.when($('#c_city_id').html($('#r_city_id').html())).done(function(){
                    $('#c_city_id').val($('#r_city_id').val());
                });
                $('#c_pincode').val($('#r_pincode').val());
                
                $('#c_c_landline').val($('#r_c_landline').val());
                $('#c_landline').val($('#r_landline').val());
                $('#c_mob').val($('#r_mob').val());
                $('#c_c_fax').val($('#r_c_fax').val());
                $('#c_fax').val($('#r_fax').val());                
                $('#c_Demail').val($('#r_Demail').val());                
            }
            else{                
                $('#c_address,#c_state_id,#c_district_id,#c_city_id,#c_pincode,#c_c_landline,#c_landline,#c_mob,#c_c_fax,#c_fax,#c_Demail').val('');
                $('#c_state_id,#c_district_id,#c_city_id').val('-1');
            }             
        })
    })
    function GetDistrict(val,FillTo){
        //FillDataHtml('AjaxFill/GetDistricts.php',{'id':val},FillTo,true,false);  
        $.fn.FillData({url:'AjaxFill/GetDistricts.php',Fill_To:FillTo,Arr:{'id':val},Async:false});          
    }
    
    /*function GetCity(val,FillTo){        
        FillDataHtml('AjaxFill/GetCity.php',{'id':val},FillTo,true);                    
    }*/
    
    function GetPin(GetFrom,FillTo){        
        $('#'+FillTo).val($('#'+GetFrom).find(':selected').data('pin'));                
    }
    
</script>
<div class="row">
    <div class="form-group col-md-7">
      <label for="<?php echo $ParamArry['prefix']?>address">Address:</label>
      <textarea class="form-control" name="<?php echo $ParamArry['prefix']?>address" id="<?php echo $ParamArry['prefix']?>address" rows="8" placeholder="Address" data-validate="<?php echo $ParamArry['prefix']?>address|textarea|<?php echo $ParamArry['Mand']['Addr']?>|1|2000|alnum_spc|Please enter Valid Source!"><?php echo $ParamMod[$ParamArry['prefix'].'Addr']; ?></textarea>     
    </div>
    
    <div class="form-group col-md-5">
      <label for="<?php echo $ParamArry['prefix']?>state_id">State:</label>
      <select name="<?php echo $ParamArry['prefix']?>state_id" id="<?php echo $ParamArry['prefix']?>state_id" class="form-control" data-validate="<?php echo $ParamArry['prefix']?>state_id|text|<?php echo $ParamArry['Mand']['City']?>|1|10|num|dontselect=-1|Please enter Valid option!" onchange="GetDistrict(this.value,'<?php echo $ParamArry['prefix']?>district_id');">
        <option value="-1">--- Select ---</option>
        <?php       
            $rs1=fetchtable("web_st_states", "1" , 1 ,"order by state_name");
            if($rs1[0]>0){
                foreach($rs1[1] as $row1){
                    if($row1['state_id']==$ParamMod[$ParamArry['prefix'].'City'])
                        echo "<option value='$row1[state_id]' selected='' >".ucwords(strtolower($row1['state_name']))."</option>";
                    else
                        echo "<option value='$row1[state_id]' >".ucwords(strtolower($row1['state_name']))."</option>";
                }                                                          
            }                                                                             
        ?>
      </select>
    </div>
    
    <div class="form-group col-md-5">
      <label for="<?php echo $ParamArry['prefix']?>district_id">City/ District:</label>
      <select name="<?php echo $ParamArry['prefix']?>district_id" id="<?php echo $ParamArry['prefix']?>district_id" class="form-control" data-validate="<?php echo $ParamArry['prefix']?>district_id|text|<?php echo $ParamArry['Mand']['Dist']?>|1|10|num|dontselect=-1|Please enter Valid option!">
        <option value="-1">--- Select ---</option>
        <?php
            if(!empty($ParamMod[$ParamArry['prefix'].'City'])&& ($ParamMod[$ParamArry['prefix'].'City'])!='-1'){
                $rs1=fetchtable("web_st_districts","state_id={$ParamMod[$ParamArry['prefix'].'City']} order by district_name");
                if($rs1[0]>0){
                    foreach($rs1[1] as $row1){
                        if($row1['district_id']==$ParamMod[$ParamArry['prefix'].'Dist'])
                            echo "<option value='$row1[district_id]' selected='' >$row1[district_name]</option>";
                        else
                            echo "<option value='$row1[district_id]' >$row1[district_name]</option>";
                    }                                                          
                }    
            }                                                                            
        ?>
      </select>
    </div>
    
    <div class="form-group col-md-5">
      <label for="<?php echo $ParamArry['prefix']?>pincode">Pincode:</label>
      <input type="text" class="form-control" name="<?php echo $ParamArry['prefix']?>pincode" id="<?php echo $ParamArry['prefix']?>pincode" rows="8" placeholder="Pincode" data-validate="<?php echo $ParamArry['prefix']?>pincode|text|n|6|10|alnum_spc|Please enter Valid Pincode!" value="<?php echo $ParamMod[$ParamArry['prefix'].'Pin']; ?>"/>     
    </div>
</div>

<?php
if($ContactFlage){
?>
    <div class="row">
        <div class="form-group col-md-6">
          <label for="<?php echo $ParamArry['prefix']?>landline">Landline:</label>
          <div class="clearfix"></div>
          <div class="col-md-4">
            <input type="text" class="form-control" name="<?php echo $ParamArry['prefix']?>c_landline" id="<?php echo $ParamArry['prefix']?>c_landline" size="3" maxlength="3" placeholder="Std Code" data-validate="<?php echo $ParamArry['prefix']?>c_landline|text|<?php echo $ParamArry['Mand']['Land'] ?? 'n'?>|1|5|num|Please enter Valid Number!" value="<?php echo $ParamMod[$ParamArry['prefix'].'c_Land']; ?>"/>
          </div>
          <div class="col-md-8">
            <input type="text" class="form-control" name="<?php echo $ParamArry['prefix']?>landline" id="<?php echo $ParamArry['prefix']?>landline" size="8" maxlength="8" placeholder="Number" data-validate="<?php echo $ParamArry['prefix']?>landline|text|<?php echo $ParamArry['Mand']['Land'] ?? 'n'?>|8|10|num|Please enter Valid Number!" value="<?php echo $ParamMod[$ParamArry['prefix'].'Land']; ?>"/>
          </div>     
        </div>
        
        <div class="form-group col-md-6">
          <label for="<?php echo $ParamArry['prefix']?>c_fax">Fax:</label>
          <div class="clearfix"></div>
          <div class="col-md-4">
            <input type="text" class="form-control" name="<?php echo $ParamArry['prefix']?>c_fax" id="<?php echo $ParamArry['prefix']?>c_fax" size="3" maxlength="3" placeholder="Std Code" data-validate="<?php echo $ParamArry['prefix']?>c_fax|text|<?php echo $ParamArry['Mand']['Fax'] ?? 'n'?>|1|5|num|Please enter Valid Number!" value="<?php echo $ParamMod[$ParamArry['prefix'].'c_Fax']; ?>"/>
          </div>
          <div class="col-md-8">
            <input type="text" class="form-control" name="<?php echo $ParamArry['prefix']?>fax" id="<?php echo $ParamArry['prefix']?>fax" size="8" maxlength="8" placeholder="Number" data-validate="<?php echo $ParamArry['prefix']?>fax|text|<?php echo $ParamArry['Mand']['Fax'] ?? 'n'?>|8|10|num|Please enter Valid Number!" value="<?php echo $ParamMod[$ParamArry['prefix'].'Fax']; ?>"/>
          </div>     
        </div>
    </div>
    
    <div class="row">
        <div class="form-group col-md-6">
          <label for="<?php echo $ParamArry['prefix']?>mob">Mobile:</label>
          <input type="text" class="form-control" name="<?php echo $ParamArry['prefix']?>mob" id="<?php echo $ParamArry['prefix']?>mob" rows="8" placeholder="Mobile" data-validate="<?php echo $ParamArry['prefix']?>mob|text|<?php echo $ParamArry['Mand']['mob'] ?? 'n'?>|10|11|num|Please enter mobile number !" value="<?php echo $ParamMod[$ParamArry['prefix'].'mob']; ?>"/>     
        </div>
       
        <div class="form-group col-md-6">
          <label for="<?php echo $ParamArry['prefix']?>Demail">Email-ID:</label>
          <input type="text" class="form-control" name="<?php echo $ParamArry['prefix']?>Demail" id="<?php echo $ParamArry['prefix']?>Demail" rows="8" placeholder="Email ID" value="<?php echo $ParamMod[$ParamArry['prefix'].'Demail']; ?>"/>     
        </div>
    </div>
<?php
}
?>