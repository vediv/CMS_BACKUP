<?php 
sleep(1);
include_once 'corefunction.php';
include_once("function.php");
$searchKeword = (isset($_POST['searchInputall']))? $_POST['searchInputall']: "";
$page =(isset($_POST['pageNum']))? $_POST['pageNum']: 0;
$pagelimit = (isset($_POST['limitval']))? $_POST['limitval']: 10; 
$action = (isset($_POST['action'])) ? $_POST['action']: "";
$filtervalue=(isset($_POST['filtervalue']))? $_POST['filtervalue']:'00';
switch($action)
{
    case "save_edit_slider":
    $entryid1=trim($_POST['ventryid']); $entryid=db_quote($conn, $entryid1);
    if($entryid1!=''){    
            $sql="select count('$entryid1') as entryCount,video_status from entry where entryid='$entryid1' and status='2'";
            $row= db_select($conn,$sql);
            $entryCount=$row[0]['entryCount']; $video_status=$row[0]['video_status'];
            if($entryCount==0)
            {
                echo 3;
                die();
            } 
            if($entryCount==1 && $video_status=='inactive')
            {
                echo 4;
                die();
            }    
        }
     $slider_category=$_POST['category_id'];   	
     $slider_msg1=$_POST['slider_msg'];
     $slider_msg=db_quote($conn, $slider_msg1);
     $img_id=$_POST['imgid'];
     $query3="update slider_image_detail set ventryid=$entryid,slider_category='$slider_category',slider_msg=$slider_msg where img_id='$img_id'";
     $q= db_query($conn,$query3);
     if($q)
        {
           /*----------------------------update log file begin-------------------------------------------*/
          $error_level=1;$msg="update Slider Detail($entryid1,$slider_msg)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
          $qry='';
           write_log($error_level,$msg,$lusername,$qry);
         /*----------------------------update log file End---------------------------------------------*/   
        }
        else 
        {
            /*----------------------------update log file begin-------------------------------------------*/
            $error_level=5;$msg="update Slider Detail($entryid1,$slider_msg)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
            $qry=$query3;
            write_log($error_level,$msg,$lusername,$qry);
           /*----------------------------update log file End---------------------------------------------*/ 
        }
    $page =(isset($_POST['pageindex']))? $_POST['pageindex']: ""; 
   break;    
   
}

?>
<div class="box-header" >
    <div class="row" style="border: 0px solid red; margin: -25px 5px 10px 5px;">
    <table border='0' style="width:98%; margin-left: 10px;">
    <tr>
    <td width="15%">
    <select id="pagelmt"  style="width:60px;" onchange="selpagelimit('pagelmt','slider_image_paging.php','load');" >
        <option value="10"  <?php echo $pagelimit==10? "selected":""; ?> >10</option>
        <option value="20"  <?php echo $pagelimit==20? "selected":""; ?> >20</option>
         <option value="50"  <?php echo $pagelimit==50? "selected":""; ?> >50</option>
        <option value="100" <?php echo $pagelimit==100? "selected":""; ?> >100</option>
        <option value="200" <?php echo $pagelimit==200? "selected":""; ?> >200</option>
        <option value="500" <?php echo $pagelimit==500? "selected":""; ?> >500</option>
        </select> Records Per Page
    </td>    
    <td width="10%"><input type="button"  class="btn-primary btn-xs" value="Set Priority" onclick="setPriority();" ></td>
    <td width="30%" align="left">
       <?php
       $qry="SELECT category_id,header_name  FROM header_menu where header_status='1' and menu_type='h' order by header_name";
       $fetch = db_select($conn,$qry);
       ?> 
        View Slider By Category : 
        <select name="filterentry" id="filterentry" onchange="filterView('<?php echo $page;  ?>','<?php echo $pagelimit; ?>','<?php echo $searchKeword;?>');" style="text-transform: uppercase !important;">
        <option value="00" <?php echo $filtervalue==='00' ?'selected' : '' ?> >ALL</option> 
        <?php foreach ($fetch as $fetchCat) {                                    
             $category_id=$fetchCat['category_id'];  $header_name= strtoupper($fetchCat['header_name']); 
             $sel=$category_id==$filtervalue?'selected':'';
         ?>   
        <option value="<?php echo $category_id;?>" <?php echo $sel;  ?>  ><?php echo $header_name; ?></option>
        <?php }  ?>    
     </select>
    </td>
    <td width="40%">
    <form class="navbar-form" role="search" method="post" style="  padding: 0 !important;">
       <div class="input-group add-on" style="float: right;">
           <input class="form-control"  size="30" onkeyup="SeachDataTable('slider_image_paging.php','<?php echo $pagelimit;?>','<?php //echo $page; ?>','load','<?php echo $filtervalue; ?>')"  placeholder="Search By Entryid OR Msg"  autocomplete="off" name='searchQuery' id='searchInput'  type="text" value="<?php echo $searchKeword; ?>">
       <div class="input-group-btn">
           <button class="enableOnInput btn btn-default" disabled='disabled' id='submitBtn' type="button" style="height: 30px;   padding: 4px 6px !important;" onclick="SearchDataTableValue('slider_image_paging.php','<?php echo $pagelimit;?>','<?php //echo $page; ?>','load','<?php echo $filtervalue; ?>')"><i class="glyphicon glyphicon-search"></i></button>	
       </div>
       </div>
  </form>
    
