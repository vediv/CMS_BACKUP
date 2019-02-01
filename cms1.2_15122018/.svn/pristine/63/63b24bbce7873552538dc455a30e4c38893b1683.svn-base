<?php
include_once 'corefunction.php';
include_once("config.php");
$Entryid=$_REQUEST['Entryid'];
$getpageindex=$_REQUEST['pageindex'];
$ptag=$_REQUEST['ptag'];
$limitval=$_REQUEST['limitval'];
$entryId = $Entryid;
$version = null;
$result = $client->baseEntry->get($entryId, $version);
//print '<pre>'.print_r($result, true).'</pre>';
$name=$result->name;
$duration=$result->duration; $msDuration=$result->msDuration ;
?>
<!--<link href="dist/css/navAccordion.css" rel="stylesheet" type="text/css" />-->
<link href="player_css/functional.css" rel="stylesheet" type="text/css" />
<link href="dist/css/custom.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="js/bootstrap-multiselect.css" type="text/css"/>
<link href="dist/css/jquery.flexdatalist.min.css" rel="stylesheet" type="text/css" />
<div class="modal-header">
          <button type="button" class="close" onclick="CloseVideo();" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit Entry - <?php echo $name; ?></h4>
</div>
<div class="modal-body" style="border:0px solid red;"> 
<div class="tabbable tabs-left">
 <ul class="nav nav-tabs">
<li class="active"><a href="#metadata" data-toggle="tab">MetaData</a></li>
<li ><a href="#thumb" data-toggle="tab" onclick="showThumbnail('<?php echo $Entryid; ?>','<?php echo $getpageindex; ?>');">Thumbnail</a></li>
<?php  if(in_array(5, $otherPermission)){ ?><li><a href="#plan" data-toggle="tab" onclick="showPlantab('<?php echo $Entryid; ?>','<?php echo $getpageindex; ?>','<?php echo $ptag ?>');">Plan</a></li><?php } ?>
<?php  if(in_array(6, $otherPermission)){ ?><li><a href="#advertisement" data-toggle="tab" onclick="showAdvg('<?php echo $Entryid; ?>','<?php echo $publisher_unique_id; ?>','<?php echo $duration ?>','<?php echo $msDuration ?>');">Advertisements</a></li><?php } ?>
 </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="metadata"><span id="flashMeta"></span></div>
        <div class="tab-pane" id="thumb"><span id="flashthumb"></span></div>
        <div class="tab-pane" id="plan"><span id="flashplan"></span></div>
        <div class="tab-pane" id="advertisement"><span id="flashadvg"></span><?php //include_once 'advertisementShow.php'; ?></div>
    </div>
    </div>  
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-default" onclick="CloseVideo();" data-dismiss="modal">Close</button>
</div>
<?php include_once 'ksession_close.php'; ?>
<script type="text/javascript">
function CloseVideo(){
document.getElementById("show_detail_model_view").innerHTML="";
    //return false();
$('#myModal').modal('hide');
}
var entryid="<?php echo $entryId; ?>"; 
var pageindex="<?php echo $getpageindex; ?>";
var limitval="<?php echo $limitval ?>";
showMetaData(entryid,pageindex,limitval) // first time call
function showMetaData(eid,pindex,limitval)
{
    $("#flashMeta").show();
    $("#flashMeta").fadeIn(800).html('Loading <img src="img/image_process.gif" />');
    var dataString = 'Entryid='+eid+"&pageindex="+pindex+'&limitval='+ limitval; 
     $.ajax({
       type: "POST",
       url: "metaDataShow.php",
       data: dataString,
       cache: false,
       success: function(r){
       //alert(result);
             $("#metadata").html('');
             $("#flashMeta").hide();
             $("#metadata").html(r);
       }
     });
}
function showThumbnail(eid,pindex)
{
    
    $("#flashthumb").show();
    $("#flashthumb").fadeIn(800).html('Loading <img src="img/image_process.gif" />');
    var dataString = 'Entryid='+eid+"&pageindex="+pindex+'&limitval='+ limitval; 
     $.ajax({
       type: "POST",
       url: "thumnailShow.php",
       data: dataString,
       cache: false,
       success: function(r){
       //alert(result);
             $("#thumb").html('');
             $("#flashthumb").hide();
             $("#thumb").html(r);
       }
     });
} 
function showPlantab(eid,pindex,ptag)
{
    
    $("#flashplan").show();
    $("#flashplan").fadeIn(800).html('Loading <img src="img/image_process.gif" />');
    var dataString = 'Entryid='+eid+"&pageindex="+pindex+"&ptag="+ptag+'&limitval='+ limitval; 
     $.ajax({
       type: "POST",
       url: "planShow.php",
       data: dataString,
       cache: false,
       success: function(r){
             $("#plan").html('');
             $("#flashplan").hide();
             $("#plan").html(r);
       }
     });
}
function showAdvg(eid,partner_uniqueid,duration,msDuration)
{
    //console.log(eid+"--"+partner_uniqueid+"--"+duration);
    $("#flashadvg").show();
    $("#flashadvg").fadeIn(800).html('Loading <img src="img/image_process.gif" />');
    var dataString = 'Entryid='+eid+"&partner_uniqueid="+partner_uniqueid+"&duration="+duration+"&msDuration="+msDuration; 
     $.ajax({
       type: "POST",
       url: "advertisementShow.php",
       data: dataString,
       cache: false,
       success: function(r){
             $("#advertisement").html('');
             $("#flashadvg").hide();
             $("#advertisement").html(r);
       }
     }); 
}

</script>