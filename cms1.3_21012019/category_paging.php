<?php
include_once 'corefunction.php';
$searchTextMatch = (isset($_POST['searchInputall']))? $_POST['searchInputall']: "";
$pagelimit = (isset($_POST['limitval']))? $_POST['limitval']:50;
$page=(isset($_POST['pageNum']))? $_POST['pageNum']:1;
$get_refresh = (isset($_POST['refresh']))? $_POST['refresh']: "";
include_once 'function.php';
include_once("config.php");
$action = (isset($_POST['categoryaction'])) ? $_POST['categoryaction']: "";
switch($action)
{
case "checkSubcategory":
    $category_ID=(isset($_POST['category_ID']))? $_POST['category_ID']: "";
    $qrycheck="Select entry_count  from categories where category_id='$category_ID'";
    $fetchSub= db_select($conn,$qrycheck);
    $getentry_count = $fetchSub[0]['entry_count'];
    if($getentry_count>0){  echo 1; }
    else{ echo 0; }
    exit;
break;
case "add_category":
$category = new KalturaCategory();
$category_ID	 = (isset($_POST['category_ID']))? $_POST['category_ID']: "";
$cat_name	 = (isset($_POST['cat_name']))? $_POST['cat_name']: "";
$cat_description = (isset($_POST['cat_description']))? $_POST['cat_description']: null;
$cat_tags	 = (isset($_POST['cat_tags']))? $_POST['cat_tags']: null;
$host_url_t	 = (isset($_POST['host_url_t']))? $_POST['host_url_t']: null;
$imgUrls_t	 = (isset($_POST['imgUrls_t']))? $_POST['imgUrls_t']: null;
$host_url_i	 = (isset($_POST['host_url_i']))? $_POST['host_url_i']: null;
$imgUrls_i	 = (isset($_POST['imgUrls_i']))? $_POST['imgUrls_i']: null;

//$insert="insert into categories(category_id,partner_id,cat_name,priority)
//Select '$category_ID','$partnerID','$cat_name',ifnull(max(priority),0)+1 from categories";
//$exe=db_query($insert);
$category->parentId = $category_ID;
$category->name = $cat_name;
$category->description = $cat_description;
$category->tags = $cat_tags;
$result_add = $client->category->add($category);
if(!empty($result_add))
{
$CatID=$result_add->id; $parentId=$result_add->parentId; $partnerID=PARTNER_ID;
$depth=$result_add->depth; $catname=$result_add->name;

$cfullName=$result_add->fullName; $fullIds=$result_add->fullIds;
$entriesCount=$result_add->entriesCount;
$createdAt=$result_add->createdAt; $updatedAt=$result_add->updatedAt;
//$cdescription=$result_add->description;
//$ctags=$result_add->tags;
$cdescription=db_quote($conn,$result_add->description);
$ctags=db_quote($conn,$result_add->tags);
$directEntriesCount=$result_add->directEntriesCount;
$directSubCategoriesCount=$result_add->directSubCategoriesCount;
//insert record in our category table.
$insert="insert into categories(category_id,parent_id,dept,partner_id,cat_name,fullname,fullids,entry_count,direct_sub_categories_count,description,tags,created_at,updated_at,duser_id,priority,direct_entries_count)
Select '$CatID','$parentId','$depth','$partnerID','$catname','$cfullName','$fullIds','$entriesCount','$directSubCategoriesCount',$cdescription,$ctags,NOW(),Now(),'$get_user_id',ifnull(max(priority),0)+1,'$directEntriesCount' from categories";
$exe=db_query($conn,$insert);
if($exe)
{
    if($parentId>0){
    $categoryinfo = $client->category->get($parentId);
    $catidk=$categoryinfo->id; $entriesCount=$categoryinfo->entriesCount; $direct_SubCategories_Count=$categoryinfo->directSubCategoriesCount;
    // update directSubCategoriesCount entriesCount
    $updatecatinfo="UPDATE categories set entry_count='$entriesCount',direct_sub_categories_count='$direct_SubCategories_Count' where category_id='".$catidk."'";
    $exe=db_query($conn,$updatecatinfo);
    /*----------------------------update log file begin-------------------------------------------*/
         $error_level=1;$msg="Create New Category($catname)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
         $qry=$insert;
         write_log($error_level,$msg,$lusername,$qry);
      /*----------------------------update log file End---------------------------------------------*/
    }
}
else
{
/*----------------------------update log file begin-------------------------------------------*/
     $error_level=5;$msg="Create New Category($catname)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
     $qry=$insert;
     write_log($error_level,$msg,$lusername,$qry);
  /*----------------------------update log file End---------------------------------------------*/
}

$t_original_url='';$t_small_url=''; $t_mediam_url=''; $t_large_url=''; $t_custom_url='';
if($host_url_t!='' && $imgUrls_t!='')
{
$que_del=  explode(",", $imgUrls_t);
$t_original_url=$que_del[0];  $t_small_url=$que_del[1]; $t_mediam_url=$que_del[2];
$t_large_url=$que_del[3]; $t_custom_url=$que_del[4];
}
$i_original_url=''; $i_small_url=''; $i_mediam_url='';  $i_large_url=''; $i_custom_url='';
if($host_url_i!='' && $imgUrls_i!='')
{
$f_i=  explode(",", $imgUrls_i);
$i_original_url=$f_i[0]; $i_small_url=$f_i[1];
$i_mediam_url=$f_i[2];  $i_large_url=$f_i[3]; $i_custom_url=$f_i[4];
}
$upp="insert into category_thumb_icon_url(category_id,host_url_thumb,host_url_icon,t_original_url,t_small_url,t_mediam_url,t_large_url,t_custom_url,i_original_url,i_small_url,i_mediam_url,i_large_url,i_custom_url,created_at,updated_at)
values('$CatID','$host_url_t','$host_url_i','$t_original_url','$t_small_url','$t_mediam_url','$t_large_url','$t_custom_url','$i_original_url','$i_small_url','$i_mediam_url','$i_large_url','$i_custom_url',NOW(),NOW())";
db_query($conn,$upp);
}
break;
/***** following Case doing  single delete  ***/
case "deletecontent":
    $deleteentryID = (isset($_POST['entryID']))? $_POST['entryID']: "";
    $parent_id = (isset($_POST['parent_id']))? $_POST['parent_id']: "";
    $priorityParent = (isset($_POST['priority_parent']))? $_POST['priority_parent']: "";
    $moveEntriesToParentCategory = KalturaNullableBoolean::NULL_VALUE;
    //$moveEntriesToParentCategory = null;
    $result = $client->category->delete($deleteentryID,$moveEntriesToParentCategory);
    //$delete1 = "DELETE FROM categories where category_id='$deleteentryID'";
    $delete1 = "update categories set status='3',priority='0' where category_id='$deleteentryID'";
    $dc=db_query($conn,$delete1);
    $qheaderMenu = "update header_menu set header_status='3' where category_id='$deleteentryID'";
    $dc=db_query($conn,$qheaderMenu);
    if($dc)
    {
     // this category id remove from entry table in categoryid column
     $updateeEntryTable="update entry set categoryid=TRIM(BOTH ',' FROM REPLACE(CONCAT(',',categoryid,',') , ',$deleteentryID,', ',')) where FIND_IN_SET($deleteentryID,categoryid)";
     $uEntry=db_query($conn,$updateeEntryTable);
     /*----------------------------update log file begin-------------------------------------------*/
     $error_level=1;$msg="delete Category($deleteentryID)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
     $qry=$delete1;
     write_log($error_level,$msg,$lusername,$qry);
  /*----------------------------update log file End---------------------------------------------*/
    }
    else
    {
        /*----------------------------update log file begin-------------------------------------------*/
     $error_level=5;$msg="delete Category($deleteentryID)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
     $qry=$delete1;
     write_log($error_level,$msg,$lusername,$qry);
  /*----------------------------update log file End---------------------------------------------*/
    }
    //$delete2 = "DELETE FROM category_thumb_icon_url where category_id='$deleteentryID'";
    //$dcu=db_query($conn,$delete2);
    if($parent_id>0){
    $categoryinfo = $client->category->get($parent_id);
    $catidk=$categoryinfo->id; $entriesCount=$categoryinfo->entriesCount; $direct_SubCategories_Count=$categoryinfo->directSubCategoriesCount;
    // update directSubCategoriesCount entriesCount
    $updatecatinfo="UPDATE categories set entry_count='$entriesCount',direct_sub_categories_count='$direct_SubCategories_Count' where category_id='".$catidk."'";
    $exe=db_query($conn,$updatecatinfo);
    }
    $uppriority="update categories set priority=priority-1 where priority>$priorityParent";
    db_query($conn,$uppriority);
    //$pageindex_when_delete = (isset($_POST['pageindex']))? $_POST['pageindex']: "";
    //$pager->pageIndex=$pageindex_when_delete;
break;
/***** following Case doing  delete all category with subcategory  ***/
case "delete_with_sub_category":
   function categoryChildDelete($categoryid,$parentid) {
    global $conn;
    $sqry = "SELECT category_id,priority FROM categories WHERE parent_id = '$categoryid' and status!='3'";
    $totalRowC=  db_totalRow($conn,$sqry);
    $children = array();
        if($totalRowC > 0) {
            $fetchCat=  db_select($conn,$sqry);
            foreach($fetchCat as $row){
             $priority=$row['priority']; $category_id=$row['category_id'];
             $delete1 = "update categories set status='3' where category_id='".$category_id."' ";
             $dc=db_query($conn,$delete1);
             $qheaderMenu = "update header_menu set header_status='3' where category_id='$category_id'";
             $dc=db_query($conn,$qheaderMenu);
             $updateeEntryTable="update entry set categoryid=TRIM(BOTH ',' FROM REPLACE(CONCAT(',',categoryid,',') , ',$category_id,', ',')) where FIND_IN_SET($category_id,categoryid)";
             $uEntry=db_query($conn,$updateeEntryTable);
             $uppriority="update categories set priority=priority-1 where priority>$priority";
             db_query($conn,$uppriority);
             $children[$row['category_id']] = categoryChildDelete($category_id,$parentid);
            }
        }
    //return $children;
    }
    $delcategoryid = (isset($_POST['entryID']))? $_POST['entryID']: "";
    $parent_id = (isset($_POST['parent_id']))? $_POST['parent_id']: "";
    $priorityParent = (isset($_POST['priority_parent']))? $_POST['priority_parent']: "";
    $qry="select category_id,parent_id,priority from categories where parent_id='".$delcategoryid."' order by priority";
    $fcid=  db_select($conn,$qry);
    categoryChildDelete($delcategoryid,$parentid);
    $deletem = "update categories set status='3',priority='0' where category_id='$delcategoryid'";
    $dc=db_query($conn,$deletem);
    $qheaderMenu = "update header_menu set header_status='3' where category_id='$delcategoryid'";
    $dc=db_query($conn,$qheaderMenu);
    // this category id remove from entry table in categoryid column
    $updateeEntryTable="update entry set categoryid=TRIM(BOTH ',' FROM REPLACE(CONCAT(',',categoryid,',') , ',$delcategoryid,', ',')) where FIND_IN_SET($delcategoryid,categoryid)";
    $uEntry=db_query($conn,$updateeEntryTable);

     /*----------------------------update log file begin-------------------------------------------*/
     $error_level=1;$msg="delete Category($delcategoryid)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
     $qry=$delete1;
     write_log($error_level,$msg,$lusername,$qry);
   /*----------------------------update log file End---------------------------------------------*/
    $uppriority="update categories set priority=priority-1 where priority>$priorityParent";
    db_query($conn,$uppriority);
    $moveEntriesToParentCategory = KalturaNullableBoolean::NULL_VALUE;
    $result = $client->category->delete($delcategoryid, $moveEntriesToParentCategory);
break;
case "save_edit_category":
         $category_ID = (isset($_POST['catid']))? $_POST['catid']: "";
         $pageindex_when_edit = (isset($_POST['pageindex']))? $_POST['pageindex']: "";
         $cat_name = htmlspecialchars ((isset($_POST['entryname'])) ? $_POST['entryname']: '');
         $cat_description = (isset($_POST['entrydesc']))? $_POST['entrydesc']: '';
         $cat_tags = (isset($_POST['entrytags']))? $_POST['entrytags']: '';
         $id = $category_ID;
         $category = new KalturaCategory();
         $category->name = $cat_name;
         $category->description = $cat_description;
         $category->tags = $cat_tags;
         $result_update = $client->category->update($id, $category);
         if($result_update!='')
         {
         $c_name=$result_update->name;
         $c_description=db_quote($conn,$result_update->description);
         $c_tags=db_quote($conn,$result_update->tags);
         //$c_tags=$result_update->tags;
         $c_fullName=$result_update->fullName;
         $query="select COUNT($category_ID) AS entryFound from categories where  category_id='$category_ID' OR parent_id='$category_ID'";
         $getData= db_select($conn,$query);
         $entryFound = $getData[0]['entryFound'];
         if($entryFound==1)
         {
             echo $upc="update categories set cat_name='$c_name',description=$c_description,tags=$c_tags,fullname='$c_fullName' where category_id='$category_ID'";
             $uc=db_query($conn,$upc);
              if($uc)
                {
                   /*----------------------------update log file begin-------------------------------------------*/
                   $error_level=1;$msg="Update Category($c_name)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
                   $qry=$upc;
                   write_log($error_level,$msg,$lusername,$qry);
                   /*----------------------------update log file End---------------------------------------------*/
                }
                else
                {
                     /*----------------------------update log file begin-------------------------------------------*/
                   $error_level=5;$msg="Update Category($c_name)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
                   $qry=$upc;
                   write_log($error_level,$msg,$lusername,$qry);
                   /*----------------------------update log file End---------------------------------------------*/
                }
         }
         if($entryFound>1)
         {
              $queryP="select parent_id,cat_name from categories where category_id='$category_ID'";
              $getDataP=  db_select($conn,$queryP);
              $parent_id = $getDataP[0]['parent_id']; $cat_name_old = $getDataP[0]['cat_name'];
              if($parent_id==0)
              {
                 $needle='>';
                 $update1="UPDATE categories set fullname=REPLACE(fullname,'$cat_name_old$needle','$c_name$needle')";
                 db_query($conn,$update1);
                 $upc1="update categories set cat_name='$c_name',description=$c_description,tags=$c_tags,fullname='$c_fullName' where category_id='$category_ID'";
                 db_query($conn,$upc1);
              }
              if($parent_id>0)
              {
                 $needle='>';
                 $update2="UPDATE categories set fullname=REPLACE(fullname,'$needle$cat_name_old','$needle$c_name')";
                 db_query($conn,$update2);
                 $upc2="update categories set cat_name='$c_name',description=$c_description,tags=$c_tags,fullname='$c_fullName' where category_id='$category_ID'";
                 db_query($conn,$upc2);

              }
           }
        }
       $page=$pageindex_when_edit;

break;
case "save_thumb_icon":
$category_ID	 = (isset($_POST['catid']))? $_POST['catid']: "";
$pageindex_when_edit	 = (isset($_POST['pageindex']))? $_POST['pageindex']: "";
$host_url_t_edit	 = (isset($_POST['host_url_t_edit']))? $_POST['host_url_t_edit']: null;
$img_urls_t_edit	 = (isset($_POST['img_urls_t_edit']))? $_POST['img_urls_t_edit']: null;
$host_url_i_edit	 = (isset($_POST['host_url_i_edit']))? $_POST['host_url_i_edit']: null;
$img_urls_i_edit	 = (isset($_POST['img_urls_i_edit']))? $_POST['img_urls_i_edit']: null;
$t_original_url='';$t_small_url=''; $t_mediam_url=''; $t_large_url=''; $t_custom_url='';

if($host_url_t_edit!='' && $img_urls_t_edit!='')
{
$que_del=  explode(",", $img_urls_t_edit);
$t_original_url=$que_del[0];  $t_small_url=$que_del[1]; $t_mediam_url=$que_del[2];
$t_large_url=$que_del[3]; $t_custom_url=$que_del[4];
$checkQuery="select category_id from category_thumb_icon_url where category_id='$category_ID'";
$categoryCount=  db_totalRow($conn,$checkQuery);
if($categoryCount==1)
{
$upp="UPDATE category_thumb_icon_url SET host_url_thumb='$host_url_t_edit',t_original_url='$t_original_url',
t_small_url='$t_small_url',t_mediam_url='$t_mediam_url',t_large_url='$t_large_url',
t_custom_url='$t_custom_url',updated_at=NOW() where category_id='$category_ID'";
}
 else {
  $upp="insert into category_thumb_icon_url(category_id,host_url_thumb,t_original_url,
  t_small_url,t_mediam_url,t_large_url,t_custom_url,created_at,updated_at)
  values('$category_ID','$host_url_t_edit','$t_original_url','$t_small_url','$t_mediam_url','$t_large_url','$t_custom_url',NOW(),NOW())";
}
$fire=db_query($conn,$upp);
/*----------------------------update log file begin-------------------------------------------*/
    $error_level=1;$msg="save Category thumb"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
    $qry=$upp;
    write_log($error_level,$msg,$lusername,$qry);
    /*----------------------------update log file End---------------------------------------------*/
}
$i_original_url=''; $i_small_url=''; $i_mediam_url='';  $i_large_url=''; $i_custom_url='';
if($host_url_i_edit!='' && $img_urls_i_edit!='')
{
$f_i=  explode(",", $img_urls_i_edit);
$i_original_url=$f_i[0]; $i_small_url=$f_i[1];
$i_mediam_url=$f_i[2];  $i_large_url=$f_i[3]; $i_custom_url=$f_i[4];
$checkQuery="select category_id from category_thumb_icon_url where category_id='$category_ID'";
$categoryCount=  db_totalRow($conn,$checkQuery);
if($categoryCount==1)
{
$u="UPDATE category_thumb_icon_url SET host_url_icon='$host_url_i_edit',i_original_url='$i_original_url',
i_small_url='$i_small_url',i_mediam_url='$i_mediam_url',i_large_url='$i_large_url',i_custom_url='$i_custom_url',
updated_at=NOW() WHERE category_id='$category_ID'";

}
 else {
$up="insert into category_thumb_icon_url(category_id,host_url_icon,
i_original_url,i_small_url,i_mediam_url,i_large_url,i_custom_url,created_at,updated_at)
values('$category_ID','$host_url_i_edit','$i_original_url','$i_small_url','$i_mediam_url','$i_large_url','$i_custom_url',NOW(),NOW())";
 }
