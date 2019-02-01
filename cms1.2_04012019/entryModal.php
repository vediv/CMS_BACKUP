<?php 
include_once 'corefunction.php';
include_once("config.php");
$Entryid=$_POST['Entryid']; $getpageindex=$_POST['pageindex'];
$ptag=$_POST['ptag']; $limitval=$_POST['limitval'];
$searchInputall=isset($_POST['searchInputall'])?$_POST['searchInputall']:'';
$entryId = $Entryid;
$version = null;
$result = $client->baseEntry->get($entryId, $version);
//print '<pre>'.print_r($result, true).'</pre>';
$name=$result->name;
$duration=$result->duration; $msDuration=$result->msDuration;
?>

<div class="modal-header"> <!--onclick="CloseVideo();"-->
    <button type="button" class="close"  data-dismiss="modal1">&times;</button>
    <h4 class="modal-title">Edit Entry - <?php echo $name; ?></h4>
</div>
<div class="modal-body" style="border:0px solid ; min-height: 400px;"> 
   <div class="row">
      <div class="col-md-12">
     <div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
    <?php  if(in_array(1, $otherPermission)){ ?><li class="active"><a href="#metadata" data-toggle="tab" onclick="showMetaData('<?php echo $Entryid; ?>','<?php echo $getpageindex; ?>','<?php echo $limitval; ?>','<?php echo $searchInputall; ?>');">Metadata</a></li><?php } ?>
    <?php  if(in_array(2, $otherPermission)){ ?><li><a href="#thumb" data-toggle="tab" onclick="showThumbnail('<?php echo $Entryid; ?>','<?php echo $getpageindex; ?>','<?php echo $limitval; ?>','<?php echo $searchInputall; ?>');">Thumbnail</a></li><?php } ?>
    <?php  if(in_array(3, $otherPermission)){?><li><a href="#access_control" data-toggle="tab" onclick="accessControl('<?php echo $Entryid; ?>','<?php echo $getpageindex; ?>','<?php echo $limitval; ?>','<?php echo $searchInputall; ?>');">Access Control</a></li><?php } ?>
    <?php  if(in_array(4, $otherPermission)){?><li><a href="#currency" data-toggle="tab" onclick="currencyMataData('<?php echo $Entryid; ?>','<?php echo $getpageindex; ?>','<?php echo $limitval; ?>','<?php echo $searchInputall; ?>');">Price</a></li><?php } ?>
    <?php  if(in_array(7, $otherPermission)){?><li><a href="#content_partner" data-toggle="tab" onclick="contentPartner('<?php echo $Entryid; ?>','<?php echo $getpageindex; ?>','<?php echo $limitval; ?>','<?php echo $searchInputall; ?>');">Content Partner</a></li><?php } ?>
    <?php  if(in_array(5, $otherPermission)){ ?><li><a href="#plan" data-toggle="tab" onclick="showPlantab('<?php echo $Entryid; ?>','<?php echo $getpageindex; ?>','<?php echo $ptag ?>','<?php echo $limitval; ?>','<?php echo $searchInputall; ?>');">Content Type</a></li><?php } ?>
    <?php  if(in_array(6, $otherPermission)){ ?><li><a href="#advertisement" data-toggle="tab" onclick="showAdvg('<?php echo $Entryid; ?>','<?php echo $publisher_unique_id; ?>','<?php echo $duration ?>','<?php echo $msDuration ?>','<?php echo $getpageindex; ?>','<?php echo $limitval; ?>','<?php echo $searchInputall; ?>');">Advertisements</a></li><?php } ?>
    <?php  if(in_array(32, $otherPermission)){ ?><li><a href="#content_viewer" data-toggle="tab" onclick="ContentViewer('<?php echo $Entryid; ?>','<?php echo $getpageindex; ?>','<?php echo $limitval; ?>','<?php echo $searchInputall; ?>');">Content Viewer(Rating)</a></li><?php } ?>
    <?php  if(in_array(33, $otherPermission)){ ?><li><a href="#age_restriction" data-toggle="tab" onclick="ageRestriction('<?php echo $Entryid; ?>','<?php echo $getpageindex; ?>','<?php echo $limitval; ?>','<?php echo $searchInputall; ?>');">Content Rating</a></li><?php } ?>
    
    </ul>
    <div class="tab-content">
       <div class="tab-pane active"  id="metadata"><span id="flashMeta"></span></div>
        <div class="tab-pane" id="thumb"><span id="flashthumb"></span></div>
        <div class="tab-pane" id="access_control"><span id="flash_access_control"></span></div>
        <div class="tab-pane" id="currency"><span id="flash_currency"></span></div>
        <div class="tab-pane" id="content_partner"><span id="flash_content_partner"></span></div>
        <div class="tab-pane" id="plan"><span id="flashplan"></span></div>
        <div class="tab-pane" id="advertisement"><span id="flashadvg"></span></div>
        <div class="tab-pane" id="content_viewer"><span id="contentviewer"></span></div>
        <div class="tab-pane" id="age_restriction"><span id="agerestriction"></span></div>
    </div>
