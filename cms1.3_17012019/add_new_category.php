<?php
include_once 'corefunction.php';
//include_once("config.php");
?>
<script type="text/javascript" src="scripts/jquery.form.js"></script>
<script type="text/javascript" >
 $(document).ready(function() {
     $('#photoimg').on('change',function() {
     $("#preview_t").html('');
     $("#preview_t").html('Uploading.... <img src="img/image_process.gif" alt="Uploading...."/>');
     var publisher_unique_id="<?php echo $publisher_unique_id ?>";
     var apiURL="<?php  echo $apiURL."/upload" ?>";
     var apiBody = new FormData($('#imageform')[0]);
     apiBody.append("partnerid",publisher_unique_id);
     apiBody.append("tag","upload_thumb");
     apiBody.append("fileAction","image");
     apiBody.append('data', $('#photoimg')[0].files[0]);
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
                $("#host_url_t").val(HOST_original);
                $("#img_urls_t").val(fulldata);
                var imgPrev='<img src="'+imgShow+'" class="preview">';
                document.getElementById('preview_t').innerHTML=imgPrev;
                    }
            });

     });
     $('#photoimg1').on('change', function() {
     $("#preview_i").html('');
     $("#preview_i").html('Uploading.... <img src="img/image_process.gif" alt="Uploading...."/>');
     var publisher_unique_id="<?php echo $publisher_unique_id ?>";
     var apiURL="<?php  echo $apiURL."/upload" ?>";
     var apiBody = new FormData($('#imageform_i')[0]);
     apiBody.append("partnerid",publisher_unique_id);
     apiBody.append("tag","upload_icon");
     apiBody.append("fileAction","image");
     apiBody.append('data',$('#photoimg1')[0].files[0]);
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
                $("#host_url_i").val(HOST_original);
                $("#img_urls_i").val(fulldata);
                var imgPrev='<img src="'+imgShow+'" class="preview">';
                document.getElementById('preview_i').innerHTML=imgPrev;
                    }
            });



     });
 });
 function checkInput(){
 var x= document.getElementById("cat_name").value.replace(/[^a-z0-9\s]/gi, '').replace(/\s+/g, '').toLowerCase();
 document.getElementById("cat_alias").value=x;
 }
</script>

<div class="modal-header">
          <button type="button" class="close"  data-dismiss="modal" onclick="CloseCategoryModal();">&times;</button>
          <h4 class="modal-title">Add New Category</h4>
</div>
<div class="modal-body" style="border:0px solid red;">
<div class="row" style="border: 0px solid red;">
       <?php  if(in_array(21, $otherPermission)){ ?>
        <div class="col-md-6" style="border: 0px solid blue;">
         <div class="form-group" style="display: inline-flex">
            <label for="inputPassword" class="control-label ">Thumbnail Image:</label>
           <div class="col-xs-8">
            <form id="imageform" method="post" enctype="multipart/form-data"  class="form-horizontal">

              <div class="form-group col-sm-4 col-md-4 col-lg-4"  style="margin-left: 1px; margin-top: 1px">
               <input type="file" class="inputFile" name="photoimg" id="photoimg" placeholder="select a File" >  </div>
            <div align="left" class="col-lg-12 col-md-6 col-sm-6" style="border: 0px solid blue; ">
               <div class="row">
                   <input name="host_url_t" id="host_url_t"  type="hidden" class="inputFile" />
                   <input name="img_urls_t" id="img_urls_t"  type="hidden" class="inputFile" />
                     <div class="col-lg-6 col-md-6 col-sm-6" id="preview_t">
                </div></div>
              </div>
             </form>
        </div>
                  </div>
        </div>
       <?php }
        if(in_array(22, $otherPermission)){ ?>
        <div class="col-md-6" style="border: 0px solid blue;">
             <div class="form-group"  style="display: inline-flex">
            <form id="imageform_i" method="post" enctype="multipart/form-data"  class="form-horizontal">
                  <div class="col-lg-4 col-md-4">
            <label for="inputPassword" class="control-label">Icon Image:</label>
            </div>
            <div class="col-xs-8">
              <div class="form-group col-sm-4 col-md-4 col-lg-4" style="margin-top: 1px">
               <input type="file" class="inputFile" name="photoimg1" id="photoimg1" placeholder="select a File"  ></div>
                <div class="col-lg-12 col-md-6 col-sm-6" style="border: 0px solid blue;">
               <div class="row">
                   <input name="host_url_i" id="host_url_i"  type="hidden" class="inputFile" />
                   <input name="img_urls_i" id="img_urls_i"  type="hidden" class="inputFile" />
                   <div class="col-lg-12 col-md-6 col-sm-6" id="preview_i" >
                </div>
               </div>
               </div>
            </div>
            </form>

              </div>
        </div>
        <?php } ?>

        </div>

