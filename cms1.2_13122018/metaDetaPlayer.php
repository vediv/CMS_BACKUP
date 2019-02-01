<?php
include_once 'corefunction.php';
include_once("config.php");
$entryid=$Entryid;  
$result = $client->baseEntry->get($entryid, $version);
$thumbnailUrl=$result->thumbnailUrl; $dataUrl=$result->dataUrl;
   $sese="select downloadURL,puser_id from entry where entryid='".$entryid."'";
    $fff= db_select($conn,$sese);
    $downloadURL=$fff[0]['downloadURL']; $puser_id=$fff[0]['puser_id'];
    $ses="select name from publisher where par_id='".$puser_id."'";
    $ff= db_select($conn,$ses);
    $Creator=$ff[0]['name']; 
    $createdAt=$result->createdAt;
    $plays=$result->plays;  $duration=$result->duration; 
    $msDuration=$result->msDuration ; $mediaType=$result->mediaType;   
    $mdeitype= $mediaType==1 ? "video" : ""; $moderationStatus=$result->moderationStatus;
    $moderationStatus_main= $moderationStatus==6 ? "Auto approved" : "";
    ?>
   <link rel="stylesheet" href="layouts/css/flowplayer.css"/>
   <script type="text/javascript" src="layouts/js/flowplayer.js"></script>
   <script type="text/javascript" src="layouts/js/flowplayer.hlsjs.light.min.js"></script>
   <div id="fp-dash" class="is-closeable" style="background-image:url(<?php echo $thumbnailUrl."/height/100/width/200"; ?>);"></div>  
    <p> <strong>Creator </strong>  : <?php echo $Creator; ?></p>
    <p><strong>Created on :</strong> <?php echo gmdate("d/m/y", $createdAt); ?></p>
   <hr/>
   <p><strong>Type : </strong>  <?php echo $mdeitype; ?>   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>Duration : </strong><?php echo gmdate("H:i:s", $duration); ?></p> 
   <!--<p><strong>Moderation : </strong><?php //echo $moderationStatus_main; ?>      </p>--> 
   <script type="text/javascript">
        var dataurl="<?php echo $downloadURL; ?>";
        flowplayer("#fp-dash", {
           splash: true,
           ratio: 9/16,
           clip: {
           sources: [
           { 
              type: "application/x-mpegurl",
              src:dataurl
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
        $("#show_detail_model_view").html('');  // close modal
        $('#myModalVodEdit').modal('hide');
       });   
   </script>
 <?php include_once 'ksession_close.php'; ?>  