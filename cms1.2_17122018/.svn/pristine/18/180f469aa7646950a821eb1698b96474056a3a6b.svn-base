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
<style type="text/css">
	 button, input, optgroup, select, textarea{color: #454545 !important; font-size: 13px !important;     font-weight: 600 !important; padding: 4px; background-color: #f5f5f5;    background-image: -moz-linear-gradient(center top , #f5f5f5, #f1f1f1);
    border: 1px solid #dcdcdc;    border-radius: 2px;   cursor: default; line-height: 27px;    list-style: outside none none;  }
  
     .half {    float: left;    padding-left: 12px;    width: 49.6%;}
      .half-container{padding: 10px; width: 100%;}
      .loader { border: 8px solid #f3f3f3; border-top: 8px solid #3498db; border-radius: 50%;width: 80px;height: 80px;animation: spin 2s linear infinite;}
@keyframes spin {0% { transform: rotate(0deg); }100% { transform: rotate(360deg);}
.hide-loader{display:none;}
 </style>
 <link href="bootstrap/css/pagingCss.css" rel="stylesheet" type="text/css" /> 
    <script src="dist/js/jquery-1.10.1.min.js"></script>
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
    	
 <?php include_once 'header.php';?>
<?php include_once 'lsidebar.php';?>
      <!-- Content Wrapper. Contains page content -->



      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
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
          	
          <div class="box">
          	
          <div class="box-header">

<div id="embed-api-auth-container"></div>

<div class="col-md-12" style="margin-top:10px;background:#eeeeee; border:0px solid red; ">
<div class="pull-left">
   <div id="view-selector-container" class="col-sm-9"  style="display: inline-flex; margin-left: 0px; width:50%;padding:1px; border:0px solid red;"></div> 
</div>
<!--<div id="view-selector-container" class="col-sm-9"  style="display: inline-flex; margin-left: 0px; width:50%;padding:1px; border:1px solid red;"></div>--> 
<?php $today=date("Y-m-d"); $before1month=date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-1 month" ) ); ?>
<div class="pull-right">
<form action="javascript:" id="frmDateRange">
    <div class="col-sm-3" style="display: inline-flex; padding:3px; margin-left:25px;     font-size: 13px !important;">
    <label for="from" style="padding: 5px 3px 0 0 !important">From</label>
    <input type="text" id="startDate" size="10"  placeholder="eg. <?php echo $before1month?>" value="<?php echo $before1month?>" required="">
    <label for="to" style="padding: 5px 3px 0 3px !important;">to</label>
    <input type="text" id="endDate" size="10" placeholder="eg. <?php echo date("Y-m-d")?>" value="<?php echo date("Y-m-d")?>" required="">
    <button type="submit" class="btn btn-success" style="padding: 2px 4px !important;  margin-left: 10px; border-color: #4cae4c !important;">Get Data</button>
    </div>
</form>
</div>    
    </div>

    <div class="col-md-12" style="margin-top:10px; padding-left: 0px;">
    <select id="country" onchange="getstate(this.value)"></select>
    <select id="state" onchange="getcity(this.value)" ><option>Select State</option></select>
	<select id="city"><option>Select City</option></select>
	 
            
     </div>
   

 <script type="text/javascript">
  $(function() {
    $("#startDate").datepicker({dateFormat: "yy-mm-dd"});  
    $("#endDate").datepicker({dateFormat: "yy-mm-dd"});
  });
</script>
<script type="text/JavaScript">
var $select = $('#country');
 $.getJSON('analytics/countries.json', function(data){

 $select.html('<option>Select Country</option>');

 $.each(data.countries, function(key, val){
 $select.append('<option value="' + val.id + '"   id="' + val.id + '">' + val.name + '</option>');
 })
 });
    
function getstate(countryid){
$.getJSON('analytics/states.json', function(data){
	var stateobj=data.states;
 //alert(stateobj.length);
optn="<option>Select State</option>";
  for(var j=0; j<stateobj.length; j++)
  {
  var country_id=stateobj[j].country_id;
  var	Name=stateobj[j].name;
  var stateid=stateobj[j].id;
  
  if(country_id==countryid)
  	optn+='<option value='+stateid+' >'+Name+'</option>'
  }
 
document.getElementById("state").innerHTML=optn;

});
}


function getcity(stateid){
	$.getJSON('analytics/cities.json', function(data){
	var cityobj=data.cities;
 
 var len=cityobj.length;
 optnl='<option value="">Select City</option>'; 
 
for(var k=0; k<len; k++)
  {
  var state_id=cityobj[k].state_id;
  var	Name=cityobj[k].name;
  var cityid=cityobj[k].id;
  
  if(state_id==stateid)
  {
  	optnl+='<option value="'+Name+'">'+Name+'</option>';
  	
  }
  	
  }
document.getElementById("city").innerHTML=optnl;
document.getElementById("city").focus();

});
}
</script>
  
  
  
  <div class="half-container" style="padding-top: 50px">
  	<h4 style="margin-top:52px;">GEO GRAPH</h4>
  	<div style="display:inherit" class="day box box-primary">
                <div class="box-header">
  	
  	<div class="loader" id="loader" style="position: absolute; margin: 7% 0% 0% 42%" >  </div>
  <div id="GEO_GRAPH" style="height: 300px;margin-top:40px;">
  </div>
  </div></div></div>
  
  
   <div class="half">
   	<h4>Daily users for last 30 days</h4>
   	 <div style="display:inherit" class="day box box-primary">
       <div class="box-header">
  <div class="half-container">
  	
  	<div class="loader" id="loader" style="margin:19% 1% 0 36%; position: absolute;">  </div>
  <div id="USER_GRAPH" style="height: 300px;">
  </div></div>
  </div>
  </div>
  </div>
  
  <div class="half">
  	<h4>Operating System</h4>
  	 <div style="display:inherit" class="day box box-primary">
       <div class="box-header">
  <div class="half-container">
  
  <div class="loader" id="loader" style="margin: 19% 1% 0 36%; position: absolute;">  </div>
  <div id="OS_GRAPH" style="height: 300px;">
  </div></div></div>
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
   
   <div class="half"><h4>Geo graph (Session)</h4>
   	 <div style="display:inherit" class="day box box-primary">
        <div class="box-header">
   <div class="half-container">
  	<div class="loader" id="loader" style="margin: 19% 1% 0 36%; position: absolute;">  </div>
   <div id="GEO_GRAPH_SESSION" style="height: 300px;">
   </div>
   </div></div></div>
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
   
   
    <div class="half"><h4>Top country by session</h4>
    	 <div style="display:inherit" class="day box box-primary">
           <div class="box-header">
   <div class="half-container">
  	<div class="loader" id="loader" style="margin: 19% 1% 0 36%; position: absolute;">  </div>
   <div id="TOP_COUNTRY" style="height: 300px; ">
   </div></div></div>
   </div>
   </div>
  
    
      <!-- <div class="half">
   <div class="half-container">
  	<h4>AGE</h4>
  	<div class="loader" id="loader"  style="margin: 7% 0% 0% 15%;position: absolute;">  </div>
   <div id="AGE_GRAPH" style="height: 300px; width: 100%;">
   </div>
   </div>
    </div>-->
  
 <!--- <div class="half">
   <div class="half-container">
  	<h4>GENDER</h4>
  	<div class="loader" id="loader" style="margin: 7% 0% 0% 19%;position: absolute;">  </div>
   <div id="GENDER_GRAPH" style="height: 300px; width: 100%;">
   </div>
   </div>
  </div > -->
   
  
    </div>
         </div>     
        <div>	
       </div>

        </section><!-- /.content -->
      
    </div><!-- /.content-wrapper -->


      <?php
       include_once"footer.php"; include_once 'commonJS.php';
      ?>
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
  
  
  var startDate=function(){return _("startDate").value};
  var endDate=function(){return _("endDate").value};

  /**
   * Create a new DataChart instance with the given query parameters
   * and Google chart options. It will be rendered inside an element
   * with the id "chart-container".
   */
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
  
  
  
 /* var age = new gapi.analytics.googleCharts.DataChart({
    
   query: {
      'dimensions': 'ga:userAgeBracket',
      'metrics': 'ga:users',
      'start-date': '30daysAgo',
      'end-date': 'yesterday',
    },
    chart: {
      type: 'PIE',
      container: 'AGE_GRAPH',
      options: {
        region: 'userAgeBracket', 
        //resolution: 'metros',
        //keepAspectRatio:true,
        displayMode: 'userAgeBracket',
        options: {
        width: '500',
        pieHole: 4/9
      }
        
      }
    }
  });*/
  
 /* var gender = new gapi.analytics.googleCharts.DataChart({
    
   query: {
      'dimensions': 'ga:userGender',
      'metrics': 'ga:users',
      'start-date': 'yesterday',
      'end-date': 'today',
    },
    chart: {
      type: 'PIE',
      container: 'GENDER_GRAPH',
      options: {
        region: 'userGender', 
        //resolution: 'metros',
        //keepAspectRatio:true,
        displayMode: 'userGender',
        options: {
        width: '500',
        pieHole: 4/9
      }
        
      }
    }
  });*/
 
  function getCity()
  {
  	if(_("city").value=="")
  	{
  		var location=_("state").value;
  	}
  	else
  	{
  		location=_("city").value;
  	}
  	return location;
  }
  
 
  _("city").addEventListener("change",function(){startDate()
  userno.set({query: {'start-date': startDate(),'end-date': endDate(),'filters':'ga:city=='+getCity()}}).execute();
  geo.set({query: {'start-date': startDate(),'end-date': endDate(),'filters':'ga:city=='+getCity()}}).execute();
  OS.set({query: {'start-date': startDate(),'end-date': endDate(),'filters':'ga:city=='+getCity()}}).execute();
  browser.set({query: {'start-date': startDate(),'end-date': endDate(),'filters':'ga:city=='+getCity()}}).execute();
  device.set({query: {'start-date': startDate(),'end-date': endDate(),'filters':'ga:city=='+getCity()}}).execute();
  resolution.set({query: {'start-date': startDate(),'end-date': endDate(),'filters':'ga:city=='+getCity()}}).execute();
  geo_session.set({query: {'start-date': startDate(),'end-date': endDate(),'filters':'ga:city=='+getCity()}}).execute();
  user_session.set({query: {'start-date': startDate(),'end-date': endDate(),'filters':'ga:city=='+getCity()}}).execute();
  country_session.set({query: {'start-date': startDate(),'end-date': endDate(),'filters':'ga:city=='+getCity()}}).execute();
//  age.set({query: {'start-date': startDate(),'end-date': endDate()}}).execute();
//  gender.set({query: {'start-date': startDate(),'end-date': endDate()}}).execute();

  });
  _("city").addEventListener("focus",function(){startDate()
  userno.set({query: {'start-date': startDate(),'end-date': endDate(),'filters':'ga:city=='+getCity()}}).execute();
  geo.set({query: {'start-date': startDate(),'end-date': endDate(),'filters':'ga:city=='+getCity()}}).execute();
  OS.set({query: {'start-date': startDate(),'end-date': endDate(),'filters':'ga:city=='+getCity()}}).execute();
  browser.set({query: {'start-date': startDate(),'end-date': endDate(),'filters':'ga:city=='+getCity()}}).execute();
  device.set({query: {'start-date': startDate(),'end-date': endDate(),'filters':'ga:city=='+getCity()}}).execute();
  resolution.set({query: {'start-date': startDate(),'end-date': endDate(),'filters':'ga:city=='+getCity()}}).execute();
  geo_session.set({query: {'start-date': startDate(),'end-date': endDate(),'filters':'ga:city=='+getCity()}}).execute();
  user_session.set({query: {'start-date': startDate(),'end-date': endDate(),'filters':'ga:city=='+getCity()}}).execute();
  country_session.set({query: {'start-date': startDate(),'end-date': endDate(),'filters':'ga:city=='+getCity()}}).execute();
//  age.set({query: {'start-date': startDate(),'end-date': endDate()}}).execute();
//  gender.set({query: {'start-date': startDate(),'end-date': endDate()}}).execute();

  });

  
  
 
  _("frmDateRange").addEventListener("submit",function(){startDate()
  userno.set({query: {'start-date': startDate(),'end-date': endDate()}}).execute();
  geo.set({query: {'start-date': startDate(),'end-date': endDate()}}).execute();
  OS.set({query: {'start-date': startDate(),'end-date': endDate()}}).execute();
  browser.set({query: {'start-date': startDate(),'end-date': endDate()}}).execute();
  device.set({query: {'start-date': startDate(),'end-date': endDate()}}).execute();
  resolution.set({query: {'start-date': startDate(),'end-date': endDate()}}).execute();
  geo_session.set({query: {'start-date': startDate(),'end-date': endDate()}}).execute();
  user_session.set({query: {'start-date': startDate(),'end-date': endDate()}}).execute();
  country_session.set({query: {'start-date': startDate(),'end-date': endDate()}}).execute();
//age.set({query: {'start-date': startDate(),'end-date': endDate()}}).execute();
//gender.set({query: {'start-date': startDate(),'end-date': endDate()}}).execute();

  });

  /**
   * Render the dataChart on the page whenever a new view is selected.
   */
  viewSelector.on('change', function(ids) {
  userno.set({query: {ids: ids}}).execute();
  geo.set({query: {ids: ids}}).execute();
  OS.set({query: {ids: ids}}).execute();
  browser.set({query: {ids: ids}}).execute();
  device.set({query: {ids: ids}}).execute();
  resolution.set({query: {ids: ids}}).execute();
  geo_session.set({query: {ids: ids}}).execute();
  user_session.set({query: {ids: ids}}).execute();
  country_session.set({query: {ids: ids}}).execute();
 //age.set({query: {ids: ids}}).execute();
 // gender.set({query: {ids: ids}}).execute();
  });
      $('#loader').addClass("hide-loader");
});

</script>
<script type="text/javascript" src="bootstrap/js/daterangepicker.jQuery.js"></script>
<script type="text/javascript" src="bootstrap/js/jquery-ui.js"></script>
<link rel="stylesheet" href="bootstrap/css/jquery-ui.css">
</body>
</html>
