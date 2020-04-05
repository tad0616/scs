<?php
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

/********************* 自訂函數 *********************/

function vv($array = [])
{
    Utility::dd($array);
}

function have_scs_power($kind = '', $stu_id = '')
{
    return Tools::chk_scs_power(__FILE__, __LINE__, $kind, $stu_id, '', '', '', 'return');
}

function have_consult_power($kind = '', $stu_id = '', $consult_id = '', $consult_uid = '')
{
    return Tools::chk_consult_power(__FILE__, __LINE__, $kind, $stu_id, $consult_id, $consult_uid, 'return');
}
