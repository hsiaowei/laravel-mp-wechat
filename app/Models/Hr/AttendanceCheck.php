<?php

namespace App\Models\Hr;

use Illuminate\Database\Eloquent\Model;

class AttendanceCheck extends Model
{
    //
    protected $table = 'wx_attendance_user_status';
    public $timestamps = true;
    protected $primaryKey = 'id';
    public $incrementing = true;

    /**
     * 获取考勤信息
     *  getAttendance
     * @param mixed $fixed参数一的说明
     * @Author: Lyn.zou <lyn.zou@areschina.com>
     * @CreateDate: 2019-04-02 11:31:50
     * @Version: 1.0
     * @return array 返回类型
     */
    public function getAttendanceInfo($companyid, $month_no, $status, $select = '*')
    {
        return $this->select($select)->where('company_id', $companyid)->where('month_no', $month_no)->where('status', $status)->orderBy('confirm_time')->limit(10)->get();
    }

    /**
     * 更新用户消息回传情况
     *  getAttendance
     * @param mixed $fixed参数一的说明
     * @Author: Lyn.zou <lyn.zou@areschina.com>
     * @CreateDate: 2019-04-02 11:31:50
     * @Version: 1.0
     * @return array 返回类型
     */
    public function updateBatch($ids)
    {
        return $this->whereIn('id', $ids)->update(['status' => 2, 'updated_at' => date('Y-m-d H:i:s', time())]);
    }

    /**
     * 获取用户的考勤确认情况
     *  getUserAttendanceInfo
     * @param mixed $fixed参数一的说明
     * @Author: Lyn.zou <lyn.zou@areschina.com>
     * @CreateDate: 2019-04-08 09:50:21
     * @Version: 1.0
     * @return array 返回类型
     */
    public function getUserAttendanceInfo($companyid, $month_no, $emp_no)
    {
        $month_data = date_parse_from_format('Y-m', $month_no);

        $month_no = $month_data['year'] . '-' . (strlen($month_data['month']) > 1 ? $month_data['month'] : '0' . $month_data['month']);

        $result = $this->where('company_id', $companyid)
            ->where('month_no', $month_no)
            ->where('emp_no', $emp_no)
            ->orderBy('created_at', 'desc')
            ->first();

        return $result;

    }


}
