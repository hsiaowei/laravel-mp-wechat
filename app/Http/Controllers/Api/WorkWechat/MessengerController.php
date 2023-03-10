<?php

namespace App\Http\Controllers\Api\WorkWechat;

use EasyWeChat\Kernel\Exceptions\InvalidArgumentException;
use EasyWeChat\Kernel\Messages\News;
use EasyWeChat\Kernel\Messages\NewsItem;
use EasyWeChat\Kernel\Messages\TextCard;
use EasyWeChat\Kernel\Messages\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MessengerController extends WechatBaseController
{
    const MESSAGE_TEXT = 'text';
    const MESSAGE_IMAGE = 'image';
    const MESSAGE_VOICE = 'voice';
    const MESSAGE_VIDEO = 'video';
    const MESSAGE_FILE = 'file';
    const MESSAGE_TEXT_CARD = 'textcard';
    const MESSAGE_NEWS = 'news';
    const MESSAGE_MULTIPLE_NEWS = 'mpnews';
    protected $messenger;

    /**
     * Send WeChat Message
     * text - 文本消息
     * image - 图片消息
     * voice - 语音消息
     * video - 视频消息
     * file - 文件消息
     * textcard - 文本卡片消息
     * news - 图文消息
     * mpnews - 图文消息
     * @param Request $request
     * @return mixed
     * @author Dennis 2017/09/16
     */
    public function sendMessage($msg_type, Request $request)
    {
        try {
            // init the messenger variable
            $this->messenger = isset($request->agent_id) ?
                $this->workWeChat->agent($request->agent_id)->messenger :
                $this->defaultAgent->messenger;


            if ($msg_type != 'news') {
                //$this->messenger->secretive();
            }
            $Message = '';
            switch ($msg_type) {
                case self::MESSAGE_TEXT:
                    $Message = $this->newTextMessage($request);
                    break;
                case self::MESSAGE_TEXT_CARD:
                    $Message = $this->newTextCardMessage($request);
                    break;
                case self::MESSAGE_NEWS:
                case self::MESSAGE_MULTIPLE_NEWS:
                    $Message = $this->newNewsMessage($request);
                    break;
                case self::MESSAGE_FILE:
                case self::MESSAGE_VOICE:
                case self::MESSAGE_IMAGE:
                    $Message = $this->newMediaMessage($msg_type, $request);
                    break;
                case self::MESSAGE_VIDEO:
                    $Message = $this->newVideoMessage($request);
                    break;
                default:
                    break;
            }

            if ($request->touser) {
                $result = $Message->toUser($request->touser)->send();
            } elseif ($request->toparty) {
                $result = $Message->toParty($request->toparty)->send();
            } elseif ($request->totag) {
                $result = $Message->toTag($request->totag)->send();
            } else {
                return $this->responseError('无消息接收人(touser,toparty,totag 必须一个不为空)', 4401);
            }
            return $this->responseWeChat($result);

        } catch (InvalidArgumentException $e) {
            //$error_message = trans('WechatApi.agent_id_error', ['agent_id' => $request->agent_id]);
            $error_message = $e->getMessage();
            Log::error($error_message);
            return $this->responseError($error_message, $e->getCode());
        }
    }

    /**
     * Make text message instance
     * @param $request
     * @return mixed
     */
    private function newTextMessage(Request $request)
    {
        return $this->messenger->message($request->text);
    }

    private function newTextCardMessage(Request $request)
    {
        $TextCard = new TextCard([
            'title' => $request->title,
            'description' => $request->description,
            'url' => $request->url
        ]);
        return $this->messenger->message($TextCard);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    private function newNewsMessage(Request $request)
    {
        $NewsItem[] = new NewsItem([
            'title' => $request->title,
            'description' => $request->description,
            'url' => $request->url,
            'image' => $request->image,
        ]);
        $News = new News($NewsItem);
        return $this->messenger->message($News);
    }

    /**
     * Make media message instance
     * @param $request
     * @return mixed
     */
    private function newMediaMessage($msg_type, Request $request)
    {
        $MediaType = ucfirst(strtolower($msg_type));
        $MediaMessage = new $MediaType($request->media_id);
        return $this->messenger->message($MediaMessage);
    }

    private function newVideoMessage(Request $request)
    {
        $VideoMessage = new Video($request->media_id, [
            'title' => $request->title,
            'description' => $request->description,
            'media_id' => $request->media_id,
            'thumb_media_id' => $request->thumb_media_id
        ]);
        return $this->messenger->message($VideoMessage);
    }
}
