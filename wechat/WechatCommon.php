<?php
/**
 * Created by Darth-Ahsoka.
 * Author: Darth-Ahsoka  929204168@qq.com
 * Date: 2017/7/14
 * Version: 0.8 beta
 * Last Update: 2019/03/24
 * Update History:
 *      2017/08/17 创建0.7 Alpha 版本
 *      2019/03/24 0.8 beta  优化名字空间，修改部分函数命名,更改类名
 *                 修改_post,_get函数，废除 postXmlCurl和postXmlSSLCurl
 */
namespace endor\wechat;

/**
 * Class WechatCommon
 * @package endor\wechat
 * 微信接口基类，用于封装一些基本的操作，如cURL,
 * 微信鉴签，xml到数组的转换等
 */
class WechatCommon
{
    // 微信配置参数对象
    protected $_wxConfigure;

    public function __construct(&$wxConfigure)
    {
        if(isset($wxConfigure) && !empty($wxConfigure) && $wxConfigure!=null)
        {
            $this->_wxConfigure = $wxConfigure;
        }
    }

    // CURL发起 GET 请求
    public function _get($url,$valid=false)
    {
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_HEADER,0);
        if(!$valid)
        {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

    // CURL发起 POST请求
    public function _post($url,$postdata)
    {
        // 发起post请求
        $ch=curl_init();//初始化
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$postdata);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

    /**
     * @param $xml
     * @param $url
     * @param int $second
     * @return bool|mixed
     * 以xml形式将数据提交到URL，有别于AbstractAPI中的_post方法
     *
     */
    public function postXmlCurl($xml,$url,$second=30)
    {
        //初始化curl
        $ch = curl_init();
        //设置超时
        curl_setopt($ch, CURLOPT_TIMEOUT, $second);
        //这里设置代理，如果有的话
        //curl_setopt($ch,CURLOPT_PROXY, '8.8.8.8');
        //curl_setopt($ch,CURLOPT_PROXYPORT, 8080);
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);
        //设置header
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        //要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        //post提交方式
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        //运行curl
        $data = curl_exec($ch);

        //返回结果
        if($data)
        {
            curl_close($ch);
            return $data;
        }
        else
        {
            $error = curl_errno($ch);
            echo "curl出错，错误码:$error"."<br>";
            echo "<a href='http://curl.haxx.se/libcurl/c/libcurl-errors.html'>错误原因查询</a></br>";
            curl_close($ch);
            return false;
        }
    }

    /**
     * 	作用：使用证书，以post方式提交xml到对应的接口url
     *  以xml形式将数据提交到URL，有别于AbstractAPI中的_post方法
     *  使用ssl通道，需要加载证书文件
     */
    function postXmlSSLCurl($xml,$url,$second=30)
    {
        $ch = curl_init();
        //超时时间
        curl_setopt($ch,CURLOPT_TIMEOUT,$second);
        //这里设置代理，如果有的话
        //curl_setopt($ch,CURLOPT_PROXY, '8.8.8.8');
        //curl_setopt($ch,CURLOPT_PROXYPORT, 8080);
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);
        //设置header
        curl_setopt($ch,CURLOPT_HEADER,FALSE);
        //要求结果为字符串且输出到屏幕上
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,TRUE);
        //设置证书
        //使用证书：cert 与 key 分别属于两个.pem文件
        //默认格式为PEM，可以注释
        $privateCeriPath = $this->_wxConfigure->getParameter("sslcert_path");
        $publicKeyPath =  $this->_wxConfigure->getParameter("sslkey_path");

        curl_setopt($ch,CURLOPT_SSLCERTTYPE,'PEM');
        curl_setopt($ch,CURLOPT_SSLCERT, $privateCeriPath);
        //默认格式为PEM，可以注释
        curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
        curl_setopt($ch,CURLOPT_SSLKEY, $publicKeyPath);
        //post提交方式
        curl_setopt($ch,CURLOPT_POST, true);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$xml);
        $data = curl_exec($ch);
        //返回结果
        if($data){
            curl_close($ch);
            return $data;
        }
        else {
            $error = curl_errno($ch);
            echo "curl出错，错误码:$error"."<br>";
            echo "<a href='http://curl.haxx.se/libcurl/c/libcurl-errors.html'>错误原因查询</a></br>";
            curl_close($ch);
            return false;
        }
    }

    /**
     * 生成签名随机数
     */
    public function createNonceStr($length = 32) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    /**
     * 	作用：array转xml, 使用的是基于微信的 XML schema,
     *  其他地方请勿使用
     */
    public function arrayToXml($arr)
    {
        $xml = "<xml>";
        foreach ($arr as $key=>$val)
        {
            if (is_numeric($val))
            {
                $xml.="<".$key.">".$val."</".$key.">";

            }
            else
                $xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
        }
        $xml.="</xml>";
        return $xml;
    }
}