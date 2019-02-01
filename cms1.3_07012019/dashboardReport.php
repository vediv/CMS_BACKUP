<?php
include_once 'corefunction.php';
$action=$_POST['action']; $subAction=$_POST['subAction'];
switch($action)
{
    case"registerUser":
    switch($subAction)
    {
        case "currentDay":
        $currentdate=array(); $Total_registration=array();
      	 $count ="SELECT COUNT(1) AS Total_registration ,EXTRACT(HOUR FROM added_date) AS Hours
         FROM user_registration WHERE added_date > DATE(NOW()) GROUP BY EXTRACT(HOUR FROM added_date);";
         $fetch1 = db_select($conn,$count);
         foreach ($fetch1 as $fetch)
           {
             $currentdate[]=$fetch['Hours'];
             $Total_registration[]=$fetch['Total_registration'];
           }
        //$hoursImplode = "'".implode("','",$currentdate)."'";
        //$total_registrationImplode=implode(',',$Total_registration);
        //echo json_encode(array('hours' =>$hoursImplode,'total_registration' =>$total_registrationImplode));
           print_r($Total_registration);
        ?>
       <script type="text/javascript">
         $('#container').highcharts({
                chart: {
                },
                type: 'line',
                xAxis: {
                    categories: [<?php echo implode(',', $currentdate);?>]
                },
                yAxis: {
                allowDecimals: false,
                title: {
                    text: 'User Registration'
                }
                },
                tooltip: {
                    formatter: function ()
                    {
                        return '<b>' + this.series.name + '</b><br/>' +
                         '<b>'+'Time: '+'</b>'+this.x + ':00<br/>' +
                          '<b>'+'Users: '+'</b>'+ this.y;
                    }

                },
                title: {
                    text: 'Current Record'
                },
                series: [{
                    name: 'Hours Record',
                    data: [<?php echo implode(',',$Total_registration);?>]
                }]
               });
            </script>
    <?php break;
    case "week":
        $week=array(); $Total_registration=array();
        $count ="SELECT COUNT(1) AS Total_registration ,EXTRACT(DAY FROM added_date) AS Dates
                  FROM user_registration WHERE added_date > DATE(NOW() - INTERVAL 7 DAY)
                  GROUP BY EXTRACT(DAY FROM added_date)";
        $fetch1 = db_select($conn,$count);
       foreach ($fetch1 as $fetch)
	 {
	     $week[]=$fetch['Dates'];
             $Total_registration[]=$fetch['Total_registration'];
	 }

        ?>
       <script type="text/javascript">
         $('#container').highcharts({
                chart: {
                },
                title: {
                text: 'Current Record'
                },
                xAxis: {
                    text: 'Week Date',
                    categories: [<?php echo implode(',', $week);?>]
                },
               yAxis: {
                allowDecimals: false,
                title: {
                    text: '<b>User Registration</b>'
                }
                },
                tooltip: {
                    formatter: function ()
                    {
                        return '<b>' + this.series.name + '</b><br/>' +
                         '<b>'+'Time: '+'</b>'+this.x + ':00<br/>' +
                          '<b>'+'Users: '+'</b>'+ this.y;
                    }

                },
                series: [{
                     name: 'Weekly Record',
                    data: [<?php echo implode(',',$Total_registration);?>]
                }]
               });
            </script>


   <?php  break;
    case "month":
         $Months=array(); $Total_registration=array();
      	 $count ="SELECT COUNT(1) AS Total_registration,EXTRACT(DAY FROM added_date) AS Dates FROM user_registration
                  WHERE (added_date BETWEEN  DATE_FORMAT(NOW() ,'%Y-%m-01') AND NOW() )
                  GROUP BY EXTRACT(DAY FROM added_date); ";
          $fetch1 = db_select($conn,$count);
          foreach ($fetch1 as $fetch)
	   {
		         $Months[]=$fetch['Dates'];
 		        $Total_registration[]=$fetch['Total_registration'];
           }

        ?>
       <script type="text/javascript">
         $('#container').highcharts({
                chart: {
                },
                title: {
                text: 'Current Record'
                },
                xAxis: {
         	 title: {
                text: 'Month Date'
                      },
                categories: [<?php echo implode(',', $Months);?>]
                },
                yAxis: {
                allowDecimals: false,
                title: {
                    text: '<b>User Registration</b>'
                }
                },
                tooltip: {
                   formatter: function ()
                        {
                            return '<b>' + this.series.name + '</b><br/>' +
                             '<b>'+'Date: '+'</b>'+this.x + '<br/>' +
                              '<b>'+'Users: '+'</b>'+ this.y;
                        }

                },
                series: [{
                     name: 'Monthly Record',
                    data: [<?php echo implode(',',$Total_registration);?>]
                }]
               });
            </script>


   <?php  break;
    case "year":
    $year=array(); $Total_registration=array();
      	 $yearQuery ="SELECT COUNT(1) AS Total_registration,EXTRACT(MONTH FROM added_date) AS Months FROM user_registration
				  WHERE (added_date BETWEEN  DATE_FORMAT(NOW() ,'%Y-01-01') AND NOW() )
				  GROUP BY EXTRACT(MONTH FROM added_date)";
         $fetchYear = db_select($conn,$yearQuery);
         foreach ($fetchYear as $fetchY)
         {   $monthName=$fetchY['Months'];
             //$monthName = date("M", mktime(0, 0, 0, $fetchY['Months'], 10));
             $year[]=$monthName;
             $Total_registration[]=$fetchY['Total_registration'];
         }
         print_r($year);
        ?>
       <script type="text/javascript">
         $('#container').highcharts({
                chart: {
                },
                title: {
                text: 'Current Record'
                },
                xAxis: {
         	 title: {
                text: 'Months'
                      },
                categories: [<?php echo implode(',',$year); //echo  "'".implode("','",$year)."'"; ?>]
                },
                yAxis: {
                allowDecimals: false,
                title: {
                    text: '<b>User Registration</b>'
                }
                },
                tooltip: {
                   formatter: function ()
                    {
                        return '<b>' + this.series.name + '</b><br/>' +
                         '<b>'+'Month: '+'</b>'+this.x + '<br/>' +
                          '<b>'+'Users: '+'</b>'+ this.y;
                    }

                },
                series: [{
                    name: 'Yearly Record',
                    data: [<?php echo implode(',',$Total_registration);?>]
                }]
               });
            </script>


    <?php }
    break;
        case "subscriptiondata":
        $subaction=$_POST['subaction'];
        if($subaction=='cardinfo')
        {
           $querySub ="SELECT COUNT(*) as totaldata,SUM(IF (status_code='300',1,0)) AS total_sucess,
           SUM(IF (status_code='0300',1,0)) AS total_sucess_new,SUM(IF (order_msg='Success',1,0)) AS tsucess,
           SUM(IF (payment_for='plan',1,0)) AS total_subcription_only,
           SUM(IF (payment_for='wallet',1,0)) AS total_payPerView,
           SUM(IF (payment_for='subs_code',1,0)) AS total_subsCode
           FROM user_payment_details";
           $fetchTotal = db_select($conn,$querySub);
           $totalSub=$fetchTotal[0]['totaldata']; $total_sucess=$fetchTotal[0]['total_sucess'];
           $total_sucess_new=$fetchTotal[0]['total_sucess_new']; $total_subcription_only=$fetchTotal[0]['total_subcription_only'];
           $total_payPerView=$fetchTotal[0]['total_payPerView'];$total_subsCode=$fetchTotal[0]['total_subsCode'];
           $tsuccessSub=$total_sucess+$total_sucess_new; $failSub=$totalSub-$tsuccessSub;
           //query to get total Amount(Revenue)
           $qryRevenue="SELECT SUM(IF(payment_for='plan',amount,0)) AS subscripAmount,SUM(IF(payment_for='wallet',amount,0)) AS payPerAmount
           FROM user_payment_details WHERE order_status ='Success'";
           $fetchRevenue = db_select($conn,$qryRevenue);
           $subscripAmount=$fetchRevenue[0]['subscripAmount']; $payPerAmount=$fetchRevenue[0]['payPerAmount'];
           $qryAds="select SUM(amount) AS adsAmount from ads_revenue where tag='ads_revenue'";
           $fetchads = db_select($conn,$qryAds);
           $adsAmount=$fetchads[0]['adsAmount'];
           $totalRevenue=$subscripAmount+$payPerAmount+$adsAmount;
           $row2=array('totalSub' =>$totalSub,'successSub' => $tsuccessSub,'failSub' => $failSub,
            'total_subcription_only' => $total_subcription_only,'total_payPerView' => $total_payPerView,
            'total_subsCode' => $total_subsCode,'TotalSubscribtionAmount' =>$subscripAmount,
            'TotalPayPerViewAmount' =>$payPerAmount,'TotalAdsAmount' =>$adsAmount,'TotalRevenue' =>$totalRevenue);
           $result[]= $row2;
           sleep(1);
           echo json_encode(array('data' =>$result));
          //db_close($conn);
        }
        break;
        case "latest_subscription":
        $show=$_POST['show']; $year=$_POST['year']; $month=$_POST['month'];
        $querysub="SELECT upd.trans_id,upd.orderid,upd.added_date,upd.order_status,upd.order_msg,upd.amount,ur.uid,ur.user_id
        FROM user_payment_details upd left join user_registration ur ON upd.userid=ur.uid
        WHERE YEAR(upd.added_date) = $year AND MONTH(upd.added_date) =$month AND order_status!='Aborted'  order by UNIX_TIMESTAMP(upd.added_date) DESC LIMIT 0,5";
        $fetchData = db_select($conn,$querysub);
        $totalRecord = db_totalRow($conn,$querysub);
        $result = array();$rows=array();
        foreach ($fetchData as $row) {
         $rows['uid']=$row['uid'];
         $rows['trans_id']=$row['trans_id'];
         $rows['OrderID']=$row['orderid'];
         $rows['name']=$row['uname'];
         $rows['added_date']=$row['added_date'];
         $rows['order_msg']=$row['order_status']==NULL?'NA':$row['order_status'];;
         if($rows['trans_id']!=''){ $rows['order_msg']=$row['order_status']==NULL?'NA':$row['order_status']; }
         $rows['amount']=$row['amount'];
         $result[]=$rows;
        }

        echo json_encode(array('status' =>1,'data' =>$result,'totalRecord'=>$totalRecord));
        break;
        case "subscriptionReport":
        $show=$_POST['show']; $year=$_POST['year_sub']; $month=$_POST['month_sub'];
        $querytotal="SELECT Count(*) as totalCount,
        SUM(IF(payment_for='plan',1,0)) AS totalplan,
        SUM(IF(payment_for='wallet',1,0)) AS total_payperview,
        SUM(IF(payment_for='subs_code',1,0)) AS totalsubscode ,
        SUM(IF(payment_for='plan' AND order_status='Payment Initiated',1,0)) AS total_plan_payment_initiated,
        SUM(IF(payment_for='plan' AND (order_status='Success'),1,0)) AS total_plan_success,
        SUM(IF(payment_for='plan' AND (order_status<>'Payment Initiated' AND order_status<>'Success' ),1,0)) AS total_plan_others,
        SUM(IF(payment_for='wallet' AND order_status='Payment Initiated',1,0)) AS total_payperview_pi,
        SUM(IF(payment_for='wallet' AND (order_status='Success'),1,0)) AS total_payperview_success,
        SUM(IF(payment_for='wallet' AND (order_status<>'Payment Initiated' AND order_status<>'Success' ),1,0)) AS total_payperview_others,
        SUM(IF(payment_for='subs_code' AND (order_status='Success'),1,0)) AS total_subscode_success
        FROM user_payment_details  ";
        if($year!=''&& $month=='')
        {
           $querytotal.= " WHERE YEAR(added_date) = $year";
        }
        if($year!=''&& $month!='')
        {
           $querytotal.= " WHERE YEAR(added_date) = $year AND MONTH(added_date) =$month";
        }
        //echo $querytotal;
        $fetchData = db_select($conn,$querytotal);
        $totalRecord = db_totalRow($conn,$querytotal);
        $result = array();$rows=array();
        foreach ($fetchData as $row) {
         $rows['totalsubcription']=$row['totalCount'];
         $rows['totalplan']=$row['totalplan']==NULL?0:$row['totalplan'];
         $rows['total_plan_payment_initiated']=$row['total_plan_payment_initiated']==NULL?0:$row['total_plan_payment_initiated'];
         $rows['total_plan_success']=$row['total_plan_success']==NULL?0:$row['total_plan_success'];
         $rows['total_plan_others']=$row['total_plan_others']==NULL?0:$row['total_plan_others'];
         $rows['total_payperview']=$row['total_payperview']==NULL?0:$row['total_payperview'];
         $rows['total_payperview_pi']=$row['total_payperview_pi']==NULL?0:$row['total_payperview_pi'];
         $rows['total_payperview_success']=$row['total_payperview_success']==NULL?0:$row['total_payperview_success'];
         $rows['total_payperview_others']=$row['total_payperview_others']==NULL?0:$row['total_payperview_others'];
         $rows['totalsubscode']=$row['totalsubscode']==NULL?0:$row['totalsubscode'];
         $rows['total_subscode_success']=$row['total_subscode_success']==NULL?0:$row['total_subscode_success'];
         $rows['totalSuccess']= $rows['total_plan_success']+$rows['total_payperview_success']+ $rows['total_subscode_success'];
         $rows['totalpayment_initiated']= $rows['total_plan_payment_initiated']+$rows['total_payperview_pi'];
         $rows['total_others']= $rows['total_plan_others']+$rows['total_payperview_others'];
         $result[]=$rows;
        }
        echo json_encode(array('status' =>1,'data' =>$result,'totalRecord'=>$totalRecord));
        break;
         

}
?>
