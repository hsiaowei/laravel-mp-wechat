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
        <div v-show="ifData">
            <a @click="click_url(index)" v-bind:href="list_url" v-for="(item, index) in holiday_list">
                <div class="details_card">
                    <el-row>
                        <el-col :span="6" class="bg-purple">
                            <p class="card_title">@{{item.title}}</p>
                            <p class="card_hour"><span>@{{ item.surplus|hour_number_format }}</span> @{{
                                item.surplus|unit_format }}</p>
                        </el-col>
                        <el-col :span="10" class="bg-card-chart" :id="index">
                            <!--                        <div class="card_time" v-for="(attend, key) in item.list"> <span>@{{attend}}</span></div>-->
                        </el-col>
                        <el-col :span="8" class="card_right">
                            <div class="card_right_detail" v-for="(attend, key) in item.list"><span>@{{attend}}</span>
                            </div>
                        </el-col>
                    </el-row>
                </div>
            </a>
        </div>
        <div v-show="!ifData">
            <div class="without_data">
                {{trans('admin.without_data')}}

            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{asset('js/index.js')}}"></script>
    <script src="{{asset('js/echarts.min.js')}}"></script>
    <script>

        new Vue({
            el: 'title',
            data: {
                page_title: '{{trans('holiday.my_holiday')}}'
            }
        })
    </script>
    <script>
        var a = 0;
        new Vue({
            el: '#holiday-all',
            data: {
                list_url: '#',
                checkUrl: '#',
                ifData: false,
                holiday_list: []
            },
            mounted: function () {
                this.getUserAllHoliday();

            },

            methods: {
                getUserAllHoliday: function () {
                    var that = this;
                    axios.get("/api/holiday/get-all").then(function (res) {
                        var result = res.data;
                        if (res.data.code === 0) {
                            that.ifData = true;
                            that.holiday_list = result.data;
                            console.log(result.data);
                            that.$nextTick(()=>{
                                for (const resultKey in that.holiday_list) {
                                    var value = that.holiday_list[resultKey];
                                    that.makePieGraph(resultKey, value['surplus'], value['used']);
                                }
                            })


                        } else {
                            that.ifData = false;
                            that.holiday_list = [];
                        }

                    })

                },
                click_url: function (type) {
                    this.list_url = "/holiday/view/detail?type=" + type;
                },
                /**
                 *
                 * @param domElement ID选择器
                 * @param surplus 剩余
                 * @param list 已休
                 */
                makePieGraph: function (domElement, surplus, used) {
                    var surplusNumber = parseFloat(surplus);
                    var data = [{
                        name: "剩余",
                        value: surplusNumber
                    }];
                    var usedNumber = parseFloat(used);
                    console.log(usedNumber,surplusNumber);
                    if (usedNumber>0){
                        data.unshift({
                            name: "已休",
                            value: usedNumber
                        });
                    }

                    console.log(data);
                    var mainContainer = document.getElementById(domElement);
                    var myChart = echarts.init(mainContainer);
                    var option = {
                        color: ['#ccc','#00acff'],
                        series: [
                            {
                                type: 'pie',
                                radius: ['50%', '70%'],
                                avoidLabelOverlap: false,
                                label: {
                                    show: false,
                                    position: 'center'
                                },
                                emphasis: {
                                    label: {
                                        show: false,
                                        fontSize: '30',
                                        fontWeight: 'bold'
                                    }
                                },
                                data: data
                            }
                        ]
                    };
                    if (option && typeof option === "object") {
                        myChart.setOption(option, true);
                        myChart.resize();
                    }

                }
            },
            filters: {
                hour_number_format: function (value) {
                    return parseFloat(value);
                },
                unit_format: function (value) {
                    return value.replace(parseFloat(value), '');
                },
            }
        })
    </script>
@endsection