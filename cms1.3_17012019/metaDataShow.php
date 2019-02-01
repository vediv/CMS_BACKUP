<?php
include_once 'corefunction.php';
include_once("config.php"); 
$Entryid=$_POST['Entryid']; $getpageindex=$_POST['pageindex']; 
$limitval=$_POST['limitval']; $searchInputall=$_POST['searchInputall'];
$entryId = $Entryid;
$version = null;
$result = $client->baseEntry->get($entryId, $version);
//print '<pre>'.print_r($result, true).'</pre>';
$name=$result->name; 
$description=$result->description;
$tags=$result->tags;
$categoriesIds=$result->categoriesIds;
$Creator=$result->creatorId;  
$createdAt=$result->createdAt;
$plays=$result->plays; 
$duration=$result->duration; 
$msDuration=$result->msDuration ;
$mediaType=$result->mediaType;   
$mdeitype= $mediaType==1 ? "video" : "";
$moderationStatus=$result->moderationStatus;
$moderationStatus_main= $moderationStatus==6 ? "Auto approved" : "";
$thumbnailUrl=$result->thumbnailUrl;
$dataUrl=$result->dataUrl;
//$dataUrl=$result->dataUrl."/a.m3u8";
//$resDataUrl=str_replace("url","applehttp",$dataUrl);
$selEntry="select shortdescription,sub_genre,pgrating,language,
producer,director,cast,crew,startdate,enddate,contentpartnerid,countrycode,video_status,custom_data
from entry where entryid='$Entryid'";
$f= db_select($conn,$selEntry);
$shortdesc=$f[0]['shortdescription']; $sub_genre=$f[0]['sub_genre']; $pgrating=$f[0]['pgrating'];
$language=$f[0]['language']; $producer=$f[0]['producer']; $director=$f[0]['director'];
$cast=$f[0]['cast']; $crew=$f[0]['crew']; $startdate=$f[0]['startdate']; $enddate=$f[0]['enddate'];
$contentpartnerid=$f[0]['contentpartnerid']; $countrycode=$f[0]['countrycode'];
$video_status=$f[0]['video_status']; $custom_data_json=$f[0]['custom_data'];
?> 
<div class="row" style="border: 0px solid red; margin-top: 5px;">
 <div class="pull-left" style=" border:0px solid #c7d1dd ; border-top:0px ; width: 55%; margin-left: 10px;">
     <form class="form-horizontal" method="post" id="metaDataForm" name="metaDataForm">
    <div style="height:430px;overflow-y: scroll; overflow-x: hidden; display: block;">
    <div class="form-group">
        <label for="entryname" class="control-label col-xs-3">Title *:</label>
        <div class="col-xs-8">
            <input type="text" class="form-control" name="entryname" id="entryname" placeholder="Entry Name" maxlength="35" value="<?php echo htmlentities($name); ?>">
            <input type="hidden" class="form-control" name="duration" id="duration" value="<?php echo $duration; ?>">
             <span class="help-block has-error" id="entryname-error" style="color:red;"></span>
        </div>
    </div>
    <div class="form-group">
       <label for="entrydescription" class="control-label col-xs-3">Description:</label>
       <div class="col-xs-8">
           <textarea class="form-control" rows="3" id="entrydescription" maxlength="1000" style="resize: none;" name="entrydescription" placeholder="Description" ><?php echo $description; ?></textarea>
       </div>
    </div>
    <div class="form-group">
        <label for="tags_1" class="control-label col-xs-3">Tags:</label>
        <div class="col-xs-8" id="drawTags">
            <span id="wait_loader_tags"></span>
        </div>
    </div>    
    <div class="form-group">
        <label for="category_value" class="control-label col-xs-3">Categories:</label>
        <div class="col-xs-8">
        <input type="text" size="10" name="category_metadata" value="" placeholder="Category" id="input-category" class="form-control" />
         <div id="metadata-category" class="well well-sm" style="height:70px; width: 100%; overflow: auto;">
            <?php
              if($categoriesIds=='')
               {
                  $qcategory="SELECT category_id,fullname FROM categories  WHERE category_id IN ('$categoriesIds')";
               }
              if($categoriesIds!='')
              {
                  $qcategory="SELECT category_id,fullname FROM categories  WHERE category_id IN ($categoriesIds)";
              }    
              $fetchCategory= db_select($conn,$qcategory);
              $totalRow= db_totalRow($conn,$qcategory);
              if($totalRow>0){
              foreach($fetchCategory as $fcategory) 
                 {   
              ?>
              <div id="metadata-category<?php echo $fcategory['category_id'];  ?>"><i class="fa fa-minus-circle"></i> <?php echo $fcategory['fullname'];  ?> 
              <input type="hidden" name="metadata_category[]" value="<?php echo $fcategory['category_id'];  ?>" />
              </div>
           <?php } 
              }  ?>
        </div>
        </div>  
        <!--<div class="col-xs-8" id="drawCategory">
            <span id="wait_loader_category"></span>
        </div>-->
    </div>

    <div class="form-group">
    <label for="inputPassword" class="control-label col-xs-3">Status:</label>
        <div class="col-xs-8">
        <select name="video_status" id="video_status" style="width: 310px;">
            <option  value="inactive" <?php echo $video_status=='inactive'?"selected":''; ?>>INACTIVE</option>
            <option value="active" <?php echo $video_status=='active'?"selected":''; ?>>ACTIVE</option>
        </select>
        </div>
     </div>  
        <div class="form-group">
               <label for="short_desc" class="control-label col-xs-3">Short Description:</label>
               <div class="col-xs-8">
                   <input id="short_desc" type="text" class="tags form-control" maxlength="300" name="short_desc" value="<?php echo $shortdesc; ?>"  placeholder="Enter Short description" />
               <div id="suggestions-container" style="position: relative; float: left; width: 200px;"></div>
               </div>
        </div>
   
      <div class="form-group">
       <label for="sub_genre" class="control-label col-xs-3">Sub-Genre:</label>
       <div class="col-xs-8">
       <input id="sub_genre" type="text" class="tags form-control" maxlength="35"  name="sub_genre" value="<?php echo $sub_genre; ?>"  placeholder="Enter Sub-Genre" />
       <div id="suggestions-container" style="position: relative; float: left; width: 200px;"></div>
       </div>
      </div>
    
      <div class="form-group">
       <label for="pg_rating" class="control-label col-xs-3">PG-Rating:</label>
       <div class="col-xs-8">
       <input id="pg_rating" type="text" class="tags form-control" maxlength="35"  name="pg_rating" value="<?php echo $pgrating; ?>"  placeholder="Enter PG Rating" />
      <div id="suggestions-container" style="position: relative; float: left; width: 200px;"></div>
       </div>
       </div>
    
    
      <div class="form-group">
       <label for="lang" class="control-label col-xs-3">Language:</label>
       <div class="col-xs-8">
       <input id="lang" type="text" class="tags form-control"  maxlength="35" name="lang" value="<?php echo $language; ?>"  placeholder="Enter Language" />
      <div id="suggestions-container" style="position: relative; float: left; width: 200px;"></div>
       </div>
    </div>
      <div class="form-group">
       <label for="producer" class="control-label col-xs-3">Producer:</label>
       <div class="col-xs-8">
       <input id="producer" type="text" class="tags form-control"  maxlength="35" name="producer" value="<?php echo $producer; ?>"  placeholder="Enter Producer" />
      <div id="suggestions-container" style="position: relative; float: left; width: 200px;"></div>
       </div>
    </div>
      <div class="form-group">
       <label for="director" class="control-label col-xs-3">Director:</label>
       <div class="col-xs-8">
       <input id="director" type="text" class="tags form-control" maxlength="35" name="director" value="<?php echo $director; ?>"  placeholder="Enter Director" />
      <div id="suggestions-container" style="position: relative; float: left; width: 200px;"></div>
       </div>
    </div>
      <div class="form-group">
       <label for="cast" class="control-label col-xs-3">Cast:</label>
       <div class="col-xs-8">
       <input id="cast" type="text" class="tags form-control"  maxlength="35"  name="cast" value="<?php echo $cast; ?>"  placeholder="Enter Cast" />
      <div id="suggestions-container" style="position: relative; float: left; width: 200px;"></div>
       </div>
    </div>
    
     <div class="form-group">
       <label for="crew" class="control-label col-xs-3">Crew:</label>
       <div class="col-xs-8">
       <input id="crew" type="text"  class="tags form-control" maxlength="35" name="crew" value="<?php echo $crew; ?>"  placeholder="Enter Crew" />
      <div id="suggestions-container" style="position: relative; float: left; width: 200px;"></div>
       </div>
     </div>
    <div class="form-group">
       <label for="crew" class="control-label col-xs-3">Custom Data:</label>
       <div class="col-xs-8">
           <button type="button" class="btn btn-default" maxlength="35" onclick="addRow()" id="addRowBtn" > <i class="glyphicon glyphicon-plus-sign"></i> Add Custom Data </button>
       </div>
     </div>
     <div  style="border:0px solid red;">
     <table class="table" id="productTable" >
         <tbody>
        <?php 
        $json_customdata  = json_decode($custom_data_json, true);
        $customDataCount  = count($json_customdata);
        if($customDataCount>0){
        $arrayNumber = 0;
        $x=1;
        foreach($json_customdata as $keyDesc => $Keyvalue) {
         ?>
          <tr id="row<?php echo $x; ?>" class="<?php echo $arrayNumber; ?>">			  				
            <td style="padding-left:20px;">			  					
                <input type="text" name="key_desc[]" id="key_desc<?php echo $x; ?>" maxlength="35"  placeholder="key name" value="<?php echo $keyDesc; ?>" class="form-control" />			  					
              <span class="help-block has-error" id="key_desc<?php echo $x; ?>-error" style="color:red;"></span>
            </td>
            <td style="padding-left:20px;">
               <input type="text" name="key_val[]" id="key_val<?php echo $x; ?>"  maxlength="35" placeholder="key value" value="<?php echo $Keyvalue; ?>" class="form-control"  />
               <span class="help-block has-error" id="key_val<?php echo $x; ?>-error" style="color:red;"></span>
            </td>
           <td>
	  <button class="btn btn-default removeProductRowBtn" type="button" id="removeProductRowBtn" onclick="removeProductRow(<?php echo $x; ?>)"><i class="glyphicon glyphicon-trash"></i></button>
          </td> 
          </tr>
        <?php
        $x++;
        $arrayNumber++;
            } 
          
        }
        ?>
         </tbody>			  	
     </table>
     </div>
     
  
  
  
