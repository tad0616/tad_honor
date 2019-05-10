<?php

use XoopsModules\Tadtools\Utility;
use XoopsModules\Tad_honor\Update;
if (!class_exists('XoopsModules\Tadtools\Utility')) {
    require XOOPS_ROOT_PATH . '/modules/tadtools/preloads/autoloader.php';
}
if (!class_exists('XoopsModules\Tad_honor\Update')) {
    include dirname(__DIR__) . '/preloads/autoloader.php';
}
function xoops_module_update_tad_honor(&$module, $old_version)
{
    global $xoopsDB;

    Utility::mk_dir(XOOPS_ROOT_PATH . '/uploads/tad_honor');
    Utility::mk_dir(XOOPS_ROOT_PATH . '/uploads/tad_honor/file');
    Utility::mk_dir(XOOPS_ROOT_PATH . '/uploads/tad_honor/image');
    Utility::mk_dir(XOOPS_ROOT_PATH . '/uploads/tad_honor/image/.thumbs');

    //新增檔案欄位
    if (Update::chk_fc_tag()) {
        Update::go_fc_tag();
    }

    return true;
}
