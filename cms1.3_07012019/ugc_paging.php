<?php
sleep(1);
include_once 'corefunction.php';
$searchTextMatch = (isset($_POST['searchInputall']))? $_POST['searchInputall']: "";
$pagelimit = (isset($_POST['limitval']))? $_POST['limitval']: 20;
$pager_pageIndex =(isset($_POST['first_load']))? $_POST['first_load']:0;
$filtervalue=(isset($_POST['filtervalue']))? $_POST['filtervalue']:0;
$action = (isset($_POST['maction']))? $_POST['maction']: "";
switch($action)
{
    case "deletecontent":
    $pageindex_when_delete= (isset($_POST['pageindex']))? $_POST['pageindex']: "";
    $pager_pageIndex=$pageindex_when_delete;
    break;
    case "ugc_regect":
    $ugid= $_POST['ugc_id'];
    $qryreg="update ugc_entry set status='4' where id='$ugid'";
    $rr=  db_query($conn, $qryreg);
     /*----------------------------update log file begin-------------------------------------------*/
    $error_level=1;$msg="UGC Entry Regected($ugid)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
    $qry=$upcatinfoinentry;
    write_log($error_level,$msg,$lusername,$qry);
     /*----------------------------update log file End---------------------------------------------*/
    echo 1;
    exit;
    break;
    case "only_page_limitval":
    $pageindex = (isset($_POST['pageindex']))? $_POST['pageindex']: "";
    $pager_pageIndex=$pageindex;
    break;
    case "refresh":
    //$pageindex = (isset($_POST['pageindex']))? $_POST['pageindex']: "";
    //$pager_pageIndex=$pageindex;
    break;

    case "filterview":
    $pageindex = (isset($_POST['pageindex']))? $_POST['pageindex']: "";
    $pager_pageIndex=$pageindex;
    break;

}

$query_search=''; $query_search1='';
if($searchTextMatch!='')
{
    $query_search1 = " where (ugc.title LIKE '%". $searchTextMatch . "%' or ugc.tag LIKE '%" . $searchTextMatch . "%' or ugc.entryid LIKE '%" . $searchTextMatch . "%' or ugc.description LIKE '%" . $searchTextMatch . "%')";
    $query_search = "  and (ugc.title LIKE '%". $searchTextMatch . "%' or ugc.tag LIKE '%" . $searchTextMatch . "%' or ugc.entryid LIKE '%" . $searchTextMatch . "%' or ugc.description LIKE '%" . $searchTextMatch . "%')";
}
$query = "SELECT COUNT(*) as totalEntry FROM ugc_entry ugc  LEFT JOIN entry en ON ugc.entryid=en.entryid";
if($filtervalue=='0'){  $query.=" $query_search1"; }
if($filtervalue=='11'){  $query.=" where ugc.status='$filtervalue' $query_search"; }
if($filtervalue=='2'){  $query.=" where en.status='$filtervalue' $query_search"; }
/*if($login_access_level=='c'){
    $accessLevelQuery=" and puser_id='$get_user_id'";
}*/
//echo $query;

$totalpages =db_select($conn,$query);
$totalEntry = $totalpages[0]['totalEntry'];
if($pager_pageIndex)
           $start = ($pager_pageIndex - 1) * $pagelimit;
else
      $start = 0;
      $fromDate=$_POST['fromDate']; $toDate=$_POST['toDate'];
      $entry_query="select ugc.id,ugc.title,ugc.upload_status,ugc.status,ugc.entryid,ugc.userid,ugc.added_date,ugc.category
            ,ur.user_id,en.status as kstatus from ugc_entry ugc
            LEFT JOIN user_registration ur ON ugc.userid=ur.uid  LEFT JOIN entry en ON ugc.entryid=en.entryid";
