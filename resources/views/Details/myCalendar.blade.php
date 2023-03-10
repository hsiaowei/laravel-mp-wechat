@extends('Layout.WebApp_Layout')
@section('css')
    <link href="{{ asset('/css/month.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/css/details.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
    <div id="calendar" v-cloak>
        <div class="calendar_header" id="calendar_header">
            <div class="block">
                <p class="fa fa-calendar"></p>
                <mt-field v-model="toymd" id="toymd"></mt-field>
                <mt-popup v-model="popupVisible" position="bottom">
                    <div class="time-button-view">
                        <span class="time-button-view-button" @click="popupVisible=false">取消</span>
                        <span @click="onSureTimeClick">确定</span>
                    </div>
                    <mt-picker :slots="slots" @change="onValuesChange"></mt-picker>
                </mt-popup>
                <div class="input_group" @click="choose_years" readonly="readonly"></div>
            </div>
        </div>
        <div>
            <ul class="weekdays">
                <li>{{trans('details.Sunday')}}</li>
                <li>{{trans('details.Monday')}}</li>
                <li>{{trans('details.Tuesday')}}</li>
                <li>{{trans('details.Wednesday')}}</li>
                <li>{{trans('details.Thursday')}}</li>
                <li>{{trans('details.Friday')}}</li>
                <li>{{trans('details.Saturday')}}</li>
            </ul>
            <ul class="days">
                <li v-for="(index,day2) in day1"></li>
                <li v-for="(ins,day) in days">
                    <span class="tocoloe" @click="active_date(day+1)">
                    <p v-if="current_year == new Date().getFullYear() && current_month == new Date().getMonth()+1 && day == new Date().getDate()-1"
                       class="active">@{{ day+1 }}</p>
                    <p v-else-if="choice_day == day+1" class="new_active">@{{ day+1 }}</p>
                    <p v-else class="now_active">@{{ day+1 }}</p>
                    </span>

                </li>
                <li v-for="(index,day3) in day2"></li>
            </ul>
        </div>
        <div class="calendar_card" v-show="sign">
            <el-row v-for="sign in sign_in" :key="sign.id">
                <el-col :span="7" class="calendar-left">
                    <p class="sign_state">@{{ sign.clock|if_clock }}</p>
                    <p class="sign_time">@{{ selecttime | date_time}}</p>
                </el-col>
                <el-col :span="17" class="calendar-card">
                    <p>{{trans('details.work_category')}}: <span>@{{ sign.shiftname }}</span>
                        {{--                        <label v-if="sign.holiday">&nbsp;&nbsp;{{trans('details.holiday_category')}}: <span>@{{ sign.holiday }}</span></label>--}}
                    </p>
                    <p v-if="sign.holiday">{{trans('details.holiday_category')}}: <span>@{{ sign.holiday }}</span>
                    </p>
                    <p>{{trans('details.work_time')}}: <span>@{{ sign.shifttime }}</span></p>
                    {{--<p>{{trans('details.work_card')}}: <span>@{{ sign.clock | no_card }}/@{{ sign.outtime_actual | no_card }} </span></p>--}}
                    <p v-for="(zclock,index) in sign.clock" :key="zclock.id">
                        {{trans('details.work_card')}} @{{index+1}}:
                        <span>@{{zclock | no_card }} </span>
                    </p>
                </el-col>
            </el-row>
        </div>
        <div class="calendar_card" v-show="ovtime" v-for="overtime in overtime" :key="overtime.id">
            <el-row>
                <el-col :span="7" class="calendar-left">
                    <p class="sign_state">{{trans('details.overtime_title')}}</p>
                    <p class="sign_time">@{{ selecttime| date_time }}</p>
                </el-col>
                <el-col :span="11" class="calendar-card">
                    <p>{{trans('details.work_type')}}: <span>@{{ overtime.ovtype | ovtype}}</span></p>
                    <p>{{trans('details.time_long')}}: <span>@{{ overtime.hour | time_unit}}</span></p>
                    <p>{{trans('details.work_time')}}: <span>@{{ overtime.btime|substring_time }}-@{{ overtime.etime|substring_time }}</span></p>
                </el-col>
                <el-col :span="6" class="calendar-right">
                    {{--<p>审核中: <i class="fa fa-hourglass-1"></i></p>--}}
                </el-col>
            </el-row>
        </div>
        <div class="calendar_card" v-show="abs" v-for="leave in leave_in" :key="leave.id">
            <el-row>
                <el-col :span="7" class="calendar-left">

                    <p class="sign_state">{{trans('details.leave_title')}}</p>
                    <p class="sign_time">@{{ selecttime | date_time }}</p>
                </el-col>
                <el-col :span="11" class="calendar-card">
                    <p>{{trans('details.work_type')}}: <span>@{{ leave.absname }}</span></p>
                    <p>{{trans('details.time_long')}}: <span>@{{ leave.hour | time_unit}}</span></p>
                    <p>{{trans('details.work_time')}}: <span>@{{ leave.btime|substring_time }}-@{{ leave.etime|substring_time }}</span>
                    </p>
                </el-col>
                <el-col :span="6" class="calendar-right">
                    {{--<p>审核中: <i class="fa fa-hourglass-1"></i></p>--}}
                </el-col>
            </el-row>
        </div>
        <div class="calendar_card" v-show="err" v-for="err in err_in" :key="err.id">
            <el-row>
                <el-col :span="7" class="calendar-left">

                    <p class="sign_state">{{trans('details.attendance_title')}}</p>
                    <p class="sign_time">@{{ selecttime | date_time }}</p>
                </el-col>
                <el-col :span="11" class="calendar-card">
                    <p>{{trans('details.work_type')}}: <span>@{{ err.absname }}</span></p>
                    <p>{{trans('details.time_long')}}: <span>@{{ err.hour | time_unit}}</span></p>
                    <p>{{trans('details.work_time')}}: <span>@{{ err.btime|substring_time }}-@{{ err.etime|substring_time }}</span>
                    </p>
                </el-col>
                <el-col :span="6" class="calendar-right">
                    {{--<p>审核中: <i class="fa fa-hourglass-1"></i></p>--}}
                </el-col>
            </el-row>
        </div>
        <div class="footer"></div>
    </div>
