@extends('Layout.WebApp_Layout')
@section('css')
    <link href="{{ asset('/css/salary.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
    <div id="salary_more" v-cloak>
        <div class="salary_header" id="salary_header">
            <p class="fa fa-calendar"></p>
            <mt-field v-model="toymd" id="toymd"></mt-field>
            <mt-popup v-model="popupVisible" position="bottom">
                <mt-picker :slots="slots" @change="onValuesChange" :visible-Item-Count="3"></mt-picker>
            </mt-popup>
            <div class="input_group" @click="choose_years" readonly="readonly"></div>
        </div>
        {{--<div v-for="(item,key) in salary_details">--}}
        {{--@{{ key }}--}}
        {{--</div>--}}
        <div class="salary_details">
            {{--<mt-navbar v-model="active">--}}
            {{--<mt-tab-item v-for="(tab_n,key) in salary_details" :id="key">@{{ key }}</mt-tab-item>--}}
            {{--</mt-navbar>--}}

            <div class="salary_details">
                <mt-navbar v-model="active">
                    <mt-tab-item v-for="(tab_n,index) in salary_details" v-bind:id="index" :key="tab_n.id">@{{
                        tab_n.validate_date | date_time }}
                    </mt-tab-item>
                </mt-navbar>
                <mt-tab-container v-model="active" class="salary_mes">
                    <mt-tab-container-item v-for="(tab_n,index) in salary_details" :key="tab_n.id" v-bind:id="index">
                        <div class="tab_circle">
                            <p class="special_adjustment">{{trans('salary.add_adjustment')}}</p>
                            <p class="monthly_wages">@{{ tab_n.count_amount }}</p>
                            {{--<p class="add_wages">@{{ tab_n.salary_add }} <span v-bind:class="tab_n.salary_icon"></span></p>--}}
                        </div>
                        <mt-cell v-for="tab_mes in tab_n.table_info" v-bind:title="tab_mes.mapname"
                                 v-bind:value="tab_mes.amount" :key="tab_mes.id"></mt-cell>
                    </mt-tab-container-item>
                </mt-tab-container>

            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        new Vue({
            el: 'title',
            data: {
                page_title: '{{trans('salary.view_more')}}'
            }
        })
    </script>
    <script>
        var a = 2;
        new Vue({
            el: '#salary_more',
            data: {
                toymd: '',
                empNo: '{{(request('emp_no'))}}',
                popupVisible: false,
                active: 0,
                special_money: '2500',
                fa_icon: 'fa fa-long-arrow-up',
                slots: [
                    {
                        defaultIndex: 0,
                        flex: 1,
                        values: [],
                        className: 'slot1',
                        textAlign: 'center'
                    }
                ],
                salary_details: []
            },
            mounted: function () {
                var that = this;
                var params ={};
                if (that.empNo.length != 0) {
                    params['emp_no'] = that.empNo;
                }
                axios.get("/api/salary/query-more", {params}).then(function (res) {
                    that.slots[0].values = res.data;
                    that.slots[0].defaultIndex = res.data.length - 1;

                });

                // add waterMark
                window.watermark.set(watermarkStr);

            },
            filters: {
                date_time: function (value) {
                    var now_data = value.substring(5, 10);
                    return now_data;
                }
            },
            methods: {
                choose_years: function () {
                    this.popupVisible = true;
                },
                onValuesChange: function (picker, values) {
                    this.toymd = values[0];
                    a++;
                    if (a > 2) {
                        var last_year = this.toymd;
                        this.salaryList(last_year);
                    }

                },
                salaryList: function (last_year) {
                    var that = this;
                    var params = {year: last_year};
                    if (that.empNo.length != 0) {
                        params['emp_no'] = that.empNo;
                    }
                    axios.get("/api/salary/query-more", {params}).then(function (res) {
                        that.salary_details = res.data;
                    });
                }
            }
        })
    </script>

@endsection