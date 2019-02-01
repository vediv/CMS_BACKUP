<?php
include_once 'corefunction.php';
$commanmsg = isset($_GET['val']) ? $_GET['val'] : '';
if($commanmsg=="Deactive")
{ $msgcall="Plan Deactive Successfully";  }
if($commanmsg=="Active")
{ $msgcall="Plan Active Successfully";  }
if($commanmsg=="edit")
{ $msgcall="Successfully Edit";  }
if($commanmsg=="sucess")
{ $msgcall="Successfully Added";  }
?>
<!DOCTYPE html>
<html>
  <head>
        <meta charset="UTF-8">
  	   
     <title><?php echo PROJECT_TITLE."-Menu Setting";?></title>
     <link href="dist/css/navAccordion.css" rel="stylesheet">
<style>
	input[type="radio"], input[type="checkbox"] {
    line-height: normal;
    margin: 8px 6px 0 !important;
}
input[type="checkbox"] {
	 size:12px !important;
}
</style>
  </head>
  <body class="skin-blue">
    <div class="wrapper">
   <?php include_once 'header.php';?>
           <!-- Left side column. contains the logo and sidebar -->
      <?php include_once 'lsidebar.php';?>
      <!-- Content Wrapper. Contains page content -->
<?php 
if(isset($_POST['save_menu']))
{     
        $menu_value=$_POST['menu_value'];  $m_name=$_POST['m_name'];  $m_url=$_POST['m_url']; $icon=$_POST['icon']; 
        if($menu_value==0)
        {
            $Query_plan="insert into menus(mname,menu_url,mparentid,mstatus,created_at,icon_class)
   	    values('$m_name','$m_url','$menu_value','1',NOW(),'$icon')";
            $saveplan = db_query($conn,$Query_plan);
        }    
        else{
        
        $Query_plan="insert into menus(mname,menu_url,mparentid,mstatus,created_at,icon_class)
   	values('$m_name','$m_url','$menu_value','1',NOW(),'$icon')";
        $saveplan = last_insert_id($conn,$Query_plan);
        
        
        $getChild_id="select child_id from menus where mid='$menu_value'";
        $ff=  db_select($conn,$getChild_id);
        $child_id=$ff[0]['child_id'];
        
        if($child_id!='')
        {
            $childID=$child_id.",".$saveplan;
        } 
        else{$childID=$saveplan; }
        $up="update menus set multilevel='1',child_id='$childID' where mid='$menu_value'";
        $save_plan = db_query($conn,$up);
        }
                {
                         header("Location:menu_setting.php?msg=success");       
                }
} 
?>
        
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          
          <h1>Create Menu
       <a href="#myModal" class="addnew" id="add" title="Add New" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#myModal"><small><span style="color:#3290D4" class="glyphicon glyphicon-plus " ></span></small></a>    	
 </h1>
          <ol class="breadcrumb">
            <li><a href="dashboard.php"><i class="fa fa-home" title="Home"></i> Home</a></li>
              <li class="active">Create Menu</li>
          </ol>
        </section>
     <section class="content">
           <div class="row">
          <div class="col-xs-12">
          <div class="box">
        <div class=" ">
 
	<!-- create plan Model -->
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
                  <b>Add Menu</b>
                </h4>
            </div>
       <br/>
	<!-- <form class="form-horizontal" role="form" action="#" method="post" id="confirm" style="border: 0px solid red;">-->
		  <div style="border: 1px solid #c7d1dd ; padding-top: 20px ">
<form id="myform" method="post" class="form-horizontal" >
<div class="col-lg-12">
  <div class="form-inline">
  <div class="col-sm-6 col-md-6 col-lg-6 pull-right">
 <!-- <input type="text" class="form-control" name="category_search" style="  width: 271px !important; margin-left: 9em;"   value="" placeholder="Search Categories">-->
  </div>
  </div>
</div>       
<hr style="border-top:2px solid red; margin-top: 0px; padding: 0px 0px 0px 0px">  </hr>
<div class="form-group" >
<label for="inputPassword" class="control-label col-xs-4">Menu Category:</label>
<div class="col-xs-8">
<div class="container1"> 	                 
<div class="row"> 
<div class="col-md-12" style="padding-right: 20px">
<div id="sidebar" class="well sidebar-nav" style="border: 0px solid red;"> 
<div class="mainNav">
 <div style="margin: 0px 0 9px 0px !important">
     <input type="radio" name="menu_value"  id="menu_value" required value="0" style="margin: 3px 23px 10px 6px  !important"> No Parent </label>
 </div>
