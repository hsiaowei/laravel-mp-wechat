-- auto-generated definition
create table wx_all_holiday
(
    id         int auto_increment
        primary key,
    company_id int         not null,
    emp_no     varchar(64) not null comment '工号',
    year       int         not null comment '年份',
    holiday    text null,
    uuid       varchar(45) null,
    created_at datetime null,
    constraint UIndex1
        unique (emp_no, year)
) comment '可休假汇总表' engine = MyISAM
    collate = utf8mb4_general_ci
    charset = utf8mb4;
create index Index1 on wx_all_holiday (emp_no, year);

-- auto-generated definition
create table wx_attendance_user_status
(
    id           int auto_increment
        primary key,
    company_id   int                       not null,
    emp_no       varchar(32)               not null comment '工号',
    month_no     varchar(32) default '0'   not null comment '月份',
    attendance   text                      null,
    status       tinyint     default 0     not null comment '0可确认1已确认 2已回传给hcp',
    result       tinyint                   not null comment '确认结果0没问题1.有问题',
    confirm_time datetime                  null comment '确认时间',
    note         text                      not null comment '说明',
    uuid         varchar(45) charset utf32 null,
    created_at   datetime                  not null,
    updated_at   datetime                  not null,
    constraint UIndex1
        unique (company_id, emp_no, month_no)
) comment '用户每月考勤确认状态表' engine = MyISAM
    collate = utf8mb4_general_ci
    charset = utf8mb4;
create index Index1 on wx_attendance_user_status (company_id, emp_no, month_no);


-- auto-generated definition
create table wx_config_code
(
    id           int         not null
        primary key,
    type         varchar(32) not null,
    code         varchar(32) not null,
    display_name varchar(64) not null comment '确认结果0没问题1.有问题',
    created_at   datetime    null,
    updated_at   datetime    null
) comment '用户每月考勤确认状态结果表' engine = MyISAM
    collate = utf8mb4_general_ci
    charset = utf8mb4;

-- auto-generated definition
create table wx_global_config
(
    id         int auto_increment
        primary key,
    type       varchar(20)                        not null,
    code       varchar(20)                        not null,
    value      varchar(100)                       not null,
    company_id varchar(50)                        not null,
    created_at datetime default CURRENT_TIMESTAMP null,
    updated_at datetime default CURRENT_TIMESTAMP null on update CURRENT_TIMESTAMP,
    uuid       varchar(45)                        null,
    constraint UIndex1
        unique (type, code)
) comment '全局配置表' engine = MyISAM
    collate = utf8mb4_general_ci
    charset = utf8mb4;


-- auto-generated definition
create table wx_holiday_detail
(
    id         int auto_increment
        primary key,
    company_id int         null,
    emp_no     varchar(64) null,
    month_no   varchar(32) null,
    detail     text        null,
    uuid       varchar(45) null,
    created_at datetime    null,
    constraint UIndex1
        unique (company_id, emp_no, month_no)
) comment '可休假明细表' engine = MyISAM
    collate = utf8mb4_general_ci
    charset = utf8mb4;
create index Index1 on wx_holiday_detail (company_id, emp_no, month_no);

-- auto-generated definition
create table wx_intermediate_table
(
    company_id int          null,
    table_name varchar(128) null,
    type       varchar(45)  null,
    uuid       varchar(45)  null,
    created_at datetime     null,
    updated_at datetime     null,
    col1       text         null,
    col2       text         null,
    col3       text         null,
    col4       text         null,
    col5       text         null,
    col6       text         null,
    col7       text         null,
    col8       text         null,
    col9       text         null,
    col10      text         null,
    col11      text         null,
    col12      text         null,
    col13      text         null,
    col14      text         null,
    col15      text         null,
    col16      mediumtext   null,
    col17      mediumtext   null,
    col18      mediumtext   null,
    col19      mediumtext   null,
    col20      mediumtext   null,
    constraint UIndex1
        unique (company_id, uuid)
) comment '同步数据中间表' engine = MyISAM
    collate = utf8mb4_general_ci
    charset = utf8mb4;
create index Index1 on wx_intermediate_table (company_id, uuid);

-- auto-generated definition
create table wx_leader_permission_list
(
    id          int auto_increment
        primary key,
    company_id  varchar(45)       not null,
    emp_no      varchar(45)       not null,
    lead_no     varchar(45)       not null,
    salary_auth tinyint default 0 not null,
    info_auth   tinyint default 0 not null,
    uuid        varchar(45)       null,
    created_at  date              null,
    updated_at  date              null,
    constraint UIndex1
        unique (company_id, emp_no, lead_no)
) comment '主管权限表' engine = MyISAM
    collate = utf8mb4_general_ci
    charset = utf8mb4;
create index Index1 on wx_leader_permission_list (company_id, emp_no, lead_no);

