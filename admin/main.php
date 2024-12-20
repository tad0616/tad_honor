<?php
/*-----------引入檔案區--------------*/
$xoopsOption['template_main'] = 'tad_honor_admin.tpl';
require_once __DIR__ . '/header.php';

require_once XOOPS_ROOT_PATH . '/Frameworks/art/functions.php';
require_once XOOPS_ROOT_PATH . '/Frameworks/art/functions.admin.php';
require_once XOOPS_ROOT_PATH . '/class/xoopsform/grouppermform.php';

/*-----------function區--------------*/
$module_id = $xoopsModule->getVar('mid');

$perm_desc = '';

$formi = new \XoopsGroupPermForm('', $module_id, 'tad_honor_post', $perm_desc, null, false);
$formi->addItem('1', _MA_TADHONOR_HONOR_PUBLISH_PERMISSIONS);

$permission_content = $formi->render();
$xoopsTpl->assign('permission_content', $permission_content);

/*-----------秀出結果區--------------*/
$xoopsTpl->assign('now_op', 'tad_honor_power');
$xoopsTpl->assign('tad_honor_adm', $tad_honor_adm);
require_once __DIR__ . '/footer.php';
