<?php
include_once 'corefunction.php';
include_once 'commonJS.php';
switch($action)
{
    case "subscriber":
?>
<link href="bootstrap/css/pagingCss.css" rel="stylesheet" type="text/css" />
<div id="content">    
<div class="container-fluid">
    <div id="msg" class="text-center" ></div>
    <div id="wait" class="text-center" ></div>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-envelope"></i> Send Notification</h3>
      </div>
    <div class="panel-body">
<form class="form-horizontal" action="javascript:" enctype="multipart/form-data" method="post" id="formuploadNoification" style="border: 0px solid red;">
        <div class="form-group required">
          <label class="col-sm-2 control-label" for="input-subject">Subject <span style="color:red;">*</span></label>
          <div class="col-sm-10">
            <input type="text" name="subject" placeholder="Subject" id="input-subject" class="form-control" />
            <span class="help-block has-error" id="input-subject-error" style="color:red;"></span>
          </div>
        </div>
        <div class="form-group to">
            <label class="col-sm-2 control-label" for="userlist">
            <span data-toggle="tooltip" title="Userlist">Select User <span style="color:red;">*</span></span></label>
            <div class="col-sm-10">
                <input type="text" name="userlist"  id="userlist"  placeholder="Select User"  class="form-control" />
                <input type="hidden" name="userlist"  id="user_id"  placeholder="User list"  class="form-control" />
                <span class="help-block has-error" id="userlist-error" style="color:red;"></span>
            </div>
          </div>
        <div class="form-group to" id="to-customer-group">
        <label class="col-sm-2 control-label" for="input-customer-group">Select Type <span style="color:red;">*</span></label>
        <div class="col-sm-10">
        <select name="notifyType" id="notifyType" class="form-control" onchange="GetNotifyType(this.value)">
          <option value="">Select Type</option>  
          <option value="video_entry" >Video Entry</option>
           <?php  if(in_array(34, $otherPermission)){ ?><option value="coupon">Coupon</option><?php } ?>
           <?php  if(in_array(36, $otherPermission)){ ?><option value="subscription_code">Subscription Code</option><?php } ?>
        </select>
        <span class="help-block has-error" id="notifyType-error" style="color:red;"></span>    
        </div>
        </div>
       <div class="form-group" id="videoEntryDiv">
            <label class="col-sm-2 control-label" for="userlist">
            <span data-toggle="tooltip" title="VideoEntry">Select Video <span style="color:red;">*</span></span></label>
            <div class="col-sm-10">
                <input type="text" name="VideoEntry"  id="VideoEntry"  placeholder="Select Video"  class="form-control" />
                <input type="hidden" name="entryid"  id="entryid"    class="form-control" />
                <span class="help-block has-error" id="VideoEntry-error" style="color:red;"></span>
            </div>
          </div>
         
        <div class="form-group">
          <label class="col-sm-2 control-label" for="input-message">Message <span style="color:red;">*</span></label>
          <div class="col-sm-10" >
              <textarea name="input-message" rows="3" style="resize: none; width:100%;" placeholder="message" id="input-message" size="100" ></textarea>
            <span class="help-block has-error" id="input-message-error" style="color:red;"></span>       
          </div>
        </div>
      <div class="form-group">
          <label class="col-sm-2 control-label" for="input-message">Select Image </label>
          <div class="col-sm-10" style="border:0px solid red;">
          <input type="file" id="imageUpload" name="imageUpload" name accept="image/*" >
          <div class="col-sm-7" style="border:0px solid red; margin-left:450px;margin-top: -27px!important;" id="preview_img"></div>
          <input name="img_urls" id="img_urls" type="hidden" class="inputFile" />
          </div>
           
        </div>
     </form>
        <div class="col-sm-12 text-center">
          <?php $disabled_button = (in_array(2, $UserRight) ? "" : "disabled"); ?>
            <button id="button-send" <?php echo $disabled_button; ?>   title="Send" class="btn btn-primary" onclick="send('singleUser')"><b> Send</b></button>
        </div>
    </div>
    </div>
</div>
</div>
<script src = "js/common.js"></script>
<script type="text/javascript" src="scripts/jquery.form.js"></script>
<script type='text/javascript'>
$('#imageUpload').on('change', function() {
  
  if(['image/jpeg', 'image/jpg', 'image/png', 'image/gif','image/jpeg'].indexOf($("#imageUpload").get(0).files[0].type) == -1) {
        alert('Error : Only JPEG, PNG & GIF,JPEG allowed');
        $("#imageUpload").val('');
        return false;
    }
   var apiBody1 = new FormData($('#formuploadNoification')[0]);
   apiBody1.append('data',$('input[type=file]')[0].files[0]); 
   apiBody1.append('action','marketing');
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
                  if(r==0){ alert("Error : image Height between  300 to 350 pixels.\n image width between  150 to 170 pixels"); return false; }
                }
           });
  
  });
  
