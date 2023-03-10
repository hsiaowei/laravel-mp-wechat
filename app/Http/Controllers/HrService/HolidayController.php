<?php

namespace App\Http\Controllers\HrService;


use App\Models\Hr\Salaryp;
use Illuminate\Http\Request;
use App\Models\Hr\User;
use Illuminate\Support\Facades\Cache;
use App\Models\Hr\SalaryPwd;
use App\Models\Hr\SalaryOldPwd;
use App\Models\Hr\Salary;
use App\Http\Controllers\HrService\HrBaseController;

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

        $emp_no=  session('empNo');;
        $companyid= session('companyId');
        $data=[
            'userId'=> $emp_no,
            'companyId'=>$companyid ,
        ];
		
        return view('Holiday.holidayAll')->with($data);
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
        $emp_no= session('empNo');
        $companyid= session('companyId');

        $data=[
            'userId'=>$emp_no,
            'companyId'=>$companyid ,
            'selected'=>$request->get('type'),
            'tym'=>date('Y-m'),
        ];
        return view('Holiday.holidayDetail')->with($data);
    }

}
