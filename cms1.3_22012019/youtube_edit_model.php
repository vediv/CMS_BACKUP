<?php
include_once 'corefunction.php';
include_once("config.php");
include_once("function.php");
$entryid=$_POST['Entryid']; $getpageindex=$_POST['pageindex']; $limitval=$_POST['limitval'];
$sqle="select * from entry where entryid='".$entryid."'";
$fEntry=db_select($conn,$sqle); 
$eid=$fEntry[0]['entryid']; $name=$fEntry[0]['name'];$thumbnail=$fEntry[0]['thumbnail'];$longdescription=$fEntry[0]['longdescription'];
$duration=$fEntry[0]['duration']; $tag=$fEntry[0]['tag'];$categoryid=$fEntry[0]['categoryid'];$status=$fEntry[0]['status'];
$countrycode=$fEntry[0]['countrycode']; $contentpartnerid=$fEntry[0]['contentpartnerid'];$startdate=$fEntry[0]['startdate'];$enddate=$fEntry[0]['enddate'];
$shortdescription=$fEntry[0]['shortdescription']; $director=$fEntry[0]['director'];$producer=$fEntry[0]['producer'];$cast=$fEntry[0]['cast'];
$crew=$fEntry[0]['crew']; $sub_genre=$fEntry[0]['sub_genre'];$language=$fEntry[0]['language'];$pgrating=$fEntry[0]['pgrating']; 


?>
<link href="dist/css/jquery.flexdatalist.min.css" rel="stylesheet" type="text/css"> 
<link href="bootstrap/css/youtube.css" rel="stylesheet" type="text/css">

<div class="modal-header">
          <button type="button" class="close" onclick="CloseVideo();" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit Entry - <?php echo $name; ?></h4>
</div>
<div class="modal-body" style="border:0px solid red;"> 
        <div class="row" style="border: 0px solid red; margin-top: 5px; ">
            <form class="form-horizontal" method="post" id="imageform1" action="javascript:">
            <table class="custom-table" border='0'>
            <tr>
            <td class="h5" width="20%">Youtube WatchID</td>
            <td width="20%"><input size="20"  type="text" readonly class="form-control" id="watchid_e" value="<?php echo $eid; ?>" ></td>
            <td width="30%"></td>
            <!--<td colspan="1" width="30%"><iframe width="250" height="100" src="https://www.youtube.com/embed/<?php //echo $eid;  ?>" frameborder="0" allowfullscreen></iframe></td>-->
            </tr>
           </table>
          
           <hr/>
          <div style="height:430px;overflow-y: scroll; overflow-x: hidden; display: block;">  
          <table class="custom-table"  border="0" >
            <tr>
            <td class="h5" colspan="1" width="20%">Video Status :</td>
            <td colspan="2" width="40%">
                <div class="btn-group btn-toggle" data-toggle="buttons">
                <label class="btn  <?php echo $status=='2' ? 'btn-primary active':'btn-default' ; ?>" ><input name="adstatus_e" <?php echo $status=='2' ? "checked":"";    ?>  value="2" type="radio"> ACTIVE </label>
                    <label class="btn  <?php echo $status=='-2' ? 'btn-primary active':'btn-default' ; ?>"> <input name="adstatus_e" <?php echo $status=='-2' ? "checked":"";    ?> value="-2" type="radio"> INACTIVE</label>
                 </div>
            </td>
            <td colspan="1" width="35%">Duration: <?php echo convert_sec_to($duration); // this function define in function.php ?></td>
            
             </tr>
            <tr>
            <td class="h5" colspan="1">Title :</td>
            <td colspan="3"><input type="text" class="form-control" name="entryname_e" id="entryname_e" value="<?php echo $name; ?>"  placeholder="Entry Name" ></td>
            </tr>
            <tr>
            <td class="h5" colspan="1">Description :</td>
            <td colspan="3"><textarea class="form-control" rows="3" id="entrydescription_e"  name="entrydescription_e" placeholder="Description" ><?php echo $longdescription; ?></textarea></td>
            </tr>
            <tr>
            <td class="h5" colspan="1">Tags :</td>
            <td colspan="3"><textarea class="form-control" rows="3" id="entrytags_e"  name="entrytags_e" placeholder="tags" ><?php echo $tag; ?></textarea></td>
            </tr>
            <tr>
            <td class="h5" colspan="1">Categories :</td>
            <td colspan="3">
                <div class="col-md-12">
