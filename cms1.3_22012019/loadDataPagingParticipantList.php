<?php
include_once 'corefunction.php';
include_once("function.php");
$searchKeword = (isset($_POST['searchInputall']))? $_POST['searchInputall']: "";
$page =(isset($_POST['pageNum']))? $_POST['pageNum']: 0;
$pagelimit = (isset($_POST['limitval']))? $_POST['limitval']: 20;
$action = (isset($_POST['action'])) ? $_POST['action']: "";
$filtervalue=(isset($_POST['filtervalue']))? $_POST['filtervalue']:2;
switch($action)
{
     case "save_edituserlist":
     $userid=$_POST['userid']; $name=$_POST['name']; $email=$_POST['email'];
     $dob=$_POST['dob']; $gender=$_POST['gender']; $location=$_POST['location'];
     $query3="update user_registration set uname='$name',uemail='$email',dob='$dob',ugender='$gender',
             ulocation='$location' where uid='$userid'";
     $q= db_query($conn,$query3);
     /*----------------------------update log file begin-------------------------------------------*/
          $error_level=1;$msg="Update User Detail($name)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
          $qry='';
          write_log($error_level,$msg,$lusername,$qry);
    /*----------------------------update log file End---------------------------------------------*/
     $page =(isset($_POST['pageindex']))? $_POST['pageindex']: "";
     break;
}

?>
<div class="box-header" >
    <div class="row" style="border: 0px solid red; margin: -25px 5px 10px 5px;">
    <table border='0' style="width:98%; margin-left: 0px;">
    <tr>
    <td width="50%">
    <select id="pagelmt"  style="width:60px;" onchange="selpagelimit('pagelmt','loadDataPagingParticipantList.php','load');" >
        <option value="10"  <?php echo $pagelimit==10? "selected":""; ?> >10</option>
        <option value="20"  <?php echo $pagelimit==20? "selected":""; ?> >20</option>
        <option value="50"  <?php echo $pagelimit==50? "selected":""; ?> >50</option>
        <option value="100" <?php echo $pagelimit==100? "selected":""; ?> >100</option>
        <option value="200" <?php echo $pagelimit==200? "selected":""; ?> >200</option>
        <option value="500" <?php echo $pagelimit==500? "selected":""; ?> >500</option>
        </select> Records Per Page
    </td>
    <!--<td width="20%" align="left">
        View:<select name="filterentry"  id="filterentry" onchange="filterView('<?php echo $page; ?>','<?php echo $pagelimit; ?>','<?php echo $searchKeword;?>');" style="text-transform: uppercase !important;">
        <option value="2" <?php  echo $filtervalue=='2'?"selected disabled":''; ?>>ALL</option>
        <option value="1" <?php  echo $filtervalue=='1'?"selected disabled":''; ?>>ACTIVE</option>
        <option value="0" <?php  echo $filtervalue=='0'?"selected disabled":''; ?>>INACTIVE</option>
     </select>
   </td>
   <td width="15%" align="center">
      <span class="label label-primary">ALL <span class="badge" style="color: #337ab7; background-color: #fff;padding: 0px 4px 1px 4px;"><?php echo $totalEntry; ?></span></span>
      <span class="label label-success">ACTIVE <span class="badge"  style="color: #00a65a; background-color: #fff;padding: 0px 4px 1px 4px;"><?php echo $totalActive; ?></span></span>
      <span class="label label-danger">INACTIVE <span class="badge"  style="color: #444; background-color: #fff;padding: 0px 4px 1px 4px;"><?php echo $totalInactive; ?></span></span>
  </td>-->
    <td width="40%">
        <div class="col-sm-3 col-md-3 pull-right navbar-form" role="search">
            <div class="input-group add-on" style="float: right;">
            <input id='pagelimit' type="hidden" height="30px"  value="<?php echo $pagelimit; ?>">
            <input class="form-control" size="35" onkeyup="SeachDataTable('loadDataPagingParticipantList.php','<?php echo $pagelimit;?>','<?php //echo $page; ?>','load','<?php echo $filtervalue; ?>')"  placeholder="Search by RegCode,Name,Mobile,location"  autocomplete="off" name='searchQuery' id='searchInput' class="searchInput" type="text" value="<?php echo $searchKeword; ?>">
            <div class="input-group-btn">
              <button class="enableOnInput btn btn-default" disabled='disabled' onclick="SearchDataTableValue('loadDataPagingParticipantList.php','<?php echo $pagelimit;?>','<?php //echo $page; ?>','load','<?php echo $filtervalue; ?>')" id='submitBtn' type="button" style="height: 30px;   padding: 4px 6px !important;"><i class="glyphicon glyphicon-search"></i></button>
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
if($searchKeword!='')
{
    $query_search = " and (dt.RegCode LIKE '%" . $searchKeword . "%' or dt.name LIKE '%" . $searchKeword . "%'or ur.ulocation LIKE '%" . $searchKeword . "%'or ur.mobile LIKE '%" . $searchKeword . "%')";
}
$query = "SELECT COUNT(dt.userid) as num FROM device_token dt left join user_registration ur on dt.userid = ur.uid  WHERE dt.status='1' $query_search ";
$totalpages =db_select($conn,$query);
$total_pages = $totalpages[0]['num'];
$limit = $pagelimit;
if($page)
        $start = ($page - 1) * $limit;
