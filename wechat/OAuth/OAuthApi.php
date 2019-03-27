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

// 鉴权相关参数
namespace endor\wechat\oauth;
use endor\wechat\WechatCommon;

class OAuthApi extends WechatCommon
{
    const WECHAT_GET_OAUTHCODE = "https://open.weixin.qq.com/connect/oauth2/authorize";
    const WECHAT_GET_OATUHOPENID = "https://api.weixin.qq.com/sns/oauth2/access_token"; //openid
    const WECHAT_GET_ACCESSTOKEN ="https://api.weixin.qq.com/cgi-bin/token"; // 全局token
    const WECHAT_GET_USERINFO = "https://api.weixin.qq.com/cgi-bin/user/info";

    public function __construct($wxConfigure)
    {
        parent::__construct($wxConfigure);
    }

    /**
     * @param $redirectUrl
     * 通过Code创建OauthUrl
     */
    public function  createOauthUrlForCode($redirectUrl)
    {
        $param['appid'] = $this->_wxConfigure->getParameter("appid");
        $getCodeUrl =  self::WECHAT_GET_OAUTHCODE.
                        "?appid=" .$this->_wxConfigure->getParameter("appid").
                        "&redirect_uri=" .urlencode( $redirectUrl ).
                        "&response_type=code".
                        "&scope=snsapi_base". #!!!scope设置为snsapi_base !!!
                        "&state=1";
        return $getCodeUrl;
    }

    /**
     * @param $code
     * @return mixed
     * 通过code 获取 OpenID
     */
    public function getOpenId($code)
    {
        $urlObj['appid'] = $this->_wxConfigure->getParameter("appid");
        $urlObj['secret'] = $this->_wxConfigure->getParameter("appsecret");
        $urlObj['code'] = $code;
        $urlObj["grant_type"] = "authorization_code";
        $url = self::WECHAT_GET_OATUHOPENID."?".http_build_query ($urlObj);
        $results = $this->_get($url);
        $data = json_decode($results,true);
        return $data;
    }

    /**
     * 获取静默授权时获取用户基本信息
     * openid：用户的openid。用户与公众号唯一身份标识
     * 若用户未关注公众号，无法获取详细信息
     */
    public function getWechatUserInfo($openid)
    {
        $isWechatBrowser = $this->isWeixinBrowser();
        if(!$isWechatBrowser)
            return false;

        $param['access_token'] = $this->_wxConfigure->getParameter("access_token");
        $param['openid'] = $openid;
        $param['lang'] = 'zh_CN';

        $url = self::WECHAT_GET_USERINFO . "?" .http_build_query ( $param );
        $content = file_get_contents ( $url );
        $content = json_decode ( $content, true );
        $WechatUser = new WechatUser($content);
        return $WechatUser;
    }

    // 判断是否是在微信浏览器里
    function isWeixinBrowser() {
        $agent = $_SERVER ['HTTP_USER_AGENT'];
        if (! strpos ( $agent, "icroMessenger" ))
        {
            return false;
        }
        return true;
    }


    /**
     * ? or &
     * @param 原始地址 $urls
     * @param 添加参数 $parm
     * @param 参数值 $value
     * @return $adds  带? 或 & 的参数
     */
    function addurl($urls,$param,$value="")
    {
        if(!strstr($urls, '?'))
        {
            $adds = "?".$param."=".$value;
        }
        else
        {
            $adds = "&".$param."=".$value;
        }

        return $adds;
    }

}