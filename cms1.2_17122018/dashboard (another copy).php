<?php 
include_once 'corefunction.php';
// get analytics Credential
$qryAna="select google_client_id,client_secret,refresh_token,analytics_url from mail_config where publisherID='".$publisher_unique_id."'";
$fetchAna=  db_select($conn,$qryAna);
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title><?php echo ucwords(PROJECT_TITLE)." | DashBoard";?></title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="plugins/morris/morris.css" rel="stylesheet" type="text/css" />
    <style type="text/css">
       .href_class { color: #000; }
       .bold{font-weight:bold  !important;}
       .box {  display: none;}
       .bg-yellow, .callout.callout-warning, .alert-warning, .label-waring, .modal-warning .modal-body {
    background: linear-gradient(60deg,#ffa726,#fb8c00) !important;    box-shadow: 0 4px 20px 0 rgba(0,0,0,.14),0 7px 10px -5px rgba(255,152,0,.4);}
       .bg-red, .callout.callout-danger, .alert-danger, .alert-error, .label-danger, .modal-danger .modal-body {
    background: linear-gradient(60deg,#ef5350,#e53935) !important;    box-shadow: 0 4px 20px 0 rgba(0,0,0,.14),0 7px 10px -5px rgba(244,67,54,.4) !important;
}
       #highcharts-4, #highcharts-8, #highcharts-12{ width:500px !important; }
      .info-box-icon { margin-top: -30px; height: 66px !important;    width: 64px !important;     font-size: 40px !important; line-height: 67px !important;}
      .info-box-number {    font-weight: bold  !important;      font-size: 16px  !important;  }
      .info-box-text {text-transform: capitalize  !important; font-size: 10px  !important;  color: #000  !important;}
      .info-box-content {    padding: 5px 6px 5px 2px !important;    margin-left: 65px !important;}
      .info-box {margin-bottom: 49px !important; margin-top: 29px !important; }
    </style>
   </head>
  <body class="skin-blue">
    <div class="wrapper">
       <?php include_once 'header.php';
         include_once 'lsidebar.php';?>
      <div class="content-wrapper">
        <section class="content-header">
          <h1>Dashboard<small></small></h1>
          <ol class="breadcrumb">
              <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <!-- Info boxes -->
          <?php 
           
           ?>
          <div class="row">
            <!-- Total Registration--> 
           <?php  if(in_array(23,$otherPermission)){ 
           $results ="SELECT COUNT(1) AS totrec, SUM(IF (STATUS='1',1,0)) AS totactive,SUM(IF (STATUS='0',1,0)) AS totdeactive FROM user_registration";
           $fetch = db_select($conn,$results);
           $totalrec_user=$fetch[0]['totrec'];  $totalactive=$fetch[0]['totactive'];  $totaldeactive=$fetch[0]['totdeactive'];
           $count =db_totalRow($conn,$results);   
             ?>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-gray"><i class="fa fa-user"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text" title="Total Registration" style="font-size: 12px !important; text-transform: uppercase  !important; font-weight: 700 !important;">Total Registration</span>
                  <span class="info-box-number"><a href="user_list.php?showall=showall" class="href_class"><small><?php echo $totalrec_user; ?></small></a></span>
                </div>
              </div>
            </div>
            <?php } ?> 
            <?php  if(in_array(24,$otherPermission)) {?>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-red"><i class="fa fa-users"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text" title="Total Authorized User" style="font-size: 12px !important; text-transform: uppercase  !important; font-weight: 700 !important;">Total Authorized User</span>
                    <span class="info-box-number"><a href="#" class="href_class"><small><?php echo $totalactive==''?"0":$totalactive; ?></small></a></span>
                  <span class="info-box-text" title="Total unauthorized User">Total unauthorized User</span>
                    <span class="info-box-number"><a href="#" class="href_class"><small><?php echo $totaldeactive==''?"0":$totaldeactive; ?></small></a></span>
                </div>
              </div>
            </div>
            <?php } ?>
             <?php  if(in_array(25,$otherPermission)) {?>
             <div class="col-md-3 col-sm-6 col-xs-12">
                <?php
                //$get_user_id; $login_access_level;
                include_once 'function.php';
                $sql="select sum(duration) as vlength,count(entryid) as totalcount from entry where status='2' and type='1'"; 
                if($login_access_level=='c')
                {
                    $sql.=" and puser_id='".$get_user_id."'";
                }    
                //echo $sql;
                $fetch = db_select($conn,$sql);
	        $totalvideo=$fetch[0]['totalcount']; $vlength=$fetch[0]['vlength'];
                ?>
               <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="fa fa-video-camera"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text" title="Total Content" style="font-size: 12px !important; text-transform: uppercase  !important; font-weight: 700 !important;">Total Content</span>
                  <span class="info-box-number"><a href="media_content.php" class="href_class"><?php echo  $totalvideo; ?></a></span>
                  <span class="info-box-text" title="Total Content Duration">Total Content Duration</span>
                  <span class="info-box-number"><?php echo convert_sec_to($vlength); ?></span>
                </div>
              </div>
            </div>
            <?php } ?>
            <?php  if(in_array(30,$otherPermission)) {?>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <?php
              //include_once 'function.php';
               $sql="SELECT  SUM(IF (video_status='active',1,0)) AS total_active,SUM(IF (video_status='inactive',1,0)) AS total_inactive FROM entry where status='2' and type='1'";
               if($login_access_level=='c')
                {
                    $sql.=" and puser_id='".$get_user_id."'";
                }  
               $tableAD=  db_select($conn,$sql);
               $total_active=$tableAD[0]['total_active']; $total_inactive=$tableAD[0]['total_inactive'];
                ?>
               <div class="info-box">
                <span class="info-box-icon bg-green"><i class="fa fa-video-camera"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text" title="Active Content" style="font-size: 12px !important; text-transform: uppercase  !important; font-weight: 700 !important;">Active Content</span>
                  <span class="info-box-number"><a href="#" class="href_class"><?php   echo $total_active==''?"0":$total_active; ?> </a></span>
                  <span class="info-box-text" title="Inactive Content">Inactive  Content</span>
                  <span class="info-box-number"><?php echo $total_inactive==''?"0":$total_inactive; ?></span>
                </div>
              </div>
            </div>
            <?php } ?>
            
            
            <div class="clearfix visible-sm-block"></div>
            <?php  if(in_array(26,$otherPermission)) {?>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <?php
              $results ="SELECT COUNT(1) AS totrec  FROM guest_user";
              $fetch = db_select($conn,$results);
              $totalrec=$fetch[0]['totrec'];  
              ?>  
              <div class="info-box">
                <span class="info-box-icon bg-green"><i class="fa fa-users"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text" title="Total Guest User" style="font-size: 12px !important; text-transform: uppercase  !important; font-weight: 700 !important;">Total Guest User</span>
                  <span class="info-box-number"><?php echo $totalrec; ?></span>
                </div>
              </div>
            </div>
            <?php } ?>
            <?php  if(in_array(27,$otherPermission)) {
            $queryActive ="select userid from userhistory where date(last_view) 
            between (DATE_SUB(CURDATE(), interval 14 day)) and CURDATE() group by userid order by last_view desc";
            $total15daysActive = db_totalRow($conn,$queryActive);
            $queryInActive ="select userid from userhistory where date(last_view) 
            not between (DATE_SUB(CURDATE(), interval 14 day)) and CURDATE() group by userid order by last_view desc";
            //$total15daysInActive = db_totalRow($conn,$queryInActive);
            $total15daysInActive=$totalrec_user-$total15daysActive;
            ?>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="fa fa-user"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text" title="Active Users" style="font-size: 12px !important; text-transform: uppercase  !important; font-weight: 700 !important;">Active Users(15 Days)</span>
                  <span class="info-box-number"><a href="report.php?code=15dayactive" class="href_class"><?php echo $total15daysActive==''?"0":$total15daysActive; ?></a></span>
                  <span class="info-box-text" title="Inactive Users">InActive Users(15 Days)</span>
                  <span class="info-box-number"><a href="report.php?code=15dayinactive" class="href_class"><?php echo $total15daysInActive==''?"0":$total15daysInActive; ?></a></span>
                </div>
              </div>
            </div>
            <?php } ?>
           <?php  if(in_array(38,$otherPermission)) { ?>
            <div class="col-md-3 col-sm-5 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-green"><i class="fa fa-users"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text" title="Total Subscription" style="font-size: 12px !important; text-transform: uppercase  !important; font-weight: 700 !important;">Total Subscription</span>
                  <span class="info-box-number"><a href="subscription_detail.php?code=total_subscription" class="href_class" id="totalSub"><span id="totalSub_loader"></span></a></span>
                   <!--<span class="info-box-text" title="Inactive Users">
                      <div class="pull-left">Success <span class="info-box-number" id="successSub"><span id="successSub_loader"></span></span></div>
                      <div class="pull-right">Fail<span class="info-box-number" id="failSub"><span id="failSub_loader"></span></span></div>
                  </span>-->
                </div>
              </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="fa fa-users"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text" title="Total Subscription" style="font-size: 12px !important; text-transform: uppercase  !important; font-weight: 700 !important;">Subscription</span>
                  <span class="info-box-number"><a href="subscription_detail.php?code=total_subscription" class="href_class" id="totalSub_plan"><span id="totalSub_plan_loader"></span></a></span>
                  <span class="info-box-text" title="Inactive Users">
                      <div class="pull-left">Pay per view <span class="info-box-number" id="successSub_pay_per_view"><span id="successSubPayPerView_loader"></span></span></div>
                      <div class="pull-right">Subscription code<span class="info-box-number" id="failSub_code"><span id="failSubCode_loader"></span></span></div>
                  </span>
                            
                </div>
              </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-red"><i class="fa fa-rupee"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text" title="Total Revenue" style="font-size: 12px !important; text-transform: uppercase  !important; font-weight: 700 !important;"><strong>Total Revenue</strong></span>
                    <span class="info-box-number">
                        <a href="report.php?code=revenue" class="href_class" id="totalRevenue">
                        <span id="totalRevenue_loader"></span></a>
                        </span>
                    <span class="info-box-text">
                    <table border="0" width="100%">
                          <tr><th>Subscription</th><th>Pay Per View</th><th>Ads</th></tr>
                          <tr>
                            <td id="subs_pay"><span  id="subs_pay_loader"></span></td>
                            <td id="payPer"><span id="payPer_loader"></span></td>
                            <td id="payAds" ><span id="payAds_loader"></span></td>
                          </tr>
                    </table>      
                  </span>
                </div>
              </div>
            </div>
            <script type="text/javascript" src="js/jquery-1.11.2.min.js"></script>    
           <script type="text/javascript">
           getsSubscription('subscriptiondata','cardinfo'); 
            function getsSubscription(action,cardinfo)
            {
               $("#totalSub_loader,#successSub_loader,#failSub_loader,#totalSub_plan_loader,#successSubPayPerView_loader,#failSubCode_loader,#totalRevenue,#subs_pay_loader,#payPer_loader,#payAds_loader").fadeIn(100).html('<img src="img/image_process.gif" height="20" />');
               var info = 'action='+action+'&subaction='+cardinfo; 
               $.ajax({
                type: "POST",
                url: "dashboardReport",
                dataType: 'json',
                data: info,
                     success: function(rr){
                      var totalSub=rr.data[0].totalSub;
                      var successSub=rr.data[0].successSub;
                      var failSub=rr.data[0].failSub;
                      var total_subcription_only=rr.data[0].total_subcription_only;
                      var total_payPerView=rr.data[0].total_payPerView;
                      var total_subsCode=rr.data[0].total_subsCode;
                      var totalRevenue=rr.data[0].TotalRevenue;
                      var subs_pay=rr.data[0].TotalSubscribtionAmount;
                      var payPer=rr.data[0].TotalPayPerViewAmount;
                      var payAds=rr.data[0].TotalAdsAmount;
                      $('#totalSub').html(totalSub); $("#totalSub_loader").hide();
                      $('#totalSub_plan').html(total_subcription_only); $("#totalSub_loader").hide();
                      $('#successSub_pay_per_view').html(total_payPerView); $("#totalSub_loader").hide();
                      $('#failSub_code').html(total_subsCode); $("#totalSub_loader").hide();
                      $('#totalRevenue').html(totalRevenue); $("#totalRevenue_loader").hide();
                      $('#subs_pay').html(subs_pay); $("#subs_pay_loader").hide();
                      $('#payPer').html(payPer); $("#payPer_loader").hide();
                      $('#payAds').html(payAds); $("#payAds_loader").hide();
                      //$('#successSub').html(successSub);$("#successSub_loader").hide();
                      //$('#failSub').html(failSub); $("#failSub_loader").hide();
                     }
              });
            }  
           </script>
           <?php } ?>
          </div>
          <div class='row'>
           <?php  if(in_array(38,$otherPermission)){
             $year = date('Y');
             $month = date('m');
            ?>    
          <script type="text/javascript" src="js/jquery-1.11.2.min.js"></script>    
          <div class="col-md-6">
              <div class="box1" style="background-color: #ffffff;">
                <div class="box-header box-primary">
                    <h3 class="box-title"> <i class="fa fa-users"></i> Latest Subscription</h3>
                  <div class="box-tools">
                    <div class="input-group">
                        <select name="year" id="year" class="form-control" style="width:80px;" >
                        <?php 
                        $min = $year-5;
                        $max = $year;
                        for($i=$max; $i>=$min; $i--) {
                            echo '<option value='.$i.'>'.$i.'</option>';
                         } ?>
                        </select>
                        
                        <select name="month" id="month" class="form-control"  style="width:110px;" onchange="getlatest_subscription_detail('search_month');">
                            <option value='<?php echo $month; ?>'><?php echo  date('F', mktime(0, 0, 0, $month, 2));?></option>
                            <?php for( $m=1; $m<=12; ++$m ) { 
                                $month_label = date('F', mktime(0, 0, 0, $m, 2));
                             ?>
                            <option value="<?php echo $m; ?>"><?php echo $month_label; ?></option>
                          <?php } ?>
                        </select>
                        
                    </div>
                  </div>
                </div>
                <div class="box-body" id="latest_subscription_detail">
                    <span id="latest_subscription_detail_loader"></span>
                </div>
              </div>

            </div>
          <div class="col-md-6">
              <div class="box1" style="background-color: #ffffff;">
                <div class="box-header box-primary">
                  <h3 class="box-title"> <i class="fa fa-users"></i> Subscription Report</h3>
                  <div class="box-tools">
                    <div class="input-group">
                        <select name="year_sub" id="year_sub" class="form-control" style="width:130px;" onchange="subscriptionReport('search_year');" >
                         <option value="">-Select Year-</option>    
                        <?php 
                        $min = $year-5;
                        $max = $year;
                        for($i=$max; $i>=$min; $i--) {
                            echo '<option value='.$i.'>'.$i.'</option>';
                         } ?>
                        </select>
                        <select name="month_sub" id="month_sub" class="form-control"  style="width:130px;" onchange="subscriptionReport('search_month');">
                          <option value="">-Select Month-</option>
                          <!-- <option value='<?php echo $month; ?>'><?php echo  date('F', mktime(0, 0, 0, $month, 2));?></option>-->
                            <?php for( $m=1; $m<=12; ++$m ) { 
                                $month_label = date('F', mktime(0, 0, 0, $m, 2));
                             ?>
                            <option value="<?php echo $m; ?>"><?php echo $month_label; ?></option>
                          <?php } ?>
                        </select>
                        
                    </div>
                  </div>
                </div>
                <div class="box-body" id="subscriptionReport">
                    <span id="subscriptionReportloader"></span>
                </div>
              </div>

            </div>
              <script type='text/javascript'>
                 var act='latest';
                 getlatest_subscription_detail(act);
                 function getlatest_subscription_detail(acti)
                 {
                    var month = $('#month').val();
                    var year = $('#year').val();
                    $("#latest_subscription_detail_loader").fadeIn(100).html('<img src="img/image_process.gif" height="20" />');
                        $.ajax({
                        type:'POST',
                        url:'dashboardReport',
                        dataType: "json",
                        data:{show:acti,month:month,year:year,action:'latest_subscription'},
                        success:function(r){
                           //console.log(r.totalRecord);
                           if(r.totalRecord > 0){
                            var len=r.data.length;
                            var html='';
                            html+='<table class="table table-bordered">';
                            html+='<tr><th>OrderID</th><th>Date Added</th><th>Amount</th><th>Status</th></tr>';
                            for(var i=0;i<len;i++)
                            { 
                               
                               var orderid=r.data[i].OrderID;
                               //console.log("santosh=="+orderid); 
                               var cname=r.data[i].name; var amount=r.data[i].amount;
                               var added_date=r.data[i].added_date;var status=r.data[i].order_msg;
                               html+='<tr>';
                               html+='<td>'+orderid+'</td>';
                               //html+='<td>'+cname+'</td>';
                               html+='<td>'+added_date+'</td>';
                               html+='<td>'+amount+'</td>';
                               html+='<td>'+status+'</td>';
                               html+='</tr>';
                            }
                            html+='<tr><td colspan="5" align="right"><a href="subscription_detail.php">View more...</a></td></tr>';
                            html+='</table>';
                            $('#latest_subscription_detail').html(html);
                            $("#latest_subscription_detail_loader").hide(); 
                           }
                          else{
                            $('#latest_subscription_detail').html("data not available!");
                            $("#latest_subscription_detail_loader").hide(); 
                         } 
                        }
                    });
                 }
                 var action='report';
                 subscriptionReport(action);
                 function subscriptionReport(action)
                 {
                    var month = $('#month_sub').val();
                    var year = $('#year_sub').val();
                    if(action=='search_month')
                    {
                        if(year==''){  alert("please select year."); $('#month_sub').val(''); return false;  }
                    }  
                    $("#subscriptionReportloader").fadeIn(100).html('<img src="img/image_process.gif" height="20" />');
                        $.ajax({
                        type:'POST',
                        url:'dashboardReport',
                        dataType: "json",
                        data:{show:action,month_sub:month,year_sub:year,action:'subscriptionReport'},
                        success:function(r){
                           //console.log(r.totalRecord);
                        if(r.totalRecord > 0){
                        var totalsubcription=r.data[0].totalsubcription;
                        //console.log("santosh=="+orderid); 
                         var totalplan=r.data[0].totalplan; var total_plan_payment_initiated=r.data[0].total_plan_payment_initiated;
                         var total_plan_success=r.data[0].total_plan_success;var total_plan_others=r.data[0].total_plan_others;
                         var total_payperview=r.data[0].total_payperview;var total_payperview_pi=r.data[0].total_payperview_pi;
                         var total_payperview_others=r.data[0].total_payperview_others;var total_payperview_success=r.data[0].total_payperview_success;
                         var totalsubscode=r.data[0].totalsubscode;  var total_subscode_success=r.data[0].total_subscode_success;
                         var totalSuccess=r.data[0].totalSuccess;  var totalpayment_initiated=r.data[0].totalpayment_initiated;
                         var total_others=r.data[0].total_others;
                         
                         var html='';
                            html+='<table class="table table-bordered">';
                           
                            html+='<tr><th>Plan Type</th><th>Total</th><th>Sucess</th><th>Payment Initiated</th><th>Others</th></tr>';
                            html+='<tr>';
                            html+='<td>Plan Subscription</td>';
                            html+='<td>'+totalplan+'</td>';
                            html+='<td>'+total_plan_success+'</td>';
                            html+='<td>'+total_plan_payment_initiated+'</td>';
                            html+='<td>'+total_plan_others+'</td>';
                            html+='</tr>';
                            html+='<tr>';
                            html+='<td>Pay Per view</td>';
                            html+='<td>'+total_payperview+'</td>';
                            html+='<td>'+total_payperview_success+'</td>';
                            html+='<td>'+total_payperview_pi+'</td>';
                            html+='<td>'+total_payperview_others+'</td>';
                            html+='</tr>';
                            html+='<tr>';
                            html+='<td>Subscription Code</td>';
                            html+='<td>'+totalsubscode+'</td>';
                            html+='<td>'+total_subscode_success+'</td>';
                            html+='<td>0</td>';
                            html+='<td>0</td>';
                            html+='</tr>';
                            html+='<tr><th>Total :</th><th>'+totalsubcription+'</th><th>'+totalSuccess+'</th><th>'+totalpayment_initiated+'</th><th>'+total_others+'</th></tr>';
                            html+='<tr><td colspan="5" align="right"><a href="report.php?code=subscription_detail">View Detail...</a></td></tr>';
                            html+='</table>';
                            $('#subscriptionReport').html(html);
                            $("#subscriptionReportloader").hide(); 
                           }
                          else{
                            $('#subscriptionReport').html("data not available!");
                            $("#subscriptionReportloader").hide(); 
                         } 
                        }
                    });
                 }
                 
              </script>   
           <?php } ?>  
          
          </div>  
          <div class='row'>
           <?php  if(in_array(31,$otherPermission)){ ?>    
          <script type="text/javascript" src="js/jquery-1.11.2.min.js"></script>    
          <div class="col-md-4">
              <div class="box1" style="background-color: #ffffff;">
                <div class="box-header box-primary">
                    <h3 class="box-title"> <i class="fa fa-video-camera "></i> Transcoded Video Info </h3>
                  <div class="box-tools">
                    <div class="input-group">
                        
                        <select name="year" id="year" class="form-control" style="width:80px;">
                        <option value="<?php echo $m; ?>"><?php echo $month_label; ?></option>   
                        <?php 
                        $year = date('Y');
                        $min = $year-5;
                        $max = $year;
                        for($i=$max; $i>=$min; $i--) {
                            echo '<option value='.$i.'>'.$i.'</option>';
                         } ?>
                        </select>
                        <select name="month" id="month" class="form-control"  style="width:110px;" onchange="getTranscodedVideoInfo('search_month');">
                            <option value=''>-Month-</option>
                            <?php for( $m=1; $m<=12; ++$m ) { 
                                $month_label = date('F', mktime(0, 0, 0, $m, 2));
                             ?>
                            <option value="<?php echo $m; ?>"><?php echo $month_label; ?></option>
                          <?php } ?>
                        </select>
                    </div>
                  </div>
                </div>
                <div class="box-body">
                <table class="table table-bordered">
                    <tr>
                      <th>Name</th>
                      <th>Total Content</th>
                      <th>Content Duration</th>
                    </tr>
                     <tr>
                      <td>Active Content</td>
                      <td id="actcount"> 
                       <span class="" id="actcount_loader" ></span>
                      </td>
                      <td id="actdur">
                         <span class="" id="actdur_loader" ></span>
                      </td>
                    </tr>
                     <tr>
                      <td>Inactive Content</td>
                      <td id="inactcount">
                        <span class="" id="inactcount_loader"></span>
                      </td>
                      <td id="inactdur"><span class="" id="inactdur_loader"></span></td>
                    </tr>
                     <tr>
                      <td>Deleted Content</td>
                      <td id="delcount">
                        <span class="" id="delcount_loader"></span>
                      </td>
                      <td id="deldur"><span class="" id="deldur_loader"></span></td>
                    </tr>
                    <tr>
                      <td>Total Content</td>
                      <td id="total_video">
                        <span class="" id="total_video_loader"></span>
                      </td>
                      <td id="vlength"><span class="" id="vlength_loader"></span></td>
                    </tr>
                   
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->

            </div>
              <script type='text/javascript'>
                 var act='all';
                 getTranscodedVideoInfo(act);
                 function getTranscodedVideoInfo(acti)
                 {
                    var month = $('#month').val();
                    var year = $('#year').val();
                    $("#actcount_loader,#actdur_loader,#inactcount_loader,#inactdur_loader,#delcount_loader,#deldur_loader,#total_video_loader,#vlength_loader").fadeIn(100).html('<img src="img/image_process.gif" height="20" />');
                        $.ajax({
                        type:'POST',
                        url:'coreData.php',
                        dataType: "json",
                        data:{show:acti,month:month,year:year,action:'transcoded_video_info'},
                        success:function(r){
                        if(r.status == 1){
                           var actdur=r.data[0].actdur;  
                           if(actdur==false){ actdur=0; }
                           var actcount=r.data[0].actcount;
                           if(actcount==null){ actcount=0; }
                           var inactdur=r.data[0].inactdur;
                           if(inactdur==false){ inactdur=0; }
                           var inactcount=r.data[0].inactcount;
                           if(inactcount==null){ inactcount=0; }
                           var deldur=r.data[0].deldur;
                           if(deldur==false){ deldur=0; }
                           var delcount=r.data[0].delcount;
                           if(delcount==null){ delcount=0; }
                           var vlength=r.data[0].vlength;
                           if(vlength==false){ vlength=0; }
                           $('#actcount').html(actcount); $("#actcount_loader").hide();
                           $('#actdur').html(actdur);  $("#actdur_loader").hide();
                           $('#inactcount').html(inactcount);  $("#inactcount_loader").hide();
                           $('#inactdur').html(inactdur);  $("#inactdur_loader").hide();
                           $('#delcount').html(delcount);  $("#delcount_loader").hide();
                           $('#deldur').html(deldur);  $("#deldur_loader").hide();
                           $('#total_video').html(r.data[0].total_video);  $("#total_video_loader").hide();
                           $('#vlength').html(vlength);  $("#vlength_loader").hide();
                           }
                           else{
                                //$('.user-content').slideUp();
                                //alert("User not found...");
                            } 
                        }
                    });
                 }
                 
              </script>   
           <?php } ?>  
          </div> 
          <div class='row'>
            <?php  if(in_array(28,$otherPermission) OR in_array(29,$otherPermission)) {?>
             <script type="text/javascript" src="js/jquery-1.11.2.min.js"></script>
             <script type="text/javascript">
               /* $(document).ready(function(){
                    $('button').click(function(){
                        if($(this).attr("value")=="day"){
                            $(".box").not(".day").hide();
                            $(".day").show();
                        }
                        if($(this).attr("value")=="week"){
                            $(".box").not(".week").hide();
                            $(".week").show();
                        }
                        if($(this).attr("value")=="month"){
                            $(".box").not(".month").hide();
                            $(".month").show();
                        }
                         if($(this).attr("value")=="year"){
                            $(".box").not(".year").hide();
                            $(".year").show();
                        }
                    });
                });*/
              </script> 
              <br/>
              <div class="col-md-12">
                 <div align="center"   class="row fileupload-buttonbar" style="padding-bottom: 1.4%">
                  <button type="button" value="day" class="btn btn-success fileinput-button" onclick="makeRequest('today')">
                     <span>Day</span>
                  </button>
                  <button type="button" value="week" class="btn btn-primary start" onclick="makeRequest('week')">
                     <span>Week</span>
                  </button>
                  <button type="button" value="month" class="btn btn-warning cancel" onclick="makeRequest('month')">
                      <span>Month</span>
                  </button>
                  <button type="button" value="year" class="btn btn-danger delete" onclick="makeRequest('year')">
                    <span>Year</span>
                  </button> 
                </div>
             </div>
            <?php } ?> 
           <?php   if(in_array(28,$otherPermission)) { 
            $qryAna="select google_client_id,client_secret,refresh_token,analytics_url from mail_config where publisherID='".$publisher_unique_id."'";
            $fetchAna=  db_select($conn,$qryAna);
            $google_client_id=$fetchAna[0]['google_client_id']; $client_secret=$fetchAna[0]['client_secret'];
            $refresh_token=$fetchAna[0]['refresh_token']; $analytics_url=$fetchAna[0]['analytics_url'];
            $exploadA=explode("&",$analytics_url);
            $mURl=$exploadA[0];
               ?>
         <script type="text/javascript">  
            getCode();  
            var videoResponseData=[];
            function _(id)
            {
                    return document.getElementById(id);
            }
              
            function getCode()
             {
                    var data = "refresh_token=<?php echo $refresh_token; ?>&grant_type=refresh_token&client_id=<?php echo $google_client_id; ?>&client_secret=<?php echo $client_secret; ?>";
                    var xhr=new XMLHttpRequest();
                    xhr.open("POST","https://www.googleapis.com/oauth2/v4/token",true);
                    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded'); 
                    xhr.send(data);
                    xhr.onreadystatechange=function(){if(xhr.readyState==4){parseJson(xhr.responseText)}};
             }
            function parseJson(response)
            {
                var obj=JSON.parse(response); 
                localStorage.setItem("access_token",obj.access_token)
                makeRequest('month');

            }
  
function makeRequest(duration)
{   
 videoResponseData=[]; 
 switch(duration) {
    case 'month':
       var tt="New User Video View of This " +duration+"";
        document.getElementById('days_msg').innerHTML=tt;
       var daydur="<?php echo $before1month=date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-1 month" ) )  ?>";
      ShowRegisterUserGraph("registerUser","month");  
      break;
         case 'week':
            var tt="Video View of This " +duration+"";
            document.getElementById('days_msg').innerHTML=tt;
            var daydur="<?php echo $before1week=date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-1 week" ) )  ?>";
         ShowRegisterUserGraph("registerUser","week");
         break;
        case 'year':
           var tt="Video View of This " +duration+"";
           document.getElementById('days_msg').innerHTML=tt;
           var daydur="<?php echo $before1week=date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-1 year" ) )  ?>";
           ShowRegisterUserGraph("registerUser","year"); 
        break;
         case 'today':
        var tt="Video View of This " +duration+"";
        document.getElementById('days_msg').innerHTML=tt;
        var daydur="<?php echo $before1week=date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) )) )  ?>";
        ShowRegisterUserGraph("registerUser","currentDay"); 
        break;
        
        default:
        //code block
} 
 
 var startDate=daydur;
 var today="<?php echo $before1week=date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) )) )  ?>";
 var endDate=today;
    var access_token="&access_token="+localStorage.getItem("access_token");
    //var url='https://www.googleapis.com/analytics/v3/data/ga?ids=ga%3A149139488&start-date='+startDate+'&end-date='+endDate+'&metrics=ga%3Ausers&dimensions=ga%3AeventAction%2Cga%3Adate'+access_token;
    var url="<?php echo $mURl; ?>&start-date="+startDate+"&end-date="+endDate+"&metrics=ga%3Ausers&dimensions=ga%3AeventAction%2Cga%3Adate"+access_token;
    var xhr=new XMLHttpRequest();
    xhr.open("GET",url,true);
    xhr.send();
    xhr.onreadystatechange=function(){if(xhr.readyState==4){parseResponse(xhr.responseText)}};
    
} 

