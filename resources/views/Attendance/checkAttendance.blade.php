@extends('Layout.WebApp_Layout')
@section('css')
    <link href="{{ asset('/css/attendance.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/css/from.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('/css/element.css') }}" type="text/css">
@endsection

@section('content')
    <div id="checkAttendance" >
        <div class="attendance_check_detail"></div>
        <div class="attendance-check-info" >
            <div class="attendance-title">
                <p>@{{ userName }}</p>
                <p>@{{ monthNo }}</p>
            </div>
            <div  class="attendance-check-detail" v-if="ifData">
                <div class="attendance-cell" v-for="item in attendanceInfo">
                    <span class="detail-type">@{{item.diaplayName}}</span>
                    <span class="detail-value">@{{item.value}}</span>
                </div>
                <div v-if="ifSummit">
                    <mt-radio
                            title="确认结果"
                            v-model="checkForm.result"
                            :options="resultOptions">
                    </mt-radio>
                    {{--<mt-field  label="说明" placeholder="请输入" type="textarea" rows="2" v-model="checkForm.note"></mt-field>--}}
                </div>

                <div class="attendance-btn" v-if="ifSummit">
                    <mt-button type="default" size="small" @click="cancleBtnClick">{{trans('admin.cancle_btn')}}</mt-button>
                    <mt-button type="primary" size="small" @click="sureBtnClick">{{trans('admin.sure_btn')}}</mt-button>
                </div>

            </div>
            <div class="attendance_without_data" v-else>
                {{trans('admin.without_data')}}
            </div>
        </div>


    </div>

@endsection

@section('js')
    <script src="{{asset('js/index.js')}}"></script>
    <script>
        new Vue({
            el:'title',
            data:{
                page_title:'{{trans('attendance.check_attendance')}}'
            }
        })
    </script>
    <script>

        var userID = "{{ $userId }}";
        new Vue({
            el:'#checkAttendance',
            data:{
                login_logo:'/images/ares.png',
                btnDisabled:false,
                monthNo:"{{ $month_no }}",
                userName:"{{ $userName }}",
                ifData:false,
                ifSummit:false,
                attendanceInfo:[],
                resultOptions:[
                    {
                        label: '确认无误',
                        value: '0'
                    },
                    {
                        label: '存在问题(请跟相关人员反应)',
                        value: '1'
                    }
                ],
                checkForm:{
                    id:null,
                    companyid:"{{ $companyId }}",
                    result:'0',
                    note:""
                }
            },
            mounted: function() {
                this.getAttendanceCheckInfo();

            },
            methods: {
                getAttendanceCheckInfo:function () {
                    var that = this;
                    that.$indicator.open();
                    axios.get("/api/attendance/attendance-info",{params:{month_no:that.monthNo,emp_no:userID}}).then(function (res) {
                        var result=res.data;
                        if(result.code==0){
                            that.ifData=true;
                            that.attendanceInfo=result.data.attendanceList;
                            that.checkForm.id=result.data.id;
                            if(result.data.status==0)that.ifSummit=true;
                        }
                        that.$indicator.close();
                    });
                },
                cancleBtnClick:function () {
                    history.go(-1);
                },
                sureBtnClick:function () {
                    var that = this;
                    that.$messagebox({
                        title: '提示',
                        message: '确定执行此操作?',
                        showCancelButton: true
                    });
                    that.$messagebox.confirm('确定执行此操作?').then(action => {
                        that.commitAttendanceCheckInfo();
                });
                },
                commitAttendanceCheckInfo:function () {
                    var that = this;
                    that.$indicator.open();
                    axios.post("/api/attendance/commit-user-check",that.checkForm).then(function (res) {
                        var result=res.data;
                        that.$toast(result.msg);
                        if(result.code==0){
                            that.ifSummit=false;
                            setTimeout(function (){
                                history.go(-1);
                            }, 1500);
                        }
                        that.$indicator.close();
                    });
                },
            }
        })
    </script>

@endsection