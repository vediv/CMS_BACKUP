<?php
include_once 'corefunction.php';
include_once("config.php");
$Entryid=$_REQUEST['Entryid'];
$getpageindex=$_REQUEST['pageindex'];
$entryId = $Entryid;
$version = null;
$result = $client->baseEntry->get($entryId, $version);
//print '<pre>'.print_r($result, true).'</pre>';
$name=$result->name; $description=$result->description;
$primaryBroadcastingUrl=$result->primaryBroadcastingUrl;
$thumbnailUrl=$result->thumbnailUrl;
$tags=$result->tags;
if($tags=='null')
{ $tags='';}
else{ $tags; }
$categoriesIds=$result->categoriesIds;
$entry="select countrycode from entry where type='7'";
$rr=db_select($conn,$entry);
if(!empty($rr))
{    
 $countrycode=$rr[0]['countrycode'];
}

?>
<script src="player_js/flowplayer.min.js" type="text/javascript"></script>
<script src="player_js/flowplayer.mpegdash.min.js" type="text/javascript"></script>
<script type="text/javascript" src="js/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="js/bootstrap-multiselect.css" type="text/css"/>
<script type="text/javascript">
   var dataurl="<?php echo $primaryBroadcastingUrl;  ?>";
   //var dataUrl=dataurl+"/a.m3u8";
  // var resDataUrl = dataUrl.replace("url", "applehttp");
  flowplayer("#fp-dash", {
   splash: true,
   ratio: 9/16,
   clip: {
   sources: [
   { 
      type: "application/x-mpegurl",
      src:dataurl
   },
  
]
},
embed: false

}).on("ready", function (e, api, video) {
// document.querySelector("#fp-dash .fp-title").innerHTML =
 //api.engine.engineName + " engine playing " + video.type;

});
 </script>

     <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit Entry - <?php echo $name; ?></h4>
         </div>
        <div class="modal-body" >
        <div class="tabbable tabs-left">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#a" data-toggle="tab">Metadata </a></li>
          <li ><a href="#b" data-toggle="tab">Thumbnail</a></li>
        </ul>
        <div class="tab-content">
         <div class="tab-pane active" id="a">
          <div class="row" style="border: 0px solid red; margin-top: 5px;">
          <div class="pull-left border" style=" width: 55%; margin-left: 10px; padding-left: 10px">
          <form class="form-horizontal" method="post">
          <br/>    
           <div class="form-group">
            <label for="inputEmail" class="control-label col-xs-4">Publishing points:</label>
            <div class="col-xs-8 padding-right20">
                <p style="border: 0px solid green; margin-top: 5px;"><?php echo $primaryBroadcastingUrl; ?></p>  
            </div>
          </div>   
          <div class="form-group">
            <label for="inputEmail" class="control-label col-xs-4">Title :</label>
            <div class="col-xs-8 padding-right20">
                 <input type="text" class="form-control" id="entryname" placeholder="Entry Name" value="<?php echo $name; ?>">
            </div>
          </div>
         <div class="form-group">
            <label for="inputPassword" class="control-label col-xs-4">Description:</label>
            <div class="col-xs-8 padding-right20">
                <textarea class="form-control"  rows="3" id="entrydescription" name="entrydescription" placeholder="Description" ><?php echo $description; ?></textarea>
            </div>
        </div>
         <div class="form-group">
       <label for="entrytags" class="control-label col-xs-4">Tags:</label>
       <div class="col-xs-8 padding-right20">
       <input id="tags_1" type="text" class="tags form-control"  name="tags_1" value="<?php echo $tags; ?>"  placeholder="Enter tags :eg red,green,blue" />
      <div id="suggestions-container" style="position: relative; float: left; width: 200px;"></div>

       </div>
    </div>
         <div class="form-group">
            <label for="inputPassword" class="control-label col-xs-4">Categories:</label>
            <div class="col-xs-8 padding-right20">
             <?php 
              $filter = null;
              $pager = null;
              $res = $client->category->listAction($filter, $pager);
	      ?>
                <select id="example-getting-started" class="example-getting-started" multiple="multiple" >
              <?php 
                foreach ($res->objects as $ennn) { 
                   $parentId=$ennn->parentId;
                  if(($parentId)==0)
                   {
                      $names=$ennn->name;
                      $categoriesIdsdlist = explode(',',$categoriesIds);
                      if (in_array($ennn->id, $categoriesIdsdlist)) {
                      $selected="selected"; 
                      } else {
                      $selected="";
                    }
                ?>
                 <option <?php echo $selected;  ?> value="<?php echo $ennn->id; ?>"><?php echo ucwords(($names)); ?></option>
                        <?php }
                                 } ?>
                        </select>
				   
            </div>
        </div>
              <?php include_once('countries.php'); 
