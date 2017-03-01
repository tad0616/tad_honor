<?php
/*-----------引入檔案區--------------*/
$xoopsOption['template_main'] = 'tad_honor_adm_main.tpl';
include_once "header.php";
include_once "../function.php";
/*-----------功能函數區--------------*/

//刪除tad_honor某筆資料資料
function delete_tad_honor($honor_sn = "")
{
    global $xoopsDB, $isAdmin;
    if (empty($honor_sn)) {
        return;
    }
    $sql = "delete from `" . $xoopsDB->prefix("tad_honor") . "` where `honor_sn` = '{$honor_sn}'";
    $xoopsDB->queryF($sql) or web_error($sql);

    include_once XOOPS_ROOT_PATH . "/modules/tadtools/TadUpFiles.php";
    $TadUpFiles = new TadUpFiles("tad_honor");
    $TadUpFiles->set_col("honor_sn", $honor_sn);
    $TadUpFiles->del_files();
}

//以流水號秀出某筆tad_honor資料內容
function show_one_tad_honor($honor_sn = "")
{
    global $xoopsDB, $xoopsTpl, $isAdmin;

    if (empty($honor_sn)) {
        return;
    } else {
        $honor_sn = (int) ($honor_sn);
    }

    $myts = MyTextSanitizer::getInstance();

    $sql    = "select * from `" . $xoopsDB->prefix("tad_honor") . "` where `honor_sn` = '{$honor_sn}' ";
    $result = $xoopsDB->query($sql) or web_error($sql);
    $all    = $xoopsDB->fetchArray($result);

    //以下會產生這些變數： $honor_sn , $honor_title , $honor_date , $honor_unit , $honor_counter , $honor_content , $honor_url , $honor_uid
    foreach ($all as $k => $v) {
        $$k = $v;
    }

    //計數器欄位值 +1
    add_tad_honor_counter($honor_sn);

    //將 uid 編號轉換成使用者姓名（或帳號）
    $uid_name = XoopsUser::getUnameFromId($honor_uid, 1);
    if (empty($uid_name)) {
        $uid_name = XoopsUser::getUnameFromId($honor_uid, 0);
    }

    include_once XOOPS_ROOT_PATH . "/modules/tadtools/TadUpFiles.php";
    $TadUpFiles = new TadUpFiles("tad_honor");
    $TadUpFiles->set_col("honor_sn", $honor_sn);
    $show_honor_sn_files = $TadUpFiles->show_files('up_honor_sn', true, 'thumb', true, false, null, null, false);
    $xoopsTpl->assign('show_honor_sn_files', $show_honor_sn_files);

    //過濾讀出的變數值
    $honor_title   = $myts->htmlSpecialChars($honor_title);
    $honor_date    = $myts->htmlSpecialChars($honor_date);
    $honor_content = $myts->displayTarea($honor_content, 1, 1, 0, 1, 0);
    $honor_url     = $myts->htmlSpecialChars($honor_url);

    $xoopsTpl->assign('honor_sn', $honor_sn);
    $xoopsTpl->assign('honor_title', $honor_title);
    $xoopsTpl->assign('honor_title_link', "<a href='{$_SERVER['PHP_SELF']}?honor_sn={$honor_sn}'>{$honor_title}</a>");
    $xoopsTpl->assign('honor_date', $honor_date);
    $xoopsTpl->assign('honor_unit', $honor_unit);
    $xoopsTpl->assign('honor_counter', $honor_counter);
    $xoopsTpl->assign('honor_content', $honor_content);
    $xoopsTpl->assign('honor_url', $honor_url);
    $xoopsTpl->assign('honor_uid', $uid_name);

    if (!file_exists(XOOPS_ROOT_PATH . "/modules/tadtools/sweet_alert.php")) {
        redirect_header("index.php", 3, _MA_NEED_TADTOOLS);
    }
    include_once XOOPS_ROOT_PATH . "/modules/tadtools/sweet_alert.php";
    $sweet_alert           = new sweet_alert();
    $delete_tad_honor_func = $sweet_alert->render('delete_tad_honor_func', "{$_SERVER['PHP_SELF']}?op=delete_tad_honor&honor_sn=", "honor_sn");
    $xoopsTpl->assign('delete_tad_honor_func', $delete_tad_honor_func);

    $xoopsTpl->assign('action', $_SERVER['PHP_SELF']);
    $xoopsTpl->assign('now_op', 'show_one_tad_honor');
}

//新增tad_honor計數器
function add_tad_honor_counter($honor_sn = '')
{
    global $xoopsDB;
    if (empty($honor_sn)) {
        return;
    }
    $sql = "update `" . $xoopsDB->prefix("tad_honor") . "` set `honor_counter` = `honor_counter` + 1 where `honor_sn` = '{$honor_sn}'";
    $xoopsDB->queryF($sql) or web_error($sql);
}

