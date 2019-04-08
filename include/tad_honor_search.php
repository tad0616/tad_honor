<?php
//榮譽榜搜尋程式
function tad_honor_search($queryarray, $andor, $limit, $offset, $userid)
{
    global $xoopsDB;
    if (get_magic_quotes_gpc()) {
        foreach ($queryarray as $k => $v) {
            $arr[$k] = addslashes($v);
        }
        $queryarray = $arr;
    }
    $sql = "SELECT `honor_sn`,`honor_title`,`honor_date`, `honor_uid` FROM " . $xoopsDB->prefix("tad_honor") . " where 1";
    if ($userid != 0) {
        $sql .= " AND uid=" . $userid . " ";
    }
    if (is_array($queryarray) && $count = count($queryarray)) {
        $sql .= " AND ((`honor_title` LIKE '%{$queryarray[0]}%'  OR `honor_unit` LIKE '%{$queryarray[0]}%' OR  `honor_content` LIKE '%{$queryarray[0]}%')";
        for ($i = 1; $i < $count; $i++) {
            $sql .= " $andor ";
            $sql .= "(`honor_title` LIKE '%{$queryarray[$i]}%' OR  `honor_unit` LIKE '%{$queryarray[$i]}%'  OR  `honor_content` LIKE '%{$queryarray[$i]}%')";
        }
        $sql .= ") ";
    }
    $sql .= "ORDER BY  `honor_date` DESC";
    $result = $xoopsDB->query($sql, $limit, $offset);
    $ret    = array();
    $i      = 0;
    while ($myrow = $xoopsDB->fetchArray($result)) {
        $ret[$i]['image'] = "images/coins.png";
        $ret[$i]['link']  = "index.php?honor_sn=" . $myrow['honor_sn'];
        $ret[$i]['title'] = $myrow['honor_title'];
        $ret[$i]['time']  = strtotime($myrow['honor_date']);
        $ret[$i]['uid']   = $myrow['honor_uid'];
        $i++;
    }

    return $ret;
}
