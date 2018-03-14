<?php
require_once('./LINEBotTiny.php');
require_once __DIR__ . '/../src/LINEBot.php';
require_once __DIR__ . '/../src/LINEBot/Response.php';
require_once __DIR__ . '/../src/LINEBot/MessageBuilder.php';
require_once __DIR__ . '/../src/LINEBot/Constant/MessageType.php';
require_once __DIR__ . '/../src/LINEBot/Constant/Meta.php';
require_once __DIR__ . '/../src/LINEBot/HTTPClient.php';
require_once __DIR__ . '/../src/LINEBot/HTTPClient/Curl.php';
require_once __DIR__ . '/../src/LINEBot/HTTPClient/CurlHTTPClient.php';
require_once __DIR__ . '/../src/LINEBot/MessageBuilder/TextMessageBuilder.php';
$channelAccessToken = getenv('LINE_CHANNEL_ACCESSTOKEN');
$channelSecret = getenv('LINE_CHANNEL_SECRET');
$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($channelAccessToken);
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $channelSecret]);
$m_massage=$message['text'];
if($m_massage=="安安"){
$msg = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("文字訊係");
$bot->replyMessage($replyToken,$msg);
};
/*foreach ($client->parseEvents() as $event) {
    switch ($event['type']) {
        case 'message':
            $message = $event['message'];
            switch ($message['type']) {
                case 'text':
                $replyToken=$
                	$m_message = $message['text'];$source=$event['source'];$id=$source['userId'];
                    if($m_massage!=""){
                      $msg = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("安安");
                      $bot->replyMessage($replyToken,$msg);
                    }
                    break;
            }
            break;
        default:
            error_log("Unsupporeted event type: " . $event['type']);
            break;
    }
};*/
