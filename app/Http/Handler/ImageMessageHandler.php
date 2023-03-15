<?php

namespace App\Http\Handler;

use EasyWeChat\Kernel\Contracts\EventHandlerInterface;
use Log;

/**
 * 图片消息处理器
 *
 * @author hsiaowei
 * @date  2023/3/3
 */
class ImageMessageHandler implements EventHandlerInterface
{

    /**
     * @param array $payload ={"ToUserName":"gh_129c4089ee6d","FromUserName":"oziq_s1a4s_bCkp05yOXFhaoEW7U","CreateTime":"1677812502","MsgType":"image","PicUrl":"http://mmbiz.qpic.cn/mmbiz_jpg/EC1fbN3h7YTsgmbVbJuOGtKXYkbRLbHibxpvDiaggtS4b8j85FQqyBbX3HPCcpYbc0hVBfeg7sIjEcC8XCfPOvmA/0","MsgId":"24020498219482586","MediaId":"2buuEZR0SNa3hzJGgf5W7-Cw0l_ZJCfnt2qN8isGpfwqcFZT1aysK8Trc0c0vC93"}
     * @return string
     */
    public function handle($payload = [])
    {
        // 图片消息处理器
        Log::info("收到图片消息", $payload);
        //return "已收到图片消息";
    }
}