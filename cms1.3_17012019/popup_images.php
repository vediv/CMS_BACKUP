<?php
include_once 'corefunction.php';
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title><?php echo ucwords(PROJECT_TITLE)." | PopUp Images";?></title>
<link href="bootstrap/css/pagingCss.css" rel="stylesheet" type="text/css" />

<style type="text/css">
.preview { width:200px;border:solid 1px #dedede; }
#load {
    opacity:1;
    width: 80%;
    height: 70%;
    position: fixed;
    z-index: 9999;
    color: red;
    background: transparent url("img/image_process.gif") no-repeat center;
}
.not-active-href { pointer-events: none; cursor: default; }
</style> 
</head>
<body class="skin-blue">
<div class="wrapper">
<?php 
include_once 'header.php';
include_once 'lsidebar.php';
?>
<div class="content-wrapper">
        <section class="content-header">
          <h1>PopUp Images 
         <?php  if(in_array("1", $UserRight)){ ?> 
         <a href="javascript:" data-target=".bs-example-modal-lg"  title="Add New Slider" onclick="add_new_popup_images();"><small><span class="glyphicon glyphicon-plus" style="color:#3290D4"></span></small></a>
           <?php } ?> 
         </h1> 
       
         <ol class="breadcrumb">
            <li><a href="dashboard.php"><i class="fa fa-home" title="Home"></i> Home</a></li>
            <li class="active">PopUp Images</li>
          </ol>          
          
        </section>
        <section class="content">
         <div class="row">
          <div class="col-xs-12">
          
          <div class="box" > 
           <div class="box-header">
                   
            </div> 
           <div id="flash1"></div>    
           <div id="results"></div> 
          </div>
          </div>
          </div>
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
<?php include_once "footer.php"; include_once 'commonJS.php'; ?>
</div>

<div id="LegalModal_add_new_popup_image" class="modal fade bs-example-modal-lg" aria-hidden="true" data-backdrop="static" data-keyboard="false">
<div class="modal-dialog">
   <div class="modal-content" id="add_new_popup_image"> </div> 
</div>
</div>
<script type="text/javascript">
$(document).ready(function() {
var pageNum = 0; //total loaded record group(s)
var loading  = false; //to prevents multipal ajax loads
//$("#results").html('');
$("#flash1").show();
$("#flash1").fadeIn(500).html('Loading <img src="img/image_process.gif" />');
$('#results').load("popup_image_paging.php",{'pageNum':pageNum},
function() {
                   $("#flash1").hide();
                   pageNum++;

              }); //load first group
   });
</script>
<script type="text/javascript"> 
function save_popup_image(saction){
$(".has-error").html('');     
var hostName=$("#host_url").val();
var imgUrls=$("#img_urls").val();   
var image_title=$("#image_title").val();
if(image_title=='')
{ $("#image_title-error").html("image title should not be blank");  return false;   }    
$('#saveSlider').attr('disabled',true);
$("#saving_loader").show();
$("#saving_loader").fadeIn(500).html('Saving..... <img src="img/image_process.gif" />');
        var apiBody = new FormData();
        apiBody.append("host_url",hostName);
        apiBody.append("imgUrls",imgUrls);
        apiBody.append("image_title",image_title);
        apiBody.append("action",saction);
        $.ajax({
                url:'img.php',
                method: 'POST',
                data:apiBody,
                processData: false,
                contentType: false,
                success: function(re){
                if(re==1)
                {   
                  $("#saving_loader").hide();
                  $('#LegalModal').modal('hide');
                  window.location="popup_images.php";
                }
                if(re==2){	
                $('#LegalModal').modal('show');
                $('#preview_s').css("color", "red").html('image Not saved successfully. please try again.');
                }
               
            }
            
    });	
   
  
}



function delete_temp_img(imgname,publisherid){
  var ac='delete_tmp_img'
  var dataString ='action='+ac+'&imgname='+imgname+'&parid='+publisherid;
  var t=confirm("Are you sure want to delete this ?");
  if(t)
  {    
   $.ajax({                                                                                                                                        
    type: "POST",
    url: "img.php",
    data: dataString,
    cache: false,
    success: function(result){
       if(result==1){	
       $('#LegalModal').modal('show');
       $('#photoimg').val('');
       $('#preview_s').css("color", "red").html('image Delete Successfully..');
      
       }
       
     }
    }); 
   }
   else
   {
       return false;
   }
}


</script>
</body>
</html>
