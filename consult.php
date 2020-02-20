<?php
use XoopsModules\Scs\Scs_consult;
use XoopsModules\Scs\Tools;
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
$GLOBALS['xoopsOption']['template_main'] = 'scs_consult.tpl';
require_once XOOPS_ROOT_PATH . '/header.php';

if (!$xoopsUser or (!$_SESSION['scs_adm'] and !$_SESSION['tea_class_arr'])) {
    redirect_header(XOOPS_URL . '/modules/tad_login', 3, _TAD_PERMISSION_DENIED);
}

/*-----------功能函數區----------*/

/*-----------變數過濾----------*/
include_once $GLOBALS['xoops']->path('/modules/system/include/functions.php');
$op = system_CleanVars($_REQUEST, 'op', '', 'string');
$consult_id = system_CleanVars($_REQUEST, 'consult_id', 0, 'int');
$files_sn = system_CleanVars($_REQUEST, 'files_sn', 0, 'int');
$stu_id = system_CleanVars($_REQUEST, 'stu_id', 0, 'int');

/*-----------執行動作判斷區----------*/
switch ($op) {

    //新增資料
    case 'scs_consult_store':
        $consult_id = Scs_consult::store();
        header("location: {$_SERVER['PHP_SELF']}?consult_id=$consult_id&stu_id=$stu_id");
        exit;

    //更新資料
    case 'scs_consult_update':
        Scs_consult::update($consult_id);
        header("location: {$_SERVER['PHP_SELF']}?consult_id=$consult_id&stu_id=$stu_id");
        exit;

    //下載檔案
    case 'tufdl':
        exit;

    //新增用表單
    case 'scs_consult_create':
        Scs_consult::create('', $stu_id);
        Tools::menu_option($stu_id);
        break;

    //修改用表單
    case 'scs_consult_edit':
        Scs_consult::create($consult_id, $stu_id);
        Tools::menu_option($stu_id);
        $op = 'scs_consult_create';
        break;

    //刪除資料
    case 'scs_consult_destroy':
        Scs_consult::destroy($consult_id);
        header("location: {$_SERVER['PHP_SELF']}?stu_id=$stu_id");
        exit;

    //列出所資料
    case 'scs_consult_index':
        Scs_consult::index($stu_id);
        Tools::menu_option($stu_id);
        break;

    //顯示某筆資料
    case 'scs_consult_show':
        Scs_consult::show($consult_id);
        break;

    //預設動作
    default:
        if (empty($consult_id)) {
            Scs_consult::index($stu_id);
            Tools::menu_option($stu_id);
            $op = 'scs_consult_index';
        } else {
            Scs_consult::show($consult_id, $stu_id);
            Tools::menu_option($stu_id);
            $op = 'scs_consult_show';
        }
        break;
}

/*-----------秀出結果區--------------*/
$xoopsTpl->assign('toolbar', Utility::toolbar_bootstrap($interface_menu));
$xoopsTpl->assign('now_op', $op);
$xoTheme->addStylesheet(XOOPS_URL . '/modules/scs/css/module.css');
require_once XOOPS_ROOT_PATH . '/footer.php';
