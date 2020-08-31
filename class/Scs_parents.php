<?php
namespace XoopsModules\Scs;

use XoopsModules\Scs\Scs_parents;
use XoopsModules\Scs\Tools;
use XoopsModules\Tadtools\SweetAlert;
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

class Scs_parents
{
    //列出所有 scs_parents 資料
    public static function index()
    {
        global $xoopsDB, $xoopsTpl;
        $myts = \MyTextSanitizer::getInstance();

        $sql = "select * from `" . $xoopsDB->prefix("scs_parents") . "` ";

        //Utility::getPageBar($原sql語法, 每頁顯示幾筆資料, 最多顯示幾個頁數選項);
        $PageBar = Utility::getPageBar($sql, 20, 10);
        $bar = $PageBar['bar'];
        $sql = $PageBar['sql'];
        $total = $PageBar['total'];
        $xoopsTpl->assign('bar', $bar);
        $xoopsTpl->assign('total', $total);

        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);

        $all_scs_parents = [];
        while ($all = $xoopsDB->fetchArray($result)) {
            //過濾讀出的變數值
            $all['stu_id'] = (int) $all['stu_id'];
            $all['parent_kind'] = $myts->htmlSpecialChars($all['parent_kind']);
            $all['parent_name'] = $myts->htmlSpecialChars($all['parent_name']);
            $all['parent_year'] = $myts->htmlSpecialChars($all['parent_year']);
            $all['parent_job'] = $myts->htmlSpecialChars($all['parent_job']);
            $all['parent_title'] = $myts->htmlSpecialChars($all['parent_title']);
            $all['parent_phone'] = $myts->htmlSpecialChars($all['parent_phone']);
            $all['parent_survive'] = $myts->htmlSpecialChars($all['parent_survive']);
            $all['parent_company'] = $myts->htmlSpecialChars($all['parent_company']);
            $all['parent_company_tel'] = $myts->htmlSpecialChars($all['parent_company_tel']);
            $all['parent_edu'] = $myts->htmlSpecialChars($all['parent_edu']);
            $all['parent_email'] = $myts->htmlSpecialChars($all['parent_email']);

            $all_scs_parents[] = $all;
        }

        //刪除確認的JS
        $SweetAlert = new SweetAlert();
        $SweetAlert->render('scs_parents_destroy_func',
            "{$_SERVER['PHP_SELF']}?op=scs_parents_destroy&stu_id_parent_kind=", "stu_id_parent_kind");

