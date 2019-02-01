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
        
     case "save_editdashboarduser":
     $parid=$_POST['parid']; $duser=$_POST['duser']; $demail=strtolower(trim($_POST['demail'])); 
     $menuright=$_POST['menuright'];  $actionright=$_POST['actionright'];
     $other_permissions=$_POST['other_permissions'];
     $menuright=rtrim($menuright,','); $actionright=rtrim($actionright,',');
     include_once 'function.inc.publisher.php'; 
     $qryemail="select email,par_id from ott_publisher.publisher where email='$demail'"; 
     $getEmail= db_select1($qryemail);
     $par_id=$getEmail[0]['par_id'];
     if($par_id!=''){
     if($parid!=$par_id){ echo 1; exit; }
     }
     $up="update ott_publisher.publisher set name='$duser',email='$demail' where par_id='$parid'";
     $rr=db_query1($up); 
      /* insert in client DB */
     $upp="update publisher set name='$duser',email='$demail',menu_permission='$menuright',operation_permission='$actionright',other_permission='$other_permissions' where par_id='$parid' ";
     $rr=db_query($conn,$upp); 
     /*----------------------------update log file begin-------------------------------------------*/
          $error_level=1;$msg="update Dashboard user($duser)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
          $qry='';
          write_log($error_level,$msg,$lusername,$qry);
    /*----------------------------update log file End---------------------------------------------*/   
    break;    
   
}

?>
<div class="box-header" >
    <div class="row" style="border: 0px solid red; margin: -25px 5px 10px 5px;">
    <table border='0' style="width:98%; margin-left: 10px;">
    <tr>
    <td width="15%">
    <select id="pagelmt"  style="width:60px;" onchange="selpagelimit('pagelmt','dashboarduser_paging.php','load');" >
        <option value="10"  <?php echo $pagelimit==10? "selected":""; ?> >10</option>
        <option value="20"  <?php echo $pagelimit==20? "selected":""; ?> >20</option>
        <option value="50"  <?php echo $pagelimit==50? "selected":""; ?> >50</option>
        <option value="100" <?php echo $pagelimit==100? "selected":""; ?> >100</option>
        <option value="200" <?php echo $pagelimit==200? "selected":""; ?> >200</option>
        <option value="500" <?php echo $pagelimit==500? "selected":""; ?> >500</option>
        </select> Records Per Page
    </td>
  <td width="60%">
   <!--<form class="navbar-form" role="search"  style="padding: 0 !important;">-->
   <div class="col-sm-3 col-md-3 pull-right navbar-form" role="search">
       <div class="input-group add-on "  style="float: right;">  
       <input class="form-control" size="30"   onkeyup="SeachDataTable('dashboarduser_paging.php','<?php echo $pagelimit;?>','<?php //echo $page; ?>','load','')"  placeholder="Search Name,Email"  autocomplete="off" name='searchQuery' id='searchInput' class="searchInput" type="text" value="<?php echo $searchKeword; ?>">
       <div class="input-group-btn">
           <button class="enableOnInput btn btn-default" disabled='disabled' id='submitBtn' type="button" style="height: 30px;   padding: 4px 6px !important;" onclick="SearchDataTableValue('dashboarduser_paging.php','<?php echo $pagelimit;?>','<?php //echo $page; ?>','load','')"><i class="glyphicon glyphicon-search"></i></button>	
       </div>
       </div>
   </div>  
   <!--</form>-->

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
    $query_search = " and  (name LIKE '%". $searchKeword . "%' OR email LIKE '%". $searchKeword . "%')";
}    
$adjacents = 3;
$query = "SELECT COUNT(par_id) as num FROM publisher where acess_level='u'  $query_search ";
$totalpages =db_select($conn,$query);
$total_pages = $totalpages[0]['num'];
$limit = $pagelimit; 
if($page) 
        $start = ($page - 1) * $limit; 			//first item to display on this page
else
        $start = 0;
$sql="Select * from publisher  where acess_level='u'  $query_search order by  created_at DESC  LIMIT $start, $limit";
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
           <th>Name</th>
           <th>Email-Id</th>
           <th>Create Date</th>
           <th>Status</th>
           <th>Rights</th>
           <th>Action</th>
           </tr>  
 </thead>
