<?php
include_once 'corefunction.php';
$action=(isset($_POST['action']))? $_POST['action']: "";
switch($action)
{
    case "addDashboardUser":
    ?> 
  
<div class="modal-body">
     <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" onclick="CloseModal('myModal_addDashboardUserModal','view_DashboardUserModal');">
               <span aria-hidden="true">&times;</span>
               <span class="sr-only">Close</span>
        </button>
        <h4 class="modal-title" id="myModalLabel">
          <b>Add New User For Dashboard</b>
        </h4>
     </div>
<div style=" border:1px solid #c7d1dd ;">
   
    <form class="form-inline" role="form" style="padding: 10px 15px 10px 2px;">
     <div id="msg_model" style="text-align: center; color:red;"></div> 
     <p><strong>Login Detail:</strong></p>  
     <table class="table table-bordered">
                    <tr>
                      <th><label for="duser">Name *:</label></th>
                      <th><label for="demail">Email *:</label></th>
                      <th><label for="dpwd">Password *:</label></th>
                    </tr>
                    <tr>
                        <td>
                        <input type="text" class="form-control" name="duser" id="duser" maxlength="32"  placeholder="Name" >
                        <span class="help-block has-error" data-error="0" id="duser-error" style="color:red;"></span>
                        </td>
                        <td>
                        <input type="text" class="form-control" maxlength="64" name="demail" id="demail" placeholder="Email">
                        <span class="help-block has-error" data-error="0" id="demail-error" style="color:red;"></span>    
                        </td>
                        <td>
                        <input type="password" class="form-control"  maxlength="15" name="dpwd" id="dpwd" placeholder="Password">
                        <span class="help-block has-error" data-error="0" id="dpwd-error" style="color:red;"></span>    
                        </td>
                    </tr>
                  </table>
     <!--<p><strong>Contact Detail:</strong></p>    
    <div class="form-group">
        <label for="duser">Name *:</label> 
        <input type="text" class="form-control" name="duser" id="duser" maxlength="32"  placeholder="Name" >
        <span class="help-block has-error" data-error="0" id="duser-error" style="color:red;"></span>
    </div>
    <div class="form-group">
        <label for="demail">&nbsp&nbsp;Email *:</label>
        <input type="text" class="form-control" maxlength="64" name="demail" id="demail" placeholder="Email">
        <span class="help-block has-error" data-error="0" id="demail-error" style="color:red;"></span>
    </div>
    <div class="form-group">
        <label for="dpwd">&nbsp&nbsp;Password *:</label>
        <input type="password" class="form-control"  maxlength="15" name="dpwd" id="dpwd" placeholder="Password">
         <span class="help-block has-error" data-error="0" id="dpwd-error" style="color:red;"></span>
    </div>-->
<hr/>    
<?php
$get_other_permission = "SELECT other_permission,menu_permission FROM publisher where  par_id='".$get_user_id."'";
$fetch_permission=  db_select($conn,$get_other_permission);
$menu_permission=$fetch_permission[0]['menu_permission'];
?>
<p><strong>Menu Permission:</strong></p>
<div class="row">
<?php
$get_main_menu_query = "SELECT mid,mname,menu_url,mparentid,multilevel,
      child_id,icon_class FROM
      menus where mid IN($menu_permission) and multilevel!='1' and  mparentid='0'  and mstatus='1'";
$results=  db_select($conn,$get_main_menu_query);
foreach ($results as $get_main_menu) {  
    $munu_id=$get_main_menu['mid']; $menu_name=$get_main_menu['mname'];
?>

<div class="col-sm-3">
    <label class="checkbox-inline" style="color: #3290D4;">
        <input type="checkbox" name="menus[]"  value="<?php echo $munu_id;  ?>"><?php echo ucwords($menu_name); ?>
</label>
</div>
    
<?php
}
?>
</div>
<div class="row">
<?php
$get_main_menu_query = "SELECT mid,mname,menu_url,mparentid,multilevel,child_id,icon_class FROM menus
        where mid IN($menu_permission) and  mparentid='0' and multilevel='1' and mstatus='1'";
$results=  db_select($conn,$get_main_menu_query);$boxCount=1;
foreach ($results as $get_main_menu) {
    $munuid=$get_main_menu['mid']; $menuname=$get_main_menu['mname'];
?>
<div class="col-sm-4">
    <fieldset class="scheduler-border" style="min-height: 180px;">
    <legend class="scheduler-border">
        <input type="checkbox" name="menus[]" id="<?php echo $munuid;  ?>"  class="parent_main"  value="<?php echo $munuid;  ?>">
        <?php  echo ucwords($menuname) ?></legend> 
    <div class="control-group"> 
        <table style="width: 100%;">
            <?php
            $sub="SELECT mid,mname,menu_url,mparentid,multilevel FROM menus where mid IN($menu_permission) and  mparentid='".$munuid."' and mstatus='1' ";
            $res=  db_select($conn,$sub);
            foreach ($res as $get_submain_menu) {
            $submunuid=$get_submain_menu['mid']; $submenuname=$get_submain_menu['mname'];
            ?>
            <tr>
                <td> <input type="checkbox" name="menus[]" id="<?php echo $submunuid;  ?>" class="parent-<?php echo $munuid;?>" value="<?php echo $submunuid;  ?>">  </td> <td> <?php  echo ucwords($submenuname); ?></td>
            </tr>
            <?php } ?>
            
        </table>
    
    </div>
</fieldset>

</div>
<?php $boxCount++;} ?>
</div>
<hr/>
<p><strong>Action Permission: </strong>&nbsp; &nbsp;&nbsp;
    
<label class="checkbox-inline" style="color: #3290D4;">
    <input type="checkbox" name="action[]" value="1"> Create 
</label>
    <label class="checkbox-inline" style="color: #3290D4;">
     <input type="checkbox" name="action[]" value="2"> Edit 
</label>
    <label class="checkbox-inline" style="color: #3290D4;">
        <input type="checkbox" name="action[]" value="3" checked disabled> View
</label>
    <label class="checkbox-inline" style="color: #3290D4;">
     <input type="checkbox" name="action[]" value="4"> Delete
</label>
</p>
<hr/>
<?php
$other_permission=$fetch_permission[0]['other_permission'];
if($other_permission!=''){
$otherPermission=explode(",",$other_permission);

?>
<p><strong>Module Permission VOD: </strong>&nbsp; &nbsp;&nbsp;
<?php foreach($otherPermission as $val){
    $select_ott="SELECT module_id,module_name from ott_publisher.module_table where module_id='".$val."' and tag='vod' "; 
    $getData=  db_select1($select_ott);
    $totalrow1= db_totalRow1($select_ott);
    $module_id=$getData[0]['module_id']; $module_name=$getData[0]['module_name'];
    if($module_id==1 || $module_id==2){ $ck="checked"; }
    else { $ck=''; }
    if($totalrow1>0){
    ?>
    
 <label class="checkbox-inline" style="color: #3290D4;">
    <input type="checkbox" name="other_permission[]" value="<?php echo $module_id; ?>" <?php echo $ck; ?>   >
     <?php echo $module_name; ?> 
</label>
 <?php 
} } ?>   
</p>
<p><strong>Module Permission category: </strong>&nbsp; &nbsp;&nbsp;
<?php foreach($otherPermission as $val){
    $select_ott="SELECT module_id,module_name from ott_publisher.module_table where module_id='".$val."' and tag='category' "; 
    $getData=  db_select1($select_ott);
    $totalrow= db_totalRow1($select_ott);
    $module_id=$getData[0]['module_id']; $module_name=$getData[0]['module_name'];
    if($module_id==1 || $module_id==2){ $ck="checked"; }
    else { $ck=''; }
    if($totalrow>0){
    
    ?>
<label class="checkbox-inline" style="color: #3290D4;">
    <input type="checkbox" name="other_permission[]" value="<?php echo $module_id; ?>" <?php echo $ck; ?>   >
     <?php echo $module_name; ?> 
</label>
 <?php 
    } } ?>   
</p>
<p><strong>Dashboard Permission: </strong>&nbsp; &nbsp;&nbsp;
<?php foreach($otherPermission as $val){
    $select_ott="SELECT module_id,module_name from ott_publisher.module_table where module_id='".$val."' and tag='dashboard' "; 
    $getData=  db_select1($select_ott);
    $totalrow= db_totalRow1($select_ott);
    $module_id=$getData[0]['module_id']; $module_name=$getData[0]['module_name'];
    if($module_id==1 || $module_id==2){ $ck="checked"; }
    else { $ck=''; }
    if($totalrow>0){
    
    ?>
<label class="checkbox-inline" style="color: #3290D4;">
    <input type="checkbox" name="other_permission[]" value="<?php echo $module_id; ?>" <?php echo $ck; ?>   >
     <?php echo $module_name; ?> 
</label>
 <?php 
    } } ?>   
</p>
<?php 
} ?>
<hr/>
 <div class="modal-footer">
        <div class="col-sm-offset-2 col-sm-5">
            <button type="button" name="save" id="dashboard_user" class="btn btn-primary" onclick="SaveDashboardUser();" >Save</button>
        </div>
     <span id="saving_loader"> </span>
 </div>    
</form>
     
       </div>
</div> 

<?php   
break;    
case "editDashboardUser":
$par_id=$_POST['parid']; $pageindex=$_POST['pageindex']; $limitval=$_POST['limitval'];
$query1 = "SELECT par_id,name,email,menu_permission,operation_permission,other_permission
         FROM publisher   where par_id='".$par_id."' ";
$value = db_select($conn,$query1);
$par_id=$value[0]['par_id'];   $name=$value[0]['name']; $demail=$value[0]['email'];
$menu_permission=$value[0]['menu_permission']; $operation_permission=$value[0]['operation_permission']; 
$other_permission_user=$value[0]['other_permission']; 
$mpermission=explode(",",$menu_permission); 
$otherPermission_user=explode(",",$other_permission_user);
$om=explode(",",$operation_permission); 
?>   
 <div class="modal-body"> 
 <div class="modal-header">
 <button type="button" class="close" data-dismiss="modal" onclick="CloseModal('myModal_addDashboardUserModal','view_DashboardUserModal');" >
 <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
     <h4 class="modal-title" id="myModalLabel"> <b>Edit User - <?php echo ucwords($name); ?> </b></h4> 
 </div>
 <br/>
<div style=" border:1px solid #c7d1dd ;">
<form class="form-inline" role="form" style="padding: 10px 15px 10px 2px;">
<div id="msg_model1" style="text-align: center; color:red;"></div>   
<p><strong>Login Detail:</strong></p>    
<table class="table table-bordered">
                    <tr>
                      <th><label for="duser">Name *:</label></th>
                      <th><label for="demail">Email *:</label></th>
                      
                    </tr>
                    <tr>
                        <td>
                        <input type="text" class="form-control" name="duser" id="duser"  maxlength="32" value='<?php echo $name;  ?>' placeholder="Name" >
   <span class="help-block has-error" data-error="0" id="duser-error" style="color:red;"></span>
                        </td>
                        <td>
                        <input type="text" class="form-control" name="demail" id="demail"  maxlength="64" value='<?php echo $demail;  ?>' placeholder="Email">
   <span class="help-block has-error" data-error="0" id="demail-error" style="color:red;"></span>    
                        </td>
                        
                    </tr>
</table>


<!--<div class="form-group">
   <label for="cname">Name :</label>  
   <input type="text" class="form-control" name="duser" id="duser"  maxlength="32" value='<?php echo $name;  ?>' placeholder="Name" >
   <span class="help-block has-error" data-error="0" id="duser-error" style="color:red;"></span>
</div>
<div class="form-group">
    <label for="cemail">&nbsp&nbsp; Email :</label>
   <input type="text" class="form-control" name="demail" id="demail"  maxlength="64" value='<?php echo $demail;  ?>' placeholder="Email">
   <span class="help-block has-error" data-error="0" id="demail-error" style="color:red;"></span>
</div>
-->

<?php
$get_other_permission = "SELECT other_permission,menu_permission,operation_permission FROM publisher where  par_id='".$get_user_id."'";
$fetch_permission=  db_select($conn,$get_other_permission);
$menu_permission=$fetch_permission[0]['menu_permission'];
$other_permission=$fetch_permission[0]['other_permission'];
?>
<p><strong>Menu Permission:</strong></p>
<div class="row">
<?php
$get_main_menu_query = "SELECT mid,mname,menu_url,mparentid,multilevel,
      child_id,icon_class FROM
      menus where mid IN($menu_permission) and multilevel!='1' and  mparentid='0'  and mstatus='1'";
$results=  db_select($conn,$get_main_menu_query);
foreach ($results as $get_main_menu) {  
    $munu_id=$get_main_menu['mid']; $menu_name=$get_main_menu['mname'];
    if(in_array($munu_id, $mpermission)){  $checked='checked'; }
    else{ $checked=''; }
?>
<div class="col-sm-3">
    <label class="checkbox-inline" style="color: #3290D4;">
        <input type="checkbox" name="menus[]" <?php echo $checked; ?>  value="<?php echo $munu_id;  ?>"><?php echo ucwords($menu_name); ?>
</label>
</div>
<?php
}
?>
</div>
<div class="row">
<?php
$get_main_menu_query = "SELECT mid,mname,menu_url,mparentid,multilevel,child_id,icon_class FROM menus
        where mid IN($menu_permission) and  mparentid='0' and multilevel='1' and mstatus='1'";
$results=  db_select($conn,$get_main_menu_query);$boxCount=1;
foreach ($results as $get_main_menu) {
    $munuid=$get_main_menu['mid']; $menuname=$get_main_menu['mname'];
    if(in_array($munuid, $mpermission)){  $checked='checked'; }
    else{ $checked=''; }
?>
<div class="col-sm-4">
    <fieldset class="scheduler-border" style="min-height: 180px;">
    <legend class="scheduler-border">
        <input type="checkbox" name="menus[]" <?php echo $checked; ?> id="<?php echo $munuid;  ?>"  class="parent_main"  value="<?php echo $munuid;  ?>">
        <?php  echo ucwords($menuname) ?></legend> 
    <div class="control-group"> 
        <table style="width: 100%;">
            <?php
            $sub="SELECT mid,mname,menu_url,mparentid,multilevel FROM menus where mid IN($menu_permission) and  mparentid='".$munuid."' and mstatus='1' ";
            $res=  db_select($conn,$sub);
            foreach ($res as $get_submain_menu) {
            $submunuid=$get_submain_menu['mid']; $submenuname=$get_submain_menu['mname'];
             if(in_array($submunuid, $mpermission)){  $checked='checked'; }
             else{ $checked=''; }
            ?>
            <tr>
                <td> <input type="checkbox" name="menus[]" <?php echo $checked; ?> id="<?php echo $submunuid;  ?>" class="parent-<?php echo $munuid;?>" value="<?php echo $submunuid;  ?>">  </td> <td> <?php  echo ucwords($submenuname); ?></td>
            </tr>
            <?php } ?>
            
        </table>
    
    </div>
</fieldset>

</div>
<?php $boxCount++;} ?>
</div>
<p><strong>Action Permission: </strong>&nbsp; &nbsp;&nbsp;
    
<label class="checkbox-inline" style="color: #3290D4;">
    <input type="checkbox" name="action[]" value="1" <?php echo $orderdir = (in_array(1,$om) ? "checked" : ""); ?>> Create 
</label>
    <label class="checkbox-inline" style="color: #3290D4;">
     <input type="checkbox" name="action[]" value="2" <?php echo $orderdir = (in_array(2,$om) ? "checked" : ""); ?>> Edit 
</label>
    <label class="checkbox-inline" style="color: #3290D4;">
        <input type="checkbox" name="action[]" value="3" checked disabled > View
</label>
    <label class="checkbox-inline" style="color: #3290D4;">
     <input type="checkbox" name="action[]" value="4" <?php echo $orderdir = (in_array(4,$om) ? "checked" : ""); ?>> Delete
</label>
</p>
<?php
//$other_permission=$fetch_permission[0]['other_permission'];
if($other_permission!=''){
$other_permission=explode(",",$other_permission);
?>
<p><strong>Module Permission: </strong>&nbsp; &nbsp;&nbsp;
<?php
foreach($otherPermission as $val){
    $select_ott="SELECT module_id,module_name from ott_publisher.module_table where module_id='".$val."'  and tag='vod'"; 
    $getData=  db_select1($select_ott);
    $db_total1=db_totalRow1($select_ott);
    $module_id=$getData[0]['module_id']; $module_name=$getData[0]['module_name'];
    if($db_total1>0){
    ?>
<label class="checkbox-inline" style="color: #3290D4;">
    <input type="checkbox" name="other_permission[]" value="<?php echo $module_id; ?>" <?php if(in_array($module_id, $otherPermission_user)){ echo  "checked";}else{}  ?>     >
     <?php echo $module_name; ?> 
</label>
 <?php 
} } ?>   
</p>
<p><strong>Module Permission category: </strong>&nbsp; &nbsp;&nbsp;
<?php
foreach($otherPermission as $val){
    $select_ott="SELECT module_id,module_name from ott_publisher.module_table where module_id='".$val."'  and tag='category'"; 
    $getData=  db_select1($select_ott);
    $db_total=db_totalRow1($select_ott);
    $module_id=$getData[0]['module_id']; $module_name=$getData[0]['module_name'];
    if($db_total>0){
    ?>
<label class="checkbox-inline" style="color: #3290D4;">
    <input type="checkbox" name="other_permission[]" value="<?php echo $module_id; ?>" <?php if(in_array($module_id, $otherPermission_user)){ echo  "checked";}else{}  ?>     >
     <?php echo $module_name; ?> 
</label>
 <?php 
} } ?>   
</p>
<p><strong>Dashboard Permission: </strong>&nbsp; &nbsp;&nbsp;
<?php
foreach($otherPermission as $val){
    $select_ott="SELECT module_id,module_name from ott_publisher.module_table where module_id='".$val."'  and tag='dashboard'"; 
    $getData=  db_select1($select_ott);
    $db_total=db_totalRow1($select_ott);
    $module_id=$getData[0]['module_id']; $module_name=$getData[0]['module_name'];
    if($db_total>0){
    ?>
<label class="checkbox-inline" style="color: #3290D4;">
    <input type="checkbox" name="other_permission[]" value="<?php echo $module_id; ?>" <?php if(in_array($module_id, $otherPermission_user)){ echo  "checked";}else{}  ?>     >
     <?php echo $module_name; ?> 
</label>
 <?php 
} } ?>   
</p>
<?php } ?>

    <div class="modal-footer">
        <div class="col-md-10 text-center">
            <button type="button" name="save" id="dashboard_user" class="btn btn-primary" onclick="SaveEditDashboardUser('<?php echo $par_id; ?>','<?php echo $pageindex; ?>','<?php echo $limitval;  ?>');" >Update</button>
        </div>
       <span id="saving_loader"> </span>
    </div>    
</form>

</div> 

</div>    
<?php 
break;    
}
?>
<script type="text/javascript">
$(document).ready(function() {   
$(".parent_main").change(function(){
var tt= $(this).is(':checked');
    if(tt) {
        var cls = '.parent-' + $(this).prop('id');
        $(cls).prop('checked', 'checked');   
    }
    else
    {   
        var cls = '.parent-' + $(this).prop('id');
        $(cls).prop('checked',false);   
    }    
});

$('input[class*="parent"]').change(function(){
    var cls = '.' + $(this).prop('class') + ':checked';
    var len = $(cls).length;
     //alert(len);
    var parent_id = '#' + $(this).prop('class').split('-')[1];
    // 3. Check parent if at least one child is checked
    if(len) {
        $(parent_id).prop('checked', 'checked');
    } else {
        // 2. Uncheck parent if all childs are unchecked.
        $(parent_id).prop('checked', false);
    }
});
});

$('input[type=text],input[type=password]').blur(function(){
       $(this).val($.trim($(this).val().replace(/\t+/g,' ')));
}); 
</script>

