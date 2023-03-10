@extends('Layout.WebApp_Layout')
@section('css')
    <link href="{{ asset('/css/month.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/css/details.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
    <div id="overtime" v-cloak>
        <div class="details_header">
            <div class="block">
                <p class="fa fa-calendar"></p>
                <mt-field v-model="toymd" id="toymd"></mt-field>
                <mt-popup v-model="popupVisible" position="bottom" >
                    <div class="time-button-view">
                        <span class="time-button-view-button" @click="popupVisible=false">取消</span>
                        <span @click="onSureTimeClick">确定</span>
                    </div>
                    <mt-picker :slots="slots" @change="onValuesChange"></mt-picker>
                </mt-popup>
                <div class="input_group" @click="choose_years" readonly="readonly"></div>
            </div>
        </div>

        {{--<a @click="click_url(1)" v-bind:href="{{URL('/details/attendanceItem?selected=1')}}">--}}
        <div v-if="ifData">
            <mt-datetime-picker
                    :visible.sync="showTime"
                    type="date"
                    year-format="{value} 年"
                    month-format="{value} 月">
            </mt-datetime-picker>
            <a @click="click_url(1)" v-bind:href="list_url">
            <div class="details_card attend_card">
                <el-row>
                    <el-col :span="8" class="bg-purple">
                        <p class="card_title">{{trans('details.attendance_situation')}}</p>
                    </el-col>
                    <el-col :span="7" class="bg-card">
                        <div class="card_time" v-for="(attend, key) in attends">@{{ attend.type}}: <span>@{{ attend.hours | time_unit}}</span></div>
                    </el-col>
                    <el-col :span="9" class="card_right">
                        <img src="{{ asset('/images/round_bgimg.png') }}">
                        <div class="card_mes">
                            <p class="card_mes_num">@{{ signall|time_unit }}</p>
                            <p class="card_mes_text">{{trans('details.amount_to')}}</p>
                        </div>
                    </el-col>
                </el-row>
            </div>
            </a>
            <a @click="click_url(2)" v-bind:href="list_url">
            {{--<a href="https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxffbe4a3d8b2acc48&redirect_uri=http://cloud.areschina.com:8082/details/calendar&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect">--}}
            <div class="details_card leave_card">
                <el-row>
                    <el-col :span="8" class="bg-purple">
                        <p class="card_title">{{trans('details.leave_situation')}}</p>
                    </el-col>
                    <el-col :span="7" class="bg-card">
                        <div class="card_time" v-for="(leave, key) in leaves">@{{ leave.type}}: <span>@{{ leave.hours | time_unit}}</span></div>
                    </el-col>
                    <el-col :span="9" class="card_right">
                        <img src="{{ asset('/images/round_bgimg.png') }}">
                        <div class="card_mes">
                            <p class="card_mes_num">@{{ leaveall |time_unit}}</p>
                            <p class="card_mes_text">{{trans('details.amount_to')}}</p>
                        </div>
                    </el-col>
                </el-row>
            </div>
            </a>
            <a @click="click_url(3)"  v-bind:href="list_url">
            <div class="details_card overtime_card">
                <el-row>
                    <el-col :span="8" class="bg-purple">
                        <p class="card_title">{{trans('details.overtime_situation')}}</p>
                    </el-col>
                    <el-col :span="7" class="bg-card">
                        <div class="card_time" v-for="(type, key) in overtype">@{{ type.type|ovtype}}: <span>@{{ type.hours| time_unit}}</span></div>
                    </el-col>
                    <el-col :span="9" class="card_right">
                        <img src="{{ asset('/images/round_bgimg.png') }}">
                        <div class="card_mes">
                            <p class="card_mes_num">@{{ overall|time_unit }}</p>
                            <p class="card_mes_text">{{trans('details.amount_to')}}</p>
                        </div>
                    </el-col>
                </el-row>
            </div>
            </a>
        </div>
        <div v-else>
            <div class="without_data overtime_card">
                {{trans('admin.without_data')}}

            </div>

        </div>
        <div class="check_attendance_btn" v-if="ifCheck">
            <a @click="routeAttendance"  v-bind:href="checkUrl">
            <mt-button type="primary">{{trans('attendance.check_attendance')}}</mt-button>
            </a>


        </div>
    </div>
@endsection

