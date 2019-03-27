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
namespace endor\wechat\server;
use endor\wechat\WechatCommon;
use endor\wechat\WechatException;

/**
 * Class WechatServerApi
 * @package endor\wechat\server;
 * 微信公众平台服务端基础接口，主要用于获取API令牌和JS API令牌等
 */
class WechatServerApi extends  WechatCommon
{
    const WECHAT_GET_ACCESSTOKEN = "https://api.weixin.qq.com/cgi-bin/token";
    const WECHAT_GET_SERVERIPADDRESS = "https://api.weixin.qq.com/cgi-bin/getcallbackip";
    const WECHAT_GET_JSAPITICKET = "https://api.weixin.qq.com/cgi-bin/ticket/getticket";

    public function __construct(&$wxConfigure)
    {
        parent::__construct($wxConfigure);
    }

    /**
     * 获取access_token,全局access_token,
     * 该 access_token 用于部分接口请求的权限
     *
     * @return mixed
     * @throws WechatException
     */
    public function getAccessToken()
    {
        // 构造 CURL 请求
        $err="";
        $appid = $this->_wxConfigure->getParameter("appid");
        $appsecret = $this->_wxConfigure->getParameter("appsecret");

        if(!isset($appid) || strlen($appid) == 0 ){
            $errno = "40013";
            $err="appid 没有填写，请检查";
            throw new WechatException($err,$errno);
        }

        if(!isset($appsecret) || strlen($appsecret) == 0)
        {
            $errno = "40125";
            $err="appsecret 没有填写，请检查";
            throw new WechatException($err,$errno);
        }

        $url = self::WECHAT_GET_ACCESSTOKEN."?grant_type=client_credential&appid=".$appid."&secret=".$appsecret;
        $result = $this->_get($url);
        $msg = json_decode($result,true);
        if(isset($msg['errcode']) && $msg['errcode'] !== 0 )
        {
            throw new WechatException($msg['errmsg'],$msg['errcode']);
        }
        return $msg;
    }


    /**
     *
     *  通过 $access_token 获取到 jsapi 所需要的 Jsapi Ticket
     *  jsapi Ticket 次数有限，也需要全局保存，时间和access_token
     *  类似
     * @param $access_token   全局 access_token
     * @return mixed
     * @throws WechatException
     *
     */
    public function getWechatJsapiTicket()
    {
        $access_token = $this->_wxConfigure->getParameter("access_token");
        if(!isset($access_token) || strlen($access_token) == 0 ){
            $errno = "40013";
            $err="access_token 没有填写，请检查";
            throw new WechatException($err,$errno);
        }

        $url = self::WECHAT_GET_JSAPITICKET."?access_token=".$access_token."&type=jsapi";
        $result = $this->_get($url);
        $msg = json_decode($result,true);
        if(isset($msg['errcode']) && $msg['errcode'] !== 0 )
        {
            throw new WechatException($msg['errmsg'],$msg['errcode']);
        }

        return ['ticket'=>$msg['ticket'], 'expires_in'=>$msg['expires_in']];
    }

    /**
     *  JS API 签名
     */
    public function getJsApiSign()
    {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $timestamp = time();
        $nonceStr = $this->createNonceStr();

        $appid = $this->_wxConfigure->getParameter("appid");
        $jsApiTicket = $this->_wxConfigure->getParameter("jsapi_ticket");

        if(!isset($appid) || strlen($appid) == 0 ){
            $errno = "40013";
            $err="appid 没有填写，请检查";
            throw new WechatException($err,$errno);
        }

        if(!isset($jsApiTicket) || strlen($jsApiTicket) == 0 ){
            $errno = "-1";
            $err="js api ticket 不能为空";
            throw new WechatException($err,$errno);
        }
        
        // 这里参数的顺序要按照 key 值 ASCII 码升序排序
        $string = "jsapi_ticket=$jsApiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";
        $signature = sha1($string);
        $signPackage = array(
            "appId"     => $this->_wxConfigure->getParameter("appid"),
            "nonceStr"  => $nonceStr,
            "timestamp" => $timestamp,
            "url"       => $url,
            "signature" => $signature,
            "rawString" => $string
        );
        
        return $signPackage;
    }

    /**
     * @param $cb_func
     * 获取微信服务器地址
     */
    public function getWechatServerIp()
    {
        $token = $this->_wxConfigure->getParameter("access_token");
        if(!isset($token) || strlen($token) == 0 ){
            $errno = "40013";
            $err="access_token 没有填写，请检查";
            throw new WechatException($err,$errno);
        }

        $url = self::WECHAT_GET_SERVERIPADDRESS."?access_token=".$token;
        $results = $this->_get($url);
        $msg = json_decode($results,true);
        if(isset($msg['errcode']) && $msg['errcode'] !== 0 )
        {
            throw new WechatException($msg['errmsg'],$msg['errcode']);
            return ;
        }

        return $msg['ip_list'];
    }
}