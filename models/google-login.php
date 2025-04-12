<?php
// google-login.php
require_once 'vendor/autoload.php';

$googleClient = new Google_Client();
$googleClient->setClientId('YOUR_GOOGLE_CLIENT_ID');
$googleClient->setClientSecret('YOUR_GOOGLE_CLIENT_SECRET');
$googleClient->setRedirectUri('YOUR_REDIRECT_URI');
$googleClient->addScope('email');
?>
