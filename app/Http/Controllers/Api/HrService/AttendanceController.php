<?php

namespace App\Http\Controllers\Api\HrService;


use Illuminate\Http\Request;
use App\Models\Hr\User;
use App\Models\Hr\Canlendar;
use App\Models\Hr\Leader;
use App\Models\Hr\AttendanceCheck;
use Log;
use App\Http\Controllers\HrService\HrBaseController;

class AttendanceController extends HrBaseController
{
    //
    protected $canlendar;
    protected $attendanceCheck;


    public function __construct(Canlendar $canlendar, AttendanceCheck $attendanceCheck)
    {
        $this->canlendar = $canlendar;
        $this->attendanceCheck = $attendanceCheck;
    }

    /**
     * /**
     * 获取可以查询的年月
     *  getMonthList
     * @param mixed $fixed参数一的说明
     * @Author: Lyn.zou <lyn.zou@areschina.com>
     * @CreateDate: nowtime
     * @Version: 1.0
     * @return array 返回类型
     */
    public function getYearList()
    {
        return array(
            date("Y", strtotime("+1 year")),
            date('Y'),
            date("Y", strtotime("-1 year")),
        );
    }

    /**
     * 获取用户的考勤信息
     *  getCanlendarInfo
     * @param mixed $fixed参数一的说明
     * @Author: Lyn.zou <lyn.zou@areschina.com>
     * @CreateDate: nowtime
     * @Version: 1.0
     * @return array 返回类型
     */
    public function getCanlendarInfo(Request $request)
    {
        $this->validate($request, [
            'emp_no' => 'required',
        ]);
        $emp_no = $request->get('emp_no');
        $month_no = $request->get('month_no');
        $month_no = date('Y/m', strtotime($month_no));
        $canlendarinfo['emp_shift'] = [];
        $canlendarinfo['emp_clock'] = [];
        $canlendarinfo['emp_n_abs'] = [];
        $canlendarinfo['emp_e_abs'] = [];
        $canlendarinfo['emp_over'] = [];

        //查询信息
        $canlendarinfo = $this->canlendar->getCanlendarInfo(session('companyId'), $emp_no, $month_no);
        $canlendarinfo['month'] = date('Y-m');
        return $canlendarinfo;
    }


    /**
     * 获取考勤汇总信息
     *  getattendanceSummary
     * @param mixed $fixed参数一的说明
     * @Author: Lyn.zou <lyn.zou@areschina.com>
     * @CreateDate: nowtime
     * @Version: 1.0
     * @return array 返回类型
     */
    public function getattendanceSummary(Request $request)
    {
        $this->validate($request, [
            'emp_no' => 'required',
        ]);

        $companyId = session('companyId');
        $emp_no = $request->get('emp_no');
        $month_no = $request->get('month_no');

        if ($month_no) {
            $month = $month_no;
            $month_no = date('Y/m', strtotime($month_no));
        } else {
            $month = date('Y-m');
            $month_no = date('Y/m');
        }
        //查询信息
        $canlendarinfo = $this->canlendar->getCanlendarInfo($companyId, $emp_no, $month_no);

        if ($canlendarinfo) {
            //获取考勤概况信息
            $canlendarinfo = $canlendarinfo->toArray();
            $attendanceCheck = $this->attendanceCheck->getUserAttendanceInfo($companyId, $month, $emp_no);
            $result = [
                'month' => $month,
                'salary_time' => json_decode($canlendarinfo['salary_time_sum']),
                'checkStatus' => $attendanceCheck ? true : false,
            ];
            return $this->success(0, 'success', $result);

        } else {
            $result = [
                'month' => $month,
                'salary_time' => [],
                'checkStatus' => false,
            ];
            return $this->success(1, '暂无当前月份考勤数据', $result);

        }
    }


