<?php
include_once 'corefunction.php';
include_once("function.php");
$action = (isset($_POST['action'])) ? $_POST['action']: "";

switch($action)
{
     case "save_add_coupon":
     $coupon_name=$_POST['coupon_name']; $coupon_code=trim(strtoupper($_POST['coupon_code'])); $coupon_type=$_POST['type'];
     $coupon_discount=$_POST['coupon_discount']; $date_start=$_POST['date_start']; $date_end=$_POST['date_end'];  
     $uses_customer=$_POST['uses_customer'];$uses_per_coupon=$_POST['uses_per_coupon'];
     $qry="select code from coupon where code='$coupon_code'"; 
     $total_row= db_totalRow($conn,$qry);
     if($total_row==1)
     {
        echo 1; die(); 
     } 
     $insertQry="insert into coupon(name,code,type,discount,date_start,date_end,uses_total,uses_customer,status,created_at)
     values('$coupon_name','$coupon_code','$coupon_type','$coupon_discount','$date_start','$date_end','$uses_customer','$uses_per_coupon','0',NOW())";
     $last_insert_id=last_insert_id($conn,$insertQry);
     $coupon_video=$_POST['coupon_video']; 
        if($coupon_video!='')
        {
           foreach($coupon_video as $entryid)
             {
                $insertvideo="insert into coupon_video(coupon_id,entryid) values('$last_insert_id','$entryid')";
                $ins= db_query($conn,$insertvideo);
             }
        }
       /* $coupon_category=$_POST['coupon_category'];
        if($coupon_category!='')
        {
           foreach($coupon_category as $categoryid)
           {
               $insertcat="insert into coupon_category(coupon_id,category_id) values('$last_insert_id','$categoryid')";
               $ins= db_query($conn,$insertcat);
         }
        }*/
        if($last_insert_id)
             {
               /*----------------------------update log file begin-------------------------------------------*/
              $error_level=1;$msg="Add New coupon ($coupon_code)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
              $qry='';
              write_log($error_level,$msg,$lusername,$qry);
              /*----------------------------update log file End---------------------------------------------*/   
             }
            else 
             {
                 /*----------------------------update log file begin-------------------------------------------*/
                $error_level=5;$msg="Add New coupon ($coupon_code)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
                $qry=$insertQry;
                write_log($error_level,$msg,$lusername,$qry);
                /*----------------------------update log file End---------------------------------------------*/ 
           }
        
     break; 
     case "save_edit_coupon":
      $coupon_id=$_POST['coupon_id']; $coupon_name=$_POST['coupon_name']; $coupon_code=trim(strtoupper($_POST['coupon_code'])); $coupon_type=$_POST['type'];
      $coupon_discount=$_POST['coupon_discount']; $date_start=$_POST['date_start']; $date_end=$_POST['date_end'];  
      $uses_customer=$_POST['uses_customer'];$uses_per_coupon=$_POST['uses_per_coupon'];
      $coupon_video=$_POST['coupon_video']; 
      $qry="select coupon_id from coupon where code='$coupon_code'"; 
      $get= db_select($conn,$qry);
      $couponid=$get[0]['coupon_id'];
      if($couponid!=''){
        if($couponid!=$coupon_id){ echo 1; exit; }
      }
      $upData="update coupon set name='$coupon_name',code='$coupon_code',type='$coupon_type',discount='$coupon_discount',date_start='$date_start',
      date_end='$date_end',uses_total='$uses_per_coupon',uses_customer='$uses_customer',updated_at=NOW() where coupon_id='".$coupon_id."'";
      $upq=db_query($conn, $upData);
      $qdelv="delete from coupon_video where coupon_id='".$coupon_id."'";
      db_query($conn, $qdelv);
      if($coupon_video!='')
        {
           foreach($coupon_video as $entryid)
             {
                $insertvideo="INSERT INTO coupon_video SET coupon_id = '".$coupon_id."', entryid = '".$entryid."'";
                $ins= db_query($conn,$insertvideo);
             }
        }
        /*$coupon_category=$_POST['coupon_category'];
        $qdelc="delete from coupon_category where coupon_id='".$coupon_id."'";
        db_query($conn, $qdelc);
        if($coupon_category!='')
        {
           foreach($coupon_category as $categoryid)
           {
               $insertcat="INSERT INTO coupon_category SET coupon_id = '".$coupon_id ."', category_id = '" .$categoryid ."'";
               $ins= db_query($conn,$insertcat);
         }
        }*/
        
         if($upq)
             {
               /*----------------------------update log file begin-------------------------------------------*/
              $error_level=1;$msg="Update Coupon ($coupon_id)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
              $qry=$upData;
              write_log($error_level,$msg,$lusername,$qry);
              /*----------------------------update log file End---------------------------------------------*/   
             }
            else 
             {
                 /*----------------------------update log file begin-------------------------------------------*/
                $error_level=5;$msg="Update Coupon ($coupon_id)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
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
    <select id="pagelmt"  style="width:60px;" onchange="selpagelimit('pagelmt','coupons_paging.php','load');" >
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
            <input class="form-control" size="30" onkeyup="SeachDataTable('coupons_paging.php','<?php echo $pagelimit;?>','<?php //echo $page; ?>','load')"  placeholder="Search by name,code"  autocomplete="off" name='searchQuery' id='searchInput' class="searchInput" type="text" value="<?php echo $searchKeword; ?>">
            <div class="input-group-btn">
              <button class="enableOnInput btn btn-default" disabled='disabled' onclick="SearchDataTableValue('coupons_paging.php','<?php echo $pagelimit;?>','<?php //echo $page; ?>','load')" id='submitBtn' type="button" style="height: 30px;   padding: 4px 6px !important;"><i class="glyphicon glyphicon-search"></i></button>	
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
    $query_search = " where (name LIKE '%". $searchKeword . "%' or code LIKE '%" . $searchKeword . "%')";
}    
//***** following code doing delete end ***/				

    $query = "SELECT COUNT(coupon_id) as num FROM coupon  $query_search ";
    $totalpages =db_select($conn,$query);
    $total_pages = $totalpages[0]['num'];
    $limit = $pagelimit; 
    if($page) 
            $start = ($page - 1) * $limit; 			//first item to display on this page
    else
            $start = 0;
//coupon_id,name,code,type,discount,date_start,date_end,uses_total,uses_customer,status    
$sql="Select * from coupon $query_search order by created_at DESC LIMIT $start, $limit";
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
         <th>Coupon Name</th><th>Code</th><th>Discount</th><th>Type</th><th>Date Start</th>
         <th>Date End</th><th>Uses Per Coupon</th><th>Uses Per User</th><th>Status</th>
         <th>Action</th>
       </tr> 
 </thead>
<tbody>
<?php
$count=1;
foreach($que as $fetch)
{
    $coupon_id=$fetch['coupon_id']; $name=$fetch['name']; $code=$fetch['code']; $type=$fetch['type']; 
    $discount=$fetch['discount']; $date_start=$fetch['date_start'];$date_end=$fetch['date_end'];
    $uses_total=$fetch['uses_total'];$uses_customer=$fetch['uses_customer'];$cstatus=$fetch['status'];	
    $status=$cstatus==1? "<span class='label label-success'>active</span>": "<span class='label label-danger'>inactive</span>";
    if($type=='P'){ $stype='Percentage'; }
    if($type=='F'){ $stype='Fixed Amount'; }
   
 ?> 
<tr id="coupondel<?php echo $coupon_id; ?>">
<td><?php echo $name; ?></td>
<td><?php echo $code; ?></td>
<td><?php echo $discount; ?></td>
<td><?php echo $stype; ?></td>
<td><?php echo $date_start; ?></td>
<td><?php echo $date_end; ?></td>
<td><?php echo $uses_total; ?></td>
<td><?php echo $uses_customer; ?></td>
<td id="getstatus<?php  echo $coupon_id; ?>"><?php echo $status;?></td>
<td> 
<input type="hidden" size="2" id="act_deact_status<?php echo $coupon_id;  ?>" value="<?php echo $cstatus; ?>" >    
<?php  if(in_array(4, $UserRight)){ ?>       
 <a href="javascript:void(0)"  class="delete" title="Delete" onclick="CouponDelete('<?php echo $coupon_id; ?>')"><span class="glyphicon glyphicon-trash"></span></a> &nbsp;&nbsp;&nbsp;
 <?php }  if(in_array(2, $UserRight)){ ?>
 <a href="javascript:void(0)" class="myBtnn" onclick="editCoupon('<?php echo $coupon_id; ?>','<?php echo $page; ?>','<?php echo $pagelimit; ?>')"  title="Edit" class="result"><span class="glyphicon glyphicon-edit"></span></a>&nbsp;&nbsp;&nbsp;
 <a href="javascript:void(0)">
  <i id="icon_status<?php echo $coupon_id; ?>" class="status-icon fa <?php  echo ($cstatus == 1) ? 'fa-check-square-o':'fa-ban';?>" onclick="act_dect_coupon('<?php echo  $coupon_id; ?>')" ></i>
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
    $adjacent=3; $targetpage=''; $fromdate=''; $todate=''; $pageUrl='coupons_paging.php'; $filtervalue='';
    echo pagination($page,$limit,$total_pages,$adjacent,$targetpage,$searchKeword,$fromdate,$todate,$pageUrl,$filtervalue);
    ?>
    </div> 
</div>
<script src="js/commonFunctionJS.js" type="text/javascript"></script>
<script type="text/javascript">
function add_new_coupon()    
{
     $("#myModal_add_new_coupon").modal();
      $("#flash").fadeIn(500).html('Loading <img src="img/image_process.gif" />');
      var info = 'action=add_new_coupon'; 
        $.ajax({
	    type: "POST",
	    url: "couponModal.php",
	    data: info,
             success: function(result){
             $("#flash").hide();
             $('#view_modal_new_coupon').html(result);
            return false;
        }
 
        });
     return false;    
}
function editCoupon(coupon_id,pageindex,limitval)    
{
     $("#LegalModal_modal_editCoupon").modal();
      $("#flash").fadeIn(500).html('Loading <img src="img/image_process.gif" />');
      var info = 'action=editCoupon&coupon_id='+coupon_id+"&pageindex="+pageindex+"&limitval="+limitval; 
        $.ajax({
	    type: "POST",
	    url: "couponModal.php",
	    data: info,
             success: function(result){
            $("#flash").hide();
             $('#edit_modal_editCoupon').html(result);
            return false;
        }
 
        });
     return false;  
}

</script>