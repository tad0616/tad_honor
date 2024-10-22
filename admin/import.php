<?php
use Xmf\Request;
use XoopsModules\Tadtools\Utility;
use XoopsModules\Tadtools\Wcag;
/*-----------引入檔案區--------------*/
$xoopsOption['template_main'] = 'tad_honor_admin.tpl';
require_once __DIR__ . '/header.php';

/*-----------執行動作判斷區----------*/
$op = Request::getString('op');
$honor_sn = Request::getArray('honor_sn');
$json_file = XOOPS_ROOT_PATH . '/uploads/tad_honor_data.json';
switch ($op) {

    case 'import_now':
        import_now($honor_sn);
        header('location: ../index.php');
        exit;

    default:
        list_fred_honorboard();
        $op = 'tad_honor_import';
        break;

}

/*-----------秀出結果區--------------*/
$xoopsTpl->assign('now_op', $op);
require_once __DIR__ . '/footer.php';

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
    $sql = 'SELECT `gperm_groupid`, `gperm_itemid`, `gperm_name` FROM `' . $xoopsDB->prefix('group_permission') . '` WHERE `gperm_modid` = ?';
    $result = Utility::query($sql, 'i', [$mod_id]) or Utility::web_error($sql, __FILE__, __LINE__);

    while (list($gperm_groupid, $gperm_itemid, $gperm_name) = $xoopsDB->fetchRow($result)) {
        $power[$gperm_itemid][$gperm_name][$gperm_groupid] = $gperm_groupid;
    }

    //轉移權限（新權限）
    $mid = $xoopsModule->getVar('mid');
    $sql = 'SELECT `gperm_groupid`, `gperm_itemid`, `gperm_name` FROM `' . $xoopsDB->prefix('group_permission') . '` WHERE `gperm_modid` = ?';
    $result = Utility::query($sql, 'i', [$mid]) or Utility::web_error($sql, __FILE__, __LINE__);

    while (list($gperm_groupid, $gperm_itemid, $gperm_name) = $xoopsDB->fetchRow($result)) {
        $now_power[$gperm_itemid][$gperm_name][$gperm_groupid] = $gperm_groupid;
    }

    $sql = 'SELECT * FROM `' . $xoopsDB->prefix('fred_honorboard') . '`';
    $result = Utility::query($sql) or Utility::web_error($sql, __FILE__, __LINE__);

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
    global $xoopsDB, $xoopsUser, $json_file;
    $uid = $xoopsUser->uid();
    $dep = [];
    $sql = 'SELECT `department_sn`, `department_name` FROM `' . $xoopsDB->prefix('fred_honorboard_department') . '`';
    $result = Utility::query($sql) or Utility::web_error($sql, __FILE__, __LINE__);

    while (list($department_sn, $department_name) = $xoopsDB->fetchRow($result)) {
        $dep[$department_sn] = $department_name;
    }

    $sql = 'SELECT * FROM `' . $xoopsDB->prefix('fred_honorboard') . '`';
    $result = Utility::query($sql) or Utility::web_error($sql, __FILE__, __LINE__);

    while (false !== ($all = $xoopsDB->fetchArray($result))) {
        if (in_array($all['honor_sn'], $honor_arr)) {
            $honor_title = $all['honor_title'];
            $honor_content = empty($all['honor_content']) ? $honor_title : $all['honor_content'];
            $honor_content = Wcag::amend($honor_content);
            $write_department = $dep[$all['write_department']];
            $write_date = $all['write_date'];
            $click = (int) $all['click'];

            $sql = 'REPLACE INTO `' . $xoopsDB->prefix('tad_honor') . '`
            (`honor_title`, `honor_date`, `honor_unit`, `honor_counter`, `honor_content`, `honor_url`, `honor_uid`)
            VALUES (?, ?, ?, ?, ?, ?, ?)';
            Utility::query($sql, 'sssissi', [$honor_title, $write_date, $write_department, $click, $honor_content, '', $uid]) or Utility::web_error($sql, __FILE__, __LINE__);

        }
    }

    $conf_value = implode(';', $dep);
    $sql = 'UPDATE `' . $xoopsDB->prefix('config') . '` SET `conf_value`=? WHERE `conf_name`=?';
    Utility::query($sql, 'ss', [$conf_value, 'honor_unit']) or Utility::web_error($sql, __FILE__, __LINE__);
    unlink($json_file);

}
