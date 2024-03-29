<?php
use Xmf\Request;
use XoopsModules\Tadtools\SweetAlert;
use XoopsModules\Tadtools\TadUpFiles;
use XoopsModules\Tadtools\Utility;
/*-----------引入檔案區--------------*/
require_once __DIR__ . '/header.php';
$xoopsOption['template_main'] = 'tad_honor_index.tpl';
require_once XOOPS_ROOT_PATH . '/header.php';
/*-----------功能函數區--------------*/

//以流水號秀出某筆tad_honor資料內容
/**
 * @param string $honor_sn
 */
function show_one_tad_honor($honor_sn = '')
{
    global $xoopsDB, $xoopsTpl, $xoopsUser;

    if (empty($honor_sn)) {
        return;
    }
    $honor_sn = (int) $honor_sn;

    $myts = \MyTextSanitizer::getInstance();

    $sql = 'SELECT * FROM `' . $xoopsDB->prefix('tad_honor') . "` where `honor_sn` = '{$honor_sn}' ";
    $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
    $all = $xoopsDB->fetchArray($result);

    //以下會產生這些變數： $honor_sn , $honor_title , $honor_date , $honor_unit , $honor_counter , $honor_content , $honor_url , $honor_uid
    foreach ($all as $k => $v) {
        $$k = $v;
    }

    //計數器欄位值 +1
    add_tad_honor_counter($honor_sn);

    //將 uid 編號轉換成使用者姓名（或帳號）
    $uid_name = \XoopsUser::getUnameFromId($honor_uid, 1);
    if (empty($uid_name)) {
        $uid_name = \XoopsUser::getUnameFromId($honor_uid, 0);
    }

    $TadUpFiles = new TadUpFiles('tad_honor');
    $TadUpFiles->set_col('honor_sn', $honor_sn);
    $show_honor_sn_files = $TadUpFiles->show_files('up_honor_sn', true, 'thumb', true);

    $xoopsTpl->assign('show_honor_sn_files', $show_honor_sn_files);

    //過濾讀出的變數值
    $honor_title = $myts->htmlSpecialChars($honor_title);
    $honor_date = $myts->htmlSpecialChars($honor_date);
    $honor_content = $myts->displayTarea($honor_content, 1, 1, 0, 1, 0);
    $honor_url = $myts->htmlSpecialChars($honor_url);

    $xoopsTpl->assign('honor_sn', $honor_sn);
    $xoopsTpl->assign('honor_title', $honor_title);
    $xoopsTpl->assign('honor_title_link', "<a href='{$_SERVER['PHP_SELF']}?honor_sn={$honor_sn}'>{$honor_title}</a>");
    $xoopsTpl->assign('honor_date', $honor_date);
    $xoopsTpl->assign('honor_unit', $honor_unit);
    $xoopsTpl->assign('honor_counter', $honor_counter);
    $xoopsTpl->assign('honor_content', $honor_content);
    $xoopsTpl->assign('honor_url', $honor_url);
    $xoopsTpl->assign('honor_uid', $honor_uid);
    $xoopsTpl->assign('uid_name', $uid_name);
    $xoopsTpl->assign('lang_viewsinfo', sprintf(_MD_TADHONOR_HONOR_VIEWS_INFO, $honor_unit, $uid_name, $honor_date, $honor_counter));

    if ($_SESSION['tad_honor_adm'] or Utility::power_chk('tad_honor_post', 1)) {
        $SweetAlert = new SweetAlert();
        $SweetAlert->render('delete_tad_honor_func', "{$_SERVER['PHP_SELF']}?op=delete_tad_honor&honor_sn=", 'honor_sn');
    }
    $xoopsTpl->assign('action', $_SERVER['PHP_SELF']);
    $xoopsTpl->assign('now_op', 'show_one_tad_honor');
    $xoopsTpl->assign('uid', $xoopsUser ? $xoopsUser->uid() : 0);
    $xoopsTpl->assign('post_power', Utility::power_chk('tad_honor_post', 1));
}

//新增tad_honor計數器
/**
 * @param string $honor_sn
 */
function add_tad_honor_counter($honor_sn = '')
{
    global $xoopsDB;
    if (empty($honor_sn)) {
        return;
    }
    $sql = 'update `' . $xoopsDB->prefix('tad_honor') . "` set `honor_counter` = `honor_counter` + 1 where `honor_sn` = '{$honor_sn}'";
    $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
}

//刪除tad_honor某筆資料資料
/**
 * @param string $honor_sn
 */
function delete_tad_honor($honor_sn = '')
{
    global $xoopsDB;
    if (empty($honor_sn)) {
        return;
    }
    if (!Utility::power_chk('tad_honor_post', 1) and !$_SESSION['tad_honor_adm']) {
        redirect_header('index.php', 3, _TAD_PERMISSION_DENIED);
    }
    $sql = 'delete from `' . $xoopsDB->prefix('tad_honor') . "` where `honor_sn` = '{$honor_sn}'";
    $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);

    $TadUpFiles = new TadUpFiles('tad_honor');
    $TadUpFiles->set_col('honor_sn', $honor_sn);
    $TadUpFiles->del_files();
}

