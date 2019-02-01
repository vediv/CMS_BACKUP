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
  
   
 //   $searchInput=isset($_GET['searchInput'])?$_GET['searchInput']:'';
    ?>
<script src="js/tableToExcel.js"></script>
<script type="text/javascript" src="js/jspdf.debug.js"></script>
<script src="plugins/jQuery/jQuery-2.1.3.min.js"></script>
<link href="bootstrap/css/pagingCss.css" rel="stylesheet" type="text/css" />
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
  
<td width="35%" align="right">
    <input type="hidden" name="fromDate" id="fromDate" value="<?php echo $fromDate; ?>"> 
    <input type="hidden" name="toDate" id="toDate" value="<?php echo $toDate; ?>">
    <a href="javascript:" class="myBtn btn" title="Export to Excel" onclick="tableToExcel('example', 'W3C Example Table')"><i class="fa fa-file-excel-o bigger-110 green"></i></a>
    <a href="javascript:" class="myBtn btn " title="Export to pdf" onclick="javascript:demoFromHTML()"><i class="fa fa-file-pdf-o bigger-110 " aria-hidden="true"></i></a>
</td>
</tr>
</table>
     <div id="load" style="display:none;"></div>
    <div class="box-body" id="content_report" >
        <table id="example" class="display" width="100%">
               <thead>
        <tr>
          <th>Entry ID</th>
          <th>Name</th>
          <th>View</th>
          <th>Duration(Sec)</th>
          <th>BytesTotal</th>
        </tr>
      </thead> 
            
        </table>
         <span id="content_report_loader"></span>
    </div>    
</div>
        
<script type='text/javascript'>
$(function() {
   $('#example').DataTable();
  // Premade test data, you can also use your own
  var testDataUrl = "http://192.168.24.34/cgi-bin/limeentry.cgi?startdate=<?php echo $fromDate; ?>&enddate=<?php echo $toDate; ?>";
  $("#example").ready(function() {
    loadData();
  });
  function loadData() {
   //$("#content_report_loader").fadeIn(1).html('<img src="img/image_process.gif" height="20" />');
   $('#load').show();
   $('#content_report').css("opacity",0.1);
   $.ajax({
      type: 'GET',
      url: testDataUrl,
      contentType: "text/plain",
      dataType: 'json',
      success: function (data) {
       //$("#content_report_loader").hide(); 
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
    
    for(var i = 1; i < length+1; i++) {
      var customer = data.data[i];
      // You could also use an ajax property on the data table initialization
      $('#example').dataTable().fnAddData( [
        customer.Entry_id,
        customer.Name,
        customer.TotalRequest,
        customer.TotalInSeconds,
        customer.BytesTotal
      ]);
    }
    
  }
})();

          
 function demoFromHTML() {
            var pdf = new jsPDF('p', 'pt', 'letter');
            // source can be HTML-formatted string, or a reference
            // to an actual DOM element from which the text will be scraped.
            source = $('#content_report')[0];

            // we support special element handlers. Register them with jQuery-style 
            // ID selector for either ID or node name. ("#iAmID", "div", "span" etc.)
            // There is no support for any other type of selectors 
            // (class, of compound) at this time.
            specialElementHandlers = {
                // element with id of "bypass" - jQuery style selector
                '#bypassme': function(element, renderer) {
                    // true = "handled elsewhere, bypass text extraction"
                    return true
                }
            };
            margins = {
                top: 80,
                bottom: 60,
                left: 40,
                width: 522
            };
            // all coords and widths are in jsPDF instance's declared units
            // 'inches' in this case
            pdf.fromHTML(
                    source, // HTML string or DOM elem ref.
                    margins.left, // x coord
                    margins.top, {// y coord
                        'width': margins.width, // max width of content on PDF
                        'elementHandlers': specialElementHandlers
                    },
            function(dispose) {
                // dispose: object with X, Y of the last line add to the PDF 
                //          this allow the insertion of new lines after html
                pdf.save('Content Report.pdf');
            }
            , margins);
        }
        
	

 </script>   
    
 
   
<?php } ?>