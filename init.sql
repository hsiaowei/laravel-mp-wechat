-- 初始化数据

--wx_pwd_rule
INSERT INTO wx_pwd_rule (id, company_id, enable_rule, length_rule, min_length, max_length, mixchar_rule, numchar_rule, uppchar_rule, lowchar_rule, sigchar_rule, include_chars, uuid, created_at, updated_at) VALUES (3, '7', '1', '1', 6, 10, '1', '1', '1', '1', '0', 2, '278315b0-1ddb-11ed-b21a-b738f203445c', '2022-08-17', null);

--wx_config_code
INSERT INTO wx_config_code (id, type, code, display_name, created_at, updated_at) VALUES (1, 'attendance', 'h001', '正班应勤时数', '2019-04-08 15:13:13', '2019-04-08 00:00:22');
INSERT INTO wx_config_code (id, type, code, display_name, created_at, updated_at) VALUES (2, 'attendance', 'h002', '实际月总出勤时数', '2019-04-08 15:15:58', '2019-04-08 15:16:01');
INSERT INTO wx_config_code (id, type, code, display_name, created_at, updated_at) VALUES (3, 'attendance', 'h003', '实际正班时数', null, null);
INSERT INTO wx_config_code (id, type, code, display_name, created_at, updated_at) VALUES (4, 'attendance', 'h004', '当月总加班时数', null, null);
INSERT INTO wx_config_code (id, type, code, display_name, created_at, updated_at) VALUES (5, 'attendance', 'h005', '病假时数', null, null);
INSERT INTO wx_config_code (id, type, code, display_name, created_at, updated_at) VALUES (6, 'attendance', 'h006', '事假时数', null, null);
INSERT INTO wx_config_code (id, type, code, display_name, created_at, updated_at) VALUES (7, 'attendance', 'h007', '当月缺勤时数', null, null);
INSERT INTO wx_config_code (id, type, code, display_name, created_at, updated_at) VALUES (8, 'attendance', 'h008', '旷工时数', null, null);
INSERT INTO wx_config_code (id, type, code, display_name, created_at, updated_at) VALUES (9, 'attendance', 'h009', '平时加班费', null, null);
INSERT INTO wx_config_code (id, type, code, display_name, created_at, updated_at) VALUES (10, 'attendance', 'h010', '周休加班费', null, null);
INSERT INTO wx_config_code (id, type, code, display_name, created_at, updated_at) VALUES (11, 'attendance', 'h011', '法定加班费', null, null);
INSERT INTO wx_config_code (id, type, code, display_name, created_at, updated_at) VALUES (12, 'attendance', 'h012', '当月合计加班费', null, null);
INSERT INTO wx_config_code (id, type, code, display_name, created_at, updated_at) VALUES (13, 'attendance', 'h013', '平时加班工时', null, null);
INSERT INTO wx_config_code (id, type, code, display_name, created_at, updated_at) VALUES (14, 'attendance', 'h014', '周末加班工时', null, null);
INSERT INTO wx_config_code (id, type, code, display_name, created_at, updated_at) VALUES (15, 'attendance', 'h015', '法定加班工时', null, null);


--测试数据
--wx_all_holiday
INSERT INTO wx_all_holiday (id, company_id, emp_no, year, holiday, uuid, created_at) VALUES (1, 7, 'ARESSZ327', 2021, '{"year":{"title":"年假","surplus":"56小时","list":["当年时数:80小时","递延时数:58小时","已休时数:48小时","失效时数:34小时","失效日期:03\\/31"]},"Seniority":{"title":"年资假","surplus":"0小时","list":["当年时数:0小时","递延时数:120小时","已休时数:0小时","失效时数:120小时","失效日期:03\\/31"]},"exchange":{"title":"补休假","surplus":"0小时","list":["已休时数:0小时"]}}', '1713b920-f072-11ec-a5f3-1fc706e0f992', '2022-06-20 16:22:14');
INSERT INTO wx_all_holiday (id, company_id, emp_no, year, holiday, uuid, created_at) VALUES (2, 7, 'ARESSZ327', 2022, '{"year":{"title":"年假","surplus":"56小时","list":["当年时数:80小时","递延时数:58小时","已休时数:48小时","失效时数:34小时","失效日期:03\\/31"]},"Seniority":{"title":"年资假","surplus":"22小时","list":["当年时数:80小时","递延时数:58小时","已休时数:48小时","失效时数:34小时","失效日期:03\\/31"]},"exchange":{"title":"补休假","surplus":"10小时","list":["当年时数:80小时","递延时数:58小时","已休时数:48小时","失效时数:34小时","失效日期:03\\/31"]}}', '9431e180-f072-11ec-8010-cbbb2fca8ea1', '2022-06-20 16:25:44');
INSERT INTO wx_all_holiday (id, company_id, emp_no, year, holiday, uuid, created_at) VALUES (3, 7, 'ARESSZ327', 2023, '{"year":{"title":"年假","surplus":"0小时","list":["当年时数:0小时","递延时数:0小时","已休时数:0小时"]},"exchange":{"title":"补休假","surplus":"0小时","list":["已休时数:0小时"]}}', '6fe3f7f0-a66c-11ed-bc75-0d720a77d968', '2023-02-07 06:20:18');

