<?php
include_once 'corefunction.php';
include_once("config.php");
$searchTextMatch = (isset($_POST['searchInputall']))? $_POST['searchInputall']: "";
$pagelimit = (isset($_POST['limitval']))? $_POST['limitval']: 20;
$pager_pageIndex =(isset($_POST['first_load']))? $_POST['first_load']:0;
$filtervalue=(isset($_POST['filtervalue']))? $_POST['filtervalue']:0;
$action = (isset($_POST['maction']))? $_POST['maction']: "";
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
                  
                $result = $client->baseEntry->delete($deleteentryID);
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
    $subGenre = (isset($_POST['sub_genre']))? $_POST['sub_genre']: null;
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
    $entryId = $updateentryID;
    $baseEntry = new KalturaBaseEntry();
    $baseEntry->name = $updateentryName;
    $baseEntry->description = $updateDesc;
    $baseEntry->tags = $updateTags;
    if(!empty($updateCategoreies))
    {    
     $updateCategoreies = implode(",",$updateCategoreies);
     $baseEntry->categoriesIds = $updateCategoreies;
    }  
    if($updateCategoreies=='null')
    {
        $baseEntry->categories = '';
        $baseEntry->categoriesIds = '';
    }   
    if($updateCategoreies=='')
    {
        $baseEntry->categories = '';
        $baseEntry->categoriesIds = '';
    }   
    $updateInkaltura = $client->baseEntry->update($entryId, $baseEntry);
    $entry_id=$updateInkaltura->id;  $name=db_quote($conn,$updateInkaltura->name); $thumbnailUrl=$updateInkaltura->thumbnailUrl;
    $description=db_quote($conn,$updateInkaltura->description);
    $tags=db_quote($conn,$updateInkaltura->tags); 
    $categories=$updateInkaltura->categories; 
    $categoriesIds=$updateInkaltura->categoriesIds; 
    $updatedAt=$updateInkaltura->updatedAt;  $createdAt=$updateInkaltura->createdAt;  $creatorId=$updateInkaltura->creatorId;
    $updatedAt_convert=date("Y-m-d H:i:s", $updatedAt); $createdAt_convert=date("Y-m-d H:i:s", $createdAt);
    if($updateInkaltura!='')
    {
        $shortDesc=db_quote($conn,$shortDesc1); $producer=db_quote($conn,$producer1); $director=db_quote($conn,$director1);
        $cast=db_quote($conn,$cast1); $crew=db_quote($conn,$crew1);
        $query_check = "SELECT COUNT('$entry_id') as num FROM entry where entryid='$entry_id'";
        $totalpages =db_select($conn,$query_check);
        $totalcount = $totalpages[0]['num'];
        if($totalcount==0)
        {
        $upEntry="insert into entry(entryid,name,thumbnail,longdescription,duration
        ,type,tag,category,categoryid,status,created_at,shortdescription,director,producer,cast,crew,sub_genre,language,
        pgrating,video_status,custom_data)
        values('$entry_id',$name,'$thumbnailUrl',$description,'$duration','1',
        $tags,'$categories','$categoriesIds','2','$createdAt_convert',$shortDesc,$director,$producer,
         $cast,$crew,'$subGenre','$lang','$pgRating','$video_status','$customDataInsert')";
        }
        else{
       	$upEntry="update entry set name=$name,thumbnail='$thumbnailUrl',longdescription=$description,
        duration='$duration',type='1',tag=$tags,category='$categories',categoryid='$categoriesIds',
        updated_at='$updatedAt_convert',shortdescription=$shortDesc,
        director=$director,producer=$producer,cast=$cast,crew=$crew,sub_genre='$subGenre',
        language='$lang',pgrating='$pgRating',video_status='$video_status',custom_data='".$customDataInsert."'
        where entryid='$entry_id'";		      
        }
        $r=  db_query($conn,$upEntry);
        /*----------------------------update log file begin-------------------------------------------*/
                   $error_level=1;$msg="Updtate MetaData($entry_id)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
                   $qry=$upEntry;
                   write_log($error_level,$msg,$lusername,$qry);
        /*----------------------------update log file End---------------------------------------------*/
    } 
    // for update direct entry_count direct_entries_count direct_sub_categories_count
    if($updateInkaltura!='' && $categoriesIds!='')
     {
       $categories_IdsID=explode(",",$categoriesIds); 
       foreach ($categories_IdsID as $onlycatid) {
       /*$categoryinfo = $client->category->get($onlycatid);
       $parentId=$categoryinfo->parentId; //$fullname=$categoryinfo->fullName; $fullIds=$categoryinfo->fullIds; 
       $entries_Count=$categoryinfo->entriesCount;    $directSubCategoriesCount=$categoryinfo->directSubCategoriesCount;   
       $directEntriesCount=$categoryinfo->directEntriesCount;*/
        $kcat="SELECT id,parent_id,full_name,full_ids,entries_count,direct_sub_categories_count,
        direct_entries_count FROM kaltura.category  where status='2' and partner_id='$partnerID' and id='$onlycatid' " ;
        $categoryinfo =db_select($conn,$kcat);
        $parentId=$categoryinfo[0]['parent_id']; //$fullname=$categoryinfo[0]['full_name']; //$fullIds=$categoryinfo[0]['full_ids']; 
        $entries_Count=$categoryinfo[0]['entries_count'];
        $directSubCategoriesCount=$categoryinfo[0]['direct_sub_categories_count'];
        $directEntriesCount=$categoryinfo[0]['direct_entries_count'];
       
        $upcatinfo="update categories set entry_count='$entries_Count',direct_sub_categories_count='$directSubCategoriesCount',direct_entries_count='$directEntriesCount'
        where category_id='".$onlycatid."' "; 
        $r= db_query($conn,$upcatinfo);
        if($parentId>0){
         /*$categoryinfo = $client->category->get($parentId);
         $catidk=$categoryinfo->id; $entriesCount=$categoryinfo->entriesCount; 
         $direct_SubCategories_Count=$categoryinfo->directSubCategoriesCount;   
         */
         $kcatparent="SELECT id,entries_count,direct_sub_categories_count
         FROM kaltura.category  where status='2' and partner_id='$partnerID' and parent_id='$parentId' " ;
         $categoryinfo_parent =db_select($conn,$kcatparent);
         $catidk=$categoryinfo_parent[0]['id']; $entriesCount=$categoryinfo_parent[0]['entries_count']; 
         $direct_SubCategories_Count=$categoryinfo_parent[0]['direct_sub_categories_count']; 
         // update directSubCategoriesCount entriesCount
         $updatecatinfo="UPDATE categories set entry_count='$entriesCount',direct_sub_categories_count='$direct_SubCategories_Count' where category_id='".$catidk."'";
         $exe=db_query($conn,$updatecatinfo);
              }
         // update catgory entry priority
        $chk="select COUNT(*) as totalcount from category_entry where category_id='$onlycatid' and entryid='$updateentryID'";
        $fetchEntryCount=  db_select($conn,$chk);
        $tcount1=$fetchEntryCount[0]['totalcount'];
        if($tcount1==0)
        {
            $chk_max="select MAX(priority) AS maxapriority from category_entry where category_id='$onlycatid'";
            $fetchMaxpriority=  db_select($conn,$chk_max);
            $maxp=$fetchMaxpriority[0]['maxapriority'];
            $cpriority=1; if($maxp>0){ $cpriority=$maxp+1; }
            $qry_insert1="insert into category_entry(entryid,category_id,priority,created_at)
            values('$updateentryID','$onlycatid','$cpriority',NOW())";
            $rr=  db_query($conn, $qry_insert1);
        }    
              
       }
    }
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
     $queryupdate="update entry set ispremium='$isPremiums',type='1',status='2' where entryid='$planentryID' "; 
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
        $updateCategoreies = (isset($_POST['categories_id']))? $_POST['categories_id']: null;
        $updateCategoreie_ids=rtrim($updateCategoreies,',');
        $entryids = (isset($_POST['Entryids']))? $_POST['Entryids']: "";
        $baseEntry = new KalturaBaseEntry();
        $muldaddEntryID=explode(",",$entryids);
        $categories_IdsID_bulk=explode(",",$updateCategoreie_ids);
        
        foreach ($muldaddEntryID as $upentryid) {
         $entryId = $upentryid;
          $baseEntry->categoriesIds = $updateCategoreie_ids; 
          $result = $client->baseEntry->update($entryId, $baseEntry);
          $categories=$result->categories; $categoriesIds=$result->categoriesIds;
          $upcatinfoinentry="update entry set category='$categories', categoryid='$categoriesIds' where entryid='".$entryId."' "; 
          $r= db_query($conn,$upcatinfoinentry);   
         }
         /*----------------------------update log file begin-------------------------------------------*/    
        $error_level=1;$msg="Bulk Add Category($entryids,$updateCategoreies)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
        $qry=$upcatinfoinentry;
        write_log($error_level,$msg,$lusername,$qry);
     /*----------------------------update log file End---------------------------------------------*/
       // for update direct entry_count direct_entries_count direct_sub_categories_count 
       
       foreach ($categories_IdsID_bulk as $onlycatid) {
        /*
        K Api call;
        $categoryinfo = $client->category->get($onlycatid);
        $parentId=$categoryinfo->parentId; $fullname=$categoryinfo->fullName; $fullIds=$categoryinfo->fullIds; 
        $entries_Count=$categoryinfo->entriesCount;    $directSubCategoriesCount=$categoryinfo->directSubCategoriesCount;   
        $directEntriesCount=$categoryinfo->directEntriesCount;*/
        // K direct call
        $kcat="SELECT id,parent_id,full_name,full_ids,entries_count,direct_sub_categories_count,
        direct_entries_count FROM kaltura.category  where status='2' and partner_id='$partnerID' and id='$onlycatid' " ;
        $categoryinfo =db_select($conn,$kcat);
        $parentId=$categoryinfo[0]['parent_id']; $fullname=$categoryinfo[0]['full_name']; 
        $fullIds=$categoryinfo[0]['full_ids']; $entries_Count=$categoryinfo[0]['entries_count'];
        $directSubCategoriesCount=$categoryinfo[0]['direct_sub_categories_count'];
        $directEntriesCount=$categoryinfo[0]['direct_entries_count'];
        $upcatinfo="update categories set entry_count='$entries_Count',direct_sub_categories_count='$directSubCategoriesCount',direct_entries_count='$directEntriesCount'
        where category_id='".$onlycatid."' "; 
        $r= db_query($conn,$upcatinfo);
        if($parentId>0){
         /*$categoryinfo = $client->category->get($parentId);
         $catidk=$categoryinfo->id; $entriesCount=$categoryinfo->entriesCount; 
         $direct_SubCategories_Count=$categoryinfo->directSubCategoriesCount;   
         */
         $kcatparent="SELECT id,entries_count,direct_sub_categories_count
         FROM kaltura.category  where status='2' and partner_id='$partnerID' and parent_id='$parentId' " ;
         $categoryinfo_parent =db_select($conn,$kcatparent);
         $catidk=$categoryinfo_parent[0]['id']; $entriesCount=$categoryinfo_parent[0]['entries_count']; 
         $direct_SubCategories_Count=$categoryinfo_parent[0]['direct_sub_categories_count']; 
         // update directSubCategoriesCount entriesCount
         $updatecatinfo="UPDATE categories set entry_count='$entriesCount',direct_sub_categories_count='$direct_SubCategories_Count'
         where category_id='".$catidk."'";
         $exe=db_query($conn,$updatecatinfo);
         }
            
       }
       foreach($categories_IdsID_bulk as $catid)
            {
               foreach($muldaddEntryID as $entryidmain)
               {
                  $chk="select COUNT(*) as totalcount from category_entry where category_id='$catid' and entryid='$entryidmain'";
                  $fetchEntryCount=  db_select($conn,$chk);
                  $tcount1=$fetchEntryCount[0]['totalcount'];
                  if($tcount1==0)
                    {
                        $chk_max="select MAX(priority) AS maxapriority from category_entry where category_id='$catid'";
                        $fetchMaxpriority=  db_select($conn,$chk_max);
                        $maxp=$fetchMaxpriority[0]['maxapriority'];
                        $cpriority=1; if($maxp>0){ $cpriority=$maxp+1; }
                        $qry_insert1="insert into category_entry(entryid,category_id,priority,created_at)
                        values('$entryidmain','$catid','$cpriority',NOW())";
                        $rr=  db_query($conn, $qry_insert1);
                    }   
               }
            } 
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
$accessLevelQuery='';

