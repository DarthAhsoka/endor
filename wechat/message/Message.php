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
 * Class Messages
 * @package endor\wechat\message
 * 微信消息结构基类
 */
class Message
{
    # 消息类型
    protected $_msgType;

    # 公众号平台
    protected $_platform;

    # 用户
    protected $_user;

    # 消息生成时间
    protected $_timestamp;

    # 消息ID
    protected $_msgID;

    /**
     * Message constructor.
     * @param $msgType   消息类型
     * @param $timestamp 时间戳
     * @param $msgId     消息ID
     */
    public function __construct($msgType,$timestamp,$msgId)
    {
        $this->_msgID = $msgId;
        $this->_timestamp= $timestamp;
        $this->_msgType = $msgType;
    }

    /**
     * @param $platform 设置微信公众号平台ID
     */
    public function setPlatform($platform){
        $this->_platform = $platform;
    }

    /**
     * @return string 获取微信公众号平台ID
     */
    public function getPlatform() {
        return $this->_platform;
    }

    /**
     * @return string 获取消息类型
     */
    public function getType() {
        return $this->_msgType;
    }

    /**
     * @param $user stirng 设置用户的ID
     */
    public function setUser($user){
        $this->_user = $user;
    }

    /**
     * @return string 获取用户的ID
     */
    public function getUser(){
        return $this->_user;
    }


    /**
     * @return int 获取时间戳
     */
    public function getTimestamp(){
        return $this->_timestamp;
    }

    /**
     * @return string 获取消息ID
     */
    public function getMsgId() {
        return $this->_msgID;
    }
}