function ImageProcess(){
  $("#preview_img").html('Uploading.... <img src="img/image_process.gif" alt="Uploading...."/>');
  $('#imageUpload').attr('disabled',true);
  $('#button-send').attr('disabled',true);
  var publisher_unique_id="<?php echo $publisher_unique_id ?>";
  var apiURl="<?php  echo $apiURL."/upload" ?>";
  var apiBody = new FormData($('#formuploadofferimage')[0]);
  apiBody.append("partnerid",publisher_unique_id);
  apiBody.append('fileAction','image');
  apiBody.append('tag','notificationimage');
  apiBody.append('data', $('input[type=file]')[0].files[0]);
  $.ajax({
                url:apiURl,
                method: 'POST',
                dataType: 'json', 
                data:apiBody,
                processData: false,
                contentType: false,
                success: function(jsonResult){
                var HOST_original=jsonResult.image_url[0].HOST
                var URI=jsonResult.image_url[0].URI; 
                var imgShow=HOST_original+URI;
                //$("#host_url").val(HOST_original);
                setTimeout(function() {
                $("#img_urls").val(imgShow);
                $('#imageUpload').attr('disabled',false);
                $('#button-send').attr('disabled',false);   
                 var imgPrev='<img src="'+imgShow+'" class="img-responsive customer-img" style=" height: 150px!important; width: 300px!important;" >';
                document.getElementById('preview_img').innerHTML=imgPrev; }, 15000);
                 }
            });	
      }
$('input[name=\'userlist\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'controller/customFunction.php?action=getregisterUserList&filter_name='+request,
			method: 'POST',
                        dataType: 'json',
			success: function(json) {
                               
				response($.map(json, function(item) {
		         	return {
					  label: item['user_id'],
				           value: item['uid']
					}
				}));
			}
		});
	},
	'select': function(item) { 
         $('#user_id').val(item['value']);
         $('#userlist').val(item['label']);
        }
});     
$('input[name=\'VideoEntry\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'controller/customFunction.php?action=getVideoEntry&filter_name='+request,
			method: 'POST',
                        dataType: 'json',
			success: function(json) {
                        	response($.map(json, function(item) {
		         	return {
					  label: item['name'],
				          value: item['entryid']
					}
				}));
			}
		});
	},
	'select': function(item) {   
         $('#entryid').val(item['value']);
         $('#VideoEntry').val(item['label']);
        }
});     
$('#videoEntryDiv').hide();
function GetNotifyType(optionVal)
{
    if(optionVal=='video_entry'){  $('#videoEntryDiv').show();  }
    else{ $('#videoEntryDiv').hide();  $('#entryid').val(''); }
    
}
function send(suser){
      var apiURlNotification="<?php  echo $apiURL1."/notification" ?>";
      var parid="<?php echo $publisher_unique_id ?>";
      $(".has-error").html('');
      var input_subject = $('#input-subject').val();
      var userlist = $('#userlist').val();
      var input_message = $('#input-message').val();
      var notifyType = $('#notifyType').val();
      var user_id = $('#user_id').val();
      var entryid = $('#entryid').val();
      var img_urls = $('#img_urls').val();
      if(input_subject=='')   
      { var mess="Subject required!"; $("#input-subject-error").html(mess); return false;} 
      if(userlist=='')   
      { var mess="Select user required!"; $("#userlist-error").html(mess); return false;} 
      if(notifyType=='')   
      { var mess="Select Type required!"; $("#notifyType-error").html(mess); return false;} 
      if(notifyType=='video_entry')
      {  var VideoEntry = $('#VideoEntry').val();
         if(VideoEntry=='')
         { var mess="Select Video required!"; $("#VideoEntry-error").html(mess); return false;} 
         
      }
    if(input_message=='')   
    { var mess="Message required!"; $("#input-message-error").html(mess); return false;} 
     //var dataString={'partnerid':parid,'title':sub1,'message':msgg1,'image':substext,'entryid':entryid1,'userid':userid,'tag':"subscriber"};
     var apiBody = new FormData();
     apiBody.append("partnerid",parid);
     apiBody.append("title",input_subject);
     apiBody.append("userid",user_id);
     apiBody.append("entryid",entryid);
     apiBody.append("message",input_message);
     apiBody.append("tag","subscriber");
     if(img_urls!='')
     {
         apiBody.append("image",img_urls);
     }    
     // console.log(dataString);
     $("#msg").html('');
     $("#wait").fadeIn(800).html('Sending.... <img src="img/image_process.gif" />');
     $.ajax({
               url:apiURlNotification,
                method: 'POST',
                dataType: 'json',
                data:apiBody,
                processData: false,
                contentType: false,
                cache: false,
                success: function(jsonResult){
                 console.log(jsonResult);
                 var fail=jsonResult.fail; var Success=jsonResult.Success;
                 $("#wait").hide();
                 $("#msg").html("Successfully Send Notifications= "+ Success);
                 $("#msg").css("background-color","orange").css({ fontweight: "bold",});
                 $("#sub1").val(''); 
                 $("#msgg1").val('');
                 $("#entryid1").val('');
                 $("#subsurl").val(''); 
                 $("#userid").val('');
                 $("#imagesubs").val(''); 
                 
              }
      }); 
}
</script>
    <?php  
    break;
     case "broadcast":
