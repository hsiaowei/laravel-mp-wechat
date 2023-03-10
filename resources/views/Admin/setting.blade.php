@extends('Layout.WebApp_Layout')
@section('css')
    <link href="{{ asset('/css/admin.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
    <div id="setting" v-cloak>
        <div class="setting_header">
            <p>{{ trans("admin.please_enter_corpId") }}</p>
            <div class="setting_body">
                <mt-field placeholder="{{ trans("admin.corpID") }}" v-model="corpId"></mt-field>
            </div>
            <a href="#">{{ trans("admin.to_view") }}</a>
        </div>
        <div class="setting_appList">
            <div class="appList">
                <p class="appList_name">{{ trans("admin.appList") }}</p>
                <p class="appList_icon"><a class="el-icon-plus" @click="add_appList"></a></p>
            </div>
            <div class="appList_line" v-for="(item,index) in appListLine">
                <div class="appList_id">
                    <p>{{ trans("admin.Id") }}</p>
                </div>
                <div class="appList_agent">
                    <mt-field placeholder="{{ trans("admin.agentId") }}" v-model="item.agentId"></mt-field>
                </div>
                <div class="appList_secret">
                    <mt-field placeholder="{{ trans("admin.secret") }}" v-model="item.secret"></mt-field>
                </div>
                <div class="appList_delete">
                    <p @click="delete_appList(index)"><span class="el-icon-minus"></span></p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        new Vue({
            el:'title',
            data:{
                page_title:'{{ trans("admin.setting") }}'
            }
        })
    </script>
    <script>
        new Vue({
            el:'#setting',
            data:{
                corpId:'',
                newAppList: {
                    agentId: '',
                    secret: ''
                },
                appListLine:[
                    {
                        agentId: '',
                        secret: ''
                    }
                ]
            },
            created: function() {

            },
            methods: {
                add_appList:function () {
                    this.appListLine.push(this.newAppList);
                    // 添加完newAppList对象后，重置appListLine对象
                    this.newAppList = {agentId: '', secret:''}
                },
                delete_appList:function(index){
                    // 删一个数组元素
                    this.appListLine.splice(index,1);
                }

            }
        })
    </script>
@endsection