<?php

namespace App\Libraries\sms;

/**
 * desc
 *
 * @author hsiaowei
 * @date  2023/3/9
 */
interface Sms
{

    /**
     * 短信验证码服务
     * @param string $iphone
     * @param string $code
     * @param ...$_
     * @return mixed
     */
    public static function sendCode(string $iphone, string $code,  ...$_);

}