<?php

namespace App\Http\Controllers\Api\SyncData;

use App\Http\Controllers\Api\ApiBaseController;
use App\Models\WxCompanyInfo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Webpatser\Uuid\Uuid;
use Config;

class WxCompanyInfoController extends ApiBaseController
{
    //
    protected $companyInfo;

    public function __construct(WxCompanyInfo $companyInfo)
    {
        $this->companyInfo = $companyInfo;
    }

    public function getCompanyId(Request $request)
    {   // TODO UUID token 验证
        $jsondata = $request->getContent();
        $jsondata = json_decode($jsondata, JSON_UNESCAPED_UNICODE);
        if ($jsondata[0]['companyno'] && $companyname = $jsondata[0]['companyname']) {
            $companyno = $jsondata[0]['companyno'];
            $companyname = $jsondata[0]['companyname'];
        } else {
            return '缺少参数';
        }

        // return $this->companyInfo->getCompanyId($companyno,$companyname);
        $company = Config::get('companyList.comapany');
        if ($company[$companyno . $companyname]) {
            return $company[$companyno . $companyname];
        } else {
            return '参数有误';
        }
    }

    public function addCompany(Request $request)
    {

//        $companyno=$request->input('companyno');
//        $companyname=$request->input('companyname');

        $jsondata = $request->getContent();
        $jsondata = json_decode($jsondata, JSON_UNESCAPED_UNICODE);
        $companyno = $jsondata[0]['companyno'];
        $companyname = $jsondata[0]['companyname'];

        $uuid = UUID::generate();
        $this->companyInfo->uuid = $uuid;
        $this->companyInfo->company_no = $companyno;
        $this->companyInfo->company_name = $companyname;
        $this->companyInfo->save();
        return $this->companyInfo->company_id;

    }
}
