<?php include '../appcode/globals.inc.php';
include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');
AjaxFilePrevent();
userAuthenticationPageLevel();
$result=array(0=>false);
$cDate = date('Y-m-d H:i:s');

if(isset($_REQUEST['frmType'])&& $_REQUEST['frmType']!=3)
{
    $Fman=$_REQUEST['frmType']==2?'n':'y';
    // $frmVal=array(        
    //     "l_name|text|y|1|500|alnum_spc|Please enter Valid Tender Name!",        
    //     "l_title|text|y|1|500|alnum_spc|Please enter Valid Tender Title!",
    //     "l_bdesc|textarea|n|1|2000|alnum_spc|Please enter Valid data!",
    //     "l_key|textarea|n|1|2000|alnum_spc|Please enter Valid data!",
    //     "l_file|file|$Fman|1|30000|file_extn=pdf;|Please Select file, Only PDF is allowed!",
    //     "l_src|textarea|n|1|2000|alnum_spc|Please enter Valid Source!",
    //     "l_mdesc|textarea|n|1|2000|alnum_spc|Please enter Valid data!",
    //     "textarea2|textarea|y|1|500000|rtf|Please enter Valid data!",
    //     /*"link_pubDate|text|y|10|10|dt|Please enter/ select Valid Date!",*/
    //     /*"ptime|text|n|5|5|ti|Please enter/ select Valid Time!",*/
    //   //  "t_cloDate|text|n|10|10|dt|Please enter/ select Valid Date!",
    //     "ctime|text|n|5|5|ti|Please enter/ select Valid Time!",
    //   //  "t_openDate|text|n|10|10|dt|Please enter/ select Valid Date!",
    //     "otime|text|n|5|5|ti|Please enter/ select Valid Time!",
    //     "l_file|file|$Fman|5|30000|file_extn=pdf;|Please Select file,Filename should not contain any special character and white space. Invalid Filename! Allowed extenstions are pdf!"
    // );
    

    // $ValiStr=implode('|$$|',$frmVal);
    // $FrmError=$chk->requestcheck($ValiStr,"formNC","div",true,true);
    // if($FrmError){
    //     $result[0]=false;
    //     $result[1]=$FrmError;
    //    // goto ComeHere;        
    // }
    rtfPathManage($_REQUEST['textarea2']);
    $FielArr=array(
        't_cat_id'=>$_REQUEST['t_cat_id'],   
        'tender_name' => htmlspecialchars($_REQUEST['l_name'], ENT_QUOTES),
        'title' => htmlspecialchars($_REQUEST['l_title'], ENT_QUOTES),
        'bdesc' => htmlspecialchars($_REQUEST['l_bdesc'], ENT_QUOTES),
        'keywords' => htmlspecialchars($_REQUEST['l_key'], ENT_QUOTES),
        'creator_id'=>$_SESSION['userid'],
        'creation_date'=> $cDate,
        'source' => htmlspecialchars($_REQUEST['l_src'], ENT_QUOTES),
        'meta_tag' => htmlspecialchars($_REQUEST['l_mdesc'], ENT_QUOTES),
        'details'=>$_REQUEST['textarea2'],
        'pub_date'=>!empty($_REQUEST['link_pubDate']) ? $_REQUEST['link_pubDate']:'',
        'pub_time'=> $_REQUEST['ptime'],
        'close_date'=>!empty($_REQUEST['t_cloDate'])?$_REQUEST['t_cloDate']:'',
        'close_time'=>$_REQUEST['ctime'],
        'open_date'=>!empty($_REQUEST['t_openDate'])? $_REQUEST['t_openDate']:'',
        'open_time'=>$_REQUEST['otime'],                
        't_num'=>$_REQUEST['t_num'],     
        //'l_bdesc' => htmlspecialchars($_REQUEST['l_bdesc'],ENT_QUOTES),       
    );
}


