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
<script type="text/javascript">
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
          <h1>Analytics Active User </h1>
          <ol class="breadcrumb">
            <li><a href="dashbord.php"><i class="fa fa-home" title="Home"></i> Home</a></li>
              <li class="active">Analytics Active User </li>
          </ol>
        </section>
<section class="content">
<div class="row">
<div class="col-xs-12">
                <div class="box" id="results">
                <div id="load" style="display:none;"></div>
                <div class="box-header">
                <div id="embed-api-auth-container"></div>
                <div class="col-md-12" style="margin-top:10px;background:#eeeeee;">
                    <div id="view-selector-container" class="col-sm-8"  style="display: inline-flex; margin-left: 0px; width:775px;padding:1px;"></div> 
                    <?php $today=date("Y-m-d"); $before1month=date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-1 month" ) ); ?>
                    <!--<form action="javascript:" id="frmDateRange">
                    <div class="col-sm-3" style="display: inline-flex; padding:3px; margin-left:25px;     font-size: 13px !important;">
                    <label for="from" style="padding: 5px 3px 0 0 !important">From</label>
                    <input type="text" id="startDate" size="10" style=" padding: 4px !important;    width: 32% !important;" placeholder="eg. <?php echo $before1month?>" value="<?php echo $before1month?>" required="">
                    <label for="to" style="padding: 5px 3px 0 3px !important;">to</label>
                    <input type="text" id="endDate" size="10" style=" padding: 4px !important;    width: 32% !important;" placeholder="eg. <?php echo date("Y-m-d")?>" value="<?php echo date("Y-m-d")?>" required="">
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
                   </form>
                </div>
               <div class="col-md-2 col-lg-4 col-sm-12">&nbsp;</div>
                </div>
                   <div class="half" ><h4>1 Day Active Users<level data-toggle="tooltip" title="The number of unique users who had at least one session within the last day in your active date range."> <i class="fa fa-question-circle" style="color: #058dc7;"></i></level></h4>
                    <div style="display:inherit" class="day box box-primary">
                    <div class="box-header">
                    <div class="half-container">
                        <div class="loader" id="loader" style="margin: 19% 1% 0 36%; position: absolute;">  </div>
                    <div id="one_DayActive_user" style="height: 300px; ">
                    </div></div></div>
                    </div>
                    </div>
                   <div class="half"><h4>7 Day Active Users<level data-toggle="tooltip" title="The number of unique users who had at least one session within a 7-day period. The 7-day period includes the last day in your active date range."> <i class="fa fa-question-circle" style="color: #058dc7;"></i></level></h4>
                    <div style="display:inherit" class="day box box-primary">
                    <div class="box-header">
                    <div class="half-container">
                        <div class="loader" id="loader" style="margin: 19% 1% 0 36%; position: absolute;">  </div>
                    <div id="seven_DayActive_user" style="height: 300px; ">
                    </div></div></div>
                    </div>
                    </div>
                    <div class="half"><h4>14 Day Active Users<level data-toggle="tooltip" title="The number of unique users who had at least one session within a 14-day period. The 14-day period includes the last day in your active date range"> <i class="fa fa-question-circle" style="color: #058dc7;"></i></level></h4>
                    <div style="display:inherit" class="day box box-primary">
                    <div class="box-header">
                    <div class="half-container">
                        <div class="loader" id="loader" style="margin: 19% 1% 0 36%; position: absolute;">  </div>
                    <div id="fourteen_DayActive_user" style="height: 300px; ">
                    </div></div></div>
                    </div>
                    </div>
                    <div class="half"><h4>28 Day Active Users<level data-toggle="tooltip" title="The number of unique users who had at least one session within a 28-day period. The 28-day period includes the last day in your active date range"> <i class="fa fa-question-circle" style="color: #058dc7;"></i></level></h4>
                    <div style="display:inherit" class="day box box-primary">
                    <div class="box-header">
                    <div class="half-container">
                        <div class="loader" id="loader" style="margin: 19% 1% 0 36%; position: absolute;">  </div>
                    <div id="thirty_DayActive_user" style="height: 300px; ">
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
</div>	
</div>

</section><!-- /.content -->

</div><!-- /.content-wrapper -->
<?php include_once"footer.php"; include_once 'commonJS.php';?>
</div><!-- ./wrapper -->
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

  viewSelector.execute();
  var startDate=function(){return _("startDate").value};
  var endDate=function(){return _("endDate").value};
 
