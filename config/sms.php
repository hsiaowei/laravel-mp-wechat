<?php

/*
 * This file is part of the overtrue/laravel-wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
    */
    'default' => env('SMS_DRIVER', 'tencent'),
    /*
     * 默认配置，将会合并到各模块中
     */
    'platforms' => [
        /**
         * 腾讯云短信平台
         */
        'tencent' => [
            'secret_id' => env('TENCENTCLOUD_SECRET_ID', ''),
            'secret_key' => env('TENCENTCLOUD_SECRET_KEY', ''),
            'sdk_app_id' => env('TENCENTCLOUD_SMS_SDK_APP_ID', ''),
            'sign_name' => env('TENCENTCLOUD_SMS_SIGN_NAME', ''),
            'template_id' => env('TENCENTCLOUD_SMS_TEMPLATE_ID', ''),
        ],

        // 后续待接入其他
        'ali' => [
            'driver' => 'pgsql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '5432'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'schema' => 'public',
            'sslmode' => 'prefer',
        ],



    ],

];
