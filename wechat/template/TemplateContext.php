<?php
/**
 * Created by PhpStorm.
 * User: Mianyang Kamino S&T Co,Ltd @ ahsoka:929204168
 * Date: 2017/7/14
 * Time: 18:00
 * Version: 0.7 Alpha
 * Last Update: 2017/07/20
 * Update History:
 *      2017/07/20  创建0.7 Alpha 版本
 */

namespace endor\wechat\template;

/**
 * 微信公众号模板消息上下文结构
 */
class TemplateContext
{
    // 值
    public $_value ;
    // 颜色
    public $_color ;
    // 关键字
    public $_keywords;

    /**
     * TData constructor.
     * @param $keywords 关键字
     * @param $value    值
     * @param $color    颜色
     */
    public function __construct($keywords,$value,$color="#000000")
    {
        $this->_value = $value;
        $this->_color = $color;
        $this->_keywords = $keywords;
    }

    // 转换成数组
    public function toArray()
    {
        return array(
            'value'=>$this->_value,
            'color'=>$this->_color
        );
    }

    /**
     * @return string
     * 获取关键字
     */
    public function getKeywords()
    {
        return $this->_keywords;
    }

    public function pushArray(&$array)
    {
        $array["{$this->_keywords}"] = $this->toArray();
    }
}
