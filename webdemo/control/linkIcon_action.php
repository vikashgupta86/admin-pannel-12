<?php 
include '../appcode/globals.inc.php';
include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');
AjaxFilePrevent();
userAuthenticationPageLevel();

$result=array(0=>false);

$Fman=$_REQUEST['frmType']==2?'n':'y';

$frmVal=array(        
    "l_file|file|$Fman|1|5000|file_extn=jpg;jpeg;png;|Please Select file, Allowed extenstions are jpg, jpeg, png!"
);

$ValiStr=implode('|$$|',$frmVal);
$FrmError=$chk->requestcheck($ValiStr,"formNC","div",true,true);

// if($FrmError[0]){
//     $result[0]=false;
//     $result[1]=$FrmError;
// }
// else{

    $frmVal=array(        
        "lid|text|y|1|10|num|Please enter Valid option!",
    );

    $ValiStr=implode('|$$|',$frmVal);
    $FrmError=$chk->requestcheck($ValiStr,"formNC","div",true,true);

    // if($FrmError[0]){
    //     $result[2]=array(true,'Something went wrong, Please try again!','alert-info');
    // }else{

        if(!empty($_FILES['l_file']['name']))
        {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
            $allowedExt = ['jpg', 'jpeg', 'png'];

            $fileTmp = $_FILES['l_file']['tmp_name'];
            $fileName = $_FILES['l_file']['name'];
            $fileExt = pathinfo($_FILES['l_file']['name'], PATHINFO_EXTENSION);
            $fileType = mime_content_type($fileTmp);

            if (!in_array($fileType, $allowedTypes) || !in_array($fileExt, $allowedExt)) {
                $result[2] = [true, 'Incorrect file format!', 'alert-info'];
                    
            }
            elseif (substr_count($fileName, '.') > 1) 
            {
                $result[2] = [true, 'Multiple extensions are not allowed!', 'alert-info'];
               
            }
            else
            {
                $filName=upload('l_file',$_SESSION['uploader']);        

                if(empty($filName)){
                    $result[2]=array(true,'Unable to upload the file!','alert-info');
                }
                else{
                    $FielArr=array(
                        'icon_name'=>$filName
                    );
                }
            }
        }

        if(isset($_REQUEST['frmType']) && !empty($FielArr)){
            switch($_REQUEST['frmType']){
                case 1:#for the add
                case 2:#update
                    $Fields=implode('|$$|',array_keys($FielArr));
                    $Values=implode("|$$|",$FielArr);

                    //$success=update("web_links_final",$Fields,$Values,"lid=$_REQUEST[lid]");
                    $lid = (int)$_REQUEST['lid'];
                    $success = update("web_links_final", $FielArr, "lid = $lid", 1 );

                break;

                case 3:
                    $success=update("web_links_final","icon_name","","lid=$_REQUEST[lid]");

                    $lid = (int)$_REQUEST['lid'];
                    $success = update("web_links_final", "icon_name", "lid = $lid", 1 );

                break;
            }

            if($success){
                $result[0]=true;
            }
        }

    //}
//}

echo frm_response($result);