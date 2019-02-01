<?php
include_once 'corefunction.php';
$action=(isset($_REQUEST['action']))? $_REQUEST['action']: "";
switch($action)
{
	case "add_new_offer":
        $currentDate=date('Y-m-d HH:ii:ss');
        $after_one_month=date('Y-m-d HH:ii:ss', strtotime('+1 months'));
        $currentDateonly=date('Y-m-d');
        $pin = '';
        $a = "0123QWERTYUIOPASDFGH456789JKLZXCVBNM";
        $b = str_split($a);
        for ($i=1; $i <= 10 ; $i++) { 
        $pin .= $b[rand(0,strlen($a)-1)];
        }
        $offerCode=$pin;
        ?> 
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"> Add Offer</h4>
        </div>
        <div class="modal-body">
        <form class="form-inline" role="form" action="javascript:" enctype="multipart/form-data" method="post" id="formuploadofferimage" style="border: 0px solid red;">
         <div class="col-md-12" >
           <div id="error"></div>     
             <div class="pull-left">
                  <label for="imageUpload" class="btn btn-primary btn-block">Select Image</label>
                  <input type="file" id="imageUpload" name="imageUpload" name accept="image/*" style="display: none">
            </div> 
           <div class="pull-right" style="border:0px solid red; width:30%;">
                <div class="col-sm-7" id="preview_img">Image Preview</div>
           </div>
         </div>
        </form>
      <hr/>       
<form class="form-inline" role="form" action="javascript:"  method="post" onsubmit="return save_offer('save_add_offer')" id="formAddoffer" style="border: 0px solid red;">
<div class="col-md-12" >
     
  <div class="">
    <div class="box-body">
        <table   style="border-collapse: separate; border-spacing: 0 1em;" width='100%' >
        <tr>
          <td>Offer Name *</td>
          <td>
          <input name="img_urls" id="img_urls"  type="hidden" class="inputFile" />    
          <input type="text" class="form-control" maxlength="30"  name="offer_name" id="offer_name" placeholder="Offer Name">
          <span class="help-block has-error" id="offer_name-error" style="color:red;"></span>
          </td>
          <td>
          <level data-toggle="tooltip" title="The code the customer enters to get the discount."> 
          <i class="fa fa-question-circle" style="color: blue;"></i> Code</level> *</td>
          <td>  
            <input type="text" class="form-control" maxlength="10"  name="offer_code" onkeyup="changeToUpperCase(this)" id="offer_code" placeholder="Code"  value="<?php echo $offerCode; ?>">
            <span class="help-block has-error" id="offer_code-error" style="color:red;"></span>
          </td>
        </tr>
        <tr>
          <td>
          <level data-toggle="tooltip" title="Percentage or Fixed Amount."> 
          <i class="fa fa-question-circle" style="color: blue;"></i> Type</level> 
          </td>
          <td>  
             <select name="input-type" id="input-type"  class="form-control" style="width:200px;">
             <option value="P">Percentage</option> 
             <option value="F">Fixed Amount</option>
          </select>
          </td>
          <!--<td>Discount *</td>
          <td>  
            <input type="text" class="form-control" maxlength="30"  name="offer_discount" id="offer_discount" placeholder="Discount">
           <span class="help-block has-error" id="offer_discount-error" style="color:red;"></span>
          </td>-->
           <td valign="top">Message</td> 
       <td valign="top">
           <textarea name="msg" id="msg" cols="20" rows="2" maxlength="180" style="resize: none; width:85%;"></textarea>
       </td>
        </tr>
        <tr>
       <td valign="top">Discount *</td> 
       <td colspan="2">
        <div  style="border:0px solid red;" >   
        <?php $sql="Select name,currency,country_code from countries_currency where status='1' order by  name ";
    $TotalCurrencyCountry = db_totalRow($conn,$sql);
    $data = db_select($conn,$sql);
    ?>
        <table class="table" id="currencyTable" style="width:87%;">
        <tr><th>Currency</th><th>Price</th></tr>     
    <tbody>
    <?php
    $arrayNumber = 0;
    $x = 1;
    if($TotalCurrencyCountry>0){  
    foreach ($data as $fdata)
    {   
    ?>
    <tr id="row<?php echo $x; ?>" class="<?php echo $arrayNumber; ?>">			  				
    <td style="margin-left:20px;">
     <input type="hidden" name="currency[]"  id="currency<?php echo $x; ?>" readonly  placeholder="price" class="form-control" value="<?php echo $fdata['country_code']; ?>"   />  
     <input type="text" readonly  placeholder="currency" class="form-control" value="<?php echo $fdata['name']; ?>"   />  
     <span class="help-block has-error" id="currency<?php echo $x; ?>-error" style="color:red;"></span>   
     <td style="padding-left:20px;">
     <input type="text" name="price[]"  id="price<?php echo $x; ?>"  placeholder="price" class="form-control"  />
     <span class="help-block has-error" id="price<?php echo $x; ?>-error" style="color:red;"></span>
     </td>
     <!--<td>
     <button class="btn btn-default removeProductRowBtn" disabled type="button" id="removeProductRowBtn" onclick="removeProductRow(<?php echo $x; ?>)"><i class="glyphicon glyphicon-trash"></i></button>
     </td>-->
     </tr>
        <?php
        $x++;
         }
       } 
        ?>
       </tbody>			  	
       </table>
        </div>  
       </td>
   
        </tr>
        <tr>
          <td>Date Start</td>
          <td> 
         <div class='input-group date' id='datetimepicker1'>
            <input type='text' class="form-control" placeholder="Date Start" size='16' value="<?php echo $currentDate; ?>" id="input-date-start" name="date_start"  />
            <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
            </span>
         </div>    
                     <span class="help-block has-error" id="input-date-start-error" style="color:red;"></span>
     
           </td>
           <td>Date End</td>
        <td>  
        <div class='input-group date' id='datetimepicker2'>
            <input type='text' class="form-control" size='16' value="<?php echo $after_one_month; ?>" placeholder="Date End"  id="input-date-end" name="date_end"  />
        <span class="input-group-addon">
            <span class="glyphicon glyphicon-calendar"></span>
        </span>
        </div>  
            <span class="help-block has-error" id="input-date-end-error" style="color:red;"></span>
        </td>
        </tr>
        <tr>
        <td>
          <level data-toggle="tooltip" title="The maximum number of times the Offer can be used by any user. Leave blank for unlimited"> 
          <i class="fa fa-question-circle" style="color: blue;"></i> Uses Per Offer</level>
        </td>
        <td>
          <input type="text" name="uses_per_offer" id="uses_per_offer" maxlength="30" value="1" placeholder="Uses Per Offer"  class="form-control" />  
        <span class="help-block has-error" id="uses_per_offer-error" style="color:red;"></span>
        </td>
        <td>
          <level data-toggle="tooltip" title="The maximum number of times the Offer can be used by a single User. Leave blank for unlimited"> 
          <i class="fa fa-question-circle" style="color: blue;"></i> Uses Per User</level>
        </td>
        <td>
        <input type="text" name="uses_customer" id="uses_customer" maxlength="30" value="1" placeholder="Uses Per Customer"  class="form-control" />
        <span class="help-block has-error" id="uses_customer-error" style="color:red;"></span>
        
        </td>
        </tr> 

      </table> 
    </div>
  </div>
</div>
          
<div class="modal-footer">
<div class="col-sm-offset-3 col-sm-4" style="right: 6%;">
    <button type="submit" name="save_add_offer" id="save_add_offers" class="btn btn-primary" >Save</button>
   <!-- <span id="saving_loader"> </span>-->  
</div>
<div align="center" id="saving_loader"></div>    
</div>
</form>  
</div> 
<script src = "js/common.js"></script>
<script src="js/add_custom_row.js" type="text/javascript"></script>
<script type="text/javascript" src="scripts/jquery.form.js"></script>
<script type='text/javascript'>

function changeToUpperCase(t) {
  var eleVal = document.getElementById(t.id);
  eleVal.value= eleVal.value.toUpperCase().replace(/ /g,'');
}
$('#datetimepicker1').datetimepicker({
    defaultDate: new Date(),
    //format: 'DD/MM/YYYY hh:mm:ss A',
    format: 'YYYY-MM-DD HH:mm:ss',
    sideBySide: true
});
$('#datetimepicker2').datetimepicker({
    defaultDate: new Date(),
    //format: 'DD/MM/YYYY hh:mm:ss A',
    format: 'YYYY-MM-DD HH:mm:ss',
    sideBySide: true
});


function save_offer(act)
{
    $(".has-error").html('');
    var offer_name = $('#offer_name').val();
    var offer_code = $('#offer_code').val();
    //var offer_discount = $('#offer_discount').val();
    //var pattern_with_no_space=/^[0-9A-Za-z]+/;
    var pattern_with_no_space=/^(?=.*[a-zA-Z])(?=.*[0-9])[a-zA-Z0-9]+$/;
    var pattern_only_numeric=/^[0-9]+/;
    if(offer_name=='')   
    { var mess="offer name should not be blank"; $("#offer_name-error").html(mess); return false;} 
    if(offer_name=='')
    {
        var mess="offer name should not be blank"; $("#offer_name-error").html(mess); return false;
    }
    if(offer_code=='')
    {
        var mess="offer Code should not be blank"; $("#offer_code-error").html(mess); return false;
    }
    else if(offer_code.length>0){
         if ((offer_code.length <5) && (offer_code.length < 11)) 
         { var mess="Code must be between 5 and 10 characters!"; $("#offer_code-error").html(mess);return false;  }
         else if(!offer_code.match(pattern_with_no_space))
         { var mess="Please enter alphanumeric value"; $("#offer_code-error").html(mess);return false;} 
    }
    /*if(offer_discount==''){var mess="Discount should not be blank"; $("#offer_discount-error").html(mess); return false;}
    if(offer_discount.length>0){
     if(!offer_discount.match(pattern_only_numeric))
     { var mess="enter only numeric value"; $("#offer_discount-error").html(mess);return false;} 
    } */
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
var input_date_start = $('#input-date-start').val();
if(input_date_start==''){  { var mess="Start Date should not be Blank"; $("#input-date-start-error").html(mess);return false;}    }
var input_date_end = $('#input-date-end').val();
if(input_date_end==''){  { var mess="End Date should not be Blank"; $("#input-date-end-error").html(mess);return false;}    }

var startdate = input_date_start.split(" ");
var onlyStartDate=startdate[0];
var enddate = input_date_end.split(" ");
var onlyEndDate=enddate[0];

var currentDate="<?php echo $currentDateonly; ?>";
if(onlyStartDate<currentDate)
{
    alert("Date start should be greather than or equal to current date.");
    return false;
}    

if(new Date(onlyStartDate) > new Date(onlyEndDate))
{
    alert("date end should be greather than or equal to date start.");
    return false;
}
var input_uses_total=$('#uses_per_offer').val();
if(input_uses_total.length>0){
             if(!input_uses_total.match(/^[0-9]+$/))
             { var mess="enter only numeric value"; $("#uses_per_offer-error").html(mess);return false;} 
        }
var input_uses_customer=$('#uses_customer').val();
if(input_uses_customer.length>0){
             if(!input_uses_customer.match(/^[0-9]+$/))
             { var mess="enter only numeric value"; $("#uses_customer-error").html(mess);return false;} 
        }        
    $("#saving_loader").fadeIn(400).html('Saving... <img src="img/image_process.gif" />');
    $('#save_add_offers').attr('disabled',true);
    $.ajax({
      method : 'POST',
      url : 'offers_paging.php',
      data : $('#formAddoffer').serialize() +"&action="+act,
      success: function(jsonResult){
            if(jsonResult==1)
            {
                $('#myModal_add_new_offer').modal('show');
                $("#saving_loader").hide(); 
                $('#save_add_offers').attr('disabled',false);
                var msg='<div class="alert alert-danger alert-dismissible fade in">';
                msg+='<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'
                msg+='<strong>Warning :</strong> Offer code is already in use!.'
                msg+='</div>';
                $("#error").html(msg);
                return false;
            }    
            $("#saving_loader").hide(); 
            $('#myModal_add_new_offer').modal('hide');
            $("#results").html(jsonResult);
            $("#msg").html("Success: Offer Add Successfull"); 
        }
      });  
}
    $('input[type=text]').blur(function(){ 
           $(this).val($.trim($(this).val().replace(/\t+/g,' ')));
    });
 


$(document).ready(function() { 
  $('#imageUpload').on('change', function() {
  
  if(['image/jpeg', 'image/jpg', 'image/png', 'image/gif','image/jpeg'].indexOf($("#imageUpload").get(0).files[0].type) == -1) {
        alert('Error : Only JPEG, PNG & GIF,JPEG allowed');
        $("#imageUpload").val('');
        return false;
    }
   var apiBody1 = new FormData($('#formuploadofferimage')[0]);
   apiBody1.append('data',$('input[type=file]')[0].files[0]); 
   apiBody1.append('action','marketing');
    $.ajax({
                url:'includes/image_process.php',
                method: 'POST',
                data:apiBody1,
                processData: false,
                contentType: false,
                success: function(r){
                  if(r==1){
                       ImageProcess(); 
                  }
                  if(r==0){ alert("Error : image Height between  300 to 350 pixels.\n image width between  150 to 170 pixels"); return false; }
                }
           });
  
  });
  
function ImageProcess(){
  $("#preview_img").html('Uploading.... <img src="img/image_process.gif" alt="Uploading...."/>');
  $('#imageUpload').attr('disabled',true);
  $('#save_add_offers').attr('disabled',true);
  var publisher_unique_id="<?php echo $publisher_unique_id ?>";
  var apiURl="<?php  echo $apiURL."/upload" ?>";
  var apiBody = new FormData($('#formuploadofferimage')[0]);
  apiBody.append("partnerid",publisher_unique_id);
  apiBody.append('fileAction','image');
  apiBody.append('tag','marketing');
  apiBody.append('data', $('input[type=file]')[0].files[0]);
  $.ajax({
                url:apiURl,
                method: 'POST',
                dataType: 'json', 
                data:apiBody,
                processData: false,
                contentType: false,
                success: function(jsonResult){
                var HOST_original=jsonResult.image_url[0].HOST
                var URI=jsonResult.image_url[0].URI; 
                var imgShow=HOST_original+URI;
                //$("#host_url").val(HOST_original);
                setTimeout(function() {
                $("#img_urls").val(imgShow);
                $('#imageUpload').attr('disabled',false);
                $('#save_add_offers').attr('disabled',false);   
                 var imgPrev='<img src="'+imgShow+'" class="img-responsive customer-img"  >';
                document.getElementById('preview_img').innerHTML=imgPrev; }, 15000);
                    }
            });	
      }      
  
 }); 
 
</script>  
<?php   
break;
case "editOffer":
$offer_id=$_POST['offer_id']; $pageindex=$_POST['pageindex']; $limitval=$_POST['limitval'];
$query1="select * from offers  where offer_id='$offer_id'";
$fetch= db_select($conn,$query1);
$offer_name=$fetch[0]['offer_name']; $offer_code=$fetch[0]['code']; $offer_type=$fetch[0]['type'];
$offer_discount=$fetch[0]['offer_discount']; $date_start=$fetch[0]['date_start']; $date_end=$fetch[0]['date_end'];  
$uses_customer=$fetch[0]['uses_customer'];$uses_per_offer=$fetch[0]['uses_total']; $img_urls=$fetch[0]['img_url'];
$msg=$fetch[0]['msg'];$currency=$fetch[0]['currency']; 
$img=$img_urls!=''?$img_urls:'img/notavailable.jpg';
$json_customdataCurrency  = json_decode($currency,true);
$sql="Select name,currency,country_code from countries_currency where status='1'";
$TotalCurrencyCountry = db_totalRow($conn,$sql);
$data = db_select($conn,$sql);

?>   
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Offer Detail</h4>
        </div>
        <div class="modal-body">
        <form class="form-inline" role="form" action="javascript:" enctype="multipart/form-data" method="post" id="formuploadofferimage_edit" style="border: 0px solid red;">
         <div class="col-md-12" >
           <div id="error"></div>     
             <div class="pull-left">
                  <label for="imageUpload" class="btn btn-primary btn-block">Select New Image</label>
                  <input type="file" id="imageUpload" name="imageUpload" name accept="image/*" style="display: none">
            </div> 
           <div class="pull-right" style="border:0px solid red; width:20%;">
             <div class="col-sm-7" id="preview_img_edit"><img src="<?php echo $img; ?>" class="img-responsive customer-img"></div>
         </div>
         </div>
        </form>
      <hr/>       
<form class="form-inline" role="form" action="javascript:"  method="post" onsubmit="return update_offer('save_edit_offer')" id="formEditoffer" style="border: 0px solid red;">
<div class="col-md-12" >
     
  <div class="">
    <div class="box-body">
        <table   style="border-collapse: separate; border-spacing: 0 1em;" width='100%' >
        <tr>
          <td>Offer Name *</td>
          <td>
              <input name="img_urls" id="img_urls"  type="hidden" class="inputFile" value="<?php echo $img_urls; ?>" /> 
              <input name="offer_id" id="offer_id"  type="hidden" class="inputFile" value="<?php echo $offer_id; ?>" /> 
          <input type="text" value="<?php echo $offer_name; ?>" class="form-control" maxlength="30"  name="offer_name" id="offer_name" placeholder="Offer Name" >
          <span class="help-block has-error" id="offer_name-error" style="color:red;"></span>
          </td>
          <td>
          <level data-toggle="tooltip" title="The code the customer enters to get the discount."> 
          <i class="fa fa-question-circle" style="color: blue;"></i> Code</level> *</td>
          <td>  
              <input type="text" value="<?php echo $offer_code; ?>" class="form-control" maxlength="10"  name="offer_code" onkeyup="changeToUpperCase(this)" id="offer_code" placeholder="Code" >
            <span class="help-block has-error" id="offer_code-error" style="color:red;"></span>
          </td>
        </tr>
        <tr>
          <td>
          <level data-toggle="tooltip" title="Percentage or Fixed Amount."> 
          <i class="fa fa-question-circle" style="color: blue;"></i> Type</level> 
          </td>
          <td>  
             <select name="input-type" id="input-type"  class="form-control" style="width:200px;">
                 <option value="P" <?php echo $offer_type=='P'?'selected':''  ?> >Percentage</option> 
             <option value="F" <?php echo $offer_type=='F'?'selected':''  ?>>Fixed Amount</option>
          </select>
          </td>
          <!--<td>Discount *</td>
          <td>  
            <input type="text" class="form-control" maxlength="30"  name="offer_discount" id="offer_discount" placeholder="Discount">
           <span class="help-block has-error" id="offer_discount-error" style="color:red;"></span>
          </td>-->
           <td valign="top">Message</td> 
       <td valign="top">
           <textarea name="msg" id="msg" cols="20" rows="2" maxlength="180" style="resize: none; width:91%;"><?php echo $msg ?></textarea>
       </td>
        </tr>
        <tr>
       <td valign="top">Discount *</td> 
       <td colspan="2">
        <div  style="border:0px solid red;" >   
         <table class="table" id="currencyTable" style="width:100%;">
        <tr><th>Currency</th><th>Price</th></tr>     
    <tbody>
    <?php
    $arrayNumber = 0;
    $x = 1;
    if($TotalCurrencyCountry>0){  
    foreach($json_customdataCurrency as $currencyCode => $CurrencyPrice)
    { 
        $sqlGet="Select name,currency,country_code from countries_currency where status='1' and country_code='$currencyCode'";
        $dataGet = db_select($conn,$sqlGet);
        $cname=$dataGet[0]['name'];
    ?>
    <tr id="row<?php echo $x; ?>" class="<?php echo $arrayNumber; ?>">			  				
    <td style="margin-left:20px;">
     <input type="hidden" name="currency[]"  id="currency<?php echo $x; ?>" readonly  placeholder="price" class="form-control" value="<?php echo $currencyCode; ?>"   />  
     <input type="text" readonly  placeholder="currency" class="form-control" value="<?php echo $cname; ?>"   />  
     <span class="help-block has-error" id="currency<?php echo $x; ?>-error" style="color:red;"></span>   
     <td style="padding-left:20px;">
       <input type="text" name="price[]"  id="price<?php echo $x; ?>" value="<?php echo $CurrencyPrice; ?>" placeholder="price" class="form-control"  />
           <span class="help-block has-error" id="price<?php echo $x; ?>-error" style="color:red;"></span>
     </td>
     <td>
     <button class="btn btn-default removeProductRowBtn" disabled type="button" id="removeProductRowBtn" onclick="removeProductRow(<?php echo $x; ?>)"><i class="glyphicon glyphicon-trash"></i></button>
     </td>
     </tr>
        <?php
        $x++;
         }
       } 
        ?>
       </tbody>			  	
       </table>
        </div>  
          </td>
   
        </tr>
        <tr>
          <td>Date Start</td>
          <td> 
         <div class='input-group date' id='datetimepicker1'>
            <input type='text' value="<?php echo $date_start; ?>" class="form-control" placeholder="Date Start" size='16' value="<?php echo $currentDate; ?>" id="input-date-start" name="date_start"  />
            <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
            </span>
         </div>   
              <span class="help-block has-error" id="input-date-start-error" style="color:red;"></span>
           </td>
           <td>Date End</td>
        <td>  
        <div class='input-group date' id='datetimepicker2'>
            <input type='text' value="<?php echo $date_end; ?>" class="form-control" size='16' value="<?php echo $after_one_month; ?>" placeholder="Date End"  id="input-date-end" name="date_end"  />
        <span class="input-group-addon">
            <span class="glyphicon glyphicon-calendar"></span>
        </span>
        </div>
               <span class="help-block has-error" id="input-date-end-error" style="color:red;"></span>
         
        </td>
        </tr>
        <tr>
        <td>
          <level data-toggle="tooltip" title="The maximum number of times the Offer can be used by any user. Leave blank for unlimited"> 
          <i class="fa fa-question-circle" style="color: blue;"></i> Uses Per Offer</level>
        </td>
        <td>
          <input type="text" value="<?php echo $uses_per_offer; ?>" name="uses_per_offer" id="uses_per_offer" maxlength="30" value="1" placeholder="Uses Per Offer"  class="form-control" />  
         <span class="help-block has-error" id="uses_per_offer-error" style="color:red;"></span>
        </td>
        <td>
          <level data-toggle="tooltip" title="The maximum number of times the Offer can be used by a single User. Leave blank for unlimited"> 
          <i class="fa fa-question-circle" style="color: blue;"></i> Uses Per User</level>
        </td>
        <td>
        <input type="text" value="<?php echo $uses_customer; ?>" name="uses_customer" id="uses_customer" maxlength="30" value="1" placeholder="Uses Per Customer"  class="form-control" />
        <span class="help-block has-error" id="uses_customer-error" style="color:red;"></span>
        <input type="hidden" name="pageNum" value="<?php echo $pageindex; ?>">
        <input type="hidden" name="limitval" value="<?php echo $limitval; ?>">
        </td>
        </tr> 

      </table> 
    </div>
  </div>
</div>
          
<div class="modal-footer">
<div class="col-sm-offset-3 col-sm-4" style="right: 6%;">
    <button type="submit" name="save_edit_offer" id="save_edit_offers" class="btn btn-primary" >Update</button>
   <!-- <span id="saving_loader"> </span>-->  
</div>
<div align="center" id="saving_loader"></div>    
</div>
</form>  
</div> 
<script src = "js/common.js"></script>
<script src="js/add_custom_row.js" type="text/javascript"></script>
<script type="text/javascript" src="scripts/jquery.form.js"></script>
<script type='text/javascript'>

function changeToUpperCase(t) {
  var eleVal = document.getElementById(t.id);
  eleVal.value= eleVal.value.toUpperCase().replace(/ /g,'');
}
$('#datetimepicker1').datetimepicker({
    defaultDate: new Date(),
    //format: 'DD/MM/YYYY hh:mm:ss A',
    format: 'YYYY-MM-DD HH:mm:ss',
    sideBySide: true
});
$('#datetimepicker2').datetimepicker({
    defaultDate: new Date(),
    //format: 'DD/MM/YYYY hh:mm:ss A',
    format: 'YYYY-MM-DD HH:mm:ss',
    sideBySide: true
});


function update_offer(act)
{
    $(".has-error").html('');
    var offer_name = $('#offer_name').val();
    var offer_code = $('#offer_code').val();
    //var offer_discount = $('#offer_discount').val();
    //var pattern_with_no_space=/^[0-9A-Za-z]+/;
    var pattern_with_no_space=/^(?=.*[a-zA-Z])(?=.*[0-9])[a-zA-Z0-9]+$/;
    var pattern_only_numeric=/^[0-9]+/;
    if(offer_name=='')   
    { var mess="offer name should not be blank"; $("#offer_name-error").html(mess); return false;} 
    if(offer_code=='')
    {
        var mess="offer Code should not be blank"; $("#offer_code-error").html(mess); return false;
    }
    else if(offer_code.length>0){
         if ((offer_code.length <5) && (offer_code.length < 11)) 
         { var mess="Code must be between 5 and 10 characters!"; $("#offer_code-error").html(mess);return false;  }
         else if(!offer_code.match(pattern_with_no_space))
         { var mess="Please enter alphanumeric value"; $("#offer_code-error").html(mess);return false;} 
    }
    /*if(offer_discount==''){var mess="Discount should not be blank"; $("#offer_discount-error").html(mess); return false;}
    if(offer_discount.length>0){
     if(!offer_discount.match(pattern_only_numeric))
     { var mess="enter only numeric value"; $("#offer_discount-error").html(mess);return false;} 
    } */
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
    var input_date_start = $('#input-date-start').val();
if(input_date_start==''){  { var mess="Start Date should not be Blank"; $("#input-date-start-error").html(mess);return false;}    }
var input_date_end = $('#input-date-end').val();
if(input_date_end==''){  { var mess="End Date should not be Blank"; $("#input-date-end-error").html(mess);return false;}    }

var startdate = input_date_start.split(" ");
var onlyStartDate=startdate[0];
var enddate = input_date_end.split(" ");
var onlyEndDate=enddate[0];
if(new Date(onlyStartDate) > new Date(onlyEndDate))
{
    alert("date end should be greather than or equal to date start.");
    return false;
}
var input_uses_total=$('#uses_per_offer').val();
if(input_uses_total.length>0){
             if(!input_uses_total.match(/^[0-9]+$/))
             { var mess="enter only numeric value"; $("#uses_per_offer-error").html(mess);return false;} 
        }
var input_uses_customer=$('#uses_customer').val();
if(input_uses_customer.length>0){
             if(!input_uses_customer.match(/^[0-9]+$/))
             { var mess="enter only numeric value"; $("#uses_customer-error").html(mess);return false;} 
        }        

    $("#saving_loader").fadeIn(400).html('Saving... <img src="img/image_process.gif" />');
    $('#save_add_offers').attr('disabled',true);
    $.ajax({
      method : 'POST',
      url : 'offers_paging.php',
      data : $('#formEditoffer').serialize() +"&action="+act,
      success: function(jsonResult){
            if(jsonResult==1)
            {
                $('#LegalModal_modal_editOffer').modal('show');
                $("#saving_loader").hide(); 
                $('#save_edit_offers').attr('disabled',false);
                var msg='<div class="alert alert-danger alert-dismissible fade in">';
                msg+='<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'
                msg+='<strong>Warning :</strong> Offer code is already in use!.'
                msg+='</div>';
                $("#error").html(msg);
                return false;
            }    
            $("#saving_loader").hide(); 
            $('#LegalModal_modal_editOffer').modal('hide');
            $("#results").html(jsonResult);
            $("#msg").html("Success: Offer Update Successfully"); 
        }
      });  
}
    $('input[type=text]').blur(function(){ 
           $(this).val($.trim($(this).val().replace(/\t+/g,' ')));
    });
 


$(document).ready(function() { 
  $('#imageUpload').on('change', function() {
  if(['image/jpeg', 'image/jpg', 'image/png', 'image/gif','image/jpeg'].indexOf($("#imageUpload").get(0).files[0].type) == -1) {
        alert('Error : Only JPEG, PNG & GIF,JPEG allowed');
        $("#imageUpload").val('');
        return false;
    }
   var apiBody1 = new FormData($('#formuploadofferimage_edit')[0]);
   apiBody1.append('data',$('input[type=file]')[0].files[0]); 
   apiBody1.append('action','marketing');
    $.ajax({
                url:'includes/image_process.php',
                method: 'POST',
                data:apiBody1,
                processData: false,
                contentType: false,
                success: function(r){
                  if(r==1){
                       ImageProcess(); 
                  }
                  if(r==0){ alert("Error : image Height between  300 to 350 pixels.\n image width between  150 to 170 pixels"); return false; }
                }
           });
  
  });
  
function ImageProcess(){
  $("#preview_img_edit").html('Uploading.... <img src="img/image_process.gif" alt="Uploading...."/>');
  $('#imageUpload').attr('disabled',true);
  $('#save_edit_offers').attr('disabled',true);
  var publisher_unique_id="<?php echo $publisher_unique_id ?>";
  var apiURl="<?php  echo $apiURL."/upload" ?>";
  var apiBody = new FormData($('#formuploadofferimage_edit')[0]);
  apiBody.append("partnerid",publisher_unique_id);
  apiBody.append('fileAction','image');
  apiBody.append('tag','marketing');
  apiBody.append('data', $('input[type=file]')[0].files[0]);
  $.ajax({
                url:apiURl,
                method: 'POST',
                dataType: 'json', 
                data:apiBody,
                processData: false,
                contentType: false,
                success: function(jsonResult){
                var HOST_original=jsonResult.image_url[0].HOST
                var URI=jsonResult.image_url[0].URI; 
                var imgShow=HOST_original+URI;
                //$("#host_url").val(HOST_original);
                setTimeout(function() {
                $("#img_urls").val(imgShow);
                $('#imageUpload').attr('disabled',false);
                $('#save_edit_offers').attr('disabled',false);   
                 var imgPrev='<img src="'+imgShow+'" class="img-responsive customer-img"  >';
                document.getElementById('preview_img_edit').innerHTML=imgPrev; }, 15000);
                    }
            });	
      }      
  
 }); 
 
</script>  
<?php 
break;    
}
?>
 
