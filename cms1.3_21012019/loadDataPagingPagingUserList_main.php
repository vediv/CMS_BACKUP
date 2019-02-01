<?php 
include_once 'corefunction.php';
include_once("function.php");
$searchKeword = (isset($_POST['searchInputall']))? $_POST['searchInputall']: "";
$page =(isset($_POST['pageNum']))? $_POST['pageNum']: 0;
$pagelimit = (isset($_POST['limitval']))? $_POST['limitval']: 15;
$action = (isset($_POST['action'])) ? $_POST['action']: "";
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
    <table border='0' style="width:98%; margin-left: 10px;">
    <tr>
    <td width="25%">
    <select id="pagelmt"  style="width:60px;" onchange="selpagelimit('pagelmt','loadDataPagingUserList.php','load');" >
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
            <input class="form-control" size="30" onkeyup="SeachDataTable('loadDataPagingUserList.php','<?php echo $pagelimit;?>','<?php //echo $page; ?>','load')"  placeholder="Search Entries by name,email"  autocomplete="off" name='searchQuery' id='searchInput' class="searchInput" type="text" value="<?php echo $searchKeword; ?>">
            <div class="input-group-btn">
              <button class="enableOnInput btn btn-default" disabled='disabled' onclick="SearchDataTableValue('loadDataPagingUserList.php','<?php echo $pagelimit;?>','<?php //echo $page; ?>','load')" id='submitBtn' type="button" style="height: 30px;   padding: 4px 6px !important;"><i class="glyphicon glyphicon-search"></i></button>	
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
    $query_search = " where (user_id LIKE '%" . $searchKeword . "%' or uemail LIKE '%" . $searchKeword . "%'or ulocation LIKE '%" . $searchKeword . "%'or ugender LIKE '%" . $searchKeword . "%')";
}
$reg_id_user =(isset($_POST['reg_id_user']))? $_POST['reg_id_user']: 0;
$queryUser='';
if($reg_id_user!=0)
{
    $queryUser = " where uid ='$reg_id_user'";
} 
//***** following code doing delete end ***/				
    $query = "SELECT COUNT(uid) as num FROM user_registration $query_search $queryUser";
    $totalpages =db_select($conn,$query);
    $total_pages = $totalpages[0]['num'];
    $limit = $pagelimit; 
    if($page) 
            $start = ($page - 1) * $limit; 			//first item to display on this page
    else
            $start = 0;

$sql="Select * from user_registration $query_search $queryUser order by added_date DESC  LIMIT $start, $limit";
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
                        <th>User-id</th>
                        <th>User-Name</th>
                        <!--<th>Name</th>-->
                        <th>Email</th>
                        <th>Gender</th>
                        <th>Register Date</th>
                        <th>Provider</th>
                        <th>Status</th>
			<th>Action</th>
                      </tr>
</thead>
<tbody>
<?php
$count=1;
foreach($que as $fetch)
{
  $id=$fetch['uid']; $user_id=$fetch['user_id']; $name=$fetch['uname']; $email=$fetch['uemail'];  $dob=$fetch['dob'];
  $gen=$fetch['ugender']; $loc=$fetch['ulocation']; $add_date=$fetch['added_date']; $prob=$fetch['oauth_provider']; 
  $u_status=$fetch['status'];
  $status=$u_status==1? "<span class='label label-success'>active</span>": "<span class='label label-danger'>inactive</span>";
?> 
<tr id="userdel<?php echo $id; ?>">
<td>
<a href="javascript:void(0)" class="myBtnn" onclick="viewUserDetail('<?php echo $id; ?>')"  title="View User Detail" class="result">
<?php echo $id ;?></a>
</td>    
<!--<td><?php echo $user_id ;?></td>-->
<td><?php echo $user_id;?></td>
<td><?php echo $email; ?></td>
<td><?php echo $gen; ?></td>
<td><?php echo $add_date; ?></td> 
<td><?php echo $prob; ?></td>
<td id="getstatus<?php  echo $id; ?>"><?php echo $status; ?></td>
<td> 
<input type="hidden" size="2" id="act_deact_status<?php echo $id;  ?>" value="<?php echo $u_status; ?>" >    
<?php  if(in_array(4, $UserRight)){ ?>       
 <!--<a href="javascript:void(0)"  class="delete" title="Delete" onclick="userdelete('<?php echo $id; ?>')"><span class="glyphicon glyphicon-trash"></span></a> &nbsp;&nbsp;&nbsp; -->
 <?php }  if(in_array(2, $UserRight)){ ?>
 <!--<a href="javascript:void(0)" class="myBtnn" onclick="edit_userList('<?php echo $id; ?>','<?php echo $page; ?>','<?php echo $pagelimit; ?>')" id="<?php  echo $id; ?>" title="Edit" class="result"><span class="glyphicon glyphicon-edit"></span></a>&nbsp;&nbsp;&nbsp;-->
 <a href="javascript:void(0)">
  <i id="icon_status<?php echo $id; ?>" class="status-icon fa <?php  echo ($u_status == 1) ? 'fa-check-square-o':'fa-ban';?>" onclick="act_dect_user('<?php echo  $id; ?>')" ></i>
 </a>  
<?php } ?>
&nbsp&nbsp;
  <a href="javascript:" data-target=".bs-example-modal-lg"  title="Send Email" onclick="TemplateViewInModal('<?php echo $email;  ?>','userList','emailSend');">
   <i  class="fa fa fa-envelope" ></i>
  </a>
</td> </tr>       

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
    $adjacent=3; $targetpage=''; $fromdate=''; $todate=''; $pageUrl='loadDataPagingUserList.php'; $filtervalue='';
    echo pagination($page,$limit,$total_pages,$adjacent,$targetpage,$searchKeword,$fromdate,$todate,$pageUrl,$filtervalue);
    ?>
    </div> 
</div>
<script src="js/commonFunctionJS.js" type="text/javascript"></script>
<script type="text/javascript">
function edit_userList(userid,pageindex,limitval)    
{
     $("#LegalModal_modal_edit_userList").modal();
     //$("#flash").fadeIn(500).html('Loading <img src="img/image_process.gif" />');
      var info = 'action=edit_userList&userid='+userid+"&pageindex="+pageindex+"&limitval="+limitval; 
        $.ajax({
	    type: "POST",
	    url: "userListModal.php",
	    data: info,
             success: function(result){
            // $("#flash").hide();
             $('#edit_modal_userList').html(result);
            return false;
        }
 
        });
     return false;  
}

</script>