</div>
<br/>
<div class="form-group">
<div class="col-xs-offset-2 col-xs-10">
<?php  if(in_array(1, $UserRight)){ ?>    
<!--<button type="button" class="btn btn-primary btn1"  disabled  id="only_save_button" name="save_only_submit"   onclick="save_metedata_in_server('only_save','<?php echo $Entryid; ?>','<?php echo $getpageindex;  ?>','<?php echo $limitval;  ?>');" >Save</button>-->
<button type="button" class="btn btn-primary btn1"  disabled  id="save_button" name="submit"   onclick="save_metedata_in_server('saveClose','<?php echo $Entryid; ?>','<?php echo $getpageindex;  ?>','<?php echo $limitval;  ?>');" >Save & Close</button>
<span id="saving_matadata"> </span>
<?php } else{ ?>
  <!--<button type="button" class="btn btn-primary" data-dismiss="modal"  name="submit" disabled>Save & Close</button>-->
  <button type="submit" class="btn btn-primary" data-dismiss="modal1"  name="submit" disabled>Save & Close</button>
<?php } ?> 
</div>
</div>
</form>

</div> 
<div class="pull-right" id="drawVideoPlayer11"  style="border:1px solid #c7d1dd ; width: 40%; margin-right: 5px; padding:5px; height: 400px;">
    <!--<span id="wait_loader_videoPlay" style="margin: 0 auto;" ></span>-->
    <?php include_once 'metaDetaPlayer.php'; ?>
    
