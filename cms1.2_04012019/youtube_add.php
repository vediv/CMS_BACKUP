<?php
include_once 'corefunction.php';
//include_once("config.php");
?>
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
            <td class="h5" width="30%">Youtube WatchID</td>
            <td width="40%"><input  type="text" class="form-control" id="watchid"   placeholder="Enter watch ID from Youtube "></td>
            <td width="30%"><button type="button" class="button btn btn-info" onclick="GetYoutubeMatadata('<?php echo $publisher_unique_id; ?>')">Load Metadata</button>
            <span  id="wait"></span>
            </td>
           
            </tr>
           </table>
          
           <hr/>
          <div style="height:430px;overflow-y: scroll; overflow-x: hidden; display: block;">  
          <table class="custom-table"  border="0" >
            <tr>
            <td class="h5" colspan="1" width="20%">Video Status :</td>
            <td colspan="1" width="30%">
                <div class="btn-group btn-toggle" data-toggle="buttons">
                    <label class="btn btn-default"><input name="adstatus" value="active" type="radio" > ACTIVE </label>
                    <label class="btn  btn-primary active"> <input name="adstatus" value="inactive" checked="" type="radio"> INACTIVE</label>
                 </div>
            </td>
            <td colspan="1" width="35%">Duration: <input type="text" id="duration" readonly size="10" ></td>
            <td colspan="1" width="15%"><div id="thumbnail"></div> <input type="hidden" id="thumbnail_set" > </td>
             </tr>
            <tr>
            <td class="h5" colspan="1">Title :</td>
            <td colspan="3"><input type="text" class="form-control" name="entryname" id="entryname" placeholder="Entry Name" ></td>
            </tr>
            <tr>
            <td class="h5" colspan="1">Description :</td>
            <td colspan="3"><textarea class="form-control" rows="3" id="entrydescription" name="entrydescription" placeholder="Description" ></textarea></td>
            </tr>
            <tr>
            <td class="h5" colspan="1">Tags :</td>
            <td colspan="3"><textarea class="form-control" rows="3" id="entrytags" name="entrytags" placeholder="tags" ></textarea></td>
            </tr>
            <tr>
            <td class="h5" colspan="1">Categories :</td>
            <td colspan="3">
                <div class="col-md-12" id="drawCategory">
                <span id="wait_loader_category_youtube"></span>
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
<tr>
    <td class="h5">Start Date: </td>
    <td><input id="start_date" type="text" class="tags form-control"  name="start_date"   placeholder="Enter Start date YYYY-mm-dd" /></td>
    <td  class="h5">End date :</td>
    <td><input id="end_date" type="text" class="tags form-control"  name="end_date"   placeholder="Enter End date YYYY-mm-dd" /></td>
</tr>
<tr>
    <td class="h5">Content Partner : </td>
    <td> <?php 
     $sel="Select contentpartnerid,name from content_partner where status='1' order by name";
     $fet=db_select($conn,$sel);
     ?>
      <select class="selectpicker" name="content_partner" id="content_partner" style="width: 250px;">
       <option value="">Select Content Partner</option>
               <?php foreach ($fet as $val) 
               {  $cid=$val['contentpartnerid'];  
                  $cname=$val['name']; 
                  $sel=$cid==$contentpartnerid?"selected":'';
               ?>
               <option value="<?php echo $cid;  ?>" <?php echo $sel; ?>><?php echo $cname." (".$cid.")";  ?></option>
               <?php } ?>
       </select>    
    </td>
    <td  class="h5">Country Code :</td>
    <td><div class="col-xs-8" id="drawCountryCode"> 
 <span id="wait_loader_country"></span>   
</div></td>
</tr>
            
           </table> 
           </div> 
 <br/>    
<div class="form-group">
<div class="col-xs-offset-2 col-xs-10">
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

<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
<script>  var partnerid="<?php echo $publisher_unique_id;  ?>";</script>
<script src="dist/js/custom.js" type="text/javascript"></script>      
<script src="js/youtube.js" type="text/javascript"></script>
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
    var startdate = $('#start_date').val();	
    var enddate = $('#end_date').val();	 
    var contentpartner = $('#content_partner').val();
    var countrycode = $('#country_code').val();	 
     var entrycategores = $('#category_value').val();
     //var entrycategores=finald.slice(0, -1);
       var apiBody = new FormData();
       apiBody.append("partnerid",partnerid);
       apiBody.append("watch_id",watch_id);
       apiBody.append("name",entryname); 
       apiBody.append("long_desc",longdesc); 
       apiBody.append("tags",entrytags);
       apiBody.append("categoryid",entrycategores); 
       apiBody.append("short_desc",shortdesc); 
       apiBody.append("sgenre",subgenre);
       apiBody.append("pgrating",pgrating);
       apiBody.append("language",lang);
       apiBody.append("producer",producer);
       apiBody.append("director",director);
       apiBody.append("cast",cast);
       apiBody.append("crew",crew);
       apiBody.append("start_date",startdate);
       apiBody.append("end_date",enddate);
       apiBody.append("contentpartner",contentpartner);
       apiBody.append("country_code",countrycode);
       apiBody.append("status",adstatus);
       apiBody.append("duration",duration);
       apiBody.append("thumbnail",thumbnail_set);
       apiBody.append("subtag","add");
       apiBody.append("tag","video_entry");
        $.ajax({
                url:apiURL,
                method: 'POST',
                dataType: 'json', 
                data:apiBody,
                processData: false,
                contentType: false,
                    success: function(jsonResult){
                       console.log(jsonResult);
                       //window.location.href="youtube_content.php?msg=success";
                    }
            });	 
      
}
</script>
