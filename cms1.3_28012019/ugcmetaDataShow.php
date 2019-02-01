<?php
include_once 'corefunction.php';
$Entryid=$_POST['Entryid']; $getpageindex=$_POST['pageindex']; 
$limitval=$_POST['limitval']; $searchInputall=$_POST['searchInputall'];
$entryId = $Entryid;
$selEntry=" select * from ugc_entry where id='$Entryid'";
$f= db_select($conn,$selEntry);
$name=$f[0]['title'];$tag=$f[0]['tag']; $status=$f[0]['status'];
$description=$f[0]['description'];
$video_path=$f[0]['video_name'];
//$fileName = basename($video_path1);
//$video_path="ugc_video/$fileName";
$userID=$get_user_id;
?> 
<link rel="stylesheet" href="layouts/css/flowplayer.css"/>
   <script type="text/javascript" src="layouts/js/flowplayer.js"></script>
   <script type="text/javascript" src="layouts/js/flowplayer.hlsjs.light.min.js"></script>

<div class="row" style="border: 0px solid red; margin-top: 5px;">
 <div class="pull-left" style=" border:0px solid #c7d1dd ; border-top:0px ; width: 55%; margin-left: 10px;">
     <form class="form-horizontal" method="post" id="metaDataForm" name="metaDataForm">
    <div>
    <div class="form-group">
        <label for="entryname" class="control-label col-xs-3">Title *:</label>
        <div class="col-xs-8">
            <input type="text" class="form-control" name="entryname" id="entryname" placeholder="Entry Name" maxlength="35" value="<?php echo htmlentities($name); ?>">
            <input type="hidden" class="form-control" name="duration" id="duration" value="<?php echo $duration; ?>">
            <input type="hidden" class="form-control" name="video_path" id="video_path" placeholder="Entry Name" maxlength="35" value="<?php echo $video_path; ?>">
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
  <!--<div class="form-group">
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
    </div>-->

</div>
<br/>
<div class="form-group">
<div class="col-xs-offset-2 col-xs-10">
<?php  if(in_array(1, $UserRight)){ if($status=='11'){ ?>    
<!--<button type="button" class="btn btn-primary btn1"  disabled  id="only_save_button" name="save_only_submit"   onclick="save_metedata_in_server('only_save','<?php echo $Entryid; ?>','<?php echo $getpageindex;  ?>','<?php echo $limitval;  ?>');" >Save</button>-->

<button type="button" class="btn btn-primary btn1"  disabled  id="save_button" name="submit" style="margin-left: 130px; margin-top:0px;"  onclick="save_ugcmetedata_in_server('saveClose','<?php echo $Entryid; ?>','<?php echo $getpageindex;  ?>','<?php echo $limitval;  ?>');" >Save</button>
<button type="button" class="btn btn-danger btn1"   id="reject" name="submit"  style=" margin-top: 0px;" onclick="ugcRegect('ugc_regect','<?php echo $Entryid; ?>','<?php echo $getpageindex;  ?>','<?php echo $limitval;  ?>')">Reject</button>
<span id="saving_matadata"> </span>
<?php } } else{ ?>
  <!--<button type="button" class="btn btn-primary" data-dismiss="modal"  name="submit" disabled>Save & Close</button>-->
  <!--<button type="submit" class="btn btn-primary" data-dismiss="modal1"  name="submit" disabled>Save & Close</button>-->
 
      <?php } ?> 
</div>
</div>
</form>

</div> 
<div class="pull-right" id="drawVideoPlayer11"  style="border:0px solid black ; width: 40%; margin-right: 30px; padding:5px; height: 305px !important;">
    <!--<span id="wait_loader_videoPlay" style="margin: 0 auto;" ></span>-->
    <div id="fp-dash" class="is-closeable" style="margin-top: 55px;"></div>  
     <script type="text/javascript">
        var dataurl="<?php echo $video_path; ?>";
        var separation_dataurl =dataurl.split('.');
        var dataurl_len = separation_dataurl.length;
        var dataurl_type = separation_dataurl[dataurl_len-1];
        var type =" ";
        if(dataurl_type=="mp4")
        {
            type= "video/mp4";
        }
        else if (dataurl_type=="m3u8")
        {
            type= "application/x-mpegurl";
        }
         else if (dataurl_type=="MOV")
        {
            type= "video/mov";
        }
         else if (dataurl_type=="wmv")
        {
            type= "video/wmv";
        }
         else if (dataurl_type=="mkv")
        {
            type= "video/mkv";
        }
         else if (dataurl_type=="webm")
        {
            type= "video/webm";
        }
        
        flowplayer("#fp-dash", {
           splash: true,
           ratio: 9/16,
           clip: {
           sources: [
           {    
              type: type,
              src:dataurl
           },
        ]
        },
        embed: false
        }).on("ready", function (e, api, video) {
          //document.querySelector("#fp-dash .fp-title").innerHTML =
          //api.engine.engineName + " engine playing " + video.type;

        });
        var api = flowplayer();
        $(".close").on("click", function () {
        api.unload();
        $("#drawVideoPlayer11").html('');  // close modal
        $('#myModalVodEdit').modal('hide');
       });   
   </script>
