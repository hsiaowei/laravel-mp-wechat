<?php

namespace App\Http\Middleware;

use Closure;
use EasyWeChat\Factory;
use Illuminate\Support\Facades\Session;
use Log;


class WeChatAuth
{

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param $scope snsapi_base：静默授权，可获取成员的基础信息；
     *              已移除 snsapi_userinfo：静默授权，可获取成员的详细信息，但不包含手机、邮箱；
     *               snsapi_privateinfo：手动授权，可获取成员的详细信息，包含手机、邮箱。
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // 微信浏览器验证
        if (!strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger')) {
            //return new Response('Forbidden: 请在微信客户端打开链接', 403);
            return Response()->view("Layout.WechatError");
        }
        // 跳转地址
        $callback_uri = $_SERVER['APP_URL'] . '/wechat/callback?uri=' . urlencode($request->fullUrl());

        // 获取用户信息
        $empUser = Session::get("wechat_user_info", []);
        // 未登录
        //Log::info('auth>user:' . json_encode($empUser));
        //dd($empUser,empty($empUser));
        if (empty($empUser)) {
            $wechatUser = Session::get("wechat_user", []);
            //Log::info('auth>wechat_user:' . json_encode($wechatUser));
            // 未授权
            if (empty($wechatUser)) {
                //Log::info('未授权跳转');
                // 配置信息
                $config = config('wechat.official_account.default');
//                $config['oauth'] = [
//                     'scopes' => ['snsapi_userinfo'],
//                     'callback' => $callback_uri,
//                 ];
                $app = Factory::officialAccount($config);
                //dd($callback_uri,$request->getBaseUrl(),$request);
                //Log::info('auth>callback_uri:' . $callback_uri);
                return $app->oauth->scopes(['snsapi_userinfo'])
                    ->redirect($callback_uri);
            } else {
                return redirect('/userBind');
            }
        }
        return $next($request);
    }

}
