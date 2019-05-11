<?php
$modversion = [];

//---模組基本資訊---//
$modversion['name'] = _MI_TADHONOR_NAME;
$modversion['version'] = '1.48';
$modversion['description'] = _MI_TADHONOR_DESC;
$modversion['author'] = _MI_TADHONOR_AUTHOR;
$modversion['credits'] = _MI_TADHONOR_CREDITS;
$modversion['help'] = 'page=help';
$modversion['license'] = 'GPL see LICENSE';
$modversion['license_url'] = 'www.gnu.org/licenses/gpl-2.0.html/';
$modversion['image'] = "images/logo_{$xoopsConfig['language']}.png";
$modversion['dirname'] = basename(__DIR__);

//---模組狀態資訊---//
$modversion['release_date'] = '2019/05/10';
$modversion['module_website_url'] = 'https://tad0616.net';
$modversion['module_website_name'] = _MI_TADHONOR_AUTHOR_WEB;
$modversion['module_status'] = 'release';
$modversion['author_website_url'] = 'https://tad0616.net';
$modversion['author_website_name'] = _MI_TADHONOR_AUTHOR_WEB;
$modversion['min_php'] = 5.4;
$modversion['min_xoops'] = '2.5';

//---paypal資訊---//
$modversion['paypal'] = [];
$modversion['paypal']['business'] = 'tad0616@gmail.com';
$modversion['paypal']['item_name'] = 'Donation :' . _MI_TADHONOR_AUTHOR;
$modversion['paypal']['amount'] = 0;
$modversion['paypal']['currency_code'] = 'USD';

//---安裝設定---//
$modversion['onInstall'] = 'include/onInstall.php';
$modversion['onUpdate'] = 'include/onUpdate.php';
$modversion['onUninstall'] = 'include/onUninstall.php';

//---啟動後台管理界面選單---//
$modversion['system_menu'] = 1;

//---資料表架構---//
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';
$modversion['tables'][1] = 'tad_honor';
$modversion['tables'][2] = 'tad_honor_files_center';

//---管理介面設定---//
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = 'admin/main.php';
$modversion['adminmenu'] = 'admin/menu.php';

//---使用者主選單設定---//
$modversion['hasMain'] = 1;

//---搜尋設定---//
$modversion['hasSearch'] = 1;
$modversion['search']['file'] = 'include/tad_honor_search.php';
$modversion['search']['func'] = 'tad_honor_search';

//---樣板設定---//

$modversion['templates'] = [
    ['file' => 'tad_honor_adm_main.tpl', 'description' => 'tad_honor_adm_main.tpl'],
    ['file' => 'tad_honor_adm_power.tpl', 'description' => 'tad_honor_adm_power.tpl'],
    ['file' => 'tad_honor_adm_import.tpl', 'description' => 'tad_honor_adm_import.tpl'],
    ['file' => 'tad_honor_adm_import_tadnews.tpl', 'description' => 'tad_honor_adm_import_tadnews.tpl'],
    ['file' => 'tad_honor_index.tpl', 'description' => 'tad_honor_index.tpl'],
];


//---區塊設定---//

$modversion['blocks'][] = [
    'file'        => 'tad_honor_list.php',
    'name'        => _MI_TADHONOR_LIST_BLOCK_NAME,
    'description' => _MI_TADHONOR_LIST_BLOCK_DESC,
    'show_func'   => 'tad_honor_list',
    'template'    => 'tad_honor_list.tpl',
    'edit_func'   => 'tad_honor_list_edit',
    'options'     => '10',
];

$modversion['blocks'][] = [
    'file'        => 'tad_honor_marquee.php',
    'name'        => _MI_TADHONOR_MARQUEE_BLOCK_NAME,
    'description' => _MI_TADHONOR_MARQUEE_BLOCK_DESC,
    'show_func'   => 'tad_honor_marquee',
    'template'    => 'tad_honor_marquee.tpl',
    'edit_func'   => 'tad_honor_marquee_edit',
    'options'     => '6|24|#f2f2ff|1px solid #08084d',
];



$i = 0;
$modversion['config'][$i]['name'] = 'honor_unit';
$modversion['config'][$i]['title'] = '_MI_TADHONOR_HONOR_UNIT';
$modversion['config'][$i]['description'] = '_MI_TADHONOR_HONOR_UNIT_DESC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = _MI_TADHONOR_HONOR_UNIT_DEFAULT;
$i++;

$modversion['config'][$i]['name'] = 'show_confetti';
$modversion['config'][$i]['title'] = '_MI_TADHONOR_SHOW_CONFETTI';
$modversion['config'][$i]['description'] = '_MI_TADHONOR_SHOW_CONFETTI_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;
$i++;
