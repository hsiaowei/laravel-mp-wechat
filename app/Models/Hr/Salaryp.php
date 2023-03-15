<?php

namespace App\Models\Hr;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Salaryp extends Model
{
    //
    protected $table = 'wx_personal_salaryp';
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
     * 查询用户的整体
     *  getUserSalaryPwd
     * @param mixed $fixed参数一的说明
     * @Author: Lyn.zou <lyn.zou@areschina.com>
     * @CreateDate: 2018-03-29 16:17:25
     * @Version: 1.0
     * @return array 返回类型
     */
    public function getUserTotalSalaryP($companyid, $emp_no)
    {
        $result = $this->select(DB::raw('mapname,sum(amount) as count_amount,validate_date,emp_no,company_id'))
            ->where('company_id', $companyid)
            ->where('emp_no', $emp_no)
            ->groupBy('validate_date')
            ->orderBy('validate_date', 'asc')
            ->get();

        if ($result) {
            $result = $result->toArray();
        } else {
            $result = [];
        }
        return $result;
    }

    /**
     * 查询日期查询某人的一次薪资改变
     *  getSalaryPByDate
     * @param mixed $fixed参数一的说明
     * @Author: Lyn.zou <lyn.zou@areschina.com>
     * @CreateDate: 2018-04-09 15:29:09
     * @Version: 1.0
     * @return array 返回类型
     */
    public function getSalaryPByDate($companyid, $emp_no, $date)
    {
        $result = $this->select('mapname', 'amount', 'validate_date')
            ->where('company_id', '=', $companyid)
            ->where('emp_no', '=', $emp_no)
            ->where('validate_date', '=', $date)
            ->get();
        if ($result) {
            $result = $result->toArray();
        } else {
            $result = [];
        }
        return $result;
    }

    /**
     * 根据年份筛选数据
     *  getSalaryPByYear
     * @param mixed $fixed参数一的说明
     * @Author: Lyn.zou <lyn.zou@areschina.com>
     * @CreateDate: 2018-04-09 16:17:36
     * @Version: 1.0
     * @return array 返回类型
     */
    public function getSalaryPByYear($companyid, $emp_no, $year)
    {
        if (empty($year)) {
            $res = $this->select('mapname', 'amount', 'validate_date')
                ->where('company_id', '=', $companyid)
                ->where('emp_no', '=', $emp_no)
                ->groupBy('validate_date')
                ->get();;

            $result = array();
            foreach ($res as $value) {
                if (!in_array(substr($value->validate_date, 0, 4), $result)) {
                    $result[] = substr($value->validate_date, 0, 4);
                }
            }

        } else {
            $start = $year . '/01/01';
            $end = ($year + 1) . '/01/01';

            $result = $this->select(DB::raw('sum(amount) as count_amount,validate_date'))
                ->where('company_id', '=', $companyid)
                ->where('emp_no', '=', $emp_no)
                ->where('validate_date', '>', $start)
                ->where('validate_date', '<', $end)
                ->groupBy('validate_date')
                ->orderBy('validate_date', 'asc')
                ->get();

            $detailRes = $this->select('mapname', 'amount', 'validate_date')
                ->where('company_id', '=', $companyid)
                ->where('emp_no', '=', $emp_no)
                ->where('validate_date', '>', $start)
                ->where('validate_date', '<', $end)
                ->orderBy('validate_date', 'asc')
                ->get();

            if ($detailRes) {
                $detailRes = $detailRes->toArray();
                $result = $result->toArray();
                $detailRes = $this->array_group_by($detailRes, 'validate_date');

                foreach ($result as $k => $item) {
                    $result[$k]['table_info'] = $detailRes[$item['validate_date']];
                }
            }
        }

        return $result;
    }

    public function array_group_by($arr, $key)
    {
        $grouped = [];
        foreach ($arr as $value) {
            $grouped[$value[$key]][] = $value;
        }

        if (func_num_args() > 2) {
            $args = func_get_args();
            foreach ($grouped as $key => $value) {
                $parms = array_merge([$value], array_slice($args, 2, func_num_args()));
                $grouped[$key] = call_user_func_array('array_group_by', $parms);
            }
        }
        return $grouped;
    }

    /**
     * 获取用户最近一个月的薪资
     *  getUserNearMonthSalary
     * @param mixed $fixed参数一的说明
     * @Author: Lyn.zou <lyn.zou@areschina.com>
     * @CreateDate: nowtime
     * @Version: 1.0
     * @return array 返回类型
     */
    public function getUserNearMonthSalary($leader, $companyid, $select = '*')
    {
        //查询出最新薪资的日期

        $sql = "select wx_leader_permission_list.emp_no, wx_personal_salaryp.validate_date,sum(amount) as amounttotal from wx_leader_permission_list    
 inner join  wx_personal_salaryp 
 on wx_leader_permission_list.emp_no=wx_personal_salaryp.emp_no 

 where wx_leader_permission_list.company_id =" . $companyid . "
 and  wx_personal_salaryp.validate_date=(  
                          select  max(validate_date) from wx_personal_salaryp p1
                          where p1.emp_no=wx_personal_salaryp.emp_no 
                        and p1.company_id=wx_personal_salaryp.company_id 
                       )
 and lead_no='" . $leader . "'
  group by wx_leader_permission_list.emp_no,validate_date
  order by wx_leader_permission_list.emp_no asc
  ";

        $res = DB::select($sql);

        return $res;
    }

}