</div>	
     
</div>

<script src = "js/autocomplete.js"></script>
<script type="text/javascript">
drawTags('<?php echo $entryId; ?>');  
function drawTags(entryid)
{
    $("#wait_loader_tags").fadeIn(400).html('Loading... <img src="img/image_process.gif" />');
    var dataString ='action=tags_in_ugcmetaData&entryid='+entryid;
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
function save_ugcmetedata_in_server(smatadata,ugc_id,pageindex,limitval)
{
   var publisher_unique_id="<?php  echo $publisher_unique_id ?>";
   var puser_id="<?php  echo $get_user_id ?>";
   var userID="<?php  echo $userID ?>";
   var apiURl="<?php  echo $apiURL."/singleupload" ?>";
   var inputTitle = $('#entryname').val();
    $(".has-error").html(''); 
    if(inputTitle=='')
     {
            var message="Entry Name should not be blank";
            $("#inputTitle-error").html(message);
            return false;
      }
     var upload_url=$('#video_path').val();
     var mytags = $('#tags_1').val();
     var descrip = $('#entrydescription').val();
     var video_status = 'inactive';
     //var userid = $('#userid').val();
     var displaystr='Saving.......';
     $("#flash_saving").show();
     $("#flash_saving").fadeIn(400).html(' Saving......... <img src="img/image_process.gif" />');
     $('#myFormSubmit').attr('disabled',true);
     var apiBody = new FormData();
     apiBody.append("filepath",upload_url);
     apiBody.append("name",inputTitle);
     apiBody.append("partnerid",publisher_unique_id);
     apiBody.append("tags",mytags);
     apiBody.append("desc",descrip);
     apiBody.append("userid",userID);
     apiBody.append("vstatus",video_status);
     $.ajax({
        url:apiURl,
        method: 'POST',
        dataType: 'json', 
        data:apiBody,
        processData: false,
          contentType: false,
          success: function(jsonResult){
                 console.log(jsonResult); 
                 var status1=jsonResult.status;
                 if(status1=="1")
                 {
                   var entryid=jsonResult.entryid;
                   var name=jsonResult.name;
                   var type=jsonResult.type;
                   var thumbnailurl=jsonResult.thumbnailurl;
                   var desc=jsonResult.desc;
                   var tags=jsonResult.tags;
                   var created_at=jsonResult.created_at;
                   var kalstatus=jsonResult.kalstatus;
                   $("#results").load("save_entry.php",{entryid:entryid,name:name,type:type,thumbnailurl:thumbnailurl,desc:desc,tags:tags,created_at:created_at,action:'save_entry_ugc',vstatus:video_status,userid:userID,upload_url:upload_url,kalstatus:kalstatus,ugc_id:ugc_id}, 
                   function(r) {
                   if(r==1)
                      {
                          alert("successfully uploaded!");
                          window.location.href='ugc_content.php';
                      } 
                      if(r==0)
                      {
                          alert("something went wrong please try again!");
                          $('#myFormSubmit').attr('disabled',false);
                          return false;
                      } 
                   });
                  }    
                  
                 if(status1=="0")
                 {
                     alert("something went wrong please try again!");
                     $('#myFormSubmit').attr('disabled',false);
                     return false;
                 }
                  
              }
      });	  
     
    
}

function ugcRegect(act,ugc_id,pageindex,limitval)
{
   //$('#myModal_add_to_category').modal('show');
   //$("#saving_loader").fadeIn(400).html('Saving... <img src="img/image_process.gif" />');
   $('#reject').attr('disabled',true); 
   var info = 'ugc_id='+ugc_id+"&maction="+act; 
    $.ajax({
        type: "POST",
        url: "ugc_paging.php", 
        data: info,
         success: function(result){
                $('#myModalugcEdit').modal('hide');
                $('#load').show();
                $('#results').css("opacity",0.1);
                if(result==1){
                $( "#results" ).load("ugc_paging.php",{ pageindex:pageindex,limitval:limitval,maction:'only_page_limitval'},
                function(r) {
                $( "#results" ).html(r);
                $("#msg").html("Entry Rejected.");
                $('#load').hide();
                $('#results').css("opacity",1);
                });
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