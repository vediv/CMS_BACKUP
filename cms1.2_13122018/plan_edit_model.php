<?php
include_once 'corefunction.php'; 
$id=$_REQUEST['Entryids'];
$query1="select planID,planName,pValue,pduration from plandetail where planID='$id'";
$query2= db_select($conn,$query1);
 ?>
      <!-- Modal content-->
<div class="tab-pane active" id="tab1" >
	<div style=" border:1px solid #c7d1dd ;">
<form class="form-horizontal" role="form" action="#" method="post" ><br/>
<div class="form-group">
<label class="control-label col-md-3">Plan Name:</label>
<div class="col-md-8">
<input type="text"  class="form-control" value="<?php echo $query2[0]['planName']; ?>"  name="pname">
</div>
</div>

   <div class="form-group">
      <label class="control-label col-md-3" >Plan Duration:</label>
      <div class="col-md-8"> 
        <input type="text"  class="form-control" name="pduration" value="<?php echo $query2[0]['pduration']; ?>" required aria-required pattern="^[a-zA-Z\d@#$_-]*$" placeholder="Enter Search Tag Name" title="Space Not Allowed">
      </div>	
    </div>

   <div class="form-group">
<label class="control-label col-md-3">Plan Amount:</label>
<div class="col-md-8">
<input type="text"  class="form-control" value="<?php echo $query2[0]['pValue']; ?>"  name="pamount">
</div>
</div>
<input type="hidden" class="form-control" name="id" value="<?php echo $query2[0]['planID']; ?>">
   <div class="modal-footer" style="margin-top:25px;">
    <div class="col-sm-offset-2 col-sm-8" style="margin-left: -140px;">
    <button type="submit" name="sub" class="btn btn-primary" id="edit">Update</button>
   </div>
  </div>
  </form>
</div></div>
 
