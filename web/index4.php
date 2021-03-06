<?php
require_once('./LINEBotTiny.php');
require_once __DIR__ . '/../src/LINEBot.php';
require_once __DIR__ . '/../src/LINEBot/Response.php';
require_once __DIR__ . '/../src/LINEBot/HTTPClient.php';
require_once __DIR__ . '/../src/LINEBot/MessageBuilder.php';
require_once __DIR__ . '/../src/LINEBot/TemplateActionBuilder.php';
require_once __DIR__ . '/../src/LINEBot/Constant/Meta.php';
require_once __DIR__ . '/../src/LINEBot/Constant/MessageType.php';
require_once __DIR__ . '/../src/LINEBot/Constant/ActionType.php';
require_once __DIR__ . '/../src/LINEBot/Constant/TemplateType.php';
require_once __DIR__ . '/../src/LINEBot/HTTPClient/Curl.php';
require_once __DIR__ . '/../src/LINEBot/HTTPClient/CurlHTTPClient.php';
require_once __DIR__ . '/../src/LINEBot/TemplateActionBuilder.php';
require_once __DIR__ . '/../src/LINEBot/TemplateActionBuilder/PostbackTemplateActionBuilder.php';
require_once __DIR__ . '/../src/LINEBot/MessageBuilder/TemplateBuilder.php';
require_once __DIR__ . '/../src/LINEBot/MessageBuilder/LocationMessageBuilder.php';
require_once __DIR__ . '/../src/LINEBot/MessageBuilder/TemplateBuilder/ConfirmTemplateBuilder.php';
require_once __DIR__ . '/../src/LINEBot/MessageBuilder/TextMessageBuilder.php';
require_once __DIR__ . '/../src/LINEBot/MessageBuilder/TemplateMessageBuilder.php';
//USE oqz0qx1hdl6jbtca;
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
                    $m_message = $message['text']; $source=$event['source']; $idtype = $source['type'];  $userid=$source['userId'];
                    $roomid=$source['roomId']; $groupid=$source['groupId'];
                    $res = $bot->getProfile($userid); $profile = $res->getJSONDecodedBody();$displayName = $profile['displayName'];
		    $address=$message['address']; $title=$message['title'];
                    $longitude=$message['longitude']; $latitude=$message['latitude'];
                    date_default_timezone_set('Asia/Taipei');$time=date("Y-m-d H:i:s");$date=date("Y-m-d");
		    $key=rand(1000,9999);
                    if($m_message=="進"){
                        $mysqli = new mysqli('gzp0u91edhmxszwf.cbetxkdyhwsb.us-east-1.rds.amazonaws.com', "vu5qzklum1466fvr", "ieewar6pa07471zn", "oqz0qx1hdl6jbtca","3306");
			$sql="INSERT INTO mysql (name,msg,vcode,userid,groupid,worktime) VALUES ('$displayName','$m_message','$key','$userid','$groupid','$time')";
			$result = $mysqli->query($sql);	
                        $msg = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($key);
                        $bot->replyMessage($replyToken,$msg);
			$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("請輸入驗證碼");
			$response = $bot->pushMessage($userid, $textMessageBuilder);
                    }
		    $mysqli = new mysqli('gzp0u91edhmxszwf.cbetxkdyhwsb.us-east-1.rds.amazonaws.com', "vu5qzklum1466fvr", "ieewar6pa07471zn", "oqz0qx1hdl6jbtca","3306");
		    $sql = "select vcode from mysql where worktype='' and userid='$userid'";
			$result = $mysqli->query($sql);
			while($row = $result->fetch_array(MYSQLI_BOTH)) {
  				$vcode = $row['vcode'] ;
			}
		    if($m_message==$vcode){
		    	$mysqli = new mysqli('gzp0u91edhmxszwf.cbetxkdyhwsb.us-east-1.rds.amazonaws.com', "vu5qzklum1466fvr", "ieewar6pa07471zn", "oqz0qx1hdl6jbtca","3306");	
			$sql = "UPDATE mysql SET worktype='進' where userid='$userid' and worktype='';";
			$client->replyMessage(array(
        				'replyToken' => $event['replyToken'],
     			   		'messages' => array(
				   	array(
                                          'type' => 'text',
                                          'text' => "驗證成功!!"
                                       	),
 				)));
		    }
		    if($m_message=="出"){
                        $mysqli = new mysqli('gzp0u91edhmxszwf.cbetxkdyhwsb.us-east-1.rds.amazonaws.com', "vu5qzklum1466fvr", "ieewar6pa07471zn", "oqz0qx1hdl6jbtca","3306");
			$sql="INSERT INTO mysql (name,msg,vcode,userid,groupid,worktime) VALUES ('$displayName','$m_message','$key','$userid','$groupid','$time')";
			$result = $mysqli->query($sql);	
                        $msg = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($key);
                        $bot->replyMessage($replyToken,$msg);
			$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("請輸入驗證碼");
			$response = $bot->pushMessage($userid, $textMessageBuilder);
                    }
		    $mysqli = new mysqli('gzp0u91edhmxszwf.cbetxkdyhwsb.us-east-1.rds.amazonaws.com', "vu5qzklum1466fvr", "ieewar6pa07471zn", "oqz0qx1hdl6jbtca","3306");
		    $sql = "select vcode from mysql where worktype='' and userid='$userid'";
			$result = $mysqli->query($sql);
			while($row = $result->fetch_array(MYSQLI_BOTH)) {
  				$vcode = $row['vcode'] ;
			}
		    if($m_message==$vcode){
		    	$mysqli = new mysqli('gzp0u91edhmxszwf.cbetxkdyhwsb.us-east-1.rds.amazonaws.com', "vu5qzklum1466fvr", "ieewar6pa07471zn", "oqz0qx1hdl6jbtca","3306");	
			$sql = "UPDATE mysql SET worktype='出' where userid='$userid' and worktype='';";
			$client->replyMessage(array(
        				'replyToken' => $event['replyToken'],
     			   		'messages' => array(
				   	array(
                                          'type' => 'text',
                                          'text' => "驗證成功!!"
                                       	),
 				)));
		    }
                 break;
            }
            break;
        default:
            error_log("Unsupporeted event type: " . $event['type']);
            break;
    }
};
