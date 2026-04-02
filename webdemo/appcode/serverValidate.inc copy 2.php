<?php
declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Constants
|--------------------------------------------------------------------------
*/

const VALIDATE_EMAIL      = '/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/';
const VALIDATE_INTEGER    = '/^[0-9-]+$/';
const VALIDATE_ALPHA      = '/^[a-zA-Z\s]+$/';
const VALIDATE_ALPHA_S    = '/^[a-zA-Z\s ]+$/';
const VALIDATE_ALPHANUM   = '/^[A-Za-z0-9\r\n]+$/';
const VALIDATE_ALPHANUM_S = '/^[A-Za-z0-9 \r\n\/]+$/';
const VALIDATE_ALPHANUM_SPC = '/^[a-zA-Z0-9 \r\n!@.\-:$_#&,;?]+$/';
const VALIDATE_DATE       = '/^(0[1-9]|[12]\d|3[01])\/(0[1-9]|1[0-2])\/\d{4}$/';
const VALIDATE_TIME       = '/^(2[0-3]|[01]?[0-9]):([0-5]?[0-9])$/';
const VALIDATE_FILENAME   = '/^[a-zA-Z0-9]+\.[a-z0-9]{3,4}$/i';


/*
|--------------------------------------------------------------------------
| Core Helpers
|--------------------------------------------------------------------------
*/

function checkInp(string $str, string $pattern): bool
{
    return preg_match($pattern, $str) === 1;
}

function checkLang(string $str, string $pattern): bool
{
    $result = preg_replace($pattern, '', $str);
    return $result === $str;
}

function getFormType(): string
{
    $contentType = '';

    if (!empty($_SERVER['HTTP_CONTENT_TYPE'])) {
        $contentType = strtolower($_SERVER['HTTP_CONTENT_TYPE']);
    } elseif (!empty($_SERVER['CONTENT_TYPE'])) {
        $contentType = strtolower($_SERVER['CONTENT_TYPE']);
    }

    if (str_contains($contentType, 'multipart/form-data')) {
        return 'Upload';
    }

    if (str_contains($contentType, 'application/x-www-form-urlencoded')) {
        return 'Normal';
    }

    return '';
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


function todate(string $datevar): string
{
    if (strpos($datevar, '/') === false) {
        return '';
    }

    [$day, $month, $year] = explode('/', $datevar);
    return sprintf('%04d-%02d-%02d', (int)$year, (int)$month, (int)$day);
}

function DateDifference(string $from, string $to): bool
{
    if (strpos($from, '/') === false || strpos($to, '/') === false) {
        return false;
    }

    $fromDate = strtotime(todate($from));
    $toDate   = strtotime(todate($to));

    if ($fromDate === false || $toDate === false) {
        return false;
    }

    return ($toDate - $fromDate) <= 0;
}

function CheckInternet(): bool
{
    return (bool) @fsockopen('www.google.com', 80, $errno, $errstr, 3);
}

function CheckEmailDomain(string $email): bool
{
    if (!CheckInternet()) {
        return true;
    }

    $parts = explode('@', $email);
    if (count($parts) !== 2) {
        return false;
    }

    return getmxrr($parts[1], $mxrecords);
}


/*
|--------------------------------------------------------------------------
| Main Validation Engine (Same Old Name)
|--------------------------------------------------------------------------
*/

function requestcheck(
    string $ValidationStr,
    ?string $formName,
    string $pType,
    bool $forAjax = false,
    bool $nonASCII = false
) {

    $chkFlag = false;
    $errors  = [];

    $fields = explode("|$$|", $ValidationStr);
    $FormType = $formName !== null ? getFormType() : '';

    foreach ($fields as $definition) {

        $parts = explode('|', $definition);
        $fieldName = $parts[0] ?? '';
        $required  = strtolower($parts[2] ?? '') === 'y';

        $value = $_REQUEST[$fieldName] ?? '';
        $value = is_string($value) ? trim($value) : $value;

        $errorMessage = end($parts);

        if ($required && ($value === '' || $value === null)) {
            $errors[$fieldName][] = "$fieldName: $errorMessage";
            $chkFlag = true;
            continue;
        }

        foreach ($parts as $rule) {

            if ($rule === 'email' && $value !== '') {
                if (!checkInp($value, VALIDATE_EMAIL)) {
                    $errors[$fieldName][] = "$fieldName: $errorMessage";
                    $chkFlag = true;
                }
            }

            if ($rule === 'alpha' && $value !== '') {
                if (!checkInp($value, VALIDATE_ALPHA)) {
                    $errors[$fieldName][] = "$fieldName: $errorMessage";
                    $chkFlag = true;
                }
            }

            if ($rule === 'numeric' && $value !== '') {
                if (!checkInp($value, VALIDATE_INTEGER)) {
                    $errors[$fieldName][] = "$fieldName: $errorMessage";
                    $chkFlag = true;
                }
            }

            if ($rule === 'dt' && $value !== '') {
                if (!checkInp($value, VALIDATE_DATE)) {
                    $errors[$fieldName][] = "$fieldName: $errorMessage";
                    $chkFlag = true;
                }
            }

            if ($rule === 'time' && $value !== '') {
                if (!checkInp($value, VALIDATE_TIME)) {
                    $errors[$fieldName][] = "$fieldName: $errorMessage";
                    $chkFlag = true;
                }
            }
        }
    }

    if ($forAjax) {
        return [$chkFlag, $errors];
    }

    if ($chkFlag && !$forAjax) {
        foreach ($errors as $field => $msgs) {
            foreach ($msgs as $msg) {
                echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        createErrorSpace('$formName','$field','$pType','" . addslashes($msg) . "');
                    });
                </script>";
            }
        }
    }

    return $chkFlag;
}