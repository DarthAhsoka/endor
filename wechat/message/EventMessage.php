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
 * Class EventMessage
 * 事件消息类
 */
class EventMessage extends Message
{
    # 事件类型
    protected $_eventType;

    public function  __construct($platform, $user, $timestamp, $msgId ,$eventType)
    {
        parent::__construct('event',$timestamp, $msgId);
        $this->setPlatform($platform);
        $this->setUser($user);
        $this->setEventType($eventType);
    }

    public function setEventType($eventType){
        $this->_eventType = $eventType;
    }

    public function getEventType(){
        return $this->_eventType;
    }
}
