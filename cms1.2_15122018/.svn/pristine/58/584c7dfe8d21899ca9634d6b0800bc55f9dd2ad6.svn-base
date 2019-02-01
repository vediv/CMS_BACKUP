<?php
include_once 'corefunction.php';
$action=(isset($_REQUEST['action']))? $_REQUEST['action']: "";
switch($action)
{
	case "add_new_subCode":
        $currentDate=date('Y-m-d HH:ii:ss');
        $after_one_month=date('Y-m-d HH:ii:ss', strtotime('+1 months'));
        $currentDateonly=date('Y-m-d');
        $pin = '';
        $a = "0123QWERTYUIOPAS456789DFGHJKLZXCVBNM";
        $b = str_split($a);
        for ($i=1; $i <= 10 ; $i++) { 
        $pin .= $b[rand(0,strlen($a)-1)];
        }
        $randomCode=$pin;
        ?> 
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"> Add Subscription Code</h4>
        </div>
    
<div class="modal-body" >
    <form class="form-inline" method="post" id="formAddSubCode"> 
<div class="col-md-12" >
     <div id="error"></div>   
  <div class="box box-default">
    <div class="box-body">
        <table  border='0'  style="border-collapse: separate; border-spacing: 0 1em;" width='100%' >
        <tr>
          <td>Name *</td>
          <td>  
          <input type="text" class="form-control" maxlength="30"  name="subcode_name" id="subcode_name" placeholder="Name">
          <span class="help-block has-error" id="subcode_name-error" style="color:red;"></span>
          </td>
          <td>
          <level data-toggle="tooltip" title="The code the customer enters to get the Subscription."> 
          <i class="fa fa-question-circle" style="color: blue;"></i> Code</level> *</td>
          <td>  
              <input type="text" class="form-control" maxlength="10"  name="subcode_code" id="subcode_code" onkeyup="changeToUpperCase(this)"  placeholder="Code"  value="<?php echo $randomCode; ?>">
            <span class="help-block has-error" id="subcode_code-error" style="color:red;"></span>
          </td>
          </tr>
         <tr>
          <td>
          <level data-toggle="tooltip" title="This plan create in plandetail."> 
          <i class="fa fa-question-circle" style="color: blue;"></i> Select Plan *:</level> 
          </td>
          <td>  
          <?php
          $sql="SELECT planID,planName FROM plandetail where pstatus='1' and plan_used_for='s'";
          $FetchData=  db_select($conn, $sql);
          ?>    
          <select name="planid" id="planid" class="form-control" style="width:200px;">
              <option value="">--Select Plan--</option>
              <?php
              foreach($FetchData as $getPduration)
              {   $planID=trim($getPduration['planID']); $planName=$getPduration['planName'];
              ?>
              <option value="<?php echo $planID; ?>"><?php echo $planName." ($planID)"; ?></option>"; 
              <?php } ?>
          </select>
            <span class="help-block has-error" id="planid-error" style="color:red;"></span>
           <!--<input type="text" class="form-control" maxlength="30"  name="duration" id="duration" placeholder="duration">
           <span class="help-block has-error" id="duration-error" style="color:red;"></span>-->
          </td>
          <!--<td>Duration Type :</td>
          <td>  
           <select name="type" id="duration_type" name="duration_type" class="form-control" style="width:200px;">
              <option value="month">Month</option> 
            
             </select>
          </td>-->
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
            <input type='text' class="form-control" size='16' value="<?php echo $after_one_month; ?>" placeholder="Date End" id="input-date-end" name="date_end"  />
            <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
            </span>
        </div>
            <span class="help-block has-error" id="input-date-end-error" style="color:red;"></span>
        </td>
        </tr>
        
      </table> 
    </div>
  </div>
</div>
          
<div class="modal-footer" >
<button type="button" class="btn btn-primary center-block" data-dismiss="modal1" name="save_add_subCode"  id="save_add_subCode" onclick=" return saveAddSubcodes('saveAddSubcodes');" >
Save & Close </button> 
</div>
     <div align="center" id="saving_loader"></div>
</form>  
</div> 
<script src = "js/common.js"></script>
<script type='text/javascript'>
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

function changeToUpperCase(t) {
  var eleVal = document.getElementById(t.id);
  eleVal.value= eleVal.value.toUpperCase().replace(/ /g,'');
}

function saveAddSubcodes(act){
$(".has-error").html('');
var subcode_name = $('#subcode_name').val();
var subcode_code= $('#subcode_code').val();
var planid = $('#planid').val();
//var pattern_with_no_space=/^[0-9A-Za-z]+/;
var pattern_with_no_space=/^(?=.*[a-zA-Z])(?=.*[0-9])[a-zA-Z0-9]+$/;
var pattern_only_numeric=/^[0-9]+/;
if(subcode_name=='')   
{ var mess="Name should not be blank"; $("#subcode_name-error").html(mess); return false;} 
if(subcode_code=='')
{
    var mess="Code should not be blank"; $("#subcode_code-error").html(mess); return false;
}
if(subcode_code.length>0){
     if ((subcode_code.length <5) && (subcode_code.length < 11)) 
     { var mess="Code must be between 5 and 10 characters!"; $("#subcode_code-error").html(mess);return false;  }
     else if(!subcode_code.match(pattern_with_no_space))
     { var mess="Please enter alphanumeric value"; $("#subcode_code-error").html(mess);return false;} 
}

if(planid=='')
{
    var mess="select plan"; $("#planid-error").html(mess); return false;
}
/*if(duration.length>0){
     if(!duration.match(pattern_only_numeric))
     { var mess="Please enter Number value Only"; $("#duration-error").html(mess);return false;} 
}*/
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

$("#saving_loader").fadeIn(400).html('Saving... <img src="img/image_process.gif" />');
$('#save_add_subCode').attr('disabled',true);
    $.ajax({
      method : 'POST',
      url : 'sub_paging.php',
      data : $('#formAddSubCode').serialize() +"&action="+act,
      success: function(jsonResult){
            if(jsonResult==1)
            {
                $('#myModal_add_new_subCode').modal('show');
                $("#saving_loader").hide(); 
                $('#save_add_subCode').attr('disabled',false);
                var msg='<div class="alert alert-danger alert-dismissible fade in">';
                msg+='<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'
                msg+='<strong>Warning :</strong> Subscription code  is already in use!.'
                msg+='</div>';
                $("#error").html(msg);
                return false;
            }    
            $("#saving_loader").hide(); 
            $('#myModal_add_new_subCode').modal('hide');
            $("#results").html(jsonResult);
            $("#msg").html("Subscription Code Added Successfully"); 
        }
      });  
  
} 
</script>  
        <?php   
        break;
        case "editsubCode":
        $subcid=$_POST['subcid']; $pageindex=$_POST['pageindex']; $limitval=$_POST['limitval'];
        $query1="select subcid,name,code,duration,duration_type,date_start,date_end,planid
        from subscription_code  where subcid='".$subcid."'";
        $fetch= db_select($conn,$query1);
        $subcid =$fetch[0]['subcid']; $name =$fetch[0]['name'];$code =$fetch[0]['code']; $duration_type =$fetch[0]['duration_type'];  
        $duration =$fetch[0]['duration']; $date_start =$fetch[0]['date_start']; $date_end =$fetch[0]['date_end']; 
        $planid =$fetch[0]['planid']; 
        ?>   
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Subscription Code</h4>
        </div>
        <div class="modal-body" >
<form class="form-inline" method="post" id="formEditSubCode"> 
   <div class="col-md-12">
    <div id="error"></div>   
    <div class="box box-default">
      <div class="box-body">
          <table  border='0'  style="border-collapse: separate; border-spacing: 0 1em;" width='100%' >
          <tr>
            <td>Name *</td>
            <td>  
                <input type="text" class="form-control" maxlength="30"  name="subcode_name" id="subcode_name" placeholder="Name" value="<?php echo $name; ?>">
            <span class="help-block has-error" id="subcode_name-error" style="color:red;"></span>
            </td>
            <td>
            <level data-toggle="tooltip" title="The code the customer enters to get the Subscription."> 
            <i class="fa fa-question-circle" style="color: blue;"></i> Code</level> *</td>
            <td>  
                <input type="text" class="form-control" maxlength="10"  name="subcode_code" id="subcode_code" onkeyup="changeToUpperCase(this)"  placeholder="Code" value="<?php echo $code; ?>">
              <span class="help-block has-error" id="subcode_code-error" style="color:red;"></span>
            </td>
        </tr>
        <tr>
          <td>
          <level data-toggle="tooltip" title="Duration 6 month or 1 year etc."> 
          <i class="fa fa-question-circle" style="color: blue;"></i> Duration *:</level> 
          </td>
          <td> 
           <?php
          $sql="SELECT planID,planName FROM plandetail where pstatus='1' and plan_used_for='s'";
          $FetchData=  db_select($conn, $sql);
        
          ?>    
           <select name="planid" id="planid" class="form-control" style="width:200px;">
              <option value="">--Select Plan--</option>
              <?php
              foreach($FetchData as $getPduration)
              {   $planID=trim($getPduration['planID']); $planName=$getPduration['planName'];
              ?>
              <option value="<?php echo $planID; ?>" <?php echo $planID==$planid?'selected':''; ?>  ><?php echo $planName." ($planID)"; ?></option>"; 
              <?php } ?>
          </select>
            <span class="help-block has-error" id="planid-error" style="color:red;"></span>
           <!--<input type="text" class="form-control" maxlength="30"  name="duration" id="duration" placeholder="duration" value="<?php echo $duration; ?>">
           <span class="help-block has-error" id="duration-error" style="color:red;"></span>-->
          </td>
          <!--<td>Duration Type :</td>
          <td>  
           <select name="type" id="duration_type" name="duration_type" class="form-control" style="width:200px;">
               <option value="month" <?php //echo $duration_type=='month'?'selected':''; ?>>Month</option> 
             
             </select>
          </td>-->
        </tr>
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
          <input type="hidden" name="pageNum" value="<?php echo $pageindex; ?>">
        <input type="hidden" name="limitval" value="<?php echo $limitval; ?>">
        </tr>
       
</table> 
</div>
</div>
</div>

<div class="modal-footer" >
<button type="button" class="btn btn-primary center-block" data-dismiss="modal1" name="save_edit_subcode"  id="save_edit_subcode" onclick=" return saveEditSubCodes('saveEditSubCodes','<?php echo $subcid; ?>');" >
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
function changeToUpperCase(t) {
  var eleVal = document.getElementById(t.id);
  eleVal.value= eleVal.value.toUpperCase().replace(/ /g,'');
}  
function saveEditSubCodes(act,subcid){
$(".has-error").html('');
var subcode_name = $('#subcode_name').val();
var subcode_code= $('#subcode_code').val();
var planid = $('#planid').val();
//var pattern_with_no_space=/^[0-9A-Za-z]+/;
var pattern_with_no_space=/^(?=.*[a-zA-Z])(?=.*[0-9])[a-zA-Z0-9]+$/;
var pattern_only_numeric=/^[0-9]+/;
if(subcode_name=='')   
{ var mess="Name should not be blank"; $("#subcode_name-error").html(mess); return false;} 
if(subcode_code=='')
{
    var mess="Code should not be blank"; $("#subcode_code-error").html(mess); return false;
}
if(subcode_code.length>0){
     if ((subcode_code.length <5) && (subcode_code.length < 11)) 
     { var mess="Code must be between 5 and 10 characters!"; $("#subcode_code-error").html(mess);return false;  }
     else if(!subcode_code.match(pattern_with_no_space))
     { var mess="Please enter alphanumeric value"; $("#subcode_code-error").html(mess);return false;} 
}

if(planid=='')
{
    var mess="seletc plan"; $("#planid-error").html(mess); return false;
}
/*if(duration.length>0){
     if(!duration.match(pattern_only_numeric))
     { var mess="Please enter Number value Only"; $("#duration-error").html(mess);return false;} 
}*/
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
$("#saving_loader").fadeIn(400).html('Saving... <img src="img/image_process.gif" />');
$('#save_edit_subcode').attr('disabled',true);

           $.ajax({
             method : 'POST',
             url : 'sub_paging.php',
             data : $('#formEditSubCode').serialize() +"&action="+act+"&subcid="+subcid,
             success: function(r){
                   if(r==1)
                   {
                     $('#LegalModal_modal_editsubCode').modal('show');
                     $("#saving_loader").hide(); 
                     $('#save_edit_subcode').attr('disabled',false);
                     var msg='<div class="alert alert-danger alert-dismissible fade in">';
                     msg+='<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'
                     msg+='<strong>Warning :</strong> Subscription Code is already in use!.'
                     msg+='</div>';
                     $("#error").html(msg);
                     return false;
                   }    
                   $("#saving_loader").hide(); 
                   $('#LegalModal_modal_editsubCode').modal('hide');
                   $("#results").html(r);
                   $("#msg").html("You have modified Subscription Code! "); 
               }
             });  

       } 

        <?php 
        break;    
}
?>
 
