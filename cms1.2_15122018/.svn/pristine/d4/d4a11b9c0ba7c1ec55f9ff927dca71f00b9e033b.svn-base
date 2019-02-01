<?php
include_once 'corefunction.php';
$page =(isset($_REQUEST['page']))? $_REQUEST['page']: 0;
$searchInput =(isset($_REQUEST['searchInput']))? $_REQUEST['searchInput']: '';
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title><?php echo PROJECT_TITLE." - View Log History";?></title>
<link href="bootstrap/css/pagingCss.css" rel="stylesheet" type="text/css" />
  </head>
  <body class="skin-blue">
    <div class="wrapper">
   <?php include_once 'header.php';?>
           <!-- Left side column. contains the logo and sidebar -->
      <?php include_once 'lsidebar.php';?>
      <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
 <section class="content-header">
            <h1>
             View User History
            </h1>
          <ol class="breadcrumb">
            <li><a href="dashbord.php"><i class="fa fa-home" title="Home"></i> Home</a></li>
                      <li class="active">User History</li>
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
				     <input class="form-control" title="Search Entries by songid  or Song title or Tag or Username" size="40" placeholder="Search Entries by songid  or Song title or Tag or Username"  
				     autocomplete="off" name='searchInput' id='searchInput' class="searchInput" type="text" value="<?php echo htmlentities($searchInput); ?>">
				    
				     
				      <div class="input-group-btn">
				        <!--<button class="enableOnInput btn btn-default" disabled='disabled' type="button" id="searchall"> -->
				        <button type="submit" class="enableOnInput btn btn-default"  id='submitBtn'  ><i class="glyphicon glyphicon-search"></i></button>	
				        </button>
				  </div>
   
				    </div>
				  </form>
				  </div>
  	
  </div>
          </div><!-- /.box-header -->
         <script src="js/popup.js"></script> 
             <div class="modal fade" id="myModal" role="dialog" data-keyboard="false" data-backdrop="static">
					    <div class="modal-dialog modal-lg">
					    
					      <!-- Modal content-->
					      <div class="modal-content" id="show_detail_model_view">
					       
					      </div>
					      
					    </div>
					  </div>
          
          
          
     <div class="box">
 <!-- /.box-header -->
           <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                      <tr>
                           <!--<th>S.No</th>-->
                           <th>User-Name</th>
                           <th>Entry Ids</th>
                           <th>View-Entries</th>
                           <th>View-Date</th>
						   
                      </tr>
               </thead>
          <tbody>
<?php
$searchQuery=''; $searchURL=''; 
if(!empty($searchInput))
{  $searchInput;  
   $searchQuery=" AND ur.uname LIKE '%$searchInput%' OR uavl.entry_ids LIKE '%$searchInput%'";
   $searchURL="&searchInput=$searchInput";
}
$adjacents = 3;
$targetpage="view_log_history.php";
$query = "SELECT COUNT(*) AS num FROM user_history as uavl LEFT JOIN user_registration AS ur ON uavl.uid=ur.uid  where uavl.partner_id='$partnerID' $searchQuery";
	$totalpages =db_select($query);
	$total_pages = $totalpages[0]['num'];
	$limit = 7; 
	if($page) 
		$start = ($page - 1) * $limit; 			//first item to display on this page
	else
		$start = 0;