--wx_attendance_user_status
INSERT INTO wx_attendance_user_status (id, company_id, emp_no, month_no, attendance, status, result, confirm_time, note, uuid, created_at, updated_at) VALUES (1, 7, 'ARESSZ325', '2019-04', '{"h001":"248","h002":"236.72","h003":"293.89","h004":"15.17","h005":"42","h006":"0","h007":"57.17","h008":"0","h009":"0","h010":"0","h011":"0","h012":"224.9345","h013":"830.3448","h014":"0","h015":"1055.2793"}', 1, 0, '2019-05-06 11:12:51', '', 'c6f6a300-33f1-11e8-9651-5b2cd48e7cb7', '2019-04-26 00:00:00', '2019-05-06 11:12:51');
INSERT INTO wx_attendance_user_status (id, company_id, emp_no, month_no, attendance, status, result, confirm_time, note, uuid, created_at, updated_at) VALUES (2, 7, 'ARESSZ325', '2019-05', '{"h001":"248","h002":"236.72","h003":"293.89","h004":"15.17","h005":"42","h006":"0","h007":"57.17","h008":"0","h009":"0","h010":"0","h011":"0","h012":"224.9345","h013":"830.3448","h014":"0","h015":"1055.2793"}', 0, 0, '2019-05-06 11:12:51', '', 'c6f6a300-33f1-11e8-9651-5b2cd48e7cb7', '2019-04-26 00:00:00', '2019-05-06 11:12:51');
INSERT INTO wx_attendance_user_status (id, company_id, emp_no, month_no, attendance, status, result, confirm_time, note, uuid, created_at, updated_at) VALUES (3, 7, 'ARESSZ325', '2019-06', '{"h001":"248","h002":"236.72","h003":"293.89","h004":"15.17","h005":"42","h006":"0","h007":"57.17","h008":"0","h009":"0","h010":"0","h011":"0","h012":"224.9345","h013":"830.3448","h014":"0","h015":"1055.2793"}', 0, 0, null, '', 'c6f6a300-33f1-11e8-9651-5b2cd48e7cb7', '2019-04-26 00:00:00', '2019-05-06 11:12:51');
INSERT INTO wx_attendance_user_status (id, company_id, emp_no, month_no, attendance, status, result, confirm_time, note, uuid, created_at, updated_at) VALUES (4, 7, 'ARESSZ325', '2019-07', '{"h001":"168h","h002":"225.17h","h003":"168h","h004":"57.17h","h005":"0h","h006":"0h","h007":"0h","h008":"0h","h009":"224.9345","h010":"830.3448","h011":"0","h012":"1055.2793","h013":"15.17h","h014":"42h","h015":"0h"}', 0, 0, null, '', 'c6f6a300-33f1-11e8-9651-5b2cd48e7cb7', '2019-04-26 00:00:00', '2019-05-06 11:12:51');
INSERT INTO wx_attendance_user_status (id, company_id, emp_no, month_no, attendance, status, result, confirm_time, note, uuid, created_at, updated_at) VALUES (5, 7, 'ARESSZ325', '2019-03', '{"h001":"168h","h002":"244h","h003":"168h","h004":"76h","h005":"0h","h006":"0h","h007":"0h","h008":"0h","h009":"533.7931","h010":"790.8046","h011":"0","h012":"1324.5977","h013":"36h","h014":"40h","h015":"0h"}', 2, 0, '2019-05-06 11:12:51', '', 'c6f6a300-33f1-11e8-9651-5b2cd48e7cb7', '2019-04-26 00:00:00', '2019-05-06 11:12:51');
INSERT INTO wx_attendance_user_status (id, company_id, emp_no, month_no, attendance, status, result, confirm_time, note, uuid, created_at, updated_at) VALUES (6, 7, 'ARESSZ325', '2022-02', '{"h001":"168h","h002":"261.17h","h003":"164h","h004":"97.17h","h005":"0h","h006":"0h","h007":"0h","h008":"0h","h009":"889.6552","h010":"734.8552","h011":"0","h012":"1624.5103","h013":"60h","h014":"37.17h","h015":"0h"}', 2, 0, '2019-05-06 11:12:51', '', 'c6f6a300-33f1-11e8-9651-5b2cd48e7cb7', '2019-04-26 00:00:00', '2019-05-06 11:12:51');
INSERT INTO wx_attendance_user_status (id, company_id, emp_no, month_no, attendance, status, result, confirm_time, note, uuid, created_at, updated_at) VALUES (7, 7, 'ARESSZ325', '2019-01', '{"h001":"168h","h002":"260h","h003":"168h","h004":"92h","h005":"0h","h006":"0h","h007":"0h","h008":"0h","h009":"622.7586","h010":"988.5057","h011":"0","h012":"1611.2644","h013":"42h","h014":"50h","h015":"0h"}', 2, 0, '2019-05-06 11:12:51', '', 'c6f6a300-33f1-11e8-9651-5b2cd48e7cb7', '2019-04-26 00:00:00', '2019-05-06 11:12:51');

--wx_holiday_detail
INSERT INTO wx_holiday_detail (id, company_id, emp_no, month_no, detail, uuid, created_at) VALUES (2, 7, 'ARESSZ327', '2019-02', '{"year":{"head":"年假","detail":[{"title":"年假","list":[{"date":"05\\/27","time":"08:10-09:00","duration":"1h"},{"date":"06\\/14","time":"08:10-17:10","duration":"8h"}]}]},"exchange":{"head":"补休","detail":[{"title":"加班(补休)","list":[{"date":"06\\/22","time":"08:10-17:10","duration":"7.5h"}]},{"title":"已补休","list":[{"date":"06\\/18","time":"08:10-09:10","duration":"1h"},{"date":"06\\/21","time":"08:10-11:10","duration":"3h"}]}]}}', null, '2019-06-21 00:00:00');
INSERT INTO wx_holiday_detail (id, company_id, emp_no, month_no, detail, uuid, created_at) VALUES (3, 7, 'ARESSZ327', '2020-03', '{"year":{"head":"年假","detail":[{"title":"年假","list":[{"date":"05\\/27","time":"08:10-09:00","duration":"1h"},{"date":"06\\/14","time":"08:10-17:10","duration":"8h"}]}]},"exchange":{"head":"补休","detail":[{"title":"加班(补休)","list":[{"date":"06\\/22","time":"08:10-17:10","duration":"7.5h"}]},{"title":"已补休","list":[{"date":"06\\/18","time":"08:10-09:10","duration":"1h"},{"date":"06\\/21","time":"08:10-11:10","duration":"3h"}]}]}}', null, '2019-06-21 00:00:00');
INSERT INTO wx_holiday_detail (id, company_id, emp_no, month_no, detail, uuid, created_at) VALUES (7, 7, 'ARESSZ327', '2022-04', '{"year":{"head":"年假","detail":[{"title":"已休年资假","list":[{"date":"06\\/06","time":"08:00-17:00","duration":"8小时"},{"date":"06\\/07","time":"08:00-17:00","duration":"8小时"}]}]},"Seniority":{"head":"年资假","detail":[{"title":"已休年资假","list":[{"date":"06\\/20","time":"08:00-17:00","duration":"8小时"},{"date":"06\\/23","time":"08:00-17:00","duration":"8小时"},{"date":"06\\/08","time":"08:00-17:00","duration":"8小时"}]}]},"exchange":{"head":"补休","detail":[{"title":"加班（补休）","list":[]},{"title":"已补休","list":[]}]}}', 'a00acbe0-f074-11ec-856d-e9976b543549', '2022-06-20 16:40:23');
INSERT INTO wx_holiday_detail (id, company_id, emp_no, month_no, detail, uuid, created_at) VALUES (8, 28, 'ARESSZ327', '2022-05', '{"year":{"head":"年假","detail":[{"title":"已休年假","list":[{"date":"06\\/01","time":"08:00-17:00","duration":"8小时"}]}]},"Seniority":{"head":"年资假","detail":[{"title":"已休年资假","list":[{"date":"06\\/06","time":"08:00-17:00","duration":"8小时"},{"date":"06\\/07","time":"08:00-17:00","duration":"8小时"},{"date":"06\\/08","time":"08:00-17:00","duration":"8小时"}]}]},"exchange":{"head":"补休","detail":[{"title":"加班（补休）","list":[{"date":"06\\/20","time":"08:00-17:00","duration":"8小时"}]},{"title":"已补休","list":[{"date":"06\\/22","time":"08:00-17:00","duration":"8小时"},{"date":"06\\/23","time":"08:00-17:00","duration":"8小时"}]}]}}', '4c4ecc00-f075-11ec-a9a9-d5acc736c818', '2022-06-20 16:45:12');
INSERT INTO wx_holiday_detail (id, company_id, emp_no, month_no, detail, uuid, created_at) VALUES (10, 7, 'ARESSZ327', '2022-06', '{"year":{"head":"年假","detail":[{"title":"已休年假","list":[{"date":"05\\/30","time":"08:00-17:00","duration":"8小时"},{"date":"05\\/31","time":"08:00-17:00","duration":"8小时"},{"date":"06\\/15","time":"12:00-17:00","duration":"4小时"},{"date":"06\\/16","time":"08:00-17:00","duration":"8小时"},{"date":"06\\/17","time":"08:00-17:00","duration":"8小时"}]}]},"Seniority":{"head":"年资假","detail":[{"title":"已休年资假","list":[{"date":"06\\/06","time":"08:00-17:00","duration":"8小时"},{"date":"06\\/07","time":"08:00-17:00","duration":"8小时"},{"date":"06\\/08","time":"08:00-17:00","duration":"8小时"}]}]},"exchange":{"head":"补休","detail":[{"title":"加班（补休）","list":[{"date":"06\\/10","time":"08:00-10:00","duration":"2小时"}]},{"title":"已补休","list":[{"date":"06\\/13","time":"08:00-10:00","duration":"2小时"},{"date":"06\\/13","time":"16:00-17:00","duration":"1小时"},{"date":"06\\/09","time":"08:00-09:00","duration":"1小时"}]}]}}', 'e2e039f0-f07c-11ec-89a5-87d3e7943582', '2022-06-20 17:39:31');
INSERT INTO wx_holiday_detail (id, company_id, emp_no, month_no, detail, uuid, created_at) VALUES (11, 7, 'ARESSZ327', '2023-01', '{"year":{"head":"年假","detail":[{"title":"已休年假","list":[]}]},"exchange":{"head":"补休","detail":[{"title":"加班（补休）","list":[]},{"title":"已补休","list":[]}]}}', '23f6e180-a0ec-11ed-a05d-4b50f4b6d093', '2023-01-31 06:19:19');
INSERT INTO wx_holiday_detail (id, company_id, emp_no, month_no, detail, uuid, created_at) VALUES (12, 7, 'ARESSZ327', '2023-02', '{"year":{"head":"年假","detail":[{"title":"已休年假","list":[]}]},"exchange":{"head":"补休","detail":[{"title":"加班（补休）","list":[]},{"title":"已补休","list":[]}]}}', '7373f870-a66c-11ed-a319-f332d80384b7', '2023-02-07 06:20:24');

