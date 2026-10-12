<?php
use Xmf\Request;
use XoopsModules\Scs\Scs_general;
use XoopsModules\Scs\Tools;
use XoopsModules\Tadtools\Utility;

include_once '../../mainfile.php';
include_once 'header.php';

if (!is_object($xoopsUser) || (empty($_SESSION['scs_adm']) && empty($_SESSION['counselor']) && empty($_SESSION['tutor']) && empty($_SESSION['tea_class_arr']))) {
    http_response_code(403);
    exit;
}

$op = Request::getString('op');
$school_year = Request::getInt('school_year');
$stu_grade = Request::getInt('stu_grade');
$stu_class = Request::getInt('stu_class');
$stu_id = Request::getInt('stu_id');
$checkClassAccess = static function () use ($school_year, $stu_grade, $stu_class): void {
    if (!Tools::chk_scs_power(__FILE__, __LINE__, 'index', '', $school_year, $stu_grade, $stu_class, 'return')) {
        http_response_code(403);
        exit;
    }
};

switch ($op) {
    case 'get_teachers':
        $all_teachers = [];
        foreach (Tools::get_school_teachers() as $uid => $teacher) {
            $all_teachers[] = ['badge badge-default' => htmlspecialchars((string) $teacher['name'] . ' (' . $teacher['uname'] . ')', ENT_QUOTES, _CHARSET), 'value' => (int) $uid];
        }
        Utility::dd($all_teachers);
        break;
    case 'get_stu_grade_option':
        $checkClassAccess();
        $option = '<option value="">請選擇年級</option>';
        foreach (Tools::get_general_data_arr('scs_general', 'stu_grade', ['school_year' => $school_year]) as $val) {
            $option .= '<option value="' . (int) $val . '">' . (int) $val . '</option>';
        }
        die($option);
    case 'get_stu_class_option':
        $checkClassAccess();
        $option = '<option value="">請選擇班級</option>';
        foreach (Tools::get_general_data_arr('scs_general', 'stu_class', ['school_year' => $school_year, 'stu_grade' => $stu_grade]) as $val) {
            $option .= '<option value="' . (int) $val . '">' . (int) $val . '</option>';
        }
        die($option);
    case 'get_stu_name_option':
        $checkClassAccess();
        $option = '<option value="">請選擇學生</option>';
        foreach (Scs_general::get_general_stu_arr(['school_year' => $school_year, 'stu_grade' => $stu_grade, 'stu_class' => $stu_class]) as $stu) {
            $selected = ((int) $stu['stu_id'] === $stu_id) ? 'selected' : '';
            $option .= '<option value="' . (int) $stu['stu_id'] . '" ' . $selected . '>' . htmlspecialchars((string) $stu['stu_name'], ENT_QUOTES, _CHARSET) . '</option>';
        }
        die($option);
}
