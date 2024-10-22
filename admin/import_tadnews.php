<?php
use Xmf\Request;
use XoopsModules\Tadtools\Utility;
/*-----------引入檔案區--------------*/
$xoopsOption['template_main'] = 'tad_honor_admin.tpl';
require_once __DIR__ . '/header.php';
/*-----------執行動作判斷區----------*/
$op = Request::getString('op');
$nsn = Request::getArray('nsn');
$ncsn = Request::getInt('ncsn');
$json_file = XOOPS_ROOT_PATH . '/uploads/tad_honor_data.json';

switch ($op) {

    case 'import_now':
        import_now($nsn, $ncsn);
        header('location: ../index.php');
        exit;

    case 'list_tadnews':
        list_tadnews($ncsn);
        $op = 'list_tadnews';
        break;
    default:
        list_tadnews_cate();
        $op = 'tad_honor_import_tadnews';
        break;

}

/*-----------秀出結果區--------------*/
$xoopsTpl->assign('now_op', $op);
require_once __DIR__ . '/footer.php';

/*-----------功能函數區--------------*/

//列出所有 list_tadnews 資料
function list_tadnews_cate()
{
    global $xoopsDB, $xoopsModule, $xoopsTpl;

    //取得某模組編號

    $moduleHandler = xoops_getHandler('module');
    $ThexoopsModule = $moduleHandler->getByDirname('tadnews');

    if ($ThexoopsModule) {
        $mod_id = $ThexoopsModule->getVar('mid');
        $xoopsTpl->assign('show_error', '0');
    } else {
        $xoopsTpl->assign('show_error', '1');
        $xoopsTpl->assign('msg', _MA_TADHONOR_NO_TADNEWS);

        return;
    }

    $sql = 'SELECT * FROM `' . $xoopsDB->prefix('tad_news_cate') . '`';
    $result = Utility::query($sql) or Utility::web_error($sql, __FILE__, __LINE__);

    $all_cate = [];
    while (false !== ($all = $xoopsDB->fetchArray($result))) {
        $all_cate[] = $all;
    }

    $xoopsTpl->assign('all_cate', $all_cate);
}

//列出所有 list_tadnews 資料
/**
 * @param $ncsn
 */
function list_tadnews($ncsn)
{
    global $xoopsDB, $xoopsTpl;

    $sql = 'SELECT * FROM `' . $xoopsDB->prefix('tad_news') . '` WHERE `ncsn`=? AND `enable`=1';
    $result = Utility::query($sql, 'i', [$ncsn]) or Utility::web_error($sql, __FILE__, __LINE__);

    $all_content = [];
    while (false !== ($all = $xoopsDB->fetchArray($result))) {
        $all_content[] = $all;
    }

    $xoopsTpl->assign('all_content', $all_content);
    $xoopsTpl->assign('ncsn', $ncsn);
}

//匯入
/**
 * @param $nsn_arr
 * @param $ncsn
 */
function import_now($nsn_arr, $ncsn)
{
    global $xoopsDB, $xoopsModuleConfig, $json_file;

    $honor_unit_arr = explode(';', $xoopsModuleConfig['honor_unit']);

    $sql = 'SELECT * FROM `' . $xoopsDB->prefix('tad_news') . '` WHERE `ncsn`=? AND `enable`=1';
    $result = Utility::query($sql, 'i', [$ncsn]) or Utility::web_error($sql, __FILE__, __LINE__);

    while (false !== ($all = $xoopsDB->fetchArray($result))) {
        if (in_array($all['nsn'], $nsn_arr)) {
            $honor_title = $all['news_title'];
            $honor_content = empty($all['news_title']) ? $honor_title : $all['news_content'];
            $honor_unit = $honor_unit_arr[0];
            $honor_date = $all['start_day'];
            $honor_counter = (int) $all['counter'];
            $honor_uid = (int) $all['uid'];
            $sql = 'REPLACE INTO `' . $xoopsDB->prefix('tad_honor') . '`
            (`honor_title`, `honor_date`, `honor_unit`, `honor_counter`, `honor_content`, `honor_url`, `honor_uid`)
            VALUES (?, ?, ?, ?, ?, ?, ?)';
            Utility::query($sql, 'sssissi', [$honor_title, $honor_date, $honor_unit, $honor_counter, $honor_content, '', $honor_uid]) or Utility::web_error($sql, __FILE__, __LINE__);

        }
    }
    unlink($json_file);
}
