<?php 
sleep(1);
include_once 'corefunction.php';
include_once("function.php");
$searchKeword = (isset($_POST['searchInputall']))? $_POST['searchInputall']: "";
$page =(isset($_POST['pageNum']))? $_POST['pageNum']: 0;
$pagelimit = (isset($_POST['limitval']))? $_POST['limitval']: 10;
$action = (isset($_POST['action'])) ? $_POST['action']: "";
switch($action)
{
    case "refresh":
    break;
}
?>
<div class="box-header" >
    <div class="row" style="border: 0px solid red; margin: -25px 5px 0px 5px;">
<table border='0' style="width:100%; margin-left: 1px;">
    <tr>
    <td width="15%">
    <select id="pagelmt"  style="width:60px;" onchange="selpagelimit_new('pagelmt','bulkupload_paging.php','load');" >
        <option value="10"  <?php echo $pagelimit==10? "selected":""; ?> >10</option>
        <option value="20"  <?php echo $pagelimit==20? "selected":""; ?> >20</option>
         <option value="50"  <?php echo $pagelimit==50? "selected":""; ?> >50</option>
        <option value="100" <?php echo $pagelimit==100? "selected":""; ?> >100</option>
        <option value="200" <?php echo $pagelimit==200? "selected":""; ?> >200</option>
        <option value="500" <?php echo $pagelimit==500? "selected":""; ?> >500</option>
        </select> Records Per Page
    </td>
  
<td width="75%">
<div class="col-sm-3 col-md-3 pull-right navbar-form" role="search">  
            <div class="input-group add-on" style="float: right;">
            <input id='pagelimit' type="hidden" height="30px"  value="<?php echo $pagelimit; ?>">   
            <input class="form-control" size="30" onkeyup="SeachDataTable('bulkupload_paging.php','<?php echo $pagelimit;?>','<?php //echo $page; ?>','load')"  placeholder="Search By JobID,Filename"  autocomplete="off" name='searchQuery' id='searchInput' class="searchInput" type="text" value="<?php echo $searchKeword; ?>">
            <div class="input-group-btn">
              <button class="enableOnInput btn btn-default" disabled='disabled' onclick="SearchDataTableValue('bulkupload_paging.php','<?php echo $pagelimit;?>','<?php //echo $page; ?>','load')" id='submitBtn' type="button" style="height: 30px;   padding: 4px 6px !important;"><i class="glyphicon glyphicon-search"></i></button>	
            </div>
            </div>
         </div>  
</td>
<td width="5%">
     <div class="col-xs-1 hidden-xs hidden-sm pull-right" style="border:none;  margin-top:1px !important;">   
      <a href="javascript:" onclick="return refreshcontent('refresh','<?php echo $page;  ?>','<?php echo $pagelimit; ?>','<?php echo $searchTextMatch;?>','<?php echo $filtervalue;?>');" title="refresh" style="float: right"><i class="fa fa-refresh" aria-hidden="true"></i></a>   
    </div>
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
if($searchKeword!='')
{
    $query_search = " and  (file_name LIKE '%".$searchKeword. "%' OR kaltura_job_id LIKE '%". $searchKeword . "%'" . ")";
}    
			
$adjacents = 3;
$query = "SELECT * FROM bulkupload_log where puser_id='$get_user_id'  $query_search  ";
$total_pages = db_totalRow($conn,$query);
$limit = $pagelimit; 
if($page) 
        $start = ($page - 1) * $limit; 			
else
        $start = 0;

$sql = "SELECT * FROM bulkupload_log where puser_id='$get_user_id'  $query_search  order by uploaded_at DESC LIMIT $start, $limit";
$que = db_select($conn,$sql);
$countRow=  db_totalRow($conn,$sql);
if($countRow==0)
{echo "<div align='center'><strong>No Record Found</strong> </div><br/>";}   
/* Setup page vars for display. */
?>
<form id="form" name="myform" style="border: 0px solid red;" method="post" action="priority.php">
  <table id="example1" class="table table-fixedheader table-bordered table-striped" style="width: 100%;">
<thead>
    <tr>
           <th>Job id</th>
           <th>FileName</th>
           <th>Status</th>
           <th>Description</th>
           <th>Uploaded At</th>
           <th>Action</th>
           <!--<th title="Subscription History">Detail</th>-->
    </tr> 
</thead>
<tbody>
<?php
$count=1;
foreach($que as $fetch)
{
    $bid=$fetch['bid']; $kaltura_job_id=$fetch['kaltura_job_id'];  $file_name=$fetch['file_name']; $uploaded_at=$fetch['uploaded_at'];
    $kquery="select status,message,description from  kaltura.batch_job_log where job_id='$kaltura_job_id' and partner_id='$partnerID'";
    $fetchKaltura =db_select($conn,$kquery);
    $status=$fetchKaltura[0]['status'];
    $kmessage=$fetchKaltura[0]['message'];
    $kdescription=$fetchKaltura[0]['description'];
    
 ?> 
<tr>
<td><?php echo $kaltura_job_id; ?></td>    
<td><?php echo $file_name; ?></td>
<td><?php echo $kmessage ?></td>
<td><pre style="border:0"><?php echo $kdescription  ?></pre></td>
<td><?php echo $uploaded_at ;?></td>
<td><a href="javascript:void(0)" onclick="viewBulkUploadEntries('<?php echo $kaltura_job_id; ?>')" > 
<i class="fa fa-eye" aria-hidden="true"  data-placement="left"  title="View entries" style="padding-right: 8px  !important;"></i>
</a></td>


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
    $adjacent=3; $targetpage=''; $fromdate=''; $todate=''; $pageUrl='bulkupload_paging.php'; $filtervalue='';
    echo pagination($page,$limit,$total_pages,$adjacent,$targetpage,$searchKeword,$fromdate,$todate,$pageUrl,$filtervalue);
    ?>
    </div> 
</div>  
<script src="js/commonFunctionJS.js" type="text/javascript"></script>
<script type="text/javascript">
  function viewBulkUploadEntries(kjobid)
{
   $("#msg").html(); 
   $("#myModalViewBulkEntries").modal();
   $("#flash").fadeIn(500).html('Loading <img src="img/image_process.gif" />');
   var info = 'kjobid='+kjobid+"&action=view_bulk_entries"; 
       $.ajax({
	    type: "POST",
	    url: "categories_view_entry.php",
	    data: info,
            success: function(result){
             $("#flash").hide();    
             $('#viewBulkEntries').html(result);
              }   
            });
     return false;   
}
function refreshcontent(ref,pageindex,limitval,searchtext,filterview){
     $('#load').show();
     $('#results').css("opacity",0.1);
     var apiBody = new FormData();
     apiBody.append("pageNum",pageindex);
     apiBody.append("limitval",limitval);
     apiBody.append("searchInputall",searchtext);
     apiBody.append("filtervalue",filterview);
     apiBody.append("action",ref);
      $.ajax({
           type: "POST",
           url: "bulkupload_paging.php",
           data: apiBody,
           processData: false,
           contentType: false,
           cache: false,
           success: function(result){
           	 $("#results").html(result);
                 $("#load").hide();
                 $('#results').css("opacity",1);
          }
     });
}
</script>