$fire=db_query($conn,$u);
}
$page=$pageindex_when_edit;
break;
case "update_priority":
   echo "Priority updated successfully.";
break;
case "refresh":
$pagelimit=(isset($_POST['limitval']))? $_POST['limitval']:'';
$page=(isset($_POST['pageNum']))? $_POST['pageNum']:'';
    break;
case "sync":
    /*$kentry="SELECT entry_id,category_id,created_at FROM kaltura.category_entry where partner_id='$partnerID' and status='2'";
    $fetchKcat= db_select($conn,$kentry);
    foreach($fetchKcat as $fcat)
    {
            $entry_id=$fcat['entry_id']; $category_id=$fcat['category_id'];$created_at=$fcat['created_at'];
            $insert="insert into category_entry(entryid,category_id,priority,created_at)
                  values ('$entry_id','$category_id','0','$created_at')";
            $fire=db_query($conn,$insert);
    }*/
    $kcategory="SELECT id,parent_id,depth,name,full_name,entries_count,full_ids,
     direct_sub_categories_count,description,tags,direct_entries_count
    FROM kaltura.category where partner_id='$partnerID' and status='2'";
    $fetchKcat= db_select($conn,$kcategory);
    foreach($fetchKcat as $fcat)
    {
        $cid=$fcat['id']; $parent_id=$fcat['parent_id'];$depth=$fcat['depth'];$name=db_quote($conn,$fcat['name']);
        $fullname=db_quote($conn,$fcat['full_name']);$entries_count=$fcat['entries_count'];$tags=db_quote($conn,$fcat['tags']);
        $direct_entries_count=$fcat['direct_entries_count'];
        $direct_sub_categories_count=$fcat['direct_sub_categories_count'];
        $description=db_quote($conn,$fcat['description']); $fullids=$fcat['full_ids'];
        $query = "SELECT COUNT(category_id) FROM categories where category_id='".$cid."'";
        $totalpages =db_select($conn,$query);
        $total_pages = db_totalRow($conn,$query);
        if($total_pages>0)
        {
            $upsync="update categories set parent_id='$parent_id',
            dept='$depth',cat_name=$name,fullname=$fullname,fullids='$fullids',
            entry_count='$entries_count',direct_sub_categories_count='$direct_sub_categories_count',
            description=$description,tags=$tags,direct_entries_count='$direct_entries_count' where category_id='".$cid."'";
            $exe=db_query($conn,$upsync);
        }
    }
    break;
    case "syncSingleCategory":
    $category_id_from_k	 = (isset($_POST['category_id_from_k']))? $_POST['category_id_from_k']: "";
    $result_add = $client->category->get($category_id_from_k);
    $CatID=$result_add->id; $parentId=$result_add->parentId; $partnerID=PARTNER_ID;
    $depth=$result_add->depth; $catname=$result_add->name; $cfullName=$result_add->fullName; $fullIds=$result_add->fullIds;
    $entriesCount=$result_add->entriesCount; $createdAt=$result_add->createdAt; $updatedAt=$result_add->updatedAt;
    $cdescription=db_quote($conn,$result_add->description);
    $ctags=db_quote($conn,$result_add->tags);
    $directEntriesCount=$result_add->directEntriesCount;
    $directSubCategoriesCount=$result_add->directSubCategoriesCount;
    $insert="insert into categories(category_id,parent_id,dept,partner_id,cat_name,fullname,fullids,entry_count,
     direct_sub_categories_count,description,tags,created_at,updated_at,duser_id,priority,direct_entries_count)
     Select '$CatID','$parentId','$depth','$partnerID','$catname','$cfullName','$fullIds','$entriesCount',
     '$directSubCategoriesCount',$cdescription,$ctags,NOW(),NOW(),'$get_user_id',ifnull(max(priority),0)+1,'$directEntriesCount' from categories";
     $exe=db_query($conn,$insert);
    /*----------------------------update log file begin-------------------------------------------*/
         $error_level=1;$msg="Sync New Category($catname)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
         $qry='';
         write_log($error_level,$msg,$lusername,$qry);
      /*----------------------------update log file End---------------------------------------------*/
    break;
