<?php include '../appcode/globals.inc.php';
include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');
AjaxFilePrevent();
userAuthenticationPageLevel();
$result=array(0=>false);

if(isset($_REQUEST['frmType'])&& $_REQUEST['frmType']!=3){
    $Fman=$_REQUEST['frmType']==2?'n':'y';
    
    $frmVal=array(
            /*"l_name|text|y|1|500|alnum_spc|Please enter Valid Link Name!",
            "l_name_h|text|n|1|5000|alnum_spc|Please enter Valid Media Name!",
            "l_title|text|y|1|500|alnum_spc|Please enter Valid Link Title!",*/
            "l_bdesc|textarea|n|1|2000|alnum_spc|Please enter Valid data!",
            "l_bdesc_h|textarea|n|1|20000|alnum_spc|Please enter Valid data!",
            "l_natur|radio|y|1|2|selmin=1|Please Select atleast One option!",
            "m_type|radio|y|1|2|selmin=1|Please Select atleast One option!",
			"nmnh_type_id|text|y|1|10|num|dontselect=-1|Please enter Valid option!"
        );
        
        switch($_REQUEST['l_natur']){
            case 1:
                $frmVal=array_merge($frmVal,array(
                    "l_file|file|$Fman|5|2048|file_extn=jpg;jpeg;png;|Please Select file, Allowed extenstions are jpg, jpeg, png!",
                ));
            break;
            case 2:
                switch(isset($_REQUEST['m_type'])){
                    case 1:
                        $frmVal=array_merge($frmVal,array(
                            "l_file|file|$Fman|1|20000|ext=mp4;flv;|Please Select file, Allowed extenstions are mp4, flv!",
                        ));
                    break;
                    
                    case 2:
                        $frmVal=array_merge($frmVal,array(
                            "l_url|text|y|1|500|url|Please enter Valid URL!",
                        ));
                    break;
                }            
            break;
        }
        
        
        $ValiStr=implode('|$$|',$frmVal);


// echo "<pre>";
//     var_dump($_REQUEST);
// echo "<hr>";
//     var_dump($_FILES);
// var_dump($ValiStr);

//         echo "</pre>";
//     die();
    
    $FrmError=$chk->requestcheck($ValiStr,"formNC","div",true,true);
        if($FrmError[0] ?? ''){
            $result[0]=false;
            $result[1]=$FrmError;
            goto ComeHere;        
        }
        
        #those have no dom to show the error to user
        $frmVal=array(        
            "m_cat_id|text|y|1|10|num|Please enter Valid option!",
        );
        $ValiStr=implode('|$$|',$frmVal);
        $FrmError=$chk->requestcheck($ValiStr,"formNC","div",true,true);
        if($FrmError[0] ?? ''){
            $result[2]=array(true,'Something went wrong, Please try again!','alert-info');
            goto ComeHere; 
        }
        
        $FielArr=array(
                    'm_cat_id'=>$_REQUEST['m_cat_id'],
                    /*'m_name'=>htmlspecialchars($_REQUEST['l_name'],ENT_QUOTES),
                    'm_name_h'=>htmlspecialchars($_REQUEST['l_name_h'],ENT_QUOTES),
                    'm_title'=>$_REQUEST['l_title'],*/
                    'm_description'=>$_REQUEST['l_bdesc'],
                    'm_description_h'=>htmlspecialchars($_REQUEST['l_bdesc_h'],ENT_QUOTES),                
                    'url'=>$_REQUEST['l_url'],
                    'type_of_media'=>$_REQUEST['l_natur'],
                    'm_id'=>$_REQUEST['m_id'],
                    'creator_id'=>$_SESSION['userid'],
                    'creation_date'=> date('Y-m-d H:i:s'),
					'content_type'=>$_REQUEST['nmnh_type_id'],
                    
                );
        
        
        if(!empty($_FILES['l_file']['name'])){
            $filName = upload('l_file',$_SESSION['uploader']);        
            if(empty($filName)){
                $result[2]=array(true,'Unable to upload the file!','alert-info');
                goto ComeHere; 
            }
            
            $FielArr=array_merge($FielArr,array(
                    'image_name'=>$filName
                ));
        }
    }
    
    if(isset($_REQUEST['frmType'])){
        switch($_REQUEST['frmType'])
        {
            case 1:#for the add
                // $Fields=implode(',',array_keys($FielArr));
                // $Values=implode("|$$|",$FielArr);
                // $data = array_combine(explode(',',$Fields), explode('|$$|',$Values));

           // $success = insert("web_media_temp", $data);
            $insertRes = insert("web_media_temp", $FielArr, 1);
            $success = ($insertRes !== false);

                #           $success = insert("web_media_temp",[$Fields],[$Values]);
            break;
            case 2:#update
                $ChkPub = simplefetch("SELECT mt.m_temp_id,mt.image_name from web_media_temp mt INNER JOIN web_media_final mf on mf.m_temp_id=mt.m_temp_id WHERE mt.`status`='Active' and mf.status='Active' and mt.m_temp_id= ".$_REQUEST['m_temp_id']. "");
                if($ChkPub[0]<=0)
                {
                    $Fields=implode('|$$|',array_keys($FielArr));
                    $Values=implode("|$$|",$FielArr);
                    
                    $success = update("web_media_temp",$Fields,$Values,"m_temp_id=$_REQUEST[m_temp_id]");
                }
                else{
                    $FielArr=array_merge($FielArr,array(
                        'm_id'=>$_REQUEST['m_id'],
                    ));
                    
                    if(!isset($FielArr['image_name']) || empty($FielArr['image_name']))
                        $FielArr['image_name']=$ChkPub[1][0]['image_name'];
                        
                    $Fields=implode(',',array_keys($FielArr));
                    $Values=implode("|$$|",$FielArr);
                    
                    $success = insert("web_media_temp",$Fields,$Values);    
                }
                
            break;
            
            case 3:
                $success = delete("web_media_temp","m_temp_id=$_REQUEST[m_temp_id]");
            break;
        }
    }
    
if($success)
    $result[0]=true;

ComeHere:
echo frm_response($result);