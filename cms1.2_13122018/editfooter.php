<?php
include_once 'corefunction.php';
$id=$_REQUEST['id'];
$query1="select f_year,f_content,f_hyperlink,f_date,f_status,f_id from dashbord_footer where f_id='$id' ";
$query2= db_select($conn,$query1);
?>
<html>
 <body>
  	 
<div class="tab-pane active" id="tab1" >
  	 <form class="form-horizontal" role="form" action="#" method="post" ><br/>
<div class="form-group">
<label class="control-label col-md-10">Year:</label>
<div class="col-md-10">
        <select class="form-control" name="year" style="width:450px" >
            <option  class="form-control" value="<?php echo $query2[0]['f_year']; ?>"><?php echo $query2[0]['f_year']; ?></option>
            <option value="2015">2015</option>
            <option value="2016">2016</option>
            <option value="2017">2017</option>
            <option value="2018">2018</option>
            <option value="2019">2019</option>
             <option value="2020">2020</option>
        </select>									
</div>
</div>
<br/>

<div class="form-group"> <br/>
      <label class="control-label col-md-10" >Content:</label>
      <div class="col-md-10"> 
        <input type="text" style="width:450px" class="form-control" name="content"  value="<?php echo $query2[0]['f_content']; ?>" required/>
      </div>	
    </div>
<br/>
<div class="form-group"> <br/>
      <label class="control-label col-md-10" >Url:</label>
      <div class="col-md-10"> 
        <input type="url" style="width:450px" class="form-control" name="url"  value="<?php echo $query2[0]['f_hyperlink']; ?>" required/>

      </div>	
    </div>
                <br/>
         <input type="hidden" class="form-control" name="id" value="<?php echo $id; ?>">
         <div class="modal-footer" style="margin-top:25px;">
           <div class="col-sm-offset-2 col-sm-10" style="margin-left: -140px;">
    <button type="submit" name="submit" class="btn btn-primary"  id="edit">Update</button>
   </div>
  </div>

</form>
	 </div>
 
  </body>
</html>