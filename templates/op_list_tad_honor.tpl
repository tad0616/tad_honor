<div class="confetti_part pt-5">
        <{if $show_confetti==1}>
            <script src="class/confetti.js" type="text/javascript" charset="utf-8"></script>
            <canvas id="canvas"></canvas>
        <{/if}>
        <h1 class="text-center"><{$smarty.const._MD_TADHONOR_SMNAME1}></h1>
        <div id="confetti_content">
            <table data-toggle="table" data-pagination="true" data-search="true" data-mobile-responsive="true" data-url="<{$xoops_upload_url}>/tad_honor_data.json" class="table table-striped table-hover">
                <thead>
                    <tr class="info">
                        <th data-field="honor_date" data-sortable="true" class="text-center">
                            <{$smarty.const._MD_TADHONOR_HONOR_DATE}>
                        </th>
                        <th data-field="honor_title_link">
                            <{$smarty.const._MD_TADHONOR_HONOR_TITLE}>
                        </th>
                        <th data-field="honor_unit" data-sortable="true" class="text-center text-nowrap">
                            <{$smarty.const._MD_TADHONOR_HONOR_UNIT}>
                        </th>
                        <{if $tad_honor_adm or $post_power}>
                            <th data-field="honor_function" class="text-center text-nowrap"><{$smarty.const._TAD_FUNCTION}></th>
                        <{/if}>
                    </tr>
                </thead>

            </table>
        </div>

        <{if $tad_honor_adm or $post_power}>
            <div class="text-right text-end">
                <a href="<{$xoops_url}>/modules/tad_honor/index.php?op=tad_honor_form" class="btn btn-info"><i class="fa fa-plus-square" aria-hidden="true"></i> <{$smarty.const._TAD_ADD}></a>
            </div>
        <{/if}>


</div>