<!--顯示表單-->
<link href="<{$xoops_url}>/modules/tadtools/css/font-awesome/css/font-awesome.css" rel="stylesheet">
<{if $all_cate}>
<form action="import_tadnews.php" method="post">
    <div class="input-group">
        <div class="input-group-prepend input-group-addon">
            <span class="input-group-text"><{$smarty.const._MA_TADHONOR_SELECT_HONOR_CATE}></span>
        </div>
        <select name="ncsn" id="ncsn" class="form-control">
            <{foreach from=$all_cate item=data}>
                <option value="<{$data.ncsn}>">
                    <{$data.nc_title}>
                </option>
            <{/foreach}>
        </select>
        <div class="input-group-append input-group-btn">
            <input type="hidden" name="op" value="list_tadnews">
            <button type="submit" class="btn btn-primary"><{$smarty.const._MA_TADHONOR_IMPORT}></button>
        </div>
    </div>
</form>
<{else}>
    <form action="import_tadnews.php" method="post">
    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th>
                news_title
            </th>
            <th>
                news_content
            </th>
            <th>
                uid
            </th>
            <th>
                start_day
            </th>
            <th>
                counter
            </th>
            <{if $smarty.session.tad_honor_adm}>
            <th><{$smarty.const._TAD_FUNCTION}></th>
            <{/if}>
        </tr>
        </thead>

        <tbody>
        <{foreach from=$all_content item=data}>
            <tr>
            <td>
                <!--榮譽標題-->
                <{$data.news_title}>
            </td>

            <td>
                <!--榮譽內容-->
                <{$data.news_content}>
            </td>

            <td>
                <!--發布單位-->
                <{$data.uid}>
            </td>

            <td>
                <!--公告日期-->
                <{$data.start_day}>
            </td>

            <td>
                <!--點閱次數-->
                <{$data.counter}>
            </td>
            <{if $smarty.session.tad_honor_adm}>
                <td>
                <input type="checkbox" name="nsn[]" value="<{$data.nsn}>" checked>
                </td>
            <{/if}>
            </tr>
        <{/foreach}>
        </tbody>
    </table>
    <div class="text-center">
        <input type="hidden" name="op" value="import_now">
        <input type="hidden" name="ncsn" value="<{$ncsn}>">
        <button type="submit" class="btn btn-lg btn-primary"><{$smarty.const._MA_TADHONOR_IMPORT}></button>
    </div>
    </form>
<{/if}>