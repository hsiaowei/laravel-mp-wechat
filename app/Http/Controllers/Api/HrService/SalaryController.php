<?php

namespace App\Http\Controllers\Api\HrService;

use App\Http\Controllers\HrService\HrBaseController;
use App\Models\Hr\Leader;
use App\Models\Hr\Salary;
use App\Models\Hr\SalaryOldPwd;
use App\Models\Hr\Salaryp;
use App\Models\Hr\SalaryPwd;
use App\Models\Hr\User;
use App\Models\Hr\YearSalary;
use Illuminate\Http\Request;

class SalaryController extends HrBaseController
{
    protected $salary;
    protected $yearSalary;
    protected $user;
    protected $salaryPwd;
    protected $salaryOldPwd;

    public function __construct(Salary $salary, SalaryPwd $salaryPwd, SalaryOldPwd $salaryOldPwd, User $user)
    {
        $this->salary = $salary;
        $this->user = $user;
        $this->salaryOldPwd = $salaryOldPwd;
        $this->salaryPwd = $salaryPwd;
    }

    /**
     * 修改新的薪资密码
     *  modifyNewSalaryPwd   密码的加密方式是先base64加密 再用md5加密
     * @param mixed $fixed参数一的说明
     * @Author: Lyn.zou <lyn.zou@areschina.com>
     * @CreateDate: nowtime
     * @Version: 1.0
     * @return array 返回类型
     */
    public function modifyNewSalaryPwd(Request $request)
    {
        $this->validate($request, [
            'emp_no' => 'required',
            'newpwd' => 'required',
            'oldpwd' => 'required',
        ]);

        $companyId = session('companyId');
        $emp_no = $request->get('emp_no');
        $newPwd = $request->get('newpwd');

        if ($newPwd == $request->get('oldpwd')) {
            return $this->success(3, '旧密码和新密码不能重复');
        } elseif (strlen($newPwd) < 6) {
            return $this->success(4, '新密码长度不能低于6位');
        }
        $oldPwd = $this->encryptString($request->get('oldpwd'));

        //判断老密码是否正确
        $result = $this->salaryOldPwd->getUserPwdInfo($companyId, $emp_no, $oldPwd);

        if (!empty($result)) {
            $data = [
                'company_id' => $companyId,
                'emp_no' => $emp_no,
                'pwd' => md5(base64_encode($newPwd)),
            ];
            $res = SalaryPwd::where('company_id', $companyId)->where('emp_no', $emp_no)->get();
            if (!$res || count($res) === 0) {
                SalaryPwd::create($data);
                return $this->success(0, '修改成功');
            }
            return $this->success(2, '修改失败，请稍后再试');
        } else {
            return $this->success(1, '旧密码错误');
        }
    }

    /**
     * 通过银行账号修改密码
     *  modifyNewSalaryPwd   密码的加密方式是先base64加密 再用md5加密
     * @param mixed $fixed参数一的说明
     * @Author: Lyn.zou <lyn.zou@areschina.com>
     * @CreateDate: nowtime
     * @Version: 1.0
     * @return array 返回类型
     */
    public function bankModifyNewSalaryPwd(Request $request)
    {

        $this->validate($request, [
            'newpwd' => 'required',
            'bank' => 'required',
        ]);

        $companyId = session('companyId');
        $bank = $request->get('bank');
        $newPwd = $request->get('newpwd');
        $userinfo = session('wechat_user_info');
        $emp_no = $userinfo['emp_no'];

        $userRes = $this->user->getUserInfo($companyId, $emp_no);
        $cardList = json_decode($userRes->emp_bank);
        $checkBank = false;
        foreach ($cardList as $k => $item) {
            if ($item->bankaccount == $bank) {
                $checkBank = true;
                break;
            }
        }
        if (!$checkBank) {
            return $this->success(3, '银行账户无法匹配');
        }

        if (strlen($newPwd) < 6) {
            return $this->success(4, '新密码长度不能低于6位');
        }

        $data = [
            'company_id' => $companyId,
            'emp_no' => $emp_no,
            'pwd' => md5(base64_encode($newPwd)),
        ];
        $res = SalaryPwd::where('company_id', $companyId)->where('emp_no', $emp_no)->get();
        if ($res->isEmpty()) {
            $result = SalaryPwd::create($data);
        } else {
            $result = SalaryPwd::where('company_id', $companyId)->where('emp_no', $emp_no)->update($data);
        }
        if ($result) {
            return $this->success(0, '修改成功');
        }
        return $this->success(2, '修改失败，请稍后再试');

    }