--wx_leader_permission_list
INSERT INTO wx_leader_permission_list (id, company_id, emp_no, lead_no, salary_auth, info_auth, uuid, created_at, updated_at) VALUES (6883, '7', 'ARESSZ327', 'ARESSZ327', 0, 0, '3930ac30-3afb-11e8-b0ba-d76e5131dc83', '2018-04-08', null);
INSERT INTO wx_leader_permission_list (id, company_id, emp_no, lead_no, salary_auth, info_auth, uuid, created_at, updated_at) VALUES (6873, '7', '1129589', 'ARESSZ327', 0, 0, '3930ac30-3afb-11e8-b0ba-d76e5131dc83', '2018-04-08', null);
INSERT INTO wx_leader_permission_list (id, company_id, emp_no, lead_no, salary_auth, info_auth, uuid, created_at, updated_at) VALUES (6882, '7', '1220220', 'ARESSZ327', 0, 0, '3930ac30-3afb-11e8-b0ba-d76e5131dc83', '2018-04-08', null);
INSERT INTO wx_leader_permission_list (id, company_id, emp_no, lead_no, salary_auth, info_auth, uuid, created_at, updated_at) VALUES (6880, '7', '1220667', 'ARESSZ327', 0, 0, '3930ac30-3afb-11e8-b0ba-d76e5131dc83', '2018-04-08', null);

