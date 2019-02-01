<?php 
//sleep(1);
include_once 'corefunction.php';
include_once("function.php");
$searchKeword = (isset($_POST['searchInputall']))? $_POST['searchInputall']: "";
$page =(isset($_POST['pageNum']))? $_POST['pageNum']: 0; 
$pagelimit = (isset($_POST['limitval']))? $_POST['limitval']: 10;
$action = (isset($_POST['action'])) ? $_POST['action']: "";
switch($action)
{
        
     case "save_editcontentpartner":
     $parid=$_POST['parid']; $cname=$_POST['cname']; $cemail=strtolower(trim($_POST['cemail'])); 
     $cmobile=$_POST['cmobile']; $lsdate=$_POST['lsdate']; $ledate=$_POST['ledate'];
     $menuright=$_POST['menuright'];  $actionright=$_POST['actionright'];
     $other_permissions=$_POST['other_permissions'];
     $menuright=rtrim($menuright,','); $actionright=rtrim($actionright,',');
     include_once 'function.inc.publisher.php'; 
     $qryemail="select email,par_id from ott_publisher.publisher where email='$cemail'"; 
     $getEmail= db_select1($qryemail);
     $par_id=$getEmail[0]['par_id'];
     if($par_id!=''){
     if($parid!=$par_id){ echo 1; exit; }
     }
    $up="update ott_publisher.publisher set name='$cname',email='$cemail' where par_id='$parid'";
    $rr=db_query1($up); 
    /* insert in client DB */
    $upp="update publisher set name='$cname',email='$cemail',menu_permission='$menuright',operation_permission='$actionright',other_permission='$other_permissions' where par_id='$parid' ";
    $rr=db_query($conn,$upp); 
    
    $upc="update content_partner set name='$cname',email='$cemail',mobile='$cmobile',
    license_start_date='$lsdate',license_end_date='$ledate',updated_at=NOW() where par_id='$parid' ";
    $rr=db_query($conn,$upc); 
     /*----------------------------update log file begin-------------------------------------------*/
          $error_level=1;$msg="update Content Partner Detail($cname)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
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
    <select id="pagelmt"  style="width:60px;" onchange="selpagelimit('pagelmt','content_partner_paging.php','load');" >
        <option value="10"  <?php echo $pagelimit==10? "selected":""; ?> >10</option>
        <option value="20"  <?php echo $pagelimit==20? "selected":""; ?> >20</option>
         <option value="50"  <?php echo $pagelimit==50? "selected":""; ?> >50</option>
        <option value="100" <?php echo $pagelimit==100? "selected":""; ?> >100</option>
        <option value="200" <?php echo $pagelimit==200? "selected":""; ?> >200</option>
        <option value="500" <?php echo $pagelimit==500? "selected":""; ?> >500</option>
        </select> Records Per Page
    </td>
  <td width="60%">
      <div class="col-sm-3 col-md-3 pull-right navbar-form" role="search">  
            <div class="input-group add-on" style="float: right;">
            <input id='pagelimit' type="hidden" height="30px"  value="<?php echo $pagelimit; ?>">   
            <input class="form-control" size="30" onkeyup="SeachDataTable('content_partner_paging.php','<?php echo $pagelimit;?>','<?php //echo $page; ?>','load')"  placeholder="Search Entries by Name,Email"  autocomplete="off" name='searchQuery' id='searchInput' class="searchInput" type="text" value="<?php echo $searchKeword; ?>">
            <div class="input-group-btn">
              <button class="enableOnInput btn btn-default" disabled='disabled' onclick="SearchDataTableValue('content_partner_paging.php','<?php echo $pagelimit;?>','<?php //echo $page; ?>','load')" id='submitBtn' type="button" style="height: 30px;   padding: 4px 6px !important;"><i class="glyphicon glyphicon-search"></i></button>	
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
    $query_search = " where  (name LIKE '%". $searchKeword . "%' OR email LIKE '%". $searchKeword . "%' OR mobile LIKE '%". $searchKeword . "%')";
}    
//***** following code doing delete end ***/				
$adjacents = 3;
    $query = "SELECT COUNT(contentpartnerid) as num FROM content_partner $query_search ";
    $totalpages =db_select($conn,$query);
    $total_pages = $totalpages[0]['num'];
    $limit = $pagelimit; 
    if($page) 
            $start = ($page - 1) * $limit; 			//first item to display on this page
    else
            $start = 0;

