<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config.php';
ini_set('session.gc_maxlifetime', 72000);

session_start();

function getClient() {
    $client = new Google_Client();
    $client->setApplicationName(APPLICATION_NAME);
    $client->setScopes(SCOPES);
    $client->setAuthConfig(CLIENT_SECRET_PATH);
    $client->setAccessType('offline');

    $accessToken = $_SESSION['accessToken'];
    $client->setAccessToken($accessToken);

    return $client;
}
?>