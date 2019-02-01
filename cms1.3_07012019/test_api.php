<!DOCTYPE html>
<html>
<head>
    <title>jQuery AJAX POST Form</title>
    <meta charset="utf-8">
</head>
<body>
<span id="image-holder" ></span>
         <!-- <form id="upload_form" enctype="multipart/form-data"> 
            <div id="wrapper" style="border:0px solid red;">
             <input id="fileUpload"  type="file" />
              <!--<a href="#"  id="pop" onclick="openBrowse();"> <span  class="text-content">Update Profile Pic</span></a>-->
             <!--<div id="waitPreview" style="border: 0px solid red;"> </div>
            <div id="image-holder"></div>
          </div>-->
              
<!--<button type="button" name="save_upload_image" id="save_upload_image" onclick="saveImgeProfile('saveimage')" class="btn  btn-default btn-default1 btnSubmit" >
<span class="btn-label" ></span>Save</button> -->  
        </form>
<script src="js/jquery-1.11.2.min.js" type="text/javascript"></script>
<script type="text/javascript">
    
/*var track_page = 0; 
load_contents(); 
function load_contents(){
       apiBody.append("partnerid",ott173);
       apiBody.append("tag","upload_slider");
       apiBody.append('data','640_1490983083.jpg');

        $.ajax({
                url: ' http://api.planetcast.in:6080/upload',
                method: 'POST',
                dataType: 'json',
                contentType: 'multipart/form-data',
                data:apiBody,
                //data:{ 'partnerid':"ott173",'title':"testing msg",'message':"Hi This is testing Notification",'tag':"upload_slider"},
                
                success: function(jsonResult){
                    console.log(jsonResult);

            }
      });
}
*/









load_contents();
/*function load_contents()
{  
     
       var apiBody = new FormData();
       apiBody.append("partnerid","ott811");
       apiBody.append("watch_id","pe4u7anS28g");
       apiBody.append("tag","get_meta");
        $.ajax({
                url:'http://202.191.166.211:6078/youtube',
                method: 'POST',
                dataType: 'json', 
                data:apiBody,
                processData: false,
                contentType: false,
                    success: function(jsonResult){
                       console.log(jsonResult); 
                     
                    }
            });	

} */   
function load_contents()
{  
       //var imageName=document.getElementById("fileUpload").value; 
       var apiBody = new FormData();
       apiBody.append("email","na@gmail.com");
       apiBody.append("password","1111");
       apiBody.append("tag","login"); 
        $.ajax({
                url:'http://192.168.27.15/ottCoreApi/php_action/login.php',
                method: 'POST',
                dataType: 'json', 
                data:apiBody,
                processData: false,
                contentType: false,
                    success: function(jsonResult){
                       console.log(jsonResult); 
                     
                    }
            });	

}    

</script>