$sql="Select * from content_partner  $query_search order by  contentpartnerid DESC LIMIT $start, $limit";
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
                 <th>ID</th>
                 <th>Name</th>
                 <th>Email</th>
                 <th>Mobile</th>
                 <th>Total-Video</th>
                 <th title="Total Duration">Total-Dur<br/>(HH:MM:SS)</th>
                 <th>Start-Date</th>
                 <th>End-Date</th>
                 <th>Status</th>
                 <th >Action</th>
           </tr>  
 </thead>
<tbody>
<?php
$count=1;
foreach($que as $fetch)
{
    $contentpartnerid=$fetch['contentpartnerid'];  $cname=$fetch['name']; $email=$fetch['email']; $mobile=$fetch['mobile']; 
     $created_at=$fetch['created_at']; $updated_at=$fetch['updated_at']; $pstatus=$fetch['status']; $par_id=$fetch['par_id']; 
     $license_start_date=$fetch['license_start_date'];  $license_end_date=$fetch['license_end_date'];
    // cal total duration and total video of partner
    $qtr="select sum(duration) as vlength,count(puser_id) as totalcount from entry where  puser_id='$par_id' and status='2' and type='1' ";
    $ft=  db_select($conn,$qtr);
    $vlength=convert_sec_to($ft[0]['vlength']); $totalcount=$ft[0]['totalcount'];	
 ?> 
<tr id="cpdel<?php echo $contentpartnerid; ?>">
<td><?php echo $par_id; ?></td>    
<td><?php echo ucwords($cname); ?></td>
<td><?php echo $email;?></td>
<td><?php echo $mobile;?></td>
<td><?php echo $totalcount;?></td>
<td><?php echo $vlength;?></td>
<td><?php echo $license_start_date; ?></td>
<td><?php echo $license_end_date; ?></td>
<td id="getstatus<?php  echo $contentpartnerid; ?>"><?php echo $pstatus==1?"active": "inactive"; ?></td>
<td>
<input type="hidden" size="1" id="ad_status<?php echo $contentpartnerid;  ?>" value="<?php echo $pstatus;  ?>" >
<?php  if(in_array(4, $UserRight)){ ?>     
<a href="javascript:void(0)" class="delete" title="Delete" onclick="cdelete('<?php echo $contentpartnerid; ?>')"><span class="glyphicon glyphicon-trash"></span></a> &nbsp;&nbsp;&nbsp;
<?php }  if(in_array(2, $UserRight)){ ?>
<a href="javascript:void(0)" class="myBtnn" onclick="editContentPartnerModal('<?php echo $par_id; ?>','<?php echo $page; ?>','<?php echo $pagelimit; ?>')"  id="<?php  echo $contentpartnerid; ?>"  data-target=".bs-example-modal-lg" data-toggle="modal" title="Edit" class="result"><span class="glyphicon glyphicon-edit"></span></a>&nbsp;&nbsp;&nbsp;
<a  href="javascript:void(0)">
    <i id="icon_status<?php echo $contentpartnerid; ?>"   class="status-icon fa <?php  echo ($pstatus == 1) ? 'fa-check-square-o':'fa-ban';?>" onclick=act_dect_content('<?php echo $contentpartnerid;  ?>')></i> 
</a>
<?php } ?>
</td> 
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
    $adjacent=1; $targetpage=''; $fromdate=''; $todate=''; $pageUrl='content_partner_paging.php';
    echo pagination($page,$limit,$total_pages,$adjacent,$targetpage,$searchKeword,$fromdate,$todate,$pageUrl,$filtervalue);
    ?>
    </div> 
</div>    
</form> 
<script src="js/commonFunctionJS.js" type="text/javascript"></script>
<script type="text/javascript">
function addContentPartnerModal()    
{
     $("#myModal_addContentPartnerModal").modal();
     //$("#flash").fadeIn(500).html('Loading <img src="img/image_process.gif" />');
      var info = 'action=addContentPartner'; 
        $.ajax({
	    type: "POST",
	    url: "contentPartnerModal.php",
	    data: info,
             success: function(result){
            // $("#flash").hide();
             $('#view_ContentPartnerModal').html(result);
            return false;
        }
 
        });
     return false;    
}
function editContentPartnerModal(parid,pageindex,limitval)    
{
     $("#LegalModal_editContentPartnerModal").modal();
     //$("#flash").fadeIn(500).html('Loading <img src="img/image_process.gif" />');
      var info = 'action=editContentPartner&parid='+parid+"&pageindex="+pageindex+"&limitval="+limitval; 
        $.ajax({
	    type: "POST",
	    url: "contentPartnerModal.php",
	    data: info,
             success: function(result){
            // $("#flash").hide();
             $('#edit_modal_contentpartner').html(result);
            return false;
        }
 
        });
     return false;  
}


</script>
