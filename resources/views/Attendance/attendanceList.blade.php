@extends('Layout.WebApp_Layout')
@section('css')
    <link href="{{ asset('/css/attendance.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
    <div id="attendance" v-cloak>
        <div class="attendance_header">
            <mt-field v-model="toymd" id="toymd" readonly="readonly"></mt-field>
            <p class="fa fa-navicon" @click="choose_years"></p>
            <mt-popup v-model="popupVisible" position="top" pop-transition="popup-fade">
                <mt-picker :slots="slots" :visible-Item-Count="3" @change="onValuesChange"></mt-picker>
            </mt-popup>
        </div>
        <div class="attendance_list">
            <div class="list_card overtime_list">
                <div class="list_header">
                    <div class="list_left">
                        <img src="{{ asset('/images/overtime_icon.png') }}"/>
                        <p>{{trans('attendance.overtime_list')}}</p>
                    </div>
                    <div class="list_right">
                        <a @click="click_url(1)" v-bind:href="list_url"><p>{{trans('attendance.view_more')}}</p></a>
                    </div>
                </div>
                <div class="list_content">
                    <div v-for="(overtime,index) in overtime_list">
                        <div class="bg_purple" v-if="index < 3">
                            <a @click="staff_click(3,overtime.emp_no)" v-bind:href="staffAttend">
                                {{--<a href="{{URL('/details/attendanceItem?emp_no=#')}}">--}}
                                <div class="second_man">
                                    {{--<img  v-bind:src="leave_head_img">--}}
                                    <img v-bind:src="overtime.emp_no | empimg" :onerror="user_img_default">
                                    <p class="mes">
                                    <div class="list_label"><img v-bind:src="index | list_img"></div>
                                    </p>
                                    <p>@{{ overtime.emp_name }}</p>
                                    <p>@{{ overtime.hours | time}}</p>
                                </div>
                            </a>
                        </div>
                        <div class="card_right" v-else></div>
                    </div>
                </div>
            </div>
            <div class="list_card leave_list">
                <div class="list_header">
                    <div class="list_left">
                        <img src="{{ asset('/images/leave_icon.png') }}"/>
                        <p>{{trans('attendance.leave_list')}}</p>
                    </div>
                    <div class="list_right">
                        <a @click="click_url(2)" v-bind:href="list_url"><p>{{trans('attendance.view_more')}}</p></a>
                    </div>
                </div>
                <div class="list_content">
                    <div v-for="(leave,index) in leave_list">
                        <div class="bg_purple" v-if="index < 3">
                            <a @click="staff_click(2,leave.emp_no)" v-bind:href="staffAttend">
                                <div class="second_man">
                                    {{--<img  v-bind:src="leave_head_img">--}}
                                    <img v-bind:src="leave.emp_no | empimg" :onerror="user_img_default">
                                    <p class="mes">
                                    <div class="list_label"><img v-bind:src="index | list_img"></div>
                                    </p>
                                    <p>@{{ leave.emp_name }}</p>
                                    <p>@{{ leave.hours | time}}</p>
                                </div>
                            </a>
                        </div>
                        <div class="card_right" v-else></div>
                    </div>
                </div>
            </div>
            <div class="list_card attend_list">
                <div class="list_header">
                    <div class="list_left">
                        <img src="{{ asset('/images/attend_icon.png') }}"/>
                        <p>{{trans('attendance.attend_list')}}</p>
                    </div>
                    <div class="list_right">
                        <a @click="click_url(3)" v-bind:href="list_url"><p>{{trans('attendance.view_more')}}</p></a>
                    </div>
                </div>
                <div class="list_content">
                    <div v-for="(attend,index) in attend_list">
                        <div class="bg_purple" v-if="index < 3">
                            <a @click="staff_click(1,attend.emp_no)" v-bind:href="staffAttend">
                                <div class="second_man">
                                    {{--<img  v-bind:src="leave_head_img">--}}
                                    <img v-bind:src="attend.emp_no | empimg" :onerror="user_img_default">
                                    <p class="mes">
                                    <div class="list_label"><img v-bind:src="index | list_img "></div>
                                    </p>
                                    <p>@{{ attend.emp_name }}</p>
                                    <p>@{{ attend.hours | time}}</p>
                                </div>
                            </a>
                        </div>
                        <div class="card_right" v-else></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{asset('js/index.js')}}"></script>
    <script>
        new Vue({
            el: 'title',
            data: {
                page_title: '{{trans('attendance.attendance_ranking')}}'
            }
        })
    </script>
    <script>
        var to_years = new Date().getFullYear();//标准时间  今天  年
        var to_month = new Date().getMonth() + 1;//标准时间  今天  月
        var to_quarter = '';//本季度，默认为空
        var userID = "{{ $userId }}";//工号
        var yeartype = "3";//下拉框 3月 2季度 1年
        new Vue({
            el: '#attendance',
            data: {
                user_img_default: 'this.src="' + '{{ asset("/images/avatar.jpg") }}' + '"', //default头像 add by frank
                toymd: '本月',
                now_ymd: '',
                list_url: '#',
                staffAttend: '#',
                leave_head_img: '{{ asset("/images/avatar.jpg") }}',
                popupVisible: false,
                slots: [
                    {
                        defaultIndex: 0,
                        flex: 1,
                        values: ['本月', '本季度', '本年'],
                        className: 'slot1',
                        textAlign: 'center'
                    }
                ],
                overtime_list: [],
                leave_list: [],
                attend_list: []
            },
            filters: {
                empimg: function (value) {
                    return "{{ asset('/empimages') }}" + '/' + value + '.jpg';
                },
                time: function (val) {
                    return val + "H";
                },
                list_img: function (val) {
                    if (val == 0) {
                        return "{{ asset('/images/first.png') }}";
                    } else if (val == 1) {
                        return "{{ asset('/images/second.png') }}";
                    } else {
                        return "{{ asset('/images/third.png') }}";
                    }
                }
            },
            mounted: function () {
                var to_m = new Date().getMonth() + 1;//标准时间  今天  月
                if (to_m.toString().length < 2) {
                    to_m = '0' + to_m;
                } else {
                    to_m = to_m;
                }
                this.now_ymd = to_years + '-' + to_m;

//                this.attendanceList(to_years,to_month,to_quarter);
            },
            methods: {
                choose_years: function () {
                    this.popupVisible = true;
                },
                onValuesChange: function (picker, values) {
                    this.toymd = values[0];
                    var choice_time = this.toymd;
                    if (choice_time == '本月') {
                        yeartype = '3';
                        var _quarter = '';//本季度，默认为空
                        if (to_month.toString().length < 2) {
                            to_month = '0' + to_month;
                        } else {
                            to_month = to_month;
                        }
                        this.attendanceList(to_years, to_month, _quarter);
                    } else if (choice_time == '本年') {
                        yeartype = '1';
                        var _month = '';//本月默认为空
                        var _quarter = '';//本季度，默认为空
                        this.attendanceList(to_years, _month, _quarter);
                    } else {
                        yeartype = '2';
                        var _month = '';//本月默认为空
                        if (to_month >= 1 && to_month <= 3) {
                            var to_quarter = 1;
                        } else if (to_month >= 4 && to_month <= 6) {
                            var to_quarter = 2;
                        } else if (to_month >= 7 && to_month <= 9) {
                            var to_quarter = 3;
                        } else {
                            var to_quarter = 4;
                        }
                        this.attendanceList(to_years, _month, to_quarter);
                    }
                },
                click_url: function (value) {
                    var url_name;
                    var choice_time = this.toymd;

                    if (value == 1) {
                        url_name = '/overtime-list';
                    } else if (value == 2) {
                        url_name = '/leave-list';
                    } else {
                        url_name = '/attend-error';
                    }
                    if (choice_time == '本月') {
                        var _quarter = '';//本季度，默认为空
                        if (to_month.toString().length < 2) {
                            to_month = '0' + to_month;
                        }
                        this.list_url = "{{URL('/attendance/view')}}" + url_name + "?yeartype=" + yeartype;
                    } else if (choice_time == '本年') {
                        var _month = '';//本月默认为空
                        var _quarter = '';//本季度，默认为空
                        this.list_url = "{{URL('/attendance/view')}}" + url_name + "?yeartype=" + yeartype;
                    } else {
                        var _month = '';//本月默认为空
                        if (to_month >= 1 && to_month <= 3) {
                            var to_quarter = 1;
                        } else if (to_month >= 4 && to_month <= 6) {
                            var to_quarter = 2;
                        } else if (to_month >= 7 && to_month <= 9) {
                            var to_quarter = 3;
                        } else {
                            var to_quarter = 4;
                        }
                        this.list_url = "{{URL('/attendance/view')}}" + url_name + "?yeartype=" + yeartype;
                    }


                },
                attendanceList: function (to_years, to_month, to_quarter) {
                    var that = this;
                    var month_no = to_years + '/' + to_month;
                    axios.get("/api/attendance/ranking-list", {
                        params: {
                            yeartype: yeartype,
                            quarter: to_quarter,
                            emp_no: userID
                        }
                    }).then(function (res) {
                        that.overtime_list = res.data.overRank;
                        that.leave_list = res.data.leaveRank;
                        that.attend_list = res.data.errRank;
                    });

                },
                staff_click: function (val, staff_no) {
                    var _ymd = this.now_ymd;
                    this.staffAttend = '/attendance/view/detail?selected=' + val + "&staff_no=" + staff_no + "&toymd=" + _ymd;
                }
            }
        })
    </script>
@endsection