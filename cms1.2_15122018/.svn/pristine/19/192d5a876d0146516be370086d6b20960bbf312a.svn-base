<?php
    $client_id = "821149278327-5ggr4kjht6ja1gleekhthbqukql0ao2e.apps.googleusercontent.com"; //your client id
    $client_secret = "30eHngIjiEHQOx5CwktRo_7N"; //your client secret
    $redirect_uri = "http://localhost/blacktheme_3_12/admin-mycloud_now/Analytics_old.php";
	//$redirect_uri = "http://127.0.0.1:3000/auth/google_oauth2/callback";
    $scope = "https://www.googleapis.com/auth/plus.login"; //google scope to access
    $state = "profile"; //optional
    $access_type = "offline"; //optional - allows for retrieval of refresh_token for offline access

    if(isset($_POST['results'])){
        $_SESSION['accessToken'] = get_oauth2_token($_POST['results']);
    }

    //returns session token for calls to API using oauth 2.0
        function get_oauth2_token($code) {
        global $client_id;
        global $client_secret;
        global $redirect_uri;
        $oauth2token_url = "https://accounts.google.com/o/oauth2/token";
        $clienttoken_post = array(
        "code" => $code,
        "client_id" => $client_id,
        "client_secret" => $client_secret,
        "redirect_uri" => $redirect_uri,
        "grant_type" => "authorization_code"
        );

        $curl = curl_init($oauth2token_url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $clienttoken_post);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $json_response = curl_exec($curl);
        error_log($json_response);
        curl_close($curl);   
        $authObj = json_decode($json_response);

        if (isset($authObj->refresh_token)){
            //refresh token only granted on first authorization for offline access
            //save to db for future use (db saving not included in example)
            global $refreshToken;
            $refreshToken = $authObj->refresh_token;
        }

        $accessToken = $authObj->access_token;
        return $accessToken;
    }
?>

<!DOCTYPE html>
<html>
<head>
	 
  <title>Mycloud_TV GA</title>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" href="analytics/css/index.css">
  <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <script src="analytics/js/Chart.js"></script>
    <script src="analytics/js/utils.js"></script>

<script src="analytics/js/moment.min.js"></script>

<link rel="stylesheet" href="analytics/css/chartjs-visualizations.css">


<!--GA-->
<!--<script src="https://apis.google.com/js/client:platform.js?onload=startApp"></script>-->
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>  
  <script type="text/javascript">
    (function () {
      var po = document.createElement('script');
      po.type = 'text/javascript';
      po.async = true;
      po.src = 'https://plus.google.com/js/client:plusone.js?onload=start';
      var s = document.getElementsByTagName('script')[0];
      s.parentNode.insertBefore(po, s);
    })();
  </script>
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
            <li><a href="dashbord.php"><i class="fa fa-home" title="Home"></i> Home</a></li>
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
	
	
	