else
        $start = 0;
$sql="SELECT dt.userid,dt.name,dt.RegCode,dt.regDate,ur.mobile,ur.ulocation,ur.dob FROM
device_token dt LEFT JOIN user_registration ur ON dt.userid = ur.uid
WHERE dt.status='1' $query_search order by dt.regDate DESC  LIMIT $start, $limit";
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
            <th>Reg code</th>
            <th>Name</th>
            <th>Mobile</th>
            <!--<th>Name</th>-->
            <th>Register Date</th>
            <th>Location</th>
            <th>DOB</th>
          </tr>
</thead>
<tbody>
<?php
$count=1;
foreach($que as $fetch)
{
  $participant_id=$fetch['userid']; $name=$fetch['name']; $reg_code=$fetch['RegCode'];
  $mobile=$fetch['mobile']; $reg_date=$fetch['regDate'];$ulocation=$fetch['ulocation'];$dob=$fetch['dob'];
  $status=$u_status==1? "<span class='label label-success'>active</span>": "<span class='label label-danger'>inactive</span>";
?>
<tr id="userdel<?php echo $participant_id; ?>">
<!--<a href="javascript:void(0)" class="myBtnn" onclick="viewUserDetail('<?php echo $participant_id; ?>')"  title="View Participant Detail" class="result">
<?php echo $reg_code ;?></a>-->

<!--<td><?php echo $name ;?></td>-->
<td><?php echo $reg_code ;?></td>
<td><?php echo $name;?></td>
<td><?php echo $mobile;?></td>
<td><?php echo $reg_date; ?></td>
<td><?php echo $ulocation; ?></td>
<td><?php echo $dob; ?></td>
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
    $adjacent=3; $targetpage=''; $fromdate=''; $todate=''; $pageUrl='loadDataPagingParticipantList.php';
    echo pagination($page,$limit,$total_pages,$adjacent,$targetpage,$searchKeword,$fromdate,$todate,$pageUrl,$filtervalue);
    ?>
    </div>
</div>
<script src="js/commonFunctionJS.js" type="text/javascript"></script>
<script type="text/javascript">
function filterView(pageNum,limitval,searchtext)
{
    var filtervalue = $('#filterentry').val();
    $('#load').show();
    $('#results').css("opacity",0.1);
     var apiBody = new FormData();
     apiBody.append("filtervalue",filtervalue);
     //apiBody.append("pageindex",pageindex);
     apiBody.append("limitval",limitval);
     apiBody.append("searchInputall",searchtext);
     apiBody.append("action","filterview");
      $.ajax({
           type: "POST",
           url: "loadDataPagingParticipantList",
           data: apiBody,
           processData: false,
           contentType: false,
           cache: false,
           success: function(result){
           $("#results").html(result);
           $('#load').hide();
           $('#results').css("opacity",1);
          }
     });
}

</script>
