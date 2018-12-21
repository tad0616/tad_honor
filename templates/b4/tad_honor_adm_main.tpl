<!--顯示表單-->
<link href="<{$xoops_url}>/modules/tadtools/css/font-awesome/css/font-awesome.css" rel="stylesheet">
<script type="text/javascript" src="<{$xoops_url}>/modules/tadtools/My97DatePicker/WdatePicker.js"></script>

<{if $now_op=="tad_honor_form"}>
  <{includeq file="$xoops_rootpath/modules/tad_honor/templates/tad_honor_form.tpl"}>
<{/if}>


<!--顯示某一筆資料-->
<{if $now_op=="show_one_tad_honor"}>
  <{if $isAdmin}>
    <{$delete_tad_honor_func}>
  <{/if}>
  <h2 class="text-center"><{$honor_title}></h2>



  <!--發佈日期-->
  <div class="row">
    <label class="col-sm-3 text-right">
      <{$smarty.const._MA_TADHONOR_HONOR_DATE}>
    </label>
    <div class="col-sm-9">
      <{$honor_date}>
    </div>
  </div>

  <!--發布單位-->
  <div class="row">
    <label class="col-sm-3 text-right">
      <{$smarty.const._MA_TADHONOR_HONOR_UNIT}>
    </label>
    <div class="col-sm-9">
      <{$honor_unit}>
    </div>
  </div>

  <!--點閱次數-->
  <div class="row">
    <label class="col-sm-3 text-right">
      <{$smarty.const._MA_TADHONOR_HONOR_COUNTER}>
    </label>
    <div class="col-sm-9">
      <{$honor_counter}>
    </div>
  </div>

  <!--詳細內容-->
  <div class="row">
    <label class="col-sm-3 text-right">
      <{$smarty.const._MA_TADHONOR_HONOR_CONTENT}>
    </label>
    <div class="col-sm-9">

      <div class="card card-body bg-light m-1">
        <{$honor_content}>
      </div>
    </div>
  </div>

  <!--相關連結-->
  <div class="row">
    <label class="col-sm-3 text-right">
      <{$smarty.const._MA_TADHONOR_HONOR_URL}>
    </label>
    <div class="col-sm-9">
      <{$honor_url}>
    </div>
  </div>

  <!--發布者-->
  <div class="row">
    <label class="col-sm-3 text-right">
      <{$smarty.const._MA_TADHONOR_HONOR_UID}>
    </label>
    <div class="col-sm-9">
      <{$honor_uid}>
    </div>
  </div>


  <!---->
  <div class="row">
    <label class="col-sm-3 text-right">
      <{$smarty.const._MA_TADHONOR_SHOW_HONOR_SN_FILES}>
    </label>
    <div class="col-sm-9">
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
                <a href="javascript:delete_tad_honor_func(<{$data.honor_sn}>);" class="btn btn-sm btn-danger"><{$smarty.const._TAD_DEL}></a>
                <a href="<{$xoops_url}>/modules/tad_honor/admin/main.php?op=tad_honor_form&honor_sn=<{$data.honor_sn}>" class="btn btn-sm btn-warning"><{$smarty.const._TAD_EDIT}></a>
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
