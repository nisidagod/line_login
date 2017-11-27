<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml' lang='ja' xml:lang='ja'>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
<title>LINE Login v2 Sample</title>
</head>
<body>
<?php

require_once __DIR__ . '/vendor/autoload.php';

$session_factory = new \Aura\Session\SessionFactory;
$session = $session_factory->newInstance($_COOKIE);
$segment = $session->getSegment('Vendor\Package\ClassName');

$csrf_value = $session->getCsrfToken()->getValue();

$callback = urlencode('https://' . $_SERVER['HTTP_HOST']  . '/line_callback.php');
$url = 'https://access.line.me/dialog/oauth/weblogin?response_type=code&client_id=' . getenv('1539757035') . '&redirect_uri=' . $callback . '&state=' . $csrf_value;
echo '<a href=' . $url . '><button class="contact">LINE Login v2 Sample</button></a>';

?>
</body>
</html>