$country_code=  explode(",", $countrycode);
?> 
<div class="form-group">
       <label for="country_code" class="control-label col-xs-4">Country Code:</label>
<div class="col-xs-8">
  <select id="country_code" class="boot-multiselect-demo" multiple="multiple">
  <?php foreach ($countries as $key => $value) { 
          if(in_array($key, $country_code)){
              $sel="selected";
          }
          else
          {
           $sel="";
          }   
   ?>   
      <option value="<?php echo $key;?>" <?php echo $sel; ?> ><?php echo $value ?></option>
  <?php } ?>
</select>
       </div>
</div>  
              
<div class="form-group">
<div class="col-xs-offset-4 col-xs-6">
<?php  if(in_array(2, $UserRight)){ ?>
<button type="button" class="btn btn-primary" data-dismiss="modal" name="submit"  id="myFormSubmit" onclick="save_metedata_live_in_server('live_metadata_save','<?php echo $Entryid; ?>','<?php echo $getpageindex;  ?>');" >Save & Close</button>
<?php } else { ?>
<button type="button" class="btn btn-primary" data-dismiss="modal" name="submit" disabled>Save & Close</button>
<?php } ?>
</div>
</div>
</form>
           
</div>
          
<div class="pull-right border" style="width: 40%; margin-right: 10px;">
<div id="fp-dash" class="is-closeable" style="background-image:url(<?php echo $thumbnailUrl."/height/100/width/200"; ?>);"></div>   
</div>	

 
 </div>	
</div>
        
<div class="tab-pane" id="b">
	<div class="border0">
 
<?php  if(in_array(2, $UserRight)){ $disable1=""; } else {$disable1="disabled";} ?>

<form action="" method="post" enctype="multipart/form-data" id="uploadForm">
<div class="form-inline">
    <div class="form-group">
        <input type="file" class="inputFile" <?php echo $disable1; ?>  name="userImage" placeholder="select a File" id="image" onChange="validate_image(this.value)" required> 
      <input name="enteryID" value="<?php echo $Entryid; ?>" type="hidden" class="inputFile" />
    </div>
<button type="submit"  <?php echo $disable1; ?> class="btn btn-sm btn-primary btnSubmit" id="js-upload-submit">Upload files</button>
</div>
</form> 
<div id="flash_thumbnail"></div>                        	
<hr/>	
<div id="result_thumbnail" style="border: 0px solid red;">
</div>	 
<?php if(in_array(2, $UserRight)){ ?>

<button type="button" class="btn btn-primary margin" data-dismiss="modal" name="submit"  id="myFormSubmit" style="" onclick="save_thumbnail('saveandclose_thumnnail','<?php echo $Entryid; ?>','<?php echo $getpageindex;  ?>');" >Save & Close</button>
<?php } else { ?> 
	
<button type="button" class="btn btn-primary" disabled data-dismiss="modal" name="submit">Save & Close</button>
<?php } ?>
</div>
        </div>
      </div>  
       
      
       
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
       </div>
 </div>
<?php include_once 'ksession_close.php'; ?>
<script type="text/javascript">
    $(document).ready(function() { 
      $('.example-getting-started').multiselect();
      $('.boot-multiselect-demo').multiselect({ 
            includeSelectAllOption: true,
            buttonWidth: 250,
            enableFiltering: true });
       });
    
