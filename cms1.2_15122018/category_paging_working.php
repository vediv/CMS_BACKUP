<?php 
include_once 'corefunction.php';
$searchKeword = (isset($_POST['searchInputall']))? $_POST['searchInputall']: "";
$page =(isset($_POST['pageNum']))? $_POST['pageNum']: 0;
$get_refresh = (isset($_POST['refresh']))? $_POST['refresh']: "";
include_once("config.php");
$filter = null; $pager = null;
$res = $client->category->listAction($filter, $pager);
$totalCategoryCount=$res->totalCount;
$category_id_from_k=array();
foreach ($res->objects as $catgeoryEntry)
{   
   $category_id_from_k[]=$catgeoryEntry->id;     }
   print_r($category_id_from_k);
?>
<div class="box-header">
    <div class="row" style="border: 0px solid red; margin: -25px 5px 10px 5px;">
    <table border='0' style="width:98%; margin-left: 10px;">
    <tr>
    <td width="15%"><input type="button"  class="btn-primary btn-xs" value="Set Priority" onclick="setPriority();" ></td>
    <td width="55%">
        <form class="navbar-form" role="search" method="post" style="  padding: 0 !important;">
               <div class="input-group add-on" style="float: right;">
               <input id='pagelimit' type="hidden" height="30px"  value="<?php echo $pagelimit; ?>">   
               <input class="form-control" size="30"  placeholder="Search Entries"  autocomplete="off" name='searchQuery' id='searchInput' class="searchInput" type="text" value="<?php echo $searchKeword; ?>">
               <div class="input-group-btn">
               <button class="enableOnInput btn btn-default" disabled='disabled' id='submitBtn' type="button" style="height: 26px;   padding: 4px 6px !important;" ><i class="glyphicon glyphicon-search"></i></button>	
               <!--<button class="enableOnInput btn btn-default" disabled='disabled' id='clearcBtn' type="button" >
               <span class="glyphicon glyphicon-remove"></span>
               </button>-->	
               </div>
               </div>
          </form>
    </td>
    <!--<td width="10%">
     <div class="col-xs-1 hidden-xs hidden-sm pull-right" style="border:none;  margin-top:10px !important;">   
     <a href="javascript:void(0)" onclick="return refreshcontent('refresh');" title="refresh" style="float: right"><i class="fa fa-refresh" aria-hidden="true"></i></a>   
     </div>
     </td>-->
    <td width="5%">
     <div class="col-xs-1 hidden-xs hidden-sm pull-right" style="border:none;  margin-top:10px !important;">   
     <a href="javascript:void(0)" onclick="return refreshcontent('refresh','<?php echo $page; ?>','<?php echo $searchKeword;?>');" title="Refresh & Sync" style="float: right"><i class="fa fa-refresh" aria-hidden="true"></i></a>   
     </div>
     </td>
    </tr>
</table>
<div class="">
  <div class="pull-left" id="flash" style="text-align: center;"></div> 
</div>        
</div>
<?php 
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
    $moveEntriesToParentCategory = KalturaNullableBoolean::NULL_VALUE;
    //$moveEntriesToParentCategory = null;
    $result = $client->category->delete($deleteentryID,$moveEntriesToParentCategory);
    $delete1 = "DELETE FROM categories where category_id='$deleteentryID'";
    $dc=db_query($conn,$delete1);
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
    $pageindex_when_delete = (isset($_POST['pageindex']))? $_POST['pageindex']: "";
    $pager->pageIndex=$pageindex_when_delete;  
    
    
