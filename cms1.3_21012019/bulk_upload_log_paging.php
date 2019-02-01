<?php
include_once 'corefunction.php';
include_once("config.php");
include_once("function.php");
$page_index=(isset($_POST['first_load']))? $_POST['first_load']:1;
$pagelimit = (isset($_POST['limitval']))? $_POST['limitval']: 20;
$fromdate = (isset($_POST['fromdate']))? $_POST['fromdate']: '';
$todate = (isset($_POST['todate']))? $_POST['todate']: '';
?>
<!--<div class="box-header">
 <div class="pull-left" id="flash" style="text-align: center;"></div>      
</div>
-->
<div class="box-header">
    <div class="row table-responsive" style="border: 0px solid red; margin-top:-15px;">
    <table border='0' style="width:98%; margin-left: 10px; font-size: 12px;">
    <tr>
    <td width="7%">
        <select id="pagelmt"  onchange="selpagelimit();">
          <option value="20" <?php echo $pagelimit==20? "selected":""; ?> >20</option>
          <option value="50" <?php echo $pagelimit==50? "selected":""; ?> >50</option>
          <option value="100" <?php echo $pagelimit==100? "selected":""; ?> >100</option>
          <option value="200" <?php echo $pagelimit==200? "selected":""; ?> >200</option>
        </select> Records Per Page
    </td>
    <td width="5%">Created Between :<input type="text" id="fromDate" readonly name="fromDate" style="width: 27% !important;" value="<?php echo $fromdate; ?>"  autocomplete="off" > <i class="fa fa-calendar" aria-hidden="true" style="z-index: 1;margin-top: 6px;position: relative;"> </i> 
        <input type="text" id="toDate" readonly  name="toDate" style="width:27% !important; margin-left: 6px;"  value="<?php echo $todate; ?>" autocomplete="off" ><i class="fa fa-calendar" aria-hidden="true" style="z-index: 1; margin-top: 6px; position: relative;     padding: 3px;
}"></i></td>
    <td width="1%"> <a href="javascript:void(0)"  onclick="clearDates('<?php echo $page_index;?>','<?php echo $pagelimit; ?>');">Clear Dates</a></td>
    
    <td width="1%">
     <div class="  pull-right" style="border:0px solid red;  margin-top:0px !important;">   
 <a href="javascript:void(0)" onclick="return refreshcontent('<?php echo $page_index;?>','<?php echo $pagelimit; ?>');" title="refresh"><i class="fa fa-refresh" aria-hidden="true"></i></a>   
     </div>
     </td>
    </tr>
</table>	  
</div>
<div class="">
      <div class="pull-left" id="flash" style="text-align: center;"></div>
      <div id="load" style="display:none;"></div>
      <div class="pull-left" id="msg" style="text-align: center;"></div>
</div>
</div>
<form action="#" id="form" name="myform" style="border: 0px solid red; ">
   <table id="example1" class="table table-fixedheader table-bordered table-striped">
    <thead>
       <tr>
        <!--<th>JobID</th-->  
        <th>Type</th>
        <th>Original file name</th>
        <th>Uploaded ON</th>
        <th>No of item</th>
        <th>Status</th>
        <th>Notification</th>
        <th>Action</th>
       </tr>    
    </thead>
    <tbody>
