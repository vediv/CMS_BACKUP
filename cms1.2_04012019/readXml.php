<?php 
//rror_reporting(E_ALL & ~E_NOTICE);
//ini_set('display_errors', TRUE);
error_reporting(0);
date_default_timezone_set('Asia/Calcutta');
set_time_limit(0);
$path='/Download/planetcast/FTP/mrss_automototv/';
function downloadThumbnail($thumbUrl,$folderDate)
{
    global $path;
    $fileUrl = $thumbUrl;
    $fileLocation=  basename($thumbUrl); //The path & filename to save to.
    //$saveTo = 'download/'.$fileLocation; //Open file handler.
    //$saveTo='/Download/planetcast/FTP/mrss_automototv/'.$fileLocation;
    $saveTo=$path.$folderDate."/".$fileLocation;
    $fp = fopen($saveTo, 'w+');
    if($fp === false){
            throw new Exception('Could not open');
    }
    $ch = curl_init($fileUrl); 
    curl_setopt($ch, CURLOPT_FILE, $fp); 
    //curl_setopt($ch, CURLOPT_TIMEOUT, 60*60*60); 
    $result=curl_exec($ch); //Execute the request.
    if(curl_errno($ch)){
        throw new Exception(curl_error($ch));
    }
    $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    if($statusCode == 200){
        return 1; // download successfully
    } else{
         return 2; // something went wrong.
        //echo "Status Code: " . $statusCode;
    }
    
}
function downloadVideoContent($mediaUrl,$folderDate)
{
    global $path;
    $fileUrl = $mediaUrl;
    $fileLocation=  basename($mediaUrl); //The path & filename to save to.
    //$saveTo = 'download/'.$fileLocation; //Open file handler.
    $saveTo=$path.$folderDate."/".$fileLocation;
    $fp = fopen($saveTo, 'w+');
    if($fp === false){
            throw new Exception('Could not open');
    }
    $ch = curl_init($fileUrl); 
    curl_setopt($ch, CURLOPT_FILE, $fp); 
    //curl_setopt($ch, CURLOPT_TIMEOUT, 60*60*60); 
    $result=curl_exec($ch); //Execute the request.
    if(curl_errno($ch)){
        throw new Exception(curl_error($ch));
    }
    $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    if($statusCode == 200){
        return 1; // download successfully
    } else{
         return 2; // something went wrong.
        //echo "Status Code: " . $statusCode;
    }
    
}
function db_quote($conn_client,$value) {
    //$connection = db_connect();
    return "'" . mysqli_real_escape_string($conn_client,$value) . "'";
}

