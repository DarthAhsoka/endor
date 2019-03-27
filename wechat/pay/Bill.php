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
 * Class DownloadBill
 * @package endor\wechat\pay;
 * 微信对账单接口
 */
class Bill extends RequestPay
{
    const DOWNLOAD_BILL_REQUESTURI = "https://api.mch.weixin.qq.com/pay/downloadbill";

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
        try
        {
            if($this->parameters["bill_date"] == null )
            {
                throw new WechatException("对账单接口中，缺少必填参数bill_date！"."<br>");
            }
            $appid = $this->_wxConfigure->getParameter("appid");
            $mchid = $this->_wxConfigure->getParameter("mchid");
            $this->parameters["appid"] = $appid;//公众账号ID
            $this->parameters["mch_id"] = $mchid;//商户号
            $this->parameters["nonce_str"] = $this->createNoncestr();//随机字符串
            $this->parameters["sign"] = $this->getSign($this->parameters);//签名
            return  $this->arrayToXml($this->parameters);
        }catch (WxRuntimeException $e)
        {
            die($e->errorMessage());
        }
    }

}