<div id="graphcontainer" style="display: block;">
     <div id="active-users-container" style="width: 12%; float: right; margin-top: 4.1%;"> </div>
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
    <ul class="FlexGrid FlexGrid--halves" style="margin-left: 20px;width:50%;">
    	<li class="FlexGrid-item"  style="width:100%; ">
    		<div class="Chartjs">
    			<div class="Titles">
    				<div style="font-size: 19px; height:30px;width:100%; background-color: #222223;  color:white;">Geo Graph</div>
    				<div class="Titles-sub" style="font-size: 12px; padding-bottom: 8px;">By Users</div>
    			</div>
    		</div>
    		<div class="Chartjs" style="font-size: 15px !important;">  
                 <figure class="Chartjs-figure" id="regions_divnew2" style="width:500px"> </figure>
            </div>
    	<li/>
    </ul>
    </div>
   
	<div class="Chartjs" style="position: relative; display: inline-flex;width: 100%;">
	<!--<div id="main-chart-container" style="width: 30%; position: absolute; "> </div>-->
	<!--  Session Line Chart Start -->
	<ul class="FlexGrid FlexGrid--halves" style="width:50%;">
    <li class="FlexGrid-item" style="width:100%; ">
        <div class="Chartjs">
            <div class="Titles">
                <div style="font-size: 19px; height:30px;width:100%; background-color: #222223; color:white;margin-top:80px;"> Last 7 days Sessions  </div>
                <div class="Titles-sub" style="font-size: 12px; ">Last 7 days         </div>
                <div class="Chartjs" style="position: relative; display: inline-flex;"> 
                    <div class="Chartjs" style="font-size: 15px !important;"> 
                        <section id="breakdown-chart-container" style="padding: 0px !important"> </section>
                
                    </div>
                </div>
            </div>
        </div>
    </li>
    </ul>
    
    <!--  Session Pie Chart Start -->
    <ul class="FlexGrid FlexGrid--halves" style="margin-left: 20px;width:50%">
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
	
	
		<!--<hr style="color: #b0b1b2 !important; margin-top:140px;" />-->
	
    <div class="Chartjs" style="position: relative; display: inline-flex;width: 100%;">
    	    <!--  Session Line Chart Last 30 Days Start -->
    <ul class="FlexGrid FlexGrid--halves" style="width:50%;">
    	<li class="FlexGrid-item" style="width:100%;">
    		<div class="Chartjs">
    			<div class="Titles">
    				<!--<h2>Daily users</h2>-->
    				<div style="font-size: 19px; height:30px;width:100%; background-color: #222223; color:white;"> Daily users for last 30 days	</div>
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
     <!--  Session Line Chart Last Week Days Start -->
    <ul class="FlexGrid FlexGrid--halves" style="margin-left: 20px;width: 50%;">
    	<li class="FlexGrid-item" style="width:100%; ">
    		<div class="Chartjs">
    			<div class="Titles">
    				<!--<h2>Comparing sessions from last week to this week</h2>-->
    				<div style="font-size: 19px; height:30px;width:100%; background-color:  #222223; color:white;"> Previous 7 days	</div>
    				<div class="Titles-sub" style="font-size: 12px; padding-bottom: 8px;">By sessions </div>
    			 <div class="Chartjs" style="position: relative; display: inline-flex;"> 
    				<div class="Chartjs" style="font-size: 15px !important;">  
                         <div id="data-chart-1-container"> </div>
                        <!--div id="date-range-selector-1-container"> </div-->
                    </div>
                </div>
    		</div></div>
    	</li>
    </ul>
    </div>

    <!--<hr style="color: #b0b1b2 !important;" />-->
    <div class="Chartjs" style="position: relative; display: inline-flex; width: 100%">
         <!--  Session comparison chart between Previous week and this week Start -->
    <ul class="FlexGrid FlexGrid--halves" style="width: 50%">
    	<li class="FlexGrid-item" style="width:100%;">
    		<div class="Chartjs">
    			<div class="Titles">
    			<!--	<h2>This Week vs Last Week (by users)</h2>-->
    				<div style="font-size: 19px; height:30px;width:100%; background-color:  #222223; color:white;"> This Week vs Last Week (by users)	</div>
    				<div class="Titles-sub" style="font-size: 12px; padding-bottom: 8px;">By sessions    			</div>
    			</div>
    		</div>
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
    	</li>
    </ul>
    <!--  Session comparison chart between Previous Year and this Year Start -->
    <ul class="FlexGrid FlexGrid--halves" style="margin-left: 20px;width: 50%" >
    	<li class="FlexGrid-item" style="width:100%; ">
    		<div class="Chartjs">
    			<div class="Titles">
    				<!--<h2>This Year vs Last Year (by users)</h2>-->
    				<div style="font-size: 19px; height:30px;width:100%; background-color:  #222223; color:white;"> This Year vs Last Year (by users)	</div>
    				<div class="Titles-sub" style="font-size: 12px; padding-bottom: 8px;">By sessions 			</div>
    			
    			</div>
    		</div>
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
    	</li>
    </ul>
    </div>
    
    
   <div class="Chartjs" style="position: relative; display: inline-flex; width: 100%">
         <!--  Session comparison chart between Previous week and this week Start -->
    <ul class="FlexGrid FlexGrid--halves" style="width: 50%">
    	<li class="FlexGrid-item" style="width:100%;">
    		<div class="Chartjs">
    			<div class="Titles">
    			<div style="font-size: 19px; height:30px;width:100%; background-color:  #222223; color:white;"> Operating System	</div>
    				<!--<div class="Titles-sub" style="font-size: 12px; padding-bottom: 8px;">By Users			</div>-->
    			         <div class="Chartjs" style="position: relative; display: inline-flex;"> 
    				        <div class="Chartjs" style="font-size: 15px !important;">  
                                <figure class="Chartjs-figure" id="regions_divnew_os" style="width:600px"> </figure>
                
                            </div>
                        </div>
    		      </div>
    		  </div>
    	</li>
    </ul>
      <ul class="FlexGrid FlexGrid--halves" style="margin-left: 20px;width: 50%" >
    	<li class="FlexGrid-item" style="width:100%; ">
    		<div class="Chartjs">
    			<div class="Titles">
    				<div style="font-size: 19px; height:30px;width:100%; background-color:  #222223; color:white;"> Browser	</div>
    				<!--<div class="Titles-sub" style="font-size: 12px; padding-bottom: 8px;">By Users			</div>-->
    			         <div class="Chartjs" style="position: relative; display: inline-flex;"> 
    				        <div class="Chartjs" style="font-size: 15px !important;">  
                                <figure class="Chartjs-figure" id="regions_divnew_browser" style="width:600px"> </figure>
                
                            </div>
                        </div>
    		      </div>
    		  </div>
    	</li>
    </ul>
    </div>
    
    <div class="Chartjs" style="position: relative; display: inline-flex; width: 100%">
         <!--  Session comparison chart between Previous week and this week Start -->
    <ul class="FlexGrid FlexGrid--halves" style="width: 50%">
    	<li class="FlexGrid-item" style="width:100%;">
    		<div class="Chartjs">
    			<div class="Titles">
    				<div style="font-size: 19px; height:30px;width:100%; background-color: black;  color:white;">Device	</div>
    				<!--<div class="Titles-sub" style="font-size: 12px; padding-bottom: 8px;">By Users			</div>-->
    			         <div class="Chartjs" style="position: relative; display: inline-flex;"> 
    				        <div class="Chartjs" style="font-size: 15px !important;">  
                                <figure class="Chartjs-figure" id="regions_divnew_device" style="width:600px"> </figure>
                
                            </div>
                        </div>
    		      </div>
    		  </div>
    	</li>
    </ul>
      <ul class="FlexGrid FlexGrid--halves" style="margin-left: 20px;width: 50%" >
    	<li class="FlexGrid-item" style="width:100%; ">
    		<div class="Chartjs">
    			<div class="Titles">
    				<div style="font-size: 19px; height:30px;width:100%; background-color: black;  color:white;"> Resolution	</div>
    				<!--<div class="Titles-sub" style="font-size: 12px; padding-bottom: 8px;">By Users			</div>-->
    			         <div class="Chartjs" style="position: relative; display: inline-flex;"> 
    				        <div class="Chartjs" style="font-size: 15px !important;">  
                                <figure class="Chartjs-figure" id="regions_divnew_screen" style="width:600px"> </figure>
                
                            </div>
                        </div>
    		      </div>
    		  </div>
    	</li>
    </ul>
    </div>
    
    
    
    
    <div class="Chartjs" style="position: relative; display: inline-flex; width: 100%">
         <!--  Session comparison chart between Previous week and this week Start -->
    <ul class="FlexGrid FlexGrid--halves" style="width: 50%">
    	<li class="FlexGrid-item" style="width:100%;">
    		<div class="Chartjs">
    			<div class="Titles">
    				<div style="font-size: 19px; height:30px;width:100%; background-color: black;  color:white;">Event Category/Action</div>
    				<!--<div class="Titles-sub" style="font-size: 12px; padding-bottom: 8px;">By Users			</div>-->
    			         <div class="Chartjs" style="position: relative; display: inline-flex;"> 
    				        <div class="Chartjs" style="font-size: 15px !important;">  
                                <figure class="Chartjs-figure" id="regions_divnew_event_cat" style="width:600px"> </figure>
                
                            </div>
                        </div>
    		      </div>
    		  </div>
    	</li>
    </ul>
    
   <ul class="FlexGrid FlexGrid--halves" style="margin-left: 20px;width: 50%" >
    	<li class="FlexGrid-item" style="width:100%; ">
    		<div class="Chartjs">
    			<div class="Titles">
    				<div style="font-size: 19px; height:30px;width:100%; background-color: black;  color:white;">Real Time graph</div>
    				<!--<div class="Titles-sub" style="font-size: 12px; padding-bottom: 8px;">By Users			</div>-->
    			        <div class="Chartjs" style="position: relative; display: inline-flex;"> 
    				        <div class="Chartjs" style="font-size: 15px !important;">  
                                <figure class="Chartjs-figure" id="regions_divnew_event_min" style="width:600px"> </figure>
                
                            </div>
                        </div>
    		      </div>
    		  </div>
    	</li>
  </ul>
    
     
    </div>
    </br></br>
    <div class="Chartjs" style="position: relative; display: inline-flex; width: 100%">
         <!--  Session comparison chart between Previous week and this week Start -->
    <ul class="FlexGrid FlexGrid--halves" style="width: 50%">
    	<li class="FlexGrid-item" style="width:100%;">
    		<div class="Chartjs">
    			<div class="Titles">
    				<div style="font-size: 19px; height:30px;width:100%; background-color: black;  color:white;">Gender	</div>
    				<!--<div class="Titles-sub" style="font-size: 12px; padding-bottom: 8px;">By Users			</div>-->
    			         <div class="Chartjs" style="position: relative; display: inline-flex;"> 
    				        <div class="Chartjs" style="font-size: 15px !important;">  
                                <figure class="Chartjs-figure" id="regions_divnew_gender" style="width:600px"> </figure>
                
                            </div>
                        </div>
    		      </div>
    		  </div>
    	</li>
    </ul>
    
       <ul class="FlexGrid FlexGrid--halves" style="margin-left: 20px;width: 50%" >
    	<li class="FlexGrid-item" style="width:100%; ">
    		<div class="Chartjs">
    			<div class="Titles">
    				<div style="font-size: 19px; height:30px;width:100%; background-color: black;  color:white;">AGE	</div>
    				<!--<div class="Titles-sub" style="font-size: 12px; padding-bottom: 8px;">By Users			</div>-->
    			         <div class="Chartjs" style="position: relative; display: inline-flex;"> 
    				        <div class="Chartjs" style="font-size: 15px !important;">  
                                <figure class="Chartjs-figure" id="regions_divnew_age" style="width:600px"> </figure>
                
                            </div>
                        </div>
    		      </div>
    		  </div>
    	</li>
    </ul>
    
    </div>
    
    <!--<hr style="color: #b0b1b2 !important;" />-->


  <!--div id="regions_divnew2old" style="width: 900px; height: 500px;"> </div><br><br>
 <div id="regions_div" style="width: 900px; height: 500px;"> </div-->
 </div>
 
