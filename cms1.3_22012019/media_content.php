<?php include_once 'corefunction.php'; ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title><?php echo ucwords(PROJECT_TITLE)."-VOD";?></title>
<link href="bootstrap/css/pagingCss.css" rel="stylesheet" type="text/css" />
<style type="text/css">
.box-header { padding: 6px 10px !important}
.dropdown-menu {  border-color: #777 !important; color:#777 !important; }
.navbar-form .input-group > .form-control { height: 26px !important; } 
.btn-info1 {background-color: #225081 !important; color:#fff !important; border-color:#225081 !important;}
.btn-success1{background-color: #172d44 !important; color:#fff !important; border-color:#172d44 !important; } 
.table-bordered > thead > tr > th, .table-bordered > thead > tr > td { border-left: 0 solid red !important;  border-bottom: 0 solid red !important;}
a .dropdown {color: #444 !important;}
.not-active-href { pointer-events: none; cursor: default; }
@media screen and (-webkit-min-device-pixel-ratio:0) {
    .test_button{margin-left:4px; margin-bottom:2px}
}

</style>
</head>
<body class="skin-blue" onload="initResizeEvents();">
<div class="wrapper"  >
<?php include_once 'header.php';?>
<?php include_once 'lsidebar.php';?>
<?php //include_once 'lsidebar.php';?>
<div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>Upload Media
           <?php  if(in_array("1", $UserRight)){ ?>
           <a href="#LegalModal" data-target=".bs-example-modal-lg" data-toggle="modal" title="Add New">
           	<small><span class="glyphicon glyphicon-plus" style="color:#3290D4"></span></small></a>
           <?php } ?>    
          </h1> 
          <ol class="breadcrumb">
            <li><a href="dashboard.php"><i class="fa fa-home" title="Home"></i> Home</a></li>
            <li class="active">Upload Media</li>
          </ol>          
         </section>
        <section class="content">
           <div class="row">
          <div class="col-xs-12">
          
          <div class="box" > 
           <div class="box-header">
               <div class="pull-left" id="flash1" style="text-align: center;"></div>
            </div>   
              <div id="results" class="results" ></div> 
          </div>
          </div>
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      
<?php include_once 'commonJS.php';   ?>
<!-- this following code show the upload model START CODE -->       
<div id="LegalModal" class="modal fade bs-example-modal-lg" aria-hidden="true" data-backdrop="static" data-keyboard="false" >
  <div class="modal-dialog modal-lg">
    <div class="modal-content" style="border-radius: 14px; ">
        <div class="modal-body">
        <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                       <span aria-hidden="true">&times;</span>
                       <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">
                  <b>Upload Media</b>
                </h4>
            </div>
         <?php include_once 'upload_by_admin.php'; ?>
     </div> 
    </div>
  </div>
</div>
<!-- Model for view and update content.... START DIV -->				  
<?php  include_once "footer.php"; ?>
</div>

<div class="modal fade" id="myModalVodEdit" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg-extralarge">
    <div class="modal-content" id="show_detail_model_view"></div>
  </div>
</div>
<!-- Model for view and update content.... END DIV -->
<!-- Model for bulk plan edit START DIV -->
<div class="modal fade" id="myModal_bulk" role="dialog" data-keyboard="false" data-backdrop="static">
 <div class="modal-dialog modal-lg">
   <!-- Modal content-->
   <div class="modal-content" id="bulk_plan_edit_model" style="height: 250px;">

   </div>

 </div>
</div>
<div class="modal fade" id="myModal_add_to_category" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg">
   <!-- Modal content-->
   <div class="modal-content" id="show_add_to_category" style="height: 500px;">

   </div>

 </div>
</div>
<div class="modal fade" id="myModal_bulkContentPartner" role="dialog" data-keyboard="false" data-backdrop="static">
 <div class="modal-dialog modal-lg">
   <div class="modal-content" id="show_bulkContentPartner" style="height: 500px;"></div>
 </div>
</div>
<div class="modal fade" id="myModal_bulkContentViewer" role="dialog" data-keyboard="false" data-backdrop="static">
 <div class="modal-dialog modal-lg">
   <div class="modal-content" id="show_bulkContentViewer" style="height: 500px;"></div>
 </div>
</div>
<!-- Model for bulk plan edit END DIV -->
<script type="text/javascript">
var _=function(id){return document.getElementById(id)};  
function initResizeEvents()
{
    if(window.attachEvent)
    {
         window.attachEvent('onresize', function(){ console.log("onresize"); setPlContainerHeight();});
    }
    
    else if(window.addEventListener)
    {
        window.addEventListener('resize', function(){console.log("resize"); setPlContainerHeight();}, true);
    }
    
    else
    {
        console.log("The browser does not support Javascript event binding");
    }
}
setPlContainerHeight();
//window.addEventListener('load', function(){ console.log("load"); setPlContainerHeight();}, true);
function setPlContainerHeight()
{
   var wHeight=height();
   var HeaderHeight=20;
   var footerHeight=80;
   var AddHF=HeaderHeight+footerHeight;
   var newHeight=wHeight-AddHF;
   var tbodyHeight=newHeight-150;
   setHeight('results',newHeight);
   /*setTimeout(function(){
        setHeight('tbodyHeight',tbodyHeight);
        _("settbodyHeight").value=tbodyHeight; 
    },500);*/
}
function setHeight(el,height)
{
    return _(el).style.height=height+"px";
}
function height(el)
{
        if(el)
        return el.offsetHeight||el.clientHeight||0;
        else
        return window.innerHeight||document.documentElement.clientHeight||document.body.clientHeight||0;
}
   
$(document).ready(function() {
     var track_load = 1; 
     var loading  = false;
      $("#flash1").show();
      $("#flash1").fadeIn(500).html('Loading <img src="img/image_process.gif" />');
      $('#results').load("media_paging.php",
       {'first_load':track_load},
        function() { $('#flash1').hide(); track_load++; }); 
     });
     
</script>
</body>
</html>
