@extends('Layout.WebApp_Layout')
@section('css')
    <link href="{{ asset('/css/salary.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
    <div id="salary" v-cloak>

        {{--  begin add--}}
        <div v-show="pwd_verify">
            <div class="login_logo">
                <img v-bind:src="login_logo">
            </div>

            <div v-if="isfirstlogin=='N'">
                <div class="login_input">
{{--                    <p class="fa fa-user"></p>--}}
                    <mt-field placeholder="{{ trans('admin.pasword') }}" type="password" v-model="password"></mt-field>
                </div>
                <div class="login_input">
                    <mt-button type="primary" :disabled="btnDisabled"
                               @click="psw_verify_btn">{{ trans('admin.verify_pwd') }}</mt-button>
                </div>
                <div class="forget_password_btn">
                    <a href="{{ url('password/view/forget-password') }}">忘记密码?</a>
                </div>
                <mt-popup v-model="popup_pwd" position="top" class="popup_pwd">
                    <p v-text="pwd_msg"></p>
                </mt-popup>
            </div>

            <div v-else>
                {{--<p style="text-align:center; font-size: 20px"> 第一次登录请修改密码</p>--}}
                <mt-popup v-model="popup_pwdM" position="top" class="popup_pwd">
                    <p>第一次登录请修改密码</p>
                </mt-popup>
                <div class="login_input">
{{--                    <p class="fa fa-user"></p>--}}
                    <mt-field placeholder="{{ trans('admin.oldpasword') }}" type="password"
                              v-model="password"></mt-field>
                </div>
                <div class="login_input">
{{--                    <p class="fa fa-user"></p>--}}
                    <mt-field placeholder="{{ trans('admin.newpasword') }}" type="password"
                              v-model="newpassword"></mt-field>
                </div>
                <div class="login_input">
{{--                    <p class="fa fa-user"></p>--}}
                    <mt-field placeholder="{{ trans('admin.newcpasword') }}" type="password"
                              v-model="newcpassword"></mt-field>
                </div>
                <div class="login_input">
                    <mt-button type="primary" :disabled="btnDisabled"
                               @click="psw_change_btn">{{ trans('admin.change_pwd') }}</mt-button>
                </div>
                <mt-popup v-model="popup_pwd" position="top" class="popup_pwd">
                    <p v-text="pwd_msg"></p>
                </mt-popup>
            </div>
        </div>
        {{--  end add--}}

        <div v-show="salary_page">
            <div id="panel">
                <div class="chart chart_photo" id="main"></div>
            </div>
            <div class="salary_details">
                <div class="apply_group">
                    <div class="salary_title"> {{trans('salary.special_adjustment')}}</div>
                    <div class="salary_content">
                        @{{ special_money }} <span v-bind:class="fa_icon"></span>
                    </div>
                </div>
                <div class="apply" v-for="(salary,index) in salary_details" v-if="index < 6">
                    <mt-cell v-bind:title="salary.mapname" v-bind:value="salary.amount"></mt-cell>
                </div>
                <div class="apply_btn">
                    <a @click="click_url(index)" v-bind:href="list_url"><p>{{trans('salary.view_details')}}</p></a>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script src="{{asset('js/echarts.min.js')}}"></script>
    <script>
        var height = window.screen.height * 0.45;
        var width = window.screen.width * 0.90;

        var mydiv = document.getElementsByClassName("chart_photo");

        for (var i = 0; i < mydiv.length; i++) {
            mydiv[i].style.height = height + "px";
            mydiv[i].style.width = width + "px";
        }
        new Vue({
            el: 'title',
            data: {
                page_title: '{{trans('salary.salary_view')}}'
            }
        })
    </script>
    <script>
        var to_years = new Date().getFullYear();//标准时间  今天  年
        var to_month = new Date().getMonth() + 1;//标准时间  今天  月
        var to_day = new Date().getDate();//标准时间  今天  日
        var a = 0;

        var userID = "{{ $userId }}";
        var isFirst = "{{ $isfirstlogin }}";
        var query_date = ['2009-09', '2010-07'];
        var all_salary_number = [1500, 2800];
        var all_query_number = [0, 300];
        new Vue({
            el: '#salary',

            data: {
                isfirstlogin: '',
                list_url: '#',
                toymd: '',
                password: '',
                newpassword: '',
                newcpassword: '',
                pwd_msg: '',
                login_logo: '/images/ares.png',
                popupVisible: false,
                pwd_verify: true,
                salary_page: false,
                popup_pwd: false,
                popup_pwdM: false,
                btnDisabled: false,

                special_money: '',
                fa_icon: 'fa fa-long-arrow-up',
                salary_details: [],
                btn_hide: false
            },
            mounted: function () {
                var ymd;
                if (to_month.toString().length < 2) {
                    to_month = '0' + to_month;
                } else {
                    to_month = to_month;
                }
                if (to_day.toString().length < 2) {
                    to_day = '0' + to_day;
                } else {
                    to_day = to_day;
                }
                ymd = to_years + '-' + to_month + '-' + to_day;
                var that = this;

                that.isfirstlogin = isFirst;
                if (that.isfirstlogin == 'Y') {
                    that.popup_pwdM = true;
                }

                // add waterMark
                window.watermark.set(watermarkStr);
            },
            methods: {
                click_url: function () {
                    this.list_url = "{{URL('/salary/view/query-more')}}";
                },

                psw_verify_btn: function () {
                    //http://localhost:8082/api/userPwd?emp_no=ARESSZ234
                    var that = this;
                    if (that.password == '') {
                        that.popup_pwd = true;
                        that.pwd_msg = '密码不能为空！';
                        return;
                    }
                    that.btnDisabled = true;
                    axios.get("/api/salary/check-pwd", {
                        params: {
                            emp_no: userID,
                            pwd: that.password
                        }
                    }).then(function (res) {
                        //console.log(res.data);
                        if (res.data.code == 0) {
                            that.pwd_verify = false;
                            that.salary_page = true;

                            axios.get("/api/salary/salary-query", {
                                params: {
                                    emp_no: userID,
                                    basedate: '2017/10/08'
                                }
                            }).then(function (res) {
                                query_date = res.data.validate;
                                all_salary_number = res.data.amount;
                                all_query_number = res.data.diff;
                                that.special_money = res.data.diffamount;
                                that.salary_details = res.data.detail;
                                console.log(res.data);
                                myChart(query_date, all_salary_number, all_query_number);
                            });
                        } else {
                            that.popup_pwd = true;
                            that.pwd_msg = '密码错误请重新输入！';
                        }
                        that.btnDisabled = false;
                    });
                },

                psw_change_btn: function () {

                    if (this.password == '') {
                        this.popup_pwd = true;
                        this.pwd_msg = '请输入原密码';
                        return false;
                    }
                    if (this.password == '') {
                        this.popup_pwd = true;
                        this.pwd_msg = '请输入新密码';
                        return false;
                    }

                    if (this.newpassword != this.newcpassword) {
                        this.popup_pwd = true;
                        this.pwd_msg = '密码确认不一致 请重新输入';
                    } else {
                        var that = this;
                        that.btnDisabled = true;
                        axios.get("/api/salary/modify-pwd", {
                            params: {
                                emp_no: userID,
                                oldpwd: this.password,
                                newpwd: this.newpassword
                            }
                        }).then(function (res) {
                            console.log(res);
                            if (res.data.code == '0') {
                                that.pwd_verify = false;
                                that.salary_page = true;
                            } else {
                                that.popup_pwd = true;
                                that.pwd_msg = res.data.msg;
                            }
                            that.btnDisabled = false;
                        });
                    }
                },


            }
        });

        function myChart(query_date, all_salary_number, all_query_number) {
            var myChart = echarts.init(document.getElementById("main"));
            myChart.setOption({
                title: {
                    text: '调薪历史',
                    textStyle: {
                        color: '#333'
                    }
                },
                tooltip: {
                    trigger: 'axis'
                },
                grid: {
                    left: '1%',
                    right: '4%',
                    bottom: '3%',
                    containLabel: true,
                    backgroundColor: 'red'
                },
                xAxis: [
                    {
                        type: 'category',
                        boundaryGap: false,
                        //                    data : ['2009-09','2010-07']
                        data: query_date
                    }
                ],
                yAxis: [
                    {
                        type: 'value'
                    }
                ],
                series: [
                    {
                        name: '薪酬',
                        type: 'line',
                        itemStyle: {
                            normal: {
                                color: '#2BA7EA'
                            }
                        },
                        label: {
                            normal: {
                                show: true,
                                position: 'top',
                                textStyle: {
                                    color: 'red'
                                }
                            }
                        },
                        areaStyle: {
                            normal: {
                                color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
                                    offset: 0,
                                    color: '#2BA7EA'
                                }, {
                                    offset: 1,
                                    color: '#fff'
                                }])
                            }
                        },
                        //                    data:[3000, 4500]
                        data: all_salary_number
                    },
                    {
                        name: '上调',
                        type: 'line',
                        itemStyle: {
                            normal: {
                                color: 'rgba(0,0,0,0)'
                            }
                        },
                        areaStyle: {
                            normal: {
                                color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
                                    offset: 0,
                                    color: 'rgba(0,0,0,0)'
                                }, {
                                    offset: 1,
                                    color: 'rgba(0,0,0,0)'
                                }])
                            }
                        },
                        //                    data:[0, 1500]
                        data: all_query_number
                    }
                ]
            });
        }
    </script>

@endsection