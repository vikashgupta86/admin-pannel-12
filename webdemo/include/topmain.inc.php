<?php

    include __DIR__ . "/browser_info.inc.php";


    // $_SESSION['auth_seed1'] = random_int(100000, 999999);
    // $_SESSION['auth_seed']  = random_int(100000, 999999);

    // $lang = filter_input(INPUT_GET, 'lang', FILTER_VALIDATE_INT);
    // if (!$lang) {
    //     $lang = $_SESSION['lang'] ?? 1;
    // }
    // $lang = in_array($lang, [1, 2], true) ? $lang : 1;
    // $_SESSION['lang'] = $lang;

    // $altLang = ($lang === 1) ? 2 : 1;

    // $level = filter_input(INPUT_GET, 'level', FILTER_VALIDATE_INT) ?? 0;
    // $ls_id = filter_input(INPUT_GET, 'ls_id', FILTER_VALIDATE_INT);
    // $lid   = filter_input(INPUT_GET, 'lid', FILTER_VALIDATE_INT) ?? 0;
    // $vmod  = filter_input(INPUT_GET, 'vmod', FILTER_VALIDATE_INT);


    // $currentPage = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

    // $query = ['lang' => $altLang];

    // if ($ls_id !== null) {
    //     $query['level'] = $level;
    //     $query['ls_id'] = $ls_id;
    //     $query['lid']   = $lid;

    //     if ($vmod === 2) {
    //         $query['vmod'] = 2;
    //     }
    // }

    // $queryString = http_build_query($query);

    // switch ($currentPage) {
    //     case 'sitemap.php':
    //         $link = "sitemap.php?lang={$altLang}";
    //         break;

    //     case 'show_tenders.php':
    //         $link = "show_tenders.php?{$queryString}";
    //         break;

    //     default:
    //         if ($ls_id !== null) {
    //             $link = "show_content.php?{$queryString}";
    //         } else {
    //             $link = "index.php?lang={$altLang}";
    //         }
    //         break;
    // }




    // $sSeed1 = get_num();
    // $_SESSION['auth_seed1'] = $sSeed1;

    // $sSeed = get_num();
    // $_SESSION['auth_seed'] = $sSeed;

    // $_SESSION['lang'] = isset($_REQUEST['lang']) ? $_REQUEST['lang'] : $_SESSION['lang'];
    // $_SESSION['lang'] = !isset($_SESSION['lang']) || empty($_SESSION['lang']) ? 1 : $_SESSION['lang'];
    // $userid_front =  !empty($_SESSION['userid_front']) ? $_SESSION['userid_front'] : '';

    // $link = "";
    // //$sess=1;$sessnew=2;
    // if ($_SESSION['lang'] != null) {
    //     $sess = $_SESSION['lang'];
    //     if ($sess == 1) {
    //         $sessnew = 2;
    //     } else {
    //         $sessnew = 1;
    //     }
    // }


    // $level = filter_input(INPUT_GET, 'level', FILTER_VALIDATE_INT) ?? 0;
    // $ls_id = filter_input(INPUT_GET, 'ls_id', FILTER_VALIDATE_INT);
    // $lid   = filter_input(INPUT_GET, 'lid', FILTER_VALIDATE_INT) ?? 0;
    // $vmod  = filter_input(INPUT_GET, 'vmod', FILTER_VALIDATE_INT);


    // if ($ls_id !== null) {
    //     $query['level'] = $level;
    //     $query['ls_id'] = $ls_id;
    //     $query['lid']   = $lid;

    //     if ($vmod === 2) {
    //         $query['vmod'] = 2;
    //     }
    // }    

    // // $page = end(explode('/', $_SERVER["REQUEST_URI"]));
    // $page = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
    // $page2 = (explode('?', $page));
    // // echo $page2[0];


    // $append .= "lang=$sessnew&level=$_GET[level]&ls_id=$_GET[ls_id]&lid=$_GET[lid]";
    // $append2 .= "&vmod=2";


    // if ($_GET['vmod'] != null) {
    //     $append = $append . $append2;
    // }


    // if ($_GET['ls_id'] != null) {
    //     if ($page2[0] == "show_tenders.php") {
    //         $link = "show_tenders.php?" . $append;
    //         //echo $link;
    //         //  die;
    //     } else {
    //         $link = "show_content.php?" . $append;
    //     }
    // } else {
    //     if ($page2[0] == "sitemap.php") {
    //         $link = "sitemap.php?lang=$sessnew";
    //     } else if ($page2[0] == "show_tenders.php") {
    //         $link = "show_tenders.php?" . $append;
    //     } else {
    //         #$link= "index.php?lang=$sessnew&nma_type=$_SESSION[nma_type]";
    //         $link = "index.php?lang=$sessnew";
    //     }
    // }





