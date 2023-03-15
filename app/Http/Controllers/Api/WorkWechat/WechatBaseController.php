<?php

namespace App\Http\Controllers\Api\WorkWechat;

use App\Http\Controllers\Api\ApiBaseController;
use App\Models\SysWechatConfig;
use Config;
use EasyWeChat\Factory;

class WechatBaseController extends ApiBaseController
{
    protected $workWeChat;
    protected $defaultAgent;

    public function __construct()
    {
        $wx_config = Config::get('wechat.workchat');
        //dd($wx_config);
        if (is_array($wx_config) && count($wx_config) > 0) {
            $this->workWeChat = Factory::work($wx_config);
            $this->defaultAgent = $this->workWeChat->agent($wx_config['default_agent']);
        } else {
            $this->responseError('企业微信相关配置为空,请检查配置档.', 404);
        }
    }

    /**
     * 初始化WX配置数据
     * @param array $data
     * @return mixed
     */
    public function initWechatConfig($companyId, $agentId = null)
    {
        $wx_config = Config::get('wechat.workchat' . $companyId);

        if (!$wx_config) {
            return false;

        }
        $agentId = $agentId ? $agentId : $wx_config['agents'][$wx_config['default_agent']]['agent_id'];
        $agent_secret_key = $wx_config['agents'][$agentId]['secret'];
        $menus = $wx_config['agents'][$agentId]['menus'];

        $wx_config['agent_id'] = $agentId;
        $wx_config['secret'] = $agent_secret_key;
        $wx_config['menus'] = $menus;


        $result = array(
            'corp_id' => $wx_config['corp_id'],
            'agent_id' => $agentId,
            'secret' => $agent_secret_key,
            'response_type' => $wx_config['response_type'],
            'log' => $wx_config['log'],
            'agents' => $wx_config['agents'],

            'menus' => $menus,
        );
        $this->workWeChat = Factory::work($result);
        $this->defaultAgent = $this->workWeChat->agent($agentId);
        return $result;
    }

    /**
     * WorkWeChat API response the same format JSON data
     * @param array $data
     * @return mixed
     */
    public function responseWeChat($data)
    {
        // Call WorkWeChat API Successfully
        if ($data['errcode'] == '0') {
            return $this->responseSuccess($data);
        }
        // get error message from config file
        // reference https://work.weixin.qq.com/api/doc#10649
        return $this->responseError(
            Config::get('wechat_errors.' . $data['errcode']),
            $data['errcode']
        );
    }
}
