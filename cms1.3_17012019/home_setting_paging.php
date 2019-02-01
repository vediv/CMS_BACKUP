<?php
sleep(1);
include_once 'corefunction.php';
include_once("function.php");
$searchKeword = (isset($_POST['searchInputall']))? $_POST['searchInputall']: "";
$page =(isset($_POST['pageNum']))? $_POST['pageNum']: 0;
$pagelimit = (isset($_POST['limitval']))? $_POST['limitval']: 10;
$action = (isset($_POST['action'])) ? $_POST['action']: "";
switch($action)
{
     case "save_hometag":
      $ttag=$_POST['ttag']; $stag=$_POST['stag'];
      $sql="insert into home_title_tag (title_tag_name,search_tag,tag_status,priority,create_date) Select '$ttag','$stag','0',ifnull(max(priority),0)+1,NOW() from home_title_tag";
      $r=db_query($conn,$sql);
         /*----------------------------update log file begin-------------------------------------------*/
          $error_level=1;$msg="Add New HomeSettingTag($ttag)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
          $qry='';
          write_log($error_level,$msg,$lusername,$qry);
          /*----------------------------update log file End---------------------------------------------*/   
      $page =(isset($_POST['pageindex']))? $_POST['pageindex']: ""; 
       
   break;    
     case "save_edithometag":
     $tagid=$_POST['tagid']; $ttag=$_POST['ttag']; $stag=$_POST['stag'];
     $query3="update home_title_tag set title_tag_name='$ttag',search_tag='$stag',create_date=Now() where tags_id='$tagid'";
     $q= db_query($conn,$query3);
     /*----------------------------update log file begin-------------------------------------------*/
          $error_level=1;$msg="update HomeSettingTag Detail($ttag)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
          $qry='';
          write_log($error_level,$msg,$lusername,$qry);
    /*----------------------------update log file End---------------------------------------------*/   
     $page =(isset($_POST['pageindex']))? $_POST['pageindex']: "";
     break;    
   
}

?>
<div class="box-header" >
    <div class="row" style="border: 0px solid red; margin: -25px 5px 10px 5px;">
    <table border='0' style="width:98%; margin-left: 10px;">
    <tr>
    <td width="15%">
    <select id="pagelmt"  style="width:60px;" onchange="selpagelimit('pagelmt','home_setting_paging.php','load');" >
        <option value="10"  <?php echo $pagelimit==10? "selected":""; ?> >10</option>
        <option value="20"  <?php echo $pagelimit==20? "selected":""; ?> >20</option>
         <option value="50"  <?php echo $pagelimit==50? "selected":""; ?> >50</option>
        <option value="100" <?php echo $pagelimit==100? "selected":""; ?> >100</option>
        <option value="200" <?php echo $pagelimit==200? "selected":""; ?> >200</option>
        <option value="500" <?php echo $pagelimit==500? "selected":""; ?> >500</option>
        </select> Records Per Page
    </td>
    <td width="15%"><input type="button"  class="btn-primary btn-xs" value="Set Priority" onclick="setPriority();" ></td>
    <td width="60%">
     <!--<form class="navbar-form" role="search" method="post" style="  padding: 0 !important;">-->
         <div class="col-sm-3 col-md-3 pull-right navbar-form" role="search">  
            <div class="input-group add-on" style="float: right;">
            <input id='pagelimit' type="hidden" height="30px"  value="<?php echo $pagelimit; ?>">   
            <input class="form-control" size="30" onkeyup="SeachDataTable('home_setting_paging.php','<?php echo $pagelimit;?>','<?php //echo $page; ?>','load')"  placeholder="Search Entries by tagName Or SearchTag"  autocomplete="off" name='searchQuery' id='searchInput' class="searchInput" type="text" value="<?php echo $searchKeword; ?>">
            <div class="input-group-btn">
              <button class="enableOnInput btn btn-default" disabled='disabled' onclick="SearchDataTableValue('home_setting_paging.php','<?php echo $pagelimit;?>','<?php //echo $page; ?>','load')" id='submitBtn' type="button" style="height: 30px;   padding: 4px 6px !important;"><i class="glyphicon glyphicon-search"></i></button>	
            </div>
            </div>
         </div>   
     <!--</form>-->

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
    $query_search = " where (title_tag_name LIKE '%". $searchKeword . "%' or search_tag LIKE '%" . $searchKeword . "%')";
}    

