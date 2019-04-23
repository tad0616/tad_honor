<?php

use XoopsModules\Tad_honor\Utility;

include dirname(__DIR__) . '/preloads/autoloader.php';

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
