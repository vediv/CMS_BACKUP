<?php 
include_once 'corefunction.php';
?>
<!DOCTYPE html>
<html>
  <head>
  <meta charset="UTF-8">
  <title><?php echo PROJECT_TITLE." - Adsense";?></title>
  <script src="dist/js/jquery-1.10.1.min.js"></script>
  <link href="bootstrap/css/pagingCss.css" rel="stylesheet" type="text/css" /> 
  <style>
      .half{width: 48%; float: left;margin-bottom: 25px; margin-right: 17px; margin-left: 5px;} .half-container{padding: 10px;background:;}  .loader { border: 8px solid #f3f3f3; border-top: 8px solid #3498db; border-radius: 50%;width: 80px;height: 80px;animation: spin 2s linear infinite; @keyframes spin {0% { transform: rotate(0deg); }100% { transform: rotate(360deg);} .hide-loader{display:none;}
   </style>
  </head>
<body class="skin-blue" onload="initBody()">
     <div class="wrapper">
    	
<?php include_once 'header.php';?>
<?php include_once 'lsidebar.php';?>
<div class="content-wrapper" >
        <!-- Content Header (Page header) -->
     <section class="content-header">
        <h1>Adsense</h1>
          <ol class="breadcrumb">
            <li><a href="dashboard.php"><i class="fa fa-home" title="Home"></i> Home</a></li>
              <li class="active">Adsense</li>
          </ol>
    </section>
     <section class="content">
       <div class="row">
           <div class="col-xs-12">
              <div class="box">
                 <div class="box-header">
                       <div class="row" style="border:0px solid red;">
   	
   	      <?php $today=date("Y-m-d"); $before1month=date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-1 month" ) ); ?>
<form action="javascript:" onsubmit="return makeAllRequests()">
 <div class="col-md-12" style="text-align: center; margin-bottom: 14px">
   <label for="from">From</label>
   <input type="text" id="startDate" style=" padding: 4px !important;    width: 83px !important;" placeholder="eg. <?php echo $before1month?>" value="<?php echo $before1month?>" required="">
    <i class="fa fa-calendar" aria-hidden="true"></i>
    <label for="to">to</label>
    <input type="text" id="endDate" style=" padding: 4px !important;    width: 83px !important;" placeholder="eg. <?php echo date("Y-m-d")?>" value="<?php echo date("Y-m-d")?>" required="">
    <i class="fa fa-calendar" aria-hidden="true"></i>    &nbsp;&nbsp;
    <button type="submit" class="btn btn-success" style="padding: 2px 6px !important;  border-color: #4cae4c !important;">Get Data</button>
    <br/>
    </div>
 </div>
</form>
<script type="text/javascript">
  $(function() {
    $("#startDate").datepicker({dateFormat: "yy-mm-dd"});  
    $("#endDate").datepicker({dateFormat: "yy-mm-dd"});
  });
</script>


<div class="half">
     <div class="Chartjs"> 
    		  <div style="font-size: 19px; height:30px;width:50%;  color:#09192a; line-height: 1.5;  "> User Clicks</div> 
     </div>
   <div class="day box box-primary" style=""> 
      <div class="half-container">
          <div class="loader" id="loader" style="margin: 22% 0% 0% 40%;position: absolute;">  </div>
           <div id="clickChart" style="height: 300px;"> </div>
       </div>
   </div>
</div>      
 <div class="half"> 
     <div class="Chartjs"> 
    	<div style="font-size: 19px; height:30px;width:50%;  color:#09192a; line-height: 1.5;  "> User Views</div>  
     </div>
 <div class="day box box-primary"> 
    <div class="half-container">
  		<div class="loader" id="loader" style="position: absolute; margin: 22% 0% 0% 40%" >  </div>
       <div id="viewsChart" style="height: 300px; width: 100%;"></div>
    </div>
  </div>
</div>
<div class="half">
       <div class="Chartjs"> 
    		<div style="font-size: 19px; height:30px;width:50%;  color:#09192a; line-height: 1.5;  "> Revenue</div>  
       </div>     	
      <div class="day box box-primary"> 
          <div class="half-container" style="">
         		 <div class="loader" id="loader" style="margin: 22% 0% 0% 40%;position: absolute;">  </div>
           <div id="earningChart" style="height: 300px; width: 100%;"></div>
           </div>
        </div>
</div>
<div class="half">
     <div class="Chartjs"> 
    	<div style="font-size: 19px; height:30px;width:50%;  color:#09192a; line-height: 1.5;"> Impressions</div>  
    </div>
 <div class="day box box-primary" style=""> 
     <div class="half-container" style=" ">
         	<div class="loader" id="loader" style="position: absolute; margin: 22% 0% 0% 40%" >  </div>
            <div id="impressionChart" style="height: 300px; width: 100%;"> </div>
      </div>
  </div>
 </div>  
 
</div>
</div>     
       
</section><!-- /.content -->
      
</div><!-- /.content-wrapper -->
<?php
       include_once"footer.php"; include_once 'commonJS.php';
?>
</div><!-- ./wrapper -->
<script type="text/javascript">
var clickResposeData=[];
var viewResposeData=[];
var earnResposeData=[];
var imprResposeData=[];

function log(obj)
{
    console.log(obj);
}

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
        var data = "refresh_token=1/ihtSHK428arZQOsePJpyXu7guoPg5yNsORfwUV-D_vkpRTiha4G_nKuyFFaIMloR&grant_type=refresh_token&client_id=231090503373-7ftq27h2cfslnr8189iadb9e7f0dp7rn.apps.googleusercontent.com&client_secret=NzPrRCJSyz7sD9dtdhawia13";
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
     makeAllRequests();
     
 }

