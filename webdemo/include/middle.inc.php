<?php
$conn = db_connect();
$lang_id      = (int)($_SESSION['lang'] ?? 1);
$content_type = !empty($_SESSION['userid_front']) ? 2 : 1;
$pos_id       = 4;

// Different SQL query based on language
if ($lang_id == 1) {
    // English (lang_id=1) - Direct link_temp_id match with structure
    $sql = "SELECT lf.lid, lf.icon_name, ls.ls_id, ls.parent_ls_id, ls.position, ls.link_level,
    lt.link_name, lt.meta_tag, lt.link_bdesc, lt.details, lt.type_id, lt.url, lt.file_name,
    CASE 
    WHEN lt.type_id = 1 THEN CONCAT('WriteReadData/L45218/', lt.file_name)
    WHEN lt.type_id = 2 THEN lt.url
    ELSE '' 
END AS lfile,
CASE 
    WHEN lt.type_id = 1 OR lt.type_id = 2 THEN 'target=\"_blank\"' 
    ELSE '' 
END AS l_target
    FROM web_links_final lf
    INNER JOIN web_link_temp lt ON lt.link_temp_id = lf.link_temp_id
    INNER JOIN web_links_structure ls ON ls.lid = lf.lid
    WHERE lf.status = 'Active'
    AND lt.status = 'Active'
    AND ls.status = 'Active'
    AND lt.lang_id = ?
    AND lt.content_type = ?
    AND (lf.expiry_date IS NULL OR lf.expiry_date > CURRENT_DATE())
    AND (
    (ls.pos_id IN (?, 7) AND ls.link_level IS NULL)
    OR
    (ls.parent_ls_id IN (SELECT ls2.ls_id FROM web_links_structure ls2 WHERE ls2.pos_id IN (?, 7)))
    OR
    (ls.link_level = 2)
    )
    ORDER BY ls.position ASC";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiii", $lang_id, $content_type, $pos_id, $pos_id);
} else {
    // Hindi (lang_id=2) - Use hindi_id from web_links_final to get English structure
    // KEY CHANGE: INNER JOIN ensures ONLY links with Hindi translation are shown
    $sql = "SELECT lf_eng.lid, lf_eng.icon_name, ls.ls_id, ls.parent_ls_id, ls.position, ls.link_level,
    lt_hindi.link_name, lt_hindi.meta_tag, lt_hindi.link_bdesc, lt_hindi.details, lt_hindi.type_id, lt_hindi.url, lt_hindi.file_name,
    CASE WHEN lt_hindi.type_id != 3 THEN 'target=\"_blank\"' ELSE '' END AS l_target,
    CASE WHEN lt_hindi.type_id = 1 THEN 'showfile.php'
    WHEN lt_hindi.type_id = 2 THEN 'showlink.php'
    ELSE '' END AS lfile
    FROM web_links_final lf_hindi
    INNER JOIN web_link_temp lt_hindi ON lt_hindi.link_temp_id = lf_hindi.link_temp_id
    INNER JOIN web_links_final lf_eng ON lf_eng.hindi_id = lf_hindi.lid
    INNER JOIN web_link_temp lt_eng ON lt_eng.link_temp_id = lf_eng.link_temp_id
    INNER JOIN web_links_structure ls ON ls.lid = lf_eng.lid
    WHERE lf_hindi.status = 'Active'
    AND lf_eng.status = 'Active'
    AND lt_hindi.status = 'Active'
    AND lt_eng.status = 'Active'
    AND ls.status = 'Active'
    AND lt_hindi.lang_id = ?
    AND lt_hindi.content_type = ?
    AND lt_eng.lang_id = 1
    AND (lf_hindi.expiry_date IS NULL OR lf_hindi.expiry_date > CURRENT_DATE())
    AND (
    (ls.pos_id IN (?, 7) AND ls.link_level IS NULL)
    OR
    (ls.parent_ls_id IN (SELECT ls2.ls_id FROM web_links_structure ls2 WHERE ls2.pos_id IN (?, 7)))
    OR
    (ls.link_level = 2)
    )
    ORDER BY ls.position ASC";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiii", $lang_id, $content_type, $pos_id, $pos_id);
}

$stmt->execute();
$allData = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Additional filter: Remove any rows with empty link_name (safety check)
$filteredData = [];
foreach ($allData as $row) {
    if (!empty(trim($row['link_name']))) {
        $filteredData[] = $row;
    }
}
$allData = $filteredData;

// 2. Helper function for Dynamic URLs and Icons
function getDynamicUrlData($row, $lang_id) {
    $data = ['url' => '', 'target' => '', 'icon' => ''];
    $fileBase = "WriteReadData/L45218/";
    switch ($row['type_id']) {
        case 1: // File Link
            $data['url'] = $fileBase . $row['file_name'];
            $data['target'] = 'target="_blank"';
            $ext = strtolower(pathinfo($row['file_name'], PATHINFO_EXTENSION));
            if ($ext == 'pdf') {
                $data['icon'] = '<i class="fa fa-file-pdf-o text-danger"></i> ';
            } else {
                $data['icon'] = '<i class="fa fa-file-image-o text-primary"></i> ';
            }
            break;
        case 2: // URL Link
            $data['url'] = $row['url'];
            $data['target'] = 'target="_blank"';
            $data['icon'] = '<i class="fa fa-external-link"></i> ';
            break;
        case 3: // Content Link
            $data['url'] = "show_content.php?lang=$lang_id&level=" . ($row['link_level'] ?? 0) . "&ls_id=" . $row['ls_id'] . "&lid=" . $row['lid'];
            $data['target'] = '';
            break;
    }
    return $data;
}

