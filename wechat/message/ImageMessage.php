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
/**
 * Class MessagesAPI
 * 图片消息类
 */
class ImageMessage extends Message
{
    # 图片消息连接,当 $_msgType == images 时启用
    private $_imgUrl;
    private $_mediaId;

    public function  __construct($platform, $user, $timestamp, $msgId ,$url,$_mediaId)
    {
        parent::__construct("image", $sender, $receiver, $timestamp, $msgId);
        $this->_imgUrl =$url;
        $this->_mediaId=$_mediaId;
    }

    public function getImageUrl() {
        return $this->_imgUrl;
    }

    public function getMediaId() {
        return $this->_mediaId;
    }

    public function setMediaId($mediaId) {
        $this->_mediaId = $mediaId;
    }

    public function setImageUrl($url) {
        $this->_imgUrl = $url;
    }

    public function response() {
        $tplXmlStr =  "<xml>
                       <ToUserName><![CDATA[%s]]></ToUserName>
                       <FromUserName><![CDATA[%s]]></FromUserName>
                       <CreateTime>%s</CreateTime>
                       <MsgType><![CDATA[image]]></MsgType>
                       <Content><![CDATA[%s]]></Content>
                       </xml>";
        $tplXmlStr = trim($tplXmlStr);
        $time = time();
        $tplXmlStr = sprintf($tplXmlStr,$this->getUser(),$this->getPlatForm(), $time, $this->getContent());
        echo $tplXmlStr;
    }
}