if($filtervalue=='0'){  $entry_query.=" $query_search1"; }
if($filtervalue=='11'){  $entry_query.=" where ugc.status='$filtervalue' $query_search"; }
if($filtervalue=='2'){  $entry_query.=" where en.status='$filtervalue' $query_search"; }
$entry_query.=" ORDER BY (ugc.added_date) DESC  LIMIT $start,$pagelimit ";
//echo "<br/>Entry Select=".$entry_query;
$fetchMedia=  db_select($conn,$entry_query);
$total_pages=$totalEntry;
$act_inact="SELECT  SUM(IF (en.status='2',1,0)) AS total_active,SUM(IF (ugc.status='11',1,0)) AS
total_inactive,SUM(IF (en.status='1',1,0)) AS total_convert,SUM(IF (ugc.status='4',1,0)) AS trejected
FROM ugc_entry ugc left join entry en ON ugc.entryid=en.entryid  ";
$tableAD=  db_select($conn,$act_inact);
$totalActive=$tableAD[0]['total_active']; $totalInactive=$tableAD[0]['total_inactive'];
$total_convert=$tableAD[0]['total_convert']; $treject=$tableAD[0]['trejected'];
$totalEntry=$totalActive+$totalInactive+$total_convert+$treject;
$total_active_disabled=$totalActive==0?'disabled':'';
$total_inactive_disabled=$totalInactive==0?'disabled':'';
?>
<div class="box-header" >
  <div class="input-group" style="margin-left:30%">
    <?php  if(in_array(31,$otherPermission)){
      $fromDate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-1 month" ) );
     $toDate = date('Y-m-d');}
      ?>
   <link rel="stylesheet" href="bootstrap/css/jquery-ui.css">
    <label for="from">From</label>
    <input type="text" id="fromDate" size="10"   name="fromDate" autocomplete="off" value="<?php echo $fromDate; ?>"   />
    <i class="fa fa-calendar" id="from" aria-hidden="true" style="cursor:pointer;"></i>
    <label for="to">To</label>
    <input type="text" id="toDate" size="10"   name="toDate" autocomplete="off" value="<?php echo $toDate; ?>"   />
    <i class="fa fa-calendar" aria-hidden="true" id="to" style="cursor:pointer;"></i>
      <button type="button" onclick="getTranscodedVideoInfo('search_month');" title="Search" class="btn btn-default"><i class="fa fa-search"></i> </button>
  </div>
    <div class="row table-responsive" style="border: 0px solid red; margin-top:5px;">
    <table border='0' style="width:98%; margin-left: 10px; font-size: 12px;">
    <tr>
    <td width="17%"><select id="pagelmt"  style="width:60px;" onchange="selpagelimit('<?php echo $pager_pageIndex;  ?>','<?php echo $filtervalue; ?>','<?php echo $searchTextMatch;?>');" >
        <option value="10"  <?php echo $pagelimit==10? "selected":""; ?> >10</option>
        <option value="20"  <?php echo $pagelimit==20? "selected":""; ?> >20</option>
        <option value="50"  <?php echo $pagelimit==50? "selected":""; ?> >50</option>
        <option value="100" <?php echo $pagelimit==100? "selected":""; ?> >100</option>
        <option value="200" <?php echo $pagelimit==200? "selected":""; ?> >200</option>
        <option value="500" <?php echo $pagelimit==500? "selected":""; ?> >500</option>
        </select> Records Per Page</td>
  <td width="12%" align="center">
        View:<select name="filterentry"  id="filterentry" onchange="filterView('<?php echo $pager_pageIndex;  ?>','<?php echo $pagelimit; ?>','<?php echo $searchTextMatch;?>');" style="text-transform: uppercase !important;">
        <option value="0" <?php  echo $filtervalue=='0'?"selected":''; ?>>ALL</option>
        <option value="2" <?php echo $total_active_disabled; echo $filtervalue=='2'?"selected":''; ?>>Ready</option>
        <option value="11" <?php echo $total_inactive_disabled; echo $filtervalue=='11'?"selected":''; ?>>Pending</option>
     </select>
  </td>
  <td width="40%" align="center">
      <span class="label label-primary">ALL <span class="badge" style="color: #337ab7; background-color: #fff;padding: 0px 4px 1px 4px;"><?php echo $totalEntry; ?></span></span>
      <span class="label label-success">READY <span class="badge"  style="color: #00a65a; background-color: #fff;padding: 0px 4px 1px 4px;"><?php echo $totalActive; ?></span></span>
      <span class="label label-default">PENDING <span class="badge"  style="color: #444; background-color: #fff;padding: 0px 4px 1px 4px;"><?php echo $totalInactive; ?></span></span>
      <span class="label label-warning">CONVERTING <span class="badge"  style="color: #444; background-color: #fff;padding: 0px 4px 1px 4px;"><?php echo $total_convert; ?></span></span>
      <span class="label label-danger">REJECTED <span class="badge"  style="color: #444; background-color: #fff;padding: 0px 4px 1px 4px;"> <?php echo $treject; ?></span></span>

  </td>
    <td width="35%">
     <!--<form class="navbar-form" role="search" method="post" style=" padding: 0 !important;">-->
       <div class="col-sm-3 col-md-3 pull-right navbar-form" role="search">
       <div class="input-group add-on" style="float: right;">
       <input class="form-control" size="30" onkeyup="SeachDataTable('ugc_paging.php','<?php echo $pagelimit;?>','<?php echo $pager_pageIndex ;?>','load','<?php echo $filtervalue; ?>')"  placeholder="Search Entries by tagName,searchtag"  autocomplete="off" name='searchQuery' id='searchInput' class="searchInput" type="text" value="<?php echo $searchTextMatch; ?>">
       <div class="input-group-btn">
       <button class="enableOnInput btn btn-default" onclick="SearchDataTableValue('ugc_paging.php','<?php echo $pagelimit;?>','<?php echo $pager_pageIndex ?>','load','<?php echo $filtervalue; ?>')" disabled='disabled' id='submitBtn' type="button" style="height: 30px;   padding: 4px 6px !important;" ><i class="glyphicon glyphicon-search"></i></button>
       </div>
       </div>
       </div>
       <!--</form>-->
   </td>
    <td width="5%">
     <div class="col-xs-1 hidden-xs hidden-sm pull-right" style="border:none;  margin-top:1px !important;">
      <a href="javascript:" onclick="return refreshcontent('refresh','<?php echo $pager_pageIndex;  ?>','<?php echo $pagelimit; ?>','<?php echo $searchTextMatch;?>','<?php echo $filtervalue;?>');" title="refresh" style="float: right"><i class="fa fa-refresh" aria-hidden="true"></i></a>
    </div>
     </td>
    </tr>
