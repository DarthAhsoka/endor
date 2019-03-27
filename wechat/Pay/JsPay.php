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
use endor\wechat\pay\PayApi;

/**
 * Class JsPay
 * @package endor\wechat\pay\PayApi;
 * Js 支付接口
 */
class JsPay extends RequestPay
{
    const WECHAT_GET_OAUTHCODE = "https://open.weixin.qq.com/connect/oauth2/authorize";
    const WECHAT_GET_OATUHOPENID = "https://api.weixin.qq.com/sns/oauth2/access_token"; //openid

    //code码，用以获取openid
    protected $code;
    //用户的openid
    protected $openid;
    //使用统一支付接口得到的预支付id
    protected $prepay_id;

    function __construct($wxConfigure = null)
    {
        parent::__construct($wxConfigure);
        $this->url = self::WECHAT_GET_OAUTHCODE;
        $this->curl_timeout = $this->_wxConfigure->getParameter("timeout");
    }

    /**
     * 	作用：生成可以获得code的url
     *  这里和静默登录所用的OAuth认证不一样
     *  不能混用
     */
    function createOauthUrlForCode($redirectUrl)
    {
        $urlObj["appid"] = $this->_wxConfigure->getParameter("appid");
        $urlObj["redirect_uri"] = "{$redirectUrl}";
        $urlObj["response_type"] = "code";
        $urlObj["scope"] = "snsapi_base";
        $urlObj["state"] = "STATE"."#wechat_redirect";
        $bizString = $this->formatBizQueryParaMap($urlObj, false);
        return self::WECHAT_GET_OAUTHCODE . "?".$bizString;
    }

    /**
     * 	作用：生成可以获得openid的url
     */
    function createOauthUrlForOpenid()
    {
        $urlObj["appid"] = $this->_wxConfigure->getParameter("appid");
        $urlObj["secret"] = $this->_wxConfigure->getParameter("appsecret");
        $urlObj["code"] = $this->code;
        $urlObj["grant_type"] = "authorization_code";
        $bizString = $this->formatBizQueryParaMap($urlObj, false);
        return self::WECHAT_GET_OATUHOPENID."?".$bizString;
    }

    /**
     * 	作用：通过curl向微信提交code，以获取openid
     */
    function getOpenid()
    {
        $url = $this->createOauthUrlForOpenid();
        //初始化curl
        $ch = curl_init();
        //设置超时
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->curl_timeout);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        //运行curl，结果以jason形式返回
        $res = curl_exec($ch);
        curl_close($ch);
        //取出openid
        $data = json_decode($res,true);
        if(isset($data['openid']) && !empty($data['openid']))
        {
            $this->openid = $data['openid'];
            return $this->openid;
        }
        return null;
    }

    /**
     * 	作用：设置prepay_id
     */
    function setPrepayId($prepayId)
    {
        $this->prepay_id = $prepayId;
    }

    /**
     * 	作用：设置code
     */
    function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * 	作用：设置jsapi的参数
     */
    public function getParameters()
    {
        $jsApiObj["appId"] =  $this->_wxConfigure->getParameter("appid");
        $timeStamp = time();
        $jsApiObj["timeStamp"] = "$timeStamp";
        $jsApiObj["nonceStr"] = $this->createNoncestr();
        $jsApiObj["package"] = "prepay_id={$this->prepay_id}";
        $jsApiObj["signType"] = "MD5";
        $jsApiObj["paySign"] = $this->getSign($jsApiObj);
        $this->parameters = json_encode($jsApiObj);
        return $this->parameters;
    }
}