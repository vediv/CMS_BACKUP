<?php
include_once 'corefunction.php';
include_once("function.php");
$action = (isset($_POST['action'])) ? $_POST['action']: "";
switch($action)
{
     case "save_add_offer":
     $offer_name=$_POST['offer_name']; $offer_code=trim(strtoupper($_POST['offer_code'])); $offer_type=$_POST['input-type'];
     $offer_discount=$_POST['offer_discount']; $date_start=$_POST['date_start']; $date_end=$_POST['date_end'];  
     $uses_customer=$_POST['uses_customer'];$uses_per_offer=$_POST['uses_per_offer']; $img_urls=$_POST['img_urls'];
     $msg=$_POST['msg'];
     $currency=($_POST['currency']); $price=($_POST['price']);
     $customCurrencyInsert='';
     if(!empty($currency) && !empty($price))
     {
        $currency_price_Val=array_combine($currency,$price);
        $customCurrencyInsert= json_encode($currency_price_Val);
     } 
     $qry="select code from offers where code='$offer_code'"; 
     $total_row= db_totalRow($conn,$qry);
     if($total_row==1)
     {
        echo 1; die(); 
     } 
     $insertQry="insert into offers(offer_name,code,type,msg,uses_total,
     uses_customer,status,currency,date_start,date_end,img_url,created_at)
     values('$offer_name','$offer_code','$offer_type','$msg','$uses_per_offer','$uses_customer',0,'$customCurrencyInsert','$date_start','$date_end','$img_urls',NOW())";
     $in=db_query($conn,$insertQry);
     if($in)
             {
               /*----------------------------update log file begin-------------------------------------------*/
              $error_level=1;$msg="Add New Offer ($offer_code)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
              $qry='';
              write_log($error_level,$msg,$lusername,$qry);
              /*----------------------------update log file End---------------------------------------------*/   
             }
            else 
             {
                 /*----------------------------update log file begin-------------------------------------------*/
                $error_level=5;$msg="Add New Offer ($offer_code)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
                $qry=$insertQry;
                write_log($error_level,$msg,$lusername,$qry);
                /*----------------------------update log file End---------------------------------------------*/ 
           }
     break; 
     case "save_edit_offer":
     $offer_id=$_POST['offer_id']; $offer_name=$_POST['offer_name']; $offer_code=trim(strtoupper($_POST['offer_code'])); 
     $offer_type=$_POST['input-type'];  $msg=$_POST['msg'];
     $offer_discount=$_POST['offer_discount']; $date_start=$_POST['date_start']; $date_end=$_POST['date_end'];  
     $uses_customer=$_POST['uses_customer'];$uses_per_offer=$_POST['uses_per_offer']; $img_urls=$_POST['img_urls'];
     $currency=$_POST['currency']; $price=$_POST['price'];
     $qry="select offer_id from offers where code='$offer_code'"; 
     $get= db_select($conn,$qry);
     $offerid=$get[0]['offer_id'];
     if($offerid!=''){
        if($offerid!=$offer_id){ echo 1; exit; }
      }
     $customCurrencyUpdate='';
     if(!empty($currency) && !empty($price))
     {
        $currency_price_Val=array_combine($currency,$price);
        $customCurrencyUpdate= json_encode($currency_price_Val);
     }  
      $upData="update offers set offer_name='$offer_name',code='$offer_code',type='$offer_type',msg='$msg',date_start='$date_start',
      date_end='$date_end',uses_total='$uses_per_offer',uses_customer='$uses_customer',currency='$customCurrencyUpdate',img_url='$img_urls',updated_at=NOW() where offer_id='".$offer_id."'";
      $upq=db_query($conn, $upData);
       if($upq)
             {
               /*----------------------------update log file begin-------------------------------------------*/
              $error_level=1;$msg="Update Offer ($offer_id)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
              $qry=$upData;
              write_log($error_level,$msg,$lusername,$qry);
              /*----------------------------update log file End---------------------------------------------*/   
             }
            else 
             {
                 /*----------------------------update log file begin-------------------------------------------*/
                $error_level=5;$msg="Update Offer ($offer_id)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
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
    <select id="pagelmt"  style="width:60px;" onchange="selpagelimit('pagelmt','offers_paging.php','load');" >
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
        <input class="form-control" size="30" onkeyup="SeachDataTable('offers_paging.php','<?php echo $pagelimit;?>','<?php //echo $page; ?>','load')"  placeholder="Search By Name,Code"  autocomplete="off" name='searchQuery' id='searchInput' class="searchInput" type="text" value="<?php echo $searchKeword; ?>">
        <div class="input-group-btn">
        <button class="enableOnInput btn btn-default" onclick="SearchDataTableValue('offers_paging.php','<?php echo $pagelimit;?>','<?php //echo $page; ?>','load')" disabled='disabled' id='submitBtn' type="button" style="height: 30px;   padding: 4px 6px !important;" ><i class="glyphicon glyphicon-search"></i></button>	
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
    $query_search = " and (offer_name LIKE '%". $searchKeword . "%' or code LIKE '%" . $searchKeword . "%')";
}    
//***** following code doing delete end ***/				

    $query = "SELECT COUNT(offer_id) as num FROM offers where status!='3'  $query_search ";
    $totalpages =db_select($conn,$query);
    $total_pages = $totalpages[0]['num'];
    $limit = $pagelimit; 
    if($page) 
            $start = ($page - 1) * $limit; 			//first item to display on this page
    else
            $start = 0;