</div>
</div>
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
   //alert("test="+myval);
   gapi.analytics.ready(function() {
   console.log("step 1");
   // Step 3: Authorize the user.
  //var CLIENT_ID = '565671880649-eu1nfc9628594tg6ti7odt12v5mkhngf.apps.googleusercontent.com';
   var CLIENT_ID = '821149278327-5ggr4kjht6ja1gleekhthbqukql0ao2e.apps.googleusercontent.com';
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
        var data = "refresh_token=1%2FCwvIsuUY9e8wH40qD5CQsaXT-MDsEMOYqhCywCgf8tE&client_id=821149278327-5ggr4kjht6ja1gleekhthbqukql0ao2e.apps.googleusercontent.com&grant_type=refresh_token&client_secret=30eHngIjiEHQOx5CwktRo_7N";
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
 /* var viewSelector = new gapi.analytics.ViewSelector({
    container: 'view-selector'
  });*/
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

 

// Time line graph End	///////


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
  
   var regiongraph2 = new gapi.analytics.googleCharts.DataChart({
    
   query: {
      'dimensions': 'ga:country',
      'metrics': 'ga:users',
      'start-date': '30daysAgo',
      'end-date': 'yesterday',
    },
    chart: {
      type: 'GEO',
      container: 'regions_divnew2',
      options: {
        region: 'world', 
        //resolution: 'metros',
        //keepAspectRatio:true,
        displayMode: 'regions',
        width:'90%',
        height:'55%'
      }
    }
  });

  var regiongraph3 = new gapi.analytics.googleCharts.DataChart({
    
   query: {
      'dimensions': 'ga:browser',
      'metrics': 'ga:users',
      'start-date': '30daysAgo',
      'end-date': 'yesterday',
    },
    chart: {
      type: 'PIE',
      container: 'regions_divnew_browser',
      options: {
        region: 'browser', 
        //resolution: 'metros',
        //keepAspectRatio:true,
        displayMode: 'browser',
        options: {
        width: '500',
        pieHole: 4/9
      }
        
      }
    }
  });
  var regiongraph4 = new gapi.analytics.googleCharts.DataChart({
    
   query: {
      'dimensions': 'ga:operatingSystem',
      'metrics': 'ga:users',
      'start-date': '30daysAgo',
      'end-date': 'yesterday',
    },
    chart: {
      type: 'PIE',
      container: 'regions_divnew_os',
      options: {
        region: 'operatingSystem', 
        //resolution: 'metros',
        //keepAspectRatio:true,
        displayMode: 'operatingSystem',
        options: {
        width: '500',
        pieHole: 4/9
      }
        
      }
    }
  });
  
 var regiongraph5 = new gapi.analytics.googleCharts.DataChart({
    
   query: {
      'dimensions': 'ga:mobileDeviceModel',
      'metrics': 'ga:users',
      'start-date': '30daysAgo',
      'end-date': 'yesterday',
    },
    chart: {
      type: 'PIE',
      container: 'regions_divnew_device',
      options: {
        region: 'mobileDeviceModel', 
        //resolution: 'metros',
        //keepAspectRatio:true,
        displayMode: 'mobileDeviceModel',
        options: {
        width: '500',
        pieHole: 4/9
      }
        
      }
    }
  });
  
   var regiongraph6 = new gapi.analytics.googleCharts.DataChart({
    
   query: {
      'dimensions': 'ga:screenResolution',
      'metrics': 'ga:users',
      'start-date': '30daysAgo',
      'end-date': 'yesterday',
    },
    chart: {
      type: 'PIE',
      container: 'regions_divnew_screen',
      options: {
        region: 'screenResolution', 
        //resolution: 'metros',
        //keepAspectRatio:true,
        displayMode: 'screenResolution',
        options: {
        width: '500',
        pieHole: 4/9
      }
        
      }
    }
  });
  var regiongraph7 = new gapi.analytics.googleCharts.DataChart({
    
   query: {
      'dimensions': 'ga:eventCategory, ga:eventAction',
      'metrics': 'ga:totalEvents,ga:users',
      'start-date': 'today',
      'end-date': 'today',
    },
    chart: {
      type: 'TABLE',
      container: 'regions_divnew_event_cat',
      options: {
        region: 'eventCategory', 
        //resolution: 'metros',
        //keepAspectRatio:true,
        displayMode: 'eventCategory',
        options: {
        width: '500',
   pieHole: 4/9
      }
        
      }
    }
  });

 
  
  
  var regiongraph8 = new gapi.analytics.googleCharts.DataChart({
    
   query: {
      'dimensions': 'ga:minute',
      'metrics': 'ga:uniqueEvents',
      'start-date': 'today',
      'end-date': 'today',
      //'filters':'ga:timeOnPage<=30',
    },
    chart: {
      type: 'LINE',
      container: 'regions_divnew_event_min',
      options: {
        region: 'userTimingCategory', 
        //resolution: 'metros',
        //keepAspectRatio:true,
        displayMode: 'userTimingCategory',
        options: {
        width: '500',
  // pieHole: 4/9
      }
        
      }
    }
  });
  
  
   var regiongraph9 = new gapi.analytics.googleCharts.DataChart({
    
   query: {
      'dimensions': 'ga:userGender',
      'metrics': 'ga:users',
      'start-date': '30daysAgo',
      'end-date': 'yesterday',
    },
    chart: {
      type: 'PIE',
      container: 'regions_divnew_gender',
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
  });
 var regiongraph10 = new gapi.analytics.googleCharts.DataChart({
    
   query: {
      'dimensions': 'ga:userAgeBracket',
      'metrics': 'ga:users',
      'start-date': '30daysAgo',
      'end-date': 'yesterday',
    },
    chart: {
      type: 'PIE',
      container: 'regions_divnew_age',
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
  });
  
  /*filter weekly data*/
  
  
/////// Time line graph End	////////////////

/////////// Country Pie graph Start	////////////////


  /**
   * Create the first DataChart for top countries over the past 30 days.
   * It will be rendered inside an element with the id "chart-1-container".
   */
  /*var dataChart1 = new gapi.analytics.googleCharts.DataChart({
    query: {
      metrics: 'ga:sessions',
      dimensions: 'ga:country',
      'start-date': '30daysAgo',
      'end-date': 'yesterday',
      'max-results': 6,
      sort: '-ga:sessions'
    },
    chart: {
      container: 'view-selector-Country1',
      type: 'PIE',
      options: {
        width: '20%',
        pieHole: 4/9
      }
    }
  });
*/

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

  /**
   * Update the first dataChart when the first view selecter is changed.
   */
  
  
  /////////// Intractive graph Start	////////////////

  
  
  var mainChart = new gapi.analytics.googleCharts.DataChart({
    query: {
      'dimensions': 'ga:browser',
      'metrics': 'ga:sessions',
      'sort': '-ga:sessions',
      'max-results': '6'
    },
    chart: {
      type: 'TABLE',
      container: 'main-chart-container',
      options: {
        width: '100%'
      }
    }
  });


  /**
   * Create a timeline chart showing sessions over time for the browser the
   * user selected in the main chart.
   */
  var breakdownChart = new gapi.analytics.googleCharts.DataChart({
    query: {
      'dimensions': 'ga:date',
      'metrics': 'ga:sessions',
      'start-date': '7daysAgo',
      'end-date': 'yesterday'
    },
    chart: {
      type: 'LINE',
      container: 'breakdown-chart-container',
      options: {
        width: '500'
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
    regiongraph2.set(newIds).execute();
    regiongraph3.set(newIds).execute();
    regiongraph4.set(newIds).execute();
    regiongraph5.set(newIds).execute();
    regiongraph6.set(newIds).execute();
    regiongraph7.set(newIds).execute();
    regiongraph8.set(newIds).execute();
    regiongraph9.set(newIds).execute();
    regiongraph10.set(newIds).execute();
    dataChart1.set({query: {ids: data.ids}}).execute();
    dataChart2.set({query: {ids: data.ids}}).execute();
    mainChart.set({query: {ids: data.ids}}).execute();
    breakdownChart.set({query: {ids: data.ids}}).execute(); 
    // Render all the of charts for this view.
    renderWeekOverWeekChart(data.ids);
   renderYearOverYearChart(data.ids);
   
  });
 

  /////////// Custom Component graph End	////////////////
  
/*   viewSelector.on('change', function(ids) { console.log("ids ",ids);console.log("second change");
    var newIds = {
      query: {
        ids: ids
      }
    }
    timeline.set(newIds).execute();
    regiongraph.set(newIds).execute();
    regiongraph2.set(newIds).execute();
    //dataChart1.set({query: {ids: ids}}).execute();
    dataChart2.set({query: {ids: ids}}).execute();
    mainChart.set({query: {ids: ids}}).execute();
    breakdownChart.set({query: {ids: ids}}).execute(); 
    // Render all the of charts for this view.
    renderWeekOverWeekChart(ids);
    renderYearOverYearChart(ids);
     
   
  });*/
 
 
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
 <!--script type="text/javascript" src="http://www.gstatic.com/charts/loader.js"></script>
   <script type="text/javascript" src="https://www.google.com/jsapi"></script-->
   <script type="text/javascript" src="http://www.google.com/jsapi"></script>
   
  

