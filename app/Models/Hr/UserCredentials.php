<?php

namespace App\Models\Hr;

use Illuminate\Database\Eloquent\Model;

/**
 * desc
 *
 * @author hsiaowei
 * @date  2023/3/6
 */
class UserCredentials extends Model
{
        protected $fillable =[
            "credentialstype",
            "credentialsno",
        ]
}