case "categoryactiveiactive":
    $catSelectedID = (isset($_POST['catChecked']))? $_POST['catChecked']: "";
    $catUnSelectedID = (isset($_POST['catunchecked']))? $_POST['catunchecked']: "";
    if($catSelectedID!=''){
        $catsel= explode(',',$catSelectedID);
        foreach($catsel as $catselid)
        {
           $qrySel="update categories set status='2' where category_id='$catselid'";
           db_query($conn, $qrySel);
           $qrySel2="update header_menu set header_status='1'  where category_id='$catselid'";
           db_query($conn, $qrySel2);
        }

    }
    if($catUnSelectedID!=''){
        $catNotSel= explode(',',$catUnSelectedID);
       foreach($catNotSel as $catnotselid)
        {
            $qryUnSel="update categories set status='1' where category_id='$catnotselid'";
            db_query($conn, $qryUnSel);
            $qrySel3="update header_menu set header_status='0'  where category_id='$catnotselid' ";
            db_query($conn, $qrySel3);
        }
    }
    echo 1;
    exit;
 break;
 case "savePlanCategory":
 $categoryid=(isset($_POST['categoryid']))? $_POST['categoryid']:'';
 $planid=(isset($_POST['planid']))? $_POST['planid']:'';
 $query="select cpi from category_plan_info where categoryid='$categoryid' and planid='$planid'";
 $getData= db_select($conn,$query);
 $entryFound = db_totalRow($conn,$query);
 if($entryFound==0)
 {
   $qry="insert into category_plan_info(categoryid,planid,created_at)values('$categoryid','$planid',NOW())";
   $exe=db_query($conn,$qry);
   // update ispremium in entry table
   $qryEntry="update entry set ispremium='1' where FIND_IN_SET('$categoryid',categoryid) and status='2'";
   db_query($conn,$qryEntry);
   /*----------------------------update log file begin-------------------------------------------*/
     $error_level=1;$msg="add plan in category($categoryid-$planid)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
     $qry='';
     write_log($error_level,$msg,$lusername,$qry);
   /*----------------------------update log file End---------------------------------------------*/
 }
