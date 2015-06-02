<?php
//  ------------------------------------------------------------------------ //
// 本模組由 tad 製作
// 製作日期：2015-01-22
// $Id:$
// ------------------------------------------------------------------------- //

/*-----------引入檔案區--------------*/
include_once "../../../mainfile.php";
include_once "../function.php";
$xoopsOption['template_main'] = (isset($_SESSION['bootstrap']) and $_SESSION['bootstrap']=='3')? 'tad_honor_adm_main_b3.html':'tad_honor_adm_main.html';
include_once "header.php";

/*-----------功能函數區--------------*/


//tad_honor編輯表單
function tad_honor_form($honor_sn=""){
  global $xoopsDB , $xoopsTpl , $xoopsModuleConfig;

  //抓取預設值
  if(!empty($honor_sn)){
    $DBV=get_tad_honor($honor_sn);
  }else{
    $DBV=array();
  }

  //預設值設定
  
  
  //設定 honor_sn 欄位的預設值
  $honor_sn=!isset($DBV['honor_sn'])?$honor_sn:$DBV['honor_sn'];
  $xoopsTpl->assign('honor_sn' , $honor_sn);
  
  //設定 honor_title 欄位的預設值
  $honor_title=!isset($DBV['honor_title'])?"":$DBV['honor_title'];
  $xoopsTpl->assign('honor_title' , $honor_title);
  
  //設定 honor_date 欄位的預設值
  $honor_date=!isset($DBV['honor_date'])?date("Y-m-d"):$DBV['honor_date'];
  $xoopsTpl->assign('honor_date' , $honor_date);
  
  //設定 honor_unit 欄位的預設值
  $honor_unit=!isset($DBV['honor_unit'])?"":$DBV['honor_unit'];
  $xoopsTpl->assign('honor_unit' , $honor_unit);
  $unit_arr=explode(';',$xoopsModuleConfig['honor_unit']);
  foreach($unit_arr as $i=>$unit){
    $unit_array[$i]['name']=$unit;
  }
  $xoopsTpl->assign('unit_array' , $unit_array);
  
  //設定 honor_counter 欄位的預設值
  $honor_counter=!isset($DBV['honor_counter'])?"":$DBV['honor_counter'];
  $xoopsTpl->assign('honor_counter' , $honor_counter);
  
  //設定 honor_content 欄位的預設值
  $honor_content=!isset($DBV['honor_content'])?"":$DBV['honor_content'];
  $xoopsTpl->assign('honor_content' , $honor_content);
  
  //設定 honor_url 欄位的預設值
  $honor_url=!isset($DBV['honor_url'])?"":$DBV['honor_url'];
  $xoopsTpl->assign('honor_url' , $honor_url);
  
  //設定 honor_uid 欄位的預設值
  $user_uid=($xoopsUser)?$xoopsUser->uid():"";
  $honor_uid=!isset($DBV['honor_uid'])?$user_uid:$DBV['honor_uid'];
  $xoopsTpl->assign('honor_uid' , $honor_uid);

  $op=(empty($honor_sn))?"insert_tad_honor":"update_tad_honor";
  //$op="replace_tad_honor";

  //套用formValidator驗證機制
  if(!file_exists(TADTOOLS_PATH."/formValidator.php")){
    redirect_header("index.php",3, _TAD_NEED_TADTOOLS);
  }
  include_once TADTOOLS_PATH."/formValidator.php";
  $formValidator= new formValidator("#myForm",true);
  $formValidator_code=$formValidator->render();

  //詳細內容
  if(!file_exists(XOOPS_ROOT_PATH."/modules/tadtools/ck.php")){
    redirect_header("http://www.tad0616.net/modules/tad_uploader/index.php?of_cat_sn=50" , 3 , _TAD_NEED_TADTOOLS);
  }
  include_once XOOPS_ROOT_PATH."/modules/tadtools/ck.php";
  $ck=new CKEditor("tad_honor","honor_content",$honor_content);
  $ck->setHeight(400);
  $editor=$ck->render();
  $xoopsTpl->assign('honor_content_editor' , $editor);
  include_once XOOPS_ROOT_PATH."/modules/tadtools/TadUpFiles.php" ;
  $TadUpFiles=new TadUpFiles("tad_honor");
  $TadUpFiles->set_col("honor_sn",$honor_sn);
  $up_honor_sn_form=$TadUpFiles->upform(true,"up_honor_sn","");
  $xoopsTpl->assign('up_honor_sn_form',$up_honor_sn_form);

  //加入Token安全機制
  include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");
  $token = new XoopsFormHiddenToken();
  $token_form = $token->render();
  $xoopsTpl->assign("token_form" , $token_form);
  $xoopsTpl->assign('action' , $_SERVER["PHP_SELF"]);
  $xoopsTpl->assign('formValidator_code' , $formValidator_code);
  $xoopsTpl->assign('now_op' , 'tad_honor_form');
  $xoopsTpl->assign('next_op' , $op);

}