<ul style="height:170px;overflow-y: scroll;display: block;   border: 1px solid #c7d1dd; padding: 10px 2px;">
<?php
$que="SELECT mid,mname,mparentid FROM menus where mparentid=0" ;
$row=db_select($conn,$que);
foreach ($row as  $menu) {                                    
$mid=$menu['mid']; $mname=$menu['mname'];  $mparentid=$menu['mparentid']; $icon=$menu['icon'];
?>    
<li style="border-bottom: 1px solid #c7d1dd !important; border-top: 0px solid #c7d1dd !important;"> <input type="radio" name="menu_value"    id="menu_value" required value="<?php  echo $mid; ?>">	
<a href="#" style="font-size: 13px !important; color: #555;"><?php echo strtoupper($mname);?></a>
<ul>
<?php
 $ques="SELECT mid,mname FROM menus where mparentid='$mid'" ;
$rows=db_select($conn,$ques);
foreach ($rows as  $menus) {                                    
$mids=$menus['mid'];  $mnames=$menus['mname'];

   ?>	
<li>
<a href="#"> <?php  echo strtoupper($mnames); ?></a>

</li>
<?php } ?>
</ul>
</li>			
<?php 
  }
 ?>
</ul>
</div>
  </div>
        </div>    
    </div>                                                                                                           
</div> 
  </div>
     </div>

       <div class="form-group">
            <label for="inputEmail" class="control-label col-xs-4">Menu Name:</label>
            <div class="col-xs-7">
                <input type="text" class="form-control" required id="m_name" name="m_name" placeholder="Menu Name" value="">
            </div>
        </div>
         <div class="form-group">
            <label for="inputPassword" class="control-label col-xs-4">Menu URL:</label>
            <div class="col-xs-7">
            <textarea class="form-control" rows="1" id="m_url" name="m_url" placeholder="Page URL" ></textarea>
            </div> 
        </div>
         <div class="form-group">
            <label for="inputEmail" class="control-label col-xs-4">Menu Icon Class:</label>
            <div class="col-xs-7">
                <input type="text" class="form-control" required id="icon" name="icon" placeholder="Menu Icon Class" value="">
            </div>
        </div>
       
<div class="form-group">
    <div class="col-xs-offset-4 col-xs-8">
        <button type="submit" class="btn btn-primary" name="save_menu">Save & Close</button>
    </div>
 </div>

   </form> </div> </div>
		
  </div>
    </div>
  </div>
</div>
<!-- Main content -->
      
<?php
	
if(isset($_POST['sub'] ))
{
 $id=$_POST['id'];
$pname=$_POST['pname'];
$pduration=$_POST['pduration'];
$pamount=$_POST['pamount'];

$query3="update plandetail set planName='$pname',pValue='$pamount',pduration='$pduration',plan_update_date=Now() where planID='$id'";
$q= db_query($conn,$query3);
if($q)
 {
    	header("Location:planDetail.php?val=edit");  
		
		/*----------------------------update log file begin-------------------------------------------*/
   //$cdate=date('d/m/Y H:i:s');  $action="Edit Title(".$pname.")"; $username=$_SESSION['username'];
   //write_log($cdate,$action,$username);
    /*----------------------------update log file End---------------------------------------------*/ 
  }
}

?>
<div class="box" style="border-top: 0px !important">
 <!-- /.box-header -->
<div class="box-body">
 	 <form method="post">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                     <tr>
                            <th>Menu-Name</th>
                            <th>Menu ID</th>
                            <th>Page-Link</th>
                            <th>Create-Date</th>
			    <th>Status</th>
			    <th width="10%">Action</th>
                         
                      </tr> 
                    
                    </thead>
                    <tbody>
 
                    	
 <?php 

