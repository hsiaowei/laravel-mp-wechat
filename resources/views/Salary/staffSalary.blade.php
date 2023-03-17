@extends('Layout.WebApp_Layout')
@section('css')
    <link href="{{ asset('/css/salary.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
    <div id="staffSalary" v-cloak>

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
                    <mt-button type="primary" :disabled="btnDisabled" @click="psw_verify_btn">{{ trans('admin.verify_pwd') }}</mt-button>
                </div>
                <div class="forget_password_btn">
                    <a href="{{ url('password/view/forget-password') }}" >忘记密码?</a>
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
                    <mt-field placeholder="{{ trans('admin.oldpasword') }}" type="password" v-model="password"></mt-field>
                </div>
                <div class="login_input">
{{--                    <p class="fa fa-user"></p>--}}
                    <mt-field placeholder="{{ trans('admin.newpasword') }}" type="password" v-model="newpassword"></mt-field>
                </div>
                <div class="login_input">
{{--                    <p class="fa fa-user"></p>--}}
                    <mt-field placeholder="{{ trans('admin.newcpasword') }}" type="password" v-model="newcpassword"></mt-field>
                </div>
                <div class="login_input">
                    <mt-button type="primary"  :disabled="btnDisabled" @click="psw_change_btn">{{ trans('admin.change_pwd') }}</mt-button>
                </div>
                <mt-popup v-model="popup_pwd" position="top" class="popup_pwd">
                    <p v-text="pwd_msg"></p>
                </mt-popup>
            </div>
        </div>
        {{--  end add--}}

        <div v-show="salary_page" >
        <div class="staffSalary_header">
        <mt-search v-model="searchString" cancel-text=""  placeholder="{{ trans('salary.staff_search') }}"></mt-search>
        </div>
        <div class="staffSalary_details" v-for="salary in filteredArticles" :key="salary.id">
            {{--<a @click="staff_salary(salary.employee_no)" v-bind:href="staff_sal">--}}
            <a @click="staff_salary(salary.emp_no)" v-bind:href="staff_sal">
                <div class="staffSalary_list">
                    {{--<img v-bind:src="salary.head_img" />--}}
                    {{--<img v-bind:src="head_img" />--}}
					<img v-bind:src="user_img_default" :onerror="user_img_default" >
                    <div class="staff_data">
                        <div class="staff_top">
                            <div class="staff_name">@{{ salary.emp_name }}</div>
                            {{--<div class="staff_level"  v-for="amount in salary.salary">--}}
                                {{--@{{ amount.grade | grade }}   @{{ amount.degree | degree }}--}}
                            {{--</div>--}}
                            {{--<div class="staff_level">等级1</div>--}}
                        </div>
                        <div class="staff_bottom">
                            <p>@{{ salary.emp_no }}</p>
                            {{--<p>@{{ salary.employee_name }}</p>--}}
                            {{--<p>@{{ salary.staff_work_space | time_unit }}</p>--}}
                            <p > @{{ salary.emp_dept }}</p>
                            <p > @{{ salary.years| years }}</p>

                        </div>
                    </div>
                    <div class="staff_salary"  >
                          @{{ salary.amounttotal | salary_unit }}
                        <i class="el-icon-arrow-right"></i>
                    </div>
                </div>
            </a>
        </div>
    </div>
    </div>
@endsection

