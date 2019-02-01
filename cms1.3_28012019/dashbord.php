<?php 
include_once 'corefunction.php';
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title><?php echo ucwords(PROJECT_TITLE)."- DashBoard";?></title>
    <style type="text/css">
    .box {  display: none;}
    #highcharts-4, #highcharts-8, #highcharts-12{ width:500px !important; }
</style>
    <!-- Bootstrap 3.3.2 -->
    <script type="text/javascript" src="js/jquery-1.11.2.min.js"></script>
    <script type="text/javascript">
			$(document).ready(function(){
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
			});
</script>
<!--user video graph-->
 <script type="text/javascript">
  var videoResponseData=[];
  
  function _(id)
  {
  	return document.getElementById(id);
  }
  
  function initBody()
{
  getCode(); 
}

function getCode()
 {
        var data = "refresh_token=1%2FBvWdJhcefd3iJvNkzbbbMX3B_81Jsw1BhStcM0C8vxo&grant_type=refresh_token&client_id=231090503373-7ftq27h2cfslnr8189iadb9e7f0dp7rn.apps.googleusercontent.com&client_secret=NzPrRCJSyz7sD9dtdhawia13";
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
        break;
         case 'week':
            var tt="Video View of This " +duration+"";
            document.getElementById('days_msg').innerHTML=tt;
            var daydur="<?php echo $before1week=date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-1 week" ) )  ?>";
        
        break;
        case 'year':
           var tt="Video View of This " +duration+"";
           document.getElementById('days_msg').innerHTML=tt;
           var daydur="<?php echo $before1week=date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-1 year" ) )  ?>";
       
        break;
         case 'today':
            var tt="Video View of This " +duration+"";
        document.getElementById('days_msg').innerHTML=tt;
        var daydur="<?php echo $before1week=date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) )) )  ?>";
        break;
    default:
        //code block
} 
 
 var startDate=daydur;
 var today="<?php echo $before1week=date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) )) )  ?>";
 var endDate=today;

console.log(startDate+"---"+endDate);   
    
    var access_token="&access_token="+localStorage.getItem("access_token");
    
   
    var url='https://www.googleapis.com/analytics/v3/data/ga?ids=ga%3A149139488&start-date='+startDate+'&end-date='+endDate+'&metrics=ga%3Ausers&dimensions=ga%3AeventAction%2Cga%3Adate'+access_token;

    var xhr=new XMLHttpRequest();
    xhr.open("GET",url,true);
    xhr.send();
    xhr.onreadystatechange=function(){if(xhr.readyState==4){parseResponse(xhr.responseText)}};
    
} 


function parseResponse(response)
{
 var obj=JSON.parse(response);
 var data=obj.rows;
 var len=data.length;
  for(var i=0;i<len;i++)
       {
       	
       	   var evt=data[i][0];
           var date=data[i][1];
           var count=data[i][2];
           var y=date.substr(0,4);var m=date.substr(4,2);var d=date.substr(6,2);
            if(evt=="100_pct_watched"){
            //alert(evt);break;
              videoResponseData.push( { x: new Date(y,m-1,d), y: parseInt(count) });	
            }
            
                  
       }
 
 buildChart();//log();
}     