if($login_access_level=='c'){
    $accessLevelQuery=" and puser_id='$get_user_id'";
}
$query_search='';

if($searchTextMatch!='')
{
    $query_search = "  and (name LIKE '%". $searchTextMatch . "%' or tag LIKE '%" . $searchTextMatch . "%' or entryid LIKE '%" . $searchTextMatch . "%' or longdescription LIKE '%" . $searchTextMatch . "%')";
} 
switch($filtervalue)
{
       case 5:
       $vsatus=" where type='1' and status!='3' and video_status='inactive' $query_search  $accessLevelQuery  ";
       $filterValueCase=" and video_status='inactive'";     
       break;
       case 2:
       $vsatus=" where type='1' and status!='3' and video_status='active' $query_search $accessLevelQuery";
        $filterValueCase=" and video_status='active'";    
       break;    
       case 0;
       $vsatus=" where type='1' and status!='3' $query_search $accessLevelQuery";
       $filterValueCase='';
       break;
}


$query = "SELECT COUNT(entryid) as totalEntry FROM entry  $vsatus  ";
$totalpages =db_select($conn,$query);
$totalEntry = $totalpages[0]['totalEntry'];
if($pager_pageIndex) 
           $start = ($pager_pageIndex - 1) * $pagelimit; 
else
      $start = 0;
