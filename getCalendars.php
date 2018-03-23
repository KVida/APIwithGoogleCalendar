<?php
require_once __DIR__ . '/function_getClient.php';

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