<?php
include_once 'auths.php';
include_once 'auth.php';
include 'common_ga.php';
?>
<!DOCTYPE html>
<html>
<head>
	 
   <title><?php echo ucwords(PROJECT_TITLE). "-gA-Session-Detail"; ?></title>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" href="analytics/css/index.css">
 

    <script src="analytics/js/Chart.js"></script>
    <script src="analytics/js/utils.js"></script>

<script src="analytics/js/moment.min.js"></script>
  <script src="analytics/js/client.js"></script>

<link rel="stylesheet" href="analytics/css/chartjs-visualizations.css">


 
<!--endGA-->
 <?php include_once 'header.php';?>
<style>

/*-------------------------------------------- */


#main {
  margin-left: 10px;
  margin-right: 10px
  }

/*------------start graph css-------------*/

 
</style>
</head>

<body class="skin-blue">
<!--redirect-uri-->
<!--end-->

<!-- Step 1: Create the containing elements. -->

<div class="wrapper">
 
<?php include_once 'lsidebar.php';?>
<div class="content-wrapper">
	
	  <section class="content-header">
          <h1>Analytics <!--<ul class="list-unstyled legal-tabs" style="text-align:center;">-->
           <a href="#LegalModal" data-target=".bs-example-modal-lg" data-toggle="modal" title="Add New">
           	<small><span class="glyphicon glyphicon-plus" style="color:#3290D4"></span></small></a></h1> 
          <ol class="breadcrumb">
            <li><a href="dashboard.php"><i class="fa fa-home" title="Home"></i> Home</a></li>
            <li class="active">Analytics </li>
          </ol>          
         </section>
         
         <div class="col-xs-12">
          <div class="box">
        <div class="box-header">
        	</div>
        	</div>
        	</div>
<div id="main">
   <!-- interactive charts Start -->
	  <div style="display: inline;">
	 	
	 <div id="view-name" style="width:78%; padding-left: 0%; padding-top: 20px;"> </div>
	  <section id="auth-button" style="float: right; padding: 0px !important;  color:black; margin-top:-12px;"> </section>
	</div>
	
	
	
<div id="graphcontainer" style="display: block;background-color:white;">
     <div id="active-users-container" style="width: 12%; float: right; margin-top: 2.1%;"> </div>
	<section id="view-selector" style="position: relative; display: inline-flex; width: 900px"> </section>
    <hr style="color: red !important" />

 
                        <!-- <div id="data-chart-1-container"> </div>-->
                        
    <div class="row">
    	   <div class="col-sm-6" id="date-range-selector-1-container"> </div>
    	   <div class="col-sm-2">
