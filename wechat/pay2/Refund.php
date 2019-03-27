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

use endor\wechat\WechatException;

/**
 * Class Refund
 * @package endor\wechat\pay;
 * 微信支付退款请求
 */
class Refund extends RequestPay
{
    const REFUND_REQUESTURL = "https://api.mch.weixin.qq.com/secapi/pay/refund";
    public function __construct($wxConfigure = null)
    {
        parent::__construct($wxConfigure);
        $this->url = self::REFUND_REQUESTURL;
        $this->curl_timeout = $this->_wxConfigure->getParameter("timeout");
    }

    /**
     * 生成接口参数xml
     */
    function createXml()
    {
        //检测必填参数
        if($this->parameters["out_trade_no"] == null && $this->parameters["transaction_id"] == null) {
            throw new WechatException("退款申请接口中，out_trade_no、transaction_id至少填一个！"."<br>");
        }elseif($this->parameters["out_refund_no"] == null){
            throw new WechatException("退款申请接口中，缺少必填参数out_refund_no！"."<br>");
        }elseif($this->parameters["total_fee"] == null){
            throw new WechatException("退款申请接口中，缺少必填参数total_fee！"."<br>");
        }elseif($this->parameters["refund_fee"] == null){
            throw new WechatException("退款申请接口中，缺少必填参数refund_fee！"."<br>");
        }elseif($this->parameters["op_user_id"] == null){
            throw new WechatException("退款申请接口中，缺少必填参数op_user_id！"."<br>");
        }
        $appid = $this->_wxConfigure->getParameter("appid");
        $mchid = $this->_wxConfigure->getParameter("mchid");
        $this->parameters["appid"] = $appid;//公众账号ID
        $this->parameters["mch_id"] = $mchid;//商户号
        $this->parameters["nonce_str"] = $this->createNoncestr();//随机字符串
        $this->parameters["sign"] = $this->getSign($this->parameters);//签名
        return  $this->arrayToXml($this->parameters);
    }

}