//以流水號取得某筆tad_honor資料
function get_tad_honor($honor_sn=""){
  global $xoopsDB;
  if(empty($honor_sn))return;
  $sql = "select * from `".$xoopsDB->prefix("tad_honor")."` where `honor_sn` = '{$honor_sn}'";
  $result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
  $data=$xoopsDB->fetchArray($result);
  return $data;
}

//新增資料到tad_honor中
function insert_tad_honor(){
  global $xoopsDB,$xoopsUser;
  
	//取得使用者編號
	$uid=($xoopsUser)?$xoopsUser->uid():"";

  //XOOPS表單安全檢查
  if(!$GLOBALS['xoopsSecurity']->check()){
    $error=implode("<br />" , $GLOBALS['xoopsSecurity']->getErrors());
    redirect_header($_SERVER['PHP_SELF'],3, $error);
  }

  $myts =& MyTextSanitizer::getInstance();
  $_POST['honor_title'] = $myts->addSlashes($_POST['honor_title']);
  $_POST['honor_date'] = $myts->addSlashes($_POST['honor_date']);
  $_POST['honor_content'] = $myts->addSlashes($_POST['honor_content']);
  $_POST['honor_url'] = $myts->addSlashes($_POST['honor_url']);


  $sql = "insert into `".$xoopsDB->prefix("tad_honor")."`
  (`honor_title` , `honor_date` , `honor_unit` , `honor_counter` , `honor_content` , `honor_url` , `honor_uid`)
  values('{$_POST['honor_title']}' , '{$_POST['honor_date']}' , '{$_POST['honor_unit']}' , 0 , '{$_POST['honor_content']}' , '{$_POST['honor_url']}' , '{$uid}')";
  $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());

  //取得最後新增資料的流水編號
  $honor_sn = $xoopsDB->getInsertId();

  
  include_once XOOPS_ROOT_PATH."/modules/tadtools/TadUpFiles.php" ;
  $TadUpFiles=new TadUpFiles("tad_honor");
  $TadUpFiles->set_col("honor_sn",$honor_sn);
  $TadUpFiles->upload_file('up_honor_sn','','','','',true,false);
  return $honor_sn;
  
}

//更新tad_honor某一筆資料
function update_tad_honor($honor_sn=""){
  global $xoopsDB,$xoopsUser;
  
	//取得使用者編號
	$uid=($xoopsUser)?$xoopsUser->uid():"";

  //XOOPS表單安全檢查
  if(!$GLOBALS['xoopsSecurity']->check()){
    $error=implode("<br />" , $GLOBALS['xoopsSecurity']->getErrors());
    redirect_header($_SERVER['PHP_SELF'],3, $error);
  }

  $myts =& MyTextSanitizer::getInstance();
  $_POST['honor_title'] = $myts->addSlashes($_POST['honor_title']);
  $_POST['honor_date'] = $myts->addSlashes($_POST['honor_date']);
  $_POST['honor_content'] = $myts->addSlashes($_POST['honor_content']);
  $_POST['honor_url'] = $myts->addSlashes($_POST['honor_url']);


  $sql = "update `".$xoopsDB->prefix("tad_honor")."` set 
   `honor_title` = '{$_POST['honor_title']}' , 
   `honor_date` = '{$_POST['honor_date']}' , 
   `honor_unit` = '{$_POST['honor_unit']}' , 
   `honor_content` = '{$_POST['honor_content']}' , 
   `honor_url` = '{$_POST['honor_url']}' , 
   `honor_uid` = '{$uid}'
  where `honor_sn` = '$honor_sn'";
  $xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
  
  
  include_once XOOPS_ROOT_PATH."/modules/tadtools/TadUpFiles.php" ;
  $TadUpFiles=new TadUpFiles("tad_honor");
  $TadUpFiles->set_col("honor_sn",$honor_sn);
  $TadUpFiles->upload_file('up_honor_sn','','','','',true,false);
  return $honor_sn;
}

