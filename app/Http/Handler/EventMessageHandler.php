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
                return "欢迎关注 HCP-微信服务号！";
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