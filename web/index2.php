<?php
require_once('./abc.txt');
$str = "Hello World";
$file = fopen("abc.txt","a+"); //開啟檔案
 if($fp){
fwrite($file,$str);
fclose($file);
}
?>
