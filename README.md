<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, yet powerful, providing tools needed for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of any modern web application framework, making it a breeze to get started learning the framework.

If you're not in the mood to read, [Laracasts](https://laracasts.com) contains over 1100 video tutorials on a range of topics including Laravel, modern PHP, unit testing, JavaScript, and more. Boost the skill level of yourself and your entire team by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for helping fund on-going Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](http://patreon.com/taylorotwell):

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[British Software Development](https://www.britishsoftware.co)**
- [Fragrantica](https://www.fragrantica.com)
- [SOFTonSOFA](https://softonsofa.com/)
- [User10](https://user10.com)
- [Soumettre.fr](https://soumettre.fr/)
- [CodeBrisk](https://codebrisk.com)
- [1Forge](https://1forge.com)
- [TECPRESSO](https://tecpresso.co.jp/)
- [Pulse Storm](http://www.pulsestorm.net/)
- [Runtime Converter](http://runtimeconverter.com/)
- [WebL'Agence](https://weblagence.com/)

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](http://laravel.com/docs/contributions).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).

##员工服务主管服务菜单
"员工服务"
    "个人信息" => "https://hcp.azurewave.com.cn:8443/user/view/userinfo?companyid=23
    "我的考勤" =>
        我的日历" => "https://hcp.azurewave.com.cn:8443/attendance/view/canlendar?companyid=23"
        "我的考勤" => "https://hcp.azurewave.com.cn:8443/attendance/view/summary?companyid=23"
        "我的可休假" => "https://hcp.azurewave.com.cn:8443/holiday/view/all?companyid=23"
    "我的薪资" => 
        "薪资单" => "https://hcp.azurewave.com.cn:8443/salary/view/salary-detail?companyid=23"
        "调薪历史" => "https://hcp.azurewave.com.cn:8443/salary/view/salary-query?companyid=23"
"主管服务"
    "我的部属" => "https://hcp.azurewave.com.cn:8443/user/view/mydepartment?companyid=23"
    "部属考勤" => "https://hcp.azurewave.com.cn:8443/attendance/view/attendance-list?companyid=23"
    
获取打卡数据
官方地址：https://open.work.weixin.qq.com/api/doc/90000/90135/90262
要求：
1.获取记录时间跨度不超过30天

2.用户列表不超过100个。若用户超过100个，请分批获取

3.有打卡记录即可获取打卡数据，与当前”打卡应用”是否开启无关

4.标准打卡时间只对于固定排班和自定义排班两种类型有效

5.接口调用频率限制为600次/分钟

api：/api/get-clock POST
参数：
{
    "companyid":23,
    "start":"2021-08-20",
    "end":"2021-08-28",
    "userids":["xxx","xxx","xxx"] //最少2个用户ID
}
返回：
{
    "code": 0,
    "msg": "ok",
    "data": [
        {
            "emp_no": "6I20825",
            "time": "2021-08-20 08:12:03",
            "type": "up"
        }
    }
}


php-version:7.1+

#SMS证书问题

 如果您的 PHP 环境证书有问题，可能会遇到报错，类似于cURL error 60: See http://curl.haxx.se/libcurl/c/libcurl-errors.html，请尝试按以下步骤解决：

- 到 https://curl.haxx.se/ca/cacert.pem 下载证书文件cacert.pem，将其保存到 PHP 安装路径下。
- 编辑php.ini文件，删除curl.cainfo配置项前的分号注释符（;），值设置为保存的证书文件cacert.pem的绝对路径。
- 重启依赖 PHP 的服务。