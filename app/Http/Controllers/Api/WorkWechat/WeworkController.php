<?php

namespace App\Http\Controllers\Api\WorkWechat;

use App\Models\SysWechatConfig;
use Config;
use EasyWeChat\Factory;
use EasyWeChat\Kernel\Messages\News;
use EasyWeChat\Kernel\Messages\NewsItem;
use EasyWeChat\Kernel\Messages\Text;
use EasyWeChat\Kernel\Messages\TextCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WeworkController extends WechatBaseController
{
    //
    protected $user;
    protected $department;
    protected $tag;
    protected $messenger;

    public function __construct()
    {

    }

    public function wxEntrance(Request $request)
    {
        try {
            $jsondata = $request->getContent();
            $jsondata = json_decode($jsondata, JSON_UNESCAPED_UNICODE);

            //rewrite construct
            if (!empty($jsondata['companyid'])) {
                $wx_config = Config::get('wechat.workchat' . $jsondata['companyid']);

                if (is_array($wx_config) && count($wx_config) > 0) {
                    $this->workWeChat = Factory::work($wx_config);
                    $this->defaultAgent = $this->workWeChat->agent($wx_config['default_agent']);
                } else {
                    return $this->success('3', '企业微信相关配置为空,请检查配置档');
                }

                $this->user = $this->workWeChat->agent('contacts')->user;
                $this->tag = $this->workWeChat->agent('contacts')->tag;
                $this->department = $this->workWeChat->agent('contacts')->department;

            }

            if (!empty($jsondata['type'])) {

                //参数大小写转换(首字母变成小写) 根据类型获取相应方法  然后调用方法
                $function = lcfirst($jsondata['type']);

                $result = $this->$function($jsondata);

                $result = json_encode($result, JSON_UNESCAPED_UNICODE);

                return $result;

            } else {
                return $this->success('3', '参数为空');
            }

        } catch (\Exception $ex) {
            Log::error($ex);
            return response()->json($this->fail($ex));
        }

    }

    /**
     * 创建成员
     *  addUsers
     * @param $data 新增成员数据
     *  "userid": "zhangsan", // required
     *  "name": "张三",        // required
     *  "department":
     * "mobile": "15913215421", // required
     *  ismanger：
     *  mtagid:
     *  etagid:
     * @Author: Lyn.zou <lyn.zou@areschina.com>
     * @CreateDate: 2018-03-21 17:15:17
     * @Version: 1.0
     * @return array 返回类型
     */
    public function addUsers($jsondata)
    {
        $res = [];
        foreach ($jsondata['data'] as $key => $val) {
            // change key CASE_LOWER

            $val = array_change_key_case($val, CASE_LOWER);
            //add user
            $userresult = $this->user->create($val);

            //如果成员新增成功则继续加入标签信息，否则放入新增失败
            if ($userresult['errcode'] == 0) {
                //add emp tag
                $tagResult = $this->tag->tagUsers($val['etagid'], [$val['userid']]);
                //判断成员标签是否创建成功，成功则继续判断是否主管，失败则记录
                if ($tagResult['errcode'] == 0) {
                    //add manger tag
                    if (!empty($val['mtagid'])) {
                        $manageResult = $this->tag->tagUsers($val['mtagid'], [$val['userid']]);
                        if ($manageResult['errcode'] != 0) {
                            $fail['userid'] = $val['userid'];
                            $fail['errmsg'] = $manageResult['errmsg'];
                            $res['fail']['managetag'][] = $fail;
                        }
                    }
                } else {
                    $fail['userid'] = $val['userid'];
                    $fail['errmsg'] = $tagResult['errmsg'];
                    $res['fail']['emptag'][] = $val['userid'];
                }
            } else {
                $fail['userid'] = $val['userid'];
                $fail['errmsg'] = $userresult['errmsg'];
                $res['fail']['create'][] = $fail;
            }
        }
        if (empty($res['fail'])) {
            $result['code'] = '0';
            $result['msg'] = 'success';
        } else {
            $result['code'] = '1';
            $result['msg'] = 'fail';
            $result['data'] = $res['fail'];
        }

        return $result;
    }

    /**
     * 更新成员
     *  addUsers
     * @param $data 更新成员数据
     *  "userid": "zhangsan", // required
     *  "name": "张三",
     *  "department":
     * "mobile": "15913215421",
     *  ismanger：
     *  mtagid:
     *  etagid:
     * @Author: Lyn.zou <lyn.zou@areschina.com>
     * @CreateDate: 2018-03-21 17:15:17
     * @Version: 1.0
     * @return array 返回类型
     */
    public function updateUsers($data)
    {

    }

    /**
     * 删除成员
     *  delUsers
     * @param $data 删除成员数据
     * userid"      required
     * @Author: Lyn.zou <lyn.zou@areschina.com>
     * @CreateDate: nowtime
     * @Version: 1.0
     * @return array 返回类型
     */
    public function delUsers($jsondata)
    {
        $res = [];
        foreach ($jsondata['data'] as $key => $val) {
            // change key CASE_LOWER
            $val = array_change_key_case($val, CASE_LOWER);
            //del user
            $userresult = $this->user->delete($val['userid']);
            if ($userresult['errcode'] != 0) {
                $res['fail'][] = $val['userid'];
            }
        }
        if (empty($res['fail'])) {
            $result['code'] = '0';
            $result['msg'] = 'success';
        } else {
            $result['code'] = '1';
            $result['msg'] = 'fail';
            $result['data'] = $res['fail'];
        }
        return $result;
    }

    /**
     * 获取用户状态
     *  GetUsersStatus
     * @param $data 查询数据
     * @Author: Lyn.zou <lyn.zou@areschina.com>
     * @CreateDate: 2018-03-21 17:15:20
     * @Version: 1.0
     * @return array 返回类型
     */
    public function getUsersStatus($jsondata)
    {
        $res = [];

        foreach ($jsondata['data'] as $key => $val) {
            // change key CASE_LOWER
            $val = array_change_key_case($val, CASE_LOWER);
            //del user
            $result = $this->user->get($val['userid']);
            //$result =  json_decode($result, JSON_UNESCAPED_UNICODE);

            // add 状态 3 ：表示没有加入通讯录
            //激活状态: 1=已激活，2=已禁用，4=未激活。
            //已激活代表已激活企业微信或已关注微信插件。未激活代表既未激活企业微信又未关注微信插件。
            if (empty($result['status'])) {
                $result['status'] = 3;
            }
            $res[$result['status']][] = $val['userid'] . (isset($result['name']) ? $result['name'] : '');
        }

        return $res;
    }

    /**
     * 给用户发送消息
     *  sendMessages
     * @param $data 消息内容
     * @Author: Lyn.zou <lyn.zou@areschina.com>
     * @CreateDate: nowtime
     * @Version: 1.0
     * @return array 返回类型
     */
    public function sendMessages($jsondata)
    {
        /*  目前写了text 和 textcard  news
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
                    break;
                case 'TEXT_CARD':
                    $Message = new TextCard(['title' => $val['title'],
                        'description' => $val['msgcontent'],
                        'url' => $val['url']
                    ]);
                    break;

                case 'NEWS':
                    $items = [
                        new NewsItem([
                            'title' => $val['title'],
                            'description' => $val['msgcontent'],
                            'url' => $val['url'],
                            'image' => $val['image'],
                            // ...
                        ]),
                    ];
                    $Message = new News($items);
                    break;
                default:
                    break;
            }

            $Message = $this->messenger->message($Message);
            $textRex = $Message->toUser($val['userid'])->send();

            //如果发送失败则记录并且返回
            if ($textRex['errcode'] != 0) {
                $res['fail'][] = [
                    'userid' => $val['userid'],
                    'errmsg' => $textRex['errmsg']
                ];
            }
        }

        if (empty($res['fail'])) {
            $result['code'] = '0';
            $result['msg'] = 'success';
        } else {
            $result['code'] = '1';
            $result['msg'] = 'fail';
            $result['data'] = $res['fail'];
        }
        return $result;
    }

}