</table>
</div>
<div>
      <div class="pull-left" id="flash" style="text-align: center;"></div>
      <div id="load" style="display:none;"></div>
      <div class="pull-left" id="msg" style="text-align: center;"></div>
</div>
</div>
<form action="#" id="form" name="myform" style="border: 0px solid red; ">
    <div class="table-responsive">
    <table  class="table table-bordered table-striped"  style="table-layout:fixed; width:100%;">
    <thead style="display: block; overflow-y: scroll; ">
      <tr>
        <th  style="width:1%"><input type="checkbox" id="ckbCheckAll"></th>
        <th  style="width:8%">ID</th>
        <th  style="width:10%">UserName</th>
        <th  style="width:20%">Name</th>
        <!--<th  style="width:25%">Categories</th>-->
        <th  style="width:10%">Created-On</th>
        <th  style="width:7%" title="Upload Status">U-Status<input  type="hidden" id="settbodyHeight" size="3"></th>
        <th  style="width:6%" >Action
            <span style="background: #fff;position: absolute; height: 34px;margin-top:-5px; width:20px;  right: 0;  " >
            </span>
        </th>
       </tr>
    </thead>
<tbody style="overflow-y: scroll;display: block;" id="tbodyHeight">
<?php
$count=1;
foreach($fetchMedia as $entry_media) {
    $id=$entry_media['id']; $entryid=$entry_media['entryid'];
    $name=$entry_media['title']; $status=$entry_media['status'];
    $upload_status=$entry_media['upload_status']; $createdAt=$entry_media['added_date'];
    $userid = $entry_media['userid']; $categories=$entry_media['category'];
    $useridName=$entry_media['user_id']; $kstatus=$entry_media['kstatus'];
    if($status=='11') { $statusc="Pending";  $redyColor='label-default';  $disableLink='';}
    if($status=='4') { $statusc="Rejected";  $redyColor='label-danger';  $disableLink='';}

    if($kstatus=='-1') { $statusc="error_converting";  $redyColor='label-warning';  $disableLink='';}
    if($kstatus=='-2') { $statusc="error_importing";  $redyColor='label-warning';  $disableLink='';}
    if($kstatus=='0') { $statusc="import";  $redyColor='label-warning';  $disableLink='';}
    if($kstatus=='1') { $statusc="converting";  $redyColor='label-warning';  $disableLink='';}
    if($kstatus=='2') { $statusc="Ready"; $redyColor='label-success';  $disableLink='';}

?>
<tr id="<?php echo $count."_r"; ?>" style="font-size: 12px; background:<?php echo $actColor; ?>">
<td  style="width:1%" >
<input type="checkbox" class="checkBoxClass" name="Entrycheck[]" value="<?php echo $id; ?>">
</td>

<td  style="width:8%">
    <a style="cursor: pointer;"   >
 <?php echo $entryid;?></a>
</td>
<td  style="width:10%"  title="<?php echo $useridName;  ?>">
<?php  echo wordwrap($useridName,20, "\n", true)."($userid)";?>
</td>
<td  style="width:20%"  title="<?php echo $name;  ?>">
<?php  echo wordwrap($name,20, "\n", true);?>
</td>
<!--<td  style="width:25%; font-size: 11px; word-break: break-all"  title="<?php echo wordwrap($categories,41, "\n", true);?>">
<?php  echo wordwrap($categories,41, "\n", true); ?>
</td>-->
<td  style="width:10%"><?php echo date("d/m/y H:i:s", strtotime($createdAt)); ?></td>
<td  style="width:7%">
<span class="label <?php echo $redyColor; ?> label-white middle"><?php echo  $statusc; ?></span>
</td>
<td  style="width:6%">
<a style="cursor: pointer;" class="<?php echo $disableLink; ?>" onclick="viewVodDetail('<?php echo $pager_pageIndex; ?>','<?php echo $id; ?>','<?php echo $ptag;?>','<?php echo $pagelimit;?>','<?php echo $searchTextMatch; ?>');" >
<i class="fa fa-eye" aria-hidden="true"  data-placement="left"  title="View and transcode" style="padding-right: 8px  !important;"></i>
</a>
<?php  //if(in_array(4, $UserRight)){ ?>
<!--<a href="javascript:void(0)" onclick="return deleteContent('<?php echo $id; ?>','deletecontent','<?php echo $pager_pageIndex; ?>','<?php echo $pagelimit;?>')"><i class="fa fa-trash-o" aria-hidden="true" title="Delete"></i></a>-->
<?php //}?>
</td>
</tr>
<?php
     $count++;
}
?>
</tbody>
</table>
</div>
</form>
<?php
/* paging code............*/

