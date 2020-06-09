<?php
$ch =curl_init();
//此处输入API的URL
$url= 'http://member.bilibili.com/x/web/data/survey?type=1';
curl_setopt($ch,CURLOPT_URL,$url);
//此处输入浏览器Cookie中的SESSDATA，保密！
$sessdata= '';
curl_setopt($ch,CURLOPT_COOKIE,$sessdata);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec($ch);

$array= array(json_decode($response,true));
$s = array_column($array, 'data');
$date= date("Ymd",strtotime("-1 day"));
$ss = array_column($s, $date);
$sss = array_column($ss, 'arc_inc');
$jsona= json_encode($sss);
$fin= str_replace("[[","[",$jsona);
$finb= str_replace("]]","]",$fin);
print_r($finb);
//}
?>
