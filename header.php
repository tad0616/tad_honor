<?php
require_once dirname(dirname(__DIR__)) . '/mainfile.php';

//判斷是否對該模組有管理權限
if (!isset($_SESSION['tad_honor_adm'])) {
    $_SESSION['tad_honor_adm'] = ($xoopsUser) ? $xoopsUser->isAdmin() : false;
}

$interface_menu[_MD_TADHONOR_LIST] = 'index.php';
$interface_icon[_MD_TADHONOR_LIST] = "fa-trophy";
