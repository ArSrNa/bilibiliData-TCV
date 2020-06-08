# bilibiliData-TCV
利用腾讯云图对bilibili数据监控
# 准备
平台粉丝数API，以bilibili举例
腾讯云图
云服务器或云函数
PHP，JavaScript基础

# 原理
抓取数据API，然后对API进行格式化，然后提取数组，映射到腾讯云图上

#API获取
API可以在github上找，也可以F12查找，github上有bilibili非官方整理的API 
[https://github.com/SocialSisterYi/bilibili-API-collect](https://github.com/SocialSisterYi/bilibili-API-collect)
比如粉丝数，是这个API：
[https://api.bilibili.com/x/relation/stat?vmid=24749747](https://api.bilibili.com/x/relation/stat?vmid=24749747)
其中：```https://api.bilibili.com/x/relation/stat?vmid={查找的uid}```
uid可以在个人空间里找到uid,例如：https://space.bilibili.com/24749747
24749747就是UID

腾讯云图对接
在腾讯云图里，编辑数据源用API，如果你直接输入https://api.bilibili.com/x/relation/stat?vmid=24749747，得到的结果是

```{"code":0,"message":"0","ttl":1,"data":{"mid":24749747,"following":179,"whisper":0,"black":4,"follower":7708}}```

格式化一下

{

    "code":0,
    
    "message":"0",
    
    "ttl":1,
    
    "data":{
    
        "mid":24749747,
        
        "following":179,
        
        "whisper":0,
        
        "black":4,
        
        "follower":7708
        
    }
    
}

有用的数据在data里，其余都是返回码，所以只要

你会发现有二级数组，而且腾讯云图数据格式要有中括号，二级数组在腾讯云里是没办法提取出来的，所以必须要进行处理


数据处理
这里用的是PHP，因为扩展性强

首先先获得bilibiliapi的内容：

$表示变量 根据自己习惯来

```$json= file_get_contents('https://api.bilibili.com/x/relation/stat?vmid=24749747');```

再把json格式数据解码为php的数组

注意这部分变量

```$array= array(json_decode($json));```
去掉返回的代码值，只提取data部分

```$ss = array_column($array, 'data');```
将数据转换为json格式，再范化为腾讯云图数据格式，把{替换为[{，}替换为 }]

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
```

# 腾讯云图映射
## 上传API
PHP的API可以托管给腾讯云函数，每个月有100万次免费额度，或者交给自己服务器处理，这部分不多讲

然后再腾讯云图里把数据改为API，输入PHP路径


勾上由服务器发起请求

数据如下

```
[
  {
    "mid": 24749747,
    "following": 179,
    "whisper": 0,
    "black": 0,
    "follower": 7708
  }
]
```

mid:用户UID

Following：关注数

下面两个不知道什么

Follower：粉丝数

根据实际情况映射


到此，教程结束，感谢支持
更多玩法等你探索！

我是Ar-Sr-Na，业余无线电爱好者，个人网站www.arsrna.com准备
