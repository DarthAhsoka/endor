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
 * 地理坐标事件消息类
 */
class LocationEventMessage extends EventMessage
{
    # 如果是 LOCATION事件，这三个参数分别是 纬度，经度和精度
    protected $_latitude;
    protected $_longitude;
    protected $_precision;

    public function __construct($platform, $user, $timestamp, $msgId, $eventType)
    {
        parent::__construct($platform, $user, $timestamp, $msgId, $eventType);
    }

    /**
     * @param $lat 纬度
     * @param $lng 经度
     * @param $pre 精度
     */
    public function setLocation($lat,$lng,$pre)
    {
        $this->_latitude  = $lat;
        $this->_longitude = $lng;
        $this->_precision = $pre;
    }

    /**
     * @return array 获取地址位置坐标
     */
    public function getLocation()
    {
        return [
            'latitude' => $this->_latitude,
            'longitude'=> $this->_longitude,
            'precision'=> $this->_precision
        ];
    }
}