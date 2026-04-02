<?php


        function parse_size(string $size): int {
            $unit = preg_replace('/[^bkmgtpezy]/i', '', $size);
            $value = (float) preg_replace('/[^0-9\.]/', '', $size);

            if ($unit !== '') {
                return (int) round($value * pow(1024, stripos('bkmgtpezy', strtolower($unit[0]))));
            }

            return (int) round($value);
        }

        function file_upload_max_size(): int{
            $postMax = parse_size(ini_get('post_max_size'));
            $uploadMax = parse_size(ini_get('upload_max_filesize'));

            if ($uploadMax > 0 && $uploadMax < $postMax) {
                return $uploadMax;
            }

            return $postMax;
        }

        define('MAX_UPLOAD_SIZE', file_upload_max_size());

/*

        function db_connect(): mysqli
        {
            $conn = new mysqli(
                $_ENV['HOST'],
                $_ENV['USER_NAME'],
                $_ENV['PASS'],
                $_ENV['DB'],
                (int) ($_ENV['DB_PORT'] ?? 3306)
            );

            $conn->set_charset('utf8mb4');

            return $conn;
        }

*/

        function db_query(string $sql, string $types = '', array $params = []): array
        {
            $conn = db_connect();

            try {

                $stmt = $conn->prepare($sql);

                if ($types !== '' && !empty($params)) 
                {
                    $stmt->bind_param($types, ...$params);
                }

                $stmt->execute();

                $result = $stmt->get_result();

                $data = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];

                $response = [
                    'success' => true,
                    'data' => $data,
                    'affected_rows' => $stmt->affected_rows,
                    'insert_id' => $conn->insert_id
                ];

                $stmt->close();
            //    $conn->close();

                return $response;

            } catch (Throwable $e) {

              //  $conn->close();

                error_log("DB Error: " . $e->getMessage());

                return [
                    'success' => false,
                    'error' => $e->getMessage()
                ];
            }
        }


        function db_transaction(callable $callback): bool
        {
            $conn = db_connect();

            try {

                $conn->begin_transaction();

                $callback($conn);

                $conn->commit();
                // $conn->close();

                return true;

            } catch (Throwable $e) {

                $conn->rollback();
                // $conn->close();

                error_log("Transaction Error: " . $e->getMessage());

                return false;
            }
        }





function db_connect(): mysqli
{
    static $conn = null;

    if ($conn instanceof mysqli) {
        return $conn;
    }

    $host = $_ENV['HOST'] ?? 'localhost';
    $db   = $_ENV['DB'] ?? '';
    $user = $_ENV['USER_NAME'] ?? '';
    $pass = $_ENV['PASS'] ?? '';
    $port = !empty($_ENV['DB_PORT']) ? (int)$_ENV['DB_PORT'] : 3306;


    
    $conn = new mysqli($host, $user, $pass, $db, $port);

    if ($conn->connect_error) {

        if (($_ENV['APPMOD'] ?? '') === 'Developing') {
            exit('Database Error: ' . $conn->connect_error);
        }

        error_log('Database Error: ' . $conn->connect_error);
        exit('Database Error: ' . $conn->connect_error);
    }

    if (!$conn->select_db($db)) {

        if (($_ENV['APPMOD'] ?? '') === 'Developing') {
            exit('Database Error: Cannot select database.');
        }

        error_log('Database Error: Cannot select database.');
        exit('Database Error: Cannot select database.');
    }

    if (!$conn->set_charset('utf8mb4')) {

        if (($_ENV['APPMOD'] ?? '') === 'Developing') {
            exit('Charset Error: ' . $conn->error);
        }

        exit('Database charset configuration failed.');
    }

    return $conn;
}





function db_close(): void
{
    static $closed = false;

    if ($closed) {
        return;
    }

    $conn = db_connect();

    if ($conn instanceof mysqli) {
        $conn->close();
    }

    $closed = true;
}












function remove_url_param(string $key, string $query = ''): string
{
    parse_str($query ?: ($_SERVER['QUERY_STRING'] ?? ''), $params);
    unset($params[$key]);
    return http_build_query($params);
}






