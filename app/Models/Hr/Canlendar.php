<?php

namespace App\Models\Hr;

use Config;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Canlendar extends Model
{
    //
    protected $table = 'wx_personal_calendar_page';


    /**
     * 获取某个人月的考勤信息
     *  getCanlendarInfo
     * @param mixed $fixed参数一的说明
     * @Author: Lyn.zou <lyn.zou@areschina.com>
     * @CreateDate: 2018-03-29 16:17:25
     * @Version: 1.0
     * @return array 返回类型
     */
    public function getCanlendarInfo($companyid, $emp_no, $month)
    {
        $month_data = date_parse_from_format('Y/m', $month);
        $month = $month_data['year'] . '/' . (strlen($month_data['month']) > 1 ? $month_data['month'] : '0' . $month_data['month']);
        return $this->select('*')->where('company_id', '=', $companyid)->where('emp_no', '=', $emp_no)->where('month_no', '=', $month)->first();

    }

    /**
     * 获取一些人的考勤信息
     *  getUsersattendanceInfo
     * @param mixed $fixed参数一的说明
     * @Author: Lyn.zou <lyn.zou@areschina.com>
     * @CreateDate: nowtime
     * @Version: 1.0
     * @return array 返回类型
     */
    public function getUsersattendanceInfo($companyid, $emp_nos, $type, $select = '*')
    {

        if ($type == 3) {
            $date = date('Y/m');
            $result = $this->select($select)
                ->where('company_id', '=', $companyid)
                ->where('month_no', '=', $date)
                ->whereIn('emp_no', $emp_nos)
                ->orderby('emp_no', 'asc')
                ->get();
        } else {
            if ($type == 2) {
                //获取当季年月
                $season = ceil(date('n') / 3);
                $date = [date('Y/m', mktime(0, 0, 0, ($season - 1) * 3 + 1, 1, date('Y'))),
                    date('Y/m', mktime(0, 0, 0, ($season - 1) * 3 + 2, 1, date('Y'))),
                    date('Y/m', mktime(0, 0, 0, ($season - 1) * 3 + 3, 1, date('Y')))];

            } else {
                //获取当前年 年月
                $date = array();
                for ($i = 0; $i < 12; $i++) {
                    if ($i < 9) {
                        $date[] = date('Y') . '/' . '0' . ($i + 1);
                    } else {
                        $date[] = date('Y') . '/' . ($i + 1);
                    }
                }
            }

            $search = $this->select($select)
                ->where('company_id', '=', $companyid)
                ->whereIn('month_no', $date)
                ->whereIn('emp_no', $emp_nos)
                ->orderby('emp_no', 'asc')
                ->get();

            $result = array();
            //把每个人的数据拼接到一起
            foreach ($search as $k => $item) {
                if ($k == 0) {
                    $result[] = $item;
                } else {
                    //判断是否同一个用户
                    if ($search[$k]->emp_no == $search[$k - 1]->emp_no) {
                        //判断有没有相应的数据
                        if (count(json_decode($item->emp_n_abs_t)) > 0) {
                            //判断第一个数据是否为空 不为空拼接字符串
                            if (count(json_decode($result[count($result) - 1]->emp_n_abs_t)) == 0) {
                                $result[count($result) - 1]->emp_n_abs_t = $item->emp_n_abs_t;
                            } else {
                                $result[count($result) - 1]->emp_n_abs_t = substr($result[count($result) - 1]->emp_n_abs_t, 0, -1) . ',' . substr($item->emp_n_abs_t, 1);
                            }
                        }
                        if (count(json_decode($item->emp_e_abs_t)) > 0) {
                            if (count(json_decode($result[count($result) - 1]->emp_e_abs_t)) == 0) {
                                $result[count($result) - 1]->emp_e_abs_t = $item->emp_e_abs_t;
                            } else {
                                $result[count($result) - 1]->emp_e_abs_t = substr($result[count($result) - 1]->emp_e_abs_t, 0, -1) . ',' . substr($item->emp_e_abs_t, 1);
                            }
                        }
                        if (count(json_decode($item->emp_over_t)) > 0) {
                            if (count(json_decode($result[count($result) - 1]->emp_over_t)) == 0) {
                                $result[count($result) - 1]->emp_over_t = $item->emp_over_t;
                            } else {
                                $result[count($result) - 1]->emp_over_t = substr($result[count($result) - 1]->emp_over_t, 0, -1) . ',' . substr($item->emp_over_t, 1);
                            }
//
                        }
                    } else {
                        $result[] = $item;
                    }
                }
            }

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
    public function deleteUserAttendanceInfo($companyid, $date, $emp_nos = null)
    {
        config(['database.connections.mysql.database' => 'work_wechat' . $companyid]);
        \DB::reconnect();
        if ($emp_nos) {
            $result = DB::connection('mysql')->table('wx_personal_calendar_page')->where('company_id', '=', $companyid)
                ->where('month_no', '=', $date)
                ->whereIn('emp_no', $emp_nos)
                ->delete();
        } else {
            $result = DB::connection('mysql')->table('wx_personal_calendar_page')->where('company_id', '=', $companyid)
                ->where('month_no', '=', $date)
                ->delete();
        }

        return $result;

    }


}
