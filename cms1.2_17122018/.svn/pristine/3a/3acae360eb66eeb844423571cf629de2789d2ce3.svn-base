<?php 
include_once 'corefunction.php';
?>
<!DOCTYPE html>
<html>
  <head>
<meta charset="UTF-8">
 <title><?php echo PROJECT_TITLE." | Subscription Detail";?></title>
<link href="bootstrap/css/pagingCss.css" rel="stylesheet" type="text/css" />
<style type="text/css">
.box-header {  padding: 4px 10px 0px 10px !important;  }
.navbar-form .input-group > .form-control {    height: 26px !important; }
h5 {margin-top: 0px  !important;}
.input-group-btn:last-child > .btn, .input-group-btn:last-child > .btn-group {
    height: 26px;
    margin-left: -1px;
    padding: 4px;
}

#load {
    opacity:1;
    width: 80%;
    height: 70%;
    position: fixed;
    z-index: 9999;
    color: red;
    background: transparent url("img/image_process.gif") no-repeat center;
}
tr.detail-row{display:none}tr.detail-row.open{display:block;display:table-row}
#subscItemTable tr{background-color:lightgray;}
</style>
  </head>
  <body class="skin-blue">
    <div class="wrapper">
   <?php include_once 'header.php';?>
      <!-- Left side column. contains the logo and sidebar -->
      <?php include_once 'lsidebar.php';?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
         <section class="content-header">
          <h1>Subscription Detail</h1>
          <ol class="breadcrumb">
            <li><a href="dashboard.php"><i class="fa fa-home" title="Home"></i> Home</a></li>
            <li class="active">Subscription Detail </li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
         <div class="row" >
          <div class="col-xs-12" >
             <div class="box" style="border:0px solid red; min-height: 550px !important;"> 
                 <div class="box-header"></div> 
                 <div id="flash1"></div>    
                 <div id="results"></div> 
             </div>
          </div>
          </div>
  </section>
</div>
    <?php include_once "footer.php"; include_once 'commonJS.php'; ?>
    </div>
 <div class="modal fade" id="myModal_show_subscription" role="dialog" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" id="view_modal_user_subscription"></div>
    </div>
  </div>
     

<script type="text/javascript">
$(document).ready(function() {
var pageNum = 0; //total loaded record group(s)
var loading  = false; //to prevents multipal ajax loads
$("#results").html('');
$("#flash1").show();
$("#flash1").fadeIn(500).html(' Loading <img src="img/image_process.gif" />');
$('#results').load("subscription_paging.php",{'pageNum':pageNum},
function() {
                   $("#flash1").hide();
                   pageNum++;

              }); //load first group
 });
   

</script>      
</body>
</html>
