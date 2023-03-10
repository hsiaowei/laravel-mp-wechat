@extends('Layout.WebApp_Layout')
@section('css')
    <link href="{{ asset('/css/month.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/css/details.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
    <div id="attendance" v-cloak>
        <div class="attendance_header">
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
        <div class="tab_card"></div>
        <mt-navbar v-model="selected" style="background-color: #ffffff">
            <mt-tab-item id="1"><span><i class="fa fa-calendar-check-o"></i> {{trans('details.attendance_title')}}</span></mt-tab-item>
            <mt-tab-item id="2"><span><i class="el-icon-time"></i> {{trans('details.leave_title')}}</span></mt-tab-item>
            <mt-tab-item id="3"><span><i class="el-icon-edit"></i> {{trans('details.overtime_title')}}</span></mt-tab-item>
        </mt-navbar>

        <!-- tab-container -->
        <mt-tab-container v-model="selected" style="background-color: #ffffff">
            <mt-tab-container-item id="1">
                <div class="tab_message_attendance">
                    <!--<img src="{{ asset('/images/no_data.png') }}" v-show="no_attend_data" class="no_data">-->
                    <div v-for="(attendance,key) in attendance_list">
                        <h3 v-if="attendance_list != ''">@{{ key }}</h3>
                        <el-row  v-for="item in attendance" :key="item.id">
                            <el-col :span="8" class="leave-left">
                                <p class="">@{{ item.cday | date_time}}</p>
                            </el-col>
                            <el-col :span="10" class="leave-right">
                                {{--<p>{{trans('details.work_category')}}: <span>@{{ item.attend_work }}</span></p>--}}
                                <p>{{trans('details.work_time')}}: <span>@{{ item.btime |substring_time}}-@{{ item.etime |substring_time}}</span></p>
                                <p>{{trans('details.time_long')}}: <span>@{{ item.hour  | time_unit_h}}</span></p>
                            </el-col>
                            {{--<el-col :span="3" class="leave-right">--}}
                                {{--<div class="message_icon" @click="attendance_message(item.cday)"><span class='fa fa-bars'></span></div>--}}
                            {{--</el-col>--}}
                           {{-- <el-col :span="3" class="leave-right">
                                <div class="message_icon"  @click='attendance_back(item.attend_url)'><span class='fa fa-file-text-o'></span></div>
                            </el-col>
							--}}
                        </el-row>
                     </div>
                </div>
            </mt-tab-container-item>
            <mt-tab-container-item id="2" style="background-color: #ffffff">
                <div class="tab_message_attendance">
                    {{--<img src="{{ asset('/images/no_data.png') }}" v-show="no_leave_data" class="no_data">--}}
                    <div v-for="(leave,key) in leave_list">
                        <h3>@{{ key}}</h3>
                        <el-row  v-for="item in leave" :key="item.id">
                            <el-col :span="8" class="leave-left">
                                <p>@{{ item.cday | date_time}}</p>
                            </el-col>
                            <el-col :span="16" class="leave-right">
                                {{--<p>{{trans('details.leave_type')}}: <span>@{{ item.absname }}&nbsp;&nbsp;&nbsp;&nbsp;{{trans('details.leave_space')}}: <span>@{{ item.hour | time_unit_h}}</span></span></p>--}}
                                <p>{{trans('details.leave_time')}}: <span>@{{ item.btime |substring_time}}-@{{ item.etime |substring_time}}</span></p>
                                <p>{{trans('details.leave_space')}}: <span>@{{ item.hour | time_unit_h}}</span></p>
                            </el-col>
                        </el-row>
                    </div>
                </div>
            </mt-tab-container-item>
            <mt-tab-container-item id="3" style="background-color: #ffffff">
                <div class="tab_message_attendance">
                    {{--<img src="{{ asset('/images/no_data.png') }}" v-show="no_overtime_data" class="no_data">--}}
                    <div v-for="(overtime,key) in overtime_list" :key="overtime.id">
                        <h3 >@{{ key|ovtype }}</h3>
                        <el-row  v-for="item in overtime" :key="item.id">
                            <el-col :span="8" class="leave-left">
                                {{--<i class="fa fa-circle"></i>--}}
                                <p class="">@{{ item.cday | date_time }}</p>
                            </el-col>
                            <el-col :span="13" class="leave-right">
                                <p>{{trans('details.apply_time')}}: <span>@{{ item.btime |substring_time}}-@{{ item.etime |substring_time}}</span></p>
                                <p>{{trans('details.work_time')}}: <span>@{{ item.hour | time_unit_h}}</span></p>
                            </el-col>
                            <el-col :span="3" class="leave-right">
                                {{--<div class="message_icon" @click="overtime_message(item.ovday)"><span class='fa fa-bars'></span></div>--}}
                            </el-col>
                        </el-row>
                    </div>
                </div>
            </mt-tab-container-item>

        </mt-tab-container>
        <mt-popup v-model="popupAlert">
            <div class="popupAlert" v-for="item in attend_details">
                {{--<p>{{trans('details.work_date')}}: @{{ item.attend_date | date_time }}</p>--}}
                {{--<p>{{trans('details.work_category')}}: @{{ item.attend_work }}</p>--}}
                {{--<p>{{trans('details.work_begin_card')}}: @{{ item.begin_card | no_card}}</p>--}}
                {{--<p>{{trans('details.work_end_card')}}: @{{ item.end_card | no_card }}</p>--}}
                {{--<p>{{trans('details.work_all_card')}}: @{{ item.all_card | no_card }}</p>--}}
            </div>
        </mt-popup>
        <mt-popup v-model="popupButton">
            <div class="popupButton" >
                <p>请选择您要的操作:</p>
                {{--<a href="{{URL('/apply/signInApply')}}" :@click="make_card"><mt-button size="small" type="default">{{trans('details.make_card')}}</mt-button></a>--}}
                {{--<a href="{{URL('/apply/leaveApply')}}" :@click="ask_for_leave"><mt-button size="small" type="primary">{{trans('details.ask_for_leave')}}</mt-button></a>--}}
                <a href="#" @click="make_card(make_card1)"><mt-button size="small" type="default">{{trans('details.make_card')}}</mt-button></a>
                <a href="#" @click="ask_for_leave(make_card1)"><mt-button size="small" type="primary">{{trans('details.ask_for_leave')}}</mt-button></a>
            </div>
        </mt-popup>
        <mt-popup v-model="popupOvertime">
            <div class="popupOvertime" v-for="item in overtime_details">
                <p>{{trans('details.work_date')}}: @{{ item.attend_date | date_time }}</p>
                <p>{{trans('details.work_category')}}: @{{ item.attend_work }}</p>
                <p>{{trans('details.work_begin_card')}}: @{{ item.begin_card | no_card }}</p>
                <p>{{trans('details.work_end_card')}}: @{{ item.end_card | no_card}}</p>
                <p>{{trans('details.work_all_card')}}: @{{ item.all_card | no_card }}</p>
            </div>
        </mt-popup>
    </div>
