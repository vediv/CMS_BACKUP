<?php 
include_once 'corefunction.php';
$searchTextMatch = (isset($_POST['searchInputall']))? $_POST['searchInputall']: "";
$pagelimit = (isset($_POST['limitval']))? $_POST['limitval']:15;
$pager_pageIndex =(isset($_POST['pageNum']))? $_POST['pageNum']:1;
$get_refresh = (isset($_POST['refresh']))? $_POST['refresh']: "";
include_once 'function.php';
include_once("config.php");
$action = (isset($_POST['categoryaction'])) ? $_POST['categoryaction']: "";
switch($action)
{
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
    $delete1 = "DELETE FROM categories where category_id='$deleteentryID'";
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
    $delete2 = "DELETE FROM category_thumb_icon_url where category_id='$deleteentryID'";
    $dcu=db_query($conn,$delete2);
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
     $delcategoryid = (isset($_POST['entryID']))? $_POST['entryID']: "";
     $parent_id = (isset($_POST['parent_id']))? $_POST['parent_id']: "";
     $priorityParent = (isset($_POST['priority_parent']))? $_POST['priority_parent']: "";
     $qry="select category_id,parent_id,priority from categories where parent_id='".$delcategoryid."' order by priority";
     $fcid=  db_select($conn,$qry);
     $totalSub= db_totalRow($conn,$qry);
     foreach($fcid as $fetcid)
     {   
         $category_id=$fetcid['category_id']; $parentid=$fetcid['parent_id'];  $priority=$fetcid['priority'];
         $delete1 = "DELETE FROM categories where category_id='".$category_id."' and parent_id='".$delcategoryid."'";
         $dc=db_query($conn,$delete1);
         $qheaderMenu = "update header_menu set header_status='3' where category_id='$category_id'";
         $dc=db_query($conn,$qheaderMenu);
         // this category id remove from entry table in categoryid column
         $updateeEntryTable="update entry set categoryid=TRIM(BOTH ',' FROM REPLACE(CONCAT(',',categoryid,',') , ',$category_id,', ',')) where FIND_IN_SET($category_id,categoryid)";
         $uEntry=db_query($conn,$updateeEntryTable);
         $delete2 = "DELETE FROM category_thumb_icon_url where category_id='".$category_id."'";
         $dcu=db_query($conn,$delete2);
           // update priority
        $uppriority="update categories set priority=priority-1 where priority>$priority";
        db_query($conn,$uppriority);
     }
    $deletem = "DELETE FROM categories where category_id='$delcategoryid'";
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
    $delete_url = "DELETE FROM category_thumb_icon_url where category_id='$delcategoryid'";
    $dcu=db_query($conn,$delete_url);
    $moveEntriesToParentCategory = KalturaNullableBoolean::NULL_VALUE;
    $result = $client->category->delete($delcategoryid, $moveEntriesToParentCategory);
    //$pageindex_when_delete = (isset($_POST['pageindex']))? $_POST['pageindex']: "";
    //$pager->pageIndex=$pageindex_when_delete;  
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
             $upc="update categories set cat_name='$c_name',description=$c_description,tags=$c_tags,fullname='$c_fullName' where category_id='$category_ID'";
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
       $pager_pageIndex=$pageindex_when_edit;

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
$pager_pageIndex=$pageindex_when_edit;   
break;    
case "update_priority":
   echo "Priority updated successfully.";
    break;
case "refresh":
    $filter = null; $pager = null;
    $res = $client->category->listAction($filter, $pager);
    
    foreach ($res->objects as $Catgory) {                                    
         $categoryID=$Catgory->id;
         $depth=$Catgory->depth; $parentId=$Catgory->parentId; $depth=$Catgory->depth; $partnerId=$Catgory->partnerId; 
         $name=db_quote($conn,$Catgory->name);  
         $fullname=db_quote($conn,$Catgory->fullName);$fullids=$Catgory->fullIds;$entry_count=$Catgory->entriesCount;
         $directSubCategoriesCount=$Catgory->directSubCategoriesCount;$description=db_quote($conn,$Catgory->description);
         $tags=db_quote($conn,$Catgory->tags);$direct_entries_count=$Catgory->directEntriesCount;
         $query = "SELECT COUNT(category_id) as totalnum FROM categories where category_id='".$categoryID."'";
         $totalpages =db_select($conn,$query);
         $total_pages = db_totalRow($conn,$query);
         if($total_pages>0)
         {
            $upsync="update categories set parent_id='$parentId',dept='$depth',cat_name=$name,fullname=$fullname,fullids='$fullids',entry_count='$entry_count',direct_sub_categories_count='$directSubCategoriesCount',description=$description,tags=$tags,direct_entries_count='$direct_entries_count' where category_id='".$categoryID."'";
            $exe=db_query($conn,$upsync);
            
         }    
        /* if($total_pages==0)
         {
            $insert="insert into categories(category_id,parent_id,dept,partner_id,cat_name,fullname,fullids,entry_count,direct_sub_categories_count,description,tags,created_at,updated_at,duser_id,priority,) 
            Select '$categoryID','$parentId','$depth','$partnerId',$name,$fullname,'$fullids','$entry_count','$directSubCategoriesCount',$description,$tags,NOW(),Now(),'$get_user_id',ifnull(max(priority),0)+1,'$direct_entries_count' from categories";
            $exe=db_query($conn,$insert);
         } */   
    }  
     /*----------------------------update log file begin-------------------------------------------*/
    $error_level=1;$msg="Sync Category"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
    $qry='';
    write_log($error_level,$msg,$lusername,$qry);
    /*----------------------------update log file End---------------------------------------------*/
    
    //echo "Sync Successfully Done.";
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
}

