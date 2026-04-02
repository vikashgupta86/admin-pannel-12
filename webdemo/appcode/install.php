
<?php

    function get_client_ip() {
        $ip_address = '';
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip_address = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip_address = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
        } else {
            $ip_address = $_SERVER['REMOTE_ADDR'];
        }
        return $ip_address;
    }

    function get_server_ip() {
        $host = gethostname();
        $ip = gethostbyname($host);
        return $ip;
    }

    $client_ip = get_client_ip();
    $server_ip = get_server_ip();
    $server_addr_superglobal = $_SERVER['SERVER_ADDR'] ?? '';

    $loopback_ipv4 = '127.0.0.1';
    $loopback_ipv6 = '::1';

    if ($client_ip === $server_ip || $client_ip === $server_addr_superglobal || $client_ip === $loopback_ipv4 || $client_ip === $loopback_ipv6) {
        $same_machine = true;
    } else {
        $same_machine = false;
    }

    if(!$same_machine) {
        echo "Installation can only be run from the same machine. Your IP: {$client_ip}";
        exit;
    } else {
        echo "Installation can proceed. Your IP: {$client_ip}";
        echo '<br>';
        echo 'Current PHP version: ' . phpversion();
    }
?>