$sql="SELECT uavl.*,ur.uname FROM user_history AS uavl LEFT JOIN user_registration AS ur ON uavl.uid=ur.uid where uavl.partner_id='$partnerID' $searchQuery ORDER BY uavl.vid DESC LIMIT $start, $limit";		
$result = db_query($sql);	
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
					    //$pagination.= '<a href="javascript:void(0)" onclick="changePagination(\''.$counter.'\')">'.$counter.'</a>';				
				}
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage?page=$lpm1$searchURL\">$lpm1</a>"; 
				//$pagination.= '<a href="javascript:void(0)" onclick="changePagination(\''.$lpm1.'\')">'.$lpm1.'</a>';
				
				$pagination.= "<a href=\"$targetpage?page=$lastpage$searchURL\">$lastpage</a>";	
				//$pagination.= '<a href="javascript:void(0)" onclick="changePagination(\''.$lastpage.'\')">'.$lastpage.'</a>';	
			}
			//in middle; hide some front and some back
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				$pagination.= "<a href=\"$targetpage?page=1$searchURL\">1</a>";
				//$pagination.= '<a href="javascript:void(0)" onclick="changePagination(\'1\')">1</a>';	
				$pagination.= "<a href=\"$targetpage?page=2$searchURL\">2</a>";
				//$pagination.= '<a href="javascript:void(0)" onclick="changePagination(\'2\')">2</a>';
				$pagination.= "...";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
					$pagination.= "<a href=\"$targetpage?page=$counter$searchURL\">$counter</a>";	
					//$pagination.= '<a href="javascript:void(0)" onclick="changePagination(\''.$counter.'\')">'.$counter.'</a>';				
				}
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage?page=$lpm1$searchURL\">$lpm1</a>";
				//$pagination.= '<a href="javascript:void(0)" onclick="changePagination(\''.$lpm1.'\')">'.$lpm1.'</a>';
				$pagination.= "<a href=\"$targetpage?page=$lastpage$searchURL\">$lastpage</a>";	
				//$pagination.= '<a href="javascript:void(0)" onclick="changePagination(\''.$lastpage.'\')">'.$lastpage.'</a>';	
			}
			//close to end; only hide early pages
			else
			{
				$pagination.= "<a href=\"$targetpage?page=1$searchURL\">1</a>";
				//$pagination.= '<a href="javascript:void(0)" onclick="changePagination(\'1\')">1</a>';	
				$pagination.= "<a href=\"$targetpage?page=2$searchURL\">2</a>";
				//$pagination.= '<a href="javascript:void(0)" onclick="changePagination(\'2\')">2</a>';
				$pagination.= "...";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter$searchURL\">$counter</a>";	
						//$pagination.= '<a href="javascript:void(0)" onclick="changePagination(\''.$counter.'\')">'.$counter.'</a>';					
				}
			}
		}
		
		//next button
		if ($page < $counter - 1) 
			$pagination.= "<a href=\"$targetpage?page=$next$searchURL\">Next </a>";
		    //$pagination.= '<a href="javascript:void(0)" onclick="changePagination(\''.$next.'\')">Next</a>';	
		else
			$pagination.= "<span class=\"disabled\">Next </span>";
		$pagination.= "</div>\n";		
	}
?>                    	
<?php 
// value come from notification
$rr= db_select($sql);
foreach($rr as $fetch ) 
   {
     $userid=$fetch['uid'];  $uname=$fetch['uname']; $user_historyID=$fetch['vid']; $entry_ids=$fetch['entry_ids']; 
	 $viewdate=$fetch['last_view']; 
 ?>  
          <tr>
             <!-- <td><?php echo $i++; ?></td>-->
              <td><a href="#" class="myBtn" pageindex="<?php echo $page; ?>" id="<?php echo $userid; ?>"><?php echo $uname; ?></a></td>
              <td> <?php echo $entry_ids ;?></td>
              <td> <a onclick="PopupCenterN('user_history_view_entry.php?user_id=<?php echo $userid;?> &pageindex=<?php echo $page;?>', 'User View Entries','750px','550px');" title="Load" class="button"> 
                   View Entries</a></td>
              <td> <?php echo $viewdate; ?></td>
          </tr>
<?php } ?>  
 </tbody>                  
</table>         
    
 </div>
<div style="border: 0px solid red; float: right; margin-top: 5px;"><strong><?php echo ($page* $limit)." of ".$total_pages;?></strong>  <?php echo $pagination;?></div> 
 </div>             
    <!-- /.box-body -->
 </div><!-- /.box -->  
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      <?php
       include_once"footer.php";
      ?>
    </div><!-- ./wrapper -->
<script src="js/jquery.blockUI.js"></script>

 <script type="text/javascript">
/* this is for model JS with edit and view detail */
$(document).ready(function(){
	
    $(".myBtn").click(function(){
        $("#myModal").modal();
		var element = $(this);
		var user_id = element.attr("id");
		var EntryPageindex = element.attr("pageindex");
	    var info = 'user_id=' + user_id+"&pageindex="+EntryPageindex; 
       // alert(info);
        $.ajax({
	    type: "POST",
	    url: "user_details_history.php",
	    data: info,
        success: function(result){
        $('#show_detail_model_view').html(result);
        return false;
        }
 
        });
     return false;    
    });
 
});
</script>
  </body>
</html>
