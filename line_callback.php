<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml' lang='ja' xml:lang='ja'>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
<title>LINE Login v2 Sample Callback</title>
</head>
<body>
<?php

require_once __DIR__ . '/vendor/autoload.php';

$unsafe = $_SERVER['REQUEST_METHOD'] == 'POST'
       || $_SERVER['REQUEST_METHOD'] == 'PUT'
       || $_SERVER['REQUEST_METHOD'] == 'DELETE';

$session_factory = new \Aura\Session\SessionFactory;
$session = $session_factory->newInstance($_COOKIE);
$csrf_value = $_GET['state'];
$csrf_token = $session->getCsrfToken();
if ($unsafe || !$csrf_token->isValid($csrf_value)) {
  return;
}

$callback = 'https://' . $_SERVER['HTTP_HOST']  . '/line_callback.php';
if (isset($_GET['code'])) {
  $url = 'https://api.line.me/v2/oauth/accessToken';
  $data = array(
    'grant_type' => 'authorization_code',
    'client_id' => getenv('1539757035'),
    'client_secret' => getenv('45d7f699c88dcb8e01fca97fd09a22f1'),
    'code' => $_GET['code'],
    'redirect_uri' => $callback
  );
  $data = http_build_query($data, '', '&');
  $header = array(
    'Content-Type: application/x-www-form-urlencoded'
  );
  $context = array(
    'http' => array(
      'method'  => 'POST',
      'header'  => implode('\r\n', $header),
      'content' => $data
    )
  );
  $resultString = file_get_contents($url, false, stream_context_create($context));
  $result = json_decode($resultString, true);

  if(isset($result['access_token'])) {
    $url = 'https://api.line.me/v2/profile';
    $context = array(
      'http' => array(
      'method'  => 'GET',
      'header'  => 'Authorization: Bearer '. $result['access_token']
      )
    );
    $profileString = file_get_contents($url, false, stream_context_create($context));
    $profile = json_decode($profileString, true);
　　　　　　　　echo '<img src="' . htmlspecialchars($profile["pictureUrl"], ENT_QUOTES) . '" />';
    echo '<p>displayName : ' . htmlspecialchars($profile["displayName"], ENT_QUOTES) . '</p>';
    echo '<p>userId : ' . htmlspecialchars($profile["userId"], ENT_QUOTES) . '</p>';

    $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient(getenv('xRqejpxMVQK8pUA17z8jMKKDaEKmis3XoYArpP+EkrUrhwO7RSb10BCo3IpfcAJoAAxqcvcwrHH0INAXfrMee0+OePxm2umiq+k4SdS05O3OcLW/FN4RLqhdrTQ6DC5XZvgn3UaUmMYqLUouPfvpUQdB04t89/1O/w1cDnyilFU='));
    $bot = new \LINE\LINEBot($httpClient, ['channelSecret' => getenv('329695d93f519ef5bdc856f2276c7b4d')]);
    $bot->pushMessage($profile["userId"], new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('Logged in via LINE Login v2.'));
  }
}
else {
  echo '<p>Login Failed.</p>';
}
?>
</body>
</html>
