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

$modversion = array();

//---模組基本資訊---//
$modversion['name'] = _MI_SCS_NAME;
$modversion['version'] = '1.0';
$modversion['description'] = _MI_SCS_DESC;
$modversion['author'] = _MI_SCS_AUTHOR;
$modversion['credits'] = _MI_SCS_CREDITS;
$modversion['help'] = 'page=help';
$modversion['license'] = 'GPL see LICENSE';
$modversion['image'] = "images/logo.png";
$modversion['dirname'] = basename(__DIR__);

//---模組狀態資訊---//
$modversion['status_version'] = '1.0';
$modversion['release_date'] = '2020-01-21';
$modversion['module_website_url'] = 'https://www.tad0616.net';
$modversion['module_website_name'] = _MI_SCS_AUTHOR_WEB;
$modversion['module_status'] = 'release';
$modversion['author_website_url'] = 'https://www.tad0616.net';
$modversion['author_website_name'] = _MI_SCS_AUTHOR_WEB;
$modversion['min_php'] = '5.4';
$modversion['min_xoops'] = '2.5';

//---paypal資訊---//
$modversion['paypal'] = array();
$modversion['paypal']['business'] = 'tad0616@gmail.com';
$modversion['paypal']['item_name'] = 'Donation :' . _MI_SCS_AUTHOR;
$modversion['paypal']['amount'] = 0;
$modversion['paypal']['currency_code'] = 'USD';

//---安裝設定---//
$modversion['onInstall'] = "include/onInstall.php";
$modversion['onUpdate'] = "include/onUpdate.php";
$modversion['onUninstall'] = "include/onUninstall.php";

//---資料表架構---//
$modversion['sqlfile']['mysql'] = "sql/mysql.sql";
$modversion['tables'][] = "scs_brother_sister";
$modversion['tables'][] = "scs_consult";
$modversion['tables'][] = "scs_data_center";
$modversion['tables'][] = "scs_files_center";
$modversion['tables'][] = "scs_general";
$modversion['tables'][] = "scs_guardian";
$modversion['tables'][] = "scs_parents";
$modversion['tables'][] = "scs_students";

//---後台使用系統選單---//
$modversion['system_menu'] = 1;

//---後台管理介面設定---//
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = 'admin/power.php';
$modversion['adminmenu'] = 'admin/menu.php';

//---前台主選單設定---//
$modversion['hasMain'] = 1;
$modversion['sub'][] = array('name' => _MI_SCS_PAGE_1, 'url' => 'consult.php');

//---樣板設定---//
$modversion['templates'][] = array('file' => 'scs_adm_main.tpl', 'description' => 'scs_adm_main.tpl');
$modversion['templates'][] = array('file' => 'scs_adm_power.tpl', 'description' => 'scs_adm_power.tpl');
$modversion['templates'][] = array('file' => 'scs_index.tpl', 'description' => 'scs_index.tpl');
$modversion['templates'][] = array('file' => 'scs_consult.tpl', 'description' => 'scs_consult.tpl');

//---偏好設定---//

$i = 0;

// 教育部學校代碼
$modversion['config'][$i] = [
    'name' => 'school_code',
    'title' => '_MI_SCS_SCHOOL_CODE',
    'description' => '_MI_SCS_SCHOOL_CODE_DESC',
    'formtype' => 'textbox',
    'valuetype' => 'text',
    'default' => '',
];

// 教育部學校代碼
$i++;
$modversion['config'][$i] = [
    'name' => 'school_name',
    'title' => '_MI_SCS_SCHOOL_NAME',
    'description' => '_MI_SCS_SCHOOL_NAME_DESC',
    'formtype' => 'textbox',
    'valuetype' => 'text',
    'default' => '',
];

// 血型選項
$i++;
$modversion['config'][$i] = [
    'name' => 'stu_blood',
    'title' => '_MI_SCS_STU_BLOOD',
    'description' => '_MI_SCS_STU_BLOOD_DESC',
    'formtype' => 'textbox',
    'valuetype' => 'text',
    'default' => 'A;B;O;AB',
];