--wx_personal_calendar_page
INSERT INTO wx_personal_calendar_page (id, company_id, emp_no, month_no, emp_shift, emp_clock, emp_n_abs, emp_e_abs, emp_over, emp_n_abs_t, emp_e_abs_t, emp_over_t, salary_time_sum, uuid, created_at, updated_at) VALUES (22722, '7', 'ARESSZ325', '2021/04', '[{
	"cday": "04\\/01",
	"intime": "01 08:00",
	"outtime": "01 16:00",
	"shiftname": "大白班",
	"hour": "8"
}, {
	"cday": "04\\/02",
	"intime": "02 08:00",
	"outtime": "02 16:00",
	"shiftname": "大白班",
	"hour": "8"
}, {
	"cday": "04\\/03",
	"intime": "03 08:00",
	"outtime": "03 16:00",
	"shiftname": "大白班",
	"hour": "8"
}, {
	"cday": "04\\/04",
	"intime": "04 20:00",
	"outtime": "05 04:00",
	"shiftname": "大夜班",
	"hour": "8"
}, {
	"cday": "04\\/05",
	"intime": "05 20:00",
	"outtime": "06 04:00",
	"shiftname": "大夜班",
	"hour": "8"
}, {
	"cday": "04\\/06",
	"intime": "06 20:00",
	"outtime": "07 04:00",
	"shiftname": "大夜班",
	"hour": "8"
}, {
	"cday": "04\\/07",
	"intime": "07 08:00",
	"outtime": "07 16:00",
	"shiftname": "大白班",
	"hour": "8"
}, {
	"cday": "04\\/08",
	"intime": "08 08:00",
	"outtime": "08 16:00",
	"shiftname": "大白班",
	"hour": "8"
}, {
	"cday": "04\\/09",
	"intime": "09 08:00",
	"outtime": "09 16:00",
	"shiftname": "大白班",
	"hour": "8"
}, {
	"cday": "04\\/10",
	"intime": "10 08:00",
	"outtime": "10 16:00",
	"shiftname": "大白班",
"type": "N",
	"hour": "8"
}, {
	"cday": "04\\/11",
	"intime": "11 08:00",
	"outtime": "11 16:00",
	"shiftname": "大白班",
	"hour": "8"
}, {
	"cday": "04\\/12",
	"intime": "12 08:00",
	"outtime": "12 16:00",
	"shiftname": "大白班",
	"hour": "8"
}, {
	"cday": "04\\/13",
	"intime": "13 08:00",
	"outtime": "13 16:00",
	"shiftname": "大白班",
	"hour": "8"
}, {
	"cday": "04\\/14",
	"intime": "14 08:00",
	"outtime": "14 16:00",
	"shiftname": "大白班",
	"hour": "8"
}, {
	"cday": "04\\/15",
	"intime": "15 08:00",
	"outtime": "15 16:00",
	"shiftname": "大白班",
	"hour": "8"
}, {
	"cday": "04\\/16",
	"intime": "16 08:00",
	"outtime": "16 16:00",
	"shiftname": "大白班",
	"hour": "8"
}, {
	"cday": "04\\/17",
	"intime": "17 20:00",
	"outtime": "18 04:00",
	"shiftname": "大夜班",
	"hour": "8"
}, {
	"cday": "04\\/18",
	"intime": "18 20:00",
	"outtime": "19 04:00",
	"shiftname": "大夜班",
	"hour": "8"
}, {
	"cday": "04\\/19",
	"intime": "19 20:00",
	"outtime": "20 04:00",
	"shiftname": "大夜班",
	"hour": "8"
}, {
	"cday": "04\\/20",
	"intime": "20 20:00",
	"outtime": "21 04:00",
	"shiftname": "大夜班",
	"hour": "8"
}, {
	"cday": "04\\/21",
	"intime": "21 20:00",
	"outtime": "22 04:00",
	"shiftname": "大夜班",
	"hour": "8"
}, {
	"cday": "04\\/22",
	"intime": "22 20:00",
	"outtime": "23 04:00",
	"shiftname": "大夜班",
	"hour": "8"
}, {
	"cday": "04\\/23",
	"intime": "23 20:00",
	"outtime": "24 04:00",
	"shiftname": "大夜班",
	"hour": "8"
}, {
	"cday": "04\\/24",
	"intime": "24 20:00",
	"outtime": "25 04:00",
	"shiftname": "大夜班",
	"hour": "8"
}, {
	"cday": "04\\/25",
	"intime": "25 20:00",
	"outtime": "26 04:00",
	"shiftname": "大夜班",
	"hour": "8"
}, {
	"cday": "04\\/26",
	"intime": "26 20:00",
	"outtime": "27 04:00",
	"shiftname": "大夜班",
	"hour": "8"
}, {
	"cday": "04\\/27",
	"intime": "27 20:00",
	"outtime": "28 04:00",
	"shiftname": "大夜班",
	"hour": "8"
}, {
	"cday": "04\\/28",
	"intime": "28 20:00",
	"outtime": "29 04:00",
	"shiftname": "大夜班",
	"hour": "8"
}, {
	"cday": "04\\/29",
	"intime": "29 20:00",
	"outtime": "30 04:00",
	"shiftname": "大夜班",
	"hour": "8"
}, {
	"cday": "04\\/30",
	"intime": "30 08:00",
	"outtime": "30 16:00",
	"shiftname": "大白班",
	"hour": "8"
}]', '[{"cday":"04\\/02","clock":"2 07:22\\/2 16:57"},{"cday":"04\\/03","clock":"03 07:33\\/14 16:47"},{"cday":"01\\/13","clock":"13 07:35\\/13 16:45"},{"cday":"01\\/12","clock":"12 07:16\\/12 16:48"},{"cday":"01\\/11","clock":"\\/"},{"cday":"01\\/10","clock":"10 07:56\\/10 16:49"},{"cday":"01\\/09","clock":"09 07:29\\/09 16:47"},{"cday":"01\\/08","clock":"08 07:32\\/08 16:48"},{"cday":"01\\/07","clock":"\\/"},{"cday":"01\\/06","clock":"\\/"},{"cday":"01\\/05","clock":"\\/"},{"cday":"01\\/04","clock":"04 07:33\\/04 16:48"},{"cday":"01\\/03","clock":"03 08:37\\/03 16:45"},{"cday":"01\\/02","clock":"\\/"}]', '[{"cday":"04\\/02","absname":"年假","btime":"02 14:40","etime":"02 17:27","hour":"3"},{"cday":"04\\/08","absname":"年假","btime":"08 08:10","etime":"08 13:00","hour":"4"},{"cday":"04\\/09","absname":"年假","btime":"09 08:10","etime":"09 13:00","hour":"4"},{"cday":"04\\/10","absname":"年假","btime":"10 08:10","etime":"10 13:00","hour":"4"},{"cday":"04\\/11","absname":"年假","btime":"11 08:10","etime":"11 13:00","hour":"4"},{"cday":"04\\/12","absname":"年假","btime":"12 08:10","etime":"12 13:00","hour":"4"},{"cday":"04\\/15","absname":"年假","btime":"15 08:10","etime":"15 13:00","hour":"4"},{"cday":"04\\/16","absname":"年假","btime":"16 08:10","etime":"16 13:00","hour":"4"},{"cday":"04\\/16","absname":"抵用补休","btime":"16 13:00","etime":"16 14:30","hour":"1.5"}]', '[{"cday":"04\\/15","absname":"旷工","btime":"15 13:00","etime":"15 17:10","hour":"4"}]', '[{"cday":"04\\/20","btime":"20 08:40","etime":"20 20:40","ovtype":"S","hour":"0"},{"cday":"04\\/19","btime":"19 17:40","etime":"19 18:40","ovtype":"N","hour":"1"},{"cday":"04\\/17","btime":"17 17:40","etime":"17 20:30","ovtype":"N","hour":"2.5"},{"cday":"04\\/13","btime":"13 08:40","etime":"13 19:40","ovtype":"S","hour":"7.5"},{"cday":"04\\/10","btime":"10 17:40","etime":"10 18:10","ovtype":"N","hour":".5"},{"cday":"04\\/03","btime":"03 17:40","etime":"03 21:00","ovtype":"N","hour":"3"}]', '[{"cday":"04\\/02","absname":"年假","btime":"02 14:40","etime":"02 17:27","hour":"3"},{"cday":"04\\/08","absname":"年假","btime":"08 08:10","etime":"08 13:00","hour":"4"},{"cday":"04\\/09","absname":"年假","btime":"09 08:10","etime":"09 13:00","hour":"4"},{"cday":"04\\/10","absname":"年假","btime":"10 08:10","etime":"10 13:00","hour":"4"},{"cday":"04\\/11","absname":"年假","btime":"11 08:10","etime":"11 13:00","hour":"4"},{"cday":"04\\/12","absname":"年假","btime":"12 08:10","etime":"12 13:00","hour":"4"},{"cday":"04\\/15","absname":"年假","btime":"15 08:10","etime":"15 13:00","hour":"4"},{"cday":"04\\/16","absname":"年假","btime":"16 08:10","etime":"16 13:00","hour":"4"},{"cday":"04\\/16","absname":"抵用补休","btime":"16 13:00","etime":"16 14:30","hour":"1.5"}]', '[{"cday":"03\\/29","absname":"旷工","btime":"29 08:28","etime":"29 17:10","hour":"8"},{"cday":"04\\/15","absname":"旷工","btime":"15 13:00","etime":"15 17:10","hour":"4"}]', '[{"cday":"04\\/20","btime":"20 08:40","etime":"20 20:40","ovtype":"S","hour":"0"},{"cday":"04\\/19","btime":"19 17:40","etime":"19 18:40","ovtype":"N","hour":"1"},{"cday":"04\\/17","btime":"17 17:40","etime":"17 20:30","ovtype":"N","hour":"2.5"},{"cday":"04\\/13","btime":"13 08:40","etime":"13 19:40","ovtype":"S","hour":"7.5"},{"cday":"04\\/10","btime":"10 17:40","etime":"10 18:10","ovtype":"N","hour":".5"},{"cday":"04\\/03","btime":"03 17:40","etime":"03 21:00","ovtype":"N","hour":"3"},{"cday":"03\\/27","btime":"27 17:40","etime":"27 21:10","ovtype":"N","hour":"3.5"},{"cday":"03\\/25","btime":"25 17:40","etime":"25 20:40","ovtype":"N","hour":"2"}]', '{"sign_info":{"sum_hours":"12","details":[{"type":"旷工","hours":"12"}]},"leave_info":{"sum_hours":"32.5","details":[{"type":"年假","hours":"31"},{"type":"抵用补休","hours":"1.5"}]},"over_info":{"sum_hours":"20","details":[{"type":"S","hours":"7.5"},{"type":"N","hours":"12.5"}]}}', '9ef851b0-33f1-11e8-9839-41b50309e3f4', '2018-03-30', null);

