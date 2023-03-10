<?php

namespace App\Models\Hr;

use Illuminate\Database\Eloquent\Model;

class HolidayDetail extends Model
{
    //
    protected $table='wx_holiday_detail';
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
     * 获取某个人月的休假信息
     *  getCanlendarInfo
     * @param mixed $fixed参数一的说明
     * @Author: Lyn.zou <lyn.zou@areschina.com>
     * @CreateDate: 2019-06-20 10:55:23
     * @Version: 1.0
     * @return array 返回类型
     */
    public function getMonthHolidayInfo($companyid,$emp_no,$month)
    {
        $month_data= date_parse_from_format('Y-m',$month);
        $month=$month_data['year'].'-'.( strlen($month_data['month'])>1?$month_data['month']:'0'.$month_data['month']);
        return   $this->select('*')->where('company_id','=',$companyid)->where('emp_no','=',$emp_no)->where('month_no','=',$month)->first();

    }
    /**
     * 获取某个人月的休假信息
     *  getCanlendarInfo
     * @param mixed $fixed参数一的说明
     * @Author: Lyn.zou <lyn.zou@areschina.com>
     * @CreateDate: 2019-06-20 10:55:23
     * @Version: 1.0
     * @return array 返回类型
     */
    public function getYearHolidayInfo($companyid,$emp_no,$month_no,$year=null)
    {
        $return=[];

        if(!$year){
            $year=date('Y');
        }
        $last=($year-1).'-12';
        $new=($year+1).'-1';

        $month_data= date_parse_from_format('Y-m',$month_no);
        $month=$month_data['year'].'-'.( strlen($month_data['month'])>1?$month_data['month']:'0'.$month_data['month']);

        $result=   $this->select('*')
                    ->where('company_id','=',$companyid)
                    ->where('emp_no','=',$emp_no)
                    ->where('month_no','>',$last)
                    ->where('month_no','<',$new)
                    ->orderBy('month_no','desc')
                    ->get();
        foreach ($result as $item) {
            $detail= json_decode($item['detail']);


            $return["year"][] =[
                'date'=>$item['month_no'],
                'detail'=>($detail->year->detail&&count($detail->year->detail[0]->list))?$detail->year->detail[0]->list:[],
            ];

            $currentSeniorityArr = [];
            if (isset($detail->Seniority) && isset($detail->Seniority->detail)){
                $currentSeniorityArr = $detail->Seniority->detail[0]->list;
            }
            $return["Seniority"][] =[
                'date'=>$item['month_no'],
                'detail'=>$currentSeniorityArr,
            ];

            if($month==$item['month_no']){
                $return["exchange"]=$detail->exchange->detail;
            }

        }

/*        return array(
            'year'=>$yearArr,
            'other'=>$currentMonthDate,
        );*/

        return $return;

    }

}
