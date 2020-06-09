<?php
$ch =curl_init();
//此处输入API的URL
$url= "http://member.bilibili.com/x/web/data/pandect?type=1"
curl_setopt($ch,CURLOPT_URL,$url);
//此处输入浏览器Cookie中的SESSDATA，保密！
$sessdata= '';
curl_setopt($ch,CURLOPT_COOKIE,$sessdata);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec($ch);

//$json= file_get_contents('https://www.arsrna.cn/bilibilidata/ccc.php');
$array= array(json_decode($response,true));
$sss = array_column($array, 'data');
$jsona= json_encode($sss);
$fin= str_replace("[[","[",$jsona);
$finb= str_replace("]]","]",$fin);
print_r($finb);
//}
?>