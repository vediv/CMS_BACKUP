<?php
include_once 'corefunction.php';
include_once("config.php");
if(is_array($_FILES) and !empty($_FILES)) {
if(is_uploaded_file($_FILES['userImage']['tmp_name'])) {
$enteryID=$_POST['enteryID'];
$DBname=DATABASE_Name;
$userID=$get_user_id; // this is define in corefuntion.php
$dir_path=TEMP_VIDEO_THUMNAIL_PATH;
        $new_path = $dir_path.$DBname."/".$userID;
           if(is_dir($new_path)) {
	    //echo "The Directory $userID exists";
         } else {
             
             mkdir($new_path, 0777,true);
             
            }
 
$sourcePath = $_FILES['userImage']['tmp_name'];
$targetPath = "$new_path/".$_FILES['userImage']['name'];
if(move_uploaded_file($sourcePath,$targetPath)) {
     // echo $targetPath;
$path="$targetPath";
$entryId = $enteryID;
$fileData = $path;
$result = $client->thumbAsset->addfromimage($entryId, $fileData);
//$result="yes";
if($result!='')
{
	if (is_file($path)){
        unlink($path);
        }
include_once 'ksession_close.php';        
echo "1";

}
else {
	echo "Some Problem in server for upload image please try some time.";
}
?>
  
<?php
          }
     }
}
?>