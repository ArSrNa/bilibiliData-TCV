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