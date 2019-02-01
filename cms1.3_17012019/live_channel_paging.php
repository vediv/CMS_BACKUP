<?php
//sleep(1);
include_once 'corefunction.php';
include_once("config.php");
$pager = new KalturaFilterPager();
$filter = null;
$filter = new KalturaLiveStreamEntryFilter(); 
$pager->pageIndex=1; $pager->pageSize = 1;
$total_media = $client->liveStream->listAction($filter, $pager);
$total_media_kaltura_onlytotal=$total_media->totalCount;
//print '<pre>'.print_r($total_media_kaltura_onlytotal, true).'</pre>';
include_once 'function.php';
$filtervalue=(isset($_POST['filtervalue']))? $_POST['filtervalue']:0;
switch($filtervalue)
{
       case -2:
       $vsatus=" where status='2' and type='7'   ";
       $filterValueCase=" ";     
       break;
       case 2:
       $vsatus=" where status='2' and type='7' ";
        $filterValueCase=" ";    
       break;    
       case 0;
       $vsatus=" where status='2' and type='7' ";
       $filterValueCase='';
       break;
}
$searchTextMatch = (isset($_POST['searchInputall']))? $_POST['searchInputall']: "";
$pagelimit = (isset($_POST['limitval']))? $_POST['limitval']: 5;
$pager_pageIndex =(isset($_POST['first_load']))? $_POST['first_load']:0;   
$get_refresh = (isset($_POST['refresh']))? $_POST['refresh']: "";
$entry_query="select count(entryid) as total_entry from entry  $vsatus";
$etable=  db_select($conn,$entry_query);
$totalCountEntryTable=$etable[0]['total_entry'];
if($pager_pageIndex) 
            $start = ($pager_pageIndex - 1) * $pagelimit; 			//first item to display on this page
    else
            $start = 0;
$entry_query="select entryid from entry  $vsatus    LIMIT $start,$pagelimit";
$etable_get=  db_select($conn,$entry_query);
$arr = array_map(function($el){ return $el['entryid']; }, $etable_get);
$ids = implode(',',$arr);  

if($filtervalue<0){  $pager_pageIndex_new=$start==0?1:1;  }
if($filtervalue>0){  $pager_pageIndex_new=$start==0?1:1;  }
if($filtervalue==0){ $pager_pageIndex_new=$start==0?1:$pager_pageIndex;}
$filter = null;
$filter = new KalturaLiveStreamEntryFilter();
$filter->searchTextMatchOr = $searchTextMatch;
$filter->searchTextMatchAnd = $searchTextMatch;
$filter->orderBy = "-createdAt";
$filter->statusIn = '0,1,2';
//$filter->typeEqual = KalturaEntryType::MEDIA_CLIP;
$pager = new KalturaFilterPager();
$action = (isset($_POST['maction']))? $_POST['maction']: "";
switch($action)
{
    /***** following code doing delete start ***/
      case "deletecontent":
      $pageindex_when_delete	 = (isset($_POST['pageindex']))? $_POST['pageindex']: "";
      
     break;  
 /***** following code doing multi delete start ***/
    case "multidelete":
        $pageindex_when_delete	 = (isset($_POST['pageindex']))? $_POST['pageindex']: "";
        $pager->pageIndex=$pageindex_when_delete;
        
    break; 
 /***** following code doing update metadata start ***/
    case "saveandclose_live_metadata": 
    $pager->pageIndex=$pageindex_when_update; 
    break; 
    /***** following code doing  save and close thubnail start***/
    case "saveandclose_thumnnail":
    $thubmentryID	 = (isset($_POST['entryid']))? $_POST['entryid']: "";
    $pageindex_when_thubm = (isset($_POST['pageindex']))? $_POST['pageindex']: "";
    $pager->pageIndex=$pageindex_when_thubm;
     /*----------------------------update log file begin-------------------------------------------*/    
    $error_level=1;$msg="Save Thumbnail($thubmentryID)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
    $qry='';
    write_log($error_level,$msg,$lusername,$qry);
    /*----------------------------update log file End---------------------------------------------*/ 
    
    break;
    case "save_access_metadata":
     $entryID = (isset($_POST['entryid']))? $_POST['entryid']: "";
     $country_name_code = (isset($_POST['country_name_code']))? $_POST['country_name_code']: ""; 
     $countryaccess = (isset($_POST['countryaccess']))? $_POST['countryaccess']: "";
     if($countryaccess!='0' && $countryaccess!='1'){
      $country_data=$country_name_code;
     }
     else {
        $country_data=$countryaccess;
     }
     $queryupdate="update entry set country_data='$country_data' where entryid='$entryID' "; 
     $upd =db_query($conn,$queryupdate);
     if($upd){
    /*----------------------------update log file begin-------------------------------------------*/    
     $error_level=1;$msg="Save Access Control($entryID)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
     $qry='';
     write_log($error_level,$msg,$lusername,$qry);
    /*----------------------------update log file End---------------------------------------------*/ 
    }
   else 
   {
     /*----------------------------update log file begin-------------------------------------------*/
     $error_level=5;$msg="Save Access Control($entryID)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
     $qry=$queryupdate;
     write_log($error_level,$msg,$lusername,$qry);
     /*----------------------------update log file End---------------------------------------------*/ 
 } 
     break;   
    case "only_page_limitval":
    $pageindex = (isset($_POST['pageindex']))? $_POST['pageindex']: "";  
    $pager->pageIndex=$pageindex;        
    break;
    case "refresh": case "liveModalClose":
    //$pageindex = (isset($_POST['pageindex']))? $_POST['pageindex']: "";  
    //$pager_pageIndex=$pageindex;        
    break; 
   
}
$filter->idIn=$filtervalue==0?null:$ids;
$pager->pageIndex=$pager_pageIndex_new;
$pager->pageSize = $pagelimit;
//for switch
$filterQuery='';
$result_media = $client->liveStream->listAction($filter, $pager);
$total_media_kaltura=$result_media->totalCount;
//print '<pre>'.print_r($result_media, true).'</pre>'; 
if($filtervalue<0){ $total_pages_from_kaltura=$total_media_kaltura_onlytotal;  }
if($filtervalue>0){ $total_pages_from_kaltura=$total_media_kaltura_onlytotal;  }
if($filtervalue==0){ $total_pages_from_kaltura=$total_media_kaltura_onlytotal;  }

