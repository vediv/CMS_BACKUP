<?php
include_once 'corefunction.php';
$searchTextMatch = (isset($_POST['searchInputall']))? $_POST['searchInputall']: "";
$pagelimit = (isset($_POST['limitval']))? $_POST['limitval']: "50";
include_once("config.php");
$page =(isset($_POST['first_load']))? $_POST['first_load']:"";
$get_refresh = (isset($_POST['refresh']))? $_POST['refresh']: "";
$publisher_unique_id;
$fiterQry="select filtervalue from filter_setting where filtertag='vod_youtube'";
$fiter=  db_select($fiterQry);
$filtervalue=$fiter[0]['filtervalue'];
$action = (isset($_POST['maction'])) ? $_POST['maction']: "";
switch($action)
{
    case "deletecontent":
         $deleteentryID	 = (isset($_POST['entryID']))? $_POST['entryID']: "";
         $entrytable = db_query($conn,"update entry set status='3' where entryid='$deleteentryID'");
         $user_authentication_view_log = db_query($conn,"update user_authentication_view_log set status='3' where entry_id='$deleteentryID'");
         $watch_later = db_query($conn,"update watch_later set status='3' where entryid='$deleteentryID'");
         $favourite = db_query($conn,"update favourite set status='3' where entryid='$deleteentryID'");
         $playlist_config = db_query($conn,"update playlist_config set status='3' where song_id='$deleteentryID'");
        $page = (isset($_POST['pageindex']))? $_POST['pageindex']: "";
        $pagelimit = (isset($_POST['limitval']))? $_POST['limitval']: "";
      break;    
}

$sqlt="select entryid from entry where type='8' and status!='3'";
if($filtervalue==0){
    $sqlt.="";
}
if($filtervalue==2){
    $sqlt.=" AND status='".$filtervalue."'";
}
if($filtervalue<0){
    $sqlt.=" AND status='".$filtervalue."'";
}
if($searchTextMatch!='')
{
    $sqlt.=" AND (entryid='".$searchTextMatch."' OR name LIKE '%" . $searchTextMatch . "%' OR category LIKE '%" . $searchTextMatch . "%' OR tag LIKE '%" . $searchTextMatch . "%'  )";
    
}    
$sqlt;
$total_pages=db_totalRow($conn,$sqlt);
$limit = $pagelimit; 
if($page) 
	 $start = ($page - 1) * $limit; 			//first item to display on this page
   else
$start = 0;
$sqly="select entryid,name,thumbnail,category,ispremium,isfeatured,status,created_at from entry where type='8' and  status!='3'";
$searchQ='';
if($searchTextMatch!='')
{
    $searchQ=" AND (entryid='".$searchTextMatch."' OR name LIKE '%" . $searchTextMatch . "%' OR category LIKE '%" . $searchTextMatch . "%' OR tag LIKE '%" . $searchTextMatch . "%'  )";
    
}  
if($filtervalue==0){
    $sqly.=" $searchQ LIMIT $start, $limit";
}
if($filtervalue==2){
    $sqly.=" AND status='".$filtervalue."' $searchQ LIMIT $start, $limit";
}
if($filtervalue<0){
    $sqly.=" AND status='".$filtervalue."' $searchQ LIMIT $start, $limit";
}

