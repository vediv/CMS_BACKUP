<?php 
//sleep(1);
include_once 'corefunction.php';
include_once("function.php");
$action = (isset($_POST['action'])) ? $_POST['action']: ""; 
switch($action)
{
    case "changeStatus":
    $ticid=$_POST['ticid'];
    $statusVal=$_POST['statusVal']; 
    if($statusVal=='pending'){ $dateUpdate= 'created_at=NOW()'; }
    if($statusVal=='inprocess'){ $dateUpdate= 'inprocess_at=NOW()'; }
    if($statusVal=='close'){ $dateUpdate= 'close_at=NOW()'; }
    $sql="update ticket set ticket_status='$statusVal',par_id='$get_user_id',$dateUpdate where tic_id='".$ticid."' ";
    $r=db_query($conn,$sql);
        /*----------------------------update log file begin-------------------------------------------*/
         $error_level=1;$msg="Update Ticket Status($statusVal tid=$ticid--by=$get_user_id)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
         $qry='';
         write_log($error_level,$msg,$lusername,$qry);
         /*----------------------------update log file End---------------------------------------------*/   
    break;    
}
$searchKeword = (isset($_POST['searchInputall']))? $_POST['searchInputall']: "";
$page =(isset($_POST['pageNum']))? $_POST['pageNum']: 0;
$pagelimit = (isset($_POST['limitval']))? $_POST['limitval']: 10;
?>
<div class="box-header" >
    <div class="row" style="border: 0px solid red; margin: -25px 5px 10px 5px;">
    <table border='0' style="width:98%; margin-left: 10px;">
    <tr>
    <td width="25%">
        <select id="pagelmt"  style="width:60px;" onchange="selpagelimit('pagelmt','ticket_paging.php','load');" >
        <option value="10"  <?php echo $pagelimit==10? "selected":""; ?> >10</option>
        <option value="20"  <?php echo $pagelimit==20? "selected":""; ?> >20</option>
         <option value="50"  <?php echo $pagelimit==50? "selected":""; ?> >50</option>
        <option value="100" <?php echo $pagelimit==100? "selected":""; ?> >100</option>
        <option value="200" <?php echo $pagelimit==200? "selected":""; ?> >200</option>
        <option value="500" <?php echo $pagelimit==500? "selected":""; ?> >500</option>
        </select> Records Per Page
    </td>
    <td width="45%">
       <div class="col-sm-3 col-md-3 pull-right navbar-form" role="search"> 
        <div class="input-group add-on" style="float: right;">
        <input id='pagelimit' type="hidden" height="30px"  value="<?php echo $pagelimit; ?>">   
        <input class="form-control" size="30" onkeyup="SeachDataTable('ticket_paging.php','<?php echo $pagelimit;?>','<?php //echo $page; ?>','load')"  placeholder="Search by ticket Number,subject,status,email,usename"  autocomplete="off" name='searchQuery' id='searchInput' class="searchInput" type="text" value="<?php echo $searchKeword; ?>">
        <div class="input-group-btn">
        <button class="enableOnInput btn btn-default" disabled='disabled' id='submitBtn' type="button" style="height:30px;   padding: 4px 6px !important;" onclick="SearchDataTableValue('ticket_paging.php','<?php echo $pagelimit;?>','<?php //echo $page; ?>','load')"><i class="glyphicon glyphicon-search"></i></button>	
        </div>
        </div>
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
     $query_search = " where 
     (tic.ticket_number LIKE '%". $searchKeword . "%'
     or tic.ticket_sub LIKE '%" . $searchKeword . "%'
     or tic.ticket_status LIKE '%" . $searchKeword . "%'
     or ur.uemail LIKE '%" . $searchKeword . "%'
     or ur.user_id LIKE '%" . $searchKeword . "%'
     )";
}    
$query = "SELECT COUNT(tic.tic_id) as num FROM ticket tic LEFT JOIN user_registration ur on tic.userid=ur.uid  $query_search ";
$totalpages =db_select($conn,$query);
$total_pages = $totalpages[0]['num'];
$limit = $pagelimit; 
if($page) 
        $start = ($page - 1) * $limit; 			//first item to display on this page
else

    $start = 0;