if($entryFound==1){
       $cpi=$getData[0]['cpi'];
       $qry="update category_plan_info set categoryid='$categoryid',planid='$planid',updated_at=NOW() where cpi='$cpi' ";
       $exe=db_query($conn,$qry);
   /*----------------------------update log file begin-------------------------------------------*/
       $error_level=1;$msg="Update plan in category($categoryid-$planid)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
       $qry='';
       write_log($error_level,$msg,$lusername,$qry);
    /*----------------------------update log file End---------------------------------------------*/
 }


 $pagelimit=(isset($_POST['limitval']))? $_POST['limitval']:'';
 $page=(isset($_POST['pageNum']))? $_POST['pageNum']:'';
 break;
}

$query = "SELECT COUNT(category_id) as num FROM categories cat where cat.status!='3'    ";
if($searchTextMatch!='')
{
    $query.=" and (cat.fullname LIKE '%". $searchTextMatch . "%' or cat.cat_name LIKE '" . $searchTextMatch . "%')";
}
//echo "Total Query=".$query;
$totalpages =db_select($conn,$query);
$total_pages = $totalpages[0]['num'];
$limit = $pagelimit;
if($page)
        $start = ($page - 1) * $limit; 			//first item to display on this page
else
        $start = 0;
/*$sql="SELECT cat.catid,cat.category_id,cat.cat_name,cat.parent_id,cat.created_at,cat.priority,cat.fullname,
    cat.direct_sub_categories_count,cat.direct_entries_count,cat.status,cat.priority,cti.t_mediam_url,cti.t_small_url,cti.i_small_url,
    cti.host_url_thumb,cti.host_url_icon,cpi.planid FROM categories  cat
    LEFT JOIN category_thumb_icon_url cti ON cat.category_id = cti.category_id
    LEFT JOIN category_plan_info cpi ON cat.category_id = cpi.categoryid
    where cat.status!='3'  ";*/
    $sql="SELECT cat.catid,cat.category_id,cat.cat_name,cpi.tag,cat.parent_id,cat.created_at,cat.priority,cat.fullname,
        cat.direct_sub_categories_count,cat.direct_entries_count,cat.status,cat.priority,cti.t_mediam_url,cti.t_small_url,cti.i_small_url,
        cti.host_url_thumb,cti.host_url_icon FROM categories  cat
        LEFT JOIN category_thumb_icon_url cti ON cat.category_id = cti.category_id
        LEFT JOIN category_plan_info cpi ON cat.category_id = cpi.categoryid
        where cat.status!='3'  ";
