<?php
include_once 'corefunction.php';
include_once("function.php");
$action = (isset($_POST['action'])) ? $_POST['action']: "";
switch($action)
{
     case "saveAddSubcodes":
     $subcode_name=$_POST['subcode_name']; $subcode_code=trim($_POST['subcode_code']); $type=$_POST['type'];
     //$duration=$_POST['duration'];
     $planid=$_POST['planid'];
     $date_start=$_POST['date_start']; $date_end=$_POST['date_end'];  
     $qry="select code from subscription_code where code='$subcode_code'"; 
     $total_row= db_totalRow($conn,$qry);
     if($total_row==1)
     {
        echo 1; die(); 
     } 
     $insertQry="insert into subscription_code(name,code,uses_customer,date_start,date_end,status,created_at,planid)
     values('$subcode_name','$subcode_code','0','$date_start','$date_end','0',NOW(),'$planid')";
     $ins= db_query($conn,$insertQry);
     if($ins)
        {
          /*----------------------------update log file begin-------------------------------------------*/
         $error_level=1;$msg="Add New Subscription Code ($subcode_code)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
         $qry='';
         write_log($error_level,$msg,$lusername,$qry);
         /*----------------------------update log file End---------------------------------------------*/   
        }
     else 
        {
            /*----------------------------update log file begin-------------------------------------------*/
           $error_level=5;$msg="Add New Subscription Code ($subcode_code)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
           $qry=$insertQry;
           write_log($error_level,$msg,$lusername,$qry);
           /*----------------------------update log file End---------------------------------------------*/ 
      }
     break; 
     case "saveEditSubCodes":
      $subc_id=$_POST['subcid']; $subcode_name=$_POST['subcode_name']; $subcode_code=trim($_POST['subcode_code']); 
      //$duration_type=$_POST['type'];
      $planid=$_POST['planid']; //$duration=$_POST['duration']; 
      $date_start=$_POST['date_start']; $date_end=$_POST['date_end']; 
      $qry="select subcid from subscription_code where code='$subcode_code'"; 
      $get= db_select($conn,$qry);
      $subcid=$get[0]['subcid'];
      if($subcid!=''){
        if($subcid!=$subc_id){ echo 1; exit; }
      }
      $upData="update subscription_code set name='$subcode_name',code='$subcode_code',date_start='$date_start',
      date_end='$date_end',updated_at=NOW(),planid='$planid' where subcid='".$subc_id."'";
      $upq=db_query($conn, $upData);
       if($upq)
             {
               /*----------------------------update log file begin-------------------------------------------*/
              $error_level=1;$msg="Update Subscription Code ($subc_id)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
              $qry='';
              write_log($error_level,$msg,$lusername,$qry);
              /*----------------------------update log file End---------------------------------------------*/   
             }
            else 
             {
                 /*----------------------------update log file begin-------------------------------------------*/
                $error_level=5;$msg="Update Subscription Code ($subc_id)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
                $qry=$upData;
                write_log($error_level,$msg,$lusername,$qry);
                /*----------------------------update log file End---------------------------------------------*/ 
           }
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
    <td width="15%">
    <select id="pagelmt"  style="width:60px;" onchange="selpagelimit('pagelmt','sub_paging.php','load');" >
        <option value="10"  <?php echo $pagelimit==10? "selected":""; ?> >10</option>
        <option value="20"  <?php echo $pagelimit==20? "selected":""; ?> >20</option>
         <option value="50"  <?php echo $pagelimit==50? "selected":""; ?> >50</option>
        <option value="100" <?php echo $pagelimit==100? "selected":""; ?> >100</option>
        <option value="200" <?php echo $pagelimit==200? "selected":""; ?> >200</option>
        <option value="500" <?php echo $pagelimit==500? "selected":""; ?> >500</option>
        </select> Records Per Page
    </td>
    <!--<td width="15%"><input type="button"  class="btn-primary btn-xs" value="Set Priority" onclick="setPriority();" ></td>-->
    <td width="60%">
         <div class="col-sm-3 col-md-3 pull-right navbar-form" role="search">  
            <div class="input-group add-on" style="float: right;">
            <input id='pagelimit' type="hidden" height="30px"  value="<?php echo $pagelimit; ?>">   
            <input class="form-control" size="30" onkeyup="SeachDataTable('sub_paging.php','<?php echo $pagelimit;?>','<?php //echo $page; ?>','load')"  placeholder="Search by name,code"  autocomplete="off" name='searchQuery' id='searchInput' class="searchInput" type="text" value="<?php echo $searchKeword; ?>">
            <div class="input-group-btn">
              <button class="enableOnInput btn btn-default" disabled='disabled' onclick="SearchDataTableValue('sub_paging.php','<?php echo $pagelimit;?>','<?php //echo $page; ?>','load')" id='submitBtn' type="button" style="height: 30px;   padding: 4px 6px !important;"><i class="glyphicon glyphicon-search"></i></button>	
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
    $query_search = " and (name LIKE '%". $searchKeword . "%' or code LIKE '%" . $searchKeword . "%')";
}    
    $query = "SELECT COUNT(subcid) as num FROM subscription_code where status!='3'  $query_search ";
    $totalpages =db_select($conn,$query);
    $total_pages = $totalpages[0]['num'];
    $limit = $pagelimit; 
    if($page) 
            $start = ($page - 1) * $limit; 			//first item to display on this page
    else
            $start = 0;
