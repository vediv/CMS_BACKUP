<?php include_once 'corefunction.php';?>
<style type="text/css">
.form-control {    display: block;    width: 100%;    height: 25px; padding: 0 8px; font-size: 12px;}
    h5, .h5 {    font-size: 13px;} .custom-table td { padding: 3px 3px !important;}
    .height-56{height: 56px;}
    textarea.form-control {    height: 56px !important;}
    .well {    padding: 19px;    margin-bottom: 2px;    background-color: transparent;}
    </style>
<link href="bootstrap/css/youtube.css" rel="stylesheet" type="text/css">
<div class="modal-header">
                <button type="button" class="close"  data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="myModalLabel">
                  <b>Add From Youtube</b>
                </h4>
            </div>    
<div class="modal-body" style="border:0px solid red;"> 
 <div class="tabbable tabs-left">
        <ul class="nav nav-tabs">
       <li class="active h5"><a href="#youtube_metadata" data-toggle="tab">VIDEO</a></li>
        <li class="h5"><a href="#youtubechannel" data-toggle="tab" >CHANNEL</a></li>
        </ul>
<div class="tab-content">
        <div class="tab-pane active" id="youtube_metadata">
        <div class="row" style="border: 0px solid red; margin: 5px 5px 5px 10px; ">
            <form class="form-horizontal" method="post" id="imageform" action="javascript:">
            <table class="custom-table" border='0'>
            <tr>
            <td class="h5" width="9%">Youtube WatchID</td>
            <td width="14%"><input  type="text" class="form-control" id="watchid"   placeholder="Enter watch ID from Youtube "></td>
            <td width="30%"><button type="button"  class="button btn btn-info" style="padding: 2px 12px" onclick="GetYoutubeMatadata('<?php echo $publisher_unique_id; ?>')">Load Metadata</button>
            <span  id="wait"></span>
            </td>
           
            </tr>
           </table>
          
           <hr/>
          <!--<div style="height:348px;overflow-y: scroll; overflow-x: hidden; display: block;"> --> 
           <div style="">
         
            <td class="h5" colspan="1" width="20%">Video Status :</td>
            <td colspan="1" width="30%" style="margin-bottom: 12px">
                <div class="btn-group btn-toggle" data-toggle="buttons" style="margin-bottom: 5px;">
                    <label class="btn btn-default" style="padding: 2px 12px"><input name="adstatus" value="active" type="radio" > ACTIVE </label>
                    <label class="btn  btn-primary active" style="padding: 2px 12px"> <input name="adstatus" value="inactive" checked="" type="radio"> INACTIVE</label>
                 </div>
            </td>
            <td colspan="1" width="35%" style="margin-left: 45px">Duration: <input type="text" id="duration" readonly size="10" ></td>
            <td colspan="1" width="15%"><div id="thumbnail" style="float: right; margin-bottom: 9px; margin-right: 5px;"></div> <input type="hidden" id="thumbnail_set"> </td>
            </tr>
            <tr>
            	 <table class="custom-table"  border="1" BORDERCOLOR="#ccc">
            <tr>
            </tr>
            <tr>
            	 <td class="h5" colspan="1">Title :</td>
            <td colspan="1"><input type="text" class="form-control" name="entryname" id="entryname" placeholder="Entry Name" ></td>
           
            <td class="h5" colspan="1">Description :</td>
            <td colspan="1"><textarea class="form-control" rows="3" id="entrydescription" name="entrydescription" placeholder="Description" ></textarea></td>
            </tr>
           <!--
            <tr>
                       <td class="h5" colspan="1">Tags :</td>
                       <td colspan="3"><textarea class="form-control" rows="3" id="entrytags" name="entrytags" placeholder="tags" ></textarea></td>
                       </tr>-->
           
            <tr>
            	<td class="h5" colspan="1">Tags :</td>
            <td colspan="1"><textarea class="form-control" rows="3" class="height-56"  id="entrytags" name="entrytags" placeholder="tags" ></textarea></td>
            
            <td class="h5" colspan="1">Categories :</td>
            <td colspan="1">
             <!--   <div class="col-xs-12">-->
        <input type="text" size="10" name="category_metadata"  placeholder="Category" id="input-category" class="form-control" />
         <div id="metadata-category" class="well well-sm" style="height:50px; width: 100%; overflow: auto;">
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
                  <input type="hidden" name="metadata_category[]"  value="<?php echo $fcategory['category_id'];  ?>" />
              </div>
           <?php } 
              }  ?>
        <!--</div>-->
        </div>  
            </td>    
</tr>
<tr>
    <td class="h5">Short Description :</td>
    <td><input  type="text" class="tags form-control" id="short_desc"  name="short_desc"  placeholder="Enter Short description" /></td>
    <td  class="h5">Sub-Genre :</td>
    <td> <input id="sub_genre" type="text" class="form-control"  name="sub_genre"   placeholder="Enter Sub-Genre" /></td>
