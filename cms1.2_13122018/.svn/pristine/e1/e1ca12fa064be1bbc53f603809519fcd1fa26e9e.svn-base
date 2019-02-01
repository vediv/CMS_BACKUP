<?php
include_once 'corefunction.php';
$id=$_REQUEST['Menuids'];
$query1="select mid,mname,menu_url from menus where mid='$id'";
$query2= db_select($conn,$query1);
 ?>
      <!-- Modal content-->
<div class="tab-pane active" id="tab1" >
<form class="form-horizontal" role="form" action="#" method="post" ><br/>
<div class="form-group">
<label class="control-label col-md-10">Menu Name:</label>
<div class="col-md-10">
<input type="text" style="width:450px" class="form-control" value="<?php echo $query2[0]['mname']; ?>"  name="mname">
</div>
</div>
<br/>
   <div class="form-group"> <br/>
      <label class="control-label col-md-10" >Menu URL:</label>
      <div class="col-md-10"> 
        <input type="text" style="width:450px" class="form-control" name="menu" value="<?php echo $query2[0]['pduration']; ?>" required aria-required pattern="^[a-zA-Z\d@#$_-]*$" placeholder="Enter Search Tag Name" title="Space Not Allowed">
      </div>	
    </div>

   <div class="form-group">
<label class="control-label col-md-10">Plan Amount:</label>
<div class="col-md-10">
<input type="text" style="width:450px" class="form-control" value="<?php echo $query2[0]['pValue']; ?>"  name="pamount">
</div>
</div>
<input type="hidden" class="form-control" name="id" value="<?php echo $query2[0]['planID']; ?>">
   <div class="modal-footer" style="margin-top:25px;">
    <div class="col-sm-offset-2 col-sm-10" style="margin-left: -140px;">
    <button type="submit" name="sub" class="btn btn-primary" id="edit">Update</button>
   </div>
  </div>
  </form>
</div>
 
