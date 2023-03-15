<?php

namespace App\Http\Controllers\Api\SyncData;

use App\Http\Controllers\Api\ApiBaseController;
use App\Models\WxscheduleInfoSync;
use DB;
use Illuminate\Http\Request;
use Webpatser\Uuid\Uuid;

class WxScheduleController extends ApiBaseController
{
    //
    protected $empschedulesync;

    public function __construct(WxScheduleInfoSync $es)
    {
        $this->empschedulesync = $es;
    }

    /**
     * @param Request $request
     */
    public function syncEmpSchedule(Request $request)
    {
        $uuid = UUID::generate();
        $jsondata = $request->getContent();
        $jsondata = json_decode($jsondata, JSON_UNESCAPED_UNICODE);

        $companyid = $jsondata['companyid'];

        $data = [];
        foreach ($jsondata['data'] as $key => $val) {
            $data[$key]['company_id'] = $companyid;
            $data[$key]['uuid'] = $uuid;
            $data[$key]['created_at'] = date('y-m-d G:i:s', time());

            $data[$key]['employee_id'] = $val['a'];
            $data[$key]['schedule_date'] = $val['b'];
            $data[$key]['shift_group_id'] = $val['c'];
            $data[$key]['shift_id'] = $val['d'];
        }
        //往数据库批量插入数据
        $result = $this->empschedulesync::insert($data);
        if (!$result) {
            DB::rollBack();
            return 'error';
        }
        // only insert newdata
        // add replace into   `
        try {
            DB::insert("replace into  wx_emp_schedule_info  select es.* from wx_emp_schedule_info_sync as es
                        where  es.uuid='" . $uuid . "'");
        } catch (Exception $e) {
            DB::rollBack();
            return 'error';
        };
        return 'success';

    }
}
