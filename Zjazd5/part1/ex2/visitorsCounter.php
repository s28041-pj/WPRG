<style>
    body {
        background-color: #f8f8f8;
    }
</style>
<?php
$visitors = 1;

if (isset($_COOKIE['visitors'])) {
    $visitors = (int)$_COOKIE['visitors'] + 1;
}

setcookie('visitors', $visitors, time() + (86400 * 2));

if ($visitors > 1) {
    echo "You visit this page $visitors times";
} else {
    echo "This is your $visitors visit on this page";
}
?>
