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
                /*case 'text':
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
                    break;*/
                    case 'text':
                    $m_message = $message['text'];
                    if($m_message=="156"){
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
                                     'type' => 'postback',
                                     'label' => 'Postback example',
                                     'data' => 'action=buy&itemid=123'
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
                                'type' => 'template', // 訊息類型 (模板)
                'altText' => 'Example buttons template', // 替代文字
                'template' => array(
                    'type' => 'carousel', // 類型 (旋轉木馬)
                    'columns' => array(
                        array(
                            'thumbnailImageUrl' => 'https://api.reh.tw/line/bot/example/assets/images/example.jpg', // 圖片網址 <不一定需要>
                            'title' => 'Example Menu 1', // 標題 1 <不一定需要>
                            'text' => 'Description 1', // 文字 1
                            'actions' => array(
                                array(
                                    'type' => 'postback', // 類型 (回傳)
                                    'label' => 'postback 1', // 標籤 1
                                    'data' => 'action=buy&itemid=123' // 資料
                                ),
                                array(
                                    'type' => 'message', // 類型 (訊息)
                                    'label' => 'Message example 1', // 標籤 2
                                    'text' => 'Message example 1' // 用戶發送文字
                                ),
                                array(
                                    'type' => 'uri', // 類型 (連結)
                                    'label' => 'Uri example 1', // 標籤 3
                                    'uri' => 'https://github.com/GoneTone/line-example-bot-php' // 連結網址
                                )
                            )
                        ),
                        array(
                            'thumbnailImageUrl' => 'https://api.reh.tw/line/bot/example/assets/images/example.jpg', // 圖片網址 <不一定需要>
                            'title' => 'Example Menu 2', // 標題 2 <不一定需要>
                            'text' => 'Description 2', // 文字 2
                            'actions' => array(
                                array(
                                    'type' => 'postback', // 類型 (回傳)
                                    'label' => 'postback 2', // 標籤 1
                                    'data' => 'action=buy&itemid=123' // 資料
                                ),
                                array(
                                    'type' => 'message', // 類型 (訊息)
                                    'label' => 'Message example 2', // 標籤 2
                                    'text' => 'Message example 2' // 用戶發送文字
                                ),
                                array(
                                    'type' => 'uri', // 類型 (連結)
                                    'label' => 'Uri example 2', // 標籤 3
                                    'uri' => 'https://github.com/GoneTone/line-example-bot-php' // 連結網址
                                )
                            ))))))));
                    }
                    break;     
            }
            break;
        default:
            error_log("Unsupporeted event type: " . $event['type']);
            break;
    }
};
