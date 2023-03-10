/*
 Work Wechat Data Transfer

 Target Server Type    : MySQL
 Target Server Version : 50717
 File Encoding         : 65001

 Date: 16/08/2021 16:13:11
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for wx_all_holiday
-- ----------------------------
DROP TABLE IF EXISTS `wx_all_holiday`;
CREATE TABLE `wx_all_holiday` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `emp_no` varchar(64) NOT NULL COMMENT '工号',
  `year` int(11) NOT NULL COMMENT '年份',
  `holiday` text,
  `uuid` varchar(45) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `only` (`emp_no`,`year`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wx_attendance_user_status
-- ----------------------------
DROP TABLE IF EXISTS `wx_attendance_user_status`;
CREATE TABLE `wx_attendance_user_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `emp_no` varchar(32) NOT NULL COMMENT '工号',
  `month_no` varchar(32) NOT NULL DEFAULT '0' COMMENT '月份',
  `attendance` text,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0可确认1已确认 2已回传给hcp',
  `result` tinyint(4) NOT NULL COMMENT '确认结果0没问题1.有问题',
  `confirm_time` datetime DEFAULT NULL COMMENT '确认时间',
  `note` text NOT NULL COMMENT '说明',
  `uuid` varchar(45) CHARACTER SET utf32 DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `month_user` (`company_id`,`emp_no`,`month_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户每月考勤确认状态表';

-- ----------------------------
-- Table structure for wx_config_code
-- ----------------------------
DROP TABLE IF EXISTS `wx_config_code`;
CREATE TABLE `wx_config_code` (
  `id` int(11) NOT NULL,
  `type` varchar(32) NOT NULL,
  `code` varchar(32) NOT NULL,
  `display_name` varchar(64) NOT NULL COMMENT '确认结果0没问题1.有问题',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户每月考勤确认状态结果表';

-- ----------------------------
-- Table structure for wx_holiday_detail
-- ----------------------------
DROP TABLE IF EXISTS `wx_holiday_detail`;
CREATE TABLE `wx_holiday_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) DEFAULT NULL,
  `emp_no` varchar(64) DEFAULT NULL,
  `month_no` varchar(32) DEFAULT NULL,
  `detail` text,
  `uuid` varchar(45) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `only` (`company_id`,`emp_no`,`month_no`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wx_intermediate_table
-- ----------------------------
DROP TABLE IF EXISTS `wx_intermediate_table`;
CREATE TABLE `wx_intermediate_table` (
  `company_id` int(11) DEFAULT NULL,
  `table_name` varchar(128) COLLATE utf8mb4_bin DEFAULT NULL,
  `type` varchar(45) COLLATE utf8mb4_bin DEFAULT NULL,
  `uuid` varchar(45) COLLATE utf8mb4_bin DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `col1` text COLLATE utf8mb4_bin,
  `col2` text COLLATE utf8mb4_bin,
  `col3` text COLLATE utf8mb4_bin,
  `col4` text COLLATE utf8mb4_bin,
  `col5` text COLLATE utf8mb4_bin,
  `col6` text COLLATE utf8mb4_bin,
  `col7` text COLLATE utf8mb4_bin,
  `col8` text COLLATE utf8mb4_bin,
  `col9` text COLLATE utf8mb4_bin,
  `col10` text COLLATE utf8mb4_bin,
  `col11` text COLLATE utf8mb4_bin,
  `col12` text COLLATE utf8mb4_bin,
  `col13` text COLLATE utf8mb4_bin,
  `col14` text COLLATE utf8mb4_bin,
  `col15` text COLLATE utf8mb4_bin,
  `col16` mediumtext COLLATE utf8mb4_bin,
  `col17` mediumtext COLLATE utf8mb4_bin,
  `col18` mediumtext COLLATE utf8mb4_bin,
  `col19` mediumtext COLLATE utf8mb4_bin,
  `col20` mediumtext COLLATE utf8mb4_bin,
  KEY `nidx` (`company_id`,`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='wx_intermediate_table';

-- ----------------------------
-- Table structure for wx_leader_permission_list
-- ----------------------------
DROP TABLE IF EXISTS `wx_leader_permission_list`;
CREATE TABLE `wx_leader_permission_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` varchar(45) COLLATE utf8mb4_bin NOT NULL,
  `emp_no` varchar(45) COLLATE utf8mb4_bin NOT NULL,
  `lead_no` varchar(45) COLLATE utf8mb4_bin NOT NULL,
  `salary_auth` tinyint(4) NOT NULL DEFAULT '0',
  `info_auth` tinyint(4) NOT NULL DEFAULT '0',
  `uuid` varchar(45) COLLATE utf8mb4_bin DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UIdx1` (`company_id`,`emp_no`,`lead_no`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='WX_LEADER_PERMISSION_LIST';

-- ----------------------------
-- Table structure for wx_personal_calendar_page
-- ----------------------------
DROP TABLE IF EXISTS `wx_personal_calendar_page`;
CREATE TABLE `wx_personal_calendar_page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` varchar(45) COLLATE utf8mb4_bin NOT NULL,
  `emp_no` varchar(45) COLLATE utf8mb4_bin NOT NULL,
  `month_no` varchar(45) COLLATE utf8mb4_bin NOT NULL,
  `emp_shift` text COLLATE utf8mb4_bin,
  `emp_clock` text COLLATE utf8mb4_bin,
  `emp_n_abs` text COLLATE utf8mb4_bin,
  `emp_e_abs` text COLLATE utf8mb4_bin,
  `emp_over` text COLLATE utf8mb4_bin,
  `emp_n_abs_t` text COLLATE utf8mb4_bin NOT NULL,
  `emp_e_abs_t` text COLLATE utf8mb4_bin NOT NULL,
  `emp_over_t` text COLLATE utf8mb4_bin NOT NULL,
  `salary_time_sum` text COLLATE utf8mb4_bin NOT NULL,
  `uuid` varchar(45) COLLATE utf8mb4_bin DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UIdx1` (`company_id`,`emp_no`,`month_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='WX_PERSONAL_CALENDAR_PAGE';

-- ----------------------------
-- Table structure for wx_personal_information_page
-- ----------------------------
DROP TABLE IF EXISTS `wx_personal_information_page`;
CREATE TABLE `wx_personal_information_page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` varchar(45) COLLATE utf8mb4_bin NOT NULL,
  `emp_no` varchar(45) COLLATE utf8mb4_bin NOT NULL,
  `emp_name` varchar(1000) COLLATE utf8mb4_bin DEFAULT NULL,
  `emp_indate` varchar(1000) COLLATE utf8mb4_bin DEFAULT NULL,
  `emp_outdate` varchar(1000) COLLATE utf8mb4_bin DEFAULT NULL,
  `emp_dept` varchar(1000) COLLATE utf8mb4_bin DEFAULT NULL,
  `emp_edu` varchar(1000) COLLATE utf8mb4_bin DEFAULT NULL,
  `emp_title` varchar(1000) COLLATE utf8mb4_bin DEFAULT NULL,
  `emp_address` varchar(1000) COLLATE utf8mb4_bin DEFAULT NULL,
  `emp_phone` varchar(1000) COLLATE utf8mb4_bin DEFAULT NULL,
  `emp_emergencycontactor` varchar(1000) COLLATE utf8mb4_bin DEFAULT NULL,
  `emp_arg` text COLLATE utf8mb4_bin,
  `emp_bank` text COLLATE utf8mb4_bin,
  `emp_credentials` text COLLATE utf8mb4_bin,
  `emp_career` text COLLATE utf8mb4_bin,
  `uuid` varchar(45) COLLATE utf8mb4_bin DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UIdx1` (`company_id`,`emp_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='wx_personal_information_page';

-- ----------------------------
-- Table structure for wx_personal_pwd
-- ----------------------------
DROP TABLE IF EXISTS `wx_personal_pwd`;
CREATE TABLE `wx_personal_pwd` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` varchar(45) COLLATE utf8mb4_bin NOT NULL,
  `emp_no` varchar(45) COLLATE utf8mb4_bin NOT NULL,
  `old_pwd` text COLLATE utf8mb4_bin,
  `new_pwd` text COLLATE utf8mb4_bin,
  `uuid` varchar(45) COLLATE utf8mb4_bin DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UIdx1` (`company_id`,`emp_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- ----------------------------
-- Table structure for wx_personal_salary_page
-- ----------------------------
DROP TABLE IF EXISTS `wx_personal_salary_page`;
CREATE TABLE `wx_personal_salary_page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` varchar(45) COLLATE utf8mb4_bin NOT NULL,
  `emp_no` varchar(45) COLLATE utf8mb4_bin NOT NULL,
  `month_no` varchar(45) COLLATE utf8mb4_bin NOT NULL,
  `emp_pay_type` varchar(45) COLLATE utf8mb4_bin DEFAULT NULL,
  `emp_salary` varchar(45) COLLATE utf8mb4_bin NOT NULL,
  `emp_salary_fix` text COLLATE utf8mb4_bin,
  `emp_salary_tax` text COLLATE utf8mb4_bin,
  `emp_salary_temp` text COLLATE utf8mb4_bin,
  `emp_salary_ov` text COLLATE utf8mb4_bin,
  `emp_salary_abs` text COLLATE utf8mb4_bin,
  `emp_salary_insure` text COLLATE utf8mb4_bin,
  `emp_salary_b` text COLLATE utf8mb4_bin,
  `emp_salary_bs` text COLLATE utf8mb4_bin,
  `emp_salary_tw` text COLLATE utf8mb4_bin COMMENT '台湾薪资特定模块',
  `emp_salary_tw_bs` text COLLATE utf8mb4_bin COMMENT '台湾福利金',
  `emp_salary_insure_cpy` text COLLATE utf8mb4_bin,
  `uuid` varchar(45) COLLATE utf8mb4_bin DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UIdx1` (`company_id`,`emp_no`,`month_no`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='WX_PERSONAL_SALARY_PAGE';

-- ----------------------------
-- Table structure for wx_personal_salary_pwd
-- ----------------------------
DROP TABLE IF EXISTS `wx_personal_salary_pwd`;
CREATE TABLE `wx_personal_salary_pwd` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` varchar(45) NOT NULL,
  `emp_no` varchar(45) NOT NULL,
  `pwd` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wx_personal_salaryp
-- ----------------------------
DROP TABLE IF EXISTS `wx_personal_salaryp`;
CREATE TABLE `wx_personal_salaryp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` varchar(45) COLLATE utf8mb4_bin NOT NULL,
  `emp_no` varchar(45) COLLATE utf8mb4_bin NOT NULL,
  `validate_date` varchar(45) COLLATE utf8mb4_bin NOT NULL,
  `mapname` varchar(45) COLLATE utf8mb4_bin NOT NULL,
  `amount` varchar(45) COLLATE utf8mb4_bin NOT NULL,
  `uuid` varchar(45) COLLATE utf8mb4_bin DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UIdx1` (`company_id`,`emp_no`,`validate_date`,`mapname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='wx_personal_salaryp';

-- ----------------------------
-- Triggers structure for table wx_personal_pwd
-- ----------------------------
DROP TRIGGER IF EXISTS `wx_personal_pwd_trg`;
delimiter ;;
CREATE TRIGGER `wx_personal_pwd_trg` BEFORE INSERT ON `wx_personal_pwd` FOR EACH ROW BEGIN
    set  new.old_pwd= TO_BASE64(AES_ENCRYPT(new.old_pwd,'wechat'));
	set  new.new_pwd= TO_BASE64(AES_ENCRYPT(new.new_pwd,'wechat')); 
  END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table wx_personal_salary_page
-- ----------------------------
DROP TRIGGER IF EXISTS `wx_personal_page_trg`;
delimiter ;;
CREATE TRIGGER `wx_personal_page_trg` BEFORE INSERT ON `wx_personal_salary_page` FOR EACH ROW BEGIN
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
;;
delimiter ;

SET FOREIGN_KEY_CHECKS = 1;


/* 2022-02-28 add:五险一金(公司负担)
ALTER TABLE `wx_personal_salary_page` DROP `emp_salary_tw`;;
ALTER TABLE `wx_personal_salary_page` ADD `emp_salary_tw` TEXT NULL DEFAULT NULL COMMENT '台湾薪资特定模块' AFTER `emp_salary_bs`;;


ALTER TABLE `wx_personal_salary_page` DROP `emp_salary_tw_bs`;;
ALTER TABLE `wx_personal_salary_page` ADD `emp_salary_tw_bs` TEXT NULL DEFAULT NULL COMMENT '台湾福利金' AFTER `emp_salary_tw`;;


-- ALTER TABLE `wx_personal_salary_page` DROP `emp_salary_insure_cpy`;;
ALTER TABLE `wx_personal_salary_page` ADD `emp_salary_insure_cpy` TEXT NULL DEFAULT NULL COMMENT '五险一金(公司负担)' AFTER `emp_salary_tw_bs`;;



DROP TRIGGER IF EXISTS `wx_personal_page_trg`;;

CREATE TRIGGER `wx_personal_page_trg` BEFORE INSERT ON `wx_personal_salary_page` FOR EACH ROW BEGIN
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
;;

*/

