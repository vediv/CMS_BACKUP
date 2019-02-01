<?php  include_once 'corefunction.php';
$regid=$_GET['regid'];
?>
<!DOCTYPE html>
<html>
  <head>
  <meta charset="UTF-8">
  <title><?php echo PROJECT_TITLE." | Participant List";?></title>
  <link href="bootstrap/css/pagingCss.css" rel="stylesheet" type="text/css" />
  </head>
  <body class="skin-blue">
    <div class="wrapper">
   <?php include_once 'header.php';?>
      <?php include_once 'lsidebar.php';?>
      <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <section class="content-header">
  <h1>Participant List</h1>
          <ol class="breadcrumb">
            <li><a href="dashboard.php"><i class="fa fa-home" title="Home"></i> Home</a></li>
                      <li class="active">Participant List</li>
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

</div><!-- /.content-wrapper -->
<?php include_once "footer.php"; include_once 'commonJS.php'; ?>
    </div><!-- ./wrapper -->

<div id="LegalModal_viewUserDetail" tabindex="-1" aria-labelledby="myModalLabel" role="dialog"  aria-hidden="true" class="modal fade bs-example-modal-lg" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg">
      <div class="modal-content" id="viewUserDetail_modal"></div>
    </div>
  </div>
<div class="modal fade" id="myModaldownload" role="dialog" data-keyboard="false" data-backdrop="static">
 <div class="modal-dialog modal-lg">
   <div class="modal-content" id="download_notification">
   </div>
 </div>
</div>
<?php include_once 'view/modalTemplate.php'; ?>
<script src="bootstrap/js/jquery-ui.js"></script>
<script type="text/javascript">
var reg_id="<?php echo $regid; ?>"
$(document).ready(function() {
var pageNum = 0; //total loaded record group(s)
var loading  = false; //to prevents multipal ajax loads
//$("#results").html('');
$("#flash1").show();
$("#flash1").fadeIn(500).html('Loading <img src="img/image_process.gif" />');
$('#results').load("loadDataPagingParticipantList.php",{'pageNum':pageNum,'reg_id_user':reg_id},
function() {
                   $("#flash1").hide();
                   pageNum++;

              }); //load first group
   });

function SaveEditUserList(userid,pageindex,limitval)
{

    $(".has-error").html('');
    var name = $('#name').val();
    var email = $('#email').val();
    var dob = $('#dob').val();
    var gender = $('#gender').val();
    var location = $('#location').val();
    var pattern=/^[0-9A-Za-z-_#|\s]+$/;
    //var pattern_with_email=/^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/;
    var regexEmail = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if(name=='')
    { var mess="Name should not be Blank"; $("#name-error").html(mess); return false;}
    else if(!name.match(pattern))
    {  var mess="(Please enter alphanumeric value with #_-)  Eg:test123,test-123,#test_23";$("#name-error").html(mess);return false;}
    if(email=='')
    { var mess="Email  should not be Blank"; $("#email-error").html(mess); return false;}
    else if(!regexEmail.test(email))
    { var mess="Please enter valid Email Address"; $("#email-error").html(mess);return false;}
    if(dob=='')
    { var mess="Date of Birth should not be Blank"; $("#dob-error").html(mess); return false;}
    else if(!dob.match(/^\d{2}-\d{2}-\d{4}$/))
    { var mess="Please enter Date Of Birth with valid format dd-mm-yyyy "; $("#dob-error").html(mess);return false;}
    $('#user_list').attr('disabled',true);
    $("#saving_userlist").show();
    $("#saving_userlist").fadeIn(500).html('Saving..... <img src="img/image_process.gif" />');
    var apiBody = new FormData();
    apiBody.append("userid",userid);
    apiBody.append("name",name);
    apiBody.append("email",email);
    apiBody.append("dob",dob);
    apiBody.append("gender",gender);
    apiBody.append("location",location);
    apiBody.append("pageindex",pageindex);
    apiBody.append("limitval",limitval);
    apiBody.append("action","save_edituserlist");
    $.ajax({
                url:'loadDataPagingParticipantList.php',
                method: 'POST',
                data:apiBody,
                processData: false,
                contentType: false,
                success: function(re){
                $("#flash").hide();
                $('#LegalModal_modal_edit_userList').modal('hide');
                $("#results").html(re);
                $("#msg").html("User Details edit successfull..");

            }

    });

}

function userdelete(usersid){
var st=document.getElementById('act_deact_status'+usersid).value;
if(st==1) { alert('This User is active so you can not delete'); return false;}
var d=confirm("Are you sure you want to Delete This User?");
if(d)
{
       var info = 'usersid='+usersid+'&action=user_list_delete';
       $.ajax({
       type: "POST",
       url: "coredelete.php",
       data: info,
       success: function(r){
         if(r==1)
         {
             $("#userdel" + usersid).remove();
         }

         }
    });
}

}
</script>
 <!--active-deactive-->
<script type="text/javascript">
function act_dect_user(useid){
var userstatus=document.getElementById('act_deact_status'+useid).value;
var msg = (userstatus == 1) ? "inactive":"active";
var c=confirm("Are you sure you want to "+msg+ " This?")
if(c)
{
 $.ajax({
   type: "POST",
   url: "core_active_deactive.php",
   data:'useid='+useid+'&userstatus='+userstatus+'&action=userlist',
   success: function(resuser){
   	  if(resuser==0)
   	   {
   	     var img_status=document.getElementById('getstatus'+useid).innerHTML="<span class='label label-danger'>inactive</span>";
   	     $('#icon_status'+useid).removeClass('fa-check-square-o').addClass('fa-ban');
   	   }
   	   if(resuser==1)
   	   {
   	   	var img_status=document.getElementById('getstatus'+useid).innerHTML="<span class='label label-success'>active</span>";
   	   	$('#icon_status'+useid).removeClass('fa-ban').addClass('fa-check-square-o');
   	   }
           $('#act_deact_status'+useid).val(useid);


     }

   });
 }
}

function viewUserDetail(userid)
{
      $("#LegalModal_viewUserDetail").modal();
       var info = 'action=viewParticipantDetail&userid='+userid;
        $.ajax({
	    type: "POST",
	    url: "participantListModal.php",
	    data: info,
             success: function(result){
             $('#viewUserDetail_modal').html(result);
            return false;
         }

        });
     return false;
}
function OpenDownloadModal()
{
     $("#myModaldownload").modal();
     //$("#flash").fadeIn(500).html('Loading <img src="img/image_process.gif" />');
      var info = 'action=participantList';
        $.ajax({
	    type: "POST",
	    url: "downloadData.php",
	    data: info,
        success: function(result){
        $('#download_notification').html(result);
        return false;
        }

        });
     return false;
}
</script>
</body>
</html>
