<?php
include_once 'corefunction.php';
$userName=DASHBOARD_USER_NAME;  
$userID=$get_user_id; // This path define in corefunction.php
$target_path = TEMP_VIDEO_UPLOAD_PATH."$userID/";  
?>
<link rel="stylesheet" href="upload_css/jquery.fileupload.css">
<link rel="stylesheet" href="upload_css/jquery.fileupload-ui.css">
<script src="js/jquery.blockUI.js"></script>   
<script type="text/javascript">
    $(document).ready(function(){
    $('.btn-toggle').click(function() {
    $(this).find('.btn').toggleClass('active');  
    
    if ($(this).find('.btn-primary').size()>0) {
    	$(this).find('.btn').toggleClass('btn-primary');
    }
    if ($(this).find('.btn-danger').size()>0) {
    	$(this).find('.btn').toggleClass('btn-danger');
    }
    if ($(this).find('.btn-success').size()>0) {
    	$(this).find('.btn').toggleClass('btn-success');
    }
    if ($(this).find('.btn-info').size()>0) {
    	$(this).find('.btn').toggleClass('btn-info');
    }
    
    $(this).find('.btn').toggleClass('btn-default');
       
});

});
</script>
    <!-- The file upload form used as target for the file upload widget -->
    <div style=" border:1px solid #c7d1dd ;">
    <form id="fileupload" action="" method="POST" enctype="multipart/form-data" style="padding-top: 23px; padding-left: 9px">
        <!-- Redirect browsers with JavaScript disabled to the origin page -->
        <noscript><input type="hidden" name="redirect" value=""></noscript>
        <div class="row fileupload-buttonbar">
        <div class="col-md-1">
               <!-- <input type="checkbox" class="toggle" style="padding-right: 20px">-->
               
                <span class="fileupload-process"></span>
            </div>
            <div class="col-md-7">
                <!-- The fileinput-button span is used to style the file input field as button -->
                <span class="btn btn-success fileinput-button">
                    <i class="glyphicon glyphicon-plus"></i>
                    <span>Select files...</span>
                    <input type="file" name="files" id="selectFile" >
                </span>
                <button type="submit" class="btn btn-primary start">
                    <i class="glyphicon glyphicon-upload"></i>
                    <span>Start upload</span>
                </button>
                <button type="reset" class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancel upload</span>
                </button>
                <!--<button type="button" class="btn btn-danger delete">
                    <i class="glyphicon glyphicon-trash"></i>
                    <span>Delete</span>
                </button>-->
                </div>
                
            <!-- The global progress state -->
            <div class="col-lg-5 fileupload-progress fade">
                <!-- The global progress bar -->
               
            </div>
            
           
        </div>
        <div id="result_div"></div> 
         
        <!-- The
        	 table listing the files available for upload/download -->
        <table role="presentation" class="table table-striped" border='0' id="ajax_div"><tbody class="files"></tbody></table>
        
        
        
    </form>
    </div>
    
    <br>
  
    
  <!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td>
            <span class="preview"></span>
        </td>
        <td>
            <p class="name">{%=file.name%}</p>
            <strong class="error text-danger"></strong>
        </td>
        <td>
            <p class="size">Processing...</p>
            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
        </td>
        <td>
            {% if (!i && !o.options.autoUpload) { %}
                <button class="btn btn-primary start" disabled>
                    <i class="glyphicon glyphicon-upload"></i>
                    <span>Start</span>
                </button>
            {% } %}
            {% if (!i) { %}
                <button class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancel</span>
                </button>
            {% } %}
        </td>
    </tr>
{% } %}
</script>
<!-- The template to display files available for download -->
<div>
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
        <td>
            <span class="preview">
                {% if (file.thumbnailUrl) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
                {% } %}
            </span>
        </td>
        <td width='28%'>
            <p class="name">
                {% if (file.url) { %}
                   <!--<a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>-->
                    <a href="#" title="{%=file.name%}" download="#" {%=file.thumbnailUrl?'data-gallery':''%}>
                    {%=file.name%}
                    </a>
               
                    {% } else { %}
                    <span>{%=file.name%}</span>
                {% } %}
            </p>
            {% if (file.error) { %}
                <div><span class="label label-danger">Error</span> {%=file.error%}</div>
            {% } %}
        </td>
        <td>
            <span class="size">{%=o.formatFileSize(file.size)%}</span>
        </td>
        <td style="border: 0px solid red;">
            {% if (file.deleteUrl) { %}
                <button class="btn btn-danger delete"  style="margin-left: 92px !important" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                    <i class="glyphicon glyphicon-trash"></i>
                    <span>Delete</span>
                </button>
                <input type="checkbox" name="delete" value="1" class="toggle">
                <br/>  <br/> 
                
        
        <form class="form-horizontal" method="post">
        <div class="form-group">
            <label for="inputEmail" class="control-label col-xs-2">Title :</label>
            <div class="col-xs-9">
            	
           
            	
            	<input type="hidden" size="50" class="form-control" id="userid" style="margin-bottom: 12px" value="<?php echo $userID; ?>">
            	<input type="hidden" size="50" class="form-control" id="file_send_url" style="margin-bottom: 12px" value="<?php echo $target_path; ?>{%=file.name%}">
                <input type="text" class="form-control" id="inputTitle" maxlength="35"  placeholder="Title" value="{%=file.name%}">
                <span class="help-block has-error" id="inputTitle-error" style="color:red;"></span>            
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword" class="control-label col-xs-2">Tags:</label>
            <div class="col-xs-9">
               <input type="text" class="form-control" id="tokenfield" name="mytags"  placeholder="Enter tags :eg red,green,blue" />
              <!-- <input type="text" value="Amsterdam,Washington,Sydney,Beijing,Cairo" data-role="tagsinput"  />-->
            </div>
        </div>
         <div class="form-group">
            <label for="inputPassword" class="control-label col-xs-2">Description:</label>
            <div class="col-xs-9">
            <textarea class="form-control" rows="3" id="description" name="mydescription" placeholder="Description" ></textarea>
            </div>
         </div>
         <div class="form-group">
            <label for="inputPassword" class="control-label col-xs-2">Status:</label>
            <div class="col-xs-9">
            <select name="video_status" id="video_status" >
                <option value="inactive">INACTIVE</option>
                <option value="active">ACTIVE</option>
            </select>
            </div>
         </div>
         
       
       
        <div class="form-group">
            <div class="col-xs-offset-2 col-xs-9">
                <button type="button" class="btn btn-primary" name="submit" value="Submit" id="myFormSubmit" onclick="save_detail_in_server();" >Save</button>
            
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-offset-2 col-xs-9">
               <div id="flash_saving"></div> 
            </div>
        </div>
       
    </form>
                
                
            {% } else { %}
                <button class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancel</span>
                </button>
            {% } %}
        </td>
    </tr>
    
  
   
    
    
    
    
    
{% } %}
</script>
    

