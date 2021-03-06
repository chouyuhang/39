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
                    $roomid=$source['roomId']; $groupid=$source['groupId'];$type=$message['type'];
                    $res = $bot->getProfile($userid); $profile = $res->getJSONDecodedBody();$displayName = $profile['displayName'];
		    $address=$message['address']; $title=$message['title'];
                    $longitude=$message['longitude']; $latitude=$message['latitude']; 
                    date_default_timezone_set('Asia/Taipei');$time=date("Y-m-d H:i:s");
		    if($address!=""){
		    //if($address!="" && $longitude>=121.5650 && $longitude<=121.5659 && $latitude>=25.0860 && $latitude<=25.0869){
			$mysqli = new mysqli('gzp0u91edhmxszwf.cbetxkdyhwsb.us-east-1.rds.amazonaws.com', "vu5qzklum1466fvr", "ieewar6pa07471zn", "oqz0qx1hdl6jbtca","3306");
			$sql = "select worktype from mysql where location='' and longitude='' and latitude='' and userid='$userid'";
			$result = $mysqli->query($sql);
			while($row = $result->fetch_array(MYSQLI_BOTH)) {
  			$worktype = $row['worktype'] ;
			}	
			if($worktype!=""){
			    $mysqli = new mysqli('gzp0u91edhmxszwf.cbetxkdyhwsb.us-east-1.rds.amazonaws.com', "vu5qzklum1466fvr", "ieewar6pa07471zn", "oqz0qx1hdl6jbtca","3306");	
			    $sql = "UPDATE mysql SET location='$address',longitude='$longitude',latitude='$latitude'worktime2='$time' where name='$displayName' and worktype!=''and userid='$userid';";
			    $result = $mysqli->query($sql);
				$client->replyMessage(array(
        				'replyToken' => $event['replyToken'],
     			   		'messages' => array(
				   	array(
                                          'type' => 'text',
                                          'text' => "定位成功!!"
                                       	),
 				)));
			$sql="SELECT worktype from mysql where userid='$userid'";
			$result = $mysqli->query($sql);
			while($row = $result->fetch_array(MYSQLI_BOTH)) {
  				$worktype = $row['worktype'] ;
 			 }
			//$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($displayName." ".$worktype);
		    	//$response = $bot->pushMessage('R8466f385da9bd8eac6fb509622c0a892', $textMessageBuilder);
			}
		    else{
			$mysqli = new mysqli('gzp0u91edhmxszwf.cbetxkdyhwsb.us-east-1.rds.amazonaws.com', "vu5qzklum1466fvr", "ieewar6pa07471zn", "oqz0qx1hdl6jbtca","3306");
			$sql="SELECT number from mysql";
			$result = $mysqli->query($sql);
			while($row = $result->fetch_array(MYSQLI_BOTH)) {
  				$number = $row['number'] ;
 			 }
			$number=$number+1;
			$sql="INSERT INTO mysql (number,name,userid,worktime,location,longitude,latitude) VALUES ('$number','$displayName','$userid','$time','$address','$longitude','$latitude')";
			$result = $mysqli->query($sql);
			$client->replyMessage(array(
  			'replyToken' => $event['replyToken'],
    			'messages' => array(
            		array(
                	'type' => 'template', 
                	'altText' => 'Example confirm template', 
                	'template' => array(
                    	'type' => 'confirm',
                    	'text' => '你現在是進還是出?',
                    	'actions' => array(
                        	array(
                            	'type' => 'message', 
                            	'label' => '進', 
                            	'text' => '進'
                        	),
                        	array(
                            	'type' => 'message', 
                            	'label' => '出', 
                            	'text' => '出' 
                        	)
                    	))))));
			$z=0;
			while($z==0){
			sleep(5);
			$sql = "select worktype,worktime from mysql where worktype='' and userid='$userid'";
			$result = $mysqli->query($sql);
			while($row = $result->fetch_array(MYSQLI_BOTH)) {
				$worktype = $row['worktype'] ;
				$worktime = $row['worktime'];
			}
			$sql = "select worktype from mysql where worktime='$worktime' and userid='$userid'";
			$result = $mysqli->query($sql);
			while($row = $result->fetch_array(MYSQLI_BOTH)) {
				$worktype2 = $row['worktype'];
			}	
			if($worktype2!="")break;
			if($worktype==""){
				$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("請按進出按紐");
				$response = $bot->pushMessage($userid, $textMessageBuilder);
			}
		    }
		  }
		}
		break;
		case 'text':
		    $replyToken=$event['replyToken'];
                    $m_message = $message['text']; $source=$event['source']; $idtype = $source['type'];  $userid=$source['userId'];
                    $roomid=$source['roomId']; $groupid=$source['groupId'];
                    $res = $bot->getProfile($userid); $profile = $res->getJSONDecodedBody();$displayName = $profile['displayName'];
		    $address=$message['address']; $title=$message['title'];
                    $longitude=$message['longitude']; $latitude=$message['latitude'];
                    date_default_timezone_set('Asia/Taipei');$time=date("Y-m-d H:i:s");$date=date("Y-m-d");
		    /*if($m_message!="" && $userid!='Ud9a4e29db28b8b07a78cecf6d8ec3bdb' && $roomid!='R8466f385da9bd8eac6fb509622c0a892'){
	            //if($m_message!=""){
		    	$mysqli = new mysqli('gzp0u91edhmxszwf.cbetxkdyhwsb.us-east-1.rds.amazonaws.com', "vu5qzklum1466fvr", "ieewar6pa07471zn", "oqz0qx1hdl6jbtca","3306");
		    	$sql = "SELECT userid from mysql";
		    	$result = $mysqli->query($sql);
			$row = $result->fetch_array(MYSQLI_BOTH);
		    	$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($m_message);
		    	$response = $bot->pushMessage('R8466f385da9bd8eac6fb509622c0a892', $textMessageBuilder);
			$response = $bot->pushMessage('Ud9a4e29db28b8b07a78cecf6d8ec3bdb', $textMessageBuilder);
		    }*/
		    $mysqli = new mysqli('gzp0u91edhmxszwf.cbetxkdyhwsb.us-east-1.rds.amazonaws.com', "vu5qzklum1466fvr", "ieewar6pa07471zn", "oqz0qx1hdl6jbtca","3306");
			$join=false;$unjoin=false;
			$sql = "SELECT inside from inin";
			$result = $mysqli->query($sql);
			while($row = $result->fetch_array(MYSQLI_BOTH)){
  				$inside = $row['inside'] ;
 			if(preg_match("/$inside/i","$m_message")){
  				$join=true;
			 }
			}
			$sql = "SELECT outside from outout";
			$result = $mysqli->query($sql);
			while($row = $result->fetch_array(MYSQLI_BOTH)){
  				$outside = $row['outside'] ;
			if(preg_match("/$outside/i","$m_message")){
  				$unjoin=true;
			 }
			}
			/*$join=false;
			foreach ($inside as $value){
 			if(preg_match("/$value/i","$m_message")){
  				$join=true;
			 }
			}
			$index=0;
			$sql = "SELECT outside from outout";
			$result = $mysqli->query($sql);
			while($row = $result->fetch_array(MYSQLI_BOTH)){
  				$outside[$index] = $row['outside'] ;
				$index++;
			}
			$unjoin=false;
			foreach ($outside as $value){
 			if(preg_match("/$value/i","$m_message")){
  				$unjoin=true;
			 }
			}*/
			    
		    if($join){
			$mysqli = new mysqli('gzp0u91edhmxszwf.cbetxkdyhwsb.us-east-1.rds.amazonaws.com', "vu5qzklum1466fvr", "ieewar6pa07471zn", "oqz0qx1hdl6jbtca","3306");
			$sql = "SELECT location,number from mysql where worktype='' and userid='$userid'";
			$result = $mysqli->query($sql);
			while($row = $result->fetch_array(MYSQLI_BOTH)) {
  			$location = $row['location'] ;
			$number=$row['number'];
			}
			if($location!=""){
			$client->replyMessage(array(
			'replyToken' => $event['replyToken'],
     			   'messages' => array(
			     array(
                                          'type' => 'text',
                                          'text' => "歡迎你的到來!!" . "\n" . "祝你使用愉快!!"
                                   ),
 	       		)));
			$mysqli = new mysqli('gzp0u91edhmxszwf.cbetxkdyhwsb.us-east-1.rds.amazonaws.com', "vu5qzklum1466fvr", "ieewar6pa07471zn", "oqz0qx1hdl6jbtca","3306");
			$sql = "UPDATE mysql SET worktype='進',worktime2='$time' where name='$displayName' and worktype=' ' and number='$number';";
			$result = $mysqli->query($sql);
			$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($displayName." "."進");
		    	$response = $bot->pushMessage('R8466f385da9bd8eac6fb509622c0a892', $textMessageBuilder);
			}
			else{
			$mysqli = new mysqli('gzp0u91edhmxszwf.cbetxkdyhwsb.us-east-1.rds.amazonaws.com', "vu5qzklum1466fvr", "ieewar6pa07471zn", "oqz0qx1hdl6jbtca","3306");
			$sql="SELECT number from mysql";
			$result = $mysqli->query($sql);
			while($row = $result->fetch_array(MYSQLI_BOTH)) {
  				$number = $row['number'] ;
 			 }
			$number=$number+1;
			$sql="INSERT INTO mysql (number,name,userid,worktime,worktype) VALUES ('$number','$displayName','$userid','$time','進')";
			$result = $mysqli->query($sql);
			$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("請定位你的位置");
		    	$response = $bot->pushMessage($userid, $textMessageBuilder);
			$z=0;
			while($z==0){
				sleep(5);
				$sql = "select location,worktime from mysql where location='' and userid='$userid'";
				$result = $mysqli->query($sql);
				while($row = $result->fetch_array(MYSQLI_BOTH)) {
					$location = $row['location'];
					$worktime = $row['worktime'];
				}
				$sql = "select location from mysql where worktime='$worktime' and userid='$userid'";
				$result = $mysqli->query($sql);
				while($row = $result->fetch_array(MYSQLI_BOTH)) {
					$location2 = $row['location'];
				}	
				if($location2!="")break;
				if($location==""){
					$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("請定位你的位置");
					$response = $bot->pushMessage($userid, $textMessageBuilder);
				}
			}
			}
		    }else if($unjoin){
			$mysqli = new mysqli('gzp0u91edhmxszwf.cbetxkdyhwsb.us-east-1.rds.amazonaws.com', "vu5qzklum1466fvr", "ieewar6pa07471zn", "oqz0qx1hdl6jbtca","3306");
			$sql = "SELECT location from mysql where worktype='' and userid='$userid'";
			$result = $mysqli->query($sql);
			while($row = $result->fetch_array(MYSQLI_BOTH)) {
  			$location = $row['location'] ;
			$number=$row['number'];
			}
			if($location!=""){
			$client->replyMessage(array(
        		'replyToken' => $event['replyToken'],
     			   'messages' => array(
			     array(
                                          'type' => 'text',
                                          'text' => "歡迎你的到來!!" . "\n" . "祝你使用愉快!!"
                                   ),
 	       		)));
			$mysqli = new mysqli('gzp0u91edhmxszwf.cbetxkdyhwsb.us-east-1.rds.amazonaws.com', "vu5qzklum1466fvr", "ieewar6pa07471zn", "oqz0qx1hdl6jbtca","3306");
			$sql = "UPDATE mysql SET worktype='出',worktime2='$time' where name='$displayName' and worktype=' ' and number='$number';";
			$result = $mysqli->query($sql);
			//$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($displayName." "."出");
		    	//$response = $bot->pushMessage('R8466f385da9bd8eac6fb509622c0a892', $textMessageBuilder);
			}
			else{
			$mysqli = new mysqli('gzp0u91edhmxszwf.cbetxkdyhwsb.us-east-1.rds.amazonaws.com', "vu5qzklum1466fvr", "ieewar6pa07471zn", "oqz0qx1hdl6jbtca","3306");
			$sql="SELECT number from mysql";
			$result = $mysqli->query($sql);
			while($row = $result->fetch_array(MYSQLI_BOTH)) {
  				$number = $row['number'] ;
 			 }
			$number=$number+1;
			$sql="INSERT INTO mysql (number,name,userid,worktime,worktype) VALUES ('$number','$displayName','$userid','$time','出')";
			$result = $mysqli->query($sql);
			$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("請定位你的位置");
		    	$response = $bot->pushMessage($userid, $textMessageBuilder);
			$z=0;
			while($z==0){
				sleep(3);
				$sql = "select location,worktime from mysql where location='' and userid='$userid'";
				$result = $mysqli->query($sql);
				while($row = $result->fetch_array(MYSQLI_BOTH)) {
					$location = $row['location'];
					$worktime = $row['worktime'];
				}
				$sql = "select location from mysql where worktime='$worktime' and userid='$userid'";
				$result = $mysqli->query($sql);
				while($row = $result->fetch_array(MYSQLI_BOTH)) {
					$location2 = $row['location'];
				}	
				if($location2!="")break;
				if($location==""){
					$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("請定位你的位置");
					$response = $bot->pushMessage($userid, $textMessageBuilder);
				}
			}
			}
		    }/*else*/ if($m_message!='' && $join=true && $unjoin=true && $m_message!='毫無相關' && $m_message!='查'){
			$mysqli = new mysqli('gzp0u91edhmxszwf.cbetxkdyhwsb.us-east-1.rds.amazonaws.com', "vu5qzklum1466fvr", "ieewar6pa07471zn", "oqz0qx1hdl6jbtca","3306");
			if($m_message!='進' && $m_message!='出' && $m_message!='毫無相關'){
				$sql="INSERT INTO msg (mes) VALUES ('$m_message')";
				$result = $mysqli->query($sql);
			}
			$client->replyMessage(array(
				'replyToken' => $event['replyToken'],
				'messages' => array(
					array(
						'type' => 'template', // 訊息類型 (模板)
                				'altText' => 'simple in and out', // 替代文字
                				'template' => array(
							'type' => 'buttons', // 類型 (按鈕)
							'title' => '選單', // 標題 <不一定需要>
							'text' => '請問'.$m_message.'代表什麼', // 文字
							'actions' => array(
								array(
									'type' => 'message', // 類型 (訊息)
									'label' => '進', // 標籤 1
									'text' => '進' // 用戶發送文字
								),
								array(
									'type' => 'message', // 類型 (訊息)
									'label' => '出', // 標籤 2
									'text' => '出' // 用戶發送文字
								),
								array(
									'type' => 'message', // 類型 (訊息)
									'label' => '毫無相關', // 標籤 3
									'text' => '毫無相關' // 用戶發送文字
								)
							)
						),
					)
								
				)
							
			)
								  );
			$mysqli = new mysqli('gzp0u91edhmxszwf.cbetxkdyhwsb.us-east-1.rds.amazonaws.com', "vu5qzklum1466fvr", "ieewar6pa07471zn", "oqz0qx1hdl6jbtca","3306");
			$sql = "select mes from msg";
			$result = $mysqli->query($sql);
			while($row = $result->fetch_array(MYSQLI_BOTH)) {
				$mes = $row['mes'];
			}
			if($m_message=="進"){
				$sql="INSERT INTO inin (inside) VALUES ('$mes')";
				$result = $mysqli->query($sql);
				$sql="delete from msg where mes!=''";
				$result = $mysqli->query($sql);
			}else if($m_message=="出"){
				$sql="INSERT INTO outout (outside) VALUES ('$mes')";
				$result = $mysqli->query($sql);
				$sql="delete from msg where mes!=''";
				$result = $mysqli->query($sql);
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
