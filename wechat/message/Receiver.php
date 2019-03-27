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
 *
 */
namespace endor\wechat\message;
use endor\wechat\WechatCommon;
use endor\wechat\message\SubscribeEventMessage;
use endor\wechat\message\UnSubscribeEventMessage;
use endor\wechat\message\TemplateSendJobFinishEventMessage;
use endor\wechat\message\ClickEventMessage;
use endor\wechat\message\LocationEventMessage;

class Receiver extends WechatCommon
{
    // 其他消息
    const TEXT = "TEXT";
    // 事件:扫描二维码
    const EVENT_SCAN = 'SCAN';
    // 事件:上报地理位置
    const EVENT_LOCATION = 'LOCATION';
    // 事件：订阅
    const EVENT_SUBSCRIBE = 'subscribe';
    // 事件：取消订阅
    const EVENT_UNSUBSCRIBE = 'unsubscribe';
    // 事件：CLICK菜单点击
    const EVENT_CLICK = "CLICK";
    // 事件：Enter进入事件
    const EVENT_ENTER = "ENTER";
    // 时间：模板消息回调
    const EVENT_TEMPLATE_SENDJOBFINISH = "TEMPLATESENDJOBFINISH";
    // 图文消息
    const IMAGE ="image";

    # 事件监听
    protected static $_eventArr = [];

    public function __construct($wxConfigure = null)
    {
        parent::__construct($wxConfigure);

    }

    // 对事件进行监听注册
    public function addEventListener($eventName,$eventCallback) {
        if(isset(self::$_eventArr["{$eventName}"])){
            // 如果存在，则不需要再次注册
            return ;
        }
        else {
            self::$_eventArr["{$eventName}"] = $eventCallback;
        }
    }

    public function removeEventListener($eventName){
        if(isset(self::$_eventArr["{$eventName}"]))
            unset(self::$_eventArr["{$eventName}"]);
    }


    /**
     * 接收消息
     */
    public function receiver()
    {
        return $this->receiverMsg();
    }


    /**
     * 监视回调，如果没有添加，则不会执行回调操作
     */
    private function receiverMsg()
    {
        $msg = $this->getMessage();
        $_call = "";
        $key = "";

        if($msg && $msg->getType() == "text")
        {
            $key = self::TEXT;
        }
        if($msg && $msg->getType() == "image")
        {
            $key = self::IMAGE;
        }
        else if($msg && $msg->getType() == "event")
        {
            // event 事件需要特殊回调
            $eventType = $msg->getEventType();
            $_call = null;
            if($eventType == "subscribe"){
                $_call = null;
                $key = self::EVENT_SUBSCRIBE;
            }
            else if($eventType == "unsubscribe")
            {
                $key = self::EVENT_UNSUBSCRIBE;
            }
            else if($eventType == "ENTER")
            {
                $key = self::EVENT_ENTER;
            }
            else if($eventType == "CLICK")
            {
                $key = self::EVENT_CLICK;
            }
            else if($eventType == "LOCATION")
            {
                $key = self::EVENT_LOCATION;
            }
            else if($eventType == "SCAN")
            {
                $key = self::EVENT_SCAN;
            }
            else if($eventType == "TEMPLATESENDJOBFINISH")
            {
                $key = self::EVENT_TEMPLATE_SENDJOBFINISH;
            }

        }

        if(isset(self::$_eventArr["{$key}"])){
            $_call = self::$_eventArr["{$key}"];
        }

        if(isset($_call) && is_callable($_call)){
            call_user_func_array($_call, [$msg]);
        }
    }

    private function getMessage() {
        // PHP7 移除了HTTP_RAW_POST_DATA;
        $data = file_get_contents("php://input");
        if(!empty($data)){
            $xmlObj = simplexml_load_string($data,'SimpleXMLElement');
            // 构造消息
            if($xmlObj->MsgType == "text"){
                // 接收消息:from是用户，to是平台
                return new TextMessage($xmlObj->ToUserName,$xmlObj->FromUserName,$xmlObj->CreateTime,$xmlObj->MsgId,$xmlObj->Content);
            }
            else if($xmlObj->MsgType == "image") {
                // 图片是否保存本地
                if(isset($this->_wxConfigure)){
                    if($this->_wxConfigure->getParameter('wx.message.saveImage')){
                        // 需要保存图片到本地服务器
                        $this->saveFiles($xmlObj->PicUrl);
                    }
                }
                return new ImageMessage($xmlObj->FromUserName,$xmlObj->ToUserName,
                    $xmlObj->CreateTime,$xmlObj->MsgId,$xmlObj->PicUrl,$xmlObj->MediaId);
            }
            else if($xmlObj->MsgType == "event"){
                // 事件消息
                // 得判断是什么事件
                if(strtolower($xmlObj->Event) == "subscribe")
                    return new SubscribeEventMessage($xmlObj->ToUserName,$xmlObj->FromUserName,$xmlObj->CreateTime,$xmlObj->MsgId,$xmlObj->Event);
                else if(strtolower($xmlObj->Event) == "unsubscribe")
                    return new UnSubscribeEventMessage($xmlObj->ToUserName,$xmlObj->FromUserName,$xmlObj->CreateTime,$xmlObj->MsgId,$xmlObj->Event);
                else if(strtolower($xmlObj->Event) == "templatesendjobfinish")
                {
                    $obj=new TemplateSendJobFinishEventMessage($xmlObj->ToUserName,$xmlObj->FromUserName,$xmlObj->CreateTime,$xmlObj->MsgId,$xmlObj->Event);
                    $obj->setStatus($xmlObj->Status);
                    return $obj;
                }
                else if(strtolower($xmlObj->Event) == "click")
                {
                    $obj=new ClickEventMessage($xmlObj->ToUserName,$xmlObj->FromUserName,$xmlObj->CreateTime,$xmlObj->MsgId,$xmlObj->Event);
                    $obj->setEventKey($xmlObj->EventKey);
                    return $obj;
                }
                else if(strtolower($xmlObj->Event) == "location")
                {

                }
                return null;
            }
        }
        return null;
    }
}
