<?php 
include_once 'corefunction.php';
?>
<!DOCTYPE html>
<html>
  <head>
  <meta charset="UTF-8">
  <title><?php echo PROJECT_TITLE." | Ticket";?></title>
  <link href="bootstrap/css/pagingCss.css" rel="stylesheet" type="text/css" />
  </head>
  <body class="skin-blue">
    <div class="wrapper">
   <?php include_once 'header.php';?>
      <?php include_once 'lsidebar.php';?>
      <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <section class="content-header">
  <h1>Ticket List</h1>
          <ol class="breadcrumb">
            <li><a href="dashboard.php"><i class="fa fa-home" title="Home"></i> Home</a></li>
               <li class="active">Ticket List </li>
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
$('#results').load("ticket_paging.php",{'pageNum':pageNum},
function() {
            $("#flash1").hide();
            pageNum++;
       }); 
   });
</script>    
</body>
</html>
