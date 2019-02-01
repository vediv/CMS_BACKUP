<?php
include_once 'auths.php'; 
include_once 'auth.php'; 
//include_once 'function.inc.php';
include_once("function.php");
$conn=db_connect(DASHBOARD_USER_ID,PUBLISHER_UNIQUE_ID);
switch($code)
{
    case "content":
    $cur_date= date('Y-m-d');
    $pre_month = date('Y-m-d', strtotime('-1 months'));
    $fromDate=isset($_GET['fromDate'])?$_GET['fromDate']:$pre_month;        
    $toDate=isset($_GET['toDate'])?$_GET['toDate']:$cur_date;  
    //$searchInput=isset($_GET['searchInput'])?$_GET['searchInput']:'';
    ?>
<!--<script src="js/tableToExcel.js"></script>
<script src="js/jspdf.debug.js"></script>-->
<script src="js/jquery-1.11.2.min.js"></script>
<div class="panel panel-default">
<div class="panel-heading">
 <!-- <h3 class="panel-title "><i class="fa fa-filter"></i> Filter</h3>
   <div class="panel-title ">Text on the right</div>-->
     <div class="row">
            <div class="col-md-4 text-left"><i class="fa fa-filter"></i> Filter</div>
            <!--<div class="col-md-4 text-center">Header center</div>-->
            <div class="col-md-8 text-right"><a href="report.php?code=content">Clear Filter</a></div>
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
    <!--<select id="pagelmt"  style="width:60px;" onchange="selpagelimit('report.php?code=content');" >
       <option value="10"  <?php echo $pagelimit==10? "selected":""; ?> >10</option>
        <option value="20"  <?php echo $pagelimit==20? "selected":""; ?> >20</option>
        <option value="50"  <?php echo $pagelimit==50? "selected":""; ?> >50</option>
        <option value="100" <?php echo $pagelimit==100? "selected":""; ?> >100</option>
        <option value="200" <?php echo $pagelimit==200? "selected":""; ?> >200</option>
        <option value="500" <?php echo $pagelimit==500? "selected":""; ?> >500</option>
    </select> Records Per Page
    </td>-->
    
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
    <!--<input type="button" onclick="tableToExcel('testTable', 'W3C Example Table')" value="Excel">
    <input type="button" onclick="tableToExcel('testTable', 'W3C Example Table')" value="PDF">-->
<a href="javascript:" class="myBtn btn" title="Export to Excel" onclick="tableToExcel('testTable', 'W3C Example Table')" ><i class="fa fa-file-excel-o bigger-110 green"></i></a>
 <!--   <a href="javascript:" class="myBtn btn " title="Export to pdf" onclick="exportData('.pdf','revenue_pdf')"><i class="fa fa-file-pdf-o bigger-110 " aria-hidden="true"></i></a>-->

</td>

</tr>
</table>
    <div class="box-body" id="content_report">
     <span id="content_report_loader"></span>
     
    </div>    
</div>
<script type='text/javascript'>
$(document).ready(function () {
var dataUrl='http://192.168.24.34/cgi-bin/limeentry.cgi';    
var url = dataUrl+"?startdate=<?php echo $fromDate; ?>&enddate=<?php echo $toDate; ?>";
$("#content_report_loader").fadeIn(1).html('<img src="img/image_process.gif" height="20" />');
$.ajax({
type:'POST',
url: url,
dataType: "json",
data:{},
success:function(r){
//console.log(r);
if(r.data.length > 0){
var len=r.data.length;
var html='';
html+='<table id="testTable" class="table table-bordered">';
html+='<tr><th>Entry ID</th><th>Name</th><th>View</th><th>Duration(Sec)</th><th>BytesTotal</th></tr>';
for(var i=0;i<len;i++)
 { 
       var duration=r.data[i].TotalInSeconds;
       var entry_id=r.data[i].Entry_id; var view=r.data[i].TotalRequest;
       var name=r.data[i].Name;var bytestotal=r.data[i].BytesTotal;
       html+='<tr>';
       html+='<td>'+entry_id+'</td>';
       html+='<td>'+name+'</td>';
       html+='<td>'+view+'</td>';
       html+='<td>'+duration+'</td>';
       html+='<td>'+bytestotal+'</td>';
       html+='</tr>';
    }
    html+='</table>';
    $('#content_report').html(html);
    $("#content_report_loader").hide(); 
   }
  else{
    $('#content_report').html("data not available!");
    $("#content_report_loader").hide(); 
 } 
 }

   });
    });
</script>   
<script type="text/javascript">
   /*$("#tableToExcel").click(function (e) {
    alert("santosh");
    window.open('data:application/vnd.ms-excel,' + $('#testTable').html());
    e.preventDefault();
});*/
</script>
 
   
<?php } ?>