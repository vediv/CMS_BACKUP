<?php require_once  'corefunction.php'; ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title><?php echo ucwords(PROJECT_TITLE)." | Dashboard Users";?></title>
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
<?php include_once 'header.php'; include_once 'lsidebar.php';?>
<div class="content-wrapper">
<section class="content-header">
<h1>Add New Team Member
 <?php  if(in_array("1", $UserRight)){ ?>     
   <a href="javascript:"  title="add Dashboard User" onclick="addDashboardUserModal();"><small><span class="glyphicon glyphicon-plus" style="color:#3290D4"></span></small></a>
<?php } ?>
</h1>
<ol class="breadcrumb">
  <li><a href="dashboard.php"><i class="fa fa-home" title="Home"></i> Home</a></li>
 <li class="active">Add New Team Member</li>
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

<div class="modal fade" id="myModal_addDashboardUserModal" role="dialog" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" id="view_DashboardUserModal"></div>
    </div>
  </div>
 
<div id="LegalModal_editDashboardUser" tabindex="-1" aria-labelledby="myModalLabel" role="dialog"  aria-hidden="true" class="modal fade bs-example-modal-lg" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg">
      <div class="modal-content" id="edit_modal_DashboardUser"></div>
    </div>
  </div> 
   
       
<script type="text/javascript">
$(document).ready(function() {
var pageNum = 0; //total loaded record group(s)
var loading  = false; //to prevents multipal ajax loads
//$("#results").html('');
$("#flash1").show();
$("#flash1").fadeIn(500).html('Loading <img src="img/image_process.gif" />');
$('#results').load("dashboarduser_paging.php",{'pageNum':pageNum},
function() {
                   $("#flash1").hide();
                   pageNum++;

              }); //load first group
});
    
function SaveDashboardUser() 
{
    $(".has-error").html(''); 
    var duserName = $('#duser').val();
    var demail = $('#demail').val();
    var dpwd = $('#dpwd').val();
    var pattern=/^[A-Za-z\s]+$/;
    var pattern_with_no_space=/^[0-9A-Za-z-_#@|]+$/;
    //alert(cmobile.length);
    if(duserName=='')   
    { var mess="Name should not be Blank"; $("#duser-error").html(mess); return false;}  
    else if(!duserName.match(pattern))
    {  var mess="(Please enter only alphabetical letters)  Eg:test"; $("#duser-error").html(mess);return false;} 
    if(demail=='')   
    { var mess="email should not be Blank"; $("#demail-error").html(mess); return false;}
    else if(demail.length>0)
    {     if(!demail.match(/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/)) {
		$("#demail-error").html("(email ID invalid..)");
                return false;
	}
    }
   
    if(dpwd=='')   
    { var mess="Password should not be Blank"; $("#dpwd-error").html(mess); return false;}
    if(!checkPassword(dpwd)) {
      var mess="at least one number, one lowercase and one uppercase letter,at least six characters that are letters, numbers or special characters @#$%^&*_"; $("#dpwd-error").html(mess); return false;
      return false;
     }
    $('#dashboard_user').attr('disabled',true);
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
    apiBody.append("duserName",duserName);
    apiBody.append("demail",demail);
    apiBody.append("dpwd",dpwd);
    apiBody.append("menuright",vals);
    apiBody.append("actionright",val);
    apiBody.append("other_permissions",other_permissions);
    apiBody.append("action","adddashboarduser");
    $.ajax({
                url:'adddasboarduser.php',
                method: 'POST',
                data:apiBody,
                processData: false,
                contentType: false,
                success: function(re){
                 if(re==1)
                 {  
                    $('#myModal_addDashboardUserModal').modal('show');
                    $("#saving_loader").hide();
                    $('#dashboard_user').attr('disabled',false);
                    $('#msg_model').html("Email already exist");  
                  }
                 if(re==2)
                  { 
                     $("#saving_loader").hide();
                     $('#myModal_addDashboardUserModal').modal('hide');
                     window.location="dashboarduser.php";
                  }   
                 
                 
            }
            
    });	
}    


function SaveEditDashboardUser(parid,pageindex,limitval)
{
    //console.log(parid+"--"+pageindex+"--"+limitval);   duser, 
    $(".has-error").html('');
    var duser = $('#duser').val();
    var demail = $('#demail').val();
    var pattern=/^[0-9A-Za-z-_#|\s]+$/;
    //var pattern_with_no_space=/^[0-9A-Za-z-_#@|]+$/;
     if(duser=='')   
    { var mess="Name should not be Blank"; $("#duser-error").html(mess); return false;}  
     
    else if(!duser.match(pattern))
    {  var mess="(Please enter only alphabetical letters)  Eg:test"; $("#duser-error").html(mess);return false;} 
    if(demail=='')   
    { var mess="Email should not be Blank"; $("#demail-error").html(mess); return false;} 
    else if(demail.length>0)
    {
        if(!demail.match(/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/)) {
		$("#demail-error").html("(email ID invalid..)");
                return false;
	}
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
    $('#dashboard_user').attr('disabled',true);
    $("#saving_loader").show();
    $("#saving_loader").fadeIn(500).html('Saving..... <img src="img/image_process.gif" />');
    var apiBody = new FormData();
    apiBody.append("parid",parid); 
    apiBody.append("duser",duser);
    apiBody.append("demail",demail);
    apiBody.append("pageindex",pageindex);
    apiBody.append("limitval",limitval);
    apiBody.append("menuright",vals);
    apiBody.append("actionright",val);
    apiBody.append("other_permissions",other_permissions);
    apiBody.append("action","save_editdashboarduser");
    $.ajax({
                url:'dashboarduser_paging.php',
                method: 'POST',
                data:apiBody,
                processData: false,
                contentType: false,
                success: function(re){
                if(re==1)
                 {  
                    $('#LegalModal_editDashboardUser').modal('show');
                    $("#saving_loader").hide();
                    $('#dashboard_user').attr('disabled',false);
                    $('#msg_model1').html("<strong> Email </strong> already exist.?");  
                  }
                 else{ 
                 $("#flash").hide();
                 $('#LegalModal_editDashboardUser').modal('hide');
                 $("#results").html(re);
                 $("#msg").html("update successfully.");
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
function act_dect_dashboarduser(parid){
var adstatus=document.getElementById('ad_status'+parid).value;
var msg = (adstatus == 1) ? "inactive":"active";
var c=confirm("Are you sure you want to "+msg+ " This?");
if(c)
{
   $.ajax({
   type: "POST",
   url: "adddasboarduser.php",
   data:'parid='+parid+'&adstatus='+adstatus+'&action=dashboarduser_active_deactive',
   success: function(reslide){
   	  if(reslide==0)
   	   { 
             
   	     var img_status=document.getElementById('getstatus'+parid).innerHTML='<span class="label label-danger" title="active">inactive</span>';
   	     $('#icon_status'+parid).removeClass('fa-check-square-o').addClass('fa-ban');
   	   }
   	   if(reslide==1)
   	   {
   	   	var img_status=document.getElementById('getstatus'+parid).innerHTML='<span class="label label-success"  title="active">active </span>';
   	   	$('#icon_status'+parid).removeClass('fa-ban').addClass('fa-check-square-o');
   	   }
           $('#ad_status'+parid).val(reslide);
     }
 
   });
 }  
 
}
 
</script>    

</body>
</html>
