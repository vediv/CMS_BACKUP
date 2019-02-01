<?php 
include_once 'corefunction.php';
$entry_id=$_POST['entryID'];
$q="select COUNT('$entry_id') as num FROM entry where entryid='$entry_id'";
$totalpages =db_select($conn,$q);
$total_entry = $totalpages[0]['num'];
if($total_entry==1)
{
   	
    $f="select isfeatured FROM entry where entryid='$entry_id'";
    $ff =db_select($conn,$f);
    $isfeatured=$ff[0]['isfeatured'];
    if($isfeatured==1){
    $u="update entry set isfeatured='0' where entryid='$entry_id'";
    db_query($conn,$u);
    echo 1;
    } // 1 means update in featured_video_detail 
    else
     {
       $u="update entry set isfeatured='1' where entryid='$entry_id'";
        db_query($conn,$u);
       echo 2;
     }
}

?>