// 宗教選項
$i++;
$modversion['config'][$i] = [
    'name' => 'stu_religion',
    'title' => '_MI_SCS_STU_RELIGION',
    'description' => '_MI_SCS_STU_RELIGION_DESC',
    'formtype' => 'textbox',
    'valuetype' => 'text',
    'default' => _MI_SCS_STU_RELIGION_DEFAULT,
];

//出生地選項
$i++;
$modversion['config'][$i] = [
    'name' => 'stu_birth_place',
    'title' => '_MI_SCS_STU_BIRTH_PLACE',
    'description' => '_MI_SCS_STU_BIRTH_PLACE_DESC',
    'formtype' => 'textbox',
    'valuetype' => 'text',
    'default' => _MI_SCS_STU_BIRTH_PLACE_DEFAULT,
];

// 身份註記選項
$i++;
$modversion['config'][$i] = [
    'name' => 'stu_identity',
    'title' => '_MI_SCS_STU_IDENTITY',
    'description' => '_MI_SCS_STU_IDENTITY_DESC',
    'formtype' => 'textbox',
    'valuetype' => 'text',
    'default' => _MI_SCS_STU_IDENTITY_DEFAULT,
];

// 職業選項
$i++;
$modversion['config'][$i] = [
    'name' => 'parent_job',
    'title' => '_MI_SCS_PARENT_JOB',
    'description' => '_MI_SCS_PARENT_JOB_DESC',
    'formtype' => 'textbox',
    'valuetype' => 'text',
    'default' => _MI_SCS_PARENT_JOB_DEFAULT,
];

// 教育程度選項
$i++;
$modversion['config'][$i] = [
    'name' => 'parent_edu',
    'title' => '_MI_SCS_PARENT_EDU',
    'description' => '_MI_SCS_PARENT_EDU_DESC',
    'formtype' => 'textbox',
    'valuetype' => 'text',
    'default' => _MI_SCS_PARENT_EDU_DEFAULT,
];

// 監護人關係選項
$i++;
$modversion['config'][$i] = [
    'name' => 'guardian_title',
    'title' => '_MI_SCS_GUARDIAN_TITLE',
    'description' => '_MI_SCS_GUARDIAN_TITLE_DESC',
    'formtype' => 'textbox',
    'valuetype' => 'text',
    'default' => _MI_SCS_GUARDIAN_TITLE_DEFAULT,
];

// 父母關係選項
$i++;
$modversion['config'][$i] = [
    'name' => 'parental_relationship',
    'title' => '_MI_SCS_PARENTAL_RELATIONSHIP',
    'description' => '_MI_SCS_PARENTAL_RELATIONSHIP_DESC',
    'formtype' => 'textbox',
    'valuetype' => 'text',
    'default' => _MI_SCS_PARENTAL_RELATIONSHIP_DEFAULT,
];

$i++;
$modversion['config'][$i] = [
    'name' => 'parent_survive',
    'title' => '_MI_SCS_PARENT_SURVIVE',
    'description' => '_MI_SCS_PARENT_SURVIVE_DESC',
    'formtype' => 'textbox',
    'valuetype' => 'text',
    'default' => _MI_SCS_PARENT_SURVIVE_DEFAULT,
];

// 家庭氣氛選項
$i++;
$modversion['config'][$i] = [
    'name' => 'family_atmosphere',
    'title' => '_MI_SCS_FAMILY_ATMOSPHERE',
    'description' => '_MI_SCS_FAMILY_ATMOSPHERE_DESC',
    'formtype' => 'textbox',
    'valuetype' => 'text',
    'default' => _MI_SCS_FAMILY_ATMOSPHERE_DEFAULT,
];

// 管教方式選項
$i++;
$modversion['config'][$i] = [
    'name' => 'discipline',
    'title' => '_MI_SCS_DISCIPLINE',
    'description' => '_MI_SCS_DISCIPLINE_DESC',
    'formtype' => 'textbox',
    'valuetype' => 'text',
    'default' => _MI_SCS_DISCIPLINE_DEFAULT,
];

// 居住環境選項
$i++;
$modversion['config'][$i] = [
    'name' => 'environment',
    'title' => '_MI_SCS_ENVIRONMENT',
    'description' => '_MI_SCS_ENVIRONMENT_DESC',
    'formtype' => 'textbox',
    'valuetype' => 'text',
    'default' => _MI_SCS_ENVIRONMENT_DEFAULT,
];

