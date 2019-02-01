<?php
//sleep(2);
include_once 'corefunction.php';
include_once("function.php");
$searchKeword = (isset($_POST['searchInputall']))? $_POST['searchInputall']: "";
$page =(isset($_POST['pageNum']))? $_POST['pageNum']: 0;
$pagelimit = (isset($_POST['limitval']))? $_POST['limitval']:10;
$action = (isset($_POST['action'])) ? $_POST['action']: "";
switch($action)
{
     case "active_inactive_popup_img":
     $popup_imge_id=trim($_POST['popup_imge_id']); $img_status=trim($_POST['img_status']);
     $updateStatus=$img_status==0?1:0;
     $msg=$updateStatus==1?'active':'inactive';
     if($img_status==1){
         $msg='inactive';
         $up="update popup_images set img_status='0' where popup_imge_id='$popup_imge_id'";
     }
     else{ $up="update popup_images set img_status=IF(popup_imge_id=$popup_imge_id,1,0)"; }
      $r=db_query($conn,$up);
        if($r)
        {
           /*----------------------------update log file begin-------------------------------------------*/
          $error_level=1;$msg=" PopUP Image $msg($popup_imge_id)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
          $qry=$up;
           write_log($error_level,$msg,$lusername,$qry);
         /*----------------------------update log file End---------------------------------------------*/   
        }
     
     
    break;    
   
}

?>
<div class="box-header" >
    <div class="row" style="border: 0px solid red; margin: -25px 5px 10px 5px;">
    <table border='0' style="width:98%; margin-left: 10px;">
    <tr>
    <td width="25%">
    <select id="pagelmt"  style="width:60px;" onchange="selpagelimit_new('pagelmt','popup_image_paging.php','load');" >
        <option value="10"  <?php echo $pagelimit==10? "selected":""; ?> >10</option>
        <option value="20"  <?php echo $pagelimit==20? "selected":""; ?> >20</option>
         <option value="50"  <?php echo $pagelimit==50? "selected":""; ?> >50</option>
        <option value="100" <?php echo $pagelimit==100? "selected":""; ?> >100</option>
        <option value="200" <?php echo $pagelimit==200? "selected":""; ?> >200</option>
        <option value="500" <?php echo $pagelimit==500? "selected":""; ?> >500</option>
        </select> Records Per Page
    </td>    
   
   
    <td width="45%">
        <form class="navbar-form" role="search" method="post" style="  padding: 0 !important;">
       <div class="input-group add-on" style="float: right;">
       <input id='pagelimit' type="hidden" height="30px"  value="<?php echo $pagelimit; ?>">   
       <input class="form-control" size="30" onkeyup="SeachDataTable('popup_image_paging.php','<?php echo $pagelimit;?>','<?php //echo $page; ?>','flash')"  placeholder="Search Entries"  autocomplete="off" name='searchQuery' id='searchInput' class="searchInput" type="text" value="<?php echo $searchKeword; ?>">
       <div class="input-group-btn">
           <button class="enableOnInput btn btn-default" disabled='disabled' id='submitBtn' type="button" style="height: 26px;   padding: 4px 6px !important;" onclick="SearchDataTableValue('popup_image_paging.php','<?php echo $pagelimit;?>','<?php //echo $page; ?>','flash ')"><i class="glyphicon glyphicon-search"></i></button>	
     
       	
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
    $query_search = " where (image_title LIKE '%". $searchKeword . "%')";
}    
//***** following code doing delete end ***/				
$adjacents = 3;
    $query = "SELECT popup_imge_id FROM popup_images  $query_search ";
    $total_pages =  db_totalRow($conn,$query);
    $limit = $pagelimit; 
    if($page) 
            $start = ($page - 1) * $limit; 			//first item to display on this page
    else
            $start = 0;

$sql="Select * from popup_images $query_search order by added_date ASC LIMIT $start, $limit";
$que = db_select($conn,$sql);
$countRow=  db_totalRow($conn,$sql);
if($countRow==0)
{echo "<div align='center'><strong>No Record Found</strong> </div><br/>";}   
/* Setup page vars for display. */
?>
<form id="form" name="myform" style="border: 0px solid red;" method="post">
  <table id="example1" class="table table-fixedheader table-bordered table-striped" style="width: 100%;">
    <thead>
        <tr>
         <tr>
        <th>Images</th>
        <th>Image Title</th>
        <th>Date</th>
        <th>Status</th>
        <th>Action</th>
      </tr>             
 </tr>
 </thead>
