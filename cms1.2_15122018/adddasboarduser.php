<?php
include_once 'auths.php';
include_once 'auth.php';
$action=$_POST['action']; 
$dasbord_user_id=$_SESSION['publisher_info']['dasbord_user_id']; 
$publisher_unique_id=$_SESSION['publisher_info']['publisher_unique_id'];
switch($action)
{
     case "adddashboarduser":
     $duser=$_POST['duserName']; $inputEmail=strtolower(trim($_POST['demail'])); $dpwd=md5($_POST['dpwd']);
     $menuright=$_POST['menuright'];  $actionright=$_POST['actionright'];
     $other_permissions=$_POST['other_permissions'];
     $menuright=rtrim($menuright,','); $actionright=rtrim($actionright,',');
     include_once 'function.inc.publisher.php'; 
     $qryemail="select email from ott_publisher.publisher";
     $getDataEmail=  db_select1($qryemail);
     foreach ($getDataEmail as $dbdata)
     {
        if($dbdata['email']==$inputEmail)
        {
             echo 1;     
             exit;
        } 
     }
    $select_ott="select * from ott_publisher.publisher where  publisherID='$publisher_unique_id'"; 
    $getData=  db_select1($select_ott);
    $dbemail=$getData[0]['email']; $dbacess_level=$getData[0]['acess_level'];
    $partner_id=$getData[0]['partner_id']; $admin_secret=$getData[0]['admin_secret'];
    $service_url=$getData[0]['service_url'];$pstatus=$getData[0]['pstatus'];
    $dbName=$getData[0]['dbName'];$dbHostName=$getData[0]['dbHostName']; $dbUserName=$getData[0]['dbUserName'];
    $dbpassword=$getData[0]['dbpassword']; $company=$getData[0]['company'];
    $publisherID=$getData[0]['publisherID']; $acess_level="u"; $cdnURL=$getData[0]['cdnURL'];
    /* insert in OTT_Publisher DB */  
    $ins="insert into ott_publisher.publisher(partner_id,name,email,company,admin_secret,service_url,publisher_pass,pstatus,created_at,updated_at,acess_level,parentid,addedby,dbName,dbHostName,dbUserName,dbpassword,publisherID,cdnURL)
    values('$partner_id','$duser','$inputEmail','$company','$admin_secret','$service_url','$dpwd','$pstatus',NOW(),NOW(),'$acess_level','$dasbord_user_id','$dasbord_user_id','$dbName','$dbHostName','$dbUserName','$dbpassword','$publisherID','$cdnURL')";
    $last_insert_id=last_insert_id1($ins); // last increment id;
    
    /* insert in client DB */
    include_once 'corefunction.php';
    $ins_pub="insert into publisher(par_id,partner_id,name,email,company,admin_secret,service_url,publisher_pass,pstatus,created_at,updated_at,acess_level,dbName,dbHostName,dbUserName,dbpassword,publisherID,cdnURL,menu_permission,operation_permission,other_permission)
    values('$last_insert_id','$partner_id','$duser','$inputEmail','$company','$admin_secret','$service_url','$dpwd','$pstatus',NOW(),NOW(),'$acess_level','$dbName','$dbHostName','$dbUserName','$dbpassword','$publisherID','$cdnURL','$menuright','$actionright','$other_permissions')";
    $y=db_query($conn,$ins_pub);
     /*----------------------------update log file begin-------------------------------------------*/
          $error_level=1;$msg="Add New Dashboard user ($duser)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
          $qry='';
          write_log($error_level,$msg,$lusername,$qry);
    /*----------------------------update log file End---------------------------------------------*/
    echo 2;
    break;
     case "editdashboarduser":
     $duser=$_REQUEST['duser']; $inputEmail=strtolower(trim($_REQUEST['demail'])); $parid=$_REQUEST['parid'];
     $menuright=$_REQUEST['menuright'];  $actionright=$_REQUEST['actionright'];
     $menuright=rtrim($menuright,','); 
     $actionright=rtrim($actionright,',');
     $other_permissions=$_REQUEST['other_permissions'];
     include_once 'function.inc.publisher.php'; 
    /*update in OTT_Publisher DB */  
    $up="update ott_publisher.publisher set name='$duser',email='$inputEmail' where par_id='$parid'";
    $rr=db_query1($up);
    /* update in client DB */
    include_once 'corefunction.php';
    $upc="update publisher set name='$duser',email='$inputEmail',menu_permission='$menuright',operation_permission='$actionright',other_permission='$other_permissions' where par_id='$parid' ";
    $rr=db_query($conn,$upc);
    echo 2;
    break;
    case "dashboarduser_active_deactive":
    $parid = $_POST['parid'];
    $adstatus = $_POST['adstatus'];
    $adupdateStauscontent=$adstatus==1?0:1;
    include_once 'function.inc.publisher.php';
    $sql_main_ott = "update  ott_publisher.publisher set pstatus='".$adupdateStauscontent."' where par_id='".$parid."'";
    $rescont=db_query1($sql_main_ott);
    include_once 'corefunction.php';
    $sql_main_pub = "update  publisher set pstatus='".$adupdateStauscontent."' where par_id='".$parid."'";
    $rr=db_query($conn,$sql_main_pub);
    echo $adupdateStauscontent; 
    break;
    break;   
    case "addcontentpartner":
     $cname=$_POST['cname']; $cemail=strtolower(trim($_POST['cemail'])); $cpassword=md5($_POST['cpassword']);
     $cmobile=$_POST['cmobile']; $lsdate=$_POST['lsdate']; $ledate=$_POST['ledate'];
     $menuright=$_POST['menuright'];  $actionright=$_POST['actionright'];
     $other_permissions=$_POST['other_permissions'];
     $menuright=rtrim($menuright,','); $actionright=rtrim($actionright,',');
     include_once 'function.inc.publisher.php'; 
     $qryemail="select email from ott_publisher.publisher";
     $getDataEmail=  db_select1($qryemail);
     foreach ($getDataEmail as $dbdata)
     {
        if($dbdata['email']==$cemail)
        {
             echo 1;     
             exit;
        } 
     }
     
     $select_ott="select * from ott_publisher.publisher where  publisherID='$publisher_unique_id'"; 
     $getData=  db_select1($select_ott);
     $dbemail=$getData[0]['email']; $dbacess_level=$getData[0]['acess_level'];
     
    $partner_id=$getData[0]['partner_id']; $admin_secret=$getData[0]['admin_secret'];
    $service_url=$getData[0]['service_url'];$pstatus=$getData[0]['pstatus'];
    $dbName=$getData[0]['dbName'];$dbHostName=$getData[0]['dbHostName']; $dbUserName=$getData[0]['dbUserName'];
    $dbpassword=$getData[0]['dbpassword']; $company=$getData[0]['company'];
    $publisherID=$getData[0]['publisherID']; $acess_level="c"; $cdnURL=$getData[0]['cdnURL'];
    /* insert in OTT_Publisher DB */  
    $ins="insert into ott_publisher.publisher(partner_id,name,email,company,admin_secret,
         service_url,publisher_pass,pstatus,created_at,updated_at,acess_level,
         parentid,addedby,dbName,dbHostName,dbUserName,dbpassword,publisherID,cdnURL)
    values('$partner_id','$cname','$cemail','$company','$admin_secret',
            '$service_url','$cpassword','$pstatus',NOW(),NOW(),'$acess_level','$dasbord_user_id',
            '$dasbord_user_id','$dbName','$dbHostName','$dbUserName','$dbpassword','$publisherID','$cdnURL')";
    $last_insert_id=last_insert_id1($ins); // last increment id;
    /* insert in client DB */
    include_once 'corefunction.php';
    $ins_pub="insert into publisher(par_id,partner_id,name,email,company,admin_secret,service_url,
        publisher_pass,pstatus,created_at,updated_at,acess_level,dbName,dbHostName,dbUserName,
        dbpassword,publisherID,cdnURL,menu_permission,operation_permission,other_permission)
    values('$last_insert_id','$partner_id','$cname','$cemail','$company','$admin_secret',
            '$service_url','$cpassword','$pstatus',NOW(),NOW(),'$acess_level','$dbName','$dbHostName',
            '$dbUserName','$dbpassword','$publisherID','$cdnURL','$menuright','$actionright','$other_permissions')";
    $y=db_query($conn,$ins_pub);
    
    $ins_content_partner="insert into content_partner(name,email,mobile,status,created_at,license_start_date,license_end_date,par_id)
    values('$cname','$cemail','$cmobile','1',NOW(),'$lsdate','$ledate','$last_insert_id')";
    $y=db_query($conn,$ins_content_partner);
    
    /*----------------------------update log file begin-------------------------------------------*/
          $error_level=1;$msg="Add New Content Partner($cname)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
          $qry='';
          write_log($error_level,$msg,$lusername,$qry);
    /*----------------------------update log file End---------------------------------------------*/
    echo 2;
    break;
  
  
}

?>
