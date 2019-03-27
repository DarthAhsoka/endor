<?php
/**
 * Created by Darth-Ahsoka.
 * Author: Darth-Ahsoka  929204168@qq.com
 * Date: 2017/7/16
 * Version: 0.8 beta
 * Last Update: 2019/03/26
 * Update History:
 *      2017/08/17 创建0.7 Alpha 版本
 *      2019/03/26 0.8 beta 优化名字空间
 *                 修改部分函数命名
 *
 */
namespace endor\wechat\message;
use endor\wechat\WechatCommon;
use endor\wechat\WechatException;

/**
 * Class NewsMessage
 * 图文消息类
 * @package endor\wechat\message
 */
class NewsMessage extends Message
{
    # 图文消息内容,当 $_msgType == news 时启用
    protected $article_count = 0;
    # 多条图文消息，默认第一个item为大图，图文超过10个无响应
    protected $articles = [];

    public function  __construct($platform, $user, $timestamp, $msgId)
    {
        parent::__construct('news',$timestamp, $msgId);
        $this->setPlatform($platform);
        $this->setUser($user);
    }

    /**
     * @param $newsContext NewsContext 图文上下文结构
     * @throws WechatException
     * 添加一个图文结构到图文列表中
     */
    public function addNewsContext($newsContext)
    {
        if($this->article_count >= 10)
        {
            throw new WechatException("图文消息结构最多不能超过10个");
        }

        array_push($this->articles,$newsContext);
        $this->article_count++;
    }

    /**
     * 移除所有的图文结构
     */
    public function removeAllContext()
    {
        $this->articles = [];
        $this->article_count = 0;
    }

    /**
     *  发送消息
     */
    public function response() {
        $tplXmlStr =  "<xml>
                       <ToUserName><![CDATA[%s]]></ToUserName>
                       <FromUserName><![CDATA[%s]]></FromUserName>
                       <CreateTime>%s</CreateTime>
                       <MsgType><![CDATA[news]]></MsgType>
                       <ArticleCount><![CDATA[%s]]></ArticleCount>
                       <Articles>";

        foreach($this->articles as $v)
        {
            $tplXmlStr = $tplXmlStr . $v->toXmlSchema();
            //outText($tplXmlStr);
        }

        $tplXmlStr = $tplXmlStr."</Articles></xml>";
        $tplXmlStr = trim($tplXmlStr);
        $time = time();
        // 回复消息的时候，toUserName是个人用户,FromUserName是平台用户
        $tplXmlStr = sprintf($tplXmlStr,$this->getUser(),$this->getPlatform(), $time, $this->article_count);
//        ob_clean();
////        $fp=fopen("./logs.txt","w+");
////        fwrite($fp,$tplXmlStr,strlen($tplXmlStr));
////        fclose($fp);
        // outText($tplXmlStr);
        echo $tplXmlStr;
        exit;
    }
}
