<?php
include_once 'corefunction.php';
$action=(isset($_REQUEST['action']))? $_REQUEST['action']: "";
switch($action)
{
	
        case "get_video_entry":
        $filter_name=(isset($_GET['filter_name']))? $_GET['filter_name']: "";
        $where='';    
        if($filter_name!='')
           {
              $where=" and name LIKE '$filter_name%' ";
            }
        $query="select entryid,name from entry where type='1' and video_status='active'  $where limit 10";
        $fetchData= db_query($conn,$query);
        $result = array();$rows=array(); 
        foreach ($fetchData as $row) { 
         $rows['entryid']=$row['entryid'];
         $rows['name']=$row['name']; 
         $result[]=$rows;
        }    
        echo json_encode($result);
        break; 
        case "get_category":
        $filter_name=(isset($_GET['filter_name']))? $_GET['filter_name']: "";
        $where='';    
        if($filter_name!='')
            {
              $where=" where fullname LIKE '%$filter_name%' ";
            }
        $query="select category_id,fullname from categories  $where limit 10";
        $fetchData= db_query($conn,$query);
        $result = array();$rows=array(); 
        foreach ($fetchData as $row) { 
         $rows['category_id']=$row['category_id'];
         $rows['fullname']=$row['fullname'];
         $result[]=$rows;
        }    
        echo json_encode($result);
        break;    
        case "add_new_coupon":
        $currentDate=date('Y-m-d HH:ii:ss');
        $currentDateonly=date('Y-m-d');
        $after_one_month=date('Y-m-d HH:ii:ss', strtotime('+1 months'));
        $pin = '';
        $a = "0123QWERTYUIOPASDF456789GHJKLZXCVBNM";
        $b = str_split($a);
        for ($i=1; $i <= 10 ; $i++) { 
        $pin .= $b[rand(0,strlen($a)-1)];
        }
        $randomCode=$pin;
        ?> 
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"> Add Coupon</h4>
        </div>
    
<div class="modal-body" >
    <form class="form-inline" method="post" id="formAddCoupon"> 
<div class="col-md-12" >
     <div id="error"></div>   
  <div class="box box-default">
    <div class="box-body">
        <table  border='0'  style="border-collapse: separate; border-spacing: 0 1em;" width='100%' >
        <tr>
          <td>Coupon Name *</td>
          <td>  
          <input type="text" class="form-control" maxlength="30"  name="coupon_name" id="coupon_name" placeholder="Coupon Name">
          <span class="help-block has-error" id="coupon_name-error" style="color:red;"></span>
          </td>
          <td>
          <level data-toggle="tooltip" title="The code the customer enters to get the discount."> 
          <i class="fa fa-question-circle" style="color: blue;"></i> Code</level> *</td>
          <td>  
              <input type="text" class="form-control" maxlength="10"  name="coupon_code" onkeyup="changeToUpperCase(this)" id="coupon_code" placeholder="Code"  value="<?php echo $randomCode; ?>">
            <span class="help-block has-error" id="coupon_code-error" style="color:red;"></span>
          </td>
        </tr>
        <tr>
          <td>
          <level data-toggle="tooltip" title="Percentage or Fixed Amount."> 
          <i class="fa fa-question-circle" style="color: blue;"></i> Type</level> 
          </td>
          <td>  
              <select name="type" id="input-type" class="form-control" style="width:200px;">
             <option value="P">Percentage</option> 
             <!--<option value="F">Fixed Amount</option>-->
          </select>
          </td>
          <td>Discount*</td>
          <td>  
            <input type="text" class="form-control" maxlength="30"  name="coupon_discount" id="coupon_discount" placeholder="Discount">
           <span class="help-block has-error" id="coupon_discount-error" style="color:red;"></span>
          </td>
        </tr>
        <tr>
        <td valign="top">
          <level data-toggle="tooltip" title="Choose specific video the coupon will apply to. Select no video to apply coupon to entire video."> 
          <i class="fa fa-question-circle" style="color: blue;"></i> Video Entry</level> 
          </td>
          <td colspan="3">
          <input type="text" size="70" name="input_video" value="" placeholder="video entry" id="input_video" class="form-control" />
          <div id="coupon_video" class="well well-sm" style="height:70px; width: 598px; overflow: auto;"> </div>
          </td>    
        </tr>
       <!-- <tr>
        <td valign="top">
          <level data-toggle="tooltip" title="Choose all video under selected category"> 
          <i class="fa fa-question-circle" style="color: blue;"></i> Category</level> 
          </td>
          <td colspan="3">
          <input type="text" size="70" name="category_video" value="" placeholder="Category" id="input-category" class="form-control" />
          <div id="coupon-category" class="well well-sm" style="height:70px; width: 598px; overflow: auto;">  </div>
          </td>    
        </tr>-->
        <tr>
          <td>Date Start</td>
          <td> 
      
         <div class='input-group date' id="datetimepicker1">
             <input type='text'  class="form-control" placeholder="Date Start" size='16' value="<?php echo $currentDate; ?>" id="input-date-start" name="date_start"  />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div> 
               <span class="help-block has-error" id="input-date-start-error" style="color:red;"></span>
    
         
          </td>
          <td>Date End</td>
          <td>  
        <div class="input-group date" id="datetimepicker2">
                    <input type='text' class="form-control" size='16' value="<?php echo $after_one_month; ?>" placeholder="Date End" id="input-date-end" name="date_end"  />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
        </div> 
          <span class="help-block has-error" id="input-date-end-error" style="color:red;"></span>
        </td>
        </tr>
        <tr>
        <td>
          <level data-toggle="tooltip" title="The maximum number of times the coupon can be used by any user. Leave blank for unlimited"> 
          <i class="fa fa-question-circle" style="color: blue;"></i> Uses Per Coupon</level>
        </td>
        <td>
          <input type="text" name="uses_per_coupon" maxlength="30" value="1" placeholder="Uses Per Coupon" id="input-uses-total" class="form-control" />  
           <span class="help-block has-error" id="input-uses-total-error" style="color:red;"></span>
       
        </td>
        <td>
          <level data-toggle="tooltip" title="The maximum number of times the coupon can be used by a single User. Leave blank for unlimited"> 
          <i class="fa fa-question-circle" style="color: blue;"></i> Uses Per User</level>
        </td>
        <td>
        <input type="text" name="uses_customer" maxlength="30" value="1" placeholder="Uses Per Customer" id="input-uses-customer" class="form-control" />
           <span class="help-block has-error" id="input-uses-customer-error" style="color:red;"></span>
       
        </td>
        </tr> 

      </table> 
    </div>
  </div>
</div>
          
<div class="modal-footer" >
<button type="button" class="btn btn-primary center-block" data-dismiss="modal1" name="save_add_coupon"  id="save_add_coupon" onclick=" return save_add_coupons('save_add_coupon');" >
Save & Close </button> 
</div>
     <div align="center" id="saving_loader"></div>
</form>  
</div> 
<script src = "js/common.js"></script>
<script type='text/javascript'>
$(function () {    
    $('#datetimepicker1').datetimepicker({
        defaultDate: new Date(),
        //format: 'DD/MM/YYYY hh:mm:ss A',
        format: 'YYYY-MM-DD HH:mm:ss',
        minDate: 1,
        sideBySide: true

    });
    $('#datetimepicker2').datetimepicker({
        defaultDate: new Date(),
        //format: 'DD/MM/YYYY hh:mm:ss A',
        format: 'YYYY-MM-DD HH:mm:ss',
        sideBySide: true
    });
 });

$('input[name=\'input_video\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'couponModal.php?action=get_video_entry&filter_name='+request,
			method: 'POST',
                        dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['entryid']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'product\']').val('');
		$('#coupon_video' + item['value']).remove();
		$('#coupon_video').append('<div id="coupon_video' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="coupon_video[]" value="' + item['value'] + '" /></div>');	
	}
});
$('#coupon_video').delegate('.fa-minus-circle', 'click', function() {
	$(this).parent().remove();
});

