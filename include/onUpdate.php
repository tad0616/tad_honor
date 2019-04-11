<?php

use XoopsModules\Tad_honor\Utility;

function xoops_module_update_tad_honor(&$module, $old_version)
{
    global $xoopsDB;

    Utility::mk_dir(XOOPS_ROOT_PATH . "/uploads/tad_honor");
    Utility::mk_dir(XOOPS_ROOT_PATH . "/uploads/tad_honor/file");
    Utility::mk_dir(XOOPS_ROOT_PATH . "/uploads/tad_honor/image");
    Utility::mk_dir(XOOPS_ROOT_PATH . "/uploads/tad_honor/image/.thumbs");
    //if(!chk_chk1()) tad_honor_go_update1();
    //新增檔案欄位
    if (Utility::chk_fc_tag()) {
        Utility::go_fc_tag();
    }

    return true;
}


