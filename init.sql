alter table wx_personal_information_page
    add openid varchar(50) null comment '微信openid';

alter table wx_personal_information_page
    add auth text null comment '授权信息';

alter table wx_personal_information_page
    add auth_at datetime null comment '授权时间';

