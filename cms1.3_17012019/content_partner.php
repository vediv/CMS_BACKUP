<?php include_once 'corefunction.php'; ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title><?php echo PROJECT_TITLE." | Content Partner";?></title>
  <link href="bootstrap/css/pagingCss.css" rel="stylesheet" type="text/css" />
  <style type="text/css">
         fieldset.scheduler-border {
    border: 1px groove #ddd !important;
    padding: 0 1.4em 1.4em 1.4em !important;
    margin: 0 0 1.5em 0 !important;
    -webkit-box-shadow:  0px 0px 0px 0px #000;
    box-shadow:  0px 0px 0px 0px #000;
}

    legend.scheduler-border {
        text-align: left !important;
        width:auto; height:20px; 
        padding:12px 3px 0px 3px;
        font-size:12px; font-weight: bold;
        border-bottom:none;
        color:#3290D4; 
    }
 </style> 
    </head>
    
    <body class="skin-blue">
    <div class="wrapper">
 <?php include_once 'header.php';?>
      <?php include_once 'lsidebar.php';?>
      <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <section class="content-header">
<h1>Content Partner 
 <?php  if(in_array("1", $UserRight)){ ?>     
   <a href="javascript:"  title="add Content Partner" onclick="addContentPartnerModal();"><small><span class="glyphicon glyphicon-plus" style="color:#3290D4"></span></small></a>
<?php } ?>
</h1>
          <ol class="breadcrumb">
            <li><a href="dashboard.php"><i class="fa fa-home" title="Home"></i> Home</a></li>
                      <li class="active">Content Partner</li>
          </ol>
        </section>
    
    <section class="content">
         <div class="row">
          <div class="col-xs-12">
          
          <div class="box" > 
           <div class="box-header">
                   
            </div> 
           <div id="flash1"></div>    
           <div id="results" style="min-height: 500px;"></div> 
          </div>
          </div>
          </div>
        </section><!-- /.content -->

     
</div>
<?php include_once "footer.php"; include_once 'commonJS.php'; ?>
       </div><!-- /.content-wrapper --> 
	<!-- create plan Model -->

<div class="modal fade" id="myModal_addContentPartnerModal" role="dialog" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg-extralarge">
        <div class="modal-content" id="view_ContentPartnerModal"></div>
    </div>
  </div>
 
<div id="LegalModal_modal_edit_contentpartner" tabindex="-1" aria-labelledby="myModalLabel" role="dialog"  aria-hidden="true" class="modal fade bs-example-modal-lg" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg-extralarge">
      <div class="modal-content" id="edit_modal_contentpartner"></div>
    </div>
  </div> 
<script src="bootstrap/js/jquery-ui.js" type="text/javascript"></script> 
<script type="text/javascript">
$(document).ready(function() {
var pageNum = 0; //total loaded record group(s)
var loading  = false; //to prevents multipal ajax loads
//$("#results").html('');
$("#flash1").show();
$("#flash1").fadeIn(500).html('Loading <img src="img/image_process.gif" />');
$('#results').load("content_partner_paging.php",{'pageNum':pageNum},
function() {
                   $("#flash1").hide();
                   pageNum++;

              }); //load first group
});

