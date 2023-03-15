<?php

namespace App\Http\Controllers\Api\WorkWechat;

use App\Models\SysWechatConfig;
use Config;
use EasyWeChat\Factory;
use EasyWeChat\Kernel\Messages\Text;
use EasyWeChat\Kernel\Messages\TextCard;
use Illuminate\Http\Request;
use Log;

class WxController extends WechatBaseController
{
    //
    protected $workWeChat;
    protected $user;
    protected $departnnemt;
    protected $tag;
    protected $messenger;
    protected $oa;

    public function __construct()
    {

    }

    public function aa(Request $request)
    {
        dd($wx_config = Config::get('wechat.workchat'));
    }

    public function wxEntrance(Request $request)
    {
        $jsondata = $request->getContent();

        //	$jsondata =	'{"companyid":7,"agentid":"1000007","type":"SendMessage","data":[{"USERID":"ARESSZ325","AGENTID":"1000007","MSGTYPE":"TEXT","MSGCONTENT":"zyc您好,您于2019/04/29存在一筆考勤異常，異常類型：旷工,異常時間:2019/04/29 08:10:00~2019/04/29 17:10:00，請盡快處理，謝謝！","TITLE":"考勤异常","URL":"null"}]}';
        $jsondata = json_decode($jsondata, JSON_UNESCAPED_UNICODE);

        //rewrite construct
        if (!empty($jsondata['companyid'])) {
            $wx_config = Config::get('wechat.workchat' . $jsondata['companyid']);

            //dd($wx_config);
            if (is_array($wx_config) && count($wx_config) > 0) {
                $this->workWeChat = Factory::work($wx_config);

                $this->defaultAgent = $this->workWeChat->agent($wx_config['default_agent']);

            } else {
                return $this->responseError('企业微信相关配置为空,请检查配置档.', 404);
            }

            $this->user = $this->workWeChat->agent('contacts')->user;
            $this->tag = $this->workWeChat->agent('contacts')->tag;
            $this->departnnemt = $this->workWeChat->agent('contacts')->department;
        }

        if (!empty($jsondata['type'] && $jsondata['type'] == 'GetUsersStatus')) {
            /*"userid": "zhangsan", // required   */
            $res = [];
            foreach ($jsondata['data'] as $key => $val) {
                // change key CASE_LOWER
                $val = array_change_key_case($val, CASE_LOWER);
                //del user
                $result = $this->user->get($val['userid']);
                //$result =  json_decode($result, JSON_UNESCAPED_UNICODE);
                if (empty($result['status'])) $result['status'] = 3;
                $res[$result['status']][] = $val['userid'] . (isset($result['name']) ? $result['name'] : '');
                // add 状态 3 ：表示没有加入通讯录
                //激活状态: 1=已激活，2=已禁用，4=未激活。
                //已激活代表已激活企业微信或已关注微信插件。未激活代表既未激活企业微信又未关注微信插件。
            }
            //dd($res);
            $res = json_encode($res, JSON_UNESCAPED_UNICODE);
            return $res;

        }

        if (!empty($jsondata['type'] && $jsondata['type'] == 'GetUserStatus')) {
            /*"userid": "zhangsan", // required   */

            foreach ($jsondata['data'] as $key => $val) {
                // change key CASE_LOWER
                $val = array_change_key_case($val, CASE_LOWER);
                //del user
                $result = $this->user->get($val['userid']);
                //$result =  json_decode($result, JSON_UNESCAPED_UNICODE);
                //dd($result);
                if (empty($result['status'])) $result['status'] = 3;
                // add 状态 3 ：表示没有加入通讯录
                //激活状态: 1=已激活，2=已禁用，4=未激活。
                //已激活代表已激活企业微信或已关注微信插件。未激活代表既未激活企业微信又未关注微信插件。
            }
            return $result['status'];

        }

        if (!empty($jsondata['type'] && $jsondata['type'] == 'DelUser')) {
            /*"userid": "zhangsan", // required   */
            foreach ($jsondata['data'] as $key => $val) {
                // change key CASE_LOWER
                $val = array_change_key_case($val, CASE_LOWER);
                //del user
                $result = $this->user->delete($val['userid']);

            }
            return $result['errmsg'];

        }

        if (!empty($jsondata['type'] && $jsondata['type'] == 'DelUsers')) {
            /*"userid": "zhangsan", // required   */
            $userIds = [];
            foreach ($jsondata['data'] as $key => $val) {
                // change key CASE_LOWER
                $val = array_change_key_case($val, CASE_LOWER);
                //del user
                $result = $this->user->delete($val['userid']);
            }

            return 'success';

        }

        if (!empty($jsondata['type'] && $jsondata['type'] == 'AddUsers')) {
            /*
              *  "userid": "zhangsan", // required
              *  "name": "张三",        // required
              *  "department":
              * "mobile": "15913215421", // required
              *  ismanger：
              *  mtagid:
              *  etagid:
              */
            $manageIds = [];
            $empIds = [];
            $emps = [];
            $empTag = null;
            $manTag = null;
            $resMsg = '';
            foreach ($jsondata['data'] as $key => $val) {
                // change key CASE_LOWER
                $val = array_change_key_case($val, CASE_LOWER);

                $result = $this->user->create($val);
                //记录错误而且不是人员已存在
                if ($result['errcode'] != 0 && $result['errcode'] != 60104) {
                    $resMsg = $resMsg . $result['errmsg'];
                    Log::info($val['name'] . 'created filed.' . $val['userid'] . json_encode($result));
                }
                $emps[] = $val;
                $empIds[] = $val['userid'];
                if (!$empTag) {
                    $empTag = $val['etagid'];
                }
                if (!empty($val['mtagid'])) {
                    if (!$manTag) {
                        $manTag = $val['mtagid'];

                    }
                    $manageIds[] = $val['userid'];
                }

            }
            if ($empTag) {
                $this->tag->tagUsers(intval($empTag), $empIds);
            }

            if ($manTag) {
                $this->tag->tagUsers(intval($manTag), $manageIds);
            }
            if ($resMsg) {
                return $resMsg;
            } else {
                return 'success';
            }


        }

        if (!empty($jsondata['type'] && $jsondata['type'] == 'AddUser')) {
            /*
              *  "userid": "zhangsan", // required
              *  "name": "张三",        // required
              *  "department":
              * "mobile": "15913215421", // required
              *  ismanger：
              *  mtagid:
              *  etagid:
              */
            foreach ($jsondata['data'] as $key => $val) {
                // change key CASE_LOWER

                $val = array_change_key_case($val, CASE_LOWER);

                //add user
                $result = $this->user->create($val);

                //add emp tag
                $this->tag->tagUsers($val['etagid'], [$val['userid']]);

                //add manger tag
                if (!empty($val['mtagid'])) $this->tag->tagUsers($val['mtagid'], [$val['userid']]);

            }
            return $result['errmsg'];
        }

        if (!empty($jsondata['type'] && $jsondata['type'] == 'SendMessages')) {

            /*  目前只是写了text 和 textcard
              *  msgtype
              *  userid
              *  msgcontent:
              * title
               * url
              */
            $this->messenger = $this->workWeChat->agent($jsondata['agentid'])->messenger;
            foreach ($jsondata['data'] as $key => $val) {
                // change key CASE_LOWER
                $val = array_change_key_case($val, CASE_LOWER);
                $Message = '';
                switch ($val['msgtype']) {
                    case 'TEXT':
                        $Message = new Text($val['msgcontent']);
                        $Message = $this->messenger->message($Message);
                        break;
                    case 'TEXT_CARD':
                        $Message = new TextCard(['title' => $val['title'],
                            'description' => $val['msgcontent'],
                            'url' => $val['url']
                        ]);
                        $Message = $this->messenger->message($Message);
                        break;
                    default:
                        break;
                }
                //dd($Message);
                $result = $Message->toUser($val['userid'])->send();
                //return  $result;

            }
            return 'success';
        }

        if (!empty($jsondata['type'] && $jsondata['type'] == 'SendMessage')) {
            /*  目前只是写了text 和 textcard
              *  msgtype
              *  userid
              *  msgcontent:
              * title
               * url
              */


            $this->messenger = $this->workWeChat->agent($jsondata['agentid'])->messenger;
            foreach ($jsondata['data'] as $key => $val) {
                // change key CASE_LOWER
                $val = array_change_key_case($val, CASE_LOWER);
                $Message = '';
                switch ($val['msgtype']) {
                    case 'TEXT':
                        $Message = new Text($val['msgcontent']);
                        $Message = $this->messenger->message($Message);
                        break;
                    case 'TEXT_CARD':
                        $Message = new TextCard(['title' => $val['title'],
                            'description' => $val['msgcontent'],
                            'url' => $val['url']
                        ]);
                        $Message = $this->messenger->message($Message);
                        break;
                    default:
                        break;
                }
                //dd($Message);
                $result = $Message->toUser($val['userid'])->send();
                //return  $result;

            }
            return $result['errmsg'];
        }

    }