<div id="sidebar" class="well sidebar-nav" style="border: 0px solid red;"> 
 <div class="mainNav">
<ul>
<?php
$filter = null;
$pager = null;
$res = $client->category->listAction($filter, $pager);
$count=1;
$categoriesIdsdlist = explode(',',$categoryid);
foreach ($res->objects as $entry_categorie) {                                    
$directSubCategoriesCount=$entry_categorie->directSubCategoriesCount;           
$parentId=$entry_categorie->parentId; $categoryID=$entry_categorie->id;
$fullIds=$entry_categorie->fullIds; $fullName=$entry_categorie->fullName;
$directEntriesCount=$entry_categorie->directEntriesCount; 
$categoriesName=$entry_categorie->name; 
if(($parentId)==0){
?>    
<li> 
<?php  $checked=in_array($categoryID, $categoriesIdsdlist)?"checked":''; ?>	
<input type="checkbox" <?php echo $checked; ?> name="category_value_e" class="checkBox_category"  id="example-getting-started"  value="<?php echo $categoryID; ?>">
<a href="#"><?php echo strtoupper($categoriesName);?></a>
<ul class="mainNav-scroll">
<?php
$filter = new KalturaCategoryFilter();
$filter->advancedSearch = null;
$filter->parentIdEqual = $categoryID;
$filter->parentIdIn = '';
$filter->appearInListEqual = null;
$filter->statusEqual = null;
$pager = null;
$result_sub_categorie = $client->category->listAction($filter, $pager);
$total_sub_categorie=$result_sub_categorie->totalCount;
if($total_sub_categorie>0)
 {
  $c=1;
  foreach ($result_sub_categorie->objects as $entry_sub_categorie) {
  $subcategoriName=$entry_sub_categorie->name; $subcategori_ID=$entry_sub_categorie->id;
  //$bgcolor_sub=$subcategori_ID==$get_categorieID ? "red" :""; 
  $fullIds_sub=$entry_sub_categorie->fullIds; $fullName_sub=$entry_sub_categorie->$fullName;
?>	
<li>
<?php  $checked=in_array($subcategori_ID, $categoriesIdsdlist)?"checked":''; ?>		
<input type="checkbox" <?php echo $checked;  ?> name="category_value_e" class="checkBox_category"  id="example-getting-started"  value="<?php echo $subcategori_ID; ?>"> 
<a href="#"> <?php echo $subcategoriName; ?></a>
<ul>
<?php 
//$filter = new KalturaCategoryFilter();
$filter->advancedSearch = null;
$filter->parentIdEqual = $subcategori_ID;
$filter->parentIdIn = '';
$filter->appearInListEqual = null;
$filter->statusEqual = null;
$pager = null;
$result_sub_sub_categorie = $client->category->listAction($filter, $pager);
// print '<pre>'.print_r($result_sub_sub_categorie, true).'</pre>';
$total_sub_sub_categorie=$result_sub_sub_categorie->totalCount;
foreach ($result_sub_sub_categorie->objects as $entry_sub_sub_categorie) {
$sub_subcategoriName=$entry_sub_sub_categorie->name; $sub_sub_categori_ID=$entry_sub_sub_categorie->id;
$fullIds_sub_sub=$entry_sub_sub_categorie->fullIds; $fullName_sub_sub=$entry_sub_sub_categorie->fullName;
?>	   
<li style="padding-left: 2em !important">
<?php  $checked=in_array($sub_sub_categori_ID, $categoriesIdsdlist)?"checked":''; ?>					
<input type="checkbox" <?php echo $checked;  ?> class="checkBox_category" name="category_value_e"  id="example-getting-started"  value="<?php echo $sub_sub_categori_ID; ?>">
                <a href="#"><?php echo $sub_subcategoriName; ?></a></li>
<?php } ?>	
        </ul>
</li>
<?php  }  } ?>
</ul>
</li>
<?php }  } ?>	
</ul>
</div>
</div>
</div>
                