/*$('input[name=\'category_video\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'couponModal.php?action=get_category&filter_name='+request,
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['fullname'],
						value: item['category_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'category_video\']').val('');
		
		$('#coupon-category' + item['value']).remove();
		
		$('#coupon-category').append('<div id="coupon-category' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="coupon_category[]" value="' + item['value'] + '" /></div>');
	}	
});
$('#coupon-category').delegate('.fa-minus-circle', 'click', function() {
	$(this).parent().remove();
});*/
function changeToUpperCase(t) {
  var eleVal = document.getElementById(t.id);
  eleVal.value= eleVal.value.toUpperCase().replace(/ /g,'');
}
 $('input[type=text]').blur(function(){ 
       $(this).val($.trim($(this).val().replace(/\t+/g,' ')));
    }); 

function save_add_coupons(act){
$(".has-error").html('');
var coupon_name = $('#coupon_name').val();
var coupon_code = $('#coupon_code').val();
var coupon_discount = $('#coupon_discount').val();
//var pattern_with_no_space=/^[0-9A-Za-z]+/;
var pattern_with_no_space=/^(?=.*[a-zA-Z])(?=.*[0-9])[a-zA-Z0-9]+$/;

var pattern_only_numeric=/^[0-9]+/;
if(coupon_name=='')   
{ var mess="Coupon Name should not be Blank"; $("#coupon_name-error").html(mess); return false;} 
if(coupon_code=='')
{
    var mess="Coupon Code should not be Blank"; $("#coupon_code-error").html(mess); return false;
}
if(coupon_code.length>0){
     if ((coupon_code.length <5) && (coupon_code.length < 11)) 
     { var mess="Code must be between 5 and 10 characters!"; $("#coupon_code-error").html(mess);return false;  }
     //else if(!coupon_code.match(pattern_with_no_space))
     else if(!pattern_with_no_space.test(coupon_code))
     { var mess="Please enter alphanumeric value"; $("#coupon_code-error").html(mess);return false;} 
}
if(coupon_discount==''){
    { var mess="Discount should not be Blank"; $("#coupon_discount-error").html(mess);return false;}
}
if(coupon_discount.length>0){
     if(!coupon_discount.match(pattern_only_numeric))
     { var mess="enter only numeric value"; $("#coupon_discount-error").html(mess);return false;} 
}

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
    alert("Date start should be greater than or equal to current date..");
    return false;
}    

