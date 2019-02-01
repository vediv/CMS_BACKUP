<?php
include_once 'corefunction.php';
$action=(isset($_POST['action']))? $_POST['action']: "";
switch($action)
{
	case "edit_userList":
        $userid=$_REQUEST['userid'];  $pageindex=$_REQUEST['pageindex']; $limitval=$_POST['limitval'];
        $query1="select uid,uname,uemail,dob,ugender,ulocation from user_registration where uid='$userid'";
        $fetch= db_select($conn,$query1);
        $uname =$fetch[0]['uname']; $uemail =$fetch[0]['uemail'];  $dob =$fetch[0]['dob'];   
        $ugender =$fetch[0]['ugender']; $ulocation =$fetch[0]['ulocation']; 
        ?>
         <div class="modal-body">
         <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal" onclick="CloseModal('LegalModal_modal_edit_userList','edit_modal_userList');" >
         <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
         <h4 class="modal-title" id="myModalLabel"> <b>Edit User List - <?php echo $uname; ?> </b></h4> 
         </div>
         <br/>
       <div style=" border:1px solid #c7d1dd ;">
       <form class="form-horizontal" role="form" action="javascript:" method="post" id="confirm" onsubmit="return SaveEditUserList('<?php echo $userid; ?>','<?php echo $pageindex; ?>','<?php echo $limitval;  ?>')">
            <div class="form-group" style="margin-top: 12px">
              <label class="control-label col-sm-3">Name:</label>
              <div class="col-sm-7">
                  <input type="text" class="form-control" maxlength="30" value="<?php echo $uname; ?>"  name="name" id="name" placeholder="User Name">
                  <span class="help-block has-error" id="name-error" style="color:red;"></span>
              </div>
            </div>
                 <div class="form-group">
                   <label class="control-label col-sm-3" >Email:</label>
                   <div class="col-sm-7">          
                       <input type="text" class="form-control"  value="<?php echo $uemail; ?>" name="email" id="email"  aria-required  placeholder="Enter Email id">
                       <span class="help-block has-error" id="email-error" style="color:red;"></span>
                   </div>
                 </div>
           
           <div class="form-group">
                   <label class="control-label col-sm-3" >DOB:</label>
                   <div class="col-sm-7">          
                       <input type="text" class="form-control"  value="<?php echo $dob; ?>" name="dob" id="dob"  aria-required  placeholder="dd-mm-yyyy">
                       <span class="help-block has-error" id="dob-error" style="color:red;"></span>
                   </div>
                 </div>
          
             <div class="form-group">
                   <label class="control-label col-sm-3" >Gender:</label>
              <div class="col-sm-7">
                  <select class="form-control" name="gender" id="gender">
                      <option value="male" <?php echo $ugender=='male'? 'selected': ''; ?> >Male</option>
                       <option value="female" <?php echo $ugender=='female'? 'selected': ''; ?>>Female</option> 
                   </select>	                 
                       <span class="help-block has-error" id="gender-error" style="color:red;"></span>
              </div>
            </div>
         <!--  <div class="form-group">
                   <label class="control-label col-sm-3" >Location:</label>
                   <div class="col-sm-7">          
                       <input type="text" class="form-control"  value="<?php echo $ulocation; ?>" name="location" id="location"  aria-required  placeholder="Enter Location">
                       <span class="help-block has-error" id="location-error" style="color:red;"></span>
                   </div>
                 </div>-->
              
            <div class="modal-footer">
            <div class="pull-left col-sm-7" style="border:0px solid red;">
             <button type="submit" name="save" id="user_list" class="btn btn-primary" >Update</button>
            </div>
            <div align="left" class="pull-right col-sm-5" style="border:0px solid red;">
               <span id="saving_userlist"> </span>
            </div>
           </div>   
         </form>
       </div> 
       </div>    
       
<?php 
break; 
case "viewUserDetail":
  $userid=$_REQUEST['userid'];  
  $query1="select * from user_registration where uid='".$userid."'";
  $fetch= db_select($conn,$query1);
  $uname =$fetch[0]['uname']; $user_id =$fetch[0]['user_id']; $uemail =$fetch[0]['uemail'];  $dob =$fetch[0]['dob'];   
  $ugender =$fetch[0]['ugender'];   $oauth_provider =$fetch[0]['oauth_provider'];
  $ucountry =$fetch[0]['ucountry']; $city =$fetch[0]['ulocation'];   $ustate =$fetch[0]['ustate'];
  $userimage_url =$fetch[0]['userimage_url']!=''?$fetch[0]['userimage_url']:'N/A';
  if($city==NULL || $city=='undefined' || undefined=='')
  { $ucity='N/A'; }
 ?>
   <div class="modal-body">
         <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal" onclick="CloseModal('LegalModal_viewUserDetail','viewUserDetail_modal');" >
         <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
         <h4 class="modal-title" id="myModalLabel"> <b>User Detail - <?php echo $uname; ?> </b></h4> 
         </div>
         <br/>
       <div class="row">
            <div class="col-xs-12">
              <div class="box">
                
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tr>
                      <td><strong>Name :</strong></td>
                      <td><?php echo  $uname;  ?></td>
                      <td><strong>User ID :</strong></td>
                      <td><?php echo  $user_id;  ?></td>
                      
                    </tr>
                     <tr>
                      <td><strong>Email :</strong></td>
                      <td><?php echo $uemail; ?></td>
                      <td><strong>DOB :</strong></td>
                      <td><?php echo  $dob;  ?></td>
                     
                    </tr>
                    <tr>
                      <td><strong>Gender :</strong></td>
                      <td><?php echo $ugender; ?></td>
                      <td><strong>Login Provider :</strong></td>
                      <td><?php echo $oauth_provider; ?></td>
                    </tr>
                     <tr>
                      <td><strong>Country :</strong></td>
                      <td><?php echo  $ucountry;  ?></td>
                      <td><strong>State :</strong></td>
                      <td><?php echo $ustate; ?></td>
                     
                    </tr>
                    <tr>
                       <td><strong>City :</strong></td>
                      <td><?php echo $ucity; ?></td>
                      <td><strong>User Image :</strong></td>
                      <td><img src="<?php  echo $userimage_url; ?>" height="100" width="100"></td>
                    </tr>
                    
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
          </div> 
       </div>       
<?php 

}
?>