</div>
</div>

           
          </div> 
</div>
<script type="text/javascript">
function CloseVideo(){
//document.getElementById("show_detail_model_view").innerHTML="";
//$('#myModalVodEdit').modal('hide');

}
var entryid1="<?php echo $entryId; ?>"; 
var pageindex1="<?php echo $getpageindex; ?>";
var limitval1="<?php echo $limitval ?>";
var searchInputall1="<?php echo $searchInputall ?>";
showMetaData(entryid1,pageindex1,limitval1,searchInputall1);
function showMetaData(eid,pindex,limitval,searchInputall)
{
    $("#flashMeta").show();
    $("#flashMeta").fadeIn(800).html('Loading <img src="img/image_process.gif" />');
    var dataString = 'Entryid='+eid+"&pageindex="+pindex+'&limitval='+limitval+"&searchInputall="+searchInputall; 
     $.ajax({
       type: "POST",
       url: "metaDataShow.php",
       data: dataString,
       cache: false,
       success: function(r){
             $("#metadata").html(''); $("#thumb").html('');  $("#access_control").html('');$("#currency").html('');
             $("#plan").html(''); $("#currency").html('');$("#content_partner").html(''); $("#content_viewer").html('');
             $("#flashMeta").hide();
             $("#metadata").html(r);
       }
     });
}
function showThumbnail(eid,pindex,limitval,searchInputall)
{
    
    $("#flashthumb").show();
    $("#flashthumb").fadeIn(800).html('Loading <img src="img/image_process.gif" />');
    var dataString = 'Entryid='+eid+"&pageindex="+pindex+'&limitval='+ limitval+"&searchInputall="+searchInputall; 
     $.ajax({
       type: "POST",
       url: "thumnailShow.php",
       data: dataString,
       cache: false,
       success: function(r){
              $("#metadata").html('');$("#thumb").html('');  $("#access_control").html('');$("#currency").html('');
              $("#plan").html(''); $("#currency").html('');$("#content_partner").html(''); $("#age_restriction").html('');
              $("#content_viewer").html('');
             $("#flashthumb").hide();
             $("#thumb").html(r);
       }
     });
}
function accessControl(eid,pindex,limitval,searchInputall)
{
    $("#flash_access_control").show();
    $("#flash_access_control").fadeIn(800).html('Loading <img src="img/image_process.gif" />');
    var dataString = 'Entryid='+eid+"&pageindex="+pindex+'&limitval='+ limitval+"&searchInputall="+searchInputall;  
     $.ajax({
       type: "POST",
       url: "accessControl.php",
       data: dataString,
       cache: false,
       success: function(r){
              $("#metadata").html('');$("#thumb").html('');  $("#access_control").html('');$("#currency").html('');
              $("#plan").html(''); $("#currency").html('');$("#content_partner").html(''); $("#age_restriction").html('');
              $("#content_viewer").html('');
              $("#flash_access_control").hide();
              $("#access_control").html(r);
       }
     });
}
function currencyMataData(eid,pindex,limitval,searchInputall)
{
   
    $("#currency").show();
    $("#flash_currency").fadeIn(800).html('Loading <img src="img/image_process.gif" />');
    var dataString = 'Entryid='+eid+"&pageindex="+pindex+'&limitval='+ limitval+"&searchInputall="+searchInputall; 
     $.ajax({
       type: "POST",
       url: "currencyMetaData.php",
       data: dataString,
       cache: false,
       success: function(r){
             $("#metadata").html('');$("#thumb").html('');  $("#access_control").html('');$("#currency").html('');
             $("#plan").html(''); $("#currency").html('');$("#content_partner").html(''); $("#age_restriction").html('');
             $("#content_viewer").html('');
             $("#flash_currency").hide();
             $("#currency").html(r);
       }
     });
}
function showPlantab(eid,pindex,ptag,limitval,searchInputall)
{
   
   
    $("#flashplan").show();
    $("#flashplan").fadeIn(800).html('Loading <img src="img/image_process.gif" />');
    var dataString = 'Entryid='+eid+"&pageindex="+pindex+"&ptag="+ptag+'&limitval='+ limitval+"&searchInputall="+searchInputall;  
     $.ajax({
       type: "POST",
       url: "planShow.php",
       data: dataString,
       cache: false,
       success: function(r){
             $("#metadata").html('');$("#thumb").html('');  $("#access_control").html('');$("#currency").html('');
             $("#plan").html(''); $("#currency").html('');$("#content_partner").html('');$("#content_viewer").html('');
             $("#age_restriction").html('');
             $("#flashplan").hide();
             $("#plan").html(r);
       }
     });
}
function showAdvg(eid,partner_uniqueid,duration,msDuration,pageindex,limitval,searchInputall)
{
 
    $("#flashadvg").show();
    $("#flashadvg").fadeIn(800).html('Loading <img src="img/image_process.gif" />');
    var dataString = 'Entryid='+eid+"&partner_uniqueid="+partner_uniqueid+"&duration="+duration+"&msDuration="+msDuration+"&pageindex="+pageindex+'&limitval='+ limitval+"&searchInputall="+searchInputall;  
     $.ajax({
       type: "POST",
       url: "advertisementShow.php",
       data: dataString,
       cache: false,
       success: function(r){
            $("#metadata").html('');$("#thumb").html('');  $("#access_control").html('');$("#currency").html('');
             $("#plan").html(''); $("#currency").html('');$("#content_partner").html('');$("#content_viewer").html('');
             $("#age_restriction").html('');
             $("#flashadvg").hide();
             $("#advertisement").html(r);
       }
     }); 
}
function contentPartner(eid,pindex,limitval,searchInputall)
{
   
    $("#flash_content_partner").show();
    $("#flash_content_partner").fadeIn(800).html('Loading <img src="img/image_process.gif" />');
    var dataString = 'Entryid='+eid+"&pageindex="+pindex+'&limitval='+ limitval+"&searchInputall="+searchInputall; 
     $.ajax({
       type: "POST",
       url: "contentPartnerMetaData.php",
       data: dataString,
       cache: false,
       success: function(r){
         $("#metadata").html('');$("#thumb").html('');  $("#access_control").html('');
         $("#currency").html('');$("#plan").html(''); $("#currency").html('');$("#content_partner").html('');
         $("#age_restriction").html('');
         $("#content_viewer").html('');
        $("#flash_content_partner").hide();
        $("#content_partner").html(r);
       }
     });
}


