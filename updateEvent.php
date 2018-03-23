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

	$calendarId = 'primary';
	$eventId = '7jradfp2eiavi8i20qpo3sfo5g_20180328T070000Z';

	$event = $service->events->get($calendarId, $eventId);
	$event->setSummary('2018 new KVIDA');
	$event->setLocation('Харьков ул.Криворожская.16');


	$start = new Google_Service_Calendar_EventDateTime();
	$start->setDateTime('2018-03-31T05:00:00+03:00');
	$event->setStart($start);

	$end = new Google_Service_Calendar_EventDateTime();
	$end->setDateTime('2018-03-31T15:00:00+03:00');
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

	print_r($event);

	echo 'дата обновления' . $updatedEvent->getUpdated(); 
} catch (Exception $e) {
    echo 'false';
}