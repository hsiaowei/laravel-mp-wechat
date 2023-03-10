@extends('Layout.WebApp_Layout')
@section('css')
    <link href="{{ asset('/css/details.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/css/month.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
    <div id="tripDetails" v-cloak>
        <div class="calendar_header">
            <div class="block">
                <p class="fa fa-calendar"></p>
                <mt-field v-model="toymd" id="toymd"></mt-field>
                <mt-popup v-model="popupVisible" position="bottom" >
                    <mt-picker :slots="slots" @change="onValuesChange"></mt-picker>
                </mt-popup>
                <div class="input_group" @click="choose_years" readonly="readonly"></div>
                <a href="{{URL('/apply/tripApply')}}"><p class="fa fa-plus-square-o"></p></a>
            </div>
        </div>
        <p class="no_date">@{{ no_date }}</p>
        <div class="trip_content"  v-for="(trip,index) in tripContent">
            <el-collapse  v-model="activeName" accordion>
                <el-collapse-item v-bind:name="index">
                    <template slot="title">
                        @{{ trip.trip_time }}<span class="view_more">{{trans('details.view_more')}}</span>
                    </template>
                    <p>{{trans('details.trip_time')}}: @{{ trip.trip_space }}</p>
                    <p>{{trans('details.trip_origin')}}: @{{ trip.trip_origin }}</p>
                    <p>{{trans('details.trip_destination')}}: @{{ trip.trip_destination }}</p>
                    <p>{{trans('details.trip_content')}}: @{{ trip.trip_content }}</p>
                </el-collapse-item>
            </el-collapse>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{asset('js/index.js')}}"></script>
    <script>
        new Vue({
            el:'title',
            data:{
                page_title:'{{trans('details.trip_Details')}}'
            }
        })
    </script>
    <script>
        var to_years = new Date().getFullYear() - 2012;
        var to_month = new Date().getMonth();
        new Vue({
            el:'#tripDetails',
            data:{
                selected:'1',
                toymd:"2017-06",
                popupVisible: false,
                no_date: '',
                activeName: 0,
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
                tripContent:[
                    {
                        trip_time:'15号',
                        trip_space:'06-15 13:00~06-15 18:00',
                        trip_origin:'公司',
                        trip_destination:'北京天安门',
                        trip_content:'北京天安门城楼修复'
                    },
                    {
                        trip_time:'15号',
                        trip_space:'06-15 13:00~06-15 18:00',
                        trip_origin:'公司',
                        trip_destination:'北京天安门',
                        trip_content:'北京天安门城楼修复'
                    },
                    {
                        trip_time:'15号',
                        trip_space:'06-15 13:00~06-15 18:00',
                        trip_origin:'公司',
                        trip_destination:'北京天安门',
                        trip_content:'北京天安门城楼修复'
                    }
                ]
            },
            created: function() {
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