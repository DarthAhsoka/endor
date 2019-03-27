<?php
/**
 * Created by Darth-Ahsoka.
 * Author: Darth-Ahsoka  929204168@qq.com
 * Date: 2017/7/16
 * Version: 0.8 beta
 * Last Update: 2019/03/26
 * Update History:
 *      2017/08/17 创建0.7 Alpha 版本
 *      2019/03/26 0.8 beta 优化名字空间
 *                 修改部分函数命名
 *
 */
namespace endor\wechat\pay;

/**
 * Class RequestPay
 * @package endor\wechat\pay
 * 微信支付请求型API
 */
class RequestPay extends PayApi
{
    public function __construct($wxConfigure = null)
    {
        parent::__construct($wxConfigure);
    }

    /**
     * 	作用：设置请求参数
     */
    function setParameter($parameter, $parameterValue)
    {
        $this->parameters[$this->trimString($parameter)] = $this->trimString($parameterValue);
        return  ;
    }

    /**
     * 	作用：设置标配的请求参数，生成签名，生成接口参数xml
     */
    function createXml()
    {
        $appid = $this->_wxConfigure->getParameter("appid");
        $mchid = $this->_wxConfigure->getParameter("mchid");
        $this->parameters["appid"] =  $appid;
        $this->parameters["mch_id"] = $mchid;
        $this->parameters["nonce_str"] = $this->createNoncestr();//随机字符串
        $this->parameters["sign"] = $this->getSign($this->parameters);//签名
        return  $this->arrayToXml($this->parameters);
    }

    /**
     * 	作用：post请求xml
     */
    function postXml()
    {
        $xml = $this->createXml();
        $this->response = $this->postXmlCurl($xml,$this->url,$this->curl_timeout);
        return $this->response;
    }

    /**
     * 	作用：使用证书post请求xml
     */
    function postXmlSSL()
    {
        $xml = $this->createXml();
        $this->response = $this->postXmlSSLCurl($xml,$this->url,$this->curl_timeout);
        return $this->response;
    }

    /**
     * 	作用：获取结果
     */
    function getResult()
    {
        $this->result = $this->xmlToArray($this->response);
        return $this->result;
    }
}