@section('js')
    <script src="{{asset('js/index.js')}}"></script>
    <script>

        new Vue({
            el:'title',
            data:{
                page_title:'{{trans('details.user_situation')}}'
            }
        })
    </script>
<script>
    var a = 0;
    var userID = "{{ $userId }}";

    new Vue({
        el: '#overtime',
        data: {
            toymd:'',
            list_url:'#',
            checkUrl:'#',
            overtimes:[],
            overtype:[],
            attends:[],
            leaves:[],
            leavetimes:[],
            signtimes:[],
            leaveall:0,
            overall:0,
            signall:0,
            ifData:false,
            ifCheck:false,
            overtime_number:'',
            attend_number:'',
            leave_number:'',
            popupVisible: false,
            showTime: false,
            selectTime:null,
            slots: [
                {
                    defaultIndex:0,
                    flex: 1,
                    values: [],
                    className: 'slot1',
                    textAlign: 'center'
                },
                {
                    divider: true,
                    content: '-',
                    className: 'slot2'
                },
                {
                    defaultIndex:0,
                    flex: 1,
                    values: ['01', '02', '03', '04', '05', '06','07', '08', '09', '10', '11', '12'],
                    className: 'slot3',
                    textAlign: 'center'
                }
            ]
        },
        mounted:function(){
            var that = this;

            axios.get("/api/attendance/year-list").then(function (res) {
                that.slots[0].values = res.data;
                that.user_details(that.toymd);
            });

        },
        filters:{
            time_unit:function (value) {
                return value+"H";
            },
            ovtype:function (value) {

                if(value == 'N'){
                    return "平时";
                }
                if(value == 'S'){
                    return "假日";
                }
                if(value == 'H'){
                    return "国假";
                }
                return value ;
            },
        },
        methods: {
            choose_years:function () {
                this.selectTime=this.toymd;
                this.popupVisible = true;

            },
            onValuesChange:function(picker,values) {
                a++;
                if(a>2){
                    if(values[0] == '' ||values[0] == undefined){
                        values[0] = new Date().getFullYear();
                    }
                    this.selectTime = values[0] + '-' + values[1];
                }
            },
            onSureTimeClick:function() {
                if(this.toymd!=this.selectTime){
                    this.toymd=this.selectTime;
                    this.user_details(this.toymd);
                }
                this.popupVisible=false;

            },

            click_url:function (value){
                var _toymd=this.toymd;
                this.list_url = "{{URL('/attendance')}}"+"/view/detail?selected="+value+"&toymd="+_toymd;
            },
            routeAttendance:function (){
                var _toymd=this.toymd;

                this.checkUrl = "{{URL('/attendance')}}"+"/view/attendance-check?month_no="+_toymd;
            },
            user_details:function (_toymd) {
                var that = this;
                axios.get("/api/attendance/canlendar-summary",{params:{emp_no:userID,month_no: _toymd}}).then(function (res) {
                    var result = res.data.data;
                    that.toymd = result.month;
                    var today = result.month;
                    that.slots[0].defaultIndex = today.substring(0,4)-that.slots[0].values[0];
                    that.slots[2].defaultIndex = today.substring(5,7).replace(/\b(0+)/gi,"") - 1;

                    that.ifData= (res.data.code==0&&result['salary_time'])?true:false;
                    that.attends =[];
                    that.signall =0;
                    that.leaves =[];
                    that.leaveall =0;
                    that.overtype =[];
                    that.overall=0;
                    that.ifCheck=result.checkStatus;
                    if( res.data.code==0&&result['salary_time']){
                        //考勤概况
                        if(result['salary_time']['sign_info']['sum_hours']){
                            that.attends = result['salary_time']['sign_info']['details'];
                            that.signall = result['salary_time']['sign_info']['sum_hours'];
                        }else{

                        }
                        if(result['salary_time']['leave_info']['sum_hours']){
                            //请假概况
                            that.leaves = result['salary_time']['leave_info']['details'];
                            that.leaveall = result['salary_time']['leave_info']['sum_hours'];
                        }
                        if(result['salary_time']['over_info']['sum_hours']){
                            //加班概况
                            that.overtype = result['salary_time']['over_info']['details'];
                            that.overall =result['salary_time']['over_info']['sum_hours'];
                        }

                    }
                    // that.user_details(_toymd);
                })


            }
        }
    })
</script>
@endsection