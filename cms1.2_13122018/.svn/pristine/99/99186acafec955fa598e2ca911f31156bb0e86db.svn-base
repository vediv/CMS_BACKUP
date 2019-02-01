<?php 
include_once 'corefunction.php';
$qryAna="select google_client_id,client_secret,refresh_token from mail_config where publisherID='".$publisher_unique_id."'";
$fetchAna=  db_select($conn,$qryAna);
$google_client_id=$fetchAna[0]['google_client_id']; $client_secret=$fetchAna[0]['client_secret'];
$refresh_token=$fetchAna[0]['refresh_token']; //$analytics_url=$fetchAna[0]['analytics_url'];

?>
<!DOCTYPE html>
<html>
  <head>
<meta charset="UTF-8">
<title><?php echo PROJECT_TITLE." - Analytics";?></title>
<style type="text/javascript">
.gapi-analytics-data-chart-styles-table-th{background-color:#3c8dbc !important;}
 button, input, optgroup, select, textarea{color: #454545 !important; font-size: 13px !important; font-weight: 600 !important; padding: 4px; background-color: #f5f5f5;    background-image: -moz-linear-gradient(center top , #f5f5f5, #f1f1f1);
border: 1px solid #dcdcdc;    border-radius: 2px;   cursor: default; line-height: 27px;    list-style: outside none none;  }
.half { float: left;  padding-left: 12px;    width: 49.6%;}.half-container{padding: 10px; width: 100%;}
.loader { border: 8px solid #f3f3f3; border-top: 8px solid #3498db; border-radius: 50%;width: 80px;height: 80px;animation: spin 2s linear infinite;}
@keyframes spin { 0% { transform: rotate(0deg); }100% { transform: rotate(360deg);} }
.hide-loader{display:none;}
</style>
<link href="bootstrap/css/pagingCss.css" rel="stylesheet" type="text/css" /> 
<script type="text/javascript">
(function(w,d,s,g,js,fs){
  g=w.gapi||(w.gapi={});g.analytics={q:[],ready:function(f){this.q.push(f);}};
  js=d.createElement(s);fs=d.getElementsByTagName(s)[0];
  js.src='https://apis.google.com/js/platform.js';
  fs.parentNode.insertBefore(js,fs);js.onload=function(){g.load('analytics');};
}(window,document,'script'));
</script>
	
</head>
<body class="skin-blue" onload="getCode()">
<div class="wrapper">
<?php include_once 'header.php';?>
<?php include_once 'lsidebar.php';?>
<div class="content-wrapper">
<section class="content-header">
           <h1>Analytics Realtime Data</h1>
          <ol class="breadcrumb">
          <li><a href="dashbord.php"><i class="fa fa-home" title="Home"></i> Home</a></li>
          <li class="active">Analytics Realtime</li>
          </ol>
</section>
<section class="content">

 <div class="row">
  <div class="col-xs-12">

     <div class="box">


     <div class="box-header">

<div id="embed-api-auth-container"></div>

<div class="col-md-12" style="margin-top:10px;background:#eeeeee;">
      <div id="view-selector-container" class="col-sm-8"  style="display: inline-flex; margin-left: 0px; width:775px;padding:1px;"></div> 
</div>


<div class="half-container">
<!--<div class="loader" id="loader" style="position: absolute; margin: 10% 0% 0% 15%" >  </div>-->
<h5 style="text-align: center;font-size: 20px; margin-top: 20px;">Right Now Active User</h5>

<div id="pageChart_AU" style="height: 200px; width: 100%;">


</div>
</div>



<div class="half"> 
<div class="half-container">
<div class="loader" id="loader" style="position: absolute; margin: 10% 0% 0% 15%" >  </div>
<div id="pageChart" style="height: 300px; width: 100%;">
</div>
</div>
</div>



<div class="half">
<div class="half-container">
<div class="loader" id="loader" style="margin: 10% 0% 0% 19%;position: absolute;">  </div>
<div id="screenChart" style="height: 300px; width: 100%;">
</div>
</div>
</div>

<div class="half">
<div class="half-container">
<div class="loader" id="loader" style="position: absolute; margin: 10% 0% 0% 15%" >  </div>
<div id="eventChart" style="height: 300px; width: 100%;">
</div>
</div>
</div> 
<div class="half">
<div class="half-container">

<div id="active_user_country" style="height: 300px; width: 100%;">
</div>
</div>
</div>   
</div>

</div>	

</div>
</div>
   </section><!-- /.content -->
      
    <!-- /.content-wrapper -->


      </div> 
   <?php include_once"footer.php"; include_once 'commonJS.php';?> 
</div><!-- ./wrapper -->
   
   

<script>
var _=function(id){return document.getElementById(id)};

gapi.analytics.ready(function() {

  /**
   * Authorize the user immediately if the user has already granted access.
   * If no access has been created, render an authorize button inside the
   * element with the ID "embed-api-auth-container".
   */
  gapi.analytics.auth.authorize({
    container: 'embed-api-auth-container',
    clientid: '<?php echo $google_client_id; ?>',
    serverAuth: {
    access_token:localStorage.getItem("access_token")
   }
  });


  /**
   * Create a new ViewSelector instance to be rendered inside of an
   * element with the id "view-selector-container".
   */
  var viewSelector = new gapi.analytics.ViewSelector({
    container: 'view-selector-container'
  });

  // Render the view selector to the page.
  viewSelector.execute();
  
  
 
  /**
   * Create a new DataChart instance with the given query parameters
   * and Google chart options. It will be rendered inside an element
   * with the id "chart-container".
   */
  
  
 
 

 
  /**
   * Render the dataChart on the page whenever a new view is selected.
   */
  viewSelector.on('change', function(ids) {
  });
      //$('#loader').addClass("hide-loader");
});

</script>

<script type="text/javascript">
var pageResposeData=[];
//var pageResposeData_AU=[];
var screenResposeData=[];
var eventResposeData=[];
var activeUsers_tabular=[];
//var imprResposeData=[];

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
 	var data = "refresh_token=<?php echo $refresh_token; ?>&grant_type=refresh_token&client_id=<?php echo $google_client_id; ?>&client_secret=<?php echo $client_secret; ?>";
       // var data = "refresh_token=1/ihtSHK428arZQOsePJpyXu7guoPg5yNsORfwUV-D_vkpRTiha4G_nKuyFFaIMloR&grant_type=refresh_token&client_id=231090503373-7ftq27h2cfslnr8189iadb9e7f0dp7rn.apps.googleusercontent.com&client_secret=NzPrRCJSyz7sD9dtdhawia13";
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
 
//if(intrvl)
 //{
 //	clearInterval(intrvl);
// }
//var intrvl=setInterval(makeAllRequests,2000);

function makeAllRequests()
{
	
    makeRequest("pageViews");
     makeRequest("activeUsers");
    makeRequest("screenViews");
    makeRequest("totalEvents");
    makeRequest("activeUsers_tabular");
    //makeRequest("MATCHED_AD_REQUESTS");
     
}

function makeRequest(metrics)
{   
	dimensions="minutesAgo";params=null;
    switch(metrics)
    {
        case "pageViews":
            params="dimensions=rt:minutesAgo&metrics=rt:pageViews";
            pageResposeData=[]; 
            break;
         case "activeUsers":
        params="dimensions=rt:minutesAgo&metrics=rt:activeUsers";
            pageResposeData_AU=[]; 
            break;   
        case "screenViews":
        params="dimensions=rt:minutesAgo&metrics=rt:screenViews";
            screenResposeData=[];
            break;
        case "totalEvents":
       params="dimensions=rt:minutesAgo&metrics=rt:totalEvents";
            eventResposeData=[];
            break;
         case "activeUsers_tabular":
         params="dimensions=rt:country&metrics=rt:activeUsers";
         
         break;
    }
    
    
    
    //var startDate=_("startDate").value;
    //var endDate=_("endDate").value;
    //var apiUrl="https://www.googleapis.com/analytics/v3/data/realtime?";
    var apiUrl="https://www.googleapis.com/analytics/v3/data/realtime?ids=ga:158461067&"+params;
    //var startDate='startDate='+startDate+'';var endDate='&endDate='+endDate+'';
    var accountId="&accountId=ga:158461067";
    var metric='&metric='+metrics+''; var dimension="&dimension=rt:minutesAgo"; 
    var access_token="&access_token="+localStorage.getItem("access_token");
    //var currency="&currency=INR"
    var reqUrl=apiUrl+accountId+metric+dimension+access_token;
    //alert(metric);
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
 
 

 if(metrics=="activeUsers_tabular")
 var html='<table width="100%"><tr><td>Country</td><td>Users</td></td>';
 for(var i=0;i<len;i++)
       {
         
           switch(metrics)
            {
                case "pageViews":
                    pageResposeData.push( {y: parseInt(data[i][1]) });
                    break;
                    case "activeUsers":
                       var active =  data[i][1];
                      document.getElementById('pageChart_AU').innerHTML=active;
                      //document.getElementById("pageChart_AU").style.color= 'green';
                      //document.getElementById("pageChart_AU").innerHTML = "<font size="50"> active </font>";
                         pageChart_AU.style.fontSize = "80px";
                         pageChart_AU.style.color = 'green';
                         pageChart_AU.style.textAlign = "center"; 
                         //pageChart_AU.style.marginTop = "50px";
                       break;
                case "screenViews":
                    screenResposeData.push( {y: parseInt(data[i][1]) });
                    break;
                case "totalEvents":
                     eventResposeData.push( {y: parseInt(data[i][1]) });
                    break;
                
                case "activeUsers_tabular":
                
                 //setTimeout(function(),500);
                html+='<tr><td>'+data[i][0]+'</td><td>'+data[i][1]+'</td></tr>';
                
                
               
                break;
            } 
       }
 
 
 
 if(metrics=="activeUsers_tabular"){
 	html+='</table>';
 document.getElementById("active_user_country").innerHTML=html;
 	
 }
 
 
 buildChart();//log();
}

function buildChart()
{
 ///  Click chart    
    
 var chart = new CanvasJS.Chart("pageChart",
     {
     animationEnabled: true,
      title:{
        text: "Page Views"
      },
      axisX:{
//Try Changing to MMMM
              title: "Last 30 min",
              interval:2,
                //valueFormatString: "DD MMM ",
      },

      axisY: {
              title: "Page Views",interval: 3,
              valueFormatString: "#",gridThickness: 1,
              
      },

      data: [
      {
         type: "line",
        lineThickness: 2,lineColor:"#0F9D58",
        dataPoints:pageData()
      }
      ]
    });

chart.render(); 


///  pageactive user chart    
    
 /*var chart = new CanvasJS.Chart("pageChart_AU",
     {
    
      title:{
        text: "Page Views activer user"
      },
     

      data: [
      {
        
        
        dataPoints:pageData_AU()
      }
      ]
    });

chart.render(); */



//  View chart    

var chart = new CanvasJS.Chart("screenChart",
    {
      animationEnabled: true,
      title:{
        text: "Screen Views"
      },
      axisX:{
//Try Changing to MMMM
              title: "Last 30 min",
              //valueFormatString: "DD",
              interval:2,
            //  intervalType: "day",
      },

      axisY: {
            title: "NO.of views",interval: 3,
             gridThickness: 1,
             
             
      },

      data: [
      {
        type: "line",
        lineThickness: 2,lineColor:"#0F9D58",
        dataPoints:screenData()
      }
      ]
    });

chart.render(); 

///  Earning chart    

var chart = new CanvasJS.Chart("eventChart",
     
    {
      animationEnabled: true,
      title:{
        text: "Event views"
      },
      axisX:{
//Try Changing to MMMM
              title: "Last 30min",
              //valueFormatString: "DD",
              interval:2,
              //intervalType: "day",
      },

      axisY: {
            title: "Event views",interval: 10,
              //valueFormatString: "#",
              gridThickness: 1,
      },

      data: [
      {
        type: "line",
        lineThickness: 2,lineColor:"#0F9D58",
        dataPoints:eventData()
      }
      ]
    });

chart.render(); 


}

function pageData(){ return pageResposeData;}
function pageData_AU(){ return pageResposeData_AU;}
function screenData(){ return screenResposeData;}
function eventData(){ return eventResposeData;}



//var myVar = setInterval(function(){ pageData()}, 300);
//var myVar = setInterval(function(){ screenData()}, 300);
//var myVar = setInterval(function(){ eventData()}, 300);
//setTimeout(function(){
   //window.location.reload(1);
//}, 5000);

</script>
<script type="text/javascript" src="js/chart.js"></script>
<script type="text/javascript" src="bootstrap/js/daterangepicker.jQuery.js"></script>
<script type="text/javascript" src="bootstrap/js/jquery-ui.js"></script>
<link rel="stylesheet" href="bootstrap/css/jquery-ui.css">

</body>
</html>
