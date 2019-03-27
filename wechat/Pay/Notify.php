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
 * Class Notify
 * @package endor\wechat\pay;
 * 异步通知回调，该方法回调函数内无法使用$_SESSION,$GLOBAL,$COOKIE等
 * 超全局数组,同时该对象所处的方法不能进行$_SESSION鉴权
 */
class Notify extends ResponsePay
{
    public function __construct($wxConfigure = null)
    {
        parent::__construct($wxConfigure);
    }

    /**
     * @param $complete_result_call_func
     * @return bool
     * 微信异步完成通知，回调参数$complete_result_call_func 接受一个闭包或函数
     * 该闭包或函数接受二个参数， $results 回调记录结果 和 $status <FAIL , SUCCESS>
     * 当$status == SUCCESS 时，$results 具备完整结构
     */
    public function waitPaymentNotifyResults($complete_result_call_func)
    {
        // 获取xml结构
        $xml = file_get_contents("php://input");
        $this->saveData($xml);
        //验证签名，并回应微信。
        //对后台通知交互时，如果微信收到商户的应答不是成功或超时，微信认为通知失败，
        //微信会通过一定的策略（如30分钟共8次）定期重新发起通知，
        //尽可能提高通知的成功率，但微信不保证通知最终能成功。
        // $this->log_result("【checkSign】:\n".$notify->checkSign()."\n");
        if( $this->checkSign() == FALSE)
        {
            $this->setReturnParameter("return_code","FAIL");
            $this->setReturnParameter("return_msg","签名失败");
        }
        else
        {
            $this->setReturnParameter("return_code","SUCCESS");//设置返回码
        }

        $returnXml = $this->returnXml();
        if($this->checkSign() == TRUE)
        {
            if($this->data['result_code'] == "FAIL")
            {
                if(is_callable($complete_result_call_func))
                {
                    call_user_func_array($complete_result_call_func,[
                        'results' => $this->data,
                        'return_code'=>"FAIL",
                    ]);
                    return true;
                }
                return false;
            }
            elseif($this->data["result_code"] == "FAIL"){
                if(is_callable($complete_result_call_func))
                {
                    call_user_func_array($complete_result_call_func,[
                        'results' => $this->data,
                        'return_code'=>"FAIL",
                    ]);
                    return true;
                }
                return false;
            }
            else
            {
                if(is_callable($complete_result_call_func))
                {
                    call_user_func_array($complete_result_call_func,[
                        'results' => $this->data,
                        'return_code'=>"SUCCESS",
                    ]);
                    return true;
                }
                return false;
            }
        }
    }
}