?>
<link href="bootstrap/css/pagingCss.css" rel="stylesheet" type="text/css" />
<div id="content">    
<div class="container-fluid">
    <div id="msg" class="text-center" ></div>
    <div id="wait" class="text-center" ></div>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-envelope"></i> Send Notification</h3>
      </div>
    <div class="panel-body">
<form class="form-horizontal" action="javascript:" enctype="multipart/form-data" method="post" id="formuploadNoification" style="border: 0px solid red;">
        <div class="form-group required">
          <label class="col-sm-2 control-label" for="input-subject">Subject <span style="color:red;">*</span></label>
          <div class="col-sm-10">
            <input type="text" name="subject" placeholder="Subject" id="input-subject" class="form-control" />
            <span class="help-block has-error" id="input-subject-error" style="color:red;"></span>
          </div>
        </div>
        <div class="form-group to">
            <label class="col-sm-2 control-label" for="userlist">
            <span data-toggle="tooltip" title="Userlist">Select User <span style="color:red;">*</span></span></label>
            <div class="col-sm-10">
                  <select name="user_group" id="user_group" class="form-control">
                    <option value="">--Select User Group--</option>
                    <option value="all_active_user">All Active User</option>
                    <option value="all_inactive_user">All Inactive User</option>
                    <?php  if(in_array(5, $otherPermission)){ ?><option value="all_subscriber_user">All Subscriber User </option><?php } ?>
                    <?php  if(in_array(27,$otherPermission)) {?><option value="15dayactive_user">15 Day Active User</option>
                    <option value="15dayinactive">15 Day Inactive User</option><?php } ?>
                   </select>
                  <span class="help-block has-error" id="user_group-error" style="color:red;"></span>
            </div>
          </div>
        <div class="form-group to" id="to-customer-group">
        <label class="col-sm-2 control-label" for="input-customer-group">Select Type <span style="color:red;">*</span></label>
        <div class="col-sm-10">
        <select name="notifyType" id="notifyType" class="form-control" onchange="GetNotifyType(this.value)">
          <option value="">Select Type</option>  
          <option value="video_entry" >Video Entry</option>
          <?php  if(in_array(34, $otherPermission)){ ?><option value="coupon">Coupon</option><?php } ?>
           <?php  if(in_array(36, $otherPermission)){ ?><option value="subscription_code">Subscription Code</option><?php } ?>
      
        </select>
        <span class="help-block has-error" id="notifyType-error" style="color:red;"></span>    
        </div>
        </div>
       <div class="form-group" id="videoEntryDiv">
            <label class="col-sm-2 control-label" for="userlist">
            <span data-toggle="tooltip" title="VideoEntry">Select Video <span style="color:red;">*</span></span></label>
            <div class="col-sm-10">
                <input type="text" name="VideoEntry"  id="VideoEntry"  placeholder="Select Video"  class="form-control" />
                <input type="hidden" name="entryid"  id="entryid"    class="form-control" />
                <span class="help-block has-error" id="VideoEntry-error" style="color:red;"></span>
            </div>
          </div>
         
        <div class="form-group">
          <label class="col-sm-2 control-label" for="input-message">Message <span style="color:red;">*</span></label>
          <div class="col-sm-10" >
              <textarea name="input-message" rows="3"  style="resize: none; width:100%;" placeholder="message" id="input-message"  ></textarea>
            <span class="help-block has-error" id="input-message-error" style="color:red;"></span>       
          </div>
        </div>
      <div class="form-group">
          <label class="col-sm-2 control-label" for="input-message">Select Image </label>
          <div class="col-sm-10" style="border:0px solid red;">
          <input type="file" id="imageUpload" name="imageUpload" name accept="image/*" >
          <div class="col-sm-7" style="border:0px solid red; margin-left:450px;margin-top: -27px!important;" id="preview_img"></div>
          <input name="img_urls" id="img_urls" type="hidden" class="inputFile" />
          <span class="help-block has-error" id="imageUpload-error" style="color:red;"></span>
          </div>
           
        </div>
     </form>
        <div class="col-sm-12 text-center">
             <?php $disabled_button = (in_array(2, $UserRight) ? "" : "disabled"); ?>
          <button id="button-send"  <?php echo $disabled_button; ?>  title="Send" class="btn btn-primary" onclick="send('singleUser')"><b> Send</b></button>
        </div>
    </div>
    </div>
