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

    $calendarList  = $service->calendarList->listCalendarList();

    $srt_json = '';
    foreach ($calendarList as $calendar) {
        $getCalendars = json_decode($srt_json);
        $getCalendars []= array('id' => $calendar->id, 'name' => $calendar->summary);
        $srt_json = json_encode($getCalendars); 
    }
    print_r($srt_json);
} catch (Exception $e) {
    echo 'false';
}
?>