<?php

namespace App\Http\Controllers\Api\HrService;

use App\Http\Controllers\Api\WorkWechat\WxController;
use App\Http\Controllers\Controller;
use App\Models\Hr\Leader;
use App\Models\Hr\User;
use App\Models\WxVerifyCode;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Log;

class UserController extends Controller
{

    // 验证码默认有效期十分钟 60 * 10
    const VERIFY_CODE_EFFECTIVE = 600;

    //
    protected $user;
    protected $leader;
    protected $tag;
    protected $messenger;

    public function __construct(User $user, Leader $leader)
    {
        $this->user = $user;
        $this->leader = $leader;
    }


    /**
     * 获取用户是否存在
     *  getUserExist
     * @param Request $request
     * @param mixed $fixed参数一的说明
     * @Author: Lyn.zou <lyn.zou@areschina.com>
     * @CreateDate: nowtime
     * @Version: 1.0
     * @return array 返回类型
     */
    public function getUserExist(Request $request)
    {
        $this->validate($request, [
            'iphone' => 'required',
            'idcard' => 'required',
        ]);
        $iphone = $request->get('iphone');
        $idcard = $request->get('idcard');
        //查询信息
        $userinfo = $this->user->getUserInfoByIphone($iphone);
        if ($userinfo) {
            if (empty($userinfo['emp_credentials'])) {
                $result = $this->success(1, '此人身份信息未维护，请联系管理员!');
            } else {
                $emp_credentials = json_decode($userinfo['emp_credentials'], true);
                foreach ($emp_credentials as $credentials) {
                    if ($credentials['credentialsno'] == $idcard) {
                        return $this->success(0, '验证成功', $userinfo);
                    }
                }
                $result = $this->success(1, '此人身份信息不正确，请检查身份证号!');
            }
        } else {
            $result = $this->success(1, '暂无此人信息，请联系管理员!');
        }
        return $result;
    }

    /**
     * 绑定用户
     * @param Request $request
     * @return mixed
     */
    public function setUserBindEmp(Request $request)
    {

        $this->validate($request, [
            'iphone' => 'required',
            'idcard' => 'required',
            //'verifyCode' => 'required',
        ]);
        $iphone = $request->get('iphone');
        $code = $request->get('verifyCode');
        // 验证验证码
        $verifyCode = WxVerifyCode::where('iphone', '=', $iphone)->where('code', '=', $code)->first();
        //dd($verifyCode,$code,$iphone);
        if (empty($verifyCode)) {
            return $this->success(1, '手机号或验证码错误，请重新输入!');
        }
        $codeCreateTime = $verifyCode['created_at'];
        if (empty($codeCreateTime)) {
            return $this->success(1, '验证码生成错误!');
        }
        if ($verifyCode['status'] != WxVerifyCode::STATUS_ON) {
            return $this->success(1, '验证码无效或已被使用!');
        }
        // 更新验证码为已使用
        $verifyCode->status = WxVerifyCode::STATUS_OFF;
        //$verifyCode->save();
        $diffSeconds = Carbon::now()->diffInSeconds($codeCreateTime);
        if (static::VERIFY_CODE_EFFECTIVE < $diffSeconds) {
            return $this->success(1, '验证码已过期!');
        }
        // 处理绑定信息
        $empUser = $this->user->getUserInfoByIphone($iphone);
        if ($empUser) {
            if (empty($empUser['openid'])) {
                // 保存用户信息
                Session::put('wechat_user_info', $empUser);
                Session::put('companyId', $empUser['company_id']);
                Session::put('empNo', $empUser['emp_no']);
                $wechatUser = session('wechat_user');
                $empUser->auth = json_encode($wechatUser);
                $empUser->openid = $wechatUser['id'];
                $empUser->auth_at = date('Y-m-d H:i:s');
                $empUser->save();
                $result = $this->success(0, '绑定成功！');
            } else {
                $result = $this->success(1, '当前用户被绑定，请联系管理员解绑!');
            }
        } else {
            $result = $this->success(1, '暂无此人信息，请联系管理员!');
        }
        return $result;
    }