///$pager_pageIndex."---".$total_pages;
if($pager_pageIndex==0){ $pager_pageIndex=1; }
$prev = $pager_pageIndex - 1;	//previous page is page - 1
$next = $pager_pageIndex + 1;
$limit=$pagelimit;	//next page is page + 1
$lastpage = ceil($total_pages/$limit);
$adjacents = 3;
$lpm1 = $lastpage - 1;
$pagination = "";
if($lastpage > 1)
	{
	    $pagination .= "<div class=\"pagination\">";
		//previous button
		if($pager_pageIndex >1)
		 $pagination.= '<a href="javascript:void(0)"  onclick="changePagination(\''.$prev.'\',\''.$limit.'\',\''.$searchTextMatch.'\',\''.$filtervalue.'\')"><i class="fa fa-long-arrow-left" aria-hidden="true"></i>
Previous</a>';
		else
			$pagination.= "<span class=\"disabled \"> <i class='fa fa-long-arrow-left' aria-hidden='true'></i> Previous</span>";
		//pages
		if ($lastpage < 2 + ($adjacents * 2))	//not enough pages to bother breaking it up
		{

			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
		          ?>
			<?php 	if ($counter == $pager_pageIndex)
					$pagination.= "<span class=\"current\">$counter</span>";
				else

				    $pagination.= '<a href="javascript:void(0)" onclick="changePagination(\''.$counter.'\',\''.$limit.'\',\''.$searchTextMatch.'\',\''.$filtervalue.'\')">'.$counter.'</a>';

                                }
		}
		elseif($lastpage > 2 + ($adjacents * 2))	//enough pages to hide some
		{

			//close to beginning; only hide later pages
			if($pager_pageIndex < 1 + ($adjacents * 2))
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					if ($counter == $pager_pageIndex)
						$pagination.= "<span class=\"current\">$counter</span>";
					else

					    $pagination.= '<a href="javascript:void(0)" onclick="changePagination(\''.$counter.'\',\''.$limit.'\',\''.$searchTextMatch.'\',\''.$filtervalue.'\')">'.$counter.'</a>';
				}
				$pagination.= "...";
				$pagination.= '<a href="javascript:void(0)" onclick="changePagination(\''.$lpm1.'\',\''.$limit.'\',\''.$searchTextMatch.'\',\''.$filtervalue.'\')">'.$lpm1.'</a>';
				$pagination.= '<a href="javascript:void(0)" onclick="changePagination(\''.$lastpage.'\',\''.$limit.'\',\''.$searchTextMatch.'\',\''.$filtervalue.'\')">'.$lastpage.'</a>';
			}
			//in middle; hide some front and some back
			elseif($lastpage - ($adjacents * 2) > $pager_pageIndex && $pager_pageIndex > ($adjacents * 2))
			{


				$pagination.= '<a href="javascript:void(0)" onclick="changePagination(\'1\',\''.$limit.'\',\''.$searchTextMatch.'\',\''.$filtervalue.'\')">1</a>';
				$pagination.= '<a href="javascript:void(0)" onclick="changePagination(\'2\',\''.$limit.'\',\''.$searchTextMatch.'\',\''.$filtervalue.'\')">2</a>';
				$pagination.= "...";
				for ($counter = $pager_pageIndex - $adjacents; $counter <= $pager_pageIndex + $adjacents; $counter++)
				{
					if ($counter == $pager_pageIndex)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
					$pagination.= '<a href="javascript:void(0)" onclick="changePagination(\''.$counter.'\',\''.$limit.'\',\''.$searchTextMatch.'\',\''.$filtervalue.'\')">'.$counter.'</a>';
				}
				$pagination.= "...";
				$pagination.= '<a href="javascript:void(0)" onclick="changePagination(\''.$lpm1.'\',\''.$limit.'\',\''.$searchTextMatch.'\',\''.$filtervalue.'\')">'.$lpm1.'</a>';
				$pagination.= '<a href="javascript:void(0)" onclick="changePagination(\''.$lastpage.'\',\''.$limit.'\',\''.$searchTextMatch.'\',\''.$filtervalue.'\')">'.$lastpage.'</a>';
			}
			//close to end; only hide early pages
			else
			{

				$pagination.= '<a href="javascript:void(0)" onclick="changePagination(\'1\',\''.$limit.'\',\''.$searchTextMatch.'\',\''.$filtervalue.'\')">1</a>';
				$pagination.= '<a href="javascript:void(0)" onclick="changePagination(\'2\',\''.$limit.'\',\''.$searchTextMatch.'\',\''.$filtervalue.'\')">2</a>';
				$pagination.= "...";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $pager_pageIndex)
						$pagination.= "<span class=\"current\">$counter</span>";
					else

						$pagination.= '<a href="javascript:void(0)" onclick="changePagination(\''.$counter.'\',\''.$limit.'\',\''.$searchTextMatch.'\')">'.$counter.'</a>';
				}
			}
		}

		//next button
		if ($pager_pageIndex < $counter - 1)
		    $pagination.= '<a href="javascript:void(0)" onclick="changePagination(\''.$next.'\',\''.$limit.'\',\''.$searchTextMatch.'\',\''.$filtervalue.'\')">Next  <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>';
		else
			$pagination.= "<span class=\"disabled\"> Next <i class='fa fa-long-arrow-right' aria-hidden='true'></i></span>";
		$pagination.= "</div>\n";
	}
