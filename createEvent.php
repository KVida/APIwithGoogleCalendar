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
    
    $str_json = '{"summary":"22 \u043c\u0430\u0440\u0442\u0430 2018","startData":"2018-03-26T12:00:00+02:00","endData":"2018-03-26T16:00:00+02:00","location":"\u041a\u0438\u0435\u0432, \u0423\u043a\u0440\u0430\u0438\u043d\u0430, 02000","description":"\u044d\u0442\u043e \u043c\u043e\u0435 \u043f\u0435\u0440\u0432\u043e\u0435 \u043e\u043f\u0438\u0441\u0430\u043d\u0438\u0435"}';

    $strEvent = json_decode($str_json, true);

    $event = new Google_Service_Calendar_Event(array(
        'summary' => $strEvent['summary'],
        'location' => $strEvent['location'],
        'description' => $strEvent['description'],
        'start' => array(
          'dateTime' => $strEvent['startData'],
          'timeZone' => 'Europe/Kiev',
        ),
        'end' => array(
          'dateTime' => $strEvent['endData'],
          'timeZone' => 'Europe/Kiev',
        ),
    ));

    $calendarId = 'primary';
    $event = $service->events->insert($calendarId, $event);
    printf('Event created: %s\n', $event->htmlLink);
} catch (Exception $e) {
    echo 'false';
}
?>