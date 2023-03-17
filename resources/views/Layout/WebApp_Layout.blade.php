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
        //使用了微信内置的JSBridge
        (function() {
            if (typeof WeixinJSBridge == "object" && typeof WeixinJSBridge.invoke == "function") {
                handleFontSize();
            } else {
                document.addEventListener("WeixinJSBridgeReady", handleFontSize, false);
            }
            function handleFontSize() {
                // 设置网页字体为默认大小
                WeixinJSBridge.invoke('setFontSizeCallback', { 'fontSize' : 0 });
                // 重写设置网页字体大小的事件
                WeixinJSBridge.on('menu:setfont', function() {
                    WeixinJSBridge.invoke('setFontSizeCallback', { 'fontSize' : 0 });
                });
            }
        })();
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