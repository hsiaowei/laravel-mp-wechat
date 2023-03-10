<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 验证码表
 *
 * @author hsiaowei
 * @date  2023/3/6
 */
class WxVerifyCode extends Model
{

    const  STATUS_ON = "1";
    const  STATUS_OFF = "0";
    //
    protected $table = 'wx_verify_code';

    protected $fillable = [
        "iphone",
        "code",
        "status",
        "msg",
    ];
}