</div>
<?php //include_once 'footer.php'; ?>   
<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="upload_js/vendor/jquery.ui.widget.js"></script>
<!-- The Templates plugin is included to render the upload/download listings -->
<script src="upload_js/tmpl.min.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="upload_js/load-image.all.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="upload_js/canvas-to-blob.min.js"></script>
<!-- Bootstrap JS is not required, but included for the responsive demo navigation -->

<!-- blueimp Gallery script -->

<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="upload_js/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="upload_js/jquery.fileupload.js"></script>
<!-- The File Upload processing plugin -->
<script src="upload_js/jquery.fileupload-process.js"></script>
<!-- The File Upload image preview & resize plugin -->
<!--<script src="upload_js/jquery.fileupload-image.js"></script>-->
<!--<script src="upload_js/jquery.fileupload-audio.js"></script>-->
<script src="upload_js/jquery.fileupload-video.js"></script>
<script src="upload_js/jquery.fileupload-validate.js"></script>
<script src="upload_js/jquery.fileupload-ui.js"></script>
<!-- The main application script -->
<script src="upload_js/main.js"></script>
<script type="text/javascript">
function save_detail_in_server()
{
   var publisher_unique_id="<?php  echo $publisher_unique_id ?>";
   var puser_id="<?php  echo $get_user_id ?>";
   var apiURl="<?php  echo $apiURL."/singleupload" ?>";
   var inputTitle = $('#inputTitle').val();
    $(".has-error").html(''); 
    if(inputTitle=='')
     {
            var message="Entry Name should not be blank";
            $("#inputTitle-error").html(message);
            return false;
      }
     var upload_url = $('#file_send_url').val();
     var mytags = $('#tokenfield').val();
     var descrip = $('#description').val();
     var video_status = $('#video_status').val();
     var userid = $('#userid').val();
     var displaystr='Saving.......';
     $("#flash_saving").show();
     $("#flash_saving").fadeIn(400).html(' Saving......... <img src="img/image_process.gif" />');
     $('#myFormSubmit').attr('disabled',true);
     var apiBody = new FormData();
     apiBody.append("filepath",upload_url);
     apiBody.append("name",inputTitle);
     apiBody.append("partnerid",publisher_unique_id);
     apiBody.append("tags",mytags);
     apiBody.append("desc",descrip);
     apiBody.append("userid",userid);
     apiBody.append("vstatus",video_status);
     //apiBody.append("action","save_media");
     $.ajax({
          url:apiURl,
          method: 'POST',
          dataType: 'json', 
          data:apiBody,
          processData: false,
          contentType: false,
              success: function(jsonResult){
                 console.log(jsonResult); 
                 var status1=jsonResult.status;
                 if(status1=="1")
                 {
                   var entryid=jsonResult.entryid;
                   var name=jsonResult.name;
                   var type=jsonResult.type;
                   var thumbnailurl=jsonResult.thumbnailurl;
                   var desc=jsonResult.desc;
                   var tags=jsonResult.tags;
                   var created_at=jsonResult.created_at;
                   var kalstatus=jsonResult.kalstatus;
                   $("#results").load("save_entry.php",{entryid:entryid,name:name,type:type,thumbnailurl:thumbnailurl,desc:desc,tags:tags,created_at:created_at,action:'save_entry',vstatus:video_status,userid:userid,upload_url:upload_url,kalstatus:kalstatus}, 
                   function(r) {
                   if(r==1)
                      {
                          alert("successfully uploaded!");
                          window.location.href='media_content.php';
                      } 
                      if(r==0)
                      {
                          alert("something went wrong please try again!");
                          $('#myFormSubmit').attr('disabled',false);
                          return false;
                      } 
                   });
                  }    
                  
                 if(status1=="0")
                 {
                     alert("something went wrong please try again!");
                     $('#myFormSubmit').attr('disabled',false);
                     return false;
                 }
                  
              }
      });	  
     
    
}