var one_Dayuser = new gapi.analytics.googleCharts.DataChart({
    reportType: 'ga',
    query: {
      'dimensions': 'ga:date',
      'metrics': 'ga:1dayUsers',
      'start-date': startDate(),
      'end-date': endDate(),
      'max-results': 10,
      //sort: '-ga:sessions'
    },
    chart: {
      container: 'one_DayActive_user',
      type: 'LINE',
      options: {
        width: '500',
        pieHole: 4/9
      }
    }
  });
  var seven_Dayuser = new gapi.analytics.googleCharts.DataChart({
  	reportType: 'ga',
    query: {
      'dimensions': 'ga:date',
      'metrics': 'ga:7dayUsers',
      'start-date': startDate(),
      'end-date': endDate(),
      'max-results': 10,
      //sort: '-ga:sessions'
    },
    chart: {
      container: 'seven_DayActive_user',
      type: 'LINE',
      options: {
        width: '500',
        pieHole: 4/9
      }
    }
  });
  var fourteen_Dayuser = new gapi.analytics.googleCharts.DataChart({
  	reportType: 'ga',
    query: {
      'dimensions': 'ga:date',
      'metrics': 'ga:14dayUsers',
      'start-date': startDate(),
      'end-date': endDate(),
      'max-results': 10,
      //sort: '-ga:sessions'
    },
    chart: {
      container: 'fourteen_DayActive_user',
      type: 'LINE',
      options: {
        width: '500',
        pieHole: 4/9
      }
    }
  });
  var thirty_Dayuser = new gapi.analytics.googleCharts.DataChart({
  	reportType: 'ga',
    query: {
      'dimensions': 'ga:date',
      'metrics': 'ga:30dayUsers',
      'start-date': startDate(),
      'end-date': endDate(),
      'max-results': 10,
      //sort: '-ga:sessions'
    },
    chart: {
      container: 'thirty_DayActive_user',
      type: 'LINE',
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
 
/*  function getCity()
  {
  	return _("city").value;
  }
  
 
  _("city").addEventListener("change",function(){startDate()
  
  one_Dayuser.set({query: {'start-date': startDate(),'end-date': endDate(),'filters':'ga:city=='+getCity()}}).execute();
  seven_Dayuser.set({query: {'start-date': startDate(),'end-date': endDate(),'filters':'ga:city=='+getCity()}}).execute();
  fourteen_Dayuser.set({query: {'start-date': startDate(),'end-date': endDate(),'filters':'ga:city=='+getCity()}}).execute();
  thirty_Dayuser.set({query: {'start-date': startDate(),'end-date': endDate(),'filters':'ga:city=='+getCity()}}).execute();
//  age.set({query: {'start-date': startDate(),'end-date': endDate()}}).execute();
//  gender.set({query: {'start-date': startDate(),'end-date': endDate()}}).execute();

  });
*/
 
 _("frmDateRange").addEventListener("submit",function(){startDate()
   $('#load').show();
  $('#results').css("opacity",0.1);   
  one_Dayuser.set({query: {'start-date': startDate(),'end-date': endDate()}}).execute();
  seven_Dayuser.set({query: {'start-date': startDate(),'end-date': endDate()}}).execute();
  fourteen_Dayuser.set({query: {'start-date': startDate(),'end-date': endDate()}}).execute();
  thirty_Dayuser.set({query: {'start-date': startDate(),'end-date': endDate()}}).execute();
  setTimeout(function() {$("#load").hide();$('#results').css("opacity",1); }, 2000);
});
viewSelector.on('change', function(ids) {
        $('#load').show();
        $('#results').css("opacity",0.1);
        one_Dayuser.set({query: {ids: ids}}).execute();
        seven_Dayuser.set({query: {ids: ids}}).execute();
        fourteen_Dayuser.set({query: {ids: ids}}).execute();
        thirty_Dayuser.set({query: {ids: ids}}).execute();
        setTimeout(function() {$("#load").hide();$('#results').css("opacity",1); }, 2000);
  });
});

</script>
<script type="text/javascript" src="bootstrap/js/daterangepicker.jQuery.js"></script>
<script type="text/javascript" src="bootstrap/js/jquery-ui.js"></script>
<link rel="stylesheet" href="bootstrap/css/jquery-ui.css">
</body>
</html>
