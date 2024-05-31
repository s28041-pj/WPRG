<style>
    body {
        background-color: #f8f8f8;
    }
</style>
<?php
session_start();
$visitors = 1;

if (isset($_SESSION['visitors'])) {
    $visitors = $_SESSION['visitors'];
} elseif (isset($_COOKIE['visitors'])) {
    $visitors = (int)$_COOKIE['visitors'] + 1;
}

$_SESSION['visitors'] = $visitors;
setcookie('visitors', $visitors, time() + (86400 * 2));

if ($visitors > 1) {
    echo "You visit this web $visitors times";
} else {
    echo "This is your $visitors visit on this page";
}
?>
