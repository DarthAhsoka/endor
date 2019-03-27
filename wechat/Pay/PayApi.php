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
use endor\wechat\WechatCommon;

/**
 * Class PayApi
 * @package
 * 微信支付基础接口
 */
class PayApi extends WechatCommon
{
    // 微信支付需要使用的关联数组
    protected $parameters;
    //微信返回的响应
    protected $response;
    //返回参数，类型为关联数组
    protected $result;
    //接口链接
    protected $url;
    //curl超时时间
    protected $curl_timeout;


    // 设置配置参数
    function __construct($wxConfigure = null)
    {
        parent::__construct($wxConfigure);
        $curl_timeout = $wxConfigure->getParameter("timeout");
    }

    // 设置参数时需要使用的方法，对字符串进行处理
    function trimString($value)
    {
        $ret = null;
        if (null != $value)
        {
            $ret = $value;
            if (strlen($ret) == 0)
            {
                $ret = null;
            }
        }
        return $ret;
    }


    /**
     * 	作用：格式化参数，签名过程需要使用
     */
    function formatBizQueryParaMap($paraMap, $urlencode)
    {
        $buff = "";
        ksort($paraMap);
        foreach ($paraMap as $k => $v)
        {
            if($urlencode)
            {
                $v = urlencode($v);
            }
            //$buff .= strtolower($k) . "=" . $v . "&";
            $buff .= $k . "=" . $v . "&";
        }
        $reqPar = null;
        if (strlen($buff) > 0)
        {
            $reqPar = substr($buff, 0, strlen($buff)-1);
        }
        return $reqPar;
    }


    /**
     * 	作用：生成签名
     */
    public function getSign($paraMap)
    {
        $key = $this->_wxConfigure->getParameter("key");
        foreach ($paraMap as $k => $v)
        {
            $Parameters[$k] = $v;
        }
        //签名步骤一：按字典序排序参数
        ksort($Parameters);
        $String = $this->formatBizQueryParaMap($Parameters, false);
        //echo '【string1】'.$String.'</br>';
        //签名步骤二：在string后加入KEY
        $String = $String."&key=".$key;
        //echo "【string2】".$String."</br>";
        //签名步骤三：MD5加密
        $String = md5($String);
        //echo "【string3】 ".$String."</br>";
        //签名步骤四：所有字符转为大写
        $result_ = strtoupper($String);
        //echo "【result】 ".$result_."</br>";
        return $result_;
    }

    /**
     * 	作用：将xml转为array
     */
    public function xmlToArray($xml)
    {
        //将XML转为array
        $array_data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        return $array_data;
    }

    /**
     * 	作用：打印数组
     */
    function printErr($wording='',$err='')
    {
        print_r('<pre>');
        echo $wording."</br>";
        var_dump($err);
        print_r('</pre>');
    }

}