<?php

namespace App\Http\Controllers\Api;

use App\Libraries\sms\SmsFactory;
use App\Models\WxVerifyCode;
use Illuminate\Http\Request;

/**
 * 验证码服务
 *
 * @author hsiaowei
 * @date  2023/3/6
 */
class VerifyCodeController extends ApiBaseController
{
    //
    protected $verifyCode;

    public function __construct()
    {
    }


    /**
     * 发送验证码
     */
    public function sendVerifyCode(Request $request)
    {
        $this->validate($request, [
            'iphone' => 'required',
        ]);
        $iphone = $request->get('iphone');
        // todo send code
        $code = $this->randString(6, '0123456789');
        $sendMsg = $this->sendSms($iphone, $code);
        $data = [
            'code' => $code,
            'iphone' => $iphone,
            'status' => WxVerifyCode::STATUS_ON,
            'msg' => json_encode($sendMsg)
        ];
        $result = WxVerifyCode::create($data);
        if ($result) {
            $result = $this->success(0, '发送成功!');
        } else {

            $result = $this->success(1, '发送失败!');
        }
        return $result;

    }


    public function testSendTencentCloudSms()
    {

        $code = $this->randString(6, '0123456789');
        return $this->sendSms('13812652676', $code);
        //$this->sendTencentCloudSms('13451521321', $code);
    }

    /**
     * 腾讯云发送短信
     * @param $iphone 手机号
     * @param $code 验证码
     */
    public function sendSms($iphone, $code, $minute = "10")
    {
        //return "success-";
        return SmsFactory::sendCode($iphone,$code,$minute);
    }

    /**
     * 生成随机数字
     * @param $len
     * @return string
     * @author hsiaowei
     * @date   2017/2/6 14:36
     */
    public function randString($len = 6, $chars = 'abcdefghijkmnpqrstuvwxyz23456789')
    {
        if ($len > 10) { //位数过长重复字符串一定次数
            $chars = str_repeat($chars, 5);
        }
        $chars = str_shuffle($chars);
        $str = substr($chars, 0, $len);
        return $str;
    }

}