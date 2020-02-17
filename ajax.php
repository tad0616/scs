<?php
use XoopsModules\Scs\Scs_general;
use XoopsModules\Scs\Tools;
use XoopsModules\Tadtools\Utility;

include_once "../../mainfile.php";
include_once "header.php";

include_once XOOPS_ROOT_PATH . '/modules/system/include/functions.php';
$op = system_CleanVars($_REQUEST, 'op', '', 'string');
$school_year = system_CleanVars($_REQUEST, 'school_year', '', 'int');
$stu_grade = system_CleanVars($_REQUEST, 'stu_grade', '', 'int');
$stu_id = system_CleanVars($_REQUEST, 'stu_id', '', 'int');

switch ($op) {
    case "get_stu_grade_option":
        $condition['school_year'] = $school_year;
        $arr = Tools::get_general_data_arr('scs_general', 'stu_grade', $condition);
        $option = "<option value=''>選年級</option>";
        foreach ($arr as $val) {
            $option .= "<option value='$val'>{$val}年</option>";
        }
        die($option);
        break;

    case "get_stu_class_option":
        $condition['school_year'] = $school_year;
        $condition['stu_grade'] = $stu_grade;
        $arr = Tools::get_general_data_arr('scs_general', 'stu_class', $condition);
        $option = "<option value=''>選班級</option>";
        foreach ($arr as $val) {
            $option .= "<option value='$val'>{$val}班</option>";
        }
        die($option);
        break;

    case "get_stu_name_option":
        $condition['school_year'] = $school_year;
        $condition['stu_grade'] = $stu_grade;
        $condition['stu_class'] = $stu_class;
        $students = Scs_general::get_general_stu_arr($condition);
        $option = "<option value=''>選學生</option>";
        foreach ($students as $stu) {
            $selected = $stu['stu_id'] == $stu_id ? 'selected' : '';
            $option .= "<option value='{$stu['stu_id']}' $selected>{$stu['stu_name']}</option>";
        }
        die($option);
        break;
}
