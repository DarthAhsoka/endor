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
 * 小程序事件菜单
 */
class MiniProgramMenu extends Menu
{

    // 小程序的appid
    protected $_miniAppid;

    // pagepath miniprogram类型必须
    // 小程序的页面路径
    protected $_pagePath;

    /**
     * MiniProgramMenu constructor.
     * @param $name 菜单名字
     * @param $miniAppId 小程序的AppId
     * @param $pagePath  小程序页面路径
     *
     */
    public function __construct($name,$miniAppId = "", $pagePath = "")
    {
        parent::__construct($name);
        $this->_type = "miniprogrma";
        $this->_miniAppid = $miniAppId;
        $this->_pagePath = $pagePath;
    }

    /**
     * @param $miniAppId string 要跳转到的小程序APPID
     */
    public function setMiniAppId($miniAppId)
    {
        $this->_miniAppid = $miniAppId;
    }

    /**
     * @return string
     * 获取要跳转到的小程序的appid
     */
    public function getMiniAppId()
    {
        return $this->_miniAppid;
    }

    /**
     * @param $pagePath string 要跳转到的小程序页面路径
     */
    public function setPagePath($pagePath)
    {
        $this->_pagePath = $pagePath;
    }

    /**
     * @return string
     * 获取要跳转到的小程序的页面路径
     */
    public function getPagePath()
    {
        return $this->_pagePath;
    }

}