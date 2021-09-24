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
$zip_arr = ['中西區' => '700', '東區' => '701', '南區' => '702', '北區' => '704', '安平區' => '708', '安南區' => '709', '永康區' => '710', '歸仁區' => '711', '新化區' => '712', '左鎮區' => '713', '玉井區' => '714', '楠西區' => '715', '南化區' => '716', '仁德區' => '717', '關廟區' => '718', '龍崎區' => '719', '官田區' => '720', '麻豆區' => '721', '佳里區' => '722', '西港區' => '723', '七股區' => '724', '將軍區' => '725', '學甲區' => '726', '北門區' => '727', '新營區' => '730', '後壁區' => '731', '白河區' => '732', '東山區' => '733', '六甲區' => '734', '下營區' => '735', '柳營區' => '736', '鹽水區' => '737', '善化區' => '741', '大內區' => '742', '山上區' => '743', '新市區' => '744', '安定區' => '745'];

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
