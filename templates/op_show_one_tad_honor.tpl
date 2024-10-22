<div class="confetti_part pt-5">
    <{if $show_confetti==1}>
        <script src="class/confetti.js" type="text/javascript" charset="utf-8"></script>
        <canvas id="canvas"></canvas>
    <{/if}>

    <div id="confetti_content">
        <h2 class="mt-2"><{$honor_title|default:''}></h2>
        <!--詳細內容-->
        <div style="border-top: 1px dashed #927156; border-bottom: 1px dashed #927156; margin:10px auto 30px auto; padding:15px; ">
            <{$honor_content|default:''}>
        </div>

        <!--相關連結-->
        <{if $honor_url|default:false}>
            <div class="alert alert-warning">
                <{$smarty.const._MD_TADHONOR_HONOR_URL}><{$smarty.const._TAD_FOR}><a href="<{$honor_url|default:''}>" target="_blank"><{$honor_url|default:''}></a>
            </div>
        <{/if}>


        <{if $show_honor_sn_files|default:false}>
            <{$show_honor_sn_files|default:''}>
        <{/if}>

        <!--發佈日期-->
        <div class="alert alert-info">
            <div class="pull-right float-right pull-end">
                <{if $smarty.session.tad_honor_adm or ($post_power and $uid==$honor_uid)}>
                    <a href="javascript:delete_tad_honor_func(<{$honor_sn|default:''}>);" class="btn btn-sm btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i> <{$smarty.const._TAD_DEL}></a>
                    <a href="<{$xoops_url}>/modules/tad_honor/index.php?op=tad_honor_form&honor_sn=<{$honor_sn|default:''}>" class="btn btn-sm btn-warning"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> <{$smarty.const._TAD_EDIT}></a>
                    <a href="<{$xoops_url}>/modules/tad_honor/index.php?op=tad_honor_form" class="btn btn-sm btn-primary"><i class="fa fa-plus-square" aria-hidden="true"></i> <{$smarty.const._TAD_ADD}></a>
                <{/if}>
            </div>
            <{$lang_views_info|default:''}>
        </div>
    </div>
</div>