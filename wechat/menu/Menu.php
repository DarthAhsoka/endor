<?php
/**
 * Created by Darth-Ahsoka.
 * Author: Darth-Ahsoka  929204168@qq.com
 * Date: 2017/7/16
 * Version: 0.8 beta
 * Last Update: 2019/03/25
 * Update History:
 *      2017/08/17 创建0.7 Alpha 版本
 *      2019/03/25 · 0.8 beta 优化名字空间
 *                 · 修改addChild 以便支持连续操操作
 *                 · 添加 getChildByName 接口，以便支持连贯操作后可根据name获取子菜单项
 *
 */
namespace endor\wechat\menu;

/**
 * 微信菜单项基类
 */
class Menu 
{
    // 菜单名字
    protected $_name;

    // 菜单类型.click,view,miniprogram 三种类型
    protected $_type;

    // 调用新增永久素材接口返回的合法media_id
    protected $_media_id;

    // 子菜单结构
    protected $_children = [];

    /**
     * Menu constructor.
     * @param $name 菜单名字
     */
    public function __construct($name)
    {
        $this->_name = $name;
    }

    /**
     * @return string 获取菜单名字
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * @return string 获取菜单类型
     */
    public function getType()
    {
        return $this->_type;
    }

    /**
     * @param $media_id
     * 给菜单绑定永久资源ID
     */
    public function setMediaId($media_id)
    {
        $this->_media_id = $media_id;
    }

    /**
     * @return string
     * 获取菜单绑定的资源id
     */
    public function getMediaId()
    {
        return $this->_media_id;
    }

    /**
     * @param $menuItem Menu 子菜单项
     * @return $this
     * 给当前菜单添加子菜单
     */
    public function addChild($menuItem)
    {
        array_push($this->_children,$menuItem);
        return $this;
    }

    public function getChildByName($name)
    {
        $obj = null;
        foreach($this->_children as $v)
        {
            if($v->getName() === $name)
            {
                $obj = $v;
                break;
            }
        }
        return $obj;
    }

    /**
     * @return array
     * 获取所有子菜单
     */
    public function getChildren()
    {
        return $this->_children;
    }

    /**
     * @return int
     * 获取子菜单个数
     */
    public function getChildrenLength()
    {
        return count($this->_children);
    }

    /**
     * @return bool
     * 是否存在子菜单，返回true，为存在，否则不存在
     */
    public function hasChildren()
    {
        return count($this->_children) !== 0;
    }
}