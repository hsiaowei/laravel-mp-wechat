@extends('Layout.WebApp_Layout')
@section('css')
    <link href="{{ asset('/css/admin.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
    <div id="findSuccess" v-cloak>

    </div>
@endsection

@section('js')
    <script>
        new Vue({
            el:'title',
            data:{
                page_title:'{{ trans("admin.find_success") }}'
            }
        })
    </script>
    <script>
        new Vue({
            el:'#findSuccess',
            data:{

            },
            created: function() {

            },
            methods: {

            }
        })
    </script>
@endsection