//echo "total_pages_from_kaltura=".$total_pages_from_kaltura; echo "<br/>";
if($searchTextMatch!=''){  $total_pages=$total_media_kaltura; }
if($searchTextMatch==''){ $total_pages=$totalCountEntryTable; }
$act_inact="SELECT  SUM(IF (video_status='active',1,0)) AS total_active,SUM(IF (video_status='inactive',1,0)) AS total_inactive FROM entry where status='2' and type='7' ";
$tableAD=  db_select($conn,$act_inact);
$total_active=$tableAD[0]['total_active']; $total_inactive=$tableAD[0]['total_inactive'];
$totalEntry=$total_active+$total_inactive;
$total_active_disabled=$total_active==0?'disabled':'';
$total_inactive_disabled=$total_inactive==0?'disabled':'';
?>
<div class="box-header" >
    <div class="row table-responsive" style="border: 0px solid red; margin-top:-15px;">
    <table border='0' style="width:98%; margin-left: 10px; font-size: 12px;">
    <tr>
    <td width="17%"><select id="pagelmt"  style="width:60px;" onchange="selpagelimit('<?php echo $pager->pageIndex;  ?>','<?php echo $filtervalue; ?>','<?php echo $searchTextMatch;?>');" >
        <option value="5"  <?php echo $pagelimit==5? "selected":""; ?> >5</option>
        <option value="10"  <?php echo $pagelimit==10? "selected":""; ?> >10</option>
        <option value="50"  <?php echo $pagelimit==50? "selected":""; ?> >50</option>
        <option value="100" <?php echo $pagelimit==100? "selected":""; ?> >100</option>
        <option value="200" <?php echo $pagelimit==200? "selected":""; ?> >200</option>
        <option value="500" <?php echo $pagelimit==500? "selected":""; ?> >500</option>
        </select> Records Per Page</td>
  <!--<td width="22%" align="center">
        View:<select name="filterentry" id="filterentry" onchange="filterView('<?php echo $pager->pageIndex;  ?>','<?php echo $pagelimit; ?>','<?php echo $searchTextMatch;?>');" style="text-transform: uppercase !important;">
        <option value="0" <?php  echo $filtervalue=='0'?"selected":''; ?>>ALL</option>
        <option value="2" <?php echo $total_active_disabled; echo $filtervalue=='2'?"selected":''; ?>>ACTIVE</option>
        <option value="-2" <?php echo $total_inactive_disabled; echo $filtervalue=='-2'?"selected":''; ?>>INACTIVE</option>
     </select>
  </td>
  <td width="32%" align="center">
      <span class="label label-primary">ALL <span class="badge" style="color: #337ab7; background-color: #fff;padding: 0px 4px 1px 4px;"><?php echo $totalEntry; ?></span></span>
      <span class="label label-success">ACTIVE <span class="badge"  style="color: #00a65a; background-color: #fff;padding: 0px 4px 1px 4px;"><?php echo $total_active; ?></span></span>
      <span class="label label-default">INACTIVE <span class="badge"  style="color: #444; background-color: #fff;padding: 0px 4px 1px 4px;"><?php echo $total_inactive; ?></span></span>
   </td>-->
    <td width="65%">
     <!--<form class="navbar-form" role="search" method="post" style=" padding: 0 !important;">-->
    <div class="col-sm-3 col-md-3 pull-right navbar-form" role="search">  
        <div class="input-group add-on" style="float: right;">
        <input class="form-control" size="30" onkeyup="SeachDataTable('live_channel_paging.php','<?php echo $pagelimit;?>','<?php echo $pager->pageIndex ;?>','load','<?php echo $filtervalue; ?>')"  placeholder="Search By Name or ID"  autocomplete="off" name='searchQuery' id='searchInput' class="searchInput" type="text" value="<?php echo $searchTextMatch; ?>">
        <div class="input-group-btn">
        <button class="enableOnInput btn btn-default" onclick="SearchDataTableValue('live_channel_paging.php','<?php echo $pagelimit;?>','<?php echo $pager->pageIndex ?>','load','<?php echo $filtervalue; ?>')" disabled='disabled' id='submitBtn' type="button" style="height: 30px;   padding: 4px 6px !important;" ><i class="glyphicon glyphicon-search"></i></button>	
        </div>
        </div>
    </div>
     
    
    
       <!--</form>-->
    </td>
    <td width="5%">
     <div class="col-xs-1 hidden-xs hidden-sm pull-right" style="border:none;  margin-top:10px !important;">   
      <a href="javascript:" onclick="return refreshcontent('refresh','<?php echo $pager->pageIndex;  ?>','<?php echo $pagelimit; ?>','<?php echo $searchTextMatch;?>','<?php echo $filtervalue;?>');" title="refresh" style="float: right"><i class="fa fa-refresh" aria-hidden="true"></i></a>   
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
    <table  class="table table-bordered table-striped" border='1'  style="table-layout:fixed; width:100%;"> 
    <thead >
       <tr>
        
        <th  style="width:10%">Thumbnail</th> 
        <th  style="width:10%">ID</th>
        <th  style="width:20%">Name</th>
        <th  style="width:22%">Categories</th>
        <th  style="width:10%">Created-On</th>
        <th  style="width:7%" title="Upload Status">U-Status</th>
         <th  style="width:6%" title="Live Status">L-Status</th>
        <th  style="width:6%" >Action 
            <span style="background: #fff;position: absolute; height: 34px;margin-top:-5px; width:20px;  right: 0;  " >
            </span>
        </th>
       </tr>   
    </thead>
