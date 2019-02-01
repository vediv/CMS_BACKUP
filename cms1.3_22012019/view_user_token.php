<?php
include_once 'corefunction.php';
$commanmsg = isset($_GET['val']) ? $_GET['val'] : '';
if($commanmsg=="Expired")
{ $msgcall="Tag Expired Successfully";  }
if($commanmsg=="Active")
{ $msgcall="Tag Active Successfully";  }

$page =(isset($_REQUEST['page']))? $_REQUEST['page']: 0;
$searchInput =(isset($_REQUEST['searchInput']))? $_REQUEST['searchInput']: '';
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title><?php echo PROJECT_TITLE." - View Token History";?></title>
<link href="bootstrap/css/pagingCss.css" rel="stylesheet" type="text/css" />
  </head>
  <body class="skin-blue">
    <div class="wrapper">
   <?php include_once 'header.php';?>
           <!-- Left side column. contains the logo and sidebar -->
      <?php include_once 'lsidebar.php';?>
      
      
      <?php
// this following code for active and deactive
$uID = isset($_GET['uID']) ? $_GET['uID'] : '';
$tokenStatus= isset($_GET['tokenStatus']) ? $_GET['tokenStatus'] : '';
$tokenStatusU= ($tokenStatus==0) ? 1 : '0';
$upactive="update userinfo set expiry='$tokenStatusU' where uuid=$uID ";
$ractive=db_query($conn,$upactive);
if($ractive){
$sucess_msg= ($tokenStatus==0) ? "Active" : "Expired";  
?>
 <?php header("location:view_user_token.php?val=$sucess_msg");
}
 ?>
      
      <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
 <section class="content-header">
            <h1>
             View User Token Information
            </h1>
          <ol class="breadcrumb">
            <li><a href="dashbord.php"><i class="fa fa-home" title="Home"></i> Home</a></li>
                      <li class="active">User Token Info</li>
          </ol>
        </section>
        <!-- Main content -->
        <section class="content">
          <div class="row">
          <div class="col-xs-12">
          <div class="box">
          <div class="box-header">
          <div class="col-sm-12" style="border: 0px solid red;">
  	 <div class="pull-left">
				  	<form class="navbar-form" role="search" method="get">
				    <div class="input-group add-on">
				     <input class="form-control" title="Search Entries by songid  or Song title or Tag or Username" size="40" placeholder="Search Users Details"  
				     autocomplete="off" name='searchInput' id='searchInput' class="searchInput" type="text" value="<?php echo htmlentities($searchInput); ?>">
				  <div class="input-group-btn">
				        <!--<button class="enableOnInput btn btn-default" disabled='disabled' type="button" id="searchall">-->
				        <button type="submit" class="enableOnInput btn btn-default" id='submitBtn'><i class="glyphicon glyphicon-search"></i></button>	
				        </button>
				  </div>
   				    </div>
				  </form>
				  </div>
  	
  </div>
          </div><!-- /.box-header -->
      
            
          
          
     <div class="box">
 <!-- /.box-header -->
           <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                      <tr>
                           <!--<th>S.No</th>-->
                           <th>User-Name</th>
                           <th>IP</th>
                           <!--<th>User ID</th>-->
                           <th>Token</th>
                           <th>Device</th>
                           <th>Country</th>
                           <th>City</th>
                           <!--<th>Device Model</th>-->
                           <th>Registered Time</th>
                           <th>Last Updated Time</th>
                           <th>Status</th>
					   </tr>
			  </thead>
          <tbody>
<?php
$searchQuery=''; $searchURL=''; 
if(!empty($searchInput))
{  $searchInput;  
   $searchQuery=" Where ur.uname LIKE '%$searchInput%' OR uf.uuid LIKE '$searchInput' or uf.device_model LIKE '$searchInput%' or uf.country_code LIKE '$searchInput%' 
   or uf.city LIKE '$searchInput%' or uf.ip LIKE '$searchInput%' or uf.token LIKE '$searchInput%' or uf.device LIKE '$searchInput%'";
   $searchURL="&searchInput=$searchInput";
}
$adjacents = 3;
$targetpage="view_user_token.php";
$query = "SELECT COUNT(*) AS num FROM userinfo as uf LEFT JOIN user_registration AS ur ON uf.userid=ur.uid $searchQuery";
	$totalpages =db_select($conn,$query);
	$total_pages = $totalpages[0]['num'];
	$limit = 10; 
	if($page) 
		$start = ($page - 1) * $limit; //first item to display on this page
	else
		$start = 0;

$sql="SELECT uf.*,ur.uname FROM userinfo AS uf LEFT JOIN user_registration AS ur ON uf.userid=ur.uid $searchQuery order by ur.uid DESC LIMIT $start, $limit  ";		
$result =db_query($conn,$sql);	