<tbody>
<?php
$count=1;
foreach($que as $value)
{
    $par_id=$value['par_id']; $name=$value['name']; $email=$value['email']; $pstatus=$value['pstatus'];	
    $operation_permission=$value['operation_permission'];
    $omarray=explode(",", $operation_permission);
    $created_at=$value['created_at'];
    //$status1=$pstatus==1 ?"active":"inactive";	
    $status=$pstatus==1? "<span class='label label-success'>active</span>": "<span class='label label-danger'>inactive</span>";
  
 ?> 
<tr id="<?php echo $par_id; ?>">
<td><?php echo $name;  ?></td>
<td><?php echo $email;?></td>
<td><?php echo $created_at; ?></td>
<td id="getstatus<?php  echo $par_id; ?>"><?php echo $status; ?></td>
<td>
<span class='label label-<?php echo (in_array(3,$omarray) ? "success" : "danger"); ?>  ?>'><?php echo (in_array(3,$omarray) ? "View" : "View"); ?></span>
<span class='label label-<?php echo (in_array(1,$omarray) ? "success" : "danger"); ?>  ?>'><?php echo (in_array(1,$omarray) ? "Create" : "Create"); ?></span>
<span class='label label-<?php echo (in_array(2,$omarray) ? "success" : "danger"); ?>  ?>'><?php echo (in_array(2,$omarray) ? "Edit" : "Edit"); ?></span>
<span class='label label-<?php echo (in_array(4,$omarray) ? "success" : "danger"); ?>  ?>'><?php echo (in_array(4,$omarray) ? "Delete" : "Delete"); ?></span>
</td>
<td>
<input type="hidden" size="1" id="ad_status<?php echo $par_id;  ?>" value="<?php echo $pstatus;  ?>" >
<?php  if(in_array(4, $UserRight)){ ?>     
<!--<a href="javascript:void(0)" class="delete" title="Delete" onclick="cdelete('<?php echo $par_id; ?>')"><span class="glyphicon glyphicon-trash"></span></a> &nbsp;&nbsp;&nbsp;-->
<?php }  if(in_array(2, $UserRight)){ ?>
<a href="javascript:void(0)" class="myBtnn" onclick="editDashboardUserModal('<?php echo $par_id; ?>','<?php echo $page; ?>','<?php echo $pagelimit; ?>')" title="Edit" class="result"><span class="glyphicon glyphicon-edit"></span></a>&nbsp;&nbsp;&nbsp;
<a  href="javascript:void(0)">
    <i id="icon_status<?php echo $par_id; ?>" title="<?php  echo ($pstatus == 1) ? 'active':'inactive';?>"   class="status-icon fa <?php  echo ($pstatus == 1) ? 'fa-check-square-o':'fa-ban';?>" onclick=act_dect_dashboarduser('<?php echo $par_id;  ?>')></i> 
</a>
<?php } ?>
</td> 

</tr>             
<?php   } ?>
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
    $adjacent=3; $targetpage=''; $fromdate=''; $todate=''; $pageUrl='dashboarduser_paging.php'; $filtervalue='';
    echo pagination($page,$limit,$total_pages,$adjacent,$targetpage,$searchKeword,$fromdate,$todate,$pageUrl,$filtervalue);
    ?>
    </div> 
</div>    
</form> 
<script src="js/commonFunctionJS.js" type="text/javascript"></script>
<script type="text/javascript">
function addDashboardUserModal()    
{
     $("#msg").html('');
     $("#myModal_addDashboardUserModal").modal();
     //$("#flash").fadeIn(500).html('Loading <img src="img/image_process.gif" />');
      var info = 'action=addDashboardUser'; 
        $.ajax({
	    type: "POST",
	    url: "dashboardUserModal.php",
	    data: info,
             success: function(result){
             $('#view_DashboardUserModal').html(result);
            return false;
        }
 
        });
     return false;    
}
function editDashboardUserModal(parid,pageindex,limitval)    
{
      $("#msg").html('');
      $("#LegalModal_editDashboardUser").modal();
      var info = 'action=editDashboardUser&parid='+parid+"&pageindex="+pageindex+"&limitval="+limitval; 
        $.ajax({
	    type: "POST",
	    url: "dashboardUserModal.php",
	    data: info,
             success: function(result){
            // $("#flash").hide();
             $('#edit_modal_DashboardUser').html(result);
            return false;
        }
 
        });
     return false;  
}


</script>
