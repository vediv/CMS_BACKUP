<?php 
include_once 'corefunction.php';
$successMsg=''; $successMsgpass='';
$getMsg=isset($_GET['msg'])?$_GET['msg'] :0;
$act=isset($_GET['act'])?$_GET['act'] :0;
$fid=isset($_GET['fid'])?$_GET['fid'] :0;
$adsid=isset($_GET['adsid'])?$_GET['adsid'] :0;
if($act=='pay_per_view'){
   
   $qry="select value,type from filter_setting where fsid='".$fid."'"; 
   $fetchD= db_select($conn,$qry);
   $value=$fetchD[0]['value']; $type=$fetchD[0]['type']; //$publisher_pass=$fetchD[0]['publisher_pass'];
}
if($act=='gst'){
   
   $qry="select value,type from filter_setting where fsid='".$fid."'"; 
   $fetchD= db_select($conn,$qry);
   $value_gst=$fetchD[0]['value']; $type_gst=$fetchD[0]['type']; //$publisher_pass=$fetchD[0]['publisher_pass'];
}
$revenue_button='save_ads_revenue';
if($adsid!=''){
   
   $qry="select year,month,amount from ads_revenue where ads_id='".$adsid."'"; 
   $fetchD= db_select($conn,$qry);
   $year_r=$fetchD[0]['year']; $month_r=$fetchD[0]['month']; $amount_r=$fetchD[0]['amount']; 
   $revenue_button='update_ads_revenue';
}

if(isset($_POST['save_pay_par_view']))
{
       $tag='pay_per_view';
       $qcheck="select fsid from filter_setting where tag='".$tag."' ";
       $pay_value=$_POST['pay_value']; $validity_type=$_POST['validity_type'];
       $totalRow= db_totalRow($conn,$qcheck);
       if($totalRow==1)
       {
           $upin="update filter_setting set value='$pay_value',type='$validity_type',updated_at=NOW() where fsid='$fid'";
           $q= db_query($conn,$upin);
           $error_level=1;$msg="update Pay per View($pay_value)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
           $qry='';
           write_log($error_level,$msg,$lusername,$qry);
       }    
       if($totalRow==0)
       {
           $upin="insert into filter_setting(name,tag,value,status,type,created_at)
           values('Pay per View','$tag','$pay_value','1','$validity_type',NOW())";
           $q= db_query($conn,$upin);
           $error_level=1;$msg="insert Pay per view ($pay_value)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
           $qry='';
           write_log($error_level,$msg,$lusername,$qry);
       } 
       
       header("location:basic_setting.php?msg=1&act=$tag");
      
} 


if($getMsg==1)
{
    $successMsg='<div class="alert alert-success">
    <strong>Success!</strong> Pay Per View Update Successfully.
    </div>';
}   
if($getMsg==2)
{
    $successMsgpass='<div class="alert alert-success">
    <strong>Success!</strong> GST Update Successfully.
    </div>';
}
if($getMsg==3)
{
    $successAddRevenue='<div class="alert alert-success">
    <strong>Success!</strong> Ads Revenue add.
    </div>';
}
if($getMsg==4)
{
    $successAddRevenue='<div class="alert alert-success">
    <strong>Success!</strong> Ads Revenue update.
    </div>';
}
if(isset($_POST['saveGst']))
    {
       $tag='gst';
       $gst_type=$_POST['gst_type']; $gst=$_POST['gst'];
       $qcheck="select fsid from filter_setting where tag='".$tag."' ";
        $totalRow= db_totalRow($conn,$qcheck);
       if($totalRow==1)
       {
            $upin="update filter_setting set value='$gst',type='$gst_type',updated_at=NOW() where fsid='$fid'";
           $q= db_query($conn,$upin);
           $error_level=1;$msg="update GST($tag)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
           $qry='';
           write_log($error_level,$msg,$lusername,$qry);
       }    
       if($totalRow==0)
       {
           $upin="insert into filter_setting(name,tag,value,status,type,created_at)
           values('GST','$tag','$gst','1','$gst_type',NOW())";
           $q= db_query($conn,$upin);
           $error_level=1;$msg="insert GST ($gst)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
           $qry='';
           write_log($error_level,$msg,$lusername,$qry);
       }    
       header("location:basic_setting.php?msg=2&act=$tag");

    }
    
 if(isset($_POST['save_ads_revenue']))
    {
       //$tag='ads_revenue';
       $month_sub=$_POST['month_sub']; $year_sub=$_POST['year_sub']; $amount=$_POST['ads_amount'];
       $qcheck="select * from ads_revenue where year='$year_sub' and month='$month_sub' and tag='ads_revenue' ";
       $totalRow= db_totalRow($conn,$qcheck);
       if($totalRow==1)
       {
          $successAddRevenue='<div class="alert alert-danger">
           Year and month already exist.
          </div>'; 
       }    
       if($totalRow==0)
       {
           $upin="insert into ads_revenue(month,year,amount,tag,created_at)
           values('$month_sub','$year_sub','$amount','ads_revenue',NOW())";
           $q= db_query($conn,$upin);
           $error_level=1;$msg="insert ads revenue ($month_sub/$year_sub/$amount)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
           $qry='';
           write_log($error_level,$msg,$lusername,$qry);
       }    
       header("location:basic_setting.php?msg=3&act=ads_revenue");
    } 
    if(isset($_POST['update_ads_revenue']))
    {
        //$tag='ads_revenue';
        $month_sub=$_POST['month_sub']; $year_sub=$_POST['year_sub']; $amount=$_POST['ads_amount'];
        $upin="update ads_revenue set year='$year_sub',month='$month_sub',amount='$amount' where ads_id='$adsid'";
        $q= db_query($conn,$upin);
        $error_level=1;$msg="update ads revenue ($month_sub/$year_sub/$amount)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
        $qry='';
        write_log($error_level,$msg,$lusername,$qry);
        header("location:basic_setting.php?msg=4&act=ads_revenue");
    } 
