<?php
use XoopsModules\Scs\Scs_general;
use XoopsModules\Scs\Tools;
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
$GLOBALS['xoopsOption']['template_main'] = 'scs_adm_main.tpl';
require_once __DIR__ . '/header.php';
require_once dirname(__DIR__) . '/function.php';
$_SESSION['scs_adm'] = true;
$TadDataCenter = new TadDataCenter('scs');

/*-----------功能函數區----------*/

function scs_teacher_setup($school_year = '')
{
    global $xoopsDB, $xoopsTpl, $xoopsModuleConfig, $TadDataCenter;
    if (empty($school_year)) {
        $school_year = Tools::get_school_year();
    }
    $myts = \MyTextSanitizer::getInstance();
    $all_class = Scs_general::get_school_year_class($school_year);
    $xoopsTpl->assign('school_year', $school_year);
    $xoopsTpl->assign('all_class', $all_class);
    $teachers = Tools::get_school_teachers();
    $xoopsTpl->assign('teachers', $teachers);
    Utility::get_jquery(true);

    $TadDataCenter->set_col('school_year_class', $school_year);
    $data = $TadDataCenter->getData();
    $xoopsTpl->assign('setup', $data);

    $school_year_arr = Tools::get_general_data_arr('scs_general', 'school_year');
    $xoopsTpl->assign('school_year_arr', $school_year_arr);
}

// 儲存設定
function save_class_teacher($school_year, $class_teacher)
{
    global $TadDataCenter;
    $TadDataCenter->set_col('school_year_class', $school_year);
    $data_arr = [];
    foreach ($class_teacher as $class => $val) {
        if (is_array($val)) {
            foreach ($val as $i => $v) {
                $data_arr[$class][$i] = $v;
            }
        } else {
            $data_arr[$class][0] = $val;
        }
    }
    $TadDataCenter->saveCustomData($data_arr);

    $TadDataCenter->set_col('teacher_name', $school_year);
    $data_arr = [];
    foreach ($class_teacher as $class => $val) {
        if (is_array($val)) {
            foreach ($val as $i => $v) {
                $uid_name = \XoopsUser::getUnameFromId($v, 1);
                if (empty($uid_name)) {
                    $uid_name = \XoopsUser::getUnameFromId($v, 0);
                }
                $data_arr[$class][$i] = $uid_name;
            }
        } else {
            if ($val and is_integer($val)) {
                $uid_name = \XoopsUser::getUnameFromId($val, 1);
                if (empty($uid_name)) {
                    $uid_name = \XoopsUser::getUnameFromId($val, 0);
                }
                $data_arr[$class][0] = $uid_name;
            }
        }
    }
    $TadDataCenter->saveCustomData($data_arr);
}

/*-----------變數過濾----------*/

include_once $GLOBALS['xoops']->path('/modules/system/include/functions.php');
$op = system_CleanVars($_REQUEST, 'op', '', 'string');
$school_year = system_CleanVars($_REQUEST, 'school_year', '', 'int');
$class_teacher = system_CleanVars($_REQUEST, 'class_teacher', '', 'array');

/*-----------執行動作判斷區----------*/
switch ($op) {
    case 'save_class_teacher':
        save_class_teacher($school_year, $class_teacher);
        redirect_header($_SERVER['PHP_SELF'], 3, '儲存完成');
        break;

    default:
        $op = 'scs_teacher_setup';
        scs_teacher_setup($school_year);
        break;
}

/*-----------秀出結果區--------------*/
$xoopsTpl->assign('now_op', $op);
$xoTheme->addStylesheet('/modules/tadtools/css/font-awesome/css/font-awesome.css');
if ($_SEESION['bootstrap'] == 4) {
    $xoTheme->addStylesheet(XOOPS_URL . '/modules/tadtools/css/xoops_adm4.css');
} else {
    $xoTheme->addStylesheet(XOOPS_URL . '/modules/tadtools/css/xoops_adm3.css');
}
require_once __DIR__ . '/footer.php';