function frm_response($data, bool $json = true, bool $base64 = true, bool $debug = false)
{
    try {

        if ($json) {
            $data = json_encode($data, JSON_THROW_ON_ERROR);
        }

        if ($debug) {
            exit($data);
        }

        if ($base64) {
            $data = base64_encode($data);
        }

        if (ob_get_length()) {
            ob_end_clean();
        }

        return $data;

    } catch (Throwable $e) {
        return false;
    }
}



function decrypt_url(int $mode = 1): void
{
    if (!isset($_GET['param'])) {
        return;
    }

    $decoded = decrypt_data(str_replace(' ', '+', $_GET['param']));

    if ($mode === 2) {
        print_r($decoded);
    }

    foreach ($decoded as $k => $v) {
        $_GET[$k] = $v;
    }

    if ($mode === 3) {
        print_r($_GET);
    }
}


function get_host(): string
{
    $ips = gethostbynamel(gethostname()) ?: [];
    rsort($ips);
    return $ips[0] ?? '127.0.0.1';
}



function get_cookie_domain(): string
{
    $params = session_get_cookie_params();
    return $params['domain'] ?? '';
}

function get_cookie_params(): array
{
    return session_get_cookie_params();
}


function destroy_session(): void
{
    $params = session_get_cookie_params();

    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params['path'],
        $params['domain'],
        $params['secure'],
        $params['httponly']
    );

    session_destroy();
}





function curdatetime(string $format = 'Y/m/d H:i:s'): string
{
    return date($format);
}








function get_youtube_id(string &$url, ?string $prefix = null, array $attr = [], ?string &$vidId = null): void
{
    $pattern = '/^(?:https?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&"\'>]+)/i';

    preg_match($pattern, $url, $matches);

    $vidId = $matches[1] ?? '';

    $prefix = $prefix ?: 'https://www.youtube.com/embed/';

    if ($vidId !== '') {
        $url = $prefix . $vidId;
        if (!empty($attr)) {
            $url .= '?' . http_build_query($attr);
        }
    }
}



function read_file(string $type, int $size, string $name, string $data): void
{
    $safeName = basename($name);

    header('Pragma: public');
    header('Expires: 0');
    header("Content-Type: {$type}");
    header("Content-Length: {$size}");
    header("Content-Disposition: attachment; filename=\"{$safeName}\"");
    header('Content-Transfer-Encoding: binary');

    echo $data;
    exit;
}





function user_detail(): array
{
    $userId   = $_SESSION['userid_front_v'] ?? $_SESSION['userid'] ?? null;
    $userType = $_SESSION['user_type'] ?? null;

    $localIP  = gethostbyname(gethostname());
    $remoteIP = $_SERVER['REMOTE_ADDR'] ?? '';
    $now      = date('Y/m/d H:i:s');

    return [
        $userId,
        $userType,
        $now,
        $remoteIP,
        $localIP,
        date('Y/m/d'),
        date('H:i:s')
    ];
}





function getNum(int $length = 8): string
{
    $result = '';

    while (strlen($result) < $length) {
        $result .= (string) random_int(0, 9);
    }

    return substr($result, 0, $length);
}




function getBrowser(): string
{
    $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';

    $map = [
        '/msie/i'    => 'Internet Explorer',
        '/firefox/i' => 'Firefox',
        '/safari/i'  => 'Safari',
        '/chrome/i'  => 'Chrome',
        '/edge/i'    => 'Edge',
        '/opera/i'   => 'Opera',
        '/mobile/i'  => 'Mobile'
    ];

    foreach ($map as $regex => $name) {
        if (preg_match($regex, $userAgent)) {
            return $name;
        }
    }

    return 'Unknown';
}

function audit_trail(
    string $tablename,
    int $action = 1
): bool
{
    $conn = db_connect(); 

    $user    = user_detail();
    $browser = getBrowser();

    $dated      = $user[2];
    $user_id    = (int)$user[0];
    $user_type  = (int)$user[1];
    $ip_addr    = $user[3];
    $timed      = date('H:i:s');
    $system_ip  = $user[4];

    $sql = "INSERT INTO web_user_trail
            (dated, user_id, user_type, tablename, actiontaken, ip_addr, timed, system_ip, browser)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        if (($_ENV['APPMOD'] ?? '') === 'Developing') {
            echo $conn->error;
        }
        return false;
    }

    $stmt->bind_param(
        "siisissss",
        $dated,
        $user_id,
        $user_type,
        $tablename,
        $action,
        $ip_addr,
        $timed,
        $system_ip,
        $browser
    );

    $result = $stmt->execute();

    if (!$result && (($_ENV['APPMOD'] ?? '') === 'Developing')) {
        echo $stmt->error;
    }

    $stmt->close();

    return $result;
}




