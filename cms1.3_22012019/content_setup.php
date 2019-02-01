<?php 
include_once 'corefunction.php';
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
  <title><?php echo ucwords(PROJECT_TITLE)." | SMTP Config";?></title>
  <link href="bootstrap/css/pagingCss.css" rel="stylesheet" type="text/css" />
  <link href="bootstrap/css/content_setup.css" rel="stylesheet" type="text/css" />
  <script type="text/javascript" src="js/ajax.js"></script>
  <script type="text/javascript" src="js/content_setup.js"></script>
   <!-- CK Editor -->
    <script src="https://cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>
    
  </head>
  <body class="skin-blue">
    <div class="wrapper">
      <?php include_once 'header.php';
      include_once 'lsidebar.php';?>
     <link href="js/flot/morris.css" rel="stylesheet" type="text/css" />
      
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper" style="min-height: 700px !important;">
        <section class="content-header">
          <h1>Page Content Setup</h1> 
          <ol class="breadcrumb">
            <li><a href="dashbord.php"><i class="fa fa-home" title="Home"></i> Home</a></li>
            <li class="active">Mail Config</li>
          </ol>          
         </section>
         
          <div class="row">
              <div class="container-fluid">
                  <div class="col-sm-12">
                      <div class="bg-white padding5 paddingL10">a
                      
                      <form>
                    <textarea id="editor1" name="editor1" rows="10" cols="80">
                     
                    </textarea>
                  </form>
                      </div>
                  </div>
              </div>
             
          </div>
          
          
     </div><!-- /.content-wrapper -->
    
 <?php 
include_once "footer.php"; 
include_once 'commonJS.php';  
?>
  
         </div><!-- ./wrapper -->
 
     </body>
     
     <script>
      $(function () {
        // Replace the <textarea id="editor1"> with a CKEditor
        // instance, using default configuration.
        CKEDITOR.replace('editor1');
       
      });
    </script>
</html>
