<?php
/**
 * Created by Darth-Ahsoka.
 * Author: Darth-Ahsoka  929204168@qq.com
 * Date: 2017/7/14
 * Version: 0.8 beta
 * Last Update: 2019/03/24
 * Update History:
 *      2017/08/17 创建0.7 Alpha 版本
 *      2019/03/24 0.8 beta  优化名字空间
 */
namespace endor\wechat\menu;
use endor\wechat\WechatCommon;
use endor\wechat\WechatException;

class MenuApi extends WechatCommon
{
    const WECHAT_MENU_CREATE = "https://api.weixin.qq.com/cgi-bin/menu/create";
    const WECHAT_MENU_DELETE = "https://api.weixin.qq.com/cgi-bin/menu/delete";
    const WECHAT_MENU_GET = "https://api.weixin.qq.com/cgi-bin/menu/get";

    // 菜单数组
    protected $_menuMaps = [];

    public function __construct($wxConfigure = null)
    {
        parent::__construct($wxConfigure);
    }

    // 添加菜单项目
    public function addMenuItem(&$meunItem,$parent=null)
    {
        if($parent == null){
            // 如果没有父类，则说明自己是一级菜单
            if(count($this->_menuMaps) == 3)
                return 0;
            return array_push($this->_menuMaps,$meunItem);
        }
        else
        {
            // 有父类，说明是子菜单（二级菜单）
            return $parent->addChild($meunItem);
        }
    }

    // 生成菜单
    public function create()
    {
        $menuData = $this->generatorMenuJson();
        // 拼接地址:
        $access_token =$this->_wxConfigure->getParameter("access_token");
        $url = self::WECHAT_MENU_CREATE."?access_token=".$access_token;
        $results = $this->_post($url,$createJson);
        return json_decode($results,false);
    }

    // 获取菜单
    public function get()
    {
        // 获取菜单
        // 构造URL
        $access_token =$this->_wxConfigure->getParameter("access_token");
        $url = self::WECHAT_MENU_GET."?access_token=".$access_token;
        $results = $this->_post($url,"");
        $objArr = json_decode   ($results,true);
        if(isset($objArr['errcode']) && $objArr['errcode'] !== 0)
        {
            throw new WechatException( $objArr['errmsg'], $objArr['errcode']);
            return ;
        }
        if(is_array($objArr))
        {
            // 解析菜单
            $this->parseMenu($objArr['menu']['button']);
        }
        return true;
    }

    // 删除微信菜单
    public function delete()
    {
        $access_token =$this->_wxConfigure->getParameter("access_token");
        $url = self::WECHAT_MENU_DELETE."?access_token=".$access_token;
        $results = $this->_post($url,"");
    }

    // 获取菜单本地数据
    public function getMenu()
    {
        return $this->_menuMaps;
    }

    // 删除本地菜单
    public function clearMenu()
    {
        $this->$_menuMaps = [];
    }


    private function generatorMenuJson()
    {
        // 创建JSON数组
        $menuDataArr['button'] = array();
        foreach($this->_menuMaps as $k=>$v)
        {
            $menuItem = [];
            // 第一次遍历一级菜单
            // 首先判断是否有子菜单，如果没有子菜单，则是独立菜单
            // 如果有子菜单，说明是一个分支主菜单
            if($v->hasChildren())
            {
                $menuItem["name"] = $v->getName();
                $menuItem["sub_button"] = array();
                // 遍历子(二级)菜单
                foreach($v->getChildren() as $v)
                {
                    array_push($menuItem["sub_button"],$this->constructionMenuArr($v));
                }
            }
            else
            {
                $menuItem = $this->constructionMenuArr($v);
            }

            array_push($menuDataArr['button'],$menuItem);

        }
        // 这里必须添加JSON_UNESCAPED_UNICODE，中文不进行UNICODE编码
        $createJson =  json_encode($menuDataArr,JSON_UNESCAPED_UNICODE);
        return $createJson;
    }

    private function constructionMenuArr($menuItem)
    {
        if($menuItem->getType() == "click")
        {
            return [
                "type"=>"click",
                "name"=>$menuItem->getName(),
                "key" =>$menuItem->getKey()
            ];
        }
        else if($menuItem->getType() == "view")
        {
            return [
                "type"=>"view",
                "name"=>$menuItem->getName(),
                "url" =>$menuItem->getUrl()
            ];
        }
        else if($menuItem->getType() == "miniprogram")
        {
        
        }

        return "";
    }

    /**
     * @param $menuArr
     * 将微信菜单解析为对象数组
     */
    private function parseMenu($menuArr)
    {
        $_menuMaps = [];
        // 每一次大foreach，解析一级菜单，如果sub_button存在，则进入
        // 内层foreach，解析二级菜单
        foreach($menuArr as $key=>$value)
        {
            $parentMenu = null;
            if($value['type'] == "click")
            {
                $parentMenu = new ClickMenu($value['name']);
                isset($value['key']) && $parentMenu->setKey($value['key']);
            }
            else if($value['type'] == "view")
            {
                $parentMenu = new ViewMenu($value['name']);
                isset($value['url']) && $parentMenu->setUrl($value['url']);
            }
            else
            {
                $parentMenu = new ClickMenu($value['name']);
                isset($value['key']) && $parentMenu->setKey($value['key']);
            }

            $parentMenu = new ClickMenu($value['name']);
            if(isset($value['sub_button']) && is_array($value['sub_button']))
            {
                foreach($value['sub_button'] as $sec => $item)
                {
                    if($item['type'] === "view")
                    {
                        $sub = new ViewMenu($item['name']);
                        $sub->setUrl($item['url']);
                    }
                    else if($item['type'] === "click")
                    {
                        $sub = new ClickMenu($item['name']);
                        $sub->setKey($item['key']);
                    }
                    else if($item['type'] === "miniprogram" )
                    {
                        $sub = new MiniProgramMenu($item['name']);
                        $sub->setMiniAppId($item['appId']);
                        $sub->setPagePath($item['pagePath']);
                    }

                    $parentMenu->addChild($sub);
                }

                array_push($this->_menuMaps,$parentMenu);
            }
        }
    }
}