// $sSeed1 = get_num();
// $_SESSION['auth_seed1'] = $sSeed1;

// $sSeed = get_num();
// $_SESSION['auth_seed'] = $sSeed;

// $_SESSION['lang'] = isset($_REQUEST['lang']) ? $_REQUEST['lang'] : $_SESSION['lang'];
// $_SESSION['lang'] = !isset($_SESSION['lang']) || empty($_SESSION['lang']) ? 1 : $_SESSION['lang'];
// //echo $_SESSION['lang']."</br>";
// $userid_front =  !empty($_SESSION['userid_front']) ? $_SESSION['userid_front'] : '';

// $link = "";
// //$sess=1;$sessnew=2;
// if ($_SESSION['lang'] != null) {
//   $sess = $_SESSION['lang'];
//   if ($sess == 1) {
//     $sessnew = 2;
//   } else {
//     $sessnew = 1;
//   }
// }


// $page = end(explode('/', $_SERVER["REQUEST_URI"]));

// $page2 = (explode('?', $page));

// $append .= "lang=$sessnew&level=$_GET[level]&ls_id=$_GET[ls_id]&lid=$_GET[lid]";
// $append2 .= "&vmod=2";




// if ($_GET['vmod'] != null) {
//   $append = $append . $append2;
// }
// if ($_GET['ls_id'] != null) {

//   if ($page2[0] == "show_tenders.php") {
//     $link = "show_tenders.php?" . $append;
//     //echo $link;
//     //  die;
//   } else {
//     $link = "show_content.php?" . $append;
//   }
// } else {

//   if ($page2[0] == "sitemap.php") {

//     $link = "sitemap.php?lang=$sessnew";
//   } else if ($page2[0] == "show_tenders.php") {

//     $link = "show_tenders.php?" . $append;
//   } else {


//     $link = "index.php?lang=$sessnew";
//   }
// }    



/* -------------------------------------------------
   SEEDS
------------------------------------------------- */
$sSeed1 = getNum();
$_SESSION['auth_seed1'] = $sSeed1;

$sSeed = getNum();
$_SESSION['auth_seed'] = $sSeed;


/* -------------------------------------------------
   LANGUAGE HANDLING
------------------------------------------------- */
$langRequest = $_REQUEST['lang'] ?? null;

if ($langRequest !== null) {
    $_SESSION['lang'] = (int)$langRequest;
}

if (empty($_SESSION['lang'])) {
    $_SESSION['lang'] = 1;
}

$sess = (int)$_SESSION['lang'];
$sessnew = ($sess === 1) ? 2 : 1;


/* -------------------------------------------------
   SAFE GET PARAMETERS
------------------------------------------------- */
$level = $_GET['level'] ?? '';
$ls_id = $_GET['ls_id'] ?? '';
$lid   = $_GET['lid'] ?? '';
$vmod  = $_GET['vmod'] ?? '';

$userid_front = $_SESSION['userid_front'] ?? '';


/* -------------------------------------------------
   PAGE DETECTION (SAFE VERSION)
------------------------------------------------- */
$requestUri = $_SERVER['REQUEST_URI'] ?? '';
$uriPath    = parse_url($requestUri, PHP_URL_PATH) ?? '';

$parts = explode('/', $uriPath);
$page  = end($parts);      // SAFE: $parts is a variable
$page2 = explode('?', $page); // kept for compatibility


/* -------------------------------------------------
   QUERY STRING BUILD (LEGACY COMPATIBLE STYLE)
------------------------------------------------- */
$append  = "lang={$sessnew}&level={$level}&ls_id={$ls_id}&lid={$lid}";
$append2 = "&vmod=2";

if (!empty($vmod)) {
    $append .= $append2;
}


/* -------------------------------------------------
   LINK LOGIC (PRESERVED)
------------------------------------------------- */
$link = '';

