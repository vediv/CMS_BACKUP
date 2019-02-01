<?php 
include_once 'corefunction.php';
$qryAna="select google_client_id,client_secret,refresh_token from mail_config where publisherID='".$publisher_unique_id."'";
$fetchAna=  db_select($conn,$qryAna);
$google_client_id=$fetchAna[0]['google_client_id']; $client_secret=$fetchAna[0]['client_secret'];
$refresh_token=$fetchAna[0]['refresh_token']; //$analytics_url=$fetchAna[0]['analytics_url'];

//print_r($fetchAna);
?>
<!DOCTYPE html>
<html>
  <head>
<meta charset="UTF-8">
<title><?php echo PROJECT_TITLE." - Analytics";?></title>
<style type="text/css">
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
<script>
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
     
     
 }
 
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
    <?php include_once 'header.php'; include_once 'lsidebar.php';?>
     <div class="content-wrapper">
     <section class="content-header">
          <h1>Analytics</h1>
          <ol class="breadcrumb">
            <li><a href="dashbord.php"><i class="fa fa-home" title="Home"></i> Home</a></li>
              <li class="active">Analytics</li>
          </ol>
     </section>
     <section class="content">
      <div class="row">
        <div class="col-xs-12">
            <div class="box"  id="results">
             <div id="load" style="display:none;"></div>
<div class="box-header">
<div id="embed-api-auth-container"></div>
<div class="col-md-12" style="margin-top:10px;background:#eeeeee;">
<div id="view-selector-container" class="col-sm-8"  style="display: inline-flex; margin-left: 0px; width:775px;padding:1px;"></div> 
   <?php $today=date("Y-m-d"); $before1month=date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-1 month" ) ); ?>
   <!--<form action="javascript:" id="frmDateRange">
    <div class="col-sm-3" style="display: inline-flex; padding:3px; margin-left:40px;     font-size: 13px !important;">
    <label for="from" style="padding: 5px 3px 0 0 !important"> From</label>
    <input type="text" id="startDate" size="15" style=" padding: 4px !important;    width: 32% !important;" placeholder="eg. <?php echo $before1month?>" value="<?php echo $before1month?>" required="">
    <label for="to" style="padding: 5px 3px 0 3px !important;"> to</label>
    <input type="text" id="endDate" size="15" style=" padding: 4px !important;    width: 32% !important;" placeholder="eg. <?php echo date("Y-m-d")?>" value="<?php echo date("Y-m-d")?>" required="">
    <button type="submit" class="btn btn-success" style="padding: 2px 4px !important;  margin-left: 10px; border-color: #4cae4c !important;">Get Data</button>
    </div>
   </form>-->
    </div>
  <div class="col-md-12 " style="margin-top:10px; padding-left: 0px;">
        <div class="col-md-2 col-lg-4 col-sm-12">&nbsp;</div>
               <div class="col-md-8 col-lg-4 col-sm-12"> 
     <form action="javascript:" id="frmDateRange">
   
    <label for="from" style="padding: 5px 3px 0 0 !important"> From</label>
    <input type="text" id="startDate" size="15" style=" padding: 4px !important;    width: 32% !important;" placeholder="eg. <?php echo $before1month?>" value="<?php echo $before1month?>" required="">
    <label for="to" style="padding: 5px 3px 0 3px !important;"> to</label>
    <input type="text" id="endDate" size="15" style=" padding: 4px !important;    width: 32% !important;" placeholder="eg. <?php echo date("Y-m-d")?>" value="<?php echo date("Y-m-d")?>" required="">
    <button type="submit" class="btn btn-success" style="padding: 2px 4px !important;  margin-left: 10px; border-color: #4cae4c !important;">Get Data</button>
   

   </form></div>
               <div class="col-md-2 col-lg-4 col-sm-12">&nbsp;</div>
    </div>
  <div class="half-container" style="padding-top: 50px">
      <h4 style="margin-top:52px;">GEO GRAPH(User) <level data-toggle="tooltip" title="Users who have initiated at least one session during the date range"> <i class="fa fa-question-circle" style="color: #058dc7;"></i></level></h4>
  	<div style="display:inherit" class="day box box-primary">
                <div class="box-header">
  	
  	<div class="loader" id="loader" style="position: absolute; margin: 7% 0% 0% 42%" >  </div>
  <div id="GEO_GRAPH" style="height: 300px;margin-top:40px;">
  </div>
  </div></div></div>
  
 <!-- <div class="half-container" style="padding-top: 50px">
  <h4 style="margin-top:52px;">GEO CITY</h4>
  <div style="display:inherit" class="day box box-primary">
  	
 <div class="col-md-12" style="margin-top:10px; padding-left: 0px;">
  <h4> Primary Dimension: </h4>
  <button>Country</button>
  <button>City</button>
  <button>Continent</button>
   <button>Sub Continent</button>
  </div>
  <div class="box-header">
  <div class="loader" id="loader" style="position: absolute; margin: 15% 0% 0% 42%" >  </div>
  <div id="City_container" style="height: 300px;margin-top:40px;">
  </div>
  </div>
  </div>
 </div>-->
  
