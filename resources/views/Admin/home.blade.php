@extends('Layout.WebApp_Layout')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/element.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/home.css') }}">
@endsection

@section('content'){{--
    <mt-header fixed title="fixed top">HCP</mt-header>--}}
<div id="home" v-cloak>
    <div id="home" v-cloak>
        <div id="slide">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <img v-bind:src="menugb" style="position: relative;">
                    <div class="welcomefont" style="position: absolute; left: 7%; top: 8%; z-index: 3; ">
                        <p style="font-size: 0.4rem;"><strong>欢迎使用</strong></p><br>
                        <p style="font-size: 0.25rem;">员工自助查询系统</p>
                    </div>
                </div>
                <!-- <div class="swiper-slide">
                 <a href="#">
                  <img src="source/upload/slide002.jpg"/>
                 </a>
                </div>
              </div> -->
                <!-- <div class="pagination"></div>   -->
            </div>
            <!--categoryList-->
            <div class="categoryDesc">员工服务</div>
            <ul class="categoryLiIcon">
                <li>
                    <a href="/user/view/userinfo">
                        <i class="fa fa-user"></i>
                        <em>个人信息</em>
                    </a>
                </li>
                <li>
                    <a href="/attendance/view/canlendar">
                        <i class="fa fa-calendar"></i>
                        <em>我的日历</em>
                    </a>
                </li>
                <li>
{{--                    <a href="/attendance/view/summary">--}}
                    <a href="/attendance/view/summaryDetail">
                        <i class="fa fa-clock-o"></i>
                        <em>我的考勤</em>
                    </a>
                </li>
                <li>
                    <a href="/holiday/view/all-new">
                        <i class="fa fa-coffee"></i>
                        <em>我的可休假</em>
                    </a>
                </li>
                <li>
                    <a href="/salary/view/salary-detail">
                        <i class="fa fa-usd"></i>
                        <em>我的薪资</em>
                    </a>
                </li>
                <li>
                    <a href="/salary/view/salary-query">
                        <i class="fa fa-line-chart"></i>
                        <em>调薪历史</em>
                    </a>
                </li>


            </ul>
            <div class="categoryDesc">主管服务</div>
            <ul class="categoryLiIcon">

                <li>
                    <a href="/user/view/mydepartment">
                        <i class="fa fa-users"></i>
                        <em>我的部属</em>
                    </a>
                </li>
                <li>
                    <a href="/attendance/view/attendance-list">
                        <i class="fa fa-calendar-o"></i>
                        <em>部属考勤</em>
                    </a>
                </li>
                <li>
                    <a href="/salary/view/staff-salary">
                        <i class="fa fa-money"></i>
                        <em>部属薪资</em>
                    </a>
                </li>
            </ul>

        </div>
    </div>

</div>
@endsection

@section('js')
    <script>
        new Vue({
            el: 'title',
            data: {
                page_title: '{{ trans('admin.home') }}',

            }
        })
    </script>
    <script src="{{asset('js/index.js')}}"></script>
    <script>
        new Vue({
            el: '#home',
            data: {
                menugb: '/images/menugb.png',
                msg_show: false,
                verifyBtn: true,
                msg: null,
                iphone: '',
                idcard: '',
                verifyCode: '',
                emp: []
            },
            created: function () {
            },
            methods: {
                bind: function () {
                    var that = this;
                    if (that.iphone == '') {
                        that.msg_show = true;
                        that.msg = '手机号不能为空！';
                        return;
                    }
                    if (that.verifyCode == '') {
                        that.msg_show = true;
                        that.msg = '验证码不能为空！';
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