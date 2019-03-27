<?php
/**
 * Created by Darth-Ahsoka.
 * Author: Darth-Ahsoka  929204168@qq.com
 * Date: 2017/7/16
 * Version: 0.8 beta
 * Last Update: 2019/03/26
 * Update History:
 *      2017/08/17 创建0.7 Alpha 版本
 *      2019/03/27 0.8 beta 优化名字空间
 *                 优化类继承体系
 *
 */
namespace endor\wechat\pay;

/**
 * Class NotifyData
 * @package endor\wechat\pay;
 * 微信通知回调数据
 */
class NotifyData
{
    #微信分配的公众账号ID（企业号corpid即为此appId）
    public $appid;
    #微信支付分配的商户号
    public $mchid;
    #微信支付分配的终端设备号，
    public $device_info;
    #随机字符串，不长于32位
    public $nonce_str;
    #签名
    public $sign;
    #签名类型，目前支持HMAC-SHA256和MD5，默认为MD5
    public $sign_type;
    #SUCCESS/FAIL
    public $result_code;
    #错误返回的信息代码
    public $err_code;
    #错误返回的信息描述
    public $err_code_des;
    #用户在商户appid下的唯一标识
    public $openid;
    #用户是否关注公众账号，Y-关注，N-未关注，仅在公众账号类型支付有效
    public $is_subscribe;
    #JSAPI、NATIVE、APP
    public $trade_type;
    #银行类型，采用字符串类型的银行标识，银行类型见银行列表
    public $bank_type;
    #订单总金额，单位为分
    public $total_fee;
    #应结订单金额=订单金额-非充值代金券金额，应结订单金额<=订单金额。
    public $settlement_total_fee;
    #货币类型，符合ISO4217标准的三位字母代码，默认人民币：CNY，
    public $fee_type;
    #现金支付金额订单现金支付金额
    public $cash_fee;
    #货币类型，符合ISO4217标准的三位字母代码，默认人民币：CNY
    public $cash_fee_type;
    #代金券金额
    public $coupon_fee;
    #代金券使用数量
    public $coupon_count;
    #微信支付订单号
    public $transaction_id;
    #商户系统内部订单号，要求32个字符内，只能是数字、大小写字母_-|*@ ，且在同一个商户号下唯一。
    public $out_trade_no;
    #商家数据包，原样返回
    public $attach;
    #支付完成时间，格式为yyyyMMddHHmmss，如2009年12月25日9点10分10秒表示为2009122509101
    public $time_end;

    public function toJson()
    {
        return json_encode($this->toArray());
    }

    public function toArray()
    {
        return array(
            #微信分配的公众账号ID（企业号corpid即为此appId）
            'appid' => $this->appid,
            #微信支付分配的商户号
            'mchid' => $this->mchid,
            #微信支付分配的终端设备号，
            'device_info' => $this->device_info,
            #随机字符串，不长于32位
            'nonce_str' => $this->nonce_str,
            #签名
            'sign' => $this->sign,
            #签名类型，目前支持HMAC-SHA256和MD5，默认为MD5
            'sign_type' => $this->sign_type,
            #SUCCESS/FAIL
            'result_code' => $this->result_code,
            #错误返回的信息描述
            'err_code'=>$this->err_code,
            #错误返回的信息描述
            'err_code_des' =>$this->err_code_des,
            #用户在商户appid下的唯一标识
            'openid' => $this->openid,
            #用户是否关注公众账号，Y-关注，N-未关注，仅在公众账号类型支付有效
            'is_subscribe' => $this->is_subscribe,
            #JSAPI、NATIVE、APP
            'trade_type' => $this->trade_type,
            #银行类型，采用字符串类型的银行标识，银行类型见银行列表
            'bank_type' => $this->bank_type,
            #订单总金额，单位为分
            'total_fee' => $this->total_fee,
            #应结订单金额=订单金额-非充值代金券金额，应结订单金额<=订单金额。
            'settlement_total_fee' => $this->settlement_total_fee,
            #货币类型，符合ISO4217标准的三位字母代码，默认人民币：CNY，
            'fee_type' => $this->fee_type,
            #现金支付金额订单现金支付金额
            'cash_fee' => $this->cash_fee,
            #货币类型，符合ISO4217标准的三位字母代码，默认人民币：CNY
            'cash_fee_type' => $this->cash_fee_type,
            #代金券金额
            'coupon_fee' =>  $this->coupon_fee,
            #代金券使用数量
            'coupon_count' => $this->coupon_count,
            #微信支付订单号
            'transaction_id' => $this->transaction_id,
            #商户系统内部订单号，要求32个字符内，只能是数字、大小写字母_-|*@ ，且在同一个商户号下唯一。
            'out_trade_no' => $this->out_trade_no,
            #商家数据包，原样返回
            'attach'=> $this->attach,
            #支付完成时间，格式为yyyyMMddHHmmss，如2009年12月25日9点10分10秒表示为2009122509101
            'time_end'=> $this->time_end,
        );
    }

