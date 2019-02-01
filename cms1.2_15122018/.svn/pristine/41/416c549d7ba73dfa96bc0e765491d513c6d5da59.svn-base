<?php
//include_once '../auths.php'; 
include_once '../corefunction.php';
$action=isset($_POST['action'])?$_POST['action']:'';
$ModalName=isset($_POST['ModalName'])?$_POST['ModalName']:'';
$ModalView=isset($_POST['ModalView'])?$_POST['ModalView']:'';
switch($action)
{
     case "emailSend":
     $userEmail=isset($_POST['userEmail'])?$_POST['userEmail']:'';
?>
<link rel="stylesheet" href="scripts/summernote-bs4.css"  /> 
<script type="text/javascript" src="scripts/summernote-bs4.js"></script>
<div class="modal-header">
    <button type="button" class="close" onclick="CloseVideo('<?php echo $ModalName; ?>','<?php echo $ModalView; ?>');" data-dismiss="modal1">&times;</button>
    <h4 class="modal-title">Send Mail To- <?php echo $userEmail; ?></h4>
</div>
<div class="modal-body" style="border:0px solid ; min-height: 400px;"> 
<div id="content">    
<div class="container-fluid">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-envelope"></i> Mail</h3>
      </div>
    <div class="panel-body">
  <form class="form-horizontal">
        <div class="form-group">
          <label class="col-sm-2 control-label" for="input-store">From</label>
          <div class="col-sm-10">
           <?php
           $qry="SELECT cemail FROM client_mail where status='1'";
            $fetch = db_select($conn,$qry);
           ?> 
            <select name="from_store_id" id="input-store" class="form-control">
             <?php foreach ($fetch as $fetchemail) {                                    
              $fetchemail=$fetchemail['cemail'];  
              ?>   
               <option value="<?php echo $fetchemail; ?>"><?php echo $fetchemail; ?></option>
              <?php }  ?>
            </select>
          </div>
        </div>
        <div class="form-group">
        <label class="col-sm-2 control-label" for="input-to">To <span style="color:red;">*</span></label>
            <div class="col-sm-10">
               <input type="hidden" name="input-to" id="input-to" value="singleEmail" class="form-control" />
               <input type="text" name="singleEmail" id="singleEmail" value="<?php echo $userEmail; ?>" class="form-control"  onchange="registerEmailValidate(this.value)"/>
               <!--<select name="input-to" id="input-to" class="form-control">
                <option value="">--Select--</option>
                <option value="all_active_user">All Active User</option>
                <option value="all_inactive_user">All Inactive User</option>
              </select>-->
              <span class="help-block has-error" id="input-to-error" style="color:red;"></span>
            </div>
          </div>
        <div class="form-group required">
          <label class="col-sm-2 control-label" for="input-subject">Subject <span style="color:red;">*</span></label>
          <div class="col-sm-10">
            <input type="text" name="subject" value="" placeholder="Subject" id="input-subject" class="form-control" />
            <span class="help-block has-error" id="input-subject-error" style="color:red;"></span>
          </div>
        </div>
        <div class="form-group" >
          <label class="col-sm-2 control-label" for="input-message">Message <span style="color:red;">*</span></label>
          <div class="col-sm-10" id="textAreaLoad">
            <textarea name="input-message" placeholder="message" id="input-message" data-toggle="summernote"  class="summernote"></textarea>
            <span class="help-block has-error" id="input-message-error" style="color:red;"></span>       
          </div>
        </div>
    </form>
        <div class="col-sm-12 text-center">
          <button id="button-send"   title="Send" class="btn btn-primary" onclick="send('controller/contact.php');"> Send</button>
        </div>
    </div>
    </div>
</div>
</div>


</div>
<?php 
break;
}
?>

<script type="text/javascript">
function CloseVideo(modalName,ModalView){
$("#"+ModalView).html('');
$('#'+modalName).modal('hide');
}