$entry_query="select entryid,name,categoryid,duration,created_at,planid,ispremium,status,isfeatured,video_status,sync,downloadURL from entry  $vsatus  ORDER BY (created_at) DESC  LIMIT $start,$pagelimit";
$fetchMedia=  db_select($conn,$entry_query);
$total_pages=$totalEntry;

$act_inact="SELECT  SUM(IF (video_status='active',1,0)) AS total_active,SUM(IF (video_status='inactive',1,0)) AS
total_inactive FROM entry where status!='3' and type='1' $accessLevelQuery";
$tableAD=  db_select($conn,$act_inact);
$totalActive=$tableAD[0]['total_active']; $totalInactive=$tableAD[0]['total_inactive'];
$totalEntry=$totalActive+$totalInactive;
$total_active_disabled=$totalActive==0?'disabled':'';
$total_inactive_disabled=$totalInactive==0?'disabled':'';
?>
<div class="box-header" >
    <div class="row table-responsive" style="border: 0px solid red; margin-top:-15px;">
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
  <td width="22%" align="center">
        View:<select name="filterentry"  id="filterentry" onchange="filterView('<?php echo $pager_pageIndex;  ?>','<?php echo $pagelimit; ?>','<?php echo $searchTextMatch;?>');" style="text-transform: uppercase !important;">
        <option value="0" <?php  echo $filtervalue=='0'?"selected":''; ?>>ALL</option>
        <option value="2" <?php echo $total_active_disabled; echo $filtervalue=='2'?"selected":''; ?>>ACTIVE</option>
        <option value="5" <?php echo $total_inactive_disabled; echo $filtervalue=='5'?"selected":''; ?>>INACTIVE</option>
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
       <input class="form-control" size="30" onkeyup="SeachDataTable('media_paging.php','<?php echo $pagelimit;?>','<?php echo $pager_pageIndex ;?>','load','<?php echo $filtervalue; ?>')"  placeholder="Search Entries by tagName,searchtag"  autocomplete="off" name='searchQuery' id='searchInput' class="searchInput" type="text" value="<?php echo $searchTextMatch; ?>">
       <div class="input-group-btn">
       <button class="enableOnInput btn btn-default" onclick="SearchDataTableValue('media_paging.php','<?php echo $pagelimit;?>','<?php echo $pager_pageIndex ?>','load','<?php echo $filtervalue; ?>')" disabled='disabled' id='submitBtn' type="button" style="height: 30px;   padding: 4px 6px !important;" ><i class="glyphicon glyphicon-search"></i></button>	
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
        <!--<th  width="6%"></th>-->
        <th  style="width:8%">Thumbnail</th> 
        <th  style="width:8%">ID</th>
        <th  style="width:20%">Name</th>
        <?php  if(in_array(5, $otherPermission)){ ?><th  style="width:4%">Plan</th> <?php } ?>
        <th  style="width:25%">Categories</th>
        <th  style="width:10%">Created-On</th>
        <th  style="width:6%">Duration</th>
        <th  style="width:7%" title="Upload Status">U-Status</th>
        <th  style="width:6%" title="Video Status">V-Status<input  type="hidden" id="settbodyHeight" size="3"></th>
        <th  style="width:6%" >Action 
            <span style="background: #fff;position: absolute; height: 34px;margin-top:-5px; width:20px;  right: 0;  " >
            </span>
        </th>
       </tr>    
    </thead>
