<?php include '../appcode/globals.inc.php';
include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');
AjaxFilePrevent();
userAuthenticationPageLevel();
$result=array(0=>false);
$cDate=curdatetime();
if(isset($_REQUEST['frmType'])&& $_REQUEST['frmType']!=3){
    $frmVal=array(
        "type_id|text|y|1|10|num|dontselect=-1|Please enter Valid option!",
        "l_name|text|y|1|500|alnum_spcA|Please enter Valid Link Name!",
        "l_alias|text|n|1|500|alnum_spcA|Please enter Valid Link Name!",
        "l_title|text|y|1|500|alnum_spc|Please enter Valid Link Title!",
        "l_bdesc|textarea|n|1|2000|alnum_spcA|Please enter Valid data!",
        "l_key|textarea|n|1|2000|rtf|Please enter Valid data!", 
        "Engid|text|n|1|10|num|dontselect=-1|Please enter Valid option!",   
		"nmnh_type_id_si|text|y|1|10|num|dontselect=-1|Please enter Valid option!",		
    );
    switch($_REQUEST['type_id']){
        case 1:#for the file request
            $Fman=$_REQUEST['frmType']==2?'n':'y';
            $frmVal=array_merge($frmVal,array(
                "l_file|file|$Fman|1|20000|file_extn=pdf;|Please Select file,Filename should not contain any special character and white space. Invalid Filename! Allowed extenstions are pdf!"
            ));
        break;
        
        case 2:#for the url
            $frmVal=array_merge($frmVal,array(
                "l_url|text|y|1|500|url|Please enter Valid URL!"
            ));
        break;
        
        case 3:#for the content
            $frmVal=array_merge($frmVal,array(
                "l_src|textarea|n|1|2000|alnum_spc|Please enter Valid Source!",
                "l_mdesc|textarea|n|1|2000|alnum_spc|Please enter Valid data!",                
                "textarea2|text|y|1|500000|rtf|Please enter Valid data!",
            ));
        break;
    }
    
    switch($_POST['lsub_type']){
        case '2':
            $frmVal=array_merge($frmVal,array(
                "au_name|text|y|1|500|alnum_spcA|Please enter Valid Author Name!",
                "pubDate|text|y|10|10|dt|Please enter/ select Valid Date!",
            ));
        break;
        
        case '3':
            $frmVal=array_merge($frmVal,array(
                "event_name|text|y|1|500|alnum_spcA|Please enter Valid Event Name!",
                "efDate|text|y|10|10|dt|Please enter/ select Valid Date!",
                "etDate|text|n|10|10|dt|Please enter/ select Valid Date!",
            ));
        break;
    }
    
    $ValiStr=implode('|$$|',$frmVal);
    $FrmError=$chk->requestcheck($ValiStr,"formNC","div",true,true);
    if($FrmError[0] ?? ''){
        $result[0]=false;
        $result[1]=$FrmError;
        goto ComeHere;        
    }
    
    $FielArr=array(
        'type_id'=>$_REQUEST['type_id'],
        'lang_id'=>$_REQUEST['lang_id'],
        'link_name'=>htmlspecialchars($_REQUEST['l_name'],ENT_QUOTES),
        'link_alias'=>htmlspecialchars($_REQUEST['l_alias'],ENT_QUOTES),
        'title'=>htmlspecialchars($_REQUEST['l_title'],ENT_QUOTES),
        'link_bdesc'=>htmlspecialchars($_REQUEST['l_bdesc'],ENT_QUOTES),
        'keywords'=>htmlspecialchars($_REQUEST['l_key'],ENT_QUOTES),
        'creator_id'=>$_SESSION['userid'],
        'creation_date'=>$cDate,
        'l_sub_type'=>$_POST['lsub_type'],
        'eng_id'=>$_POST['Engid'] ?? '',                 
		'content_type'=>$_REQUEST['nmnh_type_id_si'],
    );
	


	if(!empty($_FILES['header_l_file']['name']))
    {
        //$condition = substr_count($sFileName, '.') > 1
        $filName_hed=upload('header_l_file', $_SESSION['hdUpload']);        
        if(empty($filName_hed))
        {
            $result[2]=array(true,'Unable to upload the file!','alert-info');
            goto ComeHere; 
        }
        
        $FielArr=array_merge($FielArr,array(
                'header_img'=>$filName_hed
            ));
    }
	
}






