<?php


$GLOBALS['csrf']['token'] =
    "'{$GLOBALS['csrf']['input-name']}':'" . csrf_get_tokens() . "'";

$lang = $_REQUEST['lang'] ?? $_SESSION['lang'] ?? '1';

if (is_array($lang)) {
    $lang = $lang[0];
}

if (!in_array($lang, ['1','2','3'], true)) {
    $lang = '1';
}

$_SESSION['lang'] = $lang;

$idColumn = ($lang === '3') ? 'marati_id' : 'hindi_id';


function get_meta_data(?int $lid, string $lang, string $idColumn): array
{
    if (!$lid) {
        return default_meta();
    }

    $conn = db_connect();

    if ($lang === '2' || $lang === '3') {

        $sql = "SELECT lt.title, lt.meta_tag, lt.source, lt.keywords FROM web_link_temp lt WHERE lt.link_temp_id = (SELECT link_temp_id FROM web_links_final WHERE lid = (
                    SELECT {$idColumn} FROM web_links_final WHERE lid = ? ))";

    } else {
        $sql = "SELECT lt.title, lt.meta_tag, lt.source, lt.keywords FROM web_link_temp lt WHERE lt.link_temp_id = (SELECT link_temp_id FROM web_links_final WHERE lid = ? )";
    }


    
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        return default_meta();
    }

    $stmt->bind_param("i", $lid);
    $stmt->execute();
    $result = $stmt->get_result();

    if (!$result || $result->num_rows === 0) {
        return default_meta();
    }

    return $result->fetch_assoc();
}

function default_meta(): array
{
    return [
        'title'     => $_ENV['APP_NAME'] ?? '',
        'meta_tag'  => $_ENV['APP_NAME'] ?? '',
        'source'    => $_ENV['APP_NAME'] ?? '',
        'keywords'  => $_ENV['APP_NAME'] ?? '',
    ];
}

$lid = isset($_GET['lid']) ? (int)$_GET['lid'] : null;
$myVal = get_meta_data($lid, $lang, $idColumn);


/*function CleanW3cWarn(string $str): string
{
    $str = html_entity_decode($str, ENT_QUOTES | ENT_HTML5);

    return ($_SESSION['lang'] === '1')
        ? str_replace('&', '&amp;', $str)
        : $str;
}
*/

function CleanW3cWarn(?string $str): string
{
    // Convert null to an empty string immediately to prevent further errors
    $str = $str ?? "";

    $str = html_entity_decode($str, ENT_QUOTES | ENT_HTML5);

    return (isset($_SESSION['lang']) && $_SESSION['lang'] === '1')
        ? str_replace('&', '&amp;', $str)
        : $str;
}

function stringChunk(string &$string, ?bool &$moreFlag, int $limit): void
{
    $temp = strip_tags(html_entity_decode($string));

    if ($limit <= 0 || strlen($temp) <= $limit) {
        $string = $temp;
        $moreFlag = false;
        return;
    }

    $string = substr($temp, 0, strrpos(substr($temp, 0, $limit), ' '));
    $moreFlag = true;
}

function getFileIcon(string $ext, ?int $linkType = null, ?int $iconSize = null): string
{
    $iconSizeStyle = $iconSize ? "style='font-size:{$iconSize}px'" : '';
    $ext = ($linkType === 2) ? 'url' : $ext;

    return match ($ext) {
        'pdf' => "<i class='fas fa-file-pdf' {$iconSizeStyle}></i>",
        'url' => "<i class='fas fa-up-right-from-square' {$iconSizeStyle}></i>",
        default => ''
    };
}

function filesize_formatted(?string $filename): string {

    if (!$filename) return '';

    $path = "WriteReadData/L45218/" . basename($filename);

    if (!file_exists($path)) return '';

    $size = filesize($path);

    $units = ['B','KB','MB','GB','TB'];
    $power = $size > 0 ? floor(log($size, 1024)) : 0;

    return sprintf(
        " (%.2f %s)",
        $size / pow(1024, $power),
        $units[$power]
    );
}

function find_replace_email(string $str): string
{
    preg_match_all("/\b\w+\@\w+[\.\w+]+\b/", $str, $matches);

    foreach ($matches[0] as $email) {
        $masked = strtolower(str_replace(['@','.'], ['[at]','[dot]'], $email));
        $str = str_replace($email, $masked, $str);
    }

    return $str;
}

function rtfPathManage(?string &$text, bool $forDB = true): void
{
    if ($forDB) {
        if (preg_match('~<body[^>]*>(.*?)</body>~si', $text, $data)) {
            $text = htmlspecialchars($data[1], ENT_QUOTES);
        }
    } else {
        $text = str_replace(
            '/WriteReadData',
            ($_ENV['BASE_URL'] ?? '') . '/WriteReadData',
            html_entity_decode($text ?? "")
        );
    }
}


