<?php

namespace App\Http\Controllers\Api\SyncData;


use App\Http\Controllers\Controller;
use App\Models\WxIntermediaTable;
use Config;
use DB;
use Illuminate\Http\Request;
use Log;
use Webpatser\Uuid\Uuid;

class WxIntermediateTableController extends Controller
{
    //
    protected $wxintermediatable;

    public function __construct(WxIntermediaTable $wt)
    {
        $this->wxintermediatable = $wt;
    }

    public function syncData(Request $request)
    {
        $uuid = UUID::generate();
        $jsondata = $request->getContent();

        $jsondata = json_decode($jsondata, JSON_UNESCAPED_UNICODE);
        //dd($jsondata );
        $companyid = $jsondata['companyid'];
        $tablename = $jsondata['table'];
        $type = $jsondata['type'];        // type  IU: insert or update  Del :delete  DelAll  :delete all
        $db_config = Config::get('wechat_syncdata.' . $tablename);
        if (empty($db_config)) {
            return '数据同步配置有误';
        }

        // 先清空临时表
        $this->truncate();

        if ($type == 'DelAll') {
            try {
                $sql = "delete from  $tablename where company_id=$companyid";
                DB::delete($sql);
            } catch (Exception $e) {
                return 'error';
            };
            return 'success';
        }

        if (!empty($jsondata['data'])) {
            $data = [];

            foreach ($jsondata['data'] as $key => $val) {
                $data[$key]['company_id'] = $companyid;
                $data[$key]['uuid'] = $uuid;
                $data[$key]['created_at'] = date('y-m-d G:i:s', time());
                $data[$key]['table_name'] = $tablename;
                $data[$key]['type'] = $type;
                $cnt = count($val);
                for ($i = 1; $i <= $cnt; $i++) {
                    $data[$key]['col' . ($i)] = is_array($val[$i]) ? json_encode($val[$i], JSON_UNESCAPED_UNICODE) : $val[$i];
                }
            }
            try {
                //dd($data);
                //往数据库批量插入数据
                $result = $this->wxintermediatable::insert($data);
                Log::info("往批量数据库插入数据条数：" . count($data) . ",返回条数" . $result);
            } catch (Exception $e) {
                Log::info("往数据库批量插入数据错误：", $e);
                return 'error';
            }
        }
        // only insert newdata
        // add replace into   `
        if ($type == 'IU') {
            try {
                $cols = [];

                foreach (range(1, count($db_config['cols'])) as $v)
                    $cols[] = 'col' . $v;
                $sql = "replace into  $tablename (" . 'company_id,uuid,created_at,'
                    . implode(',', $db_config['cols']) . ')'
                    . ' select ' . 'company_id,uuid,created_at, ' . implode(',', $cols) .
                    " from wx_intermediate_table as es 
                        where  es.company_id=$companyid 
                        and es.uuid='" . $uuid . "'";
                //dd($db_config,$sql);
                DB::insert($sql);
            } catch (Exception $e) {
                Log::info("IU操作数据错误：", $e);
                return 'error';
            }
        }

        if ($type == 'Del') {
            try {
                $sql = " delete  $tablename  from $tablename ,wx_intermediate_table ";
                $sql = $sql . " where  $tablename.company_id =wx_intermediate_table.company_id";
                foreach ($db_config['uk'] as $key => $val)
                    $sql = $sql . "  and  $tablename." . $val . "=wx_intermediate_table.col" . ($key + 1);

                $sql = $sql . " and wx_intermediate_table.company_id=$companyid
                          and wx_intermediate_table.uuid='" . $uuid . "'";

                DB::delete($sql);
            } catch (Exception $e) {
                Log::info("Del操作数据错误：", $e);
                return 'error';
            }
        }
        return 'success';

    }


    public function truncate()
    {

        // 独立版本
        $this->wxintermediatable->truncate();

    }
}
