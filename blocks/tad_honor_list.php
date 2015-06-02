<?php

//  ------------------------------------------------------------------------ //
// 本模組由 tad 製作
// 製作日期：2015-01-22
// $Id:$
// ------------------------------------------------------------------------- //

//區塊主函式 (tad_honor_list)
function tad_honor_list($options) {
    global $xoopsDB;

    //{$options[0]} : 顯示幾筆榮譽榜資料？
    $block['options0'] = $options[0];
    $sql               = "select * from `" . $xoopsDB->prefix("tad_honor") . "` order by `honor_date` desc";
    $result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'], 3, mysql_error());
    $content = '';
    $i       = 0;
    while ($all = $xoopsDB->fetchArray($result)) {
        $content[$i] = $all;
        $i++;
    }
    $block['bootstrap_version'] = $_SESSION['bootstrap'];
    $block['content']           = $content;

    return $block;
}

//區塊編輯函式 (tad_honor_list_edit)
function tad_honor_list_edit($options) {

    $form = "
  <table>
    <tr>
      <th>
        <!--顯示幾筆榮譽榜資料？-->
        " . _MB_TADHONOR_LIST_OPT0 . "
      </th>
      <td>
        <input type='text' name='options[0]' value='{$options[0]}'>
      </td>
    </tr>
  </table>
  ";

    return $form;
}
