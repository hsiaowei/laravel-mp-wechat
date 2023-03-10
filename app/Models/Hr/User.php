<?php

namespace App\Models\Hr;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    //
    protected $table='wx_personal_information_page';


    /**
     * 获取用户信息
     *  getUserInfo
     * @param mixed $fixed参数一的说明
     * @Author: Lyn.zou <lyn.zou@areschina.com>
     * @CreateDate: 2018-03-29 16:17:25
     * @Version: 1.0
     * @return array 返回类型
     */
    public function getUserInfo($companyid,$emp_no,$select='*')
    {
     return  $this->select($select)->where('company_id','=',$companyid)->where('emp_no','=',$emp_no)->first();
    }

    /**
     * 获取用户信息
     */
    public function getUserInfoByIphone($iphone,$select='*')
    {
        return  $this->select($select)->where('emp_phone','=',$iphone)->first();
    }

    /**
     * 获取下属的详细信息
     *  getStaffDetailInfo
     * @param mixed $fixed参数一的说明
     * @Author: Lyn.zou <lyn.zou@areschina.com>
     * @CreateDate: 2018-04-10 14:56:22
     * @Version: 1.0
     * @return array 返回类型
     */
    public function getStaffDetailInfo($companyid,$departUsers)
    {
        $empRes =$this->select('emp_no','emp_name','emp_indate','emp_outdate','emp_dept','emp_title')
            ->where('company_id',$companyid)
            ->whereIn('emp_no',$departUsers)
            ->orderby('emp_no','asc')
            ->get()
            ->toArray();

        return $empRes;
    }


}
