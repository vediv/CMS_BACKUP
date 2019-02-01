<?php
include_once 'corefunction.php';
require 'define.php';
$commonmsgg = isset($_GET['vall']) ? $_GET['vall'] : '';
$msgcalll='';
if($commonmsgg=="update")
{ $msgcalll="Template Edit Successfully";  }
?>
<!DOCTYPE html>
<html>
  <head>
        <meta charset="UTF-8">
        <title><?php echo PROJECT_TITLE." | Template List";?></title>
        <link href="bootstrap/css/pagingCss.css" rel="stylesheet" type="text/css" />
  </head>
  <body class="skin-blue">
    <div class="wrapper">
   <?php include_once 'header.php';?>
      <?php include_once 'lsidebar.php';?>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          
          <h1>Template list <a href="createTemplate.php"><small><span class="glyphicon glyphicon-plus" style="color:#3290D4"></span></small></a></h1>
          <ol class="breadcrumb">
            <li><a href="dashboard.php"><i class="fa fa-home" title="Home"></i> Home</a></li>
              <li class="active">Template list</li>
          </ol>
        </section>
     <section class="content">
           <div class="row">
          <div class="col-xs-12">
          <div class="box">
        <div class=" ">
 
</div>
<!-- Main content -->
 <div class="box" style="border-top: 0px !important">
 
 <div class="box-body">
 	 <form method="post">
                   <table id="example1" class="table table-bordered table-striped">
                    <thead>
                     <tr>  
                            <th>Template Name</th>
                            <th>Create-Date</th>
                            <th>Action</th>
			<!--    <th>Status</th>
			    <th width="10%">Action</th>-->
                      </tr> 
                    
                    </thead>
                    <tbody>
 
                    
<?php
$DBname=DATABASE_Name;
$path = TEMPLATE_CONFIG_PATH.$DBname;
if(is_dir($path))
{
$handle = opendir($path);
while ($file = readdir($handle)) {
if($file != '.' && $file != '..') {
$date = date ("F d Y H:i:s.", filemtime($path));
?>
<tr>
<td><?php echo $file ;?></td>
<td><?php  echo $date; ?></td> 
<td><a href="createTemplate.php?name=<?php echo $file ;?>&act=edit" title="Edit"><span class="glyphicon glyphicon-edit"></span> </a>
<a href="#" class="myBtn" filename="<?php echo $file ;?>"><span class="glyphicon glyphicon-eye-open" style="padding: 0px 10px"></span></a>	     
</td>
</tr> 
<?php 
  }
}
  closedir($handle);
//}
}
else
{
    echo "No template exist."; 
}
                  ?>  
                          
                    </tbody>                  
                  </table>
             
             
      </form>         
 </div>
 </div>             
                
               <!-- /.box-body -->
 </div><!-- /.box -->  
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
     <?php include_once "footer.php"; include_once 'commonJS.php'; ?>
    </div><!-- ./wrapper -->
<div class="modal fade" id="myModalcredential" role="dialog" data-keyboard="false" data-backdrop="static">
 <div class="modal-dialog modal-lg">
   <div class="modal-content" id="view_edit_credential">   
   </div>
 </div>
</div> 

<script type="text/javascript">
  /* this is for model JS with edit and view detail */
     $(document).ready(function(){
	    $(".myBtn").click(function(){
        $("#myModalcredential").modal();
		var element = $(this);
		var filename = element.attr("filename");
		var info = 'filename=' + filename; 
        // alert(info);
       $.ajax({
	    type: "POST",
	    url: "viewTemplateFile.php",
	    data: info,
        success: function(result){
        $('#view_edit_credential').html(result);
        return false;
        }
 
        });
     return false;    
    });
 
});
</script>    

       
  </body>
</html>
