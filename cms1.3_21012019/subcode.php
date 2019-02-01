<?php include_once 'corefunction.php';?>
<!DOCTYPE html>
<html>
  <head>
  <meta charset="UTF-8">
  <title><?php echo PROJECT_TITLE." | Subscription Code";?></title>
  <link href="bootstrap/css/pagingCss.css" rel="stylesheet" type="text/css" />
  </head>
  <body class="skin-blue">
   <div class="wrapper">
   <?php include_once 'header.php';?>
      <?php include_once 'lsidebar.php';?>
      <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<section class="content-header">
<h1>Subscription Code
     <?php  if(in_array("1", $UserRight)){ ?>    
     <a href="javascript:"  title="add new subscription code" onclick="add_new_subCode();"><small><span class="glyphicon glyphicon-plus" style="color:#3290D4"></span></small></a>
    <?php  } ?>
</h1>
<ol class="breadcrumb">
  <li>
  <a href="dashboard.php"><i class="fa fa-home" title="Home"></i> Home</a></li>
  <li class="active">Subscription Code </li>
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
<div class="modal fade" id="myModal_add_new_subCode" role="dialog" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" id="view_modal_new_subCode"></div>
    </div>
  </div>
<div id="LegalModal_modal_editsubCode" tabindex="-1" aria-labelledby="myModalLabel" role="dialog"  aria-hidden="true" class="modal fade bs-example-modal-lg" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg">
      <div class="modal-content" id="edit_modal_editsubCode"></div>
    </div>
  </div>     
<!--<div class="modal fade" id="myModal_view_setpriority_homeSetingtags" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
 <div class="modal-dialog modal-lg">
     <div class="modal-content" id="view_setpriority_homeSetingtags"></div>
 </div>
</div>-->   
<script src="plugins/datetimepicker/moment/moment.min.js" type="text/javascript"></script>
<script src="plugins/datetimepicker/moment/moment-with-locales.min.js" type="text/javascript"></script>
<script src="plugins/datetimepicker/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<link href="plugins/datetimepicker/bootstrap-datetimepicker.min.css" type="text/css" rel="stylesheet" media="screen" />
<script type="text/javascript">
$(document).ready(function() {
var pageNum = 0; //total loaded record group(s)
var loading  = false; //to prevents multipal ajax loads
//$("#results").html('');
$("#flash1").show();
$("#flash1").fadeIn(500).html('Loading <img src="img/image_process.gif" />');
$('#results').load("sub_paging.php",{'pageNum':pageNum},
function() {
                   $("#flash1").hide();
                   pageNum++;

              }); //load first group
   });

function subcodeDelete(subcid){
var st=document.getElementById('act_deact_status'+subcid).value;
if(st==1) { alert('This Subscription Code is active so you can not delete'); return false;} 
var d=confirm("Are you sure you want to Delete This Subscription Code ?");
if(d)
{
       var info = 'subcid='+subcid+'&action=subcription_code_delete';
       $.ajax({
       type: "POST",
       url: "coredelete.php",
       data: info,
       success: function(r){
         if(r==1)
         {
             $("#subCodedel"+subcid).remove();
         }   

         }
    });  
}    

}
</script> 
<!--active-inactive-->
<script type="text/javascript">
function act_dect_subcode(subcid){ 
var status=document.getElementById('act_deact_status'+subcid).value;
var msg = (status == 1) ? "inactive":"active";
var c=confirm("Are you sure you want to "+msg+ " This?")
if(c)
{
   $.ajax({
   type: "POST",
   url: "core_active_deactive.php",
   data:'subcid='+subcid+'&status='+status+'&action=subcription_code',
   success: function(reshome){
   	   if(reshome==0)
   	   { 
   	     var img_status=document.getElementById('getstatus'+subcid).innerHTML="<span class='label label-danger'>inactive</span>";
   	     $('#icon_status'+subcid).removeClass('fa-check-square-o').addClass('fa-ban');
   	   }
   	   if(reshome==1)
   	   {
   	   	var img_status=document.getElementById('getstatus'+subcid).innerHTML="<span class='label label-success'>active</span>";
   	   	$('#icon_status'+subcid).removeClass('fa-ban').addClass('fa-check-square-o');
   	   }
           $('#act_deact_status'+subcid).val(reshome);
       
       
     }
 
   });
 }  
 
}

</script>    
</body>
</html>
