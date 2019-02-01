<?php
include_once 'corefunction.php';
$action=trim(isset($_REQUEST['action']))?$_REQUEST['action']:'';
if(empty($action)){  header("Location:404.php"); exit;  }
switch($action)
{
    case "bulk_delete":
    include_once("config.php");
    $filter = null;
    $filter = new KalturaMediaEntryFilter();
    $filter->typeEqual = KalturaEntryType::MEDIA_CLIP;
    $deleteentryID = (isset($_POST['entryIDs']))? $_POST['entryIDs']: "";
    $deleteentryID=rtrim($deleteentryID,',');
    $muldelEntryID=explode(",",$deleteentryID);
    $activeEntry=array(); 
    foreach ($muldelEntryID as $deleid) {
          
            $sql="select count('$deleid') as entryCount from slider_image_detail where ventryid='$deleid' and img_status='1'";
            $row= db_select($conn,$sql);
            $entryCount=$row[0]['entryCount'];
            if($entryCount>=1)
             {    
                $activeEntry[]=$deleid;
             }
            else
            {    
                $result = $client->baseEntry->delete($deleid);
                $delEntry="update entry set status='3' where entryid='$deleid'";
                $entrytable = db_query($conn,$delEntry);
                if($entrytable){
                  /*----------------------------update log file begin-------------------------------------------*/    
                  $error_level=1;$msg="Delete Video entry($deleid)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
                  $qry='';
                  write_log($error_level,$msg,$lusername,$qry);
                  /*----------------------------update log file End---------------------------------------------*/ 

                 }
                 else 
                 {
                   /*----------------------------update log file begin-------------------------------------------*/
                   $error_level=5;$msg="Delete Video entry($deleid)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
                   $qry=$insert;
                   write_log($error_level,$msg,$lusername,$qry);
                   /*----------------------------update log file End---------------------------------------------*/ 
                  } 
            }
        }
       $active_count=count($activeEntry);
       if($active_count>0)
       {
            //array_unshift($activeEntry,"3");
            echo $active_entry=trim(implode(",",$activeEntry));
            die();
       }   
       else
       {
           echo 1;
       }    
      
     break; 
    
    
    /*case "bulk_upload_log_list":
    include_once("config.php"); 
    $bulkUploadFilter = new KalturaBulkUploadFilter();
    $bulkUploadFilter->orderBy = '-createdAt';
    $pager = new KalturaFilterPager();
    $pager->pageIndex = 1;
    $pager->pageSize = 10;
    $bulkuploadPlugin = KalturaBulkuploadClientPlugin::get($client);
    $result_bulk_log = $bulkuploadPlugin->bulk->listAction($bulkUploadFilter, $pager);
    $total_pages=$result_bulk_log->totalCount;
    $bulklog=array(); 
    foreach($result_bulk_log->objects as $bulkLog) {
        $bulklog[]=$bulkLog;
    }
    echo json_encode(array('success' => 1,'data' =>$bulklog,'totalCount' => $total_pages));
    $client->session->end(); // this function use KS_session Close.    
    break; */ 
    case "downlaod_bulkupload_log_file":
    $fileName=$_GET['fileName']; $durl=$_GET['durl']; $act=$_GET['act'];
    if($act=='download_log_file'){ $fileName_new=$fileName."_log.CSV"; }
    if($act=='download_oringinal_file'){ $fileName_new=$fileName; }
    $result = file_get_contents($durl);
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=".$fileName_new."");
    header("Pragma: no-cache");
    header("Expires: 0");
    print $result;
    break; 
    case "bulk_view_entries_data":
    include_once 'function.php';    
    $kjobid= (isset($_POST['kjobid']))? $_POST['kjobid']: "";
    $page= (isset($_POST['pageNum']))? $_POST['pageNum']: "";
    $pagelimit = (isset($_POST['limitval']))? $_POST['limitval']: 10; 
    $query = "SELECT bulk_upload_job_id FROM kaltura.bulk_upload_result  where bulk_upload_job_id='$kjobid' and partner_id='$partnerID' "; 
    $total_pages = db_totalRow($conn,$query);
    $limit = $pagelimit; 
    if($page) 
        $start = ($page - 1) * $limit; 			
    else
    $start = 0;
    $bulkkquery="SELECT line_index,object_id,status,object_status,row_data,created_at FROM kaltura.bulk_upload_result
    where bulk_upload_job_id='$kjobid' and partner_id='$partnerID' LIMIT $start, $limit ";    
    $fetchKalturaBulk =db_select($conn,$bulkkquery);
    ?>
    <table id="example1" class="table table-fixedheader table-bordered table-striped" style="width: 100%;">
    <thead>
            <tr>
                   <th>Entry ID</th>
                   <th>Entry Name</th>
                   <th>Created At</th>
                   <th>Status</th>
            </tr> 
    </thead>
    <tbody>
   <?php
   $count=1;
   foreach($fetchKalturaBulk as $fetch)
   {
    $line_index=$fetch['line_index']; $object_id=$fetch['object_id']; $status=$fetch['object_status']; 
    $created_at=$fetch['created_at']; 
    $rowData=$fetch['row_data']; $entryname=  explode(',',$rowData); $entryName=$entryname[0];
    if($status=='-1') { $statusc="error_converting"; }
    if($status=='-2') { $statusc="error_importing"; }
    if($status==2) { $statusc="Ready"; }
    if($status==0) { $statusc="import"; }
    if($status==1) { $statusc="Preconvert"; }
    if($status==2) { $statusc="Ready"; }
    if($status==4) { $statusc="Pending"; }
    ?> 
        <tr>
        <td><?php echo $object_id; ?></td>    
        <td><?php echo $entryName; ?></td>
        <td><?php echo $created_at ;?></td>
        <td><?php echo $statusc ?></td>
        </tr>
<?php $count++; } ?>         
</tbody>
</table>
<?php  /* new paging code............*/
//$page = 1;					//if no page var is given, default to 1.
$prev = $page - 1;							//previous page is page - 1
$next =  $page + 1;
//$limit=$pager->pageSize;							//next page is page + 1
$lastpage = ceil($total_pages/$limit);
$adjacents = 2;				
$lpm1 = $lastpage - 1;					
$pagination = "";
if($lastpage > 1)
{	
$pagination .= "<div class=\"pagination\">"; 
    //previous button
    if ( $page > 1)   
     $pagination.= '<a href="javascript:void(0)" onclick="changePagination_view_category_entry(\''.$prev.'\',\''.$limit.'\',\''.$kjobid.'\')">Previous</a>';		
    else
            $pagination.= "<span class=\"disabled\"> Previous</span>";	
    //pages	
    if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
    {	
            for ($counter = 1; $counter <= $lastpage; $counter++)
            {
                    ?>
            <?php 	if ($counter ==  $page)
                            $pagination.= "<span class=\"current\">$counter</span>";
                    else

                        $pagination.= '<a href="javascript:void(0)" onclick="changePagination_view_category_entry(\''.$counter.'\',\''.$limit.'\',\''.$kjobid.'\')">'.$counter.'</a>';		

            }
    }
    elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
    {
            //close to beginning; only hide later pages
            if( $page < 1 + ($adjacents * 2))		
            {
                    for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
                    {
                            if ($counter ==  $page)
                                    $pagination.= "<span class=\"current\">$counter</span>";
                            else
                                    //$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";	
                                $pagination.= '<a href="javascript:void(0)" onclick="changePagination_view_category_entry(\''.$counter.'\',\''.$limit.'\',\''.$kjobid.'\')">'.$counter.'</a>';				
                    }
                    $pagination.= "...";
                    //$pagination.= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>"; 
                    $pagination.= '<a href="javascript:void(0)" onclick="changePagination_view_category_entry(\''.$lpm1.'\',\''.$limit.'\',\''.$kjobid.'\')">'.$lpm1.'</a>';

                    //$pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";	
                    $pagination.= '<a href="javascript:void(0)" onclick="changePagination_view_category_entry(\''.$lastpage.'\',\''.$limit.'\',\''.$kjobid.'\')">'.$lastpage.'</a>';	
            }
            //in middle; hide some front and some back
            elseif($lastpage - ($adjacents * 2) >  $page &&  $page > ($adjacents * 2))
            {

                    $pagination.= '<a href="javascript:void(0)" onclick="changePagination_view_category_entry(\'1\',\''.$limit.'\',\''.$kjobid.'\')">1</a>';	
                    $pagination.= '<a href="javascript:void(0)" onclick="changePagination_view_category_entry(\'2\',\''.$limit.'\',\''.$kjobid.'\')">2</a>';
                    $pagination.= "...";
                    for ($counter =  $page - $adjacents; $counter <=  $page + $adjacents; $counter++)
                    {
                            if ($counter ==  $page)
                                    $pagination.= "<span class=\"current\">$counter</span>";
                            else

                            $pagination.= '<a href="javascript:void(0)" onclick="changePagination_view_category_entry(\''.$counter.'\',\''.$limit.'\',\''.$kjobid.'\')">'.$counter.'</a>';				
                    }
                    $pagination.= "...";
                    $pagination.= '<a href="javascript:void(0)" onclick="changePagination_view_category_entry(\''.$lpm1.'\',\''.$limit.'\',\''.$kjobid.'\')">'.$lpm1.'</a>';
                    $pagination.= '<a href="javascript:void(0)" onclick="changePagination_view_category_entry(\''.$lastpage.'\',\''.$limit.'\',\''.$kjobid.'\')">'.$lastpage.'</a>';	
            }
            //close to end; only hide early pages
            else
            {

                    $pagination.= '<a href="javascript:void(0)" onclick="changePagination_view_category_entry(\'1\',\''.$limit.'\',\''.$kjobid.'\')">1</a>';	

                    $pagination.= '<a href="javascript:void(0)" onclick="changePagination_view_category_entry(\'2\',\''.$limit.'\',\''.$kjobid.'\')">2</a>';
                    $pagination.= "...";
                    for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
                    {
                            if ($counter ==  $page)
                                    $pagination.= "<span class=\"current\">$counter</span>";
                            else

                                    $pagination.= '<a href="javascript:void(0)" onclick="changePagination_view_category_entry(\''.$counter.'\',\''.$limit.'\',\''.$kjobid.'\')">'.$counter.'</a>';					
                    }
            }
    }

    //next button
    if ( $page < $counter - 1) 
        $pagination.= '<a href="javascript:void(0)" onclick="changePagination_view_category_entry(\''.$next.'\',\''.$limit.'\',\''.$kjobid.'\')">Next</a>';	 
    else
            $pagination.= "<span class=\"disabled\">Next </span>";
    $pagination.= "</div>\n";		
	}
     ?>
    <div class="page" style="border: 0px solid red; margin-top: 20px; text-align: center; background-color:#fff !important; height:40px;">
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

    <?php
    sleep(1);
    break;
    case "transcoded_video_info":
        $show=$_POST['show']; 
        $queryCondt='';
        if($show=='all')
        {
            $queryCondt='';
        } 
        if($show=='search_month')
        {
            $month=$_POST['month']; $year=$_POST['year'];
            $queryCondt=" And MONTH(created_at) = $month and YEAR(created_at) = $year ";
        }    
        $count ="SELECT
            IF(video_status='active' ,SEC_TO_TIME(SUM(duration)),0) actdur,SUM(IF(video_status='active' ,1,0)) actcount,
            IF(video_status='inactive' ,SEC_TO_TIME(SUM(duration)),0) inactdur,SUM(IF(video_status='inactive' ,1,0)) inactcount
            FROM entry  WHERE `type`='1' AND `status`='2' AND duration IS NOT NULL $queryCondt GROUP BY video_status"; 
            $fetch = db_select($conn,$count);

           $actdur=$fetch[0]['actdur']; 
           $actcount=$fetch[0]['actcount'];
           $inactdur=$fetch[1]['inactdur']; $inactcount=$fetch[1]['inactcount'];
           $totalqry ="select SEC_TO_TIME(SUM(duration)) as vlength,count(entryid) as totalcount
            from entry where type='1' and (status='2' OR status='3') AND duration IS NOT NULL $queryCondt";
           $fetchTotal = db_select($conn,$totalqry);
           $total_video=$fetchTotal[0]['totalcount']; $vlength=$fetchTotal[0]['vlength'];
         
           $deletedQry =" SELECT IF(status='3',SEC_TO_TIME(SUM(duration)),0) deldur, SUM(IF(status='3',1,0)) delcount
           FROM entry  WHERE type='1' and status='3' AND duration IS NOT NULL $queryCondt GROUP BY  status";
          
           $fetchDeleted = db_select($conn,$deletedQry);
           $deldur=$fetchDeleted[0]['deldur']; $delcount=$fetchDeleted[0]['delcount'];
           $row2=array('actdur' =>substr($actdur, 0, -7),'actcount' => $actcount,
            'inactdur' => substr($inactdur, 0, -7),'inactcount' => $inactcount,'total_video' => $total_video,'vlength' => substr($vlength, 0, -7),
            'deldur' => substr($deldur, 0, -7),'delcount' => $delcount);
          $result[]= $row2;
          sleep(1);
          echo json_encode(array('status' =>1,'data' =>$result));
          db_close($conn);
        break; 
    case "category_tree_view_data":
    
    function membersTree($parentKey)
     {
       global $conn;
       $sql_main = "SELECT category_id,parent_id,cat_name,fullname,status,priority
                    from  categories where parent_id='$parentKey' and status!='3'";
       $fetchCat=  db_select($conn,$sql_main);
       //echo "santosh".$totalRow = mysqli_num_rows($resultq);
       foreach($fetchCat as $value){
       $id = $value['category_id'];
       $row1[$id]['category_id'] = $value['category_id'];
       $row1[$id]['cat_name'] = $value['cat_name'];
       $row1[$id]['priority'] = $value['priority'];
       $row1[$id]['status'] = $value['status'];
       $sql_main_child = "SELECT category_id from  categories where parent_id='$id' and status!='3'";
       $totalChild = db_totalRow($conn, $sql_main_child);
       $row1[$id]['children_data']='0';
       if($totalChild>0){
           $row1[$id]['children_data'] = array_values(membersTree($id));
          }
       }
      return $row1;
    }
    $parentKey=$_POST['parent_id'];
    $sql = "SELECT category_id  FROM categories where status!='3'";
    $totalRow= db_totalRow($conn, $sql);
    if($totalRow > 0)
    {
      //echo "parentid==".$parentKey;
      $data =membersTree($parentKey);
      }else{
       $data=["category_id"=>"0","cat_name"=>"No category present in list","text"=>"No category is present in list","nodes"=>[]];
    }
    echo json_encode(array('items'=>array_values($data)));
    // echo json_encode(array_values($data)); 
    break;    
    
    
}

?>