?>

<div class="row row-list" style="border: 0px solid red; padding: 0px 5px 0px 5px;">
<!--<div class="col-xs-1" style="padding-top: 10px; font-size: 11px;    padding-right: 0 !important;">
        <div class="dropdown dropup">
        <a data-target="#"  data-toggle="dropdown" class="dropdown-toggle">Bulk Actions<b class="caret"></b></a>
         <ul class="dropdown-menu">
            <?php if(in_array(2,$UserRight)){ ?>
           <?php  if(in_array(5,$otherPermission)){ ?>
           <li><a href="javascript:void(0)" onclick="planbulk('<?php echo $pager_pageIndex;  ?>','<?php echo $pagelimit; ?>')">Add Plan</a>
           </li> <?php } ?>
           <li><a href="javascript:void(0)" onclick="add_to_bulk_category('<?php echo $pager_pageIndex;  ?>','<?php echo $pagelimit; ?>')">Add to Category</a></li>
           <li><a href="javascript:void(0)" class="bulkactive" onclick="bulkactive('<?php echo $pager_pageIndex;  ?>','<?php echo $pagelimit; ?>','BULK_ACTIVE');">bulk active</a></li>
           <li><a href="javascript:void(0)" class="bulkinactive" onclick="bulkactive('<?php echo $pager_pageIndex;  ?>','<?php echo $pagelimit; ?>','BULK_INACTIVE');" >bulk inactive</a></li>
            <?php } if(in_array(4,$UserRight)){  ?>
           <li><a href="javascript:void(0)"   onclick="delete_bulk('<?php echo $pager_pageIndex;  ?>','<?php echo $pagelimit; ?>');" id="delete_bulk">Delete</a></li>
            <?php } ?>
           <?php if(in_array(7, $otherPermission)){  ?>
           <li><a href="javascript:void(0)"   onclick="bulkAddContentPartner('<?php echo $pager_pageIndex;  ?>','<?php echo $pagelimit; ?>');" id="bulk_content_partner">Add Content Partner</a></li>
            <?php } ?>
           <?php  if(in_array(32, $otherPermission)){  ?>
           <li><a href="javascript:void(0)"   onclick="bulkAddContentViewer('<?php echo $pager_pageIndex;  ?>','<?php echo $pagelimit; ?>');" id="bulk_content_viewer">Add Content Viewer(Rating)</a></li>
            <?php } ?>
           <?php  if(in_array(33, $otherPermission)){  ?>
           <li><a href="javascript:void(0)"   onclick="bulkAgeRestriction('<?php echo $pager->pageIndex;  ?>','<?php echo $pager->pageSize; ?>');" id="bulk_age_restriction">Age Restriction</a></li>
            <?php } ?>
         </ul>
       </div>
