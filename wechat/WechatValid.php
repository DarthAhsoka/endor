<?php
/**
 * Created by Darth-Ahsoka.
 * Author: Darth-Ahsoka  929204168@qq.com
 * Date: 2017/7/14
 * Version: 0.8 beta
 * Last Update: 2019/03/24
 * Update History:
 *      2017/08/17 创建0.7 Alpha 版本
 *      2019/03/24 0.8 beta 优化名字空间
 */
namespace endor\wechat;

class WechatValid
{
    private $_wxConfigure;

    /**
     * WechatValid constructor.
     * @param $wxConfigure object 微信配置参数
     */
    public function __construct($wxConfigure)
    {
        $this->_wxConfigure = $wxConfigure;
    }

    /**
     * valid
     * 微信验证接口
     */
    public function valid(){
        $echoStr = $_GET["echostr"];
        if($this->checkSignature()){
            ob_clean();
            echo $echoStr;
            exit;
        }
    }

    /**
     * @return bool
     * 微信验证
     */
    private function checkSignature()
    {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        $token = $this->_wxConfigure->getParameter("validate_token");
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );
        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }
}