break;
/***** following Case doing  delete all category with subcategory  ***/
case "delete_with_sub_category":
     $delcategoryid = (isset($_POST['entryID']))? $_POST['entryID']: "";
     $parent_id = (isset($_POST['parent_id']))? $_POST['parent_id']: "";
     $qry="select category_id,parent_id from categories where parent_id='".$delcategoryid."'";
     $fcid=  db_select($conn,$qry);
     foreach($fcid as $fetcid)
     {   
         $category_id=$fetcid['category_id']; $parentid=$fetcid['parent_id']; 
         $delete1 = "DELETE FROM categories where category_id='".$category_id."' and parent_id='".$delcategoryid."'";
         $dc=db_query($conn,$delete1);
         // this category id remove from entry table in categoryid column
         $updateeEntryTable="update entry set categoryid=TRIM(BOTH ',' FROM REPLACE(CONCAT(',',categoryid,',') , ',$category_id,', ',')) where FIND_IN_SET($category_id,categoryid)";
         $uEntry=db_query($conn,$updateeEntryTable);
         $delete2 = "DELETE FROM category_thumb_icon_url where category_id='".$category_id."'";
         $dcu=db_query($conn,$delete2);
     }
    $deletem = "DELETE FROM categories where category_id='$delcategoryid'";
    $dc=db_query($conn,$deletem);
    // this category id remove from entry table in categoryid column
    $updateeEntryTable="update entry set categoryid=TRIM(BOTH ',' FROM REPLACE(CONCAT(',',categoryid,',') , ',$delcategoryid,', ',')) where FIND_IN_SET($delcategoryid,categoryid)";
    $uEntry=db_query($conn,$updateeEntryTable);
     
     /*----------------------------update log file begin-------------------------------------------*/
     $error_level=1;$msg="delete Category($delcategoryid)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
     $qry=$delete1;
     write_log($error_level,$msg,$lusername,$qry);
  /*----------------------------update log file End---------------------------------------------*/ 
    $delete_url = "DELETE FROM category_thumb_icon_url where category_id='$delcategoryid'";
    $dcu=db_query($conn,$delete_url);
    $moveEntriesToParentCategory = KalturaNullableBoolean::NULL_VALUE;
    $result = $client->category->delete($delcategoryid, $moveEntriesToParentCategory);
    $pageindex_when_delete = (isset($_POST['pageindex']))? $_POST['pageindex']: "";
    $pager->pageIndex=$pageindex_when_delete;  
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
$upp="UPDATE category_thumb_icon_url SET host_url_thumb='$host_url_t_edit',t_original_url='$t_original_url',
t_small_url='$t_small_url',t_mediam_url='$t_mediam_url',t_large_url='$t_large_url',
t_custom_url='$t_custom_url',updated_at=NOW() where category_id='$category_ID'";
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
$u="UPDATE category_thumb_icon_url SET host_url_icon='$host_url_i_edit',i_original_url='$i_original_url',i_small_url='$i_small_url',i_mediam_url='$i_mediam_url',i_large_url='$i_large_url',i_custom_url='$i_custom_url',updated_at=NOW() WHERE category_id='$category_ID'";
$fire=db_query($conn,$u);
}
$page=$pageindex_when_edit;   
break;    
case "update_priority":
   echo "Priority updated successfully.";
    break;