    /**
     * 获取用户信息 保留$request->get('emp_no')(存在获取别人的情况)
     *  getUserInfo
     * @param Request $request
     * @param mixed $fixed参数一的说明
     * @Author: Lyn.zou <lyn.zou@areschina.com>
     * @CreateDate: nowtime
     * @Version: 1.0
     * @return array 返回类型
     */
    public function getUserInfo(Request $request)
    {
        $companyId = session('companyId');
        $emp_no = $request->get('emp_no', session('empNo'));
        //查询信息
        $userinfo = $this->user->getUserInfo($companyId, $emp_no);

        if ($userinfo) {
            //拼接最近学校数据

            if ($userinfo['emp_edu'] !== '[]' && $userinfo['emp_edu'] != null && $userinfo['emp_edu'] != '') {
                $userinfo['edu_detail'] = json_decode($userinfo['emp_edu'])[0]->schoolname . '|' . json_decode($userinfo['emp_edu'])[0]->academic . '|' . json_decode($userinfo['emp_edu'])[0]->major;

            } else {
                $userinfo['edu_detail'] = '';
            }
            //处理合同日期
            if ($userinfo['emp_arg'] !== '[]' && $userinfo['emp_arg'] != null && $userinfo['emp_arg'] != '') {
                $argArr = json_decode($userinfo['emp_arg']);
                $argEndTime = $argArr[0]->agrend;

                if (time() > strtotime($argEndTime)) {
                    $userinfo['edu_arg_endtime'] = $argEndTime . '已解约';
                } else {
                    $userinfo['edu_arg_endtime'] = $argEndTime . '合同中';
                }
            } else {
                $userinfo['edu_arg_endtime'] = '';

            }
            $result = $this->success(0, 'success', $userinfo);
        } else {
            $result = $this->success(1, '暂无此人信息，请联系管理员');
        }

        return $result;
    }

    /**
     * 获取我的部门信息
     *  getMydepartmentInfo
     * @param Request $request
     * @param mixed $fixed参数一的说明
     * @Author: Lyn.zou <lyn.zou@areschina.com>
     * @CreateDate: 2018-04-10 10:37:00
     * @Version: 1.0
     * @return array 返回类型
     */
    public function getMydepartmentInfo(Request $request)
    {
        $companyId = session('companyId');
        $empNo = session('empNo');
        $leader = new Leader();
        //获取下属信息
        $selectArr = ["wx_leader_permission_list.emp_no", "wx_leader_permission_list.salary_auth", "wx_leader_permission_list.info_auth", "u.emp_name", "u.emp_indate", "u.emp_outdate", "u.emp_dept", "u.emp_title"];
        $departUsers = $leader->getUnderLineInfo($empNo, $companyId, $selectArr);

        //查询本人信息
        $userinfo = $this->user->getUserInfo($companyId, $empNo);

        if ($userinfo) {
            $result['leader'] = [
                'leadername' => $userinfo['emp_name'],  //姓名
                'dept' => $userinfo['emp_dept'],      //部门
                'emp_count' => count($departUsers)     //下属人数
            ];
        } else {
            $result['leader'] = [];
        }

        $result['staff'] = $this->departClassify($departUsers);

        return $result;

    }

    /**
     * 删除用户信息
     *  deleteUserInfo
     * @param Request $request
     * @param mixed $fixed参数一的说明
     * @Author: Lyn.zou <lyn.zou@areschina.com>
     * @CreateDate: 2019-05-09 10:03:57
     * @Version: 1.0
     * @return array 返回类型
     */

    public function deleteUserInfo(Request $request)
    {

        try {
            $jsondata = $request->getContent();

            $jsondata = json_decode($jsondata, JSON_UNESCAPED_UNICODE);
            $companyId = $jsondata['companyid'];

            $requiredParams = ['companyid', 'userlist'];

            if ($this->dealJsonRequestParams($jsondata, $requiredParams)) {
                //删除微信通讯录
                $weChat = new WxController();
                $chunk_result = array_chunk($jsondata['userlist'], 199);

                foreach ($chunk_result as $item) {

                    $weChatResult = $weChat->deleteWeChatUser($companyId, $item);

                    if ($weChatResult['errcode'] == '0') {
                        //删除数据库信息
                        DB::beginTransaction();
                        $this->leader->where('company_id', $companyId)->whereIn('emp_no', $item)->delete();
                        $result = $this->user->where('company_id', $companyId)->whereIn('emp_no', $item)->delete();
                        if ($result) {
                            DB::commit();
                        } else {
                            Log::info('这些用户数据库删除失败' . json_encode($item));
                            DB::rollBack();
                            throw new \Exception('error');
                            break;
                        }
                    } else {
                        throw new \Exception($weChatResult['errmsg']);
                        break;
                    }
                }
                return $this->success('0', 'success');

            } else {
                throw new \Exception('缺少栏位');
            }

        } catch (\Exception $e) {
            return $this->success('500', $e->getMessage());
        }
    }

}
