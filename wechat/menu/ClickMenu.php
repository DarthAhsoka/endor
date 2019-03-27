<?php
/**
 * Created by Darth-Ahsoka.
 * Author: Darth-Ahsoka  929204168@qq.com
 * Date: 2017/7/16
 * Version: 0.8 beta
 * Last Update: 2019/03/25
 * Update History:
 *      2017/08/17 创建0.7 Alpha 版本
 *      2019/03/25 0.8 beta 优化名字空间
 *
 */
namespace endor\wechat\menu;

/**
 * click事件菜单
 */
class ClickMenu extends Menu
{

    // 菜单KEY值，用于消息接口推送，不超过128字节
    // click等点击类型必须
    protected $_key;

    /**
     * ClickMenu constructor.
     * @param $name string  菜单名字
     * @param $key  string  推送事件的key值
     */
    public function __construct($name,$key = "")
    {
        parent::__construct($name);
        $this->_type = "click";
        $this->_key = $key;
    }

    /**
     * @param $key
     * 设置菜单KEY值
     */
    public function setKey($key)
    {
        $this->_key = $key;
    }

    /**
     * @return string
     * 获取菜单key值
     */
    public function getKey()
    {
        return $this->_key;
    }

}