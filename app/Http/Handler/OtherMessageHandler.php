<?php

namespace App\Http\Handler;

use EasyWeChat\Kernel\Contracts\EventHandlerInterface;

/**
 * 其他消息处理器
 *
 * @author hsiaowei
 * @date  2023/3/3
 */
class OtherMessageHandler implements EventHandlerInterface
{

    /**
     * @param array $payload
     */
    public function handle($payload = [])
    {
        // Message::DEVICE_EVENT | Message::DEVICE_TEXT | Message::TEXT_CARD | Message::TRANSFER
        Log::info("其他消息", $payload);
        //return '收到其他类型消息';
    }
}