$sql="Select * from subscription_code where status!='3' $query_search order by created_at DESC LIMIT $start, $limit";
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
         <th>Name</th><th>Code</th><th>Duration</th><th>Date Start</th>
         <th>Date End</th><th>Used By Customer</th><th>Status</th>
         <th>Action</th>
       </tr> 
 </thead>
<tbody>
<?php
$count=1;
foreach($que as $fetch)
{
    $subcid=$fetch['subcid']; $name=$fetch['name']; $code=$fetch['code']; $duration=$fetch['duration']; 
    $duration_type=$fetch['duration_type']; $date_start=$fetch['date_start'];$date_end=$fetch['date_end'];
    $uses_customer=$fetch['uses_customer'];$cstatus=$fetch['status']; $planid=$fetch['planid'];
    $created_at=$fetch['created_at'];
    $status=$cstatus==1? "<span class='label label-success'>active</span>": "<span class='label label-danger'>inactive</span>";
    $used=$uses_customer==1? "<span class='label label-success'>used</span>": "<span class='label label-danger'>not used</span>";
    $sqlp="SELECT pduration FROM plandetail where planID='$planid'";
    $FetchData=  db_select($conn, $sqlp);
    $pduration=$FetchData[0]['pduration'];
?> 
<tr id="subCodedel<?php echo $subcid; ?>">
<td><?php echo $name; ?></td>
<td><?php echo $code; ?></td>
<td><?php echo $pduration." month"; ?></td>
<td><?php echo $date_start; ?></td>
<td><?php echo $date_end; ?></td>
<td><?php echo $used; ?></td>
<td id="getstatus<?php  echo $subcid; ?>"><?php echo $status;?></td>
<td> 
<input type="hidden" size="2" id="act_deact_status<?php echo $subcid;  ?>" value="<?php echo $cstatus; ?>" >    
<?php  if(in_array(4, $UserRight)){ ?>       
 <a href="javascript:void(0)"  class="delete" title="Delete" onclick="subcodeDelete('<?php echo $subcid; ?>')"><span class="glyphicon glyphicon-trash"></span></a> &nbsp;&nbsp;&nbsp;
 <?php }  if(in_array(2, $UserRight)){ ?>
 <a href="javascript:void(0)" class="myBtnn" onclick="editSubcode('<?php echo $subcid; ?>','<?php echo $page; ?>','<?php echo $pagelimit; ?>')"  title="Edit" class="result"><span class="glyphicon glyphicon-edit"></span></a>&nbsp;&nbsp;&nbsp;
 <a href="javascript:void(0)">
  <i id="icon_status<?php echo $subcid; ?>" class="status-icon fa <?php  echo ($cstatus == 1) ? 'fa-check-square-o':'fa-ban';?>" onclick="act_dect_subcode('<?php echo $subcid; ?>')" ></i>
</a>  
<?php } ?>
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
    $adjacent=3; $targetpage=''; $fromdate=''; $todate=''; $pageUrl='sub_paging.php'; $filtervalue='';
    echo pagination($page,$limit,$total_pages,$adjacent,$targetpage,$searchKeword,$fromdate,$todate,$pageUrl,$filtervalue);
    ?>
    </div> 
</div>
<script src="js/commonFunctionJS.js" type="text/javascript"></script>
<script type="text/javascript">
function add_new_subCode()    
{
     $("#myModal_add_new_subCode").modal();
      $("#flash").fadeIn(500).html('Loading <img src="img/image_process.gif" />');
      var info = 'action=add_new_subCode'; 
        $.ajax({
	    type: "POST",
	    url: "subModal.php",
	    data: info,
             success: function(result){
             $("#flash").hide();
             $('#view_modal_new_subCode').html(result);
            return false;
        }
 
        });
     return false;    
}
function editSubcode(subcid,pageindex,limitval)    
{
     $("#LegalModal_modal_editsubCode").modal();
      $("#flash").fadeIn(500).html('Loading <img src="img/image_process.gif" />');
      var info = 'action=editsubCode&subcid='+subcid+"&pageindex="+pageindex+"&limitval="+limitval; 
        $.ajax({
	    type: "POST",
	    url: "subModal.php",
	    data: info,
             success: function(result){
            $("#flash").hide();
             $('#edit_modal_editsubCode').html(result);
            return false;
        }
 
        });
     return false;  
}

</script>