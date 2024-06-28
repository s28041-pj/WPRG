<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];


    $to = 'toregi8116@cutxsew.com';
    $subject = 'New Contact Message';
    $headers = "From: $name <$email>";

    if (mail($to, $subject, $message, $headers)) {
        http_response_code(200);
    } else {
        http_response_code(500);
    }
}
?>
