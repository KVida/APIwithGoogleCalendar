<?php 
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config.php';
ini_set('session.gc_maxlifetime', 72000);
session_start();

if (isset($_POST['calendar_from']) || isset($_POST['calendar_before'])) {
    $calendar_from = $_POST['calendar_from'];
    $calendar_before = $_POST['calendar_before'];
}

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

    <br>
<?php
try { 

    $client = getClient();
    $service = new Google_Service_Calendar($client);
    
    // Print the next 10 events on the user's calendar.
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
    header('Location: http://localhost/calendar/app.php');
}
?>
</body>
</html>