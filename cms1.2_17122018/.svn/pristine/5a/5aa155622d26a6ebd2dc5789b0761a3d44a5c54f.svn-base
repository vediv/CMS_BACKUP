 <?php 
include_once 'corefunction.php';
if(isset($_REQUEST['save_priority_homeSetting']))
{
     $pidd=$_REQUEST['idd']; $prio=$_REQUEST['pr'];
     $i=0;
     foreach($pidd as $ptid)
           {
              $ptid; $pri=$prio[$i];		
               $s="update home_title_tag set priority='$pri' where tags_id='$ptid'";
               $r=db_query($conn,$s);
               $i++;
           } 
          $error_level=1;$msg="Home Setting priority Set"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
          $qry='';
          write_log($error_level,$msg,$lusername,$qry);
      
          header("Location:home_setting.php?val=update"); 
}     
?>
<!DOCTYPE html>
<html>
  <head>
  <meta charset="UTF-8">
  <title><?php echo ucwords(PROJECT_TITLE)." | Home Setting";?></title>
  <link href="bootstrap/css/pagingCss.css" rel="stylesheet" type="text/css" />
  </head>
  <body class="skin-blue">
    <div class="wrapper">
   <?php include_once 'header.php';?>
      <?php include_once 'lsidebar.php';?>
 <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <section class="content-header">
  <h1>Home Setting
       <?php  if(in_array("1", $UserRight)){ ?>    
       <a href="javascript:" data-target=".bs-example-modal-lg"  title="add new home tag" onclick="add_new_homeTag();"><small><span class="glyphicon glyphicon-plus" style="color:#3290D4"></span></small></a>
      <?php  } ?>
  </h1>
          <ol class="breadcrumb">
            <li>
            <a href="dashboard.php"><i class="fa fa-home" title="Home"></i> Home</a></li>
            <li class="active">Home Setting </li>
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
<div class="modal fade" id="myModal_add_new_homeTags" role="dialog" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="myModalLabel">
    <div class="modal-dialog ">
        <div class="modal-content" id="view_modal_new_homeTags"></div>
    </div>
  </div>
<div id="LegalModal_modal_edit_homeTags" tabindex="-1" aria-labelledby="myModalLabel" role="dialog"  aria-hidden="true" class="modal fade bs-example-modal-lg" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
      <div class="modal-content" id="edit_modal_homeTags"></div>
    </div>
  </div>     
<div class="modal fade" id="myModal_view_setpriority_homeSetingtags" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
 <div class="modal-dialog modal-lg">
     <div class="modal-content" id="view_setpriority_homeSetingtags"></div>
 </div>
</div>    
<script type="text/javascript">
$(document).ready(function() {
var pageNum = 0; //total loaded record group(s)
var loading  = false; //to prevents multipal ajax loads
//$("#results").html('');
$("#flash1").show();
$("#flash1").fadeIn(500).html('Loading <img src="img/image_process.gif" />');
$('#results').load("home_setting_paging.php",{'pageNum':pageNum},
function() {
                   $("#flash1").hide();
                   pageNum++;

              }); //load first group
   });
  
   