$(function() {
      $('.summernote').summernote({
        height: 160,
        callbacks: {
        onImageUpload : function(files, editor, welEditable) {
            for(var i = files.length - 1; i >= 0; i--) {
                sendFile(files[i], this);
             }
          }
          }
      });
});
 function sendFile(file, editor, welEditable) {
            var fileExtension = file.name.replace(/^.*\./, '');
            if (fileExtension != "jpeg" && fileExtension != "jpg" && fileExtension != "png" && fileExtension != "gif") {
              alert('Please select a valid image file');
              return false;
            }
         $('#load').show();
         $('#textAreaLoad').css("opacity",0.1);
         $('#button-send').attr('disabled',true);
         var apiBody = new FormData();
         apiBody.append("file", file);
         var publisher_unique_id="<?php echo $publisher_unique_id ?>";
         var apiURl="<?php  echo $apiURL."/upload" ?>";
         apiBody.append("partnerid",publisher_unique_id);
         apiBody.append('fileAction','image');
         apiBody.append('tag','email_images');
         apiBody.append('data', file);    
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
                $("#host_url").val(HOST_original);
                $(editor).summernote('editor.insertImage', imgShow);
                setTimeout(function() {
                $(editor).summernote('editor.insertImage', imgShow);
                    $('#load').hide();
                    $('#textAreaLoad').css("opacity",1);
                    $('#button-send').attr('disabled',false);
                }, 15000);
                  }
            });	
        }
   
function registerEmailValidate(userEmail)
{
    var info = 'action=userEmailCheck&userEmail='+userEmail; 
     $.ajax({
	    type: "POST",
	    url: "controller/customFunction.php",
	    data: info,
            success: function(r){
             if(r==0){ $('#button-send').attr('disabled',true); { var mess="This email not register with us!"; $("#input-to-error").html(mess); return false;}   }
             else { $('#button-send').attr('disabled',false);$("#input-to-error").html(''); }
         }
    });
   
}


function send(url) {
      $(".has-error").html('');
      var input_to = $('#singleEmail').val();
      var input_subject = $('#input-subject').val();
      var input_message = $('#input-message').val();
      if(input_to=='')   
      { var mess="Email should not be Blank"; $("#input-to-error").html(mess); return false;}
      else if(input_to.length>0)
       {        if(!input_to.match(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/)) {
		$("#input-to-error").html("(email ID invalid..)");
                return false;
	}
      }
      if(input_subject=='')   
      { var mess="E-Mail Subject required!"; $("#input-subject-error").html(mess); return false;} 
      if(input_message=='')   
      { var mess="E-Mail Message required!"; $("#input-message-error").html(mess); return false;} 
      
      $.ajax({
		url: url,
		type: 'post',
		data: $('#content select, #content input, #content textarea'),
		dataType: 'json',
		beforeSend: function() {
			//$('#button-send').button('loading');
		},
		complete: function() {
			//  $('#button-send').button('reset');
		},
		success: function(json) {
			$('.alert-dismissible, .text-danger').remove();

			if (json['error']) {
				if (json['error']['warning']) {
					$('#content > .container-fluid').prepend('<div class="alert alert-danger alert-dismissible"><i class="fa fa-exclamation-circle"></i> ' + json['error']['warning'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
				}

				if (json['error']['email']) {
					$('#content > .container-fluid').prepend('<div class="alert alert-danger alert-dismissible"><i class="fa fa-exclamation-circle"></i> ' + json['error']['email'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
				}

				if (json['error']['subject']) {
					$('input[name=\'subject\']').after('<div class="text-danger">' + json['error']['subject'] + '</div>');
				}

				if (json['error']['message']) {
					$('textarea[name=\'message\']').parent().append('<div class="text-danger">' + json['error']['message'] + '</div>');
				}
			}

			if (json['success']) {
				$('#content > .container-fluid').prepend('<div class="alert alert-success alert-dismissible"><i class="fa fa-check-circle"></i>  ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
			}
				
			if (json['next']) {
                             //console.log(json['next']);
                             //send(json['next']);
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	}); 
}

</script>