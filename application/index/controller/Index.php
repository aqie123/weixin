<?php
namespace app\index\controller;

use think\Controller;
use app\index\model\Index as IndexModel;
use think\session;

class Index extends Controller
{
    // 落叶知秋life
    public function common()
    {
        // 1.将timestamp,nonce.token字典排序
        if(isset($_GET['echostr'])){
            $timestamp = $_GET['timestamp'];
            $nonce = $_GET['nonce'];
            $token = 'weixin';
            $echostr = $_GET['echostr'];
            $signature = $_GET['signature'];
            $array = array($timestamp,$nonce,$token);
            sort($array);
            // 2.排序后三个参数拼接使用sha1加密
            $tmpstr = implode('',$array);
            $tmpstr = sha1($tmpstr);

            //3.加密后字符串与signature进行对比，判断请求是否来自微信
            if($tmpstr == $signature) {
                // 第一次接入微信api接口
                echo $echostr;
                exit;
            }
        }else{
            // 后面发送消息
            $this->responseMsg();
        }
    }
    // 沙盒测试
    public function test(){
        $this->common();
    }
    // 落叶知秋
    public function index(){
        $this->common();
    }

    //  https://aqie.localtunnel.me/index/index/connect  啊切life
    public function connect(){
        $this->common();
    }

    // 接收事件推动并回复
    public function responseMsg(){
        // 1.获取微信推送过来post数据 xml
        // $postArr = $GLOBALS['HTTP_RAW_POST_DATA'];
        $postArr = file_get_contents('php://input');

        // 处理消息类型，并设置回复类型和内容
        // xml转换为对象
        $postObj = simplexml_load_string($postArr);
        // 判断数据包是否是订阅的事件推送
        if(strtolower($postObj->MsgType) == 'event'){
            // 如果关注subscribe事件
            if(strtolower($postObj->Event == 'subscribe')){
                // 关注后 回复用户消息
                $arr = array(
                    array(
                        'title' => '啊切life公众号',
                        'description' => '欢迎关注，正在开发中',
                        'picUrl' => 'http://ole5vzrbd.bkt.clouddn.com/58f52ada0adad-coverbig',
                        'url' => 'https://github.com/aqie123',
                    )
                );
                $indexModel = new IndexModel;
                $indexModel->followEvent($postObj,$arr);
            }
        }

         // 用户发送图文关键字   回复单图文
        if(strtolower($postObj->MsgType) == 'text' && trim($postObj->Content)=='图文' ){
            // 从数据库查询
            $arr = array(
                array(
                    'title' => '啊切小程序',
                    'description' => '啊切小程序正在开发中',
                    'picUrl' => 'http://ole5vzrbd.bkt.clouddn.com/58f52ada0adad-coverbig',
                    'url' => 'https://github.com/aqie123',
                ),
                array(
                    'title' => '啊切商城',
                    'description' => '啊切商城基于yii2',
                    'picUrl' => 'http://ole5vzrbd.bkt.clouddn.com/58f530a872dd0-covermiddle',
                    'url' => 'https://github.com/aqie123',
                ),
                array(
                    'title' => '啊切微信号',
                    'description' => '啊切微信号正在开发',
                    'picUrl' => 'http://ole5vzrbd.bkt.clouddn.com/58f52ba8dd04d-covermiddle',
                    'url' => 'https://github.com/aqie123',
                ),

            );
            // 实例化
            $indexModel = new IndexModel;
            $indexModel->responseNews($postObj,$arr);

        }else{          // 单文本回复

            switch( trim($postObj->Content) ){
                case "早安":
                    $content = '早安喵* 5 *';
                    break;
                case "午安":
                    $content = '午安喵* 5 *';
                    break;
                case "晚安":
                    $content = '晚安喵* 5 *';
                    break;
                case "php":
                    $content = "<a href='https://github.com/aqie123'>php是世界上最好的语言</a>";
                    break;
                case "天气":
                    $content = $this->weather();
                    break;
                default:
                    $content = '未找到相关信息';
                    break;
            }

            $indexModel = new IndexModel;
            $indexModel->responseText($postObj,$content);
        }

    }

    // curl 获取 网址(调用接口)

    /**
     * @param $url (请求地址)
     * @param string $type  (请求类型)
     * @param string $res   (返回数据类型)
     * @param $arr          (post 请求参数)
     * @return mixed
     */
    public function http_curl($url,$type = 'get',$res = 'json',$arr = ''){
        //1.初始化curl
        $ch = curl_init();

        //2.设置curl的参数
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // 默认get请求
        if($type = 'post'){
            curl_setopt($ch,CURLOPT_POST,1);  // 设置为post
            curl_setopt($ch,CURLOPT_POSTFIELDS,$arr);
        }

        //如果获取的token为null，不妨先看看curl_exec返回值是否为false
        //解决办法：跳过SSL证书检查
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        //3.采集
        $output = curl_exec($ch);

        if($res == 'json'){
            if(curl_errno($ch)){
                return curl_errno($ch);
            }else{
                return json_decode($output,true);
            }
        }
        //4.关闭
        curl_close($ch);
    }


