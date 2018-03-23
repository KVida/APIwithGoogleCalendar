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
    
    $event = new Google_Service_Calendar_Event(array(
      'summary' => 'Создание нового события',
      'location' => '800 Howard St., San Francisco, CA 94103',
      'description' => 'A chance to hear more about Google\'s developer products.',
      'start' => array(
        'dateTime' => '2018-03-23T09:00:00+02:00',
        'timeZone' => 'Europe/Kiev',
      ),
      'end' => array(
        'dateTime' => '2018-03-23T17:00:00+02:00',
        'timeZone' => 'Europe/Kiev',
      ),
      'recurrence' => array(
        'RRULE:FREQ=DAILY;COUNT=2'
      ),
      'attendees' => array(
        array('email' => 'lpage@example.com'),
        array('email' => 'sbrin@example.com'),
      ),
      'reminders' => array(
        'useDefault' => FALSE,
        'overrides' => array(
          array('method' => 'email', 'minutes' => 24 * 60),
          array('method' => 'popup', 'minutes' => 10),
        ),
      ),
    ));

    $calendarId = 'primary';
    $event = $service->events->insert($calendarId, $event);
    printf('Event created: %s\n', $event->htmlLink);
} catch (Exception $e) {
    echo 'false';
}
?>