--wx_personal_information_page
INSERT INTO wx_personal_information_page (id, company_id, emp_no, emp_name, emp_indate, emp_outdate, emp_dept, emp_edu, emp_title, emp_address, emp_phone, emp_emergencycontactor, emp_arg, emp_bank, emp_credentials, emp_career, uuid, created_at, updated_at, openid, auth, auth_at) VALUES (6789, '7', 'ARESSZ327', 'Hsiaowei', '2005/05/30', '', '100000总经理', '[]', '部长', '江苏省江都市武坚镇花南村双桥组68号', '13812652676', '张维芳13776066806', '[{"agrbegin":"2014\\/10\\/27","agrend":"2017\\/11\\/26","agrtype":"勞動合同","agr_period":"3"}]', '[{"bankname":"1. 中央信託","bankaccount":"1111111111111327"}]', '[{"credentialstype":"身份证","credentialsno":"41152419930805410X"}]', '[{"companyname":"勿动：资通测试环境FOR TSMC","jobtitle":"部长","begindate":"2005\\/05\\/30","enddate":""}]', '807e68c0-211c-11e8-ba62-e1ce65477b9a', '2018-03-06 00:00:00', '2023-03-10 10:12:40', 'o7Jpk6Dqi-iH3gXIK3oy8LWqZeno', '{"id":"o7Jpk6Dqi-iH3gXIK3oy8LWqZeno","name":"Hsiaowei","nickname":"Hsiaowei","avatar":"https:\\/\\/thirdwx.qlogo.cn\\/mmopen\\/vi_32\\/Q0j4TwGTfTLJ84aH6UMJBe4QTSYzPrA9IFA2nC7ibkib6czcbuagQ5A6bFAlP1NepJ6iaVFE3IMmFUHoU18lhuu5w\\/132","email":null,"original":{"openid":"o7Jpk6Dqi-iH3gXIK3oy8LWqZeno","nickname":"Hsiaowei","sex":0,"language":"","city":"","province":"","country":"","headimgurl":"https:\\/\\/thirdwx.qlogo.cn\\/mmopen\\/vi_32\\/Q0j4TwGTfTLJ84aH6UMJBe4QTSYzPrA9IFA2nC7ibkib6czcbuagQ5A6bFAlP1NepJ6iaVFE3IMmFUHoU18lhuu5w\\/132","privilege":[]},"token":"66_ey1kdkzltYnR4uUtDRANocvffr-UK8FyceGqArzEufCPt_5r9n5IlHBkR4zoBggUDajEp9xn0Gvn_eXk02QJ2vYuOUk0zEwt4JLQuk78pkM","access_token":"66_ey1kdkzltYnR4uUtDRANocvffr-UK8FyceGqArzEufCPt_5r9n5IlHBkR4zoBggUDajEp9xn0Gvn_eXk02QJ2vYuOUk0zEwt4JLQuk78pkM","refresh_token":"66_2CNtw2iZFuPB_4WfQio_pl9E6TPkj_5QFKzp2RR8NDh2Xl5sn_hJReqcMwtDsSCjTKP_0UnFSsp_T4TFSIo33XJI4IraXxPWlCAYGnlEZfE","provider":"WeChat"}', '2023-03-10 10:12:40');

--wx_personal_pwd
INSERT INTO wx_personal_pwd (id, company_id, emp_no, old_pwd, new_pwd, uuid, created_at, updated_at) VALUES (6693, '7', 'ARESSZ325', 'viX2FzW3C7f4I8e+sG0Dcg==', 'CgfP+99n9HyHK59vzZ4HLQ==', '43a523d0-37ad-11e8-9a2d-a11bc6f76260', '2018-04-04', null);

