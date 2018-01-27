<?php

/****************************************
 * LINE 機器人範例
 * 作者:林壽山
 * 聯絡資訊: superlevin@gmail.com
 ***************************************/

require_once('./LINEBotTiny.php');

// 重要資訊1
$channelSecret = "a7e8c58d4744adbc363c42bc558db89e";
// 重要資訊2
$channelAccessToken = "WI8f+ot/+7IJffBJATgfi1+rnNYCW+RGm1u2SRg2sdOLw2Y0+4gbdJsmh0zmUdtZNvx595o+hvI3XYeFQk66EVpl1mWwDDJOlKRecD6mc8gES9hnbAH+SOcrxw3QWmrmvQPI0WxrXMwB8EVOXPx4FwdB04t89/1O/w1cDnyilFU=";
// Google表單資料
$googledataspi = "https://spreadsheets.google.com/feeds/list/1uDfSyQ0tRn8b2idrg-S0_zRMzsyOVmBvYP2qTJDKD3w/od6/public/values?alt=json";

// 建立Client from LINEBotTiny
$client = new LINEBotTiny($channelAccessToken, $channelSecret);

// 取得事件(只接受文字訊息)
foreach ($client->parseEvents() as $event) {
switch ($event['type']) {       
    case 'message':
        // 讀入訊息
        $message = $event['message'];

        // 將Google表單轉成JSON資料
        $json = file_get_contents($googledataspi);
        $data = json_decode($json, true);           
        $store_text=''; 
        // 資料起始從feed.entry          
        foreach ($data['feed']['entry'] as $item) {
            // 將keywords欄位依,切成陣列
            $keywords = explode(',', $item['gsx$keywords']['$t']);

            // 以關鍵字比對文字內容，符合的話將店名/地址寫入
            foreach ($keywords as $keyword) {
                if (mb_strpos($message['text'], $keyword) !== false) {                      
                    $store_text = $item['gsx$storename']['$t']." 地址是:".$item['gsx$storeaddress']['$t'];                 
              }
            }
        }       



        switch ($message['type']) {
            case 'text':
                // 回覆訊息
                // 第一段 你要想找_(原字串)_ 讓我想想喔…
                // 第二段 介紹你_______不錯喔
                $client->replyMessage(array(
                    'replyToken' => $event['replyToken'],
                    'messages' => array(
                        array(
                            'type' => 'text',
                            'text' => '你想要找'.$message['text'].' 讓我想想喔…',
                        ),
                        array(
                            'type' => 'text',
                            'text' => '介紹你 '.$store_text.' 不錯喔',
                        )

                    ),
                ));               
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