/* Setup page vars for display. */
	if ($page == 0) $page = 1;					//if no page var is given, default to 1.
	$prev = $page - 1;							//previous page is page - 1
	$next = $page + 1;							//next page is page + 1
	$lastpage = ceil($total_pages/$limit);		//lastpage is = total pages / items per page, rounded up.
	$lpm1 = $lastpage - 1;					
	$pagination = "";
	if($lastpage > 1)
	{	
		$pagination .= "<div class=\"pagination\">"; 
		//previous button
		if ($page > 1) 
			$pagination.= "<a href=\"$targetpage?page=$prev$searchURL\">Previous</a>";
			
		else
			$pagination.= "<span class=\"disabled\"> Previous</span>";	
		//pages	
		if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				?>
			<?php 	if ($counter == $page)
					$pagination.= "<span class=\"current\">$counter</span>";
				else
					$pagination.= "<a href=\"$targetpage?page=$counter$searchURL\">$counter</a>";	
				    //$pagination.= '<a href="javascript:void(0)" onclick="changePagination(\''.$counter.'\')">'.$counter.'</a>';		
				  
			}
		}
		elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
		{
			//close to beginning; only hide later pages
			if($page < 1 + ($adjacents * 2))		
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter$searchURL\">$counter</a>";	
					 			
				}
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage?page=$lpm1$searchURL\">$lpm1</a>"; 
				
				
				$pagination.= "<a href=\"$targetpage?page=$lastpage$searchURL\">$lastpage</a>";	
				
			}
			//in middle; hide some front and some back
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				$pagination.= "<a href=\"$targetpage?page=1$searchURL\">1</a>";
					
				$pagination.= "<a href=\"$targetpage?page=2$searchURL\">2</a>";
				
				$pagination.= "...";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
					$pagination.= "<a href=\"$targetpage?page=$counter$searchURL\">$counter</a>";	
									
				}
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage?page=$lpm1$searchURL\">$lpm1</a>";
				
				$pagination.= "<a href=\"$targetpage?page=$lastpage$searchURL\">$lastpage</a>";	
					
			}
			//close to end; only hide early pages
			else
			{
				$pagination.= "<a href=\"$targetpage?page=1$searchURL\">1</a>";
				$pagination.= "<a href=\"$targetpage?page=2$searchURL\">2</a>";
				$pagination.= "...";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter$searchURL\">$counter</a>";	
										
				}
			}
		}
		
		//next button
		if ($page < $counter - 1) 
			$pagination.= "<a href=\"$targetpage?page=$next$searchURL\">Next </a>";
		   else
			$pagination.= "<span class=\"disabled\">Next </span>";
		$pagination.= "</div>\n";		
	}
	
?>                    	
<?php 
// value come from notification
$rr= db_select($sql);
//$num=db_totalRow($q);
foreach($rr as $fetch) 
   {
     $uuid=$fetch['uuid'];  $uname=$fetch['uname']; $user_token=$fetch['token']; $ip=$fetch['ip']; $userid=$fetch['userid'];
	 $device=$fetch['device_model'];  $country=$fetch['country_code']; $city=$fetch['city']; $status=$fetch['status'];
	  $tokenstatus=$fetch['expiry'];
	 $registered_time=$fetch['registered_time'];   $last_updated=$fetch['last_updated']; 
	 if($userid==0)
	 {
	 	$uname='Guest User';
	 }
	 if($tokenstatus==0)
	 {
	 	$tokenstatus1='Expired';
	 }
     else {
	         $tokenstatus1='Active';
          }
 ?>  
           <tr>
              <!--<td><?php echo $i++; ?></td>-->
              <td><?php echo $uname; ?></td>
              <td><?php echo $ip; ?></td>
              <!--<td><?php echo $uuid; ?></td>-->
              <td><?php echo $user_token; ?></td>
              <td><?php echo $device; ?></td>
              <td><?php echo $country; ?></td>
              <td><?php echo $city; ?></td>
              <td><?php echo $registered_time; ?></td>
              <!--<td> <a onclick="PopupCenterN('user_history_view_entry.php?user_id=<?php echo $userid;?> &pageindex=<?php echo $page;?>', 'User View Entries','750px','550px');" title="Load" class="button"> 
              View Entries</a></td>-->
              <td><?php echo $last_updated; ?></td>
             <td> <a href="view_user_token.php?uID=<?php echo $uuid;?>&tokenStatus=<?php echo $tokenstatus; ?>" class="sta" title="<?php echo ($tokenstatus == 1) ? 'Active':'Expired';?>">
             <i class="status-icon fa <?php echo ($tokenstatus == 1) ? 'fa-check-square-o':'fa-ban';?>"></i> <?php echo $tokenstatus1; ?></a> </td> 
            
          </tr>
<?php } ?>  
 </tbody>                  
</table>         
 </div>
 <div style="border: 0px solid red;margin-top: 5px; min-height: 40px;">
    <div style="border: 0px solid red; float: left; margin-top: 10px; margin-left: 10px;">
<?php if($start==0) { $startShow=1; 
       $lmt=$limit<$total_pages ? $limit  :$total_pages;
       }
      else { $startShow=$start+1;  $lmt=$start+$countRow;  }
 ?>
Showing <?php echo $startShow; ?>  to <?php echo $lmt; ?>   of <?php echo $total_pages; ?> entries</strong></div>   
    <div style="border: 0px solid red; float: right;"><?php echo $pagination;?></div>   
</div>       <!-- /.box-body -->
              </div><!-- /.box -->  
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content --> 
      </div><!-- /.content-wrapper -->
       <?php include_once"footer.php"; ?>
    </div><!-- ./wrapper -->
<script type="text/javascript">
bootbox.alert("<?php echo $msgcall;?>", function() {
 window.location.href='view_user_token.php';
});
</script> 
</body>
</html>
