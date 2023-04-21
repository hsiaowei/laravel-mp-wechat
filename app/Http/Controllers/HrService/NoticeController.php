<?php

namespace App\Http\Controllers\HrService;


use App\Models\Hr\Notice;

/**
 * Class NoticeController 公告
 */
class NoticeController extends HrBaseController
{


    /**
     * 公告列表
     *  noticeList
     * @param mixed $fixed参数一的说明
     * @Author: Hsiaowei
     * @CreateDate: 2019-06-20 10:45:45
     * @return array 返回类型
     */
    public function noticeAllView(){
        $companyId = 22;//session('companyId');
        $result = Notice::where('company_id', $companyId)->orderBy('created_at', 'desc')->get()->toArray();
        return view('Notice.noticeAll',['data'=>$result]);
    }
}