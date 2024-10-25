<{if $block.content|default:false}>
  <script type="text/javascript">
    $(document).ready(function (){
      $("#tad_honor_marquee2").marquee2({yScroll: "bottom"});
    });
  </script>

  <ul id="tad_honor_marquee2" style="width: 100%; height: <{$block.height|default:1.5}>rem; background-color: <{$block.options2|default:'#ffffff'}>;border: <{$block.options3|default:'1px solid gray'}>; ">
    <{foreach from=$block.content item=data}>
      <li style="font-size: <{$block.options1|default:1}>rem; padding: 3px 5px;"><img src="<{$xoops_url}>/modules/tad_honor/images/<{cycle values='trophy,cup,medal,certificate,competition,medal2'}>.svg" alt="<{$data.honor_title}>" style="width: <{$block.options1|default:1}>rem; height: <{$block.options1|default:1}>rem; margin: 0px 4px 0px 0px;"> <a href="<{$xoops_url}>/modules/tad_honor/index.php?honor_sn=<{$data.honor_sn}>"><{$data.honor_title}></a></li>
    <{/foreach}>
  </ul>
<{/if}>