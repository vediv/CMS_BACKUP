<?php
include_once 'corefunction.php';
$id=$_REQUEST['id'];
$query1="select tags_id,title_tag_name,search_tag from home_title_tag where tags_id='$id'";
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
    <label class="control-label col-md-3">Tag Name:</label>
    <div class="col-md-5">
    <input type="text"  class="form-control" value="<?php echo $query2[0]['title_tag_name']; ?>"  name="ttag">
    </div>
    </div>
   
       <div class="form-group">
          <label class="control-label col-md-3" >Search Tag:</label>
          <div class="col-md-5"> 
            <input type="text"  class="form-control" name="stag" value="<?php echo $query2[0]['search_tag']; ?>" required aria-required pattern="^[a-zA-Z\d@#$_-]*$" placeholder="Enter Search Tag Name" title="Space Not Allowed">
          </div>	
        </div>
    <input type="hidden" class="form-control" name="id" value="<?php echo $query2[0]['tags_id']; ?>">
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
 