//列出所有tad_honor資料
function list_tad_honor()
{
    global $xoopsDB, $xoopsTpl, $xoopsUser;

    $myts = \MyTextSanitizer::getInstance();

    $TadUpFiles = new TadUpFiles('tad_honor');

    $sql = 'SELECT * FROM ' . $xoopsDB->prefix('tad_honor') . ' ORDER BY honor_date DESC';

    //Utility::getPageBar($原sql語法, 每頁顯示幾筆資料, 最多顯示幾個頁數選項);
    $PageBar = Utility::getPageBar($sql, 20, 10, null, null, 3);
    $bar = $PageBar['bar'];
    $sql = $PageBar['sql'];
    $total = $PageBar['total'];

    $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);

    $all_content = [];
    $i = 0;
    while (false !== ($all = $xoopsDB->fetchArray($result))) {
        //以下會產生這些變數： $honor_sn , $honor_title , $honor_date , $honor_unit , $honor_counter , $honor_content , $honor_url , $honor_uid
        foreach ($all as $k => $v) {
            $$k = $v;
        }

        //過濾讀出的變數值
        $honor_title = $myts->htmlSpecialChars($honor_title);
        $honor_date = $myts->htmlSpecialChars($honor_date);
        $honor_content = $myts->displayTarea($honor_content, 1, 1, 0, 1, 0);
        $honor_url = $myts->htmlSpecialChars($honor_url);

        $all_content[$i]['honor_sn'] = $honor_sn;
        $all_content[$i]['honor_title_link'] = "<a href='{$_SERVER['PHP_SELF']}?honor_sn={$honor_sn}'>{$honor_title}</a>";
        $all_content[$i]['honor_title'] = $honor_title;
        $all_content[$i]['honor_date'] = $honor_date;
        $all_content[$i]['honor_unit'] = $honor_unit;
        $all_content[$i]['honor_counter'] = $honor_counter;
        $all_content[$i]['honor_content'] = $honor_content;
        $all_content[$i]['honor_url'] = $honor_url;
        $all_content[$i]['honor_uid'] = $honor_uid;
        $all_content[$i]['uid_name'] = $uid_name;
        $TadUpFiles->set_col('honor_sn', $honor_sn);
        $show_files = $TadUpFiles->show_files('up_honor_sn', true, 'small', true, false, null, null, false);
        $all_content[$i]['list_file'] = $show_files;
        $i++;
    }

    //刪除確認的JS

    $xoopsTpl->assign('bar', $bar);
    $xoopsTpl->assign('action', $_SERVER['PHP_SELF']);
    $xoopsTpl->assign('all_content', $all_content);
    $xoopsTpl->assign('now_op', 'list_tad_honor');

    if ($_SESSION['tad_honor_adm'] or Utility::power_chk('tad_honor_post', 1)) {
        $SweetAlert = new SweetAlert();
        $SweetAlert->render('delete_tad_honor_func', "{$_SERVER['PHP_SELF']}?op=delete_tad_honor&honor_sn=", 'honor_sn');
    }

    $xoopsTpl->assign('post_power', Utility::power_chk('tad_honor_post', 1));
    $xoopsTpl->assign('uid', $xoopsUser ? $xoopsUser->uid() : 0);
}

/*-----------執行動作判斷區----------*/
$op = Request::getString('op');
$honor_sn = Request::getInt('honor_sn');
$files_sn = Request::getInt('files_sn');

switch ($op) {
    /*---判斷動作請貼在下方---*/
    //新增資料
    case 'insert_tad_honor':
        $honor_sn = insert_tad_honor();
        header("location: {$_SERVER['PHP_SELF']}?honor_sn=$honor_sn");
        exit;

    //更新資料
    case 'update_tad_honor':
        update_tad_honor($honor_sn);
        header("location: {$_SERVER['PHP_SELF']}?honor_sn=$honor_sn");
        exit;

    case 'tad_honor_form':
        tad_honor_form($honor_sn);
        break;

    case 'delete_tad_honor':
        delete_tad_honor($honor_sn);
        header("location: {$_SERVER['PHP_SELF']}");
        exit;

    //下載檔案
    case 'tufdl':
        $TadUpFiles = new TadUpFiles('tad_honor');
        $TadUpFiles->add_file_counter($files_sn);
        exit;

    default:
        if (empty($honor_sn)) {
            list_tad_honor();
        } else {
            show_one_tad_honor($honor_sn);
        }
        break;
        /*---判斷動作請貼在上方---*/
}

/*-----------秀出結果區--------------*/
$xoopsTpl->assign('toolbar', Utility::toolbar_bootstrap($interface_menu));
$xoopsTpl->assign('show_confetti', $xoopsModuleConfig['show_confetti']);
require_once XOOPS_ROOT_PATH . '/footer.php';
