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
                    $idtype = $source['type']; 
                    $id=$source['userId'];
                    $roomid=$source['roomId'];
                    $groupid=$source['groupId'];
                    date_default_timezone_set('Asia/Taipei');
                    if($idtype=="room"){
                        $client->replyMessage(array(
                        'replyToken' => $event['replyToken'],
                        'messages' => array(
                            array(
                                'type' => 'text',
                                'text' => "message: ".$m_message."\n"."roomid:".$roomid."\n"."time: ".date('Y-m-d h:i:sa')
                            ))));
                    }
                	else if($idtype=="group")
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
                    case 'location':
                    $address=$message['address'];
                    $title=$message['title'];
                    if($address!=""){
                        $client->replyMessage(array(
                        'replyToken' => $event['replyToken'],
                        'messages' => array(
                            array(
                                'type' => 'text',
                                'text' => $title."\n".$address
                            ))));
                    }
                    break;
                    case 'confirm':
                    $template=$event['type'];
                    $confirmtype=$template['type'];
                    $confirm=$confirmtype['confirm'];
                    $altText=$event['altText'];
                    $confirmtext=$template['text'];
                    $confirmtext="身高156cm?";
                    $confirmactions=$template['actions'];
                    if($m_message=="156"){
                        $client->replyMessage(array(
                        'replyToken' => $event['replyToken'],
                        'messages' => array(
                            array(
                                'type' => 'text',
                                'text' => $altText
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
