<?php
use Xmf\Request;
use XoopsModules\Tadtools\Utility;
/*-----------引入檔案區--------------*/
$GLOBALS['xoopsOption']['template_main'] = 'tad_honor_adm_import_tadnews.tpl';
require_once __DIR__ . '/header.php';
require_once dirname(__DIR__) . '/function.php';
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
    $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);

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
    global $xoopsDB, $xoopsModule, $xoopsTpl;

    $sql = 'SELECT * FROM `' . $xoopsDB->prefix('tad_news') . "` where ncsn='{$ncsn}' and `enable`='1'";
    $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);

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
    global $xoopsDB, $xoopsModuleConfig;

    $honor_unit_arr = explode(';', $xoopsModuleConfig['honor_unit']);

    $sql = 'SELECT * FROM `' . $xoopsDB->prefix('tad_news') . "` where ncsn='{$ncsn}' and `enable`='1'";
    $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);

    while (false !== ($all = $xoopsDB->fetchArray($result))) {
        if (in_array($all['nsn'], $nsn_arr)) {
            $honor_title = $xoopsDB->escape($all['news_title']);
            $honor_content = empty($all['news_title']) ? $honor_title : $xoopsDB->escape($all['news_content']);
            $honor_unit = $honor_unit_arr[0];
            $honor_date = $xoopsDB->escape($all['start_day']);
            $honor_counter = (int) $all['counter'];
            $honor_uid = (int) $all['uid'];

            $sql = 'replace into `' . $xoopsDB->prefix('tad_honor') . "`
            (`honor_title`, `honor_date`, `honor_unit`, `honor_counter`, `honor_content`, `honor_url`, `honor_uid`)
            values('{$honor_title}' , '{$honor_date}' ,  '{$honor_unit}' , '{$honor_counter}' , '{$honor_content}' , '' , '{$honor_uid}' )";
            $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        }
    }
}

/*-----------執行動作判斷區----------*/
$op = Request::getString('op');
$nsn = Request::getArray('nsn');
$ncsn = Request::getInt('ncsn');

switch ($op) {
    /*---判斷動作請貼在下方---*/

    case 'import_now':
        import_now($nsn, $ncsn);
        header('location: ../index.php');
        exit;

    case 'list_tadnews':
        list_tadnews($ncsn);
        break;
    default:
        list_tadnews_cate();

        break;
        /*---判斷動作請貼在上方---*/
}

/*-----------秀出結果區--------------*/
require_once __DIR__ . '/footer.php';
