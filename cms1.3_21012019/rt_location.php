<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title><?php echo PROJECT_TITLE." | Analytics | RealTime Location";?></title>
<style type="text/javascript">
.gapi-analytics-data-chart-styles-table-th{background-color:#3c8dbc !important;}
 button, input, optgroup, select, textarea{color: #454545 !important; font-size: 13px !important; font-weight: 600 !important; padding: 4px; background-color: #f5f5f5;    background-image: -moz-linear-gradient(center top , #f5f5f5, #f1f1f1);
border: 1px solid #dcdcdc;    border-radius: 2px;   cursor: default; line-height: 27px;    list-style: outside none none;  }
.half { float: left;  padding-left: 12px;    width: 49.6%;}.half-container{padding: 10px; width: 100%;}
.loader { border: 8px solid #f3f3f3; border-top: 8px solid #3498db; border-radius: 50%;width: 80px;height: 80px;animation: spin 2s linear infinite;}
@keyframes spin { 0% { transform: rotate(0deg); }100% { transform: rotate(360deg);} }
#load {
    opacity:1;
    width: 80%;
    height: 70%;
    position: fixed;
    z-index: 9999;
    color: red;
    background: transparent url("img/image_process.gif") no-repeat center;
} 
.hide-loader{display:none;}

</style>
<link href="bootstrap/css/pagingCss.css" rel="stylesheet" type="text/css" /> 
<link href="bootstrap/css/sb-admin-2.css" rel="stylesheet">
<script type="text/javascript">
(function(w,d,s,g,js,fs){
  g=w.gapi||(w.gapi={});g.analytics={q:[],ready:function(f){this.q.push(f);}};
  js=d.createElement(s);fs=d.getElementsByTagName(s)[0];
  js.src='https://apis.google.com/js/platform.js';
  fs.parentNode.insertBefore(js,fs);js.onload=function(){g.load('analytics');};
}(window,document,'script'));

var _=function(id){return document.getElementById(id)};
function getCode()
 {
 	//$('#load').show();
       // $('#results').css("opacity",0.1);
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
 }
 
gapi.analytics.ready(function() {
  gapi.analytics.auth.authorize({
    container: 'embed-api-auth-container',
    clientid: '<?php echo $google_client_id; ?>',
    serverAuth: {
    access_token:localStorage.getItem("access_token")
   }
  });
  var viewSelector = new gapi.analytics.ViewSelector({
    container: 'view-selector-container'
  });
  viewSelector.execute();
  viewSelector.on('change', function(ids) {
    getGAID(ids);
    $("#gaIDs").val(ids);
  });
      
});

</script>
	
</head>
<body class="skin-blue" onload="getCode()">
<div class="wrapper">
<?php include_once 'header.php';?>
<?php include_once 'lsidebar.php';?>
<div class="content-wrapper">
<section class="content-header">
    <h1>Analytics Realtime Location Data
    <?php
    $getCountry=isset($_GET['country'])? $_GET['country']:'';
    $getRegion=isset($_GET['region']) ? $_GET['region']:'';
    ?>
    </h1>
    <ol class="breadcrumb">
    <li><a href="dashbord.php"><i class="fa fa-home" title="Home"></i> Home</a></li>
    <li class="active">Analytics Realtime Location Data</li>
    </ol>
</section>
<section class="content">
    <div class="row" id="results">
          <div id="load" style="display:none;"></div> 
        <div class="col-xs-12">
            <div class="box"  style="min-height: 500px !important;">
               
                <div class="box-header" style="border:0px solid red;">
                  
                    <div  class="row" style="margin-left: 3px; margin-right: 5px;" >
                        <table width="100%" border='0'>
                            <tr>
                               <td width="15%">
                               <label for="sel1">Select View Type:</label>
                                <select class="form-control_new" onchange="viewScreenType(value);">
                                   <option value="screen">Screen</option>
                                   <option value="event">Event</option>
                                   <option value="location"  <?php echo $view=='location'?"selected":''; ?>>Location</option>
                                </select>
                                </td>
                                <td width="60%">
                                  <?php
                                  if($getCountry!='')
                                  {    
                                  ?>  
                                    <div class="inline" style="color:#fff; background-color: #3c8dbc;">
                                        <strong>Country:</strong> <?php echo $getCountry; ?>
                                        <a href="javascript:" style="color:#fff;" onclick="RemoveFilter('country');"> &nbsp;&nbsp;x </a>  
                                    </div>
                                  <?php }
                                  if($getCountry!='' && $getRegion!='')
                                  {
                                  ?>  
                                    <div class="inline" style="color:#fff; background-color: #3c8dbc; margin-left:10px;">
                                       <strong>Region:</strong> <?php echo $getRegion; ?> 
                                         <a href="javascript:" style="color:#fff; " onclick="RemoveFilter('region');"> &nbsp;&nbsp;x &nbsp;</a>  
                                    </div>
                                  <?php } ?>
                                </td>
                                
                                <td width="5%"><strong>Location </strong></td>
                            </tr>   
                            
                        </table>  
                    </div>
                       <div id="embed-api-auth-container"></div>
                       <input type="hidden" id="gaIDs">
                        <div class="col-md-12" style="margin-top:10px;background:#eeeeee;">
                          <div id="view-selector-container" class="col-sm-8"  style="display: inline-flex; margin-left: 0px; width:775px;padding:1px;"></div> 
                        </div>
            <div class="row"></div>  
            <div class="row">
                <div class="col-lg-2" style="border:0px solid red; margin-top: 40px;">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            Right Now
                        </div>
                        <div class="panel-body">
                            <p style="font-size: 50px;" align='center'><span id="rt_active_user"></span></p>
                            <p align='center'>active users on app</p>
                        </div>
                        <!--<div class="panel-footer">
                            Panel Footer
                        </div>-->
                    </div>
                    <!-- /.col-lg-4 -->
                </div>
                <div class="col-lg-10">   
                    <div class="half">
                       <div class="half-container">
                       <div class="loader" id="loader" style="margin: 10% 0% 0% 19%;position: absolute;">  </div>
                       <div id="PageViewChart" style=" width: 97%; height: 300px;">
                       </div>
                       </div>
                     </div> 
            </div>
            </div>
            <div class="row">
          
            <div class="col-md-12">
              <!-- Custom Tabs -->
              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                   <li class="active" id="view_all" ><a href="javascript:" onclick="screenView_tabular('all');">Viewing: Active Users</a></li>
                 </ul>
                <div class="tab-content">
                  <div class="tab-pane active" id="view_all_tab" ><span id="active_user_tabular"></span></div>
                 
                </div><!-- /.tab-content -->
              </div><!-- nav-tabs-custom -->
            </div><!-- /.col -->
    
            </div>           
                       
                   </div>
               
            </div>	

        </div>
    </div>
</section>
</div> 
<?php include_once"footer.php"; include_once 'commonJS.php';?> 
</div><!-- ./wrapper -->

<script type="text/javascript">
   
var interval=15000;
///setInterval(function(){ var gaIDs=_("gaIDs").value; getGAID(gaIDs)}, interval);    
var getCountry="<?php echo $getCountry; ?>";
var getRegion="<?php echo $getRegion; ?>";

var screenResposeData=[];
function getGAID(gaid)
{
        
       console.log("api hit"+gaid);
       makeRequest("activeUsers",gaid);
       makeRequest("pageView_graph",gaid);
       
}
function makeRequest(metrics,gaid)
{   
    var dimensions=''; var params=null;
    switch(metrics)
    {
       case "activeUsers":
       if(getCountry==='' && getRegion === '') 
        {
            console.log("countryList");
             params="dimensions=rt:userType,rt:country&metrics=rt:activeUsers";
        }       
        if(getCountry!='' && getRegion === '')
        {
           console.log("State List");
           params="dimensions=rt:userType,rt:region&metrics=rt:activeUsers&filters=rt:country%3D%3D"+getCountry;
           console.log(params);
        } 
        if(getCountry!='' && getRegion !== '')
        {
           console.log("City List");
           params="dimensions=rt:userType,rt:city&metrics=rt:activeUsers&filters=rt:region%3D%3D"+getRegion;
           console.log(params);
        } 
       //&filters=rt:country%3D~%5EIndia
       break;
       case "pageView_graph":
       params="dimensions=rt:minutesAgo&metrics=rt:pageviews";
       screenResposeData=[];
       break;
       
    }
    var apiUrl="https://www.googleapis.com/analytics/v3/data/realtime?ids="+gaid+"&"+params;
    var accountId="&accountId="+gaid;
    var access_token="&access_token="+localStorage.getItem("access_token");
    var reqUrl=apiUrl+accountId+access_token;
    var xhr=new XMLHttpRequest();
    xhr.open("GET",reqUrl,true);
    xhr.send();
    xhr.onreadystatechange=function(){if(xhr.readyState==4){parseResponse(xhr.responseText,metrics)}};
    
}     
function GetURLData(name,act)
{
    if(act=='country')
    {   window.location.href="analytics_realtime_data.php?view=location&country="+name; return true; }
    if(act=='region')
    {   window.location.href="analytics_realtime_data.php?view=location&country="+getCountry+"&region="+name; return true; }
    
}
function RemoveFilter(act)
{
    if(act=='country')
    {   window.location.href="analytics_realtime_data.php?view=location"; return true; }
    if(act=='region')
    {   window.location.href="analytics_realtime_data.php?view=location&country="+getCountry; return true; }
    
}
function parseResponse(response,metrics)
{
    switch(metrics)
     {
          case "activeUsers":
          var obj=JSON.parse(response);
          var totalsForAllResults=obj.totalsForAllResults;
          var key = "rt:activeUsers"; var rt_activeUsers = totalsForAllResults[key];
          console.log("rt_activeUsers="+rt_activeUsers);
          _("rt_active_user").innerHTML=rt_activeUsers;
          var html='<div  class="breadcrumb">Metric Total : '+rt_activeUsers+'</div>';
          if(rt_activeUsers>0)
          {
               var len =obj.rows.length;
               if(len>0){
               if(getCountry==='' && getRegion === '') 
               {    
                        html+='<table class="table table-bordered">';
                        html+='<thead><tr><th>Country</th><th>Active Users</th></tr></thead>';
                        html+='<tbody>';
                             for(var i=0;i<len;i++)
                              {
                                 var str=obj.rows[i];
                                 var fields = str.toString().split(',');
                                 var Country_name=fields[1];  var ActiveUsers=fields[2];
                                 var cname="country";
                                 html+='<tr><td>';
                                 html+='<a><h6 style="cursor:pointer"  onCLick="GetURLData(\''+Country_name+'\',\''+cname+'\')" title="'+Country_name+'">'+Country_name+'</h6></a>';
                                 html+='</td><td>'+ActiveUsers+'</td></tr>';
                              }
                          html+='</tbody></table>';
                } 
                if(getCountry!='' && getRegion === '')
                {
                       html+='<table class="table table-bordered">';
                        html+='<thead><tr><th>Region</th><th>Active Users</th></tr></thead>';
                        html+='<tbody>';
                             for(var i=0;i<len;i++)
                              {
                                 var str=obj.rows[i];
                                 var fields = str.toString().split(',');
                                 var region_name=fields[1];  var ActiveUsers=fields[2];
                                 var cname="region";
                                 html+='<tr><td>';
                                 html+='<a><h6 style="cursor:pointer"  onCLick="GetURLData(\''+region_name+'\',\''+cname+'\')" title="'+region_name+'">'+region_name+'</h6></a>';
                                 html+='</td><td>'+ActiveUsers+'</td></tr>';
                              }
                          html+='</tbody></table>';
                        
                
                } 
                    if(getCountry!='' && getRegion != '')
                    {
                           html+='<table class="table table-bordered">';
                            html+='<thead><tr><th>City</th><th>Active Users</th></tr></thead>';
                            html+='<tbody>';
                                 for(var i=0;i<len;i++)
                                  {
                                     var str=obj.rows[i];
                                     var fields = str.toString().split(',');
                                     var cityName=fields[1];  var ActiveUsers=fields[2];
                                     html+='<tr><td>';
                                     html+='<a><h6   title="'+cityName+'">'+cityName+'</h6></a>';
                                     html+='</td><td>'+ActiveUsers+'</td></tr>';
                                  }
                              html+='</tbody></table>';
                    }
                
              }
             
          }
          else
           {  
             _("active_user_tabular").innerHTML="data not available.";
              _("rt_active_user").innerHTML='0';
           }
          _("active_user_tabular").innerHTML=html;
         break;
        case "pageView_graph":
            var obj=JSON.parse(response);
            var totalsForAllResults=obj.totalsForAllResults;
            var key = "rt:pageviews"; var rt_pageviews = totalsForAllResults[key];
            console.log("rt_pageviews="+rt_pageviews);
                 if(rt_pageviews > 0)
                 {    
                        var data=obj.rows;
                        var len=data.length;
                       for(var i=0;i<len;i++)
                       {
                         screenResposeData.push( {y: parseInt(data[i][1]) });
                       } 
                       buildChartPageView();
                      $("#load").hide();$('#results').css("opacity",1);
                       
                 }
                 else
                 { 
                   screenResposeData.push( {y: parseInt([0][0]) });  //buildChartScreenView();
                   $("#load").hide();$('#results').css("opacity",1);
                 }
              break;
            
        }        
            
    
    

}

function buildChartPageView()
{
    var chart = new CanvasJS.Chart("PageViewChart",
    {
      animationEnabled: true,
      title:{
        text: "Pageviews (Per minute)"
      },
      axisX:{
     //Try Changing to MMMM
              title: "last 30 min",
              //valueFormatString: "DD",
              interval:2,
              
      },
     axisY: {
            title: "no. of views",interval: 3,
             gridThickness: 1,
       },
      data: [
      {
        type: "line",
        lineThickness: 2,lineColor:"#0F9D58",
        dataPoints:screenResposeData
      }
      ]
    });
       chart.render(); 
}

</script>
<script type="text/javascript" src="js/chart.js"></script>
</body>
</html>
