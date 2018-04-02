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
		  case 'location':
		    $replyToken=$event['replyToken'];
                    $m_message = $message['text']; $source=$event['source']; $idtype = $source['type'];  $userid=$source['userId'];
                    $roomid=$source['roomId']; $groupid=$source['groupId'];
                    $res = $bot->getProfile($userid); $profile = $res->getJSONDecodedBody();$displayName = $profile['displayName'];
		    $address=$message['address']; $title=$message['title'];
                    $longitude=$message['longitude']; $latitude=$message['latitude']; 
                    date_default_timezone_set('Asia/Taipei');$time=date("Y-m-d H:i:s");
		if($address!=""){
		    //if($m_message!="" && $userid!='Ud9a4e29db28b8b07a78cecf6d8ec3bdb' && $roomid!='R8466f385da9bd8eac6fb509622c0a892'){
			sleep(5);
	            if($m_message=="安安"){
		    	$mysqli = new mysqli('gzp0u91edhmxszwf.cbetxkdyhwsb.us-east-1.rds.amazonaws.com', "vu5qzklum1466fvr", "ieewar6pa07471zn", "oqz0qx1hdl6jbtca","3306");
		    	$sql = "SELECT userid from mysql";
		    	$result = $mysqli->query($sql);
			$row = $result->fetch_array(MYSQLI_BOTH);
		    	$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($m_message);
		    	//$response = $bot->pushMessage('R8466f385da9bd8eac6fb509622c0a892', $textMessageBuilder);
			$response = $bot->pushMessage('Ud9a4e29db28b8b07a78cecf6d8ec3bdb', $textMessageBuilder);
			$response = $bot->pushMessage('Ub28a7054f2aa2bfeeb103fb53ca35f32', $textMessageBuilder);
		    }
		}
		break;
            }
            break;
        default:
            error_log("Unsupporeted event type: " . $event['type']);
            break;
    }
}