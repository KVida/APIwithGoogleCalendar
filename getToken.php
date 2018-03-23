<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config.php';

ini_set('session.gc_maxlifetime', 72000);
session_start();

if (isset($_POST['authCode'])) {
    $authCode = trim($_POST['authCode']);

    $client = new Google_Client();
    $client->setApplicationName(APPLICATION_NAME);
    $client->setScopes(SCOPES);
    $client->setAuthConfig(CLIENT_SECRET_PATH);
    $client->setAccessType('offline');

    if (isset($_SESSION['accessToken'])) {
        $accessToken = $_SESSION['accessToken'];
    } else {
        $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
        $_SESSION['accessToken'] = $accessToken;
    }
   
/*    // Refresh the token if it's expired.
    if ($client->isAccessTokenExpired()) {
        $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
        $_SESSION['accessToken'] = $client->getAccessToken();
    }*/

    header('Location: http://localhost/calendar/app.php');
} else {
    header('Location: http://localhost/calendar/');
}

?>