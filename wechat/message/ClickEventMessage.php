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
 * 点击菜单事件消息类
 */
class ClickEventMessage extends EventMessage
{
    protected $_eventKey;

    public function __construct($platform, $user, $timestamp, $msgId, $eventType)
    {
        parent::__construct($platform, $user, $timestamp, $msgId, $eventType);
    }

    public function getEventKey()
    {
        return $this->_eventKey;
    }

    public function setEventKey($eventKey)
    {
        $this->_eventKey = $eventKey;
    }
}