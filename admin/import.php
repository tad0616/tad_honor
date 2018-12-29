<?php
/*-----------引入檔案區--------------*/
$xoopsOption['template_main'] = 'tad_honor_adm_import.tpl';
include_once "header.php";
include_once "../function.php";
/*-----------功能函數區--------------*/

//列出所有 list_fred_honorboard 資料
function list_fred_honorboard()
{
    global $xoopsDB, $xoopsModule, $isAdmin, $xoopsTpl;

    //取得某模組編號

    $modhandler     = xoops_getHandler('module');
    $ThexoopsModule = $modhandler->getByDirname("fred_honorboard");

    if ($ThexoopsModule) {
        $mod_id = $ThexoopsModule->getVar('mid');
        $xoopsTpl->assign('show_error', '0');
    } else {
        $xoopsTpl->assign('show_error', '1');
        $xoopsTpl->assign('msg', _MA_TADHONOR_NO_FRED);
        return;
    }

    //轉移權限(原權限)
    $sql    = "SELECT gperm_groupid,gperm_itemid,gperm_name FROM `" . $xoopsDB->prefix("group_permission") . "` WHERE `gperm_modid` ='{$mod_id}' ";
    $result = $xoopsDB->queryF($sql) or web_error($sql, __FILE__, _LINE__);
    while (list($gperm_groupid, $gperm_itemid, $gperm_name) = $xoopsDB->fetchRow($result)) {
        $power[$gperm_itemid][$gperm_name][$gperm_groupid] = $gperm_groupid;
    }

    //轉移權限（新權限）
    $mid = $xoopsModule->getVar('mid');
    $sql = "SELECT gperm_groupid,gperm_itemid,gperm_name FROM `" . $xoopsDB->prefix("group_permission") . "` WHERE `gperm_modid` ='{$mid}' ";

    $result = $xoopsDB->queryF($sql) or web_error($sql, __FILE__, _LINE__);
    while (list($gperm_groupid, $gperm_itemid, $gperm_name) = $xoopsDB->fetchRow($result)) {
        $now_power[$gperm_itemid][$gperm_name][$gperm_groupid] = $gperm_groupid;
    }

    $sql    = "SELECT * FROM `" . $xoopsDB->prefix("fred_honorboard") . "`";
    $result = $xoopsDB->query($sql) or web_error($sql, __FILE__, _LINE__);

    $all_content = array();
    while ($all = $xoopsDB->fetchArray($result)) {
        $all_content[] = $all;
    }

    $xoopsTpl->assign('all_content', $all_content);
}

//匯入
function import_now($honor_arr = array())
{
    global $xoopsDB, $xoopsModule, $isAdmin, $xoopsTpl, $xoopsUser;
    $uid  = $xoopsUser->uid();
    $myts = MyTextSanitizer::getInstance();

    $dep    = array();
    $sql    = "SELECT department_sn,department_name FROM `" . $xoopsDB->prefix("fred_honorboard_department") . "`";
    $result = $xoopsDB->query($sql) or web_error($sql, __FILE__, _LINE__);
    while (list($department_sn, $department_name) = $xoopsDB->fetchRow($result)) {
        $dep[$department_sn] = $department_name;
    }

    $sql    = "SELECT * FROM `" . $xoopsDB->prefix("fred_honorboard") . "`";
    $result = $xoopsDB->query($sql) or web_error($sql, __FILE__, _LINE__);

    while ($all = $xoopsDB->fetchArray($result)) {
        if (in_array($all['honor_sn'], $honor_arr)) {

            $honor_person     = $myts->addSlashes($all['honor_person']);
            $honor_title      = $myts->addSlashes($all['honor_title']);
            $honor_content    = empty($all['honor_content']) ? $honor_title : $myts->addSlashes($all['honor_content']);
            $write_department = $dep[$all['write_department']];
            $write_date       = $myts->addSlashes($all['write_date']);
            $click            = intval($all['click']);

            $sql = "replace into `" . $xoopsDB->prefix("tad_honor") . "`
            (`honor_title`, `honor_date`, `honor_unit`, `honor_counter`, `honor_content`, `honor_url`, `honor_uid`)
            values('{$honor_title}' , '{$write_date}' ,  '{$write_department}' , '{$click}' , '{$honor_content}' , '' , '{$uid}' )";
            $xoopsDB->queryF($sql) or web_error($sql, __FILE__, _LINE__);
        }
    }

    $conf_value = implode(';', $dep);
    $sql        = "update `" . $xoopsDB->prefix("config") . "` set `conf_value`='$conf_value' where `conf_name`='honor_unit'";
    $xoopsDB->queryF($sql) or web_error($sql, __FILE__, _LINE__);
}

/*-----------執行動作判斷區----------*/
include_once $GLOBALS['xoops']->path('/modules/system/include/functions.php');
$op       = system_CleanVars($_REQUEST, 'op', '', 'string');
$honor_sn = system_CleanVars($_REQUEST, 'honor_sn', array(), 'array');

switch ($op) {
    /*---判斷動作請貼在下方---*/

    case "import_now":
        import_now($honor_sn);
        header("location: ../index.php");
        exit;

    default:
        list_fred_honorboard();

        break;

        /*---判斷動作請貼在上方---*/
}

/*-----------秀出結果區--------------*/
$xoopsTpl->assign("isAdmin", true);
include_once 'footer.php';
