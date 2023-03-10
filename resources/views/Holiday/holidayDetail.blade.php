@extends('Layout.WebApp_Layout')
@section('css')
    <link href="{{ asset('/css/month.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/css/details.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
    <div id="holiday-detail" v-cloak>
        <div class="attendance_header">
            <div class="block"  v-show="selected=='exchange'">
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
                <mt-tab-item  id="year"  >
                <span>
                    <i :class="iconList[0]"></i>
                    年假
                </span>
                </mt-tab-item>
                <mt-tab-item  id="Seniority"  >
                <span>
                    <i :class="iconList[3]"></i>
                    年资假
                </span>
                </mt-tab-item>
                <mt-tab-item   id="exchange"  >
                <span>
                    <i :class="iconList[1]"></i>
                   补休
                </span>
                </mt-tab-item>
            </mt-navbar>

            <!-- tab-container -->
            <mt-tab-container v-model="selected" style="background-color: #ffffff">
                <mt-tab-container-item id="year" >
                    <div class="tab_message_attendance">
                        <div v-for="(detail,index) in yearList">
                            <h3 >@{{ detail.date }}</h3>
                            <el-row  v-for="(item,zindex) in detail.detail" :key="zindex">
                                <el-col :span="8" class="leave-left">
                                    <p class="">@{{ item.date}}</p>
                                </el-col>
                                <el-col :span="16" class="leave-right">
                                    <p>{{trans('details.work_time')}}: <span>@{{ item.time }}</span></p>
                                </el-col>
                                <el-col :offset="8" :span="16" class="leave-right">
                                    <p>{{trans('details.time_long')}}: <span>@{{ item.duration}}</span></p>
                                </el-col>
                            </el-row>
                        </div>
                    </div>
                </mt-tab-container-item>
                <mt-tab-container-item id="Seniority" >
                    <div class="tab_message_attendance">
                        <div v-for="(detail,index) in seniorityList">
                            <h3 >@{{ detail.title }}</h3>
                            <el-row  v-for="(item,tindex) in detail.detail" :key="tindex">
                                <el-col :span="8" class="leave-left">
                                    <p class="">@{{ item.date}}</p>
                                </el-col>
                                <el-col :span="16" class="leave-right">
                                    <p>{{trans('details.work_time')}}: <span>@{{ item.time }}</span></p>
                                </el-col>
                                <el-col :offset="8" :span="16" class="leave-right">
                                    <p>{{trans('details.time_long')}}: <span>@{{ item.duration}}</span></p>
                                </el-col>
                            </el-row>
                        </div>
                    </div>
                </mt-tab-container-item>
                <mt-tab-container-item id="exchange" >
                    <div class="tab_message_attendance">
                        <div v-for="(detail,index) in exchangeList">
                            <h3 >@{{ detail.title }}</h3>
                            <el-row  v-for="(item,tindex) in detail.list" :key="tindex">
                                <el-col :span="8" class="leave-left">
                                    <p class="">@{{ item.date}}</p>
                                </el-col>
                                <el-col :span="16" class="leave-right">
                                    <p>{{trans('details.work_time')}}: <span>@{{ item.time }}</span></p>
                                </el-col>
                                <el-col :offset="8" :span="16" class="leave-right">
                                    <p>{{trans('details.time_long')}}: <span>@{{ item.duration}}</span></p>
                                </el-col>
                            </el-row>
                        </div>
                    </div>
                </mt-tab-container-item>
            </mt-tab-container>

        {{--<div v-else>--}}
            {{--<div class="without_data overtime_card">--}}
                {{--{{trans('admin.without_data')}}--}}
            {{--</div>--}}
        {{--</div>--}}


    </div>
@endsection

@section('js')
    <script src="{{asset('js/index.js')}}"></script>

    <script>
        new Vue({
            el:'title',
            data:{
                page_title:' {{trans('holiday.holiday_detail')}}'
            }
        })
    </script>
    <script>

        var userID = "{{ $userId }}";
        var sd = "{{ $selected }}";
        var tym = "{{ $tym }}";

        new Vue({
            el:'#holiday-detail',
            data:{
                toymd:"",
                selected: sd,
                popupVisible: false,
                showTime: false,
                selectTime:null,
                iconList:[
                        'fa fa-calendar-check-o',
                        'el-icon-time',
                        'el-icon-edit',
                        'fa fa-calendar-o'
                ],
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
                holiday_list:[],
                ifData:false,
                yearList:[],
                seniorityList:[],
                exchangeList:[],

            },
            mounted: function() {
                var that = this;
                that.toymd=tym;
                axios.get("/api/attendance/year-list").then(function (res) {
                    that.slots[0].values = res.data;
                    //that.slots[0].defaultIndex = tym.substring(0,4)-that.slots[0].values[0];
                    //that.slots[2].defaultIndex = tym.substring(5,7).replace(/\b(0+)/gi,"") - 1;

                    that.slots[0].defaultIndex = that.slots[0].values.indexOf(that.toymd.substring(0, 4));
                    that.slots[2].defaultIndex = that.toymd.substring(5, 7).replace(/\b(0+)/gi, "") - 1;
                    that.get_holiday_info(tym);
                });
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
                        this.get_holiday_info(this.toymd);
                    }
                    this.popupVisible=false;

                },


                //假日明细
                get_holiday_info:function (choice_time) {
                    var that = this;
                    axios.get("/api/holiday/get-detail",{params:{emp_no:userID,month_no:choice_time}}).then(function (res) {
                        const result=res.data;
                        if(result.code==0){
//                            that.holiday_list=result.data;
                            that.yearList=result.data.year;
                            that.seniorityList=result.data.Seniority;
                            that.exchangeList=result.data.exchange;
                            that.ifData=true;
                        }else {
//                            that.otherList=[];
//                            that.holiday_list=[];
                            that.ifData=false;
                        }

                    })
                },

            }
        })
    </script>
@endsection