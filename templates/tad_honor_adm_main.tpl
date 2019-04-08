<!--顯示表單-->
<link href="<{$xoops_url}>/modules/tadtools/css/font-awesome/css/font-awesome.css" rel="stylesheet">
<script type="text/javascript" src="<{$xoops_url}>/modules/tadtools/My97DatePicker/WdatePicker.js"></script>

<{if $now_op=="tad_honor_form"}>
  <div class="container-fluid">
    <!--套用formValidator驗證機制-->
    <{$formValidator_code}>
    <form action="<{$action}>" method="post" id="myForm" enctype="multipart/form-data" class="form-horizontal" role="form">


      <!--標題-->
      <div class="row">
        <div class="form-group">
          <label class="col-md-2 control-label">
            <{$smarty.const._MA_TADHONOR_HONOR_TITLE}>
          </label>
          <div class="col-md-10">
            <input type="text" name="honor_title" id="honor_title" class="form-control " value="<{$honor_title}>" placeholder="<{$smarty.const._MA_TADHONOR_HONOR_TITLE}>">
          </div>
        </div>
      </div>

      <!--發佈日期-->
      <div class="row">
        <div class="form-group">
          <label class="col-md-2 control-label">
            <{$smarty.const._MA_TADHONOR_HONOR_DATE}>
          </label>
          <div class="col-md-4">
            <input type="text" name="honor_date" id="honor_date" class="form-control " value="<{$honor_date}>"  onClick="WdatePicker({dateFmt:'yyyy-MM-dd' , startDate:'%y-%M-%d'})" placeholder="<{$smarty.const._MA_TADHONOR_HONOR_DATE}>">
          </div>
        </div>
      </div>

      <!--發布單位-->
      <div class="row">
        <div class="form-group">
          <label class="col-md-2 control-label">
            <{$smarty.const._MA_TADHONOR_HONOR_UNIT}>
          </label>
          <div class="col-md-4">
            <select name="honor_unit" class="form-control " size=1>
              <{foreach from=$unit_array item=unit}>
                <option value="<{$unit.name}>" <{if $honor_unit == $unit.name}>selected="selected"<{/if}>><{$unit.name}></option>
              <{/foreach}>
            </select>
          </div>
        </div>
      </div>

      <!--詳細內容-->
      <div class="row">
        <div class="form-group">
          <label class="col-md-2 control-label">
            <{$smarty.const._MA_TADHONOR_HONOR_CONTENT}>
          </label>
          <div class="col-md-10">
            <{$honor_content_editor}>
          </div>
        </div>
      </div>

      <!--相關連結-->
      <div class="row">
        <div class="form-group">
          <label class="col-md-2 control-label">
            <{$smarty.const._MA_TADHONOR_HONOR_URL}>
          </label>
          <div class="col-md-10">
            <input type="text" name="honor_url" id="honor_url" class="form-control " value="<{$honor_url}>" placeholder="<{$smarty.const._MA_TADHONOR_HONOR_URL}>">
          </div>
        </div>
      </div>

      <!--上傳-->
      <div class="row">
        <div class="form-group">
          <label class="col-md-2 control-label">
            <{$smarty.const._MA_TADHONOR_UP_HONOR_SN}>
          </label>
          <div class="col-md-10">
            <{$up_honor_sn_form}>
          </div>
        </div>
      </div>

      <div class="text-center">

      <!--編號-->
      <input type='hidden' name="honor_sn" value="<{$honor_sn}>">

        <{$token_form}>

        <input type="hidden" name="op" value="<{$next_op}>">
        <button type="submit" class="btn btn-primary"><{$smarty.const._TAD_SAVE}></button>
      </div>
    </form>
  </div>
<{/if}>