/*function save_metedata_live_in_server(livematadata,entryid,pageindex){
    var entryname = $('#entryname').val();	
    var entrydesc = $('#entrydescription').val();	
    var entrytags = $('#tags_1').val();	
    var entrycategores = $('#example-getting-started').val();
    var dataString ='laction='+livematadata+'&entryid='+entryid+'&entryname='+entryname+'&entrydesc='+entrydesc+'&entrytags='+entrytags+'&entrycategores='+entrycategores+'&pageindex='+pageindex;
    //alert(dataString)
     //$("#result").html();
     $.ajax({
           type: "POST",
           url: "live_channel_paging.php",
           data: dataString,
           cache: false,
           success: function(result){
             //alert(result);
             // $("#results").html('');
              //	 $("#flash").hide();
           	 $("#results").html(result);
           }
    });   
}
*/

function save_metedata_live_in_server(livematadata,entryid,pageindex){
    
    var publisher_unique_id="<?php  echo $publisher_unique_id ?>";
    var apiURl="<?php  echo $apiURL."/livefeed" ?>";
    var entryname = $('#entryname').val();	
    var entrydesc = $('#entrydescription').val();	
    var entrytags = $('#tags_1').val(); 	
    var entrycategores = $('#example-getting-started').val();
    var country_code=$('#country_code').val();
    var apiBody = new FormData();
    apiBody.append("partnerid",publisher_unique_id); 
    apiBody.append("entryid",entryid);
    apiBody.append("name",entryname);
    apiBody.append("description",entrydesc);
    apiBody.append("kal_tag",entrytags);
    apiBody.append("tag","update");
    apiBody.append("cat_id",entrycategores);
    apiBody.append("countrycode",country_code);
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
                      if(status=='updated Successfully')
                      {
                          $("#livemsg").html("Update successfully");
                          return true;
                      }
                    }
     }); 
}



function save_thumbnail(thumb,entryid,pageindex){
   var dataString ='thumb='+thumb+'&entryid='+entryid+'&pageindex='+pageindex;
    //alert(dataString)
     //$("#result").html();
    $.ajax({
           type: "POST",
           url: "live_channel_paging.php",
           data: dataString,
           cache: false,
           success: function(result){
             //alert(result);
             // $("#results").html('');
              //	 $("#flash").hide();
           	 $("#results").html(result);
           }
    });   
}



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
			     { //$('#result_thumbnail').load("thumbnail.php");
			     	   var enteryidd = "<?php echo $Entryid; ?>";
			     	   $('#result_thumbnail').load("thumbnail.php",{'entryid':enteryidd}); //load first group
			     }
			     else {  $("#result_thumbnail").html(data);}
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
     { var msg="Are Sure want to set this Thumbnail Default?";}
     if(action=="remove")
     { var msg="Are you sure you want to delete selected thumbnail?";}
    
     var a=confirm(msg)
     if(a==true)
     { 
     //$("#result").html();
      $.ajax({
           type: "POST",
           url: "thumbnail.php",
           data: dataString,
           cache: false,
           success: function(result){
             //alert(result);
           	 $("#result_thumbnail").html('');
           	// $("#flash").hide();
           	 $("#result_thumbnail").html(result);
           }
      });
      
     }
     else
     {  return false;  }
      
      
}

function changePagination_thumbnail(pageid){
     //$("#flash").show();
     //$("#flash").fadeIn(800).html('Loading <img src="img/image_process.gif" />');
      var enteryidd = "<?php echo $Entryid; ?>";
     var dataString ='first_load='+ pageid+'&entryid='+enteryidd;
     //$("#result").html();
     $.ajax({
           type: "POST",
           url: "thumbnail.php",
           data: dataString,
           cache: false,
           success: function(result){
          //  alert(result);
           	 $("#result_thumbnail").html('');
           	 //$("#flash").hide();
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
</script>
<script src="dist/jquery.tagsinput/src/jquery.tagsinput.js" type="text/javascript"></script>
<script src="dist/js/custom.js" type="text/javascript"></script>      
                 	


                 	

  