if(new Date(onlyStartDate) > new Date(onlyEndDate))
{
    alert("date end should be greater than or equal to date start.");
    return false;
}
var input_uses_total=$('#input-uses-total').val();
if(input_uses_total.length>0){
             if(!input_uses_total.match(/^[0-9]+$/))
             { var mess="enter only numeric value"; $("#input-uses-total-error").html(mess);return false;} 
        }
var input_uses_customer=$('#input-uses-customer').val();
if(input_uses_customer.length>0){
             if(!input_uses_customer.match(/^[0-9]+$/))
             { var mess="enter only numeric value"; $("#input-uses-customer-error").html(mess);return false;} 
        }        


 $("#saving_loader").fadeIn(400).html('Saving... <img src="img/image_process.gif" />');
 $('#save_add_coupon').attr('disabled',true);
    $.ajax({
      method : 'POST',
      url : 'coupons_paging.php',
      data : $('#formAddCoupon').serialize() +"&action="+act,
      success: function(jsonResult){
            if(jsonResult==1)
            {
                $('#myModal_add_new_coupon').modal('show');
                $("#saving_loader").hide(); 
                $('#save_add_coupon').attr('disabled',false);
                var msg='<div class="alert alert-danger alert-dismissible fade in">';
                msg+='<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'
                msg+='Coupon code is already in use!.'
                msg+='</div>';
                $("#error").html(msg);
                return false;
            }    
            $("#saving_loader").hide(); 
            $('#myModal_add_new_coupon').modal('hide');
            $("#results").html(jsonResult);
            $("#msg").html("Coupon Added Successfully"); 
        }
      });  
  
} 
</script>  
        <?php   
        break;
        case "editCoupon":
        $coupon_id=$_POST['coupon_id']; $pageindex=$_POST['pageindex']; $limitval=$_POST['limitval'];
        $query1="select coupon_id,name,code,type,discount,date_start,date_end,uses_total,uses_customer from coupon  where coupon_id='$coupon_id'";
        $fetch= db_select($conn,$query1);
        $coupon_id =$fetch[0]['coupon_id']; $name =$fetch[0]['name'];$code =$fetch[0]['code']; $type =$fetch[0]['type'];  
        $discount =$fetch[0]['discount']; $date_start =$fetch[0]['date_start']; $date_end =$fetch[0]['date_end']; 
        $uses_total =$fetch[0]['uses_total']; $uses_customer =$fetch[0]['uses_customer'];
        ?>   
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Coupon</h4>
        </div>
        <div class="modal-body" >