function SaveHomeTags()
{
    $(".has-error").html('');
    var ttag = $('#ttag').val();
    var stag = $('#stag').val();
    var pattern=/^[0-9A-Za-z-_#|\s]+$/;
    var pattern_with_no_space=/^[0-9A-Za-z-_#@|]+$/;
    if(ttag=='')   
    { var mess="Tag Name should not be Blank"; $("#ttag-error").html(mess); return false;}  
    else if(!ttag.match(pattern))
    {  var mess="(Please enter alphanumeric value with #_-)  Eg:test123,test-123,#test_23";$("#ttag-error").html(mess);return false;} 
    if(stag.length>1){
    if(stag=='')   
    { var mess="Search Tag  should not be Blank"; $("#stag-error").html(mess); return false;} 
     else if(!stag.match(pattern_with_no_space))
     { var mess="Please enter only alphanumeric value with no spaces  #_-@| "; $("#stag-error").html(mess);return false;} 
    }
   
    $('#home_tag').attr('disabled',true);
    $("#saving_loader").show();
    $("#saving_loader").fadeIn(500).html('Saving..... <img src="img/image_process.gif" />');
    var apiBody = new FormData();
    apiBody.append("ttag",ttag);
    apiBody.append("stag",stag);
    apiBody.append("action","save_hometag");
    $.ajax({
                url:'home_setting_paging.php',
                method: 'POST',
                data:apiBody,
                processData: false,
                contentType: false,
                success: function(re){
                 $("#saving_loader").hide();
                 $('#myModal_add_new_homeTags').modal('hide');
                 window.location="home_setting.php";
            }
            
    });	
}
function SaveEditHomeTags(tagid,pageindex,limitval)
{
    $(".has-error").html('');
    var ttag = $('#ttag').val();
    var stag = $('#stag').val();
    var pattern=/^[0-9A-Za-z-_#|\s]+$/;
    var pattern_with_no_space=/^[0-9A-Za-z-_#@|]+$/;
    if(ttag=='')   
    { var mess="Tag Name should not be Blank"; $("#ttag-error").html(mess); return false;}  
    else if(!ttag.match(pattern))
    {  var mess="(Please enter alphanumeric value with #_-)  Eg:test123,test-123,#test_23";$("#ttag-error").html(mess);return false;} 
    if(stag.length>1){
        if(stag=='')   
        { var mess="Search Tag  should not be Blank"; $("#stag-error").html(mess); return false;} 
        else if(!stag.match(pattern_with_no_space))
        { var mess="Please enter only alphanumeric value with no spaces  #_-@| "; $("#stag-error").html(mess);return false;} 
    }
    $('#home_tag').attr('disabled',true);
    $("#saving_loader").show();
    $("#saving_loader").fadeIn(500).html('Saving..... <img src="img/image_process.gif" />');
    var apiBody = new FormData();
    apiBody.append("tagid",tagid); 
    apiBody.append("ttag",ttag);
    apiBody.append("stag",stag);
    apiBody.append("pageindex",pageindex);
    apiBody.append("limitval",limitval);
    apiBody.append("action","save_edithometag");
    $.ajax({
                url:'home_setting_paging.php',
                method: 'POST',
                data:apiBody,
                processData: false,
                contentType: false,
                success: function(re){
                $("#flash").hide();
                $('#LegalModal_modal_edit_homeTags').modal('hide');
                $("#results").html(re);
                $("#msg").html("Edited tag successfully");
                 
            }
            
    });
    
}

function setPriority()
    {
       //$("#flash").fadeIn(100).html('Wait <img src="img/image_process.gif" />');
       $('#myModal_view_setpriority_homeSetingtags').modal();
       var info = 'action=setpriority_homeSettingtags'; 
        $.ajax({
	   type: "POST",
	   url: "priority.php",
	   data: info,
         success: function(result){
         //$("#flash").hide();
         $('#view_setpriority_homeSetingtags').html(result);
         return false; 
         
          }
        });
     return false; 
    
 }

function homedelete(tagsid,priority){
var st=document.getElementById('act_deact_status'+tagsid).value;
if(st==1) { alert('This Tag is active so you can not delete'); return false;} 
var d=confirm("Are you sure you want to Delete This Tag?");
if(d)
{
       var info = 'tagsid='+tagsid+'&priority='+priority+'&action=home_tag_delete';
       $.ajax({
       type: "POST",
       url: "coredelete.php",
       data: info,
       success: function(r){
         if(r==1)
         {
             $("#homedel" + tagsid).remove();
         }   

         }
    });  
}    

}
</script> 
<!--active-deactive-->
<script type="text/javascript">
function act_dect_home(homeid){ 
var tagstatus=document.getElementById('act_deact_status'+homeid).value;
var msg = (tagstatus == 1) ? "inactive":"active";
var c=confirm("Are you sure you want to "+msg+ " This?")
if(c)
{
   $.ajax({
   type: "POST",
   url: "core_active_deactive.php",
   data:'homeid='+homeid+'&tagstatus='+tagstatus+'&action=homesetting',
   success: function(reshome){
   	   if(reshome==0)
   	   { 
   	     var img_status=document.getElementById('getstatus'+homeid).innerHTML="<span class='label label-danger'>inactive</span>";
   	     $('#icon_status'+homeid).removeClass('fa-check-square-o').addClass('fa-ban');
   	   }
   	   if(reshome==1)
   	   {
   	   	var img_status=document.getElementById('getstatus'+homeid).innerHTML="<span class='label label-success'>active</span>";
   	   	$('#icon_status'+homeid).removeClass('fa-ban').addClass('fa-check-square-o');
   	   }
           $('#act_deact_status'+homeid).val(reshome);
       
       
     }
 
   });
 }  
 
}


</script>    
</body>
</html>
