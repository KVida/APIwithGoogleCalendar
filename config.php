<?php 
	define('APPLICATION_NAME', 'mcr');
	define('CLIENT_SECRET_PATH', __DIR__ . '/client_secret.json');
	define('SCOPES', implode(' ', array(
	  Google_Service_Calendar::CALENDAR)
	));
?>
