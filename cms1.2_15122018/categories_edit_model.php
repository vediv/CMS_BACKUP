<?php
include_once 'corefunction.php';
//include_once("config.php");
$Entryid=$_REQUEST['Entryid'];
$getpageindex=$_REQUEST['pageindex'];
$limitval=$_REQUEST['limitval'];
$useridd=DASHBOARD_USER_ID;
$entryId = $Entryid;   
$s="SELECT c.cat_name,c.parent_id,c.description,c.tags,cti.t_mediam_url,cti.i_small_url,cti.host_url_thumb,cti.host_url_icon FROM categories as c 
LEFT JOIN category_thumb_icon_url as cti ON c.category_id=cti.category_id  WHERE c.category_id='$entryId'";
$que = db_select($conn,$s);
$name=$que[0]['cat_name'];  $description=$que[0]['description'];  $tags=$que[0]['tags']; $parent_id=$que[0]['parent_id'];
$t_mediam_url=$que[0]['t_mediam_url'];  $i_small_url=$que[0]['i_small_url'];  
$host_url_thumb1=$que[0]['host_url_thumb'];
 if (preg_match('/http:/',$host_url_thumb1))
           $host_url_thumb=$host_url_thumb1;
       else $host_url_thumb="http://".$host_url_thumb1; 	
  $host_url_icon1=$que[0]['host_url_icon'];
	   if (preg_match('/http:/',$host_url_icon1))
           $host_url_icon=$host_url_icon1;
       else $host_url_icon="http://".$host_url_icon1; 	

$GetChaild="select count(category_id) as totalsub from  categories where parent_id='".$Entryid."' and status!='3'";
$fet = db_select($conn,$GetChaild);
$totalsub=$fet[0]['totalsub'];

