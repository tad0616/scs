<?php
namespace XoopsModules\Scs;

use XoopsModules\Scs\Scs_general;

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

    public static function isTeacher()
    {
        global $xoopsUser, $xoopsDB;
        if ($xoopsUser->user_icq() == 'teacher') {
            $uid = $xoopsUser->uid();
            $sql = "select `col_sn`,`data_name` from `" . $xoopsDB->prefix("scs_data_center") . "`
            where `col_name`='school_year_class' and `data_value`='{$uid}' order by col_sn desc";
            $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
            $tea_class_arr = [];
            while (list($year, $class) = $xoopsDB->fetchRow($result)) {
                $tea_class_arr[$year] = $class;
            }
            return $tea_class_arr;
        }
        return false;
    }

    public static function get_school_teachers()
    {
        global $xoopsUser, $xoopsDB, $xoopsModuleConfig, $xoopsModule;

        if (empty($xoopsModuleConfig['school_code'])) {
            $mid = $xoopsModule->mid();
            redirect_header(XOOPS_URL . '/modules/system/admin.php?fct=preferences&op=showmod&mod=' . $mid, 3, '請先至偏好設定，設定「教育部學校代碼」');
        }
        $sql = "select `uid`,`name`,`uname` from `" . $xoopsDB->prefix("users") . "`
        where `user_intrest`='{$xoopsModuleConfig['school_code']}' and `user_icq`='teacher'";
        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        while (list($uid, $name, $uname) = $xoopsDB->fetchRow($result)) {
            $teachers[$uid]['name'] = $name;
            $teachers[$uid]['uname'] = $uname;
        }

        return $teachers;
    }

    public static function chk_have_power()
    {
        if (!$_SESSION['tea_class_arr'] and !$_SESSION['stu_id'] and !$_SESSION['scs_adm'] and strpos($_SERVER['PHP_SELF'], '/admin/') === false) {
            redirect_header($_SERVER['PHP_SELF'], 3, _TAD_PERMISSION_DENIED);
        }
    }

    //取得學年度
    public static function get_school_year()
    {
        global $xoopsDB;
        $sql = "select max(school_year) from `" . $xoopsDB->prefix("scs_general") . "`";
        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        list($school_year) = $xoopsDB->fetchRow($result);
        if (empty($school_year)) {
            $y = date('Y');
            $m = date('n');
            if ($m >= 8) {
                $school_year = $y - 1911;
            } else {
                $school_year = $y - 1912;
            }
        }
        return $school_year;
    }

    // 給選單用
    public static function menu_option($stu_id = '', $def_stu_grade = '', $def_stu_class = '')
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

        $school_year = self::get_school_year();
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
            $sql = "select stu_seat_no,stu_grade,stu_class from `" . $xoopsDB->prefix("scs_general") . "`
            where stu_id ='{$stu_id}'";
            $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
            list($stu_seat_no, $stu_grade, $stu_class) = $xoopsDB->fetchRow($result);

            // 下一筆
            $sql = "select stu_id from `" . $xoopsDB->prefix("scs_general") . "`
            where stu_seat_no > {$stu_seat_no} and stu_grade='{$stu_grade}' and stu_class='{$stu_class}' order by `stu_seat_no`  LIMIT 0,1";
            $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
            list($next_stu_id) = $xoopsDB->fetchRow($result);
            $xoopsTpl->assign('next_stu_id', $next_stu_id);

            // 上一筆
            $sql = "select stu_id from `" . $xoopsDB->prefix("scs_general") . "`
            where stu_seat_no < {$stu_seat_no} and stu_grade='{$stu_grade}' and stu_class='{$stu_class}' order by `stu_seat_no` DESC LIMIT 0,1";
            $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
            list($previous_stu_id) = $xoopsDB->fetchRow($result);
            $xoopsTpl->assign('previous_stu_id', $previous_stu_id);
        }
    }

    public static function get_config_arr($table = '', $name = '', $col = '')
    {
        global $xoopsTpl, $xoopsModuleConfig;

        $def_arr = explode(';', $xoopsModuleConfig[$name]);
        $col = empty($col) ? $name : $col;
        $db_arr = self::get_general_data_arr($table, $col);
        $all_arr = array_merge($db_arr, $def_arr);
        $arr = array_unique($all_arr);
        $xoopsTpl->assign($name . '_arr', $arr);
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

}