//刪除tad_honor某筆資料資料
function delete_tad_honor($honor_sn=""){
  global $xoopsDB , $isAdmin;
  if(empty($honor_sn))return;
  $sql = "delete from `".$xoopsDB->prefix("tad_honor")."` where `honor_sn` = '{$honor_sn}'";
  $xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
  
  include_once XOOPS_ROOT_PATH."/modules/tadtools/TadUpFiles.php" ;
  $TadUpFiles=new TadUpFiles("tad_honor");
  $TadUpFiles->set_col("honor_sn",$honor_sn);
  $TadUpFiles->del_files();
}

//以流水號秀出某筆tad_honor資料內容
function show_one_tad_honor($honor_sn=""){
  global $xoopsDB , $xoopsTpl , $isAdmin;

  if(empty($honor_sn)){
    return;
  }else{
    $honor_sn=intval($honor_sn);
  }

  $myts =& MyTextSanitizer::getInstance();

  $sql = "select * from `".$xoopsDB->prefix("tad_honor")."` where `honor_sn` = '{$honor_sn}' ";
  $result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
  $all=$xoopsDB->fetchArray($result);

  //以下會產生這些變數： $honor_sn , $honor_title , $honor_date , $honor_unit , $honor_counter , $honor_content , $honor_url , $honor_uid
  foreach($all as $k=>$v){
    $$k=$v;
  }

  
  //計數器欄位值 +1
  add_tad_honor_counter($honor_sn);

  //將 uid 編號轉換成使用者姓名（或帳號）
  $uid_name=XoopsUser::getUnameFromId($honor_uid,1);
  if(empty($uid_name))$uid_name=XoopsUser::getUnameFromId($honor_uid,0);

  include_once XOOPS_ROOT_PATH."/modules/tadtools/TadUpFiles.php" ;
  $TadUpFiles=new TadUpFiles("tad_honor");
  $TadUpFiles->set_col("honor_sn",$honor_sn);
  $show_honor_sn_files=$TadUpFiles->show_files('up_honor_sn', true, 'thumb',true,false,NULL,NULL,false);
  $xoopsTpl->assign('show_honor_sn_files',$show_honor_sn_files);

  //過濾讀出的變數值
  $honor_title = $myts->htmlSpecialChars($honor_title);
  $honor_date = $myts->htmlSpecialChars($honor_date);
  $honor_content = $myts->displayTarea($honor_content, 1, 1, 0, 1, 0);
  $honor_url = $myts->htmlSpecialChars($honor_url);

  $xoopsTpl->assign('honor_sn' , $honor_sn);
  $xoopsTpl->assign('honor_title',$honor_title);
  $xoopsTpl->assign('honor_title_link',"<a href='{$_SERVER['PHP_SELF']}?honor_sn={$honor_sn}'>{$honor_title}</a>");
  $xoopsTpl->assign('honor_date' , $honor_date);
  $xoopsTpl->assign('honor_unit' , $honor_unit);
  $xoopsTpl->assign('honor_counter' , $honor_counter);
  $xoopsTpl->assign('honor_content' , $honor_content);
  $xoopsTpl->assign('honor_url' , $honor_url);
  $xoopsTpl->assign('honor_uid' , $uid_name);

  if(!file_exists(XOOPS_ROOT_PATH."/modules/tadtools/sweet_alert.php")){
    redirect_header("index.php",3, _MA_NEED_TADTOOLS);
  }
  include_once XOOPS_ROOT_PATH."/modules/tadtools/sweet_alert.php";
  $sweet_alert=new sweet_alert();
  $delete_tad_honor_func=$sweet_alert->render('delete_tad_honor_func',"{$_SERVER['PHP_SELF']}?op=delete_tad_honor&honor_sn=","honor_sn");
  $xoopsTpl->assign('delete_tad_honor_func',$delete_tad_honor_func);

  $xoopsTpl->assign('action' , $_SERVER['PHP_SELF']);
  $xoopsTpl->assign('now_op' , 'show_one_tad_honor');
}


//新增tad_honor計數器
function add_tad_honor_counter($honor_sn=''){
  global $xoopsDB;
  if(empty($honor_sn))return;
  $sql = "update `".$xoopsDB->prefix("tad_honor")."` set `honor_counter` = `honor_counter` + 1 where `honor_sn` = '{$honor_sn}'";
  $xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
}