?>
<style type="text/css">
.preview
{ width:200px;border:solid 1px #dedede; }
</style>
<link href="dist/css/custom.css" rel="stylesheet" type="text/css" />
<script src="dist/jquery.tagsinput/src/jquery.tagsinput.js" type="text/javascript"></script>
<script src="dist/js/custom.js" type="text/javascript"></script>
<script type="text/javascript" >
 $(document).ready(function() {
 	//$('#photoimg').live('change', function()			{ 
     $('#photoimg_edit').on('change', function() {
     $("#preview_edit").html('Uploading.... <img src="img/image_process.gif" alt="Uploading...."/>');
     var publisher_unique_id="<?php echo $publisher_unique_id ?>";
     var apiURL="<?php  echo $apiURL."/upload" ?>";
     var apiBody = new FormData($('#imageform_edit')[0]);
     apiBody.append("partnerid",publisher_unique_id);
     apiBody.append("tag","upload_thumb");
     apiBody.append("fileAction","image");
     apiBody.append('data', $('#photoimg_edit')[0].files[0]);
     $.ajax({
                url:apiURL,
                method: 'POST',
                dataType: 'json', 
                data:apiBody,
                processData: false,
                contentType: false,
                success: function(jsonResult){
                //var len=jsonResult.image_url.length; 
                var HOST_original=jsonResult.image_url[0].HOST_original
                var URL_original=jsonResult.image_url[0].URL_original; 
                var URL_320=jsonResult.image_url[1].URL_320; 
                var URL_380=jsonResult.image_url[2].URL_380; 
                var URL_480=jsonResult.image_url[3].URL_480; 
                var URL_720=jsonResult.image_url[4].URL_720; 
                var fulldata=URL_original+","+URL_320+","+URL_380+","+URL_480+","+URL_720;
                var imgShow=HOST_original+URL_original;
                //console.log(fulldata+"---"+HOST_original);
                $("#host_url_t_edit").val(HOST_original);
                $("#img_urls_t_edit").val(fulldata);
                
                setTimeout(function() {var imgPrev='<img src="'+imgShow+'" class="preview">';
                document.getElementById('preview_edit').innerHTML=imgPrev; }, 10000);
        
                //var imgPrev='<img src="'+imgShow+'" class="preview">';
                //document.getElementById('preview_edit').innerHTML=imgPrev;       
                }
            });	 	
     
     });

$('#photoimg_edit_icon').on('change', function() {
$("#preview_i_edit").html('Uploading.... <img src="img/image_process.gif" alt="Uploading...."/>');
     var publisher_unique_id="<?php echo $publisher_unique_id ?>";
     var apiURL="<?php  echo $apiURL."/upload" ?>";
     var apiBody = new FormData($('#imageform_i_edit')[0]);
     apiBody.append("partnerid",publisher_unique_id);
     apiBody.append("tag","upload_icon");
     apiBody.append("fileAction","image");
     apiBody.append('data',$('#photoimg_edit_icon')[0].files[0]);
     $.ajax({
                url:apiURL,
                method: 'POST',
                dataType: 'json', 
                data:apiBody,
                processData: false,
                contentType: false,
                success: function(jsonResult){
                //var len=jsonResult.image_url.length; 
                var HOST_original=jsonResult.image_url[0].HOST_original
                var URL_original=jsonResult.image_url[0].URL_original; 
                var URL_50=jsonResult.image_url[1].URL_50; 
                var URL_100=jsonResult.image_url[2].URL_100; 
                var URL_200=jsonResult.image_url[3].URL_200; 
                var URL_300=jsonResult.image_url[4].URL_300; 
                var fulldata=URL_original+","+URL_50+","+URL_100+","+URL_200+","+URL_300;
                var imgShow=HOST_original+URL_original;
                console.log(fulldata+"---"+HOST_original);
                $("#host_url_i_edit").val(HOST_original);
                $("#img_urls_i_edit").val(fulldata);
                //var imgPrev='<img src="'+imgShow+'" class="preview">';
                //document.getElementById('preview_i_edit').innerHTML=imgPrev;
                 setTimeout(function() {var imgPrev='<img src="'+imgShow+'" class="preview">';
                document.getElementById('preview_i_edit').innerHTML=imgPrev; }, 10000);
                
                
                    }
            });	    
        
		
			});

			
        }); 
</script>
<div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit Category - <?php echo $name; ?></h4>
</div>
 <div id="saved_result" align="center" style="color: red;"></div>   
 <div class="modal-body" style="min-height: 400px !important;" >
        <div class="tabbable tabs-left">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#a" data-toggle="tab">Metadata</a></li>
         <?php if($totalsub>0) { ?> <li><a href="#c" data-toggle="tab">Sub Category</a></li> <?php } ?>
         <?php  if(in_array(21, $otherPermission)){ ?> 
         <li><a href="#b" data-toggle="tab">Thumbnail & Icon</a></li>
         <?Php } ?>
        </ul>
       
<div class="tab-content">
         <div class="tab-pane active" id="a">
          <div class="row" style="border: 0px solid red;">
           
       <div style=" border:1px solid #c7d1dd;  border-top: 0 none !important;margin-left: 15px; padding: 28px; width: 870px;">
           <form class="form-horizontal" method="post">
          	<div class="form-group">
            <label for="inputEmail" class="control-label col-xs-4">Category ID :</label>
            <div class="col-xs-5">
                 <input type="text" class="form-control" id="catid" readonly  value="<?php echo $entryId;?>">
            </div>
        </div>  
          	
        <div class="form-group"> 
            <label for="inputEmail" class="control-label col-xs-4">Name :</label>
            <div class="col-xs-5">
                 <input type="text" class="form-control" id="entryname" placeholder="Entry Name" value="<?php echo  ($name); ?>">
            </div>
        </div>
       
         <div class="form-group">
            <label for="inputPassword" class="control-label col-xs-4">Description:</label>
            <div class="col-xs-5">
            <textarea class="form-control" rows="3" size="100" id="entrydescription" style="resize: none; width:100%;" name="entrydescription" placeholder="Description" ><?php  echo $description; ?></textarea>
            </div>
        </div>
         <div class="form-group">
            <label for="tags_1" class="control-label col-xs-4">Tags:</label> 
            <div class="col-xs-5">
             <input id="tags_1" type="text" class="tags form-control"  name="tags_1" value="<?php echo $tags; ?>"  placeholder="Enter tags :eg red,green,blue" />
             <div id="suggestions-container"></div>
            
            </div>
        </div>
       
       <div class="form-group">
            <div class="col-xs-offset-4 col-xs-8">
                <button type="button" class="btn btn-primary" class="save_close"  <?php  echo in_array(1, $UserRight)? "":"disabled"; ?> data-dismiss="modal1" name="submit"  id="myFormSubmit" onclick="save_category_in_server('saveandclose_category')" >Save & Close</button>
            <button type="button" class="btn btn-primary" class="save_close"  <?php  echo in_array(1, $UserRight)? "":"disabled"; ?> onclick="save_category_in_server('onlysavecat')" name="submit1"  id="myFormSubmit1" >Save</button>
            <span id="saving_loader"></span>
            </div>
      </div>
</form></div>
</div>	
</div>
<?php if($totalsub>0) { ?>     
<div class="tab-pane" id="c">
       
        <table id="example1" class="table table-bordered" style="margin-top: 10px;">
        <thead>
              <tr>
                <th>Category-ID</th> <th>Category Name</th>
              </tr>
       </thead>
        <tbody> 
<?php
$GetChaild1="select category_id,cat_name from categories where parent_id='".$Entryid."' and status!='3'";
$rr = db_select($conn,$GetChaild1);
foreach($rr as $fetch)
 {
  $categoryid=$fetch['category_id'];  $cat_name=$fetch['cat_name'];
 ?>
<tr>
<td><?php echo ($categoryid); ?></td>
<td><?php echo $cat_name ;?></td>
 </tr>
<?php } ?>
    </tbody>                  
        </table>     
    </div>   
 <?php } ?>   

<div class="tab-pane" id="b">
	<hr/>
<div class="row">

	<div class="col-md-6" style="border: 0px solid blue;">
		Thumb image: <img width="50%" class="img-responsive customer-img"  src="<?php echo $host_url_thumb.$t_mediam_url; ?>"  alt="" /></div>
	<div class="col-md-6" style="border:0px solid blue;">
		Icon Image:<img style="background-color: black" class="img-responsive customer-img"  src="<?php echo $host_url_icon.$i_small_url; ?>" alt="" /></div>
	
</div>	

<hr/>
<div class="row" style="border: 0px solid red;">

        <div class="col-md-6" style="border: 0px solid blue;">
         <div class="form-group" style="display: inline-flex">
            <label for="inputPassword" class="control-label ">Thumbnail Image:</label>
           <div class="col-xs-8">
            <form id="imageform_edit" method="post" enctype="multipart/form-data"  class="form-horizontal">
           
              <div class="form-group col-sm-4 col-md-4 col-lg-4"  style="margin-left: 1px; margin-top: 1px">
               <input type="file" class="inputFile" name="photoimg_edit" id="photoimg_edit" placeholder="select a File" >  </div>
            <div align="left" class="col-lg-12 col-md-6 col-sm-6" style="border: 0px solid blue; ">
                <input name="host_url_t_edit" id="host_url_t_edit"  type="hidden" class="inputFile" />
                   <input name="img_urls_t_edit" id="img_urls_t_edit"  type="hidden" class="inputFile" /> 
               <div class="row">
                     <div class="col-lg-6 col-md-6 col-sm-6" id="preview_edit">
                     
                </div></div>
              </div>
             </form>  
          
        </div>
                  </div>
        </div>
        <div class="col-md-6" style="border: 0px solid blue;">
             <div class="form-group"  style="display: inline-flex">
         <form id="imageform_i_edit" method="post" enctype="multipart/form-data"  class="form-horizontal">
                    <div class="col-lg-4 col-md-4">
                    <label for="inputPassword" class="control-label">Icon Image:</label>
                    </div>
            <div class="col-xs-8">
              <div class="form-group col-sm-4 col-md-4 col-lg-4" style="margin-top: 1px">
               <input type="file" class="inputFile" name="photoimg_edit_icon" id="photoimg_edit_icon" placeholder="select a File"  ></div>
                <div class="col-lg-12 col-md-6 col-sm-6" style="border: 0px solid blue;">
                <input name="host_url_i_edit" id="host_url_i_edit"  type="hidden" class="inputFile" />
                   <input name="img_urls_i_edit" id="img_urls_i_edit"  type="hidden" class="inputFile" />       
               <div class="row">
                   <div class="col-lg-12 col-md-6 col-sm-6" id="preview_i_edit" ></div>
               </div>
               </div>
             </div>   
            </form>
              
        </div>
        
        </div>
  
	
	
</div>
<div class="row" >
 <div class="col-md-5" style="border: 0px solid red; margin-top: 10px;">
 <button type="button" class="btn btn-primary " <?php echo in_array(1, $UserRight)?'':'disabled'; ?> data-dismiss="modal1" name="submit"  id="save_thumb_icon" onclick="edit_category_thumb('save_thumb_icon');" >Save & Close</button>
 <span id="saving_loader1"></span> 
</div>
   
</div>

</div>
      </div>  
      </div>
</div>          
<script type="text/javascript">
function save_category_in_server(caction){  
   var catid = $('#catid').val();
    var entryname =$('#entryname').val();
    //alert(cname);
    var cat_name = $('#entryname').val();
     if (cat_name=='')
       {
    	    alert("Name must be filled out.");
    	    document.getElementById("entryname").focus();
    	    return false; 
       }
    var entrydesc = $('#entrydescription').val();	
    var entrytags = $('#tags_1').val();
    var pageindex = <?php echo $getpageindex;  ?>;
    var limitval = "<?php echo $limitval;  ?>";
    
    var save_edit_category="save_edit_category";
    var dataString ='categoryaction='+save_edit_category+'&catid='+catid+'&entryname='+entryname+'&entrydesc='+entrydesc+'&entrytags='+entrytags+'&pageindex='+pageindex+'&limitval='+limitval;
   if(caction=='onlysavecat')
   {
        $("#saved_result").show();
        //$("#saved_result").fadeIn(800).html('Saving Detail... <img src="img/image_process.gif" />');
         $('#myFormSubmit').attr('disabled',true);
         $('#myFormSubmit1').attr('disabled',true);
         $("#saving_loader").show();
         $("#saving_loader").fadeIn(500).html('Saving..... <img src="img/image_process.gif" />');
        $.ajax({
             type: "POST",
             url: "category_paging.php",
             data: dataString,
             cache: false,
             success: function(result){
             $("#saved_result").html('Save data Successfully..');
             $('#myFormSubmit').attr('disabled',false);
             $('#myFormSubmit1').attr('disabled',false);
             $("#saving_loader").hide();
             }
         });    
   
   }
   
   if(caction=='saveandclose_category')
   {
   	 $('#myFormSubmit').attr('disabled',true);
         $('#myFormSubmit1').attr('disabled',true);
         $("#saving_loader").show();
         $("#saving_loader").fadeIn(500).html('Saving..... <img src="img/image_process.gif" />');
         $.ajax({
          type: "POST",
          url: "category_paging.php",
          data: dataString,
          cache: false,
           success: function(result){
              $("#results").html(''); 
              $('#myModal_category_view').modal('hide');
              $("#msg").html('Save data Successfully');
              $("#results").html(result);
           }
    }); 
     
    }   
}

function edit_category_thumb(save_thumb_icon){  
    var catid = <?php echo $entryId; ?>;
    var pageindex = <?php echo $getpageindex;  ?>;
    var limitval = "<?php echo $limitval;  ?>";
    var host_url_t_edit=$("#host_url_t_edit").val();
    var img_urls_t_edit=$("#img_urls_t_edit").val(); 
    var host_url_i_edit=$("#host_url_i_edit").val();
    var img_urls_i_edit=$("#img_urls_i_edit").val(); 
    var dataString ='categoryaction='+save_thumb_icon+'&catid='+catid+'&pageindex='+pageindex+'&host_url_t_edit='+host_url_t_edit+'&img_urls_t_edit='+img_urls_t_edit+'&host_url_i_edit='+host_url_i_edit+'&img_urls_i_edit='+img_urls_i_edit+'&limitval='+limitval;
         $('#save_thumb_icon').attr('disabled',true);
         $("#saving_loader1").show();
         $("#saving_loader1").fadeIn(500).html('Saving..... <img src="img/image_process.gif" />');
          $.ajax({
           type: "POST",
           url: "category_paging.php",
           data: dataString,
           cache: false,
            success: function(result){
              $("#results").html(''); 
              $('#myModal_category_view').modal('hide');
              $("#msg").html('Save data Successfully');
              $("#results").html(result);
           }
    });    
}

function delete_temp_img_when_edit(imgname,publisherid,type){   
  if(type=='T')
  {var ac='delete_tmp_thumb'; var msg="Thumb";  var preview_id="preview_edit"; var filesID="photoimg_edit"; }
  if(type=='I')
  {var ac='delete_tmp_icon'; var msg="Icon";  var preview_id="preview_i_edit"; var filesID="photoimg_edit_icon";}
  var dataString ='action='+ac+'&imgname='+imgname+'&parid='+publisherid;
  $.ajax({                                                                                                                                        
    type: "POST",
    url: "temp_thumb_icon_del.php",
    data: dataString,
    cache: false,
    success: function(result){
       if(result==1){	
       $('#myModal').modal('show');
       $('#'+filesID).val('');
       $('#'+preview_id).css("color", "red").html('image '+msg+' Delete Successfully..');
      
       }
     }
    });   
}
</script>
