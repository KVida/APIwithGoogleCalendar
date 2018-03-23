<?php
	require_once __DIR__ . '/vendor/autoload.php';
	require_once __DIR__ . '/config.php';

    session_start();

	$client = new Google_Client();
    $client->setApplicationName(APPLICATION_NAME);
    $client->setScopes(SCOPES);
    $client->setAuthConfig(CLIENT_SECRET_PATH);
    $client->setAccessType('offline');
    
    $auth_url = $client->createAuthUrl();

    if (!empty($_SESSION['accessToken'])) {
        header('Location: http://localhost/calendar/app.php');
    }
?>
<!DOCTYPE html>
<html>
<head>
	<title>calendar</title>
	<meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="lib/jquery-3.3.1.js">
</head>
<body>
	<a href="<?php echo $auth_url; ?>" target="_blank">Зайти для доступа в календарь</a>
    <form method="post" action="getToken.php">
        <input type="text" name="authCode" placeholder="Скопируйте код, который появился в новом окне" required>
        <input type="submit" value="Отправить">    
    </form>
</body>
</html>
