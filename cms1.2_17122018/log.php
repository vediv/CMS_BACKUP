<?php 
include_once 'auths.php';
include_once 'auth.php';  
include_once 'function.inc.php';
$message='';
?>
  
<!DOCTYPE html>
<html>
  <head>
  	
  	

    <meta charset="UTF-8">
    	<?php include_once 'pagename.php';?>
    <title><?php echo PROJECT_TITLE."-".$PageName;?></title>
  
  </head>
  <body class="skin-blue">
    <div class="wrapper">
<?php include_once 'header.php';?>

<?php include_once 'lsidebar.php';?>
      <!-- Left side column. contains the logo and sidebar -->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
         <h1>History </h1><!--<ul class="list-unstyled legal-tabs" style="text-align:center;">-->
     <!--  <a href="#LegalModal" data-target=".bs-example-modal-lg" data-toggle="modal" title="Add New"><small><span class="glyphicon glyphicon-plus" style="color:#3290D4"></span></small></a></h1>--> 
          <ol class="breadcrumb">
            <li><a href="dashboard.php"><i class="fa fa-home" title="Home"></i> Home</a></li>
            <li class="active">Image Slider</li>
          </ol>          
            <span style="color: red;"><?php  echo  $message;?>   </span>
   
        </section>
       
        <section class="content">
           <div class="row">
          <div class="col-xs-12">
          <div class="box">
        <div class="box-header">
      
     <style>
</style>   
</div>
		  <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Log History</h3>
                 
                </div><!-- /.box-header -->
                <div class="box-body">
                  <form action="#" id="form" name="form">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
	                       <tr>
	                      	       <th>Sno</th>
	                               <th>Date & Time</th>                      
	                               <th>Action</th>
	                               <th>User</th>
	                       </tr>
                     </thead>
         <tbody>
                    	
                  <?php 
                       $i=1;
			           $file1=file("files/logs.txt");
			           krsort($file1);	
			           //print_r($file1);
			           foreach ($file1 as $fvalue) {
				             // echo $fvalue ."<br/>";
				               $num = explode(",", $fvalue);
				               $date= $num [0];
				               $action= $num [1];
				               $user= $num [2];
				 ?>     
	
	                    <tr>
		                    <td><?php echo $i;  ?></td>
	                        <td><?php echo $date;  ?></td>
	                        <td><?php echo$action;?></td>
	                        <td><?php echo $user;?></td>
                        </tr>      
                      
                      
                    
         <?php
         $i++;
         }?>             

      </tbody>
     </table>
                 
    
          <script type="text/javascript">
      $(function () {
        $("#example1").dataTable();
        $('#example2').dataTable({
          "bPaginate": true,
          "bLengthChange": false,
          "bFilter": false,
          "bSort": true,
          "bInfo": true,
          "bAutoWidth": false
        });
      });
    </script> 
    
 </div>
 </div>             
               <!-- /.box-body -->
 </div><!-- /.box -->  
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      
      <div class="modal fade" id="myModal" role="dialog" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content" style="border-radius: 14px; ">
        <div class="modal-body">
          <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                       <span aria-hidden="true">&times;</span>
                       <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">
                  <b>Edit Imagr Url</b>
                </h4>
            </div>
       <br/>
			<div class="tab-content" id="tabs">
				</div>			 	       
		 </div> 
		
  </div>
    </div>
  </div>
</div>

     <?php
      
      include"footer.php";
      ?>
    </div><!-- ./wrapper -->
	
 <script type="text/javascript">
bootbox.alert("<?php echo $msgcall;?>", function() {
 window.location.href='slider-images.php';
});
</script>

  </body>
</html>