if($searchTextMatch!='')
{
    $sql.=" and (cat.fullname LIKE '%". $searchTextMatch . "%' or cat.cat_name LIKE '" . $searchTextMatch . "%')";
}
$sql.=" order by cat.catid DESC LIMIT $start, $limit";
//echo "<br/>Full Query=".$sql;
$que = db_select($conn,$sql);
$countRow=  db_totalRow($conn,$sql);
if($countRow==0)
{die("<div align='center'><strong>No Record Found</strong> </div><br/>");}
?>
<div class="box-header" >
    <div class="row table-responsive" style="border: 0px solid red; margin-top:-25px;">
    <table border='0' style="width:98%; margin-left: 10px; font-size: 12px;">
    <tr>
    <td width="10%"><select id="pagelmt"  style="width:60px;" onchange="selpagelimit('<?php echo $page;  ?>','<?php echo $searchTextMatch;?>');" >
        <option value="10"  <?php echo $pagelimit==10? "selected":""; ?> >10</option>
        <option value="15"  <?php echo $pagelimit==15? "selected":""; ?> >15</option>
        <option value="20"  <?php echo $pagelimit==20? "selected":""; ?> >20</option>
        <option value="50"  <?php echo $pagelimit==50? "selected":""; ?> >50</option>
        <option value="100" <?php echo $pagelimit==100? "selected":""; ?> >100</option>
        <option value="200" <?php echo $pagelimit==200? "selected":""; ?> >200</option>
        <option value="500" <?php echo $pagelimit==500? "selected":""; ?> >500</option>
        </select> Records Per Page</td>

    <td width="5%">
      <input type="button" class="btn-primary btn-xs" title="active/inactive category" value="Active/Inactive" onclick="activeInactive('<?php echo $page;?>','<?php echo $pagelimit; ;?>');" ></td>
    <td width="30%">
     <!--<form class="navbar-form" role="search" method="post" style=" padding: 0 !important;">-->
      <div class="col-sm-3 col-md-3 pull-right navbar-form" role="search">
       <div class="input-group add-on" style="float: right;">
        <input class="form-control" size="30" onkeyup="SeachDataTable('category_paging.php','<?php echo $pagelimit;?>','<?php echo  $page; ;?>','load')"  placeholder="Search by Name"  autocomplete="off" name='searchQuery' id='searchInput' class="searchInput" type="text" value="<?php echo $searchTextMatch; ?>">
        <div class="input-group-btn">
        <button class="enableOnInput btn btn-default" onclick="SearchDataTableValue('category_paging.php','<?php echo $pagelimit;?>','<?php echo $page; ?>','load')" disabled='disabled' id='submitBtn' type="button" style="height: 30px;   padding: 4px 6px !important;" ><i class="glyphicon glyphicon-search"></i></button>
        </div>
       </div>
      </div>
      <!--</form>-->
    </td>
    <td width="3%">
     <div class="pull-right" style="border:0px solid red;  margin-top:1px !important;">
      <a href="javascript:" onclick="return refreshcontent('sync','<?php echo $page;  ?>','<?php echo $pagelimit; ?>','<?php echo $searchTextMatch;?>');" title="sync" style="float: left;"><i class="fa fa-refresh" aria-hidden="true"></i> Sync</a>
     </div>
     </td>
     <td width="3%">
     <div class="pull-right" style="border:0px solid red;  margin-top:1px !important;">
      <a href="javascript:" onclick="return refreshcontent('refresh','<?php echo $page;  ?>','<?php echo $pagelimit; ?>','<?php echo $searchTextMatch;?>');" title="Refresh" style="float: right; margin-left: 10px;"><i class="fa fa-refresh" aria-hidden="true"></i> Refresh</a>
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
<form id="form" name="myform" style="border: 0px solid red;" method="post" action="priority.php">
  <table id="example1" class="table table-fixedheader table-bordered table-striped" style="width: 100%;">
    <thead>
        <tr>
        <th></th>
         <?php  if(in_array(21, $otherPermission)){ ?><th width="10%">Thumbnail</th> <?php } ?>
         <?php  if(in_array(22, $otherPermission)){ ?><th width="5%">Icon</th><?php } ?>
         <th>ID</th>
         <th width="10%">Name</th>
         <?php  if(in_array(40, $otherPermission)){ ?><th>Plan</th><?php } ?>
         <th width="20%">Full-Name</th>
         <th>Created On</th>
         <!--<th>Priority</th>-->
         <th title="Sub-Categories" width="8%">Sub-Categories</th>
         <th>Entries</th>
          <th>Status</th>
         <th>Action</th>
 </tr>
 </thead>