<div style=" border:1px solid #c7d1dd ; margin: 12px;" >
<form id="myform" method="post" class="form-horizontal"  style="border:0px solid #c7d1dd;">
<div class="form-group" style="padding-top: 12px">
<label for="inputPassword" class="control-label col-xs-2">Categories *:</label>
<div class="col-xs-8">
<div class="container1">
<div class="row"><div class="col-md-12" id="showCategory"><span id="wait_loader"></span></div></div>
</div>
  </div>
     </div>

       <div class="form-group">
            <label for="inputEmail" class="control-label col-xs-2">Name *:</label>
            <div class="col-xs-8">
                 <input type="text" class="form-control" id="cat_name" name="cat_name" placeholder="Entry Name" size="100" onkeyup="checkInput()">

            </div>
        </div>
        <div class="form-group">
             <label for="inputEmail" class="control-label col-xs-2">Short Name :</label>
             <div class="col-xs-4">
                  <input type="text" class="form-control" id="cat_alias" name="cat_alias"  disabled placeholder="Category Alias/ Short Name" size="100">
             </div>
              <div class="col-xs-4"><b>Category Type:</b>
                <select id="tag_name"  style="" onchange="" >
                    <option value="N" >Normal Category</option>
                    <option value="WS">Web Series Category</option>
                    <option value="S">Seasons Category</option>
                    </select>
              </div>
              </div>
         <div class="form-group">
            <label for="inputPassword" class="control-label col-xs-2">Description:</label>
            <div class="col-xs-8">
                <textarea class="form-control" rows="1" id="cat_description" style="resize: none;" name="cat_description" placeholder="Description"  size="100" ></textarea>
            </div>
        </div>
         <div class="form-group">
            <label for="tags_1" class="control-label col-xs-2">Tags:</label>
            <div class="col-xs-8" id="drawTags">
                <span id="wait_loader_tags"></span>
            </div>
         </div>
      <div class="form-group">
    <div class="col-xs-offset-2 col-xs-10"  style="border:0px solid red;">
        <button type="button" class="btn btn-primary" disabled id="save_button"  onclick="save_add_category('add_category');">Save & Close</button>
        <span id="saving_loader"></span>
    </div>
 </div>
</form>
 <br/>
 </div>

</div>
<script type="text/javascript">

drawCateory();
function drawCateory()
{
    $("#wait_loader").fadeIn(400).html('Loading... <img src="img/image_process.gif" />');
    var dataString ='action=category_in_add_new_catgory';
    $.ajax({
    type: "POST",
    url: "ajax_common.php",
    data: dataString,
    cache: false,
    success: function(r){
      $("#wait_loader").hide(); $("#showCategory").html(r);
      drawTags();
      }

    });
}
function drawTags()
{
    $("#wait_loader_tags").fadeIn(400).html('Loading... <img src="img/image_process.gif" />');
    var dataString ='action=tags_in_add_new_category';
    $.ajax({
    type: "POST",
    url: "ajax_common.php",
    data: dataString,
    cache: false,
    success: function(result){
        $("#wait_loader_tags").hide();
         $("#drawTags").html(result);
         $('#save_button').attr('disabled',false);
     }
    });
}

function save_add_category(cat_action){
    var category_value = $('input[name=category_value]:checked', '#myform').val()
     if (!category_value ) {
    	   alert("please select atleast one category.");
    	   return false;
     }
    var cat_name = $('#cat_name').val();
    if(cat_name=='')
    {
    	    alert("Name must be filled out.");
    	    document.getElementById("cat_name").focus();
    	    return false;
    }
    var subCatFlag="0";
    var dataString ='categoryaction=checkSubcategory&category_ID='+category_value;
    return false;
    $.ajax({
    type: "POST",
    url: "category_paging.php",
    data: dataString,
    cache: false,
    success: function(r){
        if(r==1)
        {
          var a=confirm("Note: this category have video entry \n if you want to create new category then move video entry in other category.");
          if(a) {
             subCatFlag="1";
          }
          else {
             alert("No action taken"); return false;
          }
        }
        if(r==0)
        {
           subCatFlag="1";
        }
        if(subCatFlag=="1")
            {
                $('#save_button').attr('disabled',true);
                $("#saving_loader").show();
                $("#saving_loader").fadeIn(500).html('Saving..... <img src="img/image_process.gif" />');
                var cat_description = $('#cat_description').val();
                var cat_tags = $('#tags_1').val();
                var hostName_t=$("#host_url_t").val();
                var imgUrls_t=$("#img_urls_t").val();
                var hostName_i=$("#host_url_i").val();
                var imgUrls_i=$("#img_urls_i").val();
                var dataString ='categoryaction='+cat_action+'&category_ID='+category_value+'&cat_name='+cat_name+'&cat_description='+cat_description+'&cat_tags='+cat_tags+'&host_url_t='+hostName_t+'&imgUrls_t='+imgUrls_t+'&host_url_i='+hostName_i+'&imgUrls_i='+imgUrls_i;
                $.ajax({
                type: "POST",
                url: "category_paging.php",
                data: dataString,
                cache: false,
                success: function(result){
                   $('#LegalModal').modal('hide');
                   window.location="category_content.php";
                 }
                });
           }

     }
    });


}

function delete_temp_img(imgname,publisherid,type){
  if(type=='T')
  {var ac='delete_tmp_thumb'; var msg="Thumbnail";  var preview_id="preview_t"; var filesID="photoimg";}
  if(type=='I')
  {var ac='delete_tmp_icon'; var msg="Icon";  var preview_id="preview_i"; var filesID="photoimg1";}
  var dataString ='action='+ac+'&imgname='+imgname+'&parid='+publisherid;
  //alert("dataString="+dataString);
  var a=confirm("Are you Sure want to delete This " +msg+ " Image ?");
   if(a)
   {
        $.ajax({
          type: "POST",
          url: "temp_thumb_icon_del.php",
          data: dataString,
          cache: false,
          success: function(result){
             if(result==1){
             $('#LegalModal').modal('show');
             $('#'+filesID).val('');
             $('#'+preview_id).css("color", "red").html('image ' +msg+ ' Delete Successfully..');

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
