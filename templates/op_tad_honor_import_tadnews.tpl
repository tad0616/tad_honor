<{if $all_cate|default:false}>
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
            <button type="submit" class="btn btn-primary"><i class="fa fa-cloud-download" aria-hidden="true"></i> <{$smarty.const._MA_TADHONOR_IMPORT}></button>
        </div>
    </div>
</form>
<{/if}>