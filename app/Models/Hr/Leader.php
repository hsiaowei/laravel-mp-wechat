<?php

namespace App\Models\Hr;

use Illuminate\Database\Eloquent\Model;
use DB;
class Leader extends Model
{
    //
    protected $table='wx_leader_permission_list';
    public $timestamps		=	true;
    protected $primaryKey	=	'id';
    public $incrementing	=	true;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

    ];

    /**
     * 获取下属的id
     *  getUnderLine
     * @param mixed $fixed参数一的说明
     * @Author: Lyn.zou <lyn.zou@areschina.com>
     * @CreateDate: 2018-04-10 09:20:18
     * @Version: 1.0
     * @return array 返回类型
     */
    public function getUnderLine($leader_no,$companyid,$select='*')
    {
        $result=$this->select($select)->where('lead_no',$leader_no)->where('company_id',$companyid)->get()->toArray();

        $departUsers=array();
        foreach ( $result as $item) {
            $departUsers[]=$item['emp_no'];
        }
        return $departUsers;
    }

    /**
     * 获取下属的信息
     *  getUnderLineInfo
     * @param mixed $fixed参数一的说明
     * @Author: Lyn.zou <lyn.zou@areschina.com>
     * @CreateDate: 2018-04-10 09:20:18
     * @Version: 1.0
     * @return array 返回类型
     */
    public function getUnderLineInfo($leader_no,$companyid,$select='*')
    {
        $result=$this->select($select)
            ->join('wx_personal_information_page as u','wx_leader_permission_list.emp_no','u.emp_no')
            ->where('wx_leader_permission_list.lead_no',$leader_no)
            ->where('wx_leader_permission_list.company_id',$companyid)
            ->get()
            ->toArray();

        return $result;
    }
    /**
     * 获取下属的信息
     *  getUnderLineSalaryInfo
     * @param mixed $fixed参数一的说明
     * @Author: Lyn.zou <lyn.zou@areschina.com>
     * @CreateDate: 2018-04-10 09:20:18
     * @Version: 1.0
     * @return array 返回类型
     */
    public function getUnderLineSalaryInfo($leader_no,$companyid,$select='*')
    {
        $result=$this->select($select)
            ->leftJoin('wx_personal_information_page as u','wx_leader_permission_list.emp_no','u.emp_no')
            ->where('wx_leader_permission_list.lead_no',$leader_no)
            ->where('wx_leader_permission_list.salary_auth',0)
            ->where('wx_leader_permission_list.company_id',$companyid)
            ->get()
            ->toArray();

        return $result;
    }

}
