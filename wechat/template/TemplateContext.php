<?php
/**
 * Created by Darth-Ahsoka.
 * Author: Darth-Ahsoka  929204168@qq.com
 * Date: 2017/7/15
 * Version: 0.8 beta
 * Last Update: 2019/03/24
 * Update History:
 *      2017/08/17 创建0.7 Alpha 版本
 *      2019/03/24 0.8 beta 优化名字空间
 *                 将函数错误返回修改为抛出异常
 *                 返回值结构优化
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
    public $_key;

    /**
     * TData constructor.
     * @param $keywords 关键字
     * @param $value    值
     * @param $color    颜色
     */
    public function __construct($_key,$value,$color="#000000")
    {
        $this->_value = $value;
        $this->_color = $color;
        $this->_key = $_key;
    }

    /**
     * @return string
     * 获取关键字
     */
    public function getKey()
    {
        return $this->_key;
    }

    public function pushArray(&$array)
    {
        $array["{$this->_key}"] = $this->toArray();
    }

    private function toArray()
    {
        return array(
            'value'=>$this->_value,
            'color'=>$this->_color
        );
    }
}