$query = "SELECT COUNT(tags_id) as num FROM home_title_tag  $query_search ";
$totalpages =db_select($conn,$query);
$total_pages = $totalpages[0]['num'];
$limit = $pagelimit; 
    if($page) 
            $start = ($page - 1) * $limit; 			//first item to display on this page
    else
            $start = 0;

$sql="Select * from home_title_tag $query_search order by priority ASC LIMIT $start, $limit";
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
          <th>Tag Name</th>
          <th>Search Tag</th>
          <th>Priority</th>
         <th>Date</th>
         <th>status</th>
        <th>Action</th>
       </tr> 
 </thead>
<tbody>
<?php
$count=1;
foreach($que as $fetch)
{
    $id=$fetch['tags_id']; $ttag =$fetch['title_tag_name']; $stag=$fetch['search_tag']; $tagstatus=$fetch['tag_status'];	
    $priority=$fetch['priority']; $date=$fetch['create_date'];	
    $status=$tagstatus==1? "<span class='label label-success'>active</span>": "<span class='label label-danger'>inactive</span>";
   
 ?> 
<tr id="homedel<?php echo $id; ?>">
<td><?php echo $ttag; ?></td>
<td><?php echo $stag; ?></td>
<td><?php echo $priority; ?></td>
<td><?php echo $date; ?></td>
<td id="getstatus<?php  echo $id; ?>"><?php echo $status;?></td>
<td> 
<input type="hidden" size="2" id="act_deact_status<?php echo $id;  ?>" value="<?php echo $tagstatus; ?>" >    
<?php  if(in_array(4, $UserRight)){ ?>       
 <a href="javascript:void(0)"  class="delete" title="Delete" onclick="homedelete('<?php echo $id; ?>','<?php echo $priority; ?>')"><span class="glyphicon glyphicon-trash"></span></a> &nbsp;&nbsp;&nbsp;
 <?php }  if(in_array(2, $UserRight)){ ?>
 <a href="javascript:void(0)" class="myBtnn" onclick="edit_homeTag('<?php echo $id; ?>','<?php echo $page; ?>','<?php echo $pagelimit; ?>')" id="<?php  echo $id; ?>" title="Edit" class="result"><span class="glyphicon glyphicon-edit"></span></a>&nbsp;&nbsp;&nbsp;
 <a href="javascript:void(0)">
  <i id="icon_status<?php echo $id; ?>" class="status-icon fa <?php  echo ($tagstatus == 1) ? 'fa-check-square-o':'fa-ban';?>" onclick="act_dect_home('<?php echo  $id; ?>')" ></i>
</a>  
<?php } ?>
</td> </tr>       

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
    $adjacent=3; $targetpage=''; $fromdate=''; $todate=''; $pageUrl='home_setting_paging.php'; $filtervalue='';
    echo pagination($page,$limit,$total_pages,$adjacent,$targetpage,$searchKeword,$fromdate,$todate,$pageUrl,$filtervalue);
    ?>
    </div> 
</div>
<script src="js/commonFunctionJS.js" type="text/javascript"></script>
<script type="text/javascript">
function add_new_homeTag()    
{
     $("#myModal_add_new_homeTags").modal();
     //$("#flash").fadeIn(500).html('Loading <img src="img/image_process.gif" />');
      var info = 'action=add_new_hometags'; 
        $.ajax({
	    type: "POST",
	    url: "homeSettingModal.php",
	    data: info,
             success: function(result){
            // $("#flash").hide();
             $('#view_modal_new_homeTags').html(result);
            return false;
        }
 
        });
     return false;    
}
function edit_homeTag(tagid,pageindex,limitval)    
{
     $("#LegalModal_modal_edit_homeTags").modal();
     //$("#flash").fadeIn(500).html('Loading <img src="img/image_process.gif" />');
      var info = 'action=edit_homeTags&tagid='+tagid+"&pageindex="+pageindex+"&limitval="+limitval; 
        $.ajax({
	    type: "POST",
	    url: "homeSettingModal.php",
	    data: info,
             success: function(result){
            // $("#flash").hide();
             $('#edit_modal_homeTags').html(result);
            return false;
        }
 
        });
     return false;  
}




</script>