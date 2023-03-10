<?php

namespace App\Http\Controllers\Api\HrService;


use Illuminate\Http\Request;
use App\Models\Hr\User;
use Webpatser\Uuid\Uuid;
use App\Models\Hr\Canlendar;
use App\Models\Hr\Leader;
use App\Models\Hr\AttendanceCheck;
use App\Models\Hr\ConfigCode;
use Log;
use App\Http\Controllers\HrService\HrBaseController;

class AttendanceCheckController extends HrBaseController
{
    //
    protected $canlendar;
    protected $configCode;
    protected $attendanceCheck;


    public function __construct(Canlendar $canlendar, AttendanceCheck $attendanceCheck, ConfigCode $configCode)
    {
        $this->canlendar = $canlendar;
        $this->configCode = $configCode;
        $this->attendanceCheck = $attendanceCheck;
    }

    /**
     * 更新员工月考勤确认状态
     *  updateUserAttendanceCheck
     * @param mixed $fixed参数一的说明
     * @Author: Lyn.zou <lyn.zou@areschina.com>
     * @CreateDate: 2019-04-02 14:08:30
     * @Version: 1.0
     * @return array 返回类型
     */
    public function updateUserAttendanceCheck(Request $request)
    {
        try {
            $uuid = UUID::generate();

            $jsondata = $request->getContent();

            $jsondata = json_decode($jsondata, JSON_UNESCAPED_UNICODE);

            $requiredParams = ['companyid', 'info'];

            if ($this->dealJsonRequestParams($jsondata, $requiredParams)) {

                $addArr = array();
                $month_no = date('Y/m', time());
                if (array_key_exists("month_no", $jsondata)) {
                    $month_data = date_parse_from_format('Y-m', $jsondata['month_no']);
                    $month_no = $month_data['year'] . '-' . (strlen($month_data['month']) > 1 ? $month_data['month'] : '0' . $month_data['month']);
                }
                foreach ($jsondata['info'] as $item) {
                    $check = [
                        'company_id' => $jsondata['companyid'],
                        'emp_no' => $item['emp_no'],
                        'attendance' => json_encode($item['attendance']),
                        'status' => 0,
                        'month_no' => $month_no,
                        'uuid' => $uuid,
                        'created_at' => date('Y-m-d H:i:s', time())
                    ];
                    $addArr[] = $check;
                }
                if (count($addArr) > 0) {
                    $result = $this->attendanceCheck->insert($addArr);

                    if ($result) {
                        return $this->success('0', 'success');
                    } else {
                        throw new \Exception('error');
                    }
                } else {
                    throw new \Exception('error');
                }
            }

        } catch (\Exception $e) {
            return $this->success('500', $e->getMessage());
        }

    }

    /**
     * 获取员工考勤确认情况
     *  getUserAttendanceCheckResult
     * @param mixed $fixed参数一的说明
     * @Author: Lyn.zou <lyn.zou@areschina.com>
     * @CreateDate: 2019-04-04 09:11:16
     * @Version: 1.0
     * @return array 返回类型
     */
    public function getUserAttendanceCheckResult(Request $request)
    {
        try {
            $companyId = session('companyId');

            $month_no = $request->get('month_no') ? date('Y-m', strtotime($request->get('month_no'))) : date('Y-m', time());

            $select = ['id', 'month_no', 'emp_no', 'result', 'confirm_time'];

            $result = $this->attendanceCheck->getAttendanceInfo($companyId, $month_no, 1, $select);

            if ($result) {
                return $this->success('0', 'success', $result);
            } else {
                throw new \Exception('error');
            }

        } catch (\Exception $e) {
            return $this->success('500', $e->getMessage());
        }

    }

    /**
     * 更新数据确认更新的情况
     *  updateAttendanceCheckInfoResult
     * @param mixed $fixed参数一的说明
     * @Author: Lyn.zou <lyn.zou@areschina.com>
     * @CreateDate: 2019-04-04 10:37:43
     * @Version: 1.0
     * @return array 返回类型
     */
    public function updateAttendanceCheckInfoResult(Request $request)
    {
        try {
            $jsondata = $request->getContent();

            $jsondata = json_decode($jsondata, JSON_UNESCAPED_UNICODE);

            $requiredParams = ['companyid', 'idlist', 'month_no'];

            $updateArr = array();

            if ($this->dealJsonRequestParams($jsondata, $requiredParams)) {

                if (count($jsondata['idlist']) > 0) {
                    $result = $this->attendanceCheck->updateBatch($jsondata['idlist']);

                    if ($result) {
                        return $this->success('0', 'success', $result);
                    } else {
                        throw new \Exception('error');
                    }
                } else {
                    throw new \Exception('请选择需要更新的用户信息');
                }

            }
        } catch (\Exception $e) {
            return $this->success('500', $e->getMessage());
        }
    }