$sqly;
$fentry=$fet_plan=db_select($conn,$sqly);
?>
<div class="box-header" >
<div class="row" style="border: 0px solid red; margin-top:-10px;">
    <table border='0' style="width:98%; margin-left: 10px;">
    <tr>
    <td width="15%"><select id="pagelmt"  style="width:60px;" onchange="selpagelimit();" >
           <option value="50"  <?php echo $pagelimit=="50"? "selected":""; ?> >50</option>
          <option value="100" <?php echo $pagelimit=="100"? "selected":""; ?> >100</option>
          <option value="200" <?php echo $pagelimit=="200"? "selected":""; ?> >200</option>
          <option value="500" <?php echo $pagelimit=="500"? "selected":""; ?> >500</option>
        </select> Records Per Page</td>
    <td width="20%" align="right">
         View: <select name="filterentry" id="filterentry" style="text-transform: uppercase !important;">
        <option value="0" <?php echo   $filtervalue=='0'?"selected":''; ?>>ALL</option>
          <option value="2" <?php echo $filtervalue=='2'?"selected":''; ?>>ACTIVE</option>
          <option value="-2" <?php echo $filtervalue=='-2'?"selected":''; ?>>INACTIVE</option>
     </select>
    </td>
    <td width="55%">
        <form class="navbar-form" role="search" method="post" style="  padding: 0 !important;">
               <div class="input-group add-on" style="float: right;">
               <input id='pagelimit' type="hidden" height="30px"  value="<?php echo $pagelimit; ?>">   
               <input class="form-control" size="30"  placeholder="Search Entries"  autocomplete="off" name='searchQuery' id='searchInput' class="searchInput" type="text" value="<?php echo $searchTextMatch; ?>">
               <div class="input-group-btn">
               <button class="enableOnInput btn btn-default" disabled='disabled' id='submitBtn' type="button" style="padding: 2px; margin-top: 0px; width: 30px;" ><i class="glyphicon glyphicon-search"></i></button>	
               <button class="enableOnInput btn btn-default" disabled='disabled' id='clearcBtn' type="button" >
               <span class="glyphicon glyphicon-remove"></span>
               </button>	
               </div>
               </div>
          </form>
    </td>
    <td width="10%">
     <div class="col-xs-1 hidden-xs hidden-sm pull-right" style="border:none;  margin-top:10px !important;">   
     <a href="#" onclick="return refreshcontent('refresh');" title="refresh" style="float: right"><i class="fa fa-refresh" aria-hidden="true"></i></a>   
     </div>
     </td>
    </tr>
</table>	  
</div>
 
   
    
     
    <div class="">
       <div class="pull-left" id="flash" style="text-align: center;"></div> 
      <div class="pull-left" id="msg" style="text-align: center;"></div>
    </div>
</div>
<form action="#" id="form" name="myform" style="border: 0px solid red; ">
    <table  class="table table-fixedheader table-bordered table-striped" style="table-layout:fixed; width: 100%;"> 
    <thead style="display: block; overflow-y: scroll;">
      <tr>
        <th  style="width:1%"><input type="checkbox" id="ckbCheckAll"></th>
        <!--<th  width="6%"></th>-->
        <th  style="width:9%">Thumbnail</th>
        <th  style="width:10%">ID</th>
        <th  style="width:30%">Name</th>
        <th  style="width:27%">Categories</th>
        <th  style="width:10%">Created-On</th>
        <th  style="width:7%">Status</th>
        <th  style="width:6%" >Action <span style="background: #fff;position: absolute; height: 34px;margin-top:-5px; width: 20px;right: 0;" ></span></th>
       </tr>    
    </thead>
    
<tbody style="height:500px;overflow-y: scroll;display: block;">
<?php

