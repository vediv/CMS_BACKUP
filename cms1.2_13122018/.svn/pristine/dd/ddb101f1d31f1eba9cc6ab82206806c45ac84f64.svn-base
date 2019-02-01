<?php 
include_once 'corefunction.php';
?>
<!DOCTYPE html>
<html>
  <head>
<meta charset="UTF-8">
<title><?php echo PROJECT_TITLE." | PlanDetail";?></title>
<link href="bootstrap/css/pagingCss.css" rel="stylesheet" type="text/css" />
<style type="text/css">
	.box-header {      padding: 4px 10px 0px 10px !important;  }
	.navbar-form .input-group > .form-control {    height: 26px !important; }
	h5 {margin-top: 0px  !important;}
 
.input-group-btn:last-child > .btn, .input-group-btn:last-child > .btn-group {
    height: 26px;
    margin-left: -1px;
    padding: 4px;
}
 
</style>
  </head>
  <body class="skin-blue">
    <div class="wrapper">
   <?php include_once 'header.php';?>
           <!-- Left side column. contains the logo and sidebar -->
      <?php include_once 'lsidebar.php';?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
         <section class="content-header">
         <h1>Plan Detail
         <?php  if(in_array("1", $UserRight)){ ?>      
         <a href="javascript:" data-target=".bs-example-modal-lg"  title="Add New Plan" onclick="createPlan('add_new_plan');"><small><span class="glyphicon glyphicon-plus" style="color:#3290D4"></span></small></a>
         Country Currency
         <a href="javascript:"   title="View Currency For Country" onclick="createPlan('create_currency');"><small><span class="glyphicon glyphicon-eye-open" style="color:#3290D4"></span></small></a>
         
         <?php } ?>
          </h1>
          <ol class="breadcrumb">
            <li><a href="dashboard.php"><i class="fa fa-home" title="Home"></i> Home</a></li>
            <li class="active">Plan Detail   </li>
          </ol>
        </section>

        <!-- Main content -->
  <section class="content">
         <div class="row">
          <div class="col-xs-12">
             <div class="box"> 
                 <div class="box-header"></div> 
                 <div id="flash1"></div>    
                 <div id="results" style="min-height: 500px;"></div> 
             </div>
          </div>
          </div>
  </section>
</div>
    <?php include_once "footer.php"; include_once 'commonJS.php'; ?>
    </div>
 <div class="modal fade" id="myModal_add_new_plan" role="dialog" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
        <div class="modal-content" id="view_modal_new_plan"></div>
    </div>
  </div>
<div id="LegalModal_modal_edit" tabindex="-1" aria-labelledby="myModalLabel" role="dialog"  aria-hidden="true" class="modal fade bs-example-modal-lg" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
      <div class="modal-content" id="edit_modal_plan"></div>
    </div>
  </div>     

<script type="text/javascript">
$(document).ready(function() {
var pageNum = 0; //total loaded record group(s)
var loading  = false; //to prevents multipal ajax loads
//$("#results").html('');
$("#flash1").show();
$("#flash1").fadeIn(500).html('Loading <img src="img/image_process.gif" />');
$('#results').load("planDetail_paging.php",{'pageNum':pageNum},
function() {
                   $("#flash1").hide();
                   pageNum++;

              }); //load first group
   });
   