--wx_personal_salary_page
INSERT INTO wx_personal_salary_page (id, company_id, emp_no, month_no, emp_pay_type, emp_salary, emp_salary_fix, emp_salary_tax, emp_salary_temp, emp_salary_ov, emp_salary_abs, emp_salary_insure, emp_salary_b, emp_salary_bs, emp_salary_tw, emp_salary_tw_bs, emp_salary_insure_cpy, uuid, created_at, updated_at) VALUES (44, '7', 'ARESSZ327', '2022/11', '1', 'c5ISYBVaQhjLl2ZXftGqcw==', null, 'TgaBPGrrIl4D4ECkUJ5qCAgF8+LkvstGgMZEFvyj5EiDirq3SLNzClVwqBupkLX6gSjH+LLoMwke
CUfCsQ+ynJgAkg4RnDwNtJ9PoijdITI=', null, null, null, null, null, 'TgaBPGrrIl4D4ECkUJ5qCAgF8+LkvstGgMZEFvyj5EgT5nGALfGXUw5UA8xuIBjqWG15bi7dy6+X
78UoIlbqanmEYP8NsDLgQKmThKNkXRI=', null, null, 'TgaBPGrrIl4D4ECkUJ5qCEEREFSHwkubzN4qDaCrebTcdTbGzTdFEkKUnBB04p7W/iJ4AAxi6rhw
Td2r67KE/3mEYP8NsDLgQKmThKNkXRI=', 'b8a2b950-799b-11ec-9428-3b2f803e4e0e', '2022-01-20', null);
INSERT INTO wx_personal_salary_page (id, company_id, emp_no, month_no, emp_pay_type, emp_salary, emp_salary_fix, emp_salary_tax, emp_salary_temp, emp_salary_ov, emp_salary_abs, emp_salary_insure, emp_salary_b, emp_salary_bs, emp_salary_tw, emp_salary_tw_bs, emp_salary_insure_cpy, uuid, created_at, updated_at) VALUES (45, '7', 'ARESSZ327', '2022/12', '1', '0lYYGh8Y9LdJk7iCe5nqyw==', 'TgaBPGrrIl4D4ECkUJ5qCEEREFSHwkubzN4qDaCrebTcdTbGzTdFEkKUnBB04p7WKrZXHK2a+ajP
fhYU9Hy6WXJP87lGJIOizw47kOMi3xc=', 'TgaBPGrrIl4D4ECkUJ5qCNurZauQOV7qc7RGikc6lcWGiUiUymvKkNPiPbAa04n0', '/HDbHgNOY0EcZ2ZqLZfBTw==', '/HDbHgNOY0EcZ2ZqLZfBTw==', '/HDbHgNOY0EcZ2ZqLZfBTw==', 'TgaBPGrrIl4D4ECkUJ5qCCEnjGm14xtLUY2faRY25TPUDnryTp759p32WFKd1+J7EU24dlsccBBv
FHj3UDGK2mJQBVfCsNxKYEVfcbTR0f2jxSGcNNYWJNIc7shv3TckR/DduYw96UnvPtOrmUUNdNjT
mDr5CIF+HOiMHXgyhhyeOQy6yLsbw8lmneeoemjZBF2huKVesJlda7PVh51SK+fCPn0+dwfgauAf
PSCCqpQr4S40lmQqpWQ4wEWERmdKV6pjWu19ef+Ve23wWdLjTl+Fj3pnM8YwAXfli1n/K4SpfQ/e
rFl5Ufc5dUDSMNPSxYqJzsfjlST3Wn7KB1oT+bUuiKeEJI46ZIFfUqcwYwbt1yobOqBlUHhiA1E9
ZX35MYLjzSXFID7xZnDvVL/jaqS+RJz2SqZ2Zl8OQeMl6UpyT/O5RiSDos8OO5DjIt8X', '/HDbHgNOY0EcZ2ZqLZfBTw==', null, null, null, null, 'b8a2b950-799b-11ec-9428-3b2f803e4e0e', '2022-01-20', null);
INSERT INTO wx_personal_salary_page (id, company_id, emp_no, month_no, emp_pay_type, emp_salary, emp_salary_fix, emp_salary_tax, emp_salary_temp, emp_salary_ov, emp_salary_abs, emp_salary_insure, emp_salary_b, emp_salary_bs, emp_salary_tw, emp_salary_tw_bs, emp_salary_insure_cpy, uuid, created_at, updated_at) VALUES (46, '7', 'ARESSZ327', '2022/12', '2', 'c5ISYBVaQhjLl2ZXftGqcw==', null, 'TgaBPGrrIl4D4ECkUJ5qCAgF8+LkvstGgMZEFvyj5EiDirq3SLNzClVwqBupkLX6gSjH+LLoMwke
CUfCsQ+ynJgAkg4RnDwNtJ9PoijdITI=', null, null, null, null, null, 'TgaBPGrrIl4D4ECkUJ5qCAgF8+LkvstGgMZEFvyj5EgT5nGALfGXUw5UA8xuIBjqWG15bi7dy6+X
78UoIlbqanmEYP8NsDLgQKmThKNkXRI=', null, null, null, 'b8a2b950-799b-11ec-9428-3b2f803e4e0e', '2022-01-20', null);
INSERT INTO wx_personal_salary_page (id, company_id, emp_no, month_no, emp_pay_type, emp_salary, emp_salary_fix, emp_salary_tax, emp_salary_temp, emp_salary_ov, emp_salary_abs, emp_salary_insure, emp_salary_b, emp_salary_bs, emp_salary_tw, emp_salary_tw_bs, emp_salary_insure_cpy, uuid, created_at, updated_at) VALUES (47, '7', 'ARESSZ327', '2023/01', '1', 'FDoXdYBc3lN9EqfBRNbz8g==', 'TgaBPGrrIl4D4ECkUJ5qCFjHMQXQlqKmqy9zEX4EJ7J2BFYh7G+vA3zgBsO3rmLkEB4DXowIMaZI g42ieHJbFtq4NYbOM2ztQuVxANVuKnVTRkKFubQKuGMuYhVj9Qf7FMsb6WbtUa/oEZKJJlytLg==', 'TgaBPGrrIl4D4ECkUJ5qCFDInSlB6+fflt+1p/sMvZWEkyf7H0FSgJsZwccd27el', 'TgaBPGrrIl4D4ECkUJ5qCLEg8vihcWsw50xkm2WlyG8i5n8G+KYF4DsoKLYhYZeWukq6aZ/1QlUP ILM+KdwVe0goLhXZdsIiYzKVEhRW3vRUMZgtJ44CCvTr8q898Hy2cb1m+KqH7L0+HAuxDvCaJQXD jcOF06ezVFFZ8Mgo3hs0uchxuUAv2X5QV3x1fawr', 'TgaBPGrrIl4D4ECkUJ5qCLuBcbK3+7NSN92Jr0QWobZdctSsygD7JoYtzeskJ2QO', '/HDbHgNOY0EcZ2ZqLZfBTw==', 'TgaBPGrrIl4D4ECkUJ5qCAbQXJ68cnpqWQFcBimhnkMHm5Se2Wt1Q9DvKUiTfUZKVIDPdVddR8b0 1Gtm3xc3CZ3AVD0vjsxbmxef5xuIr4B8v4swEKbVYDhqXrOOamQ51jKy86e28lq1DguK+dZl9wjp JlVbD5pI7OV2k9GuYTKcX12FQLzq6ZzWRpbzc0Dp2jcYsinucIWppVy6lS68zBvfPH1JZNT+gAZb 3TK2E7GikPXTX9iInZapOf0c82XN', '/HDbHgNOY0EcZ2ZqLZfBTw==', '/HDbHgNOY0EcZ2ZqLZfBTw==', null, null, null, '3f9cba90-ac82-11ed-9778-7f0a538fcad5', '2023-02-15', null);

--wx_personal_salary_pwd
INSERT INTO wx_personal_salary_pwd (id, company_id, emp_no, pwd, created_at, updated_at) VALUES (1334, '7', 'ARESSZ327', '87d9bb400c0634691f0e3baaf1e2fd0d', '2022-08-18 17:13:16', '2022-08-18 17:13:16');

--wx_personal_salaryp
INSERT INTO wx_personal_salaryp (id, company_id, emp_no, validate_date, mapname, amount, uuid, created_at, updated_at) VALUES (7201, '7', 'ARESSZ327', '2005/11/16', '历史数据', '200', '8be5e9f0-3b01-11e8-8c7c-9958553220a9', '2018-04-08', null);
INSERT INTO wx_personal_salaryp (id, company_id, emp_no, validate_date, mapname, amount, uuid, created_at, updated_at) VALUES (7202, '7', 'ARESSZ327', '2005/04/01', '历史数据', '200', '8be5e9f0-3b01-11e8-8c7c-9958553220a9', '2018-04-08', null);
INSERT INTO wx_personal_salaryp (id, company_id, emp_no, validate_date, mapname, amount, uuid, created_at, updated_at) VALUES (7206, '7', 'ARESSZ327', '2005/02/16', '历史数据', '10', '8be5e9f0-3b01-11e8-8c7c-9958553220a9', '2018-04-08', null);
INSERT INTO wx_personal_salaryp (id, company_id, emp_no, validate_date, mapname, amount, uuid, created_at, updated_at) VALUES (7207, '7', 'ARESSZ327', '2003/04/09', '历史数据', '10', '8be5e9f0-3b01-11e8-8c7c-9958553220a9', '2018-04-08', null);
INSERT INTO wx_personal_salaryp (id, company_id, emp_no, validate_date, mapname, amount, uuid, created_at, updated_at) VALUES (7208, '7', 'ARESSZ327', '2004/08/16', '历史数据', '10', '8be5e9f0-3b01-11e8-8c7c-9958553220a9', '2018-04-08', null);
INSERT INTO wx_personal_salaryp (id, company_id, emp_no, validate_date, mapname, amount, uuid, created_at, updated_at) VALUES (7209, '7', 'ARESSZ327', '2015/04/16', '住房津贴', '608', '8be5e9f0-3b01-11e8-8c7c-9958553220a9', '2018-04-08', null);
INSERT INTO wx_personal_salaryp (id, company_id, emp_no, validate_date, mapname, amount, uuid, created_at, updated_at) VALUES (7210, '7', 'ARESSZ327', '2014/06/16', '住房津贴', '608', '8be5e9f0-3b01-11e8-8c7c-9958553220a9', '2018-04-08', null);
INSERT INTO wx_personal_salaryp (id, company_id, emp_no, validate_date, mapname, amount, uuid, created_at, updated_at) VALUES (7211, '7', 'ARESSZ327', '2014/04/01', '住房津贴', '564', '8be5e9f0-3b01-11e8-8c7c-9958553220a9', '2018-04-08', null);
INSERT INTO wx_personal_salaryp (id, company_id, emp_no, validate_date, mapname, amount, uuid, created_at, updated_at) VALUES (7212, '7', 'ARESSZ327', '2013/04/01', '住房津贴', '452', '8be5e9f0-3b01-11e8-8c7c-9958553220a9', '2018-04-08', null);
INSERT INTO wx_personal_salaryp (id, company_id, emp_no, validate_date, mapname, amount, uuid, created_at, updated_at) VALUES (7213, '7', 'ARESSZ327', '2013/06/16', '住房津贴', '564', '8be5e9f0-3b01-11e8-8c7c-9958553220a9', '2018-04-08', null);
INSERT INTO wx_personal_salaryp (id, company_id, emp_no, validate_date, mapname, amount, uuid, created_at, updated_at) VALUES (7214, '7', 'ARESSZ327', '2011/10/01', '住房津贴', '355', '8be5e9f0-3b01-11e8-8c7c-9958553220a9', '2018-04-08', null);
INSERT INTO wx_personal_salaryp (id, company_id, emp_no, validate_date, mapname, amount, uuid, created_at, updated_at) VALUES (7215, '7', 'ARESSZ327', '2012/06/16', '住房津贴', '452', '8be5e9f0-3b01-11e8-8c7c-9958553220a9', '2018-04-08', null);
INSERT INTO wx_personal_salaryp (id, company_id, emp_no, validate_date, mapname, amount, uuid, created_at, updated_at) VALUES (7216, '7', 'ARESSZ327', '2012/04/01', '住房津贴', '355', '8be5e9f0-3b01-11e8-8c7c-9958553220a9', '2018-04-08', null);
INSERT INTO wx_personal_salaryp (id, company_id, emp_no, validate_date, mapname, amount, uuid, created_at, updated_at) VALUES (7217, '7', 'ARESSZ327', '2011/04/01', '住房津贴', '265', '8be5e9f0-3b01-11e8-8c7c-9958553220a9', '2018-04-08', null);
INSERT INTO wx_personal_salaryp (id, company_id, emp_no, validate_date, mapname, amount, uuid, created_at, updated_at) VALUES (7218, '7', 'ARESSZ327', '2011/06/16', '住房津贴', '355', '8be5e9f0-3b01-11e8-8c7c-9958553220a9', '2018-04-08', null);
INSERT INTO wx_personal_salaryp (id, company_id, emp_no, validate_date, mapname, amount, uuid, created_at, updated_at) VALUES (7219, '7', 'ARESSZ327', '2010/07/16', '住房津贴', '265', '8be5e9f0-3b01-11e8-8c7c-9958553220a9', '2018-04-08', null);
INSERT INTO wx_personal_salaryp (id, company_id, emp_no, validate_date, mapname, amount, uuid, created_at, updated_at) VALUES (7220, '7', 'ARESSZ327', '2008/07/16', '住房津贴', '328', '8be5e9f0-3b01-11e8-8c7c-9958553220a9', '2018-04-08', null);
INSERT INTO wx_personal_salaryp (id, company_id, emp_no, validate_date, mapname, amount, uuid, created_at, updated_at) VALUES (7221, '7', 'ARESSZ327', '2010/04/01', '住房津贴', '340', '8be5e9f0-3b01-11e8-8c7c-9958553220a9', '2018-04-08', null);
INSERT INTO wx_personal_salaryp (id, company_id, emp_no, validate_date, mapname, amount, uuid, created_at, updated_at) VALUES (7222, '7', 'ARESSZ327', '2008/04/01', '住房津贴', '270', '8be5e9f0-3b01-11e8-8c7c-9958553220a9', '2018-04-08', null);
INSERT INTO wx_personal_salaryp (id, company_id, emp_no, validate_date, mapname, amount, uuid, created_at, updated_at) VALUES (7223, '7', 'ARESSZ327', '2008/04/02', '住房津贴', '270', '8be5e9f0-3b01-11e8-8c7c-9958553220a9', '2018-04-08', null);
INSERT INTO wx_personal_salaryp (id, company_id, emp_no, validate_date, mapname, amount, uuid, created_at, updated_at) VALUES (7224, '7', 'ARESSZ327', '2009/09/16', '住房津贴', '340', '8be5e9f0-3b01-11e8-8c7c-9958553220a9', '2018-04-08', null);
INSERT INTO wx_personal_salaryp (id, company_id, emp_no, validate_date, mapname, amount, uuid, created_at, updated_at) VALUES (7225, '7', 'ARESSZ327', '2009/12/16', '住房津贴', '340', '8be5e9f0-3b01-11e8-8c7c-9958553220a9', '2018-04-08', null);
INSERT INTO wx_personal_salaryp (id, company_id, emp_no, validate_date, mapname, amount, uuid, created_at, updated_at) VALUES (7226, '7', 'ARESSZ327', '2009/07/16', '住房津贴', '340', '8be5e9f0-3b01-11e8-8c7c-9958553220a9', '2018-04-08', null);
INSERT INTO wx_personal_salaryp (id, company_id, emp_no, validate_date, mapname, amount, uuid, created_at, updated_at) VALUES (7227, '7', 'ARESSZ327', '2007/10/16', '住房津贴', '270', '8be5e9f0-3b01-11e8-8c7c-9958553220a9', '2018-04-08', null);
INSERT INTO wx_personal_salaryp (id, company_id, emp_no, validate_date, mapname, amount, uuid, created_at, updated_at) VALUES (7228, '7', 'ARESSZ327', '2007/04/01', '住房津贴', '226', '8be5e9f0-3b01-11e8-8c7c-9958553220a9', '2018-04-08', null);
INSERT INTO wx_personal_salaryp (id, company_id, emp_no, validate_date, mapname, amount, uuid, created_at, updated_at) VALUES (7229, '7', 'ARESSZ327', '2005/04/01', '住房津贴', '104', '8be5e9f0-3b01-11e8-8c7c-9958553220a9', '2018-04-08', null);
INSERT INTO wx_personal_salaryp (id, company_id, emp_no, validate_date, mapname, amount, uuid, created_at, updated_at) VALUES (7230, '7', 'ARESSZ327', '2005/11/16', '住房津贴', '135', '8be5e9f0-3b01-11e8-8c7c-9958553220a9', '2018-04-08', null);
INSERT INTO wx_personal_salaryp (id, company_id, emp_no, validate_date, mapname, amount, uuid, created_at, updated_at) VALUES (7231, '7', 'ARESSZ327', '2006/04/01', '住房津贴', '135', '8be5e9f0-3b01-11e8-8c7c-9958553220a9', '2018-04-08', null);
INSERT INTO wx_personal_salaryp (id, company_id, emp_no, validate_date, mapname, amount, uuid, created_at, updated_at) VALUES (7232, '7', 'ARESSZ327', '2005/02/16', '住房津贴', '104', '8be5e9f0-3b01-11e8-8c7c-9958553220a9', '2018-04-08', null);
INSERT INTO wx_personal_salaryp (id, company_id, emp_no, validate_date, mapname, amount, uuid, created_at, updated_at) VALUES (7233, '7', 'ARESSZ327', '2004/08/16', '住房津贴', '104', '8be5e9f0-3b01-11e8-8c7c-9958553220a9', '2018-04-08', null);
INSERT INTO wx_personal_salaryp (id, company_id, emp_no, validate_date, mapname, amount, uuid, created_at, updated_at) VALUES (7234, '7', 'ARESSZ327', '2003/04/09', '住房津贴', '64', '8be5e9f0-3b01-11e8-8c7c-9958553220a9', '2018-04-08', null);
INSERT INTO wx_personal_salaryp (id, company_id, emp_no, validate_date, mapname, amount, uuid, created_at, updated_at) VALUES (7235, '7', 'ARESSZ327', '2006/10/16', '住房津贴', '226', '8be5e9f0-3b01-11e8-8c7c-9958553220a9', '2018-04-08', null);
INSERT INTO wx_personal_salaryp (id, company_id, emp_no, validate_date, mapname, amount, uuid, created_at, updated_at) VALUES (7236, '7', 'ARESSZ327', '2015/04/16', '本薪', '5500', '8be5e9f0-3b01-11e8-8c7c-9958553220a9', '2018-04-08', null);
INSERT INTO wx_personal_salaryp (id, company_id, emp_no, validate_date, mapname, amount, uuid, created_at, updated_at) VALUES (7237, '7', 'ARESSZ327', '2014/06/16', '本薪', '5040', '8be5e9f0-3b01-11e8-8c7c-9958553220a9', '2018-04-08', null);
INSERT INTO wx_personal_salaryp (id, company_id, emp_no, validate_date, mapname, amount, uuid, created_at, updated_at) VALUES (7238, '7', 'ARESSZ327', '2014/04/01', '本薪', '5040', '8be5e9f0-3b01-11e8-8c7c-9958553220a9', '2018-04-08', null);
INSERT INTO wx_personal_salaryp (id, company_id, emp_no, validate_date, mapname, amount, uuid, created_at, updated_at) VALUES (7239, '7', 'ARESSZ327', '2013/04/01', '本薪', '4670', '8be5e9f0-3b01-11e8-8c7c-9958553220a9', '2018-04-08', null);
INSERT INTO wx_personal_salaryp (id, company_id, emp_no, validate_date, mapname, amount, uuid, created_at, updated_at) VALUES (7240, '7', 'ARESSZ327', '2013/06/16', '本薪', '4670', '8be5e9f0-3b01-11e8-8c7c-9958553220a9', '2018-04-08', null);
INSERT INTO wx_personal_salaryp (id, company_id, emp_no, validate_date, mapname, amount, uuid, created_at, updated_at) VALUES (7241, '7', 'ARESSZ327', '2011/10/01', '本薪', '3920', '8be5e9f0-3b01-11e8-8c7c-9958553220a9', '2018-04-08', null);
INSERT INTO wx_personal_salaryp (id, company_id, emp_no, validate_date, mapname, amount, uuid, created_at, updated_at) VALUES (7242, '7', 'ARESSZ327', '2012/06/16', '本薪', '4280', '8be5e9f0-3b01-11e8-8c7c-9958553220a9', '2018-04-08', null);
INSERT INTO wx_personal_salaryp (id, company_id, emp_no, validate_date, mapname, amount, uuid, created_at, updated_at) VALUES (7243, '7', 'ARESSZ327', '2012/04/01', '本薪', '4280', '8be5e9f0-3b01-11e8-8c7c-9958553220a9', '2018-04-08', null);
INSERT INTO wx_personal_salaryp (id, company_id, emp_no, validate_date, mapname, amount, uuid, created_at, updated_at) VALUES (7244, '7', 'ARESSZ327', '2011/04/01', '本薪', '3405', '8be5e9f0-3b01-11e8-8c7c-9958553220a9', '2018-04-08', null);
INSERT INTO wx_personal_salaryp (id, company_id, emp_no, validate_date, mapname, amount, uuid, created_at, updated_at) VALUES (7245, '7', 'ARESSZ327', '2011/06/16', '本薪', '3405', '8be5e9f0-3b01-11e8-8c7c-9958553220a9', '2018-04-08', null);
INSERT INTO wx_personal_salaryp (id, company_id, emp_no, validate_date, mapname, amount, uuid, created_at, updated_at) VALUES (7246, '7', 'ARESSZ327', '2010/07/16', '本薪', '3010', '8be5e9f0-3b01-11e8-8c7c-9958553220a9', '2018-04-08', null);
INSERT INTO wx_personal_salaryp (id, company_id, emp_no, validate_date, mapname, amount, uuid, created_at, updated_at) VALUES (7247, '7', 'ARESSZ327', '2008/07/16', '本薪', '2400', '8be5e9f0-3b01-11e8-8c7c-9958553220a9', '2018-04-08', null);
INSERT INTO wx_personal_salaryp (id, company_id, emp_no, validate_date, mapname, amount, uuid, created_at, updated_at) VALUES (7248, '7', 'ARESSZ327', '2010/04/01', '本薪', '3010', '8be5e9f0-3b01-11e8-8c7c-9958553220a9', '2018-04-08', null);
INSERT INTO wx_personal_salaryp (id, company_id, emp_no, validate_date, mapname, amount, uuid, created_at, updated_at) VALUES (7249, '7', 'ARESSZ327', '2008/04/02', '本薪', '2400', '8be5e9f0-3b01-11e8-8c7c-9958553220a9', '2018-04-08', null);
INSERT INTO wx_personal_salaryp (id, company_id, emp_no, validate_date, mapname, amount, uuid, created_at, updated_at) VALUES (7250, '7', 'ARESSZ327', '2009/09/16', '本薪', '2460', '8be5e9f0-3b01-11e8-8c7c-9958553220a9', '2018-04-08', null);
INSERT INTO wx_personal_salaryp (id, company_id, emp_no, validate_date, mapname, amount, uuid, created_at, updated_at) VALUES (7251, '7', 'ARESSZ327', '2009/12/16', '本薪', '2810', '8be5e9f0-3b01-11e8-8c7c-9958553220a9', '2018-04-08', null);
INSERT INTO wx_personal_salaryp (id, company_id, emp_no, validate_date, mapname, amount, uuid, created_at, updated_at) VALUES (7252, '7', 'ARESSZ327', '2009/07/16', '本薪', '2400', '8be5e9f0-3b01-11e8-8c7c-9958553220a9', '2018-04-08', null);
INSERT INTO wx_personal_salaryp (id, company_id, emp_no, validate_date, mapname, amount, uuid, created_at, updated_at) VALUES (7253, '7', 'ARESSZ327', '2008/04/01', '本薪', '2396', '8be5e9f0-3b01-11e8-8c7c-9958553220a9', '2018-04-08', null);
INSERT INTO wx_personal_salaryp (id, company_id, emp_no, validate_date, mapname, amount, uuid, created_at, updated_at) VALUES (7254, '7', 'ARESSZ327', '2007/10/16', '本薪', '1890', '8be5e9f0-3b01-11e8-8c7c-9958553220a9', '2018-04-08', null);
INSERT INTO wx_personal_salaryp (id, company_id, emp_no, validate_date, mapname, amount, uuid, created_at, updated_at) VALUES (7255, '7', 'ARESSZ327', '2006/10/16', '本薪', '1650', '8be5e9f0-3b01-11e8-8c7c-9958553220a9', '2018-04-08', null);
INSERT INTO wx_personal_salaryp (id, company_id, emp_no, validate_date, mapname, amount, uuid, created_at, updated_at) VALUES (7256, '7', 'ARESSZ327', '2007/04/01', '本薪', '1890', '8be5e9f0-3b01-11e8-8c7c-9958553220a9', '2018-04-08', null);
INSERT INTO wx_personal_salaryp (id, company_id, emp_no, validate_date, mapname, amount, uuid, created_at, updated_at) VALUES (7257, '7', 'ARESSZ327', '2005/04/01', '本薪', '1300', '8be5e9f0-3b01-11e8-8c7c-9958553220a9', '2018-04-08', null);
INSERT INTO wx_personal_salaryp (id, company_id, emp_no, validate_date, mapname, amount, uuid, created_at, updated_at) VALUES (7258, '7', 'ARESSZ327', '2005/11/16', '本薪', '1300', '8be5e9f0-3b01-11e8-8c7c-9958553220a9', '2018-04-08', null);
INSERT INTO wx_personal_salaryp (id, company_id, emp_no, validate_date, mapname, amount, uuid, created_at, updated_at) VALUES (7259, '7', 'ARESSZ327', '2006/04/01', '本薪', '1650', '8be5e9f0-3b01-11e8-8c7c-9958553220a9', '2018-04-08', null);
INSERT INTO wx_personal_salaryp (id, company_id, emp_no, validate_date, mapname, amount, uuid, created_at, updated_at) VALUES (7260, '7', 'ARESSZ327', '2005/02/16', '本薪', '1190', '8be5e9f0-3b01-11e8-8c7c-9958553220a9', '2018-04-08', null);
INSERT INTO wx_personal_salaryp (id, company_id, emp_no, validate_date, mapname, amount, uuid, created_at, updated_at) VALUES (7261, '7', 'ARESSZ327', '2003/04/09', '本薪', '840', '8be5e9f0-3b01-11e8-8c7c-9958553220a9', '2018-04-08', null);
INSERT INTO wx_personal_salaryp (id, company_id, emp_no, validate_date, mapname, amount, uuid, created_at, updated_at) VALUES (7262, '7', 'ARESSZ327', '2004/08/16', '本薪', '840', '8be5e9f0-3b01-11e8-8c7c-9958553220a9', '2018-04-08', null);

--wx_verify_code
INSERT INTO wx_verify_code (id, company_id, iphone, code, created_at, updated_at, status, msg) VALUES (24, '', '13812652676', '247693', '2023-03-10 10:12:32', '2023-03-10 10:12:32', '1', '"success-"');
