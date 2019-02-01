<?php
include_once 'corefunction.php';
$action=(isset($_POST['action']))? $_POST['action']: "";
switch($action)
{
	case "save_slider":
        $ventryid = trim($_POST['ventryid']);
        if($ventryid!=''){    
            $sql="select count('$ventryid') as entryCount,video_status from entry where entryid='$ventryid' and status='2'";
            $row= db_select($conn,$sql);
            $entryCount=$row[0]['entryCount']; $video_status=$row[0]['video_status'];
            if($entryCount==0)
            {
                echo 3;
                die();
            } 
            if($entryCount==1 && $video_status=='inactive')
            {
                echo 4;
                die();
            }    
        }
        //$theme = (isset($_POST['theme']))? $_POST['theme']: "";
        $image_slider_name=(isset($_POST['imageName']))? $_POST['imageName']: "";
        $host_url = (isset($_POST['host_url']))? $_POST['host_url']: "";
        $imgUrls = (isset($_POST['imgUrls']))? $_POST['imgUrls']: "";
        $slidertype = (isset($_POST['category_id']))? $_POST['category_id']: "";
        $slidermsg = (isset($_POST['slider_msg']))? $_POST['slider_msg']: "";
        $slidermsg1=  db_quote($conn, $slidermsg);
        $f=  explode(",", $imgUrls);
        $original_slider_url=$f[0]; $small_slider_url=$f[1]; $medium_slider_url=$f[2]; 
        $large_slider_url=$f[3];$customslider_url=$f[4];
        $query = "INSERT INTO slider_image_detail(img_name,host_url,img_url,small_img_url,medium_img_url,large_img_url,custom_img_url,ventryid,img_status,priority,img_create_date,slider_category,slider_msg) 
        Select '$image_slider_name','$host_url','$original_slider_url','$small_slider_url','$medium_slider_url','$large_slider_url','$customslider_url','".trim($ventryid)."','0',ifnull(max(priority),0)+1,NOW(),'$slidertype',$slidermsg1 from slider_image_detail";
	$r=db_query($conn,$query);
        if($r)
        {
           /*----------------------------update log file begin-------------------------------------------*/
          $error_level=1;$msg="Add New Slider Image($image_slider_name)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
          $qry=$insert;
           write_log($error_level,$msg,$lusername,$qry);
          echo 1;  
         /*----------------------------update log file End---------------------------------------------*/   
        }
        else 
        {
            /*----------------------------update log file begin-------------------------------------------*/
            $error_level=5;$msg="Add New Slider Image($image_slider_name)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
            $qry=$insert;
            write_log($error_level,$msg,$lusername,$qry);
          echo 2;  
           /*----------------------------update log file End---------------------------------------------*/ 
        }
       
        break;
	
        case "delete_tmp_img":
	    $parID=$_REQUEST['parid']; $filename=$_REQUEST['imgname'];
            $path = IMG_SLIDER_PATH; // this is define in auths.php
            $orginalImg =IMG_SLIDER_PATH.$filename;         unlink($orginalImg);
            $Img_480 =IMG_SLIDER_PATH."480_".$filename;     unlink($Img_480);
            $Img_640 =IMG_SLIDER_PATH."640_".$filename;     unlink($Img_640);
            $Img_720 =IMG_SLIDER_PATH."720_".$filename;     unlink($Img_720);
            $Img_1080 =IMG_SLIDER_PATH."1080_".$filename;   unlink($Img_1080);
	    $d="delete from tmp_slider_image where par_id='$useridd' and type='S'";
	    db_query($conn,$d);
	    echo 1;
         break;
        
        case "add_new_slider_image":
        ?>   
        <div class="modal-body">
        <div class="modal-header">
                <button type="button" class="close"  onclick="CloseModal('LegalModal_add_new_slider','add_new_slider_image');">
                       <span aria-hidden="true">&times;</span>
                       <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">
                  <b>Slider Image Upload</b>
                </h4>
            </div>
             <br/>     
              <div style=" border:1px solid #c7d1dd ;">
       <form class="form-horizontal" role="form" id="formAddSliderImg" method="post" enctype="multipart/form-data">
           
            <input name="host_url" id="host_url"  type="hidden" class="inputFile" />
             <input name="img_urls" id="img_urls"  type="hidden" class="inputFile" />
               <div class="form-group" style="margin-top: 12px">
                      <label for="exampleInputFile" class="control-label col-sm-3">Select Image:</label>
                       <div class="col-sm-5">
                         <input type="file" class="inputFile" name="photoimg" id="photoimg" placeholder="select a File" >
                       		Image Size = Height Between  (900 to 1005)
                                <p>Width Between  (1800 to 2400)</p>
                                
                        </div>
                      <div class="col-lg-6 col-md-6 col-sm-6" id="preview_s"></div>                   
               </div> 
                   <div class="form-group">
                      <label class="control-label col-sm-3">Video Entry ID:</label>
                         <div class="col-sm-5">
                             <input type="text" class="form-control" maxlength="10" name="ventryid" id="ventryid">
                             <span class="help-block has-error" id="ventryid-error" style="color:red;"></span>
                        </div>
                    </div>
               <div class="form-group">
                      <label class="control-label col-sm-3">Slider Message:</label>
                         <div class="col-sm-5">
                             <textarea class="form-control" maxlength="200" placeholder="max. 200 characters" name="slider_msg" id="slider_msg"></textarea>
                        </div>
               </div>
              <div class="form-group">
            <label class="col-md-3 control-label">Select Header Menu For Slider:</label>
            <div class="col-md-9" id="getHeaderMenu"> 
              <span id="wait_loader_category"></span>
            </div>
             </div>
         </form>
         
        <div class="modal-footer">
            <div class="col-sm-offset-2 col-sm-5" style="border:px solid red;">
                <button type="button" class="btn btn-primary" disabled1 id="saveSlider"  onclick="save_slider_image('save_slider');">Save & Close</button>
             <span id="saving_loader"> </span>
             </div>
		</div>
             </div>  
			
 </div> 
<script type="text/javascript">
drawgetHeaderMenu('0');
function drawgetHeaderMenu(categoryid)
{
    $("#wait_loader_category").fadeIn(400).html('Loading... <img src="img/image_process.gif" />');
    var dataString ='action=getHeaderMenu&country_code='+categoryid;
    $.ajax({                                                                                                                                        
    type: "POST",
    url: "ajax_common.php",
    data: dataString,
    cache: false,
    success: function(r){
        if(r==0)
        {
           var msg="no header menu for slider  <a href='header_content.php'>Click Here to create header menu.</a>"; 
           $("#getHeaderMenu").html(msg);
           $('#saveSlider').attr('disabled',true);
           return false;
        }
        else{
        $("#wait_loader_category").hide(); 
        $("#getHeaderMenu").html(r); 
        } 
     }
      
    });  
}
</script>
<script type="text/javascript" src="scripts/jquery.form.js"></script>
<script type="text/javascript" >
  $(document).ready(function() { 
  $('#photoimg').on('change', function() {
  if(['image/jpeg', 'image/jpg', 'image/png', 'image/gif','image/jpeg'].indexOf($("#photoimg").get(0).files[0].type) == -1) {
        alert('Error : Only JPEG, PNG & GIF,JPEG allowed');
        $("#photoimg").val('');
        return false;
    }
       
    var apiBody1 = new FormData($('#formAddSliderImg')[0]);
    apiBody1.append('data',$('input[type=file]')[0].files[0]);
    apiBody1.append('action','slider_image');
    $.ajax({
                url:'includes/image_process.php',
                method: 'POST',
                data:apiBody1,
                processData: false,
                contentType: false,
                success: function(r){
                  if(r==1){
                      ImageProcess(); 
                  }
                  if(r==0){ alert("Error : Height Between (1800 to 2400) Width Between (900 to 1005)."); return false; }
                }
           });
    
    
    
     });

function ImageProcess(){
$("#preview_s").html('Uploading.... <img src="img/image_process.gif" alt="Uploading...."/>');
  $('#photoimg').attr('disabled',true);
  var publisher_unique_id="<?php echo $publisher_unique_id ?>";
  var apiURl="<?php  echo $apiURL."/upload" ?>";
  var apiBody = new FormData($('#formAddSliderImg')[0]);
       apiBody.append("partnerid",publisher_unique_id);
       apiBody.append("tag","upload_slider");
       apiBody.append("fileAction","image");
       apiBody.append('data', $('input[type=file]')[0].files[0]);
      $.ajax({
                url:apiURl,
                method: 'POST',
                dataType: 'json', 
                data:apiBody,
                processData: false,
                contentType: false,
                success: function(jsonResult){
                //var len=jsonResult.image_url.length; 
                var HOST_original=jsonResult.image_url[0].HOST_original
                var URL_original=jsonResult.image_url[0].URL_original; 
                var URL_480=jsonResult.image_url[1].URL_480; 
                var URL_640=jsonResult.image_url[2].URL_640; 
                var URL_720=jsonResult.image_url[3].URL_720; 
                var URL_1080=jsonResult.image_url[4].URL_1080; 
                var fulldata=URL_original+","+URL_480+","+URL_640+","+URL_720+","+URL_1080;
                var imgShow=HOST_original+URL_original;
                //console.log(fulldata+"---"+HOST_original);
                $("#host_url").val(HOST_original);
                $("#img_urls").val(fulldata);
                $('#photoimg').attr('disabled',false);
                $('#saveSlider').attr('disabled',false);
                var imgPrev='<img src="'+imgShow+'" class="preview">';
                document.getElementById('preview_s').innerHTML=imgPrev;       
                
                    }
            });	
  }
  
});  
 </script>	
      <?php   
      break;    
        case "edit_slider_image":
        ?>
     <div class="modal-body">
          <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                       <span aria-hidden="true">&times;</span>
                       <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">
                  <b>Edit Slider Image MetaData</b>
                </h4>
            </div>
             <br/>
	<div class="tab-content" id="tabs">
	<?php  
        $imgid=$_POST['imgid']; $pageindex=$_POST['pageindex']; $limitval=$_POST['limitval'];  $searchInputall=$_POST['searchInputall']; $filtervalue=$_POST['filtervalue'];   
        $query1="select  img_id,slider_category,slider_msg,ventryid from slider_image_detail where img_id='$imgid'";
        $row= db_select($conn,$query1);
        $entryid=$row[0]['ventryid'];	
        $slider_category=$row[0]['slider_category'];	
        $slider_msg=$row[0]['slider_msg']; $img_id=$row[0]['img_id']; 
        ?>
        <div style=" border:1px solid #c7d1dd ;">
        <form class="form-horizontal" role="form" action="javascript:" method="post" id="confirm" onsubmit="return save_edit_slider('<?php echo $imgid; ?>','<?php echo $pageindex;  ?>','<?php echo $limitval; ?>','<?php echo $searchInputall; ?>','<?php echo $filtervalue; ?>')">
                    <div class="form-group" style="margin-top: 12px">
                      <label class="control-label col-sm-4">Video Entry ID:</label>
                         <div class="col-sm-5">
                             <input type="text" class="form-control" maxlength="10" name="ventryid" id="ventryid" value="<?php echo $entryid; ?>">
                              <span class="help-block has-error" id="ventryid-error" style="color:red;"></span>
                        </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-sm-4">Slider Message:</label>
                         <div class="col-sm-5">
                             <textarea class="form-control" name="slider_msg" placeholder="max. 200 characters" maxlength="200" id="slider_msg"><?php echo $slider_msg;  ?></textarea>
                        </div>
                    </div>
             <div class="form-group">
                      <label class="control-label col-sm-4">Select Header Menu For Slider:</label>
                         <div class="col-sm-5" id="getHeaderMenu">
                              <span id="wait_loader_category"></span>
                        </div>
                    </div>
           
          <div class="modal-footer">
           <div style="text-align: center;"><span id="saving_loader"></span></div>
           <div style="text-align: center;">
               <button type="submit" name="img_up" id="updateSlider" class="btn btn-primary text-center" >Update</button>
           </div>
           </div>
</form>
       </div>
</div>			 	       
      </div> 
<script type="text/javascript">
drawgetHeaderMenu('<?php echo $slider_category; ?>');
function drawgetHeaderMenu(categoryid)
{
    $("#wait_loader_category").fadeIn(400).html('Loading... <img src="img/image_process.gif" />');
    var dataString ='action=getHeaderMenu&categoryid='+categoryid;
    $.ajax({                                                                                                                                        
    type: "POST",
    url: "ajax_common.php",
    data: dataString,
    cache: false,
    success: function(r){
        if(r==0)
         {
            var msg="no header menu for slider  <a href='header_content.php'>Click Here to create header menu.</a>"; 
            $("#getHeaderMenu").html(msg);
            $('#saveSlider').attr('disabled',true);
            return false;
         }
         else{
          $("#wait_loader_category").hide(); 
          $("#getHeaderMenu").html(r); 
         } 
      }
      
    });  
 }
 </script>
     <?php 
     break; 
        case "popup_images":
        ?>    
        <div class="modal-body">
        <div class="modal-header">
                <button type="button" class="close"  onclick="CloseModal('LegalModal_add_new_popup_image','add_new_popup_image');">
                       <span aria-hidden="true">&times;</span>
                       <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">
                  <b>PopUp Image Upload</b>
                </h4>
            </div>
             <br/>     
              <div style=" border:1px solid #c7d1dd ;">
       <form class="form-horizontal" role="form" id="imageform" method="post" enctype="multipart/form-data" >
           
           <input name="host_url" id="host_url"  type="hidden" class="inputFile" />
           <input name="img_urls" id="img_urls"  type="hidden" class="inputFile" />  
           <div class="form-group" style="margin-top: 12px">
                      <label for="exampleInputFile" class="control-label col-sm-3">Select Image:</label>
                       <div class="col-sm-7">
                         <input type="file" class="inputFile" name="photoimg" id="photoimg" placeholder="select a File" >
                       	 Note: image Height between  1024 to 1280 pixels.<br/> image width between  650 to 780 pixels
                        </div>
               </div>
          <div class="form-group" style="margin-top: 12px">
              <div class="row col-sm-7" id="preview_popimg" style="margin-left: 20px; margin-right: 20px;"></div> 
          </div>    
            <div class="form-group">
                      <label class="control-label col-sm-3">Image Title:</label>
                         <div class="col-sm-5">
                             <input type="text" class="form-control" maxlength="50" name="image_title" id="image_title">
                             <span class="help-block has-error" id="image_title-error" style="color:red;"></span>
                         </div>
             </div>   
         </form>
         
        <div class="modal-footer">
            <div class="col-sm-offset-2 col-sm-5" style="border:px solid red;">
                <button type="button" class="btn btn-primary" disabled id="saveSlider"  onclick="save_popup_image('save_popup');">Save & Close</button>
             <span id="saving_loader"> </span>
             </div>
		</div>
             </div>  
			
 </div> 

<script type="text/javascript" src="scripts/jquery.form.js"></script>
<script type="text/javascript" >
  $(document).ready(function() { 
  $('#photoimg').on('change', function() {
  if(['image/jpeg', 'image/jpg', 'image/png', 'image/gif','image/jpeg'].indexOf($("#photoimg").get(0).files[0].type) == -1) {
        alert('Error : Only JPEG, PNG & GIF,JPEG allowed');
        $("#photoimg").val('');
        return false;
    }
   var apiBody1 = new FormData($('#imageform')[0]);
   apiBody1.append('data',$('input[type=file]')[0].files[0]); 
   apiBody1.append('action','image_popup');
    $.ajax({
                url:'includes/image_process.php',
                method: 'POST',
                data:apiBody1,
                processData: false,
                contentType: false,
                success: function(r){
                  if(r==1){
                       //ImageProcess(); 
                  }
                  if(r==0){ alert("Error : image Height between  1024 to 1280 pixels.\n image width between  650 to 780 pixels"); return false; }
                }
           });
  
  });
  
function ImageProcess(){
  $("#preview_popimg").html('Uploading.... <img src="img/image_process.gif" alt="Uploading...."/>');
  $('#photoimg').attr('disabled',true);
  var publisher_unique_id="<?php echo $publisher_unique_id ?>";
  var apiURl="<?php  echo $apiURL."/popup_image" ?>";
  var apiBody = new FormData($('#imageform')[0]);
  apiBody.append("partnerid",publisher_unique_id);
  apiBody.append('data', $('input[type=file]')[0].files[0]);
  $.ajax({
                url:apiURl,
                method: 'POST',
                dataType: 'json', 
                data:apiBody,
                processData: false,
                contentType: false,
                success: function(jsonResult){
                setTimeout(function(){ 
                var status=jsonResult.status;
                if(status=="1")
                {
                var hostUrl=jsonResult.image_url;
                var imgUrl=jsonResult.image_path;
                var imgShow=hostUrl+imgUrl;
                $("#host_url").val(hostUrl);
                $("#img_urls").val(imgUrl);
                $('#photoimg').attr('disabled',false);
                $('#saveSlider').attr('disabled',false);
                $('#photoimg').val('');
                var imgPrev='<img src="'+imgShow+'" class="preview">';
                document.getElementById('preview_popimg').innerHTML=imgPrev;
                } 
                       }, 8000);
                    }
            });	
      }      
  
 }); 
 </script>	
       <?php 
        break;
        case "save_popup":
        $host_url = (isset($_POST['host_url']))? $_POST['host_url']: "";
        $imgUrls = (isset($_POST['imgUrls']))? $_POST['imgUrls']: ""; 
        $image_title = (isset($_POST['image_title']))? $_POST['image_title']: "";
        $image_title_n=db_quote($conn, $image_title);
        $image_Url = explode('/',$imgUrls);
        $image_pop_name = end($image_Url);
        $query = "INSERT INTO popup_images(img_name,image_title,host_url,img_url,img_status,added_date)
        values('$image_pop_name',$image_title_n,'$host_url','$imgUrls','0',NOW()) ";
        $r=db_query($conn,$query);
        if($r)
        {
           /*----------------------------update log file begin-------------------------------------------*/
          $error_level=1;$msg="Add New PopUP Image($image_pop_name)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
          $qry=$query;
           write_log($error_level,$msg,$lusername,$qry);
          echo 1;  
         /*----------------------------update log file End---------------------------------------------*/   
        }
        else 
        {
            /*----------------------------update log file begin-------------------------------------------*/
            $error_level=5;$msg="Add New PopUP Image($image_pop_name)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
            $qry=$query;
            write_log($error_level,$msg,$lusername,$qry);
          echo 2;  
           /*----------------------------update log file End---------------------------------------------*/ 
        }
         break;   
       }
   
?>
