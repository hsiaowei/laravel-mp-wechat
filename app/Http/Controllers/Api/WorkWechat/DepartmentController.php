<?php

namespace App\Http\Controllers\Api\WorkWechat;

use Illuminate\Http\Request;

class DepartmentController extends WechatBaseController
{
    protected $department;

    public function __construct()
    {
        parent::__construct();
        $this->department = $this->workWeChat->agent('contacts')->department;
    }


    /**
     * add department to contacts
     * @param Request $request
     * @return mixed
     */
    public function addDepartment(Request $request)
    {
        $dept['name'] = $request->name;
        $dept['parentid'] = $request->parentid;
        return $this->responseWeChat($this->department->create($dept));
    }

    public function updateDepartment(Request $request)
    {
//        $dept['department_id'] = $request->department_id,
        $dept['name'] = $request->name;
        $dept['parentid'] = $request->parentid;
        return $this->responseWeChat($this->department->update($request->department_id, $dept));
    }

    public function deleteDepartmentById($deparment_id)
    {
        return $this->responseWeChat($this->department->delete($deparment_id));
    }

    /**
     * fixme SDK 抓出来的是部门列表不是指定部门的资料
     * 取部门资料
     * @param Request $request
     * @return mixed
     */
    public function getDepartmentById($department_id)
    {
        return $this->responseWeChat($this->department->list(['id' => $department_id]));
    }

    /**
     * 取所有部门列表，带上下阶
     * @return mixed
     */
    public function getDepartmentList()
    {
        return $this->responseWeChat($this->department->list());
    }
}
