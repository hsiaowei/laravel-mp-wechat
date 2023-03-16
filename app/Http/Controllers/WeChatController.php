<?php

namespace App\Http\Controllers;

use App\Http\Handler\EventMessageHandler;
use App\Http\Handler\ImageMessageHandler;
use App\Http\Handler\MediaMessageHandler;
use App\Http\Handler\OtherMessageHandler;
use App\Http\Handler\TextMessageHandler;
use App\Models\Hr\User;
use EasyWeChat\Factory;
use EasyWeChat\Kernel\Exceptions\InvalidArgumentException;
use EasyWeChat\Kernel\Messages\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Log;

class WeChatController extends Controller
{
    /**
     * 处理微信的请求消息
     *
     * @return string
     */
    public function serve()
    {
        $config = config('wechat.official_account.default');
        //dd($config);
        $app = Factory::officialAccount($config);

        /*$server = $app->server;
        $server->push(function ($message) use ($user) {
            $fromUser = $user->get($message['FromUserName']);

            Log::info($fromUser, $message);
            return "欢迎关注 HCP-微信服务号！";

            switch ($message['MsgType']) {
                case 'event':
                    return '收到事件消息';
                    break;
                case 'text':
                    return '收到文字消息';
                    break;
                case 'image':
                    return '收到图片消息';
                    break;
                case 'voice':
                    return '收到语音消息';
                    break;
                case 'video':
                    return '收到视频消息';
                    break;
                case 'location':
                    return '收到坐标消息';
                    break;
                case 'link':
                    return '收到链接消息';
                    break;
                case 'file':
                    return '收到文件消息';
                // ... 其它消息
                default:
                    return '收到其它消息';
                    break;
            }
            return "{$fromUser->nickname} 欢迎关注 HCP-微信服务号！";
        });
        return $server->serve();*/
        try {
            // 事件消息
            $app->server->push(EventMessageHandler::class, Message::EVENT);
            // 文本消息
            $app->server->push(TextMessageHandler::class, Message::TEXT);
            // 图片消息
            $app->server->push(ImageMessageHandler::class, Message::IMAGE);
            // 同时处理多种类型的处理器(语音消息&视频消息&坐标消息&链接消息&文件消息) 当消息为任意一种都可触发
            $app->server->push(MediaMessageHandler::class, Message::VOICE | Message::SHORT_VIDEO | Message::VIDEO | Message::LOCATION | Message::LINK | Message::FILE);
            // 其他消息
            $app->server->push(OtherMessageHandler::class, Message::DEVICE_EVENT | Message::DEVICE_TEXT | Message::TEXT_CARD | Message::TRANSFER);

            return $app->server->serve();
        } catch (InvalidArgumentException $e) {
            Log::info("处理消息异常:", $e);
        }
    }

    /**
     * 处理微信的请求消息
     *
     * @return string
     */
    public function menu()
    {
        $options = config('wechat.official_account.default');
        $app = Factory::officialAccount($options);
        $buttons = [
            [
                "type" => "view",
                "name" => "主页",
                "url" =>  env('APP_URL')."/user/view/home"
            ],
            /*[
                "name"       => "菜单",
                "sub_button" => [
                    [
                        "type" => "view",
                        "name" => "搜索",
                        "url"  => "http://www.soso.com/"
                    ],
                    [
                        "type" => "view",
                        "name" => "视频",
                        "url"  => "http://v.qq.com/"
                    ],
                    [
                        "type" => "click",
                        "name" => "赞一下我们",
                        "key" => "V1001_GOOD"
                    ],
                ],
            ],*/
        ];
        $app->menu->create($buttons);
    }

    /**
     * 处理微信的请求消息
     *
     * @return string
     */
    public function templateMessage()
    {
        $options = config('wechat.official_account.default');
        $app = Factory::officialAccount($options);

        $empName = '张三';
        $type = '旷工';
        $date = '2023/03/02';
        $begin = '2023/03/02 08:30';
        $end = '2023/03/02 17:30';
        $app->template_message->send([
            'touser' => 'o7Jpk6Dqi-iH3gXIK3oy8LWqZeno',
            'template_id' => 'p2mZFJg8OYeT_ePsn4Zuob5RzaFly-lPfh2v9bw6DEc',
            'url' => env('APP_URL') . '/user/view/home',
            'scene' => 1000,
            'data' => [
                'first' => $empName . '您好，您于' . $date . '存在一笔 ' . $type . ' 类型的考勤异常',
                'keyword1' => $begin,
                'keyword2' => $end,
                'remark' => '请尽快处理，谢谢!'
            ],
        ]);

        /*        $message = new Text('考勤异常通知
                张三您好，您于2023/03/02存在一笔 旷工类型的考勤异常考勤异常开始日期: 2023/03/02 08:30考勤异常结束日期:2023/03/02 17:30请尽快处理，谢谢!');

                $result = $app->customer_service->message($message)->to('o7Jpk6Dqi-iH3gXIK3oy8LWqZeno')->send();*/


        /*$app->template_message->send([
            'touser' => 'oziq_s1a4s_bCkp05yOXFhaoEW7U',
            'template_id' => 'p2mZFJg8OYeT_ePsn4Zuob5RzaFly-lPfh2v9bw6DEc',
            'url' => env('APP_URL').'/user/view/home',
            'scene' => 1000,
            'data' => [
                'empName' => '张三',
                'date' => '2023/03/02',
                'type' => '忘刷',
                'time' => '2023/03/02 08:30~2023/03/02 17:30'
            ],
        ]);*/
    }

    /**
     * 处理微信的请求消息
     *
     * @return string
     */
    public function callback(Request $request)
    {
        // 跳转地址
        $redirect_uri = urldecode($request->query("uri", "/"));
        $empUser = Session::get("wechat_user_info", []);
        // 未登录
        Log::info('call>user:' . json_encode($empUser));
        $callback_uri = $_SERVER['APP_URL'] . '/wechat/callback?uri=' . urlencode($redirect_uri);
        // 配置信息
        //dd($empUser,$wechatUser);
        if (empty($empUser)) {
            // 已获取授权
            $wechatUser = Session::get("wechat_user", []);
            Log::info("call>session微信用户信息", $wechatUser);
            //dd($empUser);
            if (empty($wechatUser)) {

                $config = config('wechat.official_account.default');
                $config['oauth'] = [
                    'scopes' => ['snsapi_userinfo'],
                    'callback' => $callback_uri,
                ];
                $app = Factory::officialAccount($config);
                // 注意获取到的user()是object
                $wechatUser = $app->oauth->user()->toArray();
                Log::info("call>获取到微信用户信息", $wechatUser);
                if (empty($wechatUser)) {
                    return $app->oauth->redirect();
                }
                // 用户授权信息保存到session
                Session::put('wechat_user', $wechatUser);
            }
            //dd($wechatUser, $wechatUser['id'], $request,session());
            // 判断用户是否绑定
            $empUser = User::where('openid', '=', $wechatUser['id'])->first();
            if (empty($empUser)) {
                return redirect('/userBind');
            }
        }
        // 缓存信息
        Session::put('wechat_user_info', $empUser);
        Session::put('companyId', $empUser['company_id']);
        Session::put('empNo', $empUser['emp_no']);
        // by Hsiaowei Debug
        if ($wechatUser['name'] == 'Hsiaowei') {
            Session::put('empNo', str_replace('-A', '', $empUser['emp_no']));
        }

        return redirect($redirect_uri);
    }

}