## 数据处理

这里用的是PHP，因为扩展性强

首先先获得bilibiliapi的内容：

```
//$表示变量 根据自己习惯来
$json= file_get_contents('https://api.bilibili.com/x/relation/stat?vmid=24749747');
```

再把json格式数据解码为php的数组

```
//注意这部分变量
$array= array(json_decode($json));
```

去掉返回的代码值，只提取data部分

```
$ss = array_column($array, 'data');
```

将数据转换为json格式，再范化为腾讯云图数据格式，把"{"替换为"{"，"}"替换为"}"

```
$a= str_replace("{","[{",$json);
$b= str_replace("}","}]",$a);
```

最后输出结果 

```
print($jsona);
```

整合起来就是

```
<?php
$json= file_get_contents('https://api.bilibili.com/x/relation/stat?vmid=24749747');
$array= array(json_decode($json));
$ss = array_column($array, 'data');
$jsona= json_encode($ss);
$a= str_replace("{","[{",$json);
$b= str_replace("}","}]",$a);
print($jsona);
?>
