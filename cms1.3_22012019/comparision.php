<?php
include_once 'corefunction.php';
include 'common_ga.php';
?>

<!DOCTYPE html>
<html>
<head>
 
<title><?php echo ucwords(PROJECT_TITLE). "| GA-Comparision"; ?></title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="analytics/css/index.css">
<link href="bootstrap/css/pagingCss.css" rel="stylesheet" type="text/css" /> 
<script src="analytics/js/Chart.js"></script>
<script src="analytics/js/utils.js"></script>
<script src="analytics/js/client.js"></script>
<script src="analytics/js/moment.min.js"></script>
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
           <!--	<small><span class="glyphicon glyphicon-plus" style="color:#3290D4"></span></small>--></a></h1> 
          <ol class="breadcrumb">
            <li><a href="dashboard.php"><i class="fa fa-home" title="Home"></i> Home</a></li>
            <li class="active">Analytics </li>
          </ol>          
    </section>
<div id="main">
 <div class="box">
   <div class="box-body">
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
              <div class="row" style="display: none;">
    	           <div class="col-sm-6" id="date-range-selector-1-container"> </div>
    	          <div class="col-sm-2">
                 <button id='submitDate' type="button"  style="margin-top: 15%;">Show Details</button>	
                 </div>
             </div>
    
    <!--<hr style="color: #b0b1b2 !important;" />-->
   <div class="Chartjs" style="position: relative; display: inline-flex; width: 100%">
    	
         <!--  Session comparison chart between Previous week and this week Start -->
   <ul class="FlexGrid FlexGrid--halves" style="width: 49%">
    <li class="FlexGrid-item" style="width:100%;">
    		
    	<div class="Chartjs">
    		<div class="Titles">
    			<!--	<h2>This Week vs Last Week (by users)</h2>-->
    			<div style="font-size: 19px; height:30px;width:100%;  color:#09192a; line-height: 1.5;  "> This Week vs Last Week (by users)	</div>
    			<div class="Titles-sub" style="font-size: 12px; padding-bottom: 8px;">By sessions    			</div>
    		</div>
    	</div>
 <div style="display:inherit" class="day box box-primary">
    <div class="box-header">
		<div class="Chartjs" style="font-size: 15px !important;"> 
       	<figure class="Chartjs-figure" id="chart-1-container"> </figure>
	      <ol class="Chartjs-legend" id="legend-1-container">
	        <li> 
	          <i style="background:rgb(215, 215, 215)">Last week</i>
	        </li>
	        <li>
	        	<i style="background:rgba(51, 146, 194)">This week</i>
	        </li>
	       </ol>
     </div>
   </div>
</div>
</li>
</ul>
    <!--  Session comparison chart between Previous Year and this Year Start -->
<ul class="FlexGrid FlexGrid--halves" style="margin-left: 0px;width: 49%" >
    	<li class="FlexGrid-item" style="width:100%; ">
    		<div class="Chartjs">
    			<div class="Titles">
    				<!--<h2>This Year vs Last Year (by users)</h2>-->
    				<div style="font-size: 19px; height:30px;width:100%;   color:#09192a; line-height: 1.5;"> This Year vs Last Year (by users)	</div>
    				<div class="Titles-sub" style="font-size: 12px; padding-bottom: 8px;">By sessions 			</div>
    			
    			</div>
    		</div>
<div style="display:inherit" class="day box box-primary">
     <div class="box-header">
    		<div class="Chartjs" style="font-size: 15px !important;">  
              <figure class="Chartjs-figure" id="chart-2-container" style="width:100%;"> </figure>
                <ol class="Chartjs-legend" id="legend-2-container">
                	<li> 
                		<i style="background:rgb(215, 215, 215)">Last year</i>
                	</li>
                	 <li>
                		<i style="background:rgb(51, 146, 194)">This year</i>
                	</li>  
               </ol>
           </div> 
    </div> 
 </div>
</li>
</ul>
</div>
</div>
</div>    
 </div>
</div>
</div>
    <?php include_once "footer.php";  include_once 'commonJS.php'; ?>    
</div>
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
 ////////// Time line graph Start	////////////////
 
    var viewSelector = new gapi.analytics.ext.ViewSelector2({
        container: 'view-selector'
  })
  .execute();

/*  ---------------- * Query params representing the  chart's date range end.   */

  // Step 6: Hook up the components to work together.

  gapi.analytics.auth.on('success', function(response) {console.log("step 2");
    viewSelector.execute();
    document.getElementById('graphcontainer').style.display='block';
    
  });

  // Step 5: Create the timeline chart.


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

    // Update the "from" dates text.
    
    var newDate = {query: data};
   
    /////////////////////////
    //activeUsers.set(data).execute();
   
    // Render all the of charts for this view.
    renderWeekOverWeekChart(newDate);
   renderYearOverYearChart(newDate);
    
    
    ///////////////////////////
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
    // Render all the of charts for this view.
    renderWeekOverWeekChart(data.ids);
   renderYearOverYearChart(data.ids);
   
  });
 
