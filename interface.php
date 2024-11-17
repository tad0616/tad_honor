<?php
//判斷是否對該模組有管理權限
if (!isset($tad_honor_adm)) {
    $tad_honor_adm = isset($xoopsUser) && \is_object($xoopsUser) ? $xoopsUser->isAdmin() : false;
}

$interface_menu[_MD_TADHONOR_LIST] = 'index.php';
$interface_icon[_MD_TADHONOR_LIST] = "fa-trophy";