    public function toXml()
    {
        $arr = $this->toArray();
        $xml = "<xml>";
        foreach ($arr as $key=>$val)
        {
            $xml.="<".$key.">".$val."</".$key.">";
        }
        $xml.="</xml>";
        return $xml;
    }

    /**
     * @param $notifyReturnDataArr
     * 用 $notifyResturnDataArr 关联数组初始化 notifyData 对象
     */
    public function create($notifyReturnData)
    {
        isset($notifyReturnData['appid']) ? $this->appid = $notifyReturnData['appid'] : $this->appid="";
        isset($notifyReturnData['mchid']) ? $this->mchid = $notifyReturnData['mchid'] : $this->mchid="";
        isset($notifyReturnData['device_info']) ? $this->device_info = $notifyReturnData['device_info'] : $this->device_info="";
        isset($notifyReturnData['nonce_str']) ? $this->nonce_str = $notifyReturnData['nonce_str'] : $this->nonce_str="";
        isset($notifyReturnData['sign']) ? $this->sign = $notifyReturnData['sign'] : $this->sign="";
        isset($notifyReturnData['sign_type']) ? $this->sign_type = $notifyReturnData['sign_type'] : $this->sign_type="";
        isset($notifyReturnData['result_code']) ? $this->result_code = $notifyReturnData['result_code'] : $this->result_code="";
        isset($notifyReturnData['err_code']) ? $this->err_code = $notifyReturnData['err_code'] : $this->err_code="";
        isset($notifyReturnData['err_code_des']) ? $this->err_code_des = $notifyReturnData['err_code_des'] : $this->err_code_des="";
        isset($notifyReturnData['openid']) ? $this->openid = $notifyReturnData['openid'] : $this->openid="";
        isset($notifyReturnData['is_subscribe']) ? $this->is_subscribe = $notifyReturnData['is_subscribe'] : $this->is_subscribe="";
        isset($notifyReturnData['trade_type']) ? $this->trade_type = $notifyReturnData['trade_type'] : $this->trade_type="";
        isset($notifyReturnData['bank_type']) ? $this->bank_type = $notifyReturnData['bank_type'] : $this->bank_type="";
        isset($notifyReturnData['total_fee']) ? $this->total_fee = $notifyReturnData['total_fee'] : $this->total_fee="";
        isset($notifyReturnData['settlement_total_fee']) ? $this->settlement_total_fee = $notifyReturnData['settlement_total_fee'] : $this->settlement_total_fee="";
        isset($notifyReturnData['fee_type']) ? $this->fee_type = $notifyReturnData['fee_type'] : $this->fee_type="";
        isset($notifyReturnData['cash_fee']) ? $this->cash_fee = $notifyReturnData['cash_fee'] : $this->cash_fee="";
        isset($notifyReturnData['cash_fee_type']) ? $this->cash_fee_type = $notifyReturnData['cash_fee_type'] : $this->cash_fee_type="";
        isset($notifyReturnData['coupon_fee']) ? $this->coupon_fee = $notifyReturnData['coupon_fee'] : $this->coupon_fee="";
        isset($notifyReturnData['coupon_count']) ? $this->coupon_count = $notifyReturnData['coupon_count'] : $this->coupon_count="";
        isset($notifyReturnData['transaction_id']) ? $this->transaction_id = $notifyReturnData['transaction_id'] : $this->transaction_id="";
        isset($notifyReturnData['out_trade_no']) ? $this->out_trade_no = $notifyReturnData['out_trade_no'] : $this->out_trade_no="";
        isset($notifyReturnData['attach']) ? $this->attach = $notifyReturnData['attach'] : $this->attach="";
        isset($notifyReturnData['time_end']) ? $this->time_end = $notifyReturnData['time_end'] : $this->time_end="";

    }

    public function xmlToObj($xmlStr)
    {
        $array_data = json_decode(json_encode(simplexml_load_string($xmlStr, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        $this->create($array_data);
    }
}