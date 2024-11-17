<?php
use Xmf\Request;
use XoopsModules\Tadtools\BootstrapTable;
use XoopsModules\Tadtools\CkEditor;
use XoopsModules\Tadtools\FormValidator;
use XoopsModules\Tadtools\SweetAlert;
use XoopsModules\Tadtools\TadUpFiles;
use XoopsModules\Tadtools\Utility;
use XoopsModules\Tadtools\Wcag;
/*-----------引入檔案區--------------*/
require_once __DIR__ . '/header.php';
$xoopsOption['template_main'] = 'tad_honor_index.tpl';
require_once XOOPS_ROOT_PATH . '/header.php';
$json_file = XOOPS_ROOT_PATH . '/uploads/tad_honor_data.json';
/*-----------執行動作判斷區----------*/
$op = Request::getString('op');
$honor_sn = Request::getInt('honor_sn');
$files_sn = Request::getInt('files_sn');

switch ($op) {

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
            $op = 'list_tad_honor';
        } else {
            show_one_tad_honor($honor_sn);
            $op = 'show_one_tad_honor';
        }
        break;

}

/*-----------秀出結果區--------------*/
$xoopsTpl->assign('now_op', $op);
$xoopsTpl->assign('tad_honor_adm', $tad_honor_adm);
$xoopsTpl->assign('toolbar', Utility::toolbar_bootstrap($interface_menu, false, $interface_icon));
$xoopsTpl->assign('show_confetti', $xoopsModuleConfig['show_confetti']);
$xoTheme->addStylesheet('modules/' . $xoopsModule->getVar('dirname') . '/css/module.css');
require_once XOOPS_ROOT_PATH . '/footer.php';

/*-----------功能函數區--------------*/

//以流水號秀出某筆tad_honor資料內容
/**
 * @param string $honor_sn
 */
function show_one_tad_honor($honor_sn = '')
{
    global $xoopsDB, $xoopsTpl, $xoopsUser, $tad_honor_adm;

    if (empty($honor_sn)) {
        return;
    }
    $honor_sn = (int) $honor_sn;

    $myts = \MyTextSanitizer::getInstance();

    $sql = 'SELECT * FROM `' . $xoopsDB->prefix('tad_honor') . '` WHERE `honor_sn` = ?';
    $result = Utility::query($sql, 'i', [$honor_sn]) or Utility::web_error($sql, __FILE__, __LINE__);

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
    $xoopsTpl->assign('lang_views_info', sprintf(_MD_TADHONOR_HONOR_VIEWS_INFO, $honor_unit, $uid_name, $honor_date, $honor_counter));

    if ($tad_honor_adm or Utility::power_chk('tad_honor_post', 1)) {
        $SweetAlert = new SweetAlert();
        $SweetAlert->render('delete_tad_honor_func', "{$_SERVER['PHP_SELF']}?op=delete_tad_honor&honor_sn=", 'honor_sn');
    }
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
    $sql = 'UPDATE `' . $xoopsDB->prefix('tad_honor') . '` SET `honor_counter` = `honor_counter` + 1 WHERE `honor_sn` = ?';
    Utility::query($sql, 'i', [$honor_sn]) or Utility::web_error($sql, __FILE__, __LINE__);

}

//刪除tad_honor某筆資料資料
/**
 * @param string $honor_sn
 */
function delete_tad_honor($honor_sn = '')
{
    global $xoopsDB, $json_file, $tad_honor_adm;
    if (empty($honor_sn)) {
        return;
    }
    if (!Utility::power_chk('tad_honor_post', 1) and !$tad_honor_adm) {
        redirect_header('index.php', 3, _TAD_PERMISSION_DENIED);
    }
    $sql = 'DELETE FROM `' . $xoopsDB->prefix('tad_honor') . '` WHERE `honor_sn` = ?';
    Utility::query($sql, 'i', [$honor_sn]) or Utility::web_error($sql, __FILE__, __LINE__);

    $TadUpFiles = new TadUpFiles('tad_honor');
    $TadUpFiles->set_col('honor_sn', $honor_sn);
    $TadUpFiles->del_files();
    unlink($json_file);
}

//列出所有tad_honor資料
function list_tad_honor()
{
    global $xoopsTpl, $xoopsUser, $json_file, $tad_honor_adm;
    if (!file_exists($json_file)) {
        mk_tad_honor_json();
    }

    if ($tad_honor_adm or Utility::power_chk('tad_honor_post', 1)) {
        $SweetAlert = new SweetAlert();
        $SweetAlert->render('delete_tad_honor_func', "{$_SERVER['PHP_SELF']}?op=delete_tad_honor&honor_sn=", 'honor_sn');
    }

    $xoopsTpl->assign('post_power', Utility::power_chk('tad_honor_post', 1));
    $xoopsTpl->assign('uid', $xoopsUser ? $xoopsUser->uid() : 0);
    BootstrapTable::render();
}