<form class="form-inline" method="post" id="formEditCoupon"> 
   <div class="col-md-12">
    <div id="error"></div>   
    <div class="box box-default">
      <div class="box-body">
          <table  border='0'  style="border-collapse: separate; border-spacing: 0 1em;" width='100%' >
          <tr>
            <td>Coupon Name *</td>
            <td>  
                <input type="text" class="form-control" maxlength="30"  name="coupon_name" id="coupon_name" placeholder="Coupon Name" value="<?php echo $name; ?>">
            <span class="help-block has-error" id="coupon_name-error" style="color:red;"></span>
            </td>
            <td>
            <level data-toggle="tooltip" title="The code the customer enters to get the discount."> 
            <i class="fa fa-question-circle" style="color: blue;"></i> Code</level> *</td>
            <td>  
                <input type="text" class="form-control" maxlength="10"  name="coupon_code" onkeyup="changeToUpperCase(this)" id="coupon_code" placeholder="Code" value="<?php echo $code; ?>">
              <span class="help-block has-error" id="coupon_code-error" style="color:red;"></span>
            </td>
        </tr>
        <tr>
          <td>
          <level data-toggle="tooltip" title="Percentage or Fixed Amount."> 
          <i class="fa fa-question-circle" style="color: blue;"></i> Type</level> 
          </td>
          <td>  
          <select name="type" id="input-type" class="form-control" style="width:200px;">
              <option value="P" <?php echo $type=='P'?"selected":''; ?> >Percentage</option>
             <!--<option value="F" <?php echo $type=='F'?"selected":''; ?>>Fixed Amount</option>-->
          </select>
          </td>
          <td>Discount</td>
          <td>  
            <input type="text" class="form-control" maxlength="30"  name="coupon_discount" id="coupon_discount" placeholder="Discount" value="<?php echo $discount; ?>">
            <span class="help-block has-error" id="coupon_discount-error" style="color:red;"></span>
           </td>
         </tr>
         <tr>
         <td valign="top">
           <level data-toggle="tooltip" title="Choose specific video the coupon will apply to. Select no video to apply coupon to entire video."> 
           <i class="fa fa-question-circle" style="color: blue;"></i> Video Entry</level> 
           </td>
           <td colspan="3">
           <input type="text" size="70" name="input_video" value="" placeholder="video entry" id="input_video" class="form-control" />
           <div id="coupon_video" class="well well-sm" style="height:70px; width: 598px; overflow: auto;">
                <?php
                $qvideo="SELECT cv.coupon_id,cv.entryid,en.name FROM coupon_video as cv
                    LEFT JOIN entry en ON cv.entryid=en.entryid where coupon_id='".$coupon_id."'";
                $fetchVideo= db_select($conn,$qvideo);
                $totalRow= db_totalRow($conn,$qvideo);
                if($totalRow>0){
                  foreach($fetchVideo as $fvideo) 
                   {   
                ?>
                    <div id="coupon_video<?php echo $fvideo['entryid']; ?>"><i class="fa fa-minus-circle"></i><?php echo $fvideo['name'];?>
                    <input type="hidden" name="coupon_video[]" value="<?php echo $fvideo['entryid']; ?>" />
                    </div>
               <?php } }  ?>
           </div>
           </td>    
         </tr>
        <!-- <tr>
        <td valign="top">
          <level data-toggle="tooltip" title="Choose all video under selected category"> 
          <i class="fa fa-question-circle" style="color: blue;"></i> Category</level> 
          </td>
          <td colspan="3">
          <input type="text" size="70" name="category_video" value="" placeholder="Category" id="input-category" class="form-control" />
          <div id="coupon-category" class="well well-sm" style="height:70px; width: 598px; overflow: auto;">
              <?php
                $qcategory="SELECT cc.coupon_id,cc.category_id,cat.fullname FROM coupon_category  cc
                    LEFT JOIN categories cat  ON cc.category_id=cat.category_id where coupon_id='".$coupon_id."'";
                $fetchCategory= db_select($conn,$qcategory);
                $totalRow= db_totalRow($conn,$qcategory);
                if($totalRow>0){
                  foreach($fetchCategory as $fcategory) 
                   {   
                ?>
                <div id="coupon-category<?php echo $fcategory['category_id'];  ?>"><i class="fa fa-minus-circle"></i> <?php echo $fcategory['fullname'];  ?> 
                <input type="hidden" name="coupon_category[]" value="<?php echo $fcategory['category_id'];  ?>" />
                </div>
             <?php } }  ?>
          </div>
          </td>    
        </tr>-->
        <tr>
          <td>Date Start</td>
          <td> 
       
        <div class='input-group date' id='datetimepicker3'>
                    <input type='text' class="form-control" placeholder="Date Start" size='16' value="<?php echo $date_start; ?>" id="input-date-start" name="date_start"  />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>     
               <span class="help-block has-error" id="input-date-start-error" style="color:red;"></span>
          </td>
          <td>Date End</td>
        <td> 
            <div class='input-group date' id='datetimepicker4'>
                    <input type='text' class="form-control" size='16' value="<?php echo $date_end; ?>" placeholder="Date End" id="input-date-end" name="date_end"  />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
            </div>
             <span class="help-block has-error" id="input-date-end-error" style="color:red;"></span>
        </td>
        </tr>
        <tr>
        <td>
          <level data-toggle="tooltip" title="The maximum number of times the coupon can be used by any user. Leave blank for unlimited"> 
          <i class="fa fa-question-circle" style="color: blue;"></i> Uses Per Coupon</level>
        </td>
        <td>
          <input type="text"  name="uses_per_coupon" maxlength="30"  placeholder="Uses Per Coupon" id="input-uses-total" class="form-control"  value="<?php echo $uses_total; ?>" />  
        <span class="help-block has-error" id="input-uses-total-error" style="color:red;"></span>
        </td>
        <td>
          <level data-toggle="tooltip" title="The maximum number of times the coupon can be used by a single User. Leave blank for unlimited"> 
          <i class="fa fa-question-circle" style="color: blue;"></i> Uses Per User</level>
        </td>
        <td>
        <input type="text"  name="uses_customer" maxlength="30"  placeholder="Uses Per Customer" id="input-uses-customer" class="form-control" value="<?php echo $uses_customer; ?>" />
        <span class="help-block has-error" id="input-uses-customer-error" style="color:red;"></span>
        <input type="hidden" name="pageNum" value="<?php echo $pageindex; ?>">
        <input type="hidden" name="limitval" value="<?php echo $limitval; ?>">
        
        </td>
        </tr> 