</div>-->

<div class="col-xs-8 pull-right"  style="border: 0px solid red; padding: 0px 0px 0px 0px; font-size: 11px;">
    <div class="pull-left">
     <?php
      if($pager_pageIndex ==1 || $pager_pageIndex ==0) {
       if($total_pages==0){  $startShow=0;  } else {  $startShow=1;}
       $lmt=$limit<$total_pages ? $limit :$total_pages;
       }
       else{
       $startShow=(($pager_pageIndex - 1) * $limit)+1;
       $lmt=($pager_pageIndex*$limit) >$total_pages ? $total_pages: $pager_pageIndex * $limit;
       }
     ?>
    </div>

    <div class="pull-right" style="padding: 5px;">
        <span style="padding-top: 5px;float:left;margin-right: 20px;"> Showing <?php echo $startShow; ?> to <?php echo $lmt; ?>   of <strong><?php echo $total_pages; ?> </strong>entries </span>
       <?php echo $pagination;?>
    </div>

</div>
</div>
<script src="bootstrap/js/jquery-ui.js" type="text/javascript"></script>
<script type="text/javascript">
$(function() {
$("#fromDate" ).datepicker({ dateFormat: 'yy-mm-dd'});
   $('#from').click(function() {
       $("#fromDate").focus();
     });
    $("#toDate" ).datepicker({ dateFormat: 'yy-mm-dd'});
      $('#to').click(function() {
    $("#toDate").focus();
     });
});
</script>
<script type='text/javascript'>
   var act='search_month';
   getTranscodedVideoInfo(act);
   function getTranscodedVideoInfo(acti)
   {
      var fromDate = $('#fromDate').val();
      var toDate = $('#toDate').val();
        $.ajax({
          type:'POST',
          url:'ugc_paging.php',
          dataType: "json",
          data:{show:acti,fromDate:fromDate,toDate:toDate},
          success:function(r){
        console.log(r);
          }
      });
   }

