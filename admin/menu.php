<?php
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

$adminmenu = array();

$i = 1;
$adminmenu[$i]['title'] = _MI_TAD_ADMIN_HOME;
$adminmenu[$i]['link'] = 'admin/index.php';
$adminmenu[$i]['desc'] = _MI_TAD_ADMIN_HOME_DESC;
$adminmenu[$i]['icon'] = 'images/admin/home.png';

$i++;
$adminmenu[$i]['title'] = '國中匯入';
$adminmenu[$i]['link'] = 'admin/main.php';
$adminmenu[$i]['desc'] = '國中學籍匯入';
$adminmenu[$i]['icon'] = "images/admin/button.png";

$i++;
$adminmenu[$i]['title'] = '國小匯入';
$adminmenu[$i]['link'] = 'admin/import_es.php';
$adminmenu[$i]['desc'] = '國小學籍匯入';
$adminmenu[$i]['icon'] = "images/admin/button.png";

$i++;
$adminmenu[$i]['title'] = '身份設定';
$adminmenu[$i]['link'] = 'admin/class.php';
$adminmenu[$i]['desc'] = '身份設定';
$adminmenu[$i]['icon'] = "images/admin/button.png";

// $i++;
// $adminmenu[$i]['title'] = '權限管理';
// $adminmenu[$i]['link'] = 'admin/power.php';
// $adminmenu[$i]['desc'] = '權限管理';
// $adminmenu[$i]['icon'] = "images/admin/button.png";

$i++;
$adminmenu[$i]['title'] = _MI_TAD_ADMIN_ABOUT;
$adminmenu[$i]['link'] = 'admin/about.php';
$adminmenu[$i]['desc'] = _MI_TAD_ADMIN_ABOUT_DESC;
$adminmenu[$i]['icon'] = 'images/admin/about.png';
