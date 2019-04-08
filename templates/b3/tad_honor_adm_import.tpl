<!--顯示表單-->
<link href="<{$xoops_url}>/modules/tadtools/css/font-awesome/css/font-awesome.css" rel="stylesheet">
<form action="import.php" method="post">
  <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th>
          honor_person
        </th>
        <th>
          honor_title
        </th>
        <th>
          honor_content
        </th>
        <th>
          write_department
        </th>
        <th>
          write_date
        </th>
        <th>
          click
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
            <!--得獎人-->
            <{$data.honor_person}>
          </td>

          <td>
            <!--榮譽標題-->
            <{$data.honor_title}>
          </td>

          <td>
            <!--榮譽內容-->
            <{$data.honor_content}>
          </td>

          <td>
            <!--發布單位-->
            <{$data.write_department}>
          </td>

          <td>
            <!--公告日期-->
            <{$data.write_date}>
          </td>

          <td>
            <!--點閱次數-->
            <{$data.click}>
          </td>
          <{if $isAdmin}>
            <td>
              <input type="checkbox" name="honor_sn[]" value="<{$data.honor_sn}>" checked>
            </td>
          <{/if}>
        </tr>
      <{/foreach}>
    </tbody>
  </table>
  <div class="text-center">
    <input type="hidden" name="op" value="import_now">
    <button type="submit" class="btn btn-lg btn-primary"><{$smarty.const._MA_TADHONOR_IMPORT}></button>
  </div>
</form>

