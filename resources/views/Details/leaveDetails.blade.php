@extends('Layout.WebApp_Layout')
@section('css')
    <link href="{{ asset('/css/details.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/css/month.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
    <div id="leaveDetails" v-cloak>
        <div class="calendar_header">
            <div class="block">
                <p class="fa fa-calendar"></p>
                <mt-field v-model="toymd" id="toymd"></mt-field>
                <mt-popup v-model="popupVisible" position="bottom" >
                    <mt-picker :slots="slots" @change="onValuesChange"></mt-picker>
                </mt-popup>
                <div class="input_group" @click="choose_years" readonly="readonly"></div>
                <a href="{{URL('/apply/leaveApply')}}"><p class="fa fa-plus-square-o"></p></a>
            </div>
        </div>
        <p class="no_date">@{{ no_date }}</p>
        <div class="data_list" v-for="leave in leaveContent">
            <div class="content_left">
                <p class="leave_time">@{{ leave.leave_time }}</p>
                <p v-if="leave.leave_state == '核准'" class="leave_state1">@{{ leave.leave_state }}</p>
                <p v-else class="leave_state2">@{{ leave.leave_state }}</p>
            </div>
            <div class="content_right">
                <span>@{{ leave.leave_time_long }}</span>
                <span>@{{ leave.leave_space }}</span>
                <a href="{{URL('/details/leaveContent')}}">查看</a>
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
                page_title:'{{trans('details.leave_Details')}}'
            }
        })
    </script>
    <script>
        var to_years = new Date().getFullYear() - 2012;
        var to_month = new Date().getMonth();
        new Vue({
            el:'#leaveDetails',
            data:{
                selected:'1',
                toymd:"2017-06",
                popupVisible: false,
                no_date: '',
                slots: [
                    {
                        defaultIndex:to_years,
                        flex: 1,
                        values: ['2012','2013','2014','2015','2016','2017','2018','2019','2020','2021','2022'],
                        className: 'slot1',
                        textAlign: 'center'
                    },{
                        divider: true,
                        content: '-',
                        className: 'slot2'
                    }, {
                        defaultIndex:to_month,
                        flex: 1,
                        values: ['01', '02', '03', '04', '05', '06','07', '08', '09', '10', '11', '12'],
                        className: 'slot3',
                        textAlign: 'center'
                    }
                ],
                leaveContent:[
                    {
                        leave_time:'15号',
                        leave_time_long:'16h',
                        leave_space:'08:30~17:30',
                        leave_state:'核准'
                    },
                    {
                        leave_time:'22号',
                        leave_time_long:'16h',
                        leave_space:'08:30~17:30',
                        leave_state:'驳回'
                    }
                ]
            },
            mounted: function() {
            },
            methods: {
                choose_years:function () {
                    this.popupVisible = true;
                },
                onValuesChange:function(picker,values) {
                    if(values[0] == '' ||values[0] == undefined){
                        values[0] = new Date().getFullYear();
                    }
                    if(values[1] == '' ||values[1] == undefined){
                        values[1] = to_month + 1;
                    }
                    this.toymd = values[0] + '-' + values[1];
                }
            }
        })
    </script>
@endsection