$count=1;
foreach ($fentry as $fet_plan)
{ 
    $thumbnailUrl=$fet_plan['thumbnail'];
    if($thumbnailUrl==='NULL' ||  empty($thumbnailUrl))
    {
        $imgthumb='<img class="img-responsive customer-img" src="img/youtube_defaul.jpg"  height="20" width="90" >';
    } 
    else {
         $imgthumb='<img class="img-responsive customer-img" src="'.$thumbnailUrl.'"  height="20" width="90" >';
    }
     $id=$fet_plan['entryid']; $name=$fet_plan['name']; $categories=$fet_plan['category']; $created_at=$fet_plan['created_at']; 
     $status=$fet_plan['status']; $isfeatured=$fet_plan['isfeatured']; 
     $starColor = $isfeatured=="1"? "#DAA520":"#C0C0C0";
     $redyColor='btn-danger';
     if($status==2) { $statusc="Ready"; $redyColor='btn-success';
     $in=1; $d1=0; $d2=1;   $bname1="A"; $bname2='D'; $class1="btn-success active"; $class2="btn-danger"; $disable1="disabled"; $disable2="";
     $actColor="";
     }
     if($status < 0) { 
      $statusc="inactive"; $redyColor='btn-danger';
      $in=0; $d1=1; $d2=0;   $bname1="A"; $bname2='D'; $class2="btn-success active"; $class1="btn-danger"; 
      $actColor="lightgrey";   $disable1=""; $disable2="disabled";
     }
      
 ?> 

<tr id="<?php echo $count."_r"; ?>" style="background:<?php echo $actColor; ?>">
<td  style="width:1%"> <input type="checkbox" class="checkBoxClass" name="Entrycheck[]" value="<?php echo $id; ?>"></td>
<td style="width:9%"> <?php echo $imgthumb; ?>
<a href="javascript:void(0);" title="featured video" onclick="return addFeaturedVideo('<?php echo $id; ?>','<?php echo $count;  ?>')">
<span class="glyphicon glyphicon-star" style="color:<?php echo $starColor; ?>; padding-right: 23px; padding-top: 7px; position: relative;" id="starfeatured<?php echo $count; ?>"></span></a>
<?php  if(in_array(2, $UserRight)){ ?>
<div class="btn-group btn-toggle " style=" position: relative;"> 
    <button id="<?php echo $count."_a"; ?>" <?php echo $disable1; ?> title="active"  class="btn btn-xs <?php echo $class1; ?>"    onclick="vodActDeact1('<?php echo $d1; ?>','<?php echo $id; ?>','<?php echo $count;  ?>')"><?php echo $bname1; ?></button>
    <button id="<?php echo $count."_d"; ?>" <?php echo $disable2; ?> title="inactive" class="btn btn-xs <?php echo $class2; ?>"  onclick="vodActDeact2('<?php echo $d2; ?>','<?php echo $id; ?>','<?php echo $count;  ?>')"><?php echo $bname2; ?></button>
</div>
<?php } else { ?> 
 <div class="btn-group btn-toggle"> 
    <button id="<?php echo $count."_a"; ?>" disabled class="btn btn-xs <?php echo $class1; ?>"><?php echo $bname1; ?></button>
    <button id="<?php echo $count."_d"; ?>" disabled class="btn btn-xs <?php echo $class2; ?>" ><?php echo $bname2; ?></button>
</div>   
<?php } ?>    
</td> 
<td  style="width:10%"><?php echo $id;?></td>
<td  style="width:30%"><?php echo $name;?></td>
<td  style="width:27%; font-size: 12px"><span id="catgoryactStayus<?php echo $count; ?>"><?php echo  $categories; ?></span></td>
<td  style="width:10%"><?php echo $created_at; ?></td>
<td  style="width:7%">
<button  class="btn  <?php echo $redyColor; ?> btn-xs" id="adstatus<?php echo $count; ?>" ><?php echo  $statusc; ?></button>
</td>
<td  style="width:6%">
<a href="#" onclick="viewyoutube('<?php echo $id; ?>','<?php echo $page; ?>','<?php echo $limit; ?>');" > 
<i class="fa fa-eye" aria-hidden="true" data-toggle="tooltip" data-placement="left"  title="View Details" style="padding-right: 8px  !important;"></i>
</a>
<?php  if(in_array(4, $UserRight)){ ?>
<a href="#" onclick="return deleteContent('<?php echo $id; ?>','deletecontent','<?php echo $page; ?>','<?php echo $limit;?>')"><i class="fa fa-trash-o" aria-hidden="true" title="Delete"></i></a>
<?php }?>
</td>
</tr>   
<?php $count++; }?>         
</tbody>
   </table>