<tbody>
<?php
$count=1;
foreach($que as $fetch)
{
 $id=$fetch['category_id']; $catid=$fetch['catid'];
 $parent_id =$fetch['parent_id']; $name=$fetch['cat_name'];
 $createdAt=$fetch['created_at'];	$entriesCount=$fetch['entry_count'];
 $t_mediam_url=$fetch['t_mediam_url'];  $i_small_url=$fetch['i_small_url'];    $t_small_url=$fetch['t_small_url'];
 $host_url_thumb=$fetch['host_url_thumb']; $host_url_icon=$fetch['host_url_icon']; $priority=$fetch['priority'];
 $imgthumb=''; $imgicon='';
 if(!empty($t_small_url))
 {
       $imgthumb='<img class="img-responsive customer-img" src="'.$host_url_thumb.$t_small_url.'"  height="30" width="90" >';
 }
 if(!empty($i_small_url))
 {
       $imgicon='<img class="img-responsive customer-img" style="background-color: black;" src="'.$host_url_icon.$i_small_url.'"  height="25" width="40" >';
 }
 $fullname=$fetch['fullname'];   $directSubCategoriesCount=$fetch['direct_sub_categories_count'];
 $directEntriesCount=$fetch['direct_entries_count'];  $plan_tag=$fetch['tag'];
$status=$fetch['status'];
if($status=='2'){ $cstatus="<span class='label label-success'>active</span>"; }
if($status=='1'){ $cstatus="<span class='label label-danger'>inactive</span>"; }
?>
<tr id="<?php echo $count."_r"; ?>">
<td></td>
<?php  if(in_array(21, $otherPermission)){ ?><td width="10%"><?php echo $imgthumb; ?>
  <?php
    if(in_array(40, $otherPermission)){?>
  <div class="btn-group btn-toggle " style=" position: relative;">
      <button id="" title="Premium" class="btn btn-xs btn-danger">P</button>
        <button id="" title="Free" class="btn btn-xs btn-success">F</button>
    </div> <?php }?>
</td> <?php } ?>

<?php  if(in_array(22, $otherPermission)){ ?><td width="5%"><?php echo $imgicon; ?></td><?php } ?>
<td><?php echo $id;?></td>
<td><a href="javascript:void(0)" title="View Detail" onclick="categoryEdit('<?php echo $id; ?>','<?php echo $page; ?>','<?php echo $pagelimit; ?>')">
<?php echo wordwrap($name,40, "\n", true); ?>
 </a></td>
  <?php  if(in_array(40, $otherPermission)){ ?><td><?php echo  $plan_tag; ?></td><?php } ?>
<td><?php echo wordwrap($fullname,40, "\n", true); ?></td>
<td><?php echo $createdAt; ?></td>
<!--<td><?php echo $priority; ?></td>-->
<td width="8%"> <?php echo  $directSubCategoriesCount; ?></td>
<td><?php echo  $directEntriesCount; ?></td>
<td><?php echo $cstatus;?></td>
<td>
  <div class="btn-group ">
  <a class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#" role="button">Action <span class="caret"></span></a>
  <ul class="dropdown-menu" style="border:0px black solid; margin: 0 0 0 -15px !important; font-size:12px !important; background-color:#FFF0F5 !important; max-width:115px !important;min-width:100px !important;">
     <li>
       <?php   if(in_array("3", $UserRight)){ ?>
       <a href="javascript:void(0)" class="myBtnn" onclick="view_category_entry('<?php echo $id; ?>')"><i class="fa fa-eye" aria-hidden="true" data-toggle="tooltip" data-placement="left"  style="padding-left: -4px  !important;" title="View Entries"></i>View Entries</a>
       <?php } if(in_array("4", $UserRight)){ ?>
     </li>
     <li>
       <a href="javascript:void(0)" onclick="return deleteContent('<?php echo $id; ?>','deletecontent','<?php echo $page; ?>','<?php echo $parent_id; ?>','<?php echo $directSubCategoriesCount;  ?>','<?php echo $priority; ?>')"><i class="fa fa-trash-o" data-toggle="tooltip" data-placement="left"  aria-hidden="true" title="Delete" style="padding-left: -4px  !important;"></i>
       Delete </a>
     </li>
      <li>
      <?php } if(in_array("2", $UserRight)){ ?>
       <a href="javascript:void(0)" class="myBtn" onclick="categoryEdit('<?php echo $id; ?>','<?php echo $page; ?>','<?php echo $pagelimit; ?>')"><i class="fa fa-pencil-square-o" aria-hidden="true" data-toggle="tooltip" data-placement="left"  title="Edit" style="padding-left: -4px  !important;"></i>Edit</a>
     </li>
      <li>
        <a href="javascript:void(0)" class="myBtnn" onclick="SetEntryPriorty('<?php echo $id; ?>','<?php echo $name; ?>')">
        <i class="fa fa-level-up" aria-hidden="true" title="Set Video Priority" style="padding-left: -4px  !important;"></i>
        Set Priority</a>
     </li>
      <li>
        <?php
          if(in_array(40, $otherPermission)){
        if($directSubCategoriesCount=='0'){ ?>
        <a href="javascript:void(0)" class="myBtnn" onclick="AddPlanInCategory('<?php echo $id; ?>','<?php echo $name; ?>','<?php echo $page; ?>','<?php echo $pagelimit; ?>')">
        <i class="fa fa-usd" aria-hidden="true" title="add Plan" style="padding-left: -4px  !important;"></i>
        Add Plan</a>
     </li>

  </ul>
  </div>

   <!--<a href="javascript:void(0)" title="<?php echo ($status == 2) ? 'active':'inactive'; ?>" style="padding-left: 8px  !important;">
   <i id="icon_status<?php echo $id; ?>" class="status-icon fa <?php  echo ($status == 2) ? 'fa-check-square-o':'fa-ban';?>" onclick="categoryActiveInactive('<?php echo  $id; ?>','<?php echo $parent_id; ?>','<?php echo $status; ?>','<?php echo $page;?>','<?php echo $pagelimit; ?>','<?php echo $searchTextMatch; ?>')" ></i>
   </a>-->


<?php } } } ?>

</td>
</tr>
<?php    $count++; } include_once 'ksession_close.php';  ?>
</tbody>
</table>
<?php
if ($page == 0) $page = 1;
	$prev = $page - 1;
	$next = $page + 1;
	$lastpage = ceil($total_pages/$limit);
	$lpm1 = $lastpage - 1;
	$pagination = "";
	if($lastpage > 1)
	{
		$pagination .= "<div class=\"pagination\">";
		if ($page > 1)
		 $pagination.= '<a href="javascript:void(0)" onclick="changePagination(\''.$prev.'\',\''.$limit.'\',\''.$searchTextMatch.'\')"><i class="fa fa-long-arrow-left" aria-hidden="true"></i> Previous</a>';
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
				$pagination.= '<a href="javascript:void(0)" onclick="changePagination(\''.$counter.'\',\''.$limit.'\',\''.$searchTextMatch.'\')">'.$counter.'</a>';
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
				     $pagination.= '<a href="javascript:void(0)" onclick="changePagination(\''.$counter.'\',\''.$limit.'\',\''.$searchTextMatch.'\')">'.$counter.'</a>';
				}
				$pagination.= "...";
				$pagination.= '<a href="javascript:void(0)" onclick="changePagination(\''.$lpm1.'\',\''.$limit.'\',\''.$searchTextMatch.'\')">'.$lpm1.'</a>';
				$pagination.= '<a href="javascript:void(0)" onclick="changePagination(\''.$lastpage.'\',\''.$limit.'\',\''.$searchTextMatch.'\')">'.$lastpage.'</a>';
			}
			//in middle; hide some front and some back
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				//$pagination.= "<a href=\"$targetpage?page=1\">1</a>";
				$pagination.= '<a href="javascript:void(0)" onclick="changePagination(\'1\',\''.$limit.'\',\''.$searchTextMatch.'\')">1</a>';
				//$pagination.= "<a href=\"$targetpage?page=2\">2</a>";
				$pagination.= '<a href="javascript:void(0)" onclick="changePagination(\'2\',\''.$limit.'\',\''.$searchTextMatch.'\')">2</a>';
				$pagination.= "...";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
					$pagination.= '<a href="javascript:void(0)" onclick="changePagination(\''.$counter.'\',\''.$limit.'\',\''.$searchTextMatch.'\')">'.$counter.'</a>';
				}
				$pagination.= "...";
				$pagination.= '<a href="javascript:void(0)" onclick="changePagination(\''.$lpm1.'\',\''.$limit.'\',\''.$searchTextMatch.'\')">'.$lpm1.'</a>';
				$pagination.= '<a href="javascript:void(0)" onclick="changePagination(\''.$lastpage.'\',\''.$limit.'\',\''.$searchTextMatch.'\')">'.$lastpage.'</a>';
			}
			//close to end; only hide early pages
			else
			{

				$pagination.= '<a href="javascript:void(0)" onclick="changePagination(\'1\',\''.$limit.'\',\''.$searchTextMatch.'\')">1</a>';
				$pagination.= '<a href="javascript:void(0)" onclick="changePagination(\'2\',\''.$limit.'\',\''.$searchTextMatch.'\')">2</a>';
				$pagination.= "...";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else

						$pagination.= '<a href="javascript:void(0)" onclick="changePagination(\''.$counter.'\',\''.$limit.'\',\''.$searchTextMatch.'\')">'.$counter.'</a>';
				}
			}
		}

		//next button
		if ($page < $counter - 1)

		    $pagination.= '<a href="javascript:void(0)" onclick="changePagination(\''.$next.'\',\''.$limit.'\',\''.$searchTextMatch.'\')">Next <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>';
		else
			$pagination.= "<span class=\"disabled\">Next <i class='fa fa-long-arrow-right' aria-hidden='true'></i>  </span>";
		$pagination.= "</div>\n";
	}


