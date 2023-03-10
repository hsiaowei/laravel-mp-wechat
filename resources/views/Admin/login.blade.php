@extends('Layout.WebApp_Layout')
@section('css')
    <link href="{{ asset('/css/admin.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
    <div id="login" v-cloak>    
        <div class="login_logo">
            <img v-bind:src="login_logo">
        </div>
        <div class="login_input">
            <p class="fa fa-user"></p>
            <mt-field placeholder="{{ trans('admin.user_name') }}" v-model="username"></mt-field>
        </div>
        <div class="login_input">
            <p class="fa fa-user"></p>
            <mt-field placeholder="{{ trans('admin.pasword') }}" type="password" v-model="password"></mt-field>
        </div>
        <div class="login_input">
            <mt-button type="primary">{{ trans('admin.login') }}</mt-button>
        </div>
        <div class="lost_pasword">
            <a href="#">{{ trans('admin.lost_pasword') }}?</a>
        </div>
    </div>
@endsection

@section('js')
    <script>
        new Vue({
            el:'title',
            data:{
                page_title:'{{ trans('admin.login') }}'
            }
        })
    </script>
    <script>
        new Vue({
            el:'#login',
            data:{
                login_logo:'/images/ares.png'
            },
            created: function() {

            },
            methods: {

            }
        })
    </script>
@endsection