<?php
$bulkUploadFilter = new KalturaBulkUploadFilter();
$bulkUploadFilter->uploadedOnGreaterThanOrEqual = null;
if($fromdate!=''){
list($day, $month, $year) = explode('/',$fromdate);
$fromtimestamp=mkTimestamp($year,$month,$day);
$bulkUploadFilter->uploadedOnGreaterThanOrEqual = $fromtimestamp; 
}
$bulkUploadFilter->uploadedOnLessThanOrEqual = null;
if($todate!=''){
list($day, $month, $year) = explode('/',$todate);
$totimestamp=mkTimestamp($year,$month,$day);
$bulkUploadFilter->uploadedOnLessThanOrEqual = $totimestamp; 
}
$bulkUploadFilter->orderBy = '-createdAt';
//$bulkUploadFilter->bulkUploadObjectTypeEqual = string::ENTRY;
$pager = new KalturaFilterPager();
$pager->pageSize = $pagelimit;
$pager->pageIndex=$page_index;
$maction = (isset($_POST['maction']))? $_POST['maction']: "";
switch($maction)
{
    case "refresh":
    $pager->pageIndex =(isset($_POST['first_load']))? $_POST['first_load']:"";
    $pager->pageSize = $pagelimit; 
    break;
    case "deletecontent":
    $jobid =(isset($_POST['jobid']))? $_POST['jobid']:"";    
    $bulkuploadPlugin = KalturaBulkuploadClientPlugin::get($client); // delete log entry
    $result = $bulkuploadPlugin->bulk->abort($jobid);
    $pager->pageIndex =(isset($_POST['pageindex']))? $_POST['pageindex']:"";
    break;    
    //default :
    //$pager->pageIndex =(isset($_POST['pageindex']))? $_POST['pageindex']:"1";
    //$pager->pageSize = $pagelimit;     
}
$bulkuploadPlugin = KalturaBulkuploadClientPlugin::get($client);
$result_bulk_log = $bulkuploadPlugin->bulk->listAction($bulkUploadFilter, $pager);
$total_pages=$result_bulk_log->totalCount;
$count=1;
$totalCount=count($result_bulk_log->objects); 
foreach($result_bulk_log->objects as $entry_media) {
$jobid=$entry_media->id;$fileName=$entry_media->fileName; $bulkUploadType=$entry_media->bulkUploadType;
if($bulkUploadType=='bulkUploadCsv.CSV'){ $type='CSV'; }
$uploadedOn=date("d/m/y H:i:s",$entry_media->uploadedOn); 
$numOfObjects=$entry_media->numOfObjects ;	
$status=$entry_media->status;
$error=$entry_media->error;
if($error=="Error: None of the uploaded items were processed succsessfuly")
{
    $error="Error: None of the uploaded items were processed successfully";
}
$logFileUrl=$entry_media->logFileUrl;  $csvFileUrl=$entry_media->csvFileUrl; 
if($status==5) { $statusc="Finished successfully"; }
if($status==6) { $statusc="Failed"; }
?> 
<tr id="<?php echo $count."_r"; ?>">
<!--<td width="3%"><?php echo $jobid;?></td>-->
<td width="3%"><?php echo $type;?></td>
<td width="30%"><?php echo $fileName;?></td>
<td width="10%"><?php echo $uploadedOn;?></td>
<td width="7%"><?php echo $numOfObjects; ?></td>
<td width="12%"><?php echo $statusc; ?></td>
<td width="28%"><?php echo $error; ?></td>
<td width='20%'>
<ul class="list-unstyled list-inline">
<li>
<?php  if(in_array(4, $UserRight)){ ?>
<a href="javascript:void(0)" onclick="return deleteBulkContent('<?php echo $jobid; ?>','<?php echo $pager->pageIndex; ?>','<?php echo $pager->pageSize;?>','deletecontent')">
<i class="fa fa-trash-o" aria-hidden="true" title="Delete"></i></a>
<?php }?>        
</li>
<li>
<a href="coreData.php?action=downlaod_bulkupload_log_file&fileName=<?php echo $fileName; ?>&durl=<?php echo $logFileUrl  ?>&act=download_log_file"  download > 
<i class="fa fa-download" style="color:red;" aria-hidden="true" data-toggle="tooltip" data-placement="left"  title="Download Log File" ></i>
</a>    

</li> 
<li>
<a href="coreData.php?action=downlaod_bulkupload_log_file&fileName=<?php echo $fileName; ?>&durl=<?php echo $csvFileUrl  ?>&act=download_oringinal_file"  download > 
<i class="fa fa-download"  aria-hidden="true" data-toggle="tooltip" data-placement="left"  title="Download Original File"></i>
</a>
</li>
</ul>
</td>
</tr>   
<?php $count++; 
}
//$client->session->end();
?>         
</tbody>
</table>
</form>  


<div class="row row-list" style="border: 0px solid red; padding: 0px 5px 0px 5px;">
<div class="col-xs-8 pull-right"  style="border: 0px solid red; padding: 0px 0px 0px 0px; font-size: 13px;">
    <div class="pull-left">
     <?php 
      $limit=$pager->pageSize;
      if($pager->pageIndex ==1){ $startShow=1; 
      $lmt=$limit<$total_pages ? $limit :$total_pages; }
      else { 
      $startShow=(($pager->pageIndex - 1) * $limit)+1;
      $lmt=($pager->pageIndex*$limit) >$total_pages ? $total_pages: $pager->pageIndex * $limit;
      }
 ?>
</div>
<div class="pull-right" style="padding: 5px;">
<span style="padding-top: 5px;float:left;margin-right: 20px;"> Showing <?php echo $startShow; ?> to <?php echo $lmt; ?>   of <strong><?php echo $total_pages; ?> </strong>entries </span>
<?php
$adjacent=3; $targetpage=''; $searchTextMatch=''; $pageUrl='bulk_upload_log_paging.php';$filtervalue='';
echo pagination($pager->pageIndex,$pager->pageSize,$total_pages,$adjacent,$targetpage,$searchTextMatch,$fromdate,$todate,$pageUrl,$filtervalue);?>
</div>   

