<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class ApiBaseController extends Controller
{
    /**
     * Http Status Code, Default 200
     * @var int
     */
    protected $statusCode = 200;

    /**
     * Get Http Status Code
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Set Http Status Code
     * @param $code
     * @return $this
     */
    public function setStatusCode($code)
    {
        $this->statusCode = $code;
        return $this;
    }

    /**
     * 404 not found
     * @param string $msg
     * @return mixed
     */
    public function response404($msg = 'Not Found')
    {
        return $this->setStatusCode(404)->responseError($msg, 404);
    }

    /**
     * Response error message when some errors occurred
     * @param $msg
     * @param int $errcode
     * @return mixed
     */
    public function responseError($msg, $errcode = 0)
    {
        return $this->response([
            'status' => 'failed',
            'error' => [
                'code' => $errcode,
                'msg' => $msg
            ]
        ]);
    }

    /**
     * Response success json when api execute success
     * @param $data
     * @return mixed
     */
    public function responseSuccess($data)
    {
        return $this->response([
            'status' => 'success',
            'code' => $this->getStatusCode(),
            'data' => $data
        ]);
    }

    /**
     * Response data with status code
     * @param $data array
     * @return mixed
     */
    public function response($data)
    {
        return \Response::json($data,
            $this->getStatusCode(),
            ['Content-type' => 'application/json; charset=utf-8'],
            JSON_UNESCAPED_UNICODE
        );
    }

}