function get_table_name(string $query): ?string
{
    $query = strtolower(trim($query));

    if (str_starts_with($query, 'insert')) {
        if (preg_match('/insert\s+into\s+([a-z0-9_]+)/', $query, $m)) {
            return $m[1];
        }
    }

    if (str_starts_with($query, 'update')) {
        if (preg_match('/update\s+([a-z0-9_]+)/', $query, $m)) {
            return $m[1];
        }
    }

    if (str_starts_with($query, 'delete')) {
        if (preg_match('/delete\s+from\s+([a-z0-9_]+)/', $query, $m)) {
            return $m[1];
        }
    }

    return null;
}




function simplefetch(string $qry, string $types = '', array $params = [], int $showQry = 1): array|false {
    if ($showQry === 2) {
        echo $qry;
    } elseif ($showQry === 3) {
        echo $qry;
        exit;
    }

    $conn = db_connect();
    try {
        $stmt = $conn->prepare($qry);
        if (!$stmt) {
            return false;
        }
        if (!empty($types) && !empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        if (!$result) {
            $stmt->close();
            return false;
        }

        $rows = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return [count($rows), $rows];
    } catch (Throwable $e) {
        if (($_ENV['APPMOD'] ?? '') === 'Developing') {
            echo $e->getMessage();
        }
        return false;
    }
}






function simplefetchUA(
    string $qry,
    string $types = '',
    array $params = [],
    int $showQry = 1
): array|bool
{
    if ($showQry === 2) {
        echo $qry;
    } elseif ($showQry === 3) {
        echo $qry;
        exit;
    }

    $conn = db_connect();

    try {

        $conn->begin_transaction();

        $stmt = $conn->prepare($qry);

        if (!$stmt) {
            throw new RuntimeException($conn->error);
        }

        if (!empty($types) && !empty($params)) {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();

        $insertId = $conn->insert_id;

        $stmt->close();

        $conn->commit();

        return $insertId > 0 ? [$insertId] : true;

    } catch (Throwable $e) {

        $conn->rollback();

        if (($_ENV['APPMOD'] ?? '') === 'Developing') {
            echo $e->getMessage();
        }

        return false;
    }
}




/*
function insert(string $table, array $data, int $showQry = 1): array|bool
{
    $pdo = db_connect();
    $user = user_detail();

    $data['entry_by']  = $user[0];
    $data['entry_date'] = $user[2];
    $data['ip_addr']    = $user[3];

    $columns = array_keys($data);
    $placeholders = array_map(fn($col) => ':' . $col, $columns);

    $sql = "INSERT INTO {$table} (" .
        implode(',', $columns) .
        ") VALUES (" .
        implode(',', $placeholders) .
        ")";

    if ($showQry === 2) {
        echo $sql;
    } elseif ($showQry === 3) {
        echo $sql;
        exit;
    }

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute($data);

        $id = $pdo->lastInsertId();

        audit_trail($pdo, $table, $id, null, $data, 1);

        return [$id];

    } catch (Throwable $e) {

        if (($_ENV['APPMOD'] ?? '') === 'Developing') {
            echo $e->getMessage();
        }

        return false;
    } finally {
        $pdo = null;
    }
}
*/

function insert(string $table, array $data, ?int $showQry = 1): array|bool
{
    $conn = db_connect();
    $user = user_detail();

    if (empty($table) || empty($data)) {
        return false;
    }

    $data['entry_by']   = $user[0];
    $data['entry_date'] = $user[2];
    $data['ip_addr']    = $user[3];

    $columns = array_keys($data);

    $escapedColumns = array_map(function ($col) {
        return '`' . str_replace('`', '', $col) . '`';
    }, $columns);

    $placeholders = implode(',', array_fill(0, count($columns), '?'));

    $sql = "INSERT INTO `{$table}` (" .
           implode(',', $escapedColumns) .
           ") VALUES (" .
           $placeholders .
           ")";

    if ($showQry === 2) {
        echo $sql;
    } elseif ($showQry === 3) {
        echo $sql;
        exit;
    }

    try {

        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            throw new RuntimeException($conn->error);
        }

        $types  = '';
        $values = [];

        foreach ($data as $value) {

            if (is_int($value)) {
                $types .= 'i';
            } elseif (is_float($value)) {
                $types .= 'd';
            } elseif (is_null($value)) {
                $types .= 's'; 
            } else {
                $types .= 's';
            }

            $values[] = $value;
        }

        $stmt->bind_param($types, ...$values);

        if (!$stmt->execute()) {
            throw new RuntimeException($stmt->error);
        }

        $insertId = $conn->insert_id;

        $stmt->close();

        audit_trail($table, $insertId, 1);

        return [$insertId];

    } catch (Throwable $e) {

        if (($_ENV['APPMOD'] ?? '') === 'Developing') {
            echo $e->getMessage();
        }

        return false;
    }
}


function update(string $table, array $data, string $condition, int $showQry = 1): bool
{
    $conn = db_connect();
    $user = user_detail();

    if (empty($table) || empty($data) || empty($condition)) {
        return false;
    }

    $data['entry_by']   = (int)$user[0];
    $data['entry_date'] = $user[2];
    $data['ip_addr']    = $user[3];

    $setParts = [];
    $types    = '';
    $values   = [];

    foreach ($data as $col => $val) {

        $col = '`' . str_replace('`', '', $col) . '`';
        $setParts[] = "{$col} = ?";

        if (is_int($val)) {
            $types .= 'i';
        } elseif (is_float($val)) {
            $types .= 'd';
        } elseif (is_null($val)) {
            $types .= 's';
        } else {
            $types .= 's';
        }

        $values[] = $val;
    }

    $sql = "UPDATE `{$table}` 
            SET " . implode(', ', $setParts) . "
            WHERE {$condition}
            AND status != 'Deleted'";

    if ($showQry === 2) {
        echo $sql;
    } elseif ($showQry === 3) {
        echo $sql;
        exit;
    }

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        if (($_ENV['APPMOD'] ?? '') === 'Developing') {
            echo $conn->error;
        }
        return false;
    }

    if (!empty($values)) {

        $bindParams = array_merge([$types], $values);
        $tmp = [];

        foreach ($bindParams as $key => $value) {
            $tmp[$key] = &$bindParams[$key];
        }

        call_user_func_array([$stmt, 'bind_param'], $tmp);
    }

    $result = $stmt->execute();

    if (!$result && (($_ENV['APPMOD'] ?? '') === 'Developing')) {
        echo $stmt->error;
    }

    $stmt->close();

    if ($result) {
        audit_trail($table, 0, 2);
    }

    return $result;
}



