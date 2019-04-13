<?php
$adminmenu = [];
$i = 1;

$adminmenu[$i]['title'] = _MI_TAD_ADMIN_HOME;
$adminmenu[$i]['link'] = 'admin/index.php';
$adminmenu[$i]['desc'] = _MI_TAD_ADMIN_HOME_DESC;
$adminmenu[$i]['icon'] = 'images/admin/home.png';

$i++;
$adminmenu[$i]['title'] = _MI_TADHONOR_ADMENU1;
$adminmenu[$i]['link'] = 'admin/main.php';
$adminmenu[$i]['desc'] = _MI_TADHONOR_ADMENU1_DESC;
$adminmenu[$i]['icon'] = 'images/admin/badge.png';

$i++;
$adminmenu[$i]['title'] = _MI_TADHONOR_ADMENU2;
$adminmenu[$i]['link'] = 'admin/power.php';
$adminmenu[$i]['desc'] = _MI_TADHONOR_ADMENU2_DESC;
$adminmenu[$i]['icon'] = 'images/admin/keys.png';

$i++;
$adminmenu[$i]['title'] = _MI_TADHONOR_ADMENU3;
$adminmenu[$i]['link'] = 'admin/import.php';
$adminmenu[$i]['desc'] = _MI_TADHONOR_ADMENU3_DESC;
$adminmenu[$i]['icon'] = 'images/admin/synchronized.png';

$i++;
$adminmenu[$i]['title'] = _MI_TADHONOR_ADMENU4;
$adminmenu[$i]['link'] = 'admin/import_tadnews.php';
$adminmenu[$i]['desc'] = _MI_TADHONOR_ADMENU4_DESC;
$adminmenu[$i]['icon'] = 'images/admin/synchronized.png';

$i++;
$adminmenu[$i]['title'] = _MI_TAD_ADMIN_ABOUT;
$adminmenu[$i]['link'] = 'admin/about.php';
$adminmenu[$i]['desc'] = _MI_TAD_ADMIN_ABOUT_DESC;
$adminmenu[$i]['icon'] = 'images/admin/about.png';
