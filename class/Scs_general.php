<?php
namespace XoopsModules\Scs;

use XoopsModules\Scs\Tools;
use XoopsModules\Tadtools\SweetAlert;
use XoopsModules\Tadtools\TadDataCenter;
use XoopsModules\Tadtools\Utility;

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

class Scs_general
{
    //列出所有 scs_general 資料
    public static function index($school_year = '', $stu_grade = '', $stu_class = '')
    {
        global $xoopsDB, $xoopsTpl;
        if ($stu_grade) {
            $_SESSION['stu_stage'] = ($stu_grade >= 7) ? '國中' : '國小';
            $_SESSION['stages']    = ($stu_grade >= 7) ? ['七' => 7, '八' => 8, '九' => 9] : ['一' => 1, '二' => 2, '三' => 3, '四' => 4, '五' => 5, '六' => 6];
        }

        Tools::chk_scs_power(__FILE__, __LINE__, 'index', '', $school_year, $stu_grade, $stu_class);

        if (empty($school_year)) {
            $school_year = Tools::get_school_year();
        }
        $and_stu_grade = $and_stu_class = '';
        if ($stu_grade) {
            $and_stu_grade = "and `stu_grade` = '{$stu_grade}' ";
        }
        if ($stu_class) {
            $and_stu_class = "and `stu_class` = '{$stu_class}' ";
        }
        $myts = \MyTextSanitizer::getInstance();

        $sql = "select a.`stu_id`, a.`school_year`, a.`stu_grade`, a.`stu_class`, a.`stu_seat_no`, b.`stu_name`, b.`stu_no`, b.`stu_pid`, b.`stu_sex`, b.`stu_birthday`, b.`emergency_contact`, a.`fill_date` from `" . $xoopsDB->prefix("scs_general") . "` as a
        join `" . $xoopsDB->prefix("scs_students") . "` as b on a.`stu_id`=b.`stu_id`
        where a.`school_year`='{$school_year}' {$and_stu_grade} {$and_stu_class}
        order by a.`stu_grade`, a.`stu_class`, a.`stu_seat_no`";

        //Utility::getPageBar($原sql語法, 每頁顯示幾筆資料, 最多顯示幾個頁數選項);
        $PageBar = Utility::getPageBar($sql, 40, 10);
        $bar     = $PageBar['bar'];
        $sql     = $PageBar['sql'];
        $total   = $PageBar['total'];
        $xoopsTpl->assign('bar', $bar);
        $xoopsTpl->assign('total', $total);

        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);

        $all_scs_general = [];
        while ($all = $xoopsDB->fetchArray($result)) {
            //過濾讀出的變數值
            $all['stu_id']            = (int) $all['stu_id'];
            $all['school_year']       = $myts->htmlSpecialChars($all['school_year']);
            $all['stu_grade']         = $myts->htmlSpecialChars($all['stu_grade']);
            $all['stu_class']         = $myts->htmlSpecialChars($all['stu_class']);
            $all['stu_seat_no']       = $myts->htmlSpecialChars($all['stu_seat_no']);
            $all['stu_name']          = $myts->htmlSpecialChars($all['stu_name']);
            $all['stu_no']            = $myts->htmlSpecialChars($all['stu_no']);
            $all['stu_pid']           = $myts->htmlSpecialChars($all['stu_pid']);
            $all['stu_sex']           = $myts->htmlSpecialChars($all['stu_sex']);
            $all['stu_birthday']      = $myts->htmlSpecialChars($all['stu_birthday']);
            $all['emergency_contact'] = json_decode($all['emergency_contact'], true);
            $all['fill_date']         = $myts->htmlSpecialChars($all['fill_date']);

            $all_scs_general[] = $all;
        }

        //刪除確認的JS
        $SweetAlert = new SweetAlert();
        $SweetAlert->render('scs_general_destroy_func',
            "{$_SERVER['PHP_SELF']}?op=scs_general_destroy&school_year{$school_year}=&stu_id=", "stu_id");