case "refresh":
    $filter = new KalturaCategoryFilter();
    $filter->orderBy = '-createdAt';
    $pager = new KalturaFilterPager();
    $pager->pageSize = $pagelimit;
    if($page==0){ $page=1; }
    $pager->pageIndex = $page;
    $res = $client->category->listAction($filter, $pager);
    foreach ($res->objects as $Catgory) {                                    
         $categoryID=$Catgory->id;
         $query = "SELECT COUNT(category_id) as totalnum FROM categories where category_id='".$categoryID."'";
         $totalpages =db_select($conn,$query);
         $total_pages = $totalpages[0]['totalnum'];
         $depth=$Catgory->depth; $parentId=$Catgory->parentId; $depth=$Catgory->depth; $partnerId=$Catgory->partnerId; 
         $name=db_quote($conn,$Catgory->name);  
         $fullname=db_quote($conn,$Catgory->fullName);$fullids=$Catgory->fullIds;$entry_count=$Catgory->entriesCount;
         $directSubCategoriesCount=$Catgory->directSubCategoriesCount;$description=db_quote($conn,$Catgory->description);
         $tags=db_quote($conn,$Catgory->tags);$direct_entries_count=$Catgory->directEntriesCount;
         if($total_pages>0)
         {
            $upsync="update categories set parent_id='$parentId',dept='$depth',cat_name=$name,fullname=$fullname,fullids='$fullids',entry_count='$entry_count',direct_sub_categories_count='$directSubCategoriesCount',description=$description,tags=$tags,direct_entries_count='$direct_entries_count' where category_id='".$categoryID."'";
            $exe=db_query($conn,$upsync);
            
         }    
         if($total_pages==0)
         {
            $insert="insert into categories(category_id,parent_id,dept,partner_id,cat_name,fullname,fullids,entry_count,direct_sub_categories_count,description,tags,created_at,updated_at,duser_id,priority,) 
            Select '$categoryID','$parentId','$depth','$partnerId',$name,$fullname,'$fullids','$entry_count','$directSubCategoriesCount',$description,$tags,NOW(),Now(),'$get_user_id',ifnull(max(priority),0)+1,'$direct_entries_count' from categories";
            $exe=db_query($conn,$insert);
         }    
    }  
     /*----------------------------update log file begin-------------------------------------------*/
    $error_level=1;$msg="Sync Category"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
    $qry='';
    write_log($error_level,$msg,$lusername,$qry);
    /*----------------------------update log file End---------------------------------------------*/
    
    echo "Sync Successfully Done.";
    break;
}
//and fullname like '%ON DEMAND%' 
$query_search='';
if($searchKeword!='')
{
    $query_search = " where (cat.fullname LIKE '%". $searchKeword . "%' or cat.cat_name LIKE '" . $searchKeword . "%')";
}    
//***** following code doing delete end ***/				
$adjacents = 3;
    $query = "SELECT COUNT(category_id) as num FROM categories cat  $query_search ";
    $totalpages =db_select($conn,$query);
    $total_pages = $totalpages[0]['num'];
    $limit = 15; 
    if($page) 
            $start = ($page - 1) * $limit; 			//first item to display on this page
    else
            $start = 0;

