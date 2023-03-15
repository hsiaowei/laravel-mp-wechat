<?php

namespace App\Http\Controllers\Api\SyncData;

use App\Http\Controllers\Api\ApiBaseController;
use App\Models\WxShiftinfoSync;
use DB;
use Illuminate\Http\Request;
use Webpatser\Uuid\Uuid;

class WxShiftinfoController extends ApiBaseController
{
    //

    protected $shiftinfosync;

    public function __construct(WxShiftinfoSync $sy)
    {
        $this->shiftinfosync = $sy;
    }

    public function syncShift(Request $request)
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

            $data[$key]['shift_id'] = $val['a'];
            $data[$key]['shift_no'] = $val['b'];
            $data[$key]['shift_name'] = $val['c'];
            $data[$key]['begintime'] = $val['d'];
            $data[$key]['endtime'] = $val['d'];
        }
        //往数据库批量插入数据
        $result = $this->shiftinfosync::insert($data);
        if (!$result) {
            DB::rollBack();
            return 'error';
        }
        // only insert newdata
        // add replace into   `
        try {
            DB::insert("replace into  wx_shift_info  select es.* from wx_shift_info_sync as es
                        where  es.uuid='" . $uuid . "'");
        } catch (Exception $e) {
            DB::rollBack();
            return 'error';
        };
        return 'success';

    }
}