function parseResponse(response)
{
  var obj=JSON.parse(response);
  var data=obj.rows;
  var totalsForAllResults=obj.totalsForAllResults;
  console.log(totalsForAllResults);
  var key = "ga:users"; 
  var ga_users = totalsForAllResults[key];
  console.log(ga_users);
  if(ga_users >0){
  var len=data.length;
  for(var i=0;i<len;i++)
       {
       	
       	   var evt=data[i][0];
           var date=data[i][1];
           var count=data[i][2];
           var y=date.substr(0,4);var m=date.substr(4,2);var d=date.substr(6,2);
            if(evt=="100_pct_watched"){
              videoResponseData.push( { x: new Date(y,m-1,d), y: parseInt(count) });	
            }
       }
 
 buildChart();//log();
  }
  
}     

function buildChart()
{
    var chart = new CanvasJS.Chart("chartContainer",
    {
        title:{
        text: "Current Record",
        fontSize: 20,
        //fontFamily: "Verdana",
       // labelFontWeight: "bold",
      },
      animationEnabled: true,
      axisX: {
          title: "Date",
            titleFontSize: 15,
              valueFormatString: "DD",
              //interval:0,
              intervalType: "day",
             labelFontSize: 14,
             titleFontColor: "black"
      },
      axisY:{
       //includeZero: false,
        title: "User View",
          titleFontSize: 15,
        interval: 1,
        valueFormatString: "#",
        gridThickness: 1,
        labelFontSize: 14,
        titleFontColor: "black"
      },
      data: [
      {        
        type: "line",
        //lineThickness: 3,        
        dataPoints:videoData()
        
      }
      
      
      ]
    });

chart.render();
}
function videoData(){return videoResponseData;}
</script>  
           <div class="col-md-6">
                <div class="box-header" style=" border-top: 3px solid #00c0ef; background-color: #fff">
                  <div class="" style="display:inherit">
                    <div  class="box-title"><span id="days_msg"></span> </div>
                    </div>
                    <div class="box-body chart-responsive">
                         <div class="chart" id="chartContainer" style="height:400px;"></div>
                     </div><!-- /.box-body -->
                  </div><!-- /.box -->
    
              </div> 
           <?php } ?> 
        <?php   if(in_array(29,$otherPermission)) {  ?>  
         <div class="col-md-6">
              <!-- LINE CHART -->
              <div class="box box-info"  style="display:inherit">
                <div class="box-header">
                    <h3 class="box-title" id="box_title"></h3>
                </div>
                <div class="box-body chart-responsive" id="container" style="height: 420px; width: 100%; font-weight: bold;">
                </div>
              </div>
              
         </div>

         
        <?php } ?> 
              