// 3. Organize Data
$sections = [];
$children = [];
foreach ($allData as $row) {
    if ($row['link_level'] === null || $row['link_level'] == 0 || $row['link_level'] == '0') {
        $sections[$row['position']][] = $row;
    } else {
        $children[$row['parent_ls_id']][] = $row;
    }
}



?>
<!-- ================= ANNOUNCEMENT POSITION (1)================= -->

<?php if (!empty($sections[1])): 
    $parentRow = $sections[1][0];
    $parentId  = (int)$parentRow['ls_id']; 
    $myAnnouncements = $children[$parentId] ?? [];
    $parentLink = getDynamicUrlData($parentRow, $lang_id);
?>
    <div class="container-fluid wow zoomInDown" data-wow-delay="0.1s" style="background-color: #212121 !important;">
        <div class="row tickerpanle_maine">
            <div class="col-md-2 tickerpanle_maine_heading">
                <?= htmlspecialchars($parentRow['link_name']) ?> <img class="ic_ht" src="WriteReadData/IC1425/<?= htmlspecialchars($parentRow['icon_name']) ?>">
            </div>
            <div class="col-md-9 Announcement_link">
                

                <?php 
                /*
                if (!empty($myAnnouncements)): ?>
                    <marquee behavior="scroll" direction="left" onmouseover="this.stop();" onmouseout="this.start();">
                        <?php foreach ($myAnnouncements as $subRow): 
                            $link = getDynamicUrlData($subRow, $lang_id); //[cite_start]// Integrated dynamic logic [cite: 204]
                        ?>
                            <a <?= $link['target'] ?> href="<?= htmlspecialchars($link['url']) ?>">
                               &#8608;  <?= htmlspecialchars($subRow['link_name']) ?> <?= $link['icon'] ?> 
                            </a>&nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp;
                        <?php endforeach; ?>
                    </marquee>
                <?php endif; 
                */
                ?>
               
               
                
                <?php if (!empty($myAnnouncements)): ?>
                    <div class="marquee-container">
                        <div class="marquee-text">
                            <?php foreach ($myAnnouncements as $subRow): 
                                $link = getDynamicUrlData($subRow, $lang_id); //[cite_start]// Integrated dynamic logic [cite: 204]
                                ?>
                                    <a <?= $link['target'] ?> href="<?= htmlspecialchars($link['url']) ?>">
                                        &#8608;  
                                        <?= htmlspecialchars($subRow['link_name']) ?> <?= $link['icon'] ?> 
                                    </a>
                                    &nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp;
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-md-1 tickerpanle_maine_view">
                <a href="<?= htmlspecialchars($parentLink['url']) ?>" <?= $parentLink['target'] ?> style="color: inherit; text-decoration: none;">
                    View All
                </a>
            </div>
        </div>
    </div>
<?php endif; ?>



<!-- 
<div class="marquee-container bg-light text-dark py-2 d-none">
  <div class="marquee-text">
    यह Bootstrap 5 में एक चल रहा टेक्स्ट (Marquee) का उदाहरण है!
  </div>
</div> -->


























<!-- ================= PORTALS (POSITION 2) ================= -->

<?php if (!empty($sections[2])): ?>
    <?php 
        // Get the parent record for Position 2
        $parent2 = $sections[2][0]; 
        $parent2Id = (int)$parent2['ls_id'];
        
        // Get all sub-child records (Services) for this parent
        $serviceRows = isset($children[$parent2Id]) ? $children[$parent2Id] : []; 

        if (!empty($serviceRows)): 
    ?>
    <div class="container-fluid px-0">
        <div class="row g-0 serviceicon_top">
            <div id="carouselExampleControls3" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner service_icon_top">
                    <?php 
                        // Chunk items into groups of 6 for the carousel slides
                        $chunkedServices = array_chunk($serviceRows, 6); 
                        foreach ($chunkedServices as $index => $slideRows): 
                            $activeClass = ($index === 0) ? ' active' : '';
                    ?>
                        <div class="carousel-item<?= $activeClass ?>">
                            <div class="row">
                                <?php foreach ($slideRows as $row): 
                                    //$serviceUrl = $row['lfile'] . '?lid=' . (int)$row['lid'];
                                    $serviceUrl = $row['lfile'];
                                    $linkurl = getDynamicUrlData($row, $lang_id);
                                ?>
                                    <div class="col-md-2 border-end sunview">
                                        <div class="p-3 text-center">
                                            <a <?= $linkurl['target'] ?> href="<?= htmlspecialchars($linkurl['url']) ?>">
                                                <div style="margin-bottom:10px;">
                                                    <img src="WriteReadData/IC1425/<?= htmlspecialchars($row['icon_name'] ?? '') ?>" class="img-fluid">
                                                </div>
                                                <h6 class="">
                                                        <h6 class="mb-2"><?= htmlspecialchars($row['link_name']) ?></h6>
                                                </h6>
                                            </a>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
           
            
                <div class="servicion_carsousel">
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls3" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls3" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
             </div>            
        </div>
    </div>
    <?php endif; ?>
