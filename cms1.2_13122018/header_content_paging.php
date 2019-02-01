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
     case "save_editheadercontent":
     $id=$_POST['hcid']; $headername=$_POST['m_name'];   
     $menutype=$_POST['menu_type'];  $host_url=$_POST['host_url']; $img_urls=$_POST['img_urls'];
     $view_type=$_POST['view_type'];
     $query3="update header_menu set header_name='$headername', menu_type='$menutype',view_type='$view_type',host_url='$host_url',img_url='$img_urls' where hid='$id'";
     $q= db_query($conn,$query3);
     /*----------------------------update log file begin-------------------------------------------*/
          $error_level=1;$msg="update Header Content Detail($headername)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
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
    <td width="25%">       
    <select id="pagelmt"  style="width:60px;" onchange="selpagelimit('pagelmt','header_content_paging.php','load');" >
        <option value="10"  <?php echo $pagelimit==10? "selected":""; ?> >10</option>
        <option value="20"  <?php echo $pagelimit==20? "selected":""; ?> >20</option>
        <option value="50"  <?php echo $pagelimit==50? "selected":""; ?> >50</option>
        <option value="100" <?php echo $pagelimit==100? "selected":""; ?> >100</option>
    </select> Records Per Page
    </td> 
    <td width="20%"><input type="button"  class="btn-primary btn-xs" value="Set Priority" onclick="setPriority();" ></td>
    <td width="45%">
       <!--<form class="navbar-form" role="search" method="post" style="  padding: 0 !important;">-->
      <div class="col-sm-3 col-md-3 pull-right navbar-form" role="search">  
        <div class="input-group add-on" style="float: right;">
        <input id='pagelimit' type="hidden" height="30px"  value="<?php echo $pagelimit; ?>">   
        <input class="form-control" size="30" onkeyup="SeachDataTable('header_content_paging.php','<?php echo $pagelimit;?>','<?php //echo $page; ?>','load')"  placeholder="Search Entries by Header Name"  autocomplete="off" name='searchQuery' id='searchInput' class="searchInput" type="text" value="<?php echo $searchKeword; ?>">
        <div class="input-group-btn">
        <button class="enableOnInput btn btn-default" onclick="SearchDataTableValue('header_content_paging.php','<?php echo $pagelimit;?>','<?php //echo $page; ?>','load')" disabled='disabled' id='submitBtn' type="button" style="height: 30px;   padding: 4px 6px !important;" ><i class="glyphicon glyphicon-search"></i></button>	
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
  <div style="text-align:center; color: red;"><?php echo $msgg; ?></div>
</div>        
</div>
<?php 
$query_search='';
if($searchKeword!='')
{
    $query_search = " and  (header_name LIKE '%". $searchKeword . "%' OR menu_type LIKE '%". $searchKeword . "%')";
}    
//***** following code doing delete end ***/				
    $query = "SELECT COUNT(hid) as num FROM header_menu where header_status!='3'  $query_search ";
    $totalpages =db_select($conn,$query);
    $total_pages = $totalpages[0]['num'];
    $limit = $pagelimit; 
    if($page) 
            $start = ($page - 1) * $limit; 			//first item to display on this page
    else
            $start = 0;
$sql="Select * from header_menu where header_status!='3' $query_search order by priority ASC LIMIT $start, $limit";
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
           <th>Menu icon</th>  
           <th>Header Name</th>
           <th>Priority</th>
           <th>Menu Type</th>
           <th>Date</th>
           <th>Status</th>
           <th>Action</th>
         </tr> 
   </thead>
