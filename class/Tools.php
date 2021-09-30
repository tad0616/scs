<?php
namespace XoopsModules\Scs;

use XoopsModules\Scs\Scs_general;
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

/**
 * Class Tools
 */
class Tools
{

    public static function isStudent()
    {
        global $xoopsUser, $xoopsDB;
        if ($xoopsUser->user_icq() == 'student') {
            $email = $xoopsUser->email();
            $name = $xoopsUser->name();
            $stu_grade = $xoopsUser->user_from();
            if ($stu_grade) {
                $_SESSION['stu_stage'] = ($stu_grade >= 7) ? '國中' : '國小';
                $_SESSION['stages'] = ($stu_grade >= 7) ? ['七' => 7, '八' => 8, '九' => 9] : ['一' => 1, '二' => 2, '三' => 3, '四' => 4, '五' => 5, '六' => 6];
            }
            $stu_class = $xoopsUser->user_sig();
            $school_year = self::get_school_year();
            if ($email) {
                $sql = "select `stu_id` from `" . $xoopsDB->prefix("scs_students") . "`
                where `stu_email`='{$email}'";
                $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
                list($stu_id) = $xoopsDB->fetchRow($result);
            }

            if (empty($stu_id)) {
                $sql = "select a.`stu_id` from `" . $xoopsDB->prefix("scs_students") . "` as a
                join `" . $xoopsDB->prefix("scs_general") . "` as b on a.`stu_id` = b.`stu_id`
                where a.`stu_name`='{$name}' and b.`stu_grade`='{$stu_grade}' and b.`stu_class`='{$stu_class}' and b.`school_year`='{$school_year}'";
                // die($sql);
                $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
                $total = $xoopsDB->getRowsNum($result);
                if ($total > 1) {
                    redirect_header($_SERVER['PHP_SELF'], 3, "{$name} 共有 {$total} 筆同名資料，請設定學生電子郵件（OpenID用的Email）以便精確判斷。");
                } else {
                    list($stu_id) = $xoopsDB->fetchRow($result);
                }
            }

            return $stu_id;
        }
        return false;
    }

