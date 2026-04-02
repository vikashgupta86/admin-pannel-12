<?php 
include '../appcode/globals.inc.php';
include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');
AjaxFilePrevent();
userAuthenticationPageLevel();

$result = array(0 => false);
$success = false;

if (isset($_REQUEST['frmType']) && $_REQUEST['frmType'] != 3) {

    $Fman = $_REQUEST['frmType'] == 2 ? 'n' : 'y';

    $frmVal = array(
        "l_bdesc|textarea|n|1|2000|alnum_spc|Please enter Valid data!",
        "l_bdesc_h|textarea|n|1|20000|alnum_spc|Please enter Valid data!",
        "l_natur|radio|y|1|2|selmin=1|Please Select atleast One option!",
        "m_type|radio|y|1|2|selmin=1|Please Select atleast One option!",
        "nmnh_type_id|text|y|1|10|num|dontselect=-1|Please enter Valid option!"
    );

    if ($_REQUEST['l_natur'] == 1) {
        $frmVal[] = "l_file|file|$Fman|5|2048|file_extn=jpg;jpeg;png;|Please Select file, Allowed extenstions are jpg, jpeg, png!";
    } 
    elseif ($_REQUEST['l_natur'] == 2) {
        if ($_REQUEST['m_type'] == 1) {
            $frmVal[] = "l_file|file|$Fman|1|20000|ext=mp4;flv;|Please Select file, Allowed extenstions are mp4, flv!";
        } 
        elseif ($_REQUEST['m_type'] == 2) {
            $frmVal[] = "l_url|text|y|1|500|url|Please enter Valid URL!";
        }
    }

    $ValiStr = implode('|$$|', $frmVal);
    $FrmError = $chk->requestcheck($ValiStr, "formNC", "div", true, true);

    if (!empty($FrmError[0])) {
        $result[1] = $FrmError;
        echo frm_response($result);
        exit;
    }

    // Secondary Validation
    $ValiStr = "m_cat_id|text|y|1|10|num|Please enter Valid option!";
    $FrmError = $chk->requestcheck($ValiStr, "formNC", "div", true, true);

    if (!empty($FrmError[0])) {
        $result[2] = array(true, 'Something went wrong, Please try again!', 'alert-info');
        echo frm_response($result);
        exit;
    }

    $FielArr = array(
        'm_cat_id' => $_REQUEST['m_cat_id'],
        'm_description' => $_REQUEST['l_bdesc'],
        'm_description_h' => htmlspecialchars($_REQUEST['l_bdesc_h'], ENT_QUOTES),
        'url' => $_REQUEST['l_url'] ?? '',
        'type_of_media' => $_REQUEST['l_natur'],
        //'m_id' => $_REQUEST['m_id'],
        'creator_id' => $_SESSION['userid'],
        'creation_date' => date('Y-m-d H:i:s'),
        'content_type' => $_REQUEST['nmnh_type_id'],
    );


    if (!empty($_FILES['l_file']['name'])) 
    {
        $allowed = ['jpeg', 'png', 'jpg'];

        $extension = pathinfo($_FILES['l_file']['name'], PATHINFO_EXTENSION);

        if(!in_array($extension, $allowed)) 
        {
            $result[2] = [true, 'Incorrect file format!', 'alert-info'];
            echo frm_response($result);
            exit;
        }
        else
        {
            $filName = upload('l_file', $_SESSION['uploader']);
            if (empty($filName)) 
            {
                $result[2] = array(true, 'Unable to upload the file!', 'alert-info');
                echo frm_response($result);
                exit;
            }

            $FielArr['image_name'] = $filName;
        }
    }
}

if (isset($_REQUEST['frmType'])) 
{
    switch ($_REQUEST['frmType']) {

    
        case 1: // Add
            $insertRes = insert("web_media_temp", $FielArr, 1);
            $success = ($insertRes !== false);
            break;

        case 2: // Update
            $ChkPub = simplefetch("SELECT m_temp_id, image_name FROM web_media_temp WHERE status='Active'AND m_temp_id=" . $_REQUEST['m_temp_id']);

            var_dump($ChkPub[1][0]['m_temp_id']);

            if (!empty($ChkPub[1][0]['m_temp_id'])) 
            {
                //$success = update("web_media_temp", $Fields, $Values, "m_temp_id=" . $_REQUEST['m_temp_id']);

                $m_temp_id = (int)$_REQUEST['m_temp_id'];
                $success = update("web_media_temp", $FielArr, "m_temp_id = $m_temp_id", 1 );
                break;
            } 
            else 
            {

                var_dump('manish');
               // $FielArr['m_id'] = $_REQUEST['m_id'];

                if (empty($FielArr['image_name'])) {
                    $FielArr['image_name'] = $ChkPub[1][0]['image_name'];
                }

                //$success = insert("web_media_temp", $FielArr, 1);
                $insertRes = insert("web_media_temp", $FielArr, 1);
                $success = ($insertRes !== false);
                break;
            }
            break;

        case 3: // Delete
            $success = delete("web_media_temp", "m_temp_id=" . $_REQUEST['m_temp_id']);
            break;
    }
}

if ($success) {
    $result[0] = true;
}

echo frm_response($result);

