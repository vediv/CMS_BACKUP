<?php
sleep(1);
include_once 'corefunction.php';
$searchTextMatch = (isset($_POST['searchInputall']))? $_POST['searchInputall']: "";
$pagelimit = (isset($_POST['limitval']))? $_POST['limitval']: "5";
include_once("config.php");
$page =(isset($_POST['first_load']))? $_POST['first_load']:"";
$get_refresh = (isset($_POST['refresh']))? $_POST['refresh']: "";
$filtervalue=(isset($_POST['filtervalue']))? $_POST['filtervalue']:'';
$action = (isset($_POST['maction'])) ? $_POST['maction']: "";
switch($action)
{
    /***** following code doing delete start ***/
      case "deletecontent":
      $deleteentryID= (isset($_POST['entryID']))? $_POST['entryID']: "";
      // check this entry active in carosel. 
      if($deleteentryID!=''){    
        $sql="select count('$deleteentryID') as entryCount from slider_image_detail where ventryid='$deleteentryID' and img_status='1'";
        $row= db_select($conn,$sql);
            $entryCount=$row[0]['entryCount'];
            if($entryCount==1)
            {
                echo 3;
                die();
            } 
        }
                $delEntry="update entry set status='3' where entryid='$deleteentryID'"; 
                $entrytable = db_query($conn,$delEntry);
                if($entrytable){
                  /*----------------------------update log file begin-------------------------------------------*/    
                  $error_level=1;$msg="Delete Video entry($deleteentryID)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
                  $qry='';
                  write_log($error_level,$msg,$lusername,$qry);
                  /*----------------------------update log file End---------------------------------------------*/ 

                 }
                 else 
                 {
                   /*----------------------------update log file begin-------------------------------------------*/
                   $error_level=5;$msg="Delete Video entry($deleteentryID)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
                   $qry=$insert;
                   write_log($error_level,$msg,$lusername,$qry);
                   /*----------------------------update log file End---------------------------------------------*/ 
                  } 
      $pageindex_when_delete	 = (isset($_POST['pageindex']))? $_POST['pageindex']: "";
      $pager_pageIndex=$pageindex_when_delete;
    break;  
 /***** following code doing multi delete start ***/
    case "multidelete":
        $pageindex_when_delete	 = (isset($_POST['pageindex']))? $_POST['pageindex']: "";
        $pager_pageIndex=$pageindex_when_delete;
        
    break; 
 /***** following code doing update metadata start ***/
    case "saveandclose_metadata": 
    $updateentryID = (isset($_POST['entryid']))? $_POST['entryid']: null;
    $updateentryName = (isset($_POST['entryname']))? $_POST['entryname']: null;
    $updateDesc	 = (isset($_POST['entrydescription']))? $_POST['entrydescription']: null;
    $updateTags	 = (isset($_POST['entrytags']))? $_POST['entrytags']: null;
    $shortDesc1 = (isset($_POST['short_desc']))? $_POST['short_desc']: null;
    $subGenre1 = (isset($_POST['sub_genre']))? $_POST['sub_genre']: null;
    $pgRating	 = (isset($_POST['pg_rating']))? $_POST['pg_rating']: null;
    $lang	 = (isset($_POST['lang']))? $_POST['lang']: null;
    $producer1 = (isset($_POST['producer']))? $_POST['producer']: null;
    $director1 = (isset($_POST['director']))? $_POST['director']: null;
    $cast1	 = (isset($_POST['cast']))? $_POST['cast']: null;
    $crew1	 = (isset($_POST['crew']))? $_POST['crew']: null;
    $duration = (isset($_POST['duration']))? $_POST['duration']: null;
    $updateCategoreies = (isset($_POST['metadata_category']))? $_POST['metadata_category']: null;
    $video_status = (isset($_POST['video_status']))? $_POST['video_status']: null;
    $pageindex_when_update	 = (isset($_POST['pageindex']))? $_POST['pageindex']: "";
    $key_descNames	 = (isset($_POST['key_desc']))? $_POST['key_desc']: "";
    $key_vals	 = (isset($_POST['key_val']))? $_POST['key_val']: "";
    $customDataInsert='';
    if(!empty($key_descNames) && !empty($key_vals))
    {
        $keyDesc_keyVal=array_combine($key_descNames,$key_vals);
        $customDataInsert=  json_encode($keyDesc_keyVal);
    }
    if(!empty($updateCategoreies))
    {    
     $updateCategoreies_id = implode(",",$updateCategoreies);
    }  
    if($updateCategoreies=='null')
    {
        $updateCategoreies_id='';
    }   
    if($updateCategoreies=='')
    {
       $updateCategoreies_id='';
    }   
       $updatedAt_convert=date("Y-m-d H:i:s"); $createdAt_convert=date("Y-m-d H:i:s");
       $name=db_quote($conn,$updateentryName);  $description=db_quote($conn,$updateDesc);
       $tags=db_quote($conn,$updateTags); $subGenre=db_quote($conn,$subGenre1);
       $shortDesc=db_quote($conn,$shortDesc1); $producer=db_quote($conn,$producer1); $director=db_quote($conn,$director1);
       $cast=db_quote($conn,$cast1); $crew=db_quote($conn,$crew1);
        $upEntry="update entry set name=$name,longdescription=$description,
        tag=$tags,categoryid='$updateCategoreies_id',
        updated_at='$updatedAt_convert',shortdescription=$shortDesc,
        director=$director,producer=$producer,cast=$cast,crew=$crew,sub_genre=$subGenre,
        language='$lang',pgrating='$pgRating',video_status='$video_status',custom_data='".$customDataInsert."'
        where entryid='$updateentryID'";		      
        $r=  db_query($conn,$upEntry);
        /*----------------------------update log file begin-------------------------------------------*/
                   $error_level=1;$msg="Updtate MetaData($entry_id)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
                   $qry=$upEntry;
                   write_log($error_level,$msg,$lusername,$qry);
        /*----------------------------update log file End---------------------------------------------*/
    $pager_pageIndex=$pageindex_when_update; 
    break; 
    /***** following code doing  save and close thubnail start***/
    case "saveandclose_thumnnail":
    $thubmentryID	 = (isset($_POST['entryid']))? $_POST['entryid']: "";
    $pageindex_when_thubm = (isset($_POST['pageindex']))? $_POST['pageindex']: "";
    $pager_pageIndex=$pageindex_when_thubm;
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
      case "save_currency_metadata":
          $entryID = (isset($_POST['entryid']))? $_POST['entryid']: "";
          $currency=($_POST['currency']); $price=($_POST['price']);
          $customCurrencyInsert='';
          if(!empty($currency) && !empty($price))
          {
            $currency_price_Val=array_combine($currency,$price);
            $customCurrencyInsert=  json_encode($currency_price_Val);
          } 
       $queryupdate="update entry set currency_data='$customCurrencyInsert' where entryid='$entryID' "; 
       $upd =db_query($conn,$queryupdate);
       if($upd){
            /*----------------------------update log file begin-------------------------------------------*/    
            $error_level=1;$msg="Save currency_data($entryID)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
            $qry='';
            write_log($error_level,$msg,$lusername,$qry);
            /*----------------------------update log file End---------------------------------------------*/ 

           }
           else 
           {
             /*----------------------------update log file begin-------------------------------------------*/
             $error_level=5;$msg="currency_data($entryID)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
             $qry=$queryupdate;
             write_log($error_level,$msg,$lusername,$qry);
             /*----------------------------update log file End---------------------------------------------*/ 
         } 
      break;
      case "save_content_partner_metdata":
      $entryID = (isset($_POST['entryid']))? $_POST['entryid']: "";
      $contentpartnerid = (isset($_POST['content_partner']))? $_POST['content_partner']: "";
      $queryupdate="update entry set puser_id='$contentpartnerid' where entryid='$entryID' "; 
      $upd =db_query($conn,$queryupdate);
      if($upd){
                  /*----------------------------update log file begin-------------------------------------------*/    
                  $error_level=1;$msg="Save Content Partner($entryID,$isPremiums)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
                  $qry='';
                  write_log($error_level,$msg,$lusername,$qry);
                  /*----------------------------update log file End---------------------------------------------*/ 

                 }
                 else 
                 {
                   /*----------------------------update log file begin-------------------------------------------*/
                   $error_level=5;$msg="Save Content Partner($entryID,$isPremiums)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
                   $qry=$queryupdate;
                   write_log($error_level,$msg,$lusername,$qry);
                   /*----------------------------update log file End---------------------------------------------*/ 
               } 
     
      break;  
     case "saveplan":
     $planentryID = (isset($_POST['entryid']))? $_POST['entryid']: "";
     $pageindex_when_plan= (isset($_POST['pageindex']))? $_POST['pageindex']: "";
     $plan_ids = (isset($_POST['plan_ids']))? $_POST['plan_ids']: "";
     $planuniquename = (isset($_POST['planuniquename']))? $_POST['planuniquename']: "";
     $isPremiums=$planuniquename=="p" ? 1: 0;
     //echo $queryupdate="update entry set planid='$plan_ids',ispremium='$isPremiums',type='1',status='2' where entryid='$planentryID' "; 
     $queryupdate="update entry set ispremium='$isPremiums' where entryid='$planentryID' and type='8' "; 
     $upd =db_query($conn,$queryupdate);
     if($upd){
                  /*----------------------------update log file begin-------------------------------------------*/    
                  $error_level=1;$msg="Save Plan($planentryID,$isPremiums)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
                  $qry='';
                  write_log($error_level,$msg,$lusername,$qry);
                  /*----------------------------update log file End---------------------------------------------*/ 

                 }
                 else 
                 {
                   /*----------------------------update log file begin-------------------------------------------*/
                   $error_level=5;$msg="Save Plan($planentryID,$isPremiums)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
                   $qry=$queryupdate;
                   write_log($error_level,$msg,$lusername,$qry);
                   /*----------------------------update log file End---------------------------------------------*/ 
               } 
     
     
    $pager_pageIndex=$pageindex_when_plan; 
    break;
    case "savebulkplan":
      $planentryID = (isset($_POST['entryid']))? $_POST['entryid']: "";
      $pageindex_when_plan= (isset($_POST['pageindex']))? $_POST['pageindex']: "";
      $plan_ids = (isset($_POST['plan_ids']))? $_POST['plan_ids']: "";
      $planuniquename = (isset($_POST['planuniquename']))? $_POST['planuniquename']: "";
      $planIDs=rtrim($plan_ids,',');
      $mulplanEntryID=explode(",",$planentryID);
      foreach ($mulplanEntryID as $onlyplanid) {
        /*$query_check = "SELECT COUNT('$onlyplanid') as num,planid FROM entry where entryid='$onlyplanid'";
        $totalpages =db_select($conn,$query_check);
        $planIDs_get = $totalpages[0]['planid'];*/
        $isPremiums=$planuniquename=="p" ? 1: 0;	
        //$queryupdate="update entry set planid='$planIDs',ispremium='$isPremiums',type='1',status='2' where entryid='$onlyplanid'"; 
        $queryupdate="update entry set ispremium='$isPremiums',type='1',status='2' where entryid='$onlyplanid'"; 
        $upd=db_query($conn,$queryupdate);				      
      }
      /*----------------------------update log file begin-------------------------------------------*/    
        $error_level=1;$msg="Save Bulk Plan($planentryID,$isPremiums)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
        $qry=$queryupdate;
        write_log($error_level,$msg,$lusername,$qry);
     /*----------------------------update log file End---------------------------------------------*/ 
    $pageindex_when_plan= (isset($_POST['pageindex']))? $_POST['pageindex']: "";  
    $pager_pageIndex=$pageindex_when_plan;
    echo 1;
    die();
    break; 
    case "bulk_add_cat":
       $pageindex_when_plan= (isset($_POST['pageindex']))? $_POST['pageindex']: "";  
       $pager_pageIndex=$pageindex_when_plan;
       echo 1;
       die();
     break;
     case "bulk_remove_cat":
      $entryid_and_categoryID = (isset($_POST['entryid_and_categoryID']))? $_POST['entryid_and_categoryID']: null;
      $entryid_and_categoryIDs=rtrim($entryid_and_categoryID,',');
      $muldelcat=explode(",",$entryid_and_categoryIDs);
      foreach ($muldelcat as $delID) {
      $catandentryID=explode("-",$delID);
      $EntryID=trim($catandentryID[0]); $catID=trim($catandentryID[1]); 
     //remove category Entry
    //$entryId = $EntryID;
    //$categoryId = $catID;
    //$result = $client->categoryEntry->delete($entryId, $categoryId);
      }
    $pageindex_when_plan = (isset($_POST['pageindex']))? $_POST['pageindex']: "";  
    $pager_pageIndex=$pageindex_when_plan;        
    break;
    
    case "saveBulkContentPartner":
    $addcontentpartner = (isset($_POST['addcontentpartner']))? $_POST['addcontentpartner']: null;
    $entryids = (isset($_POST['entryids']))? $_POST['entryids']: "";
    $entryids=explode(",",$entryids);
     foreach ($entryids as $eids) {
        $upContentPartner="update entry set puser_id='$addcontentpartner' where entryid='".$eids."' "; 
        $r= db_query($conn,$upContentPartner);   
      }
         /*----------------------------update log file begin-------------------------------------------*/    
        $error_level=1;$msg="Bulk Add ContentPartner($entryids,$addcontentpartner)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
        $qry='';
        write_log($error_level,$msg,$lusername,$qry);
     /*----------------------------update log file End---------------------------------------------*/
     echo 1;
     die();
    break;    
    
    case "save_contentViewer":
    $addcontentviewer = (isset($_POST['addcontentviewer']))? $_POST['addcontentviewer']: '';
    $entryID = (isset($_POST['entryid']))? $_POST['entryid']: ""; 
    $queryupdate="update entry set age_limit='$addcontentviewer' where entryid='$entryID' "; 
    $upd =db_query($conn,$queryupdate);
    if($upd){
                /*----------------------------update log file begin-------------------------------------------*/    
                $error_level=1;$msg="Save Content Viewer Rating($entryID,$addcontentviewer)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
                $qry='';
                write_log($error_level,$msg,$lusername,$qry);
                /*----------------------------update log file End---------------------------------------------*/ 

               }
               else 
               {
                 /*----------------------------update log file begin-------------------------------------------*/
                 $error_level=5;$msg="Save Content Viewer Rating($entryID,$addcontentviewer)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
                 $qry=$queryupdate;
                 write_log($error_level,$msg,$lusername,$qry);
                 /*----------------------------update log file End---------------------------------------------*/ 
             } 
    
    break; 
    case "saveAgeR":
    $agelimit = (isset($_POST['agelimit']))? $_POST['agelimit']: '';
    $entryID = (isset($_POST['entryid']))? $_POST['entryid']: ""; 
    $queryupdate="update entry set age_limit='$agelimit' where entryid='$entryID' "; 
    $upd =db_query($conn,$queryupdate);
    if($upd){
                /*----------------------------update log file begin-------------------------------------------*/    
                $error_level=1;$msg="Save Age Restriction($entryID,$agelimit)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
                $qry='';
                write_log($error_level,$msg,$lusername,$qry);
                /*----------------------------update log file End---------------------------------------------*/ 

               }
               else 
               {
                 /*----------------------------update log file begin-------------------------------------------*/
                 $error_level=5;$msg="Save Content Viewer Rating($entryID,$agelimit)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
                 $qry=$queryupdate;
                 write_log($error_level,$msg,$lusername,$qry);
                 /*----------------------------update log file End---------------------------------------------*/ 
             } 
    
    break; 
     case "saveBulkContentViewer":
     $addcontentviewer = (isset($_POST['addcontentviewer']))? $_POST['addcontentviewer']: '';
     $entryids= (isset($_POST['entryids']))? $_POST['entryids']: ""; 
     $entryids=explode(",",$entryids);
     foreach ($entryids as $eids) {
        $upContentViewer="update entry set age_limit='$addcontentviewer' where entryid='".$eids."' "; 
        $r= db_query($conn,$upContentViewer);   
      }
         /*----------------------------update log file begin-------------------------------------------*/    
        $error_level=1;$msg="Bulk Add Content Viewer($entryids,$addcontentviewer)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
        $qry=$upcatinfoinentry;
        write_log($error_level,$msg,$lusername,$qry);
     /*----------------------------update log file End---------------------------------------------*/
     echo 1;
     die();
     
     break;
     case "saveAgeRestrictionBulk":
     $agelimit = (isset($_POST['agelimit']))? $_POST['agelimit']: '';
     $entryids= (isset($_POST['entryids']))? $_POST['entryids']: ""; 
     $entryids=explode(",",$entryids);
     foreach ($entryids as $eids) {
        $upContentViewer="update entry set age_limit='$agelimit' where entryid='".$eids."' "; 
        $r= db_query($conn,$upContentViewer);   
      }
         /*----------------------------update log file begin-------------------------------------------*/    
        $error_level=1;$msg="Bulk Add Age Restriction($entryids,$agelimit)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
        $qry=$upcatinfoinentry;
        write_log($error_level,$msg,$lusername,$qry);
     /*----------------------------update log file End---------------------------------------------*/
     echo 1;
     die();
     
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
/*$accessLevelQuery='';
//if($login_access_level=='c'){
   // $accessLevelQuery=" and puser_id='$get_user_id'";
}*/
//$filtervalue='';
$sqlt = "SELECT COUNT(entryid) as totalEntry FROM entry where type='8' and status!='3'   ";
if($filtervalue==''){ $sqlt.=""; }
if($filtervalue=='active' || $filtervalue=='inactive'){ $sqlt.=" and video_status='$filtervalue'";  }
if($searchTextMatch!='')
{
    $sqlt .= "  and (name LIKE '%". $searchTextMatch . "%' or tag LIKE '%" . $searchTextMatch . "%' or entryid LIKE '%" . $searchTextMatch . "%' or longdescription LIKE '%" . $searchTextMatch . "%')";
}
//echo $sqlt;
$totalpages =db_select($conn,$sqlt);
$totalEntry = $totalpages[0]['totalEntry'];
$total_pages=$totalEntry;
$limit = $pagelimit; 
if($page) 
	 $start = ($page - 1) * $limit; 			//first item to display on this page
   else
$start = 0;
$entry_query="select entryid,name,categoryid,duration,created_at,planid,ispremium,thumbnail,
status,isfeatured,video_status,sync,downloadURL from entry where  type='8' and status!='3' ";

if($filtervalue=='active' || $filtervalue=='inactive'){ $entry_query.=" and video_status='$filtervalue'";  }
if($searchTextMatch!='')
{
    $entry_query .= "  and (name LIKE '%". $searchTextMatch . "%' or tag LIKE '%" . $searchTextMatch . "%' or entryid LIKE '%" . $searchTextMatch . "%' or longdescription LIKE '%" . $searchTextMatch . "%')";
}
$entry_query.=" ORDER BY (created_at) DESC  LIMIT $start,$pagelimit";
//echo "<br/> DataQuery=".$entry_query; 

$fentry=  db_select($conn,$entry_query);
$act_inact="SELECT  SUM(IF (video_status='active',1,0)) AS total_active,SUM(IF (video_status='inactive',1,0)) AS
total_inactive FROM entry where status!='3' and type='8' $accessLevelQuery";
$tableAD=  db_select($conn,$act_inact);
$totalActive=$tableAD[0]['total_active']; $totalInactive=$tableAD[0]['total_inactive'];
$totalEntry=$totalActive+$totalInactive;
$total_active_disabled=$totalActive==0?'disabled':'';
$total_inactive_disabled=$totalInactive==0?'disabled':'';
?>
<div class="box-header" >
<div class="row" style="border: 0px solid red; margin-top:-10px;">
    <table border='0' style="width:98%; margin-left: 10px; font-size: 12px;">
    <tr>
    <td width="17%"><select id="pagelmt"  style="width:60px;" onchange="selpagelimit('<?php echo $page;  ?>','<?php echo $filtervalue; ?>','<?php echo $searchTextMatch;?>');" >
        <option value="10"  <?php echo $pagelimit==10? "selected":""; ?> >10</option>
         <option value="5"  <?php echo $pagelimit==5? "selected":""; ?> >5</option>
        <option value="20"  <?php echo $pagelimit==20? "selected":""; ?> >20</option>
        <option value="50"  <?php echo $pagelimit==50? "selected":""; ?> >50</option>
        <option value="100" <?php echo $pagelimit==100? "selected":""; ?> >100</option>
        <option value="200" <?php echo $pagelimit==200? "selected":""; ?> >200</option>
        <option value="500" <?php echo $pagelimit==500? "selected":""; ?> >500</option>
        </select> Records Per Page</td>
  <td width="22%" align="center">
        View:<select name="filterentry"  id="filterentry" onchange="filterView('<?php echo $page;  ?>','<?php echo $pagelimit; ?>','<?php echo $searchTextMatch;?>');" style="text-transform: uppercase !important;">
        <option value="" <?php  echo $filtervalue==''?"selected":''; ?>>ALL</option>
        <option value="active" <?php echo $total_active_disabled; echo $filtervalue=='active'?"selected":''; ?>>ACTIVE</option>
        <option value="inactive" <?php echo $total_inactive_disabled; echo $filtervalue=='inactive'?"selected":''; ?>>INACTIVE</option>
     </select>
  </td>
  <td width="32%" align="center">
      <span class="label label-primary">ALL <span class="badge" style="color: #337ab7; background-color: #fff;padding: 0px 4px 1px 4px;"><?php echo $totalEntry; ?></span></span>
      <span class="label label-success">ACTIVE <span class="badge"  style="color: #00a65a; background-color: #fff;padding: 0px 4px 1px 4px;"><?php echo $totalActive; ?></span></span>
      <span class="label label-default">INACTIVE <span class="badge"  style="color: #444; background-color: #fff;padding: 0px 4px 1px 4px;"><?php echo $totalInactive; ?></span></span>
  </td>
    <td width="35%">
     <!--<form class="navbar-form" role="search" method="post" style=" padding: 0 !important;">-->
       <div class="col-sm-3 col-md-3 pull-right navbar-form" role="search">    
       <div class="input-group add-on" style="float: right;">
       <input class="form-control" size="30" onkeyup="SeachDataTable('youtube_paging.php','<?php echo $pagelimit;?>','<?php echo $page ;?>','load','<?php echo $filtervalue; ?>')"  placeholder="Search Entries by id,name,tags,etc"  autocomplete="off" name='searchQuery' id='searchInput' class="searchInput" type="text" value="<?php echo $searchTextMatch; ?>">
       <div class="input-group-btn">
       <button class="enableOnInput btn btn-default" onclick="SearchDataTableValue('youtube_paging.php','<?php echo $pagelimit;?>','<?php echo $page; ?>','load','<?php echo $filtervalue; ?>')" disabled='disabled' id='submitBtn' type="button" style="height: 30px;   padding: 4px 6px !important;" ><i class="glyphicon glyphicon-search"></i></button>	
       </div>
       </div>
       </div>   
       <!--</form>-->
   </td>
    <td width="5%">
     <div class="col-xs-1 hidden-xs hidden-sm pull-right" style="border:none;  margin-top:1px !important;">   
      <a href="javascript:" onclick="return refreshcontent('refresh','<?php echo $page;  ?>','<?php echo $pagelimit; ?>','<?php echo $searchTextMatch;?>','<?php echo $filtervalue;?>');" title="refresh" style="float: right"><i class="fa fa-refresh" aria-hidden="true"></i></a>   
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
    <table  class="table table-fixedheader table-bordered table-striped" style="table-layout:fixed; width: 100%;"> 
    <thead style="display: block; overflow-y: scroll;">
      <tr>
        <th  style="width:1%"><input type="checkbox" id="ckbCheckAll"></th>
        <!--<th  width="6%"></th>-->
        <th  style="width:9%">Thumbnail</th>
        <th  style="width:10%">ID</th>
        <th  style="width:30%">Name</th>
        <th  style="width:21%">Categories</th>
        <th  style="width:10%">Created-On</th>
        <th  style="width:7%" title="Upload Status">U-Status</th>
        <th  style="width:6%" title="Video Status">V-Status
        <th  style="width:6%" >Action <span style="background: #fff;position: absolute; height: 34px;margin-top:-5px; width: 20px;right: 0;" ></span></th>
       </tr>    
    </thead>
    
<tbody style="height:500px;overflow-y: scroll;display: block;">
<?php
$count=1;
foreach ($fentry as $fet_plan)
{ 
    $categoryid=$fet_plan['categoryid']; $thumbnailUrl=$fet_plan['thumbnail'];
    $qryC="SELECT fullname FROM categories WHERE category_id IN ('$categoryid')";
    $cfetch=  db_select($conn,$qryC);
    $categories=$cfetch[0]['fullname'];
    if($thumbnailUrl==='NULL' ||  empty($thumbnailUrl))
    {
        $imgthumb='<img class="img-responsive customer-img" src="img/youtube_defaul.jpg"  height="20" width="90" >';
    } 
    else {
         $imgthumb='<img class="img-responsive customer-img" src="'.$thumbnailUrl.'"  height="20" width="90" >';
    }
    $id=$fet_plan['entryid']; $name=$fet_plan['name'];  $created_at=$fet_plan['created_at']; 
    $status=$fet_plan['status']; $isfeatured=$fet_plan['isfeatured']; $isPremium=$fet_plan['ispremium'];
    $starColor = $isfeatured=="1"? "#DAA520":"#C0C0C0";
    if($isPremium!='')
            {    
                $ptag=$isPremium=='1' ? "p": "f";
                $planname= ucwords($ptag); 
                $plan_title=$ptag=='p'?"Premium":"Free";
                if($ptag=='p'){$plan_title="Premium";}
                if($ptag=='f'){$plan_title="Free";}
            }
    $disableLink=''; $redyColor='label-success'; $vStatus='label-success'; $disableLink='';
        $actColor=""; $disable="";
        $in=1; $d1=0; $d2=1;   $bname1="A"; $bname2='D'; $class1="btn-success active"; $class2="btn-danger"; $disable1="disabled"; $disable2="";
        $video_status=$fet_plan['video_status'];
        if($video_status=="inactive" || $video_status=="Inactive")
        {
            $in=0; $d1=1; $d2=0;   $bname1="A"; $bname2='D'; $class2="btn-success active"; $class1="btn-danger"; 
            $actColor="#e8e8e8";   $disable1=""; $disable2="disabled"; $vStatus='label-default';  
        }   
        if($status==2) { $statusc="Ready"; }
        if($status==0) { $statusc="import"; }
        if($status==1) { $statusc="converting"; }
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
<td  style="width:10%">
    <a href="javascript:void(0)" onclick="viewyoutube('<?php echo $id; ?>','<?php echo $page; ?>','<?php echo $limit; ?>','<?php echo $searchTextMatch; ?>','<?php echo $ptag; ?>');" > 
     <?php echo $id;?>
    </a>
</td>
<td  style="width:30%"><?php echo $name;?></td>
<td  style="width:21%; font-size: 12px"><?php echo  $categories; ?></span></td>
<td  style="width:10%"><?php echo $created_at; ?></td>
<td  style="width:7%">
<button  class="btn  <?php echo $redyColor; ?> btn-xs" id="adstatus<?php echo $count; ?>" ><?php echo  $statusc; ?></button>
</td>
<td  style="width:6%" id="catgoryactStayus<?php echo $count; ?>">
   <span  class="label <?php echo $vStatus; ?> label-white middle"><?php echo  $video_status; ?></span> 
</td>
<td  style="width:6%">
<a href="javascript:void(0)" onclick="viewyoutube('<?php echo $id; ?>','<?php echo $page; ?>','<?php echo $limit; ?>','<?php echo $searchTextMatch; ?>','<?php echo $ptag; ?>');" > 
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
$pagination .= "<div class=\"pagination\">"; 
  if ($page > 1) 
   $pagination.= '<a href="javascript:void(0)" onclick="changePagination(\''.$prev.'\',\''.$limit.'\',\''.$searchKeword.'\',\''.$filtervalue.'\')"><i class="fa fa-long-arrow-left" aria-hidden="true"></i> Previous</a>';		
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
                  $pagination.= '<a href="javascript:void(0)" onclick="changePagination(\''.$counter.'\',\''.$limit.'\',\''.$searchKeword.'\',\''.$filtervalue.'\')">'.$counter.'</a>';		
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
				     $pagination.= '<a href="javascript:void(0)" onclick="changePagination(\''.$counter.'\',\''.$limit.'\',\''.$searchKeword.'\',\''.$filtervalue.'\')">'.$counter.'</a>';				
				}
				$pagination.= "...";
				$pagination.= '<a href="javascript:void(0)" onclick="changePagination(\''.$lpm1.'\',\''.$limit.'\',\''.$searchKeword.'\',\''.$filtervalue.'\')">'.$lpm1.'</a>';
				$pagination.= '<a href="javascript:void(0)" onclick="changePagination(\''.$lastpage.'\',\''.$limit.'\',\''.$searchKeword.'\',\''.$filtervalue.'\')">'.$lastpage.'</a>';	
			}
			//in middle; hide some front and some back
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				//$pagination.= "<a href=\"$targetpage?page=1\">1</a>";
				$pagination.= '<a href="javascript:void(0)" onclick="changePagination(\'1\',\''.$limit.'\',\''.$searchKeword.'\',\''.$filtervalue.'\')">1</a>';	
				//$pagination.= "<a href=\"$targetpage?page=2\">2</a>";
				$pagination.= '<a href="javascript:void(0)" onclick="changePagination(\'2\',\''.$limit.'\',\''.$searchKeword.'\',\''.$filtervalue.'\')">2</a>';
				$pagination.= "...";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
					$pagination.= '<a href="javascript:void(0)" onclick="changePagination(\''.$counter.'\',\''.$limit.'\',\''.$searchKeword.'\',\''.$filtervalue.'\')">'.$counter.'</a>';				
				}
				$pagination.= "...";
				$pagination.= '<a href="javascript:void(0)" onclick="changePagination(\''.$lpm1.'\',\''.$limit.'\',\''.$searchKeword.'\',\''.$filtervalue.'\')">'.$lpm1.'</a>';
				$pagination.= '<a href="javascript:void(0)" onclick="changePagination(\''.$lastpage.'\',\''.$searchKeword.'\',\''.$filtervalue.'\')">'.$lastpage.'</a>';	
			}
			//close to end; only hide early pages
			else
			{
				
				$pagination.= '<a href="javascript:void(0)" onclick="changePagination(\'1\',\''.$limit.'\',\''.$searchKeword.'\',\''.$filtervalue.'\')">1</a>';	
				$pagination.= '<a href="javascript:void(0)" onclick="changePagination(\'2\',\''.$limit.'\',\''.$searchKeword.'\',\''.$filtervalue.'\')">2</a>';
				$pagination.= "...";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						
						$pagination.= '<a href="javascript:void(0)" onclick="changePagination(\''.$counter.'\',\''.$limit.'\',\''.$searchKeword.'\',\''.$filtervalue.'\')">'.$counter.'</a>';					
				}
			}
		}
		
		//next button
		if ($page < $counter - 1) 
			
		    $pagination.= '<a href="javascript:void(0)" onclick="changePagination(\''.$next.'\',\''.$limit.'\',\''.$searchKeword.'\',\''.$filtervalue.'\')">Next <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>';	 
		else
			$pagination.= "<span class=\"disabled\">Next <i class='fa fa-long-arrow-right' aria-hidden='true'></i>  </span>";
		$pagination.= "</div>\n";		
	}


