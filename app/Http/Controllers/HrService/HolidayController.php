<?php

namespace App\Http\Controllers\HrService;


use Illuminate\Http\Request;

class HolidayController extends HrBaseController
{

    protected $emp_no;
    protected $companyid;

    public function __construct(Request $request)
    {

    }

    /**
     * 节假日汇总
     *  holidayAllView
     * @param mixed $fixed参数一的说明
     * @Author: Lyn.zou <lyn.zou@areschina.com>
     * @CreateDate: 2019-06-20 09:33:29
     * @Version: 1.0
     * @return array 返回类型
     */
    public function holidayAllView(Request $request)
    {

        $emp_no = session('empNo');;
        $companyid = session('companyId');
        $data = [
            'userId' => $emp_no,
            'companyId' => $companyid,
        ];

        return view('Holiday.holidayAll')->with($data);
    }


    /**
     * 节假日汇总
     *  holidayAllNewView
     * @param mixed $fixed参数一的说明
     * @Author: hsiaowei
     * @CreateDate: 2023-03-20 09:33:29
     * @Version: 1.0
     * @return array 返回类型
     */
    public function holidayAllNewView(Request $request)
    {

        $userinfo=  session('wechat_user_info');
        $emp_no=  $userinfo['userid'];
        $companyid= session('companyid');
        $data=[
            'userId'=> $emp_no,
            'companyId'=>$companyid ,
        ];

        return view('Holiday.holidayAllNew')->with($data);
    }

    /**
     * 节假日详情页面
     *  attendanceDeatilView
     * @param mixed $fixed参数一的说明
     * @Author: Lyn.zou <lyn.zou@areschina.com>
     * @CreateDate: 2019-06-20 09:33:29
     * @Version: 1.0
     * @return array 返回类型
     */
    public function holidayDetailView(Request $request)
    {
        $emp_no = session('empNo');
        $companyid = session('companyId');

        $data = [
            'userId' => $emp_no,
            'companyId' => $companyid,
            'selected' => $request->get('type'),
            'tym' => date('Y-m'),
        ];
        return view('Holiday.holidayDetail')->with($data);
    }

}
