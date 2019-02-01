<?php
include_once 'corefunction.php';
$currentDate=date('Y-m-d');
$que="SELECT uname,user_id,uid,status,uemail FROM user_registration WHERE DATE(added_date) = '$currentDate'";
$num_rows=db_totalRow($conn,$que);
$qLogo="SELECT  name,value FROM filter_setting where tag='client_logo' and type='logo'";
$fetchLogoInfo=db_select($conn,$qLogo);
$ClientCompanyName=$fetchLogoInfo[0]['name'];
$ClientLogo=$fetchLogoInfo[0]['value'];
?>
<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
<link href="bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" />
<link href="font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css" />
<link href="font-awesome/css/ionicons.min.css" rel="stylesheet" type="text/css" />
<link href="plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
<link href="dist/css/AdminLTE.css" rel="stylesheet" type="text/css" />
<link href="dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
 <link href="plugins/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
<style type="text/css">
 .no-print{ display:none;}
 .skin-blue .main-header .logo { font-size: 14px !important;}
</style>
      <header class="main-header">
        <a href="dashboard.php" class="logo"> 
        <?php if($ClientLogo!=''){ ?>
        <img src="<?php echo $ClientLogo; ?>" height="40" width="90" style="border:0px solid red;" title="<?php echo COMPANY_NAME; ?>" />
        <?php } else{ echo COMPANY_NAME;} ?></a>
        <nav class="navbar navbar-static-top" role="navigation">
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <div class="navbar-custom-menu" >
            <ul class="nav navbar-nav">
            	 <li class="dropdown messages-menu">
                <?php if($login_access_level!='c'){ ?>
                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                  <i class="fa fa-envelope-o" title="Alert"></i>
                 <span class="label label-successs" id="refresh_div" style="background-color: #ff0000;"><?php 
                 echo $num_rows; ?></span>
                </a> <?php  } ?>
               <ul class="dropdown-menu">
               	
                <li class="header" id="refresh_div">You have <?php echo $num_rows; ?> Users Registered Today</li>
                <!--<li>
                <ul class="menu">
                <li> 
                <?php
                $r = db_select($conn,$que);
                foreach($r as $rv){
                $uname=$rv['uname']; $unameID=$rv['user_id'];  $uid=$rv['uid']; $ustatus=$rv['status']; $uemail=$rv['uemail'];
                $name=$uname==''? $unameID:$uname; 
                ?>
                <a href="user_list.php?regid=<?php echo $uid; ?>">
                <h4>
                <?php
                echo ucwords($unameID)." , ".$uemail;?>
                </h4>
                <p></p>
                </a>
                <?php } ?>
                 </ul>

                <li class="footer"><a href="user_list.php?showall=all">see all registered users</a></li>-->
                </ul>
                </li>

                
    <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <!--<img src="images/img.jpg" alt="">--><?php echo ucwords(DASHBOARD_USER_NAME);?>
                    <span class="caret"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <?php 
                    if($login_access_level=='c')
                    {  $userName="CP"; }
                    if($login_access_level=='p')
                    {  $userName="Admin"; }
                    if($login_access_level=='u')
                    {  $userName="User"; }
                    ?>
                   <li>
                      <a href="javascript:;">
                        <span class="badge bg-red pull-right"><?php echo PUBLISHER_UNIQUE_ID; ?></span>
                        <span><?php echo ucwords($userName); ?></span>
                      </a>
                    </li>
                    <?php if($login_access_level=='p'){?><li><a href="dashboarduser.php"> Team Mgmt</a></li><?php } ?>
                    <li><a href="myProfile.php"> Profile</a></li>
                    <li><a href="logout.php"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                  </ul>
                </li>
    </ul>  
     <!--<li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <span class="hidden-xs"><?php echo ucwords(DASHBOARD_USER_NAME);?><span class="caret"></span></span>
                </a>
               <ul class="dropdown-menu">
                 
                  <li class="user-header">
                    <p>
                    <?php 
                    if($login_access_level=='c')
                    {  $userName="Content Partner"; }
                    if($login_access_level=='p')
                    {  $userName="Admin"; }
                    if($login_access_level=='u')
                    {  $userName="User"; }
                     echo DASHBOARD_USER_NAME."(".PUBLISHER_UNIQUE_ID.")<br>".  ucwords($userName);?>
                    </p>
                  </li>
                 
                  
                  <li class="user-body">
                      <?php  if(ACCESS_LEVEL =='p'){?>
                    <div class="col-xs-4 text-center">
                      <a href="#"></a>
                    </div>
                    <div class="col-xs-4 text-center">
                      <a href="#"></a>
                    </div>
                    <div class="col-xs-4 text-center">
                      <a href="dashboarduser.php" class="btn btn-default btn-flat">Users</a>
                    </div>
                    <div class="pull-left">
                    </div>
                    <div class="pull-right">
                        <a href="dashboarduser.php" class="btn btn-default btn-flat">Team Mgmt</a>
                    </div>
                      
                      
                        <?php } ?>
                  </li>
                
                 
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="#" class="btn btn-default btn-flat">Profile</a>
                    </div>
                    <div class="pull-right">
                        <a href="logout.php" class="btn btn-default btn-flat">Logout</a>
                    </div>
                  </li>
                </ul> 
              </li>
            </ul>-->
            
          </div>
        </nav>


</header>