/*
function save_detail_in_server()
{
    var inputTitle = $('#inputTitle').val();
    $(".has-error").html(''); 
    if(inputTitle=='')
     {
            var message="Entry Name should not be blank";
            $("#inputTitle-error").html(message);
            return false;
      }
     var upload_url = $('#file_send_url').val();
     var mytags = $('#tokenfield').val();
     var descrip = $('#description').val();
     var video_status = $('#video_status').val();
     var userid = $('#userid').val();
     var displaystr='Saving.......';
     $("#flash_saving").show();
     $("#flash_saving").fadeIn(400).html(' Saving......... <img src="img/image_process.gif" />');
     $('#myFormSubmit').attr('disabled',true);
     var apiBody = new FormData();
     apiBody.append("upload_url",upload_url);
     apiBody.append("inputTitle",inputTitle);
     apiBody.append("mytags",mytags);
     apiBody.append("descrip",descrip);
     apiBody.append("userid",userid);
     apiBody.append("vstatus",video_status);
     apiBody.append("action","save_media");
     $.ajax({
                url:'save_media.php',
                method: 'POST',
                data:apiBody,
                processData: false,
                contentType: false,
                success: function(rr){
                    //alert(rr);
                      if(rr==5)
                      {
                          alert("upload successfully");
                          window.location.href='media_content.php';
                      } 
                      if(rr==6)
                      {
                          alert("upload successfully");
                          window.location.href='media_content.php';
                      } 
                      
                 }
                
       });	
     
    
}
*/

</script>