?>
</form>

<div class="page" style="border: 0px solid red; text-align: center; background-color:#fff !important; height:40px;">
<?php
if($page ==1 || $page ==0) {
        if($total_pages==0){  $startShow=0;  } else {  $startShow=1;}
        $lmt=$limit<$total_pages ? $limit :$total_pages;
       }
      else { $startShow=(($page - 1) * $limit)+1;
       $lmt=($page*$limit) >$total_pages ? $total_pages: $page * $limit;
     }
?>
    <div class="pull-left" style="border: 0px solid red; margin-left: 5px;">
      Showing <?php echo $startShow; ?>  to <?php echo $lmt; ?>   of <?php echo $total_pages; ?> entries
    </div>
    <div class="pull-right" style="border: 0px solid red;">
    <?php
    echo $pagination;
    ?>
    </div>
</div>

<script src="js/commonFunctionJS.js" type="text/javascript"></script>
 <script type="text/javascript">
/* this is for model JS with edit and view detail */

function categoryEdit(categoryID,EntryPageindex,limitval)
{
   $("#msg").html();
   $("#myModal_category_view").modal();
   $("#flash").fadeIn(200).html('Loading <img src="img/image_process.gif" />');
   var info = 'Entryid=' + categoryID+"&pageindex="+EntryPageindex+"&limitval="+limitval;
   $.ajax({
            type: "POST",
            url: "categories_edit_model.php",
            data: info,
            success: function(result){
            $('#show_category_model_view').html(result);
            $("#flash").hide();
        }

     });
     return false;
 }