function makeAllRequests()
{
    makeRequest("CLICKS");
    makeRequest("EARNINGS");
    makeRequest("PAGE_VIEWS");
    makeRequest("MATCHED_AD_REQUESTS");
     
}

function makeRequest(metrics)
{   
    switch(metrics)
    {
        case "CLICKS":
            clickResposeData=[]; 
            break;
            
        case "EARNINGS":
            earnResposeData=[];
            break;
        case "PAGE_VIEWS":
            viewResposeData=[];
            break;
        case "MATCHED_AD_REQUESTS":
             imprResposeData=[];
            break;
    }
    

    var startDate=_("startDate").value;
    var endDate=_("endDate").value;
    var apiUrl="https://www.googleapis.com/adsense/v1.4/reports?";
    var startDate='startDate='+startDate+'';var endDate='&endDate='+endDate+'';var accountId="&accountId=pub-1255350788587778";
    var metric='&metric='+metrics+''; var dimension="&dimension=date"; var access_token="&access_token="+localStorage.getItem("access_token");
    var currency="&currency=INR"
    var reqUrl=apiUrl+startDate+endDate+accountId+metric+dimension+currency+access_token;
    var xhr=new XMLHttpRequest();
    xhr.open("GET",reqUrl,true);
    xhr.send();
    xhr.onreadystatechange=function(){if(xhr.readyState==4){parseResponse(xhr.responseText,metrics)}};
    
}      
function parseResponse(response,metrics)
{
 var obj=JSON.parse(response);
 var data=obj.rows;
 var len=data.length;
  for(var i=0;i<len;i++)
       {
           var date=data[i][0].split("-");
           var y=date[0];var m=date[1];var d=date[2];
           switch(metrics)
            {
                case "CLICKS":
                    clickResposeData.push( { x: new Date(y,m-1,d), y: parseInt(data[i][1]) });
                    break;
                case "EARNINGS":
                    earnResposeData.push( { x: new Date(y,m-1,d), y: parseInt(data[i][1]) });
                    break;
                case "PAGE_VIEWS":
                     viewResposeData.push( { x: new Date(y,m-1,d), y: parseInt(data[i][1]) });
                    break;
                case "MATCHED_AD_REQUESTS":
                     imprResposeData.push( { x: new Date(y,m-1,d), y: parseInt(data[i][1]) });
                    break;
            } 
       }
 
 buildChart();//log();
}

function buildChart()
{
var chart = new CanvasJS.Chart("clickChart",
    {
       toolTip:{
      	borderColor:"#058dc7",
      	borderThickness: 1,
    },
      axisX:{
//Try Changing to MMMM
              title: "Date",
              valueFormatString: "DD MMM",
              interval:4,
              intervalType: "day",
      },

      axisY: {
            title: "NO.of clicks",interval: 1,
              valueFormatString: "#",gridThickness: 1,
      },
      data: [
      {
        type: "line",
        lineThickness: 2,lineColor:"#058dc7",
        markerColor:"#058dc7",
        dataPoints:clickData()
      }
      ]
    });

chart.render(); 
///  View chart    

var chart = new CanvasJS.Chart("viewsChart",
    {
     /*
      title:{
             text: "User Views"
           },*/
       toolTip:{
      	borderColor:"#058dc7",
      	borderThickness: 1,
      },
      axisX:{
//Try Changing to MMMM
              title: "Date",
              valueFormatString: "DD MMM",
              interval:4,
              intervalType: "day",
      },

      axisY: {
            title: "NO.of views",interval: 50,
              valueFormatString: "#",gridThickness: 1,
      },

      data: [
      {
        type: "line",
        lineThickness: 2,lineColor:"#058dc7",
         markerColor:"#058dc7",
        dataPoints:viewData()
      }
      ]
    });

chart.render(); 

///  Earning chart    

var chart = new CanvasJS.Chart("earningChart",
    {

      /*
      title:{
              text: "Revenue"
            },*/
        toolTip:{
      	borderColor:"#058dc7",
      	borderThickness: 1,
      },
      axisX:{
//Try Changing to MMMM
              title: "Date",
              valueFormatString: "DD MMM",
              interval:4,
              intervalType: "day",
      },

      axisY: {
            title: "Earning INR",interval: 10,
              valueFormatString: "#",gridThickness: 1,
      },

      data: [
      {
        type: "line",
        lineThickness: 2,lineColor:"#058dc7",
         markerColor:"#058dc7",
        dataPoints:earnData()
      }
      ]
    });

chart.render(); 

// impression Chart 
var chart = new CanvasJS.Chart("impressionChart",
    {

    /*
      title:{
            text: "Impressions"
          },*/
      toolTip:{
      	borderColor:"#058dc7",
      	borderThickness: 1,
      },
      axisX:{
//Try Changing to MMMM
              title: "Date",
              valueFormatString: "DD MMM",
              interval:4,
              intervalType: "day",
      },

      axisY: {
            title: "impressions",interval: 100,
              valueFormatString: "#",gridThickness: 1,
      },

      data: [
      {
          type: "line",
          lineThickness: 2,lineColor:"#058dc7",
          markerColor:"#058dc7",
          dataPoints:imprData()
      }
      ]
    });

chart.render(); 
}
function clickData(){ return clickResposeData;}
function viewData(){ return viewResposeData;}
function earnData(){ return earnResposeData;}
function imprData(){ return imprResposeData;}
$('#loader').addClass("hide-loader");
</script>
<script type="text/javascript" src="js/chart.js"></script>
<script type="text/javascript" src="bootstrap/js/daterangepicker.jQuery.js"></script>
<script type="text/javascript" src="bootstrap/js/jquery-ui.js"></script>
<link rel="stylesheet" href="bootstrap/css/jquery-ui.css">
</body>
</html>