<?php endif; ?>

<!-- ================= PORTALS ENDS ================= -->


<!-- ================= MINISTER (POSITION 3) ================= -->
<?php if (!empty($sections[3])): ?>
    <?php foreach ($sections[3] as $mRow): ?>
        <div class="container-fluid bg-light py-5">
            <div class="container">
                <div class="row border bg-white rounded p-4">
                    <div class="col-md-2">
                        <img src="WriteReadData/IC1425/<?= htmlspecialchars($mRow['icon_name']) ?>" class="img-fluid">
                    </div>
                    <div class="col-md-10 minstermaine_heading">
                        <p><?= html_entity_decode($mRow['link_bdesc'] ?? '') ?></p>
                        <h3 class="text-primary"><?= html_entity_decode($mRow['link_name'] ?? '') ?><br><?= html_entity_decode($mRow['meta_tag'] ?? '') ?></h3>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
<!-- ================= MINISTER ENDS ================= -->

<!-- =========ABOUT SECTION ROW  POSITION (4, 5 & 6)====================-->
<div class="container-fluid about py-3">
    <div class="container py-3">
        <div class="row g-5">
            <div class="col-lg-12 wow fadeInLeft" data-wow-delay="0.2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInLeft;">
                <div class="row">
    <!-- =========ABOUT SECTION STARTS  POSITION (4)====================-->
                    <div class=" col-md-8">
                    
                        <?php if (!empty($sections[4])): ?>
                            <div class="container py-4">
                                <?php foreach ($sections[4] as $row): ?>
                                    <h1 class="display-2 mb-4 text-primary"><img class="ic_ht" src="WriteReadData/IC1425/<?= htmlspecialchars($row['icon_name'] ?? "") ?>"> <?= htmlspecialchars($row['link_name']) ?></h2>
                                    <p class="mb-4 text-justify" style="text-align: justify; color: black;"><?= html_entity_decode($row['link_bdesc'] ?? '') ?></p>
                                <?php 
                                // Generate the dynamic URL for this specific section's "View more" page
                                $viewMoreData = getDynamicUrlData($row, $lang_id); 
                                ?>
                                <?php
                                if ($lang_id == 1)
                                {
                                ?>
                                <div class="mt-3">
                                    <a href="<?= htmlspecialchars($viewMoreData['url']) ?>" 
                                       <?= $viewMoreData['target'] ?> 
                                       class="btn btn-primary rounded-pill py-2 px-4">
                                       View more &#10132;
                                    </a>
                                </div>
                                <?php
                                }
                                else
                                {
                                ?>
                                <div class="mt-3">
                                    <a href="<?= htmlspecialchars($viewMoreData['url']) ?>" 
                                       <?= $viewMoreData['target'] ?> 
                                       class="btn btn-primary rounded-pill py-2 px-4">
                                       ???? ????? &#10132;
                                    </a>
                                </div>
                                <?php
                                }
                                ?>
                                
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    
                    </div>
                    
    <!-- =========ABOUT SECTION ENDS====================-->
    
    
    <!-- =========OTHER MINISTERS STARTS POSITION (5 & 6)====================-->
                
                    <?php if (!empty($sections[5]) || !empty($sections[6])): ?>
                    <?php foreach ([5,6] as $pos): ?>
                        <?php if (!empty($sections[$pos])): ?>
                            <?php foreach ($sections[$pos] as $row): ?>
                                <div class=" col-md-2">
                                    <div class="row team pb-5">
                                        <div class=" pb-2">
                                            <div class="row g-4">
                                                <div class="col-md-12 col-lg-12 wow fadeInUp" data-wow-delay="0.2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
                                                    <div class="team-item">
                                                        <div class="team-img">
                                                            <img src="WriteReadData/IC1425/<?= htmlspecialchars($row['icon_name']) ?>" class="img-fluid">
                                                        </div>
                                                        
                                                        <div class="team-content bg-light text-center p-2">
                                                            <h4><?= htmlspecialchars($row['link_name']) ?></h4>
                                                            <p class="mb-0"><?= html_entity_decode($row['link_bdesc'] ?? '') ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                    
                            <?php endforeach; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    
                    <!-- =========OTHER MINISTERS ENDS====================-->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- =========ABOUT SECTION ROW ENDS====================-->

<!-- =========NEWS ROW STARTS POSITION (7 & 8)====================-->


<div class="container-fluid product py-5 bg-light">
    <div class="container py-5">

        <div class="tab-class">
            <div class="row g-4">
                <div class="row">
<!-- =========NEWS & Events STARTS POSITION (7)====================-->                
                    <div class="col-md-8">
