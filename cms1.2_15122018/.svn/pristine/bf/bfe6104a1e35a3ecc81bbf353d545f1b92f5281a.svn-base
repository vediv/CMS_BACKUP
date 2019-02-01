<?php 
include_once 'corefunction.php';
include_once("function.php");
$searchKeword = (isset($_POST['searchInputall']))? $_POST['searchInputall']: "";
$page =(isset($_POST['pageNum']))? $_POST['pageNum']: 0;
$pagelimit = (isset($_POST['limitval']))? $_POST['limitval']: 10;
$action = (isset($_POST['action'])) ? $_POST['action']: "";

?>
<div class="box-header" >
    <div class="row" style="border: 0px solid red; margin: -25px 5px 10px 5px;">
    <table border='0' style="width:98%; margin-left: 10px;">
    <tr>
    <td width="25%">
    <select id="pagelmt"  style="width:60px;" onchange="selpagelimit('pagelmt','notification_list_paging.php','load');" >
       <option value="10"  <?php echo $pagelimit==10? "selected":""; ?> >10</option>
        <option value="15"  <?php echo $pagelimit==15? "selected":""; ?> >15</option>
       
        <option value="20"  <?php echo $pagelimit==20? "selected":""; ?> >20</option>
         <option value="50"  <?php echo $pagelimit==50? "selected":""; ?> >50</option>
        <option value="100" <?php echo $pagelimit==100? "selected":""; ?> >100</option>
        <option value="200" <?php echo $pagelimit==200? "selected":""; ?> >200</option>
        <option value="500" <?php echo $pagelimit==500? "selected":""; ?> >500</option>
        </select> Records Per Page
    </td>
    <td width="55%">
        <div class="col-sm-3 col-md-3 pull-right navbar-form" role="search">  
            <div class="input-group add-on" style="float: right;">
            <input id='pagelimit' type="hidden" height="30px"  value="<?php echo $pagelimit; ?>">   
            <input class="form-control" size="30" onkeyup="SeachDataTable('notification_list_paging.php','<?php echo $pagelimit;?>','<?php //echo $page; ?>','load','')"  placeholder="Search ID,Title,Message,Mode"  autocomplete="off" name='searchQuery' id='searchInput' class="searchInput" type="text" value="<?php echo $searchKeword; ?>">
            <div class="input-group-btn">
              <button class="enableOnInput btn btn-default" disabled='disabled' onclick="SearchDataTableValue('notification_list_paging.php','<?php echo $pagelimit;?>','<?php //echo $page; ?>','load','')" id='submitBtn' type="button" style="height: 30px;   padding: 4px 6px !important;"><i class="glyphicon glyphicon-search"></i></button>	
            </div>
            </div>
       </div>
    </td>
    <td width="5%">
        <a href="javascript:" class="myBtn btn btn-info" onclick="OpenDownloadModal()">Download</a>
    </td>
    
</tr>
</table>
<div class="">
  <div class="pull-left" id="flash" style="text-align: center;"></div>
  <div id="load" style="display:none;"></div>
  <div class="pull-left" id="msg" style="text-align: center;"></div> 
</div>        
</div>
<?php 
$query_search=''; 
if(!empty($searchKeword))
{   
   $query_search=" Where notification_id LIKE '%$searchKeword%' OR title LIKE '$searchKeword' or message LIKE '$searchKeword%' 
   or mode LIKE '$searchKeword%' or status LIKE '$searchKeword%'";
   
}
 $query = "SELECT COUNT(notification_id) AS num FROM notification_details $query_search";
	$totalpages =db_select($conn,$query);
	$total_pages = $totalpages[0]['num'];
	$limit = $pagelimit; 
	if($page) 
		$start = ($page - 1) * $limit; //first item to display on this page
	else
		$start = 0;
$sql="SELECT * FROM notification_details $query_search order by notification_id DESC LIMIT $start, $limit";
$que= db_select($conn,$sql);
$countRow=  db_totalRow($conn,$sql);
if($countRow==0)
{echo "<div align='center'><strong>No Record Found</strong> </div><br/>";}   
/* Setup page vars for display. */
?>
<form id="form" name="myform" style="border: 0px solid red;" method="post">
  <table id="example1" class="table table-fixedheader table-bordered table-striped" style="width: 100%;">
    <thead>
          <tr>
                           <!--<th>S.No</th>-->
                           <th>Notification ID</th>
                           <th width="20%">Title</th>
                           <th width="20%">Message</th>
                           <th>Thumbnail</th>
                           <!--<th>Total-Success</th>
                           <th>Total-Fail</th>-->
                          <!-- <th>Status</th>-->
                           <th>Mode</th>
                           <th>Sending-Time</th>
                           <!--<th>Sending-By</th>-->
	</tr>  
</thead>
<tbody>
<?php
$count=1;
foreach($que as $fetch)
{
  $nid=$fetch['notification_id'];  $title=$fetch['title']; $message=$fetch['message']; $thumbnail=$fetch['thumbnail']; 
  $total_success=$fetch['total_success'];$total_fail=$fetch['total_fail'];  $status=$fetch['status'];  
  $sending_time=$fetch['sending_time'];$sendingby=$fetch['sendingby'];
  $Showthumbnail=($thumbnail=='NULL' || $thumbnail=='')  ? "N/A":"<img src='{$thumbnail}' height='50' />";
  $mode=($fetch['mode']=='NULL' || $fetch['mode']=='') ? "":$fetch['mode'];
?> 
<tr>
              <td><?php echo $nid; ?></td>
              <td><?php echo wordwrap($title,40, "\n", true); ?></td>
              <td><?php echo wordwrap($message,40, "\n", true); ?></td>
              <td><?php echo $Showthumbnail; ?></td>
              <!--<td><?php //echo $total_success; ?></td>
              <td><?php //echo $total_fail; ?></td>-->
              <!--<<?php // echo $status; ?></td>-->
              <td><?php echo $mode; ?></td>
              <td><?php echo $sending_time; ?></td>
              <!--<td><?php //echo $sendingby; ?></td>-->
          </tr>      

<?php $count++; } ?>         
</tbody>
</table>
</form> 
<div class="page" style="border: 0px solid red; text-align: center; background-color:#fff !important; height:40px;">
<?php if($start==0) { 
       if($total_pages==0){  $startShow=0;  } else {  $startShow=1;}
       $lmt=$limit<$total_pages ? $limit :$total_pages;
       }
      else { $startShow=$start+1;  $lmt=$start+$countRow;  }
?>    
    <div class="pull-left" style="border: 0px solid red;">
      Showing <?php echo $startShow; ?>  to <?php echo $lmt; ?>   of <?php echo $total_pages; ?> entries   
      <span style="margin-left: 50px;" id="paging_loader"></span>
    </div> 
    <div class="pull-right" style="border: 0px solid red;">
    <?php
    if ($page == 0) $page = 1;
    $adjacent=3; $targetpage=''; $fromdate=''; $todate=''; $pageUrl='notification_list_paging.php'; $filtervalue='';
    echo pagination($page,$limit,$total_pages,$adjacent,$targetpage,$searchKeword,$fromdate,$todate,$pageUrl,$filtervalue);
    ?>
    </div> 
</div>
<script src="js/commonFunctionJS.js" type="text/javascript"></script>