function mk_tad_honor_json()
{
    global $xoopsDB, $xoopsUser, $json_file, $tad_honor_adm;

    $uid = $xoopsUser ? $xoopsUser->uid() : '';
    $myts = \MyTextSanitizer::getInstance();

    $TadUpFiles = new TadUpFiles('tad_honor');

    $sql = 'SELECT * FROM ' . $xoopsDB->prefix('tad_honor') . ' ORDER BY honor_date DESC';
    $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);

    $all_content = [];
    while (false !== ($honor = $xoopsDB->fetchArray($result))) {

        $honor['honor_function'] = '';
        $TadUpFiles->set_col('honor_sn', $honor['honor_sn']);
        $list_file = $TadUpFiles->show_files('up_honor_sn', true, 'small', true, false, null, null, false);
        //過濾讀出的變數值
        $honor['honor_title'] = $myts->htmlSpecialChars($honor['honor_title']);
        $honor['honor_date'] = $myts->htmlSpecialChars($honor['honor_date']);
        $honor['honor_content'] = $myts->displayTarea($honor['honor_content'], 1, 1, 0, 1, 0);
        $honor['honor_url'] = $myts->htmlSpecialChars($honor['honor_url']);
        $honor['honor_title_link'] = "<a href='{$_SERVER['PHP_SELF']}?honor_sn={$honor['honor_sn']}'>{$honor['honor_title']}</a>{$list_file}";
        if (($tad_honor_adm || Utility::power_chk('tad_honor_post', 1) || $uid == $honor['honor_uid'])) {
            $honor['honor_function'] = '<a href="javascript:delete_tad_honor_func(' . $honor['honor_sn'] . ');" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="' . _TAD_DEL . '"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
            <a href="' . XOOPS_URL . '/modules/tad_honor/index.php?op=tad_honor_form&honor_sn=' . $honor['honor_sn'] . '" class="btn btn-sm btn-warning" data-bs-toggle="tooltip" title="' . _TAD_EDIT . '"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
        }

        $all_content[] = $honor;
    }
    file_put_contents($json_file, json_encode($all_content, 256));

    return $all_content;
}

//更新tad_honor某一筆資料
/**
 * @param string $honor_sn
 * @return string
 */
function update_tad_honor($honor_sn = '')
{
    global $xoopsDB, $xoopsUser, $json_file, $tad_honor_adm;

    if (!Utility::power_chk('tad_honor_post', 1) and !$tad_honor_adm) {
        redirect_header('index.php', 3, _TAD_PERMISSION_DENIED);
    }

    //取得使用者編號
    $uid = $xoopsUser ? $xoopsUser->uid() : '';

    //XOOPS表單安全檢查
    if ($_SERVER['SERVER_ADDR'] != '127.0.0.1' && !$GLOBALS['xoopsSecurity']->check()) {
        $error = implode('<br>', $GLOBALS['xoopsSecurity']->getErrors());
        redirect_header($_SERVER['PHP_SELF'], 3, $error);
    }

    $honor_title = $_POST['honor_title'];
    $honor_date = $_POST['honor_date'];
    $honor_unit = $_POST['honor_unit'];
    $honor_content = $_POST['honor_content'];
    $honor_content = Wcag::amend($honor_content);
    $honor_url = $_POST['honor_url'];

    $sql = 'UPDATE `' . $xoopsDB->prefix('tad_honor') . '` SET
    `honor_title` = ?,
    `honor_date` = ?,
    `honor_unit` = ?,
    `honor_content` = ?,
    `honor_url` = ?,
    `honor_uid` = ?
    WHERE `honor_sn` = ?';
    Utility::query($sql, 'sssssii', [$honor_title, $honor_date, $honor_unit, $honor_content, $honor_url, $uid, $honor_sn]) or Utility::web_error($sql, __FILE__, __LINE__);

    $TadUpFiles = new TadUpFiles('tad_honor');
    $TadUpFiles->set_col('honor_sn', $honor_sn);
    $TadUpFiles->upload_file('up_honor_sn', '', '', '', '', true, false);
    unlink($json_file);
    return $honor_sn;
}

//新增資料到tad_honor中
/**
 * @return int
 */
function insert_tad_honor()
{
    global $xoopsDB, $xoopsUser, $json_file, $tad_honor_adm;

    if (!Utility::power_chk('tad_honor_post', 1) and !$tad_honor_adm) {
        redirect_header('index.php', 3, _TAD_PERMISSION_DENIED);
    }

    //取得使用者編號
    $uid = $xoopsUser ? $xoopsUser->uid() : '';

    //XOOPS表單安全檢查
    if ($_SERVER['SERVER_ADDR'] != '127.0.0.1' && !$GLOBALS['xoopsSecurity']->check()) {
        $error = implode('<br>', $GLOBALS['xoopsSecurity']->getErrors());
        redirect_header($_SERVER['PHP_SELF'], 3, $error);
    }

    $honor_title = $_POST['honor_title'];
    $honor_date = $_POST['honor_date'];
    $honor_unit = $_POST['honor_unit'];
    $honor_content = $_POST['honor_content'];
    $honor_content = Wcag::amend($honor_content);
    $honor_url = $_POST['honor_url'];

    $sql = 'INSERT INTO `' . $xoopsDB->prefix('tad_honor') . '` (`honor_title`, `honor_date`, `honor_unit`, `honor_counter`, `honor_content`, `honor_url`, `honor_uid`) VALUES (?, ?, ?, 0, ?, ?, ?)';
    Utility::query($sql, 'sssssi', [$honor_title, $honor_date, $honor_unit, $honor_content, $honor_url, $uid]) or Utility::web_error($sql, __FILE__, __LINE__);

    //取得最後新增資料的流水編號
    $honor_sn = $xoopsDB->getInsertId();

    $TadUpFiles = new TadUpFiles('tad_honor');
    $TadUpFiles->set_col('honor_sn', $honor_sn);
    $TadUpFiles->upload_file('up_honor_sn', '', '', '', '', true, false);
    unlink($json_file);
    return $honor_sn;
}