?>    

<div class="row row-list" style="border: 0px solid red; padding: 0px 5px 0px 5px;">
<div class="col-xs-8 pull-right"  style="border: 0px solid red; padding: 0px 0px 0px 0px; font-size: 11px;">
    <div class="pull-left">
     <?php
      if($page ==1 || $page ==0) { 
       if($total_pages==0){  $startShow=0;  } else {  $startShow=1;} 
       $lmt=$limit<$total_pages ? $limit :$total_pages;
       }
       else{
       $startShow=(($page - 1) * $limit)+1;
       $lmt=($page*$limit) >$total_pages ? $total_pages: $page * $limit;
       }
     ?>
    </div>
     
    <div class="pull-right" style="padding: 5px;">
        <span style="padding-top: 5px;float:left;margin-right: 20px;"> Showing <?php echo $startShow; ?> to <?php echo $lmt; ?>   of <strong><?php echo $total_pages; ?> </strong>entries </span>
       <?php echo $pagination;?>
    </div>   

</div>
</div> 
<script type="text/javascript">
function viewyoutube(Entryid,EntryPageindex,limitval,searchInputall,ptag)
{
   $("#flash").fadeIn(100).html('Wait <img src="img/image_process.gif" />');
   $('#myModal_youtube').modal();
   var info = 'Entryid='+Entryid+"&pageindex="+EntryPageindex+'&limitval='+ limitval+'&searchInputall='+searchInputall+'&ptag='+ptag; 
    $.ajax({
       type: "POST",
       url: "youtubeModal.php",
       data: info,
     success: function(result){
     $("#flash").hide();
     $('#show_youtube_view').html(result);
      }
    });
 return false; 

 }
function changePagination(pageid,limitval,searchtext,filterview){
     var dataString ='first_load='+pageid+'&limitval='+limitval+'&searchInputall='+searchtext+"&filtervalue="+filterview;
     $('#load').show();
     $('#results').css("opacity",0.1);
     $.ajax({
           type: "POST",
           url: "youtube_paging.php",
           data: dataString,
           cache: false,
           success: function(result){
             	$("#results").html(result);
                $('#load').hide();
		$('#results').css("opacity",1);
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
       apiBody.append("action","youtube_active");
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
       apiBody.append("action","youtube_inactive");
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
           url: "youtube_paging.php",
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
           url: "youtube_paging.php",
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
           url: "youtube_paging.php",
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
$("#searchInput").keyup(function(event) {
    if (event.keyCode === 13) {
        $("#submitBtn").click();
    }
});
</script>
