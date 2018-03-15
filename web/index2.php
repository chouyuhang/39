<?php
require_once __DIR__ . '/../web/abc.txt';
require_once('./LINEBotTiny.php');
require_once __DIR__ . '/../src/LINEBot.php';
require_once __DIR__ . '/../src/LINEBot/Response.php';
require_once __DIR__ . '/../src/LINEBot/Constant/Meta.php';
require_once __DIR__ . '/../src/LINEBot/HTTPClient.php';
require_once __DIR__ . '/../src/LINEBot/HTTPClient/Curl.php';
require_once __DIR__ . '/../src/LINEBot/Constant/MessageType.php';
require_once __DIR__ . '/../src/LINEBot/MessageBuilder.php';
require_once __DIR__ . '/../src/LINEBot/HTTPClient/CurlHTTPClient.php';
require_once __DIR__ . '/../src/LINEBot/MessageBuilder/TextMessageBuilder.php';
$channelAccessToken = getenv('LINE_CHANNEL_ACCESSTOKEN');
$channelSecret = getenv('LINE_CHANNEL_SECRET');
$client = new LINEBotTiny($channelAccessToken, $channelSecret);
$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($channelAccessToken);
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $channelSecret]);
foreach ($client->parseEvents() as $event) {
    switch ($event['type']) {
        case 'message':
            $message = $event['message'];
            switch ($message['type']) {
                case 'text':
                    $replyToken=$event['replyToken'];
                	$m_message = $message['text']; $source=$event['source']; $idtype = $source['type'];  $id=$source['userId'];
                    $roomid=$source['roomId']; $groupid=$source['groupId'];
                    $pictureUrl=$message['pictureUrl'];$res = $bot->getProfile($id);$profile = $res->getJSONDecodedBody();
                    $displayName = $profile['displayName'];
                    date_default_timezone_set('Asia/Taipei');
                    /*if($m_message=="安安"){
                        $msg = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("安安");
                        $bot->replyMessage($replyToken,$msg);
                    }*/
                    $str = "Hello World";
                    $fp = fopen("abc.txt","a+"); //開啟檔案
                    if($fp || $m_message!=""){
                       fwrite($fp,$str);
                       fclose($fp);
                    }
                    break;
            }
            break;
        default:
            error_log("Unsupporeted event type: " . $event['type']);
            break;
    }
};
$str = "Hello World";
$file = fopen("abc.txt","a+"); //開啟檔案
 if($fp){
fwrite($file,$str);
fclose($file);
}

