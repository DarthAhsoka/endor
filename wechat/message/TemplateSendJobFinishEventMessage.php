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
 * 模板消息送达回调事件
 */
class TemplateSendJobFinishEventMessage extends EventMessage
{
    # 送达状态
    protected $_status;

    public function __construct($plateForm, $user, $timestamp, $msgId, $eventType)
    {
        parent::__construct($plateForm, $user, $timestamp, $msgId, $eventType);
    }

    /**
     * @param $status string 设置送达状态
     */
    public function setStatus($status)
    {
        $this->_status = $status;
    }

    /**
     * @return mixed 获取送达状态
     */
    public function getStatus()
    {
        return $this->_status;
    }

}