function buildChart()
{
    var chart = new CanvasJS.Chart("chartContainer",
    {
        title:{
        text: "Current Record",
        fontSize: 18,
        fontFamily: "Verdana",
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

<script type="text/javascript" src="js/chart.js"></script></head>
<!--end-->



  </head>
  <body class="skin-blue" onload="initBody()">
    <div class="wrapper">
      <?php include_once 'header.php';
      include_once 'lsidebar.php';?>
     <link href="js/flot/morris.css" rel="stylesheet" type="text/css" />
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Dashboard  <?php //echo "<pre>"; print_r($_SESSION); echo "</pre>"; ?>    
            <small>Control panel</small>
          </h1>
          <br>
         
          <!-- Dynamic View of All Views Of CHARTS GRAPHS -->
		
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-home" title="Home"></i> Home</a></li>
            <li class="active">Dashboard </li>
          </ol>
        </section>
    <!-- Main content -->
        <section class="content">
        <div class="row">
         <?php  if($_SESSION['publisher_info']['acess_level'] =='p' || $_SESSION['publisher_info']['acess_level'] =='u'){  ?>
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-aqua">
              	<?php
                $results ="SELECT COUNT(1) AS totrec, SUM(IF (STATUS='1',1,0)) AS totactive,SUM(IF (STATUS='0',1,0)) AS totdeactive FROM user_registration";
                $fetch = db_select($results);
	        $totalrec=$fetch[0]['totrec'];  $totalactive=$fetch[0]['totactive'];  $totaldeactive=$fetch[0]['totdeactive'];
                $count =db_totalRow($results);
               ?>
	     <!--
		 <div class="inner"> <h3><?php echo $totalrec ?></h3><p>Total Registration</p></div>
	<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>-->
		  <div class="inner"  style="text-align: center">
	     	 <i class="fa fa-bar-chart-o fa-5x"></i>
	     	  <h3><?php echo $totalrec ?></h3>
	     </div>
                <!--<div class="icon"><i class="ion ion-bag"></i></div>-->
               <a href="user_list.php?showall=showall" class="small-box-footer"><p>Total Registration</p> </a>
              </div>
            </div><!-- ./col -->         
             <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <!--
              <div class="small-box bg-teal-gradient">
                              <div class="inner">
                              <h3><?php echo $totalactive ?></h3><p>Active Users</p>
                              </div>               
                              <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                            </div>-->
              
              <div class="small-box bg-color-brown">
                <div class="inner" style="text-align: center">
                <i class="fa fa-users fa-5x"></i>
                 <h3><?php echo $totalactive==''?"0":$totalactive; ?></h3>
                </div>
               <!-- <div class="icon"><i class="ion ion-stats-bars"></i></div>-->
                <a href="user_list.php?showall=active" class="small-box-footer small-box-footer-yellow "><p>Active Users</p> </a>
              </div>
              
            </div><!-- ./col -->
       <div class="col-lg-3 col-xs-6">
              <!-- small box -->
               <div class="small-box bg-color-purple">
              		<?php
	              	  $count ="select sum(length_in_msecs) as vlength,count(id) as totalcount from kaltura.entry where status='2' and type='1' and partner_id='$partnerID' and categories_ids!='824'";
		                $fetch = db_select($count);
			   	$vlength=$fetch[0]['vlength'];  $totalvideo=$fetch[0]['totalcount']; 
		                // $count =db_totalRow($results);
				    ?>
               <div class="inner" style="text-align: center">
                    	<i class="fa fa-video-camera fa-5x" aria-hidden="true"></i>

                      <h3><?php echo $totalvideo ?></h3>
                    </div>
               <!-- <div class="icon"><i class="ion ion-stats-bars"></i></div>-->
                <a href="media_content.php" class="small-box-footer small-box-footer-purple"><p>Total Video</p> </a>
              </div>
            </div><!-- ./col -->
           
          <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-color-red">
              		<?php
	            $seconds= $vlength/1000;
			//for seconds
			if($seconds> 0)
			{
			$sec= "" . ($seconds%60);
			if($seconds % 60 <10)
			{
			$sec= "0" . ($seconds%60);
			}
			}
			 else{
                            $sec= "00";
                        }			//for mins
			if($seconds > 60)
				{
				$mins= "". ($seconds/60%60);
				if(($seconds/60%60)<10)
				{
				$mins= "0" . ($seconds/60%60);
				}
				}
				else
				{
				$mins= "00";
				}
			//for hours
			if($seconds/60 > 60)
			{
			$hours= "". floor($seconds/60/60);
			if(($seconds/60/60) < 10)
			{
			$hours= "0" . floor($seconds/60/60);
			}
			
			}
			else
			{
			$hours= "00";
			}

                   $time_format= "" . $hours . ":" . $mins . ":" . $sec; //00:15:00   
		               
		        ?>
                 <div class="inner" style="text-align: center">
                    		<i class="fa fa-clock-o fa-5x" aria-hidden="true"></i>
                  <h3><?php echo $time_format; ?></h3> 
                </div>
               <!-- <div class="icon"><i class="ion ion-stats-bars"></i></div>-->
                 <a href="#" class="small-box-footer small-box-footer-red"><p>Total Content Duration </p> </a>
              </div>
            </div>
         
         <?php  } ?> 
        </div>
      
    
      
        <!-- code for Video Views Divs-->
        
         	
         	
         	   	 <div class="row">
              <div class="col-md-12">
              	   <div align="center"   class="row fileupload-buttonbar" style="padding-bottom: 1.4%">
                <!-- The fileinput-button span is used to style the file input field as button -->
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
            <!-- The global progress state -->
        </div>
         	<br>
         	<div class="col-md-6">
            
              <!-- VIdeo view  CHART -->
                 
                <div class="box-header" style=" border-top: 3px solid #00c0ef; background-color: #fff">
                  <div class=""+duration+"box box-primary" style="display:inherit">
                  	
                    <div  class="box-title"><span id="days_msg"></span> </div>
                    </div>
                    <div class="box-body chart-responsive">
                         <div class="chart" id="chartContainer" style="height:400px;"></div>
                     </div><!-- /.box-body -->
                  </div><!-- /.box -->
    
              </div> 
              
              <!--<div style="display:inherit" class="day box box-primary">
               <div class="box-header"><span id="days_msg"></span> </div>
              
               </div>
                <div class="box-body chart-responsive">
                 <div  class="chart" id="chartContainer" style="height: 400px;"></div>
               </div>
            -->
           
         <!-- /.box -->
           <!-- code for Wibsite Views Divs-->
            
            <div class="col-md-6">
              <!-- LINE CHART -->
              <div class="box box-info day"  style="display:inherit">
                <div class="box-header">
                  <h3 class="box-title">Today's New User</h3>
                </div>
                <div class="box-body chart-responsive" id="container4">
                  <div class="chart" id="line-chart" style="height: 300px;"></div>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
              
              <div class="box box-info week">
                <div class="box-header">
                  <h3 class="box-title">New Users of This Week</h3>
                </div>
                <div class="box-body chart-responsive" id="container5">
                  <div class="chart" id="line-chart" style="height: 300px;"></div>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
              
               <div class="box box-info month">
                <div class="box-header">
                  <h3 class="box-title">New Users of This Month</h3>
                </div>
                <div class="box-body chart-responsive" id="container6">
                  <div class="chart" id="line-chart" style="height: 300px;"></div>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
              
               <div class="box box-info year">
                <div class="box-header">
                  <h3 class="box-title">New Users of This Year</h3>
                </div>
                <div class="box-body chart-responsive" id="container7">
                  <div class="chart" id="line-chart" style="height: 300px;"></div>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
              
            </div><!-- /.col (RIGHT) -->
          </div><!-- /.row -->
       
        </div>
       
           </section><!-- /.content -->
         <?php
            include"footer.php";
      ?>
  
         </div><!-- /.content-wrapper --> </div><!-- ./wrapper -->
   
   <!-- Bootstrap 3.3.2 -->
  <script src="js/flot/highcharts.js" type="text/javascript"></script>
  <script src="js/flot/exporting.js" type="text/javascript"></script>
  
  
 <!--All Queries of Videos Views REcords-->
 
 <!--Current Year Wise REcords-->
   <?php
         $date3=array(); $view_count3=array();
      	 $count ="SELECT COUNT(1) AS count_view,EXTRACT(MONTH FROM last_view) AS Months FROM view_log 
                  WHERE (last_view BETWEEN  DATE_FORMAT(NOW() ,'%Y-01-01') AND NOW() )
                  GROUP BY EXTRACT(MONTH FROM last_view);";
         $fetch1 = db_select($count);
		 //foreach ($fetch1 as $fetch) 
		 //{
		         //$date3[]=$fetch['Months'];  
 		         //$view_count3[]=$fetch['count_view'];   
		// }
        
   ?> 
    <!--EnD-->
  <!--Current Month Wise REcords-->
      <?php
           $date2=array(); $view_count2=array();
      	   $count ="SELECT COUNT(1) AS count_view,EXTRACT(DAY FROM last_view) AS Month_Days FROM view_log 
                  WHERE (last_view BETWEEN  DATE_FORMAT(NOW() ,'%Y-%m-01') AND NOW() ) 
                  GROUP BY EXTRACT(DAY FROM last_view);";
             $fetch1 = db_select($count);
		   //foreach ($fetch1 as $fetch) 
		  // {
		       //  $date2[]=$fetch['Month_Days']; // echo "<br>";
 		        // $view_count2[]=$fetch['count_view'];   // echo "<br>";
		   //}
     ?> 
      <!--EnD-->
    <!--Current Week Wise REcords-->
   <?php
         $date1=array(); $view_count1=array();
      	 $count ="SELECT COUNT(1) AS count_view ,EXTRACT(DAY FROM last_view) AS Week_Date FROM view_log 
         WHERE last_view> DATE(NOW())- INTERVAL 7 DAY GROUP BY EXTRACT(DAY FROM last_view)";
         $fetch1 = db_select($count);
		 //foreach ($fetch1 as $fetch) 
		 //{
		      //  $date1[]=$fetch['Week_Date'];  
 		       // $view_count1[]=$fetch['count_view'];   
		 //}
   ?> 
   <!--EnD-->
   
   <!--Current Date REcords-->
   <?php
   		$date=array(); $view_count=array();
         $count ="SELECT COUNT(1) AS count_view ,EXTRACT(HOUR FROM last_view) AS hours 
         FROM view_log WHERE last_view> DATE(NOW()) GROUP BY EXTRACT(HOUR FROM last_view)";
         $fetch1 = db_select($count);
		 //foreach ($fetch1 as $fetch) 
		 //{
		        //$date[]=$fetch['hours'];  
		        //$view_count[]=$fetch['count_view'];  
		 //}
        // $count =db_totalRow($results);
   ?> 
     <!--EnD-->
  <!--END All Queries of Videos Views REcords-->
  
 <!--========================================================================================================================-->
  <!--All Queries of USER REGISTRATIONS REcords-->
 
 <!--Current Year Wise REcords-->
   <?php
         $Months3=array(); $Total_registration3=array();
      	 $count ="SELECT COUNT(1) AS Total_registration,EXTRACT(MONTH FROM added_date) AS Months FROM user_registration 
				  WHERE (added_date BETWEEN  DATE_FORMAT(NOW() ,'%Y-01-01') AND NOW() )
				  GROUP BY EXTRACT(MONTH FROM added_date);";
         $fetch1 = db_select($count);
		 foreach ($fetch1 as $fetch) 
		 {
		         $Months3[]=$fetch['Months'];  
 		         $Total_registration3[]=$fetch['Total_registration'];   
		 }
        
   ?> 
    <!--EnD-->
  <!--Current Month Wise REcords-->
      <?php
           $Months2=array(); $Total_registration2=array();
      	 $count ="SELECT COUNT(1) AS Total_registration,EXTRACT(DAY FROM added_date) AS Dates FROM user_registration 
                  WHERE (added_date BETWEEN  DATE_FORMAT(NOW() ,'%Y-%m-01') AND NOW() )
                  GROUP BY EXTRACT(DAY FROM added_date); ";
         $fetch1 = db_select($count);
		 foreach ($fetch1 as $fetch) 
		 {
		         $Months2[]=$fetch['Dates'];  
 		         $Total_registration2[]=$fetch['Total_registration'];   
		 }
     ?> 
      <!--EnD-->
    <!--Current Week Wise REcords-->
   <?php
          $Months1=array(); $Total_registration1=array();
      	 $count ="SELECT COUNT(1) AS Total_registration ,EXTRACT(DAY FROM added_date) AS Dates 
                  FROM user_registration WHERE added_date > DATE(NOW() - INTERVAL 7 DAY) 
                  GROUP BY EXTRACT(DAY FROM added_date)";
         $fetch1 = db_select($count);
		 foreach ($fetch1 as $fetch) 
		 {
		         $Months1[]=$fetch['Dates'];  
 		         $Total_registration1[]=$fetch['Total_registration'];   
		 }
   ?> 
   <!--EnD-->
   
   <!--Current Date REcords-->
   <?php
   		 $Months=array(); $Total_registration=array();
      	 $count ="SELECT COUNT(1) AS Total_registration ,EXTRACT(HOUR FROM added_date) AS Hours 
                  FROM user_registration WHERE added_date > DATE(NOW()) GROUP BY EXTRACT(HOUR FROM added_date);";
         $fetch1 = db_select($count);
		 foreach ($fetch1 as $fetch) 
		 {
		         $Months[]=$fetch['Hours'];  
 		         $Total_registration[]=$fetch['Total_registration'];   
		 }
   ?> 
     <!--EnD-->
    <!-- END All Queries of USER REGISTRATIONS REcords-->

 <!-- Graphs Page script For Videos Views Starts   -->


     

 <!--USER REGISTRATION chart block  Page script Starts -->  
 <!--24 hour chart block start -->
<script type="text/javascript">
$(function () {
	 $(document).ready(function () {
        Highcharts.setOptions({
            global: {
                useUTC: false
            }
        });
    $('#container4').highcharts({
    	
    	type: 'line',
        title: {
                text: 'Current Record'
              },
         xAxis: {
         	 title: {
                text: 'Hours'
                      },  
                categories: [<?php echo implode(',', $Months);?>]
                },
        yAxis: {
            title: {
                text: 'User Registration'
            },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                           }]
                 },
                
        tooltip: {
                formatter: function () 
                {
                    return '<b>' + this.series.name + '</b><br/>' +
                     '<b>'+'Time: '+'</b>'+this.x + ':00<br/>' +
                      '<b>'+'Users: '+'</b>'+ this.y;
                }
			
            },
            exporting: {
                enabled: false
              
            },
      plotOptions: {
            line: {
                dataLabels: {
                    enabled: true
                },
                enableMouseTracking: true
            }
        },
        series: [{
            name: 'Hours Record',
            marker: {
                symbol: 'diamond'
            },
            data: [<?php echo implode(',',$Total_registration);?>]
        }]
    });
    });
});
</script>
<!--END-->


 <!--Current Week chart block start -->  
<script type="text/javascript">
$(function () {
	 $(document).ready(function () {
        Highcharts.setOptions({
            global: {
                useUTC: false
            }
        });
    $('#container5').highcharts({
    	
    	type: 'line',
        title: {
                text: 'Current Record'
              },
         xAxis: {
         	
                 title: {
                text: 'Week Date'
                      },         	
                categories: [<?php echo implode(',', $Months1);?>]
               
                },
        yAxis: {
            title: {
                text: 'User Registration'
            },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                           }]
                 },
                
        tooltip: {
                formatter: function () 
                {
                    return '<b>' + this.series.name + '</b><br/>' +
                     '<b>'+'Date: '+'</b>'+this.x + '<br/>' +
                      '<b>'+'Users: '+'</b>'+ this.y;
                }
			
            },
            exporting: {
                enabled: false
              
            },
      plotOptions: {
            line: {
                dataLabels: {
                    enabled: true
                },
                enableMouseTracking: true
            }
        },
        series: [{
            name: 'Weekly Record',
            marker: {
                symbol: 'diamond'
            },
            data: [<?php echo implode(',',$Total_registration1);?>]
        }]
    });
    });
});
</script>
<!--END-->

    
     <!--Current Month chart block start -->  
