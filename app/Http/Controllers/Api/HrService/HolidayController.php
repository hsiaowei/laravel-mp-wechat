<?php

namespace App\Http\Controllers\Api\HrService;

use App\Http\Controllers\HrService\HrBaseController;
use App\Models\Hr\HolidayAll;
use App\Models\Hr\HolidayDetail;
use App\Models\Hr\User;
use Illuminate\Http\Request;

class HolidayController extends HrBaseController
{
    protected $all_holiday;
    protected $holiday_detail;
    protected $user;

    public function __construct(HolidayAll $holidayAll, HolidayDetail $holidayDetail, User $user)
    {

        $this->user = $user;
        $this->all_holiday = $holidayAll;
        $this->holiday_detail = $holidayDetail;


    }

    /**
     * 获取用户当年休假汇总
     *  modifyNewSalaryPwd
     * @param mixed $fixed参数一的说明
     * @Author: Lyn.zou <lyn.zou@areschina.com>
     * @CreateDate: 2019-06-20 10:45:45
     * @Version: 1.0
     * @return array 返回类型
     */
    public function getUserAllHoliday(Request $request)
    {
        $this->validate($request, [
            'emp_no' => 'required',
        ]);

        $companyId = session('companyId');
        $emp_no = $request->get('emp_no');
        $result = HolidayAll::where('company_id', $companyId)->where('emp_no', $emp_no)->where('year', date('Y', time()))->first();


        if ($result) {
            $result = $result->toArray();
            return $this->success(0, 'success', json_decode($result['holiday']));
        } else {
            return $this->success(1, '暂无当年年假数据');
        }
    }

    /**
     * 获取用户每月休假详情
     *  getUserMonthHolidayDetail
     * @param mixed $fixed参数一的说明
     * @Author: Lyn.zou <lyn.zou@areschina.com>
     * @CreateDate: 2019-06-20 10:45:45
     * @Version: 1.0
     * @return array 返回类型
     */
    public function getUserMonthHolidayDetail(Request $request)
    {
        $this->validate($request, [
            'emp_no' => 'required',
        ]);
        $companyId = session('companyId');
        $emp_no = $request->get('emp_no');
        $month_no = $request->get('month_no') ? $request->get('month_no') : date('Y-m');
        $year = $request->get('year') ? $request->get('year') : date('Y');
        $holidayDetail = new HolidayDetail();
        $result = $holidayDetail->getYearHolidayInfo($companyId, $emp_no, $month_no, $year);
//        $result=  $holidayDetail->getMonthHolidayInfo($companyid,$emp_no,$month_no);

        if ($result) {
            return $this->success(0, 'success', $result);
        } else {
            return $this->success(1, '暂无当年月数据');
        }
    }

}