<button id='submitDate' type="button"  style="margin-top: 15%;">Show Details</button>	
</div>
          <div class="col-sm-4" >
          <div class="row fileupload-buttonbar" style="margin-top:25px; float: right;margin-right:12px;">
             
                <!-- The fileinput-button span is used to style the file input field as button -->
              
                <button  value="Day" class="btn btn-primary start" id="daily_data" onclick="testf('1');">
                   <span>Day</span>
                </button>
                <button  value="Week" class="btn btn-warning cancel" id="weekly_data" onclick="testf('7');" >
                    <span>Week</span>
                </button>
                <button  value="Month" class="btn btn-danger delete" id="monthly_data" onclick="testf('30');">
                  <span>Month</span>
                </button> 
               <!-- <button type="button" onclick=_"gaq.push();">Contact Us!</button>-->
            </div>
            <!-- The global progress state -->
        </div>
        </div>
          </br>  
        
    <div class="Chartjs" style="position: relative; display: inline-flex;width:100%;">
    	    
    	    <!--  GEO Graph by Session Start -->
    <ul class="FlexGrid FlexGrid--halves" style="width:50%;">
    	<li class="FlexGrid-item" style="width:100%;">
    		<div class="Chartjs">
    			<div class="Titles">
                        <div style="font-size: 19px; height:30px;width:100%; background-color:#222223; color:white; "> Geo Graph</div>
                        <div class="Titles-sub" style="font-size: 12px; padding-bottom: 8px;">By sessions</div>
                       </div>
    		 </div>
            <div class="Chartjs" style="font-size: 15px !important;"> 
                                <figure class="Chartjs-figure" id="regions_divnew" style="width: 500px"> </figure>
                        
            </div>
            
    	</li>
    </ul>
    <!--  GEO Graph by User Start -->
   <ul class="FlexGrid FlexGrid--halves" style="width:55%;">
    	<li class="FlexGrid-item" style="width:100%;">
    		<div class="Chartjs">
    			<div class="Titles">
    				<!--<h2>Daily users</h2>-->
    				<div style="font-size: 19px; height:30px;width:100%; background-color: #222223; color:white;"><span id="days_msg"> </span></div>
    				    <div class="Titles-sub" style="font-size: 12px">By sessions         </div>
        			<div class="Chartjs" style="position: relative; display: inline-flex;"> 
        				<div class="Chartjs" style="font-size: 15px !important;"> 
                            <section id="timeline" style="padding: 0px !important"> </section> 
                        </div>
                    </div>
                </div>
    		</div>
    	</li>
    </ul>
    </div>
   
	<div class="Chartjs" style="position: relative; display: inline-flex;width: 100%;">
	<!--<div id="main-chart-container" style="width: 30%; position: absolute; "> </div>-->
	<!--  Session Line Chart Start -->
	
    
    <!--  Session Pie Chart Start -->
    <ul class="FlexGrid FlexGrid--halves" style="width:100%">
        <li class="FlexGrid-item" style="width:100%;">
            <div class="Chartjs">
                <div class="Titles">
                    <div style="font-size: 19px; height:30px;width:100%; background-color: #222223;  color:white;margin-top:80px;"> Top Countries by Sessions </div>
                    <div class="Titles-sub" style="font-size: 12px; padding-bottom: 8px;">Last 30 days         </div>
                         <div class="Chartjs" style="position: relative; display: inline-flex;"> 
                            <div class="Chartjs" style="font-size: 15px !important;">  
              .                  <section id="view-selector-Country2" style=" padding: 0px !important"> </section> 
                
                            </div>
                        </div>
                  </div>
              </div>
        </li>
    </ul>
	</div>
	
   
 </div>
 
</div>
</div>
    <?php include_once "footer.php"; ?>    
</div>
</body>
</html>
   <!-- Step 2: Load the library. -->

<script>
(function(w,d,s,g,js,fjs){
  g=w.gapi||(w.gapi={});g.analytics={q:[],ready:function(cb){this.q.push(cb)}};
  js=d.createElement(s);fjs=d.getElementsByTagName(s)[0];
  js.src='analytics/js/platform.js';
  fjs.parentNode.insertBefore(js,fjs);js.onload=function(){g.load('analytics')};
}(window,document,'script'));
</script>
<script src="analytics/js/view-selector2.js"></script>

<!-- Include the DateRangeSelector component script. -->
<script src="analytics/js/date-range-selector.js"></script>

