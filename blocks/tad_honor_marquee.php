<?php
//區塊主函式 (tad_honor_marquee)
function tad_honor_marquee($options)
{
    global $xoopsDB;

    //{$options[0]} : 取出幾筆榮譽榜資料？
    $block['options0'] = $options[0];
    //{$options[1]} : 跑馬燈方向
    $block['options1'] = $options[1];
    //{$options[2]} : 跑馬燈速度
    $block['options2'] = $options[2];
    //{$options[3]} : 跑馬燈CSS外觀設定
    $block['options3'] = $options[3];
    //{$options[4]} : 跑馬燈條目CSS外觀設定
    $block['options4'] = $options[4];
    $sql               = "select * from `" . $xoopsDB->prefix("tad_honor") . "` order by `honor_date` desc";
    $result            = $xoopsDB->query($sql) or web_error($sql);
    $content           = '';
    $i                 = 0;
    while ($all = $xoopsDB->fetchArray($result)) {
        $content[$i] = $all;
        $i++;
    }
    $block['content'] = $content;

    return $block;
}

//區塊編輯函式 (tad_honor_marquee_edit)
function tad_honor_marquee_edit($options)
{

    //"跑馬燈方向"預設值
    $checked_1_0 = ($options[1] == 'left') ? 'checked' : '';
    $checked_1_1 = ($options[1] == 'right') ? 'checked' : '';
    $checked_1_2 = ($options[1] == 'up') ? 'checked' : '';
    $checked_1_3 = ($options[1] == 'down') ? 'checked' : '';

    //"跑馬燈速度"預設值
    $selected_2_0 = ($options[2] == '2') ? 'selected' : '';
    $selected_2_1 = ($options[2] == '4') ? 'selected' : '';
    $selected_2_2 = ($options[2] == '6') ? 'selected' : '';
    $selected_2_3 = ($options[2] == '8') ? 'selected' : '';
    $selected_2_4 = ($options[2] == '10') ? 'selected' : '';

    $form = "
  <table>
    <tr>
      <th>
        <!--取出幾筆榮譽榜資料？-->
        " . _MB_TADHONOR_MARQUEE_OPT0 . "
      </th>
      <td>
        <input type='text' name='options[0]' value='{$options[0]}'>
      </td>
    </tr>
    <tr>
      <th>
        <!--跑馬燈方向-->
        " . _MB_TADHONOR_MARQUEE_OPT1 . "
      </th>
      <td>
          <input type='radio' name='options[1]' value='left' $checked_1_0> left
          <input type='radio' name='options[1]' value='right' $checked_1_1> right
          <input type='radio' name='options[1]' value='up' $checked_1_2> up
          <input type='radio' name='options[1]' value='down' $checked_1_3> down
      </td>
    </tr>
    <tr>
      <th>
        <!--跑馬燈速度-->
        " . _MB_TADHONOR_MARQUEE_OPT2 . "
      </th>
      <td>
        <select name='options[2]'>
          <option value='2' $selected_2_0>2</option>
          <option value='4' $selected_2_1>4</option>
          <option value='6' $selected_2_2>6</option>
          <option value='8' $selected_2_3>8</option>
          <option value='10' $selected_2_4>10</option>
        </select>
      </td>
    </tr>
    <tr>
      <th>
        <!--跑馬燈CSS外觀設定-->
        " . _MB_TADHONOR_MARQUEE_OPT3 . "
      </th>
      <td>
        <textarea name='options[3]'>{$options[3]}</textarea>
      </td>
    </tr>
    <tr>
      <th>
        <!--跑馬燈條目CSS外觀設定-->
        " . _MB_TADHONOR_MARQUEE_OPT4 . "
      </th>
      <td>
        <textarea name='options[4]'>{$options[4]}</textarea>
      </td>
    </tr>
  </table>
  ";

    return $form;
}
