<?php
require_once('./LINEBotTiny.php');
$channelAccessToken = getenv('LINE_CHANNEL_ACCESSTOKEN');
$channelSecret = getenv('LINE_CHANNEL_SECRET');
$client = new LINEBotTiny($channelAccessToken, $channelSecret);
foreach ($client->parseEvents() as $event) {
switch ($event['type']) {
        case 'message':
            $message = $event['message'];
            switch ($message['type']) {
                case 'text':
                    $client->replyMessage(array(
                        'replyToken' => $event['replyToken'],
                        'messages' => array(
                            array( 'type' => 'text',
                                  'text' => $message['text']
                            ))));
                            
                    break;
                            case "image" :
                             $client->replyMessage(array(
                        'replyToken' => $event['replyToken'],
                        'messages' => array(
                            array(
                               "type" => "image",
                               "originalContentUrl" => $message,
                               "previewImageUrl" => $message . "https://www.penghu-nsa.gov.tw/FileDownload/Album/Big/20161012162551758864338.jpg"
                                    $
                            ))))message = getObjContent("jpeg"); );
				break;
                default:
                    error_log("Unsupporeted message type: " . $message['type']);
                    break;
            }
            break;
        default:
            error_log("Unsupporeted event type: " . $event['type']);
            break;
    }
};
