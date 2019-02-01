<?php
include_once 'corefunction.php';
$id=$_REQUEST['id'];
$query1="select img_id,ventryid from slider_image_detail where img_id='$id'";
$r= db_select($conn,$query1);
foreach($r as $row)
{
   $url1=$row['ventryid'];	
   $id1=$row['img_id'];	
/*----------------------------update log file begin-------------------------------------------*/
   //$cdate=date('d/m/Y H:i:s');  $action="Edit image url (".$url1.")"; $username=$_SESSION['username'];
   //write_log($cdate,$action,$username);
    /*----------------------------update log file End---------------------------------------------*/ 
 
}

?>
<form class="form-horizontal" role="form" action="#" method="post" id="confirm">
<div class="form-group">
<label class="control-label col-sm-3">Enter Entry ID:</label>
    <div class="col-sm-10">
        <input type="" class="form-control" required name="iurl" value="<?php  echo $url1;  ?>" placeholder="Entry ID">
    </div>
</div>


<div class="form-group">
<label class="control-label col-sm-3"></label>
<div class="col-sm-8">
<input type="hidden" class="form-control" required name="id1" value="<?php  echo $id1;  ?>" placeholder="image url">
 </div>
 </div>
									    
<div class="modal-footer">
<div class="col-sm-offset-2 col-sm-5">
<button type="submit" name="img_up" class="btn btn-primary" >Update</button>
</div>
</div>

</form>
												          
							
