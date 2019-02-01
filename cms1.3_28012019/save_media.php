<?php
include_once 'corefunction.php';
include_once("config.php");
$upload_url=$_POST['upload_url']; $inputTitle=$_POST['inputTitle']; $mytags=$_POST['mytags'];
$descrip=$_POST['descrip']; $userID=$_POST['userid'];  $video_status=$_POST['vstatus'];
// for geting upload token
$uploadToken = null;
$result_token = $client->uploadToken->add($uploadToken);
//print '<pre>'.print_r($result_token, true).'</pre>';
$uploadTokenId=$result_token->id;
if($uploadTokenId=='')
{ echo json_encode(array('status' =>1,'msg' =>"Error in uploadind please try some time.")); exit;  }    

$fileData = $upload_url;
$resume = null;
$finalChunk = null;
$resumeAt = null;
$result_upload = $client->uploadToken->upload($uploadTokenId, $fileData, $resume, $finalChunk, $resumeAt);
$file_upload_token=$result_upload->id;
if($file_upload_token=='')
{ echo json_encode(array('status' =>2,'msg' =>"Error in uploadind please try some time.")); exit;  } 
$entry = new KalturaBaseEntry();
$entry->name = $inputTitle;
$entry->description = $descrip;
$entry->userId = $userID;
//$entry->categoriesIds = $categoryid;
$entry->tags = $mytags;
$uploadTokenId = $file_upload_token;
$type = KalturaEntryType::AUTOMATIC;
$result = $client->baseEntry->addfromuploadedfile($entry, $uploadTokenId, $type);

//print '<pre>'.print_r($result, true).'</pre>';
$entry_id=$result->id;  $name=db_quote($conn,$result->name); $thumbnailUrl=$result->thumbnailUrl; 
if($entry_id=='')
{ echo json_encode(array('status' =>3,'msg' =>"Error in uploadind please try some time.")); exit;  } 
$type=$result->type; $description=db_quote($conn,$result->description);
$tags=db_quote($conn,$result->tags);$createdAt=$result->createdAt; $status=$result->status; //$duration=$result->duration;
$createdAt_convert=date("Y-m-d H:i:s", $createdAt);
if($entry_id!='')
{
   $upload_date=date("Y-m-d", $createdAt);
   $upload_entry="Insert into entry(entryid,name,thumbnail,longdescription,type,tag,status,ispremium,created_at,video_status,puser_id)
   values('$entry_id',$name,'$thumbnailUrl',$description,'$type',$tags,'$status','0','$createdAt_convert','inactive','$userID')";
   $uploadEntry= db_query($conn,$upload_entry);
  if($uploadEntry)
   {
     /*----------------------------update log file begin-------------------------------------------*/
     $error_level=1;$msg="Save New video($entry_id)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
     $qry='';
     write_log($error_level,$msg,$lusername,$qry);
    if (is_file($upload_url)){
     unlink($upload_url);
     } 
    include_once 'ksession_close.php'; 
    //echo json_encode(array('status' =>5,'msg' =>"upload successfully")); exit; 
    echo 5;
    exit;
     /*----------------------------update log file End---------------------------------------------*/  
   }
   else
   {
       /*----------------------------update log file begin-------------------------------------------*/
     $mysql_error=mysqli_error($conn);
     $error_level=5; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
     $qry=$upload_entry;
     write_log($error_level,$mysql_error,$lusername,$qry);
      if (is_file($upload_url)){
     unlink($upload_url);
     } 
     //include_once 'ksession_close.php'; 
     echo 6;
     //echo json_encode(array('status' =>6,'msg' =>"upload successfully but not saved in DB ")); exit; 
     exit;
     
   }      


}
?>
