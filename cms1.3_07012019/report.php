<?php 
include_once 'corefunction.php';
$code=isset($_GET['code'])?$_GET['code']:'';
?>
<!DOCTYPE html>
<html>
  <head>
<meta charset="UTF-8">
<title><?php echo PROJECT_TITLE." | Report";?></title>
<style type="text/css">
    .dataTables_wrapper .dt-buttons {
  float:none;  
  text-align:center;
}
.box-header {  padding: 4px 10px 0px 10px !important;  }
.navbar-form .input-group > .form-control {    height: 26px !important; }
h5 {margin-top: 0px  !important;}
.input-group-btn:last-child > .btn, .input-group-btn:last-child > .btn-group {height: 26px;margin-left: -1px;padding: 4px;}
</style>
<link href="bootstrap/css/pagingCss.css" rel="stylesheet" type="text/css" />
<script src="plugins/jQuery/jquery-3.3.1.js" type="text/javascript"></script>
<link rel="stylesheet" href="bootstrap/css/jquery-ui.css">
<link rel="stylesheet" href="plugins/datatables/jquery.dataTables.min.css">

</head>
  <body class="skin-blue">
    <div class="wrapper">
<?php include_once 'header.php';?>
<?php include_once 'lsidebar.php';?>
       
<div class="content-wrapper">
<section class="content-header">
   <h1>Report</h1>
    <ol class="breadcrumb">
      <li><a href="dashboard.php"><i class="fa fa-home" title="Home"></i> Home</a></li>
      <li class="active">Report</li>
    </ol>
</section>
<section class="content">

          <!-- Default box -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title"> </h3>
              <form class="form-horizontal">
                  <div class="">
                      <div class="col-sm-6" style="border:0px solid red;">
                           <div class="form-group">
                            <label class="col-sm-4 control-label" >Choose the report type</label>
                            <div class="col-sm-6">
                                <select name="report_type" id="report_type" class="form-control" onchange="ChooseReport(this.value);">
                                <option value="">Choose the report type</option>  
                                <?php if(in_array(27,$otherPermission)) { ?>  
                                <option value="15dayactive" <?php echo $code=='15dayactive'?'selected':'' ?>>15 Days Active User</option>
                                <option value="15dayinactive" <?php echo $code=='15dayinactive'?'selected':'' ?>>15 Days Inactive User</option>
                                <?php } ?>
                                <?php if(in_array(38,$otherPermission)) { ?>  
                                <option value="subscription_detail" <?php echo $code=='subscription_detail'?'selected':'' ?>>Subscription Report</option>
                                <option value="revenue" <?php echo $code=='revenue'?'selected':'' ?>>Revenue Report</option>
                                <option value="content" <?php echo $code=='content'?'selected':'' ?>>Content Report</option>
                                <option value="contentpartner" <?php echo $code=='contentpartner'?'selected':'' ?>>Content Partner Report</option>

                                <?php } ?>
                              </select>
                            </div>
                          </div>
                      </div>
                      <div class="pull-right"><!--Download--></div>
                  </div>         
              </form>  
             </div>
            <?php
            $page=isset($_GET['page'])?$_GET['page']:'0';
            $pagelimit=isset($_GET['pagelimit'])?$_GET['pagelimit']:10;
            ?>  
            <div class="box-body">
             <?php  
             switch($code)
             {
                case "15dayactive":
                $filter_user=isset($_GET['filter_user'])?$_GET['filter_user']:'';
                ?>
                <div class="panel panel-default">
                <div class="panel-heading">
                  <h3 class="panel-title"><i class="fa fa-filter"></i> Filter</h3>
                </div>
                <div class="panel-body">
                 <div class="form-inline">   
                  <div class="form-group">
                    <!--<label class="control-label" for="input-customer">Customer</label>-->
                    <input name="filter_customer" value="<?php echo $filter_user; ?>" size="100" placeholder="Search By userid,name,email,last view date" id="input_customer" class="form-control" autocomplete="off" type="text">
                  </div>

                  <div class="form-group text-right">
                    <button type="button" id="button-filter" class="btn btn-default"><i class="fa fa-search"></i> Search</button>
                  </div>
                </div>
                </div>
              </div>
              <?php 
               break;
                case "15dayinactive":
                $filter_user=isset($_GET['filter_user'])?$_GET['filter_user']:'';
               ?>
                <div class="panel panel-default">
                <div class="panel-heading">
                  <h3 class="panel-title"><i class="fa fa-filter"></i> Filter</h3>
                </div>
                <div class="panel-body">
                 <div class="form-inline">   
                  <div class="form-group">
                    <!--<label class="control-label" for="input-customer">Customer</label>-->
                    <input name="filter_customer" value="<?php echo $filter_user; ?>" size="100" placeholder="Search By userid,name,email,last view date" id="input_customer" class="form-control" autocomplete="off" type="text">
                  </div>

                  <div class="form-group text-right">
                    <button type="button" id="button-filter" class="btn btn-default"><i class="fa fa-search"></i> Search</button>
                  </div>
                </div>
                </div>
              </div>
                <?php 
                break;    
              } 
             ?>
            </div><!-- /.box-body -->
            <div class="box-footer">
             <?php
              switch($code)
              {
                case "15dayactive":
                include_once 'reports/usersReport.php'; 
                break;
                case "15dayinactive":
                include_once 'reports/usersReport.php'; 
                break;
                case "subscription_detail":
                include_once 'reports/subscriptionReport.php'; 
                break;
                case "revenue":
                include_once 'reports/revenueReport.php'; 
                break;
                case "content":
                include_once 'reports/contentReport.php'; 
                break;
                case "contentpartner":
                include_once 'reports/contentpartnerReport.php'; 
                break;
              }
             ?>
            </div><!-- /.box-footer-->
          </div><!-- /.box -->

        </section>
    
    
