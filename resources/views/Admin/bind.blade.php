@extends('Layout.WebApp_Layout')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/admin.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/element.css') }}">
@endsection

@section('content')
    <div id="login" v-cloak>
        <div class="login_logo">
            <img v-bind:src="login_logo">
        </div>
        <div class="login_input">
            <p class="fa fa-user"></p>
            <mt-field placeholder="{{ trans('admin.idcard') }}" v-model="idcard"></mt-field>
        </div>

        <div class="login_input">
            <p class="fa fa-phone"></p>
            <mt-field placeholder="{{ trans('admin.iphone') }}" v-model="iphone"></mt-field>
        </div>

        <div class="login_input" v-show="verifyBtn">
            <mt-button type="primary" @click="verifyIphone">{{ trans('admin.verify') }}</mt-button>
        </div>
        <div class="login_input" v-show="!verifyBtn">
            <p class="fa fa-tablet"></p>
            <mt-field placeholder="{{ trans('admin.verify_code') }}" v-model="verifyCode">
                <mt-button type="primary" class="verify_code" @click="sendVerifyCode" height="45px"
                           v-text="verifyCodeBtn" :disabled="verifyBtnDisable"
                           width="100px"></mt-button>
            </mt-field>
        </div>
        <div class="login_input" v-show="!verifyBtn">
            <mt-button type="primary" @click="bind">{{ trans('admin.bind') }}</mt-button>
        </div>
        <mt-popup v-model="msg_show" position="top" class="msg_show">
            <p v-text="msg"></p>
        </mt-popup>
    </div>
@endsection

@section('js')
    <script>
        new Vue({
            el: 'title',
            data: {
                page_title: '{{ trans('admin.bind') }}',
            }
        })
    </script>
    <script src="{{asset('js/index.js')}}"></script>
    <script>
        new Vue({
            el: '#login',
            data: {
                login_logo: '/images/ares.png',
                msg_show: false,
                verifyBtn: true,
                verifyBtnDisable: false,
                msg: null,
                iphone: '',
                idcard: '',
                verifyCode: '',
                verifyCodeBtn: '{{ trans('admin.verify_send') }}',
                emp: [],
                seconds: 60
            },
            created: function () {
            },
            methods: {
                showMsg: function (msg) {
                    var that = this;
                    var msgShowSeconds = 3;
                    var seconds = 0;
                    that.msg = msg;
                    that.msg_show = true;
                    msgShowTime = setInterval(function () {
                        seconds++;
                        //console.log(seconds);
                        if (seconds > msgShowSeconds) {
                            clearInterval(msgShowTime);
                            that.msg_show = false;
                        }
                    }, 1000);
                },
                verifyIphone: function () {
                    var that = this;
                    if (that.idcard == '') {
                        that.showMsg('身份证号码不能为空！');
                        return;
                    }
                    if ( !(/^[1-9]\d{5}(19|20)\d{2}((0[1-9])|(1[0-2]))(([0-2][1-9])|10|20|30|31)\d{3}[0-9|X|x]$/).test(that.idcard)) {
                        that.msg_show = true;
                        that.showMsg('身份证号码长度不匹配或有误！');
                        return;
                    }
                    if (that.iphone == '') {
                        that.msg_show = true;
                        that.showMsg('手机号不能为空！');
                        return;
                    }
                    if ( !(/^[1]\d{10}$/).test(that.iphone)) {
                        that.msg_show = true;
                        that.showMsg('手机号长度不匹配或有误！');
                        return;
                    }
                    axios.get("/api/user/getexist", {
                        params: {
                            iphone: that.iphone,
                            idcard: that.idcard
                        }
                    }).then(function (res) {
                        //console.log(res.data);
                        if (res.data.code == 0) {
                            that.verifyBtn = false;
                        } else {
                            that.showMsg(res.data.msg);
                        }
                    });
                },
                sendVerifyCode: function () {
                    var that = this;
                    if (that.iphone == '') {
                        that.showMsg('手机号不能为空！');
                        return;
                    }
                    that.verifyBtnDisable = true;
                    axios.get("/api/sendCode", {
                        params: {
                            iphone: that.iphone
                        }
                    }).then(function (res) {
                        // 是否成功显示
                        that.showMsg(res.data.msg);
                        if (res.data.code == 0) {
                            var tmpBtnText = that.verifyCodeBtn;
                            that.verifyCodeBtn = that.seconds;
                            time = setInterval(function () {
                                that.verifyCodeBtn--;
                                if (that.verifyCodeBtn <= 0) {
                                    clearInterval(time)
                                    that.verifyCodeBtn = tmpBtnText;
                                    that.verifyBtnDisable = false;
                                }
                            }, 1000);
                        } else {
                            that.verifyBtnDisable = false;
                        }
                    });
                    that.verifyBtn = false;
                },
                bind: function () {
                    var that = this;
                    if (that.iphone == '') {
                        that.showMsg('手机号不能为空！');
                        return;
                    }
                    if (that.verifyCode == '') {
                        that.showMsg('验证码不能为空！');
                        return;
                    }
                    axios.get("/api/user/bind", {
                        params: {
                            iphone: that.iphone,
                            idcard: that.idcard,
                            verifyCode: that.verifyCode
                        }
                    }).then(function (res) {
                        //console.log(res.data);
                        if (res.data.code == 0) {
                            //
                            that.msg_show = true;
                            that.msg = res.data.msg;
                            setInterval(function () {
                                window.location = '/user/view/home';
                            }, 3000)
                        } else {
                            that.msg_show = true;
                            that.msg = res.data.msg;
                        }
                    });
                }
            }
        })
    </script>
@endsection