<?php 
if (!empty($sections[7])): 
    foreach ($sections[7] as $mainItem): 
    $mainId = (int)$mainItem['ls_id'];
    $subLinks = isset($children[$mainId]) ? $children[$mainId] : []; 
    // Generate the dynamic URL for the "View more" button based on the main category
    $mainLinkData = getDynamicUrlData($mainItem, $lang_id);
?>
                        <h1 class="display-2 mb-4 text-primary"><img class="ic_ht"  src="WriteReadData/IC1425/<?= htmlspecialchars($mainItem['icon_name'] ?? "") ?>"> <?= html_entity_decode($mainItem['link_name']) ?></h1>

                        <div class="col-lg-12   wow fadeInRight" data-wow-delay="0.1s">

                            <ul class="nav nav-pills navbar_tabpanelltop  tab-buttons whatsnew-4 overflow-x-auto d-flex justify-content-between position-relative text-center mb-5">
<?php 
        foreach ($subLinks as $index => $sub): 
        $subId = (int)$sub['ls_id'];
?>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link <?= ($index === 0) ? 'active' : '' ?>" id="tab-btn-<?= $subId ?>" data-bs-toggle="tab" data-bs-target="#tab-content-<?= $subId ?>" type="button" role="tab">
                                        <?= htmlspecialchars($sub['link_name']) ?>
                                </a>
                                </li>
<?php 
        endforeach; 
?>        
                            </ul>
                        </div>

                        <div class="tab-content" id="pos7TabContent">
<?php 
        foreach ($subLinks as $index => $sub): 
        $subId = (int)$sub['ls_id'];
        $grandChildren = isset($children[$subId]) ? $children[$subId] : [];
?>                        
                            <div id="tab-content-<?= $subId ?>" class="tab-pane fade show p-0 <?= ($index === 0) ? 'show active' : '' ?>">
                                <div class="tabpanel_links">
<?php 
            if (!empty($grandChildren)):  
                foreach ($grandChildren as $gc): 
                //$gcUrl = $gc['lfile'] . '?lid=' . (int)$gc['lid'];
                $gcUrl = $gc['lfile'];
                //echo $gcUrl
                $gc[$key]['file_display_size'] = '';
                if (file_exists($gcUrl)) {
                    $bytes = filesize($gcUrl);
                    if ($bytes >= 1048576) {
                        $gc['file_display_size'] = '(' . number_format($bytes / 1048576, 2) . ' MB)';
                    } elseif ($bytes >= 1024) {
                        $gc['file_display_size'] = '(' . number_format($bytes / 1024, 2) . ' KB)';
                    } else {
                        $gc['file_display_size'] = '(' . $bytes . ' Bytes)';
                    }
                }
                //[cite_start]// Call the helper function to generate the correct URL and Icon [cite: 5]
                $gcData = getDynamicUrlData($gc, $lang_id);
?>
                                    
                                    <a href="<?= htmlspecialchars($gcUrl) ?>" <?= $gc['l_target'] ?> class="text-decoration-none">
                                        <?= htmlspecialchars($gc['link_name']) ?> <?= $gcData['icon'] ?>  <small style="font-size: 0.8em;"> <?= $gc['file_display_size'] ?></small>
                                        <span>➔</span>
                                    </a>
<?php 
                endforeach; 
            else: 
?>
                                    <div class="col-12 text-center text-muted">No records found.</div>
<?php 
            endif; 
?>
                                </div>
                            </div>
<?php 
        endforeach; 
?>
                        </div>

                        <?php
                        if ($lang_id == 1)
                        {
                        ?>
                        <a href="<?= htmlspecialchars($mainLinkData['url']) ?>" <?= $mainLinkData['target'] ?> class="btn btn-primary rounded-pill py-2 px-4 px-lg-3 mb-3 mb-md-3 mb-lg-0">View more &#10132;</a>
                        <?php
                        }
                        else
                        {
                        ?>
                        <a href="<?= htmlspecialchars($mainLinkData['url']) ?>" <?= $mainLinkData['target'] ?> class="btn btn-primary rounded-pill py-2 px-4 px-lg-3 mb-3 mb-md-3 mb-lg-0">???? ????? &#10132;</a>
                        <?php
                        }
                        ?>

<?php 
    endforeach; 
endif; 
?>
                    </div>
<!-- =========NEWS & Events ENDS====================-->

<!-- =========PORTALS STARTS POSITION (8)====================-->
                    <div class="col-md-4">
<?php 
if (!empty($sections[8])): 
    foreach ($sections[8] as $mainItem): 
    $mainId = (int)$mainItem['ls_id'];
    $subItems = isset($children[$mainId]) ? $children[$mainId] : []; 
    // Generate the dynamic URL for the "View more" button based on the main category
    $mainLinkData = getDynamicUrlData($mainItem, $lang_id);
?>
                        <h1 class="display-2 mb-4 text-primary"><img class="ic_ht" src="WriteReadData/IC1425/<?= htmlspecialchars($mainItem['icon_name'] ?? "") ?>"> <?= htmlspecialchars($mainItem['link_name']) ?></h1>
                        <div class="watsnew_linkspanel">
                            <div class="">