        $xoopsTpl->assign('action', $_SERVER['PHP_SELF']);
        $xoopsTpl->assign('all_scs_parents', $all_scs_parents);
    }

    //scs_parents編輯表單
    public static function create($stu_id = '')
    {
        global $xoopsDB, $xoopsTpl, $xoopsUser, $xoopsModuleConfig;
        Tools::chk_scs_power(__FILE__, __LINE__, 'create', $stu_id);

        //抓取預設值
        $DBV = !empty($stu_id) ? self::get($stu_id) : [];

        $xoopsTpl->assign('parents', $DBV);

        Tools::get_config_arr('scs_parents', 'parent_survive');
        Tools::get_config_arr('scs_parents', 'parent_edu');
        Tools::get_config_arr('scs_parents', 'parent_job');
    }

    //新增資料到scs_parents中
    public static function store($stu_id, $parent_kind = '', $data = [], $check = true)
    {
        global $xoopsDB, $xoopsUser;

        //XOOPS表單安全檢查
        if ($check) {
            Tools::chk_scs_power(__FILE__, __LINE__, 'create', $stu_id);
            Utility::xoops_security_check();
        }

        $myts = \MyTextSanitizer::getInstance();

        $parent_kind = $myts->addSlashes($parent_kind);
        $parent_name = $myts->addSlashes($data['parent_name']);
        $parent_year = $myts->addSlashes($data['parent_year']);
        $parent_job = $myts->addSlashes($data['parent_job']);
        $parent_title = $myts->addSlashes($data['parent_title']);
        $parent_phone = $myts->addSlashes($data['parent_phone']);
        $parent_survive = $myts->addSlashes($data['parent_survive']);
        $parent_company = $myts->addSlashes($data['parent_company']);
        $parent_company_tel = $myts->addSlashes($data['parent_company_tel']);
        $parent_edu = $myts->addSlashes($data['parent_edu']);
        $parent_email = $myts->addSlashes($data['parent_email']);

        $sql = "replace into `" . $xoopsDB->prefix("scs_parents") . "` (
        `stu_id`,
        `parent_kind`,
        `parent_name`,
        `parent_year`,
        `parent_job`,
        `parent_title`,
        `parent_phone`,
        `parent_survive`,
        `parent_company`,
        `parent_company_tel`,
        `parent_edu`,
        `parent_email`
        ) values(
        '{$stu_id}',
        '{$parent_kind}',
        '{$parent_name}',
        '{$parent_year}',
        '{$parent_job}',
        '{$parent_title}',
        '{$parent_phone}',
        '{$parent_survive}',
        '{$parent_company}',
        '{$parent_company_tel}',
        '{$parent_edu}',
        '{$parent_email}'
        )";
        $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
    }

    //以流水號秀出某筆scs_parents資料內容
    public static function show($stu_id = '')
    {
        global $xoopsDB, $xoopsTpl;

        if (empty($stu_id)) {
            return;
        } else {
            $stu_id = (int) $stu_id;
        }
        Tools::chk_scs_power(__FILE__, __LINE__, 'show', $stu_id);

        $myts = \MyTextSanitizer::getInstance();

        $all = self::get($stu_id);

        //以下會產生這些變數： $stu_id, $parent_kind, $parent_name, $parent_year, $parent_job, $parent_title, $parent_phone, $parent_survive, $parent_company, $parent_company_tel, $parent_edu, $parent_email
        $arr = [];
        foreach ($all as $parent_kind => $parent) {
            foreach ($parent as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $kk => $vv) {
                        $arr[$parent_kind][$k][$kk] = empty($vv) ? '　' : $myts->htmlSpecialChars($vv);
                    }
                } else {
                    $arr[$parent_kind][$k] = empty($v) ? '　' : $myts->htmlSpecialChars($v);
                }
            }
        }
        $xoopsTpl->assign('parents', $arr);
    }

    //更新scs_parents某一筆資料
    public static function update($stu_id = '', $data = [], $check = true, $pass_empty = true)
    {
        global $xoopsDB, $xoopsUser;

        //XOOPS表單安全檢查
        if ($check) {
            Tools::chk_scs_power(__FILE__, __LINE__, 'update', $stu_id);
            Utility::xoops_security_check();
        }

        $myts = \MyTextSanitizer::getInstance();
        $update_item = [];
        foreach ($data as $kind => $arr) {
            foreach ($arr as $col => $val) {
                if (empty($val) and $pass_empty) {
                    continue;
                }
                $$col[$kind] = $val = $myts->addSlashes($val);

                $update_item[$kind][] = "`$col` = '{$val}'";

            }
        }

        foreach ($parent_name as $kind => $name) {
            if (empty($name)) {
                continue;
            }
            $update_sql = implode(', ', $update_item[$kind]);
            $sql = "
            INSERT INTO `" . $xoopsDB->prefix("scs_parents") . "`(
                `stu_id`, `parent_kind`, `parent_name`, `parent_year`, `parent_job`, `parent_title`, `parent_phone`, `parent_survive`, `parent_company`, `parent_company_tel`, `parent_edu`, `parent_email`
            ) VALUES(
                '{$stu_id}', '{$kind}', '{$name}', '{$parent_year[$kind]}', '{$parent_job[$kind]}', '{$parent_title[$kind]}', '{$parent_phone[$kind]}', '{$parent_survive[$kind]}', '{$parent_company[$kind]}', '{$parent_company_tel[$kind]}', '{$parent_edu[$kind]}', '{$parent_email[$kind]}'
                )
            ON DUPLICATE KEY UPDATE
            $update_sql";
            // $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
            $xoopsDB->queryF($sql) or die($sql);
        }
    }

    //刪除scs_parents某筆資料資料
    public static function destroy($stu_id = '', $parent_kind = '')
    {
        global $xoopsDB;
        Tools::chk_scs_power(__FILE__, __LINE__, 'destroy', $stu_id);

        if (empty($stu_id) or empty($parent_kind)) {
            return;
        }

        $and_parent_kind = !empty($parent_kind) ? "and `parent_kind` = '$parent_kind'" : '';

        $sql = "insert into " . $xoopsDB->prefix("scs_parents_del") . " select *
        from " . $xoopsDB->prefix("scs_parents") . " where `stu_id` = '{$stu_id}' $and_parent_kind";
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);

        $sql = "delete from `" . $xoopsDB->prefix("scs_parents") . "`
        where `stu_id` = '{$stu_id}' $and_parent_kind";
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);

    }

    //以流水號取得某筆scs_parents資料
    public static function get($stu_id = '', $parent_kind = '')
    {
        global $xoopsDB;

        if (empty($stu_id)) {
            return;
        }

        $and_parent_kind = $parent_kind ? "and `parent_kind` = '{$parent_kind}'" : '';

        $sql = "select * from `" . $xoopsDB->prefix("scs_parents") . "`
        where `stu_id` = '{$stu_id}' {$and_parent_kind}";
        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);

        $data_arr = [];
        while ($data = $xoopsDB->fetchArray($result)) {
            $kind = $data['parent_kind'] == '父' ? 'f' : 'm';
            $data_arr[$kind] = $data;
        }
        return $data_arr;
    }

    //取得scs_parents所有資料陣列
    public static function get_all()
    {
        global $xoopsDB;
        $sql = "select * from `" . $xoopsDB->prefix("scs_parents") . "`";
        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $data_arr = [];
        while ($data = $xoopsDB->fetchArray($result)) {
            $stu_id = $data['stu_id'];
            $parent_kind = $data['parent_kind'];
            $data_arr[$stu_id][$parent_kind] = $data;
        }
        return $data_arr;
    }

}
