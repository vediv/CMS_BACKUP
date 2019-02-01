<?php
include_once 'auths.php'; 
include_once 'auth.php'; 
//include_once 'function.inc.php';
include_once("function.php");
$conn=db_connect(DASHBOARD_USER_ID,PUBLISHER_UNIQUE_ID);
switch($code)
{
    case "contentpartner":
    $cur_date= date('Y-m-d');
    $pre_month = date('Y-m-d', strtotime('-1 months'));
    $fromDate=isset($_GET['fromDate'])?$_GET['fromDate']:$pre_month;        
    $toDate=isset($_GET['toDate'])?$_GET['toDate']:$cur_date;  
  
   
 //   $searchInput=isset($_GET['searchInput'])?$_GET['searchInput']:'';
    ?>

<script src="tableToExcel.js"></script>
       <script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

<div class="panel panel-default">
<div class="panel-heading">
 <!-- <h3 class="panel-title "><i class="fa fa-filter"></i> Filter</h3>
   <div class="panel-title ">Text on the right</div>-->
     <div class="row">
            <div class="col-md-4 text-left"><i class="fa fa-filter"></i> Filter</div>
            <!--<div class="col-md-4 text-center">Header center</div>-->
            <div class="col-md-8 text-right"><a href="report.php?code=contentpartner">Clear Filter</a></div>
        </div>
</div>
<div class="panel-body">
    <div class="pull-center">
    <div class="form-inline">   
         <div class="form-group">
            
           <label for="from">from</label>
           <input type="text" id="fromDate" size="10"  name="fromDate" autocomplete="off" value="<?php echo $fromDate; ?>"   />
           <i class="fa fa-calendar" aria-hidden="true"></i>
           <label for="to">to</label>
           <input type="text" id="toDate" size="10" name="toDate" autocomplete="off" value="<?php echo $toDate; ?>"  />
           <i class="fa fa-calendar" aria-hidden="true"></i>
        
         </div>
  <div class="form-group text-right">
           <button type="button" id="button-filter-Content" class="btn btn-default"><i class="fa fa-search"></i> Search</button>
         </div>
       </div>

       </div>
   
  
     </div>
</div>
<div class="clear"></div>
<div class="row" style="border: 0px solid red; ">
    <table border='0' style="width:98%; margin-left: 10px;">
    <tr>
    <td width="25%">
    <select id="pagelmt"  style="width:60px;" onchange="selpagelimit('report.php?code=contentpartner');" >
       <option value="10"  <?php echo $pagelimit==10? "selected":""; ?> >10</option>
        <option value="20"  <?php echo $pagelimit==20? "selected":""; ?> >20</option>
        <option value="50"  <?php echo $pagelimit==50? "selected":""; ?> >50</option>
        <option value="100" <?php echo $pagelimit==100? "selected":""; ?> >100</option>
        <option value="200" <?php echo $pagelimit==200? "selected":""; ?> >200</option>
        <option value="500" <?php echo $pagelimit==500? "selected":""; ?> >500</option>
    </select> Records Per Page
    </td>
    
   <td width="47%">
     <!--   <div class="col-sm-3 col-md-3 pull-right navbar-form" role="search">  
            <div class="input-group add-on" style="float: right;">
            <input id='pagelimit' type="hidden" height="30px"  value="<?php  // echo $pagelimit; ?>">   
            <input class="form-control" size="30"  placeholder="Search by EntryID"  autocomplete="off" name='searchInput' id='searchInput' class="searchInput" type="text" value="<?php echo $searchInput; ?>">
            <div class="input-group-btn">
              <button class="enableOnInput btn btn-default"   id='searchSub' type="button" style="height: 30px;   padding: 4px 6px !important;"><i class="glyphicon glyphicon-search"></i></button>	
            </div>
            </div>
       </div>-->
    </td>
<td width="35%" align="right">
    <input type="hidden" name="fromDate" id="fromDate" value="<?php echo $fromDate; ?>"> 
    <input type="hidden" name="toDate" id="toDate" value="<?php echo $toDate; ?>">

<input type="button" onclick="tableToExcel('testTable', 'W3C Example Table')" value="Excel">
<input type="button" onclick="tableToExcel('testTable', 'W3C Example Table')" value="PDF"></td>

</tr>
</table>
    <div class="box-body" id="contentpartner_report">
                    <span id="contentpartner_report_loader"></span>
    </div>    
</div>
        
 
       <script type='text/javascript'>
                 $(document).ready(function () {
                  var url = "http://192.168.24.34/cgi-bin/limecontent.cgi?startdate=<?php echo $fromDate; ?>&enddate=<?php echo $toDate; ?>";
                 $("#contentpartner_report_loader").fadeIn(1).html('<img src="img/image_process.gif" height="20" />');
                        $.ajax({
                        type:'POST',
                        url: url,
                        dataType: "json",
                        
                        success:function(res){
                            
                         //  console.log(res);
                           var myJSON = JSON.stringify(res); 
                          // alert(myJSON);
                          var len=myJSON.length;
                         
                          // if(myJSON.length > 0){
                            
                        var html='';
                            html+='<table id="testTable" class="table table-bordered">';
                            html+='<tr><th>Content partner ID</th><th>Name</th><th>No of Videos</th><th>View</th><th>BytesTotal</th></tr>';
                            for(var i=0;i<len;i++)
                         { 
                               
                               var duration=myJSON.puser_id;
                                console.log(duration);
                               var entry_id=res.Entry_id; var view=res.TotalRequest;
                               var name=res[i].Name;var bytestotal=res.BytesTotal;
                               html+='<tr>';
                               html+='<td>'+entry_id+'</td>';
                               html+='<td>'+name+'</td>';
                               html+='<td>'+view+'</td>';
                               html+='<td>'+duration+'</td>';
                               html+='<td>'+bytestotal+'</td>';
                               html+='</tr>';
                            }
                            html+='</table>';
                            $('#contentpartner_report').html(html);
                            $("#contentpartner_report_loader").hide(); 
                           //}
                          //else{
                          //  $('#contentpartnert_report').html("data not available!");
                           // $("#contentpartner_report_loader").hide(); 
                         //} 
                         }
                        
                    });
                     });
                     
                     
   
 </script>   
    
 
   
<?php } ?>