    /**
     * 检查用户的薪酬密码是否正确
     *  checkSalaryNewPwd
     * @param mixed $fixed参数一的说明
     * @Author: Lyn.zou <lyn.zou@areschina.com>
     * @CreateDate: nowtime
     * @Version: 1.0
     * @return array 返回类型
     */
    public function checkSalaryNewPwd(Request $request)
    {
        $this->validate($request, [
            'pwd' => 'required',
        ]);

        $companyId = session('companyId');
        $empNo = session('empNo');
        $pwd = $request->get('pwd');
        $res = SalaryPwd::where('company_id', $companyId)->where('emp_no', $empNo)->where('pwd', md5(base64_encode($pwd)))->get();
        if ($res->isEmpty()) {
            return $this->success(1, '错误');
        } else {
            return $this->success(0, '正确');
        }
    }

    /**
     * 获取薪酬明细
     *  getSalaryDetail
     * @param mixed $fixed参数一的说明
     * @Author: Lyn.zou <lyn.zou@areschina.com>
     * @CreateDate: 2018-04-09 09:24:42
     * @Version: 1.0
     * @return array 返回类型
     */
    public function getSalaryDetail(Request $request)
    {
        $this->validate($request, [
            'emp_no' => 'required',
        ]);
        $companyId = session('companyId', 15);
        $emp_no = $request->get('emp_no');
        $month_no = $request->get('month_no');
        $emp_pay_type = $request->get('type', 1);

        $month_no = date('Y/m', strtotime($month_no));
        $result = $this->salary->getUserSalaryDetail($companyId, $emp_no, $month_no, $emp_pay_type);
        $countArr = [
            "emp_amount" => 0,
            "emp_salary_fix_amount" => 0,
            "emp_salary_tax_amount" => 0,
            "emp_salary_temp_amount" => 0,
            "emp_salary_ov_amount" => 0,
            "emp_salary_abs_amount" => 0,
            "emp_salary_insure_amount" => 0,
            "emp_salary_insure_cpy_amount" => 0,
            "emp_salary_b_amount" => 0,
            "emp_salary_bs_amount" => 0,
            "emp_salary_bs_tw_amount" => null,
            "emp_salary_bs_tw_bs_amount" => null,
            "emp_salary_insure_cpy_amount" => null
        ];
        $countArr['emp_amount'] = 0;
        //循环解码 并且计算次数
        foreach ($result as $k => $item) {
            if ($item != '' && $item != '[]') {
                $res = $this->decryptString($item, 'wechat');

                $result[$k] = $res;

                if (is_array(json_decode($res))) {
                    $countArr[$k . '_amount'] = 0;
                    $countInfo = 0;
                    $result[$k] = json_decode($res);
                    foreach (json_decode($res) as $j => $cout) {
                        $countInfo += number_format($cout->amount, 2, '.', '');
                        // $countArr[$k.'_amount']+= bcadd(  $countArr[$k.'_amount'], number_format($cout->amount, 2, '.', ''),2) ;

                    }
                    $countArr[$k . '_amount'] = (string)$countInfo;
                    $countArr['emp_amount'] += $countInfo;
                }
            }
        }
        $countArr['emp_amount'] = (string)$countArr['emp_amount'];
        $result['amount'] = $countArr;
        return $result;
    }

    /**
     * 查询薪酬调整历史
     *  getSalaryQueryTotal
     * @param mixed $fixed参数一的说明
     * @Author: Lyn.zou <lyn.zou@areschina.com>
     * @CreateDate: 2018-04-09 14:33:52
     * @Version: 1.0
     * @return array 返回类型
     */
    public function getSalaryQueryTotal(Request $request)
    {
        $this->validate($request, [
            'emp_no' => 'required',
        ]);
        $companyId = session('companyId');
        $emp_no = $request->get('emp_no');

        $salaryp = new Salaryp();
        //查询总体调薪情况
        $result = $salaryp->getUserTotalSalaryP($companyId, $emp_no);

        $amount = array();
        $validate = array();
//        数据梳理
        foreach ($result as $item) {
            $amount[] = $item['count_amount'];
            $validate[] = $item['validate_date'];
        }
        //查询最近一次调薪情况
        $recentCount = 0;
        if ($result) {
            $recent = $salaryp->getSalaryPByDate($companyId, $emp_no, $result[count($result) - 1]['validate_date']);
            foreach ($recent as $item) {
                $recentCount += round($item['amount'], 2);
            }
        } else {
            $recent = [];
        }

        $res = [
            'amount' => $amount,
            'validate' => $validate,
            'detail' => $recent,
            'diffamount' => $recentCount,
        ];
        return $res;
    }

