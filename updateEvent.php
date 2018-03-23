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

try{
	$client = getClient();

	$service = new Google_Service_Calendar($client);

	$str_json = '{"summary":"22 \u043c\u0430\u0440\u0442\u0430 2018","startData":"2018-03-26T12:00:00+02:00","endData":"2018-03-26T16:00:00+02:00","location":"\u041a\u0438\u0435\u0432, \u0423\u043a\u0440\u0430\u0438\u043d\u0430, 02000","description":"\u044d\u0442\u043e \u043c\u043e\u0435 \u043f\u0435\u0440\u0432\u043e\u0435 \u043e\u043f\u0438\u0441\u0430\u043d\u0438\u0435"}';

    $strEvent = json_decode($str_json, true);

	$calendarId = 'primary';
	$eventId = 'vr59q9ibrfh8pvur3haej182tk';

	$event = $service->events->get($calendarId, $eventId);
	$event->setSummary($strEvent['summary']);
	$event->setLocation($strEvent['location']);


	$start = new Google_Service_Calendar_EventDateTime();
	$start->setDateTime($strEvent['startData']);
	$event->setStart($start);

	$end = new Google_Service_Calendar_EventDateTime();
	$end->setDateTime($strEvent['endData']);
	$event->setEnd($end);

	/*//на целый день c по - не беря в расчет последний день
	$start = new Google_Service_Calendar_EventDateTime();
	$start->setDate('2018-03-30');
	$event->setStart($start);

	$end = new Google_Service_Calendar_EventDateTime();
	$end->setDate('2018-04-01');
	$event->setEnd($end);*/

	/*//на целый день
	$date = new Google_Service_Calendar_EventDateTime();
	$date->setDate('2018-03-26');

	$event->setStart($date);
	$event->setEnd($date);*/

	$updatedEvent = $service->events->update($calendarId, $event->getId(), $event);

	echo 'дата обновления' . $updatedEvent->getUpdated(); 
} catch (Exception $e) {
    echo 'false';
}