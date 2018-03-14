<?php
require_once __DIR__ . '/../src/LINEBot.php';
require_once __DIR__ . '/../src/LINEBot/Constant/Meta.php';
require_once __DIR__ . '/../src/LINEBot/HTTPClient.php';
require_once __DIR__ . '/../src/LINEBot/MessageBuilder/TextMessageBuilder.php';
require_once __DIR__ . '/../src/LINEBot/HTTPClient/CurlHTTPClient.php';
$channelAccessToken = getenv('LINE_CHANNEL_ACCESSTOKEN');
$channelSecret = getenv('LINE_CHANNEL_SECRET');
$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($channelAccessToken);
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $channelSecret]);
//$res = $bot->getProfile('user-id');
//if ($res->isSucceeded()) {
 //   $profile = $res->getJSONDecodedBody();
 //   $displayName = $profile['displayName'];
 //   $statusMessage = $profile['statusMessage'];
 //   $pictureUrl = $profile['pictureUrl'];
//}
$msg = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("文字訊係");
$bot->replyMessage($replyToken,$msg);
