<{if $block.content|default:false}>
    <ul class="vertical_menu">
        <{foreach from=$block.content item=data}>
            <li>
                <img src="<{$xoops_url}>/modules/tad_honor/images/<{cycle values='trophy,cup,medal,certificate,competition,medal2'}>.svg" alt="<{$data.honor_title}>" style="width:32px; height:32px; float: left; margin: 2px 4px 2px 0px;">
                <a href="<{$xoops_url}>/modules/tad_honor/index.php?honor_sn=<{$data.honor_sn}>">
                <{$data.honor_date}>
                <{$data.honor_title}></a>
            </li>
        <{/foreach}>
    </ul>
    <div class="text-right text-end">
        <a href="<{$xoops_url}>/modules/tad_honor/index.php"><span class="badge badge-info bg-info">more...</span></a>
    </div>
<{/if}>