</div>
<?php include_once "footer.php"; include_once 'commonJS.php'; ?>
</div>
    
 <div id="LegalModal_EntryDetail" tabindex="-1" aria-labelledby="myModalLabel" role="dialog"  aria-hidden="true" class="modal fade bs-example-modal-lg" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg">
      <div class="modal-content" id="EntryDetail_modal"></div>
    </div>
  </div> 
 
 <div id="LegalModal_PartnerDetail" tabindex="-1" aria-labelledby="myModalLabel" role="dialog"  aria-hidden="true" class="modal fade bs-example-modal-lg" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg">
      <div class="modal-content" id="EntryPartner_modal"></div>
    </div>
  </div> 
 
 <div id="LegalModal_ContentVideoDetail" tabindex="-1" aria-labelledby="myModalLabel" role="dialog"  aria-hidden="true" class="modal fade bs-example-modal-lg" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg">
      <div class="modal-content" id="ContentVideoDetail_modal"></div>
    </div>
  </div> 
      
<script type="text/javascript" src="plugins/datatables/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="plugins/datatables/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="plugins/datatables/buttons.flash.min.js"></script>
<script type="text/javascript" src="plugins/datatables/jszip.min.js"></script>
<script type="text/javascript" src="plugins/datatables/pdfmake.min.js"></script>
<script type="text/javascript" src="plugins/datatables/vfs_fonts.js"></script>
<script type="text/javascript" src="plugins/datatables/buttons.html5.min.js"></script>
<script type="text/javascript" src="plugins/datatables/buttons.print.min.js"></script>      
<script src="bootstrap/js/jquery-ui.js"></script>
<script type="text/javascript">
$(function() {
$("#fromDate" ).datepicker({ dateFormat: 'yy-mm-dd'});
      $('.fa-calendar').click(function() {
    $("#fromDate").focus();
     });
    $("#toDate" ).datepicker({ dateFormat: 'yy-mm-dd'});
      $('#to').click(function() {
    $("#toDate").focus();
     });
});

function ChooseReport(actValue)
{
    if(actValue==''){ alert("Choose the report type."); return false; }
    location="report.php?code="+actValue;
}
function selpagelimit(pageUrl)
{
    var pagelmt=$("#pagelmt").val();
        //location="report.php?code="+actValue;
    location=pageUrl+"&pagelimit="+pagelmt;  
}
var code="<?php echo $code; ?>";
var pagelimit="<?php echo $pagelimit; ?>";
$('#button-filter').on('click', function() {
	var url = '';
	var filter_customer = $('input[name=\'filter_customer\']').val();
	if (filter_customer) {
		url += '&filter_user=' + encodeURIComponent(filter_customer);
	}
	/*var filter_date_start = $('input[name=\'filter_date_start\']').val();
	
	if (filter_date_start) {
		url += '&filter_date_start=' + encodeURIComponent(filter_date_start);
	}
	
	var filter_date_end = $('input[name=\'filter_date_end\']').val();
	
	if (filter_date_end) {
		url += '&filter_date_end=' + encodeURIComponent(filter_date_end);
	}
	
	var filter_order_status_id = $('select[name=\'filter_order_status_id\']').val();
	
	if (filter_order_status_id != 0) {
		url += '&filter_order_status_id=' + encodeURIComponent(filter_order_status_id);
	} */
	
	location = 'report.php?code='+code+url;
});