<tbody>
<?php
$count=1;
foreach($que as $value) 
{
    $id=$value['popup_imge_id']; $img_name=$value['img_name'];  $added_date=$value['added_date'];  $img_status=$value['img_status'];
    $img_url=$value['img_url'];  $host_url=$value['host_url']; $img_title=$value['image_title']; 	
    $disableLink=$img_status==1?'not-active-href':'';	
 ?> 
<tr id="sliderdel<?php echo $id; ?>">
<td width="250">
<img class="img-responsive customer-img" width="200"   src="<?php echo $host_url.$img_url; ?>" alt="" />

</td>

<td><?php echo $img_title; ?></td>
<td><?php echo $added_date;?></td>
<td id="getstatus<?php  echo $id; ?>"><?php echo $img_status==1?"active": "inactive"; ?></td>
<td>
<div class="dropdown">
<?php  if(in_array(4, $UserRight)){ ?>   
<a href="javascript:void(0)" class="<?php echo $disableLink; ?>" title="Delete" onclick="popup_img_delete('<?php echo $id; ?>','<?php echo $page;?>')" ><span class="glyphicon glyphicon-trash"></span></a>&nbsp;&nbsp;&nbsp;
<?php }  if(in_array(2, $UserRight)){ ?>
<a href="javascript:void(0)">
<i id="icon_status<?php echo $id; ?>" class="status-icon fa <?php  echo ($img_status == 1) ? 'fa-check-square-o':'fa-ban';?>" onclick="act_dect_popup_image('<?php echo $id; ?>','<?php echo $img_status; ?>')" ></i>
</a> 
  <?php } ?>
 </div>
</td>
</tr>   
<?php $count++; } ?>         
</tbody>
</table>

<div class="page" style="border: 0px solid red; text-align: center; background-color:#fff !important; height:40px;">
<div class="col-md-12 pull-right" style="border:0px solid red;margin-top: 0px; min-height: 20px;">
<?php if($start==0) { $startShow=1; 
       $lmt=$limit<$total_pages ? $limit :$total_pages;
       }
      else { $startShow=$start+1;  $lmt=$start+$countRow;  }
?>
<div class="col-md-3 pull-left" style="border: 0px solid red;">
 Showing <?php echo $startShow; ?>  to <?php echo $lmt; ?>   of <?php echo $total_pages; ?> entries </div>
<?php
if ($page == 0) $page = 1;
$adjacent=1; $targetpage=''; $fromdate=''; $todate='';
echo pagination($page,$limit,$total_pages,$adjacent,$targetpage,$searchKeword,$fromdate,$todate);?></div> 
</div>

</form>
<script src="js/commonFunctionJS.js" type="text/javascript"></script>
<script type="text/javascript">
function add_new_popup_images()    
{
     $("#LegalModal_add_new_popup_image").modal();
     //$("#flash").fadeIn(500).html('Loading <img src="img/image_process.gif" />');
      var info = 'action=popup_images'; 
        $.ajax({
	    type: "POST",
	    url: "img.php",
	    data: info,
             success: function(result){
            // $("#flash").hide();
             $('#add_new_popup_image').html(result);
            return false;
        }
 
        });
     return false;    
}
function changePagination(pageid,limitval,searchtext,fromdate,todate){    
     $('#load').show();
      $('#results').css("opacity",0.1);
      var dataString ='pageNum='+pageid+'&limitval='+limitval+'&searchInputall='+searchtext+'&fromdate='+fromdate+'&todate='+todate;
      $.ajax({
           type: "POST",
           url: "popup_image_paging.php",
           data: dataString,
           cache: false,
           success: function(result){
           	 $("#results").html('');
                 $("#results").html(result);
                 $('#load').hide();
                 $('#results').css("opacity",1);
           }
     }); 
}


function popup_img_delete(popup_imge_id,pageNum){
var d=confirm("Are you sure you want to Delete This image?");
if(d)
{
       var info = 'popup_imge_id='+popup_imge_id+'&action=popup_img_delete';
       $.ajax({
       type: "POST",
       url: "coredelete.php",
       data: info,
       success: function(r){
         if(r==1)
         {
               $('#results').load("popup_image_paging.php",{'pageNum':pageNum},
	           function() {
	  	   pageNum++;
	  	}); //load first g
         }   

         }
    });  
}    

}

function act_dect_popup_image(popup_imge_id,img_status){
var msg = (img_status == 1) ? "inactive":"active";
var c=confirm("Are you sure you want to "+msg+ " This?");
if(c)
{	
 
   $('#load').show();
   $('#results').css("opacity",0.1);         
   $.ajax({
   type: "POST",
   url: "popup_image_paging.php",
   data:'popup_imge_id='+popup_imge_id+'&img_status='+img_status+'&action=active_inactive_popup_img',
   success: function(result){
          $("#results").html('');
                 $("#results").html(result);
                 $('#load').hide();
                 $('#results').css("opacity",1);
                 $('#msg').html("image succesfully "+msg);
     }
 
   });
 }  
 
}


</script>