<tbody >
<?php
if($totalCountEntryTable!=0){
$count=1;
$totalCount=count($result_media->objects); 
foreach($result_media->objects as $entry_media) {
$id=$entry_media->id ;	
$status=$entry_media->status;  
$mediaType=$entry_media->mediaType;
//$mdeitype_icon= $mediaType==1 ? "<i class='fa fa-film' aria-hidden='true'></i>" : "";
$mdeitype= $mediaType==7 ? "Live" : "";
if($status=='-1') { $statusc="error_converting"; }
if($status=='-2') { $statusc="error_importing"; }
if($status==2) { $statusc="Ready"; }
if($status==0) { $statusc="import"; }
if($status==1) { $statusc="converting"; }
if($status==2) { $statusc="Ready"; }
if($status==4) { $statusc="Pending"; }
$name=$entry_media->name ; $tumnail_height_width="/width/100/height/60"; $thumbnailUrl=$entry_media->thumbnailUrl ;
$plays=$entry_media->plays;$categories=$entry_media->categories ; $duration=$entry_media->duration;$createdAt=$entry_media->createdAt;
$entryTable="select planid,ispremium,isfeatured,status,video_status,entryid from entry where entryid='$id'"; 
$db_totalRow=db_totalRow($conn,$entryTable);
    
     $fetchEntry=db_select($conn,$entryTable);  
     $entryid = $fetchEntry[0]['entryid'];
     $planid = $fetchEntry[0]['planid']; $statusDB=$fetchEntry[0]['status'];  $video_status=$fetchEntry[0]['video_status'];
     if($statusDB==1 && $status==2)
     { $up="update entry set status='2',duration='$duration' where status='1' and entryid='$entryid'"; db_query($conn,$up); }
     $isPremium=$fetchEntry[0]['ispremium'];
        $planname="NA"; $plan_title="Plan Not Added"; 
        $ptag=''; 
            if($isPremium!='')
            {    
                 $ptag=$isPremium=='1' ? "p": "f";
                 $planname= ucwords($ptag); 
                 $plan_title=$ptag=='p'?"Premium":"Free";
                 if($ptag=='p'){$plan_title="Premium";}
                 if($ptag=='f'){$plan_title="Free";}
             }
            $isfeatured = $fetchEntry[0]['isfeatured']=="1"? "#DAA520":"#C0C0C0";  
            $starColor=$isfeatured; $disableLink=''; $redyColor='label-success'; $vStatus='label-success'; $disableLink='';
            $actColor=""; $disable="";
            $in=1; $d1=0; $d2=1;   $bname1="A"; $bname2='D'; $class1="btn-success active"; $class2="btn-danger"; $disable1="disabled"; $disable2="";
            if($video_status=="inactive" || $video_status=="Inactive")
            {
                
                $in=0; $d1=1; $d2=0;   $bname1="A"; $bname2='D'; $class2="btn-success active"; $class1="btn-danger"; 
                $actColor="#e8e8e8";   $disable1=""; $disable2="disabled"; $vStatus='label-default';  
            } 
            if($status!=2){  $disableLink='not-active-href';  }

?>
<tr id="<?php echo $count."_r"; ?>" style="font-size: 12px; background:<?php echo $actColor; ?>">
<!--<td style="width:15%">
 <img class="img-responsive customer-img"  src="<?php echo $thumbnailUrl.$tumnail_height_width; ?>" alt="" />
</td>-->
<td style="width:10%">
<img class="img-responsive customer-img"  src="<?php echo $thumbnailUrl.$tumnail_height_width; ?>" alt="" />
<?php  if(in_array(2, $UserRight)){ ?>
<div class="btn-group btn-toggle " style=" position: relative; margin-top:4px;"> 
    <button id="<?php echo $count."_a"; ?>" title="active" <?php echo $disable1; ?>  class="btn btn-xs <?php echo $class1; ?>" onclick="vodActDeact1('<?php echo $d1; ?>','<?php echo $id; ?>','<?php echo $count;  ?>')"><?php echo $bname1; ?></button>
    <button id="<?php echo $count."_d"; ?>" title="inactive" <?php echo $disable2; ?> class="btn btn-xs <?php echo $class2; ?>"  onclick="vodActDeact2('<?php echo $d2; ?>','<?php echo $id; ?>','<?php echo $count;  ?>')"><?php echo $bname2; ?></button>
</div>
<?php } else { ?> 
 <div class="btn-group btn-toggle" style="position: relative; margin-top:4px;"> 
    <button id="<?php echo $count."_a"; ?>" title="active" disabled class="btn btn-xs <?php echo $class1; ?>"><?php echo $bname1; ?></button>
    <button id="<?php echo $count."_d"; ?>" title="inactive" disabled class="btn btn-xs <?php echo $class2; ?>" ><?php echo $bname2; ?></button>
</div>   
<?php } ?>    
</td> 
<td  style="width:10%"><a href="javascript:void(0)" class="<?php echo $disableLink; ?>" onclick="viewLiveDetail('<?php echo $pager->pageIndex; ?>','<?php echo $id; ?>','<?php echo $ptag;?>','<?php echo $pager->pageSize;?>');" ><?php echo $id;?></a></td>
<td  style="width:20%"  title="<?php echo $name;  ?>"><?php  echo wordwrap($name,20, "\n", true);?></td>
<td  style="width:31%; font-size: 11px;" data-toggle="tooltip" title="<?php echo  $categories; ?>">
<?php  echo wordwrap($categories,30, "\n", true); ?>
</td>
<td  style="width:10%"><?php echo date("d/m/y H:i:s", $createdAt); ?></td>
<td  style="width:10%">
<span class="label <?php echo $redyColor; ?> label-white middle"><?php echo  $statusc; ?></span>
</td>
<td  style="width:6%" id="catgoryactStayus<?php echo $count; ?>">
   <span  class="label <?php echo $vStatus; ?> label-white middle"><?php echo  $video_status; ?></span> 
</td>
<td  style="width:7%">
<a href="javascript:void(0)" class="<?php echo $disableLink; ?>" onclick="viewLiveDetail('<?php echo $pager->pageIndex; ?>','<?php echo $id; ?>','<?php echo $ptag;?>','<?php echo $pager->pageSize;?>');" > 
<i class="fa fa-eye" aria-hidden="true" data-toggle="tooltip" data-placement="left"  title="View Details" style="padding-right: 8px  !important;"></i>
</a>
<?php  if(in_array(4, $UserRight)){ ?>
<a href="javascript:void(0)" onclick="return deleteContent('<?php echo $id; ?>','deletecontent','<?php echo $pager->pageIndex; ?>','<?php echo $pager->pageSize;?>')"><i class="fa fa-trash-o" aria-hidden="true" title="Delete"></i></a>
<?php }?>
</td>
</tr>
<?php


$count++;
}
}
else { echo "data not available."; }
include_once 'ksession_close.php';
?>         
</tbody>
</table>
</div>        
</form>  
<?php
/* new paging code............*/
$pager->pageIndex=$pager_pageIndex;
if($pager->pageIndex==0){ $pager->pageIndex=1; }
$prev = $pager->pageIndex - 1;	//previous page is page - 1
$next = $pager->pageIndex + 1;
$limit=$pager->pageSize;	//next page is page + 1
$lastpage = ceil($total_pages/$limit);
$adjacents = 1;				
$lpm1 = $lastpage - 1;					
$pagination = "";
if($lastpage > 1)
	{	
	    $pagination .= "<div class=\"pagination\">";  
		//previous button
		if ($pager->pageIndex >1)   
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
			<?php 	if ($counter == $pager->pageIndex)
					$pagination.= "<span class=\"current\">$counter</span>";
				else
				
				    $pagination.= '<a href="javascript:void(0)" onclick="changePagination(\''.$counter.'\',\''.$limit.'\',\''.$searchTextMatch.'\',\''.$filtervalue.'\')">'.$counter.'</a>';		
				    
                                }
		}
		elseif($lastpage > 2 + ($adjacents * 2))	//enough pages to hide some
		{
    
			//close to beginning; only hide later pages
			if($pager->pageIndex < 1 + ($adjacents * 2))		
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					if ($counter == $pager->pageIndex)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						
					    $pagination.= '<a href="javascript:void(0)" onclick="changePagination(\''.$counter.'\',\''.$limit.'\',\''.$searchTextMatch.'\',\''.$filtervalue.'\')">'.$counter.'</a>';				
				}
				$pagination.= "...";
				$pagination.= '<a href="javascript:void(0)" onclick="changePagination(\''.$lpm1.'\',\''.$limit.'\',\''.$searchTextMatch.'\',\''.$filtervalue.'\')">'.$lpm1.'</a>';
				$pagination.= '<a href="javascript:void(0)" onclick="changePagination(\''.$lastpage.'\',\''.$limit.'\',\''.$searchTextMatch.'\',\''.$filtervalue.'\')">'.$lastpage.'</a>';	
			}
			//in middle; hide some front and some back
			elseif($lastpage - ($adjacents * 2) > $pager->pageIndex && $pager->pageIndex > ($adjacents * 2))
			{
                           
				
				$pagination.= '<a href="javascript:void(0)" onclick="changePagination(\'1\',\''.$limit.'\',\''.$searchTextMatch.'\',\''.$filtervalue.'\')">1</a>';	
				$pagination.= '<a href="javascript:void(0)" onclick="changePagination(\'2\',\''.$limit.'\',\''.$searchTextMatch.'\',\''.$filtervalue.'\')">2</a>';
				$pagination.= "...";
				for ($counter = $pager->pageIndex - $adjacents; $counter <= $pager->pageIndex + $adjacents; $counter++)
				{
					if ($counter == $pager->pageIndex)
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
					if ($counter == $pager->pageIndex)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
							
						$pagination.= '<a href="javascript:void(0)" onclick="changePagination(\''.$counter.'\',\''.$limit.'\',\''.$searchTextMatch.'\')">'.$counter.'</a>';					
				}
			}
		}
		
		//next button
		if ($pager->pageIndex < $counter - 1) 
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
            <?php  if(in_array(2,$UserRight)){ ?>  
           <?php  if(in_array(5,$otherPermission)){ ?>
           <li><a href="javascript:void(0)" onclick="planbulk('<?php echo $pager->pageIndex;  ?>','<?php echo $pager->pageSize; ?>')">Add Plan</a>
           </li> <?php } ?>
           <li><a href="javascript:void(0)" onclick="add_to_bulk_category('<?php echo $pager->pageIndex;  ?>','<?php echo $pager->pageSize; ?>')">Add to Category</a></li>
           <li><a href="javascript:void(0)" class="bulkactive" onclick="bulkactive('<?php echo $pager->pageIndex;  ?>','<?php echo $pager->pageSize; ?>','BULK_ACTIVE');">bulk active</a></li>
           <li><a href="javascript:void(0)" class="bulkinactive" onclick="bulkactive('<?php echo $pager->pageIndex;  ?>','<?php echo $pager->pageSize; ?>','BULK_INACTIVE');" >bulk inactive</a></li>
            <?php } if(in_array(4,$UserRight)){  ?>
           <li><a href="javascript:void(0)"   onclick="delete_bulk('<?php echo $pager->pageIndex;  ?>','<?php echo $pager->pageSize; ?>');" id="delete_bulk">Delete</a></li>
            <?php } ?>
         </ul>   
       </div> 