</tr>
<tr>
    <td class="h5">PG-Rating :</td>
    <td><input id="pg_rating" type="text" class="form-control"  name="pg_rating"   placeholder="Enter PG Rating" /></td>
    <td  class="h5">Language :</td>
    <td> <input id="lang" type="text" class="form-control"  name="lang"  placeholder="Enter Language" /></td>
</tr>
<tr>
    <td class="h5">Producer: </td>
    <td><input id="producer" type="text" class="form-control"  name="producer"   placeholder="Enter Producer" /></td>
    <td  class="h5">Director :</td>
    <td>  <input id="director" type="text" class="tags form-control"  name="director"   placeholder="Enter Director" /></td>
</tr>
<tr>
    <td class="h5">Cast: </td>
    <td> <input id="cast" type="text" class="tags form-control"  name="cast"   placeholder="Enter Cast" /></td>
    <td  class="h5">Crew :</td>
    <td>  <input id="crew" type="text" class="tags form-control"  name="crew"   placeholder="Enter Crew" /></td>
</tr>
</table> 
</div> 
<br/>    
<div class="form-group">
<div class="col-xs-offset-5 col-xs-10  col-md-2">
<?php  if(in_array(2, $UserRight)){ ?>    
  <button type="button" class="btn btn-primary btn1" disabled data-dismiss="modal1" name="submit"  id="myFormSubmit" onclick="save_youtube_metedata('<?php echo $publisher_unique_id;  ?>');" >Save & Close</button>
<?php } else{ ?>
  <button type="button" class="btn btn-primary" data-dismiss="modal" name="submit" disabled>Save & Close</button> 
<?php } ?> 
</div>
</div>      
           </form>
           
        </div>
        
        </div>
        
<?php 
$sql="SELECT category_id,parent_id,LCASE(cat_name) as cat_name FROM categories where category_id=(SELECT category_id FROM categories WHERE cat_name='YT CASE') OR parent_id=(SELECT category_id FROM categories WHERE cat_name='YT CASE')";
//$sql="SELECT category_id,parent_id,LCASE(cat_name) as cat_name FROM categories ";
$result=db_select($conn,$sql);
$categoryArr=json_encode($result);
?>        
<script> var catArray='<?php echo  $categoryArr; ?>';</script>           

        <div class="tab-pane" id="youtubechannel" > <!-- youtube channel-->
            <div class="row">
                <br>
                <div class="col-sm-8">
                    <form method="Post" action="javascript:" onsubmit="getPlaylist(this);return false;">
                        <table class="custom-table"><tr><td class="h5">Channel Id</td><td><input type="text" name="channelid" required="" class="form-control" placeholder="Enter your channel id."></td><td><button type="submit" class="button btn btn-info">Load Playlist</button></td></tr></table>
                    </form>
                </div>
                <div class="col-sm-12"><hr></div> 
                </div>  
            
            
                <div class="row">
                
                <div class="col-sm-4 " >
                    <h4 class="border-bottom">Playlist</h4>
                    <div id="getPlaylist"></div>  
                </div> 
                
                <div class="col-sm-5 " >
                    <h4 class="border-bottom">Playlist Videos</h4>
                    <div id="getPlaylistVideo"></div>
                </div> 
                
                <div class="col-sm-3 ">
                    <h4 class="border-bottom">Selected <span id="basketTitle"></span></h4>
                    <div id="categoryTree"></div>
                    <div class="basket" id="basketContainer">
                    
                    <div id="basketData"></div>   
                    </div>
                </div>
                
                
            </div>               
        </div> <!-- !youtube channel-->
     
</div>
    </div>  
</div>

<!-- <div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div> -->
<script>  var partnerid="<?php echo $publisher_unique_id;  ?>";</script>
<script src="dist/js/custom.js" type="text/javascript"></script>      
<script src="js/youtube.js" type="text/javascript"></script>
<script src = "js/autocomplete.js"></script>
<script type="text/javascript">
$('.btn-toggle').click(function() {
    $(this).find('.btn').toggleClass('active');  
    
    if ($(this).find('.btn-primary').size()>0) {
    	$(this).find('.btn').toggleClass('btn-primary');
    }
   $(this).find('.btn').toggleClass('btn-default');
       
});
drawCateory();
function drawCateory()
{
    $("#wait_loader_category_youtube").fadeIn(400).html('Loading... <img src="img/image_process.gif" />');
    var dataString ='action=category_in_youtube';
    $.ajax({                                                                                                                                        
    type: "POST",
    url: "ajax_common.php",
    data: dataString,
    cache: false,
    success: function(r){
      $("#wait_loader_category_youtube").hide(); 
      $("#drawCategory").html(r);
      drawCountry();
      }
      
    });  
}
function drawCountry()
{
    $("#wait_loader_country").fadeIn(400).html('Loading... <img src="img/image_process.gif" />');
    var dataString ='action=countryCode_in_youtube_add';
    $.ajax({                                                                                                                                        
    type: "POST",
    url: "ajax_common.php",
    data: dataString,
    cache: false,
    success: function(r){
     $("#wait_loader_country").hide(); 
     $("#drawCountryCode").html(r); 
    }
      
    });  
}
</script>