$sql="SELECT cat.catid,cat.category_id,cat.cat_name,cat.parent_id,cat.created_at,cat.priority,cat.fullname,cat.direct_sub_categories_count,cat.direct_entries_count,cti.t_mediam_url,cti.t_small_url,cti.i_small_url,cti.host_url_thumb,cti.host_url_icon FROM categories  cat 
LEFT JOIN category_thumb_icon_url cti ON cat.category_id = cti.category_id $query_search order by cat.catid DESC LIMIT $start, $limit";
$que = db_select($conn,$sql);
$countRow=  db_totalRow($conn,$sql);
if($countRow==0)
{die("<div align='center'><strong>No Record Found</strong> </div><br/>");}   
/* Setup page vars for display. */
?>
<form id="form" name="myform" style="border: 0px solid red;" method="post" action="priority.php">
  <table id="example1" class="table table-fixedheader table-bordered table-striped" style="width: 100%;">
    <thead>
        <tr>
       <th><!-- <input type="checkbox" id="ckbCheckAll">--></th>
        <th>Thumbnail</th>
        <th>Icon</th>
         <th>ID</th>
         <th width="20%">Name</th>
         <th width="20%">Full-Name</th>
         <th>Priority</th>
         <th>Created On</th>
         <th title="Sub-Categories">Sub-Cat</th>
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
     $status=$fetch['status'];
     if(!empty($t_small_url))
     {
           $imgthumb='<img class="img-responsive customer-img" src="'.$host_url_thumb.$t_small_url.'"  height="30" width="90" >';
     } 
     if(!empty($i_small_url))
     {
           $imgicon='<img class="img-responsive customer-img" style="background-color: black;" src="'.$host_url_icon.$i_small_url.'"  height="25" width="40" >';
     } 
     $fullname=$fetch['fullname'];   $directSubCategoriesCount=$fetch['direct_sub_categories_count'];;   
     $directEntriesCount=$fetch['direct_entries_count'];
     if(in_array($id, $category_id_from_k))
     {
     ?> 
    <tr id="<?php echo $count."_r"; ?>">
    <td></td>
    <td><?php echo $imgthumb; ?></td>
    <td><?php echo $imgicon; ?></td>
    <td><?php echo $id;?></td>
    <td><a href="javascript:void(0)" title="View Detail" onclick="categoryEdit('<?php echo $id; ?>','<?php echo $page; ?>')">
    <?php echo wordwrap($name,40, "\n", true); ?>
     </a></td>
    <td><?php echo wordwrap($fullname,40, "\n", true); ?></td>
    <td><?php echo $priority; ?></td>
    <td><?php echo $createdAt; ?></td>
    <td> <?php echo  $directSubCategoriesCount; ?></td>
    <td><?php echo  $directEntriesCount; ?></td>
    <td>
    <div class="dropdown">
     <?php   if(in_array("3", $UserRight)){ ?>
      <a href="javascript:void(0)" class="myBtnn" onclick="view_category_entry('<?php echo $id; ?>')"><i class="fa fa-eye" aria-hidden="true" data-toggle="tooltip" data-placement="left"  title="View Entries"></i></a>
      <?php } if(in_array("2", $UserRight)){ ?>    
      <a href="javascript:void(0)" class="myBtn" onclick="categoryEdit('<?php echo $id; ?>','<?php echo $page; ?>')"><i class="fa fa-pencil-square-o" aria-hidden="true" data-toggle="tooltip" data-placement="left"  title="Edit" style="padding-left: 8px  !important;"></i></a>
      <a href="javascript:void(0)" class="myBtn" onclick="categoryEdit('<?php echo $id; ?>','<?php echo $page; ?>')"><i class="fa fa-pencil-square-o" aria-hidden="true" data-toggle="tooltip" data-placement="left"  title="Edit" style="padding-left: 8px  !important;"></i></a>
      
      <?php } if(in_array("4", $UserRight)){ ?>
       <a href="javascript:void(0)" onclick="return deleteContent('<?php echo $id; ?>','deletecontent','<?php echo $page; ?>','<?php echo $parent_id; ?>','<?php echo $directSubCategoriesCount;  ?>')"><i class="fa fa-trash-o" data-toggle="tooltip" data-placement="left"  aria-hidden="true" title="Delete" style="padding-left: 8px  !important;"></i>
      </a> 
       <?php } ?>
     </div>
    </td>
    </tr>   
    <?php  }else{  echo $id;?>
       
    <?php   } $count++; } ?>         
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
		 $pagination.= '<a href="javascript:void(0)" onclick="changePagination(\''.$prev.'\',\''.$searchKeword.'\')"><i class="fa fa-long-arrow-left" aria-hidden="true"></i> Previous</a>';		
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
				$pagination.= '<a href="javascript:void(0)" onclick="changePagination(\''.$counter.'\',\''.$searchKeword.'\')">'.$counter.'</a>';		
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
				     $pagination.= '<a href="javascript:void(0)" onclick="changePagination(\''.$counter.'\',\''.$searchKeword.'\')">'.$counter.'</a>';				
				}
				$pagination.= "...";
				$pagination.= '<a href="javascript:void(0)" onclick="changePagination(\''.$lpm1.'\',\''.$searchKeword.'\')">'.$lpm1.'</a>';
				$pagination.= '<a href="javascript:void(0)" onclick="changePagination(\''.$lastpage.'\',\''.$searchKeword.'\')">'.$lastpage.'</a>';	
			}
			//in middle; hide some front and some back
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				//$pagination.= "<a href=\"$targetpage?page=1\">1</a>";
				$pagination.= '<a href="javascript:void(0)" onclick="changePagination(\'1\',\''.$searchKeword.'\')">1</a>';	
				//$pagination.= "<a href=\"$targetpage?page=2\">2</a>";
				$pagination.= '<a href="javascript:void(0)" onclick="changePagination(\'2\',\''.$searchKeword.'\')">2</a>';
				$pagination.= "...";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
					$pagination.= '<a href="javascript:void(0)" onclick="changePagination(\''.$counter.'\',\''.$searchKeword.'\')">'.$counter.'</a>';				
				}
				$pagination.= "...";
				$pagination.= '<a href="javascript:void(0)" onclick="changePagination(\''.$lpm1.'\',\''.$searchKeword.'\')">'.$lpm1.'</a>';
				$pagination.= '<a href="javascript:void(0)" onclick="changePagination(\''.$lastpage.'\',\''.$searchKeword.'\')">'.$lastpage.'</a>';	
			}
			//close to end; only hide early pages
			else
			{
				
				$pagination.= '<a href="javascript:void(0)" onclick="changePagination(\'1\',\''.$searchKeword.'\')">1</a>';	
				$pagination.= '<a href="javascript:void(0)" onclick="changePagination(\'2\',\''.$searchKeword.'\')">2</a>';
				$pagination.= "...";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						
						$pagination.= '<a href="javascript:void(0)" onclick="changePagination(\''.$counter.'\',\''.$searchKeword.'\')">'.$counter.'</a>';					
				}
			}
		}
		
		//next button
		if ($page < $counter - 1) 
			
		    $pagination.= '<a href="javascript:void(0)" onclick="changePagination(\''.$next.'\',\''.$searchKeword.'\')">Next <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>';	 
		else
			$pagination.= "<span class=\"disabled\">Next <i class='fa fa-long-arrow-right' aria-hidden='true'></i>  </span>";
		$pagination.= "</div>\n";		
	}


