<?php
namespace app\index\model;
class Index{
    // 关注回复
    public function followEvent($postObj,$arr){
        /*
        $toUser = $postObj->FromUserName;
        $fromUser = $postObj->ToUserName;
        $time = time();
        $MsgType = 'text';
        $Content = "欢迎{$postObj->ToUserName}关注aqie微信账号！回复'早安','午安','晚安'获取相应问候,回复图文查看更多.";
        $template = "
                    <xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[%s]]></MsgType>
                    <Content><![CDATA[%s]]></Content>
                    </xml>
                ";
        $info = sprintf($template,$toUser,$fromUser,$time,$MsgType,$Content);
        echo $info;
        */

        $this->responseNews($postObj,$arr);
    }

    // 多图文 回复
    public function responseNews($postObj,$arr){
        $toUser = $postObj->FromUserName;
        $fromUser = $postObj->ToUserName;


        $template = "
                <xml>
                <ToUserName><![CDATA[%s]]></ToUserName>
                <FromUserName><![CDATA[%s]]></FromUserName>
                <CreateTime>%s</CreateTime>
                <MsgType><![CDATA[%s]]></MsgType>
                <ArticleCount>".count($arr)."</ArticleCount>
                <Articles>";
        foreach ($arr as $k=>$v){
            $template .="
                <item>
                <Title><![CDATA[".$v['title']."]]></Title> 
                <Description><![CDATA[".$v['description']."]]></Description>
                <PicUrl><![CDATA[".$v['picUrl']."]]></PicUrl>
                <Url><![CDATA[".$v['url']."]]></Url>
                </item>";
        }
        $template .="
                </Articles>
                </xml>
            ";
        echo sprintf($template, $toUser, $fromUser, time(), 'news');
    }

    // 回复单文本
    public function responseText($postObj,$content){
        $template = "
                    <xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[%s]]></MsgType>
                    <Content><![CDATA[%s]]></Content>
                    </xml>
                ";
        $toUser = $postObj->FromUserName;
        $fromUser = $postObj->ToUserName;
        $time = time();
        $MsgType = 'text';
        $info = sprintf($template,$toUser,$fromUser,$time,$MsgType,$content);
        echo $info;
    }

}