    public static function isTeacher($kind = '', $uid = '', $return_arr = true)
    {
        global $xoopsUser, $xoopsDB;
        if ($xoopsUser->user_icq() == 'teacher') {

            $and_data_name = !empty($kind) ? "and `data_name`='$kind'" : '';

            if (empty($uid)) {
                $uid = $xoopsUser->uid();
            }
            $sql = "select `col_sn`,`data_name` from `" . $xoopsDB->prefix("scs_data_center") . "`
            where `col_name`='school_year_class' and `data_value`='{$uid}' $and_data_name order by col_sn desc";
            $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);

            if (!empty($kind)) {
                $year = [];
                while (list($year, $class) = $xoopsDB->fetchRow($result)) {
                    $years[$year] = $year;
                }
                if (!empty($years)) {
                    if ($return_arr) {
                        return $years;
                    } else {
                        return true;
                    }
                }
            } else {
                $tea_class_arr = [];
                while (list($year, $class) = $xoopsDB->fetchRow($result)) {
                    if (strpos($class, '-') !== false) {
                        $tea_class_arr[$year] = $class;
                    }
                }
                if (!empty($tea_class_arr)) {
                    if ($return_arr) {
                        return $tea_class_arr;
                    } else {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    public static function get_school_teachers()
    {
        global $xoopsDB, $xoopsModuleConfig, $xoopsModule;

        if (!isset($xoopsModuleConfig)) {
            $modhandler = xoops_gethandler('module');
            $xoopsModule = $modhandler->getByDirname("scs");
            $config_handler = xoops_gethandler('config');
            $xoopsModuleConfig = $config_handler->getConfigsByCat(0, $xoopsModule->mid());
        }

        if (empty($xoopsModuleConfig['school_code'])) {
            $mid = $xoopsModule->mid();
            redirect_header(XOOPS_URL . '/modules/system/admin.php?fct=preferences&op=showmod&mod=' . $mid, 3, '請先至偏好設定，設定「教育部學校代碼」');
        }

        $teachers = [];
        $schools = explode(';', $xoopsModuleConfig['school_code']);
        foreach ($schools as $school_code) {
            $sql = "select `uid`,`name`,`uname` from `" . $xoopsDB->prefix("users") . "`
            where `user_intrest`='{$school_code}' and `user_icq`='teacher' order by `name`,`uname`";
            $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
            while (list($uid, $name, $uname) = $xoopsDB->fetchRow($result)) {
                $teachers[$uid]['name'] = $name;
                $teachers[$uid]['uname'] = $uname;
            }

        }

        return $teachers;
    }

    // 檢查是否有權限
    public static function chk_scs_power($file, $line, $kind = '', $stu_id = '', $school_year = '', $stu_grade = '', $stu_class = '', $mode = '')
    {
        //          觀看學生資料    編輯學生資料    刪除學生資料    新增學生資料
        // 管 理 員  全部           全部            全部            全部
        // 輔導主任  全部           全部            全部            全部
        // 專輔教師  全部           不可            不可            不可
        // 班級導師  自己班學生     自己班學生       不可            不可
        // 班級學生  自己           自己(限制時程內) 不可            不可

        switch ($kind) {
            case 'index':
                if ($_SESSION['scs_adm'] or $_SESSION['counselor'] or $_SESSION['tutor']) {
                    return true;
                } elseif ($_SESSION['tea_class_arr']) {
                    if (in_array("{$school_year}-{$stu_grade}-{$stu_class}", $_SESSION['tea_class_arr'])) {
                        return true;
                    }
                }
                break;

            case 'show':
                if ($_SESSION['scs_adm'] or $_SESSION['counselor'] or $_SESSION['tutor']) {
                    return true;
                } elseif ($_SESSION['tea_class_arr']) {
                    $stu = Scs_general::get($stu_id);
                    foreach ($stu as $student) {
                        if (in_array($student['grade_class'], $_SESSION['tea_class_arr'])) {
                            return true;
                        }
                    }
                } elseif ($_SESSION['stu_id'] and $_SESSION['stu_id'] == $stu_id) {
                    return true;
                }
                break;

            case 'create':
                if ($_SESSION['scs_adm'] or $_SESSION['counselor']) {
                    return true;
                } elseif ($_SESSION['tea_class_arr']) {
                    $stu = Scs_general::get($stu_id);
                    foreach ($stu as $student) {
                        if (in_array($student['grade_class'], $_SESSION['tea_class_arr'])) {
                            return true;
                        }
                    }
                } elseif ($_SESSION['stu_id'] and $_SESSION['stu_id'] == $stu_id and self::stu_edit_able()) {
                    return true;
                }
                break;

            case 'update':
                if ($_SESSION['scs_adm'] or $_SESSION['counselor']) {
                    return true;
                } elseif ($_SESSION['tea_class_arr']) {
                    $stu = Scs_general::get($stu_id);
                    foreach ($stu as $student) {
                        if (in_array($student['grade_class'], $_SESSION['tea_class_arr'])) {
                            return true;
                        }
                    }
                } elseif ($_SESSION['stu_id'] and $_SESSION['stu_id'] == $stu_id and self::stu_edit_able()) {
                    return true;
                }
                break;

            case 'destroy':
                if ($_SESSION['scs_adm'] or $_SESSION['counselor']) {
                    return true;
                }
                break;
        }

        if ($mode == 'return') {
            return false;
        } else {
            $file = \addslashes($file);
            redirect_header($_SERVER['HTTP_REFERER'], 3, _TAD_PERMISSION_DENIED . "<div>$file:$line</div>");
        }

    }
    // 檢查是否有輔導權限
    public static function chk_consult_power($file, $line, $kind = '', $stu_id = '', $consult_id = '', $consult_uid = '', $mode = '')
    {
        global $xoopsUser;
        //             新增輔導紀錄     觀看輔導紀錄
        // 管 理 員     不可               不可
        // 輔導主任     任一學生            任一學生/導師.專輔紀錄
        // 專輔教師     任一學生            自己個案紀錄/導師紀錄
        // 班級導師     自己班學生          自己班學生/自己的紀錄
        // 班級學生     不可                不可

        switch ($kind) {
            // 觀看學生的輔導列表
            case 'index':
                if ($_SESSION['counselor'] or $_SESSION['tutor']) {
                    return true;
                } elseif ($_SESSION['tea_class_arr']) {
                    $stu = Scs_general::get($stu_id);
                    foreach ($stu as $student) {
                        if (in_array($student['grade_class'], $_SESSION['tea_class_arr'])) {
                            return true;
                        }
                    }
                }
                break;

            // 觀看輔導員輔導紀錄列表
            case 'counselor_index':
                if ($_SESSION['counselor']) {
                    return true;
                } elseif ($_SESSION['tutor']) {
                    $consult = Scs_consult::get($consult_id);
                    $now_uid = $xoopsUser->uid();
                    if ($consult['consult_uid'] == $now_uid) {
                        return true;
                    }
                }
                break;

            // 觀看某學生完整紀錄pdf
            case 'show':
                if ($_SESSION['counselor']) {
                    return true;
                } elseif ($_SESSION['tutor']) {
                    $consult = Scs_consult::get($consult_id);
                    $now_uid = $xoopsUser->uid();
                    if ($consult['consult_uid'] == $now_uid or self::isTeacher('', $consult['consult_uid'], false)) {
                        return true;
                    }
                } elseif ($_SESSION['tea_class_arr']) {
                    $stu = Scs_general::get($stu_id);
                    $consult = Scs_consult::get($consult_id);
                    $now_uid = $xoopsUser->uid();

                    foreach ($stu as $student) {
                        if (in_array($student['grade_class'], $_SESSION['tea_class_arr'])) {
                            if ($consult['consult_uid'] == $now_uid) {
                                return true;
                            } else {
                                // 若之前的發布者是舊班導，那也可以看，但無法刪或編輯
                                if (self::isTeacher('', $consult['consult_uid'], false)) {
                                    return true;
                                }
                            }
                        }
                    }
                }
                break;

            case 'create':
                if ($_SESSION['counselor'] or $_SESSION['tutor']) {
                    return true;
                } elseif ($_SESSION['tea_class_arr']) {
                    $stu = Scs_general::get($stu_id);
                    foreach ($stu as $student) {
                        if (in_array($student['grade_class'], $_SESSION['tea_class_arr'])) {
                            return true;
                        }
                    }
                }
                break;

            case 'update':
                if ($_SESSION['counselor']) {
                    return true;
                } elseif ($_SESSION['tutor']) {
                    $consult = Scs_consult::get($consult_id);
                    $now_uid = $xoopsUser->uid();
                    if ($consult['consult_uid'] == $now_uid) {
                        return true;
                    }
                } elseif ($_SESSION['tea_class_arr']) {
                    $stu = Scs_general::get($stu_id);
                    $consult = Scs_consult::get($consult_id);
                    $now_uid = $xoopsUser->uid();
                    foreach ($stu as $student) {
                        if (in_array($student['grade_class'], $_SESSION['tea_class_arr'])) {
                            return true;
                        }
                    }
                }
                break;

            // 觀看統計或報表界面
            case 'statistics':
                if ($_SESSION['counselor']) {
                    return true;
                } elseif ($_SESSION['tutor']) {
                    $now_uid = $xoopsUser->uid();
                    if ($consult_uid == $now_uid) {
                        return true;
                    }
                }
                break;

            // 下載某學生完整紀錄pdf
            case 'download':
                if ($_SESSION['counselor'] or $_SESSION['tutor']) {
                    return true;
                } elseif ($_SESSION['tea_class_arr']) {
                    $stu = Scs_general::get($stu_id);
                    foreach ($stu as $student) {
                        if (in_array($student['grade_class'], $_SESSION['tea_class_arr'])) {
                            return true;
                        }
                    }
                }
                break;

            case 'destroy':
                if ($_SESSION['scs_adm'] or $_SESSION['counselor']) {
                    return true;
                }
                break;

        }

        if ($mode == 'return') {
            return false;
        } else {
            $file = \addslashes($file);
            redirect_header($_SERVER['HTTP_REFERER'], 3, _TAD_PERMISSION_DENIED . "<div>$file:$line</div>");
        }

    }

    public static function stu_edit_able()
    {
        global $xoopsTpl;
        $TadDataCenter = new TadDataCenter('scs');
        $school_year = Tools::get_school_year();
        $TadDataCenter->set_col('school_year_class', $school_year);
        $setup = $TadDataCenter->getData();
        $xoopsTpl->assign('setup', $setup);
        $now = time();
        $start = strtotime($setup['stu_start_sign'][0]);
        $stop = strtotime($setup['stu_stop_sign'][0]);
        $edit_able = ($now >= $start and $now <= $stop) ? true : false;
        $xoopsTpl->assign('edit_able', $edit_able);
        return $edit_able;
    }

    //取得學年度
    public static function get_school_year()
    {
        global $xoopsDB;
        // $sql = "select max(school_year) from `" . $xoopsDB->prefix("scs_general") . "`";
        // $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        // list($school_year) = $xoopsDB->fetchRow($result);
        // if (empty($school_year)) {
        $y = date('Y');
        $m = date('n');
        if ($m >= 8) {
            $school_year = $y - 1911;
        } else {
            $school_year = $y - 1912;
        }
        // }
        return $school_year;
    }

    // 給選單用
    public static function menu_option($stu_id = '', $def_school_year = '', $def_stu_grade = '', $def_stu_class = '')
    {
        global $xoopsTpl, $xoopsDB;
        $xoopsTpl->assign('stu_id', $stu_id);

        $and_stu_id = '';
        if ($stu_id) {
            $and_stu_id = "and `stu_id` = '{$stu_id}'";
        }

        $and_stu_grade = '';
        if ($def_stu_grade) {
            $and_stu_grade = "and `stu_grade` = '{$def_stu_grade}'";
            $xoopsTpl->assign('stu_grade', $def_stu_grade);
        }

        $and_stu_class = '';
        if ($def_stu_class) {
            $and_stu_class = "and `stu_class` = '{$def_stu_class}'";
            $xoopsTpl->assign('stu_class', $def_stu_class);
        }

        $sql = "select * from `" . $xoopsDB->prefix("scs_general") . "`
        where 1 {$and_stu_id} {$and_stu_grade} {$and_stu_class} order by `stu_grade`, `stu_class`, `stu_class`, `stu_seat_no`";

        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $arr = $school_year_to_grade = [];
        while ($data = $xoopsDB->fetchArray($result)) {
            $g = $data['stu_grade'];
            $y = $data['school_year'];
            $arr[$g] = $data;
            $arr[$g]['favorite_subject'] = explode(';', $data['favorite_subject']);
            $arr[$g]['difficult_subject'] = explode(';', $data['difficult_subject']);
            $arr[$g]['expertise'] = explode(';', $data['expertise']);
            $arr[$g]['interest'] = explode(';', $data['interest']);
            $arr[$g]['grade_class'] = "{$y}-{$g}-{$data['stu_class']}";
            $school_year_to_grade[$y] = $g;
        }

        $school_year = $def_school_year ? $def_school_year : self::get_school_year();
        $xoopsTpl->assign('school_year', $school_year);

        $school_year_arr = self::get_general_data_arr('scs_general', 'school_year');
        $xoopsTpl->assign('school_year_arr', $school_year_arr);

        $condition['school_year'] = $school_year;
        $stu_grade_arr = self::get_general_data_arr('scs_general', 'stu_grade', $condition);
        $xoopsTpl->assign('stu_grade_arr', $stu_grade_arr);

        $menu_stu_grade = $school_year_to_grade[$school_year];

        if (!empty($menu_stu_grade)) {
            if ($stu_id) {
                $xoopsTpl->assign('stu_grade', $menu_stu_grade);
            }

            $condition['stu_grade'] = $menu_stu_grade;
            $stu_class_arr = self::get_general_data_arr('scs_general', 'stu_class', $condition);
            $xoopsTpl->assign('stu_class_arr', $stu_class_arr);
        }

        if (!empty($arr[$menu_stu_grade]['stu_class'])) {
            if ($stu_id) {
                $xoopsTpl->assign('stu_class', $arr[$menu_stu_grade]['stu_class']);
            }

            $condition['stu_class'] = $arr[$menu_stu_grade]['stu_class'];
            $stu_arr = Scs_general::get_general_stu_arr($condition);
            $xoopsTpl->assign('stu_arr', $stu_arr);
        }

        if ($stu_id) {
            $sql = "select stu_seat_no,school_year,stu_grade,stu_class from `" . $xoopsDB->prefix("scs_general") . "`
            where stu_id ='{$stu_id}'";
            $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
            list($stu_seat_no, $school_year, $stu_grade, $stu_class) = $xoopsDB->fetchRow($result);
            $xoopsTpl->assign('stu_seat_no', $stu_seat_no);

            // 下一筆
            $sql = "select a.stu_id,a.stu_seat_no,b.stu_name from `" . $xoopsDB->prefix("scs_general") . "` as a
            join `" . $xoopsDB->prefix("scs_students") . "` as b on a.stu_id=b.stu_id
            where a.stu_seat_no > {$stu_seat_no} and a.school_year='{$school_year}' and a.stu_grade='{$stu_grade}' and a.stu_class='{$stu_class}'
            order by a.`stu_seat_no`  LIMIT 0,1";
            $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
            $next = $xoopsDB->fetchArray($result);
            $xoopsTpl->assign('next', $next);

            // 上一筆
            $sql = "select a.stu_id,a.stu_seat_no,b.stu_name from `" . $xoopsDB->prefix("scs_general") . "` as a
            join `" . $xoopsDB->prefix("scs_students") . "` as b on a.stu_id=b.stu_id
            where a.stu_seat_no < {$stu_seat_no} and a.school_year='{$school_year}' and a.stu_grade='{$stu_grade}' and a.stu_class='{$stu_class}'
            order by a.`stu_seat_no` DESC LIMIT 0,1";
            $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
            $previous = $xoopsDB->fetchArray($result);
            $xoopsTpl->assign('previous', $previous);
        }
    }

    // 將偏好設定轉為陣列
    public static function get_config_arr($mode = 'assign', $name = '', $col = '')
    {
        global $xoopsTpl, $xoopsModuleConfig;

        $def_arr = explode(';', $xoopsModuleConfig[$name]);
        $col = empty($col) ? $name : $col;
        // $db_arr = self::get_general_data_arr($table, $col);
        // $all_arr = array_merge($def_arr, $db_arr);
        $arr = array_unique($def_arr);
        if ($mode == 'return') {
            return $arr;
        } else {
            $xoopsTpl->assign($name . '_arr', $arr);
        }
    }

    //轉為民國
    public static function tw_birthday($birthday = '')
    {
        list($y, $m, $d) = explode('-', $birthday);
        $y = $y - 1911;
        return "{$y}-{$m}-{$d}";
    }

    //取得某項陣列
    public static function get_general_data_arr($table = '', $col = 'school_year', $condition = [])
    {
        global $xoopsDB;
        $arr = $where_condition = [];
        $where = "";
        if ($condition) {
            foreach ($condition as $k => $v) {
                $where_condition[] = "`{$k}`='{$v}'";
            }
            $where = "where " . implode(' and ', $where_condition);
        }
        $sql = "select `{$col}` from `" . $xoopsDB->prefix($table) . "` $where group by `{$col}` order by `{$col}`";
        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        while (list($data) = $xoopsDB->fetchRow($result)) {
            if (empty($data)) {
                continue;
            }
            if (strpos($data, ';') !== false) {
                $opt_arr = explode(';', $data);
                foreach ($opt_arr as $opt) {
                    $arr[] = $opt;
                }
            } else {
                $arr[] = $data;
            }

        }
        return $arr;
    }

    public static function array_key_last($array)
    {
        if (!is_array($array) || empty($array)) {
            return null;
        }

        return array_keys($array)[count($array) - 1];
    }

    public static function array_key_first(array $arr)
    {
        foreach ($arr as $key => $unused) {
            return $key;
        }
        return null;
    }
}
