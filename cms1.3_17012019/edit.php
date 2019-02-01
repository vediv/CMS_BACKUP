<?php
include_once 'corefunction.php';
$id=$_REQUEST['id'];  $getpageindex=$_REQUEST['pageindex']; 
$query1="select uid,uname,uemail,dob,ugender,ulocation from user_registration where uid='$id'";
$query2= db_select($conn,$query1);

?>
<div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit User - <?php echo $query2[0]['uname']; ?></h4>
         </div>
          <div class="modal-body" >
          	<div style=" border:1px solid #c7d1dd;">
  	 <form class="form-horizontal" role="form" action="#" method="post">
  	 	
<div class="form-group" style="display: flex; margin-top: 12px !important;">
<label class="control-label col-md-3">Name:</label><br/><br/>
  <div class="col-md-8">
        <input type="text"  id="uname" class="form-control" value="<?php echo $query2[0]['uname']; ?>"  name="name">
        </div>
        </div>

   <div class="form-group" style=" display: flex;">  
      <label class="control-label col-md-3" >Email:</label><br/><br/>
       <div class="col-md-8">
        <input type="text" id="uemail" class="form-control" name="email" value="<?php echo $query2[0]['uemail']; ?>" required>
      </div>	
    </div>
   <div class="form-group" style=" display:flex;"> 
      <label class="control-label col-md-3" >DOB:</label> <br/><br/>
       <div class="col-md-8">
        <input type="text"  id="udob" class="form-control" name="dob" value="<?php echo $query2[0]['dob']; ?>" required>
      </div>	
    </div>

   <div class="form-group" style=" display:flex;">
      <label class="control-label col-md-3" >Gender:</label><br/><br/>
      <div class="col-md-8">
        <input type="text"  id="ugender" class="form-control" name="gender" value="<?php echo $query2[0]['ugender']; ?>" required>
      </div>	
    </div>
   <div class="form-group" style=" display:flex;">  
      <label class="control-label col-md-3" >Location:</label><br/><br/>
      <div class="col-md-8">
        <input type="text" id="ulocation" class="form-control" name="location" value="<?php echo $query2[0]['ulocation']; ?>" required>
      </div>	
   </div>
<input type="hidden" class="form-control" name="id" value="<?php echo $query2[0]['uid']; ?>">
   <div class="modal-footer" style="margin-top:25px; ">
           <div class="col-sm-offset-1 col-sm-4" >
    <button type="button" data-dismiss="modal" name="sub" class="btn btn-primary" id="edit" onclick="save_edit('save_edit','<?php echo $id; ?>','<?php echo $getpageindex;  ?>');">Update</button>





   </div>
  </div>
</form>
			 
			<div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
       </div>
			</div>			 	  
	 </div>

<script type="text/javascript">
function save_edit(action,id,pageindex){
	var upname = $('#uname').val();
	var upemail = $('#uemail').val();
	var updob = $('#udob').val();   
	var upgender = $('#ugender').val();
	var uplocation = $('#ulocation').val();
	var dataString ='action='+action+'&id='+id+'&pageindex='+pageindex+'&upname='+upname+'&upemail='+upemail+'&updob='+updob+'&upgender='+upgender+'&uplocation='+uplocation;
   
    $.ajax({
           type: "POST",
           url: "loadDataPagingUserList.php",
           data: dataString,
           cache: false,
           success: function(result){
             //alert(result);
             // $("#results").html('');
              //	 $("#flash").hide();
           	 $("#pagingResult").html(result);
           }
    });   
}
</script>
