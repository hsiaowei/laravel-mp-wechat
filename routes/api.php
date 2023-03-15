<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::any('getUserById/{userid}', 'Api\WorkWechat\UserController@getUserById');
//Route::any('addUser', 'Api\WorkWechat\UserController@addUser');
//Route::any('sendMessage/{msg_type}', 'Api\WorkWechat\MessengerController@sendMessage');
//

////SYNC empbasic data
//Route::post('emp/syncEmpBasic', 'Api\SyncData\WxEmpInfoController@syncEmpBasic');
////SYNC EmpSchedule data
//Route::post('schedule/syncEmpSchedule', 'Api\SyncData\WxScheduleController@syncEmpSchedule');
////SYNC shift data
//Route::post('shift/syncShift', 'Api\SyncData\WxShiftinfoController@syncShift');

//SYNC data
Route::group(['middleware'=>['cut.database']], function(){
    Route::any('syncdata', 'Api\SyncData\WxIntermediateTableController@syncData');
    //删除用户
    Route::any('user/delete', 'Api\HrService\UserController@deleteUserInfo');
});
// truncate
Route::any('truncate', 'Api\SyncData\WxIntermediateTableController@truncate');


Route::group(['middleware'=>['wechat.auth']], function(){
    //Route::any('personinfopage', 'Api\QueryData\PersonInfoPageController@test');
    Route::any('personinfopage', 'Api\QueryData\PersonInfoPageController@getPersonInfo');
});


// 不需要授权
// 效验用户是否存在
Route::get('/user/exist','Api\HrService\UserController@getUserExist');
// 用户绑定
Route::get('/user/bind','Api\HrService\UserController@setUserBindEmp');
//发送验证码
Route::get('/sendCode','Api\VerifyCodeController@sendVerifyCode');
//个人用户
Route::group(['prefix' => "user",'middleware' => ['web','cut.database','wechat.auth']], function(){
    //获取个人信息接口数据
    Route::get('getinfo','Api\HrService\UserController@getUserInfo');
    //获取我的部门信息
    Route::get('my-department','Api\HrService\UserController@getMydepartmentInfo');
});


/**
 * 考勤
 */
//获取可显示年月信息
Route::get('attendance/year-list','Api\HrService\AttendanceController@getYearList');
//返回当前年月
Route::get('attendance/currentMonth',function( ){
    $data=date('Y-m');
    return $data;
    //   Department.detailedDatum
});
Route::group(['prefix' => "attendance",'middleware' => ['web','cut.database','wechat.auth']], function(){

    //获取某个月的考勤信息
    Route::get('canlendar-info','Api\HrService\AttendanceController@getCanlendarInfo');
    //获取某月考勤汇总
    Route::get('canlendar-summary','Api\HrService\AttendanceController@getattendanceSummary');
    //获取某月考勤汇总详情
    Route::get('summary-detail','Api\HrService\AttendanceController@getSummaryDetail');
    //考勤排名
    Route::get('ranking-list','Api\HrService\AttendanceController@getattendanceRankingInfo');
    Route::get('attendance-info','Api\HrService\AttendanceCheckController@getUserAttendanceInfo');
    //更新考勤确认结果
    Route::any('commit-user-check','Api\HrService\AttendanceCheckController@commitUserAttendanceCheckResult');
});

Route::group(['prefix' => "attendance-check",'middleware' => ['cut.database']], function(){

    //新增考勤确认
    Route::any('add-check','Api\HrService\AttendanceCheckController@updateUserAttendanceCheck');
    //获取考勤确认结果
    Route::any('check-result','Api\HrService\AttendanceCheckController@getUserAttendanceCheckResult');
    //更新考勤确认结果
    Route::any('update-user-check','Api\HrService\AttendanceCheckController@updateAttendanceCheckInfoResult');
    //停止所有用户某月的提交
    Route::get('stop-month-check','Api\HrService\AttendanceCheckController@refreshMonthType');


});


//薪资
Route::group(['prefix' => "salary",'middleware' => ['web','cut.database','wechat.auth']], function(){

    //修改密码接口(银行账号)
    Route::get('bank-modify-pwd','Api\HrService\SalaryController@bankModifyNewSalaryPwd');
    //修改密码接口（原密码）
    Route::get('modify-pwd','Api\HrService\SalaryController@modifyNewSalaryPwd');
    //修改密码接口
    Route::get('check-pwd','Api\HrService\SalaryController@checkSalaryNewPwd');
    //获取薪酬详细信息
    Route::get('salary-detail','Api\HrService\SalaryController@getSalaryDetail');
    //调薪历史数据
    Route::get('salary-query','Api\HrService\SalaryController@getSalaryQueryTotal');
    //调薪查看更多
    Route::get('query-more','Api\HrService\SalaryController@getQueryMoreInfo');
    //获取部署薪酬
    Route::get('staff-salary','Api\HrService\SalaryController@getStaffSalaryInfo');


});

//假日
Route::group(['prefix' => "holiday",'middleware' => ['cut.database']], function(){

    //获取用户当年节假日详情
    Route::get('get-all','Api\HrService\HolidayController@getUserAllHoliday');
    //获取用户详细数据
    Route::get('get-detail','Api\HrService\HolidayController@getUserMonthHolidayDetail');



});

Route::post('register', 'ApiController@register');
Route::post('get-token', 'ApiController@login');
Route::group(['middleware' =>['auth.jwt','cut.database']], function () {
    Route::get('logout', 'ApiController@logout');
    //删除考勤数据
    Route::post('attendance/delete','Api\HrService\AttendanceController@deleteAttendanceUserInfo');
    //删除薪资数据
    Route::post('salary/delete','Api\HrService\SalaryController@deleteSalaryUserInfo');

});