?>
<div class="box-header" >
    <div class="row table-responsive" style="border: 0px solid red; margin-top:-25px;">
    <table border='0' style="width:98%; margin-left: 10px; font-size: 12px;">
    <tr>
    <td width="12%"><select id="pagelmt"  style="width:60px;" onchange="selpagelimit('<?php echo $pager_pageIndex;  ?>','<?php echo $searchTextMatch;?>');" >
        <option value="10"  <?php echo $pagelimit==10? "selected":""; ?> >10</option>
        <option value="15"  <?php echo $pagelimit==15? "selected":""; ?> >15</option>
        <option value="20"  <?php echo $pagelimit==20? "selected":""; ?> >20</option>
        <option value="50"  <?php echo $pagelimit==50? "selected":""; ?> >50</option>
        <option value="100" <?php echo $pagelimit==100? "selected":""; ?> >100</option>
        <option value="200" <?php echo $pagelimit==200? "selected":""; ?> >200</option>
        <option value="500" <?php echo $pagelimit==500? "selected":""; ?> >500</option>
        </select> Records Per Page</td>
   
   <!--<td width="2%"><input type="button"  class="btn-primary btn-xs" value="Set Priority" onclick="setPriority();" ></td>-->
    <td width="35%">
     <!--<form class="navbar-form" role="search" method="post" style=" padding: 0 !important;">-->
      <div class="col-sm-3 col-md-3 pull-right navbar-form" role="search">  
       <div class="input-group add-on" style="float: right;">
        <input class="form-control" size="30" onkeyup="SeachDataTable('category_paging.php','<?php echo $pagelimit;?>','<?php echo  $pager_pageIndex; ;?>','load')"  placeholder="Search by Name"  autocomplete="off" name='searchQuery' id='searchInput' class="searchInput" type="text" value="<?php echo $searchTextMatch; ?>">
        <div class="input-group-btn">
        <button class="enableOnInput btn btn-default" onclick="SearchDataTableValue('category_paging.php','<?php echo $pagelimit;?>','<?php echo $pager_pageIndex; ?>','load')" disabled='disabled' id='submitBtn' type="button" style="height: 30px;   padding: 4px 6px !important;" ><i class="glyphicon glyphicon-search"></i></button>	
        </div>
       </div>
      </div>   
      <!--</form>-->
    </td>
    <td width="2%">
     <div class="  pull-right" style="border:0px solid red;  margin-top:1px !important;">   
      <a href="javascript:" onclick="return refreshcontent('refresh','<?php echo $pager_pageIndex;  ?>','<?php echo $pagelimit; ?>','<?php echo $searchTextMatch;?>');" title="Sync" style="float: right"><i class="fa fa-refresh" aria-hidden="true"></i> Refresh</a>   
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
<?php
$filter = new KalturaCategoryFilter();
$filter->orderBy = '-createdAt';
if($searchTextMatch!='')
{
    //$filter->nameOrReferenceIdStartsWith = $searchTextMatch;
    //$filter->idIn = $searchTextMatch;
    $filter->freeText=$searchTextMatch;
}
$pager = new KalturaFilterPager();
$pager->pageSize = $pagelimit;
$pager->pageIndex = $pager_pageIndex;
$Categoryresult = $client->category->listAction($filter, $pager);
$total_pages=$Categoryresult->totalCount;
$limit=$pager->pageSize;
$page=$pager_pageIndex; 
if($page) 
            $start = ($page - 1) * $limit; 			//first item to display on this page
    else
            $start = 0;