function SaveContentPartner() 
{
    
    $(".has-error").html('');
    var cname = $('#cname').val();
    var cemail = $('#cemail').val();
    var cmobile = $('#cmobile').val();
    var cpassword = $('#cpassword').val();
    var lsdate = $('#lsdate').val();
    var ledate = $('#ledate').val();
    var pattern=/^[A-Za-z\s]+$/;
    var pattern_with_no_space=/^[0-9A-Za-z-_#@|]+$/;
    if(cname=='')   
    { var mess="name should not be blank"; $("#cname-error").html(mess); return false;}  
    else if(!cname.match(pattern))
    {  var mess="(Please enter only alphabetical letters)  Eg:test"; $("#cname-error").html(mess);return false;} 
    if(cemail=='')   
    { var mess="email should not be blank"; $("#cemail-error").html(mess); return false;}
    else if(cemail.length>0)
    {        if(!cemail.match(/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/)) {
		$("#cemail-error").html("(email ID invalid..)");
                return false;
	}
    }
    if(cmobile.length>0)
    {
        var length = cmobile.length;
        if (length < 10 || length > 10) {
		$("#cmobile-error").html("(Please Enter 10 Digit Number)");
		return false;
	}
	if(!cmobile.match(/^[0-9-+]+$/)) {
		$("#cmobile-error").html("(mobile number invalid..)");
		return false;
	}
    }
    if(cpassword=='')   
    { var mess="password should not be blank"; $("#cpassword-error").html(mess); return false;}
     if(!checkPassword(cpassword)) {
      var mess="at least one number, one lowercase and one uppercase letter,at least six characters that are letters, numbers or special characters @#$%^&*_";
      $("#cpassword-error").html(mess); return false;
     }
    if(lsdate=='')   
    { var mess="License Start date should not be Blank"; $("#lsdate-error").html(mess); return false;} 
    if(ledate=='')   
    { var mess="License End date should not be Blank"; $("#ledate-error").html(mess); return false;} 
    if(new Date(lsdate) > new Date(ledate))
         {
            var mess="End Date must be greater than or Equal to Start date"; $("#ledate-error").html(mess);return false; 
         }
    $('#content_partner').attr('disabled',true);
    $("#saving_loader").show();
    $("#saving_loader").fadeIn(500).html('Saving..... <img src="img/image_process.gif" />');
    var checkboxes = document.getElementsByName('menus[]');
              var vals = "";
              for (var i=0, n=checkboxes.length;i<n;i++) 
              {
                if (checkboxes[i].checked) 
                {
                    //vals += ","+checkboxes[i].value;
                    vals +=checkboxes[i].value+',';
                }
              }
              var action = document.getElementsByName('action[]');
              var val = "";
              for (var i=0, n=action.length;i<n;i++) 
              {
                if (action[i].checked) 
                {
                    //vals += ","+checkboxes[i].value;
                    val +=action[i].value+',';
                }
              }
              var action = document.getElementsByName('other_permission[]');
              var val_other = "";
              for (var i=0, n=action.length;i<n;i++) 
              {
                if (action[i].checked) 
                {
                    //vals += ","+checkboxes[i].value;
                    val_other +=action[i].value+',';
                }
              }
    var other_permissions=val_other.slice(0, -1);
    var apiBody = new FormData();
    apiBody.append("cname",cname);
    apiBody.append("cemail",cemail);
    apiBody.append("cmobile",cmobile);
    apiBody.append("cpassword",cpassword);
    apiBody.append("lsdate",lsdate); 
    apiBody.append("ledate",ledate);
    apiBody.append("menuright",vals);
    apiBody.append("actionright",val);
    apiBody.append("other_permissions",other_permissions);
    apiBody.append("action","addcontentpartner");
     $.ajax({
                url:'adddasboarduser.php',
                method: 'POST',
                data:apiBody,
                processData: false,
                contentType: false,
                success: function(re){
                 if(re==1)
                 {  
                    $('#myModal_addContentPartnerModal').modal('show');
                    $("#saving_loader").hide();
                    $('#content_partner').attr('disabled',false);
                    $('#msg_model').html("Email already exist");  
                  }
                 if(re==2)
                  { 
                     $("#saving_loader").hide();
                     $('#myModal_addContentPartnerModal').modal('hide');
                     window.location="content_partner.php";
                  }   
            }
    });	
}    
  
function SaveEditContentPartner(parid,pageindex,limitval)
{
    
    //console.log(parid+"--"+pageindex+"--"+limitval);    
    //return false;
    $(".has-error").html('');
    var cname = $('#cname').val();
    var cemail = $('#cemail').val();
    var cmobile = $('#cmobile').val();
    var lsdate = $('#lsdate').val();
    var ledate = $('#ledate').val();
    var pattern=/^[0-9A-Za-z-_#|\s]+$/;
    //var pattern_with_no_space=/^[0-9A-Za-z-_#@|]+$/;
     if(cname=='')   
    { var mess="Content Name should not be Blank"; $("#cname-error").html(mess); return false;}  
     
    else if(!cname.match(pattern))
    {  var mess="(Please enter only alphabetical letters)  Eg:test"; $("#cname-error").html(mess);return false;} 
     if(cemail=='')   
    { var mess="Email should not be Blank"; $("#cemail-error").html(mess); return false;} 
    else if(cemail.length>0)
    {
        if(!cemail.match(/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/)) {
		$("#cemail-error").html("(email ID invalid..)");
                return false;
	}
    }
    if(cmobile.length>0)
    {
        var length = cmobile.length;
        if (length < 10 || length > 10) {
		$("#cmobile-error").html("(Please Enter 10 Digit Number)");
		return false;
	}
	if(!cmobile.match(/^[0-9-+]+$/)) {
		$("#cmobile-error").html("(mobile number invalid..)");
		return false;
	}
    }
    if(lsdate=='')   
    { var mess="License Start date should not be Blank"; $("#lsdate-error").html(mess); return false;} 
    if(ledate=='')   
    { var mess="License End date should not be Blank"; $("#ledate-error").html(mess); return false;} 
    if(new Date(lsdate) > new Date(ledate))
         {
             var mess="End Date must be grether or Equal then Start date"; $("#ledate-error").html(mess);return false; 
         }
    var checkboxes = document.getElementsByName('menus[]');
              var vals = "";
              for (var i=0, n=checkboxes.length;i<n;i++) 
              {
                if (checkboxes[i].checked) 
                {
                    //vals += ","+checkboxes[i].value;
                    vals +=checkboxes[i].value+',';
                }
              }
              var action = document.getElementsByName('action[]');
              var val = "";
              for (var i=0, n=action.length;i<n;i++) 
              {
                if (action[i].checked) 
                {
                    //vals += ","+checkboxes[i].value;
                    val +=action[i].value+',';
                }
              }
              var action = document.getElementsByName('other_permission[]');
              var val_other = "";
              for (var i=0, n=action.length;i<n;i++) 
              {
                if (action[i].checked) 
                {
                    //vals += ","+checkboxes[i].value;
                    val_other +=action[i].value+',';
                }
              }
    var other_permissions=val_other.slice(0, -1);     
    $('#content_partner').attr('disabled',true);
    $("#saving_loader").show();
    $("#saving_loader").fadeIn(500).html('Saving..... <img src="img/image_process.gif" />');
    var apiBody = new FormData();
    apiBody.append("parid",parid); 
    apiBody.append("cname",cname);
    apiBody.append("cemail",cemail);
    apiBody.append("cmobile",cmobile);
    apiBody.append("lsdate",lsdate); 
    apiBody.append("ledate",ledate);
    apiBody.append("pageindex",pageindex);
    apiBody.append("limitval",limitval);
    apiBody.append("menuright",vals);
    apiBody.append("actionright",val);
    apiBody.append("other_permissions",other_permissions);
    apiBody.append("action","save_editcontentpartner");
    $.ajax({
                url:'content_partner_paging.php',
                method: 'POST',
                data:apiBody,
                processData: false,
                contentType: false,
                success: function(re){
                if(re==1)
                 {  
                    $('#LegalModal_modal_edit_contentpartner').modal('show');
                    $("#saving_loader").hide();
                    $('#content_partner').attr('disabled',false);
                    $('#msg_model1').html("Email already exist");  
                  }
                 else{ 
                 $("#flash").hide();
                 $('#LegalModal_modal_edit_contentpartner').modal('hide');
                 $("#results").html(re);
                 $("#msg").html("Content Partner edit successfully..");
                 }
                 
            }
            
    });
    
}
    
function cdelete(cpid){
var st=document.getElementById('ad_status'+cpid).value;
if(st==1) { alert('This Partner is active so you can not delete'); return false;} 
var d=confirm("Are you sure you want to Delete This Partner?");
if(d)
{
       var info = 'cpid='+cpid+'&action=content_part_delete';
       $.ajax({
       type: "POST",
       url: "coredelete.php",
       data: info,
       success: function(r){
         if(r==1)
         {
           // var adstatus=document.getElementById('getstatus'+cpid).innerHTML="delete";
           //  document.getElementById('getstatus'+cpid).style.color = 'red';
             $("#cpdel" + cpid).remove();
         }   

         }
    });  
}    

}
</script>        
<script type="text/javascript">

/*function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            alert("Please enter only Numbers.");
            return false;
        }
        return true;
    }

    function validation() {
        var phoneNo = document.getElementById('cmobile');

    if (phoneNo.value == "" || phoneNo.value == null) {
            //alert("Please enter your Mobile No.");
            return true;
        } 
        if (phoneNo.value.length < 10 || phoneNo.value.length > 10) {
            alert("Mobile No. is not valid, Please Enter 10 Digit Mobile No.");
            return false;
        }

      //  alert("Success ");
        return true;
        }
*/
</script>


 <script type="text/javascript">
function act_dect_content(contentid){
var adstatus=document.getElementById('ad_status'+contentid).value;
var msg = (adstatus == 1) ? "inactive":"active";
var c=confirm("Are you sure you want to "+msg+ " This?")
if(c)
{
 $.ajax({
   type: "POST",
   url: "core_active_deactive.php",
   data:'contentid='+contentid+'&adstatus='+adstatus+'&action=content_partner',
   success: function(rescont){
   	   if(rescont==0)
   	   { 
   	   	 var adstatus=document.getElementById('getstatus'+contentid).innerHTML=msg;
   	     $('#icon_status'+contentid).removeClass('fa-check-square-o').addClass('fa-ban');
   	   }
   	   if(rescont==1)
   	   {
   	   	var adstatus=document.getElementById('getstatus'+contentid).innerHTML=msg;
   	   	$('#icon_status'+contentid).removeClass('fa-ban').addClass('fa-check-square-o');
   	   }
       $('#ad_status'+contentid).val(rescont);
       
       
     }
 
   });
 }  
 
}
 
</script>    

</body>
</html>
