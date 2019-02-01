<?php
include_once 'corefunction.php';
if(isset($_POST['save_priority_slider']))
{
     $pidd=$_REQUEST['idd']; $prio=$_REQUEST['pr'];
     $i=0;
     foreach($pidd as $ptid)
           {
              $ptid; $pri=$prio[$i];
              $s="update slider_image_detail set priority='$pri' where img_id='$ptid'";
              $r=db_query($conn,$s);
              $i++;
     }
     $error_level=1;$msg="Slider priority Set"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
     $qry='';
     write_log($error_level,$msg,$lusername,$qry);
     header("Location:slider-images.php?val=update");
}

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title><?php echo ucwords(PROJECT_TITLE)." | Slider Images";?></title>
<link href="bootstrap/css/pagingCss.css" rel="stylesheet" type="text/css" />
<style type="text/css">
.preview { width:200px;border:solid 1px #dedede; }
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
          <h1>Image Slider
         <?php  if(in_array("1", $UserRight)){ ?>
         <a href="javascript:" data-target=".bs-example-modal-lg"  title="Add New Slider" onclick="add_new_slider();"><small><span class="glyphicon glyphicon-plus" style="color:#3290D4"></span></small></a>
           <?php } ?>
         </h1>

         <ol class="breadcrumb">
            <li><a href="dashboard.php"><i class="fa fa-home" title="Home"></i> Home</a></li>
            <li class="active">Image Slider</li>
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
</div>

<div id="LegalModal_add_new_slider" class="modal fade bs-example-modal-lg" aria-hidden="true" data-backdrop="static" data-keyboard="false">
<div class="modal-dialog modal-lg">
   <div class="modal-content" id="add_new_slider_image"> </div>
</div>
</div>

<div class="modal fade" id="myModal_edit_slider" role="dialog" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg">
      <div class="modal-content" style="border-radius: 14px; " id="edit_slider_image"></div>
    </div>
  </div>
<div class="modal fade" id="myModal_view_setpriority_slider" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
 <div class="modal-dialog modal-lg">
     <div class="modal-content" id="view_setpriority_slider"></div>
</div>
</div>
<script type="text/javascript">
$(document).ready(function() {
var pageNum = 0; //total loaded record group(s)
var loading  = false; //to prevents multipal ajax loads
//$("#results").html('');
$("#flash1").show();
$("#flash1").fadeIn(500).html('Loading <img src="img/image_process.gif" />');
$('#results').load("slider_image_paging.php",{'pageNum':pageNum},
function() {
                   $("#flash1").hide();
                   pageNum++;

              }); //load first group
   });
</script>

<script type="text/javascript">
function setPriority()
    {
       //$("#flash").fadeIn(100).html('Wait <img src="img/image_process.gif" />');
       $('#myModal_view_setpriority_slider').modal();
       var info = 'action=setpriority_slider';
        $.ajax({
	   type: "POST",
	   url: "priority.php",
	   data: info,
         success: function(result){
         //$("#flash").hide();
         $('#view_setpriority_slider').html(result);
         return false;

          }
        });
     return false;

 }

function save_slider_image(saction){
$(".has-error").html('');
var ventryid = $('#ventryid').val();
var imageval=$("#photoimg").val();
$('#saveSlider').attr('disabled',true);
if(imageval=='')
 {
       alert("please select a image?");
       return false;
 }
var hostName=$("#host_url").val();
var imgUrls=$("#img_urls").val();
var category_id=$("#category_value").val();
var tagentry = $('#tagentry').val();
var slider_msg=$("#slider_msg").val();
$("#saving_loader").show();
$("#saving_loader").fadeIn(500).html('Saving..... <img src="img/image_process.gif" />');
//var dataString ='action='+saction+'&ventryid='+ventryid+'&host_url='+hostName+'&imgUrls='+imgUrls+"&imageName="+imageval+"&slidertype="+slidertype+"&slider_msg="+slider_msg;
//alert("dataString"+dataString);
        var apiBody = new FormData();
        apiBody.append("ventryid",ventryid);
        apiBody.append("host_url",hostName);
        apiBody.append("imgUrls",imgUrls);
        apiBody.append("imageName",imageval);
        apiBody.append("category_id",category_id);
        apiBody.append("tagentry",tagentry);
        apiBody.append("slider_msg",slider_msg);
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
                 window.location="slider-images.php";
                }
                if(re==2){
                $('#LegalModal').modal('show');
                $('#preview_s').css("color", "red").html('image Not saved successfully. please try again.');
                }
               if(re==3)
               {
                    $('#LegalModal').modal('show');
                    var mess="EntryID not valid.please enter valid EntryID.";
                    $("#ventryid-error").html(mess);
                    $("#saving_loader").hide();
                    $('#saveSlider').attr('disabled',false);
                    return false;
                 }
               if(re==4)
               {
                    $('#LegalModal').modal('show');
                    var mess="EntryID is <b>inactive</b>. please actvie a video then save a slider image.";
                    $("#ventryid-error").html(mess);
                    $("#saving_loader").hide();
                    $('#saveSlider').attr('disabled',false);
                    return false;
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
function act_dect_slider(slideid){
var img_status=document.getElementById('act_deact_status'+slideid).value;
var video_entry_id=document.getElementById('video_entry_id'+slideid).value;
/*if(video_entry_id=='')
{
    alert("please update Video entryID then image is Active.");
    return false;
}*/
var msg = (img_status == 1) ? "inactive":"active";
var c=confirm("Are you sure you want to "+msg+ " This?")
if(c)
{
 $.ajax({
   type: "POST",
   url: "core_active_deactive.php",
   data:'slideid='+slideid+'&img_status='+img_status+'&action=slider_image',
   success: function(reslide){
      /*if(reslide==3)
       {
            var mess="EntryID not valid.please enter valid EntryID.";
            alert(mess);
            return false;
         }
       if(reslide==4)
       {
            var mess="EntryID is <b>inactive</b>. please actvie a video then save a slider image.";
            alert(mess);
            return false;
       }*/
          if(reslide==0)
   	   {
   	     var img_status=document.getElementById('getstatus'+slideid).innerHTML="<span class='label label-danger'>inactive</span>";
   	     $('#icon_status'+slideid).removeClass('fa-check-square-o').addClass('fa-ban');
   	   }
   	   if(reslide==1)
   	   {
   	   	var img_status=document.getElementById('getstatus'+slideid).innerHTML="<span class='label label-success'>active</span>";
   	   	$('#icon_status'+slideid).removeClass('fa-ban').addClass('fa-check-square-o');
   	   }
           $('#act_deact_status'+slideid).val(reslide);



     }

   });
 }

}

</script>
</body>
</html>
