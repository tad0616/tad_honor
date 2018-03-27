<ul class="list-group">
  <{foreach from=$block.content item=data}>
    <li class="list-group-item">
      <img src="<{$xoops_url}>/modules/tad_honor/images/<{cycle values='trophy,cup,medal,certificate,competition,medal2'}>.svg" alt="<{$data.honor_title}>" style="width:32px; height:32px; float: left; margin: 2px 4px 2px 0px;">
      <{$data.honor_date}>
      <a href="<{$xoops_url}>/modules/tad_honor/index.php?honor_sn=<{$data.honor_sn}>"><{$data.honor_title}></a>
    </li>
  <{/foreach}>
</ul>
<div class="text-right">[ <a href="<{$xoops_url}>/modules/tad_honor/index.php">more...</a> ]</div>
