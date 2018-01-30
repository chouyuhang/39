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
                	$m_message = $message['text'];
                    if($m_message == "A"){
                         $client->replyMessage(array(
                             'replyToken' => $event['replyToken'],
                             'messages' => array(
                             array(
                                   'type' => 'text',
                                   'text' => $Q
                               )
                            )
                        	));
                    }
                     else {
                            $client->replyMessage(array(
                            'replyToken' => $event['replyToken'],
                            'messages' => array(
                                array(
                                    'type' => 'text',
                                    'text' => $a
                                    )
                            )
                    	    ));
                    }
                    break;
                
            }
            break;
        default:
            error_log("Unsupporeted event type: " . $event['type']);
            break;
    }
};