//$sql="Select * from ticket $query_search order by tic_id LIMIT $start, $limit";
$sql="SELECT tic.*,ur.user_id,ur.uemail FROM ticket  tic 
LEFT JOIN user_registration ur on tic.userid=ur.uid  $query_search  order by tic.tic_id DESC LIMIT $start, $limit ";
$que = db_select($conn,$sql);
$countRow=  db_totalRow($conn,$sql);
if($countRow==0)
{echo "<div align='center'><strong>No Record Found</strong> </div><br/>";}   
/* Setup page vars for display. */
?>
<form id="form" name="myform" style="border: 0px solid red;" method="post">
  <table id="example1" class="table table-fixedheader table-bordered table-striped" style="width: 100%;">
    <thead>
        <tr>
            <th>Ticket No</th>
            <th>Type</th>
            <th>Subject</th>
            <th>UserName</th>
            <th>UserEmail</th>
            <th title="message">Message</th>
            <th>Status</th>
            <th>Request Date</th>
            <th>Action</th>
        </tr>
 </thead>
<tbody>
<?php
$count=1;
foreach($que as $fetch)
{
     $tic_id=$fetch['tic_id'];  $ticket_number=$fetch['ticket_number']; $ticket_tag=$fetch['ticket_tag']; 
     $ticket_sub=$fetch['ticket_sub']; $ticket_msg=$fetch['ticket_msg'];  $userid=$fetch['userid'];
     $ticket_status=$fetch['ticket_status']; $created_at=$fetch['created_at']; 
     $userName=$fetch['user_id']; $userEmail=$fetch['uemail'];
     if($ticket_tag=='s'){ $ttad='Support'; }
     if($ticket_tag=='b'){ $ttad='Business'; }
     if($ticket_tag=='f'){ $ttad='Feedback'; }
     if($ticket_status=='pending'){ $tStatus='label-danger'; }
     if($ticket_status=='inprocess'){ $tStatus='label-warning'; }
     if($ticket_status=='close'){ $tStatus='label-success'; }
 ?> 
<tr id="ticketdel<?php echo $tic_id; ?>">
<td><?php echo $ticket_number; ?></td>
<td><?php echo $ttad; ?></td>
<td><?php echo $ticket_sub; ?></td>
<td><?php echo $userName; ?></td>
<td><?php echo $userEmail; ?></td>
<td title="<?php echo $ticket_msg; ?>" style="word-break: break-all;max-width:270px;"><?php echo $ticket_msg; //wordwrap($ticket_msg,10, "\n", true); ?></td>
<td><?php //echo $ticket_status; ?>
<span  class="label <?php echo $tStatus; ?> label-white middle"><?php echo  $ticket_status; ?></span> </td>
<td><?php echo $created_at; ?></td>
<td> 
<?php if(in_array(2, $UserRight)){ ?>
    <select class="form-control" id="process_status" onchange="updateStatus(this.value,'<?php echo $tic_id; ?>','<?php echo $page; ?>','<?php echo $pagelimit; ?>','<?php echo $searchKeword; ?>');">
      <option value="pending" <?php echo $ticket_status=='pending'?'selected':'';  ?>>Pending</option>
      <option value="inprocess" <?php echo $ticket_status=='inprocess'?'selected':'';  ?>>Inprocess</option>
      <option value="close" <?php echo $ticket_status=='close'?'selected':'';  ?>>Close</option>
  </select>  
<?php } ?>
</td> 
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
    $adjacent=3; $targetpage=''; $fromdate=''; $todate=''; $pageUrl='ticket_paging.php'; $filtervalue='';
    echo pagination($page,$limit,$total_pages,$adjacent,$targetpage,$searchKeword,$fromdate,$todate,$pageUrl,$filtervalue);
    ?>
    </div> 
</div>

<script src="js/commonFunctionJS.js" type="text/javascript"></script>
<script type="text/javascript">
function updateStatus(selectStatusVal,tid,page,pagelimit,searchkeyword)    
{
       var c=confirm("Are you sure want to update Status ?");
       if(c==true){
       $('#load').show();
       $('#results').css("opacity",0.1);  
       var info = 'action=changeStatus&statusVal='+selectStatusVal+'&ticid='+tid+'&pageNum='+page+'&limitval='+pagelimit+'&searchInputall='+searchkeyword; 
       $.ajax({
                url:'ticket_paging.php',
                method: 'POST',
                data:info,
                    success: function(result){
                         $("#results").html('');
                         $("#results").html(result);
                         $('#load').hide();
                         $('#results').css("opacity",1);
                     }
            });
        }
        else{ alert("No action taken"); }
            
}
</script>