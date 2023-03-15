<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\DB;

/**
 * desc
 *
 * @author hsiaowei
 * @date  2023/3/6
 */
trait CommonTrait
{

    /**
     * 返回失败的json数据
     *
     * @param \Exception $ex
     * @return string 'code'            =>    -999,
     *
     * 'code'            =>     -999,
     * 'message'        =>      'fail'
     * ];
     */
    public function fail(\Exception $ex)
    {
        if ($ex->getCode() == 0) {
            $code = -999;
        } else {
            $code = $ex->getCode();
        }

        if ('Trying to get property of non-object' == $ex->getMessage()) {
            return [
                'code' => -50000,
                'msg' => '当前系统错误，请重试！',
            ];
        } else {

            return [
                'code' => $code,
                'msg' => $ex->getMessage(),
            ];
        }
    }

    /**
     * 返回成功的json数据
     *
     * @return array
     *
     * [
     *    'code'            =>    1,
     *    'message'        =>    'success',
     *    'data'            =>    ''
     * ];
     *
     */
    public function success($code = 0, $message = false, $data = [])
    {
        $jsonArray ['code'] = $code;
        $jsonArray ['msg'] = $message ?: $this->getErrorMsg($code);
        empty($data) ?: $jsonArray ['data'] = $data;
        return response()->json($jsonArray);
    }

    /**
     * 全局返回码
     * @param $errcode
     */
    public static function getErrorMsg($errcode = 0)
    {
        $msg = array(
            0 => '请求成功',
            1 => '请求失败',
            -1 => '系统繁忙，此时请开发者稍候再试',
            2001 => '二维码有误！',
            3001 => '账号异常，请联系管理员',
            4001 => '操作失败',
            4002 => '不合法的请求',
            4003 => '参数有误',
            4004 => '数据重复',
            4005 => '暂不允许操作',
            -5000 => '当前系统错误，请重试',

        );
        return $msg[$errcode];
    }

    /**
     * 二维数组排序
     * @param array $arr 需要排序的二维数组
     * @param string $keys 所根据排序的key
     * @param string $type 排序类型，desc、asc
     * @return array $new_array 排好序的结果
     */
    function array_sort($array, $field, $sort = 'SORT_DESC')
    {
        $arrSort = array();
        foreach ($array as $uniqid => $row) {
            foreach ($row as $key => $value) {
                $arrSort[$key][$uniqid] = $value;
            }
        }
        if (count($array) > 0) {
            array_multisort($arrSort[$field], constant($sort), $array);
        }

        return $array;
    }


    /**
     * 分组
     * @param $errcode
     */
    public static function array_group_by($arr, $key)
    {
        $grouped = [];
        foreach ($arr as $value) {
            $grouped[$value[$key]][] = $value;
        }

        if (func_num_args() > 2) {
            $args = func_get_args();
            foreach ($grouped as $key => $value) {
                $parms = array_merge([$value], array_slice($args, 2, func_num_args()));
                $grouped[$key] = call_user_func_array('array_group_by', $parms);
            }
        }
        return $grouped;
    }

    /**
     * 对象 转 数组
     *
     * @param object $obj 对象
     * @return array
     */
    public function object_to_array($stdclassobject)
    {
        $array = array();
        if (count($stdclassobject) > 0) {
            $_array = is_object($stdclassobject) ? get_object_vars($stdclassobject) : $stdclassobject;
            foreach ($_array as $key => $value) {
                $value = (is_array($value) || is_object($value)) ? $this->object_to_array($value) : $value;
                $array[$key] = $value;
            }
        }

        return $array;
    }

    /**
     *  字符串加密
     */
    public function encryptString($str)
    {
        $sql = "SELECT TO_BASE64(AES_ENCRYPT('" . $str . "','wechat'))";
        $search = "TO_BASE64(AES_ENCRYPT('" . $str . "','wechat'))";

        $result = DB::select(DB::raw($sql));
        $result = $this->object_to_array($result);

        return $result[0][$search];
    }

    /**
     *  字符串解密
     */
    public function decryptString($str, $key)
    {
        $sql = "SELECT AES_DECRYPT(FROM_BASE64('" . $str . "'),'" . $key . "')";;
        $search = "AES_DECRYPT(FROM_BASE64('" . $str . "'),'" . $key . "')";
        $result = DB::select(DB::raw($sql));

        $result = $this->object_to_array($result);

        if ($result) {
            foreach ($result[0] as $item) {
                $res = $item;
            }
        } else {
            $res = '';
        }

        return $res;
    }

    /**
     *  部门分类并且计算工龄
     */
    public function departClassify($empRes)
    {
        $depData = array();
        $depArr = array();
        //计算工龄  并且根据部门分类
        foreach ($empRes as $k => $item) {
            if ($item['emp_outdate'] == '') {
                $year = date('Y') - date('Y', strtotime($item['emp_indate']));
                $month = date('m') - date('m', strtotime($item['emp_indate']));
            } else {
                $year = date('Y', strtotime($item['emp_outdate'])) - date('Y', strtotime($item['emp_indate']));
                $month = date('m', strtotime($item['emp_outdate'])) - date('m', strtotime($item['emp_indate']));
            }
            $item['years'] = (string)round((12 * $year + $month) / 12, 1);

            //判断部门数组是否已经存在此部门，存在就进入对应数组，不存在就加入数据
            if (in_array($item['emp_dept'], $depArr)) {
                $key = array_search($item['emp_dept'], $depArr);
                $depData[$key]['emp_count'] += 1;
                $depData[$key]['deptinfo'][] = $item;

            } else {
                $addArr = [];
                $depArr[] = $item['emp_dept'];
                $addArr[] = $item;
                $depData[] = [
                    'deptname' => $item['emp_dept'],
                    'emp_count' => 1,
                    'deptinfo' => $addArr,
                ];
            }

        }
        return $depData;
    }

    /**
     * 计算数组对象中某个字段的累计值
     */
    public function getArrayObjSum($arr, $key)
    {
        $result = '0';
        if ($arr) {
            foreach ($arr as $item) {
                $result += $item->$key;
            }
        }
        return (string)$result;
    }

    /**
     * 批量处理json数据格式里的校验(目前只处理1层对象)
     *  dealJsonRequestParams
     * @param mixed $fixed参数一的说明
     * @Author: Lyn.zou <lyn.zou@areschina.com>
     * @CreateDate: 2019-04-04 10:48:19
     * @Version: 1.0
     * @return array 返回类型
     */
    public function dealJsonRequestParams($jsondata, $params = [])
    {
        if ($jsondata) {
            foreach ($params as $item) {

                if (!array_key_exists($item, $jsondata)) {
                    throw new \Exception('缺少参数' . $item);
                    return false;
                }
            }
        } else {
            throw new \Exception('缺少json参数');
            return false;
        }

        return true;
    }

    /**
     * 把数组对象处理成key的数组
     *  dealObjectToArrayByKey
     * @param mixed $fixed参数一的说明
     * @Author: Lyn.zou <lyn.zou@areschina.com>
     * @CreateDate: 2019-04-04 10:48:19
     * @Version: 1.0
     * @return array 返回类型
     */
    public function dealObjectToArrayByKey($object, $key)
    {
        $result = array();
        foreach ($object as $item) {
            $result[$item[$key]] = $item;

        }

        return $result;
    }

}