function save_new_plan()
{
    $(".has-error").html('');
    var planName = $('#plan_name').val();
    var plan_duration = $('#plan_duration').val();
    //var plan_amount = $('#plan_amount').val();
    var plan_desc = $('#plan_desc').val();
    var plantype = $('#plantype').val();
    var plan_used_for = $('#plan_used_for').val();
    var pattern=/^[0-9A-Za-z-_#|\s]+$/;
    var onlyNumber=/^[0-9]+$/;
    if(planName=='')   
    { var mess="Plan Name should not be Blank"; $("#plan_name-error").html(mess); return false;}  
    else if(!planName.match(pattern))
    {  var mess="(Please enter alphanumeric value with #,_-)  Eg:test123,test-123,#test_23";$("#plan_name-error").html(mess);return false;} 
    var currency = document.getElementsByName('currency[]');
    var validateCurrency=true;
    for (var x = 0; x < currency.length; x++) {     
    var currency_id = currency[x].id;
    if(currency[x].value == '')
         {	    		    	
            $("#"+currency_id+"-error").html('select currency.');
            validateCurrency = false;
         }
     }
   
/*'10.5' returns true  
'115.25' returns true 
'1535.803' returns false  
'7' returns true  
'.74' returns false  
'153.14.5' returns false  
'415351108140' returns true  
'415351108140.5' returns true  
'415351108140.55' returns true  
'415351108140.556' returns false
*/
     var regexp = /^\d+(\.\d{1,2})?$/;
     var price = document.getElementsByName('price[]');
      var validatePrice=true;
        for (var x = 0; x < price.length; x++) {       
            var price_Id = price[x].id;
             if(price[x].value == ''){	
                $("#"+price_Id+"-error").html('price is required!');
                validatePrice = false
               }
              else if(!regexp.test(price[x].value))
              { 
                var mess="(Please enter numeric or Decimal value)  Eg:200,2.1.20.1 "; 
                $("#"+price_Id+"-error").html(mess);
                validatePrice = false;
              }  
        }  
     
    if(validateCurrency == false ||  validatePrice == false) { return false; } 
    if(plan_duration=='')   
    { var mess="Plan Duration should not be Blank"; $("#plan_duration-error").html(mess); return false;} 
    else if(!plan_duration.match(onlyNumber))
    { var mess="Please enter only Numeric Value"; $("#plan_duration-error").html(mess);return false;} 
    if(plantype=='')   
    { var mess="Select Plan Type "; $("#plantype-error").html(mess); return false;} 
   
    $('#save_plan').attr('disabled',true);
    $("#saving_loader").show();
    $("#saving_loader").fadeIn(500).html('Saving..... <img src="img/image_process.gif" />');
    $.ajax({
      method : 'POST',
      url : 'planDetail_paging.php',
      data : $('#addNewPlan').serialize()+"&action=save_new_plan",
      success: function(re){
                if(re==2){	
                $('#myModal_add_new_plan').modal('show');
                $("#saving_loader").hide();
                $('#error_msg-error').css("color", "red").html('Plan not created ,somethig wrong. please try again.');
                $('#save_plan').attr('disabled',false);
                return false;
                }
                if(re==1){	
                $('#myModal_add_new_plan').modal('show');
                $("#saving_loader").hide();
                $('#error_msg-error').css("color", "red").html('You are already created plan for subcription.please inactive or delete.');
                $('#save_plan').attr('disabled',false);
                return false;
                }
                $("#saving_loader").hide();
                $('#myModal_add_new_plan').modal('hide');
                window.location="planDetail.php"; 
        }
      });  
    
}

function save_editPlan(planid,pageindex,limitval)
{
    $(".has-error").html('');
    var planName = $('#plan_name').val();
    var plan_duration = $('#plan_duration').val();
    var plan_desc = $('#plan_desc').val();
    var plantype = $('#plantype').val();
    var plan_used_for = $('#plan_used_for').val();
    var pattern=/^[0-9A-Za-z-_#|\s]+$/;
    var onlyNumber=/^[0-9]+$/;
    if(planName=='')   
    { var mess="Plan Name should not be Blank"; $("#plan_name-error").html(mess); return false;}  
    else if(!planName.match(pattern))
    {  var mess="(Please enter alphanumeric value with #,_-)  Eg:test123,test-123,#test_23";$("#plan_name-error").html(mess);return false;} 
   
    var currency = document.getElementsByName('currency[]');
    var validateCurrency=true;
    for (var x = 0; x < currency.length; x++) {     
    var currency_id = currency[x].id;
    if(currency[x].value == '')
         {	    		    	
            $("#"+currency_id+"-error").html('select currency.');
            validateCurrency = false;
         }
     }
     var regexp = /^\d+(\.\d{1,2})?$/;
     var price = document.getElementsByName('price[]');
      var validatePrice=true;
        for (var x = 0; x < price.length; x++) {       
            var price_Id = price[x].id;
             if(price[x].value == ''){	
                $("#"+price_Id+"-error").html('price is required!');
                validatePrice = false
               }
              else if(!regexp.test(price[x].value))
              { 
                var mess="(Please enter numeric or Decimal value)  Eg:200,2.1.20.1 "; 
                $("#"+price_Id+"-error").html(mess);
                validatePrice = false;
              }  
        }  
    if(validateCurrency == false ||  validatePrice == false) { return false; } 
    if(plan_duration=='')   
    { var mess="Plan Duration should not be Blank"; $("#plan_duration-error").html(mess); return false;} 
    else if(!plan_duration.match(onlyNumber))
    { var mess="Please enter only Numeric Value"; $("#plan_duration-error").html(mess);return false;} 
    if(plantype=='')   
    { var mess="Select Plan Type "; $("#plantype-error").html(mess); return false;} 
  
    $('#save_plan').attr('disabled',true);
    $("#saving_loader").show();
    $("#saving_loader").fadeIn(500).html('Saving..... <img src="img/image_process.gif" />');
     $.ajax({
      method : 'POST',
      url : 'planDetail_paging.php',
      data : $('#editPlan').serialize()+"&action=save_edit_plan&planid="+planid+"&pageNum="+pageindex+"&limitval="+limitval,
      success: function(re){
                if(re==2){	
                $('#LegalModal_modal_edit').modal('show');
                $("#saving_loader").hide();
                $('#error_msg-error').css("color", "red").html('Plan Not updated ,somethig wrong. please try again.');
                $('#save_plan').attr('disabled',false);
                return false;
                }
                $("#flash").hide();
                $('#LegalModal_modal_edit').modal('hide');
                $("#results").html(re);
                $("#msg").html("Plan Update successfull..");
        }
      });  
}
function save_NewPrice(planid,pageindex,limitval) 
{
    $(".has-error").html('');
     var currency = document.getElementsByName('currency[]');
    var validateCurrency=true;
    for (var x = 0; x < currency.length; x++) {     
    var currency_id = currency[x].id;
    if(currency[x].value == '')
         {	    		    	
            $("#"+currency_id+"-error").html('select currency.');
            validateCurrency = false;
         }
     }
     var regexp = /^\d+(\.\d{1,2})?$/;
     var price = document.getElementsByName('price[]');
      var validatePrice=true;
        for (var x = 0; x < price.length; x++) {       
            var price_Id = price[x].id;
             if(price[x].value == ''){	
                $("#"+price_Id+"-error").html('price is required!');
                validatePrice = false
               }
              else if(!regexp.test(price[x].value))
              { 
                var mess="(Please enter numeric or Decimal value)  Eg:200,2.1.20.1 "; 
                $("#"+price_Id+"-error").html(mess);
                validatePrice = false;
              }  
        } 
     var regexp = /^\d+(\.\d{1,2})?$/;
     var newPrice = document.getElementsByName('newprice[]');
      var validateNewPrice=true;
        for (var x = 0; x < newPrice.length; x++) {       
            var price_Id = newPrice[x].id;
             if(newPrice[x].value == ''){	
                $("#"+price_Id+"-error").html('new price is required!');
                validateNewPrice = false
               }
              else if(!regexp.test(newPrice[x].value))
              { 
                var mess="(Please enter numeric or Decimal value)  Eg:200,2.1.20.1 "; 
                $("#"+price_Id+"-error").html(mess);
                validateNewPrice = false;
              }  
        }    
      if(validateCurrency == false ||  validatePrice == false ||  validateNewPrice == false) { return false; } 
      $('#save_new_price').attr('disabled',true);
      $("#saving_loader").show();
      $("#saving_loader").fadeIn(500).html('Saving..... <img src="img/image_process.gif" />');
      $.ajax({
      method : 'POST',
      url : 'planDetail_paging.php',
      data : $('#saveNewPrice').serialize()+"&action=update_new_price&planid="+planid+"&pageNum="+pageindex+"&limitval="+limitval,
      success: function(re){
                if(re==2){	
                $('#LegalModal_modal_edit').modal('show');
                $("#saving_loader").hide();
                $('#error_msg-error').css("color", "red").html('New Price Not updated ,somethig wrong. please try again.');
                $('#save_new_price').attr('disabled',false);
                return false;
                }
                $("#flash").hide();
                $('#LegalModal_modal_edit').modal('hide');
                $("#results").html(re);
                $("#msg").html("New Price Update successfully..");
        }
      });  
      
    
}
</script>      
<script type="text/javascript">
function plan_act_deact(planid){
    var adstatus=document.getElementById('ad_status'+planid).value;
    var msg = (adstatus == 1) ? "inactive":"active";
    var c=confirm("Are you sure you want to "+msg+ " This Plan?");
    if(c)
    {
        $.ajax({
        type: "POST",
        url: "core_active_deactive.php",
        data: 'planid='+planid+'&adstatus='+adstatus+'&action=plan',
        success: function(re){
                if(re==0)
                { 
                  var img_status=document.getElementById('getstatus'+planid).innerHTML="<span class='label label-danger'>inactive</span>";
                  $('#icon_status'+planid).removeClass('fa-check-square-o').addClass('fa-ban');
                }
                if(re==1)
                {
                     var img_status=document.getElementById('getstatus'+planid).innerHTML="<span class='label label-success'>active</span>";
                     $('#icon_status'+planid).removeClass('fa-ban').addClass('fa-check-square-o');
                }
                $('#ad_status'+planid).val(re);
          
               
               
          }
        }); 
      }
}
function pdelete(pid){
var st=document.getElementById('ad_status'+pid).value;
if(st==1) { alert('This Plan is active so you can not delete'); return false;} 
var d=confirm("Are you sure you want to Delete This Plan?");
if(d)
{
       var info = 'pid='+pid+'&action=plan_delete';
       $.ajax({
       type: "POST",
       url: "coredelete.php",
       data: info,
       success: function(r){
         if(r==1)
         {
             var adstatus=document.getElementById('getstatus'+pid).innerHTML="delete";
             document.getElementById('getstatus'+pid).style.color = 'red';
             $("#pdel" + pid).remove();
         }   

         }
    });  
}    

}


</script>
</body>
</html>
