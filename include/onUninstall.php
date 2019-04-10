<?php

function xoops_module_uninstall_tad_honor(&$module)
{
    global $xoopsDB;
    $date = date("Ymd");

    rename(XOOPS_ROOT_PATH . "/uploads/tad_honor", XOOPS_ROOT_PATH . "/uploads/tad_honor_bak_{$date}");

    return true;
}

