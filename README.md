# 准备

平台粉丝数API，以bilibili举例

腾讯云图

云服务器或云函数

PHP，JavaScript基础

# 原理

抓取数据API，然后对API进行格式化，然后提取数组，映射到腾讯云图上

# API获取

API可以在github上找，也可以F12查找，github上有bilibili非官方整理的API[https://github.com/SocialSisterYi/bilibili-API-collect](https://github.com/SocialSisterYi/bilibili-API-collect)

比如粉丝数，是这个API(必须使用http)：[http://api.bilibili.com/x/relation/stat?vmid=24749747](http://api.bilibili.com/x/relation/stat?vmid=24749747)

```
其中：https://api.bilibili.com/x/relation/stat?vmid={查找的uid}
```

uid可以在个人空间里找到uid例如：

```
https://space.bilibili.com/24749747
```

24749747就是UID

# 腾讯云图对接

在腾讯云图里，编辑数据源用API，如果你直接输入[https://api.bilibili.com/x/relation/stat?vmid=24749747](https://api.bilibili.com/x/relation/stat?vmid=24749747)，得到的结果是

```
{"code":0,"message":"0","ttl":1,"data":{"mid":24749747,"following":179,"whisper":0,"black":4,"follower":7708}}
```

格式化一下

```
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
```

有用的数据在data里，其余都是返回码，所以只要

你会发现有二级数组，而且腾讯云图数据格式要有中括号，二级数组在腾讯云里是没办法提取出来的，所以必须要进行处理

![](https://ask.qcloudimg.com/http-save/yehe-3335308/d609dgvyzx.png)

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
```

# 腾讯云图映射

## 上传API

PHP的API可以托管给腾讯云函数，每个月有100万次免费额度，或者交给自己服务器处理，这部分不多讲

然后再腾讯云图里把数据改为API，输入PHP路径

![](https://ask.qcloudimg.com/http-save/yehe-3335308/gpv55d30e5.png)

勾上

![](https://ask.qcloudimg.com/http-save/yehe-3335308/3vjl9wig8z.png)

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

![](https://ask.qcloudimg.com/http-save/yehe-3335308/c4ufv8x3io.png)

# 2020-6-9更新：

## 对于需要SESSDATA的API

首先打开平台网站，然后在网址栏左侧点击

![](https://ask8088-private-1251520898.cn-south.myqcloud.com/developer-images/article/3335308/q0mitmksx9.png?q-sign-algorithm=sha1&q-ak=AKID2uZ1FGBdx1pNgjE3KK4YliPpzyjLZvug&q-sign-time=1591679295;1591686495&q-key-time=1591679295;1591686495&q-header-list=&q-url-param-list=&q-signature=e725ba17bd5b2b9505ac4486b2f2d0ef41bb53fc)

找到网站的域名处，选择SESSDATA

![](https://ask8088-private-1251520898.cn-south.myqcloud.com/developer-images/article/3335308/hnluh574bf.png?q-sign-algorithm=sha1&q-ak=AKID2uZ1FGBdx1pNgjE3KK4YliPpzyjLZvug&q-sign-time=1591679336;1591686536&q-key-time=1591679336;1591686536&q-header-list=&q-url-param-list=&q-signature=57867cdd76ff07110321d8acc7ed67e34d801b0e)

![](https://ask8088-private-1251520898.cn-south.myqcloud.com/developer-images/article/3335308/mi6kub6xuz.png?q-sign-algorithm=sha1&q-ak=AKID2uZ1FGBdx1pNgjE3KK4YliPpzyjLZvug&q-sign-time=1591679348;1591686548&q-key-time=1591679348;1591686548&q-header-list=&q-url-param-list=&q-signature=a6bf404c5328da7598c9ba5b630a618225ede76c)

记录这一部分的数值

![](https://ask8088-private-1251520898.cn-south.myqcloud.com/developer-images/article/3335308/i47rr5lnpr.png?q-sign-algorithm=sha1&q-ak=AKID2uZ1FGBdx1pNgjE3KK4YliPpzyjLZvug&q-sign-time=1591679365;1591686565&q-key-time=1591679365;1591686565&q-header-list=&q-url-param-list=&q-signature=d74b87a26f23ed7cc10d59891365823bc786e21e)

然后再在PHP代码里添加curl的get请求，并且格式化为腾讯云图格式：

```php
$ch =curl_init();
curl_setopt($ch,CURLOPT_URL,'输入API的地址');
//此处输入浏览器Cookie中的SESSDATA，保密！
$sessdata= 
curl_setopt($ch,CURLOPT_COOKIE,$sessdata);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec($ch);
//此处输出的是变量，需要Print或者return输出值，但是还需要进一步格式化
$array= array(json_decode($response,true));
//提取data值
$sss = array_column($array, 'data');
$jsona= json_encode($sss);
//格式化
$fin= str_replace("[[","[",$jsona);
$finb= str_replace("]]","]",$fin);
//输出值
print_r($finb);
```

经过格式化后数据已经正常

![](https://ask8088-private-1251520898.cn-south.myqcloud.com/developer-images/article/3335308/pym8lccfew.png?q-sign-algorithm=sha1&q-ak=AKID2uZ1FGBdx1pNgjE3KK4YliPpzyjLZvug&q-sign-time=1591679559;1591686759&q-key-time=1591679559;1591686759&q-header-list=&q-url-param-list=&q-signature=0aea3a3c40f5e1b412131255ba51fb0e02c8f332)

横纵代表意义去bilibiliAPI的github上查阅

# 到此，教程结束，感谢支持

更多玩法等你探索！

我是Ar-Sr-Na，业余无线电爱好者，个人网站www.arsrna.com
