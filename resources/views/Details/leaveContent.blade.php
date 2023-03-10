@extends('Layout.WebApp_Layout')
@section('css')
    <link href="{{ asset('/css/details.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
    <div id="leaveContent"  v-cloak>
        <div  v-for="leave in leave_content">
            <div class="leave_content">
                <div class="leave_title">@{{ leave.leave_date }}<span class="view_more">@{{ leave.leave_space }}</span></div>
                <p>{{trans('details.begin_time')}}: @{{ leave.leave_begin_time }}</p>
                <p>{{trans('details.end_time')}}: @{{ leave.leave_end_time }}</p>
                <p>{{trans('details.leave_type')}}: @{{ leave.leave_type }}</p>
                <p>{{trans('details.leave_reason')}}: @{{ leave.leave_reason }}</p>
            </div>
            <div class="opbuttom">
                <img src="{{ asset('/images/opbuttom.png') }}">
            </div>
            <el-steps :space="100" direction="vertical" :active="leave.hello">
                <el-step>
                    <template slot="title">
                        <p class="state_a">@{{ leave.leave_state_1 }}</p>
                        <p class="state_b">@{{ leave.leave_state_time }}</p>
                    </template>
                </el-step>
                <el-step >
                    <template slot="title">
                        <p>@{{ leave.leave_state_2 }}</p>
                        <p>@{{ leave.leave_sign_boss }}</p>
                    </template>
                </el-step>
                <el-step>
                    <template slot="title">
                        <p>@{{ leave.leave_state_3 }}</p>
                    </template>
                </el-step>
            </el-steps>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{asset('js/index.js')}}"></script>
    <script>
        new Vue({
            el:'title',
            data:{
                page_title:'{{trans('details.leave_content')}}'
            }
        })
    </script>
    <script>
        new Vue({
            el:'#leaveContent',
            data:{
                leave_content:[
                    {
                        leave_date:'2017-03-30',
                        leave_space:'共计15h',
                        leave_begin_time:'2017-03-30 13:00',
                        leave_end_time:'2017-03-30 18:00',
                        leave_type:'年假',
                        hello:2,
                        leave_reason:'北京天安门城楼修复',
                        leave_state_1:'已提交申请',
                        leave_state_time:'2017-03-30 13:17',
                        leave_state_2:'驳回',
                        leave_sign_boss:'张三',
                        leave_state_3:'同意申请'
                    }
                ]
            },
            mounted: function() {
            },
            methods: {

            }
        })
    </script>
@endsection