@extends('Layout.WebApp_Layout')
@section('css')
    <link href="{{ asset('/css/details.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
    <div id="leaveContent" v-cloak>
        <div  v-for="overtime in overtime_content">
            <div class="leave_content">
                <div class="leave_title">@{{ overtime.overtime_date }}<span class="view_more">@{{ overtime.overtime_space }}</span></div>
                <p>{{trans('details.overtime_time')}}: @{{ overtime.overtime_time }}</p>
                <p>{{trans('details.overtime_classes')}}: @{{ overtime.overtime_classes }}</p>
                <p>{{trans('details.overtime_type')}}: @{{ overtime.overtime_type }}</p>
            </div>
            <div class="opbuttom">
                <img src="{{ asset('/images/opbuttom.png') }}">
            </div>
            <el-steps :space="100" direction="vertical" :active="overtime.hello">
                <el-step>
                    <template slot="title">
                        <p class="state_a">@{{ overtime.overtime_state_1 }}</p>
                        <p class="state_b">@{{ overtime.overtime_state_time }}</p>
                    </template>
                </el-step>
                <el-step >
                    <template slot="title">
                        <p>@{{ overtime.overtime_state_2 }}</p>
                        <p>@{{ overtime.overtime_sign_boss }}</p>
                    </template>
                </el-step>
                <el-step>
                    <template slot="title">
                        <p>@{{ overtime.overtime_state_3 }}</p>
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
                page_title:'{{trans('details.overtime_content')}}'
            }
        })
    </script>
    <script>
        new Vue({
            el:'#leaveContent',
            data:{
                overtime_content:[
                    {
                        overtime_date:'2017-03-30',
                        overtime_space:'共计3h',
                        overtime_time:'19:00~21:00',
                        overtime_type:'补休',
                        overtime_classes:'例假日',
                        hello:2,
                        overtime_state_1:'已提交申请',
                        overtime_state_time:'2017-03-30 13:17',
                        overtime_state_2:'驳回',
                        overtime_sign_boss:'张三',
                        overtime_state_3:'同意申请'
                    }
                ]
            },
            created: function() {
            },
            methods: {

            }
        })
    </script>
@endsection