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
                    $source=$event['source'];
                    $type = $source['type']; 
                    $id=$source['userId'];
                    $roomid=$source['roomId'];
                    $groupid=$source['groupId'];
                    date_default_timezone_set('Asia/Taipei');
                    if($type=="room"){
                        $client->replyMessage(array(
                        'replyToken' => $event['replyToken'],
                        'messages' => array(
                            array(
                                'type' => 'text',
                                'text' => "message: ".$m_message."\n"."roomid:".$roomid."\n"."time: ".date('Y-m-d h:i:sa')
                            ))));
                    }
                	else if($type=="group")
                	{
                		$client->replyMessage(array(
                        'replyToken' => $event['replyToken'],
                        'messages' => array(
                            array(
                                'type' => 'text',
                                'text' => "message: ".$m_message."\n"."groupid: ".$groupid."\n"."time: ".date('Y-m-d h:i:sa')
                            ))));
                	}
                    else{
                        $client->replyMessage(array(
                        'replyToken' => $event['replyToken'],
                        'messages' => array(
                            array(
                                'type' => 'text',
                                'text' => "message: ".$m_message."\n"."userid: ".$id."\n"."time: ".date('Y-m-d h:i:sa')
                            ))));
                    }
                    break;
            }
            break;
            switch ($event['type']) {
            case 'location':
                    $type=$event['type'];
                    $title=$event['title'];
                    $address=$event['address'];
                    $latitude=$event['latitude'];
                    $longitude=$event['longitude'];
                    if($type=="location"){
                        $client->replyMessage(array(
                        'replyToken' => $event['replyToken'],
                        'messages' => array(
                            array(
                                'type' => 'location',
                                'location' => "title".$title."address".$address."latitude".$latitude."longitude".$longitude
                            ))));
                    }
                    break;
                    }
            break;
        default:
            error_log("Unsupporeted event type: " . $event['type']);
            break;
    }
};
