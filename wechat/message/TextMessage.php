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
 *      优化部分函数命名
 *
 */
namespace endor\wechat\message;

class TextMessage extends Message
{
    # 文本消息内容,当 $_msgType == text 时启用
    protected $_content;

    /**
     * TextMessage constructor.
     * @param $platform string 微信公众号ID
     * @param $user     string 用户ID
     * @param $timestamp int 时间戳
     * @param $msgId     string 消息ID
     * @param $content   string 文本消息内容
     */
    public function  __construct($platform, $user, $timestamp, $msgId ,$content)
    {
        parent::__construct('text',$timestamp, $msgId);
        $this->setPlatform($platform);
        $this->setUser($user);
        $this->_content=$content;
    }

    /**
     * @return string 获取内容
     */
    public function getContent() {
        return $this->_content;
    }

    /**
     * @param $content string 设置消息内容
     */
    public function setContent($content) {
        $this->_content = $content;
    }

    /**
     * 消息回复
     */
    public function response() {
        $tplXmlStr =  "<xml>
                       <ToUserName><![CDATA[%s]]></ToUserName>
                       <FromUserName><![CDATA[%s]]></FromUserName>
                       <CreateTime>%s</CreateTime>
                       <MsgType><![CDATA[text]]></MsgType>
                       <Content><![CDATA[%s]]></Content>
                       </xml>";
        $tplXmlStr = trim($tplXmlStr);
        $time = time();
        // 回复消息的时候，toUserName是个人用户,FromUserName是平台用户
        $tplXmlStr = sprintf($tplXmlStr,$this->getUser(),$this->getPlatForm(), $time, $this->getContent());
        ob_clean();
        echo $tplXmlStr;
        exit;
    }
}
