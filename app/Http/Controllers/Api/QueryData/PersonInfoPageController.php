<?php

namespace App\Http\Controllers\Api\QueryData;

use App\Http\Controllers\Api\ApiBaseController;
use App\Models\WxPersonalInformationPage;
use Illuminate\Http\Request;

class PersonInfoPageController extends ApiBaseController
{
    // test
    protected $personinfo;

    public function __construct(WxPersonalInformationPage $pi)
    {
        header("Content-type: application/json");
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, OPTIONS, POST");
        header("Access-Control-Allow-Credentials: true");
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding, X-Requested-With, Origin");

        $this->personinfo = $pi;
    }

    public function test(Request $request)
    {
        return $request;
    }

    public function getPersonInfo(Request $request)
    {
        $emp_no = $request->input('emp_no');
        $company_id = $request->input('company_id');
        $result = $this->personinfo->getPersonInfo($company_id, $emp_no);
        return $result->toArray();
    }


}
