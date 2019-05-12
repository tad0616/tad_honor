<?php
use XoopsModules\Tadtools\CkEditor;
use XoopsModules\Tadtools\FormValidator;
use XoopsModules\Tadtools\TadUpFiles;
use XoopsModules\Tadtools\Utility;
xoops_loadLanguage('main', 'tadtools');
/********************* 自訂函數 ********************
 * @param string $honor_sn
 */
/*
 * @param string $honor_sn
 */

//tad_honor編輯表單
function tad_honor_form($honor_sn = '')
{
    global $xoopsDB, $xoopsTpl, $xoopsModuleConfig, $isAdmin, $xoopsUser;

    if (!Utility::power_chk('tad_honor_post', 1) and !$isAdmin) {
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
    $xoopsTpl->assign('action', $_SERVER['PHP_SELF']);
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
    $sql = 'SELECT * FROM `' . $xoopsDB->prefix('tad_honor') . "` where `honor_sn` = '{$honor_sn}'";
    $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
    $data = $xoopsDB->fetchArray($result);

    return $data;
}

//新增資料到tad_honor中
/**
 * @return int
 */
function insert_tad_honor()
{
    global $xoopsDB, $xoopsUser, $isAdmin;

    if (!Utility::power_chk('tad_honor_post', 1) and !$isAdmin) {
        redirect_header('index.php', 3, _TAD_PERMISSION_DENIED);
    }

    //取得使用者編號
    $uid = $xoopsUser ? $xoopsUser->uid() : '';

    //XOOPS表單安全檢查
    if (!$GLOBALS['xoopsSecurity']->check()) {
        $error = implode('<br>', $GLOBALS['xoopsSecurity']->getErrors());
        redirect_header($_SERVER['PHP_SELF'], 3, $error);
    }

    $myts = \MyTextSanitizer::getInstance();
    $_POST['honor_title'] = $myts->addSlashes($_POST['honor_title']);
    $_POST['honor_date'] = $myts->addSlashes($_POST['honor_date']);
    $_POST['honor_content'] = $myts->addSlashes($_POST['honor_content']);
    $_POST['honor_url'] = $myts->addSlashes($_POST['honor_url']);

    $sql = 'insert into `' . $xoopsDB->prefix('tad_honor') . "` (`honor_title` , `honor_date` , `honor_unit` , `honor_counter` , `honor_content` , `honor_url` , `honor_uid`) values('{$_POST['honor_title']}' , '{$_POST['honor_date']}' , '{$_POST['honor_unit']}' , 0 , '{$_POST['honor_content']}' , '{$_POST['honor_url']}' , '{$uid}')";
    $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);

    //取得最後新增資料的流水編號
    $honor_sn = $xoopsDB->getInsertId();

    $TadUpFiles = new TadUpFiles('tad_honor');
    $TadUpFiles->set_col('honor_sn', $honor_sn);
    $TadUpFiles->upload_file('up_honor_sn', '', '', '', '', true, false);

    return $honor_sn;
}

//更新tad_honor某一筆資料
/**
 * @param string $honor_sn
 * @return string
 */
function update_tad_honor($honor_sn = '')
{
    global $xoopsDB, $xoopsUser, $isAdmin;

    if (!Utility::power_chk('tad_honor_post', 1) and !$isAdmin) {
        redirect_header('index.php', 3, _TAD_PERMISSION_DENIED);
    }

    //取得使用者編號
    $uid = $xoopsUser ? $xoopsUser->uid() : '';

    //XOOPS表單安全檢查
    if (!$GLOBALS['xoopsSecurity']->check()) {
        $error = implode('<br>', $GLOBALS['xoopsSecurity']->getErrors());
        redirect_header($_SERVER['PHP_SELF'], 3, $error);
    }

    $myts = \MyTextSanitizer::getInstance();
    $_POST['honor_title'] = $myts->addSlashes($_POST['honor_title']);
    $_POST['honor_date'] = $myts->addSlashes($_POST['honor_date']);
    $_POST['honor_content'] = $myts->addSlashes($_POST['honor_content']);
    $_POST['honor_url'] = $myts->addSlashes($_POST['honor_url']);

    $sql = 'update `' . $xoopsDB->prefix('tad_honor') . "` set
   `honor_title` = '{$_POST['honor_title']}' ,
   `honor_date` = '{$_POST['honor_date']}' ,
   `honor_unit` = '{$_POST['honor_unit']}' ,
   `honor_content` = '{$_POST['honor_content']}' ,
   `honor_url` = '{$_POST['honor_url']}' ,
   `honor_uid` = '{$uid}'
  where `honor_sn` = '$honor_sn'";
    $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);

    $TadUpFiles = new TadUpFiles('tad_honor');
    $TadUpFiles->set_col('honor_sn', $honor_sn);
    $TadUpFiles->upload_file('up_honor_sn', '', '', '', '', true, false);

    return $honor_sn;
}