function getLinkUpdatedOn(
    int $lid,
    int $ls_id,
    int $level,
    bool $archFlage = false,
    array $pubDArray = []
): ?string
{
    $conn = db_connect();

    if ($ls_id > 0) {

        if ($level === 0) {
            $subQry = " AND ls.link_level IS NULL AND ls.ls_id=? AND lf.lid=?";
            $types  = "ii";
            $params = [$ls_id, $lid];
        } else {
            $subQry = " AND ls.link_level=?";
            $types  = "i";
            $params = [$level];
        }

        $subQry .= (count($pubDArray) > 0)
            ? " AND ls.parent_ls_id=?"
            : " AND ls.ls_id=?";

        $types   .= "i";
        $params[] = $ls_id;

        $subQry .= $archFlage
            ? " AND lf.expiry_date <= CURRENT_DATE()"
            : " AND (lf.expiry_date IS NULL OR lf.expiry_date > CURRENT_DATE())";

        $sql = "
            SELECT ls.link_level, lf.lid, ls.ls_id,
                   MAX(lf.publish_date) AS publish_date
            FROM web_links_final lf
            INNER JOIN web_link_temp lt ON lt.link_temp_id = lf.link_temp_id
            INNER JOIN web_links_structure ls ON ls.lid = lf.lid
            WHERE lf.status='Active'
              AND lt.status='Active'
              AND ls.status='Active'
              $subQry
            GROUP BY lf.lid
        ";

        $stmt = $conn->prepare($sql);
        if (!$stmt) return null;

        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $result = $stmt->get_result();

    } else {

        $sql = "
            SELECT MAX(lf.publish_date) AS publish_date
            FROM web_links_final lf
            INNER JOIN web_link_temp lt ON lt.link_temp_id = lf.link_temp_id
            WHERE lf.status='Active'
              AND lt.status='Active'
        ";

        $result = $conn->query($sql);
    }

    if (!$result || $result->num_rows === 0) {
        return format_latest_date($pubDArray);
    }

    $row = $result->fetch_assoc();

    $pubDArray[] = $row['publish_date'];

    $nextLevel = empty($row['link_level'])
        ? 1
        : ((int)$row['link_level'] + 1);

    return getLinkUpdatedOn(
        (int)($row['lid'] ?? $lid),
        (int)($row['ls_id'] ?? $ls_id),
        $nextLevel,
        $archFlage,
        $pubDArray
    );
}

function format_latest_date(array $dates): ?string
{
    if (empty($dates)) return null;

    usort($dates, fn($a, $b) => strtotime($a) <=> strtotime($b));

    return date('F d, Y', strtotime(end($dates)));
}


function subquerylinkhindi(): string
{
    $lang = (int)($_SESSION['lang'] ?? 1);

    if ($lang === 3) {
        return "h.link_name AS hindi_name,
                h.details AS hdetails,
                h.link_bdesc AS hlink_bdesc,
                h.title AS htitle,
                DATE_FORMAT(h.publish_date,'%d %M %Y') AS hpublish_date,
                lf.marati_id,";
    }

    return "h.link_name AS hindi_name,
            h.details AS hdetails,
            h.link_bdesc AS hlink_bdesc,
            h.title AS htitle,
            DATE_FORMAT(h.publish_date,'%d %M %Y') AS hpublish_date,
            lf.hindi_id,";
}

function subqueryjoin(): string
{
    $lang = (int)($_SESSION['lang'] ?? 1);
    $joinColumn = ($lang === 3) ? 'marati_id' : 'hindi_id';

    return " LEFT JOIN (
        SELECT t1.link_name,t1.link_bdesc,t1.details,
               t1.title,t1.type_id,f1.publish_date,
               f1.expiry_date,f1.lid
        FROM web_links_final f1
        INNER JOIN web_link_temp t1
            ON t1.link_temp_id=f1.link_temp_id
           AND t1.lang_id=$lang
    ) h ON h.lid=lf.$joinColumn ";
}

