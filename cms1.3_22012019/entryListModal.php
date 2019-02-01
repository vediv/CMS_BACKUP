<?php
include_once 'corefunction.php';
$action=(isset($_POST['action']))? $_POST['action']: "";
switch($action)
{
    case "viewPartnerDetail":
        $pid=$_REQUEST['pid'];
        $quer="select * from content_partner where par_id='".$pid."'";
        $fetch= db_select($conn,$quer);
       $cname=$fetch[0]['name']; $email=$fetch[0]['email']; $mobile=$fetch[0]['mobile']; 
     $created_at=$fetch['created_at']; $updated_at=$fetch['updated_at']; $pstatus=$fetch['status']; $par_id=$fetch['par_id']; 
     $license_start_date=$fetch['license_start_date'];  $license_end_date=$fetch['license_end_date'];
    
    
         ?>
        <div class="modal-body">
         <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal" onclick="CloseModal('LegalModal_PartnerDetail','EntryPartner_modal');" >
         <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
         <h4 class="modal-title" id="myModalLabel"> <b>Content Partner Detail - <?php echo $cname; ?> </b></h4> 
         </div>
         <br/>
       <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tr>
                      <td><strong>Name :</strong></td>
                      <td><?php echo ucwords($cname);   ?></td>
                      <td><strong>Email:</strong></td>
                      <td><?php echo  $email;  ?></td>
                      
                  
                    
                     <tr>
<!--                     <td title="Total Duration"><strong>Total-Dur<br/>(HH:MM:SS)</strong></td>
                      <td><?php echo  $vlength;  ?></td>-->
                      <td><strong>Mobile :</strong></td>
                      <td><?php echo $mobile; ?></td>
                     
                    </tr>
<!--                    <tr>
                       <td><strong>Total Videos :</strong></td>
                      <td><?php echo $totalcount; ?></td>
                      <td><strong>User Image :</strong></td>
                      <td><img src="<?php // echo $userimage_url; ?>" height="100" width="100"></td>
                    </tr>-->
                    
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
          </div> 
       </div>      
       
<?php 
break; 
case "viewcontentvideo":
        $cvid=$_REQUEST['cvid'];  $pageindex=$_REQUEST['pageindex']; $limitval=$_POST['limitval'];
        $query1="select uid,uname,uemail,dob,ugender,ulocation from user_registration where uid='$cvid'";
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
case "viewEntryDetail":
  $entryid=$_REQUEST['entryid'];  
  $query1="select name,entryid,tag,shortdescription,categoryid from entry where entryid='".$entryid."'";
  $fetch= db_select($conn,$query1);
  $name =$fetch[0]['name']; $entryid =$fetch[0]['entryid']; $tag =$fetch[0]['tag'];  $sd =$fetch[0]['shortdescription'];   
//  $thumbnail =$fetch[0]['thumbnail']!=''?$fetch[0]['thumbnail']:'N/A';
  $categoryid =$fetch[0]['categoryid'];
  $query2="SELECT cat_name,fullname FROM categories WHERE category_id IN($categoryid)";
  $fetch= db_select($conn,$query2);
 ?>
   <div class="modal-body">
         <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal" onclick="CloseModal('LegalModal_EntryDetail','EntryDetail_modal');" >
         <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
         <h4 class="modal-title" id="myModalLabel"> <b>Entry Detail - <?php echo $name; ?> </b></h4> 
         </div>
         <br/>
       <div class="row" >
            <div class="col-xs-12">
              <div class="box">
              <div class="box-body">
                    <table class="table table-responsive">
                    <tr><td><strong>Name :</strong></td>
                        <td><?php echo  $name;  ?></td></tr>
                    <tr><td><strong>Short Description :</strong></td>
                        <td><?php echo  $sd;  ?></td></tr>
                     
                    <tr><td><strong>User ID :</strong></td>
                      <td><?php echo  $entryid;  ?></td></tr>
                    <tr> <td><strong>Tags :</strong></td>
                      <td><?php echo $tag; ?></td></tr>
                    <tr><td><strong>Category:</strong></td>
                       <td><?php
                        
      foreach($fetch as $fetchcat)
      {
         
    //  echo $catname =$fetchcat['cat_name'];
          $fulname =$fetchcat['fullname'];
         $result = explode(", ", $fulname);
         $full_name = implode ( "  ", $result ) . " <br> ";
     // $fullname =$fetchcat['fullname'];  

      
       echo $full_name; } ?></td></tr>
                   <!-- <tr>  <td><strong>Thumbnail :</strong></td>
                      <td><img src="<?php  // echo $thumbnail; ?>" height="100" width="100"></td>
                    </tr>-->

                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
          </div> 
       </div>       
<?php 
}

?>
