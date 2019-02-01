<?php
include_once 'corefunction.php';
$useridd=$_SESSION['publisher_info']['publisher_unique_id'];
$action=(isset($_POST['action']))? $_POST['action']: "";   
switch($action)
{
	case "delete_tmp_thumb":
	   $parID=$_REQUEST['parid']; $filename=$_REQUEST['imgname'];
		for($i=1; $i<6; $i++)
		{
        	  if($i==1)
			{ $delimg=$filename; }
			if($i==2)
			{ $delimg="320_".$filename; }
			if($i==3)
			{ $delimg="380_".$filename; }
			if($i==4)
			{ $delimg="480_".$filename; }
			if($i==5)
			{ $delimg="720_".$filename; }
                $path = IMG_CATEGORY_THUMB_PATH.$delimg;
		unlink($path);
		}
        $dd="delete from tmp_image_thumb_icon where par_id='$useridd' and type='T'";
		db_query($dd);
		echo 1;
		  break;
	case "delete_tmp_icon":
	    $parID=$_REQUEST['parid']; $filename=$_REQUEST['imgname'];
		for($j=1; $j<6; $j++)
		{
        	if($j==1)
			{ $delicon=$filename; }
			if($j==2)
			{ $delicon="50_".$filename; }
			if($j==3)
			{ $delicon="100_".$filename; }
			if($j==4)
			{ $delicon="200_".$filename; }
			if($j==5)
			{ $delicon="300_".$filename; }
                   $path = IMG_CATEGORY_ICON_PATH.$delicon;
		unlink($path);
		}
        $d="delete from tmp_image_thumb_icon where par_id='$useridd' and type='I'";
		db_query($d);
		echo 1;
         break;
		 
    		 
	
}
?>

       
       
       
       
