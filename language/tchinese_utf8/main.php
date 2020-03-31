<?php
/**
 * Scs module
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright  The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license    http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package    Scs
 * @since      2.5
 * @author     tad
 * @version    $Id $
 **/

xoops_loadLanguage('main', 'tadtools');
define('_TAD_NEED_TADTOOLS', '需要 tadtools 模組，可至<a href="http://campus-xoops.tn.edu.tw/modules/tad_modules/index.php?module_sn=1" target="_blank">XOOPS輕鬆架</a>下載。');

define('_MD_SCS_STU_ID', '學生編號');
define('_MD_SCS_BS_NAME', '姓名');
define('_MD_SCS_BS_RELATIONSHIP', '稱謂');
define('_MD_SCS_BS_YEAR', '出生年');
define('_MD_SCS_BS_SCHOOL', '畢（肄）業學校');
define('_MD_SCS_BS_NOTE', '備註');
define('_MD_SCS_SHOW_STU_ID_BS_RELATIONSHIP_FILES', '');
define('_MD_SCS_PARENTAL_RELATIONSHIP_DEF', '同住');
define('_MD_SCS_SCHOOL_YEAR', '學年度');
define('_MD_SCS_STU_GRADE', '年級');
define('_MD_SCS_STU_CLASS', '班級');
define('_MD_SCS_STU_SEAT_NO', '座號');
define('_MD_SCS_STU_HEIGHT', '身高');
define('_MD_SCS_STU_WEIGHT', '體重');
define('_MD_SCS_PARENTAL_RELATIONSHIP', '父母關係');
define('_MD_SCS_FAMILY_ATMOSPHERE', '家庭氣氛');
define('_MD_SCS_FATHER_DISCIPLINE', '父管教');
define('_MD_SCS_MOTHER_DISCIPLINE', '母管教');
define('_MD_SCS_ENVIRONMENT', '居住環境');
define('_MD_SCS_ACCOMMODATION', '本人住宿');
define('_MD_SCS_ECONOMIC', '經濟狀況');
define('_MD_SCS_MONEY', '週零用金');
define('_MD_SCS_FEEL', '我覺得');
define('_MD_SCS_FAVORITE_SUBJECT', '喜愛學科');
define('_MD_SCS_FAVORITE_SUBJECT_DEF0', '國文');
define('_MD_SCS_FAVORITE_SUBJECT_DEF1', '英語');
define('_MD_SCS_FAVORITE_SUBJECT_DEF2', '數學');
define('_MD_SCS_FAVORITE_SUBJECT_DEF3', '社會');
define('_MD_SCS_FAVORITE_SUBJECT_DEF4', '歷史');
define('_MD_SCS_FAVORITE_SUBJECT_DEF5', '地理');
define('_MD_SCS_FAVORITE_SUBJECT_DEF6', '公民');
define('_MD_SCS_FAVORITE_SUBJECT_DEF7', '自然');
define('_MD_SCS_FAVORITE_SUBJECT_DEF8', '生物');
define('_MD_SCS_FAVORITE_SUBJECT_DEF9', '體育');
define('_MD_SCS_FAVORITE_SUBJECT_DEF10', '健康教育');
define('_MD_SCS_FAVORITE_SUBJECT_DEF11', '音樂');
define('_MD_SCS_FAVORITE_SUBJECT_DEF12', '美術');
define('_MD_SCS_FAVORITE_SUBJECT_DEF13', '綜合活動');
define('_MD_SCS_FAVORITE_SUBJECT_DEF14', '電腦');
define('_MD_SCS_FAVORITE_SUBJECT_DEF15', '童軍');
define('_MD_SCS_FAVORITE_SUBJECT_DEF16', '家政');
define('_MD_SCS_FAVORITE_SUBJECT_DEF17', '輔導');
define('_MD_SCS_FAVORITE_SUBJECT_DEF18', '選修自然');
define('_MD_SCS_FAVORITE_SUBJECT_DEF19', '班務活動');
define('_MD_SCS_FAVORITE_SUBJECT_DEF20', '社團');
define('_MD_SCS_FAVORITE_SUBJECT_DEF21', '表演藝術');
define('_MD_SCS_FAVORITE_SUBJECT_DEF23', '雕刻');
define('_MD_SCS_FAVORITE_SUBJECT_DEF24', '空白');
define('_MD_SCS_FAVORITE_SUBJECT_DEF26', '選修數學');
define('_MD_SCS_FAVORITE_SUBJECT_DEF27', '選修自然');
define('_MD_SCS_FAVORITE_SUBJECT_DEF28', '國文輔導');
define('_MD_SCS_FAVORITE_SUBJECT_DEF29', '英語輔導');
define('_MD_SCS_FAVORITE_SUBJECT_DEF30', '數學輔導');
define('_MD_SCS_FAVORITE_SUBJECT_DEF31', '自然輔導');
define('_MD_SCS_FAVORITE_SUBJECT_DEF32', '社會輔導');
define('_MD_SCS_FAVORITE_SUBJECT_DEF33', '選修國文');
define('_MD_SCS_FAVORITE_SUBJECT_DEF34', '選修英語');
define('_MD_SCS_FAVORITE_SUBJECT_DEF35', '社會領域');
define('_MD_SCS_FAVORITE_SUBJECT_DEF36', '健康與體育');
define('_MD_SCS_FAVORITE_SUBJECT_DEF37', '藝術與人文');
define('_MD_SCS_FAVORITE_SUBJECT_DEF38', '綜合活動');
define('_MD_SCS_FAVORITE_SUBJECT_DEF39', '本土教育');
define('_MD_SCS_FAVORITE_SUBJECT_DEF40', '自然與生活科技');
define('_MD_SCS_DIFFICULT_SUBJECT', '困難學科');
define('_MD_SCS_DIFFICULT_SUBJECT_DEF0', '國文');
define('_MD_SCS_DIFFICULT_SUBJECT_DEF1', '英語');
define('_MD_SCS_DIFFICULT_SUBJECT_DEF2', '數學');
define('_MD_SCS_DIFFICULT_SUBJECT_DEF3', '社會');
define('_MD_SCS_DIFFICULT_SUBJECT_DEF4', '歷史');
define('_MD_SCS_DIFFICULT_SUBJECT_DEF5', '地理');
define('_MD_SCS_DIFFICULT_SUBJECT_DEF6', '公民');
define('_MD_SCS_DIFFICULT_SUBJECT_DEF7', '自然');
define('_MD_SCS_DIFFICULT_SUBJECT_DEF8', '生物');
define('_MD_SCS_DIFFICULT_SUBJECT_DEF9', '體育');
define('_MD_SCS_DIFFICULT_SUBJECT_DEF10', '健康教育');
define('_MD_SCS_DIFFICULT_SUBJECT_DEF11', '音樂');
define('_MD_SCS_DIFFICULT_SUBJECT_DEF12', '美術');
define('_MD_SCS_DIFFICULT_SUBJECT_DEF13', '綜合活動');
define('_MD_SCS_DIFFICULT_SUBJECT_DEF14', '電腦');
define('_MD_SCS_DIFFICULT_SUBJECT_DEF15', '童軍');
define('_MD_SCS_DIFFICULT_SUBJECT_DEF16', '家政');
define('_MD_SCS_DIFFICULT_SUBJECT_DEF17', '輔導');
define('_MD_SCS_DIFFICULT_SUBJECT_DEF18', '選修自然');
define('_MD_SCS_DIFFICULT_SUBJECT_DEF19', '班務活動');
define('_MD_SCS_DIFFICULT_SUBJECT_DEF20', '社團');
define('_MD_SCS_DIFFICULT_SUBJECT_DEF21', '表演藝術');
define('_MD_SCS_DIFFICULT_SUBJECT_DEF23', '雕刻');
define('_MD_SCS_DIFFICULT_SUBJECT_DEF24', '空白');
define('_MD_SCS_DIFFICULT_SUBJECT_DEF26', '選修數學');
define('_MD_SCS_DIFFICULT_SUBJECT_DEF27', '選修自然');
define('_MD_SCS_DIFFICULT_SUBJECT_DEF28', '國文輔導');
define('_MD_SCS_DIFFICULT_SUBJECT_DEF29', '英語輔導');
define('_MD_SCS_DIFFICULT_SUBJECT_DEF30', '數學輔導');
define('_MD_SCS_DIFFICULT_SUBJECT_DEF31', '自然輔導');
define('_MD_SCS_DIFFICULT_SUBJECT_DEF32', '社會輔導');
define('_MD_SCS_DIFFICULT_SUBJECT_DEF33', '選修國文');
define('_MD_SCS_DIFFICULT_SUBJECT_DEF34', '選修英語');
define('_MD_SCS_DIFFICULT_SUBJECT_DEF35', '社會領域');
define('_MD_SCS_DIFFICULT_SUBJECT_DEF36', '健康與體育');
define('_MD_SCS_DIFFICULT_SUBJECT_DEF37', '藝術與人文');
define('_MD_SCS_DIFFICULT_SUBJECT_DEF38', '綜合活動');
define('_MD_SCS_DIFFICULT_SUBJECT_DEF39', '本土教育');
define('_MD_SCS_DIFFICULT_SUBJECT_DEF40', '自然與生活科技');
define('_MD_SCS_EXPERTISE', '特殊專長');
define('_MD_SCS_EXPERTISE_DEF0', '球類');
define('_MD_SCS_EXPERTISE_DEF1', '游泳');
define('_MD_SCS_EXPERTISE_DEF2', '國術');
define('_MD_SCS_EXPERTISE_DEF3', '美術');
define('_MD_SCS_EXPERTISE_DEF4', '樂器');
define('_MD_SCS_EXPERTISE_DEF5', '歌唱');
define('_MD_SCS_EXPERTISE_DEF6', '工藝');
define('_MD_SCS_EXPERTISE_DEF7', '家事');
define('_MD_SCS_EXPERTISE_DEF8', '演說');
define('_MD_SCS_EXPERTISE_DEF9', '寫作');
define('_MD_SCS_EXPERTISE_DEF10', '舞蹈');
define('_MD_SCS_EXPERTISE_DEF11', '戲劇');
define('_MD_SCS_EXPERTISE_DEF12', '書法');
define('_MD_SCS_EXPERTISE_DEF13', '珠算');
define('_MD_SCS_EXPERTISE_DEF14', '外語');
define('_MD_SCS_EXPERTISE_DEF15', '中打');
define('_MD_SCS_EXPERTISE_DEF16', '會計統計');
define('_MD_SCS_EXPERTISE_DEF17', '領導');
define('_MD_SCS_EXPERTISE_DEF18', '電腦');
define('_MD_SCS_EXPERTISE_DEF19', '英打');
define('_MD_SCS_EXPERTISE_DEF20', '中文輸入');
define('_MD_SCS_INTEREST', '休閒興趣');
define('_MD_SCS_INTEREST_DEF0', '影視');
define('_MD_SCS_INTEREST_DEF1', '閱讀');
define('_MD_SCS_INTEREST_DEF2', '登山');
define('_MD_SCS_INTEREST_DEF3', '露營');
define('_MD_SCS_INTEREST_DEF4', '旅行');
define('_MD_SCS_INTEREST_DEF5', '游泳');
define('_MD_SCS_INTEREST_DEF6', '釣魚');
define('_MD_SCS_INTEREST_DEF7', '演奏');
define('_MD_SCS_INTEREST_DEF8', '歌唱');
define('_MD_SCS_INTEREST_DEF9', '音樂');
define('_MD_SCS_INTEREST_DEF10', '舞蹈');
define('_MD_SCS_INTEREST_DEF11', '繪畫');
define('_MD_SCS_INTEREST_DEF12', '集郵');
define('_MD_SCS_INTEREST_DEF13', '打球');
define('_MD_SCS_INTEREST_DEF14', '國術');
define('_MD_SCS_INTEREST_DEF15', '編織');
define('_MD_SCS_INTEREST_DEF16', '寵物');
define('_MD_SCS_INTEREST_DEF17', '栽培');
define('_MD_SCS_INTEREST_DEF18', '電腦');
define('_MD_SCS_INTEREST_DEF19', '逛街');
define('_MD_SCS_INTEREST_DEF20', '下棋');
define('_MD_SCS_CLUB', '參加社團');
define('_MD_SCS_CADRE', '班級幹部');
define('_MD_SCS_STU_PERSONALITY', '我的個性');
define('_MD_SCS_STU_ADVANTAGE', '我的優點');
define('_MD_SCS_STU_IMPROVE', '我需要改進的地方');
define('_MD_SCS_FILL_DATE', '填寫日期');
define('_MD_SCS_STU_DIFFICULT', '我目前遇到最大的困難是');
define('_MD_SCS_STU_NEED_HELP', '我目前最需要的協助是');
define('_MD_SCS_SHOW_STU_ID_SCHOOL_YEAR_FILES', '');
define('_MD_SCS_GUARDIAN_NAME', '姓名');
define('_MD_SCS_GUARDIAN_SEX', '性別');
define('_MD_SCS_GUARDIAN_TITLE', '關係');
define('_MD_SCS_GUARDIAN_TEL', '電話');
define('_MD_SCS_GUARDIAN_ADDR', '通訊處');
define('_MD_SCS_SHOW_STU_ID_FILES', '大頭照');
define('_MD_SCS_PARENT_KIND_DEF', '父');
define('_MD_SCS_PARENT_SURVIVE_DEF', '存');
define('_MD_SCS_PARENT_KIND', '稱謂');
define('_MD_SCS_PARENT_NAME', '姓名');
define('_MD_SCS_PARENT_YEAR', '出生年');
define('_MD_SCS_PARENT_JOB', '職業');
define('_MD_SCS_PARENT_TITLE', '職稱');
define('_MD_SCS_PARENT_PHONE', '手機電話');
define('_MD_SCS_PARENT_SURVIVE', '存歿');
define('_MD_SCS_PARENT_COMPANY', '工作機構');
define('_MD_SCS_PARENT_COMPANY_TEL', '公司電話');
define('_MD_SCS_PARENT_EDU', '學歷');
define('_MD_SCS_PARENT_EMAIL', '電子信箱');
define('_MD_SCS_SHOW_STU_ID_PARENT_KIND_FILES', '');
define('_MD_SCS_STU_SEX_DEF', '男');
define('_MD_SCS_STU_RELIGION_DEF', '無');
define('_MD_SCS_STU_NO', '學號');
define('_MD_SCS_STU_NAME', '姓名');
define('_MD_SCS_STU_PID', '身份證');
define('_MD_SCS_STU_SEX', '性別');
define('_MD_SCS_STU_BIRTHDAY', '生日');
define('_MD_SCS_STU_BLOOD', '血型');
define('_MD_SCS_STU_RELIGION', '宗教');
define('_MD_SCS_STU_RESIDENCE', '僑居地');
define('_MD_SCS_STU_BIRTH_PLACE', '出生地');
define('_MD_SCS_STU_EMAIL', '電子郵件');
define('_MD_SCS_STU_ADDR', '通訊地');
define('_MD_SCS_STU_RESIDENCE_COUNTY', '戶籍縣市');
define('_MD_SCS_STU_RESIDENCE_CITY', '戶籍鄉鎮市區');
define('_MD_SCS_STU_RESIDENCE_ADDR', '戶籍地');
define('_MD_SCS_STU_ZIP', '通訊郵遞區號');
define('_MD_SCS_STU_COUNTY', '通訊縣市');
define('_MD_SCS_STU_CITY', '通訊鄉鎮市區');
define('_MD_SCS_STU_TEL1', '電話1');
define('_MD_SCS_STU_TEL2', '電話2');
define('_MD_SCS_STU_IDENTITY', '身份別');
define('_MD_SCS_STU_EDUCATION', '學歷及就學');
define('_MD_SCS_STU_AUTOBIOGRAPHY', '自傳');
define('_MD_SCS_POST_GRADUATION_PLAN', '畢業後計畫');
define('_MD_SCS_NOTE', '備註');
define('_MD_SCS_EMERGENCY_CONTACT', '聯絡人');
define('_MD_SCS_PHYSIOLOGICAL_DEFECT', '生理缺陷');
define('_MD_SCS_SPECIAL_DISEASE', '特殊疾病');
define('_MD_SCS_UP_STU_ID', '大頭照');
define('_MD_SCS_YS', '學年學期');
define('_MD_SCS_PAGE_1', '個別諮商');
define('_MD_SCS_CONSULT_ID', '諮商編號');
define('_MD_SCS_STU_ID', '學生編號');
define('_MD_SCS_CONSULT_DATE', '會談日期');
define('_MD_SCS_CONSULT_TIME', '會談時間');
define('_MD_SCS_CONSULT_MOTIVATION', '來談動機');
define('_MD_SCS_CONSULT_KIND', '問題類別');
define('_MD_SCS_CONSULT_REASON', '主要原因');
define('_MD_SCS_CONSULT_METHOD', '處理方式');
define('_MD_SCS_CONSULT_NOTE', '備註資料');
define('_MD_SCS_CONSULT_UID', '諮商者編號');
define('_MD_SCS_CONSULT_UID_NAME', '諮商者');
define('_MD_SCS_UP_CONSULT_ID', '相關檔案');
define('_MD_SCS_SHOW_CONSULT_ID_FILES', '相關檔案');