-- auto-generated definition
create table wx_personal_calendar_page
(
    id              int auto_increment
        primary key,
    company_id      varchar(45) not null,
    emp_no          varchar(45) not null,
    month_no        varchar(45) not null,
    emp_shift       text        null,
    emp_clock       text        null,
    emp_n_abs       text        null,
    emp_e_abs       text        null,
    emp_over        text        null,
    emp_n_abs_t     text        not null,
    emp_e_abs_t     text        not null,
    emp_over_t      text        not null,
    salary_time_sum text        not null,
    uuid            varchar(45) null,
    created_at      date        null,
    updated_at      date        null,
    constraint UIndex1
        unique (company_id, emp_no, month_no)
) comment '员工日历表' engine = MyISAM
    collate = utf8mb4_general_ci
    charset = utf8mb4;
create index Index1 on wx_personal_calendar_page (company_id, emp_no, month_no);

-- auto-generated definition
create table wx_personal_information_page
(
    id                     int auto_increment
        primary key,
    company_id             varchar(45)   not null,
    emp_no                 varchar(45)   not null,
    emp_name               varchar(1000) null,
    emp_indate             varchar(1000) null,
    emp_outdate            varchar(1000) null,
    emp_dept               varchar(1000) null,
    emp_edu                varchar(1000) null,
    emp_title              varchar(1000) null,
    emp_address            varchar(1000) null,
    emp_phone              varchar(1000) null,
    emp_emergencycontactor varchar(1000) null,
    emp_arg                text          null,
    emp_bank               text          null,
    emp_credentials        text          null,
    emp_career             text          null,
    uuid                   varchar(45)   null,
    created_at             timestamp     null,
    updated_at             timestamp     null,
    openid                 varchar(50)   null comment '微信ID',
    auth                   varchar(1000) null comment '授权信息',
    auth_at                datetime      null comment '授权时间',
    constraint UIndex1
        unique (company_id, emp_no)
) comment '员工信息表' engine = MyISAM
    collate = utf8mb4_general_ci
    charset = utf8mb4;
create index Index1 on wx_personal_information_page (company_id, emp_no);

-- auto-generated definition
create table wx_personal_pwd
(
    id         int auto_increment
        primary key,
    company_id varchar(45) not null,
    emp_no     varchar(45) not null,
    old_pwd    text        null,
    new_pwd    text        null,
    uuid       varchar(45) null,
    created_at date        null,
    updated_at date        null,
    constraint UIndex1
        unique (company_id, emp_no)
) comment '员工密码表' engine = MyISAM
    collate = utf8mb4_general_ci
    charset = utf8mb4;
create index Index1 on wx_personal_pwd (company_id, emp_no);

-- auto-generated definition
create table wx_personal_salary_page
(
    id                    int auto_increment
        primary key,
    company_id            varchar(45)             not null,
    emp_no                varchar(45)             not null,
    month_no              varchar(45)             not null,
    emp_pay_type          varchar(45) default '1' null comment '薪酬类别：1薪资，2为奖金',
    emp_salary            varchar(45)             not null,
    emp_salary_fix        text                    null,
    emp_salary_tax        text                    null,
    emp_salary_temp       text                    null,
    emp_salary_ov         text                    null,
    emp_salary_abs        text                    null,
    emp_salary_insure     text                    null,
    emp_salary_b          text                    null,
    emp_salary_bs         text                    null,
    emp_salary_tw         text                    null comment '台湾薪资特定模块',
    emp_salary_tw_bs      text                    null comment '台湾福利金',
    emp_salary_insure_cpy text                    null,
    uuid                  varchar(45)             null,
    created_at            date                    null,
    updated_at            date                    null,
    constraint UIndex1
        unique (company_id, emp_no, month_no, emp_pay_type)
) comment '员工薪资表' engine = MyISAM
    collate = utf8mb4_general_ci
    charset = utf8mb4;
create index Index1 on wx_personal_salary_page (company_id, emp_no, month_no, emp_pay_type);

-- auto-generated definition
create table wx_personal_salary_pwd
(
    id         int auto_increment
        primary key,
    company_id varchar(45) not null,
    emp_no     varchar(45) not null,
    pwd        text        null,
    created_at datetime    null,
    updated_at datetime    null
) comment '员工薪资密码表' engine = MyISAM
    collate = utf8mb4_general_ci
    charset = utf8mb4;
create index Index1 on wx_personal_salary_pwd (company_id, emp_no);

-- auto-generated definition
create table wx_personal_salaryp
(
    id            int auto_increment
        primary key,
    company_id    varchar(45) not null,
    emp_no        varchar(45) not null,
    validate_date varchar(45) not null,
    mapname       varchar(45) not null,
    amount        varchar(45) not null,
    uuid          varchar(45) null,
    created_at    date        null,
    updated_at    date        null,
    constraint UIdx1
        unique (company_id, emp_no, validate_date, mapname)
) comment '员工调薪历史表' engine = MyISAM
    collate = utf8mb4_general_ci
    charset = utf8mb4;

