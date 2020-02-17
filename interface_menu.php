<?php
use XoopsModules\Scs\Tools;
//判斷是否對該模組有管理權限
if (!isset($_SESSION['scs_adm'])) {
    $_SESSION['scs_adm'] = ($xoopsUser) ? $xoopsUser->isAdmin() : false;
}

// 若是學生（其值是編號）
if (!isset($_SESSION['stu_id'])) {
    $_SESSION['stu_id'] = ($xoopsUser) ? Tools::isStudent() : false;
}
// 若是老師（其值是班級陣列）
if (!isset($_SESSION['tea_class_arr'])) {
    $_SESSION['tea_class_arr'] = ($xoopsUser) ? Tools::isTeacher() : false;
}

$interface_menu[_TAD_TO_MOD] = "index.php";
$interface_icon[_TAD_TO_MOD] = "fa-chevron-right";
// if (empty($_SESSION['stu_id'])) {
//     $interface_menu[_MD_SCS_PAGE_1] = "consult.php";
//     $interface_icon[_MD_SCS_PAGE_1] = "fa-chevron-right";
// }

if ($_SESSION['scs_adm']) {
    $interface_menu[_TAD_TO_ADMIN] = "admin/main.php";
    $interface_icon[_TAD_TO_ADMIN] = "fa-sign-in";
}
