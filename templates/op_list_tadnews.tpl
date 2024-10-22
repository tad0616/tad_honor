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
            <th><{$smarty.const._TAD_FUNCTION}></th>
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
                <td>
                <input type="checkbox" name="nsn[]" value="<{$data.nsn}>" checked>
                </td>
            </tr>
        <{/foreach}>
        </tbody>
    </table>
    <div class="text-center">
        <input type="hidden" name="op" value="import_now">
        <input type="hidden" name="ncsn" value="<{$ncsn|default:''}>">
        <button type="submit" class="btn btn-lg btn-primary"><i class="fa fa-cloud-download" aria-hidden="true"></i> <{$smarty.const._MA_TADHONOR_IMPORT}></button>
    </div>
</form>