<?php

namespace App\Models\Hr;

use Illuminate\Database\Eloquent\Model;
use Config;
use Illuminate\Support\Facades\DB;

class Salary extends Model
{
    //
    protected $table = 'wx_personal_salary_page';
    public $timestamps = true;
    protected $primaryKey = 'id';
    public $incrementing = true;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

    ];

    /**
     * 查询用户的薪酬详细
     *  getUserSalaryPwd
     * @param mixed $fixed参数一的说明
     * @Author: Lyn.zou <lyn.zou@areschina.com>
     * @CreateDate: 2018-03-29 16:17:25
     * @Version: 1.0
     * @return array 返回类型
     */
    public function getUserSalaryDetail($companyid, $emp_no, $month_no, $emp_pay_type = 1)
    {
        $selectArr = ['emp_salary', 'emp_salary', 'emp_salary_fix', 'emp_salary_tax', 'emp_salary_temp', 'emp_salary_ov', 'emp_salary_abs', 'emp_salary_insure', 'emp_salary_b', 'emp_salary_bs'
            , 'emp_salary_tw', 'emp_salary_tw_bs', 'emp_salary_insure_cpy' //标准版未纳入
        ];

        $result = $this->select($selectArr)->where('company_id', '=', $companyid)->where('emp_no', '=', $emp_no)->where('month_no', '=', $month_no)->where('emp_pay_type', '=', $emp_pay_type)->first();

        if ($result) {
            $result = $result->toArray();
        } else {
            $result = [];
        }

        return $result;
    }

    /**
     * 删除的考勤信息
     *  deleteUserAttendanceInfo
     * @param mixed $fixed参数一的说明
     * @Author: Lyn.zou <lyn.zou@areschina.com>
     * @CreateDate: 2020-08-24 10:34:02
     * @Version: 1.0
     * @return array 返回类型
     */
    public function deleteUserSalaryInfo($companyid, $date, $emp_nos = null)
    {
        config(['database.connections.mysql.database' => 'work_wechat' . $companyid]);
        \DB::reconnect();
        if ($emp_nos) {
            $result = DB::connection('mysql')->table('wx_personal_salary_page')->where('company_id', '=', $companyid)
                ->where('month_no', '=', $date)
                ->whereIn('emp_no', $emp_nos)
                ->delete();
        } else {
            $result = DB::connection('mysql')->table('wx_personal_salary_page')->where('company_id', '=', $companyid)
                ->where('month_no', '=', $date)
                ->delete();
        }

        return $result;

    }

}
