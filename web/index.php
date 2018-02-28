<?php
use LINE\LINEBot;
require_once('./LINEBotTiny.php');
$channelAccessToken = getenv('LINE_CHANNEL_ACCESSTOKEN');
$channelSecret = getenv('LINE_CHANNEL_SECRET');
$client = new LINEBotTiny($channelAccessToken, $channelSecret);

$json_content = file_get_contents('php://input');
$json = json_decode($json_content, true);

// 可以一次送來多筆資料，所以是陣列
foreach ($json['result'] as $result) {
    $content = $result['content'];
    if ($result['eventType'] == '138311609100106403') {
        // 加入好友或封鎖
        $mid = $content['params'][0];
        if ($content['opType'] == 4) {
            echo '加入好友 ' . $mid;
        }
        if ($content['opType'] == 8) {
            echo '封鎖 ' . $mid;
        }
        // 利用 curl 另外取得 user 資料
        $profile = curlUserProfileFromLine($mid);
        echo 'name = ' . $profile['displayName'];
        echo '<img src="' . $profile['pictureUrl'] . '" />';
    }
}


foreach ($client->parseEvents() as $event) {
    switch ($event['type']) {
        case 'message':
            $message = $event['message'];
            switch ($message['type']) {
                case 'text':
                	$m_message = $message['text']; $source=$event['source']; $idtype = $source['type'];  $id=$source['userId'];
                    $roomid=$source['roomId']; $groupid=$source['groupId']; date_default_timezone_set('Asia/Taipei');
                    if($m_message=="安安" && $idtype=="room"){
                        $client->replyMessage(array(
                        'replyToken' => $event['replyToken'],
                        'messages' => array(
                            array(
                                'type' => 'text',
                                'text' => "message: ".$m_message."\n"."userid: ".$id."\n"."roomid:".$roomid."\n"."time: ".date('Y-m-d h:i:sa')
                            ))));
                    }
                	else if($m_message=="安安" && $idtype=="group")
                	{
                		$client->replyMessage(array(
                        'replyToken' => $event['replyToken'],
                        'messages' => array(
                            array(
                                'type' => 'text',
                                'text' => "message: ".$m_message."\n"."userid: ".$id."\n"."groupid: ".$groupid."\n"."time: ".date('Y-m-d h:i:sa')
                            ))));
                	}
                    else if($m_message=="安安" && $idtype=="user"){
                        $client->replyMessage(array(
                        'replyToken' => $event['replyToken'],
                        'messages' => array(
                            array(
                                'type' => 'text',
                                'text' => "message: ".$m_message."\n"."userid: ".$id."\n"."time: ".date('Y-m-d h:i:sa')
                            ))));
                    }
                    else if($m_message=="156"){
                        $client->replyMessage(array(
                        'replyToken' => $event['replyToken'],
                        'messages' => array(
                            array(
                                'type' => 'template',
                                'altText' => 'Example confirm template',
                                'template' => array(
                                    'type' => 'confirm',
                                    'text' => '你156cm嗎?',
                                    'actions' => array(
                                        array(
                                        'type' => 'message',
                                        'label' => '是',
                                        'text' => 'QQ'
                                         ),
                                        array(
                                        'type' => 'message',
                                        'label' => '否',
                                        'text' => 'NICE'
                                        )
                            ))))));
                    }
                        else if($m_message=="1"){
                        $client->replyMessage(array(
                        'replyToken' => $event['replyToken'],
                        'messages' => array(
                            array(
                                'type' => 'template', 
                                'altText' => 'Example buttons template',
                                'template' => array(
                                'type' => 'buttons',	
                                'title' => '選單',
                                'text' => '請選擇',
                                'actions' => array(
                                     array(
                                    'type' => 'message',
                                    'label' => '問候語',
                                    'text' => 'Hello world!'
                                ),
                                    array(
                                    'type' => 'message',
                                    'label' => '問候語',
                                    'text' => 'Hello world!'
                                 ),
                                    array(
                                    'type' => 'uri', 
                                    'label' => '德明財經科技大學首頁',
                                    'uri' => 'http://www.takming.edu.tw'
                             )
                            ))))));
                    }
                    else if($m_message=="2"){
                        $client->replyMessage(array(
                        'replyToken' => $event['replyToken'],
                        'messages' => array(
                            array(
                                'type' => 'template', 
                'altText' => 'Example buttons template', 
                'template' => array(
                    'type' => 'carousel', // 類型 (旋轉木馬)
                    'columns' => array(
                        array(
                            'thumbnailImageUrl' => 'https://api.reh.tw/line/bot/example/assets/images/example.jpg',
                            'title' => 'Example Menu 1',
                            'text' => 'Description 1',
                            'actions' => array(
                                array(
                                    'type' => 'message',
                                    'label' => '問候語',
                                    'text' => 'Hello world!'
                                ),
                                array(
                                    'type' => 'message',
                                    'label' => 'Message example 1', 
                                    'text' => 'Message example 1'
                                ),
                                array(
                                    'type' => 'uri', 
                                    'label' => 'Uri example 1',
                                    'uri' => 'https://github.com/GoneTone/line-example-bot-php'
                                )
                            )
                        ),
                        array(
                            'thumbnailImageUrl' => 'https://api.reh.tw/line/bot/example/assets/images/example.jpg',
                            'title' => 'Example Menu 2',
                            'text' => 'Description 2',
                            'actions' => array(
                                array(
                                    'type' => 'message',
                                    'label' => '問候語',
                                    'text' => 'Hello world!'
                                ),
                                array(
                                    'type' => 'message',
                                    'label' => 'Message example 2', 
                                    'text' => 'Message example 2'
                                ),
                                array(
                                    'type' => 'uri',
                                    'label' => 'Uri example 2',
                                    'uri' => 'https://github.com/GoneTone/line-example-bot-php'
                                )
                            ))))))));                        
                    }
                    break;
                    case 'location':
                    $source=$event['source'];
                    $idtype = $source['type']; 
                    $id=$source['userId'];
                    $address=$message['address'];
                    $title=$message['title'];
                    $latitude=$message['latitude'];
                    $longitude=$message['longitude'];
                    if($address!=""){
                        $client->replyMessage(array(
                        'replyToken' => $event['replyToken'],
                        'messages' => array(
                            array(
                                'type' => 'text',
                                'text' => $title."\n".$address."\n"."經度:".$longitude."\n"."緯度:".$latitude."\n"."userid: ".$id
                            ))));
                    }
                    break;  
                    case 'sticker':
                    $packageId=$message['packageId'];
                    $stickerId=$message['stickerId'];
                    if($stickerId!=""){
                        $client->replyMessage(array(
                        'replyToken' => $event['replyToken'],
                        'messages' => array(
                            array(
                                'type' => 'sticker',
                                'packageId' => $packageId,
                                'stickerId' => $stickerId
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
