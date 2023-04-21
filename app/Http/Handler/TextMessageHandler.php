<?php

namespace App\Http\Handler;

use EasyWeChat\Kernel\Contracts\EventHandlerInterface;
use Log;

/**
 * 文本消息处理类
 *
 * @author hsiaowei
 * @date  2023/3/3
 */
class TextMessageHandler implements EventHandlerInterface
{

    /**
     * @param array $payload ={"ToUserName":"gh_129c4089ee6d","FromUserName":"oziq_s1a4s_bCkp05yOXFhaoEW7U","CreateTime":"1677812360","MsgType":"text","Content":"1","MsgId":"24020493868380089"}
     * @return string
     */
    public function handle($payload = [])
    {
        // 文本消息处理
        switch ($payload['Content']) {
            case '清理登录缓存':
                $url = url('/tools/session/flush');
                return "<a href='$url'>点击我清理缓存</a>";
                break;
            case '考勤':
                $url = url('attendance/view/attendance-check');
                return "<a href='$url'>考勤确认</a>";
                break;
            default :
                //return "收到文本消息内容为：".$payload['Content'];
        }
    }

}