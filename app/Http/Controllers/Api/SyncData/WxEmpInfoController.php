<?php

namespace App\Http\Controllers\Api\SyncData;

use App\Http\Controllers\Api\ApiBaseController;
use App\Models\WxCompanyInfo;
use App\Models\WxEmpInfoSync;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use  Webpatser\Uuid\Uuid;
use  DB;

class WxEmpInfoController extends ApiBaseController
{
    //
    protected $companyInfo;
    protected $empbasicsyncInfo;

    public function __construct(WxCompanyInfo $companyInfo,WxEmpInfoSync $empbasicsyncInfo)
    {
        $this->companyInfo=$companyInfo;
        $this->empbasicsyncInfo=$empbasicsyncInfo;
    }

    public function syncEmpBasic(Request $request)
  {
      $uuid=UUID::generate();
      $jsondata= $request->getContent();
      $jsondata= json_decode($jsondata, JSON_UNESCAPED_UNICODE);

      $companyid=$jsondata['companyid'];
      $data=[];
      foreach($jsondata['data'] as $key => $val)
      {   $data[$key]['company_id'] = $companyid;
          $data[$key]['uuid'] = $uuid;
          $data[$key]['created_at'] = date('y-m-d G:i:s',time());

          $data[$key]['employee_no'] = $val['a'];
          $data[$key]['employee_name'] = $val['b'];
          $data[$key]['employee_gender'] = $val['c'];
          $data[$key]['employee_indate'] = $val['d'];
          if(!empty($val['e']))
              $data[$key]['employee_outdate'] = $val['e'];
             else  $data[$key]['employee_outdate'] =null;

          $data[$key]['employee_id'] = $val['f'];
      }
      //往数据库批量插入数据
      $result= $this->empbasicsyncInfo ::insert($data);
      if(!$result){
          DB::rollBack();
          return 'error';
      }
      // only insert newdata
      //   add replace into
      try{
          DB::insert("replace into  wx_employee_info  select es.* from wx_employee_info_sync as es
                        where  es.uuid='". $uuid."'" );
      }
      catch (Exception $e){
          DB::rollBack();
          return  'error';
      }; 
      return  'success';

  }

}