        $xoopsTpl->assign('action', $_SERVER['PHP_SELF']);
        $xoopsTpl->assign('all_scs_general', $all_scs_general);
    }

    //scs_general::create(編輯表單
    public static function create($stu_id = '', $school_year = '')
    {
        global $xoopsTpl;
        Tools::chk_scs_power(__FILE__, __LINE__, 'create', $stu_id, $school_year);

        $form2_other_arr = [
            '父母關係'    => ['var_name' => 'parental_relationship', 'type' => 'select'],
            '家庭氣氛'    => ['var_name' => 'family_atmosphere', 'type' => 'select'],
            '父管教方式'   => ['var_name' => 'father_discipline', 'type' => 'select', 'opt' => 'discipline'],
            '母管教方式'   => ['var_name' => 'mother_discipline', 'type' => 'select', 'opt' => 'discipline'],
            '居住環境'    => ['var_name' => 'environment', 'type' => 'select'],
            '本人住宿'    => ['var_name' => 'accommodation', 'type' => 'select'],
            '經濟狀況'    => ['var_name' => 'economic', 'type' => 'select'],
            '每星期零用錢約' => ['var_name' => 'money', 'type' => 'input'],
            '覺得零用錢'   => ['var_name' => 'feel', 'type' => 'select'],
        ];
        $xoopsTpl->assign('form2_other_arr', $form2_other_arr);

        //抓取預設值
        $DBV = !empty($stu_id) ? self::get($stu_id) : [];

        if ($stu_id) {
            $_SESSION['stu_stage'] = (Tools::array_key_last($DBV) >= 7) ? '國中' : '國小';
            $_SESSION['stages']    = (Tools::array_key_last($DBV) >= 7) ? ['七' => 7, '八' => 8, '九' => 9] : ['一' => 1, '二' => 2, '三' => 3, '四' => 4, '五' => 5, '六' => 6];
        }

        $xoopsTpl->assign('general', $DBV);
        //預設值設定
        foreach ($form2_other_arr as $other) {
            if ($other['type'] == 'select') {
                if (!empty($other['opt'])) {
                    // Utility::dd($other);
                    $other_arr[$other['var_name']] = Tools::get_config_arr($other['opt'], $other['var_name'], 'return');
                } else {
                    $other_arr[$other['var_name']] = Tools::get_config_arr($other['var_name'], '', 'return');
                }
            }
        }

        $xoopsTpl->assign('other_arr', $other_arr);

        Tools::get_config_arr('favorite_subject');
        Tools::get_config_arr('difficult_subject');
        Tools::get_config_arr('expertise');
        Tools::get_config_arr('interest');
        Tools::get_config_arr('cadre');
    }

    // //新增資料到scs_general中
    // public static function store($stu_id, $school_year, $data = [], $check = true)
    // {
    //     global $xoopsDB;

    //     //XOOPS表單安全檢查
    //     if ($check) {
    //         Tools::chk_scs_power(__FILE__, __LINE__, 'create', $stu_id);
    //         Utility::xoops_security_check();
    //     }

    //     $myts = \MyTextSanitizer::getInstance();

    //     $school_year           = (int) $school_year;
    //     $stu_grade             = addslashes($data['stu_grade']);
    //     $stu_class             = addslashes($data['stu_class']);
    //     $stu_seat_no           = addslashes($data['stu_seat_no']);
    //     $stu_height            = addslashes($data['stu_height']);
    //     $stu_weight            = addslashes($data['stu_weight']);
    //     $parental_relationship = addslashes($data['parental_relationship']);
    //     $family_atmosphere     = addslashes($data['family_atmosphere']);
    //     $father_discipline     = addslashes($data['father_discipline']);
    //     $mother_discipline     = addslashes($data['mother_discipline']);
    //     $environment           = addslashes($data['environment']);
    //     $accommodation         = addslashes($data['accommodation']);
    //     $economic              = addslashes($data['economic']);
    //     $money                 = addslashes($data['money']);
    //     $feel                  = addslashes($data['feel']);
    //     $favorite_subject      = implode(';', $data['favorite_subject']);
    //     $difficult_subject     = implode(';', $data['difficult_subject']);
    //     $expertise             = implode(';', $data['expertise']);
    //     $interest              = implode(';', $data['interest']);
    //     $club                  = addslashes($data['club']);
    //     $cadre                 = addslashes($data['cadre']);
    //     $stu_personality       = addslashes($data['stu_personality']);
    //     $stu_advantage         = addslashes($data['stu_advantage']);
    //     $stu_improve           = addslashes($data['stu_improve']);
    //     $fill_date             = date("Y-m-d H:i:s", xoops_getUserTimestamp(time()));
    //     $stu_difficult         = addslashes($data['stu_difficult']);
    //     $stu_need_help         = addslashes($data['stu_need_help']);

    //     $sql = "replace into `" . $xoopsDB->prefix("scs_general") . "` (
    //     `stu_id`,
    //     `school_year`,
    //     `stu_grade`,
    //     `stu_class`,
    //     `stu_seat_no`,
    //     `stu_height`,
    //     `stu_weight`,
    //     `parental_relationship`,
    //     `family_atmosphere`,
    //     `father_discipline`,
    //     `mother_discipline`,
    //     `environment`,
    //     `accommodation`,
    //     `economic`,
    //     `money`,
    //     `feel`,
    //     `favorite_subject`,
    //     `difficult_subject`,
    //     `expertise`,
    //     `interest`,
    //     `club`,
    //     `cadre`,
    //     `stu_personality`,
    //     `stu_advantage`,
    //     `stu_improve`,
    //     `fill_date`,
    //     `stu_difficult`,
    //     `stu_need_help`
    //     ) values(
    //     '{$stu_id}',
    //     '{$school_year}',
    //     '{$stu_grade}',
    //     '{$stu_class}',
    //     '{$stu_seat_no}',
    //     '{$stu_height}',
    //     '{$stu_weight}',
    //     '{$parental_relationship}',
    //     '{$family_atmosphere}',
    //     '{$father_discipline}',
    //     '{$mother_discipline}',
    //     '{$environment}',
    //     '{$accommodation}',
    //     '{$economic}',
    //     '{$money}',
    //     '{$feel}',
    //     '{$favorite_subject}',
    //     '{$difficult_subject}',
    //     '{$expertise}',
    //     '{$interest}',
    //     '{$club}',
    //     '{$cadre}',
    //     '{$stu_personality}',
    //     '{$stu_advantage}',
    //     '{$stu_improve}',
    //     '{$fill_date}',
    //     '{$stu_difficult}',
    //     '{$stu_need_help}'
    //     )";
    //     $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
    // }

    //以流水號秀出某筆scs_general資料內容
    public static function show($stu_id = '', $school_year = '')
    {
        global $xoopsDB, $xoopsTpl;

        if (empty($stu_id)) {
            return;
        } else {
            $stu_id = (int) $stu_id;
        }
        Tools::chk_scs_power(__FILE__, __LINE__, 'show', $stu_id, $school_year);

        $all = self::get($stu_id);

        $myts = \MyTextSanitizer::getInstance();

        //以下會產生這些變數： $stu_id, $school_year, $stu_grade, $stu_class, $stu_seat_no, $stu_height, $stu_weight, $parental_relationship, $family_atmosphere, $father_discipline, $mother_discipline, $environment, $accommodation, $economic, $money, $feel, $favorite_subject, $difficult_subject, $expertise, $interest, $club, $cadre, $stu_personality, $stu_advantage, $stu_improve, $fill_date, $stu_difficult, $stu_need_help
        $arr = [];
        foreach ($all as $g => $year_all) {
            foreach ($year_all as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $kk => $vv) {
                        $arr[$g][$k][$kk] = empty($vv) ? '　' : $myts->htmlSpecialChars($vv);
                    }
                } else {
                    $arr[$g][$k] = $$k = empty($v) ? '　' : $myts->htmlSpecialChars($v);
                }
            }
        }
        $xoopsTpl->assign('general', $arr);
    }

    //更新scs_general某一筆資料
    public static function update($stu_id, $school_year = '', $data = [], $check = true, $pass_empty = true)
    {
        global $xoopsDB;

        //XOOPS表單安全檢查
        if ($check) {
            Tools::chk_scs_power(__FILE__, __LINE__, 'update', $stu_id, $school_year);
            Utility::xoops_security_check();
        }

        // 使用一個關聯陣列來儲存所有欄位的值
        $fields = [];

        // 從 data 中提取 stu_grade
        if (isset($data['stu_grade'])) {
            $fields['stu_grade'] = $data['stu_grade'];
        }

        $update_item = [];
        $allowed_cols = ['stu_grade', 'stu_class', 'stu_seat_no', 'stu_height', 'stu_weight', 'parental_relationship', 'family_atmosphere', 'father_discipline', 'mother_discipline', 'environment', 'accommodation', 'economic', 'money', 'feel', 'favorite_subject', 'difficult_subject', 'expertise', 'interest', 'club', 'cadre', 'stu_personality', 'stu_advantage', 'stu_improve', 'fill_date', 'stu_difficult', 'stu_need_help'];
        // Utility::dd($data);
        foreach ($data as $col => $arr) {
            if (!in_array($col, $allowed_cols, true)) {
                continue;
            }
            if (!isset($fields[$col])) {
                $fields[$col] = [];
            }

            foreach ($arr as $key => $val) {
                if ($col == 'fill_date' and empty($val)) {
                    $val = date("Y-m-d");
                }
                if (empty($val) and $pass_empty) {
                    continue;
                }
                if (is_array($val)) {
                    $sub_arr = [];
                    foreach ($val as $k => $v) {
                        $sub_arr[$k] = addslashes($v);
                    }
                    $value = addslashes(implode(';', $sub_arr));
                } else {
                    $value = addslashes($val);
                }

                $fields[$col][$key]  = $value;
                $update_item[$key][] = "`$col` = '{$value}'";
            }
        }

        foreach ($fields['stu_grade'] as $k => $grade) {
            if (empty($school_year)) {
                continue;
            }

            if (empty($fields['stu_class'][$k])) {
                $fields['fill_date'][$k] = '';
            }

            $update_sql = implode(', ', $update_item[$k]);

            if (!empty($fields['stu_class'][$k]) and !empty($fields['stu_seat_no'][$k])) {
                $favorite_subject  = implode(';', (array) $fields['favorite_subject'][$k]);
                $difficult_subject = implode(';', (array) $fields['difficult_subject'][$k]);
                $expertise         = implode(';', (array) $fields['expertise'][$k]);
                $interest          = implode(';', (array) $fields['interest'][$k]);
                $sql               = "
                INSERT INTO `" . $xoopsDB->prefix("scs_general") . "`(
                    `stu_id`, `school_year`, `stu_grade`, `stu_class`, `stu_seat_no`, `stu_height`, `stu_weight`, `parental_relationship`, `family_atmosphere`, `father_discipline`, `mother_discipline`, `environment`, `accommodation`, `economic`, `money`, `feel`, `favorite_subject`, `difficult_subject`, `expertise`, `interest`, `club`, `cadre`, `stu_personality`, `stu_advantage`, `stu_improve`, `fill_date`, `stu_difficult`, `stu_need_help`
                ) VALUES(
                    '{$stu_id}', '{$school_year}', '{$grade}', '{$fields['stu_class'][$k]}', '{$fields['stu_seat_no'][$k]}', '{$fields['stu_height'][$k]}', '{$fields['stu_weight'][$k]}', '{$fields['parental_relationship'][$k]}', '{$fields['family_atmosphere'][$k]}', '{$fields['father_discipline'][$k]}', '{$fields['mother_discipline'][$k]}', '{$fields['environment'][$k]}', '{$fields['accommodation'][$k]}', '{$fields['economic'][$k]}', '{$fields['money'][$k]}', '{$fields['feel'][$k]}', '{$favorite_subject}', '{$difficult_subject}', '{$expertise}', '{$interest}', '{$fields['club'][$k]}', '{$fields['cadre'][$k]}', '{$fields['stu_personality'][$k]}', '{$fields['stu_advantage'][$k]}', '{$fields['stu_improve'][$k]}', '{$fields['fill_date'][$k]}', '{$fields['stu_difficult'][$k]}', '{$fields['stu_need_help'][$k]}'
                    )
                ON DUPLICATE KEY UPDATE
                $update_sql";
                $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);

            }
        }
    }

    //刪除scs_general某筆資料資料
    public static function destroy($stu_id = '', $school_year = '')
    {
        global $xoopsDB;
        Tools::chk_scs_power(__FILE__, __LINE__, 'destroy', $stu_id, $school_year);

        if (empty($stu_id) or empty($school_year)) {
            return;
        }

        $and_school_year = !empty($school_year) ? "and `school_year` = '$school_year'" : '';

        $sql = "replace into " . $xoopsDB->prefix("scs_general_del") . " select *
        from " . $xoopsDB->prefix("scs_general") . " where `stu_id` = '{$stu_id}' $and_school_year";
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);

        $sql = "delete from `" . $xoopsDB->prefix("scs_general") . "`
        where `stu_id` = '{$stu_id}' $and_school_year";
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);

    }

    //以流水號取得某筆scs_general資料
    public static function get($stu_id = '', $def_stu_grade = '', $get_year = false)
    {
        global $xoopsDB, $xoopsTpl;

        if (empty($stu_id)) {
            return;
        }

        // 各班導師
        $TadDataCenter = new TadDataCenter('scs');

        $and_stu_grade = '';
        if ($def_stu_grade) {
            $and_stu_grade = "and `stu_grade` = '{$def_stu_grade}' order by `stu_grade`";
        }
        $sql = "select * from `" . $xoopsDB->prefix("scs_general") . "`
        where `stu_id` = '{$stu_id}' {$and_stu_grade}";
        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $arr    = $school_year_to_grade    = [];
        while ($data = $xoopsDB->fetchArray($result)) {
            $g                            = $data['stu_grade'];
            $y                            = $data['school_year'];
            $arr[$g]                      = $data;
            $arr[$g]['favorite_subject']  = explode(';', $data['favorite_subject']);
            $arr[$g]['difficult_subject'] = explode(';', $data['difficult_subject']);
            $arr[$g]['expertise']         = explode(';', $data['expertise']);
            $arr[$g]['interest']          = explode(';', $data['interest']);
            $arr[$g]['grade_class']       = $grade_class       = "{$y}-{$g}-{$data['stu_class']}";
            $school_year_to_grade[$y]     = $g;

            $TadDataCenter->set_col('school_year_class', $y);
            $tea_uid = $TadDataCenter->getData($grade_class, 0);

            $uid_name = \XoopsUser::getUnameFromId($tea_uid, 1);
            if (empty($uid_name)) {
                $uid_name = \XoopsUser::getUnameFromId($tea_uid, 0);
            }
            $arr[$g]['class_tea'] = $tea_uid ? $uid_name : '';
        }

        if ($get_year) {
            return $school_year_to_grade;
        }

        if ($def_stu_grade) {
            return $arr[$def_stu_grade];
        } else {
            return $arr;
        }
    }

    //取得scs_general所有資料陣列
    public static function get_all()
    {
        global $xoopsDB;
        $sql      = "select * from `" . $xoopsDB->prefix("scs_general") . "`";
        $result   = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $data_arr = [];
        while ($data = $xoopsDB->fetchArray($result)) {
            $stu_id                          = $data['stu_id'];
            $school_year                     = $data['school_year'];
            $data_arr[$stu_id][$school_year] = $data;
        }
        return $data_arr;
    }

    //取得某學年度的班級資料
    public static function get_school_year_class($school_year)
    {
        global $xoopsDB;
        $class  = [];
        $sql    = "select stu_grade,stu_class,count(*) from `" . $xoopsDB->prefix("scs_general") . "` where school_year='{$school_year}' group by stu_grade,stu_class order by stu_grade,stu_class";
        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        while (list($stu_grade, $stu_class, $count) = $xoopsDB->fetchRow($result)) {
            $class[$stu_grade][$stu_class] = $count;
        }
        return $class;
    }

    //取得某班學生陣列
    public static function get_general_stu_arr($condition = [])
    {
        global $xoopsDB;
        $arr   = $where_condition   = [];
        $where = "";
        if ($condition) {
            foreach ($condition as $k => $v) {
                if (!preg_match('/^[A-Za-z0-9_]+$/', (string) $k)) {
                    return [];
                }
                $v = $xoopsDB->escape((string) $v);
                $where_condition[] = "a.`{$k}`='{$v}'";
            }
            $where = "where " . implode(' and ', $where_condition);
        }
        $sql = "select a.school_year, a.stu_grade, a.stu_class, a.stu_seat_no, b.* from `" . $xoopsDB->prefix("scs_general") . "` as a
        join `" . $xoopsDB->prefix("scs_students") . "` as b on a.`stu_id`=b.`stu_id`
        $where order by a.`school_year`, a.`stu_grade`, a.`stu_class`, a.`stu_seat_no`";
        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        while ($data = $xoopsDB->fetchArray($result)) {
            $stu_id       = $data['stu_id'];
            $arr[$stu_id] = $data;
        }
        return $arr;
    }
}
