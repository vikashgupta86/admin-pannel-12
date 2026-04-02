<?php 
include '../appcode/globals.inc.php';
include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');

AjaxFilePrevent();
userAuthenticationPageLevel();

$result = array(0 => false);

$Fman  = $_REQUEST['frmType'] == 2 ? 'n' : 'y';
$Fman1 = $_REQUEST['frmType'] == 3 ? 'n' : 'y';

// $frmVal = array(
//     "l_file|file|$Fman|1|5000|file_extn=jpg;jpeg;png;|Please Select file, Allowed extenstions are jpg, jpeg, png!"
// );

// $ValiStr  = implode('|$$|', $frmVal);
// $FrmError = $chk->requestcheck($ValiStr, "formNC", "div", true, true);

// if ($FrmError[0]) {
//     $result[1] = $FrmError;
//     var_dump($result);
//     exit;
// }

$FielArr = array(
    // 'cat_name' => htmlspecialchars($_REQUEST['c_name'], ENT_QUOTES, 'UTF-8'),
    'cat_name'      => htmlspecialchars($_REQUEST['c_name'], ENT_QUOTES),
    'cat_name_h'    => htmlspecialchars($_REQUEST['hc_name'], ENT_QUOTES),
    'creator_id'    => $_SESSION['userid'],
    'creation_date' => date('Y-m-d H:i:s'),
);

if (isset($_REQUEST['frmType'])) {

    switch ($_REQUEST['frmType']) {

        case 1: // add
            $ChkCat = getNameQry("select m_cat_id from web_media_category where status='Active' and app_reject is null and lower(trim(cat_name))=lower(trim('$_REQUEST[c_name]'))");

            if (!empty($ChkCat)) {
                $result[2] = array(true, 'Requested Category already exist!', 'alert-info');
                echo frm_response($result);
                exit;
            }
        break;

        case 2: // update
            $ChkCat = getNameQry("select m_cat_id from web_media_category where status='Active' and app_reject is null and m_cat_id!=$_REQUEST[m_cat_id] and lower(trim(cat_name))=lower(trim('$_REQUEST[c_name]'))");

            if (!empty($ChkCat)) {
                $result[2] = array(true, 'Requested Category already exist!', 'alert-info');
                echo frm_response($result);
                exit;
            }
        break;
    }
}

if (!empty($_FILES['l_file']['name'])) 
{
    $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/PNG'];
    $allowedExt = ['jpg', 'jpeg', 'png', 'pdf', 'PNG'];

    $fileTmp = $_FILES['l_file']['tmp_name'];
    $ffileName = $_FILES['l_file']['name'];
    $fileExt = pathinfo($_FILES['l_file']['name'], PATHINFO_EXTENSION);
    $fileType = mime_content_type($fileTmp);

    if (!in_array($fileType, $allowedTypes) || !in_array($fileExt, $allowedExt)) 
    {
        $result[2] = [true, 'Incorrect file format!', 'alert-info'];
            echo frm_response($result);
            exit;
    }
    elseif(substr_count($ffileName, '.') > 1) 
    {
        $result[2] = [true, 'Multiple extensions are not allowed!', 'alert-info'];
            echo frm_response($result);
            exit;
    }
    else
    {
        $filName = upload('l_file', $_SESSION['uploader']);

        if (empty($filName)) {
            $result[2] = array(true, 'Unable to upload the file!', 'alert-info');
            echo frm_response($result);
            exit;
        }

        $FielArr = array_merge($FielArr, array(
            'img_name' => $filName
        ));
    }
}

if (isset($_REQUEST['frmType'])) {

    switch ($_REQUEST['frmType']) 
    {

        case 1: // add
            // $Fields  = implode(',', array_keys($FielArr));
            // $Values  = implode("|$$|", $FielArr);
            //$success = insert("web_media_category", $Fields, $Values);
            $insertRes = insert("web_media_category", $FielArr, 1);
            $success = ($insertRes !== false);
            break;
        break;

        case 2: // update
            // $Fields  = implode('|$$|', array_keys($FielArr));
            // $Values  = implode("|$$|", $FielArr);
            // $success = update("web_media_category", $Fields, $Values, "m_cat_id=$_REQUEST[m_cat_id]");
            $m_cat_id = (int)$_REQUEST['m_cat_id'];
            $success = update("web_media_category", $FielArr, "m_cat_id = $m_cat_id", 1 );
            break;
        case 3: // delete
            $success = delete("web_media_category", "m_cat_id=$_REQUEST[m_cat_id]");
        break;
    }
}

if (!empty($success)) {
    $result[0] = true;
}


echo frm_response($result);
