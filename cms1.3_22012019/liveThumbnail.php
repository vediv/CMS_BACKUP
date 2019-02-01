<?php 
include_once 'corefunction.php';
include_once("config.php");
?>
<style type="text/css">
    a[disabled="disabled"] {
        pointer-events: none;
    }

</style>
<div style="border:0px solid #c7d1dd;  border-top: 0px; ">
<div id="load_in_modal" style="display:none; "></div>   
<form action="#" id="form" name="myformThumbnail" id="myformThumbnail" style="border: 0px solid red; ">
<table id="example1" class="table table-fixedheader table-bordered table-striped">
<thead>
<tr>
<th>Thumbnail</th>
<th>Dimension</th>
<th>Size(KB)</th>
<!--<th>Distributors</th>-->
<th>Status</th>
<!--<th>Tags</th>-->
<th>Action</th>
</tr>  
 </thead>
<tbody>
<?php
$filter = new KalturaAssetFilter();
$action_thumb = (isset($_POST['action_thumb']))? $_POST['action_thumb']: '';
if($action_thumb=="setdefault")
{
        $thumbID = (isset($_POST['thumbID']))? $_POST['thumbID']: '';
        $result = $client->thumbAsset->setasdefault($thumbID);
}
if($action_thumb=="remove")
{
        $thumbID = (isset($_POST['thumbID']))? $_POST['thumbID']: '';
        $result = $client->thumbAsset->delete($thumbID);
}
$EntryID =$_POST['entryid'];
$filter->entryIdEqual = $EntryID;
$pager = new KalturaFilterPager();
$pager->pageSize = 4;
$pager->pageIndex = (isset($_POST['first_load']))? $_POST['first_load']: 1;
$result_media = $client->thumbAsset->listAction($filter, $pager);
$total_pages=$result_media->totalCount;
$count=1;
foreach($result_media->objects as $entry_media) {
$id=$entry_media->id ;	
$width=$entry_media->width ;
$height=$entry_media->height ;
$dimention=$width."x".$height;
$size=floor(($entry_media->size)/1024);
$tags=$entry_media->tags;
$status=$entry_media->status;
if($status==0) { $statusc="Uploading"; }
if($status==1) { $statusc="Converting"; }
if($status==2) { $statusc="Ready"; }
$buttonactive=($tags=="default_thumb") ? "disabled" :"";
$cheked=($tags=="default_thumb") ? "<i class='fa fa-check'></i>" :"";
$remove=($tags=="default_thumb") ? "<i class='fa fa-remove'></i>" :"";
?>

<tr id="<?php echo $count."_r"; ?>">
    <!--td><img class="img-responsive customer-img"  height="60" width="60" src="<?php echo SERVICEURL; ?>/api_v3/index.php/service/thumbAsset/action/serve/thumbAssetId/<?php echo $id; ?>/v/32/" /></td -->
    <td><img class="img-responsive customer-img"  height="60" width="60" src="<?php echo SERVICEURL; ?>/v1/admin_imgresz/entryid=<?php echo $id;?>/width=90/height=60/quality=100" /></td>

    <td><?php echo $dimention;?></td>
    <td><?php echo $size;?></td>
  <!--  <td><?php //echo $statusc; ?></td>-->
    <td><?php echo  $statusc; ?></td>
  <!--  <td><?php echo  $tags; ?></td>-->
    <td>
   <?php  if(in_array(2, $UserRight)){ ?>
    <p><a href="#" onclick="return thumbnail('setdefault','<?php echo $id;?>')" disabled="<?php echo $buttonactive; ?>"> <?php echo $cheked; ?> Set as Default</a></p>
   <?php } if(in_array(4, $UserRight)){  ?> 
    <p><a href="#" onclick="return thumbnail('remove','<?php echo $id;?>')" disabled="<?php echo $buttonactive; ?>"><?php echo $remove; ?> Delete</a></p>
   <?php } ?>
    </td>
</tr>   
<?php $count++; } 
include_once 'ksession_close.php';
?>
</tbody>
</table>
</form> 
</div>
<div class="page" style="border: 0px solid red; text-align: center;">
    <?php
   if($total_pages>0){
    $page =1; //if no page var is given, default to 1.
	$limit=$pager->pageSize;						//next page is page + 1
	$total = ceil($total_pages/$limit);		//lastpage is = total pages / items per page, rounded up.
    if($pager->pageIndex > 1)
	 { ?>
	<a  href="javascript:void(0)" onclick="changePagination_thumbnail('<?php echo $pager->pageIndex-1 ?>')">&nbsp;&nbsp;PREVIOUS &nbsp;&nbsp; </a>
	<?php }	
      while($page)
     {
        if($page == $pager->pageIndex)
		{ echo $page.' ' . " to "; }
        else {  ?> <a  href="javascript:void(0)" onclick="changePagination_thumbnail('<?php echo $page ?>')"><?php echo $page ?></a>
	   <?php } 
        if($page*$pager->pageSize > $result_media->totalCount)
            break;
        $page++;
      }
	 
	 if($pager->pageIndex!=$total){ ?> <a  href="javascript:void(0)" onclick="changePagination_thumbnail('<?php echo $pager->pageIndex+1 ?>')">&nbsp;&nbsp;NEXT&nbsp;&nbsp;</a>
     <?php 
       }
	 if($pager->pageIndex*$pager->pageSize <= $result_media->totalCount)
	    { echo "<font color='black'>" . $pager->pageIndex*$pager->pageSize." of ".$total_pages . " Entries " . "</font>";}
	 else 
	 	{ echo "<font color='black'>". $total_pages." of ".$total_pages. " Entries " ."</font>";}
      }         
    ?>
 </div>
  