</div>	 
</div>
<?php include_once 'ksession_close.php';  ?>
<script src = "js/autocomplete.js"></script>
<script type="text/javascript">
drawTags('<?php echo $entryId; ?>');  
function drawTags(entryid)
{
    $("#wait_loader_tags").fadeIn(400).html('Loading... <img src="img/image_process.gif" />');
    var dataString ='action=tags_in_metaData&entryid='+entryid;
    $.ajax({                                                                                                                                        
    type: "POST",
    url: "ajax_common.php",
    data: dataString,
    cache: false,
    success: function(result){
        $("#wait_loader_tags").hide();
        $("#drawTags").html(result);
        drawCateory(entryid);
       
     }
    });  
}
function drawCateory(entryid)
{
    $("#wait_loader_category").fadeIn(400).html('Loading... <img src="img/image_process.gif" />');
    var dataString ='action=category_in_metaData&entryid='+entryid;
    $.ajax({                                                                                                                                        
    type: "POST",
    url: "ajax_common.php",
    data: dataString,
    cache: false,
    success: function(r){
      $("#wait_loader_category").hide(); 
      $("#drawCategory").html(r);
      $('#save_button').attr('disabled',false);
      //videoplay(entryid);
      
      }
      
    });  
}

function videoplay(entryid)
{
    $("#wait_loader_videoPlay").fadeIn(400).html('Loading Media... <img src="img/image_process.gif" />');
    var dataString ='action=player_in_metaData&entryid='+entryid;
    $.ajax({                                                                                                                                        
    type: "POST",
    url: "ajax_common.php",
    data: dataString,
    cache: false,
    success: function(r){
     $("#wait_loader_videoPlay").hide(); 
     $("#drawVideoPlayer").html(r); 
    }
      
    });  
}
var searchInputall="<?php echo $searchInputall ?>"; 
function save_metedata_in_server(smatadata,entryid,pageindex,limitval){
    $(".has-error").html(''); 
    var entryname = $('#entryname').val();
    if(entryname=='')
       {
            var message="Entry Name should not be blank";
            $("#entryname-error").html(message);
            return false;
       }
    var entrydesc = $('#entrydescription').val();	
    var entrytags = $('#tags_1').val();	
    var shortdesc = $('#short_desc').val();	
    var subgenre = $('#sub_genre').val();	
    var pgrating = $('#pg_rating').val();	
    var lang = $('#lang').val();	
    var producer = $('#producer').val();	
    var director = $('#director').val();	
    var cast = $('#cast').val();	
    var crew = $('#crew').val();	
    var entrycategores = $('#category_value').val();
    var video_status = $('#video_status').val();
    var key_descName = document.getElementsByName('key_desc[]');
    var validateProduct=true;
    //var pattern=/^[A-Za-z]*$/;
    var pattern=/^[0-9A-Za-z-_#|\s]+$/;
    for (var x = 0; x < key_descName.length; x++) {     
    var key_desc_name_id = key_descName[x].id;
        if(key_descName[x].value == '')
         {	    		    	
            $("#"+key_desc_name_id+"-error").html('Key Name Field is required!');
            validateProduct = false;
            
         }
         else if(!key_descName[x].value.match(pattern))
         { 
           var mess="(Please input alphabet characters only with underscore.)  Eg:music_dir"; 
           $("#"+key_desc_name_id+"-error").html(mess);
           validateProduct = false;
           
         }   
     }
      /*for (var x = 0; x < key_descName.length; x++) {       						
		    if(key_descName[x].value){	    		    		    	
		    	validateProduct = true;
	      } else {      	
		    	validateProduct = false;
	      }          
      }*/
    var key_val = document.getElementsByName('key_val[]');
      var validateKeyVal=true;
        for (var x = 0; x < key_val.length; x++) {       
            var key_val_Id = key_val[x].id;
             if(key_val[x].value == ''){	
                $("#"+key_val_Id+"-error").html('Key value Field is required!');
                validateKeyVal = false
               }
              else if(!key_val[x].value.match(pattern))
              { 
                var mess="(Please enter alphanumeric value with #_-)  Eg:test123,test-123,#test_23, test 123"; 
                $("#"+key_val_Id+"-error").html(mess);
                validateKeyVal = false;
              }  
        }  
      /*for (var x = 0; x < key_val.length; x++) {       						
            if(key_val[x].value){	    		    		    	
                validateKeyVal = true;
           } else {      	
                validateKeyVal = false;
             }          
         } */
     console.log(validateProduct+"-------------"+validateKeyVal);
     if(validateProduct == false || validateKeyVal == false) { return false; }
     $("#saving_matadata").fadeIn(400).html('Saving... <img src="img/image_process.gif" />');
     $('#save_button').attr('disabled',true);
     $.ajax({
      method : 'POST',
      url : 'media_paging.php',
      data : $('#metaDataForm').serialize() +
              "&entryid="+entryid+"&maction=saveandclose_metadata&pageindex="+pageindex+"&limitval="+limitval+"&searchInputall="+searchInputall,
      success: function(jsonResult){
            if(smatadata=='saveClose') { 
                $("#saving_matadata").hide(); 
                $('#myModalVodEdit').modal('hide');
                $("#results").html(jsonResult);
                $("#msg").html("MetaData saved successfully");
            }
            if(smatadata=='only_save')
            {
                $("#saving_matadata").hide(); 
                $('#myModalVodEdit').modal('show');
                //$("#results").html(jsonResult);
                $("#msg").html("MetaData saved successfully");
            }
        }
      });  
  
}



$('input[name=\'category_metadata\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'ajax_common.php?action=category_in_metaData&filter_name='+request,
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['fullname'],
						value: item['category_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'category_metadata\']').val('');
		
		$('#metadata-category' + item['value']).remove();
		
		$('#metadata-category').append('<div id="metadata-category' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="metadata_category[]" value="' + item['value'] + '" /></div>');
	}	
});
        $('#metadata-category').delegate('.fa-minus-circle', 'click', function() {
                $(this).parent().remove();
        });
</script>
<script src="js/add_custom_row.js" type="text/javascript"></script>