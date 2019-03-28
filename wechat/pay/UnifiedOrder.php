<?php
/**
 * Created by Darth-Ahsoka.
 * Author: Darth-Ahsoka  929204168@qq.com
 * Date: 2017/7/16
 * Version: 0.8 beta
 * Last Update: 2019/03/26
 * Update History:
 *      2017/08/17 创建0.7 Alpha 版本
 *      2019/03/27 0.8 beta 优化名字空间
 *                 优化类继承体系
 *
 */
namespace endor\wechat\pay;
use endor\wechat\pay\RequestPay;
use endor\wechat\WechatException;

/**
 * Class UnifiedOrder
 * @package Kendor\wechat\pay;
 * 微信统一下单请求接口
 */
class UnifiedOrder extends RequestPay
{
    const UNIFORM_ORDER_REQUESTURI = "https://api.mch.weixin.qq.com/pay/unifiedorder";

    function __construct($wxConfigure = null)
    {
        parent::__construct($wxConfigure);
        $this->url = self::UNIFORM_ORDER_REQUESTURI;
        $this->curl_timeout = $this->_wxConfigure->getParameter("timeout");
    }

    /**
     * 生成接口参数xml
     */
    function createXml()
    {
        //检测必填参数
        if($this->parameters["out_trade_no"] == null)
        {
            throw new WechatException("缺少统一支付接口必填参数out_trade_no！"."<br>");
        }elseif($this->parameters["body"] == null){
            throw new WechatException("缺少统一支付接口必填参数body！"."<br>");
        }elseif ($this->parameters["total_fee"] == null ) {
            throw new WechatException("缺少统一支付接口必填参数total_fee！"."<br>");
        }elseif ($this->parameters["notify_url"] == null) {
            throw new WechatException("缺少统一支付接口必填参数notify_url！"."<br>");
        }elseif ($this->parameters["trade_type"] == null) {
            throw new WechatException("缺少统一支付接口必填参数trade_type！"."<br>");
        }elseif ($this->parameters["trade_type"] == "JSAPI" &&
            $this->parameters["openid"] == NULL){
            throw new WechatException("统一支付接口中，缺少必填参数openid！trade_type为JSAPI时，openid为必填参数！"."<br>");
        }

        $appid = $this->_wxConfigure->getParameter("appid");
        $mchid = $this->_wxConfigure->getParameter("mchid");

        $this->parameters["appid"]  = $appid;//公众账号ID
        $this->parameters["mch_id"] = $mchid;//商户号
        $this->parameters["spbill_create_ip"] = $_SERVER['REMOTE_ADDR'];//终端ip
        $this->parameters["nonce_str"] = $this->createNoncestr();//随机字符串
        $this->parameters["sign"] = $this->getSign($this->parameters);//签名
        return  $this->arrayToXml($this->parameters);
    }

    /**
     * 获取prepay_id
     */
    function getPrepayId()
    {
        $this->postXml();
        $this->result = $this->xmlToArray($this->response);
        $prepay_id = $this->result["prepay_id"];
        return $prepay_id;
    }

}