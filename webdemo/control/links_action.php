<?php

    include '../appcode/globals.inc.php';
    include_once(dirname_r(__FILE__, 1) . '/include/include.inc.php');

    AjaxFilePrevent();
    userAuthenticationPageLevel();

    $result = [0 => false];
    $success = false;
    $cDate = curdatetime();


    do {
        if (isset($_REQUEST['frmType']) && $_REQUEST['frmType'] != 3) {
            // $frmVal = [
            //     "type_id|text|y|1|10|num|dontselect=-1|Please enter Valid option!",
            //     "l_name|text|y|1|500|alnum_spcA|Please enter Valid Link Name!",
            //     "l_alias|text|n|1|500|alnum_spcA|Please enter Valid Link Name!",
            //     "l_title|text|y|1|500|alnum_spc|Please enter Valid Link Title!",
            //     "l_bdesc|textarea|n|1|2000|alnum_spcA|Please enter Valid data!",
            //     "l_key|textarea|n|1|2000|rtf|Please enter Valid data!",
            //     "Engid|text|n|1|10|num|dontselect=-1|Please enter Valid option!",
            //     "nmnh_type_id_si|text|y|1|10|num|dontselect=-1|Please enter Valid option!",
            // ];
            
            
            $frmVal = [
                "type_id|text|y|1|10|num|dontselect=-1|Please enter Valid option!",
                "l_name|text|y|1|500|Please enter Valid Link Name!",
                "l_alias|text|n|1|500|Please enter Valid Link Name!",
                "l_title|text|y|1|500|Please enter Valid Link Title!",
                "l_bdesc|textarea|n|1|2000|Please enter Valid data!",
                "l_key|textarea|n|1|2000|rtf|Please enter Valid data!",
                "Engid|text|n|1|10|num|dontselect=-1|Please enter Valid option!",
                "nmnh_type_id_si|text|y|1|10|num|dontselect=-1|Please enter Valid option!",
            ];

            switch ($_REQUEST['type_id']) {
                case 1:
                    $Fman = $_REQUEST['frmType'] == 2 ? 'n' : 'y';
                    $frmVal[] = "l_file|file|$Fman|1|20000|file_extn=pdf;|Please Select file, Only PDF allowed!";
                break;

                case 2:
                    $frmVal[] = "l_url|text|y|1|500|url|Please enter Valid URL!";
                break;

                case 3:
                    $frmVal[] = "l_src|textarea|n|1|2000|alnum_spc|Please enter Valid Source!";
                    $frmVal[] = "l_mdesc|textarea|n|1|2000|alnum_spc|Please enter Valid data!";
                    $frmVal[] = "textarea2|text|y|1|50000|rtf|Please enter Valid data!";
                break;
            }

            switch ($_POST['lsub_type']) {
                case '2':
                    $frmVal[] = "au_name|text|y|1|500|alnum_spcA|Please enter Valid Author Name!";
                    $frmVal[] = "pubDate|text|y|10|10|dt|Please enter Valid Date!";
                break;

                case '3':
                    $frmVal[] = "event_name|text|y|1|500|alnum_spcA|Please enter Valid Event Name!";
                    $frmVal[] = "efDate|text|y|10|10|dt|Please enter Valid Date!";
                    $frmVal[] = "etDate|text|n|10|10|dt|Please enter Valid Date!";
                break;
            }

            $ValiStr = implode('|$$|', $frmVal);
            $FrmError = $chk->requestcheck($ValiStr, "formNC", "div", true, true);

            if ($FrmError[0] ?? false) {
                $result[1] = $FrmError;
                break;
            }

    $FielArr = [
        'type_id'       => (int)trim($_REQUEST['type_id']),
        'lang_id'       => (int)trim($_REQUEST['lang_id']),
        'link_name'      => htmlspecialchars($_REQUEST['l_name'], ENT_QUOTES),
        'link_alias'      => htmlspecialchars($_REQUEST['l_alias'], ENT_QUOTES),
        'title'      => htmlspecialchars($_REQUEST['l_title'], ENT_QUOTES),
        'link_bdesc'      => htmlspecialchars($_REQUEST['l_bdesc'], ENT_QUOTES),
        'keywords'      => htmlspecialchars($_REQUEST['l_key'], ENT_QUOTES),
        // 'link_name'     => strip_tags(trim($_REQUEST['l_name'])),
        // 'link_alias'    => strip_tags(trim($_REQUEST['l_alias'])),
        // 'title'         => strip_tags(trim($_REQUEST['l_title'])),
        // 'link_bdesc'    => strip_tags(trim($_REQUEST['l_bdesc'])),
        // 'keywords'      => strip_tags(trim($_REQUEST['l_key'])),
        'creator_id'    => $_SESSION['userid'],
        'creation_date' => $cDate,
        'l_sub_type'    => isset($_POST['lsub_type']) ? trim($_POST['lsub_type']) : null,
        'eng_id'        => !empty($_POST['Engid']) ? (int)trim($_POST['Engid']) : null,
        'content_type'  => (int)trim($_REQUEST['nmnh_type_id_si']),
        'status'        => 'Active'
    ];

        
            if (!empty($_FILES['header_l_file']['name'])) 
            {
                
                $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                $allowedExt = ['jpg', 'jpeg', 'png'];

                $fileTmp = $_FILES['header_l_file']['tmp_name'];
                $fileName = $_FILES['header_l_file']['name'];
                $fileExt = pathinfo($_FILES['header_l_file']['name'], PATHINFO_EXTENSION);
                $fileType = mime_content_type($fileTmp);

                if (!in_array($fileType, $allowedTypes) || !in_array($fileExt, $allowedExt)) {
                    $result[2] = [true, 'Incorrect file format!', 'alert-info'];
                        break;
                }
                elseif (substr_count($fileName, '.') > 1) 
                {
                    $result[2] = [true, 'Multiple extensions are not allowed!', 'alert-info'];
                    break;
                }
                else
                {
                    $filName = upload('header_l_file', $_SESSION['hdUpload']);
                    if (empty($filName)) {
                        $result[2] = [true, 'Unable to upload header image!', 'alert-info'];
                        break;
                    }
                    $FielArr['header_img'] = $filName;
                }
            }

            if (!empty($_FILES['l_file']['name'])) 
            {
                $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'application/pdf'];
                $allowedExt = ['jpg', 'jpeg', 'png', 'pdf'];

                $fileTmp = $_FILES['l_file']['tmp_name'];
                $ffileName = $_FILES['l_file']['name'];
                $fileExt = pathinfo($_FILES['l_file']['name'], PATHINFO_EXTENSION);
                $fileType = mime_content_type($fileTmp);

                if (!in_array($fileType, $allowedTypes) || !in_array($fileExt, $allowedExt)) {
                    $result[2] = [true, 'Incorrect file format!', 'alert-info'];
                    break;
                }
                elseif(substr_count($ffileName, '.') > 1) 
                {
                    $result[2] = [true, 'Multiple extensions are not allowed!', 'alert-info'];
                    break;
                }
                else
                {

                    // $filName = upload('l_file', $_SESSION['uploader']);
                    // if (empty($filName)) {
                    //     $result[2] = [true, 'Unable to upload file!', 'alert-info'];
                    //     break;
                    // }
                    // $FielArr['file_name'] = $filName;
                }
            }
        }

        #   ===================== | TYPE BASED DATA | =====================
        switch (isset($_REQUEST['type_id']) ? (int)trim($_REQUEST['type_id']) : null) {
            case 1:
                if (!empty($_FILES['l_file']['name'])) 
                {
                    $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'application/pdf'];
                    $allowedExt = ['jpg', 'jpeg', 'png', 'pdf'];

                    $fileTmp = $_FILES['l_file']['tmp_name'];
                    $ffileName = $_FILES['l_file']['name'];
                    $fileExt = pathinfo($_FILES['l_file']['name'], PATHINFO_EXTENSION);
                    $fileType = mime_content_type($fileTmp);

                    if (!in_array($fileType, $allowedTypes) || !in_array($fileExt, $allowedExt)) {
                        $result[2] = [true, 'Incorrect file format!', 'alert-info'];
                        break;
                    }
                    elseif(substr_count($ffileName, '.') > 1) 
                    {
                        $result[2] = [true, 'Multiple extensions are not allowed!', 'alert-info'];
                        break;
                    }
                    else
                    {

                        $filName = upload('l_file', $_SESSION['uploader']);
                        if (empty($filName)) {
                            $result[2] = [true, 'Unable to upload file!', 'alert-info'];
                            break;
                        }
                        $FielArr['file_name'] = $filName;
                    }
                }
            break;

            case 2:
                $FielArr['url'] = $_REQUEST['l_url'];
            break;

            case 3:
                rtfPathManage($_REQUEST['textarea2']);
                $FielArr['source']   = htmlspecialchars($_REQUEST['l_src'], ENT_QUOTES);
                $FielArr['meta_tag'] = htmlspecialchars($_REQUEST['l_mdesc'], ENT_QUOTES);
                $FielArr['details']  = $_REQUEST['textarea2'];
            break;
        }

        #   ===================== | SUB TYPE DATA | =====================
        switch (isset($_POST['lsub_type']) ? trim($_POST['lsub_type']) : null) {
            case '2':
                $FielArr['author_name'] = $_REQUEST['au_name'];
                $FielArr['pub_date']    = !empty($_REQUEST['pubDate']) ? todate($_REQUEST['pubDate']) : '';
            break;
            case '3':
                $FielArr['event_name'] = $_REQUEST['event_name'];
                $FielArr['evef_date']  = !empty($_REQUEST['efDate']) ? todate($_REQUEST['efDate']) : '';
                $FielArr['evet_date']  = !empty($_REQUEST['etDate']) ? todate($_REQUEST['etDate']) : '';
            break;
        }

        #   ===================== | MAIN ACTION | =====================
        if (isset($_REQUEST['frmType'])) {
            switch ($_REQUEST['frmType']) {
            #   ================= ADD =================
            case 1:
                $FielArr['lid'] = !empty($_POST['lid']) ? (int)$_POST['lid'] : null;

                $ChkPub = simplefetch("SELECT link_temp_id FROM web_link_temp WHERE status = 'Active' AND link_name = ? AND link_alias = ?;", 
                        "ss", [$FielArr['link_name'], $FielArr['link_alias']]);
                    
                    # If the link already exists, we check if it's published. If published, we show a message. If not published, we allow the insert to proceed.
                    if (!empty($ChkPub) && $ChkPub[0] > 0) { 

                        $result[2] = [true, 'The same link is already published. If you want to update the link, please go to the edit section.', 'alert-info'];
                    } else {
                    $insertRes = insert("web_link_temp", $FielArr, 1);
                    $success = ($insertRes !== false);
                }       
            break;
            # ================= UPDATE ================= */
            case 2:
                $link_temp_id = (int)$_REQUEST['link_temp_id'];
                $ChkPub = simplefetch("SELECT wlt.link_temp_id, wlt.file_name FROM web_link_temp wlt INNER JOIN web_links_final lf ON lf.link_temp_id = wlt.link_temp_id
                     WHERE wlt.status = 'Active' AND wlt.link_temp_id = ?", "i", [$link_temp_id]);
                if (!$ChkPub || $ChkPub[0] <= 0) {
                    $success = update("web_link_temp", $FielArr, "link_temp_id = $link_temp_id", 1);
                } else {
                    $FielArr['lid'] = !empty($_POST['lid']) ? (int)$_POST['lid'] : null;
                    if (empty($FielArr['file_name']) && isset($ChkPub[1][0]['file_name'])) {
                        $FielArr['file_name'] = $ChkPub[1][0]['file_name'];
                    }
                    $insertRes = insert("web_link_temp", $FielArr, 1);
                    $success = ($insertRes !== false);
                }
                if ($success) {
                    $RevID = getName("web_link_revive", "revive_id", "link_temp_id=$link_temp_id AND revive_status=1");

                    if (!empty($RevID)) {
                        update(
                            "web_link_revive",
                            [
                                'revive_status' => 2,
                                'revived_by'    => $_SESSION['userid'],
                                'revived_on'    => $cDate
                            ],
                            "revive_id=$RevID AND revive_status=1",
                            1
                        );
                    }
                }

            break;


            case 3:

                delete("web_link_temp", "link_temp_id=" . (int)$_REQUEST['link_temp_id']);

                if (!empty($_REQUEST['lid'])) {
                    delete(
                        "web_links_final",
                        "link_temp_id=" . (int)$_REQUEST['link_temp_id'] .
                        " AND lid=" . (int)$_REQUEST['lid']
                    );
                }

                $success = true;


                echo json_encode([
                    'success' => true,
                    'message' => 'Delete functionality is currently disabled for testing purposes.'
                ]);
            break;
        }
    }
    } while (0);

    if ($success) {
        $result[0] = true;
    }

    echo frm_response($result);
//var_dump($result);