function sendVideoToServerK($par_id,$publisherid,$titles,$description,$tags,$language,$thumbBaseName,$mediaBaseName,$folderDate)
{
    global $path;
    // local db connection
   /*$db_host="192.168.27.15"; 
   $db_user="root";  
   $db_pass="cloud10.0";       
   $db_database="ott_publisher";
   */
   // server db connection 
   
   $db_host="dbhost.local"; 
   $db_user="mycloud";  
   $db_pass="MYcloud";       
   $db_database="ott_publisher";
   $conn = mysqli_connect($db_host,$db_user,$db_pass,$db_database);
   if($conn === false) {
     // Handle error - notify administrator, log to a file, show an error screen, etc.
     return mysqli_connect_error(); 
    }
    $qry="select par_id,name,publisherID,partner_id,service_url,admin_secret,dbHostName,dbUserName,dbpassword,dbName
    from ott_publisher.publisher where par_id='$par_id' and publisherID='$publisherid'";
    $result=mysqli_query($conn,$qry);
    $fetch=mysqli_fetch_assoc($result);   
    //echo "<pre>"; print_r($fetch); echo "</pre>";  
    $partner_id=$fetch['partner_id'];
    $service_url=trim($fetch['service_url']);
    $admin_secret=trim($fetch['admin_secret']);
    $dbHostName=$fetch['dbHostName'];
    $dbUserName=$fetch['dbUserName'];
    $dbpassword=$fetch['dbpassword'];
    $dbName=$fetch['dbName'];
    $uname=$fetch['name'];
    
    $db_host_client=$dbHostName; //local server name default localhost
    $db_user_client=$dbUserName;  //mysql username default is root.
    $db_pass_client=$dbpassword;       //blank if no password is set for mysql. 
    $db_database_client=$dbName;
    $conn_client = mysqli_connect($db_host_client,$db_user_client,$db_pass_client,$db_database_client);
    if($conn_client === false) {
     return mysqli_connect_error(); 
    }
    $TitleName=db_quote($conn_client,$titles); 
    $query="Select name from $db_database_client.entry where name=$TitleName";
    $r=mysqli_query($conn_client,$query);
    $rowcount=mysqli_num_rows($r);
    if($rowcount==0)
    {    
    // connect with K
    require_once('kalturaClient/KalturaClient.php');
    $config = new KalturaConfiguration($partner_id);
    $config->serviceUrl = $service_url."/";
    $client = new KalturaClient($config);
    $ks = $client->generateSession($admin_secret, $uname, KalturaSessionType::ADMIN, $partner_id);
    $client->setKs($ks);
    // for geting upload token
    $uploadToken = null;
    $result_token = $client->uploadToken->add($uploadToken);
    $uploadTokenId=$result_token->id;
    //$fileData = 'download/'.$mediaBaseName;
    $fileData=$path.$folderDate."/".$mediaBaseName;
    $resume = null;
    $finalChunk = null;
    $resumeAt = null;
    $result_upload = $client->uploadToken->upload($uploadTokenId, $fileData, $resume, $finalChunk, $resumeAt);
    $file_upload_token=$result_upload->id;
    $entry = new KalturaBaseEntry();
    $entry->name = $titles;
    $entry->description = $description;
    //$entry->categoriesIds = $categoryid;
    $entry->tags = $tags;
    $uploadTokenId = $file_upload_token;
    $type = KalturaEntryType::AUTOMATIC;
    $result = $client->baseEntry->addfromuploadedfile($entry, $uploadTokenId, $type);
   
    $entry_id=$result->id;  $name=db_quote($conn_client,$result->name); $thumbnailUrl=$result->thumbnailUrl; 
    $type=$result->type; $description=db_quote($conn_client,$result->description);
    $tags=db_quote($conn_client,$result->tags);$createdAt=$result->createdAt; $status=$result->status; 
    $createdAt_convert=date("Y-m-d H:i:s", $createdAt);
    $puser_id='172';
    $language1=='english' ? $language:'';
    $upload_entry="Insert into entry(entryid,name,thumbnail,longdescription,type,tag,status,ispremium,created_at,language,video_status,puser_id)
    values('$entry_id',$name,'$thumbnailUrl',$description,'$type',$tags,'$status','0','$createdAt_convert','$language1','inactive','$puser_id')";
   
    $result=mysqli_query($conn_client,$upload_entry);
    mysqli_close($conn_client);
    mysqli_close($conn); 
    $client->session->end();
     echo "EntryID=".$entry_id."</br/>";
    }
    
}
if(isset($_POST['feedSend']))
 { 
       $currentDate=$_POST['pubdate']; 
       $currentPUbDate = date("d-m-Y", strtotime($currentDate));
       $password=$_POST['password'];  
       if($password!='AdoreF@571#')
       {
          echo "Password not correct";  die();
       } 
       $folder_date=date("dmY", strtotime($currentDate));
       if (!is_dir($path.$folder_date)) {
                 mkdir($path.$folder_date, 0777, true);
       }
//$url="sample.xml";
$url="http://auto-moto-tv.com/content2014/Adore_atmo_en.xml";
$xml = simplexml_load_file($url);
$value = 0;
foreach($xml->channel->item as $item)
        {
          //$item->pubDate; echo "</br/>"; 
           $dt = new DateTime($item->pubDate);
           $newPUbDate = $dt->format('d-m-Y');
           if($newPUbDate==$currentPUbDate){
           $media = $item->children("http://search.yahoo.com/mrss/");
           $media_url = $media->content[0]->attributes();
           $thumb_url = $media->thumbnail[0]->attributes();
           $titles = $media->title;
           $description = $media->description;
           $tags = $media->keywords;
           $category = $media->category;
           $language = $media->language;
           $thumbBaseName=basename($thumb_url);
           $mediaBaseName=basename($media_url);
           $saveToThumb=$path.$folder_date."/".$thumbBaseName;
           $saveToVideo=$path.$folder_date."/".$mediaBaseName;
           $value++;
           if (!file_exists($saveToThumb)) {
                $dthumb=downloadThumbnail($thumb_url,$folder_date);
                if($dthumb==1)
                 {
                    //echo "thumbDownload"; echo "<br/>";
                 }
                 else { continue;  }
           }
           if (!file_exists($saveToVideo)) { 
                    $videoContent=downloadVideoContent($media_url,$folder_date);
                    if($videoContent==1)
                    {
                        //echo "videoDownload"; echo "<br/>";
                        $par_id='97';$publisherid='ott488';
                        sendVideoToServerK($par_id,$publisherid,$titles,$description,$tags,$language,$thumbBaseName,$mediaBaseName,$folder_date);
                    }
                      else { continue;  }
            }
            if(file_exists($saveToVideo)) { 
             $par_id='97';$publisherid='ott488';
             //echo "no file download";
             sendVideoToServerK($par_id,$publisherid,$titles,$description,$tags,$language,$thumbBaseName,$mediaBaseName,$folder_date);
             } 
             $flag=1;
           }
          else { $flag=0; }
        } 
        echo 'Total Mrss Feed =' . ($value) .  '<br/>';
        if($flag==0)
        {
            echo "No data for uploading....";
        }
 }
?>
<div class="row">
        <div class="col-xs-12">
        <div class="box" > 
         <div class="box-header">
             <div class="pull-left" id="flash1" style="text-align: center;"></div>
          </div>   
            <div id="results" class="results" >
                <form name="" method="post">
                    Enter Date : <input type="date" data-date="" name="pubdate" data-date-format="DD-MM-YYYY"  required>
                    Password : <input type="password" name="password" required>
                <input type="submit" name="feedSend" value="Send Feed">
                </form>
                

            </div> 
        </div>
        </div>
</div>