<?php 
        if (!empty($subItems)): 
            foreach ($subItems as $sub): 
                //$subUrl = $sub['lfile'] . '?lid=' . (int)$sub['lid'];
                $subUrl = $sub['lfile']; 
?>                              <a href="<?= htmlspecialchars($subUrl) ?>" <?= $sub['l_target'] ?>><?= htmlspecialchars($sub['link_name']) ?><span>&#10132;</span></a>
<?php 
            endforeach; 
            
        else: 
?>
                                <p class="text-muted">No sublinks available for this section.</p>
<?php 
        endif; 
?>                        
                            </div>                    
                        </div>
                    
                        <?php
                        if ($lang_id == 1)
                        {
                        ?>
                        <a href="<?= htmlspecialchars($mainLinkData['url']) ?>" <?= $mainLinkData['target'] ?> class="btn btn-primary rounded-pill py-2 px-4 px-lg-3 mb-3 mb-md-3 mb-lg-0">View more &#10132;</a>
                        <?php
                        }
                        else
                        {
                        ?>
                        <a href="<?= htmlspecialchars($mainLinkData['url']) ?>" <?= $mainLinkData['target'] ?> class="btn btn-primary rounded-pill py-2 px-4 px-lg-3 mb-3 mb-md-3 mb-lg-0">???? ????? &#10132;</a>
                        <?php
                        }
                        ?>
                        
<?php 
    endforeach; 
endif; 
?>
                    </div>
<!-- =========PORTALS ENDS====================-->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- =========NEWS ROW ENDS====================-->





<!-- =========DASHBOARD & EVENTS (9 & 10)====================-->


<div class="container-fluid  pb-5">
    <div class="container py-5">

        <div class="container products pt-5">
            <div class="row">
<!-- =========DASHBOARD STARTS POSITION (9)====================-->                
                <div class="col-md-8">
<?php 
if (!empty($sections[9])): 
    foreach ($sections[9] as $mainItem): 
    $mainId = (int)$mainItem['ls_id'];
    $subLinks = isset($children[$mainId]) ? $children[$mainId] : []; 
?>
                    <h1 class="display-2 mb-4 text-primary"><img class="ic_ht" src="WriteReadData/IC1425/<?= htmlspecialchars($mainItem['icon_name'] ?? "") ?>"> <?= htmlspecialchars($mainItem['link_name']) ?></h1>
<?php 
    endforeach; 
endif; 
?>
                        

<?php
/*$max_year = "SELECT MAX(year_id) AS max_active_id FROM web_dash_prog_data WHERE status = 'Active'";
$max_year_data = $conn->query($max_year);
$max_year_id = $max_year_data->fetch_all(MYSQLI_ASSOC);
if (!empty($max_year_id)):
    foreach ($max_year_id as $index => $year): 
        $year_id_max = (int)$year['max_active_id'];
    endforeach;
endif;
*/

$max_year = "select years from years where year_id in (SELECT MAX(year_id) AS max_active_id FROM web_dash_prog_data WHERE status = 'Active')";
$max_year_data = $conn->query($max_year);
$max_year_name = $max_year_data->fetch_all(MYSQLI_ASSOC);
if (!empty($max_year_name)):
    foreach ($max_year_name as $index => $year): 
        $year_name = (int)$year['years'];
    endforeach;
endif;


//echo ($year_name);
// 1. Fetch all active programs 
$sql_prog = "SELECT prog_id, prog_name FROM web_dash_prog WHERE status = 'Active' AND EXISTS (SELECT 1 FROM web_dash_prog_data WHERE web_dash_prog_data.prog_id = web_dash_prog.prog_id AND year_id in (SELECT MAX(year_id) AS max_active_id FROM web_dash_prog_data WHERE status = 'Active') AND status = 'Active') ORDER BY prog_id ASC";
$res_prog = $conn->query($sql_prog);
$programs = $res_prog->fetch_all(MYSQLI_ASSOC);
?>
                    
                    <div id="carouselExampleControls2" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
<?php 
if (!empty($programs)):
    foreach ($programs as $index => $prog): 
        $activeClass = ($index === 0) ? ' active' : ''; //[cite_start]// [cite: 6]
        $prog_id = (int)$prog['prog_id'];

        //[cite_start]// 2. Fetch data attributes for this specific program [cite: 4]
        $sql_data = "SELECT attribute_name, value_type, value FROM web_dash_prog_data 
                     WHERE prog_id = ? AND status = 'Active' and year_id in (SELECT MAX(year_id) AS max_active_id FROM web_dash_prog_data WHERE status = 'Active')";
        $stmt = $conn->prepare($sql_data);
        $stmt->bind_param("i", $prog_id);
        $stmt->execute();
        $res_data = $stmt->get_result();
        $attributes = $res_data->fetch_all(MYSQLI_ASSOC);
?>
                                <div class="carousel-item<?= $activeClass ?>">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="sidebar card">
                                                <div class="logo-section">
                                                    <div class="title-text">
                                                        <span><?= htmlspecialchars($prog['prog_name']) ." (" . $year_name . ")" ?></span>
                                                        <!--<br/><strong class="scroller_span">Read More</strong>-->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                    
                                        <div class="col-md-8 scroller_box_right">
                                            <div class="row">