</div>-->
   
<div class="col-xs-8 pull-right"  style="border: 0px solid red; padding: 0px 0px 0px 0px; font-size: 11px;">
    <div class="pull-left">
     <?php
     if($pager->pageIndex ==1 || $pager->pageIndex ==0) { 
       if($total_pages==0){  $startShow=0;  } else {  $startShow=1;} 
       $lmt=$limit<$total_pages ? $limit :$total_pages;
       }
       else{
       $startShow=(($pager->pageIndex - 1) * $limit)+1;
       $lmt=($pager->pageIndex*$limit) >$total_pages ? $total_pages: $pager->pageIndex * $limit;
       }
     ?>
    </div>
     
    <div class="pull-right" style="padding: 5px;">
        <span style="padding-top: 5px;float:left;margin-right: 20px;"> Showing <?php echo $startShow; ?> to <?php echo $lmt; ?>   of <strong><?php echo $total_pages; ?> </strong>entries </span>
       <?php echo $pagination;?>
    </div>   

</div>
</div> 
<script src="js/commonFunctionJS.js" type="text/javascript"></script>
<script type="text/javascript">
 function add_new_channel(act)    
{
     $("#myModal_add_new_channel").modal();
     $("#flash").fadeIn(500).html('Loading <img src="img/image_process.gif" />');
     var info = 'action=add_new_channel'; 
        $.ajax({
	    type: "POST",
	    url: "liveChannelModal.php",
	    data: info,
             success: function(result){
             $("#flash").hide();
             $('#view_modal_new_channel').html(result);
             return false;
        }
 
        });
        return false;
}
function viewLiveDetail(EntryPageindex,Entryid,ptag,limitval)
{
       $("#flash").fadeIn(100).html('Wait <img src="img/image_process.gif" />');
       $("#show_detail_live_modal_view").html();
       $('#myModalLiveEdit').modal();
       var info = 'Entryid='+Entryid+"&pageindex="+EntryPageindex+'&limitval='+ limitval; 
       $.ajax({
	   type: "POST",
	   url: "liveModal.php",
	   data: info,
         success: function(result){
         $("#flash").hide();
         $('#show_detail_live_modal_view').html(result);
          }
        });
     return false; 
}
function changePagination(pageid,limitval,searchtext,filterview){
     //$("#flash").fadeIn(100).html('Wait <img src="img/image_process.gif" />');
     var dataString ='first_load='+ pageid+'&limitval='+limitval+'&searchInputall='+searchtext+"&filtervalue="+filterview;
     //$("#result").html();
     $('#load').show();
     $('#results').css("opacity",0.1);
     $.ajax({
           type: "POST",
           url: "live_channel_paging.php",
           data: dataString,
           cache: false,
           success: function(result){
                 //$("#results").html('');
                // $("#flash").hide();
                $("#results").html(result);
                $('#load').hide();
		$('#results').css("opacity",1);
           	
           }
      });
}