<div class="half"><h4>Geo graph (Session)<level data-toggle="tooltip" title="Total number of Sessions within the date range. A session is the period time a user is actively engaged with your website, app, etc. All usage data (Screen Views, Events, Ecommerce, etc.) is associated with a session"> <i class="fa fa-question-circle" style="color: #058dc7;"></i></level></h4>
  <div style="display:inherit" class="day box box-primary">
    <div class="box-header">
        <div class="half-container">
            <div class="loader" id="loader" style="margin: 19% 1% 0 36%; position: absolute;">  </div>
            <div id="GEO_GRAPH_SESSION" style="height: 300px;"> </div>
        </div>
    </div>
  </div>
</div> 
<div class="half"><h4>Daily users for last 30 days</h4>
    <div style="display:inherit" class="day box box-primary">
        <div class="box-header">
            <div class="half-container">
                <div class="loader" id="loader" style="margin:19% 1% 0 36%; position: absolute;">  </div>
                <div id="USER_GRAPH" style="height: 300px;"></div>
            </div>
        </div>
  </div>
  </div>
  
<div class="half"><h4>Operating System</h4>
  <div style="display:inherit" class="day box box-primary">
    <div class="box-header">
    <div class="half-container">
        <div class="loader" id="loader" style="margin: 19% 1% 0 36%; position: absolute;">  </div>
        <div id="OS_GRAPH" style="height: 300px;"></div>
    </div>
    </div>
  </div>
</div> 
  
  <div class="half">
  	<h4>Browser</h4>
  	 <div style="display:inherit" class="day box box-primary">
       <div class="box-header">
  <div class="half-container"> 
  <div class="loader" id="loader" style="margin: 19% 1% 0 36%; position: absolute;">  </div>
  <div id="BROWSER_GRAPH" style="height: 300px;">
  </div></div></div>
  </div>
  </div> 
  
   <div class="half"><h4>Device</h4>
   <div style="display:inherit" class="day box box-primary">
   <div class="box-header">
   <div class="half-container"> 
   <div class="loader" id="loader" style="margin:19% 1% 0 36%; position: absolute;">  </div>
   <div id="DEVICE_GRAPH" style="height: 300px;">
   </div></div></div>
   </div>
   </div> 
   
   <div class="half"><h4>Resolution</h4>
   	 <div style="display:inherit" class="day box box-primary">
       <div class="box-header">
   <div class="half-container"> 
  	<div class="loader" id="loader" style="margin: 19% 1% 0 36%; position: absolute;">  </div>
   <div id="RESOLUTION_GRAPH" style="height: 300px;">
   </div></div></div>
   </div>
   </div> 
   
   
   
    <div class="half"><h4>Daily users for last 30 days(Session)</h4>
    	 <div style="display:inherit" class="day box box-primary">
            <div class="box-header">
   <div class="half-container"> 
  	<div class="loader" id="loader" style="margin: 19% 1% 0 36%; position: absolute;">  </div>
   <div id="USER_GRAPH_SESSION" style="height: 300px;">
   </div></div></div>
   </div>
   </div>
   
   
 <div class="half"><h4>Top country by session<level data-toggle="tooltip" title="The country from which the session originate"> <i class="fa fa-question-circle" style="color: #058dc7;"></i></level></h4>
    	 <div style="display:inherit" class="day box box-primary">
           <div class="box-header">
   <div class="half-container">
  	<div class="loader" id="loader" style="margin: 19% 1% 0 36%; position: absolute;">  </div>
   <div id="TOP_COUNTRY" style="height: 300px; ">
   </div></div></div>
   </div>
   </div>
  
    <div class="half"><h4>New user<level data-toggle="tooltip" title="The number of first-time users during the selected date range"> <i class="fa fa-question-circle" style="color: #058dc7;"></i></level></h4>
    <div style="display:inherit" class="day box box-primary">
    <div class="box-header">
    <div class="half-container">
  	<div class="loader" id="loader" style="margin: 19% 1% 0 36%; position: absolute;">  </div>
    <div id="Returning_user_graph" style="height: 300px; ">
    </div></div></div>
    </div>
     </div>
   
    
    <div class="half"><h4>Session viewed on basis of language<level data-toggle="tooltip" title="The language settings in your users' browsers. Analytics uses the ISO codes"> <i class="fa fa-question-circle" style="color: #058dc7;"></i></level></h4>
    <div style="display:inherit" class="day box box-primary">
    <div class="box-header">
    <div class="half-container">
  	<div class="loader" id="loader" style="margin: 19% 1% 0 36%; position: absolute;">  </div>
    <div id="sessionByLanguage" style="height: 300px;">
    </div></div></div>
    </div>
    </div>
