<?php
use Xmf\Request;
use XoopsModules\Tadtools\Utility;
use XoopsModules\Tadtools\Wcag;
/*-----------引入檔案區--------------*/
$xoopsOption['template_main'] = 'tad_honor_adm_import.tpl';
require_once __DIR__ . '/header.php';
require_once dirname(__DIR__) . '/function.php';
/*-----------功能函數區--------------*/

//列出所有 list_fred_honorboard 資料
function list_fred_honorboard()
{
    global $xoopsDB, $xoopsModule, $xoopsTpl;

    //取得某模組編號

    $moduleHandler = xoops_getHandler('module');
    $ThexoopsModule = $moduleHandler->getByDirname('fred_honorboard');

    if ($ThexoopsModule) {
        $mod_id = $ThexoopsModule->getVar('mid');
        $xoopsTpl->assign('show_error', '0');
    } else {
        $xoopsTpl->assign('show_error', '1');
        $xoopsTpl->assign('msg', _MA_TADHONOR_NO_FRED);

        return;
    }

    //轉移權限(原權限)
    $sql = 'SELECT gperm_groupid,gperm_itemid,gperm_name FROM `' . $xoopsDB->prefix('group_permission') . "` WHERE `gperm_modid` ='{$mod_id}'";
    $result = $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
    while (list($gperm_groupid, $gperm_itemid, $gperm_name) = $xoopsDB->fetchRow($result)) {
        $power[$gperm_itemid][$gperm_name][$gperm_groupid] = $gperm_groupid;
    }

    //轉移權限（新權限）
    $mid = $xoopsModule->getVar('mid');
    $sql = 'SELECT gperm_groupid,gperm_itemid,gperm_name FROM `' . $xoopsDB->prefix('group_permission') . "` WHERE `gperm_modid` ='{$mid}' ";

    $result = $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
    while (list($gperm_groupid, $gperm_itemid, $gperm_name) = $xoopsDB->fetchRow($result)) {
        $now_power[$gperm_itemid][$gperm_name][$gperm_groupid] = $gperm_groupid;
    }

    $sql = 'SELECT * FROM `' . $xoopsDB->prefix('fred_honorboard') . '`';
    $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);

    $all_content = [];
    while (false !== ($all = $xoopsDB->fetchArray($result))) {
        $all_content[] = $all;
    }

    $xoopsTpl->assign('all_content', $all_content);
}

//匯入
/**
 * @param array $honor_arr
 */
function import_now($honor_arr = [])
{
    global $xoopsDB, $xoopsUser;
    $uid = $xoopsUser->uid();
    $dep = [];
    $sql = 'SELECT department_sn,department_name FROM `' . $xoopsDB->prefix('fred_honorboard_department') . '`';
    $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
    while (list($department_sn, $department_name) = $xoopsDB->fetchRow($result)) {
        $dep[$department_sn] = $department_name;
    }

    $sql = 'SELECT * FROM `' . $xoopsDB->prefix('fred_honorboard') . '`';
    $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);

    while (false !== ($all = $xoopsDB->fetchArray($result))) {
        if (in_array($all['honor_sn'], $honor_arr)) {
            $honor_person = $xoopsDB->escape($all['honor_person']);
            $honor_title = $xoopsDB->escape($all['honor_title']);
            $honor_content = empty($all['honor_content']) ? $honor_title : $xoopsDB->escape($all['honor_content']);
            $honor_content = Wcag::amend($honor_content);
            $write_department = $dep[$all['write_department']];
            $write_date = $xoopsDB->escape($all['write_date']);
            $click = (int) $all['click'];

            $sql = 'replace into `' . $xoopsDB->prefix('tad_honor') . "`
            (`honor_title`, `honor_date`, `honor_unit`, `honor_counter`, `honor_content`, `honor_url`, `honor_uid`)
            values('{$honor_title}' , '{$write_date}' ,  '{$write_department}' , '{$click}' , '{$honor_content}' , '' , '{$uid}' )";
            $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        }
    }

    $conf_value = implode(';', $dep);
    $sql = 'update `' . $xoopsDB->prefix('config') . "` set `conf_value`='$conf_value' where `conf_name`='honor_unit'";
    $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
}

/*-----------執行動作判斷區----------*/
$op = Request::getString('op');
$honor_sn = Request::getArray('honor_sn');

switch ($op) {
    /*---判斷動作請貼在下方---*/

    case 'import_now':
        import_now($honor_sn);
        header('location: ../index.php');
        exit;

    default:
        list_fred_honorboard();

        break;
        /*---判斷動作請貼在上方---*/
}

/*-----------秀出結果區--------------*/
require_once __DIR__ . '/footer.php';
