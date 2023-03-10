@extends('Layout.WebApp_Layout')
@section('css')
    <link href="{{ asset('/css/attendance.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
    <div id="leaveList" v-cloak>
        {{--<div class="attendance_header">--}}
        {{--<mt-field v-model="toymd" id="toymd" readonly="readonly"></mt-field>--}}
        {{--<p class="fa fa-navicon" @click="choose_years"></p>--}}
        {{--<mt-popup v-model="popupVisible" position="top" pop-transition="popup-fade">--}}
        {{--<mt-picker :slots="slots" :visibleItemCount="3"  @change="onValuesChange"></mt-picker>--}}
        {{--</mt-popup>--}}
        {{--</div>--}}
        <div class="attendance_list">
            <div class="list_card overtime_list">
                <div class="list_content">
                    <div v-for="(leave,index) in leave_list">
                        <div class="bg_purple" v-if="index < 3">
                            <a  @click="staff_click(2,leave.emp_no)" v-bind:href="staffAttend">
                                <div class="second_man">
                                    {{--<img  v-bind:src="leave_head_img">--}}
									<img v-bind:src="leave.emp_no | empimg" :onerror="user_img_default" >
                                    <p class="mes">
                                    <div class="list_label"><img v-bind:src="index | list_img"></div>
                                    </p>
                                    <p>@{{ leave.emp_name }}</p>
                                    <p>@{{ leave.hours | time}}</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="details_data_list">
            <div calss="child_data_list" id="child_data_list" v-for="(leave,index) in leave_list"  v-if="index > 2">
                <a  @click="staff_click(2,leave.emp_no)" v-bind:href="staffAttend">
                    <div class="data_number">@{{ index }}</div>
                    <div class="data_img"> {{--<img  v-bind:src="leave_head_img">--}}
						<img v-bind:src="leave.emp_no | empimg" :onerror="user_img_default" >
					</div>
                    <div class="data_name">@{{ leave.emp_name }}</div>
                    <div class="data_time">@{{ leave.hours | time }}</div>
                </a>
            </div>

        </div>
    </div>
@endsection

@section('js')
    <script src="{{asset('js/index.js')}}"></script>
    <script>
        new Vue({
            el:'title',
            data:{
                page_title:'{{trans('attendance.leave_ranking')}}'
            }
        })
    </script>
    <script>
        var to_y = new Date().getFullYear();//标准时间  今天  年
        var yeartype = "{{ $yeartype }}";

        var userID = "{{ $userId }}";//工号
        new Vue({
            el:'#leaveList',
            data:{
				user_img_default: 'this.src="' +'{{ asset("/images/avatar.jpg") }}'+'"',//default头像 add by frank
                toymd:'本月',
                now_ymd:'',
                staffAttend:'#',
                leave_head_img:'{{ asset("/images/avatar.jpg") }}',
//                popupVisible:false,
//                slots: [
//                    {
//                        defaultIndex:0,
//                        flex: 1,
//                        values: ['本月', '本季度', '本年'],
//                        className: 'slot1',
//                        textAlign: 'center'
//                    }
//                ],
                leave_list:[]
            },
            filters:{
				empimg:function (value) {
                   return "{{ asset('/empimages') }}" +'/'+value+'.jpg';
                },
                time:function (val) {
                    return val+"H";
                },
                list_img:function (val) {
                    if(val == 0){
                        return "{{ asset('/images/first.png') }}";
                    }else if(val == 1){
                        return "{{ asset('/images/second.png') }}";
                    }else{
                        return "{{ asset('/images/third.png') }}";
                    }
                }
            },
            mounted: function() {
                var to_m = new Date().getMonth() + 1;//标准时间  今天  月
                if(to_m.toString().length<2){
                    to_m = '0'+ to_m;
                }else{
                    to_m=to_m;
                }
                this.now_ymd = to_y+'-'+to_m;
                this.leaveList(yeartype);
            },
            methods: {
//                choose_years:function () {
//                    this.popupVisible = true;
//                },
//                onValuesChange:function (picker,values) {
//                    this.toymd =  values[0];
//                },
                leaveList:function (val) {
                    var that = this;
                    axios.get("/api/attendance/ranking-list",{params:{yeartype:val,emp_no:userID}}).then(function (res) {
                        that.leave_list = res.data.leaveRank;
                    });
                },
                staff_click:function (val,staff_no) {
                    console.log(val);
                    console.log(staff_no);
                    var _ymd = this.now_ymd;
                    this.staffAttend = "{{URL('/attendance/view')}}"+"/detail?selected="+val+"&staff_no="+staff_no+"&toymd="+_ymd;
                }
            }
        })
    </script>
@endsection