?>
<!DOCTYPE html>
<html>
  <head>
<meta charset="UTF-8">
<title><?php echo PROJECT_TITLE." | Basic Detail";?></title>
<link href="bootstrap/css/pagingCss.css" rel="stylesheet" type="text/css" />
<style type="text/css">
.box-header { padding: 4px 10px 0px 10px !important;  }
.navbar-form .input-group > .form-control {    height: 26px !important; }
h5 {margin-top: 0px  !important;}
.input-group-btn:last-child > .btn, .input-group-btn:last-child > .btn-group {
    height: 26px;
    margin-left: -1px;
    padding: 4px;
}
</style>
  </head>
  <body class="skin-blue">
    <div class="wrapper">
   <?php include_once 'header.php';?>
           <!-- Left side column. contains the logo and sidebar -->
      <?php include_once 'lsidebar.php';?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
         <section class="content-header">
         <h1>Basic Setting</h1>
          <ol class="breadcrumb">
            <li><a href="dashboard.php"><i class="fa fa-home" title="Home"></i> Home</a></li>
            <li class="active">Basic Setting </li>
          </ol>
        </section>
<section class="content">
           <div class="row" >
            <!-- left column -->
            <div class="col-md-6" >
              <!-- general form elements -->
              <div class="box box-primary" >
                <div class="box-header">
                <h3 class="box-title">Pay Per View Setting</h3>
                </div><!-- /.box-header -->
               
                <form role="form" method="post">
                  <div class="box-body">
                     <?php echo $successMsg; ?>    
                    <div class="form-group">
                      <label for="pay_value">Enter Value</label>
                      <input type="number" min="0" step="1" class="form-control" id="pay_value" name="pay_value"  value="<?php echo $value; ?>"  placeholder="Enter Number only" required>
                    </div>
                    <div class="form-group">
                      <label for="validity_type">Select Validity Type</label>
                     <select class="form-control" id="validity_type" name="validity_type">
                        <option value="hour" <?php echo $type=='hour'?'selected':'';  ?> >Hour</option>
                        <!--<option value="day" <?php //echo $type=='day'?'selected':'';  ?>>Day</option>-->
                     </select> 
                    </div>
                  </div><!-- /.box-body -->
               
                 <div class="box-footer">
                     <button type="submit" name="save_pay_par_view"  class="btn btn-primary">Submit</button>
                 </div>
                </form>
                <div class="box-body" style="border: 0px solid red;">
                  <?php
                  $qry="select fsid,name,value,type,status from filter_setting where tag='pay_per_view'";
                  $ff= db_select($conn,$qry);
                  ?>    
                 <div class="table-responsive">
                    <table class="table no-margin">
                      <thead>
                        <tr>
                          <th>Name</th>
                          <th>Value</th>
                          <th>Type</th>
                          <th>Status</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach($ff as $fsocial){
                         $name=$fsocial['name']; $value=$fsocial['value']; $type=$fsocial['type'];  $fsid=$fsocial['fsid'];
                         if($type=='P'){ $type1="percentage"; }
                         else{ $type1=$type; }
                         $conf_status=$fsocial['status']; $conf_id=$fsocial['conf_id'];
                         if($conf_status==1){ $active="active"; $sclass="label-success";    }
                         else{ $active="inactive"; $sclass="label-danger"; }
                         ?>  
                        <tr>
                          <td><?php echo $name; ?></td>
                          <td><?php echo $value; ?></td>
                          <td><?php echo $type1; ?></td>
                          <td id="getstatus<?php  echo $fsid; ?>"><span id="setlevel<?php  echo $fsid; ?>" class="label <?php echo $sclass; ?>"><?php echo $active; ?></span></td>
                          <input type="hidden" size="1" id="ad_status<?php echo $fsid;  ?>" value="<?php echo $conf_status;  ?>" >
                          <!--<td>
                          <?php  if(in_array(4, $UserRight)){ ?> 
                          <a href="#">
                          <i id="icon_status<?php echo $fsid; ?>"   class="status-icon fa <?php  echo ($conf_status == 1) ? 'fa-check-square-o':'fa-ban';?>" onclick=social_act_deact('<?php echo $fsid;  ?>')></i> </a>
                          <?php } ?>
                          </td>-->
                           <td>
                          <?php  if(in_array(2, $UserRight)){ ?> 
                               <a href="basic_setting.php?fid=<?php echo $fsid; ?>&act=pay_per_view"><i  class="status-icon fa  fa-edit "></i> </a>
                          <?php } ?>
                          </td>
                        </tr>
                        <?php } ?>
                      
                      </tbody>
                    </table>
                  </div><!-- /.table-responsive -->
                 </div>
              </div>
              
              
            </div><!--/.col (left) -->
            <!-- right column -->
            <div class="col-md-6">
              <!-- general form elements disabled -->
              <div class="box box-warning" >
                <div class="box-header">
                 <h3 class="box-title">GST Setting</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <?php echo $successMsgpass; ?> 
                    <form role="form" method="post">
                    <!-- text input -->
                    <div class="form-group">
                      <label>Enter GST Value</label>
                      <input type="number" min="0" step="1"   class="form-control" id="gst" name="gst" value="<?php echo $value_gst; ?>"  placeholder="Enter Number only" required>
                    </div>
                    <div class="form-group">
                      <label for="gst_type">Select Type</label>
                     <select class="form-control" id="gst_type" name="gst_type">
                        <option value="P" <?php echo $type_gst=='P'?'selected':'';  ?> >Percentage</option>
                        
                     </select> 
                    </div>
                    <div class="box-footer">
                     <button type="submit" name="saveGst"  class="btn btn-primary">Submit</button>
                  </div>
                  </form>
                    <div class="box-body" style="border: 0px solid red;">
                  <?php
                  $qry="select fsid,name,value,type,status from filter_setting where tag='gst'";
                  $ff= db_select($conn,$qry);
                  ?>    
                 <div class="table-responsive">
                    <table class="table no-margin">
                      <thead>
                        <tr>
                          <th>Name</th>
                          <th>Value</th>
                          <th>Type</th>
                          <th>Status</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach($ff as $fsocial){
                         $name=$fsocial['name']; $value=$fsocial['value']; $type=$fsocial['type'];  $fsid=$fsocial['fsid'];
                         if($type=='P'){ $type1="percentage"; }
                         else{ $type1=$type; }
                         $conf_status=$fsocial['status']; $conf_id=$fsocial['conf_id'];
                         if($conf_status==1){ $active="active"; $sclass="label-success";    }
                         else{ $active="inactive"; $sclass="label-danger"; }
                         ?>  
                        <tr>
                          <td><?php echo $name; ?></td>
                          <td><?php echo $value; ?></td>
                          <td><?php echo $type1; ?></td>
                          <td id="getstatus<?php  echo $fsid; ?>"><span id="setlevel<?php  echo $fsid; ?>" class="label <?php echo $sclass; ?>"><?php echo $active; ?></span></td>
                          <input type="hidden" size="1" id="ad_status<?php echo $fsid;  ?>" value="<?php echo $conf_status;  ?>" >
                          <!--<td>
                          <?php  if(in_array(4, $UserRight)){ ?> 
                          <a href="#">
                          <i id="icon_status<?php echo $fsid; ?>"   class="status-icon fa <?php  echo ($conf_status == 1) ? 'fa-check-square-o':'fa-ban';?>" onclick=social_act_deact('<?php echo $fsid;  ?>')></i> </a>
                          <?php } ?>
                          </td>-->
                           <td>
                          <?php  if(in_array(2, $UserRight)){ ?> 
                               <a href="basic_setting.php?fid=<?php echo $fsid; ?>&act=gst"><i  class="status-icon fa  fa-edit "></i> </a>
                          <?php } ?>
                          </td>
                        </tr>
                        <?php } ?>
                      
                      </tbody>
                    </table>
                  </div><!-- /.table-responsive -->
                 </div>
                </div>
                <!-- /.box-body -->
              </div><!-- /.box -->
            </div><!--/.col (right) -->
          </div>
     <div class="row" >
            <!-- left column -->
            <div class="col-md-6" >
              <!-- general form elements -->
              <div class="box box-primary" style="">
                <div class="box-header">
                <h3 class="box-title">Ads Revenue Add</h3>
                </div><!-- /.box-header -->
                <hr/>
                <?php echo $successAddRevenue; ?>    
                <form class="form-inline" method="post" style="margin-left:10px;">
                <div class="input-group">
                <select name="month_sub" id="month_sub" class="form-control"  style="width:130px;" required>
                          <option value="">-Select Month-</option>
                            <?php for( $m=1; $m<=12; ++$m ) { 
                                $month_label = date('F', mktime(0, 0, 0, $m, 2));
                                $sel1='';
                                if($m==$month_r){ $sel1="selected"; }
                             ?>
                            <option value="<?php echo $m; ?>" <?php echo $sel1; ?> ><?php echo $month_label;?></option>
                          <?php } ?>
                </select>
                </div> 
                <div class="input-group">
                 <?php 
                   $year = date('Y');$min = $year-1;$max = $year;
                  ?>   
                 <select name="year_sub" id="year_sub" class="form-control"  style="width:130px;" required>
                  <option value="">-Select Year-</option>
                 <?php 
                  for($i=$max; $i>=$min; $i--) {
                      $sel='';
                      if($i==$year_r){ $sel="selected"; }
                      echo '<option value='.$i.' '.$sel.' >'.$i.'</option>';
                   } ?>
                </select>
                </div> 
                <div class="form-group">
                  <label for="amount">Amount:</label>
                  <input type="text" size="10" pattern="\d*" placeholder="amount" value="<?php echo $amount_r; ?>" required class="form-control" id="ads_amount" name="ads_amount">
                </div>
                     
                    <button type="submit" name="<?php echo $revenue_button; ?>" class="btn btn-default">Save</button>
              </form> 
                
                <div class="box-body" style="border: 0px solid red;">
                  <?php
                  $qry_rt="select SUM(amount) AS TotalAmount from ads_revenue where tag='ads_revenue'";
                  $ffrtotal= db_select($conn,$qry_rt);
                  $TotalAmount=$ffrtotal[0]['TotalAmount'];
                  $qry_r="select * from ads_revenue where tag='ads_revenue'";
                  $ffr= db_select($conn,$qry_r);
                  ?>    
                 <div class="table-responsive">
                    <table class="table no-margin">
                      <thead>
                        <tr>
                          <th>Year</th>
                          <th>Month</th>
                          <th>Amount</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach($ffr as $frevenue){
                         $ads_id=$frevenue['ads_id']; $year=$frevenue['year']; $month=$frevenue['month'];  $ads_amount=$frevenue['amount'];
                         $month_label = date('F', mktime(0, 0, 0, $month, 2));
                         ?>  
                        <tr>
                          <td><?php echo $year; ?></td>
                          <td><?php echo $month_label; ?></td>
                          <td><?php echo $ads_amount; ?></td>
                           <td>
                          <?php  if(in_array(2, $UserRight)){ ?> 
                               <a href="basic_setting.php?adsid=<?php echo $ads_id; ?>&act=ads_revenue_edit"><i  class="status-icon fa  fa-edit " style="cursor: pointer;"></i> </a>
                          <?php } ?>
                          </td>
                        </tr>
                        <?php } ?>
                        <tr><td colspan="2"><strong>Total</strong></td><td><strong><?php echo $TotalAmount; ?></strong></td></tr>
                      
                      </tbody>
                    </table>
                  </div><!-- /.table-responsive -->
                 </div>
              </div>
              
              
            </div><!--/.col (left) -->
            <!-- right column -->
          
          </div>
     
 </section>
</div>
    <?php include_once "footer.php"; include_once 'commonJS.php'; ?>
    </div>
</body>
</html>