$('#button-filter-subscription').on('click', function() {
        var url = '';
	var fromDate = $('input[name=\'fromDate\']').val();
        if (fromDate) {
		url += '&fromDate='+(fromDate);
	}
        var toDate = $('input[name=\'toDate\']').val();
	if (toDate) {
            if(fromDate==''){ alert("Select From Date First."); return false; }
            url += '&toDate=' +(toDate);
	}
        
	var date_type = $('select[name=\'date_type\']').val();
        //if(date_type==''){ alert("select date type."); return false; }
        if(fromDate!=''){ 
        if(date_type==''){ alert("select date type."); return false; } }
	if (date_type) {
            url += '&dateType=' + encodeURIComponent(date_type);
	}
        var transStatus = $('select[name=\'trans_status\']').val();
        if (transStatus) {
		url += '&transStatus=' + encodeURIComponent(transStatus);
	}
        var subscType = $('select[name=\'subscType\']').val();
        if (subscType) {
		url += '&subscType=' + encodeURIComponent(subscType);
	}
	location = 'report.php?code='+code+"&pagelimit="+pagelimit+url;
        //location = 'report.php?'+queryString+url;
});
$('#button-filter-getplan').on('click', function() { 
        var url = '';
	var plan = $('select[name=\'planid\']').val();
        if(plan==''){ alert("select plan."); return false; }
	if (plan){
	    url += '&planid=' + encodeURIComponent(plan);
	}
       location = 'report.php?code='+code+"&pagelimit="+pagelimit+url;
       //location = 'report.php?'+queryString+url;
});
$('#searchSub').on('click', function() { 
        var url = '';
	var searchInput = $('input[name=\'searchInput\']').val();
    //if(searchInput==''){ alert("Please Enter the value");  $("#searchInput").focus(); return false;}
        searchInput = searchInput.trim();
        var strlen=searchInput.length;
        if(strlen==0){  $('#searchInput').val(''); $('#searchInput').focus(); return false;   }
        if (searchInput) {
		url += '&searchInput='+(searchInput);
	}
        location = 'report.php?code='+code+"&pagelimit="+pagelimit+url;
       //location = 'report.php?'+queryString+url;
});

$('#button-filter-Revenue').on('click', function() {
        var url = '';
	var fromDate = $('input[name=\'fromDate\']').val();
        if (fromDate) {
		url += '&fromDate='+(fromDate);
	}
        var toDate = $('input[name=\'toDate\']').val();
	if (toDate) {
            if(fromDate==''){ alert("Select From Date First."); return false; }
            url += '&toDate=' +(toDate);
	}
        
	var date_type = $('select[name=\'date_type\']').val();
        //if(date_type==''){ alert("select date type."); return false; }
        if(fromDate!=''){ 
        if(date_type==''){ alert("select date type."); return false; } }
	if (date_type) {
            url += '&dateType=' + encodeURIComponent(date_type);
	}
        var transStatus = $('select[name=\'trans_status\']').val();
        if (transStatus) {
		url += '&transStatus=' + encodeURIComponent(transStatus);
	}
        var subscType = $('select[name=\'subscType\']').val();
        if (subscType) {
		url += '&subscType=' + encodeURIComponent(subscType);
	}
	location = 'report.php?code='+code+"&pagelimit="+pagelimit+url;
        //location = 'report.php?'+queryString+url;
});

$('#button-filter-Content').on('click', function() {
        var url = '';
	var fromDate = $('input[name=\'fromDate\']').val();
        if(fromDate==''){ alert("Select From Date ."); return false; }
        if (fromDate) {
		url += '&fromDate='+(fromDate);
	}
        var toDate = $('input[name=\'toDate\']').val();
         if(fromDate==''){ alert("Select To Date ."); return false; }
	if (toDate) {
           
            url += '&toDate=' +(toDate);
	}
        
	
	location = 'report.php?code='+code+"&pagelimit="+pagelimit+url;
        //location = 'report.php?'+queryString+url;
});


