<?php
//  ------------------------------------------------------------------------ //
// 本模組由 tad 製作
// 製作日期：2015-01-22
// $Id:$
// ------------------------------------------------------------------------- //
include_once XOOPS_ROOT_PATH . "/modules/tadtools/language/{$xoopsConfig['language']}/modinfo_common.php";

define('_MI_TADHONOR_NAME', 'Tad Honor Roll');
define('_MI_TADHONOR_AUTHOR', 'Fame');
define('_MI_TADHONOR_CREDITS', '');
define('_MI_TADHONOR_DESC', 'Honor Roll module');
define('_MI_TADHONOR_AUTHOR_WEB', 'Tad teaching network');
define('_MI_TADHONOR_ADMENU1', "Honor Roll Management");
define('_MI_TADHONOR_ADMENU1_DESC', "Honor Roll Management");

define('_MI_TADHONOR_LIST_BLOCK_NAME', 'New Hall of Fame');
define('_MI_TADHONOR_LIST_BLOCK_DESC', 'Latest honor roll block (tad_honor_list)');

define('_MI_TADHONOR_MARQUEE_BLOCK_NAME', 'Honor Roll Marquee');
define('_MI_TADHONOR_MARQUEE_BLOCK_DESC', 'Honor Roll Marquee block (tad_honor_marquee)');
define('_MI_TADHONOR_HONOR_UNIT', 'Publishing unit setting');
define('_MI_TADHONOR_HONOR_UNIT_DESC', 'Publishing unit setting');
define('_MI_TADHONOR_HONOR_UNIT_DEFAULT', 'Office of Academic Affairs; President\'s Office; Office of Student Affairs');

define('_MI_TADHONOR_DIRNAME', basename(dirname(dirname(__DIR__))));
define('_MI_TADHONOR_HELP_HEADER', __DIR__ . '/help/helpheader.html');
define('_MI_TADHONOR_BACK_2_ADMIN', 'Back to Administration of ');

//help
define('_MI_TADHONOR_HELP_OVERVIEW', 'Overview');