</table> 
</div>
</div>
</div>

<div class="modal-footer" >
<button type="button" class="btn btn-primary center-block" data-dismiss="modal1" name="save_edit_coupon"  id="save_edit_coupon" onclick=" return save_edit_coupons('save_edit_coupon','<?php echo $coupon_id; ?>');" >
Save & Close </button> 
</div>
<div align="center" id="saving_loader"></div>
</form>  
</div> 
    <script src = "js/common.js"></script>
    <script type='text/javascript'>
 $('#datetimepicker3').datetimepicker({
    defaultDate: new Date(),
    //format: 'DD/MM/YYYY hh:mm:ss A',
    format: 'YYYY-MM-DD HH:mm:ss',
    sideBySide: true
});
$('#datetimepicker4').datetimepicker({
    defaultDate: new Date(),
    //format: 'DD/MM/YYYY hh:mm:ss A',
    format: 'YYYY-MM-DD HH:mm:ss',
    sideBySide: true
});

$('input[name=\'input_video\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'couponModal.php?action=get_video_entry&filter_name='+request,
			method: 'POST',
                        dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['entryid']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'product\']').val('');
		$('#coupon_video' + item['value']).remove();
		$('#coupon_video').append('<div id="coupon_video' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="coupon_video[]" value="' + item['value'] + '" /></div>');	
	}
});
    $('#coupon_video').delegate('.fa-minus-circle', 'click', function() {
	$(this).parent().remove();
});


