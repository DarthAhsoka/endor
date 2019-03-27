<?php
/**
 * Created by Darth-Ahsoka.
 * Author: Darth-Ahsoka  929204168@qq.com
 * Date: 2017/7/16
 * Version: 0.8 beta
 * Last Update: 2019/03/25
 * Update History:
 *      2017/08/17 创建0.7 Alpha 版本
 *      2019/03/25 0.8 beta 优化名字空间
 *
 */
namespace endor\wechat\template;
use endor\wechat\WechatCommon;

/**
 * 微信模板消息实例类，
 * 该类支持链式访问，
 * 链式结构除send必须在最后一个位置之外，其余不区分先后,
 * send函数是链式结尾
 */
class TemplateMessage extends AbstractAPI
{
    const TEMPLATE_MSG_URL = "https://api.weixin.qq.com/cgi-bin/message/template/send";

    /* 模板数据 */
    private $tpl_data;
    /* 发送给谁 */
    private $to_userid;
    /* 模板消息id */
    private $tpl_id;
    /* url，如果url为空，则IOS进入空白页面，Android无法点击 */
    private $_url;
    /*顶部字体颜色 */
    private $topcolor;

    /**
     * TemplateMessage constructor.
     * @param  $wxConfigure 配置微信对象参数
     *
     */
    public function __construct($wxConfigure = null)
    {
        parent::__construct($wxConfigure);
        $this->tpl_data = [];
    }

    /**
     * @param $user_id 接收模板消息的用户id
     * @return $this
     */
    public function to($user_id)
    {
        $this->to_userid = $user_id;
        return $this;
    }

    /**
     * @param string $url 点击模板消息跳转的网址
     * @return $this
     *
     * 如果url为空，则IOS进入空白页面，Android无法点击
     */
    public function url($url="")
    {
        $this->_url = $url;
        return $this;
    }

    /**
     * @param $template_id 模板消息id
     * @return $this
     */
    public function tpl($template_id)
    {
        $this->tpl_id = $template_id;
        return $this;
    }

    /**
     * @param $topcolor 顶部文字颜色
     * @return $this
     */
    public function topColor($topcolor)
    {
        $this->topcolor = $topcolor;

    }

    /**
     * @param $tplContext 模板上下文结构
     * @return $this
     */
    public function withData($tplContext)
    {
        $this->tpl_data = $tplContext;
        return $this;
    }

    # @param $options
    # 当$options== null 的时候，为链式调用send
    # 否则是非链式调用，options格式如下
    /**
     * array options = [
     *     'to_userid' =>
     *     'template_id'=>
     *     'data'=>
     *  ]
     */
    public function send($options = null)
    {
        if($options == null)
        {
            // 链式调用
            return $this->dispatchSend();
        }
        else
        {
            if(!is_array($options))
            {
                return false;
            }

            $this->to_userid = isset($options['to_userid'])?$options['to_userid']:"";
            $this->tpl_data = isset($options['data'])?$options['data']:"";
            $this->tpl_id = isset($options['template_id'])?$options['template_id']:"";

            return $this->dispatchSend();
        }
    }

    private function dispatchSend()
    {
        // 发送消息
        $accessToken = $this->_wxConfigure->getParameter("access_token");
        $url = self::TEMPLATE_MSG_URL .
               "?access_token=".$accessToken;
        // 构造消息
        $msg = array(
            'touser'=>$this->to_userid,
            'template_id'=>$this->tpl_id,
            'url'=>$this->_url,
            'topcolor'=>$this->topcolor,
            'data'=>$this->tpl_data
        );

        $results = $this->_post($url,json_encode($msg));
        return json_decode($results);
    }

}