function delete(string $table, string $condition, int $showQry = 1): bool
{
    $conn = db_connect();   

    $user = user_detail();

    $status     = 'Deleted';
    $entry_by   = (int)$user[0];
    $entry_date = $user[2];
    $ip_addr    = $user[3];

    $sql = "UPDATE {$table}
            SET status = ?,
                entry_by = ?,
                entry_date = ?,
                ip_addr = ?
            WHERE {$condition}
            AND status != 'Deleted'";

    if ($showQry === 2) {
        echo $sql;
    } elseif ($showQry === 3) {
        echo $sql;
        exit;
    }

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        if (($_ENV['APPMOD'] ?? '') === 'Developing') {
            echo $conn->error;
        }
        return false;
    }

    $stmt->bind_param(
        "siss",
        $status,
        $entry_by,
        $entry_date,
        $ip_addr
    );

    $result = $stmt->execute();

    if (!$result && (($_ENV['APPMOD'] ?? '') === 'Developing')) {
        echo $stmt->error;
    }

    $stmt->close();

    if ($result) {
        audit_trail($table, 0, 3);
    }

    return $result;
}



function fetchtable(string $table, ?string $condition = null, int $fetchMode = 1): array|false
{
    $conn = db_connect();   

    $sql = "SELECT * FROM {$table} WHERE status = 'Active'";

    if (!empty($condition)) {
        $sql .= " AND {$condition}";
    }

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        if (($_ENV['APPMOD'] ?? '') === 'Developing') {
            echo $conn->error;
        }
        return false;
    }

    if (!$stmt->execute()) {
        if (($_ENV['APPMOD'] ?? '') === 'Developing') {
            echo $stmt->error;
        }
        $stmt->close();
        return false;
    }

    $result = $stmt->get_result();

    if (!$result) {
        $stmt->close();
        return false;
    }

    if ($fetchMode === 2) {
        $data = $result->fetch_all(MYSQLI_ASSOC); 
        $data = array_map(fn($row) => (object)$row, $data);
    } else {
        $data = $result->fetch_all(MYSQLI_ASSOC);
    }

    $count = count($data);

    $stmt->close();

    return [$count, $data];
}