</td>
</tr>
</table>
<div class="">
  <div class="pull-left" id="flash" style="text-align: center;"></div>
  <div id="load" style="display:none;"></div>
  <div class="pull-left" id="msg" style="text-align: center;"></div> 
</div>        
</div>
<?php 
$query_search='';
if($searchKeword!='')
{
    $query_search = " and (slider_image.ventryid LIKE '%". $searchKeword . "%' or slider_image.slider_msg LIKE '%" . $searchKeword . "%')";
} 
if($filtervalue==='00'){ $filterQuery=" where slider_image.slider_category >=0 "; }
else{ $filterQuery=" where slider_image.slider_category='".$filtervalue."' "; }
    $query = "SELECT COUNT(slider_image.img_id) as num FROM slider_image_detail slider_image $filterQuery   $query_search ";
    $totalpages =db_select($conn,$query);
    $total_pages = $totalpages[0]['num'];
    $limit = $pagelimit; 
    if($page) 
            $start = ($page - 1) * $limit; 			//first item to display on this page
    else
            $start = 0;
$sql="Select slider_image.*,cat.cat_name from slider_image_detail slider_image LEFT JOIN categories  cat ON slider_image.slider_category= cat.category_id $filterQuery  $query_search order by slider_image.priority ASC LIMIT $start, $limit";
$que = db_select($conn,$sql);
$countRow=  db_totalRow($conn,$sql);
if($countRow==0)
{echo "<div align='center'><strong>No Record Found</strong> </div><br/>";}   
/* Setup page vars for display. */
?>
<form id="form" name="myform" style="border: 0px solid red;" method="post" action="priority.php">
  <table id="example1" class="table table-fixedheader table-bordered table-striped" style="width: 100%;">
    <thead>
        <tr>
         <tr>
        <th>Images</th>
        <th>Entry ID</th>
        <th width="20%">Slider-Msg</th>
        <th>Slider-Category</th>
         <th>Date</th>
          <th>Priority</th>
          <th>Status</th>
           <!--<th>Theme</th>-->
          <th>Action</th>
      </tr>             
 </tr>
 </thead>
