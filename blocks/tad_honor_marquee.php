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
    // $block['height']   = 400;
    $block['height'] = $options[1] * 1.6;
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
    $result  = $xoopsDB->query($sql) or web_error($sql, __FILE__, __LINE__);
    $content = array();

    $i = 0;
    while ($all = $xoopsDB->fetchArray($result)) {
        $content[$i] = $all;
        $i++;
    }
    $block['content'] = $content;

    $xoTheme->addScript('browse.php?Frameworks/jquery/jquery.js');
    $xoTheme->addStylesheet(XOOPS_URL . '/modules/tad_honor/class/jquery.marquee/css/jquery.marquee.css');
    $xoTheme->addScript(XOOPS_URL . '/modules/tad_honor/class/jquery.marquee/lib/jquery.marquee.js');
    return $block;
}

//區塊編輯函式 (tad_honor_marquee_edit)
function tad_honor_marquee_edit($options)
{
    if (!file_exists(XOOPS_ROOT_PATH . "/modules/tadtools/mColorPicker.php")) {
        redirect_header("index.php", 3, _MA_NEED_TADTOOLS);
    }
    include_once XOOPS_ROOT_PATH . "/modules/tadtools/mColorPicker.php";
    $mColorPicker = new mColorPicker('.color');
    $mColorPicker->render();

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
    <ol class='my-form'>
        <li class='my-row'>
            <lable class='my-label'>" . _MB_TADHONOR_MARQUEE_OPT0 . "</lable>
            <div class='my-content'>
                <input type='text' class='my-input' name='options[0]' value='{$options[0]}' size=6>
            </div>
        </li>
        <li class='my-row'>
            <lable class='my-label'>" . _MB_TADHONOR_MARQUEE_OPT1 . "</lable>
            <div class='my-content'>
                <input type='text' class='my-input' name='options[1]' value='{$options[1]}' size=6>px
            </div>
        </li>
        <li class='my-row'>
            <lable class='my-label'>" . _MB_TADHONOR_MARQUEE_OPT2 . "</lable>
            <div class='my-content'>
                <input type='text' class='my-input color' data-hex='true' name='options[2]' value='{$options[2]}' size=6>
            </div>
        </li>
        <li class='my-row'>
            <lable class='my-label'>" . _MB_TADHONOR_MARQUEE_OPT3 . "</lable>
            <div class='my-content'>
                <input type='text' class='my-input' name='options[3]' value='{$options[3]}' size=100>
            </div>
        </li>
    </ol>";

    return $form;
}