<?php 
        if (!empty($attributes)):
            foreach ($attributes as $attr): 
                //[cite_start]// Handle large numbers with commas if needed [cite: 32]
                $displayValue = number_format($attr['value'], 2);
?>
                                                    <div class="col-md-6 " >
                                                        <div class="fact-item bg-light rounded text-center p-2">
                                                            <img class="mb-2 mt-1" src="../assets/img/empect_icon.png"> <h1 class="display-7 mb-0" data-toggle="counter-up">
                                                                <?= $displayValue ?>
                                                            </h1>
                                                            <span><?= htmlspecialchars($attr['value_type']) ?></span> <p class="mb-2"><strong><?= htmlspecialchars($attr['attribute_name']) ?></strong></p> </div>
                                                    </div>
<?php 
            endforeach; 
        endif; 
?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
<?php 
    endforeach; 
endif; 
?>
                        </div>
                    
                        <div class="iconbotttomside">
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls2" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls2" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>

                </div>
<!-- =========DASHBOARD ENDS====================-->

<!-- =========EVENTS STARTS POSITION (10)====================-->
                <div class="col-md-4 clender_panel">
<?php if (!empty($sections[10])): 

    foreach ($sections[10] as $mainItem): 
        $mainId = (int)$mainItem['ls_id'];
        $subItems = isset($children[$mainId]) ? $children[$mainId] : []; 
?>
                    <a href="<?= create_front_links_by_link_name($mainItem['link_name'])[0]; ?>"><h1 class="display-2 mb-4 text-primary"><img class="ic_ht" src="WriteReadData/IC1425/<?= htmlspecialchars($mainItem['icon_name'] ?? "") ?>"> <?= htmlspecialchars($mainItem['link_name']) ?></h1></a>
<?php 
    endforeach; 
endif; ?>
                
                    <div id='calendar'></div>

                    <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        var calendarEl = document.getElementById('calendar');
                        
                        // Determine the path relative to this HTML file
                        var fetchUrl = new URL('fetch_events.php', window.location.href).href;
                    
                        var calendar = new FullCalendar.Calendar(calendarEl, {
                        initialView: 'dayGridMonth',
                        events: 'fetch_events.php',
                        eventDisplay: 'block', 
                        
                        // 1. HIDE NEXT/PREVIOUS MONTH DATES
                        showNonCurrentDates: false, 
                    
                        // 2. REMOVE TODAY BUTTON FROM TOOLBAR
                        headerToolbar: {
                            left: 'prev,next', // Removed 'today'
                            center: 'title',
                            right: 'today' // Or 'dayGridMonth,dayGridWeek' if you use them
                        },
                        
                        // This function triggers for every single event line
                        eventDidMount: function(info) {
                            // 1. Get the color we sent from PHP
                            let eventColor = info.event.backgroundColor;
                    
                            // 2. Force the color onto the main container
                            info.el.style.setProperty('background-color', eventColor, 'important');
                            info.el.style.setProperty('border-color', eventColor, 'important');
                    
                            // 3. Force the color onto the inner wrapper (FullCalendar 5/6 requirement)
                            let innerResizer = info.el.querySelector('.fc-event-main');
                            if (innerResizer) {
                                innerResizer.style.setProperty('background-color', eventColor, 'important');
                            }
                        },
                    
                        eventMouseEnter: function(info) {
                            // Tooltip logic
                            info.el.setAttribute('title', info.event.extendedProps.tooltip);
                        }
                    });
                    calendar.render();
                        
                        // Log to console for deeper inspection
                  //      console.log("Calendar is attempting to fetch events from: ", fetchUrl);
                    });
                    </script>
                
                </div>
<!-- =========EVENTS ENDS====================-->
            </div>
        </div>
    </div>
</div>

<!-- =========DASHBOARD & EVENTS ROW ENDS====================-->


<!-- =========GALLERY ROW STARTS POSITION (11 & 12)============-->

<div class="container-fluid bg-primary  pb-5">
    <div class="container  pt-5">
        <div class="row">
        
<!-- =========VIDEO GALLERY STARTS POSITION 11============-->        
            <div class="col-md-6 ">
<?php 
if (!empty($sections[11])): 
    foreach ($sections[11] as $mainItem): 
    $mainId = (int)$mainItem['ls_id'];
    $subLinks = isset($children[$mainId]) ? $children[$mainId] : []; 
    
    $galleryUrl = "show_content.php?lang=" . $lang_id . 
    "&level=" . ($mainItem['link_level'] ?? 0) . 
    "&ls_id=" . $mainItem['ls_id'] . 
    "&lid=" . $mainItem['lid'] .
    "&vmod=3&vid=1";
?>
                <h1 class="display-2 mb-4 text-white">
                    <img class="ic_ht" src="WriteReadData/IC1425/<?= htmlspecialchars($mainItem['icon_name'] ?? "") ?>"> 
                    <a href="<?= $galleryUrl ?>" class="header_link"><?= htmlspecialchars($mainItem['link_name']) ?></a>
                </h1>
<?php
    endforeach;
endif;    
?>

