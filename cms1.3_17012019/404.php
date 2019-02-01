<?php 
include_once 'corefunction.php';
?>
<!DOCTYPE html>
<html>
  <head>
     <meta charset="UTF-8">
     <title><?php echo PROJECT_TITLE." | 404 Page not found";?></title>
     <link href="bootstrap/css/pagingCss.css" rel="stylesheet" type="text/css" />
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
          <h1>404 Error Page</h1>
          <ol class="breadcrumb">
            <li><a href="dashboard.php"><i class="fa fa-home" title="Home"></i> Home</a></li>
            <li class="active">404 error</li>
          </ol>
        </section>
      <section class="content">
          <div class="error-page">
            <h2 class="headline text-yellow"> 404</h2>
             <br/>
            <div class="error-content">
              <h3><i class="fa fa-warning text-yellow"></i> Oops! Page not found.</h3>
              <p>
                We could not find the page you were looking for.
                Meanwhile, you may <a href="dashboard.php">return to dashboard</a>.
              </p>
             
            </div><!-- /.error-content -->
          </div><!-- /.error-page -->
        </section>
      </div>
<?php include_once "footer.php"; include_once 'commonJS.php'; ?>
    </div>
  </body>
</html>