if (!empty($ls_id)) {

    if ($page2[0] === "show_tenders.php") {
        $link = "show_tenders.php?" . $append;
    } else {
        $link = "show_content.php?" . $append;
    }

} else {

    if ($page2[0] === "sitemap.php") {

        $link = "sitemap.php?lang={$sessnew}";

    } elseif ($page2[0] === "show_tenders.php") {

        $link = "show_tenders.php?" . $append;

    } else {

        $link = "index.php?lang={$sessnew}";
    }
}


function buildLangLink(string $page, int $lang, string $level, string $ls_id, string $lid, $vmod): string
{
    if ($page === 'sitemap.php') {
        return "sitemap.php?lang={$lang}";
    }

    $params = [
        'lang'  => $lang,
        'level' => $level,
        'ls_id' => $ls_id,
        'lid'   => $lid
    ];

    if (!empty($vmod)) {
        $params['vmod'] = 2;
    }

    return "show_content.php?" . http_build_query($params);
}

$englishLink = buildLangLink($page, 1, $level, $ls_id, $lid, $vmod);
$hindiLink   = buildLangLink($page, 2, $level, $ls_id, $lid, $vmod);
?>


<?php

/* ======================================================
   FETCH HEADER TOP LINKS (POS 1)
   ====================================================== */
$lang_id = (int)($_SESSION['lang'] ?? 1);
$content_type = !empty($_SESSION['userid_front']) ? 2 : 1;

$sqlHeaderTop = "
SELECT 
    lf.lid,
    ls.ls_id,
    lt.link_name,
    CASE WHEN lt.type_id!=3 THEN 'target=\"_blank\"' ELSE '' END AS l_target,
    CASE WHEN lt.type_id=1 THEN 'showfile.php'
         WHEN lt.type_id=2 THEN 'showlink.php'
         ELSE '' END AS lfile
FROM web_links_final lf
INNER JOIN web_link_temp lt ON lt.link_temp_id = lf.link_temp_id
INNER JOIN web_links_structure ls ON ls.lid = lf.lid
WHERE lf.status='Active'
AND lt.status='Active'
AND ls.status='Active'
AND ls.pos_id=1
AND ls.link_level IS NULL
AND (lf.expiry_date IS NULL OR lf.expiry_date > CURRENT_DATE())
AND lt.lang_id=?
AND lt.content_type=?
ORDER BY ls.position
";

