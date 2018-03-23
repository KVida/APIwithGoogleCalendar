<?php 
require_once __DIR__ . '/function_getClient.php';

try {    
    $client = getClient();
    $service = new Google_Service_Calendar($client);

    $calendarList  = $service->calendarList->listCalendarList();

} catch (Exception $e) { 
    $eError = explode('/var/', strip_tags($e->xdebug_message));
    $error = $eError[0];
    $error = trim(str_replace('(','',$error));
    $error = trim(str_replace('!','',$error));
    $error = trim(str_replace(')','',$error));
    if ($error == "InvalidArgumentException: invalid json token in") {
        echo "InvalidArgumentException: invalid json token in -> Нет токена доступа";
    } else {
        echo 'еще ошибки';
    }
    exit;

    /*unset($_SESSION['accessToken']);
    header('Location: http://localhost/calendar/');*/
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
    <h3>Выберете период</h3>
    <form method="post" action="select_records.php" id="dateForCalendar" name="dateForCalendar">
        <label>От</label>
        <input type="date" name="calendar_from">

        <label>До</label>
        <input type="date" name="calendar_before">

        <input type="submit" value="Отправить">
    </form>  
</body>
</html>