</div>
</div>
<script src = "js/common.js"></script>
<script type="text/javascript" src="scripts/jquery.form.js"></script>
<script type='text/javascript'>
$('#imageUpload').on('change', function() {
  
  if(['image/jpeg', 'image/jpg', 'image/png', 'image/gif','image/jpeg'].indexOf($("#imageUpload").get(0).files[0].type) == -1) {
        alert('Error : Only JPEG, PNG & GIF,JPEG allowed');
        $("#imageUpload").val('');
        return false;
    }
   var apiBody1 = new FormData($('#formuploadNoification')[0]);
   apiBody1.append('data',$('input[type=file]')[0].files[0]); 
   apiBody1.append('action','marketing');
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
                  if(r==0){ alert("Error : image Height between  300 to 350 pixels.\n image width between  150 to 170 pixels"); return false; }
                }
           });
  
  });
  
function ImageProcess(){
  $("#preview_img").html('Uploading.... <img src="img/image_process.gif" alt="Uploading...."/>');
  $('#imageUpload').attr('disabled',true);
  $('#button-send').attr('disabled',true);
  $("#imageUpload-error").html(''); 
  var publisher_unique_id="<?php echo $publisher_unique_id ?>";
  var apiURl="<?php  echo $apiURL."/upload" ?>";
  var apiBody = new FormData($('#formuploadofferimage')[0]);
  apiBody.append("partnerid",publisher_unique_id);
  apiBody.append('fileAction','image');
  apiBody.append('tag','notificationimage');
  apiBody.append('data', $('input[type=file]')[0].files[0]);
  $.ajax({
                url:apiURl,
                method: 'POST',
                dataType: 'json', 
                data:apiBody,
                processData: false,
                contentType: false,
                success: function(jsonResult){
                var HOST_original=jsonResult.image_url[0].HOST
                var URI=jsonResult.image_url[0].URI; 
                var imgShow=HOST_original+URI;
                //$("#host_url").val(HOST_original);
                setTimeout(function() {
                $("#img_urls").val(imgShow);
                $('#imageUpload').attr('disabled',false);
                $('#button-send').attr('disabled',false);
                var imgPrev='<img src="'+imgShow+'" class="img-responsive customer-img" style=" height: 150px!important; width: 300px!important;" >';
                document.getElementById('preview_img').innerHTML=imgPrev; }, 15000);
                 }
            });	
      }
