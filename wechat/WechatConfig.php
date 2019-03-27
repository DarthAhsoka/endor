<?php
/**
 * Created by Darth-Ahsoka.
 * Author: Darth-Ahsoka  929204168@qq.com
 * Date: 2017/7/14
 * Version: 0.8 beta
 * Last Update: 2019/03/24
 * Update History:
 *      2017/08/17 创建0.7 Alpha 版本
 *      2019/03/24 0.8 beta  优化名字空间
 */
namespace endor\wechat;

// 微信配置文件
class WechatConfig
{
    private $_wxParameters = [
        'appid'         => '',  # 微信appid
        'mchid'         => '',  # 微信商户号
        'oauth_token'   => '',  # 微信OAuth授权通信令牌(Access_Token，用于用户权限授权,一次申请一个，5分钟有效期)
        'access_token'  => '',  # 微信普通授权通信令牌（Access_Token,用于普通授权，2个小时有效期)
        'validate_token'=> '',  # 微信验证令牌 （永久，服务器令牌）
        'appsecret'     => '',  # 微信令牌密钥
        'img_tmp'       => '',  # 微信上传图片临时文件保存地址
        'key'           => '',  # 微信支付使用的公钥
        'sslcert_path'  => '',  # SSL证书文件路径
        'sslkey_path'   => '',  # SSL公钥文件路径
        'timeout'       => 30,  # 请求超时时间
        'jsapi_ticket'  => '',  # JSAPI 授权TICKET
    ];

    /**
     * @param $key string 配置项
     * @param $value string 配置名字
     * 设置微信配置参数
     */
    public function setParameter($key,$value){
        $this->_wxParameters["{$key}"] = $value;
    }

    /**
     * @param $key string 配置项
     * @return mixed|null 如果配置项存在，则返回该配置项的值，否则返回null
     */
    public function getParameter($key) {
        if(isset($this->_wxParameters["{$key}"])){
            return $this->_wxParameters[$key];
        }
        return null;
    }
}