@endsection

@section('js')
    <script src="{{asset('js/index.js')}}"></script>

    <script>
        new Vue({
            el:'title',
            data:{
                page_title:' {{trans('details.attendance_item')}}'
            }
        })
    </script>
    <script>
        var a = 0;
        var userID = "{{ $userId }}";
        var sd = "{{ $selected }}";
        var tym = "{{ $toymd }}";

        new Vue({
            el:'#attendance',
            data:{
                toymd:"",
                selected: sd,
                popupVisible: false,
                popupAlert: false,
                popupButton: false,
                popupOvertime: false,
                no_attend_data: false,
                no_leave_data: false,
                no_overtime_data: false,
                make_card1: '',
                showTime: false,
                selectTime:null,
                slots: [
                    {
                        defaultIndex:5,
                        flex: 1,
                        values: [],
                        className: 'slot1',
                        textAlign: 'center'
                    },{
                        divider: true,
                        content: '-',
                        className: 'slot2'
                    }, {
                        defaultIndex:5,
                        flex: 1,
                        values: ['01', '02', '03', '04', '05', '06','07', '08', '09', '10', '11', '12'],
                        className: 'slot3',
                        textAlign: 'center'
                    }
                ],
                leave_list:[],
                attendance_list:[],
                overtime_list:[],
                overtime_details:[],
                attend_details:[]
            },
            mounted: function() {
                var that = this;
                that.toymd=tym;
                axios.get("/api/attendance/year-list").then(function (res) {
                    that.slots[0].values = res.data;
                    //that.slots[0].defaultIndex = tym.substring(0,4)-that.slots[0].values[0];
                    that.slots[0].defaultIndex = that.slots[0].values.indexOf(that.toymd.substring(0, 4));
                    that.slots[2].defaultIndex = tym.substring(5,7).replace(/\b(0+)/gi,"") - 1;
                    that.get_attend_info(tym);
                });
            },
            filters:{
                time_unit_h:function (value) {
                    if(value<1){
                        value="0"+value;
                    }
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
                substring_time:function (value) {

                    return value.substring(3);
                },
                no_card:function (value) {
                    if(value == null ||value == ''){
                        return "无";
                    }else{
                        return value;
                    }
                },
                date_time:function (value) {
                    var now_data = value.substring(0,10);
                    return now_data;
                }
            },
            methods: {
                choose_years:function () {
                    this.popupVisible = true;
                },
                onValuesChange:function(picker,values) {
                    if(values[0] == '' ||values[0] == undefined){
                        values[0] = new Date().getFullYear();
                    }
                    this.selectTime = values[0] + '-' + values[1];

                },

                onSureTimeClick:function() {
                    if(this.toymd!=this.selectTime){
                        this.toymd=this.selectTime;
                        this.get_attend_info(this.toymd);
                    }
                    this.popupVisible=false;

                },
                handleClick:function(tab, event) {
                    console.log(tab, event);

                },
                attendance_message:function (choice_time) {//异常详情弹窗
                    var now_data = choice_time.substring(0,10);
                    var that = this;
                    axios.get("/api/attendDetails",{params:{emp_no:userID,cday:now_data}}).then(function (res) {
                   //     that.attend_details = res.data;
                    });
                    this.popupAlert = true;
                },
                attendance_back:function (attend_url) {//操作弹窗

                    this.make_card1 = attend_url;
                    this.popupButton = true;
                },
                //考勤明细
                get_attend_info:function (choice_time) {
                    var that = this;
                    axios.get("/api/attendance/summary-detail",{params:{emp_no:userID,month_no:choice_time}}).then(function (res) {

                        that.attendance_list = res.data.sysArr; //考勤数据
                        that.leave_list = res.data.leaveArr;       //请假数据
                        that.overtime_list = res.data.overArr;     //加班数据

                        if(res.data.sysArr.length>0){
                            that.no_attend_data = true;
                        }
                        if(res.data.overArr.length>0){
                            that.no_overtime_data = true;
                        }
                        if(res.data.leaveArr.length>0){
//                            that.no_leave_data = true;
                        }
                    })
                },


                make_card:function(make_card1){//补卡跳转
                    console.log(make_card1);
                },
                ask_for_leave:function(make_card1){//请假跳转
                    console.log(make_card1);
                }
            }
        })
    </script>
@endsection