// value come from notification
$sql="SELECT * FROM menus order by mname DESC";		
//$sql="select uid,user_id,uname,uemail,dob,ugender,ulocation,added_date,status,oauth_provider from user_registration where partner_id='$partnerID' $addquery $query_search order by uid DESC LIMIT $start, $limit";
$result = db_query($conn,$sql);	
$rr= db_select($conn,$sql);
//$num=db_totalRow($q);
 foreach($rr as $fetch)
   {
     $mid=$fetch['mid'];  $mname=$fetch['mname']; $menu_url=$fetch['menu_url']; $mparentid=$fetch['mparentid']; 
     $menu_added_date=$fetch['created_at']; $menu_update_date=$fetch['updated_at']; $mstatus=$fetch['mstatus']; 
 ?> 
    <tr id="del<?php  echo $mid; ?>">                   
    <td><?php echo ucwords($mname); ?></td>
    <td><?php echo $mid; ?></td>
    <td><?php echo $menu_url; ?></td>
    <td><?php echo $menu_added_date; ?></td>
    <td id="getstatus<?php  echo $mid; ?>"><?php echo $mstatus==1?"Active": "DeActive"; ?></td>
    <input type="hidden" size="2" id="act_deact_status<?php echo $mid;  ?>" value="<?php echo $mstatus;  ?>" >        
<td> 
<a href="#" class="delete" title="Delete" onclick="mdelete('<?php echo  $mid; ?>')" ><span class="glyphicon glyphicon-trash"></span></a> &nbsp;&nbsp;&nbsp;
<a href="#LegalModal" id="<?php  echo $mid; ?>"  data-target=".bs-example-modal-lg" data-toggle="modal" title="Edit" class="result"><span class="glyphicon glyphicon-edit"></span></a>&nbsp;&nbsp;&nbsp;
<a href="#">
  <i id="icon_status<?php echo $mid; ?>" class="status-icon fa <?php  echo ($mstatus == 1) ? 'fa-check-square-o':'fa-ban';?>" onclick="act_dect('<?php echo  $mid; ?>')" ></i>
</a> 


</td>                
     
  
            </tr>       
                  <?php } ?>  
                          
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
      
	<div id="LegalModal" tabindex="-1" aria-labelledby="myModalLabel" role="dialog"  aria-hidden="true" class="modal fade bs-example-modal-lg" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
          <div class="modal-content" style="border-radius: 14px;">
               <div class="modal-body">
                   <div class="modal-header">
                        <button type="button" class="close" 
                           data-dismiss="modal">
                               <span aria-hidden="true">&times;</span>
                               <span class="sr-only">Close</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel"> <b>Edit Menu Details</b></h4> 
                  </div>
           <div class="tab-content" id="tabs">
             <?php //include"model.php"; ?>
           </div>
        </div>
      </div>
    </div>
  </div>

      <?php
       include_once"footer.php"; include_once 'commonJS.php';  
      ?>
    </div><!-- ./wrapper -->
<script src="js/navAccordion.min.js" type="text/javascript"></script>
<script type="text/javascript">
		jQuery(document).ready(function(){
			//Accordion Nav
			jQuery('.mainNav').navAccordion({
				expandButtonText: '<i class="fa fa-chevron-right"></i>',  //Text inside of buttons can be HTML
				collapseButtonText: '<i class="fa fa-chevron-down"></i>'
			}, 
			function(){
				//console.log('Callback')
			});
			
		});
                
function mdelete(menuid){
var st=document.getElementById('act_deact_status'+menuid).value;
if(st==1) { alert('This Menu is active so you can not delete'); return false;} 
var d=confirm("Are you sure you want to Delete This?");
if(d)
{
       var info = 'menuid='+ menuid+'&action=menu_delete';
       $.ajax({
       type: "POST",
       url: "coredelete.php",
       data: info,
       success: function(r){
         if(r==1)
         {
             var adstatus=document.getElementById('getstatus'+menuid).innerHTML="delete";
             document.getElementById('getstatus'+menuid).style.color = 'red';
             $("#del" + menuid).remove();
            
         }   

         }
    });  
}    

}
                
</script>  
<script type="text/javascript">
function act_dect(menuid){
var adstatus=document.getElementById('act_deact_status'+menuid).value;
var msg = (adstatus == 1) ? "Deactive":"Active";
var c=confirm("Are you sure you want to "+msg+ " This?");
if(c)
{
 $.ajax({
   type: "POST",
   url: "core_active_deactive.php",
   data:'menuid='+menuid+'&adstatus='+adstatus+'&action=menu',
   success: function(r){
   	   if(r==0)
   	   { 
   	   	 var adstatus=document.getElementById('getstatus'+menuid).innerHTML=msg;
   	   	
   	     $('#icon_status'+menuid).removeClass('fa-check-square-o').addClass('fa-ban');
   	   }
   	   if(r==1)
   	   {
   	   	var adstatus=document.getElementById('getstatus'+menuid).innerHTML=msg;
   	   
   	   	$('#icon_status'+menuid).removeClass('fa-ban').addClass('fa-check-square-o');
   	   }
            $('#act_deact_status'+menuid).val(r);
       
       
     }
 
   });
 }  
}

    

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

  </body>
</html>