@endsection

@section('js')
    <script src="{{asset('js/index.js')}}"></script>
    <script>
        new Vue({
            el: 'title',
            data: {
                page_title: '{{trans('details.my_calendar')}}'
            }
        })
    </script>
    <script>
        var to_years = new Date().getFullYear();//标准时间  今天  年
        var to_month = new Date().getMonth();//标准时间  今天  月
        var to_day = new Date().getDate();//标准时间  今天  日
        var a = 0;
        var userID = "{{ $userId }}";
        var shiftArr = [];
        var clockArr = [];
        var overArr = [];
        var leaveArr = [];
        var errArr = [];
        new Vue({
            el: '#calendar',
            data: {
                toymd: null,//年月日
                current_year: '',//后端传过来的年份
                current_month: '',//后端传过来的月份
                choice_day: '',//选中的日期
//                current_date: '',//当前的日期
                sign_in: [],//考勤数据
                leave_in: [],//请假数据
                err_in: [],//异常数据
                selecttime: '',//选中年月日
                overtime: [],//加班数据
                sign: false,//考勤栏位状态
                ovtime: false,//请假栏位状态
                abs: false,//加班栏位状态
                err: false,//错误栏位状态
                attendance: [],//考勤情况
                day1: [],//每月第一行，一号之前需要补的空格
                day2: [],//每月最后一行，最后一天之后需要补的空格
                days: [],//每个月的天数，0开始
                solarMonth: [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31],//1到12月每个月的天数
                popupVisible: false,
                showTime: false,
                selectTime: null,
                selectValues: null,
                isActive: false,
                slots: [
                    {
                        defaultIndex: to_years,
                        flex: 1,
                        values: [],
                        className: 'slot1',
                        textAlign: 'center'
                    }, {
                        divider: true,
                        content: '-',
                        className: 'slot2'
                    }, {
                        defaultIndex: to_month,
                        flex: 1,
                        values: ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'],
                        className: 'slot3',
                        textAlign: 'center'
                    }
                ]
            },
            mounted: function () {
                var _year = to_years;
                var _month = to_month + 1;
                var _day = to_day;
                if (_month < 10) {
                    _month = "0" + _month;
                }
                if (_day < 10) {
                    _day = "0" + _day;
                }
                this.choice_day = _day;//选中的日期

                var that = this;
                axios.get("/api/attendance/year-list").then(function (res) {
                    that.slots[0].values = res.data;
                    that.toymd = _year + '-' + _month;
                    that.calendar_date(that.toymd + '-' + that.choice_day);

                });


            },
            filters: {
                time_unit: function (value) {
                    return value + "H";
                },
                if_clock: function (value) {
                    if (value && value[0] !== '' && value[0] !== '/' && value[0] !== '\/') {
                        return "已签到";
                    }
                    return "未签到";
                },
                substring_time: function (value) {

                    return value.substring(3);
                },
                no_card: function (value) {
                    if (value == null) {
                        return "无数据";
                    }
                    return value;
                },
                ovtype: function (value) {

                    if (value == 'N') {
                        return "平时";
                    }
                    if (value == 'S') {
                        return "假日";
                    }
                    if (value == 'H') {
                        return "国假";
                    }
                    return value;
                },
                date_time: function (value) {
                    var now_data = value.substring(0, 10);
                    return now_data;
                }
            },
            methods: {
                choose_years: function () {
                    this.selectTime = this.toymd;
                    this.popupVisible = true;
                },
                onValuesChange: function (picker, values) {

                    if (values[0] == '' || values[0] == undefined) {
                        values[0] = to_years;
                    }
                    if (values[1] == '' || values[1] == undefined) {
                        values[1] = to_month + 1;
                    }
                    if (!this.selectTime) {
                        this.setDayDate(values);
                    }
                    this.selectTime = values[0] + '-' + values[1];
                    this.selectValues = values;


                },
                setDayDate: function (values) {
                    this.current_year = values[0];//插件加载的当前年份
                    this.current_month = values[1];//插件加载的当前年份
                    var month_first_day;
                    month_first_day = new Date(values[0], values[1] - 1, 1);
                    this.firstWeek = month_first_day.getDay();//当月第一天周几
                    this.solarDays(values[0], values[1]);//当月多少天
                },
                onSureTimeClick: function () {
                    if (this.toymd != this.selectTime) {
                        this.toymd = this.selectTime;
                        this.calendar_date(this.toymd + '-' + this.choice_day);
                        this.setDayDate(this.selectValues);
                    }
                    this.popupVisible = false;

                },
                solarDays: function (y, m) {
                    var d = this.solarMonth[m - 1];//所选月份当月天数
                    var aa = this.firstWeek > 6 ? 0 : this.firstWeek;//第一行一号前边需要补的空格
                    this.day1 = new Array(aa);
                    this.day2 = new Array(6);
                    if (m == 2) {
                        if ((y % 4 == 0) && (y % 100 != 0) || (y % 400 == 0)) {
                            d = 29;
                        } else {
                            d = 28;
                        }
                    }
                    this.days = new Array(d);
                },
                active_date: function (value) {
                    if (value > 0 && value < 10) {
                        value = "0" + value;
                    }
                    this.choice_day = value;
                    var choice_time = this.toymd + '-' + value;
                    this.isActive = true;
                    this.chooseCurrentData(choice_time);
                },
                chooseCurrentData: function (choice_time) {
                    //清空原有数据
                    var that = this;
                    var today = choice_time;
                    that.sign_in = [];
                    that.overtime = [];
                    that.leave_in = [];
                    that.err_in = [];

                    that.slots[0].defaultIndex = that.slots[0].values.indexOf(today.substring(0, 4));
                    that.slots[2].defaultIndex = today.substring(5, 7).replace(/\b(0+)/gi, "") - 1;
                    //选择的月日，然后去对应的数组筛选数据
                    var monthday = today.substring(5, 7) + '/' + choice_time.substring(8, 10);

                    that.selecttime = today;
                    //循环获取当天班别数据和上下班数据
                    var signarr = [];
                    for (var i = 0; i < shiftArr.length; i++) {
                        if (shiftArr[i]['cday'] == monthday) {
                            signarr = [{
                                shiftname: shiftArr[i]['shiftname'], //班别名字
                                holiday: shiftArr[i]['holiday'], //班别名字
                                shifttime: shiftArr[i]['intime'].substring(2) + '-' + shiftArr[i]['outtime'].substring(2), //上班时间
                            }];
                            break;
                        }
                    }

                    //循环获取实际考勤数据
                    for (var j = 0; j < clockArr.length; j++) {
                        if (clockArr[j]['cday'] == monthday) {

                            signarr[0]['clock'] = clockArr[j].clock !== '/' ? clockArr[j].clock.split('/') : [];
                            break;
                        }
                    }
                    that.sign_in = signarr;

                    //循环获取请假数据
                    for (var k = 0; k < leaveArr.length; k++) {
                        if (leaveArr[k]['cday'] == monthday) {
                            that.leave_in.push(leaveArr[k])
                        }
                    }
                    //循环获取异常数据
                    for (var h = 0; h < errArr.length; h++) {
                        if (errArr[h]['cday'] == monthday) {
                            that.err_in.push(errArr[h])
                        }
                    }

                    // 循环获取加班数据
                    for (var z = 0; z < overArr.length; z++) {
                        if (overArr[z]['cday'] == monthday) {
                            that.overtime.push(overArr[z])
                        }
                    }

                    //判断考勤数据是否显示
                    if (that.sign_in.length > 0) {
                        that.sign = true;

                    } else {
                        that.sign = false;
                    }
                    //判断加班是否显示
                    if (that.overtime.length > 0) {
                        that.ovtime = true;
                    } else {
                        that.ovtime = false;
                    }
                    //  判断请假数据是否显示
                    if (that.leave_in.length > 0) {
                        that.abs = true;
                    } else {
                        that.abs = false;
                    }     //  判断请假数据是否显示
                    if (that.err_in.length > 0) {
                        that.err = true;
                    } else {
                        that.err = false;
                    }
                },
                calendar_date: function (choice_time) {
                    var that = this;

                    axios.get("/api/attendance/canlendar-info", {
                        params: {
                            emp_no: userID,
                            month_no: choice_time,
                        }
                    }).then(function (res) {
                        //一个月中的考勤数组数据

                        if (res.data.emp_shift) {
                            shiftArr = JSON.parse(res.data.emp_shift);
                        }
                        if (res.data.emp_clock) {
                            clockArr = JSON.parse(res.data.emp_clock);
                        }
                        if (res.data.emp_n_abs) {
                            //请假数据
                            leaveArr = JSON.parse(res.data.emp_n_abs);
                        }
                        if (res.data.emp_n_abs) {
                            //请假数据
                            errArr = JSON.parse(res.data.emp_e_abs);
                        }
                        if (res.data.emp_over) {
                            //加班数据
                            overArr = JSON.parse(res.data.emp_over);
                        }
                        that.chooseCurrentData(choice_time);

                    })

                }
            }
        })
    </script>
@endsection