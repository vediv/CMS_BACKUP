<?php
include_once 'corefunction.php';
$Entryid=$_POST['Entryid']; $getpageindex=$_POST['pageindex']; $limitval=$_POST['limitval'];$searchInputall=$_POST['searchInputall'];
if(in_array(2, $UserRight)){ $disable1=""; } else {$disable1="disabled";} ?>
<div style="border: 1px solid #c7d1dd ; border-top: 0px;    padding:20px 0px 20px 4px ">
 <form action="" method="post" enctype="multipart/form-data" id="uploadForm" style="padding-bottom: 20px">
     <div class="form-inline">
              <div class="form-group">
                 <input type="file" <?php echo $disable1; ?> class="inputFile" name="userImage" placeholder="select a File" id="image" onChange="validate_image(this.value)" required> 
                <input name="enteryID" value="<?php echo $Entryid; ?>" type="hidden" class="inputFile" />
              </div>
              <button type="submit" <?php echo $disable1; ?> class="btn btn-sm btn-primary btnSubmit" id="js-upload-submit">Upload files</button>
              <span style="border:0px solid red; margin-left:20px;" id="upload_loader"></span>
            </div>
          </form>

<div id="flash_thumbnail"></div>                        	
<div id="result_thumbnail" style="border: 0px solid red;"></div>
</div>
 <div class="modal-footer">
   <div class="col-sm-offset-3 col-sm-4" style="right: 6%;">
    <?php if(in_array(2, $UserRight)){ ?>
       <button type="button" class="btn btn-primary" data-dismiss="modal"  name="submit"  id="myFormSubmit" onclick="save_thumbnail('saveandclose_thumnnail','<?php echo $Entryid; ?>','<?php echo $getpageindex;  ?>','<?php echo $limitval;  ?>');" >Save & Close</button>
    <?php } else { ?>
    <button type="button" class="btn btn-primary" disabled data-dismiss="modal" name="submit">Save & Close</button>
    <?php } ?>
    <span id="saving_loader"> </span>  
           </div>
   </div>
<script type="text/javascript">
$(document).ready(function() {
var track_load = 1; //total loaded record group(s)
     var loading  = false; //to prevents multipal ajax loads
     $("#flash_thumbnail").show();
     $("#flash_thumbnail").fadeIn(500).html('Loading <img src="img/image_process.gif" />');
     var enteryidd = "<?php echo $Entryid; ?>";
	 $('#result_thumbnail').load("thumbnail.php",
	 {'first_load':track_load,'entryid':enteryidd},
	  function() {
	  	 	 $("#flash_thumbnail").hide();
	  	     track_load++;
	  	
	  	}); //load first group
   });
$(document).ready(function (e) {
	$("#uploadForm").on('submit',(function(e) { 
              e.preventDefault();
              $("#upload_loader").fadeIn(500).html('Wait for uploading Thumbnail.... <img src="img/image_process.gif" />');
              $('#js-upload-submit').attr('disabled',true);
		$.ajax({
        	url: "upload_image.php",
			type: "POST",
			data:  new FormData(this),
			contentType: false,
    	                cache: false,
			processData:false,
			success: function(data)
                          {
                             if(data==1) 
			     {
			     	   var enteryidd = "<?php echo $Entryid; ?>";
			     	   $('#result_thumbnail').load("thumbnail.php",{'entryid':enteryidd}); //load first group
                                   $("#upload_loader").hide(); 
                                   $('#js-upload-submit').attr('disabled',false);
                                   $('#myFormSubmit').attr('disabled',false);
                                   $('#image').val("");
                                   
                    	     }
			     else {  $("#result_thumbnail").html(data);  
                                 $("#upload_loader").hide(); $('#js-upload-submit').attr('disabled',false); 
                                  $('#myFormSubmit').attr('disabled',false);
                                 $('#image').val("");
                             }
			     //$("#targetLayer").html(data);
		    },
		  	error: function() 
	    	{
	    	} 	        
	   });
	}));
}); 
</script>
<script type="text/javascript"> 
function thumbnail(action,thumbID){
     
     var enteryidd = "<?php echo $Entryid; ?>";
     var dataString ='action_thumb='+ action+'&thumbID='+thumbID+'&entryid='+enteryidd;
     if(action=="setdefault")
     { var msg="Are you Sure want to set this Thumbnail Default?";}
     if(action=="remove")
     { var msg="Are you sure you want to delete selected thumbnail?";}
    
     var a=confirm(msg)
     if(a==true)
     { 
        $('#load_in_modal').show();
        $('#result_thumbnail').css("opacity",0.1);
        $.ajax({
           type: "POST",
           url: "thumbnail.php",
           data: dataString,
           cache: false,
           success: function(result){
           	 $("#result_thumbnail").html('');
           	 $("#result_thumbnail").html(result);
                 $('#load_in_modal').hide();
		 $('#result_thumbnail').css("opacity",1);
           }
      });
      
     }
     else
     {  return false;  }
      
}

function changePagination_thumbnail(pageid){
     
     $('#load_in_modal').show();
     $('#result_thumbnail').css("opacity",0.1);
     var enteryidd = "<?php echo $Entryid; ?>";
     var dataString ='first_load='+ pageid+'&entryid='+enteryidd;
     $.ajax({
           type: "POST",
           url: "thumbnail.php",
           data: dataString,
           cache: false,
           success: function(result){
                 $('#load_in_modal').hide();
                 $('#result_thumbnail').css("opacity",1);
                 $("#result_thumbnail").html(result);
           }
      });
} 

function validate_image(file) {
    var ext = file.split(".");
    ext = ext[ext.length-1].toLowerCase();
    var arrayExtensions = ["jpg" , "jpeg", "png", "bmp", "gif"];
    if (arrayExtensions.lastIndexOf(ext) == -1) {
        alert("Only formats are allowed : "+arrayExtensions.join(', '));
        $("#image").val("");
    }
}
var searchInputall="<?php echo $searchInputall ?>"; 
function save_thumbnail(thumb,entryid,pageindex,limitval){
    $("#saving_loader").fadeIn(500).html('Saving.... <img src="img/image_process.gif" />')
    var dataString ='maction='+thumb+'&entryid='+entryid+'&pageindex='+pageindex+'&limitval='+limitval+"&searchInputall="+searchInputall;
    $.ajax({
           type: "POST",
           url: "media_paging.php",
           data: dataString,
           cache: false,
           success: function(result){
             $('#myFormSubmit').attr('disabled',true);
             $("#saving_loader").hide();
             $("#results").html(result);
           }
    });   
}

</script>