<tbody>
<?php
$count=1;
foreach($que as $fetch)
{
    $id=$fetch['hid']; $header_name =$fetch['header_name'];  $headerstatus=$fetch['header_status'];	
    $priority=$fetch['priority']; $date=$fetch['added_date'];
    $status=$headerstatus==1? "<span class='label label-success'>active</span>": "<span class='label label-danger'>inactive</span>";
    $img_url=$fetch['img_url'];  $host_url=$fetch['host_url']; $menuType=$fetch['menu_type'];
    if (preg_match('/http:/',$host_url))
    $host_url_new=$host_url;
    else $host_url_new="http://".$host_url; 
    switch($menuType)
    {
        case "h":
        $menyTypeName="Header Menu";
        break;
        case "l":
        $menyTypeName="Left Menu";
        break;
        case "r":
        $menyTypeName="Right Menu";
        break;
        case "f":
        $menyTypeName="Footer Menu";
        break;
    
    }
    
 ?>
<tr id="headerdel<?php echo $id; ?>">
<td width="250" >
    <img class="img-responsive customer-img" style="background-color: black;" src="<?php echo $host_url_new.$img_url; ?>"  height="25" width="40" >
</td>  
<td><?php echo $header_name; ?></td>
<td><?php echo $priority; ?></td>
<td><span class='label label-info'><?php echo $menyTypeName; ?></span></td>
<td><?php echo $date; ?></td>

<td id="getstatus<?php  echo $id; ?>"><?php echo $status; ?></td>
<td> 
<input type="hidden" size="2" id="act_deact_status<?php echo $id;  ?>" value="<?php echo $headerstatus; ?>" >    
<?php  if(in_array(4, $UserRight)){ ?>       
 <a href="javascript:void(0)"  class="delete" title="Delete" onclick="homedelete('<?php echo $id; ?>')"><span class="glyphicon glyphicon-trash"></span></a> &nbsp;&nbsp;&nbsp;
 <?php }  if(in_array(2, $UserRight)){ ?>
 <a href="javascript:void(0)" class="myBtnn" onclick="edit_headerContent('<?php echo $id; ?>','<?php echo $page; ?>','<?php echo $pagelimit; ?>')" id="<?php  echo $id; ?>" title="Edit" class="result"><span class="glyphicon glyphicon-edit"></span></a>&nbsp;&nbsp;&nbsp;
 <a href="javascript:void(0)">
  <i id="icon_status<?php echo $id; ?>" class="status-icon fa <?php  echo ($headerstatus == 1) ? 'fa-check-square-o':'fa-ban';?>" onclick="act_dect_home('<?php echo  $id; ?>')" ></i>
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
    $adjacent=2; $targetpage=''; $fromdate=''; $todate=''; $pageUrl='header_content_paging.php'; $filtervalue='';
    echo pagination($page,$limit,$total_pages,$adjacent,$targetpage,$searchKeword,$fromdate,$todate,$pageUrl,$filtervalue);
    ?>
    </div> 
</div> 
<script src="js/commonFunctionJS.js" type="text/javascript"></script>
<script type="text/javascript">
function add_new_headerContent()    
{
     $("#myModal_add_new_headerContent").modal();
     //$("#flash").fadeIn(500).html('Loading <img src="img/image_process.gif" />');
      var info = 'action=add_new_headercontent'; 
        $.ajax({
	    type: "POST",
	    url: "headerContentModal.php",
	    data: info,
             success: function(result){
            // $("#flash").hide();
             $('#view_modal_new_headerContent').html(result);
            return false;
        }
 
        });
     return false;    
}
function edit_headerContent(hcid,pageindex,limitval)    
{
     $("#LegalModal_modal_edit_headerContent").modal();
     //$("#flash").fadeIn(500).html('Loading <img src="img/image_process.gif" />');
      var info = 'action=edit_headercontent&hcid='+hcid+"&pageindex="+pageindex+"&limitval="+limitval; 
        $.ajax({
	    type: "POST",
	    url: "headerContentModal.php",
	    data: info,
             success: function(result){
            // $("#flash").hide();
             $('#edit_modal_headerContent').html(result);
            return false;
        }
 
        });
     return false;  
}
function previewViewType(viewName,imgurl)    
{
     $("#myModalViewType").modal();
     //$("#flash").fadeIn(500).html('Loading <img src="img/image_process.gif" />');
      var info = 'action=viewTypePreview&viewName='+viewName+"&viewImgUrl="+imgurl; 
        $.ajax({
	    type: "POST",
	    url: "viewTypeModal.php",
	    data: info,
             success: function(result){
            // $("#flash").hide();
             $('#view_view_type').html(result);
            return false;
        }
 
        });
     return false;    
}
</script>