</script>
<script type="text/javascript">
function viewVodDetail(EntryPageindex,Entryid,ptag,limitval,searchtext)
{
    $("#flash").fadeIn(100).html('Wait <img src="img/image_process.gif" />');
    $("#show_detail_model_view").html();
    $('#myModalugcEdit').modal();
    var info = 'id='+Entryid+"&pageindex="+EntryPageindex+"&ptag="+ptag+'&limitval='+ limitval+"&searchInputall="+searchtext;
        $.ajax({
            type: "POST",
            url: "ugcModal.php",
            data: info,
          success: function(result){
          $("#flash").hide();
          $('#show_detail_model_view').html(result);
           }
         });
     return false;
}
function changePagination(pageid,limitval,searchtext,filterview){
     var dataString ='first_load='+ pageid+'&limitval='+limitval+'&searchInputall='+searchtext+"&filtervalue="+filterview;
     $('#load').show();
     $('#results').css("opacity",0.1);
     $.ajax({
           type: "POST",
           url: "ugc_paging.php",
           data: dataString,
           cache: false,
           success: function(result){
                $("#results").html(result);
                $('#load').hide();
		$('#results').css("opacity",1);
           }
      });
}

$(document).ready(function(){
$("#ckbCheckAll").click(function () {
    $(".checkBoxClass").prop('checked', $(this).prop('checked'));
});
});


function selpagelimit(pageindex,filtervalue,searchtext){
var limitval = document.getElementById("pagelmt").value;
     $('#load').show();
     $('#results').css("opacity",0.1);
     var apiBody = new FormData();
     apiBody.append("filtervalue",filtervalue);
     //apiBody.append("pageindex",pageindex);
     apiBody.append("limitval",limitval);
     apiBody.append("searchInputall",searchtext);
     apiBody.append("maction","filterview");
      $.ajax({
           type: "POST",
           url: "ugc_paging.php",
           data: apiBody,
           processData: false,
           contentType: false,
           cache: false,
           success: function(result){
           $("#results").html(result);
           $('#load').hide();
           $('#results').css("opacity",1);}
     });

}