    /**
     * 删除微信通讯录用户
     *  deleteWeChatUser
     * @param mixed $fixed参数一的说明
     * @Author: Lyn.zou <lyn.zou@areschina.com>
     * @CreateDate: 2019-06-17 09:19:38
     * @Version: 1.0
     * @return array 返回类型
     */
    public function deleteWeChatUser($companyid, $userIds)
    {
        if (!empty($companyid)) {
            $wx_config = Config::get('wechat.workchat' . $companyid);

            if (is_array($wx_config) && count($wx_config) > 0) {
                $this->workWeChat = Factory::work($wx_config);

                $this->defaultAgent = $this->workWeChat->agent($wx_config['default_agent']);

            } else {
                return $this->responseError('企业微信相关配置为空,请检查配置档.', 404);
            }

            $this->user = $this->workWeChat->agent('contacts')->user;

            $result = $this->user->delete($userIds);

            return $result;
        } else {
            return $this->responseError('缺少公司别.', 404);
        }

    }


    /**
     * 获取打卡数据
     *  getPunchClockInfo
     * @param mixed $fixed参数一的说明
     * @Author: Lyn.zou <lyn.zou@areschina.com>
     * @CreateDate: 2020-02-18 14:19:38
     * @Version: 1.0
     * @return array 返回类型
     */
    public function getPunchClockInfo(Request $request)
    {
        $jsondata = $request->getContent();
        $jsondata = json_decode($jsondata, JSON_UNESCAPED_UNICODE);

        if (!empty($jsondata['companyid'])) {
            $wx_config = Config::get('wechat.workchat' . $jsondata['companyid']);

            if (is_array($wx_config) && count($wx_config) > 0) {
                $this->workWeChat = Factory::work($wx_config);

                $start = strtotime($jsondata['start']);
                $end = strtotime($jsondata['end']);
                $userIds = $jsondata['userids'];

                $this->oa = $this->workWeChat->agent('clock')->oa;
                $result = $this->oa->checkinRecords($start, $end, $userIds);

                if ($result['errcode'] == 0 && count($result['checkindata']) > 0) {
                    $result['checkindata'] = $this->dealClockResult($result['checkindata']);
                }
                return [
                    'code' => $result['errcode'],
                    'msg' => $result['errmsg'],
                    'data' => $result['checkindata']
                ];

            } else {
                return $this->responseError('企业微信相关配置为空,请检查配置档.', 404);
            }

        } else {
            return $this->responseError('缺少公司别.', 404);
        }

    }

