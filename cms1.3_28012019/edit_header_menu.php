<?php
include_once 'corefunction.php';
 $id=$_REQUEST['id'];
$query1="select hid,category_id,header_name from header_menu where hid='$id'";
$query2= db_select($conn,$query1);
 ?>
    
      <!-- Modal content-->
   <html>
   
  <body>
  	 
   <div class="tab-pane active" id="tab1" >
  	 <div style=" border:1px solid #c7d1dd ;">
  <form class="form-horizontal" role="form" action="#" method="post" >
   <br/> 
    <div class="form-group" style="margin-top: 12px">
    <label class="control-label col-md-4">Menu Header Name:</label>
    <div class="col-md-5">
    <input type="text"  class="form-control" value="<?php echo $query2[0]['header_name']; ?>"  name="headername">
    </div>
    </div>
   
  
    <input type="hidden" class="form-control" name="id" value="<?php echo $query2[0]['hid']; ?>">
       <div class="modal-footer" >
       <div class="col-sm-offset-2 col-sm-4" >
        <button type="submit" name="sub" class="btn btn-primary center-block" id="edit">Update</button>
      </div>
      </div>

    </form>
			</div>				 
   </div>
   
  
</body>
</html>
 
