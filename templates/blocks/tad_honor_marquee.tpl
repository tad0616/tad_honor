<script type="text/javascript" src="<{$xoops_url}>/modules/tad_honor/class/jquery.marquee/lib/jquery.marquee.js"></script>

<link type="text/css" href="<{$xoops_url}>/modules/tad_honor/class/jquery.marquee/css/jquery.marquee.css" rel="stylesheet" media="all" />

<style type="text/css" media="screen">
  ul.marquee {
    width: 100%;
    height: <{$block.height}>px;

    background-color: <{$block.options2}>;
    border: <{$block.options3}>;
  }

  ul.marquee li {
    font-size: <{$block.options1}>px;
    padding: 3px 5px;
  }
</style>

<script type="text/javascript">
  $(document).ready(function (){
    $("#marquee2").marquee({yScroll: "bottom"});
  });
</script>

<ul id="marquee2" class="marquee">
  <{foreach from=$block.content item=data}>
    <li><img src="<{$xoops_url}>/modules/tad_honor/images/<{cycle values='trophy,cup,medal,certificate,competition,medal2'}>.svg" alt="<{$data.honor_title}>" style="width: <{$block.options1}>px; height: <{$block.options1}>px; margin: 0px 4px 0px 0px;"> <a href="<{$xoops_url}>/modules/tad_honor/index.php?honor_sn=<{$data.honor_sn}>"><{$data.honor_title}></a></li>
  <{/foreach}>
</ul>
