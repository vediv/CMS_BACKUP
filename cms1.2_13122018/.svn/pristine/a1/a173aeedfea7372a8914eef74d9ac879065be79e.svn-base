<?php 
include_once 'corefunction.php';
$filterBy=isset($_GET['filter'])?$_GET['filter']:'subscriber';
?>
<!DOCTYPE html>
<html>
  <head>
  <meta charset="UTF-8">
  <title><?php echo PROJECT_TITLE." | Push Notification";?></title>
  <link href="bootstrap/css/pagingCss.css" rel="stylesheet" type="text/css" />
  </head>
  <body class="skin-blue">
    <div class="wrapper">
    <?php include_once 'header.php';?>
   <?php include_once 'lsidebar.php';?>
   <div class="content-wrapper">
<section class="content-header">
  <h1>Push Notification</h1> 
  <ol class="breadcrumb">
    <li><a href="dashboard.php"><i class="fa fa-home" title="Home"></i> Home</a></li>
    <li class="active">Push Notification</li>
  </ol>          
</section>
<section class="content">
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
              <div class="row">   
              <div class="col-sm-6">
               <form class="form-horizontal" style="margin-top: 5px;">
                <div class="form-group">
                  <div class="col-sm-4">
                      <select class="form-control" onchange="getFilter(this.value);">
                       <option value="0">--Filter By--</option>
                       <option value="subscriber" <?php echo $filterBy=='subscriber'?'selected' :''; ?> >Subscriber</option>
                       <option value="broadcast" <?php echo $filterBy=='broadcast'?'selected' :''; ?>>Broadcast</option>
                   </select>
                  </div>
                </div>
                 
             </form>
              </div>
               <div class="col-sm-4 pull-right" style="border:0px solid red;margin-top: 5px;">
                   <div class="input-group pull-right"><label>Device: </label>
    				<div id="radioBtn" class="btn-group">
    					<a class="btn btn-primary btn-sm active">Mobile</a>
    				</div>
    			</div>
    		
                </div>
    	    </div>
           </div>
          
            <div id="results" style="border:0px solid red; margin:0px 5px 0px 5px;">
                <div class="box-header" >
                    <div class="row">
                        <?php
                        switch($filterBy)
                        {
                              case "subscriber":
                              $action='subscriber';    
                              include_once 'view/notificationTemplate.php';
                              break;
                              case "broadcast":
                              $action='broadcast';    
                              include_once 'view/notificationTemplate.php';
                              break;
                        }
                        ?>
                    </div>
                </div>
                
            </div> 
            </div>
        </div>  
    </div>  
</div>

<?php include_once "footer.php"; include_once 'commonJS.php'; ?>
</div><!-- ./wrapper -->
<script type="text/javascript">
function getFilter(filterval)
{
    if(filterval==0)
    {
        alert("Select Filter By"); return false;
    }    
    location.href="notification.php?filter="+filterval;
    
}
</script>
</body>
</html>
