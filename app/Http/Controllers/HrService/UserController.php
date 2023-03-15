<?php

namespace App\Http\Controllers\HrService;


use Illuminate\Http\Request;

class UserController extends HrBaseController
{

    public function __construct(Request $request)
    {


    }

    /**
     * 用户个人信息页面
     *  userBindView
     * @param mixed $fixed参数一的说明
     * @Author: Lyn.zou <lyn.zou@areschina.com>
     * @CreateDate: nowtime
     * @Version: 1.0
     * @return array 返回类型
     */
    public function userBindView(Request $request)
    {
        return view('Admin.bind');
    }

    /**
     * 用户首页
     *  userBindView
     * @param mixed $fixed参数一的说明
     * @Author: Lyn.zou <lyn.zou@areschina.com>
     * @CreateDate: nowtime
     * @Version: 1.0
     * @return array 返回类型
     */
    public function userHomeView(Request $request)
    {
        return view('Admin.home');
    }


    /**
     * 用户个人信息页面
     *  useInfoView
     * @param mixed $fixed参数一的说明
     * @Author: Lyn.zou <lyn.zou@areschina.com>
     * @CreateDate: nowtime
     * @Version: 1.0
     * @return array 返回类型
     */
    public function useInfoView(Request $request)
    {
        return view('Department.detailedDatum');
    }

    /**
     * 我的部门页面
     *  myDepartmentView
     * @param mixed $fixed参数一的说明
     * @Author: Lyn.zou <lyn.zou@areschina.com>
     * @CreateDate: nowtime
     * @Version: 1.0
     * @return array 返回类型
     */
    public function myDepartmentView(Request $request)
    {
        $emp_no = session('empNo');
        $companyid = session('companyId');
        $data = [
            'userId' => $emp_no,
            'companyId' => $companyid,
            'staff_no' => $request->get('staff_no')
        ];
        return view('Department.myDepartment')->with($data);
    }

}