?>          

<div class="page" style="border: 0px solid red; text-align: center; background-color:#fff !important; height:40px;">
 <!--<div class="pull-left">
		<div class="dropdown">
		 <a data-target="#"  data-toggle="dropdown" class="dropdown-toggle">Bulk Actions<b class="caret"></b></a>
		  <ul class="dropdown-menu">
		  		<input type="hidden" value="<?php //echo $pager->pageIndex; ?>" id="pageindex">
		   <li><a href="#"  id="delete_bulk" >Delete</a></li>
		 
		   <li><a href="#" class="planbulk" pageindex="<?php //echo $pager->pageIndex; ?>">Add Plan</a></li>
		  </ul>   
		</div>
 </div>-->
<div class="col-md-12 pull-right" style="border:0px solid red;margin-top: 0px; min-height: 20px;">
  
<?php if($start==0) { $startShow=1; 
       $lmt=$limit<$total_pages ? $limit :$total_pages;
       }
      else { $startShow=$start+1;  $lmt=$start+$countRow;  }
 ?>
<div class="col-md-3 pull-left" style="border: 0px solid red;">
 Showing <?php echo $startShow; ?>  to <?php echo $lmt; ?>   of <?php echo $total_pages; ?> entries </div>
<?php echo $pagination;?></div> 
 
</div>

</form> 
 <script type="text/javascript">
