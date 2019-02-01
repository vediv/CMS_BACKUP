<?php
include_once 'corefunction.php';
?>
<script type="text/javascript" src="js/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="js/bootstrap-multiselect.css" type="text/css"/>
<style type="text/css">
.preview
{ width:200px;border:solid 1px #dedede; }
.flexdatalist{border:solid 1px #dedede !important; }
.flexdatalist-multiple li.input-container, .flexdatalist-multiple li.input-container input {width: 250px !important; }
</style>
<div class="modal-content" style="border-radius: 14px; ">
        <div class="modal-body">
        <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                       <span aria-hidden="true">&times;</span>
                       <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">
                  <b>Add New Channel</b>
                </h4>
            </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            
<br/>
<div style=" border:1px solid #c7d1dd ;">
<form name="myForm" method="post" class="form-horizontal">
    
    <div id="msg" style="text-align: center; margin-bottom: 10px; color:red;"> </div>
       <div class="form-group">
            <label for="channelname" class="control-label col-xs-4">Channel Name *:</label>
            <div class="col-xs-6">
                <input type="text" class="form-control" id="channelname" name="channelname" placeholder="Channel Name" required>
            </div>
        </div>
         <div class="form-group">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <label for="description" class="control-label col-xs-4">Description:</label>
            <div class="col-xs-6">
            <textarea class="form-control" rows="1" id="description" name="description" placeholder="Description" ></textarea>
            </div> 
        </div>
       <div class="form-group">
            <label for="url" class="control-label col-xs-4">URL *:</label>
            <div class="col-xs-6">
                <input type="url" class="form-control" id="url" name="url" placeholder="live URL" required>
            </div> 
        </div>
    <?php include_once('countries.php'); ?> 
<div class="form-group">
       <label for="country_code" class="control-label col-xs-4">Country Code:</label>
<div class="col-xs-8">
  <select id="countrycode" multiple="multiple">
  <?php foreach ($countries as $key => $value) { 
         
   ?>   
      <option value="<?php echo $key;?>" ><?php echo $value ?></option>
  <?php } ?>
</select>
       </div>
</div>
    
<div class="form-group">
    <div class="col-xs-offset-4 col-xs-8">
        <button type="button" class="btn btn-primary" onclick="return LiveAddChannel();" >Save & Close</button>
    </div>
 </div>
 <br/>
 </form>

</div> 
	</div>
  </div>
<script type="text/javascript">
jQuery(document).ready(function(){
$('#countrycode').multiselect({
includeSelectAllOption: true,
buttonWidth: 250,
enableFiltering: true
});     
      
});

</script>
<script type="text/javascript">
function LiveAddChannel()
{
       var channelName=document.getElementById("channelname").value;
       var description=document.getElementById("description").value;
       var countrycode = $('#countrycode').val();
       var url=document.getElementById("url").value;
       if(channelName=='')
       {
           alert("Channel name required.");
            return false;
       }   
       if(url=='')
       {
            alert("URL name required.");
            return false;
           
       }   
        if(countrycode=='')
       {
            alert("country code required.");
            return false;
           
       }   
       var pattern = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
       if (!pattern.test(url)) {
            alert("Url Not valid");
            return false;
        } 
       var publisher_unique_id="<?php  echo $publisher_unique_id ?>";
        var apiURl="<?php  echo $apiURL."/livefeed" ?>";
       var apiBody = new FormData();
       apiBody.append("partnerid",publisher_unique_id);
       apiBody.append("name",channelName);
       apiBody.append("description",description);
       apiBody.append("url",url);
       apiBody.append("tag","insert");
       apiBody.append("countrycode",countrycode);
       apiBody.append("video_status",'inactive');
       $.ajax({
                url:apiURl,
                method: 'POST',
                dataType: 'json', 
                data:apiBody,
                processData: false,
                contentType: false,
                    success: function(jsonResult){
                     console.log(jsonResult);
                      var status=jsonResult.status;
                      if(status=="2")
                       {
                          alert("Live Channel add Successfully..");
                          window.location.href="live_channel_content.php";
                          return true;
                           
                       }    
                      if(status=="1")
                       {
                        
                         $("#msg").html("Opps... live channel not addded. something wrong in server...");
                         return false;
                           
                       }  
                    }
            });	 
       
}
</script>

