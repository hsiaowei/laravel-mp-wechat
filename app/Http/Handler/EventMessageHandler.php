<?php

namespace App\Http\Handler;

use EasyWeChat\Kernel\Contracts\EventHandlerInterface;
use Log;

/**
 * 文本消息处理器
 *
 * @author hsiaowei
 * @date  2023/3/2
 */
class EventMessageHandler implements EventHandlerInterface
{

    /**
     * @param array $payload ={"ToUserName":"gh_129c4089ee6d","FromUserName":"oziq_s1a4s_bCkp05yOXFhaoEW7U","CreateTime":"1677754028","MsgType":"event","Event":"subscribe","EventKey":null}
     * @return string
     */
    public function handle($payload = [])
    {
        // 收到事件消息
        Log::info("收到事件消息", $payload);
        switch ($payload['Event']) {
            case 'subscribe':
                //return "欢迎关注 HCP-微信服务号！";
                return "你好呀~欢迎关注HCP微服务!

HCP微服务可供企业员工方便快捷查询个人基本信息、考勤以及薪酬类等信息。

点此<a href ='".env('APP_URL') ."/user/view/userinfo'>验证身份绑定账号</a>";
                break;
            case 'unsubscribe':
                return "期待再次关注 HCP-微信服务号！";
                break;
            // ... 其它消息
            default:
                //return '收到其它事件消息';
                break;
        }
    }

}