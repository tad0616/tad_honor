<?php
include_once XOOPS_ROOT_PATH . "/modules/tadtools/language/{$xoopsConfig['language']}/modinfo_common.php";

define('_MI_TADHONOR_NAME', '榮譽榜');
define('_MI_TADHONOR_AUTHOR', '榮譽榜');
define('_MI_TADHONOR_CREDITS', '');
define('_MI_TADHONOR_DESC', '榮譽榜模組');
define('_MI_TADHONOR_AUTHOR_WEB', 'Tad 教材網');
define('_MI_TADHONOR_ADMENU1', '榮譽榜管理');
define('_MI_TADHONOR_ADMENU1_DESC', '榮譽榜管理');
define('_MI_TADHONOR_ADMENU2', '權限設定');
define('_MI_TADHONOR_ADMENU2_DESC', '權限設定');
define('_MI_TADHONOR_ADMENU3', '匯入 fred_honorboard');
define('_MI_TADHONOR_ADMENU3_DESC', '轉移 fred_honorboard 資料到此模組');
define('_MI_TADHONOR_ADMENU4', '匯入 tadnews 的榮譽榜');
define('_MI_TADHONOR_ADMENU4_DESC', '匯入 tadnews 的榮譽榜資料到此模組');

define('_MI_TADHONOR_LIST_BLOCK_NAME', '最新榮譽榜');
define('_MI_TADHONOR_LIST_BLOCK_DESC', '最新榮譽榜區塊 (tad_honor_list)');

define('_MI_TADHONOR_MARQUEE_BLOCK_NAME', '榮譽榜跑馬燈');
define('_MI_TADHONOR_MARQUEE_BLOCK_DESC', '榮譽榜跑馬燈區塊 (tad_honor_marquee)');
define('_MI_TADHONOR_HONOR_UNIT', '發布單位設定');
define('_MI_TADHONOR_HONOR_UNIT_DESC', '發布單位設定');
define('_MI_TADHONOR_HONOR_UNIT_DEFAULT', '教務處;學務處;校長室');
define('_MI_TADHONOR_SHOW_CONFETTI', '是否顯示動態彩帶');
define('_MI_TADHONOR_SHOW_CONFETTI_DESC', '是否顯示榮譽榜內容的動態彩帶');

define('_MI_TADHONOR_DIRNAME', basename(dirname(dirname(__DIR__))));
define('_MI_TADHONOR_HELP_HEADER', __DIR__ . '/help/helpheader.tpl');
define('_MI_TADHONOR_BACK_2_ADMIN', '回到後臺 ');

//help
define('_MI_TADHONOR_HELP_OVERVIEW', '概覽');
