<?php
session_start();
$action=isset($_POST['action'])?$_POST['action']:'no_action';
require_once '../function.inc.publisher.php';
switch($action)
{
   case "login":
   $Email = db_quote1($_POST['email']);  $Password = db_quote1($_POST['password']);  $PasswordMd5 = db_quote1(md5($_POST['password']));
   $query="Select par_id,publisherID,name,pstatus,dbName from ott_publisher.publisher where email=$Email and (publisher_pass=$Password OR publisher_pass=$PasswordMd5)  and pstatus=1";
   $row = db_select1($query);
   $totalrow=db_totalRow1($query);
   if($totalrow==1)
       {
                $pstatus=$row[0]['pstatus'];
                if($pstatus==0)
                {
                    
                    sleep(1);
                    echo 0;
                    exit;
                }     
                if($pstatus==1)
                { 
                  $_SESSION['publisher_info']['dasbord_user_id'] = $row[0]['par_id'];
                  $_SESSION['publisher_info']['publisher_unique_id'] = $row[0]['publisherID'];
                  $dbName=$row[0]['dbName']; $name=$row[0]['name'];
                  /*----------------------------update log file begin-------------------------------------------*/
                  $error_level=1;$msg="login-($name)"; $lusername=$row[0]['name']."_".$row[0]['publisherID'];
                  $qry='';
                  write_log($error_level,$msg,$lusername,$qry,$dbName);
                  /*----------------------------update log file End---------------------------------------------*/   
                  sleep(1);
                  echo 1;
                  exit;
                }           
        } 
        else
        {
             sleep(1);
             echo 2;
             exit;
        }    
   break;
}
	  
function write_log($errorLebel,$errormsg,$duserName,$query,$dbName)
{
    $new_path = "../files/".$dbName;
    if(is_dir($new_path)) { //echo "The Directory $new_path exists";
    } else {mkdir($new_path, 0777,true);}
    $cdate=date("Ymd"); 
    $log_file_name=$new_path.'/access_'.$cdate.".log";
    $lcdate=date('d/m/Y H:i:s');  $duserName1="By-".$duserName;
    switch($errorLebel)
    {
        case 0:
          $level='OFF';  
         $str="";   
        break;    
        case 1:
         $level='SUCCESS';   
         $str="$lcdate | $level | $errormsg | $duserName1 | $query".PHP_EOL;;   
        break;    
        case 2:
          $level='INFO';  
         $str="$lcdate | $level | $errormsg | $duserName1".PHP_EOL;   
        break;   
        case 3:
         $level='WARNING';     
         $str="$lcdate | $level | $errormsg | $duserName1".PHP_EOL;   
        break;
        case 4:
          $level='ERROR';
             $str="$lcdate | $level | $errormsg | $duserName1".PHP_EOL;   
            break;   
        case 5:
            $level='ERROR-SQL';
             $str="$lcdate | $level | $errormsg | $duserName1 | $query".PHP_EOL;   
            break;
        default:
          $level='OFF';    
          $str="";    
    }

    $fp = fopen($log_file_name,'a+');
    fwrite($fp,($str));
    fclose($fp);
}
?>