//列出所有tad_honor資料
function list_tad_honor(){
  global $xoopsDB , $xoopsTpl , $isAdmin;

  $myts =& MyTextSanitizer::getInstance();
  
  include_once XOOPS_ROOT_PATH."/modules/tadtools/TadUpFiles.php" ;
  $TadUpFiles=new TadUpFiles("tad_honor");
  
  $sql = "select * from `".$xoopsDB->prefix("tad_honor")."` ";

  //getPageBar($原sql語法, 每頁顯示幾筆資料, 最多顯示幾個頁數選項);
  $PageBar=getPageBar($sql,20,10,NULL,NULL,$bootstrap);
  $bar=$PageBar['bar'];
  $sql=$PageBar['sql'];
  $total=$PageBar['total'];

  $result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());

  $all_content="";
  $i=0;
  while($all=$xoopsDB->fetchArray($result)){
    //以下會產生這些變數： $honor_sn , $honor_title , $honor_date , $honor_unit , $honor_counter , $honor_content , $honor_url , $honor_uid
    foreach($all as $k=>$v){
      $$k=$v;
    }
    

    //過濾讀出的變數值
    $honor_title = $myts->htmlSpecialChars($honor_title);
    $honor_date = $myts->htmlSpecialChars($honor_date);
    $honor_content = $myts->displayTarea($honor_content, 1, 1, 0, 1, 0);
    $honor_url = $myts->htmlSpecialChars($honor_url);

    $all_content[$i]['honor_sn']=$honor_sn;
    $all_content[$i]['honor_title_link']="<a href='{$_SERVER['PHP_SELF']}?honor_sn={$honor_sn}'>{$honor_title}</a>";
    $all_content[$i]['honor_title']=$honor_title;
    $all_content[$i]['honor_date']=$honor_date;
    $all_content[$i]['honor_unit']=$honor_unit;
    $all_content[$i]['honor_counter']=$honor_counter;
    $all_content[$i]['honor_content']=$honor_content;
    $all_content[$i]['honor_url']=$honor_url;
    $all_content[$i]['honor_uid']=$uid_name;
    $TadUpFiles->set_col("honor_sn",$honor_sn);
    $show_files=$TadUpFiles->show_files('up_honor_sn', true, 'small', true, false, NULL, NULL, false);
    $all_content[$i]['list_file']=$show_files;
    $i++;
  }

  //刪除確認的JS

  $xoopsTpl->assign('bar' , $bar);
  $xoopsTpl->assign('action' , $_SERVER['PHP_SELF']);
  $xoopsTpl->assign('isAdmin' , $isAdmin);
  $xoopsTpl->assign('all_content' , $all_content);
  $xoopsTpl->assign('now_op' , 'list_tad_honor');


  if(!file_exists(XOOPS_ROOT_PATH."/modules/tadtools/sweet_alert.php")){
    redirect_header("index.php",3, _MA_NEED_TADTOOLS);
  }
  include_once XOOPS_ROOT_PATH."/modules/tadtools/sweet_alert.php";
  $sweet_alert=new sweet_alert();
  $delete_tad_honor_func=$sweet_alert->render('delete_tad_honor_func',"{$_SERVER['PHP_SELF']}?op=delete_tad_honor&honor_sn=","honor_sn");
  $xoopsTpl->assign('delete_tad_honor_func',$delete_tad_honor_func);
}



/*-----------執行動作判斷區----------*/
$op=empty($_REQUEST['op'])?"":$_REQUEST['op'];
$honor_sn=empty($_REQUEST['honor_sn'])?"":intval($_REQUEST['honor_sn']);
$files_sn=empty($_REQUEST['files_sn'])?"":intval($_REQUEST['files_sn']);


switch($op){
  /*---判斷動作請貼在下方---*/

  
  //替換資料
  //case "replace_tad_honor":
  //replace_tad_honor();
  //header("location: {$_SERVER['PHP_SELF']}?honor_sn=$honor_sn");
  //break;

  //新增資料
  case "insert_tad_honor":
  $honor_sn=insert_tad_honor();
  header("location: {$_SERVER['PHP_SELF']}?honor_sn=$honor_sn");
  break;

  //更新資料
  case "update_tad_honor":
  update_tad_honor($honor_sn);
  header("location: {$_SERVER['PHP_SELF']}?honor_sn=$honor_sn");
  break;

  
  case "tad_honor_form":
  tad_honor_form($honor_sn);
  break;

  
  case "delete_tad_honor":
  delete_tad_honor($honor_sn);
  header("location: {$_SERVER['PHP_SELF']}");
  break;
  
  //下載檔案
  case "tufdl":
  $TadUpFiles->add_file_counter($files_sn, false);
  exit;
  break;

  
  default:
  if(empty($honor_sn)){
    list_tad_honor();
    //$main.=tad_honor_form($honor_sn);
  }else{
    show_one_tad_honor($honor_sn);
  }
  break;


  /*---判斷動作請貼在上方---*/
}

/*-----------秀出結果區--------------*/
$xoopsTpl->assign("isAdmin" , true);
include_once 'footer.php';
?>