//tad_honor編輯表單
function tad_honor_form($honor_sn = '')
{
    global $xoopsTpl, $xoopsModuleConfig, $xoopsUser, $tad_honor_adm;

    if (!Utility::power_chk('tad_honor_post', 1) and !$tad_honor_adm) {
        redirect_header('index.php', 3, _TAD_PERMISSION_DENIED);
    }

    //抓取預設值
    if (!empty($honor_sn)) {
        $DBV = get_tad_honor($honor_sn);
    } else {
        $DBV = [];
    }

    //預設值設定

    //設定 honor_sn 欄位的預設值
    $honor_sn = !isset($DBV['honor_sn']) ? $honor_sn : $DBV['honor_sn'];
    $xoopsTpl->assign('honor_sn', $honor_sn);

    //設定 honor_title 欄位的預設值
    $honor_title = !isset($DBV['honor_title']) ? '' : $DBV['honor_title'];
    $xoopsTpl->assign('honor_title', $honor_title);

    //設定 honor_date 欄位的預設值
    $honor_date = !isset($DBV['honor_date']) ? date('Y-m-d') : $DBV['honor_date'];
    $xoopsTpl->assign('honor_date', $honor_date);

    //設定 honor_unit 欄位的預設值
    $honor_unit = !isset($DBV['honor_unit']) ? '' : $DBV['honor_unit'];
    $xoopsTpl->assign('honor_unit', $honor_unit);
    $unit_arr = explode(';', $xoopsModuleConfig['honor_unit']);
    foreach ($unit_arr as $i => $unit) {
        $unit_array[$i]['name'] = $unit;
    }
    $xoopsTpl->assign('unit_array', $unit_array);

    //設定 honor_counter 欄位的預設值
    $honor_counter = !isset($DBV['honor_counter']) ? '' : $DBV['honor_counter'];
    $xoopsTpl->assign('honor_counter', $honor_counter);

    //設定 honor_content 欄位的預設值
    $honor_content = !isset($DBV['honor_content']) ? '' : $DBV['honor_content'];
    $xoopsTpl->assign('honor_content', $honor_content);

    //設定 honor_url 欄位的預設值
    $honor_url = !isset($DBV['honor_url']) ? '' : $DBV['honor_url'];
    $xoopsTpl->assign('honor_url', $honor_url);

    //設定 honor_uid 欄位的預設值
    $user_uid = $xoopsUser ? $xoopsUser->uid() : '';
    $honor_uid = !isset($DBV['honor_uid']) ? $user_uid : $DBV['honor_uid'];
    $xoopsTpl->assign('honor_uid', $honor_uid);

    $op = empty($honor_sn) ? 'insert_tad_honor' : 'update_tad_honor';
    //$op="replace_tad_honor";

    $FormValidator = new FormValidator('#myForm', true);
    $FormValidator->render();

    //詳細內容
    $CkEditor = new CkEditor('tad_honor', 'honor_content', $honor_content);
    $CkEditor->setHeight(250);
    $editor = $CkEditor->render();
    $xoopsTpl->assign('honor_content_editor', $editor);

    $TadUpFiles = new TadUpFiles('tad_honor');
    $TadUpFiles->set_col('honor_sn', $honor_sn);
    $up_honor_sn_form = $TadUpFiles->upform(true, 'up_honor_sn', '');
    $xoopsTpl->assign('up_honor_sn_form', $up_honor_sn_form);

    //加入Token安全機制
    require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
    $token = new \XoopsFormHiddenToken();
    $token_form = $token->render();
    $xoopsTpl->assign('token_form', $token_form);
    $xoopsTpl->assign('now_op', 'tad_honor_form');
    $xoopsTpl->assign('next_op', $op);
}

//以流水號取得某筆tad_honor資料
/**
 * @param string $honor_sn
 * @return array|false|void
 */
function get_tad_honor($honor_sn = '')
{
    global $xoopsDB;
    if (empty($honor_sn)) {
        return;
    }
    $sql = 'SELECT * FROM `' . $xoopsDB->prefix('tad_honor') . '` WHERE `honor_sn` = ?';
    $result = Utility::query($sql, 'i', [$honor_sn]) or Utility::web_error($sql, __FILE__, __LINE__);

    $data = $xoopsDB->fetchArray($result);

    return $data;
}