$('input[name=\'userlist\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'controller/customFunction.php?action=getregisterUserList&filter_name='+request,
			method: 'POST',
                        dataType: 'json',
			success: function(json) {
                               
				response($.map(json, function(item) {
		         	return {
					  label: item['user_id'],
				           value: item['uid']
					}
				}));
			}
		});
	},
	'select': function(item) { 
         $('#user_id').val(item['value']);
         $('#userlist').val(item['label']);
        }
});     
$('input[name=\'VideoEntry\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'controller/customFunction.php?action=getVideoEntry&filter_name='+request,
			method: 'POST',
                        dataType: 'json',
			success: function(json) {
                        	response($.map(json, function(item) {
		         	return {
					  label: item['name'],
				          value: item['entryid']
					}
				}));
			}
		});
	},
	'select': function(item) {   
         $('#entryid').val(item['value']);
         $('#VideoEntry').val(item['label']);
        }
});     
$('#videoEntryDiv').hide();
function GetNotifyType(optionVal)
{
    if(optionVal=='video_entry'){  $('#videoEntryDiv').show();  }
    else{ $('#videoEntryDiv').hide();  $('#entryid').val(''); }
    
}
function send(suser){
      var apiURlNotification="<?php  echo $apiURL1."/notification" ?>";
      var parid="<?php echo $publisher_unique_id ?>";
      $(".has-error").html('');
      var input_subject = $('#input-subject').val();
      var user_group = $('#user_group').val();
      var input_message = $('#input-message').val();
      var notifyType = $('#notifyType').val();
    
      var entryid = $('#entryid').val();
      var img_urls = $('#img_urls').val();
      if(input_subject=='')   
      { var mess="Subject required!"; $("#input-subject-error").html(mess); return false;} 
      if(user_group=='')   
      { var mess="Select user group required!"; $("#user_group-error").html(mess); return false;} 
      if(notifyType=='')   
      { var mess="Select Type required!"; $("#notifyType-error").html(mess); return false;} 
      var f=0;
      if(notifyType=='video_entry')
      {  var VideoEntry = $('#VideoEntry').val();
         if(VideoEntry=='')
         { var mess="Select Video required!"; $("#VideoEntry-error").html(mess); return false;} 
         flag=1;
      }
    if(notifyType=='subscription_code')
    {
        flag=0;
    }   
    if(input_message=='')   
    { var mess="Message required!"; $("#input-message-error").html(mess); return false;}
    if(flag==1)
    {   var imageUpload = $('#imageUpload').val();
        if(imageUpload=='')
         { var mess="Select image required!"; $("#imageUpload-error").html(mess); return false;}
    }   
     var apiBody = new FormData();
     apiBody.append("partnerid",parid);
     apiBody.append("title",input_subject);
     apiBody.append("userid",user_group);
     apiBody.append("entryid",entryid);
     apiBody.append("message",input_message);
     apiBody.append("tag","broadcast");
     if(img_urls!='')
     {
         apiBody.append("image",img_urls);
     }    
     // console.log(dataString);
     $("#msg").html('');
     $("#wait").fadeIn(800).html('Sending.... <img src="img/image_process.gif" />');
    $.ajax({
               url:apiURlNotification,
                method: 'POST',
                dataType: 'json',
                data:apiBody,
                processData: false,
                contentType: false,
                cache: false,
                success: function(jsonResult){
                 console.log(jsonResult);
                 var fail=jsonResult.fail; var Success=jsonResult.Success;
                 $("#wait").hide();
                 $("#msg").html("Successfully Send Notifications= "+ Success);
                 $("#msg").css("background-color","orange").css({ fontweight: "bold",});
                 $("#sub1").val(''); 
                 $("#msgg1").val('');
                 $("#entryid1").val('');
                 $("#subsurl").val(''); 
                 $("#userid").val('');
                 $("#imagesubs").val(''); 
                
                 
              }
      });
}
</script>
    <?php  
    break;
}
?>