//列出所有tad_honor資料
function list_tad_honor()
{
    global $xoopsDB, $xoopsTpl, $isAdmin;

    $myts = MyTextSanitizer::getInstance();

    include_once XOOPS_ROOT_PATH . "/modules/tadtools/TadUpFiles.php";
    $TadUpFiles = new TadUpFiles("tad_honor");

    $sql = "select * from `" . $xoopsDB->prefix("tad_honor") . "` ";

    //getPageBar($原sql語法, 每頁顯示幾筆資料, 最多顯示幾個頁數選項);
    $PageBar = getPageBar($sql, 20, 10, null, null, 3);
    $bar     = $PageBar['bar'];
    $sql     = $PageBar['sql'];
    $total   = $PageBar['total'];

    $result = $xoopsDB->query($sql) or web_error($sql);

    $all_content = "";
    $i           = 0;
    while ($all = $xoopsDB->fetchArray($result)) {
        //以下會產生這些變數： $honor_sn , $honor_title , $honor_date , $honor_unit , $honor_counter , $honor_content , $honor_url , $honor_uid
        foreach ($all as $k => $v) {
            $$k = $v;
        }

        //過濾讀出的變數值
        $honor_title   = $myts->htmlSpecialChars($honor_title);
        $honor_date    = $myts->htmlSpecialChars($honor_date);
        $honor_content = $myts->displayTarea($honor_content, 1, 1, 0, 1, 0);
        $honor_url     = $myts->htmlSpecialChars($honor_url);

        $all_content[$i]['honor_sn']         = $honor_sn;
        $all_content[$i]['honor_title_link'] = "<a href='{$_SERVER['PHP_SELF']}?honor_sn={$honor_sn}'>{$honor_title}</a>";
        $all_content[$i]['honor_title']      = $honor_title;
        $all_content[$i]['honor_date']       = $honor_date;
        $all_content[$i]['honor_unit']       = $honor_unit;
        $all_content[$i]['honor_counter']    = $honor_counter;
        $all_content[$i]['honor_content']    = $honor_content;
        $all_content[$i]['honor_url']        = $honor_url;
        $all_content[$i]['honor_uid']        = $uid_name;
        $TadUpFiles->set_col("honor_sn", $honor_sn);
        $show_files                   = $TadUpFiles->show_files('up_honor_sn', true, 'small', true, false, null, null, false);
        $all_content[$i]['list_file'] = $show_files;
        $i++;
    }

    //刪除確認的JS

    $xoopsTpl->assign('bar', $bar);
    $xoopsTpl->assign('action', $_SERVER['PHP_SELF']);
    $xoopsTpl->assign('isAdmin', $isAdmin);
    $xoopsTpl->assign('all_content', $all_content);
    $xoopsTpl->assign('now_op', 'list_tad_honor');

    if (!file_exists(XOOPS_ROOT_PATH . "/modules/tadtools/sweet_alert.php")) {
        redirect_header("index.php", 3, _MA_NEED_TADTOOLS);
    }
    include_once XOOPS_ROOT_PATH . "/modules/tadtools/sweet_alert.php";
    $sweet_alert           = new sweet_alert();
    $delete_tad_honor_func = $sweet_alert->render('delete_tad_honor_func', "{$_SERVER['PHP_SELF']}?op=delete_tad_honor&honor_sn=", "honor_sn");
    $xoopsTpl->assign('delete_tad_honor_func', $delete_tad_honor_func);
}

/*-----------執行動作判斷區----------*/
$op       = empty($_REQUEST['op']) ? "" : $_REQUEST['op'];
$honor_sn = empty($_REQUEST['honor_sn']) ? "" : (int) ($_REQUEST['honor_sn']);
$files_sn = empty($_REQUEST['files_sn']) ? "" : (int) ($_REQUEST['files_sn']);

switch ($op) {
    /*---判斷動作請貼在下方---*/
    //新增資料
    case "insert_tad_honor":
        $honor_sn = insert_tad_honor();
        header("location: {$_SERVER['PHP_SELF']}?honor_sn=$honor_sn");
        break;

    //更新資料
    case "update_tad_honor":
        update_tad_honor($honor_sn);
        header("location: {$_SERVER['PHP_SELF']}?honor_sn=$honor_sn");
        break;

    case "tad_honor_form":
        tad_honor_form($honor_sn);
        break;

    case "delete_tad_honor":
        delete_tad_honor($honor_sn);
        header("location: {$_SERVER['PHP_SELF']}");
        break;

    //下載檔案
    case "tufdl":
        $TadUpFiles->add_file_counter($files_sn, false);
        exit;
        break;

    default:
        if (empty($honor_sn)) {
            list_tad_honor();
            //$main.=tad_honor_form($honor_sn);
        } else {
            show_one_tad_honor($honor_sn);
        }
        break;

        /*---判斷動作請貼在上方---*/
}

/*-----------秀出結果區--------------*/
$xoopsTpl->assign("isAdmin", true);
include_once 'footer.php';