//coupon_id,name,code,type,discount,date_start,date_end,uses_total,uses_customer,status    
$sql="Select * from offers where status!='3' $query_search order by created_at DESC LIMIT $start, $limit";
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
         <th>Image</th><th>Name</th><th>Code</th><th>Currency/Discount</th><th>Type</th><th>Date Start</th>
         <th>Date End</th><th>Per Coupon</th><th>Per User</th><th>Status</th>
         <th>Action</th>
       </tr> 
 </thead>
<tbody>
<?php
$count=1;
foreach($que as $fetch)
{
    $offer_id=$fetch['offer_id']; $name=$fetch['offer_name']; $code=$fetch['code']; $type=$fetch['type']; 
    $discount=$fetch['discount']; $date_start=$fetch['date_start'];$date_end=$fetch['date_end'];
    $msg=$fetch['msg']; $img_url=$fetch['img_url'];
    $uses_total=$fetch['uses_total'];$uses_customer=$fetch['uses_customer'];$cstatus=$fetch['status'];	
    $status=$cstatus==1? "<span class='label label-success'>active</span>": "<span class='label label-danger'>inactive</span>";
    if($type=='P'){ $stype='Percentage'; }
    if($type=='F'){ $stype='Fixed Amount'; }
    $currency=$fetch['currency'];
    $json_customdataCurrency  = json_decode($currency, true);
    $img=$img_url!=''?$img_url:'img/notavailable.jpg';
   
 ?> 
<tr id="coupondel<?php echo $offer_id; ?>">
<td width="100" >
    <img class="img-responsive customer-img" style="background-color: black;" src="<?php echo $img;  ?>" >
</td>
<td><?php echo $name; ?></td>
<td><?php echo $code; ?></td>
<td><?php foreach($json_customdataCurrency as $country => $price) { echo $country."-".$price ; echo "<br/>";}  ?></td>
<td><?php echo $stype; ?></td>
<td><?php echo $date_start; ?></td>
<td><?php echo $date_end; ?></td>
<td><?php echo $uses_total; ?></td>
<td><?php echo $uses_customer; ?></td>
<td id="getstatus<?php  echo $offer_id; ?>"><?php echo $status;?></td>
<td> 
<input type="hidden" size="2" id="act_deact_status<?php echo $offer_id;  ?>" value="<?php echo $cstatus; ?>" >    
<?php  if(in_array(4, $UserRight)){ ?>       
 <a href="javascript:void(0)"  class="delete" title="Delete" onclick="offerDelete('<?php echo $offer_id; ?>')"><span class="glyphicon glyphicon-trash"></span></a> &nbsp;&nbsp;&nbsp;
 <?php }  if(in_array(2, $UserRight)){ ?>
 <a href="javascript:void(0)" class="myBtnn" onclick="editOffer('<?php echo $offer_id; ?>','<?php echo $page; ?>','<?php echo $pagelimit; ?>')"  title="Edit" class="result"><span class="glyphicon glyphicon-edit"></span></a>&nbsp;&nbsp;&nbsp;
 <a href="javascript:void(0)">
  <i id="icon_status<?php echo $offer_id; ?>" class="status-icon fa <?php  echo ($cstatus == 1) ? 'fa-check-square-o':'fa-ban';?>" onclick="act_dect_offer('<?php echo  $offer_id; ?>')" ></i>
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
    $adjacent=3; $targetpage=''; $fromdate=''; $todate=''; $pageUrl='offers_paging.php'; $filtervalue='';
    echo pagination($page,$limit,$total_pages,$adjacent,$targetpage,$searchKeword,$fromdate,$todate,$pageUrl,$filtervalue);
    ?>
    </div> 
</div>
<script src="js/commonFunctionJS.js" type="text/javascript"></script>
<script type="text/javascript">
function add_new_offer()    
{
     $("#myModal_add_new_offer").modal();
      $("#flash").fadeIn(500).html('Loading <img src="img/image_process.gif" />');
      var info = 'action=add_new_offer'; 
        $.ajax({
	    type: "POST",
	    url: "offersModal.php",
	    data: info,
             success: function(result){
             $("#flash").hide();
             $('#view_modal_new_offer').html(result);
            return false;
        }
 
        });
     return false;    
}
function editOffer(offer_id,pageindex,limitval)    
{
     $("#LegalModal_modal_editOffer").modal();
      $("#flash").fadeIn(500).html('Loading <img src="img/image_process.gif" />');
      var info = 'action=editOffer&offer_id='+offer_id+"&pageindex="+pageindex+"&limitval="+limitval; 
        $.ajax({
	    type: "POST",
	    url: "offersModal.php",
	    data: info,
             success: function(result){
            $("#flash").hide();
             $('#edit_modal_editOffer').html(result);
            return false;
        }
 
        });
     return false;  
}

</script>