?>
<form id="form" name="myform" style="border: 0px solid red;" method="post" action="priority.php">
  <table id="example1" class="table table-fixedheader table-bordered table-striped" style="width: 100%;">
    <thead>
        <tr>
        <th></th>
         <?php  if(in_array(21, $otherPermission)){ ?><th>Thumbnail</th> <?php } ?>
         <?php  if(in_array(22, $otherPermission)){ ?><th>Icon</th><?php } ?>
         <th>ID</th>
         <th width="20%">Name</th>
         <th width="20%">Full-Name</th>
         <th>Created On</th>
         <th title="Sub-Categories">Sub-Cat</th>
         <th>Entries</th>
         <th>Action</th>                 
 </tr>
 </thead>
<tbody>
    <?php
     $count=1;
     //print '<pre>'.print_r($Categoryresult, true).'</pre>';
      foreach ($Categoryresult->objects as $entryCategory) {
      $category_id_from_k=$entryCategory->id;  
      $sql="SELECT cat.catid,cat.category_id,cat.cat_name,cat.parent_id,cat.created_at,cat.priority,
           cat.fullname,cat.direct_sub_categories_count,cat.direct_entries_count,
           cti.t_mediam_url,cti.t_small_url,cti.i_small_url,cti.host_url_thumb,cti.host_url_icon
           FROM categories  cat 
           LEFT JOIN category_thumb_icon_url cti ON cat.category_id = cti.category_id 
           where cat.category_id='".$category_id_from_k."'";
           $fetch = db_select($conn,$sql); 
     $countRow=  db_totalRow($conn,$sql);
     if($countRow==1){
     $id=$fetch[0]['category_id']; $catid=$fetch[0]['catid']; $parent_id =$fetch[0]['parent_id']; $name=$fetch[0]['cat_name']; 
     $createdAt=$fetch[0]['created_at'];$entriesCount=$fetch[0]['entry_count']; 
     $t_mediam_url=$fetch[0]['t_mediam_url'];  $i_small_url=$fetch[0]['i_small_url'];    $t_small_url=$fetch[0]['t_small_url'];
     $host_url_thumb=$fetch[0]['host_url_thumb']; $host_url_icon=$fetch[0]['host_url_icon']; $priority=$fetch[0]['priority'];
     $imgthumb=''; $imgicon=''; 
     if(!empty($t_small_url))
     {
         $imgthumb='<img class="img-responsive customer-img" src="'.$host_url_thumb.$t_small_url.'"  height="30" width="90" >';
     } 
     if(!empty($i_small_url))
     {
       $imgicon='<img class="img-responsive customer-img" style="background-color: black;" src="'.$host_url_icon.$i_small_url.'"  height="25" width="40" >';
     } 
     $fullname=$fetch[0]['fullname'];   $directSubCategoriesCount=$fetch[0]['direct_sub_categories_count'];;   
     //$directEntriesCount=$fetch[0]['direct_entries_count']; 
     $directEntriesCount=$entryCategory->directEntriesCount  ;
     ?> 
    <tr id="<?php echo $count."_r"; ?>">
    <td></td>
    <?php  if(in_array(21, $otherPermission)){ ?><td><?php echo $imgthumb; ?></td> <?php } ?>  
    <?php  if(in_array(22, $otherPermission)){ ?><td><?php echo $imgicon; ?></td><?php } ?>
    <td><?php echo $id;?></td>
    <td><a href="javascript:void(0)" title="View Detail" onclick="categoryEdit('<?php echo $id; ?>','<?php echo $page; ?>','<?php echo $pagelimit; ?>')">
    <?php echo wordwrap($name,40, "\n", true); ?>
     </a></td>
    <td><?php echo wordwrap($fullname,40, "\n", true); ?></td>
    <td><?php echo $createdAt; ?></td>
    <td> <?php echo  $directSubCategoriesCount; ?></td>
    <td><?php echo  $directEntriesCount; ?></td>
    <td>
    <div class="dropdown">
     <?php   if(in_array("3", $UserRight)){ ?>
      <a href="javascript:void(0)" class="myBtnn" onclick="view_category_entry('<?php echo $id; ?>')"><i class="fa fa-eye" aria-hidden="true" data-toggle="tooltip" data-placement="left"  title="View Entries"></i></a>
      <?php } if(in_array("2", $UserRight)){ ?>    
      <a href="javascript:void(0)" class="myBtn" onclick="categoryEdit('<?php echo $id; ?>','<?php echo $page; ?>','<?php echo $pagelimit; ?>')"><i class="fa fa-pencil-square-o" aria-hidden="true" data-toggle="tooltip" data-placement="left"  title="Edit" style="padding-left: 8px  !important;"></i></a>
      <?php } if(in_array("4", $UserRight)){ ?>
       <a href="javascript:void(0)" onclick="return deleteContent('<?php echo $id; ?>','deletecontent','<?php echo $page; ?>','<?php echo $parent_id; ?>','<?php echo $directSubCategoriesCount;  ?>','<?php echo $priority; ?>')"><i class="fa fa-trash-o" data-toggle="tooltip" data-placement="left"  aria-hidden="true" title="Delete" style="padding-left: 8px  !important;"></i>
      </a> 
       <?php  } ?>
     </div>
    </td>
    </tr>   
    <?php }
    else
    { 
      $category_id_from_k=$entryCategory->id;$category_name_from_k=$entryCategory->name; 
      $category_fullName_from_k=$entryCategory->fullName;
     ?>
    <tr id="<?php echo $count."_r"; ?>">
    <td></td>
    <?php  if(in_array(21, $otherPermission)){ ?><td><?php //echo $imgthumb; ?></td> <?php } ?>  
    <?php  if(in_array(22, $otherPermission)){ ?><td><?php //echo $imgicon; ?></td><?php } ?>
    <td><?php echo $category_id_from_k;?></td>
    <td><?php echo wordwrap($category_name_from_k,40, "\n", true); ?></td>
    <td><?php echo wordwrap($category_fullName_from_k,40, "\n", true); ?></td>
    <td><?php //echo $priority; ?></td>
    <td><?php // echo $createdAt; ?></td>
    <td> <?php //echo  $directSubCategoriesCount; ?></td>
    <td><?php //echo  $directEntriesCount; ?></td>
    <td>
     <span class="label label-danger label-white middle" style="cursor:pointer;" onclick="syncSingleCategory('<?php echo $category_id_from_k; ?>','<?php echo $page; ?>','<?php echo $limit;?>','<?php echo $searchTextMatch;?>');" >Not Sync</span>
    </td>
    </tr>   
<?php   } $count++; } include_once 'ksession_close.php';  ?>         
</tbody>
</table>
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
				$pagination.= '<a href="javascript:void(0)" onclick="changePagination(\''.$lastpage.'\',\''.$limit.'\',\''.$searchKeword.'\')">'.$lastpage.'</a>';	
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
                 $("#msg").html("Sync Successfully Done");
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