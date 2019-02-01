<?php 
include_once 'corefunction.php';
include_once("config.php");
$Entryid=$_POST['id']; $getpageindex=$_POST['pageindex']; $limitval=$_POST['limitval'];
$searchInputall=isset($_POST['searchInputall'])?$_POST['searchInputall']:'';                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              ;
$entryId = $Entryid;
$selEntry="select title from ugc_entry where id='$Entryid'";
$f= db_select($conn,$selEntry);
$name=$f[0]['title']; 

?>
<div class="modal-header" style=" background-color: #0480be; color: white;"> 
    <button type="button" class="close"  data-dismiss="modal1" style="color: black !important;" onclick="CloseVideo();">&times;</button>
    <h4 class="modal-title"><i>Edit Entry - <?php echo $name; ?></i></h4>
</div>
<div class="modal-body" style="border:1px solid black; min-height: 400px;"> 
   <div class="row">
      <div class="col-md-12">
     <div class="nav-tabs-custom">
<ul class="nav nav-tabs">
    <?php  if(in_array(1, $otherPermission)){ ?><li class="active"><a href="#metadata" data-toggle="tab" onclick="showMetaData('<?php echo $Entryid; ?>','<?php echo $getpageindex; ?>','<?php echo $limitval; ?>','<?php echo $searchInputall; ?>');">Metadata</a></li><?php } ?>
    </ul>
<div class="tab-content">
       <div class="tab-pane active"  id="metadata"><span id="flashMeta"></span></div>
</div>
</div>
</div>
</div> 
</div>
<script type="text/javascript">
function CloseVideo(){
document.getElementById("show_detail_model_view").innerHTML="";
$('#myModalugcEdit').modal('hide');
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
       url: "ugcmetaDataShow.php",
       data: dataString,
       cache: false,
       success: function(r){
             $("#metadata").html(''); 
             $("#metadata").html(r);
       }
     });
}
</script>