<?php 
include_once 'corefunction.php';
?>
<!DOCTYPE html>
<html>
  <head>
  <meta charset="UTF-8">
  <title><?php echo PROJECT_TITLE." | Footer Content";?></title>
  <link href="bootstrap/css/pagingCss.css" rel="stylesheet" type="text/css" />
  </head>
  <body class="skin-blue" onload="initResizeEvents();">
    <div class="wrapper">
   <?php include_once 'header.php';?>
      <?php include_once 'lsidebar.php';?>
      <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <section class="content-header">
  <h1>Footer Content
       <?php  if(in_array("1", $UserRight)){ ?>    
       <a href="javascript:" data-target=".bs-example-modal-lg"  title="add new home tag" onclick="add_new_footer();"><small><span class="glyphicon glyphicon-plus" style="color:#3290D4"></span></small></a>
      <?php  } ?>
  </h1>
          <ol class="breadcrumb">
            <li><a href="dashboard.php"><i class="fa fa-home" title="Home"></i> Home</a></li>
                      <li class="active">Footer Content  </li>
          </ol>
        </section>
<section class="content">
         <div class="row">
          <div class="col-xs-12">
          
          <div class="box" > 
           <div class="box-header">
                   
            </div> 
           <div id="flash1"></div>    
           <div id="results" style="min-height: 700px;"></div> 
          </div>
          </div>
          </div>
        </section><!-- /.content -->
        
</div><!-- /.content-wrapper -->
<?php include_once "footer.php"; include_once 'commonJS.php'; ?>
    </div><!-- ./wrapper -->
<div class="modal fade" id="myModal_add_new_footer" role="dialog" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
        <div class="modal-content" id="view_modal_new_footer"></div>
    </div>
  </div>
<div id="LegalModal_modal_edit_footer" tabindex="-1" aria-labelledby="myModalLabel" role="dialog"  aria-hidden="true" class="modal fade bs-example-modal-lg" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
      <div class="modal-content" id="edit_modal_footer"></div>
    </div>
  </div>     

<script type="text/javascript">
$(document).ready(function() {
var pageNum = 0; //total loaded record group(s)
var loading  = false; //to prevents multipal ajax loads
//$("#results").html('');
$("#flash1").show();
$("#flash1").fadeIn(500).html('Loading <img src="img/image_process.gif" />');
$('#results').load("footer_content_paging.php",{'pageNum':pageNum},
function() {
                   $("#flash1").hide();
                   pageNum++;

              }); //load first group
   });
function SaveFooter()
{
    $(".has-error").html('');
    var year = $('#year').val();
    var content = $('#content').val();
    var url = $('#url').val();
    var pattern=/^[0-9A-Za-z-_#|\s]+$/;
    var pattern_with_no_space=/^[0-9A-Za-z-_#@|]+$/;
    if(year=='')   
    { var mess="Year should not be Blank"; $("#year-error").html(mess); return false;}  
    
    if(content=='')   
    { var mess="Content should not be Blank"; $("#content-error").html(mess); return false;} 
    else if(!content.match(pattern_with_no_space))
    { var mess="Please enter only alphanumeric value with no spaces  #_-@| "; $("#content-error").html(mess);return false;} 
     if(url=='')   
    { var mess="URL should not be Blank"; $("#url-error").html(mess); return false;} 
    $('#footer_content').attr('disabled',true);
    $("#saving_loader").show();
    $("#saving_loader").fadeIn(500).html('Saving..... <img src="img/image_process.gif" />');
    var apiBody = new FormData();
    apiBody.append("year",year);
    apiBody.append("content",content);
    apiBody.append("url",url);
    apiBody.append("action","save_footer");
    $.ajax({
                url:'footer_content_paging.php',
                method: 'POST',
                data:apiBody,
                processData: false,
                contentType: false,
                success: function(re){
                 $("#saving_loader").hide();
                 $('#myModal_add_new_footer').modal('hide');
                 window.location="footer_content.php";
            }
    });	
}
function SaveEditFooter(fid,pageindex,limitval)
{
    $(".has-error").html('');
    var year = $('#year').val();
    var content = $('#content').val();
    var url = $('#url').val();
    var pattern=/^[0-9A-Za-z-_#|\s]+$/;
    var pattern_with_no_space=/^[0-9A-Za-z-_#@|]+$/;
    if(year=='')   
    { var mess="Year should not be Blank"; $("#year-error").html(mess); return false;}  
    
    if(content=='')   
    { var mess="Content should not be Blank"; $("#content-error").html(mess); return false;} 
    else if(!content.match(pattern_with_no_space))
    { var mess="Please enter only alphanumeric value with no spaces  #_-@| "; $("#content-error").html(mess);return false;} 
     if(url=='')   
    { var mess="URL should not be Blank"; $("#url-error").html(mess); return false;} 
    $('#footer_content').attr('disabled',true);
    $("#saving_loader").show();
    $("#saving_loader").fadeIn(500).html('Saving..... <img src="img/image_process.gif" />');
    var apiBody = new FormData();
    apiBody.append("fid",fid);
    apiBody.append("year",year);
    apiBody.append("content",content);
    apiBody.append("url",url);
    apiBody.append("pageindex",pageindex);  
    apiBody.append("limitval",limitval);
    apiBody.append("action","save_editfooter");
    $.ajax({
                url:'footer_content_paging.php',
                method: 'POST',
                data:apiBody,
                processData: false,
                contentType: false,
                success: function(re){
                $("#flash").hide();
                $('#LegalModal_modal_edit_footer').modal('hide');
                $("#results").html(re);
                $("#msg").html("Footer edit successfull..");
                                      }
            
    });
    
}
function footerdelete(ftcid){
var st=document.getElementById('act_deact_status'+ftcid).value;
if(st==1) { alert('This Footer is active so you can not delete'); return false;} 
var d=confirm("Are you sure you want to Delete This Footer?");
if(d)
{
       var info = 'ftcid='+ftcid+'&action=footer_delete';
       $.ajax({
       type: "POST",
       url: "coredelete.php",
       data: info,
       success: function(r){
         if(r==1)
         {
             $("#footerdel" + ftcid).remove();
         }   

         }
    });  
}    
}
</script> 
 <!--active-deactive -->
<script type="text/javascript">
function act_dect_footer(footerid){ 
var fstatus=document.getElementById('act_deact_status'+footerid).value;
var msg = (fstatus == 1) ? "inactive":"active";
var c=confirm("Are you sure you want to "+msg+ " This?")
if(c)
{
 $.ajax({
   type: "POST",
   url: "core_active_deactive.php",
   data:'footerid='+footerid+'&fstatus='+fstatus+'&action=footercontent',
   success: function(resfooter){
   	   if(resfooter==0)
   	   {    
                var fstatus=document.getElementById('getstatus'+footerid).innerHTML=msg;
                $('#icon_status'+footerid).removeClass('fa-check-square-o').addClass('fa-ban');
   	   }
   	   if(resfooter==1)
   	   {
   	   	var fstatus=document.getElementById('getstatus'+footerid).innerHTML=msg;
   	   	$('#icon_status'+footerid).removeClass('fa-ban').addClass('fa-check-square-o');
   	   }
         $('#act_deact_status'+footerid).val(resfooter);
       
         location.reload();
     }

   });
 }  
}
</script>    
</body>
</html>
