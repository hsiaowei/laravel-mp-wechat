<?php

namespace App\Http\Controllers\HrService;


use App\Models\Hr\Salaryp;
use Illuminate\Http\Request;
use App\Models\Hr\User;
use Illuminate\Support\Facades\Cache;
use App\Models\Hr\SalaryPwd;
use App\Models\Hr\SalaryOldPwd;
use App\Models\Hr\Salary;
use App\Http\Controllers\HrService\HrBaseController;

class SalaryController extends HrBaseController
{

    protected $emp_no;
    protected $companyid;

    public function __construct(Request $request)
    {

    }
    /**
     * 调薪历史页面
     *  salaryQuery
     * @param mixed $fixed参数一的说明
     * @Author: Lyn.zou <lyn.zou@areschina.com>
     * @CreateDate: nowtime
     * @Version: 1.0
     * @return array 返回类型
     *
     */
    public function salaryQueryView(Request $request){

        $emp_no=  session('empNo');
        $companyid= session('companyId');
        $data=[
            'userId'=> $emp_no,
            'companyId'=>$companyid,
        ];
        $salaryPwd=new SalaryPwd();
        //查询是否修改过密码（第一次登陆）  Y:第一次登陆  N不是第一次登陆
        $res= $salaryPwd->getUserSalaryPwd($companyid,$emp_no);
        /*if(count($res)==0){
            $data['isfirstlogin']='Y';
        }else{
            $data['isfirstlogin']='N';
        }*/
        $data['isfirstlogin'] = $this->checkEmpty($res);

        return view('Salary.salaryQuery')->with($data);
    }
    /**
     * 酬薪查询页面
     *  staffsalary
     * @param mixed $fixed参数一的说明
     * @Author: Lyn.zou <lyn.zou@areschina.com>
     * @CreateDate: nowtime
     * @Version: 1.0
     * @return array 返回类型
     *
     */
    public function staffsalaryView(Request $request){

        $emp_no=  session('empNo');
        $companyid= session('companyId');

        $data=[
            'userId'=> $emp_no,
            'companyId'=>$companyid,
        ];

        $salaryPwd=new SalaryPwd();
        //查询是否修改过密码（第一次登陆）  Y:第一次登陆  N不是第一次登陆
        $res= $salaryPwd->getUserSalaryPwd($companyid,$emp_no);

        $data['isfirstlogin'] = $this->checkEmpty($res);

        return view('Salary.staffSalary')->with($data);
    }
    /**
     * 酬薪详情页面
     *  salaryDetail
     * @param mixed $fixed参数一的说明
     * @Author: Lyn.zou <lyn.zou@areschina.com>
     * @CreateDate: nowtime
     * @Version: 1.0
     * @return array 返回类型
     *
     */
    public function salaryDetailView(Request $request){


        $emp_no=  session('empNo');
        $companyid= session('companyId');

        $data=[
            'userId'=>$emp_no,
            'companyId'=>$companyid
        ];

        $salaryPwd=new SalaryPwd();
        //查询是否修改过密码（第一次登陆）  Y:第一次登陆  N不是第一次登陆
        $res= $salaryPwd->getUserSalaryPwd($companyid,$emp_no);

        $data['isfirstlogin'] = $this->checkEmpty($res);

        return view('Salary.salaryDetails')->with($data);
    }


    /**
     * 调薪查看更多页面
     *  queryMoreView
     * @param mixed $fixed参数一的说明
     * @Author: Lyn.zou <lyn.zou@areschina.com>
     * @CreateDate: nowtime
     * @Version: 1.0
     * @return array 返回类型
     */
    public function queryMoreView(Request $request)
    {


        $emp_no=  session('empNo');
        $companyid= session('companyId');

        $data=[
            'userId'=>$emp_no,
            'companyId'=>$companyid,
            'staff_no'=>$request->get('staff_no')
        ];

        $salaryPwd=new SalaryPwd();
        //查询是否修改过密码（第一次登陆）  Y:第一次登陆  N不是第一次登陆
        $res= $salaryPwd->getUserSalaryPwd($companyid,$emp_no);

        $data['isfirstlogin'] = $this->checkEmpty($res);

        return view('Salary.salaryMore')->with($data);
    }
    /**
     * 忘记密码页面
     *  queryMoreView
     * @param mixed $fixed参数一的说明
     * @Author: Lyn.zou <lyn.zou@areschina.com>
     * @CreateDate: 2019-03-28 14:23:56
     * @Version: 1.0
     * @return array 返回类型
     */
    public function forgetPasswordView(Request $request)
    {
        $emp_no=  session('empNo');
        $companyid= session('companyId');
        $data=[
            'userId'=>$emp_no,
            'companyId'=>$companyid,
            'staff_no'=>$request->get('staff_no')
        ];


        return view('Salary.forgetPassword')->with($data);
    }

    /**
     * 判断是否登陆过
     * @param $res
     * @return string
     */
    public function checkEmpty($res): string
    {
        return (empty($res) || count($res)==0)?"Y":"N";
    }
}
