<?php
//區塊主函式 (tad_honor_marquee)
function tad_honor_marquee($options)
{
    global $xoopsDB, $xoTheme;

    //{$options[0]} : 取出幾筆榮譽榜資料？
    $block['options0'] = $options[0] = empty($options[0]) ? 10 : $options[0];
    //{$options[1]} : 文字大小
    $options[1] = intval($options[1]);

    if ($options[1] < 11 or $options[1] > 60) {
        $options[1] = 24;
    }

    $block['options1'] = $options[1];
    $block['height']   = ($options[1] * 3) + 20;
    //{$options[2]} : 背景顏色
    if (is_numeric($options[2])) {
        $options[2] = "#f2f2ff";
    }
    $block['options2'] = $options[2];
    //{$options[3]} : 跑馬燈外框樣式設定
    if (strpos($options[3], ';') !== false) {
        $options[3] = "1px solid #08084d";
    }
    $block['options3'] = $options[3];

    $sql     = "select * from `" . $xoopsDB->prefix("tad_honor") . "` order by `honor_date` desc limit 0, {$options[0]}";
    $result  = $xoopsDB->query($sql) or web_error($sql, __FILE__, _LINE__);
    $content = array();

    $i = 0;
    while ($all = $xoopsDB->fetchArray($result)) {
        $content[$i] = $all;
        $i++;
    }
    $block['content'] = $content;

    $xoTheme->addStylesheet(XOOPS_URL . '/modules/tad_honor/class/jquery.marquee/css/jquery.marquee.css');
    $xoTheme->addScript(XOOPS_URL . '/modules/tad_honor/class/jquery.marquee/lib/jquery.marquee.js');
    return $block;
}

//區塊編輯函式 (tad_honor_marquee_edit)
function tad_honor_marquee_edit($options)
{
    $options[1] = intval($options[1]);
    if ($options[1] < 11 or $options[1] > 60) {
        $options[1] = 24;
    }

    if (is_numeric($options[2])) {
        $options[2] = "#f2f2ff";
    }

    if (strpos($options[3], ';') !== false) {
        $options[3] = "1px solid #08084d";
    }

    $form = "
  <table>
    <tr>
      <th style='width:120px;'>
        <!--取出幾筆榮譽榜資料？-->
        " . _MB_TADHONOR_MARQUEE_OPT0 . "
      </th>
      <td>
        <input type='text' name='options[0]' value='{$options[0]}'>
      </td>
    </tr>
    <tr>
      <th>
        <!--文字大小-->
        " . _MB_TADHONOR_MARQUEE_OPT1 . "
      </th>
      <td>
        <input type='text' name='options[1]' value='{$options[1]}'>px
      </td>
    </tr>
    <tr>
      <th>
        <!--背景顏色-->
        " . _MB_TADHONOR_MARQUEE_OPT2 . "
      </th>
      <td>
        <input type='text' name='options[2]' value='{$options[2]}'>
      </td>
    </tr>
    <tr>
      <th>
        <!--跑馬燈外框樣式設定-->
        " . _MB_TADHONOR_MARQUEE_OPT3 . "
      </th>
      <td>
        <input type='text' name='options[3]' value='{$options[3]}'>
      </td>
    </tr>
  </table>
  ";

    return $form;
}
