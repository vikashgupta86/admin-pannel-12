<?php
 if (file_exists(BASE_PATH . '/vendor/autoload.php')) {
     require_once BASE_PATH . '/vendor/autoload.php';
 }

function clean_xss($data) {
    if ($data === null || $data === '') {
        return '';
    }

    static $purifier = null;
    if ($purifier === null) {
        $config = HTMLPurifier_Config::createDefault();
        $config->set('HTML.Doctype', 'HTML 4.01 Transitional');
        $config->set('Core.Encoding', 'UTF-8');
        
        $cacheDir = BASE_PATH . '/WriteReadData/PurifierCache';
        if (is_dir($cacheDir) && is_writable($cacheDir)) {
            $config->set('Cache.SerializerPath', $cacheDir);
        } else {
            $config->set('Cache.DefinitionImpl', null); // Disable cache if no writable dir
        }

        $purifier = new HTMLPurifier($config);
    }

    return $purifier->purify($data);
}

function clean_entity_decode($string, $flags = ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML401, $encoding = 'UTF-8') {
    $decoded = html_entity_decode($string ?? '', $flags, $encoding);
    return clean_xss($decoded);
}

function safe_html_entity_decode($string, $flags = ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML401, $encoding = 'UTF-8') {
    return clean_entity_decode($string, $flags, $encoding);
}

function clean_htmlspecialchars($string, $flags = ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML401, $encoding = 'UTF-8', $double_encode = true) {
    $purified = clean_xss($string ?? '');
    return htmlspecialchars($purified, $flags, $encoding, $double_encode);
}

function safe_htmlspecialchars($string, $flags = ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML401, $encoding = 'UTF-8', $double_encode = true) {
    return clean_htmlspecialchars($string, $flags, $encoding, $double_encode);
}

if (!function_exists('_html_entity_decode')) {
    function _html_entity_decode($string, $flags = ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML401, $encoding = 'UTF-8') {
        return clean_entity_decode($string, $flags, $encoding);
    }
}

if (!function_exists('_htmlspecialchars')) {
    function _htmlspecialchars($string, $flags = ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML401, $encoding = 'UTF-8', $double_encode = true) {
        return clean_htmlspecialchars($string, $flags, $encoding, $double_encode);
    }
}