</form>  
<?php
if ($page == 0) $page = 1;					//if no page var is given, default to 1.
	$prev = $page - 1;							//previous page is page - 1
	$next = $page + 1;							//next page is page + 1
        $lastpage = ceil($total_pages/$limit);		//lastpage is = total pages / items per page, rounded up.
	$lpm1 = $lastpage - 1;					
	$pagination = "";
	if($lastpage > 1)
	{	
              echo "santosh";
		$pagination .= "<div class=\"pagination\">"; 
		if ($page > 1) 
		 $pagination.= '<a href="javascript:void(0)" onclick="changePagination(\''.$prev.'\',\''.$limit.'\',\''.$searchKeword.'\')"><i class="fa fa-long-arrow-left" aria-hidden="true"></i> Previous</a>';		
		else
			$pagination.= "<span class=\"disabled\"><i class='fa fa-long-arrow-left' aria-hidden='true'></i> Previous</span>";	
		//pages	
		if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				?>
			<?php 	if ($counter == $page)
					$pagination.= "<span class=\"current\">$counter</span>";
				else
				$pagination.= '<a href="javascript:void(0)" onclick="changePagination(\''.$counter.'\',\''.$limit.'\',\''.$searchKeword.'\')">'.$counter.'</a>';		
				    			}
		}
		elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
		{
			//close to beginning; only hide later pages
			if($page < 1 + ($adjacents * 2))		
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
				     $pagination.= '<a href="javascript:void(0)" onclick="changePagination(\''.$counter.'\',\''.$limit.'\',\''.$searchKeword.'\')">'.$counter.'</a>';				
				}
				$pagination.= "...";
				$pagination.= '<a href="javascript:void(0)" onclick="changePagination(\''.$lpm1.'\',\''.$limit.'\',\''.$searchKeword.'\')">'.$lpm1.'</a>';
				$pagination.= '<a href="javascript:void(0)" onclick="changePagination(\''.$lastpage.'\',\''.$limit.'\',\''.$searchKeword.'\')">'.$lastpage.'</a>';	
			}
			//in middle; hide some front and some back
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				//$pagination.= "<a href=\"$targetpage?page=1\">1</a>";
				$pagination.= '<a href="javascript:void(0)" onclick="changePagination(\'1\',\''.$limit.'\',\''.$searchKeword.'\')">1</a>';	
				//$pagination.= "<a href=\"$targetpage?page=2\">2</a>";
				$pagination.= '<a href="javascript:void(0)" onclick="changePagination(\'2\',\''.$limit.'\',\''.$searchKeword.'\')">2</a>';
				$pagination.= "...";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
					$pagination.= '<a href="javascript:void(0)" onclick="changePagination(\''.$counter.'\',\''.$limit.'\',\''.$searchKeword.'\')">'.$counter.'</a>';				
				}
				$pagination.= "...";
				$pagination.= '<a href="javascript:void(0)" onclick="changePagination(\''.$lpm1.'\',\''.$limit.'\',\''.$searchKeword.'\')">'.$lpm1.'</a>';
				$pagination.= '<a href="javascript:void(0)" onclick="changePagination(\''.$lastpage.'\',\''.$searchKeword.'\')">'.$lastpage.'</a>';	
			}
			//close to end; only hide early pages
			else
			{
				
				$pagination.= '<a href="javascript:void(0)" onclick="changePagination(\'1\',\''.$limit.'\',\''.$searchKeword.'\')">1</a>';	
				$pagination.= '<a href="javascript:void(0)" onclick="changePagination(\'2\',\''.$limit.'\',\''.$searchKeword.'\')">2</a>';
				$pagination.= "...";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						
						$pagination.= '<a href="javascript:void(0)" onclick="changePagination(\''.$counter.'\',\''.$limit.'\',\''.$searchKeword.'\')">'.$counter.'</a>';					
				}
			}
		}
		
		//next button
		if ($page < $counter - 1) 
			
		    $pagination.= '<a href="javascript:void(0)" onclick="changePagination(\''.$next.'\',\''.$limit.'\',\''.$searchKeword.'\')">Next <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>';	 
		else
			$pagination.= "<span class=\"disabled\">Next <i class='fa fa-long-arrow-right' aria-hidden='true'></i>  </span>";
		$pagination.= "</div>\n";		
	}


?>    

<div class="row row-list" style="border: 0px solid red; padding: 0px 5px 0px 5px;">
<div class="col-xs-8 pull-right"  style="border: 0px solid red; padding: 0px 0px 0px 0px; font-size: 13px;">
    <div class="pull-left">
     <?php if($page ==1) { 
       $startShow=1; 
       $lmt=$limit<$total_pages ? $limit :$total_pages;
       }
      else 
      { 
             $startShow=(($page - 1) * $limit)+1;
             $lmt=($page*$limit) >$total_pages ? $total_pages: $page * $limit;
      }
 ?>
    </div>
     
    <div class="pull-right" style="padding: 5px;">
    <span style="padding-top: 5px;float:left;margin-right: 20px;"> Showing <?php echo $startShow; ?> to <?php echo $lmt; ?>   of <strong><?php echo $total_pages; ?> </strong>entries </span>
<?php echo $pagination;?></div>   

