<?php
/**
 * Created by Darth-Ahsoka.
 * Author: Darth-Ahsoka  929204168@qq.com
 * Date: 2017/7/16
 * Version: 0.8 beta
 * Last Update: 2019/03/25
 * Update History:
 *      2017/08/17 创建0.7 Alpha 版本
 *      2019/03/25 0.8 beta 优化名字空间，修改构造函数参数
 *
 */
namespace endor\wechat\menu;

/**
 * click 事件菜单
 */
class ViewMenu extends Menu

{

    // 网页链接，用户点击菜单可打开链接，不超过1024字节。
    // type为miniprogram时，不支持小程序的老版本客户端将打开本url。
    protected $_url;

    /**
     * ViewMenu constructor.
     * @param $name 菜单名字
     * @param $url 跳转地址
     */
    public function __construct($name,$url = "")
    {
        parent::__construct($name);
        $this->_type = "view";
        $this->_url = $url;
    }

    /**
     * @param $url string
     * 设置要跳转的URL
     */
    public function setUrl($url)
    {
        $this->_url=$url;
    }

    /**
     * @return string
     * 获取URL
     */
    public function getUrl()
    {
        return $this->_url;
    }
}