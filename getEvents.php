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
        $calendarId = 'primary';

        $optParams = array(
            'maxResults' => 100,
            'orderBy' => 'startTime', 
            'singleEvents' => TRUE, 
            'timeMin' => '2018-03-20T00:00:00+02:00',
            'timeMax' => '2018-03-31T00:00:00+02:00',
        );

        $results = $service->events->listEvents($calendarId, $optParams);
        $itemCalendar = $results->getItems();

        if (count($results->getItems()) == 0) {
            echo "No upcoming events found."; 
        } else {
            foreach ($results->getItems() as $event) {
                if (!empty($event->location)) {
                    $localEvent = $event->location;
                } else {
                    $localEvent = '';
                }

                if (!empty($event->description)) {
                    $descriptionEvent = $event->description;
                }else {
                    $descriptionEvent = '';
                }
            
                $getCalendars = json_decode($srt_json);
                $getCalendars []= array('calendarId' => $calendarId, 'name' => $calendar->summary,'eventId' => $event->id,'eventName' => $event->summary,'createdEvent' => $event->created, 'status' => $event->status,'htmlLink' => $event->htmlLink,'startData' => $event->start->dateTime,'endData' => $event->end->dateTime,'location' => $localEvent,'description' => $descriptionEvent);
                $srt_json = json_encode($getCalendars);
            }
        }
    }
    print_r($srt_json);
} catch (Exception $e) {
    echo 'false';
}

?>