<?php

namespace App\Http\Controllers\HrService;


use Illuminate\Http\Request;

class AttendanceController extends HrBaseController
{
    //
    protected $emp_no;
    protected $companyid;

    public function __construct(Request $request)
    {


    }

    /**
     * 我的的考勤日历页面
     *  myCanlendarView
     * @param mixed $fixed参数一的说明
     * @Author: Lyn.zou <lyn.zou@areschina.com>
     * @CreateDate: nowtime
     * @Version: 1.0
     * @return array 返回类型
     */
    public function myCanlendarView(Request $request)
    {
        //$userinfo = session('wechat_user_info');
        $emp_no = session('empNo');
        $companyid = session('companyId');
        $data = [
            'userId' => $emp_no,
            'companyId' => $companyid,
            'staff_no' => $request->get('staff_no')
        ];

        return view('Details.myCalendar')->with($data);
    }

    /**
     * 考勤汇总
     *  attendanceSummary
     * @param mixed $fixed参数一的说明
     * @Author: Lyn.zou <lyn.zou@areschina.com>
     * @CreateDate: 2018-04-10 09:41:10
     * @Version: 1.0
     * @return array 返回类型
     */
    public function attendanceSummaryView(Request $request)
    {

        //$userinfo = session('wechat_user_info');
        $emp_no = session('empNo');
        $companyid = session('companyId');
        $data = [
            'userId' => $emp_no,
            'companyId' => $companyid,
        ];

        return view('Details.userDetails')->with($data);
    }

    /**
     * 考勤详情页面
     *  attendanceDeatilView
     * @param mixed $fixed参数一的说明
     * @Author: Lyn.zou <lyn.zou@areschina.com>
     * @CreateDate: nowtime
     * @Version: 1.0
     * @return array 返回类型
     */
    public function attendanceDetailView(Request $request)
    {
        $companyId = session('companyId');
        //判断是否是查询别人的信息
        $empNo = $request->get('staff_no',session('empNo'));
        $data = [
            'userId' => $empNo,
            'companyId' => $companyId,
            'staff_no' => $request->get('staff_no'),
            'selected' => $request->get('selected'),
            'toymd' => $request->get('toymd'),
        ];
        return view('Details.attendanceItem')->with($data);
    }

    /**
     * 考勤汇总+详情页面
     *  summaryDetailView
     * @param mixed $fixed参数一的说明
     * @Author: Hsiaowei
     * @CreateDate: nowtime
     * @Version: 1.0
     * @return array 返回类型
     */
    public function summaryDetailView(Request $request)
    {
        //判断是否是查询别人的信息
        $empNo = $request->get('emp_no',session('empNo'));
        $data = [
            'emp_no' => $empNo,
            'selected' => $request->get('selected'),
            'toymd' => $request->get('toymd'),
        ];
        return view('Details.attendanceList')->with($data);
    }




    /**
     * 考勤排名页面 -部属考勤
     *  attendanceListView
     * @param mixed $fixed参数一的说明
     * @Author: Lyn.zou <lyn.zou@areschina.com>
     * @CreateDate: nowtime
     * @Version: 1.0
     * @return array 返回类型
     */
    public function attendanceListView(Request $request)
    {
        $emp_no = session('empNo');
        $companyid = session('companyId');
        $data = [
            'userId' => $emp_no,
            'companyId' => $companyid,

        ];
        return view('Attendance.attendanceList')->with($data);
    }

    /**
     * 加班排名页面
     *  overTimeRankingView
     * @param mixed $fixed参数一的说明
     * @Author: Lyn.zou <lyn.zou@areschina.com>
     * @CreateDate: 2018-04-11 13:12:48
     * @Version: 1.0
     * @return array 返回类型
     */
    public function overTimeRankingView(Request $request)
    {
        //$userinfo = session('wechat_user_info');
        $emp_no = session('empNo');
        $companyid = session('companyId');
        $data = [
            'userId' => $emp_no,
            'companyId' => $companyid,
            'yy' => $request->get('yy'),
            'mm' => $request->get('mm'),
            'yeartype' => $request->get('yeartype'),
        ];
        return view('Attendance.overtimeList')->with($data);
    }

    /**
     * 请假排名详情页面
     *  leaveRankingView
     * @param Request $request
     * @param mixed $fixed参数一的说明
     * @Author: Lyn.zou <lyn.zou@areschina.com>
     * @CreateDate: 2018-04-11 13:43:55
     * @Version: 1.0
     * @return array 返回类型
     */
    public function leaveRankingView(Request $request)
    {
        //$userinfo = session('wechat_user_info');
        $emp_no = session('empNo');
        $companyid = session('companyId');

        $data = [
            'userId' => $emp_no,
            'companyId' => $companyid,
            'yy' => $request->get('yy'),
            'yeartype' => $request->get('yeartype'),
            'mm' => $request->get('mm'),
        ];
        return view('Attendance.leaveList')->with($data);
    }

    /**
     * 考勤异常排名详情页面
     *  attendRankingView
     * @param mixed $fixed参数一的说明
     * @Author: Lyn.zou <lyn.zou@areschina.com>
     * @CreateDate: 2018-04-11 13:44:58
     * @Version: 1.0
     * @return array 返回类型
     */
    public function attendRankingView(Request $request)
    {

        //$userinfo = session('wechat_user_info');
        $emp_no = session('empNo');
        $companyid = session('companyId');
        $data = [
            'userId' => $emp_no,
            'companyId' => $companyid,
            'yy' => $request->get('yy'),
            'yeartype' => $request->get('yeartype'),
            'mm' => $request->get('mm'),
        ];
        return view('Attendance.attendList')->with($data);
    }

    /**
     * 考勤异常排名详情页面
     *  attendRankingView
     * @param mixed $fixed参数一的说明
     * @Author: Lyn.zou <lyn.zou@areschina.com>
     * @CreateDate: 2018-04-11 13:44:58
     * @Version: 1.0
     * @return array 返回类型
     */
    public function attendanceCheckView(Request $request)
    {

        $userinfo = session('wechat_user_info');
        $emp_no = session('empNo');
        $companyid = session('companyId');
        $data = [
            'userId' => $emp_no,
            'companyId' => $companyid,
            'userName' => isset($userinfo['emp_name']) ? $userinfo['emp_name'] : '张无忌',
            'month_no' => $request->get('month_no') ? $request->get('month_no') : date('Y-m', time()),

        ];
        return view('Attendance.checkAttendance')->with($data);
    }


}
