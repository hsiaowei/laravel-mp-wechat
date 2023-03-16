@extends('Layout.WebApp_Layout')
@section('css')
    <link href="{{ asset('/css/department.css?version=220620') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
    <div id="detailedDatum" v-cloak>
        <div class="detailedDatum_header" v-for="item in user_data">
            <div class="datum_header">
                <p class="user_name">@{{ item.employee_name }}</p>
                <p class="user_emp_no">@{{ item.employee_no }}</p>
                <p class="user_datum">@{{ student_data}}</p>
            </div>

            <div class="datum_img">
                <el-col :span="8" class="child_img">
                    <div class="left_img" v-if="ifSelf">
                        <img src="{{ asset('/images/id_card.png') }}" @click="id_card_btn">
                    </div>
                    <mt-popup v-model="popupVisible1">
                        <div class="id_card_mes" v-for="card in id_card">
                            <div class="id_card_top">
                                <p class="fa fa-credit-card"></p>
                                {{ trans('department.id_card') }}
                            </div>
                            <div class="id_card_bottom">
                                <b>{{ trans('department.card_type') }}: </b>@{{ card.credentialstype | card_type }}
                            </div>
                            {{--<div class="id_card_center">--}}
                            {{--<div class="id_card_sex">--}}
                            {{--<p>{{ trans('department.sex') }}: </p>--}}
                            {{--@{{ card.sex }}--}}
                            {{--</div>--}}
                            {{--<div class="id_card_national">--}}
                            {{--<p>{{ trans('department.national') }}: </p>--}}
                            {{--@{{ card.national }}--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="id_card_center">--}}
                            {{--<p>{{ trans('department.birthday') }}: </p>--}}
                            {{--@{{ card.birthday }}--}}
                            {{--</div>--}}
                            {{--<div class="id_card_center">--}}
                            {{--<p>{{ trans('department.address') }}: </p>--}}
                            {{--@{{ card.address }}--}}
                            {{--</div>--}}
                            <div class="id_card_bottom">
                                <b>{{ trans('department.id_card_number') }}: </b>@{{ card.credentialsno }}
                            </div>
                        </div>
                    </mt-popup>
                </el-col>
                <el-col :span="8" class="child_img">
                    <div class="center_img">
                        {{--<img v-bind:src="item.uesr_img">--}}
                        {{--modify by Frank--}}
                        <img v-bind:src="uesr_img" :onerror="user_img_default">
                    </div>
                </el-col>
                <el-col :span="8" class="child_img">
                    <div class="right_img" v-if="ifSelf">
                        <img src="{{ asset('/images/bank_card.png') }}" @click="bank_card_btn">
                    </div>
                    <mt-popup v-model="popupVisible3">
                        <div class="bank_card_mes">
                            <div class="bank_card_top">
                                <p class="fa fa-credit-card"></p>
                                {{ trans('department.bank_card') }}
                            </div>
                            <div class="bank_card_center" v-for="(bank,index) in emp_bank">
                                {{--<div class="bank_card_img">--}}
                                {{--<img v-bind:src="bank.bank_img">--}}
                                {{--</div>--}}
                                <div class="bank_card_img">
                                    <p class="bank_name">{{ trans('department.bank_card') }}@{{ index+1 }}：</p>
                                    <p class="bank_name_1">@{{ bank.bankname }}<br>@{{ bank.bankaccount }}</p>
                                </div>
                                <br>
                            </div>
                        </div>
                    </mt-popup>
                </el-col>
            </div>
            <div class="datum_mes">
                <el-col :span="12" class="child_mes1">
                    <div class="left_mes">
                        <p class="user_title">{{ trans('department.user_department') }}</p>
                        <p class="user_mes">@{{ item.department }}</p>
                    </div>
                </el-col>
                <el-col :span="12" class="child_mes2">
                    <div class="right_mes">
                        <p class="user_title">{{ trans('department.user_position') }}</p>
                        <p class="user_mes">@{{ item.title }}</p>
                    </div>
                </el-col>
            </div>
            <div class="datum_other">
                <div class="entry_time">
                    <span>{{ trans('department.entry_time') }}: @{{ item.indate | _time}}</span>
                </div>
                <div class="contract_time">
                    <div class="contract_time_left">
                        <span>{{ trans('department.contract_time') }}: @{{ item.arg_end}}</span></div>
                    <div class="contract_time_right"><a @click="contract_btn">{{ trans('department.click_view') }}</a>
                    </div>
                    <mt-popup v-model="popupVisible2">
                        <div class="contract_mes" v-for="cont_mes in contract">
                            <div class="contract_top">
                                <div class="contract_theme">
                                    <p class="fa fa-500px"></p>
                                    {{ trans('department.contract') }}
                                </div>
                                <p class="contract_state">
                                    @{{ cont_mes.agrtype }}
                                </p>
                            </div>
                            <div class="contract_start_stop">
                                @{{ cont_mes.agrbegin | _time}}
                            </div>
                            <div class="contract_bottom">
                                <p class="contract_trial">
                                    {{ trans('department.contract_deadline') }}: @{{ cont_mes.agr_period | years}}
                                </p>

                                {{--<p class="contract_trial">--}}
                                {{--{{ trans('department.contract_trial') }}: @{{ cont_mes.start_date | _time}}--}}
                                {{--</p>--}}
                            </div>
                        </div>
                    </mt-popup>
                </div>
            </div>
        </div>
        {{--<div class="staff_experience">--}}
        {{--<el-col :span="8" class="experience">--}}
        {{--<div class="experience_child">--}}
        {{--<img src="{{ asset('/images/salary_img.jpg') }}">--}}
        {{--</div>--}}
        {{--</el-col>--}}
        {{--<el-col :span="8" class="experience">--}}
        {{--<div class="experience_child">--}}
        {{--<img src="{{ asset('/images/training_img.jpg') }}">--}}
        {{--</div>--}}
        {{--</el-col>--}}
        {{--<el-col :span="8" class="experience">--}}
        {{--<div class="experience_child">--}}
        {{--<img src="{{ asset('/images/performance_img.jpg') }}">--}}
        {{--</div>--}}
        {{--</el-col>--}}
        {{--</div>--}}

        <div class="staff_datum" v-for="item in contact_way">
            <div class="staff_phone">
                <el-col :span="12" class="staff_phone">
                    <div class="staff_phone_left">
                        <p class="fa fa-mobile-phone"></p>
                        <div class="staff_phone_num1">
                            <input class="user_phone" :value="item.user_phone | num_null" v-on:blur="editor_num"
                                   v-bind:disabled="isDisabled1">
                        </div>
                        <div class="phone_editor">
                            <a @click="user_phone_editor">{{ trans('department.editor') }}</a>
                        </div>
                    </div>
                </el-col>
                <el-col :span="12" class="child_mes1">
                    <div class="staff_phone_right">
                        <p class="fa fa-phone"></p>
                        <div class="staff_phone_num2">
                            <input class="danger_name" :value="item.danger_name | name_null" v-on:blur="editor_name"
                                   v-bind:disabled="isDisabled2">
                            <input class="danger_phone" :value="item.danger_phone | num_null"
                                   v-on:blur="editor_danger_num" v-bind:disabled="isDisabled3">
                        </div>
                        <div class="phone_editor">
                            <a @click="danger_phone_editor">{{ trans('department.editor') }}</a>
                        </div>
                    </div>
                </el-col>
            </div>
            <div class="staff_address">
                <p class="fa fa-map-marker"></p>
                <div class="staff_address_mes">
                    <input class="address_mes" :value="item.address_mes" v-on:blur="editor_address"
                           v-bind:disabled="isDisabled4">
                </div>
                <div class="staff_address_editor">
                    <a @click="address_mes_editor">{{ trans('department.editor') }}</a>
                </div>
            </div>
        </div>
        <div class="position_table_detail" v-for="item in work_experience">
            <div class="position_detail">
                <p class="fa-circle1">·</p>
                <div class="position_table">
                    <table width="100%">
                        <tr class="table_title">
                            <td width="40%">@{{ item.begindate | _time }}</td>
                            <td width="60%">@{{ item.jobtitle }}</td>
                        </tr>
                        <tr class="table_mes">
                            <td>@{{ item.enddate |_time }}</td>
                            <td>@{{ item.companyname }}</td>
                        </tr>
                    </table>
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
                page_title: '{{ trans('department.detailed_dautm') }}'
            }
        })
    </script>
    <script>
        new Vue({
            el: '#detailedDatum',
            data: {
                btn_hide: false,
                student_data: [],//学历信息
                uesr_img: '{{ asset("/images/avatar.jpg") }}',//头像
                user_img_default: 'this.src="' + '{{ asset("/images/avatar.jpg") }}' + '"',//default头像 add by frank
                user_data: '',//基本资料
                id_card: [],//身份证资料
                bank_card: [],//银行卡资料
                work_experience: [],//工作经历
                contract: [],//所有合约
                contact_way: [],
                isDisabled1: true,
                isDisabled2: true,
                isDisabled3: true,
                isDisabled4: true,
                popupVisible1: false,
                popupVisible2: false,
                popupVisible3: false,
                empNo: '{{(request('emp_no'))}}',
                ifSelf: true,

            },
            filters: {
                empimg: function (value) {
                    return "{{ asset('/empimages') }}" + '/' + value + '.jpg';
                },
                _time: function (value) {
                    if (value == null || value == '') {
                        return '至今';
                    } else {
                        var now_data = value.substring(0, 10);
                        return now_data;
                    }
                },
                years: function (value) {
                    return value + '年';
                },
                num_null: function (value) {
                    if (value == null) {
                        return '暂无号码！';
                    } else {
                        return value;
                    }
                },
                name_null: function (value) {
                    if (value == null) {
                        return '暂无联络人！';
                    } else {
                        return value;
                    }
                },
                card_type: function (value) {
                    if (value == null) {
                        return '身份证';
                    } else {
                        return value;
                    }
                },
                bank_card: function (value) {
                    if (value == null) {
                        return '无数据';
                    } else {
                        return value;
                    }
                }
            },
            mounted: function () {
                this.ifSelf = (this.empNo.length == 0);
                this.staff_mes();
            },
            methods: {
                staff_mes: function () {
                    var that = this;
                    var params = that.ifSelf ? {} : {emp_no: that.empNo};
                    axios.get("/api/user/getinfo", {params}).then(function (res) {
                        if (res.data.code == 0 && res.data.data) {
                            that.student_data = res.data.data.edu_detail;
                            that.user_data = [{
                                employee_name: res.data.data.emp_name,   //姓名
                                employee_no: res.data.data.emp_no, //公司代码
                                department: res.data.data.emp_dept,//部门
                                title: res.data.data.emp_title, //职位
                                indate: res.data.data.emp_indate, //入职日期
                                arg_end: res.data.data.edu_arg_endtime, //合同到期日期
                                jobtitle: res.data.data.emp_indate

                            }];
                            var emergencyarr = ['', ''];
                            if (res.data.data.emp_emergencycontactor) {
                                emergencyarr = res.data.data.emp_emergencycontactor.split('|');
                            }
                            that.contact_way = [{
                                user_phone: res.data.data.emp_phone,
                                //danger_name:res.data.empagr.urgent_person,
                                //danger_phone:res.data.empagr.urgent_tel,
                                danger_name: emergencyarr[0],
                                danger_phone: emergencyarr[1],
                                address_mes: res.data.data.emp_address
                            }];
                            that.work_experience = JSON.parse(res.data.data.emp_career);//工作经历
                            that.contract = JSON.parse(res.data.data.emp_arg); //合同列表
                            that.id_card = JSON.parse(res.data.data.emp_credentials);//身份证数据
                            console.log(that.id_card);
                            that.emp_bank = JSON.parse(res.data.data.emp_bank);
                        }

                    })
                },
                user_phone_editor: function () {
                    this.isDisabled1 = false;
                },
                danger_phone_editor: function () {
                    this.isDisabled2 = false;
                    this.isDisabled3 = false;
                },
                address_mes_editor: function () {
                    this.isDisabled4 = false;
                }
                ,
                editor_num: function () {
                    this.isDisabled1 = true;
                    console.log(this.user_phone);
                },
                editor_name: function () {
                    this.isDisabled2 = true;
                    console.log(this.danger_name);
                },
                editor_danger_num: function () {
                    this.isDisabled3 = true;
                    console.log(this.danger_phone);
                },
                editor_address: function () {
                    this.isDisabled4 = true;
                    console.log(this.address_mes);
                },
                id_card_btn: function () {
                    this.popupVisible1 = true;
                },
                contract_btn: function () {
                    this.popupVisible2 = true;
                },
                bank_card_btn: function () {
                    this.popupVisible3 = true;
                }
            }
        })
    </script>
@endsection