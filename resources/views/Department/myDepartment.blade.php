@extends('Layout.WebApp_Layout')
@section('css')
    <link href="{{ asset('/css/department.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
    <div id="myDepartment" v-cloak>
        <div class="myDepartment_header">
            <mt-search v-model="searchString" cancel-text=""  placeholder="{{ trans('salary.staff_search') }}"></mt-search>
        </div>

        <div class="avatar_block" v-for="mes in user_data">
            <div class="user_message">
                {{--<img v-bind:src="avatar">--}}
				<img v-bind:src="member_img" :onerror="user_img_default">
                <div class="user_data">
                    <p>@{{ mes.leadername }} <span class="user_number">{{ $userId }}</span></p>
                    <p>@{{ mes.dept }}</p>
                </div>
            </div>
            <div class="user_department">
                <el-row>
                    <el-col :span="8">
                        {{--<p></p>--}}
                        <p class="department_text">{{ trans('department.under_man') }}:@{{ mes.emp_count }}</p>
                    </el-col>
                    <el-col :span="8">
                        {{--<p>@{{ mes.department_man }}</p>--}}
                        {{--<p class="department_text">{{ trans('department.department_man') }}</p>--}}
                    </el-col>
                    <el-col :span="8">
                        {{--<p>@{{ mes.under_department }}</p>--}}
                        {{--<p class="department_text">{{ trans('department.under_department') }}</p>--}}
                    </el-col>
                </el-row>
            </div>
        </div>
        <div v-if="searchString=='' || staff_name==''">
            <div class="department_data" v-for="depart in filteredArticles">
                    <div class="department_name">
                        <p class="depart_name">@{{ depart.deptname }}</p>
                        <p class="depart_number">@{{ depart.emp_count | people }}</p>
                    </div>

                    <div class="depart_member" v-for="member in depart.deptinfo">
                        <a  @click="click_staff(member.emp_no)" v-bind:href="staff_url">
                        <el-col :span="3">
            				<img v-bind:src="member_img" :onerror="user_img_default">
                   		 </el-col>
                          <el-col :span="19">
            		      <div class="member_data">
                                <p class="depart_name">@{{ member.emp_name }} <span>@{{ member.emp_no }}</span></p>
                                <p class="depart_number"><span>@{{ member.years | years }}</span></p>
                            </div>
                   		 </el-col>
                          <el-col :span="2">
            	     		<div class="next_icon">
                                <span class="fa fa-angle-right"></span>
                            </div>
                   		 </el-col>
                      
                        </a>
                    </div>
            </div>
        </div>
        <div v-else>
            <div class="department_data" v-for="member in staff_name">
                <div class="depart_member">
                    <a  @click="click_staff(member.emp_no)" v-bind:href="staff_url">
					     <el-col :span="3">
            				<img v-bind:src="member_img" :onerror="user_img_default">
                   		 </el-col>
                          <el-col :span="19">
            		      <div class="member_data">
                                <p class="depart_name">@{{ member.emp_name }} <span>@{{ member.emp_no }}</span></p>
                                <p class="depart_number"><span>@{{ member.years | years }}</span></p>
                            </div>
                   		 </el-col>
                          <el-col :span="2">
            	     		<div class="next_icon">
                                <span class="fa fa-angle-right"></span>
                            </div>
                   		 </el-col>
                    </a>
                </div>
            </div>
        </div>
        <div class="go_top">
            <a href="#top"><img src="{{ asset('/images/go_top.png') }}"></a>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{asset('js/index.js')}}"></script>
    <script>
        new Vue({
            el:'title',
            data:{
                page_title:'{{ trans('department.my_department') }}'
            }
        })
    </script>

    <script>
        //var basedate = "2017-08-08";
		var date = new Date();  
		var mon = date.getMonth() + 1; 
		var day = date.getDate(); 
		var basedate = date.getFullYear() + "-" + (mon<10?"0"+mon:mon) + "-" +(day<10?"0"+day:day); 
		
        new Vue({
            el:'#myDepartment',
            data:{
				avatar:'/images/avatar.jpg',
                member_img:'{{ asset("/images/avatar.jpg") }}',//头像
				user_img_default: 'this.src="' +'{{ asset("/images/avatar.jpg") }}'+'"',//default头像 add by frank
                btn_hide:false,
                staff_url:"#",
                searchString:'',
                user_data:[
                    {
                        user_name:'',
                        user_number:'',
                        user_department:'',
                        under_man:'',
                        department_man:'',
                        under_department:''
                    }
                ],
                departmentData:[],
                staff_name:[],
                new_list:{
                    employee_id: '',
                    employee_name:'',
                    employee_no:'',
                    years:''
                }

            },
            filters:{ 
				empimg:function (value) {
                   return "{{ asset('/empimages') }}" +'/'+value+'.jpg';
                },
                people:function (val) {
                    return val+"人";
                },
                years:function (val) {
                    var first = val.substring(0,1);
                    if(first == '.'){
                        return '0'+val+"年";
                    }else{
                        return val+"年";
                    }

                }
            },
            mounted: function() {
                var to_value = this.value;
                this.staff_list(to_value); 

            },
            watch:{
                searchString:function () {
                    this.staff_name = [];
                }
            },
            methods:{
                click_staff:function (val) {
                    this.staff_url = '/user/view/userinfo?emp_no='+val;
                },
                staff_search:function () {
                    var to_value = this.value;
                    this.staff_list(to_value);
                },
                staff_list:function (to_value) {
                    var that =this;
                    axios.get("/api/user/my-department",{params:{basedate:basedate,to_value:to_value}}).then(function (res) {
                        that.departmentData = res.data.staff;
                        that.user_data = [res.data.leader];
                    })
                }
            },
            computed: {
                filteredArticles: function () {
                    var articles_array = this.departmentData,
                        staff_name = this.staff_name,
                        searchString = this.searchString;
                    if(!searchString){
                        return articles_array;
                    }

                    searchString = searchString.trim().toLowerCase();

                    articles_array = articles_array.filter(
                        function(item){
                        if(item.deptname.toLowerCase().indexOf(searchString) !== -1){
                            return item;
                        }else{
                            for(var i = item.deptinfo.length-1;i>=0;i--){
                                if(item.deptinfo[i].emp_no.toLowerCase().indexOf(searchString) !== -1 ||
                                    item.deptinfo[i].emp_name.toLowerCase().indexOf(searchString) !== -1){
                                    new_list = {
//                                        employee_id:item.deptinfo[i].employee_id,
                                        emp_name:item.deptinfo[i].emp_name,
                                        emp_no:item.deptinfo[i].emp_no,
                                        years:item.deptinfo[i].years
                                    };
                                    staff_name.push(new_list);
                                }
                            }
                        }
                    });
                    return articles_array;
                }
            }
        })
    </script>
@endsection