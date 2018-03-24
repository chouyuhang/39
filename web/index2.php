<?php
require_once('./LINEBotTiny.php');
require_once __DIR__ . '/../src/LINEBot.php';
require_once __DIR__ . '/../src/LINEBot/Response.php';
require_once __DIR__ . '/../src/LINEBot/Constant/Meta.php';
require_once __DIR__ . '/../src/LINEBot/HTTPClient.php';
require_once __DIR__ . '/../src/LINEBot/HTTPClient/Curl.php';
require_once __DIR__ . '/../src/LINEBot/Constant/MessageType.php';
require_once __DIR__ . '/../src/LINEBot/MessageBuilder.php';
require_once __DIR__ . '/../src/LINEBot/HTTPClient/CurlHTTPClient.php';
require_once __DIR__ . '/../src/LINEBot/MessageBuilder/TextMessageBuilder.php';
//USE oqz0qx1hdl6jbtca;
$channelAccessToken = getenv('LINE_CHANNEL_ACCESSTOKEN');
$channelSecret = getenv('LINE_CHANNEL_SECRET');

$header=["Content-Type: application/json", "Authorization: Bearer {" . $channelAccessToken . "}"];
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
                    $pictureUrl=$message['pictureUrl'];$res = $bot->getProfile($id);$profile = $res->getJSONDecodedBody();
                    $displayName = $profile['displayName'];
                    date_default_timezone_set('Asia/Taipei');
		    $time=date("Y-m-d H:i:s");
		    //global $mysqli;
                    /*$mysqli = new mysqli('gzp0u91edhmxszwf.cbetxkdyhwsb.us-east-1.rds.amazonaws.com', "vu5qzklum1466fvr", "ieewar6pa07471zn", "oqz0qx1hdl6jbtca","3306");
			
		    $sql="INSERT INTO mysql (name,userid) VALUES ('$displayName','$userid')";
		    $result = $mysqli->query($sql);
		    $sql = "select * from mysql";
	            $result = $mysqli->query($sql);
 
			while($row = $result->fetch_array(MYSQLI_BOTH)) {
  				$name = $row['name'] ;
				$myid=$row['userid'];
 			 }
	            if(mysqli_connect_errno()){ 
                        $debugmsg='資料庫連線失敗';
                    }
                    else{
			 $mysqli->close();
		    }*/
                    if($m_message!=""){
			$insert="INSERT INTO mysql (name,userid,worktime,worktype) VALUES ('$displayName','$userid','$time','進')";
			$a = $mysqli->query($insert);
			$result = $mysqli->query($sql);
		    	$sql = "select * from mysql";
	            	$result = $mysqli->query($sql);
 		    	while($row = $result->fetch_array(MYSQLI_BOTH)) {
  		        	$name = $row['name'] ;
				$myid=$row['userid'];
				$worktime=$row['worktime'];
				$worktype=$row['worktype'];
 		   	 }
	            	if(mysqli_connect_errno()){ 
                        	$debugmsg='資料庫連線失敗';
                    	}
                    	else{
			 	$mysqli->close();
		    	}
                        $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($displayName." ".$name." ".$myid." ".$worktime."\n".$worktype);
			$response = $bot->replyMessage($replyToken, $textMessageBuilder);
		    }
                    break;
            }
            break;
        default:
            error_log("Unsupporeted event type: " . $event['type']);
            break;
    }
}