switch($_REQUEST['type_id']){
    case 1:#for the file request
        if(!empty($_FILES['l_file']['name']))
        {
            $filName=upload('l_file',$_SESSION['uploader']);        
            if(empty($filName))
            {
                $result[2]=array(true,'Unable to upload the file!','alert-info');
                goto ComeHere; 
            }
            
            $FielArr=array_merge($FielArr,array(            
                'file_name'=>$filName
            ));
        }
        
    break;
    
    case 2:#for the url        
        $FielArr=array_merge($FielArr,array(            
            'url'=>$_REQUEST['l_url']
        ));
    break;
    
    case 3:#for the content
        rtfPathManage($_REQUEST['textarea2']);  
        $FielArr=array_merge($FielArr,array(            
            'source'=>htmlspecialchars($_REQUEST['l_src'],ENT_QUOTES),
            'meta_tag'=>htmlspecialchars($_REQUEST['l_mdesc'],ENT_QUOTES),            
            'details'=>$_REQUEST['textarea2'],
        ));
    break;
}

switch($_POST['lsub_type']){
    case '2':        
        $FielArr=array_merge($FielArr,array(            
            'author_name'=>$_REQUEST['au_name'],
            'pub_date'=>!empty($_REQUEST['pubDate'])?todate($_REQUEST['pubDate']):'',
        ));
    break;
    
    case '3':
        $frmVal=array_merge($frmVal,array(
            "event_name|text|n|1|500|alnum_spcA|Please enter Valid Event Name!",
            "efDate|text|n|10|10|dt|Please enter/ select Valid Date!",
            "etDate|text|n|10|10|dt|Please enter/ select Valid Date!",
        ));
        
        $FielArr=array_merge($FielArr,array(            
            'event_name'=>$_REQUEST['event_name'],
            'evef_date'=>!empty($_REQUEST['efDate'])?todate($_REQUEST['efDate']):'',
            'evet_date'=>!empty($_REQUEST['etDate'])?todate($_REQUEST['etDate']):'',
        ));
    break;
    
    default:
        
    break;
}