// 本人住宿選項
$i++;
$modversion['config'][$i] = [
    'name' => 'accommodation',
    'title' => '_MI_SCS_ACCOMMODATION',
    'description' => '_MI_SCS_ACCOMMODATION_DESC',
    'formtype' => 'textbox',
    'valuetype' => 'text',
    'default' => _MI_SCS_ACCOMMODATION_DEFAULT,
];

// 經濟狀況選項
$i++;
$modversion['config'][$i] = [
    'name' => 'economic',
    'title' => '_MI_SCS_ECONOMIC',
    'description' => '_MI_SCS_ECONOMIC_DESC',
    'formtype' => 'textbox',
    'valuetype' => 'text',
    'default' => _MI_SCS_ECONOMIC_DEFAULT,
];

// 零用錢感受選項
$i++;
$modversion['config'][$i] = [
    'name' => 'feel',
    'title' => '_MI_SCS_FEEL',
    'description' => '_MI_SCS_FEEL_DESC',
    'formtype' => 'textbox',
    'valuetype' => 'text',
    'default' => _MI_SCS_FEEL_DEFAULT,
];

// 學科選項
$i++;
$modversion['config'][$i] = [
    'name' => 'favorite_subject',
    'title' => '_MI_SCS_FAVORITE_SUBJECT',
    'description' => '_MI_SCS_FAVORITE_SUBJECT_DESC',
    'formtype' => 'textbox',
    'valuetype' => 'text',
    'default' => _MI_SCS_FAVORITE_SUBJECT_DEFAULT,
];

// 學科選項
$i++;
$modversion['config'][$i] = [
    'name' => 'difficult_subject',
    'title' => '_MI_SCS_FAVORITE_SUBJECT',
    'description' => '_MI_SCS_FAVORITE_SUBJECT_DESC',
    'formtype' => 'textbox',
    'valuetype' => 'text',
    'default' => _MI_SCS_FAVORITE_SUBJECT_DEFAULT,
];

// 特殊專長選項
$i++;
$modversion['config'][$i] = [
    'name' => 'expertise',
    'title' => '_MI_SCS_EXPERTISE',
    'description' => '_MI_SCS_EXPERTISE_DESC',
    'formtype' => 'textbox',
    'valuetype' => 'text',
    'default' => _MI_SCS_EXPERTISE_DEFAULT,
];

// 休閒興趣選項
$i++;
$modversion['config'][$i] = [
    'name' => 'interest',
    'title' => '_MI_SCS_INTEREST',
    'description' => '_MI_SCS_INTEREST_DESC',
    'formtype' => 'textbox',
    'valuetype' => 'text',
    'default' => _MI_SCS_INTEREST_DEFAULT,
];

// 班級幹部選項
$i++;
$modversion['config'][$i] = [
    'name' => 'cadre',
    'title' => '_MI_SCS_CADRE',
    'description' => '_MI_SCS_CADRE_DESC',
    'formtype' => 'textbox',
    'valuetype' => 'text',
    'default' => _MI_SCS_CADRE_DEFAULT,
];

// 來談動機選項
$i++;
$modversion['config'][$i] = [
    'name' => 'consult_motivation',
    'title' => '_MI_SCS_CONSULT_MOTIVATION',
    'description' => '_MI_SCS_CONSULT_MOTIVATION_DESC',
    'formtype' => 'textbox',
    'valuetype' => 'text',
    'default' => _MI_SCS_CONSULT_MOTIVATION_DEFAULT,
];

// 問題類別選項
$i++;
$modversion['config'][$i] = [
    'name' => 'consult_kind',
    'title' => '_MI_SCS_CONSULT_KIND',
    'description' => '_MI_SCS_CONSULT_KIND_DESC',
    'formtype' => 'textbox',
    'valuetype' => 'text',
    'default' => _MI_SCS_CONSULT_KIND_DEFAULT,
];

// 處理方式選項
$i++;
$modversion['config'][$i] = [
    'name' => 'consult_method',
    'title' => '_MI_SCS_CONSULT_METHOD',
    'description' => '_MI_SCS_CONSULT_METHOD_DESC',
    'formtype' => 'textbox',
    'valuetype' => 'text',
    'default' => _MI_SCS_CONSULT_METHOD_DEFAULT,
];
