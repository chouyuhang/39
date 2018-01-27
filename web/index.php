<?php
$access_token ='WI8f+ot/+7IJffBJATgfi1+rnNYCW+RGm1u2SRg2sdOLw2Y0+4gbdJsmh0zmUdtZNvx595o+hvI3XYeFQk66EVpl1mWwDDJOlKRecD6mc8gES9hnbAH+SOcrxw3QWmrmvQPI0WxrXMwB8EVOXPx4FwdB04t89/1O/w1cDnyilFU=';

 
$json_string = file_get_contents('php://input');
 
$json_obj = json_decode($json_string);
 
$event = $json_obj-&amp;gt;{"events"}[0];
$type = $event-&amp;gt;{"message"}-&amp;gt;{"type"};
$message = $event-&amp;gt;{"message"};
$reply_token = $event-&amp;gt;{"replyToken"};
 
$url = "https://spreadsheets.google.com/feeds/list/1uDfSyQ0tRn8b2idrg-S0_zRMzsyOVmBvYP2qTJDKD3w/od6/public/values?alt=json";
 
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$html = curl_exec($ch);
curl_close($ch);
 
$data = json_decode($html, true);
 
$result = array();
 
foreach ($data['feed']['entry'] as $item) {
$keywords = explode(',', $item['gsx$keyword']['$t']);
foreach ($keywords as $keyword) {
if (mb_strpos($message-&amp;gt;{'text'}, $keyword) !== false) {
if ($item['gsx$title']['$t']!=""){
$candidate = array(
"type" =&amp;gt; "text",
"text" =&amp;gt; $item['gsx$title']['$t'],
);
array_push($result, $candidate);
}
 
if ($item['gsx$previewimageurl']['$t']!="" &amp;amp;&amp;amp; $item['gsx$originalcontenturl']['$t']!="") {
$candidate_image = array(
"type" =&amp;gt; "image",
"previewImageUrl" =&amp;gt; $item['gsx$previewimageurl']['$t'],
"originalContentUrl" =&amp;gt; $item['gsx$originalcontenturl']['$t']
);
array_push($result, $candidate_image);
}
 
}
}
}
// END Google Sheet Keyword Decode
 
$post_data = array(
"replyToken" =&amp;gt; $reply_token,
"messages" =&amp;gt; $result
);
 
&amp;amp;nbsp;
 
$ch = curl_init("https://api.line.me/v2/bot/message/reply");
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'Content-Type: application/json',
'Authorization: Bearer '.$access_token
//'Authorization: Bearer '. TOKEN
));
$result = curl_exec($ch);
curl_close($ch);
?>