</div>
</div> 
<script type="text/javascript">
/* thsi is for model JS with edit and view detail */
    function viewyoutube(Entryid,EntryPageindex,limitval)
    {
       $("#flash").fadeIn(100).html('Wait <img src="img/image_process.gif" />');
       $('#myModal_youtube').modal();
       var info = 'Entryid='+Entryid+"&pageindex="+EntryPageindex+'&limitval='+ limitval; 
        $.ajax({
	   type: "POST",
	   url: "youtube_edit_model.php",
	   data: info,
         success: function(result){
         $("#flash").hide();
         $('#show_youtube_view').html(result);
         //$("#LegalModal").modal('show');
         //return false;
          }
        });
     return false; 
    
 }

 function changePagination(pageid,limitval,searchtext){
     $("#flash").fadeIn(100).html('Wait <img src="img/image_process.gif" />');
     var dataString ='first_load='+pageid+'&limitval='+limitval+'&searchInputall='+searchtext;
     //$("#result").html();
     $.ajax({
           type: "POST",
           url: "youtube_paging.php",
           data: dataString,
           cache: false,
           success: function(result){
             //  alert(result);
           	 $("#results").html('');
                 $("#flash").hide();
           	 $("#results").html(result);
           }
      });
}
function deleteContent(entryID,delname,pageindex,limitval){
  
      var dataString ='entryID='+ entryID +"&maction="+delname+"&pageindex="+pageindex+'&limitval='+ limitval;
      var a=confirm("Are you sure you want to delete the selected entry ? " + entryID +  "\nPlease note: the entry will be permanently deleted from your account");
	     if(a==true)
	     {
	     	$("#flash").show();
                $("#flash").fadeIn(800).html('Loading <img src="img/image_process.gif" />');
	        $.ajax({
	           type: "POST",
	           url: "youtube_paging.php",
	           data: dataString,
	           cache: false,
	           success: function(result){
	           //alert(result);
	           	 $("#results").html('');
	           	 $("#flash").hide();
	           	 $("#results").html(result);
	           }
	         });
	     }
	     else
	     {
	     	 $("#flash").hide();
	     	 return false;
	     }
}
function addFeaturedVideo(entryID,count){
	var dataString ='entryID='+ entryID;
            $.ajax({
	           type: "POST",
	           url: "add_featured_video.php",
	           data: dataString,
	           cache: false,
	           success: function(r){
	            if(r==1)
	            { $("#starfeatured"+count).css('color','#C0C0C0'); }
	            if(r==2)
	            { $("#starfeatured"+count).css('color','#DAA520');}
	          }
	         });
	  
	    
}


function vodActDeact1(actdeact,entryid,rowcount)
{
       var apiBody = new FormData();
       apiBody.append("entryid",entryid);
       apiBody.append("tag","active");
       apiBody.append("action","youtube_video");
       $.ajax({
                url:'core_active_deactive.php',
                method: 'POST',
                data:apiBody,
                 processData: false,
                contentType: false,
                success: function(r){
                     $("#"+rowcount+"_a" ).addClass("btn-primary").removeClass("btn-default");
                     $("#"+rowcount+"_d" ).removeClass("btn-primary active");
                     $("#"+rowcount+"_a" ).prop("disabled", true);
                     $("#"+rowcount+"_d" ).prop("disabled", false);
                     $("#"+rowcount+"_r" ).css("background", "");  
                     $("#adstatus"+rowcount).addClass("btn-succes").removeClass("btn-danger");
                     $("#adstatus"+rowcount).html(r);
                     
                    }
            });
  
          
}
function vodActDeact2(actdeact,entryid,rowcount)
{
       var apiBody = new FormData();
       apiBody.append("entryid",entryid);
       apiBody.append("tag","inactive");
       apiBody.append("action","youtube_video");
       $.ajax({
                url:'core_active_deactive.php',
                method: 'POST',
                data:apiBody,
                processData: false,
                contentType: false,
                    success: function(r){
                     $("#"+rowcount+"_d" ).addClass("btn-primary active").removeClass("btn-default");
                     $("#"+rowcount+"_a" ).removeClass("btn-primary active");
                     $("#"+rowcount+"_d" ).prop("disabled", true);
                     $("#"+rowcount+"_a" ).prop("disabled", false); 
                     $("#"+rowcount+"_r" ).css("background", "lightgrey");
                     $("#adstatus"+rowcount).addClass("btn-danger").removeClass("btn-succes");
                     $("#adstatus"+rowcount).html(r);
                    }
            });
     
          
}


