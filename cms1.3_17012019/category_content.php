<?php  
include_once 'corefunction.php'; 
$check="";
if(isset($_POST['save_priority']))
{
     $pidd=$_REQUEST['idd']; $prio=$_REQUEST['pr'];
     $i=0;
     foreach($pidd as $ptid)
           {
              $ptid; $pri=$prio[$i];	
              $s="update categories set priority='$pri' where catid='$ptid'"; 
              $r=db_query($conn,$s);
              $i++;
     }  
}    

?>
<!DOCTYPE html>
<html>
  <head>
 <meta charset="UTF-8">
 <title><?php echo ucwords(PROJECT_TITLE)." | Category Content";?></title>
 <link href="bootstrap/css/pagingCss.css" rel="stylesheet" type="text/css" />
 <style type="text/css">
body {font-size: 13px !important;} .caret {    margin-left: 4px !important; }
.input-group-btn:last-child > .btn, .input-group-btn:last-child > .btn-group { padding: 3px 7px !important; }
.dropdown-menu > li > a { padding: 3px 10px !important; color: #555 !important; }
.dropdown-menu {  border: 1px solid #666 !important;}
.mainNav ul {    border-bottom: 0px solid #888 !important;  }
.mainNav ul li { border-top: 0 solid #444 !important;  border-bottom: 1px solid #888 !important; }
.preview
{ width:200px;border:solid 1px #dedede; }
.not-active-href { pointer-events: none; cursor: default; }
#load {
    opacity:1;
    width: 80%;
    height: 70%;
    position: fixed;
    z-index: 9999;
    color: red;
    background: transparent url("img/image_process.gif") no-repeat center;
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
          <h1>Add Category <?php echo $check; ?>
          <?php  if(in_array("1", $UserRight)){ ?>     
              <a href="javascript:void()"  data-target=".bs-example-modal-lg" data-toggle="modal" title="Add New" onclick="add_new_category();">
           	<small><span class="glyphicon glyphicon-plus" style="color:#3290D4"></span></small></a>
          <?php } ?>
          </h1> 
          <ol class="breadcrumb">
            <li><a href="dashboard.php"><i class="fa fa-home" title="Home"></i> Home</a></li>
            <li class="active">Add Category</li>
          </ol>          
         </section>
     <section class="content">
           <div class="row">
          <div class="col-xs-12">
          
           <div class="box" style="min-height:550px !important;"> 
           <div class="box-header">
            </div> 
           <div id="flash1"></div>    
           <div id="results"></div> 
          </div>
          </div>
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

					  
<?php 
include_once "footer.php"; include_once 'commonJS_latest.php'; ?>
</div>
<!-- this following code show the upload model -->   

<div class="modal fade" id="myModal_add_new_category" role="dialog" data-keyboard="false" data-backdrop="static">
<div class="modal-dialog modal-lg">
   <div class="modal-content" id="add_new_category_model_view"> </div> 
</div>
</div>


<!-- Model for view and update content.... start DIV -->
<div class="modal fade" id="myModal_category_view" role="dialog" data-keyboard="false" data-backdrop="static">
<div class="modal-dialog modal-lg">
   <div class="modal-content" id="show_category_model_view"> </div>
</div>
</div>
  
<div class="modal fade" id="myModal_view_entry" role="dialog" data-keyboard="false" data-backdrop="static">
 <div class="modal-dialog modal-lg">
     <div class="modal-content" id="view_category_entry"></div>
</div>
</div>

<div class="modal fade" id="myModal_view_setpriority" role="dialog" data-keyboard="false" data-backdrop="static">
 <div class="modal-dialog modal-lg">
     <div class="modal-content" id="view_setpriority"></div>
</div>
</div>
<div class="modal fade" id="myModal_view_activeinactive" role="dialog" data-keyboard="false" data-backdrop="static">
 <div class="modal-dialog modal-lg">
     <div class="modal-content" id="view_activeinactive"></div>
</div>
</div>
<div class="modal fade" id="myModal_view_categoryEntry_priority" role="dialog" data-keyboard="false" data-backdrop="static">
 <div class="modal-dialog modal-lg">
     <div class="modal-content" id="view_categoryEntry_priority"></div>
</div>
</div>

<script type="text/javascript">
$(document).ready(function() {
var pageNum = 1; //total loaded record group(s)
var loading  = false; //to prevents multipal ajax loads
//$("#results").html('');
$("#flash1").show();
$("#flash1").fadeIn(500).html('Loading <img src="img/image_process.gif" />');
    $('#results').load("category_paging.php",
    {'pageNum':pageNum},
        function() {
                   $("#flash1").hide();
                   pageNum++;

              }); //load first group
   });
</script>

<script type='text/javascript'>
function activeInactive(page,limit)
    {
        $("#msg").html(); 
       
       $("#flash").fadeIn(100).html('Wait <img src="img/image_process.gif" />');
       $('#myModal_view_activeinactive').modal();
       var info = 'action=active_inactive_category&page='+page+"&limit="+limit; 
        $.ajax({
	   type: "POST",
	   url: "category_tree_active_inactive.php",
	   data: info,
         success: function(result){
         $("#flash").hide();
         $('#view_activeinactive').html(result);
         //$("#LegalModal").modal('show');
         //return false;
          }
        });
     return false; 
    
 }
 function SetEntryPriorty(catid,catName)
    {
       $("#msg").html(); 
       $("#flash").fadeIn(100).html('Wait <img src="img/image_process.gif" />');
       $('#myModal_view_categoryEntry_priority').modal();
       var info = 'action=categoryEntryPriority&catid='+catid+'&catName='+catName; 
        $.ajax({
        type: "POST",
	url: "categoryEntryPriority.php",
	data: info,
         success: function(result){
         $("#flash").hide();
         $('#view_categoryEntry_priority').html(result);
          }
        });
     return false; 
    
 }
 function setPriority()
    {
       $("#msg").html(); 
       $("#flash").fadeIn(100).html('Wait <img src="img/image_process.gif" />');
       $('#myModal_view_setpriority').modal();
       var info = 'action=setpriority'; 
        $.ajax({
	   type: "POST",
	   url: "priority.php",
	   data: info,
         success: function(result){
         $("#flash").hide();
         $('#view_setpriority').html(result);
         //$("#LegalModal").modal('show');
         //return false;
          }
        });
     return false; 
    
 }
 
function add_new_category()    
{
    $("#msg").html(); 
     $("#myModal_add_new_category").modal();
     $("#flash").fadeIn(500).html('Loading <img src="img/image_process.gif" />');
     var info = 'action=add_new_category'; 
        $.ajax({
	    type: "POST",
	    url: "add_new_category.php",
	    data: info,
             success: function(result){
             $("#flash").hide();
             $('#add_new_category_model_view').html(result);
         return false;
        }
 
        });
     return false;    
}
function CloseCategoryModal(){
document.getElementById("add_new_category_model_view").innerHTML="";
 //return false();
$('#myModal_add_new_category').modal('hide');
}
</script>
  </body>
</html>
