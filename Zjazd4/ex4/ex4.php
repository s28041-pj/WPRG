<?php
$allowedIPsFile = 'allowedIps.txt';
$allowedPage = 'allowedPage.php';
$defaultPage = 'commonPage.php';
$userIP = $_SERVER['REMOTE_ADDR'];

if (file_exists($allowedIPsFile)) {
    $handle = fopen($allowedIPsFile, 'r');

    if ($handle) {
        $allowed = findIpInAllowedIpsFile($handle, $userIP);
        if ($allowed) {
            include($allowedPage);
        } else {
            include($defaultPage);
        }
    } else {
        include($defaultPage);
    }
} else {
    include($defaultPage);
}

function findIpInAllowedIpsFile($handle, $userIP): bool
{
    $allowed = false;
    while (($line = fgets($handle)) !== false) {
        $line = trim($line);
        if ($line === $userIP) {
            $allowed = true;
            break;
        }
    }
    fclose($handle);
    return $allowed;
}
?>
