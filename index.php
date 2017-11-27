<?php

require_once __DIR__ . '/vendor/autoload.php';

$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient(getenv('xRqejpxMVQK8pUA17z8jMKKDaEKmis3XoYArpP+EkrUrhwO7RSb10BCo3IpfcAJoAAxqcvcwrHH0INAXfrMee0+OePxm2umiq+k4SdS05O3OcLW/FN4RLqhdrTQ6DC5XZvgn3UaUmMYqLUouPfvpUQdB04t89/1O/w1cDnyilFU='));
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => getenv('329695d93f519ef5bdc856f2276c7b4d')]);

$signature = $_SERVER['HTTP_' . \LINE\LINEBot\Constant\HTTPHeader::LINE_SIGNATURE];
try {
  $events = $bot->parseEventRequest(file_get_contents('php://input'), $signature);
} catch(\LINE\LINEBot\Exception\InvalidSignatureException $e) {
  error_log('parseEventRequest failed. InvalidSignatureException => '.var_export($e, true));
} catch(\LINE\LINEBot\Exception\UnknownEventTypeException $e) {
  error_log('parseEventRequest failed. UnknownEventTypeException => '.var_export($e, true));
} catch(\LINE\LINEBot\Exception\UnknownMessageTypeException $e) {
  error_log('parseEventRequest failed. UnknownMessageTypeException => '.var_export($e, true));
} catch(\LINE\LINEBot\Exception\InvalidEventRequestException $e) {
  error_log('parseEventRequest failed. InvalidEventRequestException => '.var_export($e, true));
}

foreach ($events as $event) {
  $bot->replyText($event->getReplyToken(), "https://" . $_SERVER["HTTP_HOST"] .  "/line_login.php");
}

?>