/////////// Country Pie graph End	////////////////
  function renderWeekOverWeekChart(ids) {
console.log("renderWeek ids ",ids);
    // Adjust `now` to experiment with different days, for testing only...
    var now = moment(); // .subtract(3, 'day');

    var thisWeek = query({
      'ids': ids,
      'dimensions': 'ga:date,ga:nthDay',
      'metrics': 'ga:sessions',
      'start-date': moment(now).subtract(1, 'day').day(0).format('YYYY-MM-DD'),
      'end-date': moment(now).format('YYYY-MM-DD')
    });

    var lastWeek = query({
      'ids': ids,
      'dimensions': 'ga:date,ga:nthDay',
      'metrics': 'ga:sessions',
      'start-date': moment(now).subtract(1, 'day').day(0).subtract(1, 'week')
          .format('YYYY-MM-DD'),
      'end-date': moment(now).subtract(1, 'day').day(6).subtract(1, 'week')
          .format('YYYY-MM-DD')
    });

    Promise.all([thisWeek, lastWeek]).then(function(results) {

      var data1 = results[0].rows.map(function(row) { return +row[2]; }); 
      var data2 = results[1].rows.map(function(row) { return +row[2]; });
      var labels = results[1].rows.map(function(row) { return +row[0]; });

      labels = labels.map(function(label) {
        return moment(label, 'YYYYMMDD').format('ddd');
      });

      var data = {
        labels : labels,
        datasets : [
          {
            label: 'Last Week',
            fillColor : 'rgb(215, 215, 215)',
            strokeColor : 'rgb(169, 168, 168)',
            pointColor : 'rgba(220,220,220,1)',
            pointStrokeColor : '#fff',
            data : data2
          },
          {
            label: 'This Week',
            fillColor : 'rgba(145, 211, 235,0.5)',
            strokeColor : 'rgb(5, 141, 199)',
            pointColor : 'rgba(151,187,205,1)',
            pointStrokeColor : '#fff',
            data : data1
          }
        ]
      };

      new Chart(makeCanvas('chart-1-container')).Line(data);
      generateLegend('legend-1-container', data.datasets);
    })
    .catch(function(err) {
      console.error("Error renderWeek ",err.stack);
    });
  }


// This Year vs Last Year .............

  function renderYearOverYearChart(ids) {
console.log("renderYear ids ",ids);
    // Adjust `now` to experiment with different days, for testing only...
    var now = moment(); // .subtract(3, 'day');

    var thisYear = query({
      'ids': ids,
      'dimensions': 'ga:month,ga:nthMonth',
      'metrics': 'ga:users',
      'start-date': moment(now).date(1).month(0).format('YYYY-MM-DD'),
      'end-date': moment(now).format('YYYY-MM-DD')
    });

    var lastYear = query({
      'ids': ids,
      'dimensions': 'ga:month,ga:nthMonth',
      'metrics': 'ga:users',
      'start-date': moment(now).subtract(1, 'year').date(1).month(0)
          .format('YYYY-MM-DD'),
      'end-date': moment(now).date(1).month(0).subtract(1, 'day')
          .format('YYYY-MM-DD')
    });

    Promise.all([thisYear, lastYear]).then(function(results) {
      var data1 = results[0].rows.map(function(row) { return +row[2]; });
      var data2 = results[1].rows.map(function(row) { return +row[2]; });
      var labels = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];

      // Ensure the data arrays are at least as long as the labels array.
      // Chart.js bar charts don't (yet) accept sparse datasets.
      for (var i = 0, len = labels.length; i < len; i++) {
        if (data1[i] === undefined) data1[i] = null;
        if (data2[i] === undefined) data2[i] = null;
      }

      var data = {
        labels : labels,
        datasets : [
          {
            label: 'Last Year',
            fillColor : 'rgb(215, 215, 215)',
            strokeColor : 'rgb(5, 141, 199)',
            data : data2
          },
          {
            label: 'This Year',
            fillColor : 'rgba(145, 211, 235,0.5)',
            strokeColor : 'rgb(5, 141, 199)',
            data : data1
          }
        ]
      };

      new Chart(makeCanvas('chart-2-container')).Bar(data);
      generateLegend('legend-2-container', data.datasets);
    })
    .catch(function(err) {
      console.error("Error renderYear ",err.stack);
    });
  }
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
</body>
</html>