function subquerylinkhindetails(): string
{
    $lang = (int)($_SESSION['lang'] ?? 1);

    return "(select t.details from web_links_final f INNER JOIN web_link_temp t on t.link_temp_id=f.link_temp_id where f.status='Active' and t.status='Active'  and t.lang_id=$_SESSION[lang]  and f.lid=lf.hindi_id)as hindi_details,";
}



    function create_front_links_by_link_name($linkname) {
        //$tempName = html_entity_decode(strtolower($linkname));
        $tempName = html_entity_decode(strtolower($linkname ?? ""));
        $linkfile = array();
    
        switch ($tempName) {
            case 'accessibility options':
                $linkfile[0] = "access.php";
                $linkfile[1] = "data-hrf='access'";
                break;


		    /*case 'careers':
                $linkfile[0] = "vacancy.php";
		        break;*/
			
            case 'feedback':
                $linkfile[0] = "feedback.php";
                //$linkfile[1] = "data-bs-target='feedback'";
			    //$linkfile[2] = "data-bs-toggle='modal'";
		    break;

            case 'employee service information':
                $linkfile[0] = "empservice.php?EncHid=".$_SESSION['EncTok_front'];
                //$linkfile[1] = "EncHid=".$_SESSION['EncTok_front'];
			    //$linkfile[2] = "data-bs-toggle='modal'";
		    break;

            case 'employee pf balance information':
                $linkfile[0] = "emppf.php?EncHid=".$_SESSION['EncTok_front'];
                //$linkfile[1] = "EncHid=".$_SESSION['EncTok_front'];
			    //$linkfile[2] = "data-bs-toggle='modal'";
		    break;

            case 'employee income tax information ':
                $linkfile[0] = "empIncometax.php?EncHid=".$_SESSION['EncTok_front'];
                //$linkfile[1] = "EncHid=".$_SESSION['EncTok_front'];
			    //$linkfile[2] = "data-bs-toggle='modal'";
		    break;

            case 'employee transfer information':
                $linkfile[0] = "emptransferdtls.php?EncHid=".$_SESSION['EncTok_front'];
                //$linkfile[1] = "EncHid=".$_SESSION['EncTok_front'];
			    //$linkfile[2] = "data-bs-toggle='modal'";
		    break;

            case 'employee salary information':
                $linkfile[0] = "empsalary.php?EncHid=".$_SESSION['EncTok_front'];
                //$linkfile[1] = "EncHid=".$_SESSION['EncTok_front'];
			    //$linkfile[2] = "data-bs-toggle='modal'";
		    break;

            case 'employee leave information':
                $linkfile[0] = "empleave.php?EncHid=".$_SESSION['EncTok_front'];
                //$linkfile[1] = "EncHid=".$_SESSION['EncTok_front'];
			    //$linkfile[2] = "data-bs-toggle='modal'";
		    break;

            case 'employee profile information':
                $linkfile[0] = "empdetails.php?EncHid=".$_SESSION['EncTok_front'];
                //$linkfile[1] = "EncHid=".$_SESSION['EncTok_front'];
			    //$linkfile[2] = "data-bs-toggle='modal'";
		        break;

            case 'employee optional holidays list':
                $linkfile[0] = "empoptholidays.php?EncHid=".$_SESSION['EncTok_front'];
                //$linkfile[1] = "EncHid=".$_SESSION['EncTok_front'];
			    //$linkfile[2] = "data-bs-toggle='modal'";
		        break;

            case 'employee leave history information':
                $linkfile[0] = "empleavehistory.php?EncHid=".$_SESSION['EncTok_front'];
                //$linkfile[1] = "EncHid=".$_SESSION['EncTok_front'];
			    //$linkfile[2] = "data-bs-toggle='modal'";
		        break;

            case 'employee housing loan application':
                $linkfile[0] = "emphsgloanappl.php?EncHid=".$_SESSION['EncTok_front'];
                //$linkfile[1] = "EncHid=".$_SESSION['EncTok_front'];
			    //$linkfile[2] = "data-bs-toggle='modal'";
		        break;

            case 'employee housing loan monthly':
                $linkfile[0] = "emphsgloanmthsumm.php?EncHid=".$_SESSION['EncTok_front'];
                //$linkfile[1] = "EncHid=".$_SESSION['EncTok_front'];
			    //$linkfile[2] = "data-bs-toggle='modal'";
		        break;

            case 'employee housing loan yearly':
                $linkfile[0] = "emphsgloanyearsumm.php?EncHid=".$_SESSION['EncTok_front'];
                //$linkfile[1] = "EncHid=".$_SESSION['EncTok_front'];
			    //$linkfile[2] = "data-bs-toggle='modal'";
		        break;

            case 'sitemap':
                $linkfile[0] = "sitemap.php";
                break;

            case 'latest tenders':
            case 'tenders':
                $linkfile[0] = "show_tenders.php";
                break;

            case 'archived tenders':
                $linkfile[0] = "tendersArc.php";
                break;

            case 'photo gallery':
                #$linkfile[0]="show_media.php";
                $linkfile[0] = "show_content.php";
                $linkfile[2] = "&vmod=2";
                break;
			
		    case 'फोटो गैलरी':
                #$linkfile[0]="show_media.php";
                $linkfile[0] = "show_content.php";
                $linkfile[2] = "&vmod=2";
                break;

            case 'video gallery':
                #$linkfile[0]="show_vgallery.php";
                #$linkfile[0]="show_media.php";
                $linkfile[0] = "show_content.php";
                $linkfile[2] = "&vmod=3&vid=1";
                break;

		    case 'वीडियो गैलरी':
                #$linkfile[0]="show_vgallery.php";
                #$linkfile[0]="show_media.php";
                $linkfile[0] = "show_content.php";
                $linkfile[2] = "&vmod=3&vid=1";
                break;
			
            case 'how to reach':
                $linkfile[0] = "howtoreach.php";
                break;

            case 'archives':
                $linkfile[0] = "show_content.php";
                $linkfile[2] = "&vmod=4";
                break;

		    case 'organogram':
                $linkfile[0] = "show_organogram.php";
                //$linkfile[2] = "&vmod=4";
                break;	
                
            case 'event calendar':
                $linkfile[0] = "event_calendar.php";
                //$linkfile[2] = "&vmod=4";
                break;
			
            case 'state designated agency':
                $linkfile[0] = "map.php";
                //$linkfile[2] = "&vmod=4";
                break;
              
            
            default:
                $linkfile[0] = "show_content.php";
                break;
        }
        return $linkfile;
    }