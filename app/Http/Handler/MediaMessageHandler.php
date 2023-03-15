<?php

namespace App\Http\Handler;

use EasyWeChat\Kernel\Contracts\EventHandlerInterface;
use Log;

/**
 * 同时处理多种类型的处理器(语音消息&视频消息&坐标消息&链接消息&文件消息)
 *
 * @author hsiaowei
 * @date  2023/3/3
 */
class MediaMessageHandler implements EventHandlerInterface
{

    /**
     * @param array $payload =
     * 坐标消息={"ToUserName":"gh_129c4089ee6d","FromUserName":"oziq_s1a4s_bCkp05yOXFhaoEW7U","CreateTime":"1677812721","MsgType":"location","Location_X":"31.294686","Location_Y":"120.669951","Scale":"15","Label":"江苏省苏州市苏州工业园区园南路","MsgId":"24020503084494457"}
     * @return string
     */
    public function handle($payload = [])
    {
        // Message::VOICE | Message::SHORT_VIDEO | Message::VIDEO | Message::LOCATION | Message::LINK | Message::FILE);
        Log::info("多种类型消息", $payload);
        switch ($payload['MsgType']) {
            case 'voice':
                //return "已收到语音消息！";
                break;
            case 'video':
            case 'shortvideo':
                //return "已收到视频消息！";
                break;
            case 'location':
                //return "已收到位置消息！";
                break;
            case 'link':
                //return "已收到链接消息！";
                break;
            case 'file':
                //return "已收到文件消息！";
                break;
            // ... 其它消息
            default:
                //return '收到多种类型其它消息';
        }
    }
}