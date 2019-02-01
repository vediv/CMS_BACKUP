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
 	$('#load').show();
        $('#results').css("opacity",0.1);
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
    <h1>Analytics Realtime Screen Data</h1>
    <ol class="breadcrumb">
    <li><a href="dashbord.php"><i class="fa fa-home" title="Home"></i> Home</a></li>
    <li class="active">Analytics Realtime Screen Data</li>
    </ol>
</section>
<section class="content">
    <div class="row" id="results">
          <div id="load" style="display:none;"></div> 
        <div class="col-xs-12">
            <div class="box"  style="min-height: 500px !important;">
               
                <div class="box-header" style="border:0px solid red;">
                  
                    <div  class="col-sm-12" >
                        <div  class="pull-left" style="border:0px solid red;">   
                            <label for="sel1">Select View Type:</label>
                            <select class="form-control_new" onchange="viewScreenType(value);">
                                   <option value="screen" <?php echo $view=='screen'?"selected":''; ?>>Screen</option>
                                   <option value="event">Event</option>
                                   <option value="location">Location</option>
                                </select>
                        </div>
                        <div  class="pull-right" style="border:0px solid red;"><strong>Screen </strong>
                        <!--<a href="javascript:" onclick="return screenView_tabular('refresh')" title="refresh" >
                            <i class="fa fa-refresh" aria-hidden="true"></i></a>-->   
                        </div>
                       
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
                       <div id="screenChart" style=" width: 97%; height: 300px;">
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
                   <li class="" id="view_thirty"><a href="javascript:"  onclick="screenView_tabular('last_thirty_min');">Screen Views (Last 30 min)</a></li>
                </ul>
                <div class="tab-content">
                  <div class="tab-pane active" id="view_all_tab" ><span id="active_user_tabular"></span></div>
                  <div class="tab-pane " id="view_thirty_tab"  ><span id="active_user_tabular_last_30_min"></span></div>
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
setInterval(function(){ var gaIDs=_("gaIDs").value; getGAID(gaIDs)}, interval);
function screenView_tabular(act)
{
    $('#load').show();
    $('#results').css("opacity",0.1);
    var gaIDs=$("#gaIDs").val();
    console.log("gaid when click on tab="+gaIDs);
  
    if(act==='all' || act==='refresh') 
    { 
    $( "#view_thirty").removeClass( "active" );
    $( "#view_thirty_tab").removeClass( "active" );
    $( "#view_all").addClass( "active" );
    $( "#view_all_tab").addClass( "active" );    
    makeRequest("activeUsers",gaIDs);
    makeRequest("activeUsers_graph",gaIDs);
    }
    if(act==='last_thirty_min'){
    $( "#view_thirty").addClass( "active" );
    $( "#view_thirty_tab").addClass( "active" );
    $( "#view_all").removeClass( "active" );
    $( "#view_all_tab").removeClass( "active" );
    makeRequest("activeUsers",gaIDs);
    makeRequest("activeUsers_graph",gaIDs);    
    makeRequest("screen_view_last_thirty_min",gaIDs);
    
    }
    
}
var screenResposeData=[];
function getGAID(gaid)
{
        
       console.log("santosh"+gaid);
       makeRequest("activeUsers",gaid);
       makeRequest("activeUsers_graph",gaid);
       
}
function makeRequest(metrics,gaid)
{   
    var dimensions=''; var params=null;
    switch(metrics)
    {
       case "activeUsers":
       params="dimensions=rt:userType,rt:appName,rt:appVersion,rt:screenName&metrics=rt:activeUsers"
       break;
       case "activeUsers_graph":
       params="dimensions=rt:minutesAgo&metrics=rt:screenViews";
       screenResposeData=[];
       break;
       case "screen_view_last_thirty_min":
         params="dimensions=rt:userType,rt:appName,rt:appVersion,rt:screenName&metrics=rt:screenViews";   
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
               html+='<table class="table table-bordered">';
               html+='<thead><tr><th>Active Screen Name</th><th>App Version</th><th>Active Users</th></tr></thead>';
               html+='<tbody>';
                    for(var i=0;i<len;i++)
                     {
                        var str=obj.rows[i];
                        var fields = str.toString().split(',');
                        var active_screen_name=fields[3]; var AppVersion=fields[2]; var ActiveUsers=fields[4];
                        if(active_screen_name=="Youtube Page") { active_screen_name='POLLYWOOD'; }
                        html+='<tr><td>'+active_screen_name+'</td><td>'+AppVersion+'</td><td>'+ActiveUsers+'</td></tr>';
                     }
                html+='</tbody></table>';
               } 
             
          }
          else
           {  
             _("active_user_tabular").innerHTML="data not available.";
              _("rt_active_user").innerHTML='0';
           }
          _("active_user_tabular").innerHTML=html;
         break;
        case "activeUsers_graph":
            var obj=JSON.parse(response);
            var totalsForAllResults=obj.totalsForAllResults;
            var key = "rt:screenViews"; var rt_screenViews = totalsForAllResults[key];
            console.log("rt_screenViews="+rt_screenViews);
                 if(rt_screenViews > 0)
                 {    
                        var data=obj.rows;
                        var len=data.length;
                       for(var i=0;i<len;i++)
                       {
                         screenResposeData.push( {y: parseInt(data[i][1]) });
                       } 
                       buildChartScreenView();
                      $("#load").hide();$('#results').css("opacity",1);
                       
                 }
                 else
                 { 
                   screenResposeData.push( {y: parseInt([0][0]) });  buildChartScreenView();
                   $("#load").hide();$('#results').css("opacity",1);
                 }
              break;
              case "screen_view_last_thirty_min":
              var obj=JSON.parse(response);
              var totalsForAllResults=obj.totalsForAllResults;
              var key = "rt:screenViews"; var rt_screenViews = totalsForAllResults[key];
              var html='<div  class="breadcrumb">Metric Total : '+rt_screenViews+'</div>';
               if(rt_screenViews>0)
                {
                     var len =obj.rows.length;
                     if(len>0){
                     html+='<table class="table table-bordered">';
                     html+='<thead><tr><th>Active Screen Name</th><th>App Version</th><th>Active Users</th></tr></thead>';
                     html+='<tbody>';
                          for(var i=0;i<len;i++)
                           {
                              var str=obj.rows[i];
                              var fields = str.toString().split(',');
                              var active_screen_name=fields[3]; var AppVersion=fields[2]; var ActiveUsers=fields[4];
                              if(active_screen_name=="Youtube Page") { active_screen_name='POLLYWOOD'; }
                              html+='<tr><td>'+active_screen_name+'</td><td>'+AppVersion+'</td><td>'+ActiveUsers+'</td></tr>';
                           }
                      html+='</tbody></table>';
                     } 

                }
              _("active_user_tabular_last_30_min").innerHTML=html;
              break;
        }        
            
    
    

}


function buildChartScreenView()
{
    var chart = new CanvasJS.Chart("screenChart",
    {
      animationEnabled: true,
      title:{
        text: "Screen Views"
      },
      axisX:{
     //Try Changing to MMMM
              title: "last 30 min",
              //valueFormatString: "DD",
              interval:2,
              
      },

      axisY: {
            title: "no.of views",interval: 3,
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

<script type="text/javascript" src="bootstrap/js/daterangepicker.jQuery.js"></script>
<script type="text/javascript" src="bootstrap/js/jquery-ui.js"></script>
<link rel="stylesheet" href="bootstrap/css/jquery-ui.css">

</body>
</html>