function deleteContent(entryID,delname,pageindex,limitval){
      var dataString ='entryID='+entryID+"&laction="+delname+"&pageindex="+pageindex;
      var a=confirm("Are you sure you want to delete the selected entry ? " +entryID+  "\nPlease note: the entry will be permanently deleted from your account");
      if(a==true)
      {   
        $("#flash").show();
        $("#flash").fadeIn(800).html('Loading..<img src="img/image_process.gif" />');
       var publisher_unique_id="<?php  echo $publisher_unique_id ?>";
       var apiURl="<?php  echo $apiURL."/livefeed" ?>";
       var apiBody = new FormData();
       apiBody.append("partnerid",publisher_unique_id); 
       apiBody.append("entryid",entryID);
       apiBody.append("tag","delete");
       $.ajax({
                url:apiURl,
                method: 'POST',
                dataType: 'json', 
                data:apiBody,
                processData: false,
                contentType: false,
                    success: function(jsonResult){
                     console.log(jsonResult);
                     var status=jsonResult.status;
                     if(status==0){
                      $('#results').load("live_channel_paging.php",{'first_load':pageindex,'limitval':limitval,'maction':'deletecontent'},
                      function() {
	  	      $("#msg").html("Delete successfully");
                      $("#flash").hide();
                      });
                   }
                      
                    }
            });	
    
    
    
               /*if(dls=='0')
                 {   
                        $.ajax({
                               type: "POST",
                               url: "live_channel_paging.php",
                               data: dataString,
                               cache: false,
                               success: function(result){
                                     $("#results").html('');
                                     $("#flash").hide();
                                     window.location.reload(false);                                      
                                     $("#results").html(result);
                               }
                             });
                  }*/ 
	     }
	     else
	     {
	     	 $("#flash").hide();
	     	 return false;
	       }
             }



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
           url: "live_channel_paging.php",
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
           url: "live_channel_paging.php",
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
function vodActDeact1(actdeact,entryid,rowcount)
{
     
       var apiBody = new FormData();
       apiBody.append("entryid",entryid);
       apiBody.append("tag","active");
       apiBody.append("action","vod_active");
       $.ajax({
                url:'core_active_deactive.php',
                method: 'POST',
                data:apiBody,
                processData: false,
                contentType: false,
                    success: function(jsonResult){
                     var categoryName=jsonResult
                     $("#"+rowcount+"_a" ).addClass("btn-primary").removeClass("btn-default");
                     $("#"+rowcount+"_d" ).removeClass("btn-primary active");
                     $("#"+rowcount+"_a" ).prop("disabled", true);
                     $("#"+rowcount+"_d" ).prop("disabled", false);
                     $("#"+rowcount+"_r" ).css("background", "");
                     var html='<span  class="label label-success label-white middle">'+categoryName+'</span>';
                     $("#catgoryactStayus"+rowcount).html(html);
                     
                    }
            });
  
          
}
function vodActDeact2(actdeact,entryid,rowcount)
{
    
       var apiBody = new FormData();
       apiBody.append("entryid",entryid);
       apiBody.append("tag","inactive");
       apiBody.append("action","vod_inactive");
       $.ajax({
                url:'core_active_deactive.php',
                method: 'POST',
                data:apiBody,
                processData: false,
                contentType: false,
                    success: function(jsonResult){
                      var categoryName=jsonResult;
                      $("#"+rowcount+"_d" ).addClass("btn-primary active").removeClass("btn-default");
                      $("#"+rowcount+"_a" ).removeClass("btn-primary active");
                      $("#"+rowcount+"_d" ).prop("disabled", true);
                      $("#"+rowcount+"_a" ).prop("disabled", false); 
                      $("#"+rowcount+"_r" ).css("background", "#e8e8e8");
                      var html='<span  class="label label-default label-white middle">'+categoryName+'</span>';
                      $("#catgoryactStayus"+rowcount).html(html);
                     
                    }
            });
}   

</script>