-- auto-generated definition
create table wx_pwd_rule
(
    id            int auto_increment
        primary key,
    company_id    varchar(45) not null,
    enable_rule   varchar(10) not null comment '是否启用密码管控',
    length_rule   varchar(10) null comment '是否启用长度管控',
    min_length    decimal null comment '最小长度',
    max_length    decimal null comment '最大长度',
    mixchar_rule  varchar(10) null comment '是否启用字符复制规则',
    numchar_rule  varchar(10) null comment '是否包含数字',
    uppchar_rule  varchar(10) null comment '是否包含大写字母',
    lowchar_rule  varchar(10) null comment '是否包含小写字母',
    sigchar_rule  varchar(10) null comment '是否包含符号',
    include_chars decimal null comment '最好需要包含几种',
    uuid          varchar(45) null,
    created_at    date null,
    updated_at    date null,
    constraint UIndex1
        unique (company_id)
) comment '密码复杂度类' engine = MyISAM
    collate = utf8mb4_general_ci
    charset = utf8mb4;


-- auto-generated definition
create table wx_verify_code
(
    id         int auto_increment
        primary key,
    company_id varchar(45) not null,
    iphone     varchar(45) not null,
    code       text        not null,
    created_at timestamp null,
    updated_at timestamp null,
    status     varchar(10) default '1' null comment '默认1未使用；0已使用',
    msg        text null comment '发送短信返回状态'
) comment '验证码类' engine = MyISAM
    collate = utf8mb4_general_ci
    charset = utf8mb4;
create index Index1 on wx_verify_code (iphone);

--
-- 触发器 `wx_personal_salary_page`
--
DELIMITER $$
CREATE TRIGGER `wx_personal_page_trg` BEFORE INSERT ON `wx_personal_salary_page`
    FOR EACH ROW BEGIN
    set  new.emp_salary= TO_BASE64(AES_ENCRYPT(new.emp_salary,'wechat'));
set  new.emp_salary_fix= TO_BASE64(AES_ENCRYPT(new.emp_salary_fix,'wechat'));
set  new.emp_salary_tax= TO_BASE64(AES_ENCRYPT(new.emp_salary_tax,'wechat'));
set  new.emp_salary_temp= TO_BASE64(AES_ENCRYPT(new.emp_salary_temp,'wechat'));
set  new.emp_salary_ov= TO_BASE64(AES_ENCRYPT(new.emp_salary_ov,'wechat'));
set  new.emp_salary_abs= TO_BASE64(AES_ENCRYPT(new.emp_salary_abs,'wechat'));
set  new.emp_salary_insure= TO_BASE64(AES_ENCRYPT(new.emp_salary_insure,'wechat'));
set  new.emp_salary_b= TO_BASE64(AES_ENCRYPT(new.emp_salary_b,'wechat'));
set  new.emp_salary_bs= TO_BASE64(AES_ENCRYPT(new.emp_salary_bs,'wechat'));
set  new.emp_salary_tw= TO_BASE64(AES_ENCRYPT(new.emp_salary_tw,'wechat'));
set  new.emp_salary_tw_bs= TO_BASE64(AES_ENCRYPT(new.emp_salary_tw_bs,'wechat'));
set  new.emp_salary_insure_cpy= TO_BASE64(AES_ENCRYPT(new.emp_salary_insure_cpy,'wechat'));

END
    $$
DELIMITER ;


--
-- 触发器 `wx_personal_pwd`
--
DELIMITER $$
CREATE TRIGGER `wx_personal_pwd_trg` BEFORE INSERT ON `wx_personal_pwd`
    FOR EACH ROW BEGIN
    set  new.old_pwd= TO_BASE64(AES_ENCRYPT(new.old_pwd,'wechat'));
	set  new.new_pwd= TO_BASE64(AES_ENCRYPT(new.new_pwd,'wechat'));
END
    $$
DELIMITER ;



-- update DDL
--alter table wx_personal_information_page add openid varchar(50) null comment '微信openid';
--alter table wx_personal_information_page add auth text null comment '授权信息';
--alter table wx_personal_information_page add auth_at datetime null comment '授权时间';

-- 删除DDL 需要手动执行
--drop table wx_all_holiday;
--drop table wx_attendance_user_status;
--drop table wx_config_code;
--drop table wx_holiday_detail;
--drop table wx_intermediate_table;
--drop table wx_leader_permission_list;
--drop table wx_personal_calendar_page;
--drop table wx_personal_information_page;
--drop table wx_personal_pwd;
--drop table wx_personal_salary_page;
--drop table wx_personal_salary_pwd;
--drop table wx_personal_salaryp;
--drop table wx_verify_code;

