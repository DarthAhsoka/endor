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
use endor\wechat\message\EventMessage;
/**
 * Class SubscribeEventMessage
 * 关注事件消息类
 */
class SubscribeEventMessage extends EventMessage
{
    public function __construct($platform, $user, $timestamp, $msgId, $eventType)
    {
        parent::__construct($platform, $user, $timestamp, $msgId, $eventType);
    }
}