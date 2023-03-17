@extends('Layout.WebApp_Layout')
@section('css')
    <link href="{{ asset('/css/salary.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/css/from.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('/css/element.css') }}" type="text/css">
@endsection

@section('content')
    <div id="salary_details" v-cloak>
        <div v-show="pwd_verify">
            <div class="login_logo">
                <img v-bind:src="login_logo">
            </div>

            <div v-if="isfirstlogin=='N'">
                <div class="login_input">
                    <p class="fa fa-user"></p>
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
                    <p class="fa fa-user"></p>
                    <mt-field placeholder="{{ trans('admin.oldpasword') }}" type="password"
                              v-model="password"></mt-field>
                </div>
                <div class="login_input">
                    <p class="fa fa-user"></p>
                    <mt-field placeholder="{{ trans('admin.newpasword') }}" type="password"
                              v-model="newpassword"></mt-field>
                </div>
                <div class="login_input">
                    <p class="fa fa-user"></p>
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


        <div v-show="salary_page">
            <div class="salary_header" id="salary_header">
                <p class="fa fa-calendar"></p>
                <mt-field v-model="toymd" id="toymd" readonly="readonly"></mt-field>
                <mt-popup v-model="popupVisible" position="bottom">
                    <mt-picker :slots="slots" @change="onValuesChange" readonly="readonly"></mt-picker>
                </mt-popup>
                <div class="input_group" @click="choose_years" readonly="readonly"></div>
            </div>
            <div class="salary_details">
                <div class="salary_mes" v-if="salary_or_bonus.amount.emp_amount != 0">
                    <div class="tab_circle">
                        <p class="special_adjustment" v-text="emp_pay_type==1?
                        '{{trans('salary.real_desc').trans("salary.special_adjustment")}}'
                                :'{{trans('salary.real_desc').trans("salary.bonus_salary")}}'"> </p>
                        {{--<p class="monthly_wages" v-text="emp_amount_1"></p>--}}
                        <p class="monthly_wages" v-text="salary_or_bonus.emp_salary"></p>
                    </div>
                </div>
                <div class="bonus_btn" v-if="bonusBtnDisabled"
                     @click="showBonus()">
                    <button class="show_change_btn" ><pre v-text="emp_pay_type==1
                        ?'{{trans('salary.change_bonus_desc')}}'
                        :'{{trans('salary.change_salary_desc')}}'"></pre></button>
                </div>
                <div class="advice_content" v-if="salary_or_bonus.amount.emp_amount != 0">
                    <el-collapse accordion>
                        <el-collapse-item {{--v-if="emp_pay_type==1"--}}>
                            <template slot="title">
                                {{trans('salary.basic_salary')}}<span class="view_more"
                                                                      v-text="salary_or_bonus.amount.emp_salary_fix_amount"></span>
                            </template>
                            <div v-for="item in salary_or_bonus.emp_salary_fix">
                                <p>@{{ item.salaryname }}: @{{ item.amount }}</p>
                            </div>
                        </el-collapse-item>
                        <el-collapse-item>
                            <template slot="title">
                                {{trans('salary.bonus_salary')}}<span class="view_more"
                                                                      v-text="Number(salary_or_bonus.amount.emp_salary_b_amount) + Number(salary_or_bonus.amount.emp_salary_bs_amount)"></span>
                            </template>
                            <div v-for="item in salary_or_bonus.emp_salary_bs">
                                <p>@{{ item.salaryname }}: @{{ item.amount }}</p>
                            </div>
                            <div v-for="item in salary_or_bonus.emp_salary_b">
                                <p>@{{ item.salaryname }}: @{{ item.amount }}</p>
                            </div>
                        </el-collapse-item>
                        <el-collapse-item>
                            <template slot="title">
                                {{trans('salary.temporary_salary')}}<span class="view_more"
                                                                          v-text="salary_or_bonus.amount.emp_salary_temp_amount"></span>
                            </template>
                            <div v-for="item in salary_or_bonus.emp_salary_temp">
                                <p>@{{ item.salaryname }}: @{{ item.amount }}</p>
                            </div>
                        </el-collapse-item>
                        <el-collapse-item>
                            <template slot="title">
                                {{trans('salary.overtime_salary')}}<span class="view_more"
                                                                         v-text="salary_or_bonus.amount.emp_salary_ov_amount"></span>
                            </template>
                            <div v-for="item in salary_or_bonus.emp_salary_ov">
                                <p>@{{ item.salaryname }}: @{{ item.amount }}</p>
                            </div>
                        </el-collapse-item>
                        <el-collapse-item>
                            <template slot="title">
                                {{trans('salary.leave_deduct')}}<span class="view_more"
                                                                      v-text="salary_or_bonus.amount.emp_salary_abs_amount"></span>
                            </template>
                            <div v-for="item in salary_or_bonus.emp_salary_abs">
                                <p>@{{ item.salaryname }}: @{{ item.amount }}</p>
                            </div>
                        </el-collapse-item>
                        <el-collapse-item>
                            <template slot="title">
                                <span v-if="salary_or_bonus.amount.emp_salary_bs_tw_bs_amount">   {{trans('salary.insurance_salary_tw')}}</span>
                                <span v-else>   {{trans('salary.insurance_salary')}}</span>
                                <span class="view_more" v-text="salary_or_bonus.amount.emp_salary_insure_amount"></span>
                            </template>
                            <div v-for="item in salary_or_bonus.emp_salary_insure">
                                <p>@{{ item.salaryname }}: @{{ item.amount }}</p>
                            </div>
                        </el-collapse-item>
                    {{--明基克制部分尚未纳入标准 / 五险一金(公司负担部分)已纳入标准版本--}}
                    <el-collapse-item v-if="salary_or_bonus.emp_salary_insure_cpy">
                        <template slot="title">
                            <span>   {{trans('salary.insurance_salary_cpy')}}</span>
                            <span class="view_more" v-text="salary_or_bonus.amount.emp_salary_insure_cpy_amount"></span>
                        </template>
                        <div v-for="item in salary_or_bonus.emp_salary_insure_cpy">
                            <p>@{{ item.salaryname }}: @{{ item.amount }}</p>
                        </div>
                    </el-collapse-item>
                        <el-collapse-item>
                            <template slot="title">
                                {{trans('salary.tax_salary')}}<span class="view_more"
                                                                    v-text="salary_or_bonus.amount.emp_salary_tax_amount"></span>
                            </template>
                            <div v-for="item in salary_or_bonus.emp_salary_tax">
                                <p>@{{ item.salaryname }}: @{{ item.amount }}</p>
                            </div>
                        </el-collapse-item>
                        <el-collapse-item v-if="salary_or_bonus.amount.emp_salary_bs_tw_bs_amount">
                            <template slot="title">
                                {{trans('salary.insurance_company_tw')}}<span class="view_more"
                                                                              v-text="salary_or_bonus.amount.emp_salary_tw_amount"></span>
                            </template>
                            <div v-for="item in salary_or_bonus.emp_salary_tw">
                                <p>@{{ item.salaryname }}: @{{ item.amount }}</p>
                            </div>
                        </el-collapse-item>
                        <el-collapse-item v-if="salary_or_bonus.amount.emp_salary_bs_tw_bs_amount">
                            <template slot="title">
                                {{trans('salary.insurance_company_tw_bs')}}<span class="view_more"
                                                                                 v-text="salary_or_bonus.amount.emp_salary_tw_bs_amount"></span>
                            </template>
                            <div v-for="item in salary_or_bonus.emp_salary_tw_bs">
                                <p>@{{ item.salaryname }}: @{{ item.amount }}</p>
                            </div>
                        </el-collapse-item>
                    </el-collapse>
                </div>
                <div class="no_data" v-else>
                    暂无数据
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
                page_title: '{{trans('salary.my_salary')}}'
            }
        })
    </script>
    <script>
        var to_years = new Date().getFullYear();//标准时间  今天  年
        var to_month = new Date().getMonth();//标准时间  今天  月
        var a = 0;

        var isFirst = "{{ $isfirstlogin }}";
        var userID = "{{ $userId }}";
        var vue = new Vue({
            el: '#salary_details',
            data: {
                isfirstlogin: '',
                toymd: '',
                password: '',
                newpassword: '',
                newcpassword: '',
                pwd_msg: '',
                login_logo: '/images/ares.png',
                popupVisible: false,
                btnDisabled: false,
                pwd_verify: true,
                salary_page: false,
                popup_pwd: false,
                popup_pwdM: false,
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
                ],
                // 默认显示薪资数据
                emp_pay_type: 1,
                // 切换奖金按钮默认隐藏
                bonusBtnDisabled: false,
                // 薪资或奖金数据
                salary_or_bonus: {
                    emp_salary: 0,
                    amount: {
                        emp_amount: 0,
                        emp_salary_fix_amount: 0,
                        emp_salary_insure_amount: 0,
                        emp_salary_insure_cpy_amount: 0,
                        bonus_amount_total: 0,
                        emp_salary_abs_amount: 0,
                        emp_salary_tax_amount: 0,
                        emp_salary_ov_amount: 0,
                        emp_salary_temp_amount: 0,
                        emp_salary_tw_amount: null,
                        emp_salary_bs_tw_bs_amount: null,
                    },
                },
                // 薪资对象
                emp_salary_data: {},
                // 奖金对象
                emp_bonus_data: {},
            },
            mounted: function () {
                var that = this;
                that.isfirstlogin = isFirst;

                if (that.isfirstlogin == 'Y') {
                    that.popup_pwdM = true;
                }

                axios.get("/api/attendance/year-list").then(function (res) {
                    that.slots[0].values = res.data;
                    axios.get("/api/attendance/currentMonth").then(function (res) {
                        that.toymd = res.data;
                        that.slots[0].defaultIndex = that.slots[0].values.indexOf(that.toymd.substring(0, 4));
                        that.slots[2].defaultIndex = that.toymd.substring(5, 7).replace(/\b(0+)/gi, "") - 1;

                    })
                });

                // add waterMark
                window.watermark.set(watermarkStr);
            },
            filters: {},
            methods: {
                choose_years: function () {
                    this.popupVisible = true;
                },
                onValuesChange: function (picker, values) {
                    if (values[0] == '' || values[0] == undefined) {
                        values[0] = new Date().getFullYear();
                    }
                    if (values[1] == '' || values[1] == undefined) {
                        values[1] = to_month + 1;
                    }
                    this.toymd = values[0] + '-' + values[1];
                    a++;

                    if (a > 3) {
                        var current_month = this.toymd;
                        this.salaryDetails(current_month);
                    }
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
                            var current_month = that.toymd;

                            that.salaryDetails(current_month);
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

                salaryDetails: function (current_month) {
                    var that = this;
                    axios.get("/api/salary/salary-detail", {
                        params: {
                            month_no: current_month,
                            emp_no: userID
                        }
                    }).then(function (res) {
                        //console.log(res);
                        that.emp_pay_type = 1;
                        //if (res.data.emp_salary != 0) {
                        that.salary_or_bonus = that.emp_salary_data = res.data;

                        //}
                    });
                    this.bonusDetails(current_month);
                },
                bonusDetails: function (current_month) {
                    var that = this;
                    axios.get("/api/salary/salary-detail", {
                        params: {
                            month_no: current_month,
                            emp_no: userID,
                            type: 2
                        }
                    }).then(function (res) {
                        //console.log(res);
                        if (res.data.emp_salary) {
                            //保存数据至Bonus
                            that.emp_bonus_data = res.data;
                            //有数据则显示
                            that.bonusBtnDisabled = true;
                        } else {
                            that.bonusBtnDisabled = false;
                        }
                    }).catch(err => console.log(err));
                },
                // 切换薪资或奖金显示
                showBonus: function () {
                    if (this.emp_pay_type == 1) {
                        this.salary_or_bonus = this.emp_bonus_data;
                        this.emp_pay_type = 2;
                    } else {
                        this.salary_or_bonus = this.emp_salary_data;
                        this.emp_pay_type = 1;
                    }
                }
            }
        })
    </script>

@endsection