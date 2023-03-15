<?php
use Illuminate\Support\Facades\DB;
use \Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| HR服务端路由
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
 * 访问页面路由
 */

// 微信相关
Route::group(['prefix' => "wechat"], function () {

    Route::any('/', 'WeChatController@serve');
    Route::any('/menu', 'WeChatController@menu');
    Route::any('/message', 'WeChatController@templateMessage');
    Route::any('/callback', 'WeChatController@callback');
});

Route::group(['prefix' => "tools"], function () {

    Route::get('/session/flush', function (Request $request) {
        $request->session()->flush();
        return '清理成功';
    });

    Route::get('md5/encode', function (Request $request) {
        $pwd = $request->get('pwd', 123456);
        return "明文密码：$pwd,密文:" . md5(base64_encode($pwd));
    });

    Route::get('aes/decode', function (Request $request) {
        $pwd = $request->get('pwd', '9sHNvNHkPpWo6Fccp2QsTw==');
        return DB::select(DB::raw("SELECT AES_DECRYPT(FROM_BASE64('" . $pwd . "'),'wechat')"));
    });

    Route::get('aes/encode', function (Request $request) {
        $pwd = $request->get('pwd', 123456);
        return DB::select(DB::raw("SELECT TO_BASE64(AES_ENCRYPT('" . $pwd . "','wechat'))"));
    });
});


// 测试短信发送
Route::any('/sms/test', 'Api\VerifyCodeController@testSendTencentCloudSms');


Route::get('/', function () {
    return view('welcome');
});


//绑定页面
Route::get('userBind', 'HrService\UserController@userBindView');
//个人用户
Route::group(['prefix' => "user", 'middleware' => ['wechat.auth']], function () {

    Route::group(['prefix' => "view", 'middleware' => []], function () {
        // 个人首页
        Route::get('home', 'HrService\UserController@userHomeView');
        // 个人信息
        Route::get('userinfo', 'HrService\UserController@useInfoView');
        //我的部门页面
        Route::get('mydepartment', 'HrService\UserController@myDepartmentView');

    });

});

/**
 * 考勤
 */
Route::group(['prefix' => "attendance", 'middleware' => ['wechat.auth']], function () {

    //访问页面
    Route::group(['prefix' => "view", 'middleware' => []], function () {
        //我的日历
        Route::get('canlendar', 'HrService\AttendanceController@myCanlendarView');
        //考勤汇总
        Route::get('summary', 'HrService\AttendanceController@attendanceSummaryView');
        //考勤详细信息
        Route::get('detail', 'HrService\AttendanceController@attendanceDeatilView');
        //总考勤排名
        Route::get('attendance-list', 'HrService\AttendanceController@attendanceListView');
        //加班排名
        Route::get('overtime-list', 'HrService\AttendanceController@overTimeRankingView');
        //请假排名
        Route::get('leave-list', 'HrService\AttendanceController@leaveRankingView');
        //考勤异常排名
        Route::get('attend-error', 'HrService\AttendanceController@attendRankingView');
        //考勤确认页面
        Route::get('attendance-check', 'HrService\AttendanceController@attendanceCheckView');
    });

});

Route::get('password/view/forget-password', 'HrService\SalaryController@forgetPasswordView');

//薪资
Route::group(['prefix' => "salary", 'middleware' => ['cut.database', 'wechat.auth']], function () {
    //页面
    Route::group(['prefix' => "view", 'middleware' => []], function () {
        //薪酬查询
        Route::get('staff-salary', 'HrService\SalaryController@staffsalaryView');
        //调薪历史
        Route::get('salary-query', 'HrService\SalaryController@salaryQueryView');
        //薪酬详细
        Route::get('salary-detail', 'HrService\SalaryController@salaryDetailView');
        //调薪更多页面
        Route::get('query-more', 'HrService\SalaryController@queryMoreView');


    });
});
//节假日
Route::group(['prefix' => "holiday", 'middleware' => ['cut.database', 'wechat.auth']], function () {
    //页面
    Route::group(['prefix' => "view", 'middleware' => []], function () {
        //节假日汇总
        Route::get('all', 'HrService\HolidayController@holidayAllView');
        //节假日详情
        Route::get('detail', 'HrService\HolidayController@holidayDetailView');

    });

});