$(document).ready(function(){ 
		   $("#ckbCheckAll").click(function () {
		        $(".checkBoxClass").prop('checked', $(this).prop('checked'));
		    });
		  /*  $('td:first-child input').change(function() {
		        $(this).closest('tr').toggleClass("highlight", this.checked);
		    });
		  */
		   $('#delete_bulk').click(function(){
		    var finald = '';
		    $('.checkBoxClass:checked').each(function(){        
		        var values = $(this).val();
		        finald += values+',';
		    });
		      if(finald=='')
		      { alert("You must select at least one entry"); return false;}
		      
		      else {
		      var multidelete="multidelete";
		      var element = $(this);
                      var pageindex = element.attr("pageindex");
                      var limitval = element.attr("pageSize");
                      var dataString ='entryIDs='+ finald +"&maction="+multidelete+"&pageindex="+pageindex+'&limitval='+ limitval;
		      //alert(dataString);
		      var a=confirm("Are You sure want to delete This Entries ? " +finald+"\nPlease note: the entry will be permanently deleted from your account");
		       if(a==true)
		              {  $.ajax({   
			             type: "POST",
			             url: "media_paging.php",
			             data: dataString,
			             cache: false,
			             success: function(result){
			             //alert(result);
			           	 $("#results").html('');
			           	 $("#flash").hide();
			           	 $("#results").html(result);
			           }
			        }); 
		       }
		     else  {   $("#flash").hide(); return false;  }
		   }
		});
/* code for add plan */
$(".planbulk").click(function(){
 $("#flash").fadeIn(400).html('Wait <img src="img/image_process.gif" />');
 var finald = '';
$('.checkBoxClass:checked').each(function(){        
var values = $(this).val();
finald += values+',';
});
if(finald=='')
{ alert("You must select at least one entry"); return false;}	
$("#myModal_bulk").modal();
var element = $(this);
var Entryids = finald;
var EntryPageindex = element.attr("pageindex");
 var limitval = element.attr("pageSize");
var info = 'Entryids=' + Entryids+"&pageindex="+EntryPageindex+'&limitval='+ limitval; 
//alert(info);
$.ajax({
type: "POST",
url: "bulk_plan_edit_model.php",
data: info,
success: function(result){
$("#flash").hide();
$('#bulk_plan_edit_model').html(result);
//$("#LegalModal").modal('show');
//return false;
}

});
return false;    
});

    
/* code for add Category */
$(".categorybulk").click(function(){
 var finald = '';
    $('.checkBoxClass:checked').each(function(){        
        var values = $(this).val();
        finald += values+',';
    });

 if(finald=='')
 { alert("You must select at least one entry"); return false;}	
    $("#myModal").modal();
        var element = $(this);
        var Entryids = finald;
        var EntryPageindex = element.attr("pageindex");
        var limitval = element.attr("pageSize");
        var info = 'Entryids=' + Entryids+"&pageindex="+EntryPageindex+'&limitval='+ limitval+"&cat_add_remove=cat_add";
        //alert(info);
       $.ajax({
	   type: "POST",
	   url: "add_category_media_paging.php",
	   data: info,
       success: function(result){
       //alert(result);
       $('#show_detail_model_view').html(result);  
       //$("#LegalModal").modal('show');
        //return false;
          }
 
        });
     return false;    
    });
    
    
/* code for Remove Category */
$(".categorybulk_remove").click(function(){
 var finald = '';
    $('.checkBoxClass:checked').each(function(){        
        var values = $(this).val();
        finald += values+',';
    });
if(finald=='')
{ alert("You must select at least one entry"); return false;}	
   $("#myModal").modal();
       var element = $(this);
       var Entryids = finald;
       var EntryPageindex = element.attr("pageindex");
       var limitval = element.attr("pageSize");
   var info = 'Entryids=' + Entryids+"&pageindex="+EntryPageindex+'&limitval='+limitval+"&cat_add_remove=cat_remove"; 
    //alert(info);
   $.ajax({
       type: "POST",
       url: "add_category_media_paging.php",
       data: info,
   success: function(result){
   //alert(result);
   $('#show_detail_model_view').html(result);
   //$("#LegalModal").modal('show');
    //return false;
      }

    });
 return false;    
});

    
    
});

function selpagelimit(){
var limitval = document.getElementById("pagelmt").value;
var dataString ='limitval='+ limitval;
$("#flash").fadeIn(10000).html('Wait <img src="img/image_process.gif" />');
        $.ajax({
        type: "POST",
        url: "youtube_paging.php",
         data: dataString,
        cache: false,
        success: function(result){
               $("#results").html('');
                $("#flash").hide();
                $("#results").html(result);


                  }
            }); 
}


