<?php
return [
    // default  company_id 就不一一配置
    'wx_shift_info' => [
        'cols' => ['shift_id', 'shift_no', 'shift_name', 'begintime', 'endtime']//default company_id
        , 'uk' => ['shift_id'],//default company_id
    ],
    'wx_shift_group_info' => [
        'cols' => ['shift_group_id', 'shift_group_no', 'shift_group_name']
        , 'uk' => ['shift_group_id'],//default company_id
    ],
    'wx_emp_schedule_info' => [
        'cols' => ['employee_id', 'schedule_date', 'shift_group_id', 'shift_id']
        , 'uk' => ['employee_id', 'schedule_date'],//default company_id
    ],
    'wx_emp_clock_info' => [
        'cols' => ['employee_id', 'clock_time']
        , 'uk' => ['employee_id', 'clock_time'],//default company_id
    ],

    'wx_personal_information_page' => [
        'cols' => ['emp_no',
            'emp_name',
            'emp_indate',
            'emp_outdate',
            'emp_dept',
            'emp_edu',
            'emp_title',
            'emp_address',
            'emp_phone',
            'emp_emergencycontactor',
            'emp_arg',
            'emp_bank',
            'emp_credentials',
            'emp_career',
            'leader_flag'//是否主管，by Hsiaowei 2023-04-10
        ]
        , 'uk' => ['emp_no'],//default company_id
    ],
    'wx_personal_calendar_page' => [
        'cols' => [
            'emp_no',
            'month_no',
            'emp_shift',
            'emp_clock ',
            'emp_e_abs',
            'emp_n_abs',
            'emp_over',
            'emp_e_abs_t',
            'emp_n_abs_t',
            'emp_over_t',
            'salary_time_sum'
        ],
        'uk' => ['emp_no', 'month_no'],
    ],
    'wx_personal_pwd' => [
        'cols' => [
            'emp_no',
            'old_pwd',
            'new_pwd'
        ],
        'uk' => ['emp_no'],
    ],
    'wx_personal_salary_page' => [
        'cols' => [
            'emp_no',
            'month_no',
            'emp_pay_type',
            'emp_salary',
            'emp_salary_fix',
            'emp_salary_tax',
            'emp_salary_temp',
            'emp_salary_ov',
            'emp_salary_abs',
            'emp_salary_insure',//'五险一金(员工负担)'
            'emp_salary_b',
            'emp_salary_bs',
            'emp_salary_tw',
            'emp_salary_tw_bs',
            'emp_salary_insure_cpy',//五险一金(公司负担) 共用版已上
        ],
        'uk' => ['emp_no', 'month_no', 'emp_pay_type'],
    ],
    'wx_personal_salarp' => [
        'cols' => [
            'emp_no',
            'validate_date',
            'mapname',
            'amount'
        ],
        'uk' => ['emp_no'],
    ],

    'wx_personal_salaryp' => [
        'cols' => [
            'emp_no',
            'validate_date',
            'mapname',
            'amount'
        ],
        'uk' => ['emp_no' . 'validate_date', 'mapname'],
    ],
    'wx_leader_permission_list' => [
        'cols' => [
            'emp_no',
            'lead_no',
            'salary_auth',
            'info_auth',

        ],
        'uk' => ['emp_no', 'lead_no'],
    ],
    'wx_all_holiday' => [
        'cols' => [
            'emp_no',
            'year',
            'holiday',// 可休假调整 add used栏位如下，by Hsiaowei 2023-04-10
            // {"year":{"title":"年假","surplus":"0小时","used":"0小时","list":["当年时数:0小时","递延时数:0小时","已休时数:0小时"]},"exchange":{...}}
        ],
        'uk' => ['year', 'emp_no'],
    ],
    'wx_holiday_detail' => [
        'cols' => [
            'emp_no',
            'month_no',
            'detail',
        ],
        'uk' => ['emp_no', 'month_no'],
    ],
    'wx_notice' => [
        /**
         * {
         * "companyid": 22,
         *     "table": "wx_notice",
         *     "type": "IU",
         *     "data": [{
         *         "1": "这是通知公告标题限制60字以内，点击可查看内容",
         *         "2": "这是通知公告内容不限制字数",
         *         "3": "这是类型暂未使用",
         *         "4": "这是状态暂未使用"
         *     }]
         * }
         */
        'cols' => [
            'title',
            'content',
            'type',
            'status',
        ],
        'uk' => [],
    ],
];