</div>
</div> 
<script type="text/javascript">
  $(function() {
    $("#fromDate").datepicker({dateFormat: "dd/mm/yy"});  
    $("#fromDate").change(function() {
         var fromdate = $("#fromDate").val();
         var todate = $("#toDate").val();
         if(new Date(todate) <= new Date(fromdate))
         {
             alert("From Date must be before To Date");
             $("#fromDate").val("");
             return false;
         }
        if(todate!='')
       {  var dataString ='todate='+todate+'&fromdate='+fromdate; } 
       else{  var dataString ='fromdate='+fromdate; }   
        $('#load').show();
        $('#result_bulk_upload_log').css("opacity",0.1);
        $.ajax({
           type: "POST",
           url: "bulk_upload_log_paging.php",
           data: dataString,
           cache: false,
           success: function(result){
            	 $("#result_bulk_upload_log").html('');
            	 $("#result_bulk_upload_log").html(result);
                 $('#load').hide();
		 $('#result_bulk_upload_log').css("opacity",1);
           }
          });
        
    });
    $("#toDate").datepicker({dateFormat: "dd/mm/yy"});  
    $("#toDate").change(function() {
        var fromdate = $("#fromDate").val();
        var todate = $("#toDate").val();
        if(new Date(fromdate) >= new Date(todate))
         {
             alert("From Date must be before To Date");
             $("#toDate").val("");
             return false;
         }
       if(fromdate!='')
       {  var dataString ='todate='+todate+'&fromdate='+fromdate; } 
       else{ var dataString ='todate='+todate;  }
        $('#load').show();
        $('#result_bulk_upload_log').css("opacity",0.1);
        $.ajax({
           type: "POST",
           url: "bulk_upload_log_paging.php",
           data: dataString,
           cache: false,
           success: function(result){
            	 $("#result_bulk_upload_log").html('');
                 $("#result_bulk_upload_log").html(result);
                 $('#load').hide();
		 $('#result_bulk_upload_log').css("opacity",1);
           }
          });
        
        
    });
  });  
</script>    
<script type="text/javascript">
function changePagination(pageid,limitval,searchtext,fromdate,todate)
{
    $('#load').show();
    $('#result_bulk_upload_log').css("opacity",0.1);
     var dataString ='first_load='+pageid+'&limitval='+limitval+'&searchtext='+searchtext+'&fromdate='+fromdate+'&todate='+todate;
     $.ajax({
           type: "POST",
           url: "bulk_upload_log_paging.php",
           data: dataString,
           cache: false,
           success: function(result){
             //  alert(result);
           	 $("#result_bulk_upload_log").html('');
                $("#result_bulk_upload_log").html(result);
                 $('#load').hide();
                 $('#result_bulk_upload_log').css("opacity",1);
           }
      });
} 
function selpagelimit(){
var limitval = document.getElementById("pagelmt").value;
var dataString ='limitval='+ limitval;
$('#load').show();
    $('#result_bulk_upload_log').css("opacity",0.1);
        $.ajax({
        type: "POST",
        url: "bulk_upload_log_paging.php",
         data: dataString,
        cache: false,
        success: function(result){
               $("#result_bulk_upload_log").html('');
                $("#result_bulk_upload_log").html(result);
                $('#load').hide();
                $('#result_bulk_upload_log').css("opacity",1);
                  }
            }); 
 }

function clearDates(pageindex,pageSize)
{
      $('#load').show();
      $('#result_bulk_upload_log').css("opacity",0.1);
      var dataString ='maction=clearDates&first_load='+pageindex+'&limitval='+pageSize;
       $.ajax({
           type: "POST",
           url: "bulk_upload_log_paging.php",
           data: dataString,
           cache: false,
           success: function(result){
          	 $("#fromDate").val(""); $("#toDate").val("");
                 $("#result_bulk_upload_log").html('');
          	
          	 $("#result_bulk_upload_log").html(result);
                 $('#load').hide();
                 $('#result_bulk_upload_log').css("opacity",1);
                 
          }
     });
   return false;
}
function refreshcontent(pageindex,pageSize){
    $('#load').show();
      $('#result_bulk_upload_log').css("opacity",0.1);
      var dataString ='maction=refresh&first_load='+pageindex+'&limitval='+pageSize;
     //$("#result").html();
       $.ajax({
           type: "POST",
           url: "bulk_upload_log_paging.php",
           data: dataString,
           cache: false,
           success: function(result){
          	//alert(result);
           	 $("#result_bulk_upload_log").html('');
          	 $("#flash").hide();
          	 $("#result_bulk_upload_log").html(result);
                  $('#load').hide();
                 $('#result_bulk_upload_log').css("opacity",1);
          }
     });
}   
function deleteBulkContent(jobid,pageindex,limitval,act){
  
      var dataString ='jobid='+ jobid +"&maction="+act+"&pageindex="+pageindex+'&limitval='+ limitval;
      var a=confirm("Are you sure you want to delete the selected entry ? " + jobid + "\nPlease note: the entry will be permanently deleted from your account");
	  if(a==true)
	     {
	    $('#load').show();
           $('#result_bulk_upload_log').css("opacity",0.1);
	        $.ajax({
	           type: "POST",
	           url: "bulk_upload_log_paging.php",
	           data: dataString,
	           cache: false,
	           success: function(result){
	           //alert(result);
	           	 $("#result_bulk_upload_log").html('');
	           	 $("#result_bulk_upload_log").html(result);
                          $('#load').hide();
                          $('#result_bulk_upload_log').css("opacity",1);
	           }
	         });
	     }
	     else
	     {
	     	 $("#load").hide();
	     	 return false;
	     }
}
</script>




