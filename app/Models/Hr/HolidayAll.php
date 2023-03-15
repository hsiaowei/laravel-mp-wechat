<?php

namespace App\Models\Hr;

use Illuminate\Database\Eloquent\Model;

class HolidayAll extends Model
{
    //
    protected $table = 'wx_all_holiday';
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
    public function getUserSalaryDetail($companyid, $emp_no, $month_no)
    {
        $selectArr = ['emp_pay_type', 'emp_salary', 'emp_salary', 'emp_salary_fix', 'emp_salary_tax', 'emp_salary_temp', 'emp_salary_ov', 'emp_salary_abs', 'emp_salary_insure', 'emp_salary_b', 'emp_salary_bs'];

        $result = $this->select($selectArr)->where('company_id', '=', $companyid)->where('emp_no', '=', $emp_no)->where('month_no', '=', $month_no)->first();

        if ($result) {
            $result = $result->toArray();
        } else {
            $result = [];
        }

        return $result;
    }


}