    public function dealClockResult($data)
    {
        $result = array();

        foreach ($data as $key => $val) {
            $result[] = [
                'emp_no' => $val['userid'],
                'time' => date("Y-m-d H:i:s", $val['checkin_time']),
                'type' => $val['checkin_type'] === '上班打卡' ? 'up' : 'low',
                'exception' => $val['exception_type']
            ];

        }

        return $result;

    }

    /**
     * 给应用创建菜单
     *  createAgentMenu
     * @param mixed $fixed参数一的说明
     * @Author: Lyn.zou <lyn.zou@areschina.com>
     * @CreateDate: 2020-08-21 08:54:13
     * @Version: 1.0
     * @return array 返回类型
     */
    public function createAgentMenu(Request $request)
    {
        $jsonData = $request->only('company_id', 'agent_id');
        if (!$jsonData) {
            $jsonStr = $request->getContent();
            $jsonData = json_decode($jsonStr, JSON_UNESCAPED_UNICODE);
        }


        if ($jsonData) {
            $companyId = $jsonData['company_id'];
            if (!$companyId) {
                return $this->responseError('缺少公司别.', 403);
            }

            $agentId = isset($jsonData['agent_id']) ? $jsonData['agent_id'] : null;


            $wx_config = $this->initWechatConfig($companyId, $agentId);

            if (!$wx_config) {
                return $this->responseError('公司别有误，请传入正确公司别', 403);
            }

            $menus = $wx_config['menus'];


            $this->workWeChat = Factory::work($wx_config)->agent($agentId);


            $result = $this->workWeChat->menu->create($menus);


            return $result;
        } else {
            return $this->responseError('请传入正确的json字符串.', 403);
        }


    }


}
