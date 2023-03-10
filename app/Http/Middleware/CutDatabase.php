<?php

namespace App\Http\Middleware;

use Closure;
use GuzzleHttp\Client;
use Illuminate\Http\Response;
use Config;
use Log;

class CutDatabase
{


    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
//        if ($request->get('companyid')) {
//            $companyid = $request->get('companyid');
//        } else {
//
//            $companyid = $this->getCompanyData($request);
//        }
//        if (!$companyid) {
//            return new Response('公司不存在', 403);
//        }
//        if (!in_array($companyid, Config::get('companyList.comanyidList'))) {
//            return new Response('公司有误', 403);
//        }
//        config(['database.connections.mysql.database' => 'work_wechat' . $companyid]);
//

        return $next($request);
    }

    public function getCompanyData($request)
    {
        $jsondata = $request->getContent();
        $jsondata = json_decode($jsondata, JSON_UNESCAPED_UNICODE);

        if (count($jsondata) == 0) {

            return null;
        }
        if (in_array("companyid", $jsondata)) {
            return $jsondata['companyid'];
        } else {
            return null;
        }
    }


}
