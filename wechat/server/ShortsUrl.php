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
namespace endor\wechat\server;
use endor\wechat\WechatCommon;
use endor\wechat\WechatException;

/**
 * Class ShortsUrl
 * @package endor\wechat\foundation;
 * 短网址生成
 * 主要使用场景： 开发者用于生成二维码的原链接（商品、支付二维码等）
 * 太长导致扫码速度和成功率下降，将原长链接通过此接口转成短链接再生
 * 成二维码将大大提升扫码速度和成功率。
 */
class ShortsUrl extends  WechatCommon
{
    const CONVERT_URL="https://api.weixin.qq.com/cgi-bin/shorturl";

    public function __construct($wxConfigure)
    {
        parent::__construct($wxConfigure);
    }

    /**
     * @param $longurl 长链接地址
     * @return mixed 转换后的结果
     */
    public function shorten($longurl)
    {
        $access_token = $this->_wxConfigure->getParameter("access_token");
        $url = self::CONVERT_URL."?access_token=".$access_token;
        // 构造转换数组
        $covertArr = [
            'action'=>'long2short',
            'long_url'=>$longurl
        ];
        $results = $this->_post($url,json_encode($covertArr));
        $msg = json_decode($results,true);
        if(isset($msg['errcode']) && $msg['errcode'] !== 0 )
        {
            throw new WechatException($msg['errmsg'],$msg['errcode']);
            return ;
        }
        return $msg['short_url'];
    }
}