<!--顯示某一筆資料-->
<{if $now_op=="show_one_tad_honor"}>
  <{if $isAdmin}>
    <{$delete_tad_honor_func}>
  <{/if}>
  <h2 class="text-center"><{$honor_title}></h2>



  <!--發佈日期-->
  <div class="row">
    <label class="col-md-3 text-right">
      <{$smarty.const._MA_TADHONOR_HONOR_DATE}>
    </label>
    <div class="col-md-9">
      <{$honor_date}>
    </div>
  </div>

  <!--發布單位-->
  <div class="row">
    <label class="col-md-3 text-right">
      <{$smarty.const._MA_TADHONOR_HONOR_UNIT}>
    </label>
    <div class="col-md-9">
      <{$honor_unit}>
    </div>
  </div>

  <!--點閱次數-->
  <div class="row">
    <label class="col-md-3 text-right">
      <{$smarty.const._MA_TADHONOR_HONOR_COUNTER}>
    </label>
    <div class="col-md-9">
      <{$honor_counter}>
    </div>
  </div>

  <!--詳細內容-->
  <div class="row">
    <label class="col-md-3 text-right">
      <{$smarty.const._MA_TADHONOR_HONOR_CONTENT}>
    </label>
    <div class="col-md-9">

      <div class="well">
        <{$honor_content}>
      </div>
    </div>
  </div>

  <!--相關連結-->
  <div class="row">
    <label class="col-md-3 text-right">
      <{$smarty.const._MA_TADHONOR_HONOR_URL}>
    </label>
    <div class="col-md-9">
      <{$honor_url}>
    </div>
  </div>

  <!--發布者-->
  <div class="row">
    <label class="col-md-3 text-right">
      <{$smarty.const._MA_TADHONOR_HONOR_UID}>
    </label>
    <div class="col-md-9">
      <{$honor_uid}>
    </div>
  </div>


  <!---->
  <div class="row">
    <label class="col-md-3 text-right">
      <{$smarty.const._MA_TADHONOR_SHOW_HONOR_SN_FILES}>
    </label>
    <div class="col-md-9">
      <{$show_honor_sn_files}>
    </div>
  </div>

  <div class="text-right">
    <{if $isAdmin}>
      <a href="javascript:delete_tad_honor_func(<{$honor_sn}>);" class="btn btn-danger"><{$smarty.const._TAD_DEL}></a>
      <a href="<{$xoops_url}>/modules/tad_honor/admin/main.php?op=tad_honor_form&honor_sn=<{$honor_sn}>" class="btn btn-warning"><{$smarty.const._TAD_EDIT}></a>
      <a href="<{$xoops_url}>/modules/tad_honor/admin/main.php?op=tad_honor_form" class="btn btn-primary"><{$smarty.const._TAD_ADD}></a>
    <{/if}>
    <a href="<{$action}>" class="btn btn-success"><{$smarty.const._TAD_HOME}></a>
  </div>
<{/if}>

<!--列出所有資料-->

<{if $now_op=="list_tad_honor"}>
  <{if $all_content}>
    <{if $isAdmin}>
      <{$delete_tad_honor_func}>
    <{/if}>

    <table class="table table-striped table-hover">
      <thead>
        <tr>

          <th>
            <!--標題-->
            <{$smarty.const._MA_TADHONOR_HONOR_TITLE}>
          </th>
          <th>
            <!--發佈日期-->
            <{$smarty.const._MA_TADHONOR_HONOR_DATE}>
          </th>
          <th>
            <!--發布單位-->
            <{$smarty.const._MA_TADHONOR_HONOR_UNIT}>
          </th>
          <th>
            <!--點閱次數-->
            <{$smarty.const._MA_TADHONOR_HONOR_COUNTER}>
          </th>
          <{if $isAdmin}>
            <th><{$smarty.const._TAD_FUNCTION}></th>
          <{/if}>
        </tr>
      </thead>

      <tbody>
        <{foreach from=$all_content item=data}>
          <tr>

            <td>
              <!--標題-->
              <{$data.honor_title_link}>
              <{$data.list_file}>
            </td>

            <td>
              <!--發佈日期-->
              <{$data.honor_date}>
            </td>

            <td>
              <!--發布單位-->
              <{$data.honor_unit}>
            </td>

            <td>
              <!--點閱次數-->
              <{$data.honor_counter}>
            </td>

            <{if $isAdmin}>
              <td>
                <a href="javascript:delete_tad_honor_func(<{$data.honor_sn}>);" class="btn btn-xs btn-danger"><{$smarty.const._TAD_DEL}></a>
                <a href="<{$xoops_url}>/modules/tad_honor/admin/main.php?op=tad_honor_form&honor_sn=<{$data.honor_sn}>" class="btn btn-xs btn-warning"><{$smarty.const._TAD_EDIT}></a>
              </td>
            <{/if}>
          </tr>
        <{/foreach}>
      </tbody>
    </table>


    <{if $isAdmin}>
      <div class="text-right">
        <a href="<{$xoops_url}>/modules/tad_honor/admin/main.php?op=tad_honor_form" class="btn btn-info"><{$smarty.const._TAD_ADD}></a>
      </div>
    <{/if}>

    <{$bar}>
  <{else}>
    <{if $isAdmin}>
      <div class="jumbotron text-center">
        <a href="<{$xoops_url}>/modules/tad_honor/admin/main.php?op=tad_honor_form" class="btn btn-info"><{$smarty.const._TAD_ADD}></a>
      </div>
    <{/if}>
  <{/if}>
<{/if}>