function view_category_entry(categoryID)
{
   $("#msg").html();
   $("#myModal_view_entry").modal();
   $("#flash").fadeIn(500).html('Loading <img src="img/image_process.gif" />');
   var info = 'categoryID='+categoryID+"&action=view_category_entry";
       $.ajax({
	    type: "POST",
	    url: "categories_view_entry.php",
	    data: info,
            success: function(result){
             $("#flash").hide();
             $('#view_category_entry').html(result);
              }
            });
     return false;
}

function changePagination(pageid,limitval,searchtext){
     $('#load').show();
     $('#results').css("opacity",0.1);
      var dataString = 'pageNum='+ pageid+'&limitval='+limitval+'&searchInputall='+ searchtext;
     $.ajax({
           type: "POST",
           url: "category_paging.php",
           data: dataString,
           cache: false,
           success: function(result){
           	 $("#results").html(result);
                 $('#load').hide();
		$('#results').css("opacity",1);
           }
     });
}
function deleteContent(entryID,delname,pageindex,parent_id,subcategorycount,priority_parent){
$("#msg").html();
            if(subcategorycount==0)
            {
               var msg="Are you sure you want to delete the selected Category  ?";
                var dataString ='entryID='+ entryID +"&categoryaction="+delname+"&pageindex="+pageindex+"&parent_id="+parent_id+"&priority_parent="+priority_parent;
            }
            if(subcategorycount>0)
            {
             var  msg="The category will be deleted with its sub-categories. \nDo you want to continue?";
             var dataString ='entryID='+ entryID +"&categoryaction=delete_with_sub_category&pageindex="+pageindex+"&parent_id="+parent_id+"&priority_parent="+priority_parent;
            }
            var a=confirm(msg);
	     if(a==true)
	     {
             $("#flash").show();
             $("#flash").fadeIn(800).html('Loading <img src="img/image_process.gif" />');
	        $.ajax({
	           type: "POST",
	           url: "category_paging.php",
	           data: dataString,
	           cache: false,
	           success: function(result){
	           //alert(result);
	           $("#results").html('');
	           $("#flash").css("color", "red").html('Category Deleted Successfully..');
                   $("#results").html(result);
	          // window.location="category_content.php";
             }
	         });
	     }
	     else
	     {
	     	 $("#flash").hide();
	     	 return false;
	     }
}



function SeachDataTable(pageURL,limitval,pageNum,loaderID)
{
    $("#msg").html();
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
        var dataString ='searchInputall='+searchInputall+"&limitval="+limitval+"&pageNum="+pageNum;
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

function SearchDataTableValue(pageURL,limitval,pageNum,loaderID)
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
function refreshcontent(ref,pageindex,limitval,searchtext){
     $('#load').show();
     $('#results').css("opacity",0.1);
     var apiBody = new FormData();
     apiBody.append("pageNum",pageindex);
     apiBody.append("limitval",limitval);
     apiBody.append("searchInputall",searchtext);
     apiBody.append("categoryaction",ref);
      $.ajax({
           type: "POST",
           url: "category_paging.php",
           data: apiBody,
           processData: false,
           contentType: false,
           cache: false,
           success: function(result){
           	 $("#flash").hide();
          	 $("#results").html(result);
                 //$("#msg").html("Sync Successfully Done");
                 $('#results').css("opacity",1);
          }
     });
}
function selpagelimit(pageindex,searchtext){
var limitval = document.getElementById("pagelmt").value;
     $('#load').show();
     $('#results').css("opacity",0.1);
     var apiBody = new FormData();
     apiBody.append("limitval",limitval);
     apiBody.append("searchInputall",searchtext);
     apiBody.append("maction","filterview");
      $.ajax({
           type: "POST",
           url: "category_paging.php",
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
function syncSingleCategory(category_id_from_k,pageindex,limitval,searchtext)
{
     $('#load').show();
     $('#results').css("opacity",0.1);
     var apiBody = new FormData();
     apiBody.append("category_id_from_k",category_id_from_k);
     apiBody.append("pageNum",pageindex);
     apiBody.append("limitval",limitval);
     apiBody.append("searchInputall",searchtext);
     apiBody.append("categoryaction","syncSingleCategory");
      $.ajax({
           type: "POST",
           url: "category_paging.php",
           data: apiBody,
           processData: false,
           contentType: false,
           cache: false,
           success: function(result){
           	 $("#flash").hide();
          	 $("#results").html(result);
                 $("#msg").html("Sync Successfully Done");
                 $('#results').css("opacity",1);
          }
     });
}
</script>