<tbody>
<?php
$count=1;
foreach($que as $value)
{
    $id=$value['img_id']; $img_name=$value['img_name'];  $ventryid=$value['ventryid'];  $img_status=$value['img_status'];
    $img_url=$value['img_url'];  $host_url=$value['host_url'];	$slider_category=$value['slider_category']; $cat_name=$value['cat_name'];
    if (preg_match('/http:/',$host_url))
    $host_url_new=$host_url;
    else $host_url_new="http://".$host_url; 	
    $priority=$value['priority']; $slider_msg=$value['slider_msg'];
    //$status=$img_status==1? "active": "inactive";
    $status=$img_status==1? "<span class='label label-success'>active</span>": "<span class='label label-danger'>inactive</span>";
    $categoryName=$slider_category==='0'? 'HOME SCREEN': $cat_name;
    
 ?> 
<tr id="sliderdel<?php echo $id; ?>">
<td width="250">
<a class="fancybox" href="#<?php //echo $host_url_new.$img_url; ?>" data-fancybox-group="gallery" title=""><img src="<?php echo $host_url_new.$img_url; ?>" alt="" class="img-responsive customer-img" width="200" /></a>
</td>
<td><?php echo $ventryid; ?></td>
<td width="20%"><?php echo wordwrap($slider_msg,40, "\n", true); ?></td>
<td><?php echo $categoryName ;?></td>
<td><?php echo $value['img_create_date'];?></td>
<td><?php echo $priority; ?></td>
<td id="getstatus<?php  echo $id; ?>"><?php echo $status; ?>
<!--<span class="label label-<?php echo $img_status==1? "success": "danger"; ?>" ><?php echo $status ;?></span> -->
</td>
<td>
<div class="dropdown">
<input type="hidden" size="7" id="video_entry_id<?php echo $id;  ?>" value="<?php echo $ventryid; ?>" >
<input type="hidden" size="2" id="act_deact_status<?php echo $id;  ?>" value="<?php echo $img_status; ?>" >
<?php  if(in_array(4, $UserRight)){ ?>   
<a href="javascript:void(0)" class="delete" title="Delete" onclick="slider_img_delete('<?php echo $id; ?>','<?php echo $page;?>','<?php echo $priority; ?>')" ><span class="glyphicon glyphicon-trash"></span></a>&nbsp;&nbsp;&nbsp;
<?php }  if(in_array(2, $UserRight)){ ?>
<a href="javascript:void(0)" class="myBtnn" onclick="edit_slider_image('<?php echo $id; ?>','<?php echo $page; ?>','<?php echo $pagelimit; ?>','<?php echo $searchKeword; ?>','<?php echo $filtervalue; ?>')"   id="<?php echo $id; ?>" title="Edit Slider" class="addnew">
<span class="glyphicon glyphicon-edit"></span></a>&nbsp;&nbsp;&nbsp;
<a href="javascript:void(0)">
<i id="icon_status<?php echo $id; ?>" class="status-icon fa <?php  echo ($img_status == 1) ? 'fa-check-square-o':'fa-ban';?>" onclick="act_dect_slider('<?php echo $id; ?>')" ></i>
</a> 
  <?php } ?>
 </div>
</td>
</tr>   
<?php $count++; } ?>         
</tbody>
</table>
</form>    
<div class="page" style="border: 0px solid red; text-align: center; background-color:#fff !important; height:40px;">
<?php if($start==0) { 
       if($total_pages==0){  $startShow=0;  } else {  $startShow=1;}
       $lmt=$limit<$total_pages ? $limit :$total_pages;
       }
      else { $startShow=$start+1;  $lmt=$start+$countRow;  }
?>    
    <div class="pull-left" style="border: 0px solid red;">
      Showing <?php echo $startShow; ?>  to <?php echo $lmt; ?>   of <?php echo $total_pages; ?> entries   
      <span style="margin-left: 50px;" id="paging_loader"></span>
    </div> 
    <div class="pull-right" style="border: 0px solid red;">
    <?php
    if ($page == 0) $page = 1;
    $adjacent=1; $targetpage=''; $fromdate=''; $todate=''; $pageUrl='slider_image_paging.php'; $filtervalue=$filtervalue;
    echo pagination($page,$limit,$total_pages,$adjacent,$targetpage,$searchKeword,$fromdate,$todate,$pageUrl,$filtervalue);
    ?>
    </div> 
</div>
<script src="js/commonFunctionJS.js" type="text/javascript"></script>
<script type="text/javascript">
function add_new_slider()    
{
     $("#LegalModal_add_new_slider").modal();
     //$("#flash").fadeIn(500).html('Loading <img src="img/image_process.gif" />');
      var info = 'action=add_new_slider_image'; 
        $.ajax({
	    type: "POST",
	    url: "img.php",
	    data: info,
             success: function(result){
            // $("#flash").hide();
             $('#add_new_slider_image').html(result);
            return false;
        }
 
        });
     return false;    
}
function edit_slider_image(imgid,pageNum,limitval,searchInputall,filtervalue)    
{
     $("#myModal_edit_slider").modal();
     //$("#flash").fadeIn(500).html('Loading <img src="img/image_process.gif" />');
  var info = 'action=edit_slider_image&imgid='+imgid+"&pageNum="+pageNum+"&limitval="+limitval+"&searchInputall="+searchInputall+"&filtervalue="+filtervalue; 
        $.ajax({
	    type: "POST",
	    url: "img.php",
	    data: info,
             success: function(result){
            // $("#flash").hide();
             $('#edit_slider_image').html(result);
            return false;
        }
 
        });
     return false;  
}

