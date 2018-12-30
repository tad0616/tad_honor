<?php
//區塊主函式 (tad_honor_list)
function tad_honor_list($options)
{
    global $xoopsDB;

    //{$options[0]} : 顯示幾筆榮譽榜資料？
    $block['options0'] = $options[0];
    $sql               = "select  * from `" . $xoopsDB->prefix("tad_honor") . "`  order by `honor_date` desc limit $options[0] ";
    $result            = $xoopsDB->query($sql) or web_error($sql, __FILE__, __LINE__);
    $content           = array();
    $i                 = 0;
    while ($all = $xoopsDB->fetchArray($result)) {
        $content[$i] = $all;
        $i++;
    }
    $block['content'] = $content;

    return $block;
}

//區塊編輯函式 (tad_honor_list_edit)
function tad_honor_list_edit($options)
{

    $form = "
    <ol class='my-form'>
        <li class='my-row'>
            <lable class='my-label'>" . _MB_TADHONOR_LIST_OPT0 . "</lable>
            <div class='my-content'>
                <input type='text' class='my-input' name='options[0]' value='{$options[0]}' size=6>
            </div>
        </li>
    </ol>";

    return $form;
}
