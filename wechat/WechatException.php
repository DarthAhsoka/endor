<?php
/**
 * Created by Darth-Ahsoka.
 * Author: Darth-Ahsoka  929204168@qq.com
 * Date: 2019/03/25
 * Version: 0.8 beta
 * Last Update: 2019/03/24
 * Update History:
 *      2019/03/25 0.8 beta 创建
 */
namespace endor\wechat;

/**
 * Class WechatException
 * @package endor\wechat
 * 微信公众号接口异常类
 */
class WechatException extends \Exception
{
    /**
     * Prettify error message output.
     *
     * @return string
     */
    public function errorMessage()
    {
        return '<strong>' . htmlspecialchars($this->getMessage()) . "</strong><br />\n";
    }
}