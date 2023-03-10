@extends('Layout.WebApp_Layout')
@section('css')
    <link href="{{ asset('/css/admin.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
    <div id="findPwd" v-cloak>
        <div class="findPwd_header">
            <p>{{ trans("admin.please_enter_email") }}</p>
        </div>
        <div class="findPwd_body">
            <mt-field placeholder="{{ trans("admin.email_address") }}" v-model="user_email"></mt-field>
        </div>
        <mt-button type="primary">{{ trans("admin.verify") }}</mt-button>
    </div>
@endsection

@section('js')
    <script>
        new Vue({
            el:'title',
            data:{
                page_title:'{{ trans("admin.lost_pasword") }}'
            }
        })
    </script>
    <script>
        new Vue({
            el:'#findPwd',
            data:{
                user_email:''
            },
            created: function() {

            },
            methods: {

            }
        })
    </script>
@endsection