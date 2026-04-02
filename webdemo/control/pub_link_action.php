<?php 
include '../appcode/globals.inc.php';
include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');

AjaxFilePrevent();
userAuthenticationPageLevel();

$result = [0 => false];
$success = false;

function todate_safe($dateStr){
    if (empty($dateStr)) return '';
    return date('Y-m-d', strtotime($dateStr));
}

if(isset($_REQUEST['frmType']) && $_REQUEST['frmType'] == 1){
    // $frmVal = [
    //     "link_pubDate|text|y|10|10|dt|Please enter/ select Valid Date!",
    //     "link_expDate|text|n|10|10|dt|Please enter/ select Valid Date!",
    //     "link_nrevDate|text|n|10|10|dt|Please enter/ select Valid Date!",
    //  ];
    $frmVal = [
        "link_pubDate|text|y|10|10|Please enter/ select Valid Date!",
        "link_expDate|text|n|10|10|Please enter/ select Valid Date!",
        "link_nrevDate|text|n|10|10|Please enter/ select Valid Date!",
    ];
    $ValiStr = implode('|$$|',$frmVal);
    $FrmError = $chk->requestcheck($ValiStr,"formNC","div",true,true);

    if($FrmError){
        $result[1] = $FrmError;
        echo frm_response($result);
        exit;
    }
}

// -----------------------------
if(isset($_REQUEST['frmType'])){
    switch($_REQUEST['frmType']){

        case 1:
        case 9:

            $link_temp_id = intval($_REQUEST['link_temp_id']);

            // $FielArr = [
            //     'link_temp_id' => $link_temp_id,
            //     'publish_date' => !empty($_REQUEST['link_pubDate']) ? todate($_REQUEST['link_pubDate']) : '',
            //     'expiry_date' => !empty($_REQUEST['link_expDate']) ? todate($_REQUEST['link_expDate']) : '',
            //     'next_review_date' => !empty($_REQUEST['link_nrevDate']) ? todate($_REQUEST['link_nrevDate']) : '',
            //     'show_content' => $_REQUEST['l_show'] ?? '0',
            //     'feedback_required' => $_REQUEST['l_feed'] ?? '0',
            //     'publish_by' => $_SESSION['userid'],
            // ];

            $FielArr = array(
                'link_temp_id' => $_REQUEST['link_temp_id'],
                'publish_date' => !empty($_REQUEST['link_pubDate'])? date('Y-m-d'): date('Y-m-d'),                               
                'expiry_date'=>!empty($_REQUEST['link_expDate'])? date('Y-m-d'): NULL,
              //  'review_date'=>!empty($_REQUEST['link_nrevDate'])? date('Y-m-d'): NULL,
                'next_review_date'=>!empty($_REQUEST['link_nrevDate'])? date('Y-m-d'): NULL,
                'show_content' => $_REQUEST['l_show'] ?? '0',                
                'feedback_required' => $_REQUEST['l_feed'] ?? '0',                                 
                'publish_by' => $_SESSION['userid'],
            );            

            $ParLinkFileId = "";

            $lid = getName(
                "web_link_temp",
                "concat(lid,'|$$|',continuous_content,'|$$|',ifnull(main_link_temp_id,'')) as str",
                "link_temp_id=$link_temp_id"
            );
            $lid = explode('|$$|', $lid);


var_dump($lid);

            if(empty($lid[0]) || $lid[1] == 1){

                if(isset($lid[1]) == 1){

                    if(empty($lid[0])){

                        $FielArr1 = [
                            'link_temp_id' => $link_temp_id,
                            'publish_date' => !empty($_REQUEST['link_pubDate']) ? todate($_REQUEST['link_pubDate']) : '',
                            'publish_by' => $_SESSION['userid'],
                            'lid_main' => $lid[2],
                            'lid' => $link_temp_id,
                        ];

                        $success = insert("web_links_continuous", $FielArr1);

                    } else {

                        $success = update(
                            "web_links_continuous",
                            ['link_temp_id' => $link_temp_id],
                            "lc_id=$lid[0]"
                        );
                    }

                } else {

                    $chkPub = getName("web_links_final","lid","link_temp_id=$link_temp_id");

                    if(empty($chkPub)){

                        $success = insert("web_links_final", $FielArr);
                        $id = is_array($success) ? $success[0] : $success;

                        $link_temp_id2 = getName("web_links_final","link_temp_id","lid=$id",2);
                        $engid = getName("web_link_temp","eng_id","link_temp_id=$link_temp_id2",2);

                        if($_REQUEST['lang_id'] == 2){
                            simplefetchUA(
                                "UPDATE web_links_final SET hindi_id = ? WHERE lid = ?",
                                "ii",
                                [$id, $engid]
                            );
                        }

                        if($_REQUEST['lang_id'] == 3){
                            simplefetchUA(
                                "UPDATE web_links_final SET marati_id = ? WHERE lid = ?",
                                "ii",
                                [$id, $engid]
                            );
                        }

                    } else {

                        $linkParId = getName("web_links_final","link_temp_id","lid=$chkPub",1);
                        $ParLinkFileId = getName("web_link_temp","file_name","link_temp_id=$linkParId");

                        $success = update("web_links_final", $FielArr, "lid=$chkPub");

                        $engid = getName("web_link_temp","eng_id","link_temp_id=$link_temp_id");

                        if($_REQUEST['lang_id'] == 2){
                            simplefetchUA("UPDATE web_links_final SET hindi_id=? WHERE lid=?", "ii", [$lid[0], $engid]);
                        }

                        if($_REQUEST['lang_id'] == 3){
                            simplefetchUA("UPDATE web_links_final SET marati_id=? WHERE lid=?", "ii", [$lid[0], $engid]);
                        }
                    }
                }

            } else {

                $linkParId = getName("web_links_final","link_temp_id","lid=$lid[0]");
                $ParLinkFileId = getName("web_link_temp","file_name","link_temp_id=$linkParId");

                $success = update("web_links_final", $FielArr, "lid=$lid[0]");

                $engid = getName("web_link_temp","eng_id","link_temp_id=$link_temp_id");

                if($_REQUEST['lang_id'] == 2){
                    simplefetchUA("UPDATE web_links_final SET hindi_id=? WHERE lid=?", "ii", [$lid[0], $engid]);
                }

                if($_REQUEST['lang_id'] == 3){
                    simplefetchUA("UPDATE web_links_final SET marati_id=? WHERE lid=?", "ii", [$lid[0], $engid]);
                }
            }

            // -----------------------------
            if($success){

                $cDate = date('Y-m-d H:i:s');

                update("web_link_temp", [
                    'publish_by' => $_SESSION['userid'],
                    'publish_on' => $cDate
                ], "link_temp_id=$link_temp_id");

                if(!empty($ParLinkFileId)){
                    $folder = $_SESSION['uploader'];
                    $removeddir = realpath(__DIR__ . '/..') . "/WriteReadData/$folder/".$ParLinkFileId;

                    if(file_exists($removeddir)){
                        unlink($removeddir);
                    }
                }
            }

        break;
    }
}

if($success){
    $result[0] = true;
}

echo frm_response($result);