<?php
// The provided query to fetch active gallery videos
$sql = "SELECT mf.m_id, mt.m_temp_id, mt.image_name, mt.m_name, mt.m_description, mt.url, mt.type_of_media 
        FROM web_media_temp mt 
        INNER JOIN web_media_final mf ON mf.m_temp_id = mt.m_temp_id 
        WHERE mt.status = 'Active' 
          AND mf.status = 'Active' 
          AND mt.type_of_media = 2 ORDER BY mf.m_id DESC 
        LIMIT 4";

$result = $conn->query($sql);
$photos = $result->fetch_all(MYSQLI_ASSOC);
?>

                <div class="row">
<?php 
if (!empty($photos)):
    foreach ($photos as $index => $row): 
       $rawUrl = $row['url'] ?? "";
       // Convert standard YouTube watch link to Embed link
        // Example: transforms watch?v=ID into /embed/ID
        if (strpos($rawUrl, 'watch?v=') !== false) {
            $videoUrl = str_replace('watch?v=', 'embed/', $rawUrl);
        } else {
            $videoUrl = $rawUrl;
        }
    
        $videoName = $row['m_name'] ?? "";
?>                
                    <div class="col-md-6"><iframe width="100%" height="200" src="<?= htmlspecialchars($videoUrl, ENT_QUOTES, 'UTF-8') ?>" title="<?= htmlspecialchars($videoName, ENT_QUOTES, 'UTF-8') ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe></div>
<?php 
    endforeach; 
else: 
?>
                        <div class="carousel-item active">
                            <img src="img/no-image.jpg" class="d-block w-100" alt="No Videos found">
                        </div>
<?php 
endif; 
?>
                </div>
            </div>
<!-- =========VIDEO GALLERY ENDS============-->        
            
<!-- =========PHOTO GALLERY STARTS POSITION 12============-->        
            <div class="col-md-6 ">
<?php 
if (!empty($sections[12])): 
    foreach ($sections[12] as $mainItem): 
    $mainId = (int)$mainItem['ls_id'];
    $subLinks = isset($children[$mainId]) ? $children[$mainId] : []; 
    // Construct the dynamic URL for show_content.php
    $galleryUrl = "show_content.php?lang=" . $lang_id . 
    "&level=" . ($mainItem['link_level'] ?? 0) . 
    "&ls_id=" . $mainItem['ls_id'] . 
    "&lid=" . $mainItem['lid'] .
    "&vmod=2";
?>
                <h1 class="display-2 mb-4 text-white">
                    <img class="ic_ht" src="WriteReadData/IC1425/<?= htmlspecialchars($mainItem['icon_name'] ?? "") ?>"> 
                    <a href="<?= $galleryUrl ?>" class="header_link"><?= htmlspecialchars($mainItem['link_name']) ?></a>
                </h1>
<?php
    endforeach;
endif;    
?>

<?php
// The provided query to fetch active photo gallery images 
$sql = "SELECT mf.m_id, mt.m_temp_id, mt.image_name, mt.m_description, mt.m_name, mt.url, mt.type_of_media 
        FROM web_media_temp mt 
        INNER JOIN web_media_final mf ON mf.m_temp_id = mt.m_temp_id 
        WHERE mt.status = 'Active' 
          AND mf.status = 'Active' 
          AND mt.type_of_media = 1 
          AND mf.gallery_flage = 1";

$result = $conn->query($sql);
$photos = $result->fetch_all(MYSQLI_ASSOC);
?>

                <div id="carouselExampleControls1" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
<?php 
if (!empty($photos)):
    foreach ($photos as $index => $row): 
        //[cite_start]// The first item in a Bootstrap carousel must have the 'active' class [cite: 1]
        $activeClass = ($index === 0) ? ' active' : '';
?>
                        <div class="carousel-item<?= $activeClass ?>">
                            <img src="WriteReadData/MD32145/<?= htmlspecialchars($row['image_name']) ?>" class="d-block w-100" alt="<?= htmlspecialchars($row['m_name'] ?? 'Gallery Image') ?>">
                
<?php 
        if (!empty($row['m_description'])): ?>
                            <div class="carousel-caption d-none d-md-block">
                                <p><?= htmlspecialchars($row['m_description']) ?></p>
                            </div>
<?php 
        endif; 
?>
                        </div>
<?php 
    endforeach; 
else: 
?>
                        <div class="carousel-item active">
                            <img src="img/no-image.jpg" class="d-block w-100" alt="No images found">
                        </div>
<?php 
endif; 
?>
                    </div>

                    <div class="iconbotttomside">                    
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls1" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls1" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>            
            </div>
<!-- =========PHOTO GALLERY ENDS============-->                    
        </div>
    </div>
</div>


<!-- =========GALLERY ROW ENDS============-->



<!-- =========GOV ICONS STARTS  POSITION (13)====================-->
<div class="container-fluid footer py-3 wow fadeIn dis_none" data-wow-delay="0.2s">

    <div class="container bootomlingks">
<?php 
if (!empty($sections[13])): 
?>
        <ul>
            <marquee onmouseover="this.stop();" onmouseout="this.start();">