<tbody style="overflow-y: scroll;display: block;" id="tbodyHeight">
<?php
$count=1;
$filter = new KalturaMediaEntryFilter();
foreach($fetchMedia as $entry_media) {
        $id=$entry_media['entryid']; 
        $statusDB=$entry_media['status'];
        // kaltura entry table
        $kquery="select id,status,thumbnail,categories,length_in_msecs,subp_id from kaltura.entry where id='$id' and partner_id='$partnerID'";
        $fetchKaltura =db_select($conn,$kquery);
        $totalEntryKaltura = db_totalRow($conn,$kquery);
        $name=$entry_media['name']; $categoryid=$entry_media['categoryid']; 
        $duration=$entry_media['duration']; $createdAt=$entry_media['created_at'];
        $planid = $entry_media['planid']; $isPremium=$entry_media['ispremium'];
        $isfeatured = $entry_media['isfeatured']=="1"? "#DAA520":"#C0C0C0";
        $planname="NA"; $plan_title="Plan Not Added"; $ptag=''; 
        if($isPremium!='')
            {    
                $ptag=$isPremium=='1' ? "p": "f";
                $planname= ucwords($ptag); 
                $plan_title=$ptag=='p'?"Premium":"Free";
                if($ptag=='p'){$plan_title="Premium";}
                if($ptag=='f'){$plan_title="Free";}
            }
        $sync=$entry_media['sync'];
        $starColor=$isfeatured; $disableLink=''; $redyColor='label-success'; $vStatus='label-success'; $disableLink='';
        $actColor=""; $disable="";
        $in=1; $d1=0; $d2=1;   $bname1="A"; $bname2='D'; $class1="btn-success active"; $class2="btn-danger"; $disable1="disabled"; $disable2="";
        $video_status=$entry_media['video_status'];
        if($video_status=="inactive" || $video_status=="Inactive")
        {
            $in=0; $d1=1; $d2=0;   $bname1="A"; $bname2='D'; $class2="btn-success active"; $class1="btn-danger"; 
            $actColor="#e8e8e8";   $disable1=""; $disable2="disabled"; $vStatus='label-default';  
        }   
        if($totalEntryKaltura==1)
        {    
           $status=$fetchKaltura[0]['status']; 
           $thumbnailimg=$fetchKaltura[0]['thumbnail'];
           $duration_k=$fetchKaltura[0]['length_in_msecs'];
           $subp_id=$fetchKaltura[0]['subp_id'];
           //str(serviceUrl) + '/p/' + str(partnerid) + '/sp/' + str(subpid) + '/thumbnail/entry_id/' + str(entryid) + '/version/' + str(thumbnail_id)
           $thumbnailUrl=$serviceURL.'/p/'.$partnerID.'/sp/'.$subp_id.'/thumbnail/entry_id/'.$id.'/version/'.$thumbnailimg;
           $tumnail_height_width="/width/90/height/60"; 
           $categories=$fetchKaltura[0]['categories'];
           if($statusDB==1 && $status==2)
            { 
               $duration_in_second= ceil($duration_k/1000);
               $up="update entry set status='2',duration='$duration_in_second' where status='1' and entryid='$id'"; db_query($conn,$up); }
            }
           else
           {
           $statusc='NA';  $categories=''; $disable1="disabled"; $disable2="disabled"; 
           $disableLink='not-active-href';
           $tumnail_height_width=""; $thumbnailUrl='';
           }
           $downloadURL=$entry_media['downloadURL'];
           if($video_status=="inactive" && ($downloadURL=='' || $downloadURL===false))
            { 
              $statusc='inProgress'; $redyColor='label-warning';
              $disableLink='not-active-href'; $disable2="disabled"; $disable1="disabled";
            }
           else{ 
           if($status=='-1') { $statusc="error_converting"; }
           if($status=='-2') { $statusc="error_importing"; }
           if($status==2) { $statusc="Ready"; }
           if($status==0) { $statusc="import"; }
           if($status==1) { $statusc="converting"; }
           if($status==2) { $statusc="Ready"; }
            }
           
        
?>
<tr id="<?php echo $count."_r"; ?>" style="font-size: 12px; background:<?php echo $actColor; ?>">
<td  style="width:1%" > 
<input type="checkbox" class="checkBoxClass" name="Entrycheck[]" value="<?php echo $id; ?>">
<p><?php //echo $count; ?></p>
<!--<p><i class="fa fa-plus"  aria-hidden="true" title="More Detail"></i></p>-->
</td>
<td style="width:8%">
 <img class="img-responsive customer-img"  src="<?php echo $thumbnailUrl.$tumnail_height_width; ?>" alt="" />
 <a href="javascript:void(0);" class="<?php echo $disableLink; ?>"  title="Recommended video" onclick="return addFeaturedVideo('<?php echo $id; ?>','<?php echo $count;  ?>')" >
<span class="glyphicon glyphicon-star" style="color:<?php echo $starColor; ?>; padding-right: 23px; padding-top: 7px; position: relative;" id="starfeatured<?php echo $count; ?>"></span></a>
<?php  if(in_array(2, $UserRight)){ ?>
<div class="btn-group btn-toggle " style=" position: relative;"> 
    <button id="<?php echo $count."_a"; ?>" <?php echo $disable1; ?>  class="btn btn-xs <?php echo $class1; ?>" onclick="vodActDeact1('<?php echo $d1; ?>','<?php echo $id; ?>','<?php echo $count;  ?>')"><?php echo $bname1; ?></button>
    <button id="<?php echo $count."_d"; ?>" <?php echo $disable2; ?> class="btn btn-xs <?php echo $class2; ?>"  onclick="vodActDeact2('<?php echo $d2; ?>','<?php echo $id; ?>','<?php echo $count;  ?>')"><?php echo $bname2; ?></button>
</div>
<?php } else { ?> 
 <div class="btn-group btn-toggle"> 
    <button id="<?php echo $count."_a"; ?>" disabled class="btn btn-xs <?php echo $class1; ?>"><?php echo $bname1; ?></button>
    <button id="<?php echo $count."_d"; ?>" disabled class="btn btn-xs <?php echo $class2; ?>" ><?php echo $bname2; ?></button>
</div>   
<?php } ?>    
</td> 
<td  style="width:8%">
    <a style="cursor: pointer;" class="<?php echo $disableLink; ?>" onclick="viewVodDetail('<?php echo $pager_pageIndex; ?>','<?php echo $id; ?>','<?php echo $ptag;?>','<?php echo $pagelimit;?>','<?php echo $searchTextMatch; ?>');" >
 <?php echo $id;?></a>

</td>
<td  style="width:20%"  title="<?php echo $name;  ?>">
<?php  echo wordwrap($name,20, "\n", true);?>
</td>
<?php if(in_array(5, $otherPermission)){ ?><td style="width:4%" title="<?php echo $plan_title; ?>"><?php echo $planname; ?></td><?php } ?>
<td  style="width:25%; font-size: 11px; word-break: break-all"  title="<?php echo wordwrap($categories,41, "\n", true);?>">
<?php  echo wordwrap($categories,41, "\n", true); ?>
</td>
<td  style="width:10%"><?php echo date("d/m/y H:i:s", strtotime($createdAt)); ?></td>
<td  style="width:6%"><?php echo gmdate("H:i:s", $duration);?></td>
<td  style="width:7%">
<!--<button  class="btn  <?php echo $redyColor; ?> btn-xs" ><?php echo  $statusc; ?></button>-->
<span class="label <?php echo $redyColor; ?> label-white middle"><?php echo  $statusc; ?></span>
</td>
<td  style="width:6%" id="catgoryactStayus<?php echo $count; ?>">
   <span  class="label <?php echo $vStatus; ?> label-white middle"><?php echo  $video_status; ?></span> 
</td>
<td  style="width:6%">
<a style="cursor: pointer;" class="<?php echo $disableLink; ?>" onclick="viewVodDetail('<?php echo $pager_pageIndex; ?>','<?php echo $id; ?>','<?php echo $ptag;?>','<?php echo $pagelimit;?>','<?php echo $searchTextMatch; ?>');" > 
<i class="fa fa-eye" aria-hidden="true"  data-placement="left"  title="View Details" style="padding-right: 8px  !important;"></i>
</a>
<?php  if(in_array(4, $UserRight)){ ?>
<a href="javascript:void(0)" onclick="return deleteContent('<?php echo $id; ?>','deletecontent','<?php echo $pager_pageIndex; ?>','<?php echo $pagelimit;?>')"><i class="fa fa-trash-o" aria-hidden="true" title="Delete"></i></a>
<?php }?>
</td>
</tr>   
<?php
     $count++;
}
include_once 'ksession_close.php';
?>         
</tbody>
</table>
</div>        
</form>  
<?php
/* paging code............*/

