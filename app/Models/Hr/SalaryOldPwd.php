<?php

namespace App\Models\Hr;

use Illuminate\Database\Eloquent\Model;

class SalaryOldPwd extends Model
{
    //
    protected $table = 'wx_personal_pwd';

    public $timestamps = true;
    protected $primaryKey = 'id';
    public $incrementing = true;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'emp_no', 'company_id', 'old_pwd', 'new_pwd', 'uuid', 'created_at', 'updated_at'
    ];

    /**
     * 查询用户的老密码是否正确
     *  getCanlendarInfo
     * @param mixed $fixed参数一的说明
     * @Author: Lyn.zou <lyn.zou@areschina.com>
     * @CreateDate: 2018-03-29 16:17:25
     * @Version: 1.0
     * @return array 返回类型
     */
    public function getUserPwdInfo($companyid, $emp_no, $oldpwd)
    {
        return $this->select('id')->where('company_id', '=', $companyid)->where('emp_no', '=', $emp_no)->where('old_pwd', '=', $oldpwd)->first();

    }


}