<script type="text/javascript">
function GetYoutubeMatadata(partnerid)
{
    var watchID=document.getElementById("watchid").value;
    if(watchID==''){ alert("enter watchid from youtube"); return false;}
    $("#wait").fadeIn(100).html('Wait <img src="img/image_process.gif" />');
    var apiURL="<?php  echo $apiURL."/youtube" ?>";
       var apiBody = new FormData();
       apiBody.append("partnerid",partnerid);
       apiBody.append("watch_id",watchID);
       apiBody.append("tag","get_meta");
        $.ajax({
                url:apiURL,
                method: 'POST',
                dataType: 'json', 
                data:apiBody,
                processData: false,
                contentType: false,
                    success: function(jsonResult){
                       console.log(jsonResult); 
                       var meta=jsonResult.meta[0];
                       var title=meta.title; var desc=meta.description; var duration=meta.duration;
                       var tags=meta.tags;  var language=meta.language; var thumbnail=meta.thumbnail;
                       $("#entryname").val(title);  $("#entrydescription").val(desc); 
                       $('#entrytags').val(tags); $('#lang').val(language); $('#duration').val(duration);
                       $('#thumbnail').val(thumbnail); $('#thumbnail_set').val(thumbnail);
                       $('#myFormSubmit').prop("disabled", false);
                       $("#wait").hide();
                       var previewhumb='<img src="'+thumbnail+'" height="70" width="150" >'
                       document.getElementById("thumbnail").innerHTML=previewhumb;
                    }
            });	
}
function save_youtube_metedata(partnerid)
{ 
    var watch_id=document.getElementById("watchid").value;
    var apiURL="<?php  echo $apiURL."/youtube" ?>";
    var adstatus = $("input[name='adstatus']:checked").val();
    var duration= $('#duration').val();
    var thumbnail_set= $('#thumbnail_set').val();
    var entryname = $('#entryname').val(); 
    var longdesc = $('#entrydescription').val();	
    var entrytags = $('#entrytags').val();	  
    var shortdesc = $('#short_desc').val();	
    var subgenre = $('#sub_genre').val();  
    var pgrating = $('#pg_rating').val();	
    var lang = $('#lang').val(); 
    var producer = $('#producer').val();	
    var director = $('#director').val();  
    var cast = $('#cast').val();	
    var crew = $('#crew').val();  
    //var startdate = $('#start_date').val();	
    //var enddate = $('#end_date').val();	 
    //var contentpartner = $('#content_partner').val();
    //var countrycode = $('#country_code').val();	 
    var category=''; 
    var bulk_category = document.getElementsByName('metadata_category[]');
    for (var x = 0; x < bulk_category.length; x++) { 
           category += bulk_category[x].value+',';
        }
    var categoryids=category.slice(0, -1);
    var apiBody = new FormData();
       apiBody.append("partnerid",partnerid);
       apiBody.append("watch_id",watch_id);
       apiBody.append("name",entryname); 
       apiBody.append("long_desc",longdesc); 
       apiBody.append("tags",entrytags);
       apiBody.append("categoryid",categoryids); 
       apiBody.append("short_desc",shortdesc); 
       apiBody.append("sgenre",subgenre);
       apiBody.append("pgrating",pgrating);
       apiBody.append("language",lang);
       apiBody.append("producer",producer);
       apiBody.append("director",director);
       apiBody.append("cast",cast);
       apiBody.append("crew",crew);
       //apiBody.append("start_date",startdate);
       //apiBody.append("end_date",enddate);
       //apiBody.append("contentpartner",contentpartner);
       //apiBody.append("country_code",countrycode);
       apiBody.append("status",adstatus);
       apiBody.append("duration",duration);
       apiBody.append("thumbnail",thumbnail_set);
       apiBody.append("subtag","add");
       apiBody.append("tag","video_entry");
      
       //return false;
       $.ajax({
                url:apiURL,
                method: 'POST',
                dataType: 'json', 
                data:apiBody,
                processData: false,
                contentType: false,
                    success: function(jsonResult){
                       console.log(jsonResult);
                       window.location.href="youtube_content.php";
                    }
            });	 
      
}

$('input[name=\'category_metadata\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'ajax_common.php?action=category_in_youtube_case&filter_name='+request,
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

