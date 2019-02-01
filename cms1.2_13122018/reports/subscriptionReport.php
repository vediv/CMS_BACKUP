<?php
include_once 'auths.php'; 
include_once 'auth.php'; 
include_once 'function.inc.php';
include_once("function.php");
$conn=db_connect(DASHBOARD_USER_ID,PUBLISHER_UNIQUE_ID);
switch($code)
{
    case "subscription_detail":
    $fromDate=isset($_GET['fromDate'])?$_GET['fromDate']:'';        
    $toDate=isset($_GET['toDate'])?$_GET['toDate']:'';  
    $dateType=isset($_GET['dateType'])?$_GET['dateType']:'';
    $transStatus=isset($_GET['transStatus'])?$_GET['transStatus']:'';
    $getPlanid=isset($_GET['planid'])?$_GET['planid']:'';
    $searchInput=isset($_GET['searchInput'])?$_GET['searchInput']:'';
    $subscType=isset($_GET['subscType'])?$_GET['subscType']:'';
    ?>
<div class="panel panel-default">
<div class="panel-heading">
<!-- <h3 class="panel-title "><i class="fa fa-filter"></i> Filter</h3>
   <div class="panel-title ">Text on the right</div>-->
     <div class="row">
            <div class="col-md-4 text-left"><i class="fa fa-filter"></i> Filter</div>
            <!--<div class="col-md-4 text-center">Header center</div>-->
            <div class="col-md-8 text-right"><a href="report.php?code=subscription_detail">Clear Filter</a></div>
        </div>
</div>
<div class="panel-body">
    <div class="pull-left">
    <div class="form-inline">   
         <div class="form-group">
            Subscription Type: 
            <div class="input-group">
              <select name="subscType" id="subscType" class="form-control" style="width:150px;" >
                  <option value="all" <?php echo $subscType=='all'?'selected':'';  ?>>All</option> 
                  <option value="plan" <?php echo $subscType=='plan'?'selected':'';  ?>>Plan Subscription</option>
                  <option value="wallet" <?php echo $subscType=='wallet'?'selected':'';  ?>>Pay Per View</option>
                  <option value="subs_code" <?php echo $subscType=='subs_code'?'selected':'';  ?>>Subscription Code</option>
              </select>
            </div>  
           <label for="from">from</label>
           <input type="text" id="fromDate" size="10"  name="fromDate" autocomplete="off" value="<?php echo $fromDate; ?>"   />
           <i class="fa fa-calendar" aria-hidden="true"></i>
           <label for="to">to</label>
           <input type="text" id="toDate" size="10" name="toDate" autocomplete="off" value="<?php echo $toDate; ?>"  />
           <i class="fa fa-calendar" aria-hidden="true" id="to"></i>
           <div class="input-group">
              <select name="date_type" id="date_type" class="form-control" style="width:170px;" >
                  <option value="">-Select Date Type-</option> 
                  <option value="added_date" <?php echo $dateType=='added_date'?'selected':'';  ?>>Added Date</option> 
                  <option value="trans_date" <?php echo $dateType=='trans_date'?'selected':'';  ?>>Transaction Date</option>
                  <option value="expire_date" <?php echo $dateType=='expire_date'?'selected':'';  ?>>Expire Date</option>
              </select>
            </div>
           <div class="input-group">
              <select name="trans_status" id="trans_status" class="form-control" style="width:200px;" >
                  <option value="all" <?php echo $transStatus=='all'?'selected':'';  ?>>Transaction Status(All)</option> 
                  <option value="payment_initiated" <?php echo $transStatus=='payment_initiated'?'selected':'';  ?>>Payment Initiated</option>
                  <option value="Success" <?php echo $transStatus=='Success'?'selected':'';  ?>>Success</option>
                  <option value="otherstatus" <?php echo $transStatus=='otherstatus'?'selected':'';  ?>>Other</option>
              </select>
            </div>
           

         </div>
         <div class="form-group text-right">
           <button type="button" id="button-filter-subscription" class="btn btn-default"><i class="fa fa-search"></i> Search</button>
         </div>
       </div>

       </div>
   
    <div class="pull-right">
        <div class="form-inline">   
            <div class="form-group">
             <div class="input-group">
              <?php
              $sqln="SELECT planID,planName FROM plandetail where pstatus='1' and plan_used_for='p'";
              $FetchData=  db_select($conn, $sqln);
              ?>     
              <select name="planid" id="planid" class="form-control" style="width:120px;" >
              <option value="">-Select Plan-</option> 
              <?php
              foreach($FetchData as $getPduration)
              {   $planID=trim($getPduration['planID']); $planName=$getPduration['planName'];
              ?>
              <option value="<?php echo $planID; ?>" <?php echo $planID==$getPlanid?'selected':''; ?>  ><?php echo $planName." ($planID)"; ?></option>"; 
              <?php } ?>   
              </select>
            </div>
            </div>
            <div class="form-group text-right">
           <button type="button" id="button-filter-getplan" class="btn btn-default"><i class="fa fa-search"></i> Search</button>
         </div>
        </div>
        
    </div>
     </div>
</div>
<div class="clear"></div>
<?php 
/*$querySub ="SELECT COUNT(*) as totaldata,SUM(IF (status_code='300',1,0)) AS total_sucess,
SUM(IF (status_code='0300',1,0)) AS total_sucess_new,SUM(IF (order_msg='Success',1,0)) AS tsucess,
SUM(IF (order_status='Payment Initiated',1,0)) AS payment_initiated 
FROM user_payment_details;"; 
$fetchTotal = db_select($conn,$querySub);
$totalSub=$fetchTotal[0]['totaldata']; $total_sucess=$fetchTotal[0]['total_sucess'];
$total_sucess_new=$fetchTotal[0]['total_sucess_new']; $payment_initiated=$fetchTotal[0]['payment_initiated'];
$tsuccessSub=$total_sucess+$total_sucess_new; $failSub=$totalSub-$tsuccessSub;
$other=$totalSub-($tsuccessSub+$payment_initiated);
*/
$query = "SELECT Count(*) as totalCount,SUM(IF (order_status='Success',1,0)) AS total_sucess,
SUM(IF (order_status='Payment Initiated',1,0)) AS payment_initiated  FROM user_payment_details where order_status!='Aborted'  ";
   if($subscType=='all'){ $paymentFor=''; }
   if($subscType=='plan' || $subscType=='wallet' || $subscType=='subs_code'){ $paymentFor=" and payment_for='$subscType'"; }
   
   if($transStatus=='all' || $transStatus==''){ $orderStatus='';  }
   if($transStatus=='payment_initiated'){ $orderStatus=" And order_status='Payment Initiated'";  }
   if($transStatus=='Success'){ $orderStatus=" And order_status='Success'";  }
   if($transStatus=='otherstatus'){ $orderStatus=" And order_status!='Payment Initiated' and order_status!='Success' ";  }
   if($fromDate=='')
   {  
        $query.="   $orderStatus $paymentFor";
   }  
   
   if($fromDate!='' && $toDate=='')
   {  
       if($dateType=='added_date'){ $date_type1="added_date"; $query.=" and Date(added_date)='$fromDate' $orderStatus $paymentFor";} 
       if($dateType=='trans_date'){ $date_type1="trans_date"; $query.=" and STR_TO_DATE(trans_date,'%d-%m-%Y')='$fromDate' $orderStatus $paymentFor"; }
       if($dateType=='expire_date'){ $date_type1="exipre_date"; $query.=" and Date(expire_date)='$fromDate' $orderStatus $paymentFor";}
   }  
   if($toDate!='' && $fromDate!='')
   {
       if($dateType=='added_date'){ $date_type1="added_date"; $query.=" and (Date(added_date) BETWEEN  '$fromDate' AND '$toDate' ) $orderStatus $paymentFor"; } 
       if($dateType=='trans_date'){ $date_type1="trans_date"; $query.=" and (STR_TO_DATE(trans_date,'%d-%m-%Y') BETWEEN '$fromDate' AND '$toDate' ) $orderStatus $paymentFor"; }
       if($dateType=='expire_date'){ $date_type1="exipre_date"; $query.=" and (Date(expire_date) BETWEEN '$fromDate' AND '$toDate' ) $orderStatus $paymentFor";}
   }
   if($getPlanid!='')
   {
       $query.=" and planid='$getPlanid'";
   }
    if($searchInput!='') // this $filter_user come from report page
    {
         $query .= " and 
         (userid LIKE '%". $searchInput . "%'
         or orderid LIKE '%" . $searchInput . "%'
         or trans_id LIKE '%" . $searchInput . "%'
         )";
    }    
   //echo $query;
   $fetch = db_select($conn,$query);
   $total_pages=$fetch[0]['totalCount'];
   $totalSub=$total_pages; $total_sucess=$fetch[0]['total_sucess'];
   $payment_initiated=$fetch[0]['payment_initiated'];$failSub=$totalSub-$total_sucess;
   $other=$totalSub-($total_sucess+$payment_initiated);
   
   
   $limit = $pagelimit; 
    if($page) 
            $start = ($page - 1) * $limit; 			//first item to display on this page
    else
            $start = 0;
    $sqlqd="SELECT upd.*,ur.uid,ur.uname
          FROM user_payment_details upd left join user_registration ur ON upd.userid=ur.uid 
          where upd.order_status!='Aborted'    ";
    if($fromDate=='')
    {  
        $sql.="   $orderStatus $paymentFor";
    }  
    if($fromDate!='' && $toDate=='')
    {  
       if($dateType=='added_date'){ $date_type1="added_date"; $sql.=" and Date(upd.added_date)='$fromDate' $orderStatus $paymentFor";} 
       if($dateType=='trans_date'){ $date_type1="trans_date"; $sql.=" and STR_TO_DATE(upd.trans_date,'%d-%m-%Y')='$fromDate' $orderStatus $paymentFor"; }
       if($dateType=='expire_date'){ $date_type1="exipre_date"; $sql.=" and Date(upd.expire_date)='$fromDate' $orderStatus $paymentFor";}
    } 
    if($toDate!='' && $fromDate!='')
    {
       if($dateType=='added_date'){ $date_type1="added_date"; $sql.=" and (Date(upd.added_date) BETWEEN  '$fromDate' AND '$toDate' ) $orderStatus $paymentFor"; } 
       if($dateType=='trans_date'){ $date_type1="trans_date"; $sql.=" and (STR_TO_DATE(upd.trans_date,'%d-%m-%Y') BETWEEN '$fromDate' AND '$toDate' ) $orderStatus $paymentFor"; }
       if($dateType=='expire_date'){ $date_type1="expire_date"; $sql.=" and (Date(upd.expire_date) BETWEEN  '$fromDate' AND '$toDate' ) $orderStatus $paymentFor"; } 
    }
    if($getPlanid!='')
    {
       $sql.=" and planid='$getPlanid'";
    }  
    if($searchInput!='') // this $filter_user come from report page
    {
         $sql.= " and 
         (upd.userid LIKE '%". $searchInput . "%'
         or upd.orderid LIKE '%" . $searchInput . "%'
         or upd.trans_id LIKE '%" . $searchInput . "%'
         )";
    }  
    $sqlq=$sqlqd.$sql ." LIMIT $start, $limit";
    //echo "<br/>Data Query=".$sqlq;
    $que = db_select($conn,$sqlq);
    $countRow=  db_totalRow($conn,$sqlq);
    
    
    
    
?>
<div class="row" style="border: 0px solid red; ">
    <table border='0' style="width:98%; margin-left: 10px;">
    <tr>
    <td width="25%">
    <select id="pagelmt"  style="width:60px;" onchange="selpagelimit('report.php?code=subscription_detail');" >
       <option value="10"  <?php echo $pagelimit==10? "selected":""; ?> >10</option>
        <option value="20"  <?php echo $pagelimit==20? "selected":""; ?> >20</option>
        <option value="50"  <?php echo $pagelimit==50? "selected":""; ?> >50</option>
        <option value="100" <?php echo $pagelimit==100? "selected":""; ?> >100</option>
        <option value="200" <?php echo $pagelimit==200? "selected":""; ?> >200</option>
        <option value="500" <?php echo $pagelimit==500? "selected":""; ?> >500</option>
    </select> Records Per Page
    </td>
    <td width="30%" align="center">
      <span class="label label-primary">Total <span class="badge" style="color: #337ab7; background-color: #fff;padding: 0px 4px 1px 4px;"><?php echo $totalSub; ?></span></span>
      <span class="label label-success">Success <span class="badge"  style="color: #00a65a; background-color: #fff;padding: 0px 4px 1px 4px;"><?php echo $total_sucess; ?></span></span>
      <span class="label label-danger">Payment Initiated <span class="badge"  style="color: #444; background-color: #fff;padding: 0px 4px 1px 4px;"><?php echo $payment_initiated; ?></span></span>
      <span class="label label-danger">Other <span class="badge"  style="color: #444; background-color: #fff;padding: 0px 4px 1px 4px;"><?php echo $other; ?></span></span>
 
    </td>
    <td width="37%">
        <div class="col-sm-3 col-md-3 pull-right navbar-form" role="search">  
            <div class="input-group add-on" style="float: right;">
            <input id='pagelimit' type="hidden" height="30px"  value="<?php echo $pagelimit; ?>">   
            <input class="form-control" size="30"  placeholder="Search by userID,orderID,transactionID"  autocomplete="off" name='searchInput' id='searchInput' class="searchInput" type="text" value="<?php echo $searchInput; ?>">
            <div class="input-group-btn">
              <button class="enableOnInput btn btn-default"   id='searchSub' type="button" style="height: 30px;   padding: 4px 6px !important;"><i class="glyphicon glyphicon-search"></i></button>	
            </div>
            </div>
       </div>
    </td>
<td width="15%" align="right">
    <input type="hidden" name="fromDate" id="fromDate" value="<?php echo $fromDate; ?>"> 
    <input type="hidden" name="toDate" id="toDate" value="<?php echo $toDate; ?>">
    <input type="hidden" name="dateType" id="dateType" value="<?php echo $dateType; ?>">
    <input type="hidden" name="transStatus" id="transStatus" value="<?php echo $transStatus; ?>">
    <input type="hidden" name="planid" id="planid" value="<?php echo $getPlanid; ?>">
    <input type="hidden" name="searchInput" id="searchInput" value="<?php echo $searchInput; ?>">
    <input type="hidden" name="subsc_type" id="subsc_type" value="<?php echo $subscType; ?>">
    <a href="javascript:" class="myBtn btn" title="Export to Excel" onclick="exportData('.xls','subcription_excel')"><i class="fa fa-file-excel-o bigger-110 green"></i></a>
    <a href="javascript:" class="myBtn btn " title="Export to pdf" onclick="exportData('.pdf','subcription_pdf')"><i class="fa fa-file-pdf-o bigger-110 " aria-hidden="true"></i></a>
</td>
</tr>
</table>
        
</div>
<?php 
    if($countRow==0)
    {echo "<div align='center'><strong>No Record Found</strong> </div><br/>";}

?>
<table id="example1" class="table table-fixedheader table-bordered table-striped" style="width: 100%;">
    <thead>
        <tr>
          <th>OrderID</th>
          <th title="transaction-id">Trans-ID</th>
          <th>Customer(ID)</th>
          <th>Plan(Days)</th>
          <th>Amount</th>
          <th>Status</th>
          <th>Added Date</th>
          <th title="transaction Status">Trans Date</th>
          <th>Expire Date</th>
          <th title="Subscription Type">Sub Type</th>
          <th title="Subscription Status">Sub Status</th>
       </tr> 
 </thead>
    <tbody>
    <?php
    $count=1;
    $currentDate=date('Y-m-d');
    foreach($que as $fetch)
    {
        $uid=$fetch['uid'];$orderid=$fetch['orderid']; $trans_id=$fetch['trans_id']; $amount =$fetch['amount'];  $trans_date =$fetch['trans_date'];
        $uname=$fetch['uname']; $exipre_date =$fetch['exipre_date']; $added_date =$fetch['added_date'];
        $status_code=$fetch['status_code']; $plan_days=$fetch['plan_days'];  $planid=$fetch['planid']; $payment_mode=$fetch['payment_mode'];
        $expire_date=$fetch['expire_date']; $payment_for=$fetch['payment_for'];
        $expire_date_only=date("Y-m-d", strtotime($expire_date)); 
        if(($status_code=='0300' || $status_code=='300' ) && ($expire_date_only>=$currentDate))
        {
            $sub_status="<span class='label label-success'>active</span>";
        }
        else
        {
            $sub_status="<span class='label label-danger'>inactive</span>";
        }
        $order_msg=$fetch['order_status'];
        if($trans_id!=''){ $order_msg=$fetch['order_msg']; }
        if($payment_for=='plan'){ $subType="Plan Subscription"; }
        if($payment_for=='wallet'){ $subType="Pay per View"; }
        if($payment_for=='subs_code'){ $subType="Subscription Code"; }
     ?> 
    <tr>
<td><?php echo $orderid ?></td>
<td><?php echo $trans_id ;?></td>
<td><?php echo $uname."($uid)"; ?></td>
<td><?php echo $planid."($plan_days)";?></td>
<td><?php echo $amount;?></td>
<!--<td><?php echo $payment_mode;?></td>-->
<td><?php echo $order_msg; ?></td>
<td><?php echo $added_date; ?></td>
<td><?php echo $trans_date; ?></td>
<td><?php echo $expire_date; ?></td>
<td><?php echo $subType; ?></td>
<td><?php echo $sub_status; ?></td>
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
    $extraParameter="";
    if($fromDate!=''){ $extraParameter.="&fromDate=".$fromDate; }
    if($toDate!=''){ $extraParameter.="&toDate=".$toDate; }
    if($dateType!=''){ $extraParameter.="&dateType=".$dateType; }
    if($transStatus!=''){ $extraParameter.="&transStatus=".$transStatus; }
    if($getPlanid!=''){ $extraParameter.="&planid=".$getPlanid; } 
    if($searchInput!=''){ $extraParameter.="&searchInput=".$searchInput; }
    if($subscType!=''){ $extraParameter.="&subscType=".$subscType; }
    $adjacent=3; $targetpage="report.php?code=$code$extraParameter"; 
    echo pagination_url($page,$limit,$total_pages,$adjacent,$targetpage,$filter_user,$fromdate,$todate);
    ?>
    </div> 
</div>

<?php 
} 
?>