//print_r($FielArr); die();
    if(!empty($_FILES['l_file']['name']))
    {
        $allowedTypes = ['application/pdf'];
        $allowedExt = ['pdf'];

        $fileTmp = $_FILES['l_file']['tmp_name'];
        $fileName = $_FILES['l_file']['name'];
        $fileExt = pathinfo($_FILES['l_file']['name'], PATHINFO_EXTENSION);
        $fileType = mime_content_type($fileTmp);


        if (!in_array($fileType, $allowedTypes) || !in_array($fileExt, $allowedExt)) 
        {
            $result[2] = [true, 'Incorrect file format!', 'alert-info'];
            echo frm_response($result);
            exit;
        }
        elseif(substr_count($fileName, '.') > 1) 
        {
            $result[2] = [true, 'Multiple extensions are not allowed!', 'alert-info'];
            echo frm_response($result);
            exit;
        }
        else
        {
            $filName = upload('l_file',$_SESSION['uploader']);        
            if(empty($filName)){
                $result[2]=array(true,'Unable to upload the file!','alert-info');
            // goto ComeHere; 
            }
        
            $FielArr=array_merge($FielArr,array(            
                'file_name'=>$filName
            ));
        }
    }



if(isset($_REQUEST['frmType'])){
    switch($_REQUEST['frmType']){
        case 1:#for the add
            $ChkLink= getNameQry("select t_temp_id from web_tender_temp where status='Active' and corrigendum is null and app_reject is null and trim(lower(tender_name))=trim(lower('$_REQUEST[l_name]'))");
            if(!empty($ChkLink)){
                $result[2]=array(true,'Requested Tender Name already exist!','alert-info');
               // goto ComeHere;                                                        
            }

            if(!empty($_REQUEST['t_id']))
            {
                $FielArr=array_merge($FielArr,array(
                    't_id' => $_REQUEST['t_id'],
                ));
            }
                        
           
            
            //$success = insert("web_tender_temp",$Fields,$Values);

            $success = insert("web_tender_temp", $FielArr, 1);
        
        break;
        
        case 2:
            $ChkLink = getNameQry("select t_temp_id from web_tender_temp where status='Active' and corrigendum is null and app_reject is null and t_temp_id!= ".$_REQUEST['t_temp_id']. " and lower(trim(tender_name))=lower(trim(".$_REQUEST['l_name']."))");
            if(!empty($ChkLink)){
                $result[2]=array(true,'Requested Tender Name already exist!','alert-info');
                //goto ComeHere;                                                        
            }
            
            $ChkPub= simplefetch("SELECT tt.t_temp_id,tt.file_name from web_tender_temp tt INNER JOIN web_tender_final tf on tf.t_temp_id=tt.t_temp_id WHERE tt.`status`='Active' and tt.t_temp_id= ".$_REQUEST['t_temp_id']."");

           // print_r($ChkPub[0]); die();

            if($ChkPub[0] > 0){
               
                $ttempid = $_REQUEST['t_temp_id'];
                $success = update("web_tender_temp", $FielArr, "t_temp_id = $ttempid", 1 );

                //$success= update("web_tender_temp",$Fields,$Values,"t_temp_id=$_REQUEST[t_temp_id]");
            }
           
            
            if($success){#in case of revive
                $RevID= getName("web_tender_revive","t_revive_id","t_temp_id=$_REQUEST[t_temp_id] and revive_status=1");
                if(!empty($RevID))
                {
                    $FielArr =array(
                        'revive_status'=> 2,
                        'revived_by' => $_SESSION['userid'],
                        'revived_on' => date('Y-m-d H:i:s'),
                        'app_reject'=>1
                    );

                     $ttmpid = $_REQUEST['t_temp_id'];

                   // $success = update("web_tender_revive", $FielArr, "t_temp_id = $ttmpid", 1 );

                    $updatetndrcat = "UPDATE web_tender_revive SET revive_status = ?, revived_by = ?, revived_on = ? WHERE t_revive_id = ? AND revive_status = ? AND t_temp_id = ?";
                    $success = simplefetchUA($updatetndrcat, "issiii", [2,$_SESSION['userid'], $cDate, 1, $ttmpid]);

                   // update("web_tender_revive","revive_status|$$|revived_by|$$|revived_on","2|$$|$_SESSION[userid]|$$|$cDate","t_revive_id=$RevID and revive_status=1 and t_temp_id=$_REQUEST[t_temp_id]");
                }
            }
        break;
        
        case 3:
             $ttmpid = $_REQUEST['t_temp_id'];
            $success = delete("web_tender_temp", "t_temp_id = $ttmpid", 1 );
            //$success=delete("web_tender_temp","t_temp_id=$_REQUEST[t_temp_id]");
        break;
    }
}

if($success)
    $result[0]=true;

//ComeHere:
echo frm_response($result);