<?php
include_once 'corefunction.php';
$action=$_POST['action'];
//$("#results").load("save_entry.php",{entryid:entryid,name:name,type:type,
//thumbnailurl:thumbnailurl,desc:desc,tags:tags,created_at:created_at,action:'save_entry',vstatus:video_status}, 
switch($action)
{
     case "save_entry":
     $entry_id=$_POST['entryid'];  $type=$_POST['type'];$thumbnailurl=$_POST['thumbnailurl'];
     $video_status=$_POST['vstatus']; $upload_by_userid=$_POST['userid'];
     $createdAt=$_POST['created_at'];$createdAt_convert=date("Y-m-d H:i:s",$createdAt);
     $name=db_quote($conn,$_POST['name']); $description=db_quote($conn,$_POST['desc']);
     $tags=db_quote($conn,$_POST['tags']); $upload_url=$_POST['upload_url']; $status=$_POST['kalstatus']; 
     $upload_entry="Insert into entry(entryid,name,thumbnail,longdescription,type,tag,status,ispremium,created_at,video_status,puser_id)
     values('$entry_id',$name,'$thumbnailurl',$description,'$type',$tags,'$status','0','$createdAt_convert','inactive','$upload_by_userid')";
     $uploadEntry= db_query($conn,$upload_entry);
     if($uploadEntry)
     {
     /*----------------------------update log file begin-------------------------------------------*/
     $error_level=1;$msg="Save New video($entry_id)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
     $qry='';
     write_log($error_level,$msg,$lusername,$qry);
     if(is_file($upload_url)){
       unlink($upload_url);
     } 
     echo 1;
     exit;
     /*----------------------------update log file End---------------------------------------------*/  
    }
   else
   {
       /*----------------------------update log file begin-------------------------------------------*/
     $mysql_error=mysqli_error($conn);
     $error_level=5; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
     $qry=$upload_entry;
     if(is_file($upload_url)){
       unlink($upload_url);
     } 
     echo 0;
     exit;
     
   }      

    break; 
     case "save_entry_ugc":
     $entry_id=$_POST['entryid'];  $type=$_POST['type'];$thumbnailurl=$_POST['thumbnailurl'];
     $video_status=$_POST['vstatus']; $upload_by_userid=$_POST['userid']; $ugc_id=$_POST['ugc_id'];
     $createdAt=$_POST['created_at'];$createdAt_convert=date("Y-m-d H:i:s",$createdAt);
     $name=db_quote($conn,$_POST['name']); $description=db_quote($conn,$_POST['desc']); 
     $tags=db_quote($conn,$_POST['tags']); $upload_url=$_POST['upload_url']; $status=$_POST['kalstatus']; 
     $upload_entry="Insert into entry(entryid,name,thumbnail,longdescription,type,tag,status,ispremium,created_at,video_status,puser_id)
     values('$entry_id',$name,'$thumbnailurl',$description,'$type',$tags,'$status','0','$createdAt_convert','inactive','$upload_by_userid')";
     $uploadEntry= db_query($conn,$upload_entry);
     // update ugc table
     $upugc="update ugc_entry set status='$status',entryid='$entry_id' where id='$ugc_id'";
     db_query($conn,$upugc);
     if($uploadEntry)
     {
     /*----------------------------update log file begin-------------------------------------------*/
     $error_level=1;$msg="Save New video using UCG($entry_id)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
     $qry='';
     write_log($error_level,$msg,$lusername,$qry);
     if(is_file($upload_url)){
       unlink($upload_url);
     } 
     echo 1;
     exit;
     /*----------------------------update log file End---------------------------------------------*/  
    }
   else
   {
       /*----------------------------update log file begin-------------------------------------------*/
     $mysql_error=mysqli_error($conn);
     $error_level=5; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
     $qry=$upload_entry;
     if(is_file($upload_url)){
       unlink($upload_url);
     } 
     echo 0;
     exit;
     
   } 
   break;
     
     
}

?>
