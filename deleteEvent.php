<?php
require_once __DIR__ . '/function_getClient.php';

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