<script type="text/javascript">
$(function () {
	 $(document).ready(function () {
        Highcharts.setOptions({
            global: {
                useUTC: false
            }
        });
    $('#container6').highcharts({
    	
    	type: 'line',
        title: {
                text: 'Current Record'
              },
         xAxis: {
         	 title: {
                text: 'Month Date'
                      },  
                categories: [<?php echo implode(',', $Months2);?>]
                },
        yAxis: {
            title: {
                text: 'User Registration'
            },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                           }]
                 },
                
        tooltip: {
                formatter: function () 
                {
                    return '<b>' + this.series.name + '</b><br/>' +
                     '<b>'+'Date: '+'</b>'+this.x + '<br/>' +
                      '<b>'+'Users: '+'</b>'+ this.y;
                }
			
            },
            exporting: {
                enabled: false
              
            },
      plotOptions: {
            line: {
                dataLabels: {
                    enabled: true
                },
                enableMouseTracking: true
            }
        },
        series: [{
            name: 'Monthly Record',
            marker: {
                symbol: 'diamond'
            },
            data: [<?php echo implode(',',$Total_registration2);?>]
        }]
    });
    });
});
</script>
<!--END-->
    
   
 <!--Current Year chart block start -->  
<script type="text/javascript">
$(function () {
	 $(document).ready(function () {
        Highcharts.setOptions({
            global: {
                useUTC: false
            }
        });
    $('#container7').highcharts({
    	
    	type: 'line',
        title: {
                text: 'Current Record'
              },
         xAxis: {
         	 title: {
                text: 'Months'
                      },  
                categories: [<?php echo implode(',', $Months3);?>]
                },
        yAxis: {
            title: {
                text: 'User Registration'
            },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                           }]
                 },
                
        tooltip: {
                formatter: function () 
                {
                    return '<b>' + this.series.name + '</b><br/>' +
                     '<b>'+'Month: '+'</b>'+this.x + '<br/>' +
                      '<b>'+'Users: '+'</b>'+ this.y;
                }
			
            },
            exporting: {
                enabled: false
              
            },
      plotOptions: {
            line: {
                dataLabels: {
                    enabled: true
                },
                enableMouseTracking: true
            }
        },
        series: [{
            name: 'Yearly Record',
            marker: {
                symbol: 'diamond'
            },
            data: [<?php echo implode(',',$Total_registration3);?>]
        }]
    });
    });
});
</script>
 <!--END OF USER REGISTRATION chart block  Page script -->  
  


     </body>
</html>
