<{if $now_op=="show_one_tad_honor" or $now_op=="list_tad_honor"}>
  <div style="background: #ffffff url('images/confetti.png') no-repeat; background-size: contain; ">
<{/if}>

<{$toolbar}>

<{if $now_op=="tad_honor_form"}>
  <{include file="$xoops_rootpath/modules/tad_honor/templates/tad_honor_form.tpl"}>
<{/if}>

<!--顯示某一筆資料-->
<{if $now_op=="show_one_tad_honor"}>
  <{if $show_confetti==1}>
    <style type="text/css" media="screen">
      canvas#canvas {
        display: block;
        z-index: 1;
        pointer-events: none;
        min-height: 400px;
        width: 100%;
        position: absolute;
      }

      #confetti_content {
        min-height: 400px;
        position: relative;
      }
    </style>
    <script src="class/confetti.js" type="text/javascript" charset="utf-8"></script>

    <canvas id="canvas"></canvas>
  <{/if}>

    <div id="confetti_content">
      <h2><{$honor_title}></h2>

      <!--詳細內容-->
      <div style="border-top: 1px dashed #927156; border-bottom: 1px dashed #927156; margin:10px auto 30px auto; padding:15px; ">
        <{$honor_content}>
      </div>

      <!--相關連結-->
      <{if $honor_url}>
        <div class="alert alert-warning">
          <{$smarty.const._MD_TADHONOR_HONOR_URL}><{$smarty.const._TAD_FOR}><a href="<{$honor_url}>" target="_blank"><{$honor_url}></a>
        </div>
      <{/if}>


      <{if $show_honor_sn_files}>
        <{$show_honor_sn_files}>
      <{/if}>

      <!--發佈日期-->
      <div class="alert alert-info">
        <div class="pull-right float-right pull-end">
          <{if $smarty.session.tad_honor_adm or ($post_power and $uid==$honor_uid)}>
            <a href="javascript:delete_tad_honor_func(<{$honor_sn}>);" class="btn btn-sm btn-danger"><{$smarty.const._TAD_DEL}></a>
            <a href="<{$xoops_url}>/modules/tad_honor/index.php?op=tad_honor_form&honor_sn=<{$honor_sn}>" class="btn btn-sm btn-warning"><{$smarty.const._TAD_EDIT}></a>
            <a href="<{$xoops_url}>/modules/tad_honor/index.php?op=tad_honor_form" class="btn btn-sm btn-primary"><{$smarty.const._TAD_ADD}></a>
          <{/if}>
        </div>
<{*        <{$honor_unit}> <{$uid_name}> 於 <{$honor_date}> 發布，共有 <{$honor_counter}> 人次閱讀*}>
          <{$lang_viewsinfo}>
      </div>
    </div>
<{/if}>

<!--列出所有資料-->
<{if $now_op=="list_tad_honor"}>
  <{if $all_content}>
    <{if $show_confetti==1}>
      <style type="text/css" media="screen">
        canvas#canvas {
          display: block;
          z-index: 1;
          pointer-events: none;
          min-height: 400px;
          width: 100%;
          position: absolute;
        }

        #confetti_content {
          min-height: 400px;
          position: relative;
        }
      </style>
      <script src="class/confetti.js" type="text/javascript" charset="utf-8"></script>

      <canvas id="canvas"></canvas>
      <{/if}>
      <div id="confetti_content">
        <h1><{$smarty.const._MD_TADHONOR_SMNAME1}></h1>
        <table class="table table-striped table-hover">
          <thead>
            <tr class="info">
              <th style="text-align: center;">
                <!--發佈日期-->
                <{$smarty.const._MD_TADHONOR_HONOR_DATE}>
              </th>
              <th>
                <!--標題-->
                <{$smarty.const._MD_TADHONOR_HONOR_TITLE}>
              </th>
              <th nowrap="nowrap" style="text-align: center;">
                <!--發布單位-->
                <{$smarty.const._MD_TADHONOR_HONOR_UNIT}>
              </th>
              <{if $smarty.session.tad_honor_adm or $post_power}>
                <th></th>
              <{/if}>
            </tr>
          </thead>

          <tbody>
            <{foreach from=$all_content item=data}>
              <tr>
                <td nowrap="nowrap" style="text-align: center;">
                  <!--發佈日期-->
                  <{$data.honor_date}>
                </td>
                <td>
                  <!--標題-->
                  <{$data.honor_title_link}>
                  <{$data.list_file}>
                </td>
                <td style="text-align: center;">
                  <!--發布單位-->
                  <{$data.honor_unit}>
                </td>

                <{if $smarty.session.tad_honor_adm or ($post_power and $uid==$data.honor_uid)}>
                  <td nowrap>
                      <a href="javascript:delete_tad_honor_func(<{$data.honor_sn}>);" class="btn btn-sm btn-danger"><{$smarty.const._TAD_DEL}></a>
                      <a href="<{$xoops_url}>/modules/tad_honor/index.php?op=tad_honor_form&honor_sn=<{$data.honor_sn}>" class="btn btn-sm btn-warning"><{$smarty.const._TAD_EDIT}></a>
                  </td>
                <{/if}>
              </tr>
            <{/foreach}>
          </tbody>
        </table>
      </div>

    <{if $smarty.session.tad_honor_adm or $post_power}>
      <div class="text-right text-end">
        <a href="<{$xoops_url}>/modules/tad_honor/index.php?op=tad_honor_form" class="btn btn-info"><{$smarty.const._TAD_ADD}></a>
      </div>
    <{/if}>

    <{$bar}>
  <{else}>
    <{if $smarty.session.tad_honor_adm or $post_power}>
      <div class="jumbotron bg-light p-5 rounded-lg m-3 text-center">
        <a href="<{$xoops_url}>/modules/tad_honor/index.php?op=tad_honor_form" class="btn btn-info"><{$smarty.const._TAD_ADD}></a>
      </div>
    <{/if}>
  <{/if}>
<{/if}>
<{if $now_op=="show_one_tad_honor" or $now_op=="list_tad_honor"}>
  </div>
<{/if}>
