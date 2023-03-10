@extends('Layout.WebApp_Layout')
@section('css')
    <link href="{{ asset('/css/month.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/css/details.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
    <div id="holiday-all" v-cloak>
        <div class="details_header">
            <div class="block">
            </div>
        </div>
        <div v-if="ifData">
            <a @click="click_url(index)" v-bind:href="list_url" v-for="(item, index) in holiday_list">
            <div class="details_card attend_card"  >
                <el-row>
                    <el-col :span="6" class="bg-purple">
                        <p class="card_title">@{{item.title}}</p>
                    </el-col>
                    <el-col :span="10" class="bg-card">
                        <div class="card_time" v-for="(attend, key) in item.list"> <span>@{{attend}}</span></div>
                    </el-col>
                    <el-col :span="8" class="card_right">
                        <img src="{{ asset('/images/round_bgimg.png') }}">
                        <div class="card_holiday">
                            <p class="card_mes_num">@{{ item.surplus }}</p>
                            <p class="card_mes_text">{{trans('holiday.holiday_surplus')}}</p>
                        </div>
                    </el-col>
                </el-row>
            </div>
            </a>
        </div>
        <div v-else>
            <div class="without_data overtime_card">
                {{trans('admin.without_data')}}

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
                page_title:'{{trans('holiday.my_holiday')}}'
            }
        })
    </script>
<script>
    var a = 0;
    var userID = "{{ $userId }}";
    new Vue({
        el: '#holiday-all',
        data: {
            list_url:'#',
            checkUrl:'#',
            ifData:false,
            holiday_list:[]


        },
        mounted:function(){
            this.getUserAllHoliday();
        },

        methods: {
            getUserAllHoliday:function () {
                var that = this;
                axios.get("/api/holiday/get-all",{params:{emp_no:userID}}).then(function (res) {
                    var result =res.data;
                    if(res.data.code===0){
                        that.ifData=true;
                        that.holiday_list=result.data;
                    }else {
                        that.ifData=false;
                        that.holiday_list=[];
                    }
                })

            },
            click_url:function (type){
                this.list_url = "{{URL('/holiday')}}"+"/view/detail?type="+type+'&companyid='+companyID;
            },
        }
    })
</script>
@endsection