    /**
     * 调薪查看更多页面   保留$request->get('emp_no')(存在获取别人的情况)
     *  queryMoreView
     * @param mixed $fixed参数一的说明
     * @Author: Lyn.zou <lyn.zou@areschina.com>
     * @CreateDate: nowtime
     * @Version: 1.0
     * @return array 返回类型
     */
    public function getQueryMoreInfo(Request $request)
    {
        $companyId = session('companyId');
        $emp_no = $request->get('emp_no', session('empNo'));
        $year = $request->get('year');


        //查询某年的调薪详情
        $salaryp = new Salaryp();
        $result = $salaryp->getSalaryPByYear($companyId, $emp_no, $year);

        return $result;
    }

    /**
     * 获取下属的薪酬信息
     *  getStaffSalaryInfo
     * @param Request $request
     * @param mixed $fixed参数一的说明
     * @Author: Lyn.zou <lyn.zou@areschina.com>
     * @CreateDate: nowtime
     * @Version: 1.0
     * @return array 返回类型
     */
    public function getStaffSalaryInfo(Request $request)
    {
        $companyId = session('companyId');
        $emp_no = session('empNo');

        $leader = new Leader();
        //获取下属id
        $selectArr = ["wx_leader_permission_list.emp_no", "wx_leader_permission_list.salary_auth", "u.emp_name", "u.emp_indate", "u.emp_outdate", "u.emp_dept", "u.emp_title"];
        $empRes = $leader->getUnderLineSalaryInfo($emp_no, $companyId, $selectArr);
        //下属薪酬信息
        $salaryp = new Salaryp();
        $amountRes = $salaryp->getUserNearMonthSalary($emp_no, $companyId);

        $amountList = [];
        foreach ($amountRes as $k => $item) {
            $amountList[$item->emp_no] = $item;
        }

        foreach ($empRes as $k => $item) {
            if ($item['emp_outdate'] == '') {
                $year = date('Y') - date('Y', strtotime($item['emp_indate']));
                $month = date('m') - date('m', strtotime($item['emp_indate']));
            } else {
                $year = date('Y', strtotime($item['emp_outdate'])) - date('Y', strtotime($item['emp_indate']));
                $month = date('m', strtotime($item['emp_outdate'])) - date('m', strtotime($item['emp_indate']));
            }
            $empRes[$k]['years'] = (string)round((12 * $year + $month) / 12, 1);
            if (isset($amountList[$item['emp_no']])) {
                $empRes[$k]['amounttotal'] = (string)$amountList[$item['emp_no']]->amounttotal;
                $empRes[$k]['validate_date'] = (string)$amountList[$item['emp_no']]->validate_date;
            } else {
                $empRes[$k]['amounttotal'] = '';
                $empRes[$k]['validate_date'] = '';
            }

        }

        return $empRes;
    }


    /**
     * 删除考勤用户薪资信息
     *  deleteSalaryUserInfo
     * @param mixed $fixed参数一的说明
     * @Author: Lyn.zou <lyn.zou@areschina.com>
     * @CreateDate:2020-08-24 13:55:57
     * @Version: 1.0
     * @return array 返回类型
     */
    public function deleteSalaryUserInfo(Request $request)
    {


        $jsonData = $request->only('companyid', 'emp_nos', 'month_no');
        if (!$jsonData) {
            $jsonStr = $request->getContent();
            $jsonData = json_decode($jsonStr, JSON_UNESCAPED_UNICODE);
        }


        if (!$jsonData) {
            return $this->responseError('请传入正确的json字符串.', 403);
        }
        $emp_nos = isset($jsonData['emp_nos']) ? $jsonData['emp_nos'] : null;

        $company_id = $jsonData['companyid'];
        $month_no = $jsonData['month_no'];

        $result = $this->salary->deleteUserSalaryInfo($company_id, $month_no, $emp_nos);

        if ($result) {
            return $this->success(200, '删除成功');
        } else {
            return $this->success(300, '删除失败');
        }

    }


    /**
     * 获取年度薪资
     *  getUserYearSalary
     * @param mixed $fixed参数一的说明
     * @Author: Lyn.zou <lyn.zou@areschina.com>
     * @CreateDate: 2021-06-30 14:33:52
     * @Version: 1.0
     * @return array 返回类型
     */
    public function getUserYearSalary(Request $request)
    {
        $this->validate($request, [
            'emp_no' => 'required',

        ]);
        $companyId = session('companyId');
        $emp_no = $request->get('emp_no');
        $year = $request->get('year') ? $request->get('year') : date('Y');


        //查询总体调薪情况
        $search = YearSalary::where('emp_no', $emp_no)->where('company_id', $companyId)->where('year', $year)->get();


        $result = array(
            'total' => null,
            'detail' => null,
        );

        if ($search) {

            $realTotal = $this->decryptString($search[0]->total, 'wechat');
            $realData = $this->decryptString($search[0]->detail, 'wechat');

            $result = array(
                'total' => json_decode($realTotal),
                'detail' => json_decode($realData),
            );
        }

        return $this->success(0, 'success', $result);
    }

}
