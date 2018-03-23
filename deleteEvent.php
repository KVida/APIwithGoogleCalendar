<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config.php';

session_start();

/**
* Returns an authorized API client.
* @return Google_Client the authorized client object
*/
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

try { 
    $client = getClient();

    $service = new Google_Service_Calendar($client);

    $calendarId = 'primary';
    $eventId = '7jradfp2eiavi8i20qpo3sfo5g_20180329T070000Z'; 

	$event = $service->events->delete($calendarId, $eventId);

	echo '{"success" => true}'; 
} catch (Exception $e) {
    echo '{"success" => false}';
}