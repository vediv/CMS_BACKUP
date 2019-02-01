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
    //$searchInput=isset($_GET['searchInput'])?$_GET['searchInput']:'';
    ?>
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
    <div class="box-body" id="contentpartner_report">
    <table id="example1" class="display" width="100%">
        <thead>
        <tr>
          <th>PuserID</th>
          <th>No of Videos</th>
          <th>View</th>
          <th>BytesTotal(GB)</th>
        </tr>
      </thead> 
     </table>
        <span style="margin: 500px;" id="contentpartner_report_loader"></span>
    </div>    
</div>
<script type="text/javascript">
$(document).ready(function() {
    $('#example1').DataTable( {
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
                title: 'Content Partner Report'
            },
            {
                extend: 'pdfHtml5',
                title: 'Content Partner Report'
            }
        ]
    } );
} );

</script>    
<script type='text/javascript'>
 var name ,amount;
   $(function() {
   $('#example1').DataTable();
   // Premade test data, you can also use your own
   var testDataUrl = "http://ott.planetcast.in:7171/content_partner?startdate=<?php echo $fromDate; ?>&enddate=<?php echo $toDate; ?>";
   $("#example1").ready(function() {
    loadData();
  });
  function loadData() {
       $("#contentpartner_report_loader").fadeIn(1).html('<img src="img/image_process.gif" height="20" />');
    $.ajax({
      type: 'GET',
      url: testDataUrl,
      contentType: "text/plain",
      dataType: 'json',
      success: function (data) {
     
           $("#contentpartner_report_loader").hide(); 
        var myJsonData = data;
        populateDataTable(myJsonData);
      },
      error: function (e) {
        console.log("There was an error with your request...");
        console.log("error: " + JSON.stringify(e));
      }
    });
  }

           function adrevenue(puserid,fromdate,todate){
               
           var info = 'puserid='+puserid+'&action=content_partner_with_addRevenue'+'&fromDate='+fromdate+'&toDate='+todate;
                $.ajax({
                        type: "POST",
                        url: "dashboardReport.php",
                        dataType: "json",
                        data: info,
                success: function(r){
                var len= r.data.length;
                name=r.data[0].content_partner_name;
                //amount=r.data[0].TotalAdsAmount;
                alert(name);
             }
    });  
} 
  // populate the data table with JSON data
  function populateDataTable(data) {
      
//   $("#example").DataTable().clear();
    var length = Object.keys(data.data).length;
    // var fromdate= "<?php echo $fromDate; ?>";
    // var todate= "<?php echo $toDate; ?>";

    for(var i = 0; i < length; i++) {
        var puserid=data.data[i].puser_id;
        var customer = data.data;
        var entry=customer[i].Entry.length;
        //var getcnameadrevenue= adrevenue(puserid,fromdate,todate);
        //alert(getcnameadrevenue);
        var totalByte=0;
        var view=0;
         for(var j=0;j<entry;j++)
         {      
            var totalview=data.data[i].Entry[j].TotalRequests;
            view = view + totalview;
            var TotalBytes=data.data[i].Entry[j].TotalBytes;
            var totalByte = totalByte + TotalBytes;
            
     
      var GB1= totalByte/(1024 * 1024 * 1024);
      var GB = parseFloat(Number(GB1).toFixed(3));
         }
       // You could also use an ajax property on the data table initialization
       $('#example1').dataTable().fnAddData( [
      '<a href="javascript:void(0)" onclick="viewPartnerDetail( \'' + puserid + '\')"  title="View Entry Details" class="result">' + puserid+'</a>',
//      '<a href="javascript:void(0)" onclick="viewcontentvideoDetail( \'' + entry + '\')"  title="View Entry Details" class="result">' + entry+'</a>',

   
        //getcnameadrevenue,
        entry,
        view,
        GB,
        //amount
      ]);
   
      }
  }
})();

        
</script>   
 <script>
 
 $(document).ready(function() {
    setTimeout(function() {
        $("#contentpartner_report_loader").fadeOut(1500);
    }, 100);
});
 
 </script>
<?php } ?>