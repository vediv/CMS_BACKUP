<?php 
include_once 'corefunction.php';
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title><?php echo ucwords(PROJECT_TITLE)." | Bulk Upload";?></title>
<link href="bootstrap/css/pagingCss.css" rel="stylesheet" type="text/css" />
<link href="player_css/functional.css" rel="stylesheet" type="text/css" />
<link href="dist/css/custom.css" rel="stylesheet" type="text/css" />
<style type="text/css">
.input-group .form-control:last-child, .input-group-addon:last-child, .input-group-btn:last-child > .btn, .input-group-btn:last-child > .btn-group > .btn, .input-group-btn:last-child > .dropdown-toggle, .input-group-btn:first-child > .btn:not(:first-child), .input-group-btn:first-child > .btn-group:not(:first-child) > .btn { }
.input-group-btn:last-child > .btn, .input-group-btn:last-child > .btn-group {
padding: 3px 7px !important;
}
tr.detail-row{display:none}tr.detail-row.open{display:block;display:table-row}
#subscItemTable tr{background-color:lightgray;}
</style>
</head>
<body class="skin-blue">
<div class="wrapper">
<?php include_once 'header.php';?>
<?php include_once 'lsidebar.php';?>
 <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>Bulk Upload 
           <?php  if(in_array("1", $UserRight)){ ?>   
           <a href="#LegalModal" data-target=".bs-example-modal-lg" data-toggle="modal" title="Add New">
           	<small><span class="glyphicon glyphicon-plus" style="color:#3290D4"></span></small></a>
           <?php } ?> 
          </h1> 
          <ol class="breadcrumb">
            <li><a href="dashboard.php"><i class="fa fa-home" title="Home"></i> Home</a></li>
            <li class="active">Bulk Upload</li>
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
        </section>
      </div><!-- /.content-wrapper -->
  			  
<?php include_once "footer.php"; include_once 'commonJS.php'; ?>
</div>
<!-- this following code show the Bulk upload model -->   
<div id="LegalModal" class="modal fade bs-example-modal-lg" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg">
      <div class="modal-content" style="border-radius: 14px; ">
        <div class="modal-body">
        <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                       <span aria-hidden="true">&times;</span>
                       <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">
                  <b>Bulk Upload</b>
                </h4>
            </div>
         <?php include_once 'bulk_upload_by_admin.php'; ?>
       </div> 
  </div>
    </div>
</div>
<div class="modal fade" id="myModalViewBulkEntries" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg-extralarge">
    <div class="modal-content" id="viewBulkEntries"></div>
  </div>
</div>

<script type="text/javascript">
$(document).ready(function() {
     var track_load = 1; //total loaded record group(s)
     var loading  = false; //to prevents multipal ajax loads
     $("#flash1").show();
     $("#flash1").fadeIn(500).html('Loading <img src="img/image_process.gif" />');
     $('#results').load("bulkupload_paging.php",{'first_load':track_load},
     function() {
     $("#flash1").hide();
     track_load++;
      }); //load first group
   });

function saveImgeProfile()
{  
      var fileUpload=$("#fileUpload").val();
      if(fileUpload=='')
      {
          $("#waitPreview").html("select a CSV file.");
          $("#waitPreview").css("color","red").css({ fontweight: "bold"}); 
          return false;
      }
      var fileName=fileUpload.toLowerCase();
      var regex = new RegExp("(.*?)\.(csv)$");
      if(!(regex.test(fileName))) {
      $("#waitPreview").html("only .csv file can be uploaded.");
      $("#waitPreview").css("color","red").css({ fontweight: "bold"});
      return false;
      }
     $("#waitPreview").html("");
     $('#save_upload_image').attr('disabled',true);
     $('#fileUpload').attr('disabled',true);
     $("#uploadCSV").fadeIn(400).html('wait for uploading csv...... <img src="img/image_process.gif" />');
     var publisher_unique_id="<?php  echo $publisher_unique_id ?>";
     var puser_id="<?php  echo $get_user_id ?>";
     var apiURl="<?php  echo $apiURL."/upload" ?>";
     var apiBody = new FormData($('#upload_form')[0]);
     apiBody.append("partnerid",publisher_unique_id);
     apiBody.append("fileAction","bulkupload");
     apiBody.append('data',$('#fileUpload')[0].files[0]);
     apiBody.append('puser_id',puser_id);
     $.ajax({
          url:apiURl,
          method: 'POST',
          dataType: 'json', 
          data:apiBody,
          processData: false,
          contentType: false,
              success: function(jsonResult){
                 //console.log(jsonResult); 
                 var status=jsonResult.status;
                 var statusid=jsonResult.statusid;
                 if(status=="1")
                 {
                      $("#uploadCSV").hide();
                      uploadStatus(statusid);
                 }    
              }
      });	  

} 
function uploadStatus(statusid)
{  
     
       $("#uploadCSV").fadeIn(400).html('wait for uploading csv...... <img src="img/image_process.gif" />');
       $('#save_upload_image').attr('disabled',true);
       $('#fileUpload').attr('disabled',true);
       setTimeout(function(){
           window.location.reload(); 
       },  
            10000);
}   
/*function uploadStatus(statusid)
{  
     
       $("#uploadCSV").fadeIn(400).html('wait for uploading csv...... <img src="img/image_process.gif" />');
       setTimeout(function(){
       var publisher_unique_id="<?php  //echo $publisher_unique_id ?>";
        var apiURl="<?php  //echo $apiURL."/uploadstatus" ?>"; 
       var apiBody = new FormData();
       apiBody.append("partnerid",publisher_unique_id);
       apiBody.append("id",statusid);
        $.ajax({
                url:apiURl,
                method: 'POST',
                dataType: 'json', 
                data:apiBody,
                processData: false,
                contentType: false,
                    success: function(jsonResult){
                       
                    }
            });	
           },  
            3000);

} */  



</script>
  </body>
</html>
