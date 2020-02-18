
CREATE TABLE `scs_brother_sister` (
  `stu_id` mediumint(9) unsigned NOT NULL COMMENT '學生編號',
  `bs_relationship` varchar(255) NOT NULL DEFAULT '' COMMENT '稱謂',
  `bs_name` varchar(255) NOT NULL DEFAULT '' COMMENT '姓名',
  `bs_school` varchar(255) DEFAULT '' COMMENT '畢（肄）業學校',
  `bs_year` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '出生年次',
  `bs_note` varchar(255) DEFAULT '' COMMENT '備註',
  PRIMARY KEY (`stu_id`,`bs_relationship`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE `scs_consult` (
  `consult_id` mediumint(9) unsigned NOT NULL AUTO_INCREMENT COMMENT '諮商編號',
  `stu_id` mediumint(9) unsigned NOT NULL DEFAULT '0' COMMENT '學生編號',
  `consult_date` date NOT NULL COMMENT '諮商日期',
  `consult_start` time DEFAULT NULL COMMENT '諮商開始時間',
  `consult_end` time DEFAULT NULL COMMENT '諮商結束時間',
  `consult_motivation` varchar(255) DEFAULT '' COMMENT '來談動機',
  `consult_kind` varchar(255) DEFAULT '' COMMENT '問題類別',
  `consult_reason` varchar(255) DEFAULT '' COMMENT '主要原因',
  `consult_method` varchar(255) DEFAULT '' COMMENT '處理方式',
  `consult_note` text COMMENT '備註資料',
  PRIMARY KEY (`consult_id`),
  KEY `stu_id` (`stu_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE `scs_data_center` (
  `mid` mediumint(9) unsigned NOT NULL AUTO_INCREMENT COMMENT '模組編號',
  `col_name` varchar(100) NOT NULL DEFAULT '' COMMENT '欄位名稱',
  `col_sn` mediumint(9) unsigned NOT NULL DEFAULT '0' COMMENT '欄位編號',
  `data_name` varchar(100) NOT NULL DEFAULT '' COMMENT '資料名稱',
  `data_value` text NOT NULL COMMENT '儲存值',
  `data_sort` mediumint(9) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `col_id` varchar(100) NOT NULL COMMENT '辨識字串',
  `update_time` datetime NOT NULL COMMENT '更新時間',
  PRIMARY KEY (`mid`,`col_name`,`col_sn`,`data_name`,`data_sort`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE `scs_files_center` (
  `files_sn` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '檔案流水號',
  `col_name` varchar(255) NOT NULL DEFAULT '' COMMENT '欄位名稱',
  `col_sn` varchar(255) NOT NULL DEFAULT '' COMMENT '欄位編號',
  `sort` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `kind` enum('img','file') NOT NULL DEFAULT 'img' COMMENT '檔案種類',
  `file_name` varchar(255) NOT NULL DEFAULT '' COMMENT '檔案名稱',
  `file_type` varchar(255) NOT NULL DEFAULT '' COMMENT '檔案類型',
  `file_size` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '檔案大小',
  `description` text NOT NULL COMMENT '檔案說明',
  `counter` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '下載人次',
  `original_filename` varchar(255) NOT NULL DEFAULT '' COMMENT '檔案名稱',
  `hash_filename` varchar(255) NOT NULL DEFAULT '' COMMENT '加密檔案名稱',
  `sub_dir` varchar(255) NOT NULL DEFAULT '' COMMENT '檔案子路徑',
  `upload_date` datetime NOT NULL COMMENT '上傳時間',
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '上傳者',
  `tag` varchar(255) NOT NULL DEFAULT '' COMMENT '註記',
  PRIMARY KEY (`files_sn`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE `scs_general` (
  `stu_id` mediumint(9) unsigned NOT NULL COMMENT '學生編號',
  `school_year` tinyint(3) unsigned NOT NULL,
  `stu_grade` tinyint(3) unsigned NOT NULL COMMENT '年級',
  `stu_class` tinyint(3) unsigned DEFAULT '0' COMMENT '班級',
  `stu_seat_no` tinyint(3) unsigned DEFAULT '0' COMMENT '座號',
  `stu_height` varchar(255) DEFAULT '' COMMENT '身高',
  `stu_weight` varchar(255) DEFAULT '' COMMENT '體重',
  `parental_relationship` varchar(255) DEFAULT '' COMMENT '父母關係',
  `family_atmosphere` varchar(255) DEFAULT '' COMMENT '家庭氣氛',
  `father_discipline` varchar(255) DEFAULT '' COMMENT '父管教',
  `mother_discipline` varchar(255) DEFAULT '' COMMENT '母管教',
  `environment` varchar(255) DEFAULT '' COMMENT '居住環境',
  `accommodation` varchar(255) DEFAULT '' COMMENT '本人住宿',
  `economic` varchar(255) DEFAULT '' COMMENT '經濟狀況',
  `money` varchar(255) DEFAULT '' COMMENT '週零用金',
  `feel` varchar(255) DEFAULT '' COMMENT '我覺得',
  `favorite_subject` varchar(255) DEFAULT '' COMMENT '喜愛學科',
  `difficult_subject` varchar(255) DEFAULT '' COMMENT '困難學科',
  `expertise` varchar(255) DEFAULT '' COMMENT '特殊專長',
  `interest` varchar(255) DEFAULT '' COMMENT '休閒興趣',
  `club` varchar(255) DEFAULT '' COMMENT '參加社團',
  `cadre` varchar(255) DEFAULT '' COMMENT '班級幹部',
  `stu_personality` varchar(255) DEFAULT '' COMMENT '我的個性',
  `stu_advantage` varchar(255) DEFAULT '' COMMENT '我的優點',
  `stu_improve` varchar(255) DEFAULT '' COMMENT '我需要改進的地方',
  `fill_date` date DEFAULT NULL COMMENT '填寫日期',
  `stu_difficult` varchar(255) DEFAULT '' COMMENT '我目前遇到最大的困難是',
  `stu_need_help` varchar(255) DEFAULT '' COMMENT '我目前最需要的協助是',
  PRIMARY KEY (`stu_id`,`stu_grade`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE `scs_guardian` (
  `stu_id` mediumint(9) unsigned NOT NULL COMMENT '學生編號',
  `guardian_name` varchar(255) DEFAULT '' COMMENT '姓名',
  `guardian_sex` enum('','男','女') DEFAULT NULL COMMENT '性別',
  `guardian_title` varchar(255) DEFAULT '' COMMENT '關係',
  `guardian_tel` varchar(255) DEFAULT '' COMMENT '電話',
  `guardian_addr` varchar(255) DEFAULT '' COMMENT '通訊處',
  PRIMARY KEY (`stu_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE `scs_parents` (
  `stu_id` mediumint(9) unsigned NOT NULL COMMENT '學生編號',
  `parent_kind` varchar(30) NOT NULL DEFAULT '' COMMENT '稱謂',
  `parent_name` varchar(255) NOT NULL DEFAULT '' COMMENT '姓名',
  `parent_job` varchar(255) DEFAULT '' COMMENT '職業',
  `parent_company` varchar(255) DEFAULT '' COMMENT '工作機構',
  `parent_title` varchar(255) DEFAULT '' COMMENT '職稱',
  `parent_company_tel` varchar(255) DEFAULT '' COMMENT '公司電話',
  `parent_phone` varchar(255) DEFAULT '' COMMENT '手機電話',
  `parent_email` varchar(255) DEFAULT '' COMMENT '電子信箱',
  `parent_year` varchar(255) DEFAULT '' COMMENT '出生年次',
  `parent_survive` varchar(255) DEFAULT '' COMMENT '存歿',
  `parent_edu` varchar(255) DEFAULT '' COMMENT '教育程度',
  PRIMARY KEY (`stu_id`,`parent_kind`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE `scs_students` (
  `stu_id` mediumint(9) unsigned NOT NULL AUTO_INCREMENT COMMENT '學生編號',
  `stu_no` varchar(20) NOT NULL DEFAULT '' COMMENT '學號',
  `stu_name` varchar(255) NOT NULL DEFAULT '' COMMENT '姓名',
  `stu_pid` varchar(10) NOT NULL DEFAULT '' COMMENT '身份證號',
  `stu_sex` enum('男','女') NOT NULL COMMENT '性別',
  `stu_birthday` date NOT NULL COMMENT '生日',
  `stu_blood` varchar(20) DEFAULT NULL COMMENT '血型',
  `stu_religion` varchar(255) DEFAULT '' COMMENT '宗教',
  `stu_residence` varchar(255) DEFAULT '' COMMENT '僑居地',
  `stu_birth_place` varchar(255) DEFAULT '' COMMENT '出生地',
  `stu_email` varchar(255) DEFAULT '' COMMENT '電子郵件',
  `stu_residence_zip` varchar(255) NOT NULL DEFAULT '' COMMENT '戶籍郵遞區號',
  `stu_residence_county` varchar(255) NOT NULL DEFAULT '' COMMENT '戶籍縣市',
  `stu_residence_city` varchar(255) NOT NULL DEFAULT '' COMMENT '戶籍鄉鎮市區',
  `stu_residence_addr` varchar(300) NOT NULL DEFAULT '' COMMENT '戶籍地址',
  `stu_zip` varchar(5) NOT NULL DEFAULT '' COMMENT '通訊郵遞區號',
  `stu_county` varchar(30) NOT NULL DEFAULT '' COMMENT '通訊縣市',
  `stu_city` varchar(30) NOT NULL DEFAULT '' COMMENT '通訊鄉鎮市區',
  `stu_addr` varchar(255) NOT NULL DEFAULT '' COMMENT '通訊地址',
  `emergency_contact` text COMMENT '緊急聯絡人',
  `stu_tel1` varchar(255) DEFAULT '' COMMENT '電話1',
  `stu_tel2` varchar(255) DEFAULT '' COMMENT '電話2',
  `stu_identity` varchar(255) DEFAULT '' COMMENT '身份註記',
  `stu_education` text COMMENT '學歷及就學',
  `physiological_defect` text COMMENT '生理缺陷',
  `special_disease` text COMMENT '特殊疾病',
  `stu_autobiography` text COMMENT '自傳',
  `post_graduation_plan` text COMMENT '畢業後計畫',
  `note` text COMMENT '備註',
  PRIMARY KEY (`stu_id`),
  UNIQUE KEY `stu_pid` (`stu_pid`),
  KEY `stu_no` (`stu_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;