<!DOCTYPE html>
<html lang="cn">
<head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>@{{ page_title }}</title>
    <!-- ElementUI -->
    <link rel="stylesheet" href="{{asset('css/webApp.css')}}">
    <link rel="stylesheet" href="{{asset('css/index.css')}}">
    <link rel="stylesheet" href="{{asset('css/mintui.css')}}">
    <link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/from.css')}}">

    {{--<link rel="stylesheet" href="https://unpkg.com/mint-ui/lib/style.css">--}}
    <script src="{{asset('js/page_loading.js')}}"></script>
    @yield('css')
    <script>
        /**
         * 各公司不同要求设定水印
         */
        var watermarkStr = '{{trans("salary.watermark_description")}}';

    </script>

</head>
<body>
    <div class="loading" id="loading">
        <div class="pic"></div>
    </div>
    @yield('content')
    <!--VueJs-->
    <script src="{{asset('js/vue.js')}}"></script>
    <script src="{{asset('js/watermark.js')}}"></script>
    <!-- ElementUI -->
    <script src="{{asset('js/mintui.js')}}"></script>
    <script src="{{asset('js/axios.min.js')}}"></script>
    @yield('js')
</body>
</html>