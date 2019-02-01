<?php  include_once 'corefunction.php'; 
$regid=$_GET['regid'];
?>
<!DOCTYPE html>
<html>
  <head>
  <meta charset="UTF-8">
  <title><?php echo PROJECT_TITLE." | Notification List";?></title>
  <link href="bootstrap/css/pagingCss.css" rel="stylesheet" type="text/css" />
  </head>
  <body class="skin-blue">
    <div class="wrapper">
   <?php include_once 'header.php';?>
      <?php include_once 'lsidebar.php';?>
      <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <section class="content-header">
  <h1>Notification List</h1>
          <ol class="breadcrumb">
            <li><a href="dashboard.php"><i class="fa fa-home" title="Home"></i> Home</a></li>
                      <li class="active">Notification List</li>
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
    <div class="modal fade" id="myModaldownload" role="dialog" data-keyboard="false" data-backdrop="static">
 <div class="modal-dialog modal-lg">
   <div class="modal-content" id="download_notification">   
   </div>
 </div>
</div>
<script src="bootstrap/js/jquery-ui.js"></script> 
<script type="text/javascript">
$(document).ready(function() {
var pageNum = 0; //total loaded record group(s)
var loading  = false; //to prevents multipal ajax loads
//$("#results").html('');
$("#flash1").show();
$("#flash1").fadeIn(500).html('Loading <img src="img/image_process.gif" />');
$('#results').load("notification_list_paging.php",{'pageNum':pageNum},
function() {
                   $("#flash1").hide();
                   pageNum++;

              }); //load first group
   });
function OpenDownloadModal()     
{
     $("#myModaldownload").modal();
     //$("#flash").fadeIn(500).html('Loading <img src="img/image_process.gif" />');
      var info = 'action=notification'; 
        $.ajax({
	    type: "POST",
	    url: "downloadNotification.php",
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
