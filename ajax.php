<?php
use Xmf\Request;
use XoopsModules\Scs\Scs_general;
use XoopsModules\Scs\Tools;
use XoopsModules\Tadtools\Utility;

include_once "../../mainfile.php";
include_once "header.php";

$op = Request::getString('op');
$school_year = Request::getInt('school_year');
$stu_grade = Request::getInt('stu_grade');
$stu_id = Request::getInt('stu_id');

switch ($op) {

    case "get_teachers":
        $teachers = Tools::get_school_teachers();
        $all_teachers = [];
        foreach ($teachers as $uid => $teacher) {
            $all_teachers[] = array("label" => "{$teacher['name']} ({$teacher['uname']})", "value" => $uid);
        }
        Utility::dd($all_teachers);
        break;

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
