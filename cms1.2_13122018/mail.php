<?php 
include_once 'corefunction.php';
$action=isset($_GET['action'])?$_GET['action']:'';
/*if($action=='single')
{   
    $uemail=isset($_GET['uemail'])?$_GET['uemail']:'';  
    $sqlCountEmail = "SELECT uemail FROM user_registration where uemail='".$uemail."'";
    $validUser = db_totalRow($conn,$sqlCountEmail);
}*/
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title><?php echo PROJECT_TITLE." | Mail";?></title>
<link href="bootstrap/css/pagingCss.css" rel="stylesheet" type="text/css" />
<style type="text/css">
.box-header {  padding: 4px 10px 0px 10px !important;  }
.navbar-form .input-group > .form-control {    height: 26px !important; }h5 {margin-top: 0px  !important;}
.input-group-btn:last-child > .btn, .input-group-btn:last-child > .btn-group {height: 26px;margin-left: -1px;padding: 4px;}
</style>
<link rel="stylesheet" href="scripts/summernote-bs4.css"  /> 
  </head>
  <body class="skin-blue">
    <div class="wrapper">
   <?php include_once 'header.php';?>
      <?php include_once 'lsidebar.php';?>
      <div class="content-wrapper">
         <section class="content-header">
         <h1>Mail
         </h1>
          <ol class="breadcrumb">
            <li><a href="dashboard.php"><i class="fa fa-home" title="Home"></i> Home</a></li>
            <li class="active">Mail </li>
          </ol>
        </section>
        <!-- Main content -->
 <section class="content">       
     
     <div id="content">
         <div class="container-fluid">
         <?php
         /*$sendButton='';
         if($validUser==0){ 
          echo '<div class="alert alert-danger alert-dismissible"> 
            <i class="fa fa-exclamation-circle"></i> This email id not register with us ('.$uemail.')
           <button type="button" class="close" data-dismiss="alert">&times;</button></div>';
          $sendButton='disabled';
         }*/
         ?>    
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
                   <select name="input-to" id="input-to" class="form-control">
                    <!--<option value="newsletter">text_newsletter </option>-->
                    <option value="">--Select--</option>
                    <option value="all_active_user">All Active User</option>
                    <option value="all_inactive_user">All Inactive User</option>
                    <?php  if(in_array(5, $otherPermission)){ ?>
                    <option value="all_subscriber_user">All Subscriber User </option>
                    <?php } ?>
                    </select>
                  <span class="help-block has-error" id="input-to-error" style="color:red;"></span>
                </div>
              </div>
                  
<!--<div class="form-group to" id="to-customer-group">
  <label class="col-sm-2 control-label" for="input-customer-group">{{ entry_customer_group }}</label>
  <div class="col-sm-10">
    <select name="customer_group_id" id="input-customer-group" class="form-control">

      {% for customer_group in customer_groups %}

      <option value="{{ customer_group.customer_group_id }}">{{ customer_group.name }}</option>

      {% endfor %}

    </select>
  </div>
</div>-->
<!--<div class="form-group to" id="to-customer">
  <label class="col-sm-2 control-label" for="input-customer"><span data-toggle="tooltip" title="{{ help_customer }}">{{ entry_customer }}</span></label>
  <div class="col-sm-10">
    <input type="text" name="customers" value="" placeholder="{{ entry_customer }}" id="input-customer" class="form-control" />
    <div class="well well-sm" style="height: 150px; overflow: auto;"></div>
  </div>
</div>-->
<!-- <div class="form-group to" id="to-affiliate">
  <label class="col-sm-2 control-label" for="input-affiliate"><span data-toggle="tooltip" title="{{ help_affiliate }}">{{ entry_affiliate }}</span></label>
  <div class="col-sm-10">
    <input type="text" name="affiliates" value="" placeholder="{{ entry_affiliate }}" id="input-affiliate" class="form-control" />
    <div class="well well-sm" style="height: 150px; overflow: auto;"></div>
  </div>
</div>-->
<!--<div class="form-group to" id="to-product">
  <label class="col-sm-2 control-label" for="input-product"><span data-toggle="tooltip" title="{{ help_product }}">{{ entry_product }}</span></label>
  <div class="col-sm-10">
    <input type="text" name="products" value="" placeholder="{{ entry_product }}" id="input-product" class="form-control" />
    <div class="well well-sm" style="height: 150px; overflow: auto;"></div>
  </div>
</div>-->
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
      <?php $disabled_button = (in_array(2, $UserRight) ? "" : "disabled"); ?> 
    <button id="button-send" <?php echo $sendButton;   echo $disabled_button;?>  data-loading-text="Loading.." data-toggle="tooltip" title="Send" class="btn btn-primary" onclick="send('controller/contact.php');"> Send</button>
    </div>
</div>

  </div>
     </div>
     </div>       
 </section> 
        
</div>
<?php include_once "footer.php"; include_once 'commonJS.php'; ?>
</div>
<script type="text/javascript" src="scripts/summernote-bs4.js"></script>
<script type="text/javascript">
  $(function() {
      $('.summernote').summernote({
        height: 200,
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
                    $('#textAreaLoad').css("opacity",1);
                    $('#button-send').attr('disabled',false);
                }, 15000);
                  }
            });	
            
            
            
        }
function send(url) {
      $(".has-error").html('');
      var input_to = $('#input-to').val();
      var input_subject = $('#input-subject').val();
      var input_message = $('#input-message').val();
      if(input_to=='')   
      { var mess="Email To required!"; $("#input-to-error").html(mess); return false;} 
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
			$('#button-send').button('loading');
		},
		complete: function() {
			$('#button-send').button('reset');
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
                        	send(json['next']);
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
}
</script>
  
  
</body>
</html>
