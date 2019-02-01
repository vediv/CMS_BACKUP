<?php
include_once 'auths.php';
include_once 'auth.php';
//include_once 'function.inc.php';
include_once("function.php");
$conn=db_connect(DASHBOARD_USER_ID,PUBLISHER_UNIQUE_ID);
switch($code)
{
    case "content_pay_per_view":
    $cur_date= date('Y-m-d');
    $pre_month = date('Y-m-d', strtotime('-1 months'));
    $fromDate=isset($_GET['fromDate'])?$_GET['fromDate']:$pre_month;
    $toDate=isset($_GET['toDate'])?$_GET['toDate']:$cur_date;
    $entry_id=isset($_GET['entryid'])?$_GET['entryid']:'';
    $vname=isset($_GET['vname'])?$_GET['vname']:'';
    $email=isset($_GET['email'])?$_GET['email']:'';
?>
<div class="panel panel-default">
<div class="panel-heading">
 <!-- <h3 class="panel-title "><i class="fa fa-filter"></i> Filter</h3>
   <div class="panel-title ">Text on the right</div>-->
     <div class="row">
            <div class="col-md-4 text-left"><i class="fa fa-filter"></i> Filter</div>
            <!--<div class="col-md-4 text-center">Header center</div>-->
            <div class="col-md-8 text-right"><a href="report.php?code=content_pay_per_view">Clear Filter</a></div>
        </div>
</div>
<div class="panel-body">
  <div class="pull-left">
  <div class="form-inline">
       <div class="form-group">
          <label for="from">Video Entry:</label>
                   <input type="text" name="VideoEntry"  id="VideoEntry"  placeholder="Select Video"  class="form-control"  value="<?php echo $vname; ?>"  />
                   <input type="hidden" name="entryid"  id="entryid"    class="form-control"  value="<?php echo $entry_id; ?>"  />
                   <span  id="VideoEntry-error" style="color:red;"></span>&nbsp;
                   <div class="form-group text-right">
                     <button type="button" id="button-filter-pay_per_view" class="btn btn-default"><i class="fa fa-search"></i> Search</button>
                   </div>
         <!-- <input type="text" id="entry_id" size="10"  placeholder="Enter EntryId" name="entry_id" autocomplete="off" value="<?php echo $entry_id; ?>"   />&nbsp; -->
       </div>
     </div>
   </div>
       <div class="pull-right">
         <div class="form-inline">
         <label for="from">Email-Id:</label>
         <!-- <input type="text" id="email" size="10"  name="email" autocomplete="off" value="<?php echo $email; ?>"   />&nbsp;&nbsp; -->

             <input type="text" name="email" size="24"  id="email"  placeholder="Enter Email" value="<?php echo $email; ?>"  />
             <input type="hidden" name="email" size="24" id="user_id"  placeholder="User list"   />
             <span  id="userlist-error" style="color:red;"></span>

       <div class="form-group text-right">
         <button type="button" id="button-filter-pay_per_view_id" class="btn btn-default"><i class="fa fa-search"></i> Search</button>
       </div>
       </div>
     </div>

    <!-- <div class="pull-right">
    <div class="form-inline">
         <div class="form-group">

           <label for="from">from</label>
           <input type="text" id="fromDate" size="10"  name="fromDate" autocomplete="off" value="<?php echo $fromDate; ?>"   />
           <i class="fa fa-calendar" aria-hidden="true"></i>
           <label for="to">to</label>
           <input type="text" id="toDate" size="10" name="toDate" autocomplete="off" value="<?php echo $toDate; ?>"  />
           <i class="fa fa-calendar" aria-hidden="true" id="to"></i>

         </div>
  <div class="form-group text-right">
           <button type="button" id="button-filter-pa_per_view_range" class="btn btn-default"><i class="fa fa-search"></i> Search</button>
         </div>
       </div>
</div> -->
</div>
</div>
<div class="clear"></div>
<?php
$query = "SELECT COUNT(*) as totalCount  FROM wallet_trans_info wti left join user_registration ur ON wti.userid=ur.uid ";
$qryAds="SELECT SUM(IF(upd.order_status='Success',upd.amount,0)) AS totalSuccess,
SUM(IF(upd.order_status='Payment Initiated',upd.amount,0)) AS totalPaymetInitiated,
SUM(IF(upd.order_status<>'Payment Initiated' AND upd.order_status<>'Success',upd.amount,0)) AS totalOthers
FROM wallet_trans_info  wti left join user_payment_details upd ON wti.orderid=upd.orderid
left join user_registration ur ON wti.userid=ur.uid ";
if($entry_id!='')
{
  $query.=" where entryid='$entry_id'";
   $qryAds.="where wti.entryid='$entry_id'";
}
if($email!='')
{
   $query.=" where uemail='$email'";
   $qryAds.="where ur.uemail='$email'";
}
//echo $qryAds; echo "<br/>";
$fetchads = db_select($conn,$qryAds);
$Success = $fetchads[0]['totalSuccess']==NULL?0:$fetchads[0]['totalSuccess'];
$PaymentInitiated = $fetchads[0]['totalPaymetInitiated']==NULL?0:$fetchads[0]['totalPaymetInitiated'];
$others = $fetchads[0]['totalOthers']==NULL?0:$fetchads[0]['totalOthers'];
$totalRevenue=$Success+$PaymentInitiated+$others;
//$query ; echo "<br/>";
$fetch = db_select($conn,$query);
$total_pages=$fetch[0]['totalCount'];

$limit = $pagelimit;
    if($page)
            $start = ($page - 1) * $limit; 			//first item to display on this page
    else
            $start = 0;
    $sqlqd="SELECT wti.userid,wti.entryid,wti.orderid,upd.order_status,upd.amount,ur.uemail
            FROM wallet_trans_info wti left join user_payment_details upd ON wti.orderid=upd.orderid left join user_registration ur ON wti.userid=ur.uid ";

    if($entry_id!='')
    {
       $sql.=" where wti.entryid='$entry_id'";
    }
    if($email!='')
    {
       $sql.=" where ur.uemail='$email'";
    }
    $sqlq=$sqlqd.$sql . " LIMIT $start, $limit";
    //echo "<br/>Data Query=".$sqlq;
    $que = db_select($conn,$sqlq);
    $countRow=  db_totalRow($conn,$sqlq);
?>
<div class="row" style="border: 0px solid red; margin-top: -30px;">

    <div class="box-body" id="content_report" >
      <div class="row" style="border: 0px solid red; ">
          <table border='0' style="width:98%; margin-left: 10px;">
          <tr>
          <!--<td width="15%">
          <select id="pagelmt"  style="width:60px;" onchange="selpagelimit('report.php?code=subscription_detail');" >
             <option value="10"  <?php echo $pagelimit==10? "selected":""; ?> >10</option>
              <option value="20"  <?php echo $pagelimit==20? "selected":""; ?> >20</option>
              <option value="50"  <?php echo $pagelimit==50? "selected":""; ?> >50</option>
              <option value="100" <?php echo $pagelimit==100? "selected":""; ?> >100</option>
              <option value="200" <?php echo $pagelimit==200? "selected":""; ?> >200</option>
              <option value="500" <?php echo $pagelimit==500? "selected":""; ?> >500</option>
          </select> Records Per Page-->
          <?php
          if($entry_id!='' || $email!=''){?>
          <td width="90%" align="center">
            <span class="label label-primary">Total Revenue <span class="badge" style="color: #337ab7; background-color: #fff;padding: 0px 4px 1px 4px;"><?php echo $totalRevenue; ?></span></span>
            <span class="label label-success">Success <span class="badge"  style="color: #00a65a; background-color: #fff;padding: 0px 4px 1px 4px;"><?php echo $Success; ?></span></span>
            <span class="label label-warning">Payment Initiated<span class="badge"  style="color: #444; background-color: #fff;padding: 0px 4px 1px 4px;"><?php echo $PaymentInitiated; ?></span></span>
            <span class="label label-danger">Others<span class="badge"  style="color: #444; background-color: #fff;padding: 0px 4px 1px 4px;"><?php echo $others; ?></span></span>

          </td><?php }?>
              <td width="15%" align="right">
          <a href="javascript:" class="myBtn btn" title="Export to Excel" onclick="exportData('pay_per_view_excel','content_pay_per_view')"><i class="fa fa-file-excel-o bigger-110 green"></i></a>
          <a href="javascript:" class="myBtn btn " title="Export to pdf" onclick="exportData('pay_per_view_pdf','content_pay_per_view')"><i class="fa fa-file-pdf-o bigger-110 " aria-hidden="true"></i></a>
      </td>
      </tr>
      </table>

      </div>
        <table id="example1" class="table table-fixedheader table-bordered table-striped" style="width: 100%;">
        <thead>
        <tr>

          <th>User ID</th>
          <th>Entry ID</th>
          <th>E-mail</th>
          <th>Order ID</th>
          <th>Order Status</th>
          <th>Amount</th>
        </tr>
       </thead>
       <tbody>
       <?php
       if($entry_id!='' || $email!=''){
       $count=1;
       $currentDate=date('Y-m-d');
       foreach($que as $fetch)
       {
           $uid=$fetch['userid'];$orderid=$fetch['orderid']; $entry_id=$fetch['entryid']; $amount =$fetch['amount'];  $order_status =$fetch['order_status'];
           $uemail=$fetch['uemail'];
           if(($status_code=='0300' || $status_code=='300' ) && ($expire_date_only>=$currentDate))
           {
               $sub_status="<span class='label label-success'>active</span>";
           }
           else
           {
               $sub_status="<span class='label label-danger'>inactive</span>";
           }
        ?>
       <tr>
   <td><?php echo $uid ?></td>
   <td><?php echo $entry_id ?></td>
   <td><?php echo $uemail ?></td>
   <td><?php echo $orderid ?></td>
   <td><?php echo $order_status ?></td>
   <td><?php echo $amount ?></td>
   </tr>
   <?php $count++;} } ?>
       </tbody>
        </table>
        <span style="margin: 500px;" id="content_report_loader"></span>
        <div class="page" style="border: 0px solid red; text-align: center; background-color:#fff !important; height:40px;">
            <?php
             if($entry_id!='' || $email!=''){
               if($start==0) {
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
            if($vname!='' && $email==''){ $extraParameter.="&entryid=".$entry_id."&vname=".$vname; }
            if($email!='' && $vname==''){ $extraParameter.="&email=".$email; }
            //if($transStatus!=''){ $extraParameter.="&transStatus=".$transStatus; }
            //if($getPlanid!=''){ $extraParameter.="&planid=".$getPlanid; }

            $adjacent=3; $targetpage="report.php?code=$code$extraParameter";
            echo pagination_url($page,$limit,$total_pages,$adjacent,$targetpage,$filter_user,$fromdate,$todate);
          }?>
            </div>
        </div>
    </div>
</div>
<script src = "js/common.js"></script>
<script type="text/javascript" src="scripts/jquery.form.js"></script>
 <script>
 $(document).ready(function() {
    setTimeout(function() {
        $("#content_report_loader").fadeOut(1500);
    }, 100);
});
$('input[name=\'email\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'controller/customFunction.php?action=getregisterUserList&filter_name='+request,
			method: 'POST',
                        dataType: 'json',
			success: function(json) {

				response($.map(json, function(item) {
		         	return {
					  label: item['user_id'],
				           value: item['uid']
					}
				}));
			}
		});
	},
	'select': function(item) {
         $('#user_id').val(item['value']);
         $('#email').val(item['label']);
        }
});
$('input[name=\'VideoEntry\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'controller/customFunction.php?action=getVideoEntry&filter_name='+request,
			method: 'POST',
      dataType: 'json',
			success: function(json) {
                        	response($.map(json, function(item) {
		         	                return {
					                           label: item['name'],
				                             value: item['entryid']
					                            }
				}));
			}
		});
	},
	'select': function(item) {
          $('#entryid').val(item['value']);
          $('#VideoEntry').val(item['label']);
        }
});
 </script>
<?php } ?>