function ContentViewer(eid,pindex,limitval,searchInputall)
{
    $("#contentviewer").show();
    $("#contentviewer").fadeIn(800).html('Loading <img src="img/image_process.gif" />');
    var dataString = 'Entryid='+eid+"&pageindex="+pindex+'&limitval='+ limitval+"&searchInputall="+searchInputall; 
     $.ajax({
       type: "POST",
       url: "contentViewerMetadata.php",
       data: dataString,
       cache: false,
       success: function(r){
              $("#metadata").html('');$("#thumb").html('');  $("#access_control").html('');$("#currency").html('');
              $("#plan").html(''); $("#currency").html('');$("#content_partner").html(''); $("#content_viewer").html('');
              $("#age_restriction").html('');
              $("#contentviewer").hide();
              $("#content_viewer").html(r);
       }
     });
}

function ageRestriction(eid,pindex,limitval,searchInputall)
{
    //alert("yes");
    $("#agerestriction").show();
    $("#agerestriction").fadeIn(800).html('Loading <img src="img/image_process.gif" />');
    var dataString = 'Entryid='+eid+"&pageindex="+pindex+'&limitval='+ limitval+"&searchInputall="+searchInputall; 
     $.ajax({
       type: "POST",
       url: "AgeRestrictedMetadata.php",
       data: dataString,
       cache: false,
       success: function(r){
              $("#metadata").html('');$("#thumb").html('');  $("#access_control").html('');$("#currency").html('');
              $("#plan").html(''); $("#currency").html('');$("#content_partner").html(''); $("#content_viewer").html('');
              //$("#age_restriction").html('');
              $("#agerestriction").hide();
              $("#age_restriction").html(r);
       }
     });
}



</script>