$(function(){
$('#searchInput').keyup(function(){
//$("#searchInput").('keyup', function() {
  if ($(this).val() == '') { //Check to see if there is any text entered
        //If there is no text within the input ten disable the button
        $("#submitBtn").show();  
                $("#clearcBtn").hide();  
                $('.enableOnInput').prop('disabled', true);
                var searchInputall = $('#searchInput').val();
        var limitval = $('#pagelimit').val();
        var dataString ='searchInputall='+searchInputall+'&limitval='+ limitval;
                    $.ajax({
                    type: "POST",
                    url: "youtube_paging.php",
                    data: dataString,
                    cache: false,
                        success: function(result){
                           //alert(result);
                            //$("#submitBtn").hide();  
                                    $("#clearcBtn").hide();
                                    $("#searchword").css("display", "none");      
                                    $("#results").html('');
                                    $("#flash").hide();
                                    $("#results").html(result);
                              }
                      });
    } else {

       //If there is text in the input, then enable the button

        var get_string = $('#searchInput').val().length;

        if(get_string>=1)
         {  
                $("#submitBtn").show();  
                    $("#clearcBtn").hide();   

         }
        $('.enableOnInput').prop('disabled', false);
      }
});

$("#clearcBtn").hide(); 
$("#searchword").css("display", "none");  
$('#submitBtn').click(function(){
var searchInputall = $('#searchInput').val();
var limitval = $('#pagelimit').val();
var dataString ='searchInputall='+ searchInputall+'&limitval='+ limitval;
                   // alert(searchInputall);
           $.ajax({
           type: "POST",
           url: "youtube_paging.php",
            data: dataString,
           cache: false,
           success: function(result){
           // alert(result);
                $("#submitBtn").hide();  
                $("#clearcBtn").show();      
                $("#results").html('');
                $("#flash").hide();
                $("#results").html(result);
                $("#searchword").css("display", "");
                $('#searchword').html(searchInputall);
           }
               });
 });
// this is for cancel button code when click in cancel button then give the blank string....
$('#clearcBtn').click(function(){
        var searchInputall ='';
         //alert(searchInputall);
         var dataString ='searchInputall='+ searchInputall;
         $.ajax({
            type: "POST",
            url: "youtube_paging.php",
            data: dataString,
            cache: false,
            success: function(result){
                 $("#submitBtn").show();  
                 $('.enableOnInput').prop('disabled', true);
                 $("#clearcBtn").hide();      
                 $("#results").html('');
                 $("#flash").hide();
                 $("#results").html(result);
                 $("#searchInput").val(''); 
                 $("#searchword").css("display", "none");  
                 $('#searchword').html(''); 
                  }
              });
 });

$('#searchInput').keypress(function(event){
	var keycode = (event.keyCode ? event.keyCode : event.which);
	if(keycode == '13'){
	   var searchInputall = $('#searchInput').val();
	    $("#clearcBtn").hide(); 
            $("#searchword").css("display", "none"); 
	    if(searchInputall=='')
	   {
	       alert("Enter some Keyword For search?");
	       return false;	 
	   }
	   else
	   { 
	           var limitval = $('#pagelimit').val();
                   var dataString ='searchInputall='+ searchInputall+'&limitval='+ limitval;
	   	     $.ajax({
		           type: "POST",
		           url: "youtube_paging.php",
		            data: dataString,
		           cache: false,
		           success: function(result){
		           // alert(result);
		           	$("#submitBtn").hide();  
		           	$("#clearcBtn").show();      
		           	$("#results").html('');
		           	$("#flash").hide();
		           	$("#results").html(result);
		           	$("#searchword").css("display", "");
		           	$('#searchword').html(searchInputall);
		           }
		               });
	   	   
	   	   return false;
	   }
        
        
        
		
	}
	
});

    $("#searchInput").bind('input', function(e) {
     var $this = $(this);
     $('.enableOnInput').prop('disabled', false);
     });
     
/* Filter function start */ 
$('#filterentry').on('change',function(){
        var filtervalue = $(this).val();
       // $("#flash").fadeIn(10000).html('Wait <img src="img/image_process.gif" />');
        if(filtervalue){
            $.ajax({
                type:'POST',
                url:'media_setting.php',
                data:'filtervalue='+filtervalue+"&tag=vod_youtube",
                success:function(rr){
                    if(rr==1)
                    {    
                       $("#results" ).load("youtube_paging.php");
                       //$("#flash").hide();
                    }          
                }
            }); 
        }
    });
    /* Filter function end */
     
});
</script>


