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
            $Q2="B1:如何購買「魔法石」？\nB2:「魔法石」可經由什麼付費平台購買呢？\nB3:如果沒有信用卡可怎麼購買「魔法石」？\nB4:為什麼已成功完成交易，但尚未收到「魔法石」？";
            
          case ($m_message=="魔法石" ): 
                            $client->replyMessage(array(
                           'replyToken' => $event['replyToken'],
                           'messages' => array(
                             array(
                                   'type' => 'text',
                                   'text' => $B1
                               )
                            )
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