/*$('input[name=\'category_video\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'couponModal.php?action=get_category&filter_name='+request,
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['fullname'],
						value: item['category_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'category_video\']').val('');
		
		$('#coupon-category' + item['value']).remove();
		
		$('#coupon-category').append('<div id="coupon-category' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="coupon_category[]" value="' + item['value'] + '" /></div>');
	}	
});
        $('#coupon-category').delegate('.fa-minus-circle', 'click', function() {
                $(this).parent().remove();
        });

*/

function changeToUpperCase(t) {
  var eleVal = document.getElementById(t.id);
  eleVal.value= eleVal.value.toUpperCase().replace(/ /g,'');
}  
$('input[type=text]').blur(function(){ 
       $(this).val($.trim($(this).val().replace(/\t+/g,' ')));
    });
function save_edit_coupons(act,couponid){
        $(".has-error").html('');
        var coupon_name = $('#coupon_name').val();
        var coupon_code = $('#coupon_code').val();
        var coupon_discount = $('#coupon_discount').val();
        //var pattern_with_no_space=/^[0-9A-Za-z]+/;
        var pattern_with_no_space=/^(?=.*[a-zA-Z])(?=.*[0-9])[a-zA-Z0-9]+$/;
        var pattern_only_numeric=/^[0-9]+/;
        if(coupon_name=='')   
        { var mess="Coupon Name should not be Blank"; $("#coupon_name-error").html(mess); return false;} 
        if(coupon_code=='')
        {
            var mess="Coupon Code should not be Blank"; $("#coupon_code-error").html(mess); return false;
        }
        if(coupon_code.length>0){
             if ((coupon_code.length <5) && (coupon_code.length < 11)) 
             { var mess="Code must be between 5 and 10 characters!"; $("#coupon_code-error").html(mess);return false;  }
             else if(!coupon_code.match(pattern_with_no_space))
             { var mess="Please enter alphanumeric value"; $("#coupon_code-error").html(mess);return false;} 
        }
        if(coupon_discount==''){
          { var mess="Discount should not be Blank"; $("#coupon_discount-error").html(mess);return false;}
        }
        if(coupon_discount.length>0){
             if(!coupon_discount.match(pattern_only_numeric))
             { var mess="enter only numeric value"; $("#coupon_discount-error").html(mess);return false;} 
        }
        
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
    alert("date end should be greater than or equal to date start.");
    return false;
}

var input_uses_total=$('#input-uses-total').val();
if(input_uses_total.length>0){
             if(!input_uses_total.match(/^[0-9]+$/))
             { var mess="enter only numeric value"; $("#input-uses-total-error").html(mess);return false;} 
        }
var input_uses_customer=$('#input-uses-customer').val();
if(input_uses_customer.length>0){
             if(!input_uses_customer.match(/^[0-9]+$/))
             { var mess="enter only numeric value"; $("#input-uses-customer-error").html(mess);return false;} 
        }        
$("#saving_loader").fadeIn(400).html('Saving... <img src="img/image_process.gif" />');
$('#save_edit_coupon').attr('disabled',true);
   $.ajax({
     method : 'POST',
     url : 'coupons_paging.php',
     data : $('#formEditCoupon').serialize() +"&action="+act+"&coupon_id="+couponid,
     success: function(r){
           if(r==1)
           {
             $('#LegalModal_modal_editCoupon').modal('show');
             $("#saving_loader").hide(); 
             $('#save_edit_coupon').attr('disabled',false);
             var msg='<div class="alert alert-danger alert-dismissible fade in">';
             msg+='<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'
             msg+='Coupon code is already in use!.'
             msg+='</div>';
             $("#error").html(msg);
             return false;
           }    
           $("#saving_loader").hide(); 
           $('#LegalModal_modal_editCoupon').modal('hide');
           $("#results").html(r);
           $("#msg").html("You have modified coupons! "); 
       }
     });  

} 

        <?php 
        break;    
}
?>
 
