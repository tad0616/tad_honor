<?php

use XoopsModules\Tadtools\Utility;

if (!class_exists('XoopsModules\Tadtools\Utility')) {
    require XOOPS_ROOT_PATH . '/modules/tadtools/preloads/autoloader.php';
}
/**
 * @param $module
 * @return bool
 */
function xoops_module_install_tad_honor(&$module)
{
    Utility::mk_dir(XOOPS_ROOT_PATH . '/uploads/tad_honor');
    Utility::mk_dir(XOOPS_ROOT_PATH . '/uploads/tad_honor/file');
    Utility::mk_dir(XOOPS_ROOT_PATH . '/uploads/tad_honor/image');
    Utility::mk_dir(XOOPS_ROOT_PATH . '/uploads/tad_honor/image/.thumbs');

    return true;
}
