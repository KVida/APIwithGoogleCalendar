<?php 
require_once __DIR__ . '/function_getClient.php';

try { 

    if (isset($_POST['calendar_from']) && isset($_POST['calendar_before'])) {
        $calendar_from = $_POST['calendar_from'];
        $calendar_before = $_POST['calendar_before'];
    }

    $client = getClient();
    $service = new Google_Service_Calendar($client);
    
    $calendarId = 'primary';
    $optParams = array(
        'maxResults' => 100,
        'orderBy' => 'startTime', 
        'singleEvents' => TRUE, 
        'timeMin' => $calendar_from . 'T00:00:00+02:00',
        'timeMax' => $calendar_before . 'T00:00:00+02:00',
    );
    $results = $service->events->listEvents($calendarId, $optParams);

    if (count($results->getItems()) == 0) {
        print "No upcoming events found.\n";
    } else {
        foreach ($results->getItems() as $event) {
            echo $event->getSummary() . '<br>';

            $start = $event->start->dateTime;
            
            if (empty($start)) {
                $start = $event->start->date;
                echo '-- Начало события: ' . $start . '<br>';
            } else {
                $dateTime_explode = explode('+',$start);
                $time_explode = explode('T',$dateTime_explode[0]);
                $dateEventStart = $time_explode[0];
                $timeEventStart = $time_explode[1];
                echo '-- Начало события: ' . $dateEventStart . ' -> ';
                echo 'время: ' . $timeEventStart . '<br>';
            }

            $end = $event->end->dateTime;
            if (empty($end)) {
                $end = $event->end->date;
                echo '-- Конец события: ' . $end . '<br>';
            } else {
                $dateTime_explode = explode('+',$end);
                $time_explode = explode('T',$dateTime_explode[0]);
                $dateEventStart = $time_explode[0];
                $timeEventStart = $time_explode[1];
                echo '-- Конец события: ' . $dateEventStart . ' -> ';
                echo 'время: ' . $timeEventStart . '<br>';
            }
            $descriptionEvent = $event->description;
            if (!empty($descriptionEvent)) {
                echo '-- Описание: ' . $descriptionEvent . '<br>';
            }
            echo "<hr>";
            echo "<br>";
        }
    }
} catch (Exception $e) {
    /*$eError = explode('/var/', strip_tags($e->xdebug_message));
    var_dump($eError);

    exit;
    $error = $eError[0];
    $error = trim(str_replace('(','',$error));
    $error = trim(str_replace('!','',$error));
    $error = trim(str_replace(')','',$error));*/
   
    
    //header('Location: http://localhost/calendar/app.php');
}
    
?>
<!DOCTYPE html>
<html>
<head>
    <title>lll</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="lib/jquery-3.3.1.js">
</head>
<body>
    <h1>выбраные записи</h1>
    <h2>с <?php echo  $calendar_from; ?> по <?php echo  $calendar_before; ?> </h2>

    <form>
        <input type="button" value="Выбрать другой диапазон времени" onClick='location.href="http://localhost/calendar/app.php"'>
    </form>
</body>
</html>