<!-- Include the ActiveUsers component script. -->
<script src="analytics/js/active-users.js"></script>
<script>
var myvalue=30;
testf(myvalue);
function testf(myval)
{
	
	switch (myval) {
    case "1":
    var tt="Daily users for last "+myval+" days";
      document.getElementById('days_msg').innerHTML=tt;
        break;
    case "7":
    var tt="Daily users for last  "+myval+"  days"
      document.getElementById('days_msg').innerHTML=tt;
        break;
    case "30":
    { var tt="Daily users for last  "+myval+"  days"; }
       document.getElementById('days_msg').innerHTML=tt;
        break;
    default:
       document.getElementById('days_msg').innerHTML="Daily users for last "+myval+" days";
}
   //alert("test="+myval);
   gapi.analytics.ready(function() {
   console.log("step 1");
   // Step 3: Authorize the user.
  //var CLIENT_ID = '565671880649-eu1nfc9628594tg6ti7odt12v5mkhngf.apps.googleusercontent.com';
   var CLIENT_ID = '231090503373-7ftq27h2cfslnr8189iadb9e7f0dp7rn.apps.googleusercontent.com';
   gapi.analytics.auth.authorize({
             container: 'auth-button',
    clientid: CLIENT_ID,
    
serverAuth: {
    access_token: genKey()
   }
});

//console.log( "sonam"+genKey());
 function runAjax()
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
     localStorage.setItem("access_token",obj.access_token);
     
 }

function genKey()
 { 
    if(localStorage.getItem("access_token")) 
    {
       
        return localStorage.getItem("access_token");
    }
    else 
    {   
         runAjax();
        return localStorage.getItem("access_token");
    }
  
 }


setInterval(runAjax,180000); // runAjax will be called in every 30 minuts to refresh the access_token 



  var activeUsers = new gapi.analytics.ext.ActiveUsers({
    container: 'active-users-container',
    pollingInterval: 5
  });


  /**
   * Add CSS animation to visually show the when users come and go.
   */
    activeUsers.once('success', function() {console.log("active user");
    var element = this.container.firstChild;
    var timeout;

    this.on('change', function(data) {console.log("active user change");
      var element = this.container.firstChild;
      var animationClass = data.delta > 0 ? 'is-increasing' : 'is-decreasing';
      element.className += (' ' + animationClass);

      clearTimeout(timeout);
      timeout = setTimeout(function() {
        element.className =
        element.className.replace(/ is-(increasing|decreasing)/g, '');
      }, 3000);
    });
  });
  // Step 4: Create the view selector.
 
    var viewSelector = new gapi.analytics.ext.ViewSelector2({
        container: 'view-selector'
  })
  .execute();

/*
var viewSelector1 = new gapi.analytics.ViewSelector({
    container: 'view-selector-Country1'
  });

  var viewSelector2 = new gapi.analytics.ViewSelector({
    container: 'view-selector-Country2'
  });
  */
  
    
 
/*  ---------------- * Query params representing the  chart's date range end.   */

  // Step 6: Hook up the components to work together.

  gapi.analytics.auth.on('success', function(response) {console.log("step 2");
    viewSelector.execute();
    document.getElementById('graphcontainer').style.display='block';
    //viewSelector1.execute();
    //	viewSelector2.execute();
  });

  // Step 5: Create the timeline chart.

  var timeline = new gapi.analytics.googleCharts.DataChart({
    reportType: 'ga',
    query: {
      'dimensions': 'ga:date',
      'metrics': 'ga:sessions',
      'start-date': '15daysAgo',
      'end-date': 'yesterday',
    },
    chart: {
      type: 'LINE',
      container: 'timeline',
        options: {
        width: '500'
      }
    }
  });

 // Step 5: Create the Region chart.

  var regiongraph = new gapi.analytics.googleCharts.DataChart({
    query: {
      'dimensions': 'ga:country',
      'metrics': 'ga:sessions',
      'start-date': '30daysAgo',
      'end-date': 'yesterday',
    },
    chart: {
      type: 'GEO',
      container: 'regions_divnew',
        options: {
        	region: 'world',
        width: '500',
        displayMode: 'regions'
      }
    }
   
  });

  /**
   * Create the second DataChart for top countries over the past 30 days.
   * It will be rendered inside an element with the id "chart-2-container".
   */
  var dataChart2 = new gapi.analytics.googleCharts.DataChart({
    query: {
      metrics: 'ga:sessions',
      dimensions: 'ga:country',
      'start-date': '30daysAgo',
      'end-date': 'yesterday',
      'max-results': 6,
      sort: '-ga:sessions'
    },
    chart: {
      container: 'view-selector-Country2',
      type: 'PIE',
      options: {
        width: '500',
        pieHole: 4/9
      }
    }
  });


  
 /////// Intractive graph End	////////////
  
 var commonConfig = {
    query: {
      metrics: 'ga:sessions',
      dimensions: 'ga:date'
    },
    chart: {
      type: 'LINE',
      options: {
        width: '500'
      }
    }
  };

  /**
   * Query params representing the first chart's date range.
   */
 

 var dateRange1 = {
    'start-date': '30daysAgo',
    'end-date': 'today'
  };
  
   var dataChart1 = new gapi.analytics.googleCharts.DataChart(commonConfig)
      .set({query: dateRange1})
      .set({chart: {container: 'data-chart-1-container'}});
  
  
var dateRangeSelector1 = new gapi.analytics.ext.DateRangeSelector({
    container: 'date-range-selector-1-container'
  })
  .set(dateRange1)
  .execute();
  
 dateRangeSelector1.on('change', function(data) {console.log("daterange");
    dataChart1.set({query: data}).execute();
    
    var newDate = {query: data};
    /////////////////////////
    //activeUsers.set(data).execute();
    timeline.set(newDate).execute();
    regiongraph.set(newDate).execute();
    dataChart2.set(newDate).execute();
  

    // Update the "from" dates text.
    var datefield = document.getElementById('from-dates');
    datefield.textContent = data['start-date'] + '&mdash;' + data['end-date'];
  });



 viewSelector.on('viewChange', function(data) { console.log("first change");
 /*var newIds = {
      query: {
        ids: data.ids
             }
     }*/
  var newIds = {
      query: {
        ids: data.ids,
        'start-date':+myval+'daysAgo'
      }
    }
   

    var title = document.getElementById('view-name');
    title.textContent = data.property.name + ' (' + data.view.name + ')';
    // Start tracking active users for this view.
    activeUsers.set(data).execute();
    timeline.set(newIds).execute();
    regiongraph.set(newIds).execute();
    dataChart2.set({query: {ids: data.ids}}).execute();
  });
 
	  /**
   * Extend the Embed APIs `gapi.analytics.report.Data` component to
   * return a promise the is fulfilled with the value returned by the API.
   * @param {Object} params The request parameters.
   * @return {Promise} A promise.
   */
  function query(params) {
    return new Promise(function(resolve, reject) {
      var data = new gapi.analytics.report.Data({query: params});
      data.once('success', function(response) { resolve(response); })
          .once('error', function(response) { reject(response); })
          .execute();
          //console.log("data Query ",data);
    });
  }
  
  /**
   * Create a new canvas inside the specified element. Set it to be the width
   * and height of its container.
   * @param {string} id The id attribute of the element to host the canvas.
   * @return {RenderingContext} The 2D canvas context.
   */
  function makeCanvas(id) {
    var container = document.getElementById(id);
    var canvas = document.createElement('canvas');
    var ctx = canvas.getContext('2d');

    container.innerHTML = '';
    canvas.width = container.offsetWidth;
    canvas.height = container.offsetHeight;
    container.appendChild(canvas);

    return ctx;
  }
  
  /**
   * Create a visual legend inside the specified element based off of a
   * Chart.js dataset.
   * @param {string} id The id attribute of the element to host the legend.
   * @param {Array.<Object>} items A list of labels and colors for the legend.
   */
  function generateLegend(id, items) {
    var legend = document.getElementById(id);
    legend.innerHTML = items.map(function(item) {
      var color = item.color || item.fillColor;
      var label = item.label;
      return '<li><i style="background:' + color + '"></i>' +
          escapeHtml(label) + '</li>';
    }).join('');
  }


  // Set some global Chart.js defaults.
  Chart.defaults.global.animationSteps = 60;
  Chart.defaults.global.animationEasing = 'easeInOutQuart';
  Chart.defaults.global.responsive = true;
  Chart.defaults.global.maintainAspectRatio = false;


  
  function escapeHtml(str) {
    var div = document.createElement('div');
    div.appendChild(document.createTextNode(str));
    return div.innerHTML;
  }

});

}
 init();
</script>
 <!--script type="text/javascript" src="http://www.gstatic.com/charts/loader.js"></script>
   <script type="text/javascript" src="https://www.google.com/jsapi"></script
   <script type="text/javascript" src="http://www.google.com/jsapi"></script>-->
   
  