function filterView(pageindex,limitval,searchtext)
{
    var filtervalue = $('#filterentry').val();
    $('#load').show();
    $('#results').css("opacity",0.1);
     var apiBody = new FormData();
     apiBody.append("filtervalue",filtervalue);
     //apiBody.append("pageindex",pageindex);
     apiBody.append("limitval",limitval);
     apiBody.append("searchInputall",searchtext);
     apiBody.append("maction","filterview");
      $.ajax({
           type: "POST",
           url: "ugc_paging.php",
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

$('#searchInput').bind('paste', function (e) {
     $('.enableOnInput').prop('disabled', false);
});

function SeachDataTable(pageURL,limitval,pageNum,loaderID,filterview)
{
      var searchInputall = $('#searchInput').val();
      //console.log(pageURL+"---"+limitval+"--"+pageNum+"--"+loaderID+"--"+filterview);
      if(searchInputall=='')
      {
        $("#submitBtn").show();
	$('.enableOnInput').prop('disabled', true);
        //$("#"+loaderID).show();
        //$("#"+loaderID).fadeIn(400).html('Wait <img src="img/image_process.gif" />');
        $('#'+loaderID).show();
        $('#results').css("opacity",0.1);
        var dataString ='searchInputall='+searchInputall+"&limitval="+limitval+"&pageNum="+pageNum+"&filtervalue="+filterview;
         $.ajax({
                    type: "POST",
                    url:pageURL,
                    data: dataString,
                    cache: false,
                        success: function(result){
                         $("#searchword").css("display", "none");
                         $("#"+loaderID).hide();
                         $("#results").html(result);
                         $('#results').css("opacity",1);
                       }
                 });
      }
      else {
            //If there is text in the input, then enable the button
            var get_string = searchInputall.length;
            if(get_string>=1){  $("#submitBtn").show();    }
            $('.enableOnInput').prop('disabled', false);
      }
}

function SearchDataTableValue(pageURL,limitval,pageNum,loaderID,filterview)
{
    //console.log(pageURL+"---"+limitval+"--"+pageNum+"--"+loaderID);
    var searchInputall = $('#searchInput').val();
    searchInputall = searchInputall.trim();
    var strlen=searchInputall.length;
    console.log(searchInputall);
    if(strlen==0){  $('#searchInput').val(''); $('#searchInput').focus(); return false;   }
    $('#'+loaderID).show();
    $('#results').css("opacity",0.1);
    var apiBody = new FormData();
     apiBody.append("searchInputall",searchInputall);
     apiBody.append("limitval",limitval);
     apiBody.append("filtervalue",filterview);
     $.ajax({
     url:pageURL,
     method: 'POST',
     data:apiBody,
     processData: false,
     contentType: false,
     success: function(result){
                $("#"+loaderID).hide();
                $("#results").html(result);
                $("#searchword").css("display", "");
                $('#searchword').html(searchInputall);
                $('#results').css("opacity",1);
            }
      });


}
function refreshcontent(ref,pageindex,limitval,searchtext,filterview){
     $('#load').show();
     $('#results').css("opacity",0.1);
     var apiBody = new FormData();
     apiBody.append("first_load",pageindex);
     apiBody.append("limitval",limitval);
     apiBody.append("searchInputall",searchtext);
     apiBody.append("filtervalue",filterview);
     apiBody.append("maction",ref);
      $.ajax({
           type: "POST",
           url: "ugc_paging.php",
           data: apiBody,
           processData: false,
           contentType: false,
           cache: false,
           success: function(result){

          	 $("#results").html(result);
                 $("#load").hide();
                 $('#results').css("opacity",1);
          }
     });
}
/* ----  for resize with tableBody height code begin -----*/
setTbodyHeight();
function setTbodyHeight()
{
   var wHeight=height_new();
   var HeaderHeight=20;
   var footerHeight=97;
   var AddHF=HeaderHeight+footerHeight;
   var newHeight=wHeight-AddHF;
   var tbodyHeight=newHeight-145;
   document.getElementById("settbodyHeight").value=tbodyHeight;
   document.getElementById("tbodyHeight").style.height=tbodyHeight+"px";

}

function height_new(el)
{
        if(el)
        return el.offsetHeight||el.clientHeight||0;
        else
        return window.innerHeight||document.documentElement.clientHeight||document.body.clientHeight||0;
}

if(window.attachEvent)
    {
         window.attachEvent('onresize', function(){
             //console.log("onresize:tbody");
             setTbodyHeight();});
    }

    else if(window.addEventListener)
    {
        window.addEventListener('resize', function(){
            //console.log("resize:tbody");
            setTbodyHeight();}, true);
    }

    else
    {
        console.log("The browser does not support Javascript event binding");
    }


$("#searchInput").keyup(function(event) {
    if (event.keyCode === 13) {
        $("#submitBtn").click();
    }
});
/* ----  for resize with tableBody height code end -----*/
</script>