@section('js')
    <script>
        new Vue({
            el:'title',
            data:{
                page_title:'{{trans('salary.deploy_adjustment')}}'
            }
        })
    </script>
    <script>
        var to_years = new Date().getFullYear();//标准时间  今天  年
        var to_month = new Date().getMonth();//标准时间  今天  月
        var to_day = new Date().getDate();//标准时间  今天  日
        var a = 0;
        var isFirst = "{{ $isfirstlogin }}";
        var ifpwd="0";
        new Vue({
            el:'#staffSalary',
            data:{
                user_img_default: '{{ asset("/images/avatar.jpg") }}',//default头像 add by frank
                isfirstlogin : '',
                password:'',
                newpassword:'',
                newcpassword:'',
                pwd_msg:'',
                login_logo:'/images/ares.png',
                popupVisible:false,
                pwd_verify:true,
                salary_page:false,
                popup_pwd:false,
                popup_pwdM:false,
				btnDisabled:false,

                toymd:'',
                staff_sal:'#',
                searchString:'',
                head_img:'{{ asset("/images/avatar.jpg") }}',
                staffSalary_details:[]
            },
            mounted: function() {
                var that = this;
                that.isfirstlogin =  isFirst;

                if(that.isfirstlogin=='Y') {
                    that.popup_pwdM = true;
                }

                if(to_month>0 && to_month<10){
                    to_month = '0'+to_month;
                }
                if(to_day>0 && to_day<10){
                    to_day = '0'+to_day;
                }
                this.toymd = to_years+'-'+to_month+'-'+to_day;
            
       		  ifpwd=this.get_cookie('staffpwd');
           
                //判断五分钟内是否输入过
                if(ifpwd=='yes'){
                    this.pwd_verify = false;
                    this.salary_page = true;
                    var basedate = this.toymd;
                    this.staff_salary_list(basedate);
                }

            },
            filters:{
				empimg:function (value) {
                   return "{{ asset('/empimages') }}" +'/'+value+'.jpg';
                },
                time_unit:function (value) {
                    return value+"年";
                },
                grade:function (value) {
                    if(value == undefined ){
                        return "职等:";
                    }else{
                        return "职等:"+value;
                    }
                },
                years:function (value) {
                    if(value == undefined ){
                        return "年资:";
                    }else{
                        return "年资:"+value+'年';
                    }
                },
                degree:function (value) {
                    if(value == undefined ){
                        return "职级:";
                    }else{
                        return "职级:"+value;
                    }
                },
                salary_unit:function (value) {
                    if(value == undefined ){
                        return "0";
                    }else{
                        return value+"元";
                    }
                }
            },
            methods: {
                psw_verify_btn:function () {
                    var that = this;
                    if(that.password==''){
                        that.popup_pwd = true;
                        that.pwd_msg = '密码不能为空！';
                        return ;
                    }
                  that.btnDisabled=true;
                    axios.get("/api/salary/check-pwd",{params:{pwd:that.password,staffpwd:0}}).then(function (res) {
                        //console.log(res.data);
                        if(res.data.code==0){
                            that.pwd_verify =false;
                            that.salary_page = true;
     						 that.set_cookie('staffpwd','yes',5*60);
                            var basedate = that.toymd;
                            that.staff_salary_list(basedate);
                        }else{
                            that.popup_pwd = true;
                            that.pwd_msg = '密码错误请重新输入！';
                        }
                      	that.btnDisabled=false;

                    });
                },

                psw_change_btn:function () {

                    if(this.password ==''){
                        this.popup_pwd = true;
                        this.pwd_msg = '请输入原密码';
                        return false;
                    }
                    if(this.password ==''){
                        this.popup_pwd = true;
                        this.pwd_msg = '请输入新密码';
                        return false;
                    }

                    if( this.newpassword!=this.newcpassword ) {
                        this.popup_pwd = true;
                        this.pwd_msg = '密码确认不一致 请重新输入';
                    }
                    else {
                        var that = this;
                      that.btnDisabled=true;

                        axios.get("/api/salary/modify-pwd",{params:{oldpwd:this.password,newpwd:this.newpassword}}).then(function (res) {
                            console.log(res);
                            if(res.data.code=='0'){
                                that.pwd_verify = false;
                                that.salary_page = true;
                            }else{
                                that.popup_pwd = true;
                                that.pwd_msg = res.data.msg;
                            }
                          that.btnDisabled=false;

                        });
                    }
                },

     		  set_cookie:function (name,value,time) {
                    var exp = new Date(); //获得当前时间
                    exp.setTime(exp.getTime() + time*1000); //换成毫秒
                    document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString();

                },
              get_cookie:function (name) {
                        var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");

                        if(arr=document.cookie.match(reg))

                            return unescape(arr[2]);
                        else
                            return null;

              	},

                staff_salary_list:function (basedate) {
                    var that = this;
                    axios.get("/api/salary/staff-salary",{params:{basedate:basedate}}).then(function (res) {
                        that.staffSalary_details = res.data;
                    });
                },
                staff_salary:function (val) {
                    this.staff_sal = "/salary/view/query-more?&emp_no="+val;
                }
            },
            computed: {
                filteredArticles: function () {
                    var articles_array = this.staffSalary_details,
                        searchString = this.searchString;

                    if(!searchString){
                        return articles_array;
                    }

                    searchString = searchString.trim().toLowerCase();

                    articles_array = articles_array.filter(function(item){

                        if(item.emp_name.toLowerCase().indexOf(searchString) !== -1 ||
                            item.emp_no.toLowerCase().indexOf(searchString) !== -1 ||
                            item.emp_dept.toLowerCase().indexOf(searchString) !== -1){
                            return item;
                        }
                    });
                    return articles_array;
                }
            }
        })
    </script>

@endsection