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


class ResponsePay extends PayApi
{
    protected $data;//接收到的数据，类型为关联数组
    protected $returnParameters;//返回参数，类型为关联数组

    public function __construct($wxConfigure = null)
    {
        parent::__construct($wxConfigure);
    }

    /**
     * 将微信的请求xml转换成关联数组，以方便数据处理
     */
    function saveData($xml)
    {
        $this->data = $this->xmlToArray($xml);
    }

    function checkSign()
    {
        $tmpData = $this->data;
        unset($tmpData['sign']);
        if(is_array($tmpData))
        {
            $sign = $this->getSign($tmpData);//本地签名
            if ($this->data['sign'] == $sign) {
                return TRUE;
            }
        }

        return FALSE;
    }

    /**
     * 获取微信的请求数据
     */
    function getData()
    {
        return $this->data;
    }

    /**
     * 设置返回微信的xml数据
     */
    function setReturnParameter($parameter, $parameterValue)
    {
        $this->returnParameters[$this->trimString($parameter)] = $this->trimString($parameterValue);
    }

    /**
     * 生成接口参数xml
     */
    function createXml()
    {
        return $this->arrayToXml($this->returnParameters);
    }

    /**
     * 将xml数据返回微信
     */
    function returnXml()
    {
        $returnXml = $this->createXml();
        return $returnXml;
    }
}