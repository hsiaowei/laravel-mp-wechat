<?php

namespace App\Libraries\sms;

/**
 * desc
 *
 * @author hsiaowei
 * @date  2023/3/9
 */
class SmsFactory
{

    /** 短信发送工厂类
     * @param string $iphone
     * @param string $code
     * @param ...$_
     */
    public static function sendCode(string $iphone, string $code, ...$_)
    {


        switch (config('sms.default')) {
            case 'tencent':
                return TencentCloudSms::sendCode($iphone, $code, ...$_);
                break;
            default:
                return '其他平台暂未接入！';
        }


    }

}