function fetchcols(string $table, string $cols, ?string $condition = null, int $fetchMode = 1): array|false
{
    $conn = db_connect();   

    $sql = "SELECT {$cols} FROM {$table} WHERE status = 'Active'";

    if (!empty($condition)) {
        $sql .= " AND {$condition}";
    }

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        if (($_ENV['APPMOD'] ?? '') === 'Developing') {
            echo $conn->error;
        }
        return false;
    }

    if (!$stmt->execute()) {
        if (($_ENV['APPMOD'] ?? '') === 'Developing') {
            echo $stmt->error;
        }
        $stmt->close();
        return false;
    }

    $result = $stmt->get_result();

    if (!$result) {
        $stmt->close();
        return false;
    }

    $data = $result->fetch_all(MYSQLI_ASSOC);

    if ($fetchMode === 2) {
        $data = array_map(fn($row) => (object)$row, $data);
    }

    $count = count($data);

    $stmt->close();

    return [$count, $data];
}






function getName(string $table, string $column, string $condition): string
{
    $result = fetchcols($table, $column, $condition, 1);

    if ($result && $result[0] > 0) {
        return (string) array_values($result[1][0])[0];
    }

    return '';
}



function getNameQry(string $query): string
{
    $result = simplefetch($query);

    if ($result && $result[0] > 0) {
        return (string) array_values($result[1][0])[0];
    }

    return '';
}




function sp_call(string $spCall): array|false
{
    $conn = db_connect(); 

    $stmt = $conn->prepare($spCall);

    if (!$stmt) {
        if (($_ENV['APPMOD'] ?? '') === 'Developing') {
            echo $conn->error;
        }
        return false;
    }

    if (!$stmt->execute()) {
        if (($_ENV['APPMOD'] ?? '') === 'Developing') {
            echo $stmt->error;
        }
        $stmt->close();
        return false;
    }

    $result = $stmt->get_result();

    if (!$result) {
        $stmt->close();
        return false;
    }

    $data = $result->fetch_all(MYSQLI_ASSOC);

    $stmt->close();

    return $data;
}



function batch_execute(string $queries): bool
{
    $conn = db_connect();  

    $parts = array_filter(explode('|$$|', $queries));

    if (empty($parts)) {
        return false;
    }

    $conn->begin_transaction();

    try {

        foreach ($parts as $sql) {

            if (!$conn->query($sql)) {

                if (($_ENV['APPMOD'] ?? '') === 'Developing') {
                    echo $conn->error;
                }

                $conn->rollback();
                return false;
            }
        }

        $conn->commit();
        return true;

    } catch (Throwable $e) {

        $conn->rollback();

        if (($_ENV['APPMOD'] ?? '') === 'Developing') {
            echo $e->getMessage();
        }

        return false;
    }
}






function upload_file_binary(string $inputName, bool $thumb = false, int $thumbWidth = 100): array|false
{
    if (!isset($_FILES[$inputName])) {
        return false;
    }

    $file = $_FILES[$inputName];

    if ($file['error'] !== UPLOAD_ERR_OK) {
        return false;
    }

    if ($file['size'] > 100 * 1024 * 1024) { // 100MB
        return false;
    }

    $allowed = [
        'png','zip','pdf','doc','gif','jpg','xls','bmp','tif',
        'docx','xlsx','jpeg','pfx','avi','mp4','flv'
    ];

    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if (!in_array($ext, $allowed, true)) {
        return false;
    }

    $content = file_get_contents($file['tmp_name']);

    if ($content === false) {
        return false;
    }

    $newName = getNum(12) . '.' . $ext;

    return [
        $newName,
        $file['type'],
        $ext,
        $file['size'],
        $content
    ];
}



