@extends('Layout.WebApp_Layout')
@section('css')
    <link href="{{ asset('/css/notice.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
    <div id="notice-all" v-cloak>
        <div class="details_header">
            <div class="block">
            </div>
        </div>
        @if(count($data) > 0)
        <div class="notice_content">
            <!--            <ul
                                v-infinite-scroll="loadMore"
                                infinite-scroll-disabled="loading"
                                infinite-scroll-distance="10">
                            <li v-for="item in notice_list"   v-for="(item, index) in holiday_list">@{{ item }}</li>
                        </ul>-->
                <el-collapse accordion>
                    @foreach($data as $item)
                    <el-collapse-item>
                        <template slot="title">
                            <!--最佳效果小于60个字-->
                            <div class="notice_title">{{$item['title']}}</div>
                            <div class="notice_time">{{$item['created_at']}}</div>
                        </template>
                        <div class="notice_desc">
                            {!! $item['content'] !!}
                        </div>
                    </el-collapse-item>
                    @endforeach
                </el-collapse>
        </div>
        @else
        <div>
            <div class="without_data">
                {{trans('admin.without_data')}}
            </div>
        </div>
        @endif
    </div>

@endsection


@section('js')
    <script src="{{asset('js/index.js')}}"></script>
    <script src="{{asset('js/echarts.min.js')}}"></script>
    <script>
        // 设置标题
        new Vue({el: 'title', data: {page_title: '{{trans('notice.title')}}'}});
        new Vue({el: '#notice-all'});
    </script>
@endsection