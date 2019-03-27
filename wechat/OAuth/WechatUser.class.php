<?php
/**
 * Created by PhpStorm.
 * User: Mianyang Kamino S&T Co,Ltd @ ahsoka:929204168
 * Date: 2017/7/14
 * Time: 18:00
 * Version: 0.7 Alpha
 * Last Update: 2017/07/20
 * Update History:
 *      2017/07/20  创建0.7 Alpha 版本
 */

// 鉴权相关参数
namespace Kamino\Wechat\OAuth;

class WechatUser
{

    public function __construct($arr = null)
    {
        if(is_array($arr))
        {
            foreach($arr as $k=>$v)
            {
                switch($k)
                {
                    case "subscribe":
                        $this->subscribe=$arr['subscribe'];
                        break;
                    case "openid":
                        $this->openid=$arr['openid'];
                        break;
                    case "nickname":
                        $this->nickname=$arr['nickname'];
                        break;
                    case "sex":
                        $this->sex = $arr['sex'];
                        break;
                    case "language":
                        $this->language=$arr['language'];
                        break;
                    case "city":
                        $this->city = $arr['city'];
                        break;
                    case "province":
                        $this->province = $arr['province'];
                        break;
                    case "country":
                        $this->country = $arr['country'];
                        break;
                    case "headimgurl":
                        $this->headimgurl = $arr['headimgurl'];
                        break;
                    case "subscribe_time":
                        $this->subscribe_time = $arr['subscribe_time'];
                        break;
                    case "unionid":
                        $this->unionid = $arr['unionid'];
                        break;
                    case "remark":
                        $this->remark =$arr['remark'];
                        break;
                }
            }
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