$('#button-filter-planidR').on('click', function() { 
        var url = '';
	
	var plan = $('select[name=\'planid\']').val();
        if(plan==''){ alert("select plan."); return false; }
	if (plan) {
		url += '&planid=' + encodeURIComponent(plan);
	}
       location = 'report.php?code='+code+"&pagelimit="+pagelimit+url;
       //location = 'report.php?'+queryString+url;
});
$('#searchRevenue').on('click', function() { 
        var url = '';
	var searchInput = $('input[name=\'searchInput\']').val();
	//if(searchInput==''){ alert("Please Enter the value");  $("#searchInput").focus(); return false;}
        searchInput = searchInput.trim();
        var strlen=searchInput.length;
        if(strlen==0){  $('#searchInput').val(''); $('#searchInput').focus(); return false;   }
        if (searchInput) {
		url += '&searchInput='+(searchInput);
	}
        location = 'report.php?code='+code+"&pagelimit="+pagelimit+url;
       //location = 'report.php?'+queryString+url;
});
  
$("#searchInput").keyup(function(event) {
    if (event.keyCode === 13) {
        $("#searchSub").click();
    }
});
function exportData(exportType,pagename)
{
    if(exportType=='.xls')
    {
        var fromDate = $('input[name=\'fromDate\']').val();
        var toDate = $('input[name=\'toDate\']').val();
        var dateType = $('input[name=\'dateType\']').val();
        var transStatus = $('input[name=\'transStatus\']').val();
        var planid = $('input[name=\'planid\']').val();
        var searchInput = $('input[name=\'searchInput\']').val();
        var subscType = $('input[name=\'subsc_type\']').val();
        var queryString='&subscType='+subscType+'&fromDate='+fromDate+'&toDate='+toDate+'&dateType='+dateType+'&transStatus='+transStatus+'&planid='+planid+'&searchInput='+searchInput;
        location="exportData.php?action="+pagename+'&exportType='+exportType+queryString;
    }
    if(exportType=='.pdf')
    {
        var fromDate = $('input[name=\'fromDate\']').val();
        var toDate = $('input[name=\'toDate\']').val();
        var dateType = $('input[name=\'dateType\']').val();
        var transStatus = $('input[name=\'transStatus\']').val();
        var planid = $('input[name=\'planid\']').val();
        var searchInput = $('input[name=\'searchInput\']').val();
        var subscType = $('input[name=\'subsc_type\']').val();
        var queryString='&subscType='+subscType+'&fromDate='+fromDate+'&toDate='+toDate+'&dateType='+dateType+'&transStatus='+transStatus+'&planid='+planid+'&searchInput='+searchInput;
        //location="exportData.php?action="+pagename+'&exportType='+exportType+queryString;
        window.open("exportData?action="+pagename+'&exportType='+exportType+queryString,'_blank');    
    }
    
    
    
    
}
</script>
 <script src="js/commonFunctionJS.js" type="text/javascript"></script>

<script type="text/javascript">
 function viewEntryDetail(entryid)    
{
      $("#LegalModal_EntryDetail").modal();
       var info = 'action=viewEntryDetail&entryid='+entryid; 
        $.ajax({
	    type: "POST",
	    url: "entryListModal.php",
	    data: info,
             success: function(result){
             $('#EntryDetail_modal').html(result);
            return false;
         }
 
        });
     return false;  
}
function viewPartnerDetail(pid)    
{
      $("#LegalModal_PartnerDetail").modal();
       var info = 'action=viewPartnerDetail&pid='+pid; 
        $.ajax({
	    type: "POST",
	    url: "entryListModal.php",
	    data: info,
             success: function(result){
             $('#EntryPartner_modal').html(result);
            return false;
         }
 
        });
     return false;  
}
function viewcontentvideoDetail(cvid)    
{
      $("#LegalModal_ContentVideoDetail").modal();
       var info = 'action=viewcontentvideo&cvid='+cvid; 
        $.ajax({
	    type: "POST",
	    url: "entryListModal.php",
	    data: info,
             success: function(result){
             $('#ContentVideoDetail_modal').html(result);
            return false;
         }
 
        });
     return false;  
}
  </script>   
</body>
</html>
     