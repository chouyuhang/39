<?php
$bot = new \chouyuhang\LINEBot(
  new \chouyuhang\LINEBot\HTTPClient\CurlHTTPClient('WI8f+ot/+7IJffBJATgfi1+rnNYCW+RGm1u2SRg2sdOLw2Y0+4gbdJsmh0zmUdtZNvx595o+hvI3XYeFQk66EVpl1mWwDDJOlKRecD6mc8gES9hnbAH+SOcrxw3QWmrmvQPI0WxrXMwB8EVOXPx4FwdB04t89/1O/w1cDnyilFU='),
  ['channelSecret' => 'a7e8c58d4744adbc363c42bc558db89e']
);
$signature = $_SERVER["HTTP_".\chouyuhang\LINEBot\Constant\HTTPHeader::LINE_SIGNATURE];
$body = file_get_contents("php://input");
try {
  $events = $bot->parseEventRequest($body, $signature);
} catch (Exception $e) {
  var_dump($e); //錯誤內容
}

?>