</div>
</div>     
</div>	
</div>
</section>
</div>
<?php include_once"footer.php"; include_once 'commonJS.php';?>
</div>
<script type="text/javascript">
  
    $('[data-toggle="tooltip"]').tooltip();    

$(function() {
    $("#startDate").datepicker({dateFormat: "yy-mm-dd"});  
    $("#endDate").datepicker({dateFormat: "yy-mm-dd"});
});


var _=function(id){return document.getElementById(id)};
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

  // Render the view selector to the page.
  viewSelector.execute();
  
  
  var startDate=function(){return _("startDate").value};
  var endDate=function(){return _("endDate").value};

  var userno = new gapi.analytics.googleCharts.DataChart({
    query: {
    'dimensions': 'ga:date',
      'metrics': 'ga:users',
      'start-date': startDate(),
      'end-date': endDate()
    },
    chart: {
      container: 'USER_GRAPH',
      type: 'LINE',
      options: {
        width: '500'
         
      }
    }
  });

  var geo = new gapi.analytics.googleCharts.DataChart({
    
   query: {
      'dimensions': 'ga:country',
      'metrics': 'ga:users',
      'start-date': startDate(),
      'end-date': endDate(),
    },
    chart: {
      type: 'GEO',
      container: 'GEO_GRAPH',
      options: {
        region: 'world', 
        //resolution: 'metros',
        //keepAspectRatio:true,
        displayMode: 'regions',
        width: '100%'
       
      }
    }
  });
  var geo_Country = new gapi.analytics.googleCharts.DataChart({
   query: {
      'dimensions': 'ga:country',
      'metrics': 'ga:users, ga:newUsers,ga:sessions,ga:avgSessionDuration,ga:screenviews,ga:screenviewsPerSession' ,
      'start-date': startDate(),
      'end-date': endDate(),
       'sort': '-ga:users'
    },
    chart: {
      type: 'TABLE',
      container: 'City_container',
      options: {
       
        //resolution: 'metros',
        //keepAspectRatio:true,
        displayMode: 'regions',
        height:'350',
        width: '100%'
       
      }
    }
  });
  
 var OS = new gapi.analytics.googleCharts.DataChart({
    
   query: {
      'dimensions': 'ga:operatingSystem',
      'metrics': 'ga:users',
      'start-date': startDate(),
      'end-date': endDate(),
    },
    chart: {
      type: 'PIE',
      container: 'OS_GRAPH',
      options: {
        region: 'operatingSystem', 
        displayMode: 'operatingSystem',
        options: {
        width: '800',
        pieHole: 4/9
      }
        
      }
    }
  });
  
  var browser = new gapi.analytics.googleCharts.DataChart({
    
   query: {
      'dimensions': 'ga:browser',
      'metrics': 'ga:users',
      'start-date': startDate(),
      'end-date': endDate(),
    },
    chart: {
      type: 'PIE',
      container: 'BROWSER_GRAPH',
      options: {
        region: 'browser', 
        displayMode: 'browser',
        options: {
        width: '800',
        pieHole: 4/9
      }
        
      }
    }
  });
  
