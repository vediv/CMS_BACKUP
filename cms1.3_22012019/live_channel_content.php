<?php
include_once 'corefunction.php';
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title><?php echo ucwords(PROJECT_TITLE)." | Live Channel";?></title>
<link href="bootstrap/css/pagingCss.css" rel="stylesheet" type="text/css" />
<style type="text/css">
.box-header { padding: 6px 10px !important}
.dropdown-menu {  border-color: #777 !important; color:#777 !important; }
.navbar-form .input-group > .form-control { height: 26px !important; } 
.btn-info1 {background-color: #225081 !important; color:#fff !important; border-color:#225081 !important;}
.btn-success1{background-color: #172d44 !important; color:#fff !important; border-color:#172d44 !important; } 
.table-bordered > thead > tr > th, .table-bordered > thead > tr > td {    border-left: 0 solid red !important;  border-bottom: 0 solid red !important;}
a .dropdown {color: #444 !important;}
.not-active-href { pointer-events: none; cursor: default; }
@media(min-width:200px) and (max-width:679px){#watch-video{ height:400px;}.player{padding: 1px;} .vidThumb{height: 200px; margin-bottom: 20px;}  #watch-video img{ height: auto;width: 100%;} .video-js .vjs-big-play-button{top: 38%!important;  left: 35.5%!important;}}
@media(min-width:680px){#watch-video{ height:400px; }.vidThumb{height: 250px;margin-bottom: 20px;}.vidThumb-sm{height: 180px; margin-bottom: 20px;}  #watch-video img{ height: 447px;width: 100%;}.video-js .vjs-big-play-button{top: 47%!important;  left: 44%!important;}}
</style>
</head>
<body class="skin-blue" >
<div class="wrapper"  >
<?php include_once 'header.php';?>
<?php include_once 'lsidebar.php';?>
<?php //include_once 'lsidebar.php';?>
<div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>List of Live Channels
           <?php  if(in_array("1", $UserRight)){ ?>
            <a href="javascript:" data-target=".bs-example-modal-lg"  title="Add New Channel" onclick="add_new_channel('add_new_channel');">
           <small><span class="glyphicon glyphicon-plus" style="color:#3290D4"></span></small></a>
           <?php } ?>    
          </h1> 
          <ol class="breadcrumb">
            <li><a href="dashboard.php"><i class="fa fa-home" title="Home"></i> Home</a></li>
            <li class="active">Live Channels</li>
          </ol>          
         </section>
        <section class="content">
           <div class="row">
          <div class="col-xs-12">
          
          <div class="box" > 
           <div class="box-header">
               <div class="pull-left" id="flash1" style="text-align: center;"></div>
            </div>   
              <div id="results" class="results" style="min-height: 500px;">
             </div> 
          </div>
          </div>
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      
<?php include_once 'commonJS.php';   ?>
<?php  include_once "footer.php"; ?>
</div>
<div class="modal fade" id="myModal_add_new_channel" role="dialog" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" id="view_modal_new_channel"></div>
    </div>
  </div>
<div class="modal fade" id="myModalLiveEdit" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg-extralarge">
    <div class="modal-content" id="show_detail_live_modal_view"></div>
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
   <div class="modal-content" id="show_add_to_category" style="height: 300px;">

   </div>

 </div>
</div>
<!-- Model for bulk plan edit END DIV -->
<script type="text/javascript">
$(document).ready(function() {
     var track_load = 1; 
     var loading  = false;
      //$("#flash1").show();
      $("#flash1").fadeIn(500).html('Loading <img src="img/image_process.gif" />');
      $('#results').load("live_channel_paging.php",{'first_load':track_load},
       function() {
	  	   $('#flash1').hide();
                   track_load++;
         }); 
   });   
       
    
   

function LiveAddChannel()
{
       
      var channelName = $('#channelname').val();
      var url = $('#url').val();
      var kal_tag = $('#tags_1').val();
      var description = $('#description').val();
      $('#save_live').attr('disabled',true); 
      $("#saving_loader").show();
      $("#saving_loader").fadeIn(500).html('Saving..... <img src="img/image_process.gif" />');
       var publisher_unique_id="<?php  echo $publisher_unique_id ?>";
       var apiURl="<?php  echo $apiURL."/livefeed" ?>";
       var apiBody = new FormData();
       apiBody.append("partnerid",publisher_unique_id);
       apiBody.append("name",channelName);
       apiBody.append("url",url);
       apiBody.append("description",description);
       apiBody.append("countrycode",'NULL');
       apiBody.append("kal_tag",kal_tag);
       apiBody.append("tag","insert");
       $.ajax({
                url:apiURl,
                method: 'POST',
                dataType: 'json', 
                data:apiBody,
                processData: false,
                contentType: false,
                success: function(jsonResult){
                      console.log(jsonResult);
                      var status=jsonResult.status;
                      if(status=="2")
                       {
                          $("#saving_loader").hide();
                          alert("Live Channel add Successfully..");
                          window.location.href="live_channel_content.php";
                          return true;
                       }    
                      if(status=="1")
                       {
                         $('#save_live').attr('disabled',false); 
                         $("#saving_loader").hide();
                         $("#msg").html("Opps... live channel not addded. something wrong in server...");
                         $('#myModal_add_new_channel').modal('hide');
                         return false;
                       }  
                 }
            });	 
       
}   


</script>
</body>
</html>
