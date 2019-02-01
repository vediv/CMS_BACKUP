<?php
include_once 'corefunction.php';
//include_once("config.php");
$User_id=$_REQUEST['user_id'];
$getpageindex=$_REQUEST['pageindex'];
$query="SELECT ur.*,cou.country_name,sta.state_name,city.city_name FROM user_registration AS ur 
        LEFT JOIN countries AS cou ON ur.ucountry=cou.country_id
        LEFT JOIN states AS sta ON ur.ustate=sta.state_id
        LEFT JOIN cities AS city ON ur.ulocation=city.city_id WHERE uid=$User_id";
     $fetch =db_select($conn,$query);
     $userid=$fetch[0]['uid'];   $uname=$fetch[0]['uname'];  
	 $useridt=$fetch[0]['user_id'];   $uemail=$fetch[0]['uemail'];  
	 $dob=$fetch[0]['dob'];   $ugender=$fetch[0]['ugender'];   $status=$fetch[0]['status'];  
	 $ulocation=$fetch[0]['ulocation']; $ucountry=$fetch[0]['ucountry']; $ustate=$fetch[0]['ustate']; 
	 $added_date=$fetch[0]['added_date'];  $last_login=$fetch[0]['last_login'];   $last_logout=$fetch[0]['last_logout']; 
	 $modified=$fetch[0]['modified'];  $country_name=$fetch[0]['country_name'];  $state_name=$fetch[0]['state_name'];
	 $city_name=$fetch[0]['city_name'];
	 if($status=1)
	 {
	 	$status='Active';
	 }
	else {
		$status='Deactive';
	}
	 
?>
<style>
	.col-md-4{
		min-height: 44px;
	}
</style>
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h3 class="modal-title">User Details</h3>
      </div>
        <div class="modal-body" >
             <div class="box">
             <!-- /.box-header -->
           <div class="box-body" id="inner-content-div" style="border: 0px solid red; overflow-x: hidden; overflow-y: auto; ">
   
    
     <div class="row" >
          <div class="col-md-4"><strong>UID :</strong> <?php echo $userid; ?></div>
          <div class="col-md-4"><strong>User Name :</strong> <?php echo $uname; ?></div>
          <div class="col-md-4"><strong>User ID :</strong> <?php echo $useridt; ?></div>
          <div class="col-md-4"><strong>Email :</strong>  <?php echo $uemail; ?> </div>
          <div class="col-md-4"><strong>Date of Birth :</strong> <?php echo $dob; ?></div>
          <div class="col-md-4"><strong>Gender :</strong> <?php echo $ugender; ?></div>
          <div class="col-md-4"><strong>Country :</strong> <?php echo $country_name; ?></div>
          <div class="col-md-4"><strong>State :</strong> <?php echo $state_name; ?></div>
          <div class="col-md-4"><strong>City :</strong> <?php echo $city_name; ?></div>
          <div class="col-md-4"><strong>Status :</strong> <?php echo $status; ?></div>
          <div class="col-md-4"><strong>Added Date :</strong> <?php echo $added_date; ?></div>
          <div class="col-md-4"><strong>Last Modification :</strong> <?php echo $modified; ?></div>
          <div class="col-md-4"><strong>Last Login :</strong> <?php echo $last_login; ?></div>
          <div class="col-md-4"><strong>Last Logout :</strong> <?php echo $last_logout; ?></div>
  </div>  
        
</div>
</div>
</div>             
</div>
<script src="js/jquery.slimscroll.min.js" type="text/javascript"></script> 
<script type="text/javascript">
$(function(){
    $('#inner-content-div').slimScroll({
    	 height: '250px',
    	// width:  '352px',
    	  size: '8px', 
    	 //color: '#f5f5f5'
    });
}); 
</script>
     