function save_edit_slider(imgid,pageindex,limitval,searchInputall,filtervalue)
{
     $('#updateSlider').attr('disabled',true);
     $("#saving_loader").html('');
     $("#saving_loader").html('Saving.... <img src="img/image_process.gif" alt="Saving...."/>');
     var ventryid = $('#ventryid').val();
     var category_id=$("#category_value").val();   
     var slider_msg=$("#slider_msg").val();
     var apiBody = new FormData();
     apiBody.append("imgid",imgid);
     apiBody.append("pageindex",pageindex);
     apiBody.append("limitval",limitval);
     apiBody.append("ventryid",ventryid);
     apiBody.append("slider_msg",slider_msg);
     apiBody.append("category_id",category_id);
     apiBody.append("searchInputall",searchInputall);
     apiBody.append("filtervalue",filtervalue);
     apiBody.append("action","save_edit_slider");
     $.ajax({
                url:'slider_image_paging.php',
                method: 'POST',
                data:apiBody,
                processData: false,
                contentType: false,
                success: function(rr){
                if(rr==3)
                {
                     $('#myModal_edit_slider').modal('show');
                     $("#flash").hide();
                     var mess="EntryID not valid.please enter valid EntryID.";
                     $("#ventryid-error").html(mess);
                     $('#updateSlider').attr('disabled',false);
                     $("#saving_loader").hide();
                     $("#msg").hide(); 
                     return false;  
                }
                if(rr==4)
                {
                     $('#myModal_edit_slider').modal('show');
                     $("#flash").hide();
                     var mess="EntryID is <b>inactive</b>. please active a video then save a slider image.";
                     $("#ventryid-error").html(mess);
                     $('#updateSlider').attr('disabled',false);
                     $("#saving_loader").hide();
                     $("#msg").hide(); 
                     return false;  
                }     
                $("#saving_loader").hide();
                $('#myModal_edit_slider').modal('hide');
                $("#results").html(rr);
                $("#msg").html("<div class='alert alert-success'>Slider image edit <strong>successfully </strong>.</div>");
                }
            });	
     
    
}

function slider_img_delete(sliderid,pageNum,priority){
var st=document.getElementById('act_deact_status'+sliderid).value;
if(st==1) { alert('This Tag is active so you can not delete'); return false;} 
var d=confirm("Are you sure you want to Delete This Tag?");
if(d)
{
       var info = 'sliderid='+sliderid+'&priority='+priority+'&action=slider_img_delete';
       $.ajax({
       type: "POST",
       url: "coredelete.php",
       data: info,
       success: function(r){
         if(r==1)
         {
             //$("#sliderdel"+sliderid).remove();
              $('#results').load("slider_image_paging.php",{'pageNum':pageNum},
	           function() {
	  	   pageNum++;
	  	}); //load first g
         }   

         }
    });  
}    

}

function filterView(pageNum,limitval,searchtext)  
{
    var filtervalue = $('#filterentry').val();
    $('#load').show();
    $('#results').css("opacity",0.1);
     var apiBody = new FormData();
     apiBody.append("filtervalue",filtervalue);
     //apiBody.append("pageindex",pageindex);
     apiBody.append("limitval",limitval);
     apiBody.append("searchInputall",searchtext);
     apiBody.append("action","filterview");
      $.ajax({
           type: "POST",
           url: "slider_image_paging.php",
           data: apiBody,
           processData: false,
           contentType: false,
           cache: false,
           success: function(result){
           $("#results").html(result);
           $('#load').hide();
           $('#results').css("opacity",1);
          }
     });     
}


</script>