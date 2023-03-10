@extends('Layout.WebApp_Layout')
@section('css')
    <link href="{{ asset('/css/salary.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/css/from.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('/css/element.css') }}" type="text/css">
@endsection

@section('content')
    <div id="salary_details" v-cloak>
        <div>

            <div class="login_logo">
                <img v-bind:src="login_logo">
                <p>修改密码</p>
            </div>
            <div>
                <div class="login_input">
                    <p class="fa fa-minus-square-o"></p>
                    <mt-field autocomplete="off" placeholder="{{ trans('admin.bank') }}" type="text"
                              v-model="passwordForm.bank"></mt-field>
                </div>
                <div class="login_input">
                    <p class="fa fa-user"></p>
                    <mt-field autocomplete="off" placeholder="{{ trans('admin.newpasword') }}" type="password"
                              v-model="passwordForm.newpassword"></mt-field>
                </div>
                <div class="login_input">
                    <p class="fa fa-user"></p>
                    <mt-field autocomplete="off" placeholder="{{ trans('admin.newcpasword') }}" type="password"
                              v-model="passwordForm.newcpassword"></mt-field>
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
    </div>
@endsection

@section('js')
    <script src="{{asset('js/index.js')}}"></script>
    <script>
        new Vue({
            el: 'title',
            data: {
                page_title: '{{trans('salary.forget_password')}}'
            }
        })
    </script>
    <script>

        var userID = "{{ $userId }}";
        var companyID = "{{ session('wechat_user_info')['company_id'] }}";
        new Vue({
            el: '#salary_details',
            data: {
                toymd: '',
                passwordForm: {
                    bank: '',
                    newpassword: '',
                    newcpassword: ''
                },
                pwd_msg: '',
                login_logo: '/images/ares.png',
                popupVisible: false,
                btnDisabled: false,
                popup_pwd: false


            },
            mounted: function () {

            },
            methods: {


                psw_change_btn: function () {

                    if (this.passwordForm.bank == '') {
                        this.popup_pwd = true;
                        this.pwd_msg = '请输入HCP银行账户';
                        return false;
                    }
                    if (this.passwordForm.bank.length < 16) {
                        this.popup_pwd = true;
                        this.pwd_msg = '请输入正确的银行账户';
                        return false;
                    }
                    if (this.passwordForm.newpassword == '' || this.passwordForm.newcpassword == '') {
                        this.popup_pwd = true;
                        this.pwd_msg = '请输入新密码';
                        return false;
                    }


                    if (this.passwordForm.newpassword != this.passwordForm.newcpassword) {
                        this.popup_pwd = true;
                        this.pwd_msg = '密码确认不一致 请重新输入';
                    } else {
                        var that = this;
                        that.btnDisabled = true;

                        axios.get("/api/salary/bank-modify-pwd", {
                            params: {
                                companyid: companyID,
                                emp_no: userID,
                                bank: this.passwordForm.bank,
                                newpwd: this.passwordForm.newpassword
                            }
                        }).then(function (res) {
                            that.popup_pwd = true;
                            that.pwd_msg = res.data.msg;
                            if (res.data.code == '0') {
                                setTimeout("window.history.go(-1)", 2000);
                            }
                            that.btnDisabled = false;

                        });
                    }
                }
            }
        })
    </script>

@endsection