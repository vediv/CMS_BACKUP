<?php
include_once '../auths.php'; 
include_once '../auth.php'; 
include_once '../function.inc.php';
$conn=db_connect(DASHBOARD_USER_ID,PUBLISHER_UNIQUE_ID);
$action=isset($_REQUEST['action'])?$_REQUEST['action']:'';
switch($action)
{
    case "userEmailCheck": 
    $userEmail=isset($_POST['userEmail'])?$_POST['userEmail']:'';
    $sqlCountEmail = "SELECT uemail FROM user_registration where uemail='".$userEmail."'";
    $validUser = db_totalRow($conn,$sqlCountEmail);
    echo trim($validUser);
    break;  
    case "getregisterUserList":
    $filter_name=(isset($_GET['filter_name']))? $_GET['filter_name']: "";
    $where='';    
        if($filter_name!='')
            {
              $where=" where user_id LIKE '$filter_name%' OR uid LIKE '$filter_name%' OR uemail LIKE '$filter_name%' ";
            }
        $query="select uid,user_id,uemail from user_registration  $where limit 10";
        $fetchData= db_query($conn,$query);
        $result = array();$rows=array(); 
        foreach ($fetchData as $row) { 
         $rows['uid']=$row['uid'];
         $rows['user_id']=$row['uemail']; 
         $result[]=$rows;
        }    
        echo json_encode($result);
    break;   
    case "getVideoEntry":
        $filter_name=(isset($_GET['filter_name']))? $_GET['filter_name']: "";
        $where='';    
        if($filter_name!='')
            {
              $where=" and name LIKE '$filter_name%' ";
            }
        $query="select entryid,name from entry where type='1' and status='2' and video_status='active' $where limit 10";
        $fetchData= db_query($conn,$query);
        $result = array();$rows=array(); 
        foreach ($fetchData as $row) { 
         $rows['entryid']=$row['entryid'];
         $rows['name']=$row['name']; 
         $result[]=$rows;
        }    
        echo json_encode($result);
        break; 
        
    
}
?>