</div>
</section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php 
    include_once 'footer.php';  
    include_once 'commonJS.php';  
 ?>
    </div>

<script type="text/javascript" src="js/chart.js"></script> 
<script src="js/flot/highcharts.js" type="text/javascript"></script>
<!--<script type="text/javascript" src="http://code.highcharts.com/highcharts.js"></script>-->
<!--<script src="js/flot/exporting.js" type="text/javascript"></script>-->

<script type="text/javascript">
//ShowRegisterUserGraph("registerUser","currentDay");                       
function ShowRegisterUserGraph(action,subaction)
{
    var info = 'action='+action+'&subAction='+subaction;
    $.ajax({
    type: "POST",
    url: "dashboardReport",
    //dataType: 'json',
    data: info,
         success: function(result){
           if(subaction=='currentDay') {  
            $("#box_title").html("Today's New User");
            //$("#container_week").html('');
            //$("#container_month").html('');$("#container_year").html('');
            $("#container").html(result);
           }
           if(subaction=='week') {
            $("#box_title").html("New Users of This Week");
            //$("#container").html('');
            //$("#container_month").html('');$("#container_year").html('');
            $("#container").html(result);
           }
           if(subaction=='month') { 
            $("#box_title").html("New Users of This Month");
            //$("#container").html('');
            //$("#container_week").html('');$("#container_year").html('');
            $("#container").html(result);
           }
           if(subaction=='year') {  
            $("#box_title").html("New Users of This Year");
            //$("#container").html('');
            //$("#container_week").html('');$("#container_month").html('');
            $("#container").html(result);
           }
       }
  });

 }

</script>     
</body>
</html>
