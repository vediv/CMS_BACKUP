<?php
include_once 'corefunction.php';
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title><?php echo ucwords(PROJECT_TITLE)." | Youtube Video";?></title>
<link href="bootstrap/css/pagingCss.css" rel="stylesheet" type="text/css" />
<link href="dist/css/navAccordion.css" rel="stylesheet" type="text/css" />
<link href="dist/css/custom.css" rel="stylesheet" type="text/css" />
<style type="text/css">
.box-header { padding: 6px 10px !important}
.dropdown-menu {  border-color: #777 !important; color:#777 !important; }
.navbar-form .input-group > .form-control { height: 26px !important; } 
.btn-info1 {background-color: #225081 !important; color:#fff !important; border-color:#225081 !important;}
.btn-success1{background-color: #172d44 !important; color:#fff !important; border-color:#172d44 !important; } 
.table-bordered > thead > tr > th, .table-bordered > thead > tr > td {    border-left: 0 solid red !important;  border-bottom: 0 solid red !important;}
a .dropdown {color: #444 !important;}
.custom-table{width:100%;}
.custom-table td{padding:5px; padding-left: 10px; }
</style>
</head>
<body class="skin-blue">
<div class="wrapper">
<?php include_once 'header.php';?>
<?php include_once 'lsidebar.php';?>
<?php //include_once 'lsidebar.php';?>
<div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>Add from Youtube
           <?php  if(in_array("1", $UserRight)){ ?>
           <a href="#LegalModal" data-target=".bs-example-modal-lg" data-toggle="modal" title="Add New" onclick="add_new_youtube();">
           	<small><span class="glyphicon glyphicon-plus" style="color:#3290D4"></span></small></a>
           <?php } ?>    
          </h1> 
          <ol class="breadcrumb">
            <li><a href="dashboard.php"><i class="fa fa-home" title="Home"></i> Home</a></li>
            <li class="active">Youtube Video</li>
          </ol>          
         </section>
        <section class="content">
           <div class="row">
          <div class="col-xs-12">
          
          <div class="box" > 
           <div class="box-header">
               <div class="pull-left" id="flash1" style="text-align: center;"></div>      
            </div>   
           <div id="results"></div> 
          </div>
          </div>
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

<!-- Model for view and update content.... START DIV -->					  
<?php 
include_once "footer.php"; 
include_once 'commonJS.php';  
?>
</div>
<!-- this following code show the upload model START CODE -->       
<div class="modal fade" id="myModal_add_new_youtube" role="dialog" data-keyboard="false" data-backdrop="static">
<div class="modal-dialog modal-lg">
   <div class="modal-content" id="add_new_youtube_model_view"> </div> 
</div>
</div>

<div class="modal fade" id="myModal_youtube" role="dialog" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" id="show_youtube_view"></div>
  </div>
</div>
<!-- Model for view and update content.... END DIV -->


<script type="text/javascript">
$(document).ready(function() {
    var track_load = 1; //total loaded record group(s)
    var loading  = false; //to prevents multipal ajax loads
     $("#flash1").show();
     $("#flash1").fadeIn(500).html('Loading <img src="img/image_process.gif" />');
	 $('#results').load("youtube_paging.php",
	 {'first_load':track_load},
	  function() {
	  	 	 $("#flash1").hide();
	  	     track_load++;
	  	
	  	}); //load first group
   });


</script>

<script type='text/javascript'>
function add_new_youtube()    
{
     $("#myModal_add_new_youtube").modal();
     $('#add_new_youtube_model_view').html();
     $("#flash").fadeIn(500).html('Loading <img src="img/image_process.gif" />');
     var info = 'action=add_new_youtube'; 
        $.ajax({
	    type: "POST",
	    url: "youtube_add.php",
	    data: info,
             success: function(result){
             $("#flash").hide();
             $('#add_new_youtube_model_view').html(result);
          return false;
        }
 
        });
     return false;    
}
</script>

</body>
</html>
