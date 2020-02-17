<?php
use XoopsModules\Scs\Scs_brother_sister;
use XoopsModules\Scs\Scs_general;
use XoopsModules\Scs\Scs_guardian;
use XoopsModules\Scs\Scs_parents;
use XoopsModules\Scs\Scs_students;
use XoopsModules\Scs\Tools;
use XoopsModules\Tadtools\EasyResponsiveTabs;
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

/*-----------引入檔案區--------------*/
require_once __DIR__ . '/header.php';
$GLOBALS['xoopsOption']['template_main'] = 'scs_index.tpl';
require_once XOOPS_ROOT_PATH . '/header.php';
if (!$xoopsUser) {
    redirect_header(XOOPS_URL . '/modules/tad_login', 3, _TAD_PERMISSION_DENIED);
}

/*-----------功能函數區----------*/

function stu_edit_able()
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

/*-----------變數過濾----------*/
include_once $GLOBALS['xoops']->path('/modules/system/include/functions.php');
$op = system_CleanVars($_REQUEST, 'op', '', 'string');

$stu_id = !empty($_SESSION['stu_id']) ? (int) $_SESSION['stu_id'] : system_CleanVars($_REQUEST, 'stu_id', 0, 'int');

$school_year = system_CleanVars($_REQUEST, 'school_year', 0, 'int');
$parent_kind = system_CleanVars($_REQUEST, 'parent_kind', '', 'string');
$bs_relationship = system_CleanVars($_REQUEST, 'bs_relationship', '', 'string');
$files_sn = system_CleanVars($_REQUEST, 'files_sn', 0, 'int');
$stu_id_parent_kind = system_CleanVars($_REQUEST, 'stu_id_parent_kind', '', 'string');
$stu_id_school_year = system_CleanVars($_REQUEST, 'stu_id_school_year', '', 'string');
$stu_id_bs_relationship = system_CleanVars($_REQUEST, 'stu_id_bs_relationship', '', 'string');
$stu_grade = system_CleanVars($_REQUEST, 'stu_grade', 0, 'int');
$stu_class = system_CleanVars($_REQUEST, 'stu_class', 0, 'int');
$scs_students = system_CleanVars($_POST, 'scs_students', [], 'array');
$scs_general = system_CleanVars($_POST, 'scs_general', [], 'array');
$scs_parents = system_CleanVars($_POST, 'scs_parents', [], 'array');
$scs_guardian = system_CleanVars($_POST, 'scs_guardian', [], 'array');
$scs_brother_sister = system_CleanVars($_POST, 'scs_brother_sister', [], 'array');
/*-----------執行動作判斷區----------*/
switch ($op) {

    //更新資料
    case 'scs_students_store':
    case 'scs_students_update':
        Utility::xoops_security_check();
        $stu_id = Scs_students::update($stu_id, $scs_students, false, false);
        Scs_general::update($stu_id, $scs_general, false, false);
        Scs_parents::update($stu_id, $scs_parents, false, false);
        Scs_guardian::update($stu_id, $scs_guardian, false, false);
        Scs_brother_sister::update($stu_id, $scs_brother_sister, false);
        header("location: {$_SERVER['PHP_SELF']}?stu_id=$stu_id");
        exit;

    //修改用表單
    case 'scs_students_edit':
    case 'scs_students_create':
        $readonly = '';
        if ($_SESSION['stu_id']) {
            $edit_able = stu_edit_able();
            if (!$edit_able) {
                redirect_header($_SERVER['PHP_SELF'], 3, '尚未開放填寫');
            }
            $readonly = 'readonly';
            $edit_grade = [1 => 'readonly', 'readonly', 'readonly'];
            $school_year = Tools::get_school_year();
            $year_arr = Scs_general::get($stu_id, '', true);
            $grade = $year_arr[$school_year];
            $edit_grade[$grade] = '';
        }
        $xoopsTpl->assign('readonly', $readonly);
        $xoopsTpl->assign('edit_grade', $edit_grade);

        Scs_students::create($stu_id);
        Scs_general::create($stu_id);
        Scs_parents::create($stu_id);
        Scs_guardian::create($stu_id);
        Scs_brother_sister::create($stu_id);
        Tools::menu_option($stu_id);

        $EasyResponsiveTabs = new EasyResponsiveTabs('#demoTab');
        $EasyResponsiveTabs->rander();
        $op = 'scs_students_create';

        break;

    default:
        if ($_SESSION['stu_id']) {
            stu_edit_able();
        }
        if (!empty($stu_id)) {
            if (!empty($_SESSION['tea_class_arr'])) {
                $school_year = Tools::get_school_year();
                list($school_year, $stu_grade, $stu_class) = explode('-', $_SESSION['tea_class_arr'][$school_year]);
                $stu_arr = Scs_general::get($stu_id);
                if (!in_array($stu_arr[$stu_grade]['grade_class'], $_SESSION['tea_class_arr'])) {
                    redirect_header($_SERVER['PHP_SELF'], 3, "該學生並非您任教的學生，故無法管理。");
                }
            }
            Scs_general::show($stu_id);
            Scs_students::show($stu_id);
            Scs_parents::show($stu_id);
            Scs_guardian::show($stu_id);
            Scs_brother_sister::show($stu_id);
            Tools::menu_option($stu_id);
            $op = 'scs_students_show';
        } else {
            if (!empty($_SESSION['tea_class_arr'])) {
                $school_year = Tools::get_school_year();
                list($school_year, $stu_grade, $stu_class) = explode('-', $_SESSION['tea_class_arr'][$school_year]);
            }
            Scs_general::index($school_year, $stu_grade, $stu_class);
            Tools::menu_option($stu_id);
            $op = 'scs_general_index';
        }
        break;
}

/*-----------秀出結果區--------------*/
$xoopsTpl->assign('toolbar', Utility::toolbar_bootstrap($interface_menu));
$xoopsTpl->assign('now_op', $op);
$xoTheme->addStylesheet(XOOPS_URL . '/modules/scs/css/module.css');
$xoTheme->addStylesheet(XOOPS_URL . '/modules/tadtools/css/my-input.css');
require_once XOOPS_ROOT_PATH . '/footer.php';
