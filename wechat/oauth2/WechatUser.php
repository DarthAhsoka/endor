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
namespace endor\wechat\oauth;
class WechatUser
{
    public function __construct($arr = null)
    {
        if(is_array($arr))
        {
            $this->subscribe= isset($arr['subscribe']) ? $arr['subscribe'] : "";
            $this->openid=isset($arr['openid']) ? $arr['openid'] : "";
            $this->nickname=isset($arr['nickname']) ? $arr['openid'] : "";
            $this->sex = isset($arr['sex']) ? $arr['sex'] : "";
            $this->language=isset($arr['language']) ? $arr['language'] : "";
            $this->city = isset($arr['city']) ? $arr['city'] : "";
            $this->province = isset($arr['province']) ? $arr['province'] : "";
            $this->country = isset($arr['country']) ? $arr['country'] : "";
            $this->unionid = isset($arr['unionid']) ? $arr['unionid'] : "";
            $this->headimgurl = isset($arr['headimgurl']) ? $arr['headimgurl'] : "";
            $this->subscribe_time = isset($arr['subscribe_time']) ? $arr['subscribe_time'] : "";
            $this->remark =isset($arr['remark']) ? $arr['remark'] : "";
        }
    }

    // 是否关注微信公众号
    public $subscribe;

    // openid
    public $openid;

    // 昵称
    public $nickname;

    // 性别
    public $sex;

    // 语言
    public $language;

    // 所在城市
    public $city;

    // 所在省份
    public $province;

    // 所在国家
    public $country;

    // 头像
    public $headimgurl;

    // 关注时间
    public $subscribe_time;

    // unionid
    public $unionid;

    // 备注
    public $remark;

    public function toArray()
    {
        return [
            'subscribe'=>$this->subscribe,
            'openid'=>$this->openid,
            'nickname'=>$this->nickname,
            'sex'=>$this->sex,
            'language'=>$this->language,
            'city'=>$this->city,
            'province'=>$this->province,
            'country'=>$this->country,
            'headimgurl'=>$this->headimgurl,
            'subscribe_time'=>$this->subscribe_time,
            'unionid'=>$this->unionid,
            'remark'=>$this->remark
        ];
    }

}