    /**
     * 查询用户考勤确认详情信息
     *  getUserAttendanceInfo
     * @param mixed $fixed参数一的说明
     * @Author: Lyn.zou <lyn.zou@areschina.com>
     * @CreateDate: 2018-04-11 10:31:15
     * @Version: 1.0
     * @return array 返回类型
     */
    public function getUserAttendanceInfo(Request $request)
    {
        $this->validate($request, [
            'emp_no' => 'required',
            'month_no' => 'required',
        ]);
        try {
            $companyId = session('companyId');
            $emp_no = $request->get('emp_no');
            $month_no = $request->get('month_no');

            $_attendanceCheck = $this->attendanceCheck->getUserAttendanceInfo($companyId, $month_no, $emp_no);

            if ($_attendanceCheck) {
                $attecdance = json_decode($_attendanceCheck->attendance, JSON_UNESCAPED_UNICODE);

                $codeList = $this->dealObjectToArrayByKey($this->configCode->getCodeByType('attendance'), 'code');

                $result = array();
                $result['id'] = $_attendanceCheck->id;
                $result['status'] = $_attendanceCheck->status;
                $attendanceList = array();
                foreach ($attecdance as $k => $item) {
                    $attendanceList[] = [
                        'code' => $k,
                        'diaplayName' => $codeList[$k]['display_name'],
                        'value' => $item,
                    ];
                }
                $result['attendanceList'] = $attendanceList;
                return $this->success(0, 'success', $result);
            } else {
                throw new \Exception('缺少考勤数据');
            }


        } catch (\Exception $e) {
            return $this->success('500', $e->getMessage());
        }

    }

    /**
     * 用户数据确认更新的情况
     *  updateAttendanceCheckInfoResult
     * @param mixed $fixed参数一的说明
     * @Author: Lyn.zou <lyn.zou@areschina.com>
     * @CreateDate: 2019-04-04 10:37:43
     * @Version: 1.0
     * @return array 返回类型
     */
    public function commitUserAttendanceCheckResult(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
            'result' => 'required',
        ]);

        try {
            $id = $request->get('id');
            $commitdata = [
                'status' => 1,
                'confirm_time' => date('Y-m-d H:i:s', time()),
                'result' => $request->get('result'),
                'note' => $request->get('note'),
            ];

            $result = $this->attendanceCheck->where('id', $id)->where('status', 0)->update($commitdata);

            if ($result) {
                return $this->success(0, '提交成功');
            } else {
                return $this->success(500, '提交失败');
            }

        } catch (\Exception $e) {
            return $this->success('500', $e->getMessage());
        }

    }

    /**
     * 更新某个公司整月的考勤确认情况
     *  refreshMonthType
     * @param mixed $fixed参数一的说明
     * @Author: Lyn.zou <lyn.zou@areschina.com>
     * @CreateDate: 2019-04-04 10:37:43
     * @Version: 1.0
     * @return array 返回类型
     */
    public function refreshMonthType(Request $request)
    {
        $this->validate($request, [
            'month_no' => 'required',
        ]);

        try {
            $month_data = date_parse_from_format('Y-m', $request->get('month_no'));
            $month_no = $month_data['year'] . '-' . (strlen($month_data['month']) > 1 ? $month_data['month'] : '0' . $month_data['month']);

            $companyId = session('companyId');
            $commitdata = [
                'status' => 3,
                'updated_at' => date('Y-m-d H:i:s', time()),

            ];
            $result = $this->attendanceCheck->where('company_id', $companyId)->where('month_no', $month_no)->update($commitdata);

            if ($result) {
                return $this->success(0, '提交成功');
            } else {
                return $this->success(500, '提交失败');
            }

        } catch (\Exception $e) {
            return $this->success('500', $e->getMessage());
        }
    }
}
