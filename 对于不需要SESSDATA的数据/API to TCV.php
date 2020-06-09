<?php
//如果是云函数要加function main_handler($event, $context) {
//输入API地址
$url= "https://api.bilibili.com/x/space/acc/info?mid=24749747";
$json= file_get_contents($url);
$array= array(json_decode($json));
$ss = array_column($array, 'data');
$jsona= json_encode($ss);
print_r($jsona);
//}
?>