function _chkDupRecord($lName,$link_temp_id){
    $rs=fetchcols("web_link_temp","link_temp_id,lid,publish_by","link_temp_id=$link_temp_id and (app_reject is null || app_reject!=2)");
    if($rs[0]>0){
        #in case link has not been published 
        if(empty($rs[1][0]['publish_by']))
            return true;
        else{
            $lidQry=!empty($rs[1][0]['lid'])?" and wlf.lid={$rs[1][0][lid]}":"";
            $ChkLink1=getNameQry("select wlt.link_temp_id from web_link_temp wlt
            INNER JOIN web_links_final wlf on wlt.link_temp_id=wlf.link_temp_id
            where wlt.status='Active' and wlf.status='Active' and wlt.link_temp_id=$link_temp_id and (wlt.app_reject is null || wlt.app_reject!=2) /*and trim(lower(wlt.link_name))!=trim(lower('$lName'))*/");
            if(empty($ChkLink1)){
                return false;
            }
        }
    }
    return true;
}


// function valimp($input) {
//     // Regular expression to match only letters, numbers, and @
//     $pattern = "/^[a-zA-Z0-9@]*$/";

//     // Check if input matches the pattern
//     if (preg_match($pattern, $input)) {
//         return true;
//     } else {
//         return false;
//     }
// }

// if (valimp($input)) {
//     echo "Valid input!";
// } else {
//     echo "Invalid input! Only letters, numbers, and @ are allowed.";
// }


// $string = $_REQUEST['textarea2'];
// $char1 = "html";
// $char2 = "script";


if(isset($_REQUEST['frmType'])){

    // if (!valimp($FielArr['link_name'])) {
    //     echo "InValid input!";
    // } 
    // else
    // {

    // if (strpos($string, $char1) !== false) {
    //     echo "The string contains the character '$char1'.";
    // } 
    // elseif (strpos($string, $char2) !== false) {
    //     echo "The string contains the character '$char2'.";
    // } 
    // elseif (strpos($_REQUEST['l_key'], $char2) !== false) {
    //     echo "The string contains the character '$char2'.";
    // } 
    // elseif (strpos($_REQUEST['l_bdesc'], $char2) !== false) {
    //     echo "The string contains the character '$char2'.";
    // } 
    // elseif (strpos($_REQUEST['l_mdesc'], $char2) !== false) {
    //     echo "The string contains the character '$char2'.";
    // } 
    // elseif (strpos($_REQUEST['l_src'], $char2) !== false) {
    //     echo "The string contains the character '$char2'.";
    // } 
    // else {
        
        
    switch($_REQUEST['frmType']){
        case 1:#for the add
            if(trim($FielArr['link_alias'])==''){
            $ChkLink=getNameQry("select max(link_temp_id)as link_temp_id from web_link_temp where status='Active' and (app_reject is null || app_reject!=2) and trim(lower(link_name))=trim(lower('$FielArr[link_name]')) and trim(lower(link_alias)) is null");
        }
        else{
            $ChkLink=getNameQry("select max(link_temp_id)as link_temp_id from web_link_temp where status='Active' and (app_reject is null || app_reject!=2) and trim(lower(link_name))=trim(lower('$FielArr[link_name]')) and trim(lower(link_alias))=trim(lower('$FielArr[link_alias]'))");

            } 
            if(!empty($ChkLink)){
                //if(_chkDupRecord($FielArr['link_name'],$ChkLink)==true){
                    $result[2]=array(true,'Requested Link Name already exist!','alert-info');
                    goto ComeHere;
              //  }                                                    
            }
            $FielArr=array_merge($FielArr,array(
                'lid'=>$_REQUEST['lid'],
            ));            
            $Fields=implode(',',array_keys($FielArr));
            $Values=implode("|$$|",$FielArr);
           // echo $Fields +"<br/>"+$Values;
            $success=insert("web_link_temp",$Fields,$Values);
        break;
        
        case 2:
            /*$ChkLink=getNameQry("select max(link_temp_id)as link_temp_id from web_link_temp where status='Active' and app_reject is null and link_temp_id!=$_REQUEST[link_temp_id] and lower(trim(link_name))=lower(trim('$FielArr[link_name]'))");*/
        if(trim($FielArr['link_alias'])==''){
             $ChkLink=getNameQry("select max(link_temp_id)as link_temp_id from web_link_temp where status='Active' and app_reject is null and link_temp_id!=$_REQUEST[link_temp_id] and lower(trim(link_name))=lower(trim('$FielArr[link_name]')) and trim(lower(link_alias)) is null");
             }
             else{
                $ChkLink=getNameQry("select max(link_temp_id)as link_temp_id from web_link_temp where status='Active' and app_reject is null and link_temp_id!=$_REQUEST[link_temp_id] and lower(trim(link_name))=lower(trim('$FielArr[link_name]')) and trim(lower(link_alias))=trim(lower('$FielArr[link_alias]'))");
             }
            if(!empty($ChkLink)){
                if(_chkDupRecord($FielArr['link_name'],$ChkLink)==true){
                    #check if unpublished link already pending
                    if(!empty($_REQUEST['lid'])){
                        $cLink=getNameQry("SELECT wlt.link_temp_id,wlt.file_name from web_link_temp wlt    
                        WHERE wlt.`status`='Active' and app_reject is null  and wlt.lid=$_REQUEST[lid] order by wlt.link_temp_id desc limit 1");   
                        if(!empty($cLink)){
                            $_REQUEST['link_temp_id']=$cLink;
                            goto updatePendLink;
                        }
                    }            
                    ##########
                    $result[2]=array(true,'Requested Link Name already exist!','alert-info');
                    goto ComeHere;
                }                                                       
            }
            
          

    //         $ChkPub=simplefetch("SELECT wlt.link_temp_id,wlt.file_name from web_link_temp wlt
    // INNER JOIN web_links_final lf on lf.link_temp_id=wlt.link_temp_id
    // WHERE wlt.`status`='Active' and wlt.link_temp_id=$_REQUEST[link_temp_id]");
            
    //         if($ChkPub[0]<=0){

    //             updatePendLink:
    //             $Fields=implode('|$$|',array_keys($FielArr));
    //             $Values=implode("|$$|",$FielArr);
                
    //             $success=update("web_link_temp",$Fields,$Values,"link_temp_id=$_REQUEST[link_temp_id]",1);
 
                

    //             }
    //         else{
    //             $FielArr=array_merge($FielArr,array(
    //                 'lid'=>$_REQUEST['lid'],
    //             ));
                
    //             if(!isset($FielArr['file_name']) || empty($FielArr['file_name']))
    //                 $FielArr['file_name']=$ChkPub[1][0]['file_name'];
                    
    //             $Fields=implode(',',array_keys($FielArr));
    //             $Values=implode("|$$|",$FielArr);
                
    //            $success=insert("web_link_temp",$Fields,$Values,1);
                

    //         }
            
            

    //         $ChkPub=simplefetch("SELECT wlt.link_temp_id,wlt.file_name from web_link_temp wlt
    // INNER JOIN web_links_final lf on lf.link_temp_id=wlt.link_temp_id
    // WHERE wlt.`status`='Active' and wlt.link_temp_id=$_REQUEST[link_temp_id]");


        $sql = "SELECT wlt.link_temp_id, wlt.file_name from web_link_temp wlt INNER JOIN web_links_final lf on lf.link_temp_id=wlt.link_temp_id WHERE wlt.`status`='Active' and wlt.link_temp_id= " . (int)$_REQUEST['link_temp_id'] . ";";
        $response = simpleSelect($sql);

        if ($response && $response['status'] === 'success') {
            var_dump($response);
            foreach ($response['data'] as $row) {
                echo $row['file_name'] . "<br>";
            }
        }


if($response && $response['status'] === 'success' && count($response['data']) > 0) {
    
    echo "Record found: " . $response['data'][0]['file_name'];
                // updatePendLink:
                // $Fields=implode('|$$|',array_keys($FielArr));
                // $Values=implode("|$$|",$FielArr);
                
                // $success=update("web_link_temp",$Fields,$Values,"link_temp_id=$_REQUEST[link_temp_id]",1);


$sql = "UPDATE web_link_temp SET name = ?, age = ? WHERE link_temp_id = ?";
$types = "sii";
$values = ["Jane Doe", 28, (int)$_REQUEST['link_temp_id']];

$success = simpleUpdate($sql, $types, $values);



} else {

echo "No record found.";    

}


die();
            
            if($ChkPub[0]<=0){

                updatePendLink:
                $Fields=implode('|$$|',array_keys($FielArr));
                $Values=implode("|$$|",$FielArr);
                
                $success=update("web_link_temp",$Fields,$Values,"link_temp_id=$_REQUEST[link_temp_id]",1);
 
                

                }
            else{
                $FielArr=array_merge($FielArr,array(
                    'lid'=>$_REQUEST['lid'],
                ));
                
                if(!isset($FielArr['file_name']) || empty($FielArr['file_name']))
                    $FielArr['file_name']=$ChkPub[1][0]['file_name'];
                    
                $Fields=implode(',',array_keys($FielArr));
                $Values=implode("|$$|",$FielArr);
                
               $success=insert("web_link_temp",$Fields,$Values,1);
                

            }
                




    
            
            if($success){#in case of revive
                $RevID=getName("web_link_revive","revive_id","link_temp_id=$_REQUEST[link_temp_id] and revive_status=1");
                if(!empty($RevID)){
                    update("web_link_revive","revive_status|$$|revived_by|$$|revived_on","2|$$|$_SESSION[userid]|$$|$cDate","revive_id=$RevID and revive_status=1 and link_temp_id=$_REQUEST[link_temp_id]");
                }
            }
        break;
        
        case 3:
            $success=delete("web_link_temp","link_temp_id=$_REQUEST[link_temp_id]");
            if(!empty($_REQUEST['lid']))
                delete("web_links_final","link_temp_id=$_REQUEST[link_temp_id] and lid=$_REQUEST[lid]");
        break;
    }
    // }
}


if($success)
    $result[0]=true;

ComeHere:
echo frm_response($result);

?>