/* thsi is for model JS with edit and view detail */
function categoryEdit(categoryID,EntryPageindex) 
{
   $("#myModal_category_view").modal();
   $("#flash").fadeIn(200).html('Loading <img src="img/image_process.gif" />');
   var info = 'Entryid=' + categoryID+"&pageindex="+EntryPageindex; 
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

function changePagination(pageid,searchtext){
      $("#flash").show();
      $("#flash").fadeIn(800).html('Loading <img src="img/image_process.gif" />');
      var dataString = 'pageNum='+ pageid+'&searchInputall='+ searchtext;
     $.ajax({
           type: "POST",
           url: "category_paging.php",
           data: dataString,
           cache: false,
           success: function(result){
          //  alert(result);
           	 $("#results").html('');
                 $("#flash").hide();
           	 $("#results").html(result);
           }
     }); 
}
function deleteContent(entryID,delname,pageindex,parent_id,subcategorycount){

            if(subcategorycount==0)
            {
               var msg="Are you sure you want to delete the selected Category  ?";
                var dataString ='entryID='+ entryID +"&categoryaction="+delname+"&pageindex="+pageindex+"&parent_id="+parent_id;
            }
            if(subcategorycount>0)
            {
             var  msg="The category will be deleted with its sub-categories. \nDo you want to continue?";
             var dataString ='entryID='+ entryID +"&categoryaction=delete_with_sub_category&pageindex="+pageindex+"&parent_id="+parent_id;
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
function delete_category_entry(categoryid,entryid,trcount,publisher_id)
{
      var apiURl="<?php  echo $apiURL."/category_delete" ?>";   
      var apiBody = new FormData();
      apiBody.append("partnerid",publisher_id); 
      apiBody.append("entryid",entryid);
      apiBody.append("catid",categoryid);
      var d=confirm("Are you sure you want to Delete This entry from Category ?");
      if(d)
      {
       $.ajax({
                url:apiURl,
                method: 'POST',
                dataType: 'json', 
                data:apiBody,
                processData: false,
                contentType: false,
                    success: function(jsonResult){
                    //console.log(jsonResult);  
                    var Status=jsonResult.Status;
                    if(Status=="1")
                    {
                         document.getElementById('remove_msg').innerHTML="Entry successfully deleted from category";
                         $("#rmv" + trcount).remove();
                    }    
               
                 }
            });
        } 
    
}
function changePagination_view_category_entry(pageid,limitval,categoryid){
     $("#remove_msg").fadeIn(100).html('Wait <img src="img/image_process.gif" />');
     var dataString ='first_load='+ pageid+'&limitval='+limitval+'&categoryID='+categoryid+'&action=view_category_entry';
     //$("#paging_result").html();
     $.ajax({
           type: "POST",
           url: "categories_view_entry.php",
           data: dataString,
           cache: false,
           success: function(result){
             //  alert(result);
           	 $("#view_category_entry").html('');
                 $("#remove_msg").hide();
           	 $("#view_category_entry").html(result);
           }
      });
}

$(function(){
        $('#searchInput').keyup(function(){
       //$("#searchInput").('keyup', function() {
          if ($(this).val() == '') { //Check to see if there is any text entered
                //If there is no text within the input ten disable the button
                $("#submitBtn").show();  
		        $("#clearcBtn").hide();  
		        $('.enableOnInput').prop('disabled', true);
                var searchInputall = $('#searchInput').val();
                var dataString ='searchInputall='+ searchInputall;
		            $.ajax({
		            type: "POST",
		            url: "category_paging.php",
		            data: dataString,
		            cache: false,
			        success: function(result){
			           //alert(result);
			            //$("#submitBtn").hide();  
					    $("#clearcBtn").hide();
					    $("#searchword").css("display", "none");      
					    $("#results").html('');
					    $("#flash").hide();
					    $("#results").html(result);
			              }
		              });
            } else {
          	
               //If there is text in the input, then enable the button
               
                var get_string = $('#searchInput').val().length;
               
                if(get_string>=1)
                 {  
                 	$("#submitBtn").show();  
		            $("#clearcBtn").hide();   
		           
                 }
                $('.enableOnInput').prop('disabled', false);
              }
     });
    
       $("#clearcBtn").hide(); 
       $("#searchword").css("display", "none");  
       $('#submitBtn').click(function(){
            $("#flash").show();
            $("#flash").fadeIn(500).html('Loading <img src="img/image_process.gif" />');
               var searchInputall = $('#searchInput').val();
                var dataString ='searchInputall='+ searchInputall;
                //alert(searchInputall);
		           $.ajax({
		           type: "POST",
		           url: "category_paging.php",
		            data: dataString,
		           cache: false,
		           success: function(result){
		           // alert(result);
		           	$("#submitBtn").hide();  
		           	$("#clearcBtn").show();      
		           	$("#results").html('');
		           	$("#flash").hide();
		           	$("#results").html(result);
		           	$("#searchword").css("display", "");
		           	$('#searchword').html(searchInputall);
		           }
		      });
        });
        
		  // this is for cancel button code when click in cancel button then give the blank string....
		       $('#clearcBtn').click(function(){
                            $("#flash").show();
                            $("#flash").fadeIn(500).html('Loading <img src="img/image_process.gif" />');
		               var searchInputall ='';
		                //alert(searchInputall);
		                var dataString ='searchInputall='+ searchInputall;
		                   $.ajax({
				           type: "POST",
				           url: "category_paging.php",
				           data: dataString,
				           cache: false,
				           success: function(result){
				           	$("#submitBtn").show();  
				           	$('.enableOnInput').prop('disabled', true);
				           	$("#clearcBtn").hide();      
				           	$("#results").html('');
				           	$("#flash").hide();
				           	$("#results").html(result);
				            $("#searchInput").val(''); 
				            $("#searchword").css("display", "none");  
				            $('#searchword').html(''); 
				           }
				               });
		        });
});

</script>