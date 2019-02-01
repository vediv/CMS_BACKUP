<?php include_once 'corefunction.php'; ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title><?php echo ucwords(PROJECT_TITLE)."-Bulk Upload Log";?></title>
<link href="bootstrap/css/pagingCss.css" rel="stylesheet" type="text/css" />
<link  href="bootstrap/css/jquery-ui.css" rel="stylesheet" type="text/css">
<style>
	.input-group .form-control:last-child, .input-group-addon:last-child, .input-group-btn:last-child > .btn, .input-group-btn:last-child > .btn-group > .btn, .input-group-btn:last-child > .dropdown-toggle, .input-group-btn:first-child > .btn:not(:first-child), .input-group-btn:first-child > .btn-group:not(:first-child) > .btn {    height: 30px !important;}
.input-group-btn:last-child > .btn, .input-group-btn:last-child > .btn-group {
    padding: 3px 7px !important;
}
</style>
</head>
<body class="skin-blue">
<div class="wrapper">
<?php include_once 'header.php';?>
<?php include_once 'lsidebar.php';?>
 <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Bulk Upload Log<small>(This list shows completed and in-progress bulk upload jobs.)</small>
                
          </h1> 
          <ol class="breadcrumb">
            <li><a href="dashboard.php"><i class="fa fa-home" title="Home"></i> Home</a></li>
            <li class="active">Bulk Upload Log</li>
          </ol>          
         </section>
        <section class="content">
           <div class="row">
          <div class="col-xs-12">
          <div class="box">
    
<div class="" id="flash1" ></div>    
<div class="box" id="result_bulk_upload_log" style="border-top: 0px solid #d2d6de !important; margin-top: 10px; min-height: 500px;">		 
</div>
         
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
  			  
<?php include_once "footer.php"; include_once 'commonJS.php'; ?>
</div>
<script src="bootstrap/js/jquery-ui.js"></script> 
<script type="text/javascript">
var pageindex=1, pageSize=20; 
loadFirst(pageindex,pageSize);    
function loadFirst(pageindex,pageSize){
     $("#flash1").show();
     $("#flash1").fadeIn(400).html('Loading <img src="img/image_process.gif" />');
     var dataString ='maction=bulk_upload_log_list&first_load='+pageindex+'&limitval='+pageSize;
     var container='result_bulk_upload_log';
     $.ajax({
                url:'bulk_upload_log_paging.php',
                method: 'POST',
                data:dataString,
                cache: false,
                    success: function(Result){
                         $("#flash1").hide();
                         $("#result_bulk_upload_log").html(Result);
                         
                       } 
                   
            });	  
     
}

</script>
</body>
</html>