    /**
     * 获取汇总详情
     *  getSummaryDetail
     * @param mixed $fixed参数一的说明
     * @Author: Lyn.zou <lyn.zou@areschina.com>
     * @CreateDate: nowtime
     * @Version: 1.0
     * @return array 返回类型
     */
    public function getSummaryDetail(Request $request)
    {
        $this->validate($request, [
            'emp_no' => 'required',
            'month_no' => 'required',
        ]);

        $companyId = session('companyId');
        $emp_no = $request->get('emp_no');
        $month_no = $request->get('month_no');

        $month_no = date('Y/m', strtotime($month_no));

        //查询信息

        $canlendarinfo = $this->canlendar->getCanlendarInfo($companyId, $emp_no, $month_no);

        if (count($canlendarinfo) > 0) {
            //处理数据,根据类型进行分类,1先转数组  2根据日期排序  3根据类型进行分类
            //系统请假类型（迟到早退等）
            $signArr = $this->array_sort($this->object_to_array(json_decode($canlendarinfo['emp_e_abs_t'])), 'cday', 'SORT_ASC');
            $result['sysArr'] = $this->array_group_by($signArr, 'absname');

            //人为请假类型
            $leaveArr = $this->array_sort($this->object_to_array(json_decode($canlendarinfo['emp_n_abs_t'])), 'cday', 'SORT_ASC');

            $result['leaveArr'] = $this->array_group_by($leaveArr, 'absname');
            //加班类型
            $overArr = $this->array_sort($this->object_to_array(json_decode($canlendarinfo['emp_over_t'])), 'cday', 'SORT_ASC');

            $result['overArr'] = $this->array_group_by($overArr, 'ovtype');

        } else {
            //系统请假类型（迟到早退等）
            $result['sysArr'] = [];
            //人为请假类型
            $result['leaveArr'] = [];
            //加班类型
            $result['overArr'] = [];
        }

        return $result;

    }

    /**
     * 查询考勤排名信息
     *  getattendanceRankingInfo
     * @param mixed $fixed参数一的说明
     * @Author: Lyn.zou <lyn.zou@areschina.com>
     * @CreateDate: 2018-04-11 10:31:15
     * @Version: 1.0
     * @return array 返回类型
     */
    public function getattendanceRankingInfo(Request $request)
    {
        $companyId = session('companyId');
        $empNo = session('empNo');
        //查询 1年 2季度  3月
        $yeartype = $request->get('yeartype');
        $leader = new Leader();
        $user = new User();
        //获取下属id
        $departUsers = $leader->getUnderLine($empNo, $companyId, 'emp_no');

        //查询下属详细消息
        $empRes = $user->getStaffDetailInfo($companyId, $departUsers);

        //查询信息
        $select = ['emp_no', 'emp_n_abs_t', 'emp_e_abs_t', 'emp_over_t', 'month_no'];
        $canlendarinfo = $this->canlendar->getUsersattendanceInfo($companyId, $departUsers, $yeartype, $select);
        $leaveRank = array();//请假
        $overRank = array();//加班
        $errRank = array();//异常

        foreach ($canlendarinfo as $k => $item) {

            $leaveHour = $this->getArrayObjSum(json_decode($item['emp_n_abs_t']), 'hour');

            $currentUser = $this->checkIfHaveUser($empRes, $item['emp_no']);

            if ($currentUser) {
                if ($leaveHour != "0") {
                    $leaveRank[] = [
                        'emp_no' => $item['emp_no'],
                        'emp_name' => $currentUser['emp_name'],
                        'hours' => $leaveHour
                    ];
                }
                $overHour = $this->getArrayObjSum(json_decode($item['emp_over_t']), 'hour');
                if ($overHour != "0") {
                    $overRank[] = [
                        'emp_no' => $item['emp_no'],
                        'emp_name' => $currentUser['emp_name'],
                        'hours' => $overHour
                    ];
                }
                $errHour = $this->getArrayObjSum(json_decode($item['emp_e_abs_t']), 'hour');
                if ($errHour != "0") {
                    $errRank[] = [
                        'emp_no' => $item['emp_no'],
                        'emp_name' => $currentUser['emp_name'],
                        'hours' => $errHour
                    ];
                }
            }

        }

        $result['leaveRank'] = $this->array_sort($leaveRank, 'hours');
        $result['overRank'] = $this->array_sort($overRank, 'hours');

        $result['errRank'] = $this->array_sort($errRank, 'hours');
        return $result;
    }

    function checkIfHaveUser($users, $emp_no)
    {
        $result = null;
        foreach ($users as $k => $item) {
            if ($item['emp_no'] == $emp_no) {
                $result = $item;
                break;
            }
        }
        return $result ? $result : false;
    }

    /**
     * 删除考勤用户数据信息
     *  deleteAttendanceUserInfo
     * @param mixed $fixed参数一的说明
     * @Author: Lyn.zou <lyn.zou@areschina.com>
     * @CreateDate:2020-08-24 13:55:57
     * @Version: 1.0
     * @return array 返回类型
     */
    public function deleteAttendanceUserInfo(Request $request)
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

        $result = $this->canlendar->deleteUserAttendanceInfo($company_id, $month_no, $emp_nos);

        if ($result) {
            return $this->success(200, '删除成功');
        } else {
            return $this->success(300, '删除失败');
        }

    }

}