</td>    
</tr>
<tr>
    <td class="h5">Short Description :</td>
    <td><input  type="text" class="tags form-control" id="short_desc_e"  name="short_desc_e" value="<?php echo $shortdescription; ?>"  placeholder="Enter Short description" /></td>
    <td  class="h5">Sub-Genre :</td>
    <td> <input id="sub_genre_e" type="text" class="form-control" value="<?php echo $sub_genre; ?>"  name="sub_genre_e"   placeholder="Enter Sub-Genre" /></td>
</tr>
<tr>
    <td class="h5">PG-Rating :</td>
    <td><input id="pg_rating_e" type="text" class="form-control" value="<?php echo $pgrating; ?>"  name="pg_rating_e"   placeholder="Enter PG Rating" /></td>
    <td  class="h5">Language :</td>
    <td> <input id="lang_e" type="text" class="form-control" value="<?php echo $language; ?>"  name="lang_e"  placeholder="Enter Language" /></td>
</tr>
<tr>
    <td class="h5">Producer: </td>
    <td><input id="producer_e" type="text" class="form-control" value="<?php echo $producer; ?>"  name="producer_e"   placeholder="Enter Producer" /></td>
    <td  class="h5">Director :</td>
    <td>  <input id="director_e" type="text" class="tags form-control" value="<?php echo $director; ?>"  name="director_e"   placeholder="Enter Director" /></td>
</tr>
<tr>
    <td class="h5">Cast: </td>
    <td> <input id="cast_e" type="text" class="tags form-control" value="<?php echo $cast; ?>"  name="cast_e"   placeholder="Enter Cast" /></td>
    <td  class="h5">Crew :</td>
    <td>  <input id="crew_e" type="text" class="tags form-control" value="<?php echo $crew; ?>"  name="crew_e"   placeholder="Enter Crew" /></td>
</tr>
<tr>
    <td class="h5">Start Date: </td>
    <td><input id="start_date_e" type="text" class="tags form-control" value="<?php echo $startdate; ?>"  name="start_date_e"   placeholder="Enter Start date YYYY-mm-dd" /></td>
    <td  class="h5">End date :</td>
    <td><input id="end_date_e" type="text" class="tags form-control" value="<?php echo $enddate; ?>"  name="end_date_e"   placeholder="Enter End date YYYY-mm-dd" /></td>
</tr>
<tr>
    <td class="h5">Content Partner : </td>
    <td> <?php 
     $sel="Select contentpartnerid,name from content_partner where status='1' order by name";
     $fet=db_select($sel);
     ?>
      <select class="selectpicker" name="content_partner_e" id="content_partner_e" style="width: 250px;">
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
    <td  class="h5">Country Code:</td>
    <td><input 
       placeholder='Write your country name'
       class='flexdatalist'
       value="<?php echo $countrycode;  ?>"
       data-data='countries.json'
       data-search-in='name'
       data-visible-properties='["name"]'
       data-selection-required='true'
       data-value-property='code'
       data-text-property='{name}'
       data-min-length='1'
       multiple='multiple'
       name='country_code_e'
       id='country_code_e'
       type='text'> 
    </td>
</tr>
            
           </table> 
           </div> 
 <br/>    