<?php 
    foreach ($sections[13] as $parent13): 
        $p13_id = (int)$parent13['ls_id'];
        $subItems13 = $children[$p13_id] ?? [];
        if (!empty($subItems13)): 
            foreach ($subItems13 as $item): 
                //$fullUrl = $item['lfile'] . '?lid=' . (int)$item['lid'];
                $fullUrl = $item['lfile'];
                $botlinkurl = getDynamicUrlData($item, $lang_id);
?>
            <li>
                <a <?= $botlinkurl['target'] ?> href="<?= htmlspecialchars($botlinkurl['url']) ?>">
                    <img src="WriteReadData/IC1425/<?= htmlspecialchars($item['icon_name']) ?>">
                </a>
            </li>
<?php 
            endforeach; 
        endif;
    endforeach; 
?>
            </marquee>
        </ul>
<?php 
endif; 
?>
    </div>
</div>
<!-- =========GOV ICONS ENDS====================-->

<!-- ========= STARTS (14, 15, 16) ====================-->

<div class="container-fluid footer bg-light py-3 wow fadeIn" data-wow-delay="0.2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeIn;">
    <div class="container py-5">
    
        <div class="row g-5">

            <!-- ========= STARTS (14) ====================-->
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="footer-item d-flex flex-column">
<?php 
if (!empty($sections[14])): 
    foreach ($sections[14] as $mainItem): 
    $mainId = (int)$mainItem['ls_id'];
    $subItems = isset($children[$mainId]) ? $children[$mainId] : []; 
?>
                    <h1 class="display-2 mb-4 text-primary"><img class="ic_ht" src="WriteReadData/IC1425/<?= htmlspecialchars($mainItem['icon_name'] ?? "") ?>"> <?= htmlspecialchars($mainItem['link_name']) ?></h1>
<?php 
        if (!empty($subItems)): 
            foreach ($subItems as $sub): 
                //$subUrl = $sub['lfile'] . '?lid=' . (int)$sub['lid'];
                $subUrl = $sub['lfile']; 
              $subId = (int)$sub['ls_id'];
                $subSubLinks = $navChildren[$subId] ?? [];
                $sLink = generateLinkData($sub, $lang_id);
?>
                    <a href="<?= htmlspecialchars($sLink['url']) ?>" <?= $sub['l_target'] ?>><i class="fas fa-angle-right me-2"></i> <?= htmlspecialchars($sub['link_name']) ?><span></a>
<?php 
            endforeach; 
            
        else: 
?>
                    <p class="text-muted">No sublinks available for this section.</p>
<?php 
        endif; 
?>                        
<?php 
    endforeach; 
endif; 
?>
                </div>
            </div>
            <!-- ========= ENDS (14) ====================-->

            <!-- ========= STARTS (15) ====================-->
            <div class="col-lg-3 col-md-6">
<?php 
if (!empty($sections[15])): 
    foreach ($sections[15] as $mainItem): 
    $mainId = (int)$mainItem['ls_id'];
    $subItems = isset($children[$mainId]) ? $children[$mainId] : []; 
?>
                <h1 class="display-2 mb-4 text-primary"><img class="ic_ht" src="WriteReadData/IC1425/<?= htmlspecialchars($mainItem['icon_name'] ?? "") ?>"> <?= htmlspecialchars($mainItem['link_name']) ?></h1>

                <?= html_entity_decode($mainItem['details'] ?? "") ?>
                <div class="d-flex pt-3">
                    
                    <a class="btn btn-square btn-primary me-2" href=""><i class="fab fa-instagram"></i></a>
                    <a class="btn btn-square btn-primary me-2" href=""><i class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-square btn-primary me-2" href=""><i class="fab fa-youtube"></i></a>
                    <a class="btn btn-square btn-primary me-2" href=""><i class="fab fa-linkedin-in"></i></a>
                </div>
<?php 
    endforeach; 
endif; 
?>            </div>
                <!-- ========= ENDS (15) ====================-->


            <!-- ========= STARTS (16) ====================-->
            
            <div class="col-md-6 col-lg-6 col-xl-6">
                <div class="footer-item d-flex flex-column">
<?php 
if (!empty($sections[16])): 
    foreach ($sections[16] as $mainItem): 
    $mainId = (int)$mainItem['ls_id'];
    $subItems = isset($children[$mainId]) ? $children[$mainId] : []; 
?>
                    <h1 class="display-2 mb-4 text-primary"><img class="ic_ht" src="WriteReadData/IC1425/<?= htmlspecialchars($mainItem['icon_name'] ?? "") ?>"> <?= htmlspecialchars($mainItem['link_name']) ?></h1>
<?php 
    endforeach; 
endif; 
?> 
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3504.0818102971357!2d77.17724307549838!3d28.56730597570043!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390d1d846aaaaaab%3A0xbd194975121e8c82!2sBureau%20of%20Energy%20Efficiency!5e0!3m2!1sen!2sin!4v1770803135544!5m2!1sen!2sin" width="100%" height="200" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

                </div>
            </div>
            
            <!-- ========= ENDS (16) ====================-->



        </div>
    </div>
</div>

<!-- ========= STARTS (14, 15, 16) ====================-->





<?php 
endif; 
?>
   


            