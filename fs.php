<?php
$json= file_get_contents('https://api.bilibili.com/x/relation/stat?vmid=24749747');
$array= array(json_decode($json));
$ss = array_column($array, 'data');
$jsona= json_encode($ss);
$a= str_replace("{","[{",$json);
$b= str_replace("}","}]",$a);
print($jsona);
?>