function generatePassword(int $length = 12): array
{
    $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz23456789@#%_';
    $max = strlen($chars) - 1;

    $password = '';

    for ($i = 0; $i < $length; $i++) {
        $password .= $chars[random_int(0, $max)];
    }

    return [
        $password,
        password_hash($password, PASSWORD_DEFAULT)
    ];
}




// function todate(string $date): ?string
// {
//     if ($date === '') {
//         return null;
//     }

//     $dt = DateTime::createFromFormat('d/m/Y', $date);

//     if (!$dt) {
//         return null;
//     }

//     return $dt->format('Y-m-d');
// }



// function fromdate(string $date): ?string
// {
//     if ($date === '') {
//         return null;
//     }

//     $dt = DateTime::createFromFormat('Y-m-d', substr($date, 0, 10));

//     if (!$dt) {
//         return null;
//     }

//     return $dt->format('d/m/Y');
// }




function createFolder(string $folder, ?string $sub = null): bool
{
    $base = realpath(__DIR__ . '/..') . '/WriteReadData';

    if (!is_dir($base) && !mkdir($base, 0755, true)) {
        return false;
    }

    $path = $base . '/' . $folder;

    if (!is_dir($path) && !mkdir($path, 0755, true)) {
        return false;
    }

    if ($sub) {
        $subPath = $path . '/' . $sub;
        if (!is_dir($subPath) && !mkdir($subPath, 0755, true)) {
            return false;
        }
    }

    return true;
}




function upload(string $input, string $folder, ?string $sub = null, ?string $oldFile = null): ?string
{
    if (!isset($_FILES[$input]) || $_FILES[$input]['error'] !== UPLOAD_ERR_OK) {
        return null;
    }

    if ($_FILES[$input]['size'] > 100 * 1024 * 1024) {
        return null;
    }

    $allowed = [
        'png','zip','pdf','doc','gif','jpg','xls','bmp','tif',
        'docx','xlsx','jpeg','avi','mp4','flv','mkv'
    ];

    $ext = strtolower(pathinfo($_FILES[$input]['name'], PATHINFO_EXTENSION));

    if (!in_array($ext, $allowed, true)) {
        return null;
    }

    if (!createFolder($folder, $sub)) {
        return null;
    }

    $base = realpath(__DIR__ . '/..') . "/WriteReadData/$folder";
    $path = $sub ? "$base/$sub" : $base;

    $newName = getNum(16) . '.' . $ext;

    $destination = $path . '/' . $newName;

    if (!move_uploaded_file($_FILES[$input]['tmp_name'], $destination)) {
        return null;
    }

    if ($oldFile && file_exists($path . '/' . $oldFile)) {
        unlink($path . '/' . $oldFile);
    }

    return $newName;
}








function allowSpecialChar(string &$value): void
{
    $value = str_replace("'", "''", $value);
}




function AjaxFilePrevent(): void
{
    if (empty($_SERVER['HTTP_REFERER'])) { 
        echo "No referer";
        http_response_code(403);
        header('Location: /');
        exit;
    }

    $ref = parse_url($_SERVER['HTTP_REFERER']);
    $allowed = array_map('trim', explode(',', $_ENV['ALLOWED_HOSTS'] ?? ''));

    // if (!isset($ref['host']) || !in_array($ref['host'], $allowed, true)) {
    //     echo 'Invalid referer';
    //     http_response_code(403);
    //     exit;
    // }
}




function getDifference(string $start, string $end, int $format): int
{
    $startDt = new DateTime($start);
    $endDt   = new DateTime($end);

    $diffSeconds = $endDt->getTimestamp() - $startDt->getTimestamp();

    return match ($format) {
        1 => intdiv($diffSeconds, 60),
        2 => intdiv($diffSeconds, 3600),
        3 => intdiv($diffSeconds, 86400),
        4 => intdiv($diffSeconds, 604800),
        5 => intdiv($diffSeconds, 2628000), 
        default => intdiv($diffSeconds, 31536000), 
    };
}




function alert(): string
{
    return "onclick=\"alert('As Yet Utility Not Developed / Under Development !'); return false;\"";
}



function ordinal_suffix(int $num): string
{
    $n = $num % 100;

    if ($n < 11 || $n > 13) {
        return match ($n % 10) {
            1 => $num . 'st',
            2 => $num . 'nd',
            3 => $num . 'rd',
            default => $num . 'th'
        };
    }

    return $num . 'th';
}