    // 获取微信token
    public function getWxAccessToken1(){
        // 1.请求url
        $appid = 'wx736a139d8d9952d0';  // wx9449083b5b7bd70d
        $appsecret =  '250b1f96717c1b119fca485ad96652de';  // 06b563613266cfa822acb495d8bd2515
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appsecret;
        // 2.初始化
        $ch = curl_init();
        // 3.设置参数
        curl_setopt($ch , CURLOPT_URL, $url);
        curl_setopt($ch , CURLOPT_RETURNTRANSFER, 1);

        //如果获取的token为null，不妨先看看curl_exec返回值是否为false
        //解决办法：跳过SSL证书检查
         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        //4.调用接口
        $res = curl_exec($ch);
        //5.关闭curl
        curl_close($ch);
        // 如果有错打印出来
        /*
        if(curl_errno($ch)){
            var_dump(curl_error($ch));
        }
        */
        $arr = json_decode($res, true); // json转换为数组
        var_dump( $arr );
    }



    // 获取微信服务器id
    public function getWxServerIp(){
        $accessToken = "Ez_i9eZHZkw-CytAYHHj028cSfIlkF5qafEmj3pl7B7WOMvrOmgc__5Vx5o1MfKFLF232C3Dn7wBbJbJe4JtTJRKxIcJreZZpISgmiiv7aHVAYtukE1aw04T6OtF2D1rIWFbAHAOCL";
        $url = "https://api.weixin.qq.com/cgi-bin/getcallbackip?access_token=".$accessToken;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        $res = curl_exec($ch);
        curl_close($ch);
        /*
        if(curl_errno($ch)){
            var_dump(curl_error($ch));
        }
        */
        $arr = json_decode($res,true);
        echo "<pre>";
        var_dump( $arr );
        echo "</pre>";
    }


    // 查询天气
    public function weather(){
        //1.初始化curl
        $ch = curl_init();
        $url = 'http://api.yytianqi.com/observe?city=ip&key=48a5lhf4bdsiqttf';
        //2.设置curl的参数
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //3.采集
        $output = curl_exec($ch);
        //4.关闭
        curl_close($ch);
        var_dump(json_decode($output, true));
        $arr = json_decode($output, true);  // 天气二维数组
        $content = $arr['data'];
        $content = $content['cityName']."\n天气:".$content['tq']."\n 气温：".$content['qw']."\n风向：".$content['fx'];
        return $content;
    }

    // 创建微信菜单  https://mp.weixin.qq.com/wiki
    // https://aqie.localtunnel.me/index/index/defineItem
    public function defineItem(){
        // 通过curl 调用 get/post
        if($access_token = $this->getWxAccessToken()){
            echo $access_token = $this->getWxAccessToken() ."<br>";
            $url = " https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$access_token;
            echo $url."<br>";
            $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=6QXrx5SOpXoSBa582tdQINWGUns0PxC-VjyrkCWdi0gDZcbH3hdBT8k-R2cdUVCQq3YFIXGSPoLNJ1G_kPyy7XxuIpI4iZxvNSqm9vDc1WGyP-0DDyRrpBbjqSd0lqYMMYPaAAAFRI";

            // $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=6QXrx5SOpXoSBa582tdQINWGUns0PxC-VjyrkCWdi0gDZcbH3hdBT8k-R2cdUVCQq3YFIXGSPoLNJ1G_kPyy7XxuIpI4iZxvNSqm9vDc1WGyP-0DDyRrpBbjqSd0lqYMMYPaAAAFRI";
            $postArr = array(
                'button' => array(
                    array(
                        'name'=>urlencode('菜单一'),
                        'type'=> 'click',
                        'key'=>'item1'
                    ),
                    array(
                        'name'=>urlencode('菜单二'),
                        'type'=> 'click',
                        'key'=>'item1'
                    )
                )
            );
            echo $postJson = urldecode(json_encode($postArr));
            $res = $this->http_curl($url,'post','json',$postJson);
            var_dump($res);
        }


    }

    // 获取微信token +session (memcache mysql)
    public function getWxAccessToken(){

        // 将access_token 存在session/cookie中
        if(isset($_SESSION["access_token"]) && $_SESSION["expire_time"] > time()){  // 存在session 且未过期
            return $_SESSION["access_token"];
        }else{
            // 1.请求url
            $appid = 'wx736a139d8d9952d0';  // wx9449083b5b7bd70d
            $appsecret =  '250b1f96717c1b119fca485ad96652de';  // 06b563613266cfa822acb495d8bd2515
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appsecret;
            $res = $this->http_curl($url,'get','json');
            $access_token = $res['access_token'];
            // 将重新获取到access_token存进session
            $_SESSION["access_token"] = $access_token;
            $_SESSION["expire_time"] = time() + 7200;
            return $access_token;
        }
    }

    // （OAuth2.0机制）获取网页授权access_token）获取用户openid
    public function getbaseInfo(){
        // 1.获取code
        $appid = "wx736a139d8d9952d0";
        $redirect_uri = urlencode("https://aqie.localtunnel.me/index/index/getUserOpenId");
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$appid."&redirect_uri=".$redirect_uri."&response_type=code&scope=snsapi_base&state=123#wechat_redirect";
        header('location:'.$url);

    }

    public function getUserOpenId(){
        $appid = "wx736a139d8d9952d0";
        $appsecret = "250b1f96717c1b119fca485ad96652de";
        // 上面getbaseInfo 跳转到这个方法，携带参数
        $code = $_GET['code'];
        //2.获取网页授权access_token
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appid."&secret=".$appsecret."&code=".$code."&grant_type=authorization_code ";
        //3.拉取用户openid
        $res = $this->http_curl($url);
        var_dump($res);
    }
}