//$pager_pageIndex."---".$total_pages;
if($pager_pageIndex==0){ $pager_pageIndex=1; }
$prev = $pager_pageIndex - 1;	//previous page is page - 1
$next = $pager_pageIndex + 1;
$limit=$pagelimit;	//next page is page + 1
$lastpage = ceil($total_pages/$limit);
//$adjacents=$limit==10?1:3;
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
<div class="col-xs-1" style="padding-top: 10px; font-size: 11px;    padding-right: 0 !important;">
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
</div>
   
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
<script type="text/javascript">
/* this is for model JS with edit and view detail */
function viewVodDetail(EntryPageindex,Entryid,ptag,limitval,searchtext)
{
    $("#flash").fadeIn(100).html('Wait <img src="img/image_process.gif" />');
    $("#show_detail_model_view").html();
    $('#myModalVodEdit').modal();
    var info = 'Entryid='+Entryid+"&pageindex="+EntryPageindex+"&ptag="+ptag+'&limitval='+ limitval+"&searchInputall="+searchtext; 
        $.ajax({
            type: "POST",
            url: "entryModal.php",
            data: info,
          success: function(result){
          $("#flash").hide();
          $('#show_detail_model_view').html(result);
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
           url: "media_paging.php",
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
  
      var dataString ='entryID='+ entryID +"&maction="+delname+"&pageindex="+pageindex+'&limitval='+ limitval;
      var a=confirm("Are you sure you want to delete the selected entry ? " + entryID +  "\nPlease note: the entry will be permanently deleted from your account");
	     if(a==true)
	     {
	        $('#load').show();
                $('#results').css("opacity",0.1);
	        $.ajax({
	           type: "POST",
	           url: "media_paging.php",
	           data: dataString,
	           cache: false,
	           success: function(result){
	                 if(result==3)
                         {
                             alert("can not deleted,this entryID ? " + entryID +" is still active in Slider Image.");
                             $('#load').hide();
                             $('#results').css("opacity",1);
                             return false;
                         }    
	           	 $("#results").html('');
	           	 $("#flash").hide();
	           	 $("#results").html(result);
                         $('#load').hide();
                         $('#results').css("opacity",1);
	           }
	         });
	     }
	     else
	     {
	     	 $('#load').hide();
                 $('#results').css("opacity",1);
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
   
function bulkactive(pageindex,limitval,tag)
{
    $("#ckbCheckAll").click(function () {
      $(".checkBoxClass").prop('checked', $(this).prop('checked'));
    }); 
     var finald = '';
     $('.checkBoxClass:checked').each(function(){        
         var values = $(this).val();
         finald += values+',';
     });
       if(finald=='')
      { alert("You must select at least one entry"); return false;} 
      
        $('#load').show();
        $('#results').css("opacity",0.1);
        var entryid=finald.slice(0, -1);
        var apiBody = new FormData();
        apiBody.append("action","vod_bulk_active_inactive");
        apiBody.append("entryid",entryid);
        apiBody.append("tag",tag);
        $.ajax({
                url:'core_active_deactive.php',
                method: 'POST',
                data:apiBody,
                processData: false,
                contentType: false,
                    success: function(jsonResult){
                     console.log(jsonResult);
                     $('#load').show();
                    $('#results').css("opacity",0.1);
                    if(jsonResult==1 || jsonResult==0){
                    $( "#results" ).load( "media_paging.php", { pageindex:pageindex,limitval:limitval,maction:'only_page_limitval' }, function(r) {
                    $( "#results" ).html(r);
                    var msg=jsonResult==1? "Bulk Video Active Successfully":"Bulk Video Inactive Successfully"
                    $("#msg").html(msg);
                    $('#load').hide();
                    $('#results').css("opacity",1);
                    });
                    }
               }
            }); 
    
}

function delete_bulk(pageindex,limitval)
{
    $("#ckbCheckAll").click(function () {
      $(".checkBoxClass").prop('checked', $(this).prop('checked'));
    }); 
     var finald = '';
     $('.checkBoxClass:checked').each(function(){        
         var values = $(this).val();
         finald += values+',';
     });
       if(finald=='')
      { alert("You must select at least one entry"); return false;}
      
        var entryid=finald.slice(0, -1);
        var multidelete="bulk_delete";
        var dataString ='entryIDs='+entryid +"&action="+multidelete;
         var a=confirm("Are You sure want to delete This Entries ? " +entryid+"\nPlease note: the entry will be permanently deleted from your account");
         if(a==true)
                {  
                   $('#load').show();
                   $('#results').css("opacity",0.1); 
                   $.ajax({   
                       type: "POST",
                       url: "coreData.php",
                       data: dataString,
                       cache: false,
                       success: function(result){
                          
                           if(result!=1)
                           {
                               alert("can not deleted,this entryids ? " + result.trim() +" is still active in Slider Image.");
                           }    
                           $('#results').load("media_paging.php",{'pageindex':pageindex,'limitval':limitval,'maction':"multidelete"},
                           function(r) {
                            $("#msg").html('Entry deleted successfully.');
                            $("#flash").hide();
                            //$("#results").html(result);
                            $('#load').hide();
                            $('#results').css("opacity",1);
                          });      
                          
                     }
                  }); 
              } else  {   $("#flash").hide(); return false;  } 
    
}


function planbulk(pageindex,limitval)
{
    $("#ckbCheckAll").click(function () {
      $(".checkBoxClass").prop('checked', $(this).prop('checked'));
    }); 
     var finald = '';
     $('.checkBoxClass:checked').each(function(){        
         var values = $(this).val();
         finald += values+',';
     });
       if(finald=='')
      { alert("You must select at least one entry"); return false;}
      var entryid=finald.slice(0, -1);
      $("#flash").show();
      $("#flash").fadeIn(800).html('Wait For.. <img src="img/image_process.gif" />');
      $("#myModal_bulk").modal();
      var apiBody = new FormData();
      apiBody.append("Entryids",entryid);
      apiBody.append("pageindex",pageindex);
      apiBody.append("limitval",limitval);
        $.ajax({
                url:'bulk_plan_edit_model.php',
                method: 'POST',
                data:apiBody,
                processData: false,
                contentType: false,
                    success: function(jsonResult){
                     $("#flash").hide();
                     $('#bulk_plan_edit_model').html(jsonResult);
                     
                    }
            }); 
      return false;
    
}
function bulkAddContentPartner(pageindex,limitval)  
{
    $("#ckbCheckAll").click(function () {
      $(".checkBoxClass").prop('checked', $(this).prop('checked'));
    }); 
     var finald = '';
     $('.checkBoxClass:checked').each(function(){        
         var values = $(this).val();
         finald += values+',';
     });
       if(finald=='')
      { alert("You must select at least one entry"); return false;}
      var entryid=finald.slice(0, -1);
      $("#flash").show();
      $("#flash").fadeIn(800).html('Wait For.. <img src="img/image_process.gif" />');
      $("#myModal_bulkContentPartner").modal();
      var apiBody = new FormData();
      apiBody.append("Entryids",entryid);
      apiBody.append("pageindex",pageindex);
      apiBody.append("limitval",limitval);
      apiBody.append("action","bulkAddContentPartner");
        $.ajax({
                url:'bulk_add_template.php',
                method: 'POST',
                data:apiBody,
                processData: false,
                contentType: false,
                    success: function(jsonResult){
                     $("#flash").hide();
                     $('#show_bulkContentPartner').html(jsonResult);
                     
                    }
            }); 
      return false;
    
}

function bulkAddContentViewer(pageindex,limitval)  
{
    $("#ckbCheckAll").click(function () {
      $(".checkBoxClass").prop('checked', $(this).prop('checked'));
    }); 
     var finald = '';
     $('.checkBoxClass:checked').each(function(){        
         var values = $(this).val();
         finald += values+',';
     });
       if(finald=='')
      { alert("You must select at least one entry"); return false;}
      var entryid=finald.slice(0, -1);
      $("#flash").show();
      $("#flash").fadeIn(800).html('Wait For.. <img src="img/image_process.gif" />');
      $("#myModal_bulkContentViewer").modal();
      var apiBody = new FormData();
      apiBody.append("Entryids",entryid);
      apiBody.append("pageindex",pageindex);
      apiBody.append("limitval",limitval);
      apiBody.append("action","contentViewerRating");
        $.ajax({
                url:'bulk_add_template.php',
                method: 'POST',
                data:apiBody,
                processData: false,
                contentType: false,
                    success: function(jsonResult){
                     $("#flash").hide();
                     $('#show_bulkContentViewer').html(jsonResult);
                     
                    }
            }); 
      return false;
    
}

function bulkAgeRestriction(pageindex,limitval)  
{
    $("#ckbCheckAll").click(function () {
      $(".checkBoxClass").prop('checked', $(this).prop('checked'));
    }); 
     var finald = '';
     $('.checkBoxClass:checked').each(function(){        
         var values = $(this).val();
         finald += values+',';
     });
       if(finald=='')
      { alert("You must select at least one entry"); return false;}
      var entryid=finald.slice(0, -1);
      $("#flash").show();
      $("#flash").fadeIn(800).html('Wait For.. <img src="img/image_process.gif" />');
      $("#myModal_bulkContentViewer").modal();
      var apiBody = new FormData();
      apiBody.append("Entryids",entryid);
      apiBody.append("pageindex",pageindex);
      apiBody.append("limitval",limitval);
      apiBody.append("action","AgeRestriction");
        $.ajax({
                url:'bulk_add_template.php',
                method: 'POST',
                data:apiBody,
                processData: false,
                contentType: false,
                    success: function(jsonResult){
                     $("#flash").hide();
                     $('#show_bulkContentViewer').html(jsonResult);
                     
                    }
            }); 
      return false;
    
}

$(document).ready(function(){ 
$("#ckbCheckAll").click(function () {
    $(".checkBoxClass").prop('checked', $(this).prop('checked'));
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
           url: "media_paging.php",
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


/* code for add to bulk Category */
function add_to_bulk_category(pageindex,limitval)
{
    var finald = '';
    $('.checkBoxClass:checked').each(function(){        
        var values = $(this).val();
        finald += values+',';
    });
   if(finald=='')
   { alert("You must select at least one entry"); return false;}	
    $("#myModal_add_to_category").modal();
    $("#flash").fadeIn(400).html('Wait <img src="img/image_process.gif" />');
        var Entryids = finald;
        var info = 'Entryids=' + Entryids+"&pageindex="+pageindex+'&limitval='+limitval+"&cat_add_remove=cat_add";
        $.ajax({
	   type: "POST",
	   url: "add_category_media_paging.php",
	   data: info,
          success: function(result){
           $('#show_add_to_category').html(result);  
           $("#flash").hide();
           //return false;
          }
 
        });
     return false;    
}

function filterView(pageindex,limitval,searchtext)
{
    var filtervalue = $('#filterentry').val();
    $('#load').show();
    $('#results').css("opacity",0.1);
     var apiBody = new FormData();
     apiBody.append("filtervalue",filtervalue);
     apiBody.append("pageindex",pageindex);
     apiBody.append("limitval",limitval);
     apiBody.append("searchInputall",searchtext);
     apiBody.append("maction","filterview");
      $.ajax({
           type: "POST",
           url: "media_paging.php",
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
           url: "media_paging.php",
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

