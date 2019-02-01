<?php
include_once 'corefunction.php';
include_once("config.php");
$entryid=$Entryid;  
$result_live = $client->baseEntry->get($entryid, $version);
$primaryBroadcastingUrl=$result_live->primaryBroadcastingUrl;
$thumbnailUrl=$result_live->thumbnailUrl;
?>
<link rel="stylesheet" href="layouts/css/flowplayer.css"/>
<script type="text/javascript" src="layouts/js/flowplayer.js"></script>
<script type="text/javascript" src="layouts/js/flowplayer.hlsjs.light.min.js"></script>
<div id="fp-dash" class="is-closeable" style="background-image:url(<?php echo $thumbnailUrl."/height/100/width/200"; ?>);"></div>  
<script type="text/javascript">
var primaryBroadcastingUrl="<?php echo $primaryBroadcastingUrl;  ?>";
flowplayer("#fp-dash", {
   splash: true,
   ratio: 9/16,
   autoplay:true,
   clip: {
   sources: [
   { 
      type: "application/x-mpegurl",
      src:primaryBroadcastingUrl
   },
]
},
embed: false
}).on("ready", function (e, api, video) {
  //document.querySelector("#fp-dash .fp-title").innerHTML =
  //api.engine.engineName + " engine playing " + video.type;

});
var api = flowplayer();
$(".close").on("click", function () {
api.unload();
$("#show_detail_live_modal_view").html('');  // close modal
$('#myModalLiveEdit').modal('hide');
});   
</script>
<?php include_once 'ksession_close.php'; ?>  