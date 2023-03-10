<?php

namespace App\Http\Controllers\Api\WorkWechat;

use Illuminate\Http\Request;

class UserController extends WechatBaseController
{
    protected $user;

    public function __construct()
    {
        parent::__construct();
        $this->user = $this->workWeChat->agent('contacts')->user;
    }

    /**
     * Create new contact
     * {
     * "userid": "zhangsan", // required
     * "name": "张三",        // required
     * "english_name": "jackzhang"
     * "mobile": "15913215421",
     * "department": [1, 2],
     * "order":[10,40],
     * "position": "产品经理",
     * "gender": "1",
     * "email": "zhangsan@gzdev.com",
     * "isleader": 1,
     * "enable":1,
     * "avatar_mediaid": "2-G6nrLmr5EC3MNb_-zL1dDdzkd0p7cNliYu9V5w7o8K0",
     * "telephone": "020-123456"，
     * "extattr": {"attrs":[{"name":"爱好","value":"旅游"},{"name":"卡号","value":"1234567234"}]}
     * }
     * 参数               必须    说明
     * access_token     是    调用接口凭证
     * userid           是    成员UserID。对应管理端的帐号，企业内必须唯一。不区分大小写，长度为1~64个字节
     * name             是    成员名称。长度为1~64个字节
     * english_name     否    英文名。长度为1-64个字节。
     * mobile           否    手机号码。企业内必须唯一，mobile/email二者不能同时为空
     * department       是    成员所属部门id列表,不超过20个
     * order            否    部门内的排序值，默认为0。数量必须和department一致，数值越大排序越前面。有效的值范围是[0, 2^32)
     * position         否    职位信息。长度为0~64个字节
     * gender           否    性别。1表示男性，2表示女性
     * email            否    邮箱。长度为0~64个字节。企业内必须唯一，mobile/email二者不能同时为空
     * telephone        否    座机。长度0-64个字节。
     * isleader         否    上级字段，标识是否为上级。
     * avatar_mediaid   否    成员头像的mediaid，通过多媒体接口上传图片获得的mediaid
     * enable           否    启用/禁用成员。1表示启用成员，0表示禁用成员
     * extattr          否    自定义字段。自定义字段需要先在WEB管理端“我的企业” — “通讯录管理”添加，否则忽略未知属性的赋值
     * @param Request $request
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     */
    public function addUser(Request $request)
    {
//        $this->validateWith($request, [
//            "userid" => "required",
//            "name" => "required",
//            "mobile" => "required",
//            'department' => "required"
//        ]);

        $user = [
            "userid" => $request->input('userid'),
            "name" => $request->input('name'),
            "english_name" => $request->input('english_name'),
            "mobile" => $request->input('mobile'),
            'department' => explode('|', $request->input('department')),
            'order' => $request->order,
            'position' => $request->position,
            'gender' => $request->gender,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'isleader' => $request->isleader,
            'enable' => 1,
            'extrattr' => $request->extrattr
        ];
        // create user
        $result = $this->user->create($user);
        return $this->responseWeChat($result);
    }

    /**
     * get contact info by user id
     * @param string $userid
     * @return mixed
     */
    public function getUserById($userid)
    {
        $result = $this->user->get($userid);
        return $this->responseWeChat($result);
    }

    /**
     * Get user list by department id
     * @param Request $request
     * @return mixed
     */
    public function getUsersByDept(Request $request)
    {
        $get_users_method = $request->with_detail ?
            'getDetailedDepartmentUsers' :
            'getDepartmentUsers';
        $contact_list = $this->user->$get_users_method(
            $request->department_id,
            $request->fetch_child);
        return $this->responseSuccess($contact_list);
    }

    public function updateUser(Request $request)
    {
        $user = [
            "userid" => $request->input('userid'),
            "name" => $request->input('name'),
            "english_name" => $request->input('english_name'),
            "mobile" => $request->input('mobile'),
            'department' => explode('|', $request->input('department')),
            'order' => $request->order,
            'position' => $request->position,
            'gender' => $request->gender,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'isleader' => $request->isleader,
            'enable' => 1,
            'extrattr' => $request->extrattr
        ];
        $result = $this->user->update($request->userid, $user);
        return $this->responseWeChat($result);
    }

    /**
     * delete contact by user id
     * @param string $user_id
     * @return mixed
     */
    public function deleteUserById($user_id)
    {
        $result = $this->user->delete($user_id);
        return $this->responseWeChat($result);
    }

    // fixme SDK Issue "code":40063,"msg":"参数为空"
    public function batchDeleteUsers(Request $request)
    {
        $user_ids = explode('|', $request->userid);
        $result = $this->user->batchDelete($user_ids);
        return $this->responseWeChat($result);
    }

    public function getOpenIdByUserId(Request $request)
    {
        return $this->responseWeChat($this->user->userIdToOpenid($request->userid));
    }

    public function getUserIdByOpenId(Request $request)
    {
        return $this->responseWeChat($this->user->openidToUserId($request->openid));
    }

    /**
     * 二步验证
     * @param Request $request
     * @return mixed
     */
    public function twoStepAuth(Request $request)
    {
        return $this->responseWeChat($this->user->accept($request->userid));
    }
}
