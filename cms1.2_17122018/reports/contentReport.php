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
?>
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
         <div class="form-group" style="margin-left:280px;">
            
           <label for="from">from</label>
           <input type="text" id="fromDate" size="10"  name="fromDate" autocomplete="off" value="<?php echo $fromDate; ?>"   />
           <i class="fa fa-calendar" aria-hidden="true"></i>
           <label for="to">to</label>
           <input type="text" id="toDate" size="10" name="toDate" autocomplete="off" value="<?php echo $toDate; ?>"  />
           <i class="fa fa-calendar" aria-hidden="true" id="to"></i>
        
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
<div id="load" style="display:none;"></div>
    <div class="box-body" id="content_report" >
        <table id="example" class="display nowrap" style="width:100%">
        <thead>
        <tr>
          <th>Entry ID</th>
          <th>Name</th>
          <th>View</th>
          <th>Duration(Sec)</th>
          <th>BytesTotal(GB)</th>
        </tr>
       </thead> 
        </table>
         <span id="content_report_loader"></span>
    </div>    
</div>
<script type="text/javascript">
$(document).ready(function() {
    $('#example').DataTable( {
          dom: 'lBfrtip',
        // Configure the drop down options.
        
        lengthMenu: [
            [ 10, 25, 50, -1 ],
            [ '10', '25', '50', 'Show all' ]
        ],
        
        // Add to buttons the pageLength option.
       buttons: [
            {
                extend: 'excelHtml5',
                title: 'Content Report'
            },
            {
                extend: 'pdfHtml5',
                title: 'Content Report'
            }
        ]
    } );
} );

</script>        
<script type='text/javascript'>
$(function() {
   //$('#example').DataTable();
  // Premade test data, you can also use your own
  var testDataUrl = "http://ott.planetcast.in:7171/entry_range?startdate=<?php echo $fromDate; ?>&enddate=<?php echo $toDate; ?>";
  $("#example").ready(function() {
    loadData();
  });
  function loadData() {
   $("#content_report_loader").fadeIn(1).html('<img src="img/image_process.gif" height="20" />');
   $('#load').show();
   $('#content_report').css("opacity",0.1);
   $.ajax({
      type: 'GET',
      url: testDataUrl,
      contentType: "text/plain",
      dataType: 'json',
      success: function (data) {
       $("#content_report_loader").hide(); 
        var myJsonData = data;
        $("#load").hide();
        $('#content_report').css("opacity",1);
        
        populateDataTable(myJsonData);
      },
      error: function (e) {
        console.log("There was an error with your request...");
        console.log("error: " + JSON.stringify(e));
      }
    });
  }

  // populate the data table with JSON data
  function populateDataTable(data) {
//   $("#example").DataTable().clear();
    var length = Object.keys(data.data).length;
    
    for(var i = 0; i < length; i++) {
      
      var Entry_id=data.data[i].Entry_id;
      var Name=data.data[i].Name;
      var TotalRequest=data.data[i].TotalRequest;
      var TotalInSeconds=Math.round(data.data[i].TotalInSeconds);
      var BytesTotal=data.data[i].BytesTotal;
      var GB1= BytesTotal/(1024 * 1024 * 1024);
      var GB = parseFloat(Number(GB1).toFixed(3));
     // You could also use an ajax property on the data table initialization
 
           $('#example').dataTable().fnAddData( [
        Entry_id,
        Name,
        TotalRequest,
        TotalInSeconds,
        GB
      ]);
      
      
    }
    
  }
})();

 </script>   
<?php } ?>