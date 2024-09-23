<{if $block.content|default:false}>
  <style type="text/css" media="screen">
    ul#tad_honor_marquee2 {
      width: 100%;
      height: <{$block.height}>px;
      background-color: <{$block.options2}>;
      border: <{$block.options3}>;
    }

    ul#tad_honor_marquee2 li {
      font-size: <{$block.options1}>em;
      padding: 3px 5px;
    }
  </style>

  <script type="text/javascript">
    $(document).ready(function (){
      $("#tad_honor_marquee2").marquee2({yScroll: "bottom"});
    });
  </script>

  <ul id="tad_honor_marquee2">
    <{foreach from=$block.content item=data}>
      <li><img src="<{$xoops_url}>/modules/tad_honor/images/<{cycle values='trophy,cup,medal,certificate,competition,medal2'}>.svg" alt="<{$data.honor_title}>" style="width: <{$block.options1}>em; height: <{$block.options1}>em; margin: 0px 4px 0px 0px;"> <a href="<{$xoops_url}>/modules/tad_honor/index.php?honor_sn=<{$data.honor_sn}>"><{$data.honor_title}></a></li>
    <{/foreach}>
  </ul>
<{/if}>