var device = new gapi.analytics.googleCharts.DataChart({
    
   query: {
      'dimensions': 'ga:mobileDeviceModel',
      'metrics': 'ga:users',
      'start-date': startDate(),
      'end-date': endDate(),
    },
    chart: {
      type: 'PIE',
      container: 'DEVICE_GRAPH',
      options: {
        region: 'mobileDeviceModel', 
        displayMode: 'mobileDeviceModel',
        options: {
        width: '800',
        pieHole: 4/9
      }
        
      }
    }
  });
  
  var resolution = new gapi.analytics.googleCharts.DataChart({
    
   query: {
      'dimensions': 'ga:screenResolution',
      'metrics': 'ga:users',
      'start-date': startDate(),
      'end-date': endDate(),
    },
    chart: {
      type: 'PIE',
      container: 'RESOLUTION_GRAPH',
      options: {
        region: 'screenResolution', 
        displayMode: 'screenResolution',
        options: {
        width: '800',
        pieHole: 4/9
      }
        
      }
    }
  });
 
  var geo_session = new gapi.analytics.googleCharts.DataChart({
    query: {
      'dimensions': 'ga:country',
      'metrics': 'ga:sessions',
      'start-date': startDate(),
      'end-date': endDate(),
    },
    chart: {
      type: 'GEO',
      container: 'GEO_GRAPH_SESSION',
        options: {
        region: 'world',
        width: '500',
        displayMode: 'regions'
      }
    }
   
  });
  
   var user_session = new gapi.analytics.googleCharts.DataChart({
    reportType: 'ga',
    query: {
      'dimensions': 'ga:date',
      'metrics': 'ga:sessions',
      'start-date': startDate(),
      'end-date': endDate(),
    },
    chart: {
      type: 'LINE',
      container: 'USER_GRAPH_SESSION',
        options: {
        width: '500'
      }
    }
      });
  
  var country_session = new gapi.analytics.googleCharts.DataChart({
    query: {
      metrics: 'ga:sessions',
      dimensions: 'ga:country',
      'start-date': startDate(),
      'end-date': endDate(),
      'max-results': 5,
      sort: '-ga:sessions'
    },
    chart: {
      container: 'TOP_COUNTRY',
      type: 'PIE',
      options: {
        width: '500',
        pieHole: 4/9
      }
    }
  });
 

   var Returning_user = new gapi.analytics.googleCharts.DataChart({
    query: {
      'metrics': 'ga:newUsers',
      'dimensions': 'ga:date',
      'start-date': startDate(),
      'end-date': endDate(),
      'max-results': 5,
      // sort: '-ga:sessions'
    },
    chart: {
      container: 'Returning_user_graph',
      type: 'LINE',
      options: {
        width: '500',
        pieHole: 4/9
      }
    }
  });
  

  var count_sessionByLanguage = new gapi.analytics.googleCharts.DataChart({
 //reportType: 'ga',
    query: {
      'dimensions': 'ga:language',
      'metrics': 'ga:sessions',
      'start-date': startDate(),
      'end-date': endDate(),
     // 'max-results': 10,
      //sort: '-ga:sessions'
    },
    chart: {
      container: 'sessionByLanguage',
      type: 'TABLE',
      options: {
        width: '500',
        height:'300',
        overflow:'scroll',
        position:'static'
      
      }
    }
  });
  
 
_("frmDateRange").addEventListener("submit",function(){startDate()
    $('#load').show();
    $('#results').css("opacity",0.1);
    geo.set({query: {'start-date': startDate(),'end-date': endDate()}}).execute();
    geo_session.set({query: {'start-date': startDate(),'end-date': endDate()}}).execute();
    userno.set({query: {'start-date': startDate(),'end-date': endDate()}}).execute();
    OS.set({query: {'start-date': startDate(),'end-date': endDate()}}).execute();
    browser.set({query: {'start-date': startDate(),'end-date': endDate()}}).execute();
    device.set({query: {'start-date': startDate(),'end-date': endDate()}}).execute();
    resolution.set({query: {'start-date': startDate(),'end-date': endDate()}}).execute();
    user_session.set({query: {'start-date': startDate(),'end-date': endDate()}}).execute();
    country_session.set({query: {'start-date': startDate(),'end-date': endDate()}}).execute();
    Returning_user.set({query: {'start-date': startDate(),'end-date': endDate()}}).execute();
    count_sessionByLanguage.set({query: {'start-date': startDate(),'end-date': endDate()}}).execute();
    //geo_Country.set({query: {'start-date': startDate(),'end-date': endDate()}}).execute();
    setTimeout(function() {$("#load").hide();$('#results').css("opacity",1); }, 4000);
    
  });

  
viewSelector.on('change', function(ids) {
  $('#load').show();
  $('#results').css("opacity",0.1);  
  geo.set({query: {ids: ids}}).execute();
  geo_session.set({query: {ids: ids}}).execute();
  userno.set({query: {ids: ids}}).execute();
  OS.set({query: {ids: ids}}).execute();
  browser.set({query: {ids: ids}}).execute();
  device.set({query: {ids: ids}}).execute();
  resolution.set({query: {ids: ids}}).execute();
  user_session.set({query: {ids: ids}}).execute();
  country_session.set({query: {ids: ids}}).execute();
  Returning_user.set({query: {ids: ids}}).execute();
  count_sessionByLanguage.set({query: {ids: ids}}).execute();
  //geo_Country.set({query: {ids: ids}}).execute();
  setTimeout(function() {$("#load").hide();$('#results').css("opacity",1); }, 4000);
 });
  
});

</script>
<script type="text/javascript" src="bootstrap/js/daterangepicker.jQuery.js"></script>
<script type="text/javascript" src="bootstrap/js/jquery-ui.js"></script>
<link rel="stylesheet" href="bootstrap/css/jquery-ui.css">
 
</body>
</html>
