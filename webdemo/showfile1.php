<?php

    include BASE_PATH . '/appcode/globals.inc.php';
    include BASE_PATH . '/appcode/usercon_pdo.inc.php';
    include_once BASE_PATH . '/include/website_common.inc.php';

    $t_id  = filter_input(INPUT_GET, 't_id', FILTER_VALIDATE_INT);
    $ct_id = filter_input(INPUT_GET, 'ct_id', FILTER_VALIDATE_INT);
    $ls_id = filter_input(INPUT_GET, 'ls_id', FILTER_VALIDATE_INT);
    $lid   = filter_input(INPUT_GET, 'lid', FILTER_VALIDATE_INT);
    $level = filter_input(INPUT_GET, 'level', FILTER_VALIDATE_INT);

    $lang  = $_SESSION['lang'] ?? 1;

    $fileData = null;
    $folder   = null;


            $conn = db_connect();

    if ($t_id && !$ct_id) {
        
        $sql = "SELECT tt.file_name
                FROM web_tender_temp tt
                    INNER JOIN web_tender_final tf ON tf.t_temp_id = tt.t_temp_id
                WHERE tt.status='Active'
                    AND tf.t_id=?
                LIMIT 1";

        $res = core_query($sql, "i", [$t_id]);

        if ($res['success'] && !empty($res['data'][0])) {
            $fileData = $res['data'][0];
            $folder   = 'T45218';
        }
    } elseif ($t_id && $ct_id) {

        $sql = "SELECT tt.file_name
                FROM web_tender_temp tt
                    INNER JOIN web_tender_corrigendum_final tf ON tf.t_temp_id = tt.t_temp_id
                WHERE tt.status='Active'
                    AND tf.t_id=?
                    AND tf.ct_id=?
                LIMIT 1";

        $res = core_query($sql, "ii", [$t_id, $ct_id]);

        if ($res['success'] && !empty($res['data'][0])) {
            $fileData = $res['data'][0];
            $folder   = 'T45218';
        }
    } elseif ($ls_id && $lid) {
        $levelCondition = is_null($level) ? " AND ls.link_level IS NULL " : " AND ls.link_level = ? ";

        $sql = "SELECT lt.file_name
            FROM web_links_final lf
                INNER JOIN web_link_temp lt ON lt.link_temp_id = lf.link_temp_id
                INNER JOIN web_links_structure ls ON ls.lid = lf.lid
            WHERE lf.status='Active'
                AND lt.status='Active'
                AND lt.type_id=1
                AND ls.status='Active'
                AND lt.lang_id=?
                AND ls.ls_id=?
                AND lf.lid=?
                {$levelCondition}
            LIMIT 1";

        $params = [$lang, $ls_id, $lid];
        $types  = "iii";

        if (!is_null($level)) {
            $params[] = $level;
            $types .= "i";
        }

#        $res = core_query($sql, $types, $params);

        $res = simpleFetchPrepared($conn, $sql, $types, $params);

        if ($res['success'] && !empty($res['data'][0])) {
            $fileData = $res['data'][0];
            $folder   = 'L45218';
        }
    }

    if (!$fileData || empty($fileData['file_name'])) {
        header("Location: index.php");
        exit;
    }

    $fileName = basename($fileData['file_name']); 
    $fullPath = BASE_PATH . "/WriteReadData/{$folder}/" . $fileName;

    if (!is_file($fullPath)) {
        header("Location: index.php");
        exit;
    }

    $mimeType = mime_content_type($fullPath) ?: 'application/octet-stream';
    header("Content-Type: {$mimeType}");
    header("Content-Length: " . filesize($fullPath));
    header("Content-Disposition: inline; filename=\"" . $fileName . "\"");
    header("X-Content-Type-Options: nosniff");

    readfile($fullPath);
    exit;
