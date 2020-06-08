<?php
//如果是云函数要加function main_handler($event, $context) {
$json= file_get_contents('https://api.bilibili.com/x/relation/stat?vmid=24749747');
$array= array(json_decode($json));
$ss = array_column($array, 'data');
$jsona= json_encode($ss);
print_r($jsona);
//}
?>