<div class="form-group">
<div class="col-xs-offset-2 col-xs-10">
<?php  if(in_array(2, $UserRight)){ ?>    
  <button type="button" class="btn btn-primary btn1"  data-dismiss="modal" name="submit"  id="myFormSubmit" onclick="save_youtube_metedata_edit('<?php echo $publisher_unique_id;  ?>');" >Save & Close</button>
<?php } else{ ?>
  <button type="button" class="btn btn-primary" data-dismiss="modal" name="submit" disabled>Save & Close</button>
<?php } ?> 
</div>
</div>      
           </form>
           
        </div>
        
      
        
      
     

    </div>  

<div class="modal-footer">
  <button type="button" class="btn btn-default" onclick="CloseVideo();" data-dismiss="modal">Close</button>
</div>
<?php include_once 'ksession_close.php'; ?>
<script src="dist/jquery.tagsinput/src/jquery.tagsinput.js" type="text/javascript"></script>
<script src="dist/js/custom.js" type="text/javascript"></script>      
<script src="js/navAccordion.min.js" type="text/javascript"></script>
<script type="text/javascript">
function save_youtube_metedata_edit(partnerid)
{ 
    var watch_id=$('#watchid_e').val();
     var apiURl="<?php  echo $apiURL."/youtube" ?>";
    var adstatus = $("input[name='adstatus_e']:checked").val();
    var entryname = $('#entryname_e').val(); 
    var longdesc = $('#entrydescription_e').val();	
    var entrytags = $('#entrytags_e').val();	  
    var shortdesc = $('#short_desc_e').val();	
    var subgenre = $('#sub_genre_e').val();  
    var pgrating = $('#pg_rating_e').val();	
    var lang = $('#lang_e').val(); 
    var producer = $('#producer_e').val();	
    var director = $('#director_e').val();  
    var cast = $('#cast_e').val();	
    var crew = $('#crew_e').val();  
    var startdate = $('#start_date_e').val();	
    var enddate = $('#end_date_e').val();	 
    var contentpartner = $('#content_partner_e').val();
    var countrycode = $('#country_code_e').val();	 
    var finald = '';
    $('.checkBox_category:checked').each(function(){        
        var values = $(this).val();
        finald += values+',';
		    });
       var entrycategores=finald.slice(0, -1);
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
       apiBody.append("subtag","update");
       apiBody.append("tag","video_entry");
        $.ajax({
                url:apiURl,
                method: 'POST',
                dataType: 'json', 
                data:apiBody,
                processData: false,
                contentType: false,
                    success: function(jsonResult){
                     $("#results" ).load("youtube_paging.php");   
                    }
            });	 
      
}

</script>
<script type="text/javascript">
jQuery(document).ready(function(){
        //Accordion Nav
        jQuery('.mainNav').navAccordion({
                expandButtonText: '<i class="fa fa-chevron-right"></i>',  //Text inside of buttons can be HTML
                collapseButtonText: '<i class="fa fa-chevron-down"></i>'
        }, 
        function(){
                //console.log('Callback')
        });
$('.btn-toggle').click(function() {
    $(this).find('.btn').toggleClass('active');  
    if ($(this).find('.btn-primary').size()>0) {
    	$(this).find('.btn').toggleClass('btn-primary');
    }
    if ($(this).find('.btn-danger').size()>0) {
    	$(this).find('.btn').toggleClass('btn-danger');
    }
    if ($(this).find('.btn-success').size()>0) {
    	$(this).find('.btn').toggleClass('btn-success');
    }
    if ($(this).find('.btn-info').size()>0) {
    	$(this).find('.btn').toggleClass('btn-info');
    }
    
    $(this).find('.btn').toggleClass('btn-default');
       
});
});
function CloseVideo(){ 
document.getElementById("show_youtube_view").innerHTML="";
$('#myModal_youtube').modal('hide');
}
</script>

<!--<script src="dist/js/jquery.flexdatalist.min.js"></script>
<script type="text/javascript">
 $('.flexdatalist').flexdatalist({
     minLength: 1,
     textProperty: '{name}',
     valueProperty: 'code',
     selectionRequired: true,
     visibleProperties: ["name","code"],
     searchIn: 'name',
     data: 'countries.json'
   
});
</script>-->
