<?php
include_once 'corefunction.php';
$act=$_REQUEST['act'];
$contentID=$_POST['id']; 
switch($act)
{
 
  case "edit":
  $q="select * from content_partner WHERE contentpartnerid='$contentID'";
  $fet=db_select($conn,$q);
  $cname=$fet[0]['name']; $cemail=$fet[0]['email']; $cmobile=$fet[0]['mobile'];
  $lsdate=$fet[0]['license_start_date']; $ledate=$fet[0]['license_end_date'];
  ?>
         <div class="tab-pane active" id="tab1" >
            <br/> 
            <div style=" border:1px solid #c7d1dd ;">
          <form class="form-horizontal" role="form" action="#" method="post" id="confirm" onsubmit="return validattion()" style="border: 0px solid red;  margin-top: 12px;">
		    <div class="form-group">
		      <label class="control-label col-sm-4">Name:</label>
		      <div class="col-sm-5">
		        <input type="name" class="form-control" required name="cname" placeholder="Content Partner Name" value="<?php echo $cname; ?>">
		      </div>
		    </div>
		    <div class="form-group">
		      <label class="control-label col-sm-4">Email:</label> 
		      <div class="col-sm-5">
		        <input type="email" class="form-control"  name="cemail" placeholder="Content Partner Email" value="<?php echo $cemail; ?>" > 
                      </div>
		    </div>
		    <div class="form-group">
		      <label class="control-label col-sm-4">Mobile:</label> 
		      <div class="col-sm-5">
                          <input type="text" class="form-control" onkeypress="return isNumber(event)" name="cmobile" id="mobile" placeholder="Content Partner Mobile number"   value="<?php echo $cmobile; ?>"> 
		      </div>
		    </div>
                     <div class="form-group"> 
		      <label class="control-label col-sm-4">License Start date: *</label> 
		      <div class="col-sm-5">
                          <input type="date" class="form-control"  name="lsdate" placeholder="YYYY-mm-dd" pattern='(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))' value="<?php echo $lsdate; ?>" required> 
		      </div>
		    </div>
                  <div class="form-group">
		      <label class="control-label col-sm-4">License End date: *</label> 
		      <div class="col-sm-5">
                          <input type="date" class="form-control"  name="ledate" placeholder="YYYY-mm-dd" pattern='(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))' value="<?php echo $ledate; ?>" required> 
		      </div>
		    </div>
                    <div class="modal-footer">
                       <div class="col-sm-offset-1 col-sm-5">
                          <input type="hidden" class="form-control" name="contentid" value="<?php echo $contentID; ?>"> 
                          <button type="submit" name="sub" class="btn btn-primary" id="edit">Save</button>
                        </div>
                     </div>
     </form></div>
        </div>
 

  
  <?php 
  break;    
}
?>

<script type="text/javascript">
   function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            alert("Please enter only Numbers.");
            return false;
        }

        return true;
    }
function validattion() {
  var phoneNo = document.getElementById('mobile');
 if (phoneNo.value == "" || phoneNo.value == null) {
            //alert("Please enter your Mobile No.");
            return true;
        }
        if (phoneNo.value.length < 10 || phoneNo.value.length > 10) {
            alert("Mobile No. is not valid, Please Enter 10 Digit Mobile No.");
            return false;
        }
       // alert("Success ");
        return true;
        }
</script>
  