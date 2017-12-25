<?php

/**
 * Copyright 2016 LINE Corporation
 *
 * LINE Corporation licenses this file to you under the Apache License,
 * version 2.0 (the "License"); you may not use this file except in compliance
 * with the License. You may obtain a copy of the License at:
 *
 *   https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 */

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
                    $a="歡迎來到我們的專題!\n請輸入以下的代號來查詢相關訊息!!\nA:客服\nB:介紹";
                    $Q="請問你要查詢?\na:常見問題\nb:儲值問題";
                    $Q1="A1:「魔法石」的用途？\nA2:如何購買「魔法石」？\nA3:「魔法石」可轉移至其他帳戶嗎？\n
                    A4:如何進行綁定？\nA5:可否更換用作綁定的社交平台帳戶？";
                    $A1="ans:魔法石可用作回復體力、回復戰靈、抽取魔法石封印卡、擴充背包空間與好友上限，以及在戰鬥死亡時進行復活。";
                    $A2="ans:玩家可在遊戲內選擇「商店」，然後選擇「魔法石商店」，使用 App Store 或 Google Play 帳戶登入後選購魔法石。";
                    $A3="ans:魔法石是不可以轉移的。";
                    $A4="ans:在遊戲主界面右上角的「設定」(齒輪)點選「綁定帳戶」，將現有的帳戶與社交平台帳戶綁定，保存遊戲進度。";
                    $A5="ans:社交平台帳戶的綁定及遊戲進度是不能被取消的。如希望重新開始遊戲，可選擇重新安裝，選擇「直接開始」遊戲，或以其他未曾用作綁定的社交帳戶登入遊戲。";
                	$m_message = $message['text'];
                	if($m_message == "A")
                	{
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
                        if($m_message == "a")
                	    {
                		    $client->replyMessage(array(
                            'replyToken' => $event['replyToken'],
                            'messages' => array(
                                array(
                                    'type' => 'text',
                                    'text' => $Q1
                                )
                            )
                    	    ));
                	    }
                            if($m_message == "A1"||$m_message == "a1"||)
                	        {
                		        $client->replyMessage(array(
                                'replyToken' => $event['replyToken'],
                                'messages' => array(
                                    array(
                                        'type' => 'text',
                                        'text' => $A1
                                    )
                                )
                    	        ));
                	        }
                            if($m_message == "A2"||$m_message == "a2"||)
                	        {
                		        $client->replyMessage(array(
                                'replyToken' => $event['replyToken'],
                                'messages' => array(
                                    array(
                                        'type' => 'text',
                                        'text' => $A2
                                    )
                                )
                    	        ));
                	        }if($m_message == "A3"||$m_message == "a3"||)
                	        {
                		        $client->replyMessage(array(
                                'replyToken' => $event['replyToken'],
                                'messages' => array(
                                    array(
                                        'type' => 'text',
                                        'text' => $A3
                                    )
                                )
                    	        ));
                	        }if($m_message == "A4"||$m_message == "a4"||)
                	        {
                		        $client->replyMessage(array(
                                'replyToken' => $event['replyToken'],
                                'messages' => array(
                                    array(
                                        'type' => 'text',
                                        'text' => $A4
                                    )
                                )
                    	        ));
                	        }if($m_message == "A5"||$m_message == "a5"||)
                	        {
                		        $client->replyMessage(array(
                                'replyToken' => $event['replyToken'],
                                'messages' => array(
                                    array(
                                        'type' => 'text',
                                        'text' => $A5
                                    )
                                )
                    	        ));
                	        }
                    else{
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
