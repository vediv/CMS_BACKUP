<?php
include_once 'auths.php'; 
include_once 'auth.php'; 
include_once 'function.inc.php';
include_once("function.php");
$conn=db_connect(DASHBOARD_USER_ID,PUBLISHER_UNIQUE_ID);
/*$get_user_id=DASHBOARD_USER_ID; $publisher_unique_id=PUBLISHER_UNIQUE_ID;$login_access_level=ACCESS_LEVEL;
$partnerID=PARTNER_ID; $serviceURL=SERVICEURL;*/
//echo $code;
switch($code)
{
    case"15dayactive":
    $query_search='';
    if($filter_user!='') // this $filter_user come from report page
    {
         $query_search = " and 
         (uh.userid LIKE '%". $filter_user . "%'
         or ur.uemail LIKE '%" . $filter_user . "%'
         or ur.user_id LIKE '%" . $filter_user . "%'
         or date(uh.last_view) LIKE '%" . $filter_user . "%'
         )";
    }    
        
    $query = "select uh.userid from userhistory uh LEFT JOIN user_registration ur on uh.userid=ur.uid where date(uh.last_view) 
            between (DATE_SUB(CURDATE(), interval 14 day)) and CURDATE()   $query_search  group by uh.userid order by uh.last_view desc";
    $total_pages =  db_totalRow($conn,$query);
    $limit = $pagelimit; 
    if($page) 
            $start = ($page - 1) * $limit; 			//first item to display on this page
    else
            $start = 0;
    $sql="Select uh.userid,uh.last_view,ur.user_id,ur.uemail from userhistory uh LEFT JOIN user_registration ur on uh.userid=ur.uid
    where date(uh.last_view) 
    between (DATE_SUB(CURDATE(), interval 14 day)) and CURDATE() $query_search group by uh.userid order by uh.last_view desc
    LIMIT $start, $limit";

    //$sql="select * from userhistory where date(last_view) 
        //  between (DATE_SUB(CURDATE(), interval 14 day)) and CURDATE() group by userid order by last_view desc
      //  LIMIT $start, $limit";
    $que = db_select($conn,$sql);
    $countRow=  db_totalRow($conn,$sql);
    if($countRow==0)
    {echo "<div align='center'><strong>No Record Found</strong> </div><br/>";}
   ?>
    <table id="example1" class="table table-fixedheader table-bordered table-striped" style="width: 100%;">
    <thead>
        <tr>
          <th>User ID</th>
          <th>User Name</th>
          <th>User Email</th>
          <th>Last View</th>
       </tr> 
 </thead>
    <tbody>
    <?php
    $count=1;
    foreach($que as $fetch)
    {
        $userid=$fetch['userid']; $uemail=$fetch['uemail'];
        $user_id=$fetch['user_id']; $last_view =$fetch['last_view'];
     ?> 
    <tr>
    <td><?php echo $userid; ?></td>
     <td><?php echo $user_id; ?></td>
      <td><?php echo $uemail; ?></td>
    <td><?php echo $last_view; ?></td>
    
    </tr>       

    <?php $count++; } ?>         
    </tbody>
    </table>
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
    $adjacent=3; $targetpage="report.php?code=$code"; $fromdate=''; $todate=''; 
    echo pagination_url($page,$limit,$total_pages,$adjacent,$targetpage,$filter_user,$fromdate,$todate);
    ?>
    </div> 
</div>

   <?php   
   break;    
   case "15dayinactive":
   $query_search='';
    if($filter_user!='') // this $filter_user come from report page
    {
         $query_search = " and 
         (uh.userid LIKE '%". $filter_user . "%'
         or ur.uemail LIKE '%" . $filter_user . "%'
         or ur.user_id LIKE '%" . $filter_user . "%'
         or date(uh.last_view) LIKE '%" . $filter_user . "%'
         )";
    }    
    $query = "select uh.userid from userhistory uh LEFT JOIN user_registration ur on uh.userid=ur.uid where date(uh.last_view) 
            not between (DATE_SUB(CURDATE(), interval 14 day)) and CURDATE()   $query_search  group by uh.userid order by uh.last_view desc";
    $total_pages =  db_totalRow($conn,$query);
    $limit = $pagelimit; 
    if($page) 
            $start = ($page - 1) * $limit; 			//first item to display on this page
    else
            $start = 0;
    $sql="Select uh.userid,uh.last_view,ur.user_id,ur.uemail from userhistory uh LEFT JOIN user_registration ur on uh.userid=ur.uid
    where date(uh.last_view) 
    not between (DATE_SUB(CURDATE(), interval 14 day)) and CURDATE() $query_search group by uh.userid order by uh.last_view desc
    LIMIT $start, $limit";

    //$sql="select * from userhistory where date(last_view) 
        //  between (DATE_SUB(CURDATE(), interval 14 day)) and CURDATE() group by userid order by last_view desc
      //  LIMIT $start, $limit";
    $que = db_select($conn,$sql);
    $countRow=  db_totalRow($conn,$sql);
    if($countRow==0)
    {echo "<div align='center'><strong>No Record Found</strong> </div><br/>";}
   ?>
    <table id="example1" class="table table-fixedheader table-bordered table-striped" style="width: 100%;">
    <thead>
        <tr>
          <th>User ID</th>
          <th>User Name</th>
          <th>User Email</th>
          <th>Last View</th>
       </tr> 
 </thead>
    <tbody>
    <?php
    $count=1;
    foreach($que as $fetch)
    {
        $userid=$fetch['userid']; $uemail=$fetch['uemail'];
        $user_id=$fetch['user_id']; $last_view =$fetch['last_view'];
     ?> 
    <tr>
    <td><?php echo $userid; ?></td>
     <td><?php echo $user_id; ?></td>
      <td><?php echo $uemail; ?></td>
    <td><?php echo $last_view; ?></td>
    
    </tr>       

    <?php $count++; } ?>         
    </tbody>
    </table>
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
    $adjacent=3; $targetpage="report.php?code=$code"; $fromdate=''; $todate=''; 
    echo pagination_url($page,$limit,$total_pages,$adjacent,$targetpage,$filter_user,$fromdate,$todate);
    ?>
    </div> 
</div>

 <?php 
   break;    
}
?>