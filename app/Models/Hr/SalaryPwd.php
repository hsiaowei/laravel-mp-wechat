<?php

namespace App\Models\Hr;

use Illuminate\Database\Eloquent\Model;

class SalaryPwd extends Model
{
    //
    protected $table = 'wx_personal_salary_pwd';
    public $timestamps = true;
    protected $primaryKey = 'id';
    public $incrementing = true;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'emp_no', 'company_id', 'pwd', 'created_at', 'updated_at'
    ];

    /**
     * 查询用户的薪酬密码
     *  getUserSalaryPwd
     * @param mixed $fixed参数一的说明
     * @Author: Lyn.zou <lyn.zou@areschina.com>
     * @CreateDate: 2018-03-29 16:17:25
     * @Version: 1.0
     * @return array 返回类型
     */
    public function getUserSalaryPwd($companyid, $emp_no)
    {
        return $this->select('*')->where('company_id', '=', $companyid)->where('emp_no', '=', $emp_no)->first();

    }


}
