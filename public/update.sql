

DROP TRIGGER `wx_personal_page_trg`;

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
  END;

ALTER TABLE `wx_personal_salary_page`
DROP INDEX `UIdx1`,
ADD UNIQUE INDEX `UIdx1`(`company_id`, `emp_no`, `month_no`, `emp_pay_type`) USING BTREE;


ALTER TABLE `wx_personal_salary_page` MODIFY COLUMN `emp_pay_type` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL COMMENT '薪酬类别：1薪资，2为奖金';

update wx_personal_salary_page set emp_pay_type=1;