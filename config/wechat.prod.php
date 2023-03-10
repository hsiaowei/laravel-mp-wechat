<?php

/*
 * This file is part of the overtrue/laravel-wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
$baseUrl = "http://wechat-hcp.areschina.com:8016/";

return [
    /*
     * 路由配置
     */
    'route' => [
        /*
         * 是否开启路由
         */
        'enabled' => false,

        /*
         * 开放平台第三方平台路由配置
         */
        'open_platform' => [
            'uri' => 'serve',

            'attributes' => [
                'prefix' => 'open-platform',
                'middleware' => null,
            ],
        ],
    ],

    /*
     * 默认配置，将会合并到各模块中
     */
    'defaults' => [
        /*
         * Debug 模式，bool 值：true/false
         *
         * 当值为 false 时，所有的日志都不会记录
         */
        'debug' => true,

        /*
         * 指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
         */
        'response_type' => 'array',

        /*
         * 使用 Laravel 的缓存系统
         */
        'use_laravel_cache' => true,

        /*
         * 日志配置
         *
         * level: 日志级别，可选为：
         *                 debug/info/notice/warning/error/critical/alert/emergency
         * file：日志文件位置(绝对路径!!!)，要求可写权限
         */
        'log' => [
            'level' => env('WECHAT_LOG_LEVEL', 'debug'),
            'file' => env('WECHAT_LOG_FILE', storage_path('logs/company/wechat.log')),
        ],
    ],

    /*
     * 公众号
     */
    'official_account' => [
        /*
         * 账号基本信息，请从微信公众平台/开放平台获取
         */
//        'app_id' => env('WECHAT_OFFICIAL_ACCOUNT_APPID', 'your-app-id'),         // AppID
//        'secret' => env('WECHAT_OFFICIAL_ACCOUNT_SECRET', 'your-app-secret'),     // AppSecret
//        'token' => env('WECHAT_OFFICIAL_ACCOUNT_TOKEN', 'your-token'),          // Token
//        'aes_key' => env('WECHAT_OFFICIAL_ACCOUNT_AES_KEY', ''),                    // EncodingAESKey

        /*
         * OAuth 配置
         *
         * only_wechat_browser: 只在微信浏览器跳转
         * scopes：公众平台（snsapi_userinfo / snsapi_base），开放平台：snsapi_login
         * callback：OAuth授权完成后的回调页地址(如果使用中间件，则随便填写。。。)
         */
        // 'oauth' => [
        //     'only_wechat_browser' => false,
        //     'scopes'   => array_map('trim', explode(',', env('WECHAT_OFFICIAL_ACCOUNT_OAUTH_SCOPES', 'snsapi_userinfo'))),
        //     'callback' => env('WECHAT_OFFICIAL_ACCOUNT_OAUTH_CALLBACK', '/examples/oauth_callback.php'),
        // ],
    ],

    /*
     * 开放平台第三方平台
     */
    // 'open_platform' => [
    //     'app_id'  => env('WECHAT_OPEN_PLATFORM_APPID', ''),
    //     'secret'  => env('WECHAT_OPEN_PLATFORM_SECRET', ''),
    //     'token'   => env('WECHAT_OPEN_PLATFORM_TOKEN', ''),
    //     'aes_key' => env('WECHAT_OPEN_PLATFORM_AES_KEY', ''),
    // ],

    /*
     * 小程序
     */
    // 'mini_program' => [
    //     'app_id'  => env('WECHAT_MINI_PROGRAM_APPID', ''),
    //     'secret'  => env('WECHAT_MINI_PROGRAM_SECRET', ''),
    //     'token'   => env('WECHAT_MINI_PROGRAM_TOKEN', ''),
    //     'aes_key' => env('WECHAT_MINI_PROGRAM_AES_KEY', ''),
    // ],

    /*
     * 微信支付
     */
    // 'payment' => [
    //     'sandbox_mode'       => env('WECHAT_PAYMENT_SANDBOX', true),
    //     'app_id'             => env('WECHAT_PAYMENT_APPID', ''),
    //     'secret'             => env('WECHAT_PAYMENT_SECRET', ''),
    //     'merchant_id'        => env('WECHAT_PAYMENT_MERCHANT_ID', 'your-mch-id'),
    //     'key'                => env('WECHAT_PAYMENT_KEY', 'key-for-signature'),
    //     'cert_path'          => env('WECHAT_PAYMENT_CERT_PATH', 'path/to/cert/apiclient_cert.pem'),    // XXX: 绝对路径！！！！
    //     'key_path'           => env('WECHAT_PAYMENT_KEY_PATH', 'path/to/cert/apiclient_key.pem'),          // XXX: 绝对路径！！！！
    //     'notify_url'         => '/payments/wechat-notify', // 默认支付通知地址
    //     // 'device_info'     => env('WECHAT_PAYMENT_DEVICE_INFO', ''),
    //     // 'sub_app_id'      => env('WECHAT_PAYMENT_SUB_APP_ID', ''),
    //     // 'sub_merchant_id' => env('WECHAT_PAYMENT_SUB_MERCHANT_ID', ''),
    //     // ...
    // ],

    /*
     * 企业微信
     */
    'work' => [
        'debug' => true,
        // 企业 ID
        'corp_id' => env('WECHAT_WORK_CORP_ID', ''),
        // 应用列表
        'agents' => [
            // Cust App Info
            'default' => [
                'agent_id' => env('WECHAT_WORK_DEFAULT_AGENT_ID', ''),
                'secret' => env('WECHAT_WORK_DEFAULT_AGENT_SECRET', ''),
                // 如果应用需要接受用户回复的消息，这里需要填写，否则无须填写
                'token' => env('WECHAT_WORK_DEFAULT_FEEDBACK_TOKEN'),
                'aes_key' => env('WECHAT_WORK_DEFAULT_FEEDBACK_ASE_KEY')
            ],
            'contacts' => [
                'agent_id' => env('WECHAT_WORK_CONTACT_AGENT_ID'), // contact 是特殊的 agent 无 id, 这里任意指定，但不能用这个来发消息
                'secret' => env('WECHAT_WORK_CONTACT_SECRET')
            ]
        ],
        'default_agent' => env('WECHAT_WORK_DEFAULT_AGENT_ID'),
    ],

    /*
     * 企业微信 config
     */

    'workchat' => [
        'corp_id' => 'wxffbe4a3d8b2acc48',

        // 应用列表
        'agents' => [
            'contacts' => [
                'agent_id' => '',
                'secret' => 'UeFmzXT0xYVxCGF9PJNFBNR5vXQsSCJ8p2rs1o9RRm0',
            ],
            '0' => [
                'agent_id' => '0',
                'secret' => 'pi4kGxSC0LKW8YR-iioGuKgfdJ0uq2fhewl_HbrS3IE',
            ],
            //...
        ],

        // 指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
        'response_type' => 'array',

        'log' => [
            'level' => 'debug',
            'file' => __DIR__ . '/wechat.log',
        ],
        'default_agent' => '0'//default_agent
    ],
    'workchat7' => [
        'corp_id' => 'wxffbe4a3d8b2acc48',
        'agent_id' => 1000018,
        'secret' > 'OrGF00gwwfgpvVgPT-kfeM4WEvLrz_tRiBRbhB8N--k',

        // 应用列表
        'agents' => [
            'contacts' => [
                'agent_id' => '',
                'secret' => 'UeFmzXT0xYVxCGF9PJNFBNR5vXQsSCJ8p2rs1o9RRm0',
            ],
            'clock' => [
                'agent_id' => 3010011,
                'secret' => 'BtDyUpJGp3_cHMwuwVmDYwe2HzcsmnUJS2c5eZuWdxU',
            ],
            1000007 => [
                'agent_id' => 1000007,
                'secret' => 'rH6u_2nB3EoGGoO-aBf1rBeAjhYO6qlPxo1SkOk5eSM',
            ],
            1000018 => [
                'agent_id' => 1000018,
                'secret' => 'OrGF00gwwfgpvVgPT-kfeM4WEvLrz_tRiBRbhB8N--k',
                'menus' => [
                    'button' => [
                        [
                            "name" => "我的信息",
                            "sub_button" => [
                                [
                                    "type" => "view",
                                    "name" => "个人信息",
                                    "url" => $baseUrl .
                                        "user/view/userinfo?companyid=7"
                                ]
                            ],
                        ],
                        [
                            "name" => "我的考勤",
                            "sub_button" => [
                                [
                                    "type" => "view",
                                    "name" => "我的日历",
                                    "url" => $baseUrl .
                                        "attendance/view/canlendar?companyid=7"
                                ],
                                [
                                    "type" => "view",
                                    "name" => "我的考勤",
                                    "url" => $baseUrl .
                                        "attendance/view/summary?companyid=7"
                                ],
                                [
                                    "type" => "view",
                                    "name" => "我的可休假",
                                    "url" => $baseUrl .
                                        "holiday/view/all?companyid=7"
                                ],
                            ],
                        ],
                        [
                            "name" => "我的薪资",
                            "sub_button" => [
                                [
                                    "type" => "view",
                                    "name" => "薪资单",
                                    "url" => $baseUrl .
                                        "salary/view/salary-detail?companyid=7"
                                ],
                                [
                                    "type" => "view",
                                    "name" => "调薪历史",
                                    "url" => $baseUrl .
                                        "salary/view/salary-query?companyid=7"
                                ],

                            ],
                        ]
                    ]

                ]
            ],
            '1000021' => [
                'agent_id' => 1000021,
                'secret' => '2pd7MU0h_Iy7A6NfouvgRhE7nwfJ3_Tp1UxpeTOBTw8',
                'menus' => [
                    'button' => [
                        [
                            "name" => "我的部属",
                            "type" => "view",
                            "url" => $baseUrl . "user/view/mydepartment?companyid=7"
                        ],
                        [
                            "name" => "部属考勤",
                            "type" => "view",

                            "url" => $baseUrl . "attendance/view/attendance-list?companyid=7"
                        ],


                    ]
                ],
                //...
            ],
            //...
        ],

        // 指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
        'response_type' => 'array',

        'log' => [
            'driver' => 'daily',
            'days' => 30,
            'level' => 'info',
            'file' => storage_path('logs/company7/wechat' . date('Y-m-d', time()) . '.log'),
        ],
        'default_agent' => '1000007'//default_agent

    ],
    'workchat8' => [
        'corp_id' => 'ww8c3f31fa68615880',

        // 应用列表
        'agents' => [
            'contacts' => [
                'agent_id' => '',
                'secret' => 'SDYZLuwzf3p3t3A9mCKTR6KTN2C6sSw-STep4DLCGeQ',
            ],
            '1000002' => [
                'agent_id' => '1000002',
                'secret' => 'zIUDtZQpF_uc4gkSYCZ5LyEI3xR9kTNR-X1TpEkq2aU',
            ],
            //...
        ],

        // 指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
        'response_type' => 'array',

        'log' => [
            'level' => 'debug',
            'file' => storage_path('logs/company8/wechat' . date('Y-m-d', time()) . '.log'),
        ],
        'default_agent' => '1000002'//default_agent
    ],
    'workchat11' => [
        'corp_id' => 'ww5cd27c9692016db4',

        // 应用列表
        'agents' => [
            'contacts' => [
                'agent_id' => '',
                'secret' => 'dPt2jan9PJwckNWl7f9JMax72gxAWnVY3zHZrGCMcCg',
            ],
            '1000005' => [
                'agent_id' => '1000005',
                'secret' => 'VWxPqH-TkIMc_Gk8W_9o74EO0QNlffy0mj6CMb9DE2I',
            ],
            '1000006' => [
                'agent_id' => '1000006',
                'secret' => 'dQidSiLGi2HYhaBDp7V2V8EtKjltze9sk-8nARij2Bw',
            ],
            '1000010' => [
                'agent_id' => '1000010',
                'secret' => 'yLe3VgHy5NEGLJg6RhMFRykhp6Dg6-IQGPEOmxufYIs',
            ],
            //...
        ],

        // 指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
        'response_type' => 'array',

        'log' => [
            'driver' => 'daily',
            'level' => 'info',
            'days' => 30,
            'file' => storage_path('logs/company11/wechat' . date('Y-m-d', time()) . '.log'),
        ],
        'default_agent' => '1000005'//default_agent
    ],
    'workchat12' => [
        'corp_id' => 'ww49eae41e5aa505f4',

        // 应用列表
        'agents' => [
            'contacts' => [
                'agent_id' => '',
                'secret' => 'uXtbVyxwT1VLorOoYk3631X9JDXFuKjssKvl8y7oYi4',
            ],
            '1000002' => [
                'agent_id' => '1000002',
                'secret' => 'YLCzVXBe5hxJcp1Iw5rF3TZUKCAkM4Zjl3qBA7lnOoQ',
            ],
            '1000003' => [
                'agent_id' => '1000003',
                'secret' => 'KqSWAp232Tj6YXZO6ZCA54x3WchOXrYKMPWYkyPsrYg',
            ],

        ],

        // 指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
        'response_type' => 'array',

        'log' => [
            'driver' => 'daily',
            'level' => 'info',
            'days' => 30,
            'file' => storage_path('logs/company12/wechat' . date('Y-m-d', time()) . '.log'),
        ],
        'default_agent' => '1000002'//default_agent
    ],
    'workchat13' => [
        'corp_id' => 'ww8c15f2da143a8333',

        // 应用列表
        'agents' => [
            'contacts' => [
                'agent_id' => '',
                'secret' => '9fHNxlIkyLvst08w8GLoNWSWRVGT8TgdHy1BSG_gYzk',
            ],
            '1000002' => [
                'agent_id' => '1000002',
                'secret' => 'vQuSXJXxKy2MEPz8A0qEUg641G2gEtlY0uGqg-JOfF0',
            ],
            '1000003' => [
                'agent_id' => '1000003',
                'secret' => 'HRh0ujdqC_JsAet8JT8fJzPFLA8QCr5M1BHQYqYSstc',
            ],
            //...
        ],

        // 指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
        'response_type' => 'array',

        'log' => [
            'driver' => 'daily',
            'level' => 'info',
            'days' => 30,
            'file' => storage_path('logs/company13/wechat' . date('Y-m-d', time()) . '.log'),
        ],
        'default_agent' => '1000002'//default_agent
    ],
    'workchat14' => [
        'corp_id' => 'wwe7b244e3cd6543f1',

        // 应用列表
        'agents' => [
            'contacts' => [
                'agent_id' => '',
                'secret' => '3ugTjMhiQ-CzCaKQEsFdbM3eNVA1OgIHghRTSF1gnzI',
            ],
            '1000002' => [
                'agent_id' => '1000002',
                'secret' => 'EMB_hzu-9646r9-QsDwhvKFochK6Fzl9SY92DqNUrVg',
            ],
            '1000003' => [
                'agent_id' => '1000003',
                'secret' => '2AR2EgoAeu8Lqx9f3kGIMJ6E6kw02BMZC6YkzcNeREE',
            ],
            //...
        ],

        // 指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
        'response_type' => 'array',

        'log' => [
            'driver' => 'daily',
            'level' => 'info',
            'days' => 30,
            'file' => storage_path('logs/company14/wechat' . date('Y-m-d', time()) . '.log'),
        ],
        'default_agent' => '1000002'//default_agent
    ],
    'workchat15' => [
        'corp_id' => 'ww9765e0fcef039aa8',

        // 应用列表
        'agents' => [
            'contacts' => [
                'agent_id' => '',
                'secret' => '_Tlr9obyGIbO11_p3p3mjJBJt16NvcDM7rxgxGOdC0M',
            ],
            '1000004' => [
                'agent_id' => '1000004',
                'secret' => 'QeLdy-GeUDNL1-4I9QvHj68olLZLBEQgICFvAcCvZHA',
            ],
            '1000005' => [
                'agent_id' => '1000005',
                'secret' => 'S8F85XVxd1WxgFrDi14qjGMcH4NY8rdnDO3VsdMDdQA',
            ],
            //...
        ],

        // 指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
        'response_type' => 'array',

        'log' => [
            'driver' => 'daily',
            'level' => 'info',
            'days' => 30,
            'file' => storage_path('logs/company15/wechat' . date('Y-m-d', time()) . '.log'),
        ],
        'default_agent' => '1000004'//default_agent
    ],
    'workchat16' => [
        'corp_id' => 'ww1822706a2e95d858',

        // 应用列表
        'agents' => [
            'contacts' => [
                'agent_id' => '',
                'secret' => 'px9FzhSjOWor2OWbehulzP5Vp9ylBjZUEZWwjAFCSXo',
            ],
            '1000014' => [
                'agent_id' => '1000014',
                'secret' => 'kGpo4pkgsB-h1cThmw3fj_IrvRujWI2zidxDjhVC2jw',
            ],
            '1000015' => [
                'agent_id' => '1000015',
                'secret' => 'Hf6JbGNT-Z8JJ05WLD82Nv4H6IAs_F-tTObuCvVJsjA',
            ],
            //...
        ],

        // 指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
        'response_type' => 'array',

        'log' => [
            'driver' => 'daily',
            'level' => 'info',
            'days' => 30,
            'file' => storage_path('logs/company16/wechat' . date('Y-m-d', time()) . '.log'),
        ],
        'default_agent' => '1000014'//default_agent
    ],
    'workchat17' => [
        'corp_id' => 'wwce107351b7c597f6',

        // 应用列表
        'agents' => [
            'contacts' => [
                'agent_id' => '',
                'secret' => 'K1rQDaOJKdcvxqDmNxxhYk8_7f-FTTNiXTy3eFhYQXc',
            ],
            '1000002' => [
                'agent_id' => '1000002',
                'secret' => 'dXDwTLqvzNocMoCqhSp9aoHtPdWUqOOlaRXcZsyd8sU',
            ],
            '1000003' => [
                'agent_id' => '1000003',
                'secret' => 'gleNySlQvd5SK0OyEm-wLO80jt_9-7NnyW6zLj7sXH4',
            ],

        ],

        // 指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
        'response_type' => 'array',

        'log' => [
            'driver' => 'daily',
            'level' => 'info',
            'days' => 30,
            'file' => storage_path('logs/company17/wechat' . date('Y-m-d', time()) . '.log'),
        ],
        'default_agent' => '1000002'//default_agent
    ],
    'workchat18' => [
        'corp_id' => 'ww4e8dfa3b4f663d9a',

        // 应用列表
        'agents' => [
            'contacts' => [
                'agent_id' => '',
                'secret' => 'zD1pBPAG5IjsodGAizfzHMe48aQ6KhA7gCNYAVdnAmI',
            ],
            '1000007' => [
                'agent_id' => '1000007',
                'secret' => 'MFxZm3Hd2kkXvPdmh35vErNsIksBmv3U8e8VhxZ5VA8',
            ],
            '1000008' => [
                'agent_id' => '1000008',
                'secret' => '5-xo9x7DfgZkEugTWZ4V3U-G88qZu52WsyeQmEaJZeo',
            ],

        ],

        // 指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
        'response_type' => 'array',

        'log' => [
            'driver' => 'daily',
            'level' => 'info',
            'days' => 30,
            'file' => storage_path('logs/company18/wechat' . date('Y-m-d', time()) . '.log'),
        ],
        'default_agent' => '1000007'//default_agent
    ],
    'workchat19' => [
        'corp_id' => 'wwbf97278f6c993d0e',

        // 应用列表
        'agents' => [
            'contacts' => [
                'agent_id' => '',
                'secret' => 'VCzx9xHda8wbfJ06w_jRH4suGMEVzEShfI5dnuqh74Q',
            ],
            '1000002' => [
                'agent_id' => '1000002',
                'secret' => 'BvqviHmA89YxGlZpnzxhj3UMB9oc7ktWYVgBoai6b1Q',
            ],
            '1000003' => [
                'agent_id' => '1000003',
                'secret' => 'uQT1fJsserTXCZR99wG75B7XZaBau6LzslF3kyQpfYg',
            ],

        ],

        // 指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
        'response_type' => 'array',

        'log' => [
            'driver' => 'daily',
            'level' => 'info',
            'days' => 30,
            'file' => storage_path('logs/company19/wechat' . date('Y-m-d', time()) . '.log'),
        ],
        'default_agent' => '1000002'//default_agent
    ],
    'workchat20' => [
        'corp_id' => 'ww9531f81ba4b8fdfd',

        // 应用列表
        'agents' => [
            'contacts' => [
                'agent_id' => '',
                'secret' => 'UzfvJ77kU8GMzqAXl1gniSWjNThCO1bLnzlQ9PZJkqg',
            ],
            '1000002' => [
                'agent_id' => '1000002',
                'secret' => 'EPaysbA5-Fb3Fu0-tOZyLZMaZrBKekJ5mdB9fpIrfpE',
            ],
            '1000003' => [
                'agent_id' => '1000003',
                'secret' => 'mkPlrwNrpM3_xdCkyzP5HujRGLgDJ3mj3Vs1qgveA3Y',
            ],
            'clock' => [
                'agent_id' => '3010011',
                'secret' => 'OwIxLMHpnoS-LA1D6QnQ52iRlRzNS5TXPGecispsN3w',
            ],

        ],

        // 指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
        'response_type' => 'array',

        'log' => [
            'driver' => 'daily',
            'level' => 'info',
            'days' => 30,
            'file' => storage_path('logs/company20/wechat' . date('Y-m-d', time()) . '.log'),
        ],
        'default_agent' => '1000002'//default_agent
    ],
    'workchat21' => [
        'corp_id' => 'ww047186a5dfd3c596',

        // 应用列表
        'agents' => [
            'contacts' => [
                'agent_id' => '',
                'secret' => 'Qx-r06pJE8cbQfR_wFh87nVgwgmHFRtLudVQ8MN1c_0',
            ],
            '1000002' => [
                'agent_id' => '1000002',
                'secret' => 'U1Tm7xq_ntuopDytkB00AoENr7ldBbYvTzCl0m0qPjs',
            ],
            '1000003' => [
                'agent_id' => '1000003',
                'secret' => 'mwCgKjTH2D1qxyQoM1EadZAyYlw8XG6CT8D5NdaQGWQ',
            ],
            'clock' => [
                'agent_id' => '3010011',
                'secret' => 'ItcmqfcvElJXWLYpCDQlhPwrDqN9Q4cTpUHkSwAOT3A',
            ],

        ],
        // 指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
        'response_type' => 'array',

        'log' => [
            'driver' => 'daily',
            'level' => 'info',
            'days' => 30,
            'file' => storage_path('logs/company21/wechat' . date('Y-m-d', time()) . '.log'),
        ],
        'default_agent' => '1000002'//default_agent
    ],
    'workchat22' => [
        'corp_id' => 'ww4f0d1ad348e49098',
        'agent_id' => 1000002,
        'secret' > 'OtY2hb1CtbMgCCN_0PNSKzJ6b1xcQO5QHubElJNvpPc',

        // 应用列表
        'agents' => [
            'contacts' => [
                'agent_id' => '',
                'secret' => 'FuubMdgidzdpk2BfbRJUcUfNU6CfvGnH1PNoq7y00_0',
            ],
            1000002 => [
                'agent_id' => 1000002,
                'secret' => 'OtY2hb1CtbMgCCN_0PNSKzJ6b1xcQO5QHubElJNvpPc',
                'menus' => [
                    'button' => [
                        [
                            "name" => "我的信息",
                            "sub_button" => [
                                [
                                    "type" => "view",
                                    "name" => "个人信息",
                                    "url" => $baseUrl .
                                        "user/view/userinfo?companyid=22"
                                ]
                            ],
                        ],
                        [
                            "name" => "我的考勤",
                            "sub_button" => [
                                [
                                    "type" => "view",
                                    "name" => "我的日历",
                                    "url" => $baseUrl .
                                        "attendance/view/canlendar?companyid=22"
                                ],
                                [
                                    "type" => "view",
                                    "name" => "我的考勤",
                                    "url" => $baseUrl .
                                        "attendance/view/summary?companyid=22"
                                ],
                                [
                                    "type" => "view",
                                    "name" => "我的可休假",
                                    "url" => $baseUrl .
                                        "holiday/view/all?companyid=22"
                                ],
                            ],
                        ],
                        [
                            "name" => "我的薪资",
                            "sub_button" => [
                                [
                                    "type" => "view",
                                    "name" => "薪资单",
                                    "url" => $baseUrl .
                                        "salary/view/salary-detail?companyid=22"
                                ],
                                [
                                    "type" => "view",
                                    "name" => "调薪历史",
                                    "url" => $baseUrl .
                                        "salary/view/salary-query?companyid=22"
                                ],

                            ],
                        ]
                    ]

                ]
            ],
            '1000003' => [
                'agent_id' => 1000003,
                'secret' => 'foNpeNjhJH2cT0ZRxiruUICHZhLWFzEt3EQ1QRWbtmk',
                'menus' => [
                    'button' => [
                        [
                            "name" => "我的部属",
                            "type" => "view",
                            "url" => $baseUrl . "user/view/mydepartment?companyid=22%26agtId=1000003"
                        ],
                        [
                            "name" => "部属考勤",
                            "type" => "view",

                            "url" => $baseUrl . "attendance/view/attendance-list?companyid=22%26agtId=1000003"
                        ],


                    ]
                ],
                //...
            ],
            //...
        ],

        // 指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
        'response_type' => 'array',

        'log' => [
            'driver' => 'daily',
            'days' => 30,
            'level' => 'info',
            'file' => storage_path('logs/company22/wechat' . date('Y-m-d', time()) . '.log'),
        ],
        'default_agent' => '1000002'//default_agent

    ],

    // WFJT湖北五方晶体有限公司
    'workchat24' => [
        'corp_id' => 'wwb66df70a9d534495',
        // 应用列表
        'agents' => [
            // 通讯录
            'contacts' => [
                'agent_id' => '',
                'secret' => 'caDI0z1iewUcnf76sLQpIBZREfHZW0il9iZhGwP5m_8',
            ],
            // 打卡
            'clock' => [
                'agent_id' => '3010011',
                'secret' => '030e0SmhajVB5VW541WydqIq9paFQJ48PV5x6wDoTEY',
            ],
            // 员工服务
            '1000002' => [
                'agent_id' => '1000002',
                'secret' => 'rZmFqA8yFSZhtI3Q1ysvpgGpMwgFwBKAgh2Ge798AE0',
                'menus' => [
                    'button' => [
                        [
                            "name" => "我的信息",
                            "sub_button" => [
                                [
                                    "type" => "view",
                                    "name" => "个人信息",
                                    "url" => $baseUrl . "user/view/userinfo?companyid=24"
                                ]
                            ],
                        ],
                        [
                            "name" => "我的考勤",
                            "sub_button" => [
                                [
                                    "type" => "view",
                                    "name" => "我的日历",
                                    "url" => $baseUrl . "attendance/view/canlendar?companyid=24"
                                ],
                                [
                                    "type" => "view",
                                    "name" => "我的考勤",
                                    "url" => $baseUrl . "attendance/view/summary?companyid=24"
                                ],
                                [
                                    "type" => "view",
                                    "name" => "我的可休假",
                                    "url" => $baseUrl . "holiday/view/all?companyid=24"
                                ],
                            ],
                        ],
                        [
                            "name" => "我的薪资",
                            "sub_button" => [
                                [
                                    "type" => "view",
                                    "name" => "薪资单",
                                    "url" => $baseUrl . "salary/view/salary-detail?companyid=24"
                                ],
                                [
                                    "type" => "view",
                                    "name" => "调薪历史",
                                    "url" => $baseUrl . "salary/view/salary-query?companyid=24"
                                ],

                            ],
                        ]
                    ]

                ]
            ],
            // 主管服务
            '1000003' => [
                'agent_id' => '1000003',
                'secret' => 'ethjUhiTuwzMfOmqCwsTRnWOVOzOJ7xGej8gmtEzJu0',
                'menus' => [
                    'button' => [
                        [
                            "name" => "我的部属",
                            "type" => "view",
                            "url" => $baseUrl . "user/view/mydepartment?companyid=24"
                        ],
                        [
                            "name" => "部属考勤",
                            "type" => "view",
                            "url" => $baseUrl . "attendance/view/attendance-list?companyid=24"
                        ],


                    ]
                ],
            ],


        ],
        // 指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
        'response_type' => 'array',
        'log' => [
            'driver' => 'daily',
            'level' => 'info',
            'days' => 30,
            'file' => storage_path('logs/company24/wechat' . date('Y-m-d', time()) . '.log'),
        ],
        'default_agent' => '1000002'//default_agent
    ],
];
