<!DOCTYPE html>
<html>
  <head>
<meta charset="UTF-8">
<title><?php echo PROJECT_TITLE." | Analytics | Geo Location";?></title>
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
var _=function(id){return document.getElementById(id);};
(function(w,d,s,g,js,fs){
  g=w.gapi||(w.gapi={});g.analytics={q:[],ready:function(f){this.q.push(f);}};
  js=d.createElement(s);fs=d.getElementsByTagName(s)[0];
  js.src='https://apis.google.com/js/platform.js';
  fs.parentNode.insertBefore(js,fs);js.onload=function(){g.load('analytics');};
}(window,document,'script'));    
 function getCode()
 {
        var data = "refresh_token=<?php echo $refresh_token; ?>&grant_type=refresh_token&client_id=<?php echo $google_client_id; ?>&client_secret=<?php echo $client_secret; ?>";
        var xhr=new XMLHttpRequest();
        xhr.open("POST","https://www.googleapis.com/oauth2/v4/token",true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded'); 
        xhr.send(data);
        xhr.onreadystatechange=function(){if(xhr.readyState==4){parseJson(xhr.responseText);}};
 }
function parseJson(response)
 {
     var obj=JSON.parse(response); 
     localStorage.setItem("access_token",obj.access_token);
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
  });
});




</script>
</head>


<body class="skin-blue" onload="getCode()">
    <div class="wrapper">
    <?php include_once 'header.php'; include_once 'lsidebar.php';?>
     <div class="content-wrapper">
     <section class="content-header">
          <h1>Analytics Geo Location</h1>
          <ol class="breadcrumb">
            <li><a href="dashbord.php"><i class="fa fa-home" title="Home"></i> Home</a></li>
              <li class="active">Analytics Geo Location</li>
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
                                   <option value="location" <?php echo $view=='location'?"selected":''; ?>>Location</option>
                                   <option value="language">Event</option>
                                   <option value="location">Location</option>
                                </select>
                        </div>
                        <div  class="pull-right" style="border:0px solid red;"><strong>Screen </strong>
                        </div>
                       </div>
                       <div id="embed-api-auth-container"></div>
                       <input type="hidden" id="gaIDs">
                        <div class="col-md-12" style="margin-top:10px;background:#eeeeee;">
                            <div class="pull-left">  
                          <div id="view-selector-container" class="col-sm-8 pull-left"  style="display: inline-flex; margin-left: 0px; width:775px;padding:1px;"></div> 
                         </div>
                          <?php 
                          $today =date("Y-m-d");
                          echo $before_one_day= date('Y-m-d', strtotime($today . " - 1 day"));
                          echo $before_one_week= date('Y-m-d', strtotime($today . " - 7 day"));
                          ?>
                          <div class="pull-right">
                          <form action="javascript:" id="frmDateRange" style="border:1px solid red;">
                                 <div class="col-sm-3" style="display: inline-flex; padding:3px; margin-left:25px; font-size: 13px !important;">
                                 <label for="from" style="padding: 5px 3px 0 0 !important">Start Date</label>
                                 <input type="text" id="startDate" size="10" style=" padding: 4px !important;    width: 32% !important;" placeholder="eg. <?php echo $before1month;?>" value="<?php echo $before1month?>" required="">
                                 <label for="to" style="padding: 5px 3px 0 3px !important;">End Date</label>
                                 <input type="text" id="endDate" size="10" style=" padding: 4px !important;    width: 32% !important;" placeholder="eg. <?php echo date("Y-m-d")?>" value="<?php echo date("Y-m-d")?>" required="">
                                 <button type="submit" class="btn btn-success" style="padding: 2px 4px !important;  margin-left: 10px; border-color: #4cae4c !important;">Get Data</button>
                                 </div>
                          </form>
                          </div>
                        </div>
                        <div class="row"></div>  
                        <div class="row">
                         <div class="half-container">
                            <h4 style="margin-top:52px;"></h4>
                               <div style="display:inherit" class="day box box-primary">
                                   <div class="box-header">
                                       <div class="loader" id="loader" style="position: absolute; margin: 7% 0% 0% 42%" >  </div>
                                           <div id="GEO_GRAPH" style="height: 300px;margin-top:40px;"></div>
                                   </div>
                               </div>
                         </div>
                        </div>
                        <div class="row">
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
$(function() {
    $("#startDate").datepicker({dateFormat: "yy-mm-dd"});  
    $("#endDate").datepicker({dateFormat: "yy-mm-dd"});
});    
var startDate=function(){return _("startDate").value};
var endDate=function(){return _("endDate").value};
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
  
  

  
  

  
  
  
   
  


 
 
/* _("frmDateRange").addEventListener("submit",function(){startDate()
   
    geo.set({query: {'start-date': startDate(),'end-date': endDate()}}).execute();
  });
 viewSelector.on('change', function(ids) {
  geo.set({query: {ids: ids}}).execute();
  });
  
});*/

</script>
<script type="text/javascript" src="bootstrap/js/daterangepicker.jQuery.js"></script>
<script type="text/javascript" src="bootstrap/js/jquery-ui.js"></script>
<link rel="stylesheet" href="bootstrap/css/jquery-ui.css">
</body>
</html>
