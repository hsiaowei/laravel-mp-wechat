@extends('Layout.WebApp_Layout')
@section('css')
    <link href="{{ asset('/css/details.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
    <div id="staffAbcContent" v-cloak>
        <div class="leave_content" v-for="staff in staff_content">
            <p>{{trans('details.begin_time')}}: @{{ staff.staff_name }}</p>
            <p>{{trans('details.end_time')}}: @{{ staff.staff_date }}</p>
            <p>{{trans('details.leave_type')}}: @{{ staff.staff_situation }}</p>
            <p>{{trans('details.leave_reason')}}: @{{ staff.staff_type }}</p>
            <div class="related_content">{{trans('details.leave_reason')}}:
                @{{ staff.related_content }}</div>
        </div>
        {{--<div style="width: 100%;text-align: center;font-size: 0.3rem"><a href="">查看更多<p class="fa fa-angle-double-right"></p></a></div>--}}
    </div>
@endsection

@section('js')
    <script src="{{asset('js/index.js')}}"></script>
    <script>
        new Vue({
            el:'title',
            data:{
                page_title:'{{trans('details.staffAbcContent')}}'
            }
        })
    </script>
    <script>
        new Vue({
            el:'#staffAbcContent',
            data:{
                staff_content:[
                    {
                        staff_name:'张三',
                        staff_date:'2017-03-13',
                        staff_situation:'正面',
                        staff_type:'A',
                        related_content:'要去拆天安门，要去拆天安门要去拆天安门要去拆天安门要去拆天安门要去拆天安门，要去拆天安门要去拆天安门要去拆天安门要去拆天安门要去拆天安门，要去拆天安门要去拆天安门要去拆天安门要去拆天安门要去拆天安门要去拆天安门要去拆天安门要去拆天安门要去拆天安门要去拆天安门要去拆天安门要去拆天安门要去拆天安门要去拆天安门要去拆天安门要去拆天安门要去拆天安门要去拆天安门要去拆天安门要去拆天安门'
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