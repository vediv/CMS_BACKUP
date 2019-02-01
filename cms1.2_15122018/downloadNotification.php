<?php
include_once 'corefunction.php';
?>
 <link rel="stylesheet" href="bootstrap/css/jquery-ui.css">
 <style type="text/javascript">
	.col-md-4{
		min-height: 44px;
	}
</style>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Export Notification Data</h4>
</div>
<div class="modal-body" style="border: 0px solid red; height: 220px; ">
    
    <div class="box">
    <div class="box-body" id="inner-content-div" style="border: 0px solid red;">
    <form name="myForm" action="operation.php?action=notification_download" method="post" onsubmit="return downloadNotification()">     
        <div class="row" style="border:0px solid red;">
        	<div class="col-md-12" style="text-align: center">
  
   
    <label for="from">From</label>
    <input type="text" id="fromDate" readonly name="fromDate" autocomplete="off"    />
    <i class="fa fa-calendar" aria-hidden="true"></i>
    <label for="to">to</label>
    <input type="text" id="toDate" readonly name="toDate" autocomplete="off"  />
    <i class="fa fa-calendar" aria-hidden="true"></i>    &nbsp;&nbsp;
    <br/>
    </div></div>
    <div class="row" style="margin: 10px 0px;">
    <div class="col-md-12" style="text-align: center">
    <button  type="submit" class="btn btn-info" name="format" value=".xls"><i class="fa fa-file-excel-o" aria-hidden="true" style="padding: 0px 7px 0 0; color: rgb(8, 79, 186); font-we"></i>Download Excel</button>
    <button  type="submit" class="btn btn-info" name="format" value=".csv"><i class="fa  fa-file-text-o" aria-hidden="true" style="padding: 0px 7px 0 0; color: rgb(123, 126, 0);"></i>Download CSV</button>
         </form>
    <button  type="button" id="mypdf" class="btn btn-info" value=".pdf"  onclick="return downloadpdf()">
    <i class="fa fa fa-file-pdf-o" aria-hidden="true" style="padding: 0px 7px 0 0; color: rgb(221, 0, 0);"></i>Download PDF</button>  
    </div>
        </div> 
      </div>
        
    </div>
           

</div> 


<script type="text/javascript">
  $(function() {
    //$("#fromDate").datepicker(); 
    $( "#fromDate" ).datepicker({  maxDate: new Date() });
    $("#toDate").datepicker();
  });
</script>           
<script type="text/javascript">
function downloadNotification()
{
        
        var fromDate=document.forms["myForm"]["fromDate"].value;
        //var fromDate = document.getElementById("fromDate").value;
        var toDate=document.forms["myForm"]["toDate"].value;
        //var toDate = document.getElementById("toDate").value;
        //var format=document.forms["myForm"]["format"].value;
        if(fromDate=='')
        {
            alert("Date field should not be blank.");
            return false;
        }
        if(toDate=='')
        {
            alert("Date field should not be blank.");
            return false;
        }
       
      
} 

function downloadpdf()
{
        //var fromDate=document.forms["myForm"]["fromDate"].value;
        var fromDate = document.getElementById("fromDate").value;
        //var toDate=document.forms["myForm"]["toDate"].value;
        var toDate = document.getElementById("toDate").value;
        //var format=document.forms["myForm"]["format"].value;
        if(fromDate=='')
        {
            alert("Date field should not be blank.");
            return false;
        }
        if(toDate=='')
        {
            alert("Date field should not be blank.");
            return false;
        }   
        var mypdf = document.getElementById("mypdf").value;
        if(mypdf==".pdf")
        {
          window.open("operation.php?action=pdf&fromDate="+fromDate+"&toDate="+toDate,'_blank');    
         //window.location.href="operation.php?action=pdf&fromDate="+fromDate+
         return true;
        }
}
</script>