$stmt = $conn->prepare($sqlHeaderTop);
$stmt->bind_param("ii", $lang_id, $content_type);
$stmt->execute();
$footerLinks = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();
//echo $sqlHeaderTop;
?>

    <div id="wrapper">
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
<div class="col-md-8 text-end text-body">
</div>
        <!--Tob Bar-->
        <div class="row common tobbar_main">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4"></div>
                    <div class="col-lg-6 toplinks_n">
                        <?php foreach ($footerLinks as $index => $row): ?>
                    
                            <?php
                                $url = 'show_content.php' .$row['lfile'] . '?lang=' . $lang_id .
                                       '&level=0&ls_id=' . (int)$row['ls_id'] .
                                       '&lid=' . (int)$row['lid'];
                            ?>
                    
                            <a <?= $row['l_target'] ?>
                               href="<?= htmlspecialchars($url) ?>">
                                <?= htmlspecialchars($row['link_name']) ?>
                            </a>
                    
                            <?php if ($index < count($footerLinks) - 1): ?>
                                &nbsp;&nbsp;|&nbsp;&nbsp;
                            <?php endif; ?>
                    
                        <?php endforeach; ?>
                        
                    </div>

                    <div class="col-lg-2">
                        <div class="common">
                            <div class="common-right clearfix">
                                <ul id="header-nav">
                                    <li><a title="Skip to main"><img src="../assets/img/skip-to-maincontent.svg" width="24" height="24" alt=""></a></li>
                                    
                                    <li>




                            <button type="button" id="accessButton" class="sa-widget-custom-trigger no-button" aria-label="Accessibility Options" aria-haspopup="dialog" aria-controls="sa-main" tabindex="0"><svg width="22" height="23" viewBox="0 0 22 23" fill="currentColor">
                                    <path d="M21.7598 8.37793H14.5859V22.9131H12.1943V16.2041H9.80371V22.9131H7.41211V8.37793H0.238281V6.1416H21.7598V8.37793ZM10.999 0.550781C12.3142 0.55082 13.3906 1.55719 13.3906 2.78711C13.3906 4.01699 12.3142 5.0234 10.999 5.02344C9.68385 5.02344 8.60746 4.01702 8.60742 2.78711C8.60742 1.55716 9.68382 0.550781 10.999 0.550781Z"></path>
                            </svg></button>



                                        <!-- <a title="Social Media's" id="toggleSocial" href="javascript:void(0);"><img src="../assets/img/accessibility_icon.SVG" width="24" height="24"></a>
                                        <ul>
                                            <h1>Accessibility Tools</h1>
                                        
                                            <h2>Color Contrast</h2>
                                            <li><a href="#" ><img src="../assets/img/dark_contrast.svg"><span>High Contrast</span></a></li>
                                            <li><a href="#" ><img src="../assets/img/links2.svg"><span>Normal Contrast</span></a></li>
                                            <li><a href="#" ><img src="../assets/img/links.svg"><span>Highlight Links</span></a></li>
                                            <li><a href="#" ><img src="../assets/img/Invert.svg"><span>Invert</span></a></li>
                                            <li><a href="#" ><img src="../assets/img/Saturation.svg"><span>Saturation</span></a></li>
                                        
                                            <h2>Text Size</h2>
                                            <li><a href="#" ><img src="../assets/img/Font Size Increase.svg"><span>Font Size Increase</span></a></li>
                                            <li><a href="#" ><img src="../assets/img/font-minus.svg"><span>Font Size Decrease</span></a></li>
                                            <li><a href="#" ><img src="../assets/img/Font_normal.svg"><span>Font Size Normal</span></a></li>
                                            <li><a href="#" ><img src="../assets/img/Text Spacing.svg"><span>Text Spacing</span></a></li>
                                            <li><a href="#" ><img src="../assets/img/Line Height.svg"><span>Line Height</span></a></li>
                                        
                                            <h2>Ohter Links</h2>
                                            <li><a href="#" ><img src="../assets/img/Hide Images.svg"><span>Hide Images</span></a></li>
                                            <li><a href="#" ><img src="../assets/img/Big Cursor.svg"><span>Big Cursor</span></a></li>
                                        </ul> -->
                                    </li>

                                    <li class="hindi">
                                        <a title="Language" id="toggleSocial" href="javascript:void(0);" style="text-decoration: none; "><img src="../assets/img/language-select.svg" width="24" height="24"></a>
                                   <ul class="language_bar">
    <li>
        <a title="Link to English version" href="<?= htmlspecialchars($englishLink) ?>">
            English
        </a>
    </li>
    <li>
        <a title="Link to Hindi version" href="<?= htmlspecialchars($hindiLink) ?>">
            हिंदी में
        </a>
    </li>
</ul> </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Tob Bar-->

        <!-- Start header -->
        <div class="container-fluid px-5 py-0 d-lg-block">
            <div class="row header_main">
                <div class="col-md-6 emblemb text-md-start"><a title="Bureau of Energy Efficiency (BEE)" href="index.php"><img alt="Bureau of Energy Efficiency (BEE)" src="../assets/img/new_logo_main.png" alt="Logo"></a></div>
                <div class="col-md-6 text-center d-none ">
                    
                    <a target="_blank" href="https://amritkaal.nic.in/"><img src="../assets/img/azadi.jpg" alt=""></a>
                   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <a target="_blank" href="https://swachhbharatmission.ddws.gov.in/"><img src="../assets/img/226.jpg" alt=""></a>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <a target="_blank" href="https://india.gov.in"><img src="../assets/img/emblemBEE.png" style="height:90px;" alt=""></a>
                </div>
            </div>
        </div>
        <!-- End header -->


        <!--Navigation bar-->
        <noscript>
	        <p class="">
		        This page is trying to run JavaScript and your browser either does not support JavaScript or you may have turned-off JavaScript.
    		    If you have disabled JavaScript on your computer, please turn on JavaScript, to have proper access to this page.
	        </p>
        </noscript>

        <!-- Navbar & Hero Start -->
    <?php include __DIR__ . '/navigation.inc.php'; ?>