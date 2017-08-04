--接口介绍（2924811900@qq.com 微信公众号）QAZ
https://aqie.localtunnel.me/index/index/connect
准备：
1.npm install -g localtunnel
2.lt --subdomain klioen --port 8080 或 lt -s aqie -p 443
AppID : wx9449083b5b7bd70d
AppSecret: 06b563613266cfa822acb495d8bd2515


落叶知秋
wxa6fe43f62cca764a
6ed07b334568778e7cada4009bdc94fb

测试号信息
appID   wx736a139d8d9952d0
appsecret   250b1f96717c1b119fca485ad96652de

1.映射到外网
   a. npm install -g localtunnel
    lt -s aqie -p 443  固定域名
    npm uninstall -g localtunnel
    b. $ git clone git://github.com/defunctzombie/localtunnel-server.git
        $ cd localtunnel-server
        $ npm install
        bin/server --port 443
        pm2 start bin/server --name lt -- --port 443
        lt --host http://aqie.localtunnel.me:443 --port 8000

https://aqie.localtunnel.me/index/index/http_curl
1.事件推送
    a.订阅公众账号
2.加密/校验流程
    a.token.timestamp.nonce进行字典序排序
    b.三个参数字符串拼接成一个字符串进行sha1加密
    c.加密后字符串与signature对比，标识该请求来源于微信
3.access_token
    appid 和appsecret用来产生access_token
    唯一有效性
    全局有效性
4.curl
5. 微信开放接口
    1.微信服务器地址
    2.access_token
6.sdk  控制器 模型
7.天气查询接口 （APIStore http://apistore.baidu.com/）
    a. http://api.yytianqi.com/接口名称?city=城市ID&key=用户key(	48a5lhf4bdsiqttf  )
    b.市列表json格式获取地址：http://api.yytianqi.com/citylist/id/1
8.urlencode($city)  // curl地址里城市
9.网页授权接口 (OAuth2.0机)
    1.snsapi_base

    2.snsapi_userinfo
    3.步骤
        a.用户同意授权，获取code
        b.通过code换区网页授权access_token
        c.刷新access_token (和之前获取的不一样)，UnionID(移动端)
        d.拉取用户信息
    4. https://aqie.localtunnel.me/index/index/getbaseInfo  草料生成二维码

/*++++++++++++++++++++++++++++========微信开发高级篇==========++++++++++++++++++++*/
10.
    a.自定义菜单
        1.3个一级菜单，5个二级菜单
        2.click：点击推事件
        3.view:跳转URL
    b.群发接口
    c.网页授权接口
    d.模板消息接口
    e.二维码接口
    f.微信JS-SDK