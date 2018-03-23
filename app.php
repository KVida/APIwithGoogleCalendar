<?php 
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config.php';
ini_set('session.gc_maxlifetime', 72000);
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>lll</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="lib/jquery-3.3.1.js">
</head>
<body>
    <?php
    try { 
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
    
    $client = getClient();
    $service = new Google_Service_Calendar($client);

    $calendarList  = $service->calendarList->listCalendarList();
    ?>

        <h3>Выберете период</h3>
        <form method="post" action="select_records.php" id="dateForCalendar" name="dateForCalendar">
            <label>От</label>
            <input type="date" name="calendar_from">

            <label>До</label>
            <input type="date" name="calendar_before">

            <input type="submit" value="Отправить">
        </form>

    <?php
    } catch (Exception $e) {
        unset($_SESSION['accessToken']);
        header('Location: http://localhost/calendar/');
    }
    ?>
</body>
</html>