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
namespace endor\wechat\message;

/**
 * Class NewsContext
 * 微信图文列表，单图文节点上下文结构
 * @package endor\wechat\message
 */
class NewsContext
{
    #标题
    protected $title;
    #描述
    protected $description;
    #图片连接，支持JPG,PNG,格式：大图360*200，小图：200*200 效果最好
    protected $picUrl;
    #点击图文消息跳转连接
    protected $url;

    public function __construct($title,$description,$picUrl,$url)
    {
        $this->title = $title;
        $this->description = $description;
        $this->picUrl = $picUrl;
        $this->url = $url;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setDescription($description)
    {
        $this->description=$description;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setPicUrl($picUrl)
    {
        $this->picUrl = $picUrl;
    }

    public function getPicUrl()
    {
        return $this->picUrl;
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function toXmlSchema()
    {
        $schema = "<item>";
        $schema = $schema . "<Title><![CDATA[{$this->title}]]></Title>";
        $schema = $schema . "<Description><![CDATA[{$this->description}]]></Description>";
        $schema = $schema . "<PicUrl><![CDATA[{$this->picUrl}]]></PicUrl>";
        $schema = $schema . "<Url><![CDATA[{$this->url}]]></Url>";
        $schema = $schema . "</item>";
        return $schema;
    }
}