function convert_digit_to_words($num): string
{

    if (!is_numeric($num)) {
        return '';
    }

    $words = [
        0=>'Zero',1=>'One',2=>'Two',3=>'Three',4=>'Four',5=>'Five',
        6=>'Six',7=>'Seven',8=>'Eight',9=>'Nine',10=>'Ten',11=>'Eleven',
        12=>'Twelve',13=>'Thirteen',14=>'Fourteen',15=>'Fifteen',
        16=>'Sixteen',17=>'Seventeen',18=>'Eighteen',19=>'Nineteen',
        20=>'Twenty',30=>'Thirty',40=>'Forty',50=>'Fifty',
        60=>'Sixty',70=>'Seventy',80=>'Eighty',90=>'Ninety'
    ];

    if ($num < 21) return $words[$num] ?? '';
    if ($num < 100) {
        return $words[intdiv($num,10)*10] . ' ' . convert_digit_to_words($num % 10);
    }
    if ($num < 1000) {
        return convert_digit_to_words(intdiv($num,100)) . ' Hundred ' . convert_digit_to_words($num % 100);
    }

    return (string)$num;
}





function IND_money_format(string $money, int $dec = 2): string
{
    $parts = explode('.', $money);
    $intPart = $parts[0];
    $decPart = $parts[1] ?? '';

    $formatted = number_format((float)$intPart, 0, '', ',');

    if ($dec > 0) {
        $decPart = str_pad(substr($decPart, 0, $dec), $dec, '0');
        return $formatted . '.' . $decPart;
    }

    return $formatted;
}








function LoginSetCookie(): void
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    session_regenerate_id(true);

    $params = session_get_cookie_params();

    setcookie(
        session_name(),
        session_id(),
        [
            'expires'  => time() + (defined('CLIFETIME') ? CLIFETIME : 3600),
            'path'     => $params['path'],
            'domain'   => $params['domain'],
            'secure'   => true,
            'httponly' => true,
            'samesite' => 'Strict'
        ]
    );
}






function chkDate(string $date): bool
{
    if (str_contains($date, '/')) {
        [$d, $m, $y] = explode('/', $date);
        return checkdate((int)$m, (int)$d, (int)$y);
    }

    if (str_contains($date, '-')) {
        [$d, $m, $y] = explode('-', $date);
        return checkdate((int)$m, (int)$d, (int)$y);
    }

    return false;
}





function LiveUsers(bool $logUser = false): array
{
    $conn = db_connect();   

    $now     = time();
    $expire  = $now - 120;
    $session = session_id();
    $userId  = isset($_SESSION['userid']) ? (int)$_SESSION['userid'] : null;

    $sql = "SELECT id FROM online_users WHERE session_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $session);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {

        $stmt->close();

        $sql = "UPDATE online_users 
                SET ses_time = ?, user_id = ?
                WHERE session_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iis", $now, $userId, $session);
        $stmt->execute();
        $stmt->close();

    } else {

        $stmt->close();

        $sql = "INSERT INTO online_users (ses_time, session_id, user_id)
                VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isi", $now, $session, $userId);
        $stmt->execute();
        $stmt->close();
    }

    $sql = "DELETE FROM online_users WHERE ses_time < ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $expire);
    $stmt->execute();
    $stmt->close();

    $total = 0;
    $res = $conn->query("SELECT COUNT(*) AS cnt FROM online_users");
    if ($row = $res->fetch_assoc()) {
        $total = (int)$row['cnt'];
    }

    $resultArr = [$total];

    if ($logUser) {
        $logged = 0;
        $res = $conn->query("SELECT COUNT(*) AS cnt FROM online_users WHERE user_id IS NOT NULL");
        if ($row = $res->fetch_assoc()) {
            $logged = (int)$row['cnt'];
        }
        $resultArr[] = $logged;
    }

    return $resultArr;
}



	function headersFront($page, $param) {
		$parameter = $param;
		$pagename = strtolower($page);
		if ($pagename === "message") {
			$sendToPage = "message.php?id=" . $param . "&lang=" . $_SESSION['lang'];
			// echo "<script>window.location=\"$sendToPage\"</script>";
			header("Location:$sendToPage");
			exit;
		} elseif ($pagename === "message_close") {
			$sendToPage = "message_close.php?id=" . $param . "&lang=" . $_SESSION['lang'];
			// echo "<script>window.location=\"$sendToPage\"</script>";
			header("Location:$sendToPage");
			exit;
		} else {
			if (!is_null($param)) {
				$sendToPage = $page . ".php?" . $param . "&lang=" . $_SESSION['lang'];
			} else {
				$sendToPage = $page . ".php" . "?lang=" . ($_SESSION['lang'] ?? '');
			}

			// echo "<script>window.location=\"$sendToPage\"</script>";
			header("Location:$sendToPage");
			exit;
		}
	}



function genSide(?string $table, ?string $cols, ?string $cond): array
{
    $appName = $_ENV['APP_NAME'] ?? 'Application';
    $appDept = $_ENV['APP_DEPART'] ?? $appName;

    if (!$table || !$cols) {
        return [0, $appDept, $appDept, $appDept, $appDept];
    }

    $allowedTables = ['web_link_temp', 'circulars', 'tenders'];

    if (!in_array($table, $allowedTables, true)) {
        return [1, "{$appName}, Government Of India", $appName, $appName, "{$appName}, Government Of India"];
    }

    $conn = db_connect();

    $sql = "SELECT {$cols} FROM {$table}";

    if (!empty($cond)) {
        $sql .= " WHERE {$cond}";
    } else {
        $sql .= " LIMIT 1";
    }

    $result = $conn->query($sql);

    if (!$result) {
        return [0, $appName, $appName, $appName, $appName];
    }

    $row = $result->fetch_assoc();

    if (!$row) {
        return [0, $appName, $appName, $appName, $appName];
    }

    return [
        1,
        $row['title'] ?? $appName,
        $row['meta_tag'] ?? $appName,
        $row['source'] ?? $appName,
        $row['keywords'] ?? $appName
    ];
}








function show_msg(string $msg, string $class = 'alert-info', bool $alert = false, bool $close = true): void
{
    if (!$alert) {
        $_SESSION['msg'] =
            "<div class='alert {$class}'>" .
            htmlspecialchars($msg, ENT_QUOTES, 'UTF-8') .
            "</div>";
        return;
    }

    $js = $close ? "window.close();" : "";
    echo "<script>alert(" . json_encode($msg) . ");{$js}</script>";

    if ($close) {
        exit;
    }
}




function db_connect_sqlsrv(): PDO
{
    try {

        $host = $_ENV['SQL_HOST'] ?? '';
        $db   = $_ENV['SQL_DB'] ?? '';
        $user = $_ENV['SQL_USER'] ?? '';
        $pass = $_ENV['SQL_PASS'] ?? '';

        $dsn = "sqlsrv:Server={$host};Database={$db}";

        return new PDO(
            $dsn,
            $user,
            $pass,
            [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]
        );

    } catch (Throwable $e) {

        if (($_ENV['APPMOD'] ?? '') === 'Developing') {
            exit('SQLSRV Error: ' . $e->getMessage());
        }

        exit('Cannot connect to MS-SQL Server.');
    }
}




if (
    ($_SERVER['HTTP_ACCEPT'] ?? '') !== '*/*' &&
    empty($_SERVER['HTTP_CACHE_CONTROL'] ?? '')
) {
    unset($_SESSION['FormField'], $_SESSION['Req_Error']);
}





function subquerylinkhindi2($lang)
{

    $hindiQry = "";
    if ($lang == "2" )  {
        $hindiQry = "h.link_name ,h.link_bdesc,h.details ,h.title,date_format(h.publish_date,'%d %M %Y') as  publish_date, lf.hindi_id as lid,case when h.type_id!=3 then '' else '' end as l_target ,";
    }else if ($lang == "3" )  {
        $hindiQry = "h.link_name ,h.link_bdesc,h.details ,h.title,date_format(h.publish_date,'%d %M %Y') as  publish_date, lf.marati_id as lid,case when h.type_id!=3 then '' else '' end as l_target ,";
    } else {
        $hindiQry = "lt.link_name,lt.link_bdesc,lt.details ,lt.title,date_format(lf.publish_date,'%d %M %Y') as  publish_date, lf